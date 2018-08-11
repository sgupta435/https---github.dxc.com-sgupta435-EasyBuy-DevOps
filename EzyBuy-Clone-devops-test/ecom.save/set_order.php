<?php

//Set up (querystring) variables
$ezb_partner = isset($_GET["ezb_partner"])?$_GET["ezb_partner"]:"undef";
$ezb_order = isset($_GET["ezb_order"])?$_GET["ezb_order"]:"undef";
$ezb_order_id = isset($_GET["ezb_order_id"])?$_GET["ezb_order_id"]:"undef";
$ezb_order_details = isset($_GET["ezb_order_details"])?$_GET["ezb_order_details"]:"undef";
$ezb_order_details_origin = isset($_GET["order_details"])?$_GET["order_details"]:"undef";
$ezb_error = isset($_GET["error"])?$_GET["error"]:"undef";
$ezb_cc = isset($_GET["cc"])?$_GET["cc"]:"undef";
$ezb_ll = isset($_GET["ll"])?$_GET["ll"]:"undef";
$ezb_ms = isset($_GET["ms"])?$_GET["ms"]:"undef";
$ezb_cur = isset($_GET["cur"])?$_GET["cur"]:"undef";
$version = isset($_GET["version"])?$_GET["version"]:"undef";


/*
 * Avoid caching
 */
header("Content-Type: image/gif");
if((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' )){
	header('P3P: policyref="https://www.hp.com/w3c/p3p.xml", CP="NOI DSP COR NID PSA OUR IND COM NAV STA"');
}else{
	header('P3P: policyref="http://www.hp.com/w3c/p3p.xml", CP="NOI DSP COR NID PSA OUR IND COM NAV STA"');
}
$expires= gmstrftime("%a, %d-%b-%Y %H:%M:%S GMT",time()+30*24*3600);
//header("Set-Cookie: _hpoid=" . $ezb_partner. "|" . $ezb_order . "; expires=Tue, 26-Apr-2022 12:00:00 GMT; domain=hp.com; path=/;");
header("Set-Cookie: _hpoid=" . $ezb_partner. "|" . $ezb_order . "|". $ezb_order_id . "; expires=" .$expires ."; domain=hp.com; path=/;");


include("s.gif");

$f=fopen(getenv("APACHE_INSTANCE") . "/logs/order_log." . date("Ymd"),"a+");
fwrite($f,date("S M d G:i:s Y\t") . $ezb_error . "\t" . $ezb_partner ."\t" . $ezb_cc . "-" . $ezb_ll . "-" . $ezb_ms . "-" . $ezb_cur. "\t" . $ezb_order_id ."\t" . $ezb_order_details . "\t" . $ezb_order_details_origin . "\t" . $version . "\n");
fclose($f);
?>