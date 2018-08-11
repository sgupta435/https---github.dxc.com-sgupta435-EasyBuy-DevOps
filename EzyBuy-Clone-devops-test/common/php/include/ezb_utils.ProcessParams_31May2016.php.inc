<?php
/**
 * +======================================================================================================+
 * | EZB utils library
 * +======================================================================================================+
 **/
 
 
	
	
function UtilsProcessParams($mandatory,$optional,$debug_var_name){
/**
 * Read input parameters
 * ---------------------
 * Sets mandatory and optional parameters from available POST/GET http parameters and existing parameters (case of php include usage)
 * +------------------------------------------------------------------------------------------------------+
 * | Usage:
 * | ------
 * | require_once "include/ezb_utils.php.inc";
 * | $_req_mandatory_var_names = array("country", "lang", "clientID"); //mandatory parameters
 * | $_req_optionsal_var_names = array("debug", "FIF", "guistyle", "ezbExp", "m_s", "IncludeCountrysettings"); //optional parameters
 * | $param_ok=process_params($_req_mandatory_var_names, $_req_optional_var_names, "debug");
 * |
 * +------------------------------------------------------------------------------------------------------+
 * | IN:
 * | ---
 * | 1) mandatory parameters names array
 * | 2) optional parameters names array
 * | 3) name of variable that should be checked to see if debug mode is on (its value or POST/GET param should be true)
 * |
 * | OUT:
 * | ---
 * | 1) return value is true/false if manadatory params are all set/not set
 * | 2) $debug_msg var contains debug information if debug mode was set
 * | 3) all mandatory/optional params are set to their value or to null
 * +------------------------------------------------------------------------------------------------------+
 * | Internals:
 * | ----------
 * |02/06/2008: Creation
 * +------------------------------------------------------------------------------------------+
 * | Debug:
 * | --------
 * | use third input param 
 * +------------------------------------------------------------------------------------------+
 * | Assumptions:
 * | ------------
 * | Precedence is given to GET/POST params
 * +==========================================================================================+
 *
 **/
 
  

 	
	import_request_variables("gp", "_req_");// get GET/POST parameters
	
	
	global ${$debug_var_name};
	global ${'_req_'.$debug_var_name};
	global $debug_msg;
	$param_ok = true;
	!isset($debug_msg)?$debug_msg="":0;
	!isset(${'_req_'.$debug_var_name})?(isset(${$debug_var_name})?$local_debug=${$debug_var_name}:$local_debug=0):$local_debug=${'_req_'.$debug_var_name};
	foreach($mandatory as $name) { // process mandatory parameters
		
		
		global ${$name};
		global ${'_req_'.$name};
		//print $_REQUEST[$name];
		if (!isset(${'_req_'.$name})) {
			if (!isset(${$name})) {
				$param_ok = false; // $var is neither available in GET/POST params not was it set before (case of php include)
				if($local_debug)
					$debug_msg.= "mandatory $name missing<BR>";
			}
		} else {
		//Added By Manjunath on 11/03/2015 for Cross-Site Scripting issue  ---Start
			if(strcmp (strip_tags(${'_req_'.$name}) ,${'_req_'.$name})!=0)
			{
				echo "<font style=color:red>Error in parameter </font> ". $name . "<br\>";
				$param_ok = false;
			}

		    //Added By Manjunath on 02/04/2015  to remove ' 
			if($name == 'url'||$name =='ssad_url')
			{
				${$name}=${'_req_'.$name};
			}else
			{  ${$name} = htmlentities(str_replace("'",'',${'_req_'.$name}), ENT_QUOTES, "UTF-8"); //$var exists in GET/POST params 
		 	}
		    //end

			
			//ends for Cross-Site Scripting issue
		}
				
		if($local_debug && $param_ok)
			$debug_msg.= "mandatory $name is ${$name} <BR>";
	}
		
	foreach($optional as $name) {
		global ${$name};
		global ${'_req_'.$name};
		if (!isset(${'_req_'.$name})) {
			if (!isset(${$name})) {
				${$name} = null; // $var is neither available in GET/POST params not was it set before (case of php include)
				if($local_debug)
					$debug_msg.= "optional $name is missing <BR>";
			}
		} else {
		
		//Added By Manjunath on 11/03/2015 for Cross-Site Scripting issue  ---Start
			if(strcmp (strip_tags(${'_req_'.$name}) ,${'_req_'.$name})!=0)
			{
				echo "<font style=color:red>Error in parameter </font> ". $name . "<br\>";
				$param_ok = false;
			}
			
		   //Added By Manjunath on 02/04/2015  to remove ' 
			if($name == 'url'||$name =='ssad_url')
			{
				${$name}=${'_req_'.$name};
			}else
			{  ${$name} = htmlentities(str_replace("'",'',${'_req_'.$name}), ENT_QUOTES, "UTF-8"); //$var exists in GET/POST params 
			}
		  //end
			
           //ends for Cross-Site Scripting issue
			}
	if($local_debug && ${$name}!=null)
		$debug_msg.= "optional $name is ${$name} <BR>";
	}
	if($local_debug){
		if($param_ok)
			$debug_msg.= "---------->Read Input parameters is OK<BR>";
		else
			$debug_msg.= "----------><font color=\"red\">Read Input parameters is NOT OK</font><BR>";

	}
	
	return($param_ok);
}
?>