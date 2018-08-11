<?php
/**
 * /ezbuy/common/php/GetEzbData.php
 * $Date: 2009/03/24 08:13:39 $
 * $Revision: 1.2 $
 * $Author: ezbuydev $
 * $Id: GetEzbData.php,v 1.2 2009/03/24 08:13:39 ezbuydev Exp $
 * $Log: GetEzbData.php,v $
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
 * Revision 1.8.8.7  2008/01/25 09:35:20  ezbuy
 * Fixed as part of DCC_REL_1_7
 *
 * Revision 1.8.8.6  2008/01/25 09:32:47  ezbuy
 * Fixed as part of DCC_REL_1_7
 *
 * Revision 1.8.8.2  2007/12/19 15:38:12  ezbuy
 * Fixed as part of DCC_REL_1_1
 *
 * Revision 1.8.2.4  2007/11/20 11:19:35  ezbuy
 * Simple XML changes
 *
 * Revision 1.8  2007/07/12 16:24:16  ezbuy
 * update GDIC CVS with EZB Production. Contains preparation for Phase 3.2 and 3.4 with callbacks
 *
 * Revision 1.7  2007/04/28 19:54:24  ezbuy
 * fixed Exclusion bug
 * updated proxy class
 * included JS format for GetEzbdata
 *
 * Revision 1.5.48.2  2007/04/28 19:32:46  ezbuy
 * fixed Exclusion bug
 * updated proxy class
 * included JS format for GetEzbdata
 *
 * Revision 1.5.48.1  2007/04/25 12:10:13  ezbuy
 * fixed Exclusion bug
 * updated proxy class
 * included JS format for GetEzbdata
 *
 * Revision 1.5  2007/01/04 14:23:41  ezbuy
 * release 943 from operations, and precedent ones
 *
 * Revision 1.4  2006/03/30 15:36:03  slechner
 * REL_675_E2_PROD_676 Enhancements in:
 * - DoubleClick/Omniture proxy tagging to avoid multiple submission using cookies
 * - Shopping basket display in case segment page is undefined
 * - GetEzbdata back-end service improved proxy management
 * - report.php new features to check exclusion
 * - new ezcomploader from ClientID recognition bug
 *
 * Revision 1.3.24.1  2006/03/30 15:31:40  slechner
 * Enhancements in:
 * - DoubleClick/Omniture proxy tagging to avoid multiple submission using cookies
 * - Shopping basket display in case segment page is undefined
 * - GetEzbdata back-end service improved proxy management
 * - report.php new features to check exclusion
 * - new ezcomploader from ClientID recognition bug
 *
 * Revision 1.3  2006/03/01 11:12:31  slechner
 * REL_658_B_PROP_600 :
 * - fix encoding issue for SureSupply redirect URLs
 * - Allow for market segment to be upper case! as this was changed in SureSupply
 *
 * Revision 1.2.52.1  2006/03/01 11:01:54  slechner
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
 * Revision 1.1.2.1  2005/12/22 13:32:22  slechner
 * Added EZbuy Back end services GetEzbData, GetEzbConfig, GoEzbPartnr
 *
 *
 * $Name: HEAD $
 * $State: Exp $
 *
 * +======================================================================================================+
 * | EZB Get Price data service implementation code
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
 * | Get xml feed
 * | Apply rules
 * | Build Price Indication
 * +------------------------------------------------------------------------------------------------------+
 * | Usage:
 * | ------
 * | http://.../GetEzbData.php?cc=ch&lc=fr&ms=hho&clientId=SureSupply&format=xml&partnr=C5024A;C4804A
 * |2-letter ISO country code: country=uk& (used to get right country settings/options/configuration)
 * |2-letter ISO language code: lang=en& (3 letters possible as conversion to two letters done)
 * |product numbers: partnr=PF997AA;...&
 * |format: format=xml&
 * |clientId: clientId=psc (s_prop4)
 * +------------------------------------------------------------------------------------------------------+
 * | Glossary:
 * | ---------
 * +------------------------------------------------------------------------------------------------------+
 * | Internals:
 * | ----------
 * |04/28/2006: introduced js format & elegant dump
 * |04/23/2007: added EPP support & use of elegant debug dump
 * |12/19/2005: initial import
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
 * |avoid caching
 * +==========================================================================================+
 *
 **/
