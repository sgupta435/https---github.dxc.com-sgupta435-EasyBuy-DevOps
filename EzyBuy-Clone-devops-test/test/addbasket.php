<?php
/**
 * /ezbuy/common/php/addbasket.php
 *
 * Revision 1.3  2005/12/08 09:37:33  slechner
 * Change Addbasket as MyHardwareChoice is now MP2B compliant
 * Config changes from release 595
 * release 596
 *
 * Revision 1.2.6.1  2005/12/08 09:32:34  slechner
 * Change Addbasket as MyHardwareChoice is now MP2B compliant
 * Config changes from release 595
 *
 * Revision 1.2.4.2  2005/12/09 16:42:36  slechner
 * end of week 49 : development finished and commented
 *
 * Revision 1.2.4.1  2005/12/07 15:46:15  slechner
 * alignment and R6 preparation
 *
 * Revision 1.2  2005/12/02 14:59:21  slechner
 * Shopping basket config change for FR
 * Add basket now compliant with MP2B partners
 * merge with 590_B and 509_E
 *
 * $Name: HEAD $
 * $State: Exp $
 *
 * +======================================================================================================+
 * | Pass products & quantities to a store basket directly
 * +======================================================================================================+
 * +------------------------------------------------------------------------------------------------------+
 * | Code Structure:
 * | --------------
 * | Read Input parameters
 * | Build URL details [country,doubleclick,...]
 * | Redirect to the URL such as
 * | http://fr-hp.kelkoo.com/fr/HPEzBuyGo?m=3612823&country=ch&pn=FA289T&pkey=1&price=349&availability=6&m_s=smb&url=http://ad.uk.doubleclick.net/clk;7153290;8804324;h?http://h41162.www4.hp.com/warenkorb?add&newlang=fr&p=1260&s=ch_de_smb_pri&p1=FA289T&url1=http://h41166.www4.hp.com/catalogue/ch/de/mobile-computing/index.html&catalogurl=http://h41166.www4.hp.com/catalogue/ch/de/
 * +------------------------------------------------------------------------------------------------------+
 * | Usage:
 * | ------
 * | http://.../addbasket.php?
 * |kelkoo merchant id: m=3392423& (used by Kelkoo HPEzBuyGo)
 * |product numbers|quantity: pn=PF997AA|5,Q2232A|5& (products/quantity submitted to Store)
 * |merchant position in list: pkey=1& (used by Kelkoo HPEzBuyGo)
 * |market segment: m_s=smb& (used by Kelkoo HPEzBuyGo)
 * |product price: price=120.00& (used by Kelkoo HPEzBuyGo)
 * |url= (passed on empty in most cases as NOT USED)
 * |country=uk& (used by Kelkoo HPEzBuyGo & configuration search)
 * |lang=en& (used for configuration search)
 * |siteId=uk_en_smb_psc& (site origin submitted to store)
 * |storeId=1222& (store id submitted to store)
 * |storeUrl=http://www.hpstore.hp.co.uk/basket& (used to build url submitted to store)
 * |refererUrl=wherever& (referrer url submitted to store as product url (if one product))
 * |catalogUrl=whatever (catalog url submitted to store)
 * |type=hp|... (used today to detect hp stores only internaly)
 * |availability=whatever (used by Kelkoo HPEzBuyGo)
 * +------------------------------------------------------------------------------------------------------+
 * | Glossary:
 * | ---------
 * +------------------------------------------------------------------------------------------------------+
 * | Internals:
 * | ----------
 * |11/29/2006: MP2B resellers externalized in ini/MP2Bpartners.txt file
 * | 			and loaded through include/csvload.php library
 * |09/28/2006: BestPrint ES MP2B
 * |08/23/2006: Osilog MP2B
 * |08/03/2006: MyHardwareCHOICE Chnaged to BestPrints
 * |01/12/2006: MyHardwareCHOICE MP2B compliant
 * |12/09/2005: m_s value changed to smb/hho.
 * |			url passed on empty
 * |11/28/2005: MP2B partners are now available
 * |11/10/2005: Stop sending Referer URL to HP store if > 1000 chars
 * |04/28/2005: now accept POST and GET
 * |            now accept pn=sku1|q1,sku2|q2,...
 * |07/27/2005: add newlang=lang as hp store add basket parameter
 * +------------------------------------------------------------------------------------------------------+
 * | Debug:
 * | --------
 * | Use debug=.. as additional query string parameter
 * +------------------------------------------------------------------------------------------------------+
 * | Assumptions:
 * | ------------
 * | loads include/countrysettings_load.php that requires $country,$m_s,$lang to be set
 * | goXmlQuery parameter from countrysettings.ini file contains &country=&m_s=&from=lite
 * | 			country and m_s are the ones to be used for final call
 * | 			EX: HPEzBuyGo?country=uk&m_s=autrechose&from=lite
 * +======================================================================================================+
 *
 */

 /*
 * Include Params Processing Library
 */
require_once "include/ezb_utils.ProcessParams.php.inc";
/*
 * Include Get Settings Library
 */
require_once "include/ezb_settings.php.inc";

/*
 * Process parameters
 */
$_req_mandatory_var_names = array(); //mandatory parameters
$_req_optional_var_names = array("debug","clientId","country","m_s","lang","storeId","siteId","storeUrl","catalogUrl","refererUrl","url","m","pkey","pn","price","availability","type"); //optional parameters
$param_ok=UtilsProcessParams($_req_mandatory_var_names, $_req_optional_var_names, "debug");

$kelkoo_remove=1;

