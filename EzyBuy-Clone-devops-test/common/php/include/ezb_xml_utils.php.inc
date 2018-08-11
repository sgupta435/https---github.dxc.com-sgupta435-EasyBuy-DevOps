<?php
/**
 * /ezbuy/common/php/ezb_xml_utils.php.inc
 * $Date: 2009/03/24 08:13:39 $
 * $Revision: 1.3 $
 * $Author: ezbuydev $
 * $Id: ezb_xml_utils.php.inc,v 1.3 2009/03/24 08:13:39 ezbuydev Exp $
 * $Log: ezb_xml_utils.php.inc,v $
 * Revision 1.3  2009/03/24 08:13:39  ezbuydev
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
 * Revision 1.2.2.1  2009/03/24 07:51:16  ezbuydev
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
 * Revision 1.14.8.10  2008/01/28 11:51:27  ezbuy
 * Fixed as part of DCC_REL_1_8
 *  - Reverted the unsetting of sc attribute from the product node
 *  - If the hideOptions is set on, even the HP reseller price shoud not be displayed. Modified the code for this.
 *
 * Revision 1.14.8.9  2008/01/25 10:26:28  ezbuy
 * Fixed as part of DCC_REL_1_7
 *
 * Revision 1.14.2.6  2007/11/27 10:11:52  ezbuy
 * Chnages for DCC as well as Latest config files (.ini and .xml)
 *
 * Revision 1.14.2.5  2007/11/20 11:19:36  ezbuy
 * Simple XML changes
 *
 * Revision 1.14  2007/07/12 16:24:17  ezbuy
 * update GDIC CVS with EZB Production. Contains preparation for Phase 3.2 and 3.4 with callbacks
 *
 * Revision 1.12  2007/04/28 19:54:24  ezbuy
 * fixed Exclusion bug
 * updated proxy class
 * included JS format for GetEzbdata
 *
 * Revision 1.10.16.2  2007/04/28 19:32:47  ezbuy
 * fixed Exclusion bug
 * updated proxy class
 * included JS format for GetEzbdata
 *
 * Revision 1.10.16.1  2007/04/25 12:10:13  ezbuy
 * fixed Exclusion bug
 * updated proxy class
 * included JS format for GetEzbdata
 *
 * Revision 1.10  2007/03/02 16:55:54  ezbuy
 * new prff functionality for ireland templates
 * new omniture vars
 * update config from prod
 *
 * Revision 1.9.2.1  2007/03/02 16:47:14  ezbuy
 * new prff functionality for ireland templates
 * new omniture vars
 *
 * Revision 1.8  2006/10/18 10:15:55  slechner
 * - new config from prod
 * - new logos
 * - update metrics data sent to DoubleClick and currency table
 *
 * Revision 1.7.20.1  2006/10/18 09:58:48  slechner
 * - new config from prod
 * - new logos
 * - update metrics data sent to DoubleClick
 *
 * Revision 1.7  2006/08/03 14:43:44  slechner
 * - price reporting tool filtering capability
 *
 * Revision 1.6.58.1  2006/08/03 14:31:43  slechner
 * - price reporting tool filtering capability
 *
 * Revision 1.6  2006/04/24 21:03:25  slechner
 * REL_691_C_PROD_692 with:
 * - config change for french Shopping basket
 * - HTML layout change for SB (new html line)
 * - new column in report.php
 * - SureSupply return value improvement
 * - Omniture/DoubleClick pilot config change
 *
 * Revision 1.5.4.1  2006/04/24 20:59:25  slechner
 * REL_691_C_PROD_692 with:
 * - config change for french Shopping basket
 * - HTML layout change for SB (new html line)
 * - new column in report.php
 * - SureSupply return value improvement
 * - Omniture/DoubleClick pilot config change
 *
 * Revision 1.4  2006/03/01 11:12:31  slechner
 * REL_658_B_PROP_600 :
 * - fix encoding issue for SureSupply redirect URLs
 * - Allow for market segment to be upper case! as this was changed in SureSupply
 *
 * Revision 1.3.40.1  2006/03/01 11:01:55  slechner
 * REL_658_B_PROP_600 :
 * - fix encoding issue for SureSupply redirect URLs
 * - Allow for market segment to be upper case! as this was changed in SureSupply
 *
 * Revision 1.3  2006/01/09 14:53:32  slechner
 * - MyHardwareChoice MP2B config for CH/DE and UK
 * - SureSupply price Omniture reporting
 * - latest config
 * - release change
 *
 * Revision 1.2.12.1  2006/01/09 14:44:15  slechner
 * - MyHardwareChoice MP2B config for CH/DE and UK
 * - SureSupply price Omniture reporting
 *
 * Revision 1.2  2005/12/22 13:55:50  slechner
 * REL_602_C and REL_602_E merge into main + cofig update from Prod
 * Changes:
 * - limit quantity input inHTML template to 99
 * - new metrics as per Omniture instructions
 * - new back-end services
 * - new FR shopping basket config
 *
 * Revision 1.1.2.1  2005/12/22 13:32:23  slechner
 * Added EZbuy Back end services GetEzbData, GetEzbConfig, GoEzbPartnr
 *
 *
 * $Name: HEAD $
 * $State: Exp $
 *
 * +======================================================================================================+
 * | EZB PHP XML library
 * +======================================================================================================+
 * +------------------------------------------------------------------------------------------------------+
 * | Code Structure:
 * | --------------
 * +------------------------------------------------------------------------------------------------------+
 * | Usage:
 * | ------
 * +------------------------------------------------------------------------------------------------------+
 * | Glossary:
 * | ---------
 * +------------------------------------------------------------------------------------------------------+
 * | Internals:
 * | ----------
 * |04/28/2007: fixed reseller exclusion issue, changed proxy selection and added random proxy selection
 * |04/23/2007: added Epp ID processing & elegant dump
 * |03/02/2007: added generic price types (for GPSY and any new ones)
 * |02/22/2007: added promo nodes
 * |10/16/2006: added partner name in GoPartner URL for metrics
 * |12/19/2005: initial import
 * |
 * +------------------------------------------------------------------------------------------+
 * | Debug:
 * | --------
 * +------------------------------------------------------------------------------------------+
 * | Assumptions:
 * | ------------
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
 * +==========================================================================================+
 *
 **/

