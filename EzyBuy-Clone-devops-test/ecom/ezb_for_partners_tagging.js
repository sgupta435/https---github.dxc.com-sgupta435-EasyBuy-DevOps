/*****Set metrics sending to on ****/
s_disable_metrics=false;
/**** Define vars ****/
var country_code,language_code,customer_segment,currency_code,order_details;
var s_prop7,s_prop8,s_prop9,s_currencyCode,s_products,_rn,_rns,s_purchaseID,s_eVar1,s_eVar2,s_eVar4,s_eVar44,s_eVar5,s_eVar32,s_pageName,s_events,is_debug,debug_output;

/*******************************************************************/
/***** Define function splitting HP stores revenue into event50 ****/
/* Update: reconstruct the purchase event to include the correct revenue amounts */

var s_hp_emeaStoreIDs = new Array ( "7720023","3392423","7719923","4042523","3719023","5952223","3612823","3691423","3812923","7150223","7150123");
/* Modified function by Pradeep SV */
function s_hp_splitHHOStoreRevenue(eventList,eVar2,prodList) {
	var s_flag = false;
	if(eventList!=null && eventList.indexOf('purchase')!=-1 && eventList.indexOf("event50")==-1 && eventList.indexOf("event39")==-1) {
		if(eVar2 != null) {
			for (i=0;i<s_hp_emeaStoreIDs.length ;i++ ) {
				if (eVar2.indexOf(s_hp_emeaStoreIDs[i])!= -1)
					s_flag = true;
			}
			if (s_flag){
				s_events+=",event50,event39";
				prodArray = prodList.split(',')
				for(i=0;i<prodArray.length;i++) {
					var ta = prodArray[i].split(';')
					if(ta.length==4) {prodArray[i]+=";event50="+ta[3];}
					if(ta.length==5) {prodArray[i]+="|event50="+ta[3];}
				}
				s_products = prodArray.join(",");
				s_products+="|event39=1"
			}
		}
	}
}
/*******************************************************************/

/*******************************************************************/
/***** Define function splitting HP stores revenue into event50 ****/
/* Update: reconstruct the purchase event to include the correct revenue amounts */
var s_hp_MusicStationIDs = new Array ( "10483");
/* Modified function by Pradeep SV */
function s_hp_addMusicStationEvent(eventList,eVar2,prodList) {
	var s_flag = false;
	if(eventList!=null && eventList.indexOf('purchase')!=-1 && eventList.indexOf("event8")==-1) {
		if(eVar2 != null) {
			for (i=0;i<s_hp_MusicStationIDs.length ;i++ ) {
				if (eVar2.indexOf(s_hp_MusicStationIDs[i])!= -1)
					s_flag = true;
			}
			if (s_flag){
				s_events+=",event8";
				prodArray = prodList.split(',')
				for(i=0;i<prodArray.length;i++) {
					var ta = prodArray[i].split(';')
					if(ta.length==4) {prodArray[i]+=";event8=1";}
					if(ta.length==5) {prodArray[i]+="|event8=1";}
				}
				s_products = prodArray.join(",");
				debug('***** Adding Event8 '+s_products);
			}
		}
	}
}
/*******************************************************************/

