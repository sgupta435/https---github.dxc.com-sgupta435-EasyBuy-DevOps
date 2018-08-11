<?php
/**
 * /ezbuy/hpsb/common/basketmanager.php
 * $Date: 2009/03/24 08:13:39 $
 * $Revision: 1.2 $
 * $Author: ezbuydev $
 * $Id: basketmanager.php,v 1.2 2009/03/24 08:13:39 ezbuydev Exp $
 * $Log: basketmanager.php,v $
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
 * Revision 1.4  2007/01/09 14:30:25  ezbuy
 * release 946 with
 * - Change hotline price/min for SB DE SMB/HHO from 12ct/min to 14ct/min
 * - updated content from operations on precedent releases (configuration)
 *
 * $Name: HEAD $
 * $State: Exp $
 *
 * +======================================================================================================+
 * | EZB Shopping basket configuration main
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
 * |
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
/*
 * Avoid caching
 */
header("Content-Type: text/javascript");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

print "var the_cookie=\"";
while (list ($key, $val) = each ($_COOKIE)) {

    print "$key=$val; ";
}
print "\";\n";
include ("basketmanager.js");
?>