/*
 * Error handler
 */

 function myErrorHandler($errno, $errstr, $errfile, $errline) {
if(false){
	$f=fopen(getenv("APACHE_INSTANCE") . "/logs/php_log." . date("Ymd"),"a+");
	fwrite($f,date("[S M d G:i:s Y]") . "[error] [client " . $_SERVER['REMOTE_ADDR'] ."] $errno, $errstr, $errfile, $errline\n");
	fclose($f);
}
/*  switch ($errno) {
   default:
   return;
   break;
  }
*/
}

set_error_handler("myErrorHandler");

/*
 * Fetch Kelkoo data feed
 */


function get_ezbxmlfeed($configo,$partnr,$filter,$type,$m_r,$m_e,$format){
	
	$max_split_products=75;
	$partnra = array();
	$partnr=str_replace("#","%23",$partnr); // added by sunetra mhaske 16/06/2015
	$pn = explode(";", $partnr);
	$pn_list="";
	$j=0;
	for($i=0; $i < count($pn);$i++){
		if($i==0)
			$pn_list=$pn[$i];

		else
			$pn_list=$pn_list .";". $pn[$i];

		if(($i+1)>$max_split_products*($j+1)){
			$pn_list=$pn[$i];
			$j++;
		}
		$partnra[$j]=$pn_list;

	}
	/* build URL to get raw pricing data */
	if($configo["dataserverSource"]!="" && $configo["searchXmlQuerySource"]!=""){
		/* this is when direct access to raw data is not made but HP proxy (getEzbData) in between */
		$searchxmlurl="http://".$configo["dataserverSource"]."/".$configo["searchXmlQuerySource"];
	}else
		$searchxmlurl="http://".$configo["dataserver"]."/".$configo["searchXmlQuery"];
	$pos = strpos($searchxmlurl, ".hp.com/");
	if($pos!=false){ /* raw data pricing must be fetched from outside HP... */
		$ezbxmls='<?xml version="1.0" encoding="utf-8"?><ezb f="1.0.network.route" s="kelkoo"></ezb>';	
		return($ezbxmls);
	}	  
	
	
	
	if($filter)
		$searchxmlurl=$searchxmlurl."&filter=".$filter;
	if($type)
		$searchxmlurl=$searchxmlurl."&type=".$type;
	if($m_e)
		$searchxmlurl=$searchxmlurl."&m_e=".$m_e;
	if($m_r)
		$searchxmlurl=$searchxmlurl."&m_r=".$m_r;  
	if($format)
		$searchxmlurl=$searchxmlurl."&p_format=".$format;
	
	$use_proxy=0;
	if((strpos(php_uname(),'linux')===false)&& (strpos(strtolower(php_uname()),'g9t0296g')>0 || strpos(strtolower(php_uname()),'g9t0295g')>0 ) ) 
	{ //hp-ux env check
		$proxy=array('web-proxy','web-proxy.bbn.hp.com','web-proxy.corp.hp.com','rio.india.hp.com');
		$use_proxy=1;
	}
	$ezbxmlalls="";
	$proxy_cont="";
	for($j=0; $j < count($partnra);$j++){
		$url=str_replace('#PN#',$partnra[$j],$searchxmlurl);
		//Need some logic to pass the partnernum as a last parameter
		if(strpos($url,"country=us")!==false)
		{
			$url = str_replace('productNumber=','',$url);
			$url = str_replace($partnra[$j].'&','',$url);	
			$url = $url."&productNumber=".$partnra[$j];
		}
		//end
		
		
		if(!$use_proxy){ /* assuming hp-ux env means no need of proxy */
			$ezbxmls=file_get_contents($url);
			if(strstr(substr($ezbxmls,0,100),'<ezb')===FALSE){
				$f=fopen(getenv("APACHE_INSTANCE") . "/logs/php_log." . date("Ymd"),"a+");
				fwrite($f,date("[S M d G:i:s Y]") . "[error] [client " . $_SERVER['REMOTE_ADDR'] ."] ERROR GETTING $url ($ezbxmls)\n");
				fclose($f);
				break;		
			}else{
				$proxy_cont="ok";
			}
		}else{
			for($i=0;$i<count($proxy);$i++){
				$proxy_fp=fsockopen($proxy[$i],"8088");
				if($proxy_fp){
					$proxy_cont="";
					fputs($proxy_fp, "GET $url HTTP/1.0\r\n\r\n");
					while(!feof($proxy_fp)){
						$proxy_cont .= fread($proxy_fp,1024);
					}
  					fclose($proxy_fp);
  					$proxy_cont = substr($proxy_cont, strpos($proxy_cont,"\r\n\r\n")+4);
					if($proxy_fp && $proxy_cont!=""){
						$ezbxmls=$proxy_cont;
						break;
					}
				}
			}	
		}	
		$ezbxmlalls=$ezbxmlalls.$ezbxmls;
	}
	if($proxy_cont==""){
		$ezbxmls='<?xml version="1.0" encoding="utf-8"?><ezb f="1.0.network" s="kelkoo"></ezb>';
	}

	if(count($partnra)>1){
		$ezbxmlalls=preg_replace('/<.*?kelkoo">/i', '', $ezbxmlalls);
		$ezbxmlalls=preg_replace('/<\?xml.*>/i', '', $ezbxmlalls);
		$ezbxmlalls=preg_replace('/<\/ezb>/i', '', $ezbxmlalls);
		$ezbxmls='<?xml version="1.0" encoding="utf-8"?><ezb f="1.0" s="kelkoo">'.$ezbxmlalls.'</ezb>';
	}

	return ($ezbxmls);
}