/*******************************************************************/
/***** Define function fixing order_details string ****/
var fix_is_error="";
function s_hp_FixOrderDetails(prodList) {
	// Treat Order Details
	//order_details like ;FA104A;1;104.00,;;FA105A;1;105.00, or ;FA104A;SmartChoice;1;1000.00
	var prod=prodList.toString();
	if(prod.charAt(0)==","){
		debug("Fix order details to remove initial ','");
		prod=prod.replace(/^,/,"");
	}
	var s_order=prod.split(',;');
	var new_s_p="";
	// Loop on each product in the order
	for (var i = 0; i < s_order.length; i++){
		// Split product/qty/revenue
		var s_order_d=s_order[i];
		if(s_order_d.charAt(s_order_d.length-1)==","){
			s_order_d=s_order_d.replace(/,$/g,"");
			debug("Fix order details to remove last ','");
		}
		if(s_order_d.charAt(s_order_d.length-1)=="."){
			s_order_d=s_order_d.replace(/\.$/g,"");
			debug("Fix order details to remove last '.'");
		}
		if(s_order_d.indexOf(",")!=-1){
			s_order_d=s_order_d.replace(",",".");
			debug("Fix order details to change decimal separator to '.'");
		}
		var s_order_d_s=s_order_d.split(';');
		var rev=1.0*s_order_d_s[s_order_d_s.length-1];
		
		if(s_order_d_s[s_order_d_s.length-2]>=999){
			fix_is_error+="m";
			debug("order error: one product with quantity>=999");
		}
		if(rev==0 && (s_order_d_s[s_order_d_s.length-3]=="" || s_order_d_s[s_order_d_s.length-2]=="")){
			fix_is_error+="o";
			debug("order issue: one product with 0 price and number or quantity NOT OK");
		}
		if((s_order_d_s[s_order_d_s.length-3]=="" || s_order_d_s[s_order_d_s.length-2]=="")){
			fix_is_error+="o";
			debug("order issue: one product with price but number or quantity NOT OK");
		}
		if(rev==0 && (s_order_d_s[s_order_d_s.length-3]!="" && s_order_d_s[s_order_d_s.length-2]!="")){
			fix_is_error+="z";
			debug("one product with 0 price but number and quantity OK");
		}
		if(rev<0){
			fix_is_error+="d";
			debug("Negative revenue product");
			if(s_order_d_s[s_order_d_s.length-3]=="" || s_order_d_s[s_order_d_s.length-2]==""){
				debug("Negative revenue product w/o number or quantity found:"+s_order_d);
				s_order_d="";
				if(s_order_d_s[s_order_d_s.length-3]==""){
					s_order_d+="DISCOUNT";
					debug("product number set to DISCOUNT");
				}else{
					s_order_d+=s_order_d_s[s_order_d_s.length-3];
				}	
				s_order_d+=";";
				if(s_order_d_s[s_order_d_s.length-2]==""){
					s_order_d+="1";
					debug("product quantity set to 1");
				}else{
					s_order_d+=s_order_d_s[s_order_d_s.length-2];
				}
				s_order_d+=";";
				s_order_d+=s_order_d_s[s_order_d_s.length-1];
				if(i==0)
					s_order_d=";"+s_order_d;
				debug("product details set to:"+s_order_d);
			}
		}
		new_s_p+=(i>0?",;":"")+s_order_d;
	}
	debug("cleaned up order_details:"+new_s_p);
	return(new_s_p);
}
/*******************************************************************/

/*******************************************************************/
/***** Define function checking positive revenue ****/
var revenue_is_error="";
function s_hp_CheckRevenue(prodList) {
	// Treat Order Details
	//order_details like ;FA104A;1;104.00,;;FA105A;1;105.00, or ;FA104A;SmartChoice;1;1000.00
	var s_order=prodList.toString().split(',;');
	var new_r_sum=0;
	// Loop on each product in the order
	for (var i = 0; i < s_order.length; i++){
		// Split product/qty/revenue
		var s_order_d=s_order[i].split(';');
		// Set revenue
		var new_r=s_order_d[s_order_d.length-1];
		new_r_sum=1.0*new_r+new_r_sum;
	}
	if(new_r_sum.toFixed){
		new_r_sum=new_r_sum.toFixed(2);
	}else{
		new_r_sum=Math.round(new_r*100)/100; // less perfect for older browsers
	}
	if(new_r_sum>0 && new_r_sum<100000000)
		return(true);
	else{
		revenue_is_error="m";
		return(false);
	}
}
/*******************************************************************/

/*******************************************************************/
/***** Define function splitting revenue into event15 if HP.com visit ****/
/* Update: reconstruct the purchase event to include the correct revenue amounts */
function s_hp_splitHPComRevenue(eventList,prodList) {
	if(eventList!=null && eventList.indexOf('purchase')!=-1 && eventList.indexOf("event15")==-1) {
		s_events+=",event15";
		prodArray = prodList.split(',')
		for(i=0;i<prodArray.length;i++) {
			var ta = prodArray[i].split(';')
			if(ta.length==4) {prodArray[i]+=";event15="+ta[3];}
			if(ta.length==5) {prodArray[i]+="|event15="+ta[3];}
		}
		s_products = prodArray.join(",");
	}
}
/*******************************************************************/

/*******************************************************************/
/***** Define function splitting revenue into event41,42,43 if Any HP.com visit ****/
/* Update: reconstruct the purchase event to include the correct revenue amounts */
function s_hp_splitAnyHPComRevenue(eventList,prodList) {
	if(eventList!=null && eventList.indexOf('purchase')!=-1 && eventList.indexOf("event43")==-1) {
		s_events+=",event43,event44,event45";
		prodArray = prodList.split(',')
		for(i=0;i<prodArray.length;i++) {
			var ta = prodArray[i].split(';')
			if(ta.length==4) {prodArray[i]+=";event43="+ta[3]+"|event45="+ta[2];}
			if(ta.length==5) {prodArray[i]+="|event43="+ta[3]+"|event45="+ta[2];}
		}
		s_products = prodArray.join(",")+"|event44=1";
	}
}
/*******************************************************************/


