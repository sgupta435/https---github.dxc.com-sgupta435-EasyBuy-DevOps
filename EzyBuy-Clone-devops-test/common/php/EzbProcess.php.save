<?php
/**
 * @EzbProcess.php
 * HTML implementation code Build Code for Ezbuy
 *
 *
 **/
/*
 * Content Type declaration
 * Caching Headers and Compression start
 */
header("Content-Type: text/javascript; charset=utf-8");
require_once('include/CompressionAndCaching.class.php.inc');
$cache = new Cache_And_Compression();
$cache = new Cache_And_Compression(array('revalidate'=>false));
$cache->Start();

/*
 * Read input parameters **************
 */
require_once("include/ezb_utils.ProcessParams.php.inc");
require_once("include/ezb_settings.php.inc");
$_req_mandatory_var_names = array("cc","lc","version","ms","clientID");
$_req_optional_var_names = array("ezbdebug","v3");

$param_ok=UtilsProcessParams($_req_mandatory_var_names,$_req_optional_var_names,"ezbdebug");
/*
 * Temporary EZB3.0 migration
 */
if($v3!=1)
	$ecom_path="../../ecom";
else
	$ecom_path="../../ecom3.0";

if(!$param_ok)
	exit();
$br=($ezbdebug==1?"\n":"");
?>
EZB=window.EZB || {}; /* In case Loadjs was loaded before */
EZB.Settings={};
EZB.Settings.Get=function(){
<?php
	/**
	 * Get Country Settings
	 * EZB.Settings gets set by this function
	 * @param {}
	 * @return {}
	 * @method EZB.Settings.Get
	 * @public
	 * @static
	 */
	$res=GetEzbSettings(null, null, $cc, $lc, $ms, $clientID, "js", $ezbdebug);
	if(!$res){
		echo "\n};"; /* ensure correct javascript in page */
		echo 'EZB.Log("ERROR","Get EzbSettings failed: country="+EZB.Context.cc+" lang="+EZB.Context.lc+" PL="+EZB.Context.PL+" version="+EZB.Context.version);';
		echo "EZB.Log('ERROR','".str_replace("\n","<BR>",$debug_msg)."');";
		exit();
	}else{
		echo "\nEZB.Settings={};".$br;
		foreach ($res as $key=>$value) {
			if($key!="DynamicJS"){
				if($value=="1"){
					echo "EZB.Settings.$key=true;".$br;
				}else{
					if($value=="0"){
						echo "EZB.Settings.$key=false;".$br;
					}else{
						echo "EZB.Settings.$key='$value';".$br;
					}
				}
			}else{
				echo "\n$value;".$br;
			}
		}
	}
?>
};
EZB.Settings.Get();
<?php
/**
 * Load Main ejb.js
 */
include($ezbdebug==1?"../js/ezb.js":"../js/ezb-min.js");
include($ezbdebug==1?"../js/utils/json/Json.js":"../js/utils/json/Json-min.js");
?>
EZB.Config.Initial={};
<?php
	/**
	 * Load Country Configuration via include and callback
	 * This will set EZB.Config.Initial with the Config from the country
	 * @param {}
	 * @return {}
	 * @method EZB.Config.Get
	 * @public
	 * @static
	 */
?>
EZB.Config.Get=(function(){
<?php
	$clientId="hp.com";
	$format="JSON";
	$callback="EZB.Config.Initial=EZB.Config.CallBack";
	$config_xml_file=$res["configXmlFile"];
	include("GetEzbConfig.php");
?>
})();
<?php
/* Check Intel logo querystring, if it s there, add showIntelLogo to the option list */
?>
if (window.top.location.toString().indexOf("logo=1")!=-1) {
	EZB.Settings.options+=",showIntelLogo";
	EZB.Settings.options+=",showAMDLogo";
}
<?php
	/**
	 * Load Logo information
	 * This will set EZB.Logos with the logos array
	 * @param {}
	 * @return {}
	 * @method EZB.Logos.Get
	 * @public
	 * @static
	 */
?>
EZB.Logos=(function(){
	function Get(){
<?php
	include('include/csvload.php');
	$csv_file = "../../configuration/logos.csv";
	$mycsv = new CSV();
	$mycsv->CSVread($csv_file, ",");
	$mycsv->generateLogoArray(false);
?>
	EZB.Log("INFO:EZB.Logos.Get",(function(){c=0;for(var logo in ezb_logos){c++;}return(c)})()+" valid logos found");
	return(ezb_logos);
	}
	return{
		json:Get()
	}
})();
<?php
/**
 * Load metrics library, responsible for Omniture metrics
 * Load ezb_ui.js, responsible for single product template display
 */
echo "var ezb_css_s=[EZB.req_protocol, '//', EZB.Context.ezbserver].join('');";
include($ezbdebug==1?"$ecom_path/ezb_metrics.js":"$ecom_path/ezb_metrics-min.js");
include($ezbdebug==1?"../js/ezb_ui.js":"../js/ezb_ui-min.js");
?>

<?php
/**
 * Force ezb() if Force Displayed set
 */
?>
if(EZB.Context.ForcedDisplayId)
	ezb();