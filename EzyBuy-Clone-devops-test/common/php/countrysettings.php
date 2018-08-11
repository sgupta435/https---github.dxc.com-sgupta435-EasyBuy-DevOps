<?php
/**
 * /ezbuy/common/php/countrysettings.php
 * $Date: 2009/03/24 08:13:39 $
 * $Revision: 1.2 $
 * $Author: ezbuydev $
 * $Id: countrysettings.php,v 1.2 2009/03/24 08:13:39 ezbuydev Exp $
 * $Log: countrysettings.php,v $
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
 * Revision 1.41  2008/01/25 10:10:11  ezbuy
 * fix enable tracking issue
 *
 * Revision 1.40  2008/01/24 16:46:09  ezbuy
 * update config from prod. Fix bug with option noStaticDisable 1615
 *
 * Revision 1.39  2007/12/17 23:59:32  ezbuy
 * fixed null lead for when price indication was empty
 * remove internal http call for countrysettings (DCC preparation)
 *
 * Revision 1.38.2.1  2007/12/17 23:36:44  ezbuy
 * fixed null lead for when price indication was empty
 * remove internal http call for countrysettings (DCC preparation)
 *
 * Revision 1.38  2007/11/27 13:23:14  ezbuy
 * merge with 1340
 *
 * Revision 1.37  2007/11/14 15:19:06  ezbuy
 * update config from prod
 *
 * Revision 1.36  2007/09/21 16:34:50  ezbuy
 * - Omniture H
 * - priceDecimal bug
 *
 * Revision 1.35  2007/09/17 12:16:12  ezbuy
 * Update config from Prod
 *
 * Revision 1.34  2007/09/12 15:38:48  ezbuy
 * - fixed bug for context options handling
 *
 * Revision 1.33.6.1  2007/09/12 15:30:45  ezbuy
 * - fixed bug for context options handling
 *
 * Revision 1.33  2007/08/15 11:33:55  ezbuy
 * -made most of JS minified
 * -introduce option for ImageBuilder to display banners containing ezbuy
 * -made shopping basket compliant with "any" market segment
 *
 * Revision 1.32.4.1  2007/08/15 10:30:05  ezbuy
 * -made most of JS minified
 * -introduce option for ImageBuilder to display banners containing ezbuy
 * -made shopping basket compliant with "any" market segment
 *
 * Revision 1.32  2007/07/08 20:37:27  ezbuy
 * 1284_E_PROD_1285
 *
 * Revision 1.31.6.1  2007/07/08 20:30:19  ezbuy
 * remove countrysettings server call by including it in buildflash
 *
 * Revision 1.31  2007/06/22 22:53:05  ezbuy
 * Added Compression and Caching lib
 * Compression and Caching used in loadjs, buildflash and countrysettings
 *
 * Revision 1.30  2007/06/22 22:37:40  ezbuy
 * new Intel/AMD logos
 * Intel/AMD logos now loaded via jpg format in Flash
 * Global countrysettings
 *
 * Revision 1.29.6.1  2007/06/22 22:30:04  ezbuy
 * new Intel/AMD logos
 * Intel/AMD logos now loaded via jpg format in Flash
 * Global countrysettings
 *
 * Revision 1.29.4.1  2007/06/22 22:43:51  ezbuy
 * Added Compression and Caching lib
 * Compression and Caching used in loadjs, buildflash and countrysettings
 *
 * Revision 1.29  2007/05/16 10:43:35  ezbuy
 * force no EZB display if product contains PRE
 * stop forcing SHowAMDLogos
 * introduce new Omniture as:
 * - remove usage of event 15 as buy offline. Replace by s_eVar31
 * - introduce event 20 as number of price requests to back-end
 * - introduce eVar30 as HP.com first lead origin
 *
 * Revision 1.28.16.1  2007/05/16 10:37:01  ezbuy
 * force no EZB display if product contains PRE
 * stop forcing SHowAMDLogos
 * introduce new Omniture as:
 * - remove usage of event 15 as buy offline. Replace by s_eVar31
 * - introduce event 20 as number of price requests to back-end
 * - introduce eVar30 as HP.com first lead origin
 *
 * Revision 1.28  2007/03/20 13:23:11  ezbuy
 * update config from Prod
 *
 * Revision 1.26  2007/02/16 00:17:43  ezbuy
 * rel_1067_E_1068_PROD with:
 * - new smartchoice omniture var
 * - partner restriction takes precedence over exclusion in case both defined in ini files
 *
 * Revision 1.25.8.1  2007/02/16 00:13:50  ezbuy
 * rel_1067_E_1068_PROD with:
 * - new smartchoice omniture var
 * - partner restriction takes precedence over exclusion in case both defined in ini files
 *
 * Revision 1.25  2007/02/08 22:55:25  ezbuy
 * new .ini dynamic condition revive from initial release 960 that caused performance issue
 *
 * Revision 1.24.4.2  2007/02/06 17:19:45  ezbuy
 * end of unit tests
 *
 * Revision 1.24.4.1  2007/02/06 16:14:28  ezbuy
 * development done. tests on-going
 *
 * Revision 1.20  2007/01/25 12:29:02  ezbuy
 * Release 961 published in urgency due to a bug in countrysettings.php.
 * no branch created for this bug.
 *
 * Revision 1.19  2007/01/24 17:30:41  ezbuy
 * - New .ini conditional section capability
 * - Unique interface for FIF/Flash template ezinterface.swf
 *
 * Revision 1.17.8.8  2007/01/24 15:49:05  ezbuy
 * comments and version number ready before MTP
 *
 * Revision 1.17.8.7  2007/01/19 17:22:36  ezbuy
 * Change separator to "EZ_S" in query string
 *
 * Revision 1.17.8.6  2007/01/19 13:37:54  ezbuy
 * Added 2 conditionnal sections in "New .ini conditional section capability" project : "Start With" and "Not Start With"
 * Change algorithm so that conditions are evaluated in order according to their priority for all javascript variables in a shot
 *
 * Revision 1.17.8.5  2007/01/18 11:17:23  ezbuy
 * - change JS Param separator list from "|" to ";"
 * - Fix bug with FIF not having JSParam as parameter
 *
 * Revision 1.17.8.4  2007/01/17 18:59:24  ezbuy
 * Fix bug with JS variables truncated when containing "&".
 *
 * Revision 1.17.8.3  2007/01/15 18:30:54  ezbuy
 * "New .ini conditional section capability" files documented and finalized
 *
 * Revision 1.17.8.2  2007/01/12 17:57:48  ezbuy
 * development on-going - day 2
 *
 * Revision 1.17.8.1  2007/01/11 18:57:49  ezbuy
 * development on-going
 *
 * Revision 1.17  2006/12/15 00:02:20  ezbuy
 * - process gpsy prices (newFlash and newCSS only)
 * - process promo node (newFlash and newCSS only)
 * - fix third screen for CSS templates that should not show if HP as reseller
 * - display promo info (newCSS)
 *
 * Revision 1.16.20.1  2006/12/14 23:59:27  ezbuy
 * - process gpsy prices (newFlash and newCSS only)
 * - process promo node (newFlash and newCSS only)
 * - fix third screen for CSS templates that should not show if HP as reseller
 * - display promo info (newCSS)
 * Revision 1.16.14.1  2007/01/17 15:25:19  ezbuy
 * "Central logo configuration" files documented and finalized
 * with logo process update in Flash
 * Revision 1.16  2006/11/16 13:00:26  ezbuy
 * REL_873_E_877_PROD with:
 * - SmartChoice
 * - new CSS
 * - new SB with partner specific sessions
 * - new EPP
 * - performance improvement on PSC with delayed rendering
 *
 * Revision 1.15.30.3  2006/11/16 11:58:24  ezbuy
 * - prepare files for later compression (clean javascript)
 * - new DBC partners
 * - new jumpid for hpsb
 *
 * Revision 1.15.30.2  2006/11/09 22:35:24  slechner
 * merge with REL_803_E
 *
 * Revision 1.15.30.1  2006/11/07 07:22:31  slechner
 * latest CSS integration on latest trunk
 *
 * Revision 1.15.24.1  2006/10/24 14:29:15  slechner
 * merge from REL_825_E into REL_863_E : SmartChoice release
 *
 * Revision 1.15.14.4  2006/10/04 09:45:54  slechner
 * - introuce priceDecimal option in .ini so that price format can be configured.
 * - updated MyEZB accordingly
 *
 * Revision 1.15.14.3  2006/09/27 15:37:07  slechner
 * Flash bug fix for independance to XML DTD + getHTMLTemplate only
 *
 * Revision 1.15.14.2  2006/09/20 15:16:17  slechner
 * bug correction on newFlashHTML parameter
 *
 * Revision 1.15.14.1  2006/09/13 16:13:03  slechner
 * options newFlashHTML to allow for new templates design for both HTML and Flash
 * option fullHTML to have only HTML templates
 *
 * Revision 1.15  2006/08/03 10:01:36  slechner
 * New config_xml encoding for HTML and Flash templates - Dynamic XML Features live again
 *

 * Revision 1.14  2006/08/03 08:46:40  slechner
 * - changed MyHardwareChoice to BestPrints for MP2B in shopping basket addbasket.php
 * - added HP market (SK) and Vepenet (FR) as new partners for DBC in ezb_opened_partners.js
 * - modified precedence of PartnersRestrict/Exclude rule to cope with SureSupply
 * - latest config from prod
 *
 * Revision 1.13.6.1  2006/08/03 08:31:29  slechner
 * - changed MyHardwareChoice to BestPrints for MP2B in shopping basket addbasket.php
 * - added HP market (SK) and Vepenet (FR) as new partners for DBC in ezb_opened_partners.js
 * - modified precedence of PartnersRestrict/Exclude rule to cope with SureSupply
 *
 * Revision 1.13.2.1  2006/08/01 15:51:53  slechner
 * Fix for encoding problems implemented
 *
 * Revision 1.13  2006/07/26 09:08:51  slechner
 * Dynamic XML features live
 *

 * Revision 1.12  2006/07/14 07:11:30  slechner
 * fix issue with enabletracking not present in .ini
 *
 * Revision 1.10  2006/06/01 12:50:12  slechner
 * FIF Add to Basket project live
 *
 * Revision 1.9.4.3  2006/05/31 17:09:24  slechner
 * Implement "proxyLcFile" variable in countrysettings.ini file
 *
 * Revision 1.9.4.2  2006/05/30 08:49:54  slechner
 * modifications following Stephane's feedback on first tests
 *
 * Revision 1.9.4.1  2006/05/19 16:00:45  slechner
 * enf of 1st day test on FIF add to basket
 *
 * Revision 1.9  2006/05/05 23:55:11  slechner
 *  Omniture FIF implementation update:
 * -EmptyEZBvar() for not sending page variables if not an hp page (case for RichFX)
 * -Set Omniture vars for FIF non HP page catalogs
 * -Added two vars to be sent for FIF: s_evar16 and s_evar20 to track campaigns
 * -Do send Omniture data for FIF to emea account not only ezbuy account
 * -Do not sent Omniture data to any other account than HP
 * -Temporarily send FIF Omniture data to dev account for FIF remote catalogs
 * - Fixed bug preventing sendOmnitureLoad to work if a normal ezbuy was following a FIF movie!
 * - Fixed bug causing no Omniture tracking/AMD logos in countrysettings
 * - updated latest config from prod files
 * - added small Shopping basket template
 *
 * Revision 1.8.2.1  2006/05/05 23:51:59  slechner
 *  Omniture FIF implementation update:
 * -EmptyEZBvar() for not sending page variables if not an hp page (case for RichFX)
 * -Set Omniture vars for FIF non HP page catalogs
 * -Added two vars to be sent for FIF: s_evar16 and s_evar20 to track campaigns
 * -Do send Omniture data for FIF to emea account not only ezbuy account
 * -Do not sent Omniture data to any other account than HP
 * -Temporarily send FIF Omniture data to dev account for FIF remote catalogs
 * - Fixed bug preventing sendOmnitureLoad to work if a normal ezbuy was following a FIF movie!
 * - Fixed bug causing no Omniture tracking/AMD logos in countrysettings
 * - updated latest config from prod files
 * - added small Shopping basket template
 *
 * Revision 1.8  2006/04/28 14:22:08  slechner
 * FIF Omniture implementation + new AMD logos activated
 *
 * Revision 1.7.22.4  2006/04/28 13:12:34  slechner
 * New AMD logos OK and showAMDlogo option on
 *
 * Revision 1.6.2.1  2006/03/01 16:45:19  slechner
 * Flash taking XML from FLashVars if defined
 * if ezbpartnr define get ezb_js to load all data to re-use later on
 *
 * Revision 1.5.10.3  2006/02/16 10:21:39  slechner
 * Developped with disablePNs = "pn1;pn2" option in countrysettings.ini file
 *
 * Revision 1.4.2.1  2006/01/20 10:12:50  slechner
 * Replace HTTP loads by local loads
 *
 * Revision 1.3  2006/01/03 09:44:08  slechner
 * january 3rd new logo release
 *
 * Revision 1.2.10.1  2005/12/30 15:31:44  slechner
 * file_get_contents doesn't use absolute http path but relative pass to bypass sting staging security restriction
 *
 * Revision 1.2  2005/12/15 18:28:22  slechner
 * direct templates PL/CZ/HU / FIF-HTML alignment / Greece empty indication Price / R6 preparation
 *
 * Revision 1.1.1.1.28.3  2005/12/13 09:47:01  slechner
 * before release in 599
 *
 * Revision 1.1.1.1.28.2  2005/12/09 16:42:37  slechner
 * end of week 49 : development finished and commented
 *
 * Revision 1.1.1.1.28.1  2005/12/07 15:46:16  slechner
 * alignment and R6 preparation
 *
 * Revision 1.1.1.1.10.2  2005/11/16 15:22:28  slechner
 * ezb direct for PL, CZ and HU - end of 2nd day development
 *
 * Revision 1.1.1.1.10.1  2005/11/15 17:24:59  slechner
 * ezb direct for PL, CZ and HU - end of 1st day development
 *
 * Revision 1.1.1.1  2005/11/13 20:47:55  slechner
 * initial import
 *
 * $Name: HEAD $
 * $State: Exp $
 *
 * +======================================================================================================+
 * | EZB Country configuration read
 * +======================================================================================================+
 * +------------------------------------------------------------------------------------------------------+
 * | Code Structure:
 * | --------------
 * | Read Input Parameters
 * | Include ezbuy box size calculations
 * | Include country settings load
 * | Data gathering
 * | Set exceptions
 * | FIF=true -> output in XML format
 * | FIF= -> output in JS format
 * | 	  -> Config XML loaded and stored in ezbconfigxml JS var
 * +------------------------------------------------------------------------------------------------------+
 * | Usage:
 * | ------
 * | http://.../ezbuy/common/php/countrysettings.php?country=uk&lang=en&version=548&m_s=smb&clientID=undefined&FIF=true
 * |2-letter ISO country code: country=uk& (used to get right country settings/options/configuration)
 * |2-letter ISO language code: lang=en& (3 letters possible as conversion to two letters done)
 * |version: version=405 (not used outside caching page)
 * |market segment: m_s=hho
 * | client identification: clientID=
 * | FIF flag: FIF=true (used to send back XML as opposed to JS)
 * | countrysettings.php is called from EZBuy FIF and HTML parts
 * | - when called from FIF, FIF=true is passed on to the query string and the output is XML format
 * | - when called from HTML, FIF= is empty and the output is JS format
 * | Variables are all defined with placeholders like #PLACEHOLDER# in :
 * | - output_javascript.txt for JS output
 * | - output_xml.txt for XML output
 * +------------------------------------------------------------------------------------------------------+
 * | Glossary:
 * | ---------
 * +------------------------------------------------------------------------------------------------------+
 * | Internals:
 * | ----------
 * |07/08/2007: Include countrysettings in buildflash to save one server call
 * |05/15/2007: Remove forcing of ShowAMDlogos
 * |02/14/2007: Partner restriction takes precedence over exclusion if both are defined
 * |01/19/2007: Added 2 conditionnal sections in "New .ini conditional section capability" project
 * |			"Start With" and "Not Start With"
 * |			Change algorithm so that conditions are evaluated in section order according to section priority for all javascript variables in a shot
 * |01/18/2007: Added options for fullHTMLDirect to use CSS only for direct experience
 * |01/17/2007:
 * | 			Implement ezb_logos hard-coded information (logo information)
 * | 			by a CSV file ini/logos.txt loaded through include/csvload.php library
 * | 				: Provide a JS array for JS output
 * | 				: Provide a PHP array for determining logo Ids that must be part of $disableLogosLink variable
 * |			Each logo which link must not be activated is part of the semicolon separated list $disableLogosLink
 * |01/15/2007: Added "New .ini conditional section capability"
 * |11/06/2006: Added options for fullHTML, newFlash, price decimal
 * |08/03/2006: Modified treatment of partnersRestrict and Exclude to allow for restriction/exclusion defined in
 * |            ClientId section to overwrite the ones from the general section
 * +------------------------------------------------------------------------------------------+
 * | Debug:
 * | --------
 * | Ex : /ezbuy/common/php/countrysettings.php?country=uk&lang=en&version=595&PL=&m_s=smb&clientID=undefined&guistyle=normal&ezbExp=neutral&FIF=true
 * +------------------------------------------------------------------------------------------+
 * | Assumptions:
 * | ------------
 * | include scripts require $variables to be defined ($country,...)
 * |
 * +------------------------------------------------------------------------------------------+
 * | JS Context used:
 * | ---------------
 * | none
 * +------------------------------------------------------------------------------------------+
 * | JS Context defined:
 * | ------------------
 * | countrysettingsLoaded
 * | All .ini defined data
 * +------------------------------------------------------------------------------------------+
 * | exceptions:
 * | -----------
 * | indPriceOrder
 * | 	if equal to "" or not available in countrysettings.php return a default value equal to "sto;pp;sp;mea"
 * | 	if equal to "empty" return a value equal to ""
 * |
 * | configXmlFile if not available in countrysettings.ini will default to
 * |  			"config_hho.xml" if m_s=hho
 * |  			"config_smb.xml" if m_s=smb
 * | smallInterfaceFile if not available in countrysettings.ini will default to
 * |  			"ezinterface_small_new.swf"
 * | stdInterfaceFile if not available in countrysettings.ini will default to
 * |  			"ezinterface_new.swf"
 * | excludePercRefPrice if does not contain any values included in "sp","pp","sto" will default
 * |  			"sp"
 * | partnersExcludeIds
 * | 	replace "," by ";"
 * | partnersRestrictIds
 * | 	replace "," by ";"
 * | searchXmlQuery
 * | 	if partnersExcludeIds is available in countrysettings.ini file, will append "&m_e=partnersExcludeIds" to searchXmlQuery
 * | 	if partnersRestrictIds is available in countrysettings.ini file, will append "&m_r=partnersRestrictIds" to searchXmlQuery
 * | 	For FIF only, if guistyle=normal and ezbExp=direct, will append "&type=hp" to searchXmlQuery
 * | elocatorURL
 * | 	PL added to elocatorURL if CLIENT_ID=HP_EUROPE et PL non vide
 * | enableTracking option set-up by default for HTML and FIF parts
 * +==========================================================================================+
 *
 **/