/*******************************************************************/
/***** Define debug functions ****/
window.document.old_write = window.document.write;
function debug(param){
	if(debug_output){
		document.write(param)
	}
}
function overwrite_write(){
	if(debug_output){
		window.document.write = function(arg) {
					window.document.outputform.output.value=window.document.outputform.output.value+arg+'\n';
		}
	}
}
function undo_overwrite_write(){
	if(debug_output)
		window.document.write = window.document.old_write;
}
/*******************************************************************/
/**** Set debug if option is set ****/
overwrite_write();

/**** Check partner tags ****/
var is_tag_ok=true;
var is_error="";
if(country_code==null || country_code.length<2){country_code="undef";is_tag_ok=false;is_error+="7";}
if(language_code==null || language_code.length<2){language_code="undef";is_tag_ok=false;is_error+="8";}
if(customer_segment==null || customer_segment.length<3){customer_segment="undef";is_tag_ok=false;is_error+="9";}
if(currency_code==null || currency_code.length<3){currency_code="undef";is_tag_ok=false;is_error+="c";}
if(order_details==null || order_details.length<3){order_details="undef";is_tag_ok=false;is_error+="o";}
if((country_code.toLowerCase()).indexOf("gb")!=-1)country_code="uk";

//version
var ezb_ecom_version=window.ezb_ecom_version_r?ezb_ecom_version_r:"A36";

var omn_prod_use=true;

if(is_debug){
	debug("Debug mode IN USE, Omniture Dev account will be used");
	omn_prod_use=false;
}
if (openedPartners.indexOf(raw_ezb_partner)==-1){ /* partner not in Omniture production */
	debug(raw_ezb_partner+" ezbuy partner IS NOT live in Omniture. Will be logged to Omniture Dev account");
	omn_prod_use=false;
	is_error="t"+is_error;
}else{ /*partner in Omniture production */
	debug(raw_ezb_partner+" ezbuy partner IS live in Omniture");
	is_error="l"+is_error;
}


