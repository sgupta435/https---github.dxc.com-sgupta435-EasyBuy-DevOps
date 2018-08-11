<?php
/**
 * /ezbuy/common/php/GetEzbSettings.php
 * $Date: 2009/03/24 08:13:39 $
 * $Revision: 1.2 $
 * $Author: ezbuydev $
 * $Id: GetEzbSettings.php,v 1.2 2009/03/24 08:13:39 ezbuydev Exp $
 * $Log: GetEzbSettings.php,v $
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
 * $Name: HEAD $
 * $State: Exp $
 *
 **/

/*
 * Include Utils Library
 */
require_once "include/ezb_utils.ProcessParams.php.inc";

/*
 * Include XML Utils Library
 */
require_once "include/ezb_xml_utils.php.inc";
/*
 * Include Settings Utils Library
 */
require_once "include/ezb_settings.php.inc";

/*
 * Process parameters
 */
$_req_mandatory_var_names = array("cc","lc","ms","clientId"); //mandatory parameters
$_req_optional_var_names = array("JSparam"); //optional parameters
$param_ok=UtilsProcessParams($_req_mandatory_var_names, $_req_optional_var_names, "debug");

$format=strtolower($format);
if($format =="")/*default*/
	$format="xml";

/*
 * Avoid caching / treat debug / format
 */
if(!headers_sent()){
/*	if(!$debug){
		if($format=="xml"){
			header("Content-type: text/xml; charset=utf-8");
		} else if ($format == "js_s" || $format == "json") {
			header("Content-type: text/javascript; charset=utf-8");
		}
	}else{
*/
			header("Content-type: text/html; charset=utf-8");
/*	} */

	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
}

if($debug) {
	echo $debug_msg;
}

// Make sure if the format is JSON, the 'callback' param is also provided
if ($format !="" && $format == "json") {
	if ($callback == "") {
		$param_ok=false;
		if($debug) {
			echo "missing Callback parameter";
		}
	}
}

/*
 * Re-declare variables needed for included scripts
 */
$country=$cc;
$lang=$lc;

/*
 * Include Exceptions
 */
include ("include/country_exceptions.php");

/*
 * Re-assign variables needed
 */
$cc=$country;
$lc=$lang;
$ms = strtolower($ms);

if ($debug) {
    echo "New cc, ll, ms:<BR>";
    echo "--------------<BR>";
    echo "$cc $lc $ms";
    echo "<BR>++++++++++++++++++++<BR>";
}

if(!$param_ok){
	if($format=="xml")
	   	echo '<?xml version="1.0" ?><ezb><!--missing params--></ezb>';
	else
		echo "error={\"Response\":{\"version\" : \"0.0\",\"status\":{\"code\" : \"0\",\"message\" : \"Missing Params\"},\"query\":{\"cc\" : \"$cc\",\"lc\" : \"$lc\",\"ms\" : \"$ms\",\"clientId\" : \"$clientId\",\"format\" : \"$format\",\"callback\" : \"$callback\"}}};";
}else{
	$param = array(
	"configXmlFile"=>array("xml", ""),
	"priceDecimal"=>array("xml", ""),
	"showDirectTemplate"=>array("xml", ""),
	"indPriceOrder"=>array("xml", ""),
	"partnersExcludeIds"=>array("xml", ""),
	"partnersRestrictIds"=>array("xml", ""),
	"excludePercRefPrice"=>array("xml", ""),
	"partnersExcludePercHigh"=>array("xml", ""),
	"partnersExcludePercLow"=>array("xml", ""),
	"goXmlQuery"=>array("xml", ""),
	"elocatorURL"=>array("xml", ""),
	"disablePNs"=>array("xml", ""),
	"dataserver"=>array("xml", ""),
	"HPdataserver"=>array("xml", ""),
	"dataserverSource"=>array("xml", ""),
	"kelkooserver"=>array("xml", ""),
	"searchXmlQuery"=>array("xml", ""),
	"HPsearchXmlQuery"=>array("xml", ""),
	"css_file"=>array("xml", ""),
	"searchXmlQuerySource"=>array("xml", ""),
	"option"=>array("xml", ""),
	"disableLogosLink"=>array("xml", ""),
	"enableTracking"=>array("xml", ""),
	"ezbCurrencyCode"=>array("xml", "")
	);
	$config=GetEzbSettings($param, $JSparam, $cc, $lc, $ms, $clientId, "xml", $debug);
	$xml=$config;
	if(!$config){
			echo "Issue getting Settings";
		exit();
	}
	elegant_dump($config);
}
?>