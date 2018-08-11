<?php
/*
 * @Loadjs.php
 * HTML implementation code entry point for Ezbuy
 * Is redirecting to itself potentialy to trigger load of new ezbserver or debug library
 * Is triggering call to Build script after all server/context has been defined
 *
 **/

/*
 * Content Type declaration
 * Caching Headers and Compression start
 */
header("Content-Type: text/javascript; charset=utf-8");
//require_once('include/Test.class.php.inc');
//$test1 = new testforversion();
//$test1-> versiontest();
require_once('include/CompressionAndCaching.class.php.inc');
$cache = new Cache_And_Compression();
$cache->Start();

/*
 * Read input parameters **************
 * ezb_redirection is localy forced redirection to get either debug libraries or the right ezbserver be used
 */

/*
 * Added by Nithiyanandhan on 05/08/2013
 * Market segment is not capturing properlly.Add the default value if market segment is not available.Start here
 */
 
 if(!isset($_GET["m_s"]))
 {
    $m_s="smb";
 }
 else
 {
    $m_s=$_GET["m_s"];
 }
 /*
 * End here
 */
 



require_once("include/ezb_utils.ProcessParams.php.inc");
$_req_mandatory_var_names = array("country","lang"); /* straight forward */
$_req_optional_var_names = array("PL","ezb_redirect","ezbdebug","version");

$param_ok=UtilsProcessParams($_req_mandatory_var_names,$_req_optional_var_names,"ezbdebug");

if(isset($ezb_redirect))
echo "EZB_load_redirected=true;";
/*
 * EZB Javascript minimum declaration in case the scripts breaks
 */
if(!isset($ezb_redirect)){
	echo "function ezb(){};"; /* needs to be defined once in case ezb wont be processed later on */
	echo "scLoaded=true;"; /* do not reload the same script. HTML implementation code checks whether this is set already or not to load this script. */
}

/*
 * Exit point if failure if no country/language parameters
 * others are defaulted or taken from Javascript context
 */
if(!$param_ok){
	exit();
}

/*
 * EZB configuration version reading
 * This is key as used to force browser cache refresh when calling build script
 */
if(!isset($version)){
	$ini_file = "../../releases/loadjs.ini";
	if(!sscanf(file_get_contents($ini_file),"version=%s",$version)){
		$version="999";
	}
}
if(isset($ezb_redirect)){
	$version.=rand();
}

/*
 * EZB debug definition
 * if debug is set, load libraries and define functions
 */
if((isset($ezb_redirect) && isset($ezbdebug) && $ezbdebug)){
	/*
	 * This is only when debug mode is set
	 * Yahoo log has issues on IE. Load Yahoo on non IE browsers only
	 */
	$is_ie=isset($_SERVER["HTTP_USER_AGENT"]) && (strpos(strtolower($_SERVER["HTTP_USER_AGENT"]),"msie")!==FALSE);
	if($is_ie){
		echo "EZB.Context.is_ie=true;";
		include("../js/utils/log/ezb_log_wrapper.js"); /* this will define EZB.Log(level,messsage) */
	}else{
		include("../js/utils/yui/build/yahoo/yahoo-min.js");
		include("../js/utils/yui/build/dom/dom-min.js");
		include("../js/utils/yui/build/event/event-min.js");
		include("../js/utils/yui/build/dragdrop/dragdrop-min.js");
		include("../js/utils/yui/build/logger/logger-min.js");
		include("../js/utils/yui/build/element/element-beta-min.js");
		include("../js/utils/yui/build/button/button-min.js");
		echo "document.write('<link TYPE=\"text/css\" REL=\"STYLESHEET\" HREF=\"http://" . $_SERVER["SERVER_NAME"] . "/ezbuy/common/js/utils/yui/assets/yui.css\"></link>');";
		echo "document.write('<link TYPE=\"text/css\" REL=\"STYLESHEET\" HREF=\"http://" . $_SERVER["SERVER_NAME"] . "/ezbuy/common/js/utils/yui/assets/dpSyntaxHighlighter.css\"></link>');";
		echo "document.write('<link TYPE=\"text/css\" REL=\"STYLESHEET\" HREF=\"http://" . $_SERVER["SERVER_NAME"] . "/ezbuy/common/js/utils/yui/build/logger/assets/logger.css\"></link>');";
		echo "document.write('<link TYPE=\"text/css\" REL=\"STYLESHEET\" HREF=\"http://" . $_SERVER["SERVER_NAME"] . "/ezbuy/common/js/utils/yui/build/button/assets/button.css\"></link>');";
		/*
		 * Define log function
		 * allow for frames to also get debug window
		 */
		echo <<<________EZB_DEBUG
		if(self.location==window.top.location || !(window.parent.EZB && window.parent.EZB.Log)){
			var EZBLogReader = new YAHOO.widget.LogReader();
			EZBLogReader.verboseOutput=false;
			EZBLogReader.setTitle('EZB Debug/Log Reader Console');
			EZB.Log=function(level,msg){
				var levela=level.split(":");
				if(levela[1]){
					var comp=levela[1].split(".");
					YAHOO.log((comp[2]?comp[2]:"")+":"+msg,levela[0],comp[0]+(comp[1]?("."+comp[1]):""));
				}else{
					YAHOO.log(msg,levela[0]);
				}
				if(window.console && console.log){
					console.log(level+' '+msg);
				}
			};
		}else{
			EZB.Log=function(level,msg){
				window.parent.EZB.Log(level.split(":")[0]+":FRAME_"+level.split(":")[1],msg);
			}
		}
		EZB.Log("INFO:global","EZB Debug set");
________EZB_DEBUG;
	}
}
/*
 * EZB PSC PL exceptions
 *
 */