/*
 * Rebuild click URLs
 */
function build_ezbxmlfeed_fixDummy($xml,$country,$lang,$m_s,$client_id)
{
	$return=$xml;
	if ($return->p[0]) {
		foreach($return->p as $p) {
			if ($p->r[0]) {
				$r_i = 0;
				foreach($p->r as $r) {
					if(strstr($r->m,'DUMMY')!==FALSE){
						$r->m="";
					}
					$r_i = $r_i + 1;
				}	
			}
		}
	}
	return($return);
}
/*
 * Rebuild click URLs
 */
function build_ezbxmlfeed_urls($xml,$country,$lang,$m_s,$client_id)
{
	$return=$xml;
	$urldecode='';
	
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on')
		$protocol="https";
	else
		$protocol="http";
	
	if ($return->p[0]) {
		$price="";
		foreach($return->p as $p) {
			$p["pn"]=urlencode($p["pn"]);
						$price.= $p["pn"].'|'.$p["_pi"].",";
		}
		foreach($return->p as $p) {
			if ($p->r[0]) {
				$r_i = 0;
				foreach($p->r as $r) {
					
					if($r["t"]=="ushho")
					{
							if(strpos($p["pn"],"%23")!==false)
							{
								$spnsplit = split("%23",$p["pn"]);
								$spn = $spnsplit[0]."#".$spnsplit[1];
							}
							else
							{
								$spnsplit[0]=$p["pn"];
							}
							if(strpos($price,"%23")!==false)
							{
								$princesplit = split("%23",$price);
								$princesplit[0] = $princesplit[0]."|".$r["pr"];
							}
							else
							{
								$princesplit[0]=$price;
							}
						    						
					}
					
					$addurl='&country='.$country;
					$addurl.='&lang='.$lang;
					if($r["t"]=="ushho")
					{
					   $addurl.='&partnr='.$spnsplit[0];
					}
					else
					{
						$addurl.='&partnr='.$p["pn"];
					}
					if ($r["mp2b"]=='1') {
						$addurl.='&mp2b_partnr=__MP2B__';
					}
					$addurl.='&m_s='.$m_s;
					if($r["t"]=="ushho")
					{
					  $addurl.='&price='.$princesplit[0];
					}
					else
					{
						$addurl.='&price='.$price;
					}
					$addurl.='&type='.$r["t"];
					$addurl.='&client_id='.$client_id;
					$addurl.='&pkey='.$r_i;
					$addurl.='&availability='.$r["st"];
					$addurl.='&id='.$r["id"];
					$addurl.='&pname='.urlencode($r->n);
					
					$path=$_SERVER['PHP_SELF'];
					$patha=explode("/",$path);
					array_pop($patha);
					$new=implode("/",$patha).'/GoEzbPartner.php';
					//Modified by Nithiyanandhan on 09/10/2014 - US SMB issue fixes
					if($r["t"]=="ushho")
					{
						$urldecode = urldecode($r->u);
					}
					else
					{
						$urldecode = $r->u;
					}
					/*if($r["t"]=="ushho")
					{
						$r->u=$protocol . '://'.$_SERVER['SERVER_NAME'].$new.'?'.htmlentities($addurl.'&url='.$urldecode.'&spn='.$spn);
					}
					else
					{*/
						$r->u=$protocol . '://'.$_SERVER['SERVER_NAME'].$new.'?'.htmlentities($addurl.'&url='.$urldecode);
					/*}*/
					
					
					//end
					$r_i = $r_i + 1;
				}	
			}
		}
	}
	return($return);
}

