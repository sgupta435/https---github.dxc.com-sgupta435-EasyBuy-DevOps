
<script>
var JSON;JSON||(JSON={});
(function(){function k(a){return 10>a?"0"+a:a}function o(a){p.lastIndex=0;return p.test(a)?'"'+a.replace(p,function(a){var c=r[a];return"string"===typeof c?c:"\\u"+("0000"+a.charCodeAt(0).toString(16)).slice(-4)})+'"':'"'+a+'"'}function m(a,j){var c,d,h,n,g=e,f,b=j[a];b&&"object"===typeof b&&"function"===typeof b.toJSON&&(b=b.toJSON(a));"function"===typeof i&&(b=i.call(j,a,b));switch(typeof b){case "string":return o(b);case "number":return isFinite(b)?""+b:"null";case "boolean":case "null":return""+b;
case "object":if(!b)return"null";e+=l;f=[];if("[object Array]"===Object.prototype.toString.apply(b)){n=b.length;for(c=0;c<n;c+=1)f[c]=m(c,b)||"null";h=0===f.length?"[]":e?"[\n"+e+f.join(",\n"+e)+"\n"+g+"]":"["+f.join(",")+"]";e=g;return h}if(i&&"object"===typeof i){n=i.length;for(c=0;c<n;c+=1)"string"===typeof i[c]&&(d=i[c],(h=m(d,b))&&f.push(o(d)+(e?": ":":")+h))}else for(d in b)Object.prototype.hasOwnProperty.call(b,d)&&(h=m(d,b))&&f.push(o(d)+(e?": ":":")+h);h=0===f.length?"{}":e?"{\n"+e+f.join(",\n"+
e)+"\n"+g+"}":"{"+f.join(",")+"}";e=g;return h}}"function"!==typeof Date.prototype.toJSON&&(Date.prototype.toJSON=function(){return isFinite(this.valueOf())?this.getUTCFullYear()+"-"+k(this.getUTCMonth()+1)+"-"+k(this.getUTCDate())+"T"+k(this.getUTCHours())+":"+k(this.getUTCMinutes())+":"+k(this.getUTCSeconds())+"Z":null},String.prototype.toJSON=Number.prototype.toJSON=Boolean.prototype.toJSON=function(){return this.valueOf()});var q=/[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,
p=/[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,e,l,r={"\u0008":"\\b","\t":"\\t","\n":"\\n","\u000c":"\\f","\r":"\\r",'"':'\\"',"\\":"\\\\"},i;"function"!==typeof JSON.stringify&&(JSON.stringify=function(a,j,c){var d;l=e="";if(typeof c==="number")for(d=0;d<c;d=d+1)l=l+" ";else typeof c==="string"&&(l=c);if((i=j)&&typeof j!=="function"&&(typeof j!=="object"||typeof j.length!=="number"))throw Error("JSON.stringify");return m("",
{"":a})});"function"!==typeof JSON.parse&&(JSON.parse=function(a,e){function c(a,d){var g,f,b=a[d];if(b&&typeof b==="object")for(g in b)if(Object.prototype.hasOwnProperty.call(b,g)){f=c(b,g);f!==void 0?b[g]=f:delete b[g]}return e.call(a,d,b)}var d,a=""+a;q.lastIndex=0;q.test(a)&&(a=a.replace(q,function(a){return"\\u"+("0000"+a.charCodeAt(0).toString(16)).slice(-4)}));if(/^[\],:{}\s]*$/.test(a.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,"@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,
"]").replace(/(?:^|:|,)(?:\s*\[)+/g,""))){d=eval("("+a+")");return typeof e==="function"?c({"":d},""):d}throw new SyntaxError("JSON.parse");})})();

function submitForm(userid,password,storeid,currency,language,productinfo,storeurl)
 {

	var contactAgent = {
		"LogonInfo": {"USERID":userid, "PASSWORD":password},
		"BusinessContext" : { "STOREENT_ID" : storeid, "CURRENCY" : currency, "LANGUAGE":language },
		"ProductInfo" : productinfo
	}

	storeurlfull = storeurl;
	var jsonstr = JSON.stringify(contactAgent);
	//alert(jsonstr);
	document.addtocart.jsonreq.value = jsonstr;
	//document.addtocart.action =storeurlfull;
	//document.addtocart.submit();
	document.addtocart.setAttribute("action", storeurlfull);
	document.addtocart.submit();
	//alert("Value is sumitted");
	
}
	
</script>

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
 * /|11/29/2006: MP2B resellers externalized in ini/MP2Bpartners.txt file
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
/*/
 * Include Get Settings Library
 */
require_once "include/ezb_settings.php.inc";
require_once "include/dualsupp.php.inc";


/*
 * Process parameters
 */
$_req_mandatory_var_names = array(); //mandatory parameters
//$_req_optional_var_names = array("debug","clientId","country","m_s","lang","storeId","siteId","storeUrl","catalogUrl","refererUrl","url","m","pkey","pn","price","availability","type"); //optional parameters

/* $_req_optional_var_names = array("debug","clientId","country","m_s","lang","storeId","siteId","storeUrl","catalogUrl","refererUrl","url","m","pkey","pn","price","availability","type","template_type","aoid","jumpid");*/ 
//optional parameters

/* 
//Added By Sunetra for mobile device-Start on 03/12/2014
$_req_optional_var_names = array("debug","clientId","country","m_s","lang","storeId","siteId","storeUrl","catalogUrl","refererUrl","url","m","pkey","pn","price","availability","type","template_type","aoid","jumpid","mobile","ssad_id","ssad_url"); //optional parameters
//End
*/

//Added By Manjunath on 11/03/2015 for Sure Supply Auto Delivery Functionality ---Start 
$_req_optional_var_names = array("debug","clientId","country","m_s","lang","storeId","siteId","storeUrl","catalogUrl","refererUrl","url","m","pkey","pn","price","availability","type","template_type","aoid","jumpid","mobile","ssad_id","ssad_url"); //optional parameters
//end

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
	"goXmlQuery" =>array("xml", ""),
	//Added By Nithiyanandhan on 19/09/2014 - For ETR Integration - Start
	"ETR"=> array("xml",""),
	"Userid"=> array("xml",""),
	"Password"=> array("xml",""),
	"STOREENT_ID"=> array("xml",""),
	"EtrCurrency"=>array("xml",""),
	"Language"=>array("xml",""),
	"StoreURL"=>array("xml",""),
	//Added by Sunetra for Mobile Device- Start on 03/12/2014
	"mStoreURL"=>array("xml","")
	//End
	);
	//End
	//"tagDoubleClick" =>array("xml", ""));