$csv_file = "../../configuration/PSC_ForcedPL.csv";
if(file_exists($csv_file)){
	include('include/csvload.php');
	$mycsv = new CSV();
	$mycsv->CSVread($csv_file,",");
	$mycsv->generateJSArraySimple("PLexceptions",true);
}else{
	echo "var PLexceptions={};";
}
/*
 * EZB redirection need check: debug or ezbserver
 * when not redirection, define EZB minimum library and server side request variable
 */
if(!isset($ezb_redirect)){ /* only if not redirection already done. The following needs to be defined once.*/
	echo "EZB={};";
	echo "EZB.req_entry_uri='" . @$_SERVER["REQUEST_URI"] . "';";
	echo "EZB.req_self='" . $_SERVER["PHP_SELF"] . "';";
	echo "EZB.req_server='" . $_SERVER["SERVER_NAME"] . "';";

	if(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]=="on"){
		echo "EZB.req_protocol='https:';";
	}else{
		echo "EZB.req_protocol='http:';";
	}
	/*
	 * Include Javascript ezb load library
	 */
	include($ezbdebug?"../js/ezb_load.js":"../js/ezb_load-min.js");

	/*
	 * check various cookies settings as those would influence EZB:
	 * debug
	 * ezbserver
	 * ezbdisable
	 * ezbdisableserveroptions
	 */
	if(isset($_COOKIE["ezbserver"])){
		echo "var EZB_load_redirect=true;";
		echo "EZB.Context.ezbserver='" . $_COOKIE["ezbserver"] . "';";
	}
	if(isset($_COOKIE["ezbdebug"]) && $_COOKIE["ezbdebug"]=="1" )
		echo "EZB.Context.ezbdebug=true;";
	if(isset($_COOKIE["ezbdisableoptions"]) && $_COOKIE["ezbdisableoptions"]=="1" )
		echo "EZB.Context.ezbdisableoptions=true;";
	if(isset($_COOKIE["ezbdisable"]) && $_COOKIE["ezbdisable"]=="1" )
		echo "EZB.Context.ezbdisable=true;";
	/*
	 * Get Product Line PL from implementation paramenter
	 */
	if($PL!="" && $PL!="-1"){
		echo "EZB.Context.PL=\"$PL\";";
	}else{
		echo "window.s_ProductLine?EZB.Context.PL=s_ProductLine:0;";
	}
	/*
	 * run country code exceptions
	 */
	include ("include/country_exceptions.php");
	/*
	 * define context variable that come from within PHP params
	 */
	/*
	 * Next check if redirection needs to happen or if build script can be called immediately
 	 */
	echo <<<____EZB_BUILD_REDIRECT
	EZB.Context.version="$version";
	EZB.Context.cc="$country";
	EZB.Context.lc="$lang";
 /*
 * Added by Nithiyanandhan on 01/08/2013
 * Market segment is not capturing properlly.Add the default value if market segment is not available.Start here
 */
  
  	EZB.Context.m_s="$m_s";
  
   /*
      * End here
   */
	EZB.Load();
____EZB_BUILD_REDIRECT;
}else{
	/*
	 * this is a redirection (either for debug or for ezb server)
	 */
	echo <<<____EZB_BUILD
	EZB.Context.version="$version";
	EZB.Log("INFO:global","redirection reached with: country="+EZB.Context.cc+" lang="+EZB.Context.lc+" PL="+EZB.Context.PL+" version="+EZB.Context.version);
	EZB.Log("INFO:global","ezbserver used:"+EZB.Context.ezbserver);
	EZB.Build();
____EZB_BUILD;
}
?>