function cmp($a, $b)
{
   if ($a == $b) {
	   return 0;
   }
   return ($a < $b) ? -1 : 1;
}

/*
 * Process exclusions
 */
function options_exclusions_ezbxmlfeed($xml,$configo,$country,$lang,$m_s,$client_id,$format,$version)
{
	$return=$xml;

	$use_max=1;
	$use_min=1;
	
	$return["s"]=$return["s"] .".options_exclusion";
	
	$exclmin=$configo["partnersExcludePercLow"];
	$exclmax=$configo["partnersExcludePercHigh"];
	
	if (!($exclmax>0)) {
		$exclmax=0;
		$use_max=0;
	}
	if (!($exclmin>0)) {
		$exclmin=0;
		$use_min=0;
	}
	/*
	 * If settings show we need to process
	 */
	if ($configo["excludePercRefPrice"] && ($exclmax||$exclmin)) {
		$exclrefa=explode(";",$configo["excludePercRefPrice"]); /* split reference price string */
		for ($i=0; $i < count($exclrefa); $i++) { /* for each price type in reference price */
			if ($return->p[0] ) {/* at least one product */
				foreach($return->p as $p) { /* each product */
					$exclref=$exclrefa[$i]; 
					$exclrefprice=0;
					if ($exclref!="sto" && $p[$exclref]) { 
						$exclrefprice=$p[$exclref];
					} else {
						if ($p->r[0] && $p->r[0]['t']=="hp") {
							$exclrefprice=$p->r[0]['pr'];  
						}
					}
					if ($exclrefprice && ($exclmax!=0 || $exclmin!=0)) {  
						$exclmaxprice=(1+$exclmax/100)*$exclrefprice;
						$exclminprice=(1-$exclmin/100)*$exclrefprice; 
						if($p->r[0]){
							foreach($p->r as $r) { /* each reseller */
								if (!(($r['t']=="hp") || ($use_max*$r['pr']<=$exclmaxprice && $r['pr']>=$exclminprice*$use_min))) {
									// dont keep the reseller except if report client id
									if ($client_id=="Report") {
										$r['ex']="yes:price exclusion";
									}else{
										$r['id']="del"; /* mark for deletion */
									}
								}
							}
						}
					}
				}  
			}
		}
	}	
	return($return);
}
 
/*
 * Process Disable options
 */
function options_disable_ezbxmlfeed($xml,$configo,$country,$lang,$m_s,$client_id,$format,$version){
	$return= $xml;
	$return["s"]=$return["s"].".options_disable";  
	if(stristr($configo["options"],"nostaticdisable")){ /* if option set */
		if ($return->p[0]) {
			foreach($return->p as $p) {
				if(!($p["sp"] || $p["pp"])){ /* if no static or promo price */
					if($client_id=="Report"){
						$p["ex"]="yes:no static price";
					}else{
						$p["id"]="del"; /*mark for deletion */
					}
				}
			}
		}
	}
	return($return);
}

/*
 * Process Hide Options
 */
function options_hide_ezbxmlfeed($xml,$configo,$country,$lang,$m_s,$client_id,$format,$version){
	$return=$xml;
		
	$return["s"]=$return["s"].".options_hide";
	if(stristr($configo["options"],"hideprices")){  /* if option set */
		if ($return->p[0]) {
			foreach($return->p as $p) {
				if($p->r[0]){
					foreach($p->r as $r) {
						if($client_id=="Report"){ 
							$r["hi"]="yes:hide price";
						}else{
							unset($r["pr"]);
						}
					}
				}
			}
		}
	}
	return($return);
}
 
/*
 * Add Epp Id products
 */
function addEppid($partnr,$Eppid){
	$partnr = preg_split("/;/",$partnr);
	$newPartnr = "";
	for($i = 0;$i<count($partnr);$i++){
		if(count($partnr)-1 != $i){
			$newPartnr .= $partnr[$i].";".$partnr[$i]."_$Eppid;";
		}
		else {
			$newPartnr .= $partnr[$i].";".$partnr[$i]."_$Eppid";
		}
	}
	return $newPartnr;
}

/*
*EPP Price Indication
*/
function private_pricing_ezbxmlfeed($xml,$configo,$country,$lang,$m_s,$client_id,$format,$version,$Eppid){
	$return=$xml;
	
	$return["s"]=$return["s"].".epp";

	if ($return->p[0]) {
		foreach($return->p as $p) {
			preg_match("/_$Eppid$/", $return->$p["pn"], $match);
			if(count($match) >0){
				$prodNo = substr($return->$p["pn"],0,strlen($return->$p["pn"])-strlen($Eppid)-1);
				foreach($return->p as $pp) {
					if($pp["pn"] == $prodNo){
						$pp["pi"] = $p["pi"];
						$pp->r[0]["old_pr"] = $pp->r[0]["pr"];
						$pp->r[0]["pr"] = $p->r[0]["pr"];
						$p->r["id"]="del";
					}
				}
			}
		}
	}
	return($return);
}

/*
 * Build Price Indication
 */