//initialise variable for debug section
$AddBasketURL="";
$urls = array();

/*
 * Reads settings for country/segment
 * get config data to build redirect URL
 */
$paramCollection = array(
	"kelkooserver" =>array("xml", ""),
	"goXmlQuery" =>array("xml", ""));
	//"tagDoubleClick" =>array("xml", ""));
$res = GetEzbSettings($paramCollection, null, $country, $lang, $m_s, $clientId, "xml", $debug);
$kelkooserver=$res["kelkooserver"];
$goXmlQuery=$res["goXmlQuery"];
//$tagDoubleClick=$res["tagDoubleClick"];

$mystoreUrl = "http://".$kelkooserver."/".$goXmlQuery;
if(strpos($mystoreUrl,"?")!=false)
	$mystoreUrl .="&m=" . $_req_m;
else
	$mystoreUrl .="?m=" . $_req_m;

if(($_req_type=="hp" || $_req_type=="") && $_req_storeUrl != ""){
	//pn parameter of format sku|qty,sku|qty where qty can be omited if equal to 1
	//need to transform into pn1=sku&q1=qty&pn2=sku&q2=qty...
	//and preserve backward compatibility if only one product.
	$pn_list="";
	$pn_a = explode(",", $_req_pn);
	for($i=0; $i < count($pn_a);$i++){
		if($i>0){
			$pn_list=$pn_list . "&";
		}
		$pn_i = explode("|", $pn_a[$i]);
		if(count($pn_i)==2){
			$pn_list=$pn_list . "p" . ($i+1) ."=". (trim($pn_i[0])) ."&q" . ($i+1) . "=" . (trim($pn_i[1]));
		}else{
			$pn_list=$pn_list . "p" . ($i+1) ."=". (trim($pn_i[0]));
		}
	}
	//end of pn treatment

	// DoubleClick Tagging via Kelkoo HPEzBuyGo
	// only first product sent in case many are in param

	//$mystoreUrl .= "&pn=" . $pn_i[0] . "&pkey=" . $_req_pkey . "&price=" . $_req_price . "&availability=". $_req_availability . "&url=" . urlencode($tagDoubleClick.$_req_storeUrl);

	$storeUrlUse=str_replace("S_AMP_E","&",$_req_storeUrl);
	$storeUrlUse=str_replace("S_QM_E","?",$storeUrlUse);
	$storeUrlUse=str_replace("S_POUND_E","#",$storeUrlUse);
	$storeUrlUse=str_replace("#pn_list#",$pn_list,$storeUrlUse);


	(strlen($_req_refererUrl)<=1000)?$RefUrl=$_req_refererUrl:$RefUrl="";

	foreach($_req_optional_var_names as $name){
		$storeUrlUse=str_replace("#".$name."#",${$name},$storeUrlUse);
	}
	(strlen($_req_refererUrl)<=1000)?$RefUrl=$_req_refererUrl:$RefUrl="";

	$storeUrlUse=str_replace("#"."RefUrl"."#",$RefUrl,$storeUrlUse);


	$mystoreUrl .= "&pn=" . $pn_i[0] . "&pkey=" . $_req_pkey . "&price=" . $_req_price . "&availability=". $_req_availability . "&url=" . urlencode($storeUrlUse);

	if($kelkoo_remove)
		$mystoreUrl =$storeUrlUse;

	//$mystoreUrl .= "&pn=" . $pn_i[0] . "&pkey=" . $_req_pkey . "&price=" . $_req_price . "&availability=". $_req_availability . "&url=" . urlencode($_req_storeUrl);


	if(stristr($_req_storeUrl,'#') === FALSE && stristr($_req_storeUrl,'S_POUND_E') === FALSE){
		if($kelkoo_remove)
			$AddBasketURL= $mystoreUrl . /*urlencode(*/"?add&newlang=" . $lang . "&p=" . $_req_storeId . "&s=" . $_req_siteId . "&" . $pn_list . "&url1=" . $RefUrl . "&catalogurl=" . $_req_catalogUrl/*)*/;
		else
			$AddBasketURL= $mystoreUrl . urlencode("?add&newlang=" . $lang . "&p=" . $_req_storeId . "&s=" . $_req_siteId . "&" . $pn_list . "&url1=" . $RefUrl . "&catalogurl=" . $_req_catalogUrl);
	}else{
		$AddBasketURL= $mystoreUrl;
	}
}else{
	if($_req_type=="ebus"){
		include('include/csvload.php');
		$csv_file = "../../configuration/MP2Bpartners.csv";
		$mycsv = new CSV();
		$mycsv->CSVread($csv_file,",");
		eval($mycsv->generatePhpArray());

		if(isset($urls[$_req_m])){
			$mystoreUrl .= "&pn=" . $_req_pn . "&pkey=" . $_req_pkey . "&price=" . $_req_price . "&availability=". $_req_availability . "&url=";
			$AddBasketURL = $mystoreUrl . urlencode($urls[$_req_m].$_req_pn);
		}
	}
}
//debug if debug=... in query string
if(!empty($debug)){
	echo $debug_msg;
	echo "<H1>AddBasketUrl:</H1><BR> <A HREF=\"" . $AddBasketURL . "\">".urldecode($AddBasketURL)."</a><BR>";

	echo "<H1>MP2B Resellers :</H1><BR>";
	foreach ($urls as $key => $value) {
	   echo "Reseller ID : $key => Url : $value<br />\n";
	}

}else{
	if($AddBasketURL!=""){
		//Change location to AddBasket URL
		header("Location: " . $AddBasketURL);
	}
}

?>