$res = GetEzbSettings($paramCollection, null, $country, $lang, $m_s, $clientId, "xml", $debug);
$kelkooserver=$res["kelkooserver"];
$goXmlQuery=$res["goXmlQuery"];
//Added By Nithiyanandhan on 19/09/2014 - For ETR Integration - Start
$ETR = $res["ETR"];
$UserId = $res["Userid"];
$Password = $res["Password"];
$ETRstoreid=$res["STOREENT_ID"];
$ETRcurrency=$res["EtrCurrency"];
$ETRLanguage= $res["Language"];
$ETRStoreURL =  $res["StoreURL"];
//Added by Sunetra for Mobile Device- Start on 03/12/2014
$mStoreURL = $res["mStoreURL"];
//End
$ETRPartnum="";

//Added by Sunetra for Mobile Device- Start on 03/12/2014
if($mobile=="yes")
			{
			 if($mStoreURL!="")
			   {
				$ETRStoreURL=$mStoreURL;
			   }
			   else
			   {
			    $ETRStoreURL=$ETRStoreURL;
			   }
			}
else
            {
			
				$ETRStoreURL=$ETRStoreURL;
		    }
//End
			
//End
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
			//Added by Nithiyanandhan on 22Sep2014 - ETR integration - Start
			$ETRPartnum =$ETRPartnum. '{"PARTNUMBER":"'.$pn_i[0].'","QTY":"'.$pn_i[1].'"}';
			//End
								
		}else{
			$pn_list=$pn_list . "p" . ($i+1) ."=". (trim($pn_i[0]));
			//Added by Nithiyanandhan on 22Sep2014 - ETR integration - Start
			$ETRPartnum = $ETRPartnum.",".'{"PARTNUMBER":"'.$pn_i[0].'","QTY":"1"}';
			//End
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
		{
	
			$AddBasketURL= $mystoreUrl . /*urlencode(*/"?add&newlang=" . $lang . "&p=" . $_req_storeId . "&s=" . $_req_siteId . "&" . $pn_list . "&url1=" . $RefUrl . "&catalogurl=" . $_req_catalogUrl/*)*/;
		}	
		else
		{
	
			$AddBasketURL= $mystoreUrl . urlencode("?add&newlang=" . $lang . "&p=" . $_req_storeId . "&s=" . $_req_siteId . "&" . $pn_list . "&url1=" . $RefUrl . "&catalogurl=" . $_req_catalogUrl);
		}	
	}else{

		$AddBasketURL= $mystoreUrl;
	}

}