function build_ezbxmlfeed_priceindication($xml,$configo,$country,$lang,$m_s,$client_id,$format,$version,$browse)
{
	$return=$xml; $s=0;
	$forced_mea=false;

	$return["s"]=$return["s"].".price_indication";
	
	$config=$configo["indPriceOrder"];
	if (!$config) {
		$config="sto;pp;sp;mea;stp;lp";
	}
	if(strstr($config,'mea')===FALSE){
		$config.=";mea";
		$forced_mea=true;
	}

	$configa=explode(";",$config);
	if ($return->p[0]) {
		foreach($return->p as $p) {
			for ($i=0; $i < count($configa); $i++) {
				if ($configa[$i]=="sto") {
					$configa[$i]="st";
				}
				if ($configa[$i]!="st" && $configa[$i]!="mea") {
					if ($p[$configa[$i]]) { 
						(trim($format) == "d") ? $s=sprintf("%.2f",$p[$configa[$i]]) : $s=sprintf("%d",$p[$configa[$i]]);
						$p["pi"]=$s;
						if($browse){
							$p["_pi"]=$s;
						}
						break;
					}
				}
				$stack = array();
				$stop=false;
				if($p->r[0]){
					foreach($p->r as $r) {
						(trim($format) == "d") ? $s=sprintf("%.2f",$r["pr"]) : $s=sprintf("%d",$r["pr"]);
						array_push($stack,$s);
						if ($configa[$i]=="st" && $r["pr"] && $r["t"]=="hp") { 
							$p["pi"]=$s;
							$p["sto"]=$s; /* temporarily set the store price at product level for Omniture */
							if($browse){
								$p["_pi"]=$s;
							} 
							$stop=true;
							break;
						} else {
							//mean
						}
					}
					if ($configa[$i]=="st" && $stop) {
						break;
					}
					if ($configa[$i]=="mea") {
						if ((count($stack)-1)>3) {
							usort($stack, "cmp");
							$stack[0]=0;
							$stack[count($stack)-1]=0;
							$res=array_sum($stack)/(count($stack)-2);
						} else {
							$res=array_sum($stack)/(count($stack));
						}
						if ($res>0) {
							 (trim($format) == "d") ? $s=sprintf("%.2f",$res) : $s=sprintf("%d",$res);
							if(!$forced_mea){
								$p["pi"]=$s;
							}
							if($browse){
								$p["_pi"]=$s;
							}
						}
						break;
					}
				}
			}
		}
	} 
	return($return);
}

function sendOmniture($configo,$xml,$partnr,$cc,$lc,$ms,$partnr,$clientId="ezbuy_report",$debug=false) {
	$pn = explode(";", $partnr); // products array
	$s_products=""; // omniture s_products
	$j=0;
	$event40=false;
	$event41=false;
	$s_events="event5,event18,event20"; //event 5 page view, event18 instances, event 20 back end request
	for($i=0; $i < count($pn);$i++){
		if($i==0)
			$pre="";
		else
			$pre=",";
		if ($xml->p[$j]["pn"]==$pn[$i]) { // if product contains data
				if(!$xml->p[$j]["sp"] && !$xml->p[$j]["sto"] && !$xml->p[$j]["stp"] && !$xml->p[$j]["lp"] && !$xml->p[$j]["pp"]){
					$s_products.=$pre.";".$pn[$i].";0;0;event18=1|event40=1"; // no HP price
					$event40=true;
				}else{
					$s_products.=$pre.";".$pn[$i].";0;0;event18=1";//HP price
				}
				if(!$xml->p[$j]["pi"] || (stristr($configo["options"],"nostaticdisable")!==FALSE && !$xml->p[$j]["sp"])){ /* if option set */ // no static disable
					$s_products.="|event41=1";
					$event41=true;
				}
			$j++;
		}else{ // no data for products
			$s_products.=$pre.";".$pn[$i].";0;0;event18=1|event41=1|event40=1"; // all events set as no HP prices and no price display
			$event40=true;
			$event41=true;
		}
	}
	if($event40)
		$s_events.=",event40";
	if($event41)
		$s_events.=",event41";
	if(isset($_SERVER["HTTP_REFERER"])){
		$browse="browse";
	}else{
		$browse="direct API";
	}
	$caller=str_replace(":1180","",$_SERVER["SCRIPT_URI"]);
	$caller=str_replace(":1181","",$caller);
	$caller.="?cc=&$cc&lc=$lc&partnr=$partnr&clientId=$clientId";
	$s_products.="|event20=".(floor(count($pn)/75)+1);	
	$url="http://hphqglobal.112.2o7.net/b/ss/hphqglobal,devhphqeasybuyv2/1/H.15.1--NS/";
	$url.=rand();
	$url.="?[AQB]&pccr=true&pageName=". rawurlencode("EZB3.0 Price Request | $clientId | $cc | $lc | $ms | $browse | $partnr");
	$url.="&events=" . rawurlencode($s_events);
	$url.="&v1=".rawurlencode($cc." | ".$lc." | ".$ms);
	$url.="&v21=".rawurlencode($configo["indPriceOrder"]!=""?$configo["indPriceOrder"]:"-");
	$url.="&c4=".rawurlencode($clientId);
	$url.="&v4=".rawurlencode($clientId);
	$url.="&v32=".rawurlencode($cc." | ".$lc." | ".$ms." | ".$clientId);
	$url.="&c7=".rawurlencode($cc);
	$url.="&c8=".rawurlencode($lc);
	$url.="&c9=".rawurlencode($ms);
	$url.="&products=".rawurlencode($s_products);
	$url.="&g=".rawurlencode($caller);
	$url.="&[AQE]";
  
  

	if($debug){
		echo "Omniture:".$url;
		echo "<IMG SRC=\"$url\">";
	}else{
		$use_proxy=0;
		if((strpos(php_uname(),'linux')===false)&& (strpos(strtolower(php_uname()),'g9t0296g')>0 || strpos(strtolower(php_uname()),'g9t0295g')>0 ) ) 
		{ //hp-ux env check
			$proxy=array('web-proxy','web-proxy.bbn.hp.com','web-proxy.corp.hp.com','rio.india.hp.com');
			$use_proxy=1;
			
		}
		$proxy_cont="";
		if(!$use_proxy){ /* assuming hp-ux means no need of proxy */
				$ezbxmls=file_get_contents($url);
		}else{
			for($i=0;$i<count($proxy);$i++){
				$proxy_fp=fsockopen($proxy[$i],"8088");
				if($proxy_fp){
					$proxy_cont="";
					fputs($proxy_fp, "GET $url HTTP/1.0\r\nHost: $proxy[$i]\r\n\r\n");
					while(!feof($proxy_fp)){
						$proxy_cont .= fread($proxy_fp,1024);
					}
					fclose($proxy_fp);
					$proxy_cont = substr($proxy_cont, strpos($proxy_cont,"\r\n\r\n")+4);
					if($proxy_fp && $proxy_cont!=""){
						break;
					}
				}
			}	
		}
	}
}

