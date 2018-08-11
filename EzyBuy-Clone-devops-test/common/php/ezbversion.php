<?php
/**
 * /ezbuy/common/php/ezbversion.php
 * $Date: 2009/03/24 08:13:39 $
 * $Revision: 1.2 $
 * $Author: ezbuydev $
 * $Id: ezbversion.php,v 1.2 2009/03/24 08:13:39 ezbuydev Exp $
 * $Log: ezbversion.php,v $
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
 * Revision 1.6  2006/07/05 10:11:39  slechner
 * Fix for EZBuy accessibility anchors + ezb implementation code version tracking in Omniture + fix on old implementation code
 *
 * Revision 1.5.16.1  2006/07/05 09:39:40  slechner
 * Fix for EZBuy accessibility anchors + ezb implementation code version tracking in Omniture + fix on old implementation code
 *
 * Revision 1.5  2006/06/01 12:50:13  slechner
 * FIF Add to Basket project live
 *
 * Revision 1.4.70.2  2006/05/30 08:49:55  slechner
 * modifications following Stephane's feedback on first tests
 *
 * Revision 1.4.70.1  2006/05/19 16:00:46  slechner
 * enf of 1st day test on FIF add to basket
 *
 * Revision 1.4  2006/01/13 15:56:42  slechner
 * new examples.php and getezbuycode.php page
 *
 * Revision 1.1.1.1  2005/11/13 20:47:57  slechner
 * initial import
 *
 * $Name: HEAD $
 * $State: Exp $
 *
 * +======================================================================================================+
 * | EZB Version
 * +======================================================================================================+
 * +------------------------------------------------------------------------------------------------------+
 * | Code Structure:
 * | --------------
 * |
 * +------------------------------------------------------------------------------------------------------+
 * | Usage:
 * | ------
 * |
 * +------------------------------------------------------------------------------------------------------+
 * | Glossary:
 * | ---------
 * +------------------------------------------------------------------------------------------------------+
 * | Internals:
 * | ----------
 * | 07/05/2006 : Fix for getting correct language code (2 digits) with old implementation code (3 digits)
 * +------------------------------------------------------------------------------------------+
 * | Debug:
 * | --------
 * |
 * +------------------------------------------------------------------------------------------+
 * | Assumptions:
 * | ------------
 * |
 * +------------------------------------------------------------------------------------------+
 * | JS Context used:
 * | ---------------
 * |
 * +------------------------------------------------------------------------------------------+
 * | JS Context defined:
 * | ------------------
 * |
 * +------------------------------------------------------------------------------------------+
 * | exceptions:
 * | -----------
 * |
 * +==========================================================================================+
 *
 **/

$FIF=isset($_GET["FIF"])?$_GET["FIF"]:""; //FIF parameter to distinguish FIF from HTML version
if (isset($_GET["country"]))
$country=$_GET["country"];	//2-letter ISO country code
if ($FIF == "true" && isset($_GET["lang"]))
$lang=$_GET["lang"];  //2-letter ISO language code
$m_s=(isset($_GET["m_s"]))?$_GET["m_s"]:"MARKETSEGMENT";	//market segment

/*
 * Read version to potentialy refresh cache throughout EZB
 */
$ini_file = "../../releases/loadjs.ini";
$ini_array = parse_ini_file($ini_file, TRUE);
$version = (isset($ini_array["version"]) && $ini_array["version"] != "")?$ini_array["version"]:"1";

$proxyLcID="ezbuy_proxy_".$country."_".$lang."_".$m_s;

	if ($FIF == "true") {

		/*
		 * Avoid caching
		 */
		header("Content-Type: text/xml");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		echo "<root>\n";
		echo "<version>$version</version>\n";
		echo "<proxyLcID>$proxyLcID</proxyLcID>\n";
		echo "</root>\n";
	} else	{
?>
// set Proxy local connection object id, communicated to FIF EZBuy instances in the page
// so that they can connect to the proxy if exists in the page.
var proxyLcID="<?=$proxyLcID?>";
proxyLcID = proxyLcID.replace(/MARKETSEGMENT/g,m_s);
<?
	}
?>