/*
 * Include Utils Library
 */
require_once "include/ezb_utils.ProcessParams.php.inc";
/*
 * Include Get Settings Library
 */
require_once "include/ezb_settings.php.inc";
/*
 * Process parameters
 */
$_req_mandatory_var_names = array("country", "lang", "clientID"); //mandatory parameters
$_req_optional_var_names = array("debug", "FIF", "guistyle", "ezbExp", "m_s", "IncludeCountrysettings"); //optional parameters
$param_ok=UtilsProcessParams($_req_mandatory_var_names, $_req_optional_var_names, "debug");

/*
 * Return HTTP headers
 */
if (!headers_sent()) { // in case file not included via php include
	if (!$debug && $FIF == "true") {
		// Always try to cache this page
		header("Content-Type: text/xml; charset=utf-8");
		require_once('include/CompressionAndCaching.class.php.inc');
		$cache = new Cache_And_Compression(array('revalidate' =>false));
		$cache->Start();
	} else {
		if (!$debug) {
			/*
			 * Allow caching & Compression
			 */
			header("Content-Type: text/javascript; charset=utf-8");
			require_once('include/CompressionAndCaching.class.php.inc');
			$cache = new Cache_And_Compression(array('revalidate' =>false));
			$cache->Start();
		} else {
			header("Content-Type: text/html; charset=utf-8");
			header("Expires: Mon, 20 Feb 2090 05:00:00 GMT");
			header("Last-Modified: Mon, 26 Jul 1997 05:00:00 GMT");
		}
	}
}
if($debug)
	echo $debug_msg;