function unsetPrices($xml,$browse) {
	if ($xml->p[0]) {
		foreach($xml->p as $p) {
			if(!$p["sp"] && !$p["sto"] && !$p["stp"] && !$p["lp"] && !$p["pp"]){
				$p["nop"]=1;
			}
			unset ($p["sto"]);
			unset ($p["mea"]);
			unset ($p["lp"]);
			unset ($p["stp"]);	
			if($browse!=1){
				unset ($p["_pi"]);
				unset ($p["sp"]); /* required for no static price disable on front-end */
				unset ($p["pp"]); //required to get the promotional price strike through  
			}
		}
	}
}
function elegant_config(&$xmlstr){
	$elegant_dump_indent = '|&nbsp;&nbsp;&nbsp;&nbsp';
	$xml = simplexml_load_string($xmlstr);
	if ($xml) {
		foreach($xml->children() as $key => $value) {
			echo $elegant_dump_indent.$elegant_dump_indent;
			echo "<b>"."["."'"."$key"."'"."]"."</b>"."="."\""."$value"."\""."<br>";
		}
	}
}
function elegant_data($xml){
	$elegant_dump_indent = '|&nbsp;&nbsp;&nbsp;&nbsp';
	if ($xml->p[0]){ 
		$disp="xml";
		echo $disp."<br>";
		echo $elegant_dump_indent;
		echo "["."'"."ezb"."'"."]"."<br>";

		$np=0;
		foreach($xml->p as $p) {
			$np++;
		}

		$i=0;
		foreach($xml->p as $p) {
			$pnstr ="";
			echo $elegant_dump_indent.$elegant_dump_indent;
			echo "["."'"."p"."'"."]"."(".($i+1)."/".($np).")";

			echo "{";
			foreach($p->attributes() as $key => $value) {
				$pnstr.= "'"."$key"."'"."="."\""."$value"."\"";
				$pnstr.=",";
			}
			$pnstr = substr($pnstr,0,strlen($pnstr)-1);
			$pnstr.="}";
			echo $pnstr;
			echo "<br>";
			if($p->pro[0]){
				$pro=$p->pro[0];
				echo $elegant_dump_indent.$elegant_dump_indent.$elegant_dump_indent;
				echo "["."'"."pro"."'"."]"."(".($i+1)."/".($np).")";
				echo "{";
				foreach($pro->attributes() as $keyp => $valuep) {
					$pnstr= "'"."$keyp"."'"."="."\""."$valuep"."\"";
					$pnstr.=",";
				}
				$pnstr = substr($pnstr,0,strlen($pnstr)-1);
				echo $pnstr;
				echo "}";
				echo "<br>";
				echo $elegant_dump_indent.$elegant_dump_indent.$elegant_dump_indent.$elegant_dump_indent;
				echo "'"."h"."'"."="."\"".$pro->h."\""."<br>";
				echo $elegant_dump_indent.$elegant_dump_indent.$elegant_dump_indent.$elegant_dump_indent;
				echo "'"."te"."'"."="."\"".$pro->te."\""."<br>";
				echo $elegant_dump_indent.$elegant_dump_indent.$elegant_dump_indent.$elegant_dump_indent;
				echo "'"."ur"."'"."="."\"".$pro->ur."\""."<br>";
				echo $elegant_dump_indent.$elegant_dump_indent.$elegant_dump_indent.$elegant_dump_indent;
				echo "'"."pm"."'"."="."\"".$pro->pm."\""."<br>";
				
			}	
			if($p->r[0]){
				$nr=0;
				foreach($p->r as $r) {
					$nr++;
				}
				$j=0;
				foreach($p->r as $r) {
					$resstr="";
					echo $elegant_dump_indent.$elegant_dump_indent.$elegant_dump_indent;
					echo "["."'"."r"."'"."]"."(".($j+1)."/".($nr).")";
					echo "{";
					foreach($r->attributes() as $key => $value) {
						$resstr .= "'"."$key"."'"."="."\""."$value"."\"".",";
					}
					$resstr = substr($resstr,0,strlen($resstr)-1);
					echo $resstr;
					echo "}";
					echo "<br>";
					echo $elegant_dump_indent.$elegant_dump_indent.$elegant_dump_indent.$elegant_dump_indent;
					echo "'"."n"."'"."="."\"".$r->n."\""."<br>";
					echo $elegant_dump_indent.$elegant_dump_indent.$elegant_dump_indent.$elegant_dump_indent;
					echo "'"."u"."'"."="."\"".$r->u."\""."<br>";
					echo $elegant_dump_indent.$elegant_dump_indent.$elegant_dump_indent.$elegant_dump_indent;
					echo "'"."m"."'"."="."\"".$r->m."\""."<br>";
					$j++;
				}
			}	
			$i++;
		}
	}else{
		echo "xml"."<br>".$elegant_dump_indent;
		echo "'[s]'=". $xml["s"];
	}
}

