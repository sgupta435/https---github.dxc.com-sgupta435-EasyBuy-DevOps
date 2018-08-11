<?php
/*
 * Fetch CountrySettings
 */
function GetEzbSettings($paramCollection, $JSparam, $cc, $lc, $ms, $clientID, $format, $debug, $path="") {
/**
 * Read country settings files parameters
 * --------------------------------------
 * Traverse countrysettings file to return appropriate settings
 * +------------------------------------------------------------------------------------------------------+
 * | Usage:
 * | ------
 * | require_once "include/ezb_xml_utils.php.inc";
 * | $res=GetEzbSettings($paramCollection, $JSparam, $cc, $lc, $ms, $clientID, $format, $debug);
 * |
 * +------------------------------------------------------------------------------------------------------+
 * | IN:
 * | ---
 * | 1) null or array of keys wanted from settings file (array("ConfigXmlFile") for ex.). If null all params are returned
 * | 2) optional JS parameters sent to back-end. Format JSparam=PL|KV||id|4 for PL=KV and id=4. Impact would be that if
 * |    xml format output is required params PL=KV and id=4 would be used to return appropriate settings
 * | 3) country code
 * | 4) language code
 * | 5) market segment
 * | 6) client ID. this would filter the settings to the client ID section (and General)
 * | 7) format. Output format xml or js
 * | 8) debug true/false
 * | 9) path for .../ezbuy/common/php. If not set assuming script included from .../ezbuy/common/php
 * |
 * | OUT:
 * | ---
 * | 1) array of keys/values
 * |    xml specific: N/A
 * |    js specific: an additional key/value "DynamicJS" is added that contains javascript to be used to evaluate context
 * |    based settings (PL=KV or PL=...)
 * | 2) $debug_msg var contains debug information if debug mode was set
 * +------------------------------------------------------------------------------------------------------+
 * | Internals:
 * | ----------
 * |02/06/2008: Creation
 * +------------------------------------------------------------------------------------------+
 * | Debug:
 * | --------
 * | use 8) input param 
 * +------------------------------------------------------------------------------------------+
 * | Assumptions:
 * | ------------
 * | List of predefined keys is used within the function if first param is null
 * | It is up to the main program to traverse the output array and use it accordingly
 * +==========================================================================================+
 *
 **/
	// Data gathering from countrysettings.ini file sections
	// "" for non mandatory
	// "default" for default value
	// "-" for mandatory
	
	$paramCollectionDefault = array(
	"showDirectTemplate" =>array("js", "0"),
	"ForceDirectExperience" =>array("js", "0"),
	"configXmlFile" =>array("xml|js", ""),
	"indPriceOrder" =>array("xml|js", "sto;pp;sp;mea;stp;lp"),
	"smallInterfaceFile" =>array("xml|js", "ezinterface_small.swf"),
	"stdInterfaceFile" =>array("xml|js", "ezinterface_small.swf"),
	"proxyLcFile" =>array("js", "ezproxy.swf"),
	"goXmlQuery" =>array("xml|js", "-"),
	"excludePercRefPrice" =>array("xml|js", "sp"),
	"partnersExcludePercHigh" =>array("xml|js", ""),
	"partnersExcludePercLow" =>array("xml|js", ""),
	"elocatorURL" =>array("xml|js", "-"),
	"disablePNs" =>array("xml|js", ""),
	"dataserver" =>array("xml|js", "-"),
	"HPdataserver" =>array("js", "-"),
	"dataserverSource" =>array("xml|js", ""),
	"kelkooserver" =>array("xml|js", "-"),
	"ezbCurrencyCode" =>array("js", "EUR"),
	"flashEnable" =>array("xml", "1"),
	"searchXmlQuery" =>array("xml|js", "-"),
	"HPsearchXmlQuery" =>array("js", "-"),
	"css_file" =>array("js", "-"),
	"searchXmlQuerySource" =>array("xml|js", ""),
	"boxWidth" =>array("xml", "xxx"),
	"boxHeight" =>array("xml", "yyy"),
	"option" =>array("xml|js", ""),
	"disableLogosLink" =>array("xml|js", ""),
	"enableTracking" =>array("xml|js", "1"),
	"partnersExcludeIds" =>array("xml|js", ""),
	"partnersRestrictIds" =>array("xml|js", ""),
	"priceDecimal" =>array("xml|js", "0"),
	"xmlLoaderFile" =>array("xml", "swf/ezbase_new.swf"),
	//Added By Nithiyanandhan on 19/09/2014 - For ETR Integration - Start
	"ETR" =>array("xml",""),
	"Userid" =>array("xml",""),
	"Password" =>array("xml",""),
	"STOREENT_ID"=> array("xml",""),
	"EtrCurrency"=>array("xml",""),
	"Language"=>array("xml",""),
	"StoreURL"=>array("xml","")
	);
	//End
	global $debug_msg;
	if($JSparam){
		$JSparama = split("\|\|", $JSparam);
		for ($i = 0; $i < count($JSparama); $i++) {
			$JSparamav = split("\|", $JSparama[$i]);
			$str = "$".$JSparamav[0]."=\"".$JSparamav[1]."\";";
			eval($str);
		}
	}
	
	$apac=",au,cn,hk,in,id,jp,kr,my,nz,ph,sg,tw,th,vn,";
	$emea=",emea_africa,at,be,bg,by,ch,cs,cz,de,dk,ee,es,fi,fr,gr,hr,hu,ie,il,it,kz,lt,lv,me,emea_middle_east,nl,no,pl,pt,ro,rs,ru,se,sk,si,sr,tr,ua,uk,za,";
	$region="";
	if(strpos($apac,",".$cc.",")!==FALSE){
		$region="apac";
	}else{
		if(strpos($emea,",".$cc.",")!==FALSE){
			$region="emea";
		}else{
			$region="lar";
		}
	}

	if($path=="")
	
		$pre_path="";
	else
		$pre_path=$path."/";	
	$countrysettings_file = isset($ms) ? ("countrysettings_".$ms.".ini"):("countrysettings_smb.ini");
	$countrysettings_path = "$pre_path../../$cc/$lc/${cc}_${lc}_".$countrysettings_file;
	
	//Added by Nithiyanandhan on 2/2/2015 - AutoAD issue - Start
    if(!file_exists($countrysettings_path)&& $clientID == "SureSupplyAD")
	{
		$path = $pre_path."../../".$cc;
		$dir    = $path;
		$files2 = scandir($dir, 1);
		$lang = $files2[0];
		$countrysettings_path = "$pre_path../../$cc/".$lang."/${cc}_${lang}_".$countrysettings_file;
		
	}
	//End
	
	if($region!="")
		$countrysettings_file=$region."_".$countrysettings_file;

	$global_countrysettings_path = "$pre_path../../configuration/".$countrysettings_file;

   
	

			
	/*
	 * country countrysettings and global settings reading
	 * this merge global and countrysettings.ini with precedence for any section/key in global file
	 */
	if (file_exists($countrysettings_path)) {
		$ini_array = parse_ini_file($countrysettings_path, TRUE);
		if (file_exists($global_countrysettings_path)) {
			$global_ini_array = parse_ini_file($global_countrysettings_path, TRUE);
			foreach(array_keys($global_ini_array) as $global_section) {
				if (!array_key_exists($global_section, $ini_array)) {
					//section does not exit in cc/ll ini file
					$ini_array[$global_section] = $global_ini_array[$global_section];
				} else {
					// section exists, set key/values
					foreach($global_ini_array[$global_section] as $global_key =>$global_value) {
						$ini_array[$global_section][$global_key] = $global_value;
					}
				}
			}
		}
	} else {
		$debug_msg.="\nERROR: Could not load ini file:".$countrysettings_path;
		return (false);
	}

	if (!key_exists("GENERAL", $ini_array)) // general section must exist
		return (FALSE);
	$GENERAL = $ini_array["GENERAL"];

	if (key_exists($clientID, $ini_array)) // client id specific section
		$CID = $ini_array[$clientID];
	else
		$CID = array('false');

	/*
	 * check all params and get their value from merged .ini files
	 * abort if mandatory key not found
	 *
	 */
	$res = array();

	if(!is_array($paramCollection)){
		$paramCollection = $paramCollectionDefault;
	}
	
	$replacement = array();
	$replacement['find'] = array('#CC#','#LC#','#MS#','#SELF#');
    $replacement['replace'] = array($cc,$lc,$ms,$_SERVER['SERVER_NAME']);
        
	foreach($paramCollection as $key =>$def_array) {
		$key_format=$def_array[0];
		$key_default=$def_array[1];
		if (stristr($key_format, $format) !== FALSE) { // is the param for our format ?
			$found = false;
			isset(${$key})?$value = ${$key}:$value = $key_default; /* check if param is already set, unless set to default before checking in .ini files */
			if (key_exists($key, $CID)) { // check in clientID specific section
				if ($debug)
					$debug_msg.="\n$key found in $clientID: $CID[$key]";
				$value = $CID[$key];
				$found = true;
			} else if (key_exists($key, $GENERAL)) { // check in general section
				if ($debug)
					$debug_msg.="\n$key found in General: $GENERAL[$key]";
				$value = $GENERAL[$key];
				$found = true;
			}
			$value=str_replace($replacement['find'], $replacement['replace'], $value);
			$res = array_merge($res, array($key =>$value));
			if ($value != "-" && $value != "") {
				/* key was found and set*/
				if ($debug)
					$debug_msg.="\nSettings [$key=$value]";
			} else {
				if ($value == "-") {
					/* mandatory key not found */
					$debug_msg.="\nmissing mandatory $key ($value)";
					return(false);
				}else{
					if ($debug)
						$debug_msg.="\nnon mandatory $key missing";
				}
			}
		}
	}

	/*
	 * Process conditional sections found in ini files.
	 * Those are like PL==1N and this should be translated into conditions like if($PL=="1N") or in a new Key returned called DynamicJS in
	 * case oj JS format.
	 */


	$js_str = "";
	$js_str_def= "function beginsWith(str, sub){return(str && (str.toLowerCase() == sub.substring(0, str.length).toLowerCase()))}\n";

	foreach(array_keys($ini_array) as $global_section) { /* loop back in all sections to get conditional ones */
		/* for each section */
		$found = false;
		$return = false;
		if ($global_section != "GENERAL" && $global_section != $clientID) { /* only if not GENERAL or client id section */
			if (preg_match("/==\^/", $global_section)) { /* start with section */
				list($_left, $_right) = explode("==^", $global_section);
				$js_str.= "if(beginsWith(window.$_left,'$_right')){\n";
				eval("if(isset(\${$_left})) \$return="."strpos($".$_left.",'".$_right."')==0".";");
				$found = true;
			}
			elseif(preg_match("/==!\^/", $global_section)) { /* does not start with section */
				list($_left, $_right) = explode("==!^", $global_section);
				$js_str.= "if(!beginsWith(window.$_left,'$_right')){\n";
				eval("if(isset(\${$_left})) \$return="."strpos($".$_left.",'".$_right."')>0".";");
				$found = true;
			}
			elseif(preg_match("/==/", $global_section)) { /* equal to section */
				list($_left, $_right) = explode("==", $global_section);
				$js_str.= "if(window.$_left=='$_right'){\n";
				eval("if(isset(\${$_left})) \$return="."$".$_left."=='".$_right."'".";");
				$found = true;

			}
			elseif(preg_match("/!=/", $global_section)) {/* not equal to section */
				list($_left, $_right) = explode("!=", $global_section);
				$js_str.= "if(window.$_left!='$_right'){\n";
				eval("if(isset(\${$_left})) \$return="."$".$_left."!='".$_right."'".";");
				$found = true;
			}
			if ($found) { /* found conditional section */
				foreach($ini_array[$global_section] as $key =>$value) { /* get all key values for this cond. section */
					if(key_exists($key, $paramCollection)){ /* only the ones we want */
						$use_key=$key;
						if($key=="option")
							$use_key="options";
						$js_str.= "EZB.Settings.$use_key=\"$value\";\n"; /* javascript specific */
						if ($return) { /* php : set the key/value immediately */
							$res["$key"] = $value;
						}
					}
				}
				$js_str.= "}\n";
			}
		}
	}
	
	if (isset($res["option"]) && $res["option"] != ""){
		$res["options"]=$res["option"];
		unset($res["option"]);	
	}else{
		$res["options"]="";
	}

	if ($format != "xml") {
		if ($js_str != "") {
			$js_str = "(function(){\n".$js_str_def."\n".$js_str."})();";
			$res = array_merge($res, array("DynamicJS" =>$js_str));
		}
	}
	return ($res);
}
?>