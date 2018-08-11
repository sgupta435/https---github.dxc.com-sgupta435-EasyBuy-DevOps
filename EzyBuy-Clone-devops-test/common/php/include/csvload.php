<?php
/**
 * /ezbuy/common/php/include/csvload.php
 * $Date: 2009/03/24 08:13:39 $
 * $Revision: 1.2 $
 * $Author: ezbuydev $
 * $Id: csvload.php,v 1.2 2009/03/24 08:13:39 ezbuydev Exp $
 * $Log: csvload.php,v $
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
 * Revision 1.5.8.1  2008/01/25 09:32:49  ezbuy
 * Fixed as part of DCC_REL_1_7
 *
 * Revision 1.5  2007/07/12 16:24:17  ezbuy
 * update GDIC CVS with EZB Production. Contains preparation for Phase 3.2 and 3.4 with callbacks
 *
 * Revision 1.4  2007/03/31 00:28:31  ezbuy
 * new html directory containing images, logos and css for operations.
 *
 * Revision 1.3.16.1  2007/03/31 00:15:23  ezbuy
 * new html directory containing images, logos and css for operations.
 *
 * Revision 1.3  2007/02/11 22:17:06  ezbuy
 * introduced new config files for Doubleclick (Currencies, partrners) and Omniture (partners)
 *
 * Revision 1.2.16.1  2007/02/11 22:10:47  ezbuy
 * introduced new config files for Doubleclick (Currencies, partrners) and Omniture (partners)
 *
 * Revision 1.2  2007/02/02 16:13:19  ezbuy
 * New logo process update (Flash)
 *
 * Revision 1.1.2.5  2007/01/17 15:25:19  ezbuy
 * "Central logo configuration" files documented and finalized
 * with logo process update in Flash
 *
 * Revision 1.1.2.4  2007/01/05 17:22:51  ezbuy
 * - new logo GIFs added
 * - new intel urls added for cz, hu and pl
 * - new logos integrated in configuration files
 * - empty lines don't cause any trouble any more in CSV files
 * - ' or " are now correctly rendered by javascript output arrays.
 *
 * Revision 1.1.2.3  2007/01/03 15:14:05  ezbuy
 * changes to fit with documentation
 *
 * Revision 1.1.2.2  2006/11/30 14:13:08  ezbuy
 * Changes in central logo configuration according to Stephane's feedback
 *
 * Revision 1.1.2.1  2006/11/29 15:28:28  ezbuy
 * - MP2B compliant partners externalisation done
 * - Central logo information externalisation done
 * - CSV library with reading and output functions implemented
 *
 * Revision 1.1.2.1  2006/11/28 17:08:29  ezbuy
 * development of logo central configuration
 *
 * Revision 1.1.1.1  2005/11/13 20:47:59  slechner
 * initial import
 *
 * $Name: HEAD $
 * $State: Exp $
 *
 * +======================================================================================================+
 * | EZB CSV file like - information load
 * +======================================================================================================+
 * +------------------------------------------------------------------------------------------------------+
 * | Code Structure:
 * | --------------
 * | - CSVread allow to read a CSV file and put the content in the following structure :
 * | array of array that can be called like : $this->CSVarray[$i][$j]
 * | where $i equal to line number in CSV file
 * | and $j equal to field number on the line (0<=$j<count(field))
 * | CSV file reading is generic
 * | - Output generation could be different according to the needs :
 * | EX: generateLogoArray(), generatePhpArray()
 * +------------------------------------------------------------------------------------------------------+
 * | Usage:
 * | ------
 * | $PHPoutput=1; ("1" for PHP Output, "0" for Js Output)
 * | $csv_file = "CSV file path";
 * | $mycsv = new CSV();
 * | $mycsv->CSVread($csv_file,"CSV file separator");
 * | $mycsv->generateLogoArray($PHPoutput); // output function
 * +------------------------------------------------------------------------------------------------------+
 * | Glossary:
 * | ---------
 * +------------------------------------------------------------------------------------------------------+
 * | Internals:
 * | ----------
 * | url_exists allow to check whether the logo GIF file is available in directory
 * | Note: if Logo GIF file is not available in directory, it is removed from the generated structure
 * | if it was not removed, CSS libraries would create a logo area with a text equal to text field value
 * | instead of displaying an image based on GIF file or would display a cross indicating a missing image
 * | depending on browser version.
 * +------------------------------------------------------------------------------------------+
 * | Debug:
 * | --------
 * |
 * +------------------------------------------------------------------------------------------+
 * | Assumptions:
 * | ------------
 * | Lines beginning with "#" in CSV file are considered as comments and are thus discarded
 * | Blank lines are also discarded
 * +------------------------------------------------------------------------------------------+
 * | JS Context used:
 * | ---------------
 * |
 * +------------------------------------------------------------------------------------------+
 * | JS Context defined:
 * | ------------------
 * | generateLogoArray(0) generate a JS array with the following format :
 * | var ezb_logos={
 * | 	id1:{src:'src1',text:'text1',page:'page1'},
 * | 	id2:{src:'src2',text:'text2',page:'page2'},
 * | };
 * | " and ' must be escaped by code (\" and \') so that ezb_logos JS array could be correctly interpreted
 * +------------------------------------------------------------------------------------------+
 * | PHP Context defined:
 * | ------------------
 * | generatePhpArray() generate a PHP array
 * | that needs to be evaluated in PHP context afterwards with the following format :
 * | $urls=array("id1"=>"url1","id2"=>"url2");
 * |
 * | generateLogoArray(1) generate a PHP array with the following format :
 * | $ezb_logos=array(
 * | 	"id1" => array("src"=>"src1","text"=>"text1","page"=>"page1"},
 * | 	"id2" => array("src"=>"src2","text"=>"text2","page"=>"page2"},
 * | );
 * +------------------------------------------------------------------------------------------+
 * | exceptions:
 * | -----------
 * |
 * +==========================================================================================+
 *
 **/