//Added by Nithiyanandhan for USHHO integration - Start
else if(($_req_type=="ushho" || $_req_type=="") && $_req_storeUrl != "")
{


	
	//pn parameter of format sku|qty,sku|qty where qty can be omited if equal to 1
	//need to transform into pn1=sku&q1=qty&pn2=sku&q2=qty...
	//and preserve backward compatibility if only one product.
	//$ETRPartnum = "PARTNUMBER" : "E1E99UA", "QTY" : "2"},{ "PARTNUMBER" : "C4D27AA#ABA", "QTY" : "1";
	$pn_list="";
	$sku_list="";
	$qty="";

	$pn_a = explode(",", $_req_pn);
	for($i=0; $i < count($pn_a);$i++)
	{
		$pn_i = explode("|", $pn_a[$i]);
		if(count($pn_i)==2)
		{
			if($i===0)
			{
				$ETRPartnum = '{"PARTNUMBER":"'.$pn_i[0].'","QTY":"'.$pn_i[1].'"}';
				$sku_list = (trim($pn_i[0]))."|";
				$qty=(trim($pn_i[1]))."|";	
			}
			else
			{
				if($i===(count($pn_a)-1))
				{
					$sku_list = $sku_list.(trim($pn_i[0]));
					$qty=$qty.(trim($pn_i[1]));
					$ETRPartnum = $ETRPartnum.",".'{"PARTNUMBER":"'.$pn_i[0].'","QTY":"'.$pn_i[1].'"}';
				}
				else
				{
				$sku_list = $sku_list.(trim($pn_i[0]))."|";
				$qty=$qty.(trim($pn_i[1]))."|";
				$ETRPartnum = $ETRPartnum.",".'{"PARTNUMBER":"'.$pn_i[0].'","QTY":"'.$pn_i[1].'"}';

				}
			}
			
		}
		
		else
		{
			if($i==0)
			{
				$sku_list = (trim($pn_i[0]))."|";
				$ETRPartnum = '{"PARTNUMBER":"'.$pn_i[0].'","QTY":"1"}';
			}
			else
			{
				if($i===(count($pn_a)-1))
				{
					$sku_list = $sku_list.(trim($pn_i[0]));
					$ETRPartnum = $ETRPartnum.",".'{"PARTNUMBER":"'.$pn_i[0].'","QTY":"1"}';
				}
				else
				{
				$sku_list = $sku_list.(trim($pn_i[0]))."|";
				$ETRPartnum = $ETRPartnum.",".'{"PARTNUMBER":"'.$pn_i[0].'","QTY":"1"}';
				}
		    }
		}
		
	}
	$pn_list="sku=".$sku_list."&qty=".$qty;
	//end of pn treatment

//Added by Nithiyanandhan on 12/05/2014 - Optional code in the partner list added - Start
		    if(strpos($pn_list,"#")!==false)
			{
				$pn_list = str_replace('#', '%23', $pn_list);
			}
			if(strpos($pn_list,"|")!==false)
			{
				$pn_list = str_replace('|', '%7C', $pn_list);
			}
			if(strpos($jumpid,"/")!==false)
			{
				$jumpid = str_replace('/', '%2F', $jumpid);
			}
	//End
	
	$storeUrlUse = $url;

	$mystoreUrl .= "&pn=" . $pn_list . "&pkey=" . $_req_pkey . "&price=" . $_req_price . "&availability=". $_req_availability . "&url=" . urlencode($storeUrlUse);
	

	if($kelkoo_remove)
		$mystoreUrl =$storeUrlUse;
		

	//$mystoreUrl .= "&pn=" . $pn_i[0] . "&pkey=" . $_req_pkey . "&price=" . $_req_price . "&availability=". $_req_availability . "&url=" . urlencode($_req_storeUrl);


	if(stristr($_req_storeUrl,'#') === FALSE && stristr($_req_storeUrl,'S_POUND_E') === FALSE)
	{
		
		if($kelkoo_remove)
		{
		$AddBasketURL= $mystoreUrl . /*urlencode(*/"?". $pn_list . "&url1=" . $_req_refererUrl . "&catalogurl=" . $_req_catalogUrl."&template_type=".$template_type."&aoid=".$aoid."&jumpid=".$jumpid."&add_to_cart=Buy+from+hpshopping.com"     /*)*/;
		}
		else
		{
		$AddBasketURL= $mystoreUrl . urlencode("?" . $pn_list . "&url1=" . $_req_refererUrl . "&catalogurl=" . $_req_catalogUrl."&template_type=".$template_type."&aoid=".$aoid."&jumpid=".$jumpid."&add_to_cart=Buy+from+hpshopping.com");
		}
	}
	else
	{
		$AddBasketURL= $mystoreUrl;
	}
	
	
}


//End