require_once('include/CompressionAndCaching.class.php.inc');
$cache = new Cache_And_Compression();
$cache = new Cache_And_Compression(array('interval'=>"600",'maxAge'=>"0",'expires'=>"0"));

$cache->Start();

/*
 * Include Utils Library
 */
require_once("include/ezb_utils.ProcessParams.php.inc");

/*
 * Include XML Utils Library
 */
require_once ("include/ezb_xml_utils.php.inc");
/*
 * Include Settings Utils Library
 */
require_once ("include/ezb_settings.php.inc");
//require_once ("GetEzbConfig.php");

/*
 * Process parameters
 */
$_req_mandatory_var_names = array("cc","lc","ms","partnr","clientId"); //mandatory parameters
$_req_optional_var_names = array("format","filter","type","m_r","m_e","version","debug","Eppid","p_format","callback","JSparam","local_file","browse"); //optional parameters
$param_ok=UtilsProcessParams($_req_mandatory_var_names, $_req_optional_var_names, "debug");

$format=strtolower($format);
if($format =="")/*default*/
	$format="xml";

/*
 * Avoid caching / treat debug / format
 */
if(!headers_sent()){
	if(!$debug){
		if($format=="xml"){
			header("Content-type: text/xml; charset=utf-8");
		} else if ($format == "js_s" || $format == "json") {
			header("Content-type: text/javascript; charset=utf-8");
		}
	}else{
			header("Content-type: text/html; charset=utf-8");
	}

//	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
//	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
//	header("Cache-Control: no-store, no-cache, must-revalidate");
//	header("Cache-Control: post-check=0, pre-check=0", false);
//	header("Pragma: no-cache");
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
$ezbBothsegment = '';
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
	if($format=="json"){
		echo "$callback({\"Response\":{\"version\" : \"0.0\",\"status\":{\"code\" : \"0\",\"message\" : \"Missing Params\"},\"query\":{\"cc\" : \"$cc\",\"lc\" : \"$lc\",\"ms\" : \"$ms\",\"clientId\" : \"$clientId\",\"format\" : \"$format\",\"callback\" : \"$callback\"}}});";
	}else{
		if($format=="xml"){
			echo "<?xml version=\"1.0\" ?><ezb><!--missing params--></ezb>";
		}else{
			echo "error={\"Response\":{\"version\" : \"0.0\",\"status\":{\"code\" : \"0\",\"message\" : \"Missing Params\"},\"query\":{\"cc\" : \"$cc\",\"lc\" : \"$lc\",\"ms\" : \"$ms\",\"clientId\" : \"$clientId\",\"format\" : \"$format\",\"callback\" : \"$callback\"}}};";
		}
	}
}
else
{
	if($ms !='all')
	{
	
	$partnr=str_replace(" ","",$partnr);
	$partnr=str_replace("%23","#",$partnr);
	
	$config=GetEzbSettings(null, $JSparam, $cc, $lc, $ms, $clientId, "xml", $debug);
	$xml=$config;
  
  
	if(!$config)
  {
		if($debug)
			echo "Issue getting settings";
		if($format=="json"){
			echo "$callback({\"Response\":{\"version\" : \"0.0\",\"status\":{\"code\" : \"0\",\"message\" : \"Settings Error\"},\"query\":{\"cc\" : \"$cc\",\"lc\" : \"$lc\",\"ms\" : \"$ms\",\"clientId\" : \"$clientId\",\"format\" : \"$format\",\"callback\" : \"$callback\"}}});";
		}else{
			if($format=="xml"){
				echo "<?xml version=\"1.0\" ?><ezb><!--settings error--></ezb>";
			}else{
				echo "error={\"Response\":{\"version\" : \"0.0\",\"status\":{\"code\" : \"0\",\"message\" : \"Settings Error\"},\"query\":{\"cc\" : \"$cc\",\"lc\" : \"$lc\",\"ms\" : \"$ms\",\"clientId\" : \"$clientId\",\"format\" : \"$format\",\"callback\" : \"$callback\"}}};";
			}
		}
		exit();
	}

	if($debug){
		echo "Config Object:<BR>";
		echo "--------------<BR>";
		elegant_dump($config);
		echo "<BR>
      ";
      }
      //Added by Nithiyanandhan on 26-Oct-2012 - Start - For DisablePNs fucntionality for Region/Country level as well as Product Level(PL)
      $temppartnr =explode(";",$partnr);
      $tempdisablePNskey = $xml["disablePNs"];
      $piece = explode(";", $tempdisablePNskey);
      //Here set the partner value as null
      $partnr ="";

      $new_array = array_diff($temppartnr,$piece);
      foreach($new_array as $k =>$v){
      if($v!="")
      {
      if($partnr=="")
      {
        $partnr =$v.";";
      }
      else
      {
      $partnr= $partnr.$v.";";
      }
      }
      }
      if($partnr=="")//If partner is null then set the disableEzbuy as true to pass the empty xml to the requested page.
      {
       $xml["options"] = "disableEZBuy";
      }
      //End by Nithiyanandhan 26-Oct-2012
      
      if(!stristr($xml["options"],"disableEZBuy"))
      {
      if($Eppid)
      {
      $partnr = addEppid($partnr,$Eppid);
      }

      //Construct the reseller processing values
      if (!isset($m_r))
      {
      $m_r=$xml["partnersRestrictIds"];
      $m_r=str_replace(",",";",$m_r);
      }
      if (!isset($m_e))
      {
      $m_e=$xml["partnersExcludeIds"];
      $m_e=str_replace(",",";",$m_e);
      }
      if (!isset($p_format))
      {
      if($xml["priceDecimal"] || stristr($xml["options"],"priceDecimal") )
      $p_format = "d";
      else
      $p_format = "i";
      }
		$partnr=str_replace("%23","#",$partnr);

      if($local_file && $local_file!="" && file_exists($local_file))
                {
                  $ezbxmlo=file_get_contents($local_file);
                }else{
                $ezbxmlo=get_ezbxmlfeed($xml,$partnr,$filter,$type,$m_r,$m_e,$p_format);
                }

                $ezbxmlo=preg_replace_callback("/\<\!\[CDATA\[(.*)\]\]\>/U",create_function('$matches','if(substr($matches[1],0,4)!="http") return "<![CDATA[". str_replace("&amp;","&",htmlentities ($matches[1], ENT_QUOTES,"UTF-8")) ."]]>";else return $matches[1];'),$ezbxmlo);

          

                  $ezbsimple = simplexml_load_string($ezbxmlo);
                  $ezbsimple["s"]="kelkoo.hp.".$clientId.".".$format.".".$country.".".$lang.".".$ms;
                  $ezbsimple["f"].=".1.2";

                  if($debug){
                  echo "Feed Object:<BR>";
			            echo "--------------<BR>";
                  
			            elegant_data($ezbsimple);
			            echo "<HR>
                    ";
            }
         //}



        if(!$Eppid)
        {
              $ezbsimple=options_exclusions_ezbxmlfeed($ezbsimple,$xml,$cc,$lc,$ms,$clientId,$format,$version);
              $stringReturn = $ezbsimple->asXML();
              $stringReturn = preg_replace(array('/>[\s]+</','/<r[^<]*id="del".*?\/r>/'),array('><',''),$stringReturn);
			        $ezbsimple = simplexml_load_string($stringReturn);
			      if($debug)
            {
				      echo "Feed Object with exclusions processed:<BR>";
				      echo "--------------<BR>";
				      elegant_data($ezbsimple);
				      echo "<HR>";
			      }
		    }
		($clientId=="SureSupply")?$pi_browse=1:$pi_browse=$browse;
		$ezbsimple=build_ezbxmlfeed_priceindication($ezbsimple,$xml,$cc,$lc,$ms,$clientId,$p_format,$version,$pi_browse);
		if($debug){
			echo "Feed Object with Price indication:<BR>";
			echo "--------------<BR>";
			elegant_data($ezbsimple);
			echo "<HR>";
		}

		if($Eppid){
			$ezbsimple=private_pricing_ezbxmlfeed($ezbsimple,$xml,$cc,$lc,$ms,$clientId,$format,$version,$Eppid);
			$stringReturn = $ezbsimple->asXML() ;
			$stringReturn = preg_replace(array('/>[\s]+</','/<r[^<]*id="del".*?\/r>/'),array('><',''),$stringReturn);
        $ezbsimple = simplexml_load_string($stringReturn);
        

        if($debug){
        echo " New Feed Object with EPP Price indication:<BR>";
				echo "--------------<BR>";
				elegant_data($ezbsimple);
				echo "<HR>
          ";
          }
          }
          $ezbsimple=build_ezbxmlfeed_fixDummy($ezbsimple,$cc,$lc,$ms,$clientId);
          if($browse!=1 || (($clientId=="SureSupply") && $filter != "price"))
		  {

			$ezbsimple=build_ezbxmlfeed_urls($ezbsimple,$cc,$lc,$ms,$clientId);
      
			if($debug)
			{
				echo "Feed Object with URls rebuilt   :<BR>";
				echo "--------------<BR>";
				elegant_data($ezbsimple);
				echo "<HR>";
			}
		}

		if(($clientId!="SureSupply") && !$Eppid){
			$ezbsimple=options_disable_ezbxmlfeed($ezbsimple,$xml,$cc,$lc,$ms,$clientId,$format,$version);
			if($browse!=1){
				$stringReturn = $ezbsimple->asXML() ;
				$stringReturn = preg_replace(array('/>[\s]+</','/<p[^<]*id="del".*?\/p>/','/<p[^<]*id="del".*?\/>/'),array('><','',''),$stringReturn);
				$ezbsimple = simplexml_load_string($stringReturn);
			}
			if($debug){
				echo "Feed Object with disable options<BR>";
				echo "--------------<BR>";
				elegant_data($ezbsimple);
				echo "<HR>";
			}


			$ezbsimple=options_hide_ezbxmlfeed($ezbsimple,$xml,$cc,$lc,$ms,$clientId,$format,$version);
			if($debug){
				echo "Feed Object with Hide options:<BR>";
				echo "--------------<BR>";
				elegant_data($ezbsimple);
				echo "<HR>
          ";
          }

          }
          if($browse!=1 || $debug){ // send to Omniture if not coming from EZB HTML implementation code or if debug
          sendOmniture($xml,$ezbsimple,$partnr,$cc,$lc,$ms,$partnr,$clientId,$debug);
          }

          //We shouldn't display any prices (like list price, stock price etc.,) in the pn node of XML.
          if ($clientId != "Report") {
          unsetPrices($ezbsimple,$browse);


          }
		  
          if(is_object($ezbsimple)){
          $ezbs = $ezbsimple->asXML();
		 
          }
          else{
          //echo"The result is" . $ezbsimple["s"];

          $ezbs ="\n"."<ezb f=\"".$ezbsimple["f"]."\" s=\"".$ezbsimple["s"]."\"> \n </ezb>";
		   
		  
           }

          }else{
          $ezbs='<?xml version="1.0" encoding="utf-8"?><ezb f="1.0.disable" s="kelkoo"></ezb>';
          }


          if($format=="xml"){

          if(!$debug)
		  {
            echo $ezbs;
		   }
          else
		  {
          echo  "<pre>" . str_replace("old_pr=","<font color=\"blue\">old_pr=</font>",str_replace("hi=","<font color=\"red\">hi=</font>",str_replace("<","&lt;",str_replace(">","&gt;",$ezbs)))) . "</pre>";
			}
			
			
	}
	else
	if($format=="js_s"){
		$pieces = explode("\n", $ezbs);
		$ezbs_js="";
		for($line = 0;$line<(count($pieces));$line++){
			$char = "'";
			$string = preg_replace("/'/", "\'", $pieces[$line]);
			if($line == 0){
				$ezbs_js=  "var ezbxml = '<?xml version=\"1.0\" ?>"."'\n";
			}else{
				if (trim($string) != "")
					$ezbs_js=$ezbs_js .  "ezbxml += '".$string."'\n";

			}
		}
		$ezbs_js=str_replace("<![CDATA[","",$ezbs_js);//buy direct from hp]]>
		$ezbs_js=str_replace("]]>","",$ezbs_js);
		$ezbs_js=str_replace("</r>","	</r>",$ezbs_js);
		$ezbs_js=str_replace("</p>","	</p>",$ezbs_js);

        if(!$debug){
        echo $ezbs_js;
        }else
        echo "<pre>" .str_replace("<","&lt;",str_replace(">","&gt;",$ezbs_js)) . "</pre>";
        }

        if ($format == "json" ) {

        

        $jsonezbxmlo=JSON_ezbxmlfeed($ezbsimple,$cc,$lc,$ms,$clientId,$format,$partnr,$xml,$callback);

        if($debug) {
        echo "<BR><BR> JSON Object:<BR>--------------<BR>";
		}
		echo $jsonezbxmlo;
	}

}
else
{

//Nithiyanandhan display both market segment code - start here

	$marketsegment = array("smb", "hho");
	$arrlength = count($marketsegment);
	
	for($x = 0; $x < $arrlength; $x++) 
	{
	  $ms = strtolower($marketsegment[$x]);
	  $partnr=str_replace(" ","",$partnr);
	  $partnr=str_replace("%23","#",$partnr);
	
	$config=GetEzbSettings(null, $JSparam, $cc, $lc, $ms, $clientId, "xml", $debug);
	$xml=$config;
  	
  
if(!$config)
  {
		if($debug)
			echo "Issue getting settings";
		if($format=="json"){
			echo "$callback({\"Response\":{\"version\" : \"0.0\",\"status\":{\"code\" : \"0\",\"message\" : \"Settings Error\"},\"query\":{\"cc\" : \"$cc\",\"lc\" : \"$lc\",\"ms\" : \"$ms\",\"clientId\" : \"$clientId\",\"format\" : \"$format\",\"callback\" : \"$callback\"}}});";
		}else{
			if($format=="xml"){
				echo "<?xml version=\"1.0\" ?><ezb><!--settings error--></ezb>";
			}else{
				echo "error={\"Response\":{\"version\" : \"0.0\",\"status\":{\"code\" : \"0\",\"message\" : \"Settings Error\"},\"query\":{\"cc\" : \"$cc\",\"lc\" : \"$lc\",\"ms\" : \"$ms\",\"clientId\" : \"$clientId\",\"format\" : \"$format\",\"callback\" : \"$callback\"}}};";
			}
		}
		exit();
	}

	if($debug){
		echo "Config Object:<BR>";
		echo "--------------<BR>";
		elegant_dump($config);
		echo "<BR>
      ";
      }
      //Added by Nithiyanandhan on 26-Oct-2012 - Start - For DisablePNs fucntionality for Region/Country level as well as Product Level(PL)
      $temppartnr =explode(";",$partnr);
      $tempdisablePNskey = $xml["disablePNs"];
      $piece = explode(";", $tempdisablePNskey);
      //Here set the partner value as null
      $partnr ="";

      $new_array = array_diff($temppartnr,$piece);
      foreach($new_array as $k =>$v){
      if($v!="")
      {
      if($partnr=="")
      {
        $partnr =$v.";";
      }
      else
      {
      $partnr= $partnr.$v.";";
      }
      }
      }
      if($partnr=="")//If partner is null then set the disableEzbuy as true to pass the empty xml to the requested page.
      {
       $xml["options"] = "disableEZBuy";
      }
      //End by Nithiyanandhan 26-Oct-2012
      
      if(!stristr($xml["options"],"disableEZBuy"))
      {
      if($Eppid)
      {
      $partnr = addEppid($partnr,$Eppid);
      }

      //Construct the reseller processing values
      if (!isset($m_r))
      {
      $m_r=$xml["partnersRestrictIds"];
      $m_r=str_replace(",",";",$m_r);
      }
      if (!isset($m_e))
      {
      $m_e=$xml["partnersExcludeIds"];
      $m_e=str_replace(",",";",$m_e);
      }
      if (!isset($p_format))
      {
      if($xml["priceDecimal"] || stristr($xml["options"],"priceDecimal") )
      $p_format = "d";
      else
      $p_format = "i";
      }
		$partnr=str_replace("%23","#",$partnr);

      if($local_file && $local_file!="" && file_exists($local_file))
                {
                  $ezbxmlo=file_get_contents($local_file);
                }else{
                $ezbxmlo=get_ezbxmlfeed($xml,$partnr,$filter,$type,$m_r,$m_e,$p_format);
                }

                $ezbxmlo=preg_replace_callback("/\<\!\[CDATA\[(.*)\]\]\>/U",create_function('$matches','if(substr($matches[1],0,4)!="http") return "<![CDATA[". str_replace("&amp;","&",htmlentities ($matches[1], ENT_QUOTES,"UTF-8")) ."]]>";else return $matches[1];'),$ezbxmlo);

          

                  $ezbsimple = simplexml_load_string($ezbxmlo);
                  $ezbsimple["s"]="kelkoo.hp.".$clientId.".".$format.".".$country.".".$lang.".".$ms;
                  $ezbsimple["f"].=".1.2";

                  if($debug){
                  echo "Feed Object:<BR>";
			            echo "--------------<BR>";
                  
			            elegant_data($ezbsimple);
			            echo "<HR>
                    ";
            }
         //}



        if(!$Eppid)
        {
              $ezbsimple=options_exclusions_ezbxmlfeed($ezbsimple,$xml,$cc,$lc,$ms,$clientId,$format,$version);
              $stringReturn = $ezbsimple->asXML();
              $stringReturn = preg_replace(array('/>[\s]+</','/<r[^<]*id="del".*?\/r>/'),array('><',''),$stringReturn);
			        $ezbsimple = simplexml_load_string($stringReturn);
			      if($debug)
            {
				      echo "Feed Object with exclusions processed:<BR>";
				      echo "--------------<BR>";
				      elegant_data($ezbsimple);
				      echo "<HR>";
			      }
		    }
		($clientId=="SureSupply")?$pi_browse=1:$pi_browse=$browse;
		$ezbsimple=build_ezbxmlfeed_priceindication($ezbsimple,$xml,$cc,$lc,$ms,$clientId,$p_format,$version,$pi_browse);
		if($debug){
			echo "Feed Object with Price indication:<BR>";
			echo "--------------<BR>";
			elegant_data($ezbsimple);
			echo "<HR>";
		}

		if($Eppid){
			$ezbsimple=private_pricing_ezbxmlfeed($ezbsimple,$xml,$cc,$lc,$ms,$clientId,$format,$version,$Eppid);
			$stringReturn = $ezbsimple->asXML() ;
			$stringReturn = preg_replace(array('/>[\s]+</','/<r[^<]*id="del".*?\/r>/'),array('><',''),$stringReturn);
        $ezbsimple = simplexml_load_string($stringReturn);
        

        if($debug){
        echo " New Feed Object with EPP Price indication:<BR>";
				echo "--------------<BR>";
				elegant_data($ezbsimple);
				echo "<HR>
          ";
          }
          }
          $ezbsimple=build_ezbxmlfeed_fixDummy($ezbsimple,$cc,$lc,$ms,$clientId);
          if($browse!=1 || (($clientId=="SureSupply") && $filter != "price"))
		  {

			$ezbsimple=build_ezbxmlfeed_urls($ezbsimple,$cc,$lc,$ms,$clientId);
      
			if($debug)
			{
				echo "Feed Object with URls rebuilt   :<BR>";
				echo "--------------<BR>";
				elegant_data($ezbsimple);
				echo "<HR>";
			}
		}

		if(($clientId!="SureSupply") && !$Eppid){
			$ezbsimple=options_disable_ezbxmlfeed($ezbsimple,$xml,$cc,$lc,$ms,$clientId,$format,$version);
			if($browse!=1){
				$stringReturn = $ezbsimple->asXML() ;
				$stringReturn = preg_replace(array('/>[\s]+</','/<p[^<]*id="del".*?\/p>/','/<p[^<]*id="del".*?\/>/'),array('><','',''),$stringReturn);
				$ezbsimple = simplexml_load_string($stringReturn);
			}
			if($debug){
				echo "Feed Object with disable options<BR>";
				echo "--------------<BR>";
				elegant_data($ezbsimple);
				echo "<HR>";
			}


			$ezbsimple=options_hide_ezbxmlfeed($ezbsimple,$xml,$cc,$lc,$ms,$clientId,$format,$version);
			if($debug){
				echo "Feed Object with Hide options:<BR>";
				echo "--------------<BR>";
				elegant_data($ezbsimple);
				echo "<HR>
          ";
          }

          }
          if($browse!=1 || $debug){ // send to Omniture if not coming from EZB HTML implementation code or if debug
          sendOmniture($xml,$ezbsimple,$partnr,$cc,$lc,$ms,$partnr,$clientId,$debug);
          }

          //We shouldn't display any prices (like list price, stock price etc.,) in the pn node of XML.
          if ($clientId != "Report") {
          unsetPrices($ezbsimple,$browse);


          }
		  	//Added by Nithiyanandhan on 8/8/2016 - Truncate the price partner number - Start
			
		
    		$config_xml = $xml["configXmlFile"];;
    				
			$config_xml = file_get_contents("../../$cc/$lc/".$config_xml);
			
			$tmp = simplexml_load_string($config_xml);
			$ctaLocalizeResellerText ='';
			$ctaLocalizeBuynowText ='';
			foreach($tmp->buttons  as $btn) 
			{
				foreach($btn->btn as $btntext)
				{
					if($btntext->attributes()=="findreseller")
					{
						$ctaLocalizeResellerText = $btntext->label;
					}
					if($btntext->attributes()=="buy")
					{
						$ctaLocalizeBuynowText = $btntext->label;
					}
				}
				
			}
			
		  	$return=$ezbsimple;
			$isMarketplace=0;
			
			foreach($return->p as $p) 
			{
					if ($p->r[0]) 
					{
						
						$r_i = 0;
						foreach($p->r as $r) 
						{
							$ctasegment = $r->n;
							if($ctasegment!='Marketplace')
							{
								
								$r->u="https://findapartner.hpe.com/";
								//$p->r->addChild("u","https://findapartner.hpe.com/");
								$p->addAttribute("cta","findLocalPartner");
								$p->addAttribute("ctalocalize",$ctaLocalizeResellerText);
								
																									
							}
							else
							{
							 $isMarketplace = 1;
 							 $p->addAttribute("cta","buyNow");
							 $p->addAttribute("ctalocalize",$ctaLocalizeBuynowText);
							
							$url = split(";",$r->u);
							$r->u = "";
							$price="";
							foreach($url  as $spliturl)
							{
								$spliturl = $spliturl.";";
								if (strpos($spliturl, 'partnr=') !== false) {
									   $price='partnr='.$p["pn"]."|".$p->r["pr"].",&amp;";
								}
								if (strpos($spliturl, 'price=') !== false) {
									$spliturl = $price;
									$spliturl  = str_replace("partnr=","price=",$spliturl);
									
								}
								
								
								$r->u = $r->u . $spliturl;
								$r->u = str_replace("&amp;","&",$r->u);
								$r->u = str_replace(";","",$r->u);
							}	
							}
						    
						}
					}
					else
					{
						$p->addAttribute("cta","findLocalPartner");
						$p->addAttribute("ctalocalize",$ctaLocalizeResellerText);	
						$p->addChild("r","");
						$p->r->addChild("u","https://findapartner.hpe.com/");																					
					}
			}
			foreach($return->p as $p) 
			{
				if ($p->r[0]) 
					{
						$r_i = 0;
						foreach($p->r as $r) 
						{
							$ctasegment = $r->n;
							if($ctasegment!='Marketplace')
							{
								$p->r[$r_i]="";
								$p[$r_i]="";
					    	}
							
							$r_i = $r_i + 1;
						}
					}
				}
			foreach($return->p as $p) 
			{
				if (!$p->r[0]) 
				{
					$p->addChild("r","");
					$p->r->addChild("u","https://findapartner.hpe.com/");
				}
				 if( strpos($p["pn"], '%23') !== false )
				{
					$p->r="";
					$p[0]="";
					$p["pn"]="";
					$p["cmpy"]="";
					$p["sc"]="";
					$p["pi"]="";
					$p["cta"]="";
					$p["ctalocalize"]="";
					$p["nop"]="";
					
					//$p = str_replace($p["pn"],"",$p);
					
					
				}
			}
			
			//End
			//echo $ezbs;
          if(is_object($ezbsimple)){
          $ezbs = $ezbsimple->asXML();
		 
          }
          else{
          //echo"The result is" . $ezbsimple["s"];

          $ezbs ="\n"."<ezb f=\"".$ezbsimple["f"]."\" s=\"".$ezbsimple["s"]."\"> \n </ezb>";
		   
		  
           }

          }else{
          $ezbs='<?xml version="1.0" encoding="utf-8"?><ezb f="1.0.disable" s="kelkoo"></ezb>';
          }


          if($format=="xml"){

          if(!$debug)
		  {
            //echo $ezbs;
			$ezbBothsegment = "\n <marketSegment ms=\"$ms\">".$ezbs."</marketSegment>".$ezbBothsegment;
		  }
          else
		  {
          echo  "<pre>" . str_replace("old_pr=","<font color=\"blue\">old_pr=</font>",str_replace("hi=","<font color=\"red\">hi=</font>",str_replace("<","&lt;",str_replace(">","&gt;",$ezbs)))) . "</pre>";
			}
			
			
	}
	else
	if($format=="js_s"){
		$pieces = explode("\n", $ezbs);
		$ezbs_js="";
		for($line = 0;$line<(count($pieces));$line++){
			$char = "'";
			$string = preg_replace("/'/", "\'", $pieces[$line]);
			if($line == 0){
				$ezbs_js=  "var ezbxml = '<?xml version=\"1.0\" ?>"."'\n";
			}else{
				if (trim($string) != "")
					$ezbs_js=$ezbs_js .  "ezbxml += '".$string."'\n";

			}
		}
		$ezbs_js=str_replace("<![CDATA[","",$ezbs_js);//buy direct from hp]]>
		$ezbs_js=str_replace("]]>","",$ezbs_js);
		$ezbs_js=str_replace("</r>","	</r>",$ezbs_js);
		$ezbs_js=str_replace("</p>","	</p>",$ezbs_js);

        if(!$debug){
        echo $ezbs_js;
        }else
        echo "<pre>" .str_replace("<","&lt;",str_replace(">","&gt;",$ezbs_js)) . "</pre>";
        }

        if ($format == "json" ) {

        

        $jsonezbxmlo=JSON_ezbxmlfeed($ezbsimple,$cc,$lc,$ms,$clientId,$format,$partnr,$xml,$callback);

        if($debug) {
        echo "<BR><BR> JSON Object:<BR>--------------<BR>";
		}
		echo $jsonezbxmlo;
	}
}

$ezbBothsegment = str_replace("<?xml version=\"1.0\" encoding=\"utf-8\"?>","",$ezbBothsegment);
$ezbBothsegment = str_replace("pn=\"\"","",$ezbBothsegment);
$ezbBothsegment = str_replace("cmpy=\"\"","",$ezbBothsegment);
$ezbBothsegment = str_replace("sc=\"\"","",$ezbBothsegment);
$ezbBothsegment = str_replace("pi=\"\"","",$ezbBothsegment);
$ezbBothsegment = str_replace("cta=\"\"","",$ezbBothsegment);
$ezbBothsegment = str_replace("ctalocalize=\"\"","",$ezbBothsegment);
$ezbBothsegment = str_replace("ctalocalize=\"\"","",$ezbBothsegment);
$ezbBothsegment = str_replace("nop=\"\"","",$ezbBothsegment);
$ezbBothsegment = str_replace("<p       ></p>","",$ezbBothsegment);
$ezbBothsegment = "<?xml version=\"1.0\" encoding=\"utf-8\"?><ezbuy>".$ezbBothsegment."</ezbuy>";
			
echo $ezbBothsegment;

}

//ENd
}


?>