function Tocheckarray($val) {
	$tmp="";
	if (is_array($val)) {
		foreach($val as $key => $value) {
			if(!is_array($value)) {
				$tmp.="\"$key\" : \"$value\"".",";
			}
			else {
				$tmp.="\"".$key."\"".":"."{";
				$tmp.=Tocheckarray($value);
			}
		}
	}
	return($tmp);
}


function JSON_ezbxmlfeed($xml,$cc,$lc,$ms,$clientId,$format,$partnr,$confg,$callback)
{
	$return=$xml;
	$lbrace="{";
	$rbrace="}";
	$quote="\""; 
	$nop=0;  
	if ($return->p[0]) {
	foreach($return->children() as $key => $value){
		$nop = $nop + 1;
	}
	}
	$productDetailsArray= "";
	$retailerPresent=0;
	
	//Pre-construct the arrays for which the values are known.
	$versionArray=array("version"=> $return["f"]);
	$statusArray=array("code"=>"1","message"=>"ok");
	$queryArray=array("cc"=>$cc,"lc"=>$lc,"ms"=>$ms,"clientId"=>$clientId,"format"=>$format,"partnr"=>$partnr,"callback"=> $callback);
	$products=array("returned"=>$nop,"rules"=>$return["s"]);
	
	$resultArray=array("products"=>$products);
	
	
	//Beginning of constructing the string to be returned
	$returnArray=$callback."({";
	
	$resarr=array("Response"=>$versionArray,"status"=>$statusArray,"query"=>$queryArray,"results"=>$resultArray);
	
	if (is_array($resarr)) {
		//The loop below constructs the string upto the label "list"
		foreach($resarr as $key => $value) {
			if (is_array($value)) {
				$returnArray.="\"".$key."\"".":"."{";
				$returnArray.=Tocheckarray($value);
				
				foreach($value as $key => $value1) {
					if ($key=="message" || $key == "callback") {
						$returnArray = substr($returnArray,0,strlen($returnArray)-1);
						$returnArray.="},";
					}
				}
			} else {
				$returnArray.=Tocheckarray($value);
			}
		}
		//for loop
	}
	//if condition
	
	$productDetailsArray="\""."list"."\"".":"."{";
	$np= 0;
	
		if ($return->p[0]) {	 
		foreach($return->children() as $key => $value){
			$np = $np + 1;
		}
	}
	if ($return->p[0]) {
		for ($j=0; $j < $np ; $j++) {
			$retailerPresent=0;
			$productDetailsArray.= "\"" . $return->p[$j]["pn"]."\"".":".$lbrace;
			
			if ($return->p && $return->p[$j]) {
				
				$key_yes=0;
				//This loop builds the data upto the promo/reseller info whichever is present
				foreach($return->p[$j]->attributes() as $key => $value) {
					if ($key!="pn") {
						$productDetailsArray.="\"$key\" : \"$value\"".",";
						$key_yes=1;
					}
				}
				if(!$key_yes)
					$productDetailsArray.="\"empty\" : \"1\"".",";
				
				//for
				
				if ($return->p[$j]->pro[0]) {
					//This loop constructs the promo node details
					$productDetailsArray.="\"pro\":"."{";  
					foreach($return->p[$j]->pro[0]->attributes() as $key => $value){
						$productDetailsArray.="\"$key\" : \"$value\"".",";
					}
					foreach($return->p[$j]->pro[0] as $key => $value){
						$productDetailsArray.="\"$key\" : \"$value\"".",";
					}
					$productDetailsArray = substr($productDetailsArray,0,strlen($productDetailsArray)-1);
					$productDetailsArray.="},";
				}
				
			}
			// if
			
			if (($return->p[$j]) && ($return->p[$j]->r[0])) {
				
				//This loop constructs the reseller node details
				$retailerPresent=1;
				$productDetailsArray.=$quote."r".$quote.":"."[";
				
				$allpres=0; 
			foreach($return->p[$j]->children() as $yek=>$lue) {
			if ($yek == "r" ) {
				$allpres = $allpres + 1;
			}
			}

				$nr= $allpres;
				
				for ($k=0; $k < $nr ; $k++) {
					$productDetailsArray.=$lbrace;
					foreach($return->p[$j]->r[$k]->attributes() as $key => $value) {
						$productDetailsArray.="\"$key\" : \"$value\"".",";
						
					}
					
					foreach($return->p[$j]->r[$k] as $key => $value) {
						$productDetailsArray.="\"$key\" : \"$value\"".",";
					}
					
					$productDetailsArray = substr($productDetailsArray,0,strlen($productDetailsArray)-1);
					$productDetailsArray.=$rbrace;
					$productDetailsArray.=",";
				}
				
				$productDetailsArray = substr($productDetailsArray,0,strlen($productDetailsArray)-1);
				$productDetailsArray.="]";
			}
			// if
			
			if ($retailerPresent == 0) {
				$productDetailsArray = substr($productDetailsArray,0,strlen($productDetailsArray)-1);
			}
			$productDetailsArray.="},";
		}
		//for
		
		//Extract the proper string
		$productDetailsArray = substr($productDetailsArray,0,strlen($productDetailsArray)-1);
		$productDetailsArray.=$rbrace.$rbrace.$rbrace.$rbrace.$rbrace;
		$returnArray.=$productDetailsArray;
		
		//Format the string into a proper JSON object
		$replacement = array('find'=>array(), 'replace'=>array());
		if ($replacement['find'] == array()) {
			foreach(array_merge(range(0, 7), array(11), range(14, 31)) as $v) {
				$replacement['find'][] = chr($v);
				$replacement['replace'][] = "\\u00".sprintf("%02x", $v);
			}
			$replacement['find'] = array_merge(array(chr(0x5c), chr(0x2F), chr(0x0d), chr(0x0c), chr(0x0a), chr(0x09), chr(0x08)), $replacement['find']);
			$replacement['replace'] = array_merge(array('\\\\', '\\/', '\r', '\f', '\n', '\t', '\b'), $replacement['replace']);
		}
		
		$result_string = str_replace($replacement['find'], $replacement['replace'], $returnArray).");";
		return($result_string);
	} else {
		$result_string = substr($returnArray,0,strlen($returnArray)-1).$rbrace.$rbrace.$rbrace.$rbrace.");";
		return($result_string);
	}
}
/*
 * Elegant Dump Data Feed (debug)
 */