if ($FIF=="true")
 $format = "xml";
else
 $format = "js";

if (!$param_ok){
	if($format=="xml")
	   	echo '<?xml version="1.0" ?><root><!--missing params--></root>';
	else
		echo "error={\"Response\":{\"version\" : \"0.0\",\"status\":{\"code\" : \"0\",\"message\" : \"Missing Params\"},\"query\":{\"cc\" : \"$country\",\"lc\" : \"$lang\",\"ms\" : \"$m_s\",\"clientId\" : \"$clientID\",\"format\" : \"$format\",\"callback\" : \"N/A\"}}};";

	exit();
}
/*
 * Include Library
 */
require_once "include/ezb_settings.php.inc";


$IncludeCountrysettingsOutput = isset($IncludeCountrysettingsOutput) ? $IncludeCountrysettingsOutput: true;

$res = GetEzbSettings(null, null, $country, $lang, $m_s, $clientID, $format, $debug);

if (!$res) {
	if($format=="xml")
	   	echo '<?xml version="1.0" ?><root><!--missing settings--></root>';
	else
		echo "error={\"Response\":{\"version\" : \"0.0\",\"status\":{\"code\" : \"0\",\"message\" : \"Missing Settings\"},\"query\":{\"cc\" : \"$country\",\"lc\" : \"$lang\",\"ms\" : \"$m_s\",\"clientId\" : \"$clientID\",\"format\" : \"$format\",\"callback\" : \"N/A\"}}};";
	exit();
} else {
	$res["smallInterfaceFile"] = "ezinterface_small.swf";
	$res["stdInterfaceFile"] = "ezinterface.swf";

	if($format=="xml") {
		if (($guistyle == "normal") && ($ezbExp == "direct")) {
			$res["$searchXmlQuery"].= "&type=hp";
		}
	}

	/*
	 * Include ezbuy box size calculation
	 */
	include("include/ezbboxsize.php");

	/*
	 * Load CSV libraries
	 * Create logo PHP array
	 */
	include('include/csvload.php');
	$PHPoutput = 1;
	$csv_file = "../../configuration/logos.csv";
	$mycsv = new CSV();
	$mycsv->CSVread($csv_file, ",");
	eval($mycsv->generateLogoArray($PHPoutput));
	$disableLogosLink = "";
	foreach(array_keys($ezb_logos) as $logoID) {
		if (empty($ezb_logos["$logoID"]["page"])) {
			$disableLogosLink.= $logoID.";";
		}
	}
	if ($disableLogosLink) {
		$disableLogosLink = substr($disableLogosLink, 0, -1);
	} else {
		$disableLogosLink = "";
	}

	if ($disableLogosLink != "")
		$res["disableLogosLink"] = $disableLogosLink;

	$result = "";
	if ($format=="xml") {
		$res["boxWidth"] = $boxWidth;
		$res["boxHeight"] = $boxHeight;

		foreach($res as $key =>$value) {
			$value == "0" ? $value = "false": 0;
			$value == "1" ? $value = "true": 0;
			if ($value != "")
				$result = $result."<".$key.">".htmlspecialchars($value)."</".$key.">\n";
			else
				$result = $result."<".$key."/>\n";
		}
		$result = '<?xml version="1.0" encoding="UTF-8" ?><root>'.$result.'</root>';
		if ($IncludeCountrysettingsOutput != false) {
			echo $result;
		}

		if ($debug)
			echo "<pre>".str_replace("<", "&lt;", str_replace(">", "&gt;", $result))."</pre>";
	} else {
		foreach($res as $key =>$value) {
			$value == "0" ? $value = "": 0;
			if ($key != "DynamicJS")
				$result.= "var $key='$value';\n";
		}
		if ($res["DynamicJS"] != "") {
			$result.= "\n".$res["DynamicJS"].";\n";
		}
		echo $result;
		echo $JS_ezbboxsize;
		echo "
			if(window.partnersExcludeIds && window.partnersExcludeIds!=\"\"){
				searchXmlQuery += \"&m_e=\" + window.partnersExcludeIds.replace(/,/g , \";\") ;
				searchXmlQueryExc = \"&m_e=\" + window.partnersExcludeIds.replace(/,/g , \";\") ;
			}

			if(window.partnersRestrictIds && window.partnersRestrictIds!=\"\"){
				searchXmlQuery += \"&m_r=\" + window.partnersRestrictIds.replace(/,/g , \";\") ;
				searchXmlQueryRes = \"&m_r=\" + window.partnersRestrictIds.replace(/,/g , \";\") ;
			}

			if(window.elocatorURL!=\"\"  && window.elocatorURL.indexOf(\"CLIENT_ID=HP_EUROPE\") != -1 && window.PL !=\"\" ) {
				window.elocatorURL += \"&PRODUCT=\" + window.PL;
			}

			";
		/*
			 * Create logo JS array
		 	*/
		$noJSoutput = 0;
		$mycsv->generateLogoArray($noJSoutput);

		$cJSON = "";
		$cJSON .= "function MyCallBack(json){\n";
		$cJSON .= " configJSON = json ;\n";
		$cJSON .= " copyCJSON = json \n";
		$cJSON .= "} ";

		echo $cJSON;

		$cc=$country;
		$lc=$lang;
		$ms=$m_s;
		$clientId="hp.com";

		$format="JSON";
		$callback="MyCallBack";

		$config_xml_file=$res["configXmlFile"];

		include ("GetEzbConfig.php");

		echo "var countrysettingsLoaded=true;";
	}
}
?>