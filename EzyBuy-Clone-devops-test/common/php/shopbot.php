<?php
/**
 * /ezbuy/common/php/shopbot.php
 * $Date: 2009/03/24 08:13:39 $
 * $Revision: 1.2 $
 * $Author: ezbuydev $
 * $Id: shopbot.php,v 1.2 2009/03/24 08:13:39 ezbuydev Exp $
 * $Log: shopbot.php,v $
 * Revision 1.2  2009/03/24 08:13:39  ezbuydev
 * IT_3_0_1_2249_B with:
 * fix EZB.RequestMaxProd issue
 * fix usage of pr instead of res[0].pr
 * introduce ForceDirectExperience new .ini option
 * fix IL alignement right to left issue
 * fix GetEzbData issue when space contained in product number parameter
 * introduce special_ logos type
 * fix reporting error with special characters
 * introduce HP store revenue split recognition
 *
 * Revision 1.1.1.1.2.1  2009/03/24 07:51:16  ezbuydev
 * IT_3_0_1_2249_B with:
 * fix EZB.RequestMaxProd issue
 * fix usage of pr instead of res[0].pr
 * introduce ForceDirectExperience new .ini option
 * fix IL alignement right to left issue
 * fix GetEzbData issue when space contained in product number parameter
 * introduce special_ logos type
 * fix reporting error with special characters
 * introduce HP store revenue split recognition
 *
 * Revision 1.2  2005/12/15 18:28:21  slechner
 * direct templates PL/CZ/HU / FIF-HTML alignment / Greece empty indication Price / R6 preparation
 *
 * Revision 1.1.1.1.28.1  2005/12/07 15:46:16  slechner
 * alignment and R6 preparation
 *
 * Revision 1.1.1.1  2005/11/13 20:47:58  slechner
 * initial import
 *
 * $Name: HEAD $
 * $State: Exp $
 *
 * +======================================================================================================+
 * | EZB shopbot redirection code to redirect to Kelkoo "find partner" in case of no Flash/JS
 * +======================================================================================================+
 * +------------------------------------------------------------------------------------------------------+
 * | Code Structure:
 * | --------------
 * | Read Input parameters (query string)
 * | Convert 3 letters language code to 2 letters language code
 * | detect and set segment
 * | sets exceptions (mainly country/segment forcing)
 * | get redirect URL from country settings
 * | redirect
 * +------------------------------------------------------------------------------------------------------+
 * | Usage:
 * | ------
 * | http://../shopbot.php?partnr=C6518A&m_s=smb&country=de&lang=de
 * |2-letter ISO country code: country=uk& (used to get right country settings/options/configuration)
 * |2-letter ISO language code: lang=en&
 * |product numbers: partnr=PF997AA&
 * +------------------------------------------------------------------------------------------------------+
 * | Glossary:
 * | ---------
 * +------------------------------------------------------------------------------------------------------+
 * | Internals:
 * | ----------
 * |11/01/2005: Middle east exception:emea_middle_east force to me
 * |
 * +------------------------------------------------------------------------------------------+
 * | Debug:
 * | --------
 * | Use debug=.. as additional query string parameter
 * +------------------------------------------------------------------------------------------+
 * | Assumptions:
 * | ------------
 * |include/countrysettings_load.php requires $m_s $lang $country
 * +------------------------------------------------------------------------------------------+
 * | JS Context used:
 * | ---------------
 * +------------------------------------------------------------------------------------------+
 * | JS Context defined:
 * | ------------------
 * +------------------------------------------------------------------------------------------+
 * | exceptions:
 * | -----------
 * |force m_s to smb if ch/de or ch/fr
 * |force m_s to hho if pl, cz, hu, tr, me
 * +------------------------------------------------------------------------------------------+
 * | caching:
 * | -----------
 * +==========================================================================================+
 *
 **/

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
$_req_optional_var_names = array("debug","country","m_s","lang","partnr","clientId"); //optional parameters
$param_ok=UtilsProcessParams($_req_mandatory_var_names, $_req_optional_var_names, "debug");

/*
 * Detects/sets segment
 */
// match /ho/ in referer url : allow to catch segment for old EZBuy implementation code (v2)
if (($m_s == "") && (ereg("/ho/",$_SERVER["HTTP_REFERER"]))) {
	$m_s = "hho";
}

include ("include/country_exceptions.php");

/*
 * Reads settings for country/segment
 */
$paramCollection = array("shopbotURL" =>array("xml", "http://h30145.www3.hp.com/bin/findNow?CLIENT_ID=HP_EUROPE"));
$res = GetEzbSettings($paramCollection, null, $country, $lang, $m_s, $clientId, "xml", $debug);

$shopbotURL = $res["shopbotURL"];
$shopbotURL = ereg_replace("#PN#",$partnr, $shopbotURL);

/*
 * Redirect
 */
//debug if debug=... in query string
if(!empty($debug)){
	echo $debug_msg;
	echo "<H1>ShopBot URL:</H1><BR> <A HREF=\"" . $shopbotURL . "\">".urldecode($shopbotURL)."</a>";
}else{
	if($shopbotURL!="")	//Change location to shopbotURL
		header("Location: " . $shopbotURL);
}

?>