function elegant_dump(&$var, $var_name='', $indent='', $reference='') {
    $elegant_dump_indent = '|&nbsp;&nbsp;&nbsp;&nbsp';
     $reference=$reference.$var_name;
 
     // first check if the variable has already been parsed
     $keyvar = 'the_elegant_dump_recursion_protection_scheme';
     $keyname = 'referenced_object_name';
     if (is_array($var) && isset($var[$keyvar])) {
         // the passed variable is already being parsed!
         $real_var=&$var[$keyvar];
         $real_name=&$var[$keyname];
         $type=gettype($real_var);
         echo "$indent<b>$var_name</b> (<i>$type</i>) = <font color=\"red\">&amp;$real_name</font><br>";
     } else {
 
         // we will insert an elegant parser-stopper
         $var=array($keyvar=>$var,
                    $keyname=>$reference);
         $avar=&$var[$keyvar];
 
         // do the display
         $type=gettype($avar);
         // array?
          if (is_array($avar)) {
             $count=count($avar);
             echo "$indent<b>$var_name</b> (<i>$type($count)</i>) {<br>";
             $keys=array_keys($avar);
             foreach($keys as $name) {
                 $value=&$avar[$name];
                 elegant_dump($value, "['$name']", $indent.$elegant_dump_indent, $reference);
             }
             echo "$indent}<br>";
         } else
         // object?
          if (is_object($avar)) {
             echo "$indent<b>$var_name</b> (<i>$type</i>) {<br>";
             foreach($avar as $name=>$value) elegant_dump($value, "-&gt;$name", $indent.$elegant_dump_indent, $reference);
             echo "$indent}<br>";
         } else
         // string?
         if (is_string($avar)){
         	if($var_name=="['ex']" || $var_name=="['hi']"){
         		echo "<font color=\"red\">$indent<b>$var_name</b> (<i>$type</i>) = \"$avar\"</font><br>";
         	}else{
         		if($var_name=="['old_pr']"){
				echo "<font color=\"blue\">$indent<b>$var_name</b> (<i>$type</i>) = \"$avar\"</font><br>";
         		}else{
         			echo "$indent<b>$var_name</b> (<i>$type</i>) = \"$avar\"<br>";
         		}	
         	}
         // any other?
         }else echo "$indent<b>$var_name</b> (<i>$type</i>) = $avar<br>";
 
         $var=$var[$keyvar];
     }
 }
?>