define("MAX_LINE_SIZE_CHARS","1000");

class CSV {
	//call: $this->CSVarray[$i] with $i equal to line number,
	//$this->CSVarray[$i] returns an array of element separated by delimiter for the line $i
	function CSV() {}

	function CSVread ($myCsvFile,$myDelimiter) {
		$handle = fopen($myCsvFile, "r");
		$i=0;

		while (($data = fgetcsv($handle, MAX_LINE_SIZE_CHARS, $myDelimiter)) !== FALSE) {
    		$this->CSVarray[$i] = $data;
			$i++;
		}
		fclose($handle);
	}

	function generateLogoArray($PHPoutput) {

		if ($PHPoutput) {
			$PHP_line = '$ezb_logos=array(';
		} else {
			$JS_line = "var ezb_logos={\n";
		}

		for ($i=0; $i < count($this->CSVarray); $i++) {
			$data = $this->CSVarray[$i];
			// first character of first element
			if (isset($data[0][0]) && ($data[0][0] != "#")) {
					for ($j=0; $j < 3; $j++) {
				   		$data[$j] = ereg_replace("\"","&#34;", $data[$j]);
				   		$data[$j] = ereg_replace("\'","&#39;", $data[$j]);
				   	}
				   $logo_path = "../../html/img/logos/$data[1]";
				   if (file_exists($logo_path)) {
						if ($PHPoutput) {
							$PHP_line .= "\"$data[0]\" => array(\"src\" => \"$data[1]\", \"text\" => \"$data[2]\", \"page\" => \"$data[3]\"),";
						} else {
							list($_left, $_right) = explode(".", $data[1]);
							$JS_line .= "$data[0]:{s:'".$_left.".jp'+'g',text:'$data[2]',page:'$data[3]'},\n";
						}
					 }
			}
		}
		if ($PHPoutput) {
			$PHP_line = substr($PHP_line,0,-1).");\n";
			return $PHP_line;
		} else {
			$JS_line = substr($JS_line,0,-2)."\n};\n";
			echo $JS_line;
		}
	}

	function generateJSArraySimple($name,$string) {

		$JS_line = "var $name={\n";

		for ($i=0; $i < count($this->CSVarray); $i++) {
			$data = $this->CSVarray[$i];
			// first character of first element
			if (isset($data[0][0]) && ($data[0][0] != "#")) {
				if (isset($data[1][0]) && ($data[1][0] != "#")) {
					if($string)
						$JS_line .= "\"$data[0]\":\"$data[1]\",\n";
					else
						$JS_line .= "\"$data[0]\":$data[1],\n";
				}else{
					$line = explode("|", $data[0]);
					$pos = strpos($line[0], "-");
					if ($pos === false){
						$first=$line[0];
						$second=$line[1];
					}else{
						$first=$line[1];
						$second=$line[0];
					}
					if($string)
						$JS_line .= "\"$first\":\"$second\",\n";
					else
						$JS_line .= "\"$first\":$second,\n";
				}
			}
		}
		$JS_line = substr($JS_line,0,-2)."\n};\n";
		echo $JS_line;
	}

	function generateStringSimple($name) {

			$JS_line = "var $name=\"";

			for ($i=0; $i < count($this->CSVarray); $i++) {
				$data = $this->CSVarray[$i];
				// first character of first element
				if (isset($data[0][0]) && ($data[0][0] != "#")) {
					$JS_line .= $data[0] . "|";
				}
			}
			echo $JS_line . "\";\n";
	}

	function generatePhpArray() {

			$PHP_line = '$urls=array(';
			for ($i=0; $i < count($this->CSVarray); $i++) {
				$data = $this->CSVarray[$i];
				// first character of first element
				if (isset($data[0][0]) && ($data[0][0] != "#")) {
						   $PHP_line .= "\"$data[0]\"=>\"$data[1]\",";
				}
			}
			$PHP_line = substr($PHP_line,0,-1).");\n";
			return $PHP_line;
	}
}

?>