else{


	if($_req_type=="ebus" ){
	
	
		include('include/csvload.php');
		$csv_file = "../../configuration/MP2Bpartners.csv";
		$mycsv = new CSV();
		$mycsv->CSVread($csv_file,",");
		eval($mycsv->generatePhpArray());
		//Added by Nithiyanandhan on 10/12/2014-CDW issue - start
	
		if($country=="us")
		{
				 $_req_pn = urlencode( $_req_pn);
				 $_req_price = urlencode($_req_price);
				    if(strpos($_req_pn,"%7C")!==false)
					{
						$_req_pn = str_replace('%7C', '|', $_req_pn);
					}
					if(strpos($_req_pn,"%2C")!==false)
					{
						$_req_pn = str_replace('%2C', ',', $_req_pn);
					}
					if(strpos($_req_price,"%7C")!==false)
					{
						$_req_price = str_replace('%7C', '|', $_req_price);
					}
					if(strpos($_req_price,"%2C")!==false)
					{
						$_req_price = str_replace('%7C', ',', $_req_price);
					}
		}
		//End	

		if(isset($urls[$_req_m])){
				 //Added By Manjunath on 11/03/2015-issue is adding ssad_id and ssad_url to AddBasketURL-start
				if($ssad_id!= null && $ssad_url!=null) 
				{   
						$mystoreUrl .= "&pn=" . $_req_pn . "&pkey=" . $_req_pkey . "&price=" . $_req_price . "&availability=".$_req_availability . "&url=";
							
						$AddBasketURL =$urls[$_req_m].$_req_pn."&ssad_id=".$ssad_id."&ssad_url=".urlencode($ssad_url);
						echo 'The add basket url is '.	$AddBasketURL ;
					} else 
					//Added By Sunetra Mhaske for language support on 07/07/2015
					{ 
						$dualsupp_url = Getdualsupp($lang,$_req_m); // call Getdualsupp function from dualsupp.php.inc
						if(isset($dualsupp_url))
						{
						$mystoreUrl .= "&pn=" . $_req_pn . "&pkey=" . $_req_pkey . "&price=" . $_req_price . "&availability=".$_req_availability."&url=";
						$AddBasketURL = $mystoreUrl.urlencode(trim($dualsupp_url).$_req_pn);
						}
						else
						{
						$mystoreUrl .= "&pn=" . $_req_pn . "&pkey=" . $_req_pkey . "&price=" . $_req_price . "&availability=".$_req_availability."&url=";
						$AddBasketURL = $mystoreUrl . urlencode($urls[$_req_m].$_req_pn);
						}
						
						echo 'The add basket url is '.	$AddBasketURL ;
					} //end of code for dual language support
						
					
				}
					
		     //end
			
	}
}



//debug if debug=... in query string
if(!empty($debug)){

	// To point to ISCS STG for Testing
	//echo "Before:" . $AddBasketURL;
	//echo "<p>";
	//echo "Product&Quantity | " . $pn_list . " |";
	//$AddBasketURL=str_replace("http://h20386.www2.hp.com/Singaporestore","http://h20387.www2.hp.com/SingaporeStore",$AddBasketURL);
	//$AddBasketURL=str_replace("http://h20386.www2.hp.com/Singaporestore","http://h20387.www2.hp.com/SingaporeStore",$AddBasketURL);
	//$AddBasketURL=str_replace("&RefererUrl","&q1=1&RefererUrl",$AddBasketURL);
	//$AddBasketURL=str_replace("lang=en-UK","lang=en-GB",$AddBasketURL);
	//echo "After:" . $AddBasketURL;
	// END To point to ISCS STG for Testing
	
	echo $debug_msg;
	echo "<H1>AddBasketUrl:</H1><BR> <A HREF=\"" . $AddBasketURL . "\">".urldecode($AddBasketURL)."</a><BR>";

	echo "<H1>MP2B Resellers :</H1><BR>";
	foreach ($urls as $key => $value) {
	   echo "Reseller ID : $key => Url : $value<br />\n";
	}

}
else
{
	if($AddBasketURL!="")
	{

		//Added by Nithiyanandhan on 19/09/2014 - ETR Integration start
		//Added by Nithyianandhan on 10/12/2014 - CDW issue - Start
		if($ETR=="yes" && $_req_type!="ebus")//End
		{
			
			echo"<form name='addtocart' action='' method='post'><input type='hidden' name='jsonreq' id='jsonreq' value=''></form>";
			echo "<script language='javascript'>submitForm('".$UserId."','".$Password."',
					'".$ETRstoreid."','".$ETRcurrency."','".$ETRLanguage."',[ ".$ETRPartnum." ],'".$ETRStoreURL."');</script>";
		}
		else
		{
//		echo "addbasket = ".$AddBasketURL;

			header("Location: " . $AddBasketURL);
		}
	//End
	
	}
}


?>



