<?php
/**
 * /ezbuy/common/php/logo.php
 * $Date: 2009/03/24 08:13:39 $
 * $Revision: 1.2 $
 * $Author: ezbuydev $
 * $Id: logo.php,v 1.2 2009/03/24 08:13:39 ezbuydev Exp $
 * $Log: logo.php,v $
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
 * Revision 1.3  2007/02/02 12:46:38  ezbuy
 * New logo process update (Flash)
 *
 * Revision 1.2.14.4  2007/02/02 12:15:40  ezbuy
 * correct bug on CSV load library
 *
 * Revision 1.2.14.3  2007/01/17 15:25:19  ezbuy
 * "Central logo configuration" files documented and finalized
 * with logo process update in Flash
 *
 * Revision 1.2.14.2  2006/12/15 16:11:55  ezbuy
 * Finalize logoUrl externalisation.
 *
 * Revision 1.2.14.1  2006/11/30 14:13:08  ezbuy
 * Changes in central logo configuration according to Stephane's feedback
 *
 * Revision 1.2  2006/11/16 13:00:26  ezbuy
 * REL_873_E_877_PROD with:
 * - SmartChoice
 * - new CSS
 * - new SB with partner specific sessions
 * - new EPP
 * - performance improvement on PSC with delayed rendering
 *
 * Revision 1.1.6.2  2006/11/16 11:58:25  ezbuy
 * - prepare files for later compression (clean javascript)
 * - new DBC partners
 * - new jumpid for hpsb
 *
 * Revision 1.1.6.1  2006/11/07 07:22:32  slechner
 * latest CSS integration on latest trunk
 *
 * Revision 1.1.4.1  2006/10/24 14:29:19  slechner
 * merge from REL_825_E into REL_863_E : SmartChoice release
 *
 * Revision 1.1.2.3  2006/10/02 07:10:07  slechner
 * - fixed logos issues
 * - introduced Omniture for intermediary buttons
 * - updated CSS as per 21Torr
 *
 * Revision 1.1.2.2  2006/09/29 16:38:51  slechner
 * logos validated, alt text implemented + link through logo.php implemented
 *
 * Revision 1.1.2.1  2006/09/26 14:11:21  slechner
 * logo.php added + template_flash_new deleted as identical to template_flash
 *
 *
 * $Name: HEAD $
 * $State: Exp $
 *
 * +======================================================================================================+
 * | EZB logo redirection code to redirect to Intel/AMD web page
 * +======================================================================================================+
 * +------------------------------------------------------------------------------------------------------+
 * | Code Structure:
 * | --------------
 * | Read Input parameters (query string)
 * | Get redirect URL from "logoPageLang.csv" configuration file through csvload.php library
 * | Get page for intel/amd logo redirection (if not provided through querystring) from "logos.csv" configuration file
 * | 	through csvload.php library too
 * | Redirect
 * +------------------------------------------------------------------------------------------------------+
 * | Usage:
 * | ------
 * |Call from Flash : http://../logo.php?lang=de&logoID=cmts or
 * |Call from JS : http://../logo.php?lang=de&logoID=cmts&page=cmts.htm
 * |2-letter ISO language code: lang=en&
 * +------------------------------------------------------------------------------------------------------+
 * | Glossary:
 * | ---------
 * +------------------------------------------------------------------------------------------------------+
 * | Internals:
 * | ----------
 * | 01/17/2007: change in specifiation : amd standard url is located in logos.csv as page element
 * | 			 rather than in logoPageLang.csv file as web site path
 * | 01/16/2007: implement merge so that logo.php may be called from either PHP/flash
 * | 12/15/2006: finalize logoUrl externalization
 * | 11/30/2006: externalise redirection urls to "logoPageLang.csv" configuration file
 * +------------------------------------------------------------------------------------------+
 * | Debug:
 * | --------
 * | Use debug=.. as additional query string parameter
 * +------------------------------------------------------------------------------------------+
 * | Assumptions:
 * | ------------
 * | None
 * +------------------------------------------------------------------------------------------+
 * | JS Context used:
 * | ---------------
 * +------------------------------------------------------------------------------------------+
 * | JS Context defined:
 * | ------------------
 * +------------------------------------------------------------------------------------------+
 * | exceptions:
 * | -----------
 * | $type variable is defined from $logoID value passed on as parameter
 * |
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
 * Process parameters
 */
$_req_mandatory_var_names = array(); //mandatory parameters
$_req_optional_var_names = array("debug","lang","logoID","page"); //optional parameters
$param_ok=UtilsProcessParams($_req_mandatory_var_names, $_req_optional_var_names, "debug");


$type="";
if ($logoID) {
	$type = ereg("amd",$logoID)?"amd":"intel";
}

include('include/csvload.php');

/*
 * Load CSV libraries
 * Create logo PHP array
 */

if (!$page) {
	$PHPoutput=1;
	$csv_file = "../../configuration/logos.csv";
	$mycsv = new CSV();
	$mycsv->CSVread($csv_file,",");
	eval($mycsv->generateLogoArray($PHPoutput));
}
$logoURL="";
if ($type=="intel") {
	$csv_file = "../../configuration/logoPageLang.csv";
	$mycsv = new CSV();
	$mycsv->CSVread($csv_file,",");
	eval($mycsv->generatePhpArray());

	if(ereg("special_",$page)){
		$lang=$lang."_special";
		if (isset($urls[$lang])) {
			$logoURL=$urls[$lang];
		} else if (isset($urls["others"])) {
			$logoURL=$urls["others_special"];
		}
		$page=str_replace("special_", "", $page);
		$logoURL=str_replace("XXX", $page, $logoURL);
	}else{
		// Intel logos
		if (isset($urls[$lang])) {
			$logoURL=$urls[$lang];
		} else if (isset($urls["others"])) {
			$logoURL=$urls["others"];
		} else {
			$logoURL="http://www.intel.com/intelinside/weblinks/english/";
		}

		if($page) {
			$logoURL .= $page;
		}
		else {
			$logoURL .= $ezb_logos["$logoID"]["page"];
		}
	}

} else if ($type=="amd") {
	// AMD logos
	if($page) {
		$logoURL = $page;
	}
	else {
		$logoURL = $ezb_logos["$logoID"]["page"];
	}
 }

/*
 * Redirect
 */
//debug if debug=... in query string
if(!empty($debug)){
	echo $debug_msg;
	echo "<H1>Logo URL:</H1><BR> <A HREF=\"" . $logoURL . "\">".urldecode($logoURL)."</a>";
}else{
	//Change location to logoURL
	if($logoURL!="")
		header("Location: " . $logoURL);
}
?>