if((window.is_https && window.is_https==true) || (window.top.location.protocol.toLowerCase().indexOf('https')>=0)){
	ezb_ecom_version="s-"+ezb_ecom_version;
}
debug('escaped order='+order_details.replace(/[ \/+#].*?;/g,";").replace(/;/g,"|").replace(/,/g,"-"));

/**** Check if HP store order page and add store id ****/
if(window.store_id && window.store_id.length>2){
	ezb_partner+="-"+store_id;
	//HP store revenue not considered as HP.com revenue anymore 05/25/09
	//if(!window.l_s_eVar4)
	//	l_s_eVar4="hpstore";
}

/**** Check if HP store order number in page ****/
if(window.order_id){
	s_purchaseID=order_id;
}else{
	var _rn = new String (Math.random());
	var _rns = _rn.substring (2, 11);
	s_purchaseID=_rns;
}

/**** Check previous order cookie ****/
debug('previous order cookie found='+raw_cookie);
if(raw_cookie.indexOf(order_details.replace(/[ \/+#].*?;/g,";").replace(/;/g,"|").replace(/,/g,"-"))==-1){
	debug('This order is different from the previous one');
}else{
	debug('This order is not different from the previous one!!!');
	// do not exclude double submission from production account as this could be real orders
	//omn_prod_use=false;
	is_error+="2";
	if(raw_cookie.indexOf(s_purchaseID)!=-1){
		debug('This order is not different from the previous one and has the same order_id!!! Will be logged to Omniture Dev account');
		omn_prod_use=false;
	}
}

/*** Set Omniture vars ****/
s_prop7=country_code.toLowerCase();
s_prop8=language_code.toLowerCase();
s_prop9=customer_segment.toLowerCase();
s_currencyCode=currency_code.toUpperCase();
s_eVar1=s_prop7+" | "+s_prop8+" | "+s_prop9;
s_eVar2=ezb_partner+" | "+s_prop7+" | "+s_prop8+" | "+s_prop9;

var order_details_mem=order_details;
s_products=s_hp_FixOrderDetails(order_details.replace(/[ \/+#].*?;/g,";"));

if(fix_is_error.indexOf("o")!=-1 || fix_is_error.indexOf("m")!=-1){
	if(fix_is_error.indexOf("o")!=-1)
		is_error+="p";
	else{
		is_error+="om";
		is_tag_ok=false;
	}	
}else{
	if(fix_is_error!=""){
		is_error+=fix_is_error;
	}
}

if(!is_tag_ok){ /* at least one tag issue */
	debug("partner tagging IS NOT OK. Will be logged to Omniture Dev account");
	omn_prod_use=false;
}else{
	debug("partner tagging IS OK");
}

var s_products_mem=s_products;

s_events="purchase";
debug("s_products="+s_products);



if(window.s_prop3)
	s_prop3+="|"+s_purchaseID;
else
	s_prop3=s_purchaseID;

var is_revenue=s_hp_CheckRevenue(s_products);

debug("positive revenue:"+is_revenue);
debug('HP.com/ezbuy visited site cookie='+(window.l_s_eVar4?l_s_eVar4:"---"));
debug('HP.com (any) visited site cookie='+hp_com_visit);

if(is_revenue && window.l_s_eVar4){
	s_hp_splitHPComRevenue(s_events,s_products);
	s_eVar4=l_s_eVar4;
	s_eVar32=s_eVar1+' | '+l_s_eVar4;
	debug('***** HP.com redefining s_products to '+s_products);
	debug('***** defining s_eVar4 to '+s_eVar4)
	debug('***** defining s_eVar32 to '+s_eVar32)
}

if(is_revenue && hp_com_visit){
	s_hp_splitAnyHPComRevenue(s_events,s_products);
	debug('***** Any HP.com redefining s_products to '+s_products);
}

s_hp_splitHHOStoreRevenue(s_events,window.s_eVar2,s_products);
s_hp_addMusicStationEvent(s_events,window.s_eVar2,s_products);

if(!is_revenue){
	debug('Order revenue is negative or null or > 100 millions, will be logged to Omniture Dev account');
	is_error+="r";
	if(revenue_is_error!="")
		is_error+=revenue_is_error;
	omn_prod_use=false;
}


if(window.s_account){
	old_s_account=s_account;
}

var omniture_order=ezb_partner+" | "+s_prop7+" | "+s_prop8+" | "+s_prop9+" | "+s_purchaseID + " | " + is_error + " | " + order_details;
if (omn_prod_use){
	s_pageName="EZB | PartnerPurchase |"+ezb_ecom_version+ "-" +is_error+ "| "+s_eVar2+" | "+s_purchaseID;	
	s_eVar44=omniture_order;
	s_account="hphqeasybuyv2";
	
	if(window.old_s_account){
		if(old_s_account!=s_account){
			s_account=old_s_account+","+s_account;
		}
	}
	if(s_account.indexOf("hphqglobal,hphqemea")==-1)
		s_account="hphqglobal,hphqemea,hphqemea"+s_prop7+","+s_account;
	else
		s_account=s_account.replace("hphqemeauk","hphqemea"+s_prop7);
}else{
	s_pageName="EZBd | PartnerPurchase |"+ezb_ecom_version+ "-" +is_error+ "| "+s_eVar2+" | "+s_purchaseID;
	s_eVar5=omniture_order;
	s_account="devhphqeasybuyv2";
}
s_pageName+=" | " + order_details;
debug("Omniture pagename set to:"+s_pageName);


/**** Unset debug if option is set ****/
undo_overwrite_write();
/*****Set Order Cookie*******/
var send_order=[
		'<img src="',set_order_url,'?',
		'ezb_partner=',escape(ezb_partner),
		'&ezb_order=',escape(order_details.replace(/[ \/+#].*?;/g,";").replace(/;/g,"|").replace(/,/g,"-")),
		'&ezb_order_id=',escape(s_purchaseID),
		'&ezb_order_details=',escape(s_products_mem),
		'&error=',escape(is_error),
		'&cc=',escape(s_prop7),
		'&ll=',escape(s_prop8),
		'&ms=',escape(s_prop9),
		'&cur=',escape(s_currencyCode),
		'&order_details=',escape(order_details_mem),
		'&version=',ezb_ecom_version,
		'">'
		].join('');			
document.write(send_order);

//s_dynamicAccountSelection=true;
//s_sendAnalyticsEvent(null,s_pageName);
//s_dynamicAccountSelection=false;

if(window.old_s_account){
	//s_account=old_s_account;
}

/* Reset Commerce Variables */
/*s_products="";
s_purchaseID="";
s_eVar1="";
s_eVar2="";
s_eVar4="";
s_eVar5="";
s_eVar32="";
s_events="";
s_disable_metrics=true;
s_pageName="->"+s_pageName;*/