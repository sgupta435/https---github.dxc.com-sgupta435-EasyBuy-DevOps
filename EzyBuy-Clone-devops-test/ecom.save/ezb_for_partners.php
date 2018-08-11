<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0");
header("Pragma: no-cache");
header("Content-Type: text/javascript");

//Set up (querystring) variables
$is_https=false; //debug only
if((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ) || (isset($_GET["is_https"]) && $_GET["is_https"]==1)){
	$is_https =true;
}

//$version = isset($_GET["version"])?$_GET["version"]:"";
//if($version!=""){
//	echo "var ezb_ecom_version_r=\"".$version."\";";
//}

$ezb_partner = $_GET["ezb_partner"];
$ezb_partner = isset($_GET["ezb_partner"])?$_GET["ezb_partner"]:"0000000";

if(strlen($ezb_partner)<6)
	$ezb_partner=$ezb_partner . "-" . "0000000";

//Set up (Javascript) variables
print "var ezb_partner=\"";
print $ezb_partner;
print "\";\n";

print "var raw_ezb_partner=\"";
print $ezb_partner;
print "\";\n";

print "var raw_cookie=\"";
if(!isset($_COOKIE['_hpoid']))
	if($_GET["_hpoid"]){
		print $_GET["_hpoid"];
	}else{
		print "empty";
	}
else
	print $_COOKIE['_hpoid'];
print "\";\n";

if(!isset($_COOKIE['_ezb_o'])){
	if(isset($_GET["_ezb_o"]) && $_GET["_ezb_o"]){
		print "var l_s_eVar4=\"";
		print $_GET["_ezb_o"];
		print "\";\n";
	}
}else{
	print "var l_s_eVar4=\"";
	print $_COOKIE['_ezb_o'];
	print "\";\n";
}

if(!isset($_COOKIE['HP_EMEA_COOKIE'])){
	print "var hp_com_visit=0;\n";
}else{
	print "var hp_com_visit=1;\n";
}

if($is_https){
	$url='https' . '://'.$_SERVER['HTTP_HOST'];
	print "var is_https=true;\n";
}else{
	$url='http' . '://'.$_SERVER['HTTP_HOST'];
	print "var is_https=false;\n";
}

if(!isset($_SERVER['REDIRECT_URL'])){
	$patha=explode("/",$_SERVER['PHP_SELF']);
	array_pop($patha);
}else{
	$patha=explode("/",$_SERVER['REDIRECT_URL']);
	array_pop($patha);
	array_pop($patha);
}
$new=implode("/",$patha).'/set_order.php';
$url_order=$url . $new;
$new=implode("/",$patha).'/ezb_for_partners_tagging-min.js?'.rand();
$url_partners=$url . $new;

print "var set_order_url=\"";
print $url_order;
print "\";\n";

include('../common/php/include/csvload.php');

$csv_file = "../configuration/EZB_OmniturePartners.csv";
$mycsv = new CSV();
$mycsv->CSVread($csv_file,",");
$mycsv->generateStringSimple("openedPartners");

print "document.write('<script type=\"text/javascript\" language=\"JavaScript\" src=\"$url_partners\"></script>');";
if($is_https)
	print "/*var s_disable_metrics=true;*/var _rm_page=true;document.write('<script type=\"text/javascript\" language=\"JavaScript\" src=\"https://www.hp.com/cma/region/emea/country/metricsEMEAuk_en.js\"></script>');";
else
	print "/*var s_disable_metrics=true;*/var _rm_page=true;document.write('<script type=\"text/javascript\" language=\"JavaScript\" src=\"http://www.hp.com/cma/region/emea/country/metricsEMEAuk_en.js\"></script>');";



?>