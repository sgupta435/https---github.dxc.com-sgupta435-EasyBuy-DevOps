<?php
/**
 * /ezbuy/common/php/GetEzbConfig.php
 * $Date: 2009/03/24 08:13:39 $
 * $Revision: 1.2 $
 * $Author: ezbuydev $
 * $Id: GetEzbConfig.php,v 1.2 2009/03/24 08:13:39 ezbuydev Exp $
 * $Log: GetEzbConfig.php,v $
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
 * Revision 1.7.58.6  2008/01/25 09:35:19  ezbuy
 * Fixed as part of DCC_REL_1_7
 *
 * Revision 1.7.58.5  2008/01/25 09:32:47  ezbuy
 * Fixed as part of DCC_REL_1_7
 *
 * Revision 1.7.58.3  2008/01/16 09:45:48  ezbuy
 * Fixed as part of DCC_REL_1_4
 *
 * Revision 1.7.58.2  2007/12/19 15:38:12  ezbuy
 * Fixed as part of DCC_REL_1_1
 *
 * Revision 1.7.52.5  2007/11/16 16:29:13  ezbuy
 * Simple XML changes
 *
 * Revision 1.7.52.1  2007/10/16 06:43:13  ezbuy
 * Performance improvement - phase 4 dot 2
 *
 * Revision 1.7.54.3  2007/09/11 13:51:29  ezbuy
 * Performance improvement - phase 4
 *
 * Revision 1.7  2007/02/08 22:55:25  ezbuy
 * new .ini dynamic condition revive from initial release 960 that caused performance issue
 *
 * Revision 1.6.8.1  2007/02/06 17:48:56  ezbuy
 * fix bug tied to introduction of incl attribute in VAT node.
 *
 * Revision 1.6  2007/01/22 12:46:13  ezbuy
 * - currency table update + resellerID for Doubleclick update
 * - new option fullHTMLdirect which allows to configure CSS templates only when
 * we are in a direct mode.
 * - Fix XML formatting issue in GetEzbConfig.php for SureSupply
 *
 * Revision 1.5.8.1  2007/01/22 10:17:44  ezbuy
 * - Fix XML formatting issue in GetEzbConfig.php for SureSupply
 *
 * Revision 1.5  2007/01/04 14:23:41  ezbuy
 * release 943 from operations, and precedent ones
 *
 * Revision 1.4  2006/08/03 14:43:44  slechner
 * - price reporting tool filtering capability
 *
 * Revision 1.3.86.1  2006/08/03 14:31:43  slechner
 * - price reporting tool filtering capability
 *
 * Revision 1.3  2006/03/01 11:12:30  slechner
 * REL_658_B_PROP_600 :
 * - fix encoding issue for SureSupply redirect URLs
 * - Allow for market segment to be upper case! as this was changed in SureSupply
 *
 * Revision 1.2.52.1  2006/03/01 11:01:53  slechner
 * REL_658_B_PROP_600 :
 * - fix encoding issue for SureSupply redirect URLs
 * - Allow for market segment to be upper case! as this was changed in SureSupply
 *
 * Revision 1.2  2005/12/22 13:55:49  slechner
 * REL_602_C and REL_602_E merge into main + cofig update from Prod
 * Changes:
 * - limit quantity input inHTML template to 99
 * - new metrics as per Omniture instructions
 * - new back-end services
 * - new FR shopping basket config
 *
 * Revision 1.1.2.1  2005/12/22 13:32:21  slechner
 * Added EZbuy Back end services GetEzbData, GetEzbConfig, GoEzbPartnr
 *
 *
 * $Name: HEAD $
 * $State: Exp $
 *
 * +======================================================================================================+
 * | EZB Get Config xml service implementation code
 * +======================================================================================================+
 * +------------------------------------------------------------------------------------------------------+
 * | Code Structure:
 * | --------------
 * | Load library
 * | Read Input parameters (query string)
 * | Avoid caching
 * | Convert 3 letters language code to 2 letters language code
 * | Load country exceptions
 * | Load country config
 * | Get config xml path
 * | Get config XML
 * +------------------------------------------------------------------------------------------------------+
 * | Usage:
 * | ------
 * | http://.../GetEzbConfig.php?cc=ch&lc=fr&ms=hho
 * |2-letter ISO country code: country=uk& (used to get right country settings/options/configuration)
 * |2-letter ISO language code: lang=en& (3 letters possible as conversion to two letters done)
 * |market segment: ms=hho
 * +------------------------------------------------------------------------------------------------------+
 * | Glossary:
 * | ---------
 * +------------------------------------------------------------------------------------------------------+
 * | Internals:
 * | ----------
 * |12/19/2005: initial import
 * |08/03/2006: simplified the xml returned for pricing service like SureSupply
 * |            by adding "clientId" param and returning minimum info if not set to hp.com
 * |
 * +------------------------------------------------------------------------------------------+
 * | Debug:
 * | --------
 * | &debug=whatever
 * +------------------------------------------------------------------------------------------+
 * | Assumptions:
 * | ------------
 * |$country needed by include files
 * |$lang needed by include files
 * |xml format returned
 * +------------------------------------------------------------------------------------------+
 * | JS Context used:
 * | ---------------
 * +------------------------------------------------------------------------------------------+
 * | JS Context defined:
 * | ------------------
 * +------------------------------------------------------------------------------------------+
 * | exceptions:
 * | -----------
 * +------------------------------------------------------------------------------------------+
 * | caching:
 * | -----------
 * |Force caching
 * +==========================================================================================+
 *
 **/

/*
 * Include Utils Library
 */
require_once "include/ezb_utils.ProcessParams.php.inc";

/*
 * Include Params Processing Library
 */
require_once "include/ezb_settings.php.inc";
/*
 * Include XML Utils Library
 */
require_once "include/ezb_xml_utils.php.inc";
/*
 * Process parameters
 */
$_req_mandatory_var_names = array("cc","lc","ms","format"); //mandatory parameters
$_req_optional_var_names = array("debug","clientId","callback"); //optional parameters
$param_ok=UtilsProcessParams($_req_mandatory_var_names, $_req_optional_var_names, "debug");

$format=strtolower($format);

/*
 * Avoid caching / treat debug / format
 */
if(!headers_sent()){
	if(!$debug){
		if($format=="xml"){
			header("Content-type: text/xml; charset=utf-8");
		} else {
			header("Content-type: text/javascript; charset=utf-8");
		}
	}else{
			header("Content-type: text/html; charset=utf-8");
	}
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
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
* Re-declare variables needed
*/
$country=$cc;
$lang=$lc;

$setComma = 0;
$setDynComma = 0;

$success=0;
$msg = "";
$returnArray = "";
$returnArray1 = "";
$CntExp = 0;

/*
* Include Exceptions
*/
include("include/country_exceptions.php");

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

if (!$param_ok) {
    if($format=="xml")
    	echo '<?xml version="1.0" ?><ezb><!--missing params--></ezb>';
    else
    	echo "error={\"Response\":{\"version\" : \"0.0\",\"status\":{\"code\" : \"0\",\"message\" : \"Missing Params\"},\"query\":{\"cc\" : \"$cc\",\"lc\" : \"$lc\",\"ms\" : \"$ms\",\"clientId\" : \"$clientId\",\"format\" : \"$format\",\"callback\" : \"$callback\"}}};";
}
else {

	if(!isset($config_xml)){
		$paramCollection = array("configXmlFile" =>array("xml", "-"));
		$confg=GetEzbSettings($paramCollection, null, $cc, $lc, $ms, $clientId, "xml", $debug);
		if($confg==false){
			if($debug){
				echo "error reading country settings";
			}
		}else{
    		$config_xml = $confg["configXmlFile"];
    	}
    }
	$config_xml = file_get_contents("../../$cc/$lc/".$config_xml);
	$config_xml=preg_replace_callback("/\<\!\[CDATA\[(.*)\]\]\>/U",create_function('$matches','return "<![CDATA[". urlencode(str_replace(array("\\\","\"","+"),array("@B@","@Q@","@P@"),$matches[1])) ."]]>";'),$config_xml);

    if($config_xml==FALSE){
    	$config_xml="<root></root>";
    	$success = "0";
        $msg="Error in config XML file";
    }


	if ($clientId!="hp.com"){
        $config_xml = preg_replace(array('/<dynamic[^\^]*dynamic>/'), array(""), $config_xml);
        $config_xml = preg_replace(array('/<buttons[^\^]*buttons>/'), array(""), $config_xml);
        preg_match_all('/<setting func="(currencychar|priceformat|abbrchars|digitgroupingsymbol|decimalsymbol)">[^~]*?<\/setting>/',$config_xml,$matches);
        $all_match="";
        foreach($matches[0] as $val) {
            $all_match .= $val;
        }
        $config_xml = preg_replace(array('/<ctryconfig[^\^]*ctryconfig>/'), array("<ctryconfig>". $all_match . "</ctryconfig>"), $config_xml);
        preg_match_all('/<field func="(vat)"( incl="[01]*"|)>[^\^]*?<\/field>/',$config_xml,$matches);
        $all_match="";
        foreach($matches[0] as $val) {
            $all_match .= $val;
        }
        $config_xml = preg_replace(array('/<text>[^\^]*<\/text>/'), array("<text>". $all_match . "</text>"), $config_xml);
    }

	if ( $format == "xml" ) {
		if(!$debug)
			echo $config_xml;
		else
			echo  "<pre>" . str_replace("<","&lt;",str_replace(">","&gt;",$config_xml)) . "</pre>";
		return;
	}

if($config_xml=="<root></root>")
	$tmp=NULL;
else
$tmp = simplexml_load_string($config_xml);


$lbrace="{";
$rbrace="}";
$version="0.0";
$productDetailsArray= "";
$retailerPresent=0;


//Pre-construct the arrays for which the values are known.

$versionArray=array("version"=> $version);
$statusArray=array("code"=> $success,"message"=> $msg);
$queryArray=array("cc"=>$cc,"lc"=>$lc,"ms"=>$ms,"clientId"=>$clientId,"format"=>$format,"callback"=> $callback);
$products="";

if ($tmp) {
    $products.="\""."results"."\"".":"."{";
    $returnArray = substr($returnArray,0,strlen($returnArray)-1);
}

if ($tmp->dynamic->jscontext) {

    $products.= "\""."context"."\"".":"."[";
    //$CntchAttrExp=count($tmp->dynamic->jscontext->text->field);


	$CntchAttrExp=0;
	if($tmp->dynamic->jscontext->text)
	foreach ($tmp->dynamic->jscontext->text->children() as $a=>$b) {
		$CntchAttrExp = $CntchAttrExp + 1;
	}

    if ($tmp->dynamic->jscontext->text->field[0]) {
        for ($x=0; $x<$CntchAttrExp; $x++) {
            $products.="{";
            $products.="\""."cond"."\""." : "."\"".$tmp->dynamic->jscontext->text->field[$x]["cond"]."\"".",";
            $products.="\""."config"."\"".":"."{";
            $products.="\"".$tmp->dynamic->jscontext->text->field[$x]["func"]."\"".":";
            $products.="\"".trim($tmp->dynamic->jscontext->text->field[$x])."\"";
            $products.="}},";
        }
        $products = substr($products,0,strlen($products)-1);
       //$products.="}";
    }
    $products.="],";
}


if ($tmp->dynamic->xmlfeed[0]) {
    $products.="\""."dynamic"."\"".":"."[";
    $Cntdyn=0;
if($tmp->dynamic->xmlfeed->buttons[0])
	foreach ($tmp->dynamic->xmlfeed->buttons->children() as $a=>$b) {
		 $Cntdyn =  $Cntdyn + 1;
	}
    if ($tmp->dynamic->xmlfeed->buttons) {
        for ($l=0; $l<$Cntdyn; $l++) {
            $tmp->dynamic->xmlfeed->buttons[$l]["id"];
            if (($tmp->dynamic->xmlfeed->buttons[$l]["id"] == "channel") || ($tmp->dynamic->xmlfeed->buttons[$l]["id"] ==  "neutral") || ($tmp->dynamic->xmlfeed->buttons[$l]["id"] == "direct")) {
                $products=dynamicconcat($products,$tmp,$l);
            }
        }
    }

    $products = substr($products,0,strlen($products)-1);
    $products.="],";
}

$resultArray=array("products"=>$products);
$returnArray=$callback."({";

//Mah
$CntCfg=0;
if($tmp->ctryconfig)
foreach ($tmp->ctryconfig->children() as $a=>$b) {
	$CntCfg = $CntCfg + 1;
}
//Mah

if ($tmp->ctryconfig->setting[0]) {
    $productDetailsArray="\""."standard"."\"".":"."{"."\""."config"."\"".":"."{";
    for ($j=0; $j<$CntCfg; $j++) {
        $dblqts15=$tmp->ctryconfig->setting[$j];
        if (!(rtrim(ltrim($dblqts15)) == '')) {
            $dblqts15=str_replace('"','\"',$dblqts15);
            $productDetailsArray.="\"".trim($tmp->ctryconfig->setting[$j]["func"])."\"";
            $productDetailsArray.=":"."\"".trim($dblqts15)."\"".",";
        }
    }
}

$Cntintr=0;
if($tmp->text[0])
foreach( $tmp->text->children() as $a=>$b) {
	$Cntintr = $Cntintr + 1;
}
if ($tmp->text->field) {
    for ($k=0; $k<$Cntintr; $k++) {
        $cdatadblqts=$tmp->text->field[$k];
        if (!(rtrim(ltrim($cdatadblqts)) == '')) {
            $cdatadblqts=str_replace('"','\"',$cdatadblqts);
            $productDetailsArray.="\"".trim($tmp->text->field[$k]["func"])."\"";
            $productDetailsArray.=":\"".trim($cdatadblqts)."\",";
        }
    }
}

//Mah $CntExp=count($tmp->buttons);
$a = 0;
while (true) {
	if ($tmp->buttons[$a] ) {
		$CntExp = $CntExp + 1;
		$a = $a + 1;
	}
	else
		break;
}

if ($tmp->buttons[0]) {
    for ($l=0; $l<$CntExp; $l++) {
        if (($tmp->buttons[$l]->attributes() == "channel") || ($tmp->buttons[$l]->attributes() == "direct") || ($tmp->buttons[$l]->attributes() == "neutral")) {
            $productDetailsArray=concat($productDetailsArray,$tmp,$l);
        }
    }
    $productDetailsArray = substr($productDetailsArray,0,strlen($productDetailsArray)-1);
    $productDetailsArray.="}";
}

$productDetailsArray = substr($productDetailsArray,0,strlen($productDetailsArray)-1);
$productDetailsArray.=$rbrace.$rbrace;

if ($tmp) {
    $productDetailsArray.=$rbrace.$rbrace.$rbrace;
}


$returnArray1.= $products;
$returnArray1.= $productDetailsArray;
$replacement = array('find'=>array(), 'replace'=>array());

if ($replacement['find'] == array()) {
    foreach(array_merge(range(0, 7), array(11), range(14, 31)) as $v) {
        $replacement['find'][] = chr($v);
        $replacement['replace'][] = "\\u00".sprintf("%02x", $v);
    }
    $replacement['find'] = array_merge(array(chr(0x5c), chr(0x2F), chr(0x0d), chr(0x0c), chr(0x0a), chr(0x09), chr(0x08)), $replacement['find']);
    $replacement['replace'] = array_merge(array('\\\\', '\\/', '\r', '\f', '\n', '\t', '\b'), $replacement['replace']);
}

$result_string = str_replace($replacement['find'], $replacement['replace'], $returnArray1).");";
$result_string = str_replace('="','=\\"',$result_string);
//$result_string = str_replace('"<','"<\\',$result_string);
//$result_string = str_replace('<BR>','<\\BR\\>',$result_string);
//$result_string = str_replace('<br>','<\\BR\\>',$result_string);
$result_string = str_replace('\\\\"','\"',$result_string);
$result = strstr($result_string,'\r\n');
if ($result) {
    $success=0;
    $msg="Error in config XML file";
}
else if ($tmp == NULL) {
    $success=0;
    $msg="Error in config XML file";
}
else {
    $success=1;
    $msg="ok";
}
$statusArray=array("code"=> $success,"message"=> $msg);
$resarr=array("Response"=>$versionArray,"status"=>$statusArray,"query"=>$queryArray);

if (is_array($resarr)) {
    foreach($resarr as $key => $value){
        if (is_array($value)) {
            $returnArray.="\"".$key."\"".":"."{";
            $returnArray.=Tocheckarray($value);
            foreach($value as $key => $value1){
                if ($key=="message" || $key == "callback") {
                    $returnArray = substr($returnArray,0,strlen($returnArray)-1);
                    $returnArray.="},";
                }
            }
        } else {
            $returnArray.=Tocheckarray($value);
        }
    }
}

    if (!($tmp)) {
        $returnArray = substr($returnArray,0,strlen($returnArray)-1);
    }

    $resultArray1=$returnArray.$result_string;
    $result_string=$resultArray1;
    echo $result_string;

}

function concat($productDetailsArray,$tmp,$l){
    $productDetailsArray.="\"".$tmp->buttons[$l]["id"]."\""." : "."{";
    $CntchAttrExp=0;
if($tmp->buttons[$l])
	foreach(  $tmp->buttons[$l]->children() as $a=>$b) {
		$CntchAttrExp = $CntchAttrExp + 1;
	}

    if ($tmp->buttons[$l]->btn) {
        for ($x=0; $x<$CntchAttrExp; $x++) {
	if($tmp->buttons[$l]->btn[$x])
            foreach($tmp->buttons[$l]->btn[$x]->children() as $k=>$v){
                if ((rtrim(ltrim($v)))=='') {
                    // Do nothing
                } else if ($k == "label") {
                    $dblqts=$v;
                }


            }
            $dblqts=str_replace('"','\"',$dblqts);
            $productDetailsArray.="\"".$tmp->buttons[$l]->btn[$x]["func"]."\"".":"."{";
            if (trim($dblqts) != "") {
                $productDetailsArray.="\""."label"."\"". " : "  ."\"".$dblqts."\"";
            }
            $setComma = 1;

            if ($tmp->buttons[$l]->btn[$x]->tooltip) {
                foreach($tmp->buttons[$l]->btn[$x]->tooltip as $y=>$e){
                    if ($y=="tooltip") {
                        $productDetailsArray.=","."\""."tooltip"."\"". " : " ."\"".$e."\"";
                    }
                }

                $setComma = 1;
            }


				$y = 0;
			if($tmp->buttons[$l]->btn[$x]->txt[0])
				foreach ($tmp->buttons[$l]->btn[$x]->txt->children() as $a=>$b) {
					  //if (rtrim(ltrim($b)) != '' ){
						    $b=str_replace('"','\"',$b);
							$productDetailsArray.=","."\""."txt_".$y."\""." : "."\"".$b."\"";
							$setComma = 1;
							$y = $y + 1;
						//}

				}

            $Cntlnk=count($tmp->buttons[$l]->btn[$x]->link[0]); //Mah
            if ($Cntlnk>=1) {
                if ($setComma == 1) {
                    $productDetailsArray.=",";
                }
                $productDetailsArray.="\""."link"."\"".":"."{";
                if (trim($tmp->buttons[$l]->btn[$x]->link->label) != "") {
                    $productDetailsArray.="\""."label"."\"". " : " ."\"".$tmp->buttons[$l]->btn[$x]->link->label."\"";
                }
                $productDetailsArray.=","."\""."action"."\"". " : " ."\"".$tmp->buttons[$l]->btn[$x]->link->action."\"";
                $productDetailsArray.="}";

            }
			//Mah
            if ($tmp->buttons[$l]->btn[$x]->action[0]) {
                $productDetailsArray.=","."\""."action"."\"". ":" . "\"".$tmp->buttons[$l]->btn[$x]->action."\"";
            }
            $productDetailsArray.="},";
        }
        $productDetailsArray = substr($productDetailsArray,0,strlen($productDetailsArray)-1);
        $productDetailsArray.="},";
    }
    $productDetailsArray=str_replace("{,","{",$productDetailsArray);
    return $productDetailsArray;
}


function dynamicconcat($products,$tmp,$l)
{
    $CntchAttrExp=0;
if($tmp->dynamic->xmlfeed->buttons[$l])
	foreach ($tmp->dynamic->xmlfeed->buttons[$l]->children() as $a=>$b) {
		$CntchAttrExp = $CntchAttrExp + 1;
	}

    if ($tmp->dynamic->xmlfeed->buttons[$l]->btn) {
        for ($x=0; $x<$CntchAttrExp; $x++) {
            $cntcond=count($tmp->dynamic->xmlfeed->buttons[$l]->btn[$x])/2;
            $products.="{";
            $products.="\""."cond"."\""." : "."\"".$tmp->dynamic->xmlfeed->buttons[$l]->btn[$x]["cond"]."\"".",";
            $products.="\""."config"."\"".":"."{";
            $products.="\"".$tmp->dynamic->xmlfeed->buttons[$l]["id"]."\"". ":" ."{";
            for ($z=0; $z<$cntcond; $z++) {
                foreach($tmp->dynamic->xmlfeed->buttons[$l]->btn[$x]->attributes() as $key=>$value){
                    if ($key == "func") {
			   $products.="\"".$value."\"".":"."{";
                    }
                }
if($tmp->dynamic->xmlfeed->buttons[$l]->btn[$x])
                foreach($tmp->dynamic->xmlfeed->buttons[$l]->btn[$x]->children() as $yek=>$lue){
                    if ((rtrim(ltrim($lue)))=='') {
                        //Do nothing
                    } else if ($yek == "label") {
			    $lue=str_replace('"','\"',$lue);
                        $products.="\""."label"."\"". " : " ."\"".$lue."\"";
                    }
                }

                $dblqts3=str_replace('"','\"',$dblqts3);
                if (!(rtrim(ltrim($dblqts3)) == '')) {
                    $products.="\"".$dblqts3."\"";
		      $setDynComma = 1;
                }


				$y = 0;
			if($tmp->dynamic->xmlfeed->buttons[$l]->btn[$x]->txt)
				foreach ($tmp->dynamic->xmlfeed->buttons[$l]->btn[$x]->txt->children() as $a=>$b) {
					  //if (rtrim(ltrim($b)) != '' ){
						    $b=str_replace('"','\"',$b);
							$products.=","."\""."txt_".$y."\""." : "."\"".$b."\"";
							$setDynComma = 1;
							$y = $y + 1;
						//}
				}

                $Cntlnk=count($tmp->dynamic->xmlfeed->buttons[$l]->btn[$x]->link[0]); //Mah
                if ($Cntlnk>=1) {
                    if ($setDynComma == 1) {
                        $products.=",";
                    }


                    $products.="\""."link"."\"".":"."{";
                    $products.="\""."label"."\"". " : " ."\"".$tmp->dynamic->xmlfeed->buttons[$l]->btn[$x]->link->label."\"";
                    $products.=","."\""."action"."\"". " : " ."\"". $tmp->dynamic->xmlfeed->buttons[$l]->btn[$x]->link->action."\"";
                    $products.="}";
                }
				//Mah
                if ($tmp->dynamic->xmlfeed->buttons[$l]->btn[$x]->action[0]) {
                    $products.=","."\""."action"."\"".":". "\"".$tmp->dynamic->xmlfeed->buttons[$l]->btn[$x]->action."\"";
                }

                $products.="}";
            }
            $products.="}}},";

        }
        $products.=",";

    }
    $products = substr($products,0,strlen($products)-1);
    return $products;
}

?>







