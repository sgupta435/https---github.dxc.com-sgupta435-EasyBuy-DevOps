/**
 * /ezbuy/ecom/ezb_metrics.js
 * Revision 1.11  2006/03/14 08:36:29  slechner
 * fix concerning 1st start from price not shown
 *
 * Revision 1.10.10.1  2006/03/14 08:22:38  slechner
 * fix concerning 1st start from price not shown
 * Revision 1.10.6.2  2006/03/15 16:06:55  slechner
 * New Flash plugin detection script + plugin version  logged into Omniture reports
 *
 * Revision 1.9.10.2  2006/03/03 15:25:34  slechner
 * step 2 in new tagging
 *
 * Revision 1.9.10.1  2006/02/22 09:30:14  slechner
 * First version of new Partners tagging:
 * - proxy tag Omniture/DoubleClick
 * - stop sending Pages Loads events to All Omniture Accounts
 * - Submit others events to all accounts including easybuy
 *
 * Revision 1.9  2006/02/07 10:43:51  slechner
 * Fixed eVar3 Bug in ezb_metrics.js REL_641_B_642_PROD
 *
 * Revision 1.8.6.1  2006/02/07 10:39:34  slechner
 * Fixed eVar3 Bug in ezb_metrics.js
 *
 *
 * $Name: HEAD $
 * $State: Exp $
 *
 * +======================================================================================================+
 * | EZB Omniture utils library
 * +======================================================================================================+
 * +------------------------------------------------------------------------------------------------------+
 * | Code Structure:
 * | --------------
 * | SetEZBredirect JS function is called directly by Flash 
 * | for a goXML click as well as for an add to basket click
 * |
 * +------------------------------------------------------------------------------------------------------+
 * | Usage:
 * | ------
 * |
 * +------------------------------------------------------------------------------------------------------+
 * | Glossary:
 * | ---------
 * +------------------------------------------------------------------------------------------------------+
 * | Internals:
 * | ----------
 * |05/15/2007 : Added number of price requests to back end (event20)
 * |			 Added s_eVar30/event15 and _ezb_o cookie for first origin of lead
 * |			 Added changes for Buy offline screens eVar31 (event15 removed)
 * |04/02/2007 : Updated s_account to work around PSC comparison tool issue (set it to initial one if set to hphqglobal only)
 * |03/11/2007 : Updated SmartChoice specific pageName and eVar
 * |02/14/2007 : defined SmartChoice specific pageName and eVar
 * |08/11/2006 : force s_prop4 psc for APAC
 * |07/13/2006 : enableTracking option used to make sure that Omniture not called at all (even on button click)
 * |07/05/2006 : replace FlashPlugin version tracking by ezbuy implementation code version tracking
 * |05/24/2006 : change process of default Omniture values for s_prop4,... following FIF Omniture change
 * |		- change setEZBconfig to setEZBaccount
 * |		- made s_products and s_events global variables
 * |		- added	SetEZBvarCommon() and SetEZBvarFIF() to simplify the process of sending
 * |05/06/2006 : FIF add to basket : redirections made from Flash interface which implies
 * |		 "SetEZBredirect" function is now obsolete and all traces of ezb_kelkooURLnode are removed
 * |05/05/2006 : - Omniture FIF implementation update:
 * |		 EmptyEZBvar() for not sending page variables if not an hp page (case for RichFX)
 * |		 Set Omniture vars for FIF non HP page catalogs
 * |		 Added two vars to be sent for FIF: s_evar16 and s_evar20 to track campaigns
 * |		 Do send Omniture data for FIF to emea account not only ezbuy account
 * |		 Do not sent Omniture data to any other account than HP
 * |		 Temporarily send FIF Omniture data to dev account for FIF remote catalogs
 * |		 Fixed bug preventing sendOmnitureLoad to work if a normal ezbuy was following a FIF movie!
 * |		 Do not use Omniture plugin to not erase campaign information
 * |04/05/2006 : - Added functions for Omniture FIF implementation :
 * |		 sendOmnitureFIFLoad(myPartnr) to handle metrics 
 * |		 for the first Flash box loaded from a Flash container.
 * |		 - guistyle=load prevent sendOmnitureLoad to be called
 * |		 - s_pagename="EZB HTML ..." when called from a HTML template 
 * |		 (impact page views, add basket and find a local partner call)
 * |		 - enableTracking off does not allow a call to sendOmnitureLoad for HTML part
 * |03/15/2006 : Added Flash plugin version next to EZB View for Omniture
 * |2/1/2006: Fixed Bug in ezb_AddBasket
 * |12/22/2005: changed call to s_dc instead of s_gs as per Omniture requets.
 * | encoding of &url= parameter in ezb_kelkooURLnode is made in SetEZBredirect function
 * |
 * +------------------------------------------------------------------------------------------+
 * | Debug:
 * | --------
 * |
 * +------------------------------------------------------------------------------------------+
 * | Assumptions:
 * | ------------
 * |
 * |
 * +------------------------------------------------------------------------------------------+
 * | JS Context used:
 * | ---------------
 * |
 * +------------------------------------------------------------------------------------------+
 * | JS Context defined:
 * | ------------------
 * | ezb_FindPartner() used for  find a local partner link when showDirectTemplate=true
 * +------------------------------------------------------------------------------------------+
 * | exceptions:
 * | -----------
 * | &url= is passed empty to addbasket.php script
 * |
 * +==========================================================================================+
 *
 **/
var ezb_FIF=false; // is it FIF
var ezbloaded=false; //detects whether page load and therefore sendOmnitureLoad has been fired
if(window.ezbloaded_not_needed)
	ezbloaded=true;
var ezbOmVars=new Array;//Omniture vars specific to ezb
var ezbOldValues=new Array;//Omniture values before ezb
var ezbNewValues=new Array;//Omniture values specific to ezb
var ezb_s_account="hphqglobal,hphqemea,hphqeasybuyv2";// default account
var s_account;
var s_account_mem=s_account;
var na="-";
var _sw=window;
var redirectURL="empty";
var redirectURLNewW=false;
var pageURL=window.top.location.toString();
var ezbOMdebug= (pageURL.lastIndexOf("ezbomdebug=") != -1) ? true : false;
var oldOmnitureArgs="empty";
var ezbdebug="";
var URLnode="";
var l_indPriceOrder=(window.EZB && EZB.Settings && EZB.Settings.indPriceOrder!="")?EZB.Settings.indPriceOrder:"-";

(_sw.l4&&l4.length>1)?0:l4="-";
(_sw.l7&&l7.length>1)?0:l7="-";
(_sw.l8&&l8.length>1)?0:l8="-";
(_sw.l9&&l9.length>1)?0:l9="-";
(_sw.l2&&l2.length>1)?0:l2="-";
(_sw.l3&&l3.length>1)?0:l3="-";

var ezb_debug_overwrite_alert=false;
function overwrite_alert(){
	if(ezb_debug_overwrite_alert){
		_sw.alert = function(arg) {
					_sw.document.outputform.output.value=_sw.document.outputform.output.value+arg+'\n';
		}
	}
}
overwrite_alert();

function addLoadEvent(func){
	if(!ezbloaded){
		var oldonload = _sw.onload;
		if (typeof _sw.onload != 'function') {
			_sw.onload = func;
		} else {
			_sw.onload = function() {
				oldonload();
				func();
			}
		}
	}else{
		func();
	}
}

function SetEZBaccount(){
	s_pageName=escape(window.s_pageName||'');
	
	if(_sw.ezb_FIF==false && !ezbloaded) // Except for FIF page view load should only fly to ezb account
		ezb_s_account="hphqglobal,hphqeasybuyv2";
	
	if(ezb_s_account!="hphqglobal,hphqeasybuyv2" && ezb_s_account!="hphqeasybuyv2"){
		if(_sw.s_account&&_sw.s_account.indexOf("hphq")!=-1){//if HP page use all Omniture accounts
			if(s_account=="hphqglobal" && s_account_mem.indexOf("hp")!=-1){
				ezb_s_account=s_account_mem+",hphqeasybuyv2";
			}else{
				ezb_s_account=s_account+",hphqeasybuyv2";
			}	
		}
	}

	/* following lines will be used by Omniture code to potentialy dynamicaly change the account to be used. */	
	s_dynamicAccountList="devhphqeasybuyv2=localhost,127.0.0.1,ezbserver,ezbomdebug,hpqcorp,cpqcorp,stage,ezbhtml,debug";
	s_dynamicAccountMatch=window.top.location.toString();
}
function SetEZBvar(arr){

	for (var i = 0; i < arr.length/2; i++){
		var k=ezbOmVars.length;
		ezbOmVars[k]=arr[2*i];
		ezbNewValues[k]=arr[2*i+1];
	
		if(ezbNewValues[k].indexOf('\u2122')>1) ezbNewValues[k]=ezbNewValues[k].split('\u2122').join("&#193;");
		if(ezbNewValues[k].indexOf('\u2019\u2019')>1)	ezbNewValues[k]=ezbNewValues[k].split('\u2019\u2019').join("&#148;");
					
		if(eval("_sw."+ezbOmVars[k])){
			ezbOldValues[k]=eval(ezbOmVars[k]);
		}else{
			ezbOldValues[k]="";
		}
		if(ezbOmVars[k]=="s_eVar2"){
			ezbNewValues[k]=ezbNewValues[k]+ " | " + l7 + " | " + l8 + " | " +l9;
		}
		eval(ezbOmVars[k]+'="'+ezbNewValues[k].split("\"").join("") +'"');
	}
}
function SetEZBvarFIF(){
	
	if(_sw.s_account&&_sw.s_account.indexOf("hphq")==-1){//if non HP page
		EmptyEZBvar();
		l4="ezb_FIF_remote_catalog";
		l2="ezb_FIF_remote_catalog";
		l3="_";
	}else{// hp page
	
	}
	SetEZBvar(["s_eVar16","in_R2790_"+l9+"_"+l7+"_"+l8+"/fif/"+l2+"/"+l3,"s_eVar20","in_R2790_"+l9+"_"+l7+"_"+l8+"/"+l2+"/"+l3]);
}	

function SetEZBvarCommon(){

    //Added by Nithiyanandhan on 10/10/2013 - Omniture Issue fix

    _sw.s_prop4 = EZB.Context.clientID;
//	if (_sw.s_prop4 && s_prop4.length > 0) {
//       		 if (_sw.s_prop4 == '') {
//          			  _sw.s_prop4 = EZB.Context.clientID;
//       		 }
//    
//    	}

	l4=="-"?((_sw.s_prop4&&s_prop4.length>0)?l4=_sw.s_prop4:0):0;
	(l4.indexOf("product catalog")!=-1)?l4="psc":0;
	l2=="-"?((_sw.s_prop2&&s_prop2.length>0)?l2=_sw.s_prop2:0):0;
	l3=="-"?((_sw.s_prop3&&s_prop3.length>0)?l3=_sw.s_prop3:0):0;
	l7=="-"?l7=EZB.Context.cc:0;
	l8=="-"?l8=EZB.Context.lc:0;
	l9=="-"?l9=EZB.Context.m_s:0;
	
	SetEZBaccount();
	
	SetEZBvar(["s_currencyCode",EZB.Settings.ezbCurrencyCode,"s_account",ezb_s_account,"s_prop13",ezb_s_account]);
	if(window.s_products)
		SetEZBvar(["s_events",s_events,"s_products",s_products]);
	SetEZBvar(["s_eVar1",l7+" | "+l8+" | "+l9,"s_eVar4",l4]);
	SetEZBvar(["s_eVar32",l7+" | "+l8+" | "+l9+" | "+l4]);
	SetEZBvar(["s_prop4",l4,"s_prop7",l7,"s_prop8",l8,"s_prop9",l9]);
	SetEZBvar(["s_eVar30","HP.com->Buy"]);
	if(window.l_s_eVar16)
		SetEZBvar(["s_eVar16",l_s_eVar16]);
}
function EmptyEZBvar(){// Set all s_propX and s_eVarX to ""

	vars_number=30;
	for (var i = 1; i < vars_number+1; i++){
		var k=ezbOmVars.length;
		ezbOmVars[k]="s_prop"+i;
		ezbOmVars[k+vars_number]="s_eVar"+i;
		ezbNewValues[k]="";
		ezbNewValues[k+vars_number]="";
	
		if(eval("_sw."+ezbOmVars[k])){
			ezbOldValues[k]=eval(ezbOmVars[k]);
			ezbOldValues[k+vars_number]=eval(ezbOmVars[k+20]);
		}else{
			ezbOldValues[k]="";
			ezbOldValues[k+vars_number]="";
		}
		eval(ezbOmVars[k]+'="'+ezbNewValues[k].split("\"").join("") +'"');
		eval(ezbOmVars[k+vars_number]+'="'+ezbNewValues[k+vars_number].split("\"").join("") +'"');
	}
}
function UnsetEZB(){
	for (var i=0;i<ezbOmVars.length;i++) {
		if(eval("_sw."+ezbOmVars[i]))eval(ezbOmVars[i]+'="'+ezbOldValues[i]+'"');
	}
	ezbOmVars.length=0;
	ezbOldValues.length=0;
	ezbNewValues.length=0;
	s_pageName=unescape(s_pageName);
}
function s_sendAnalyticsEventWrap(str){
	if(EZB.Settings.enableTracking!=-1){
		s_dynamicAccountSelection=true;
		/* detect H code */
		if(window.s_gi && typeof s_gi == 'function') {/* H code */
			s_sendAnalyticsEvent(null,s_pageName);
		}else{
			if(window.s_gs && typeof s_gs == 'function') {/* G code */
				ns=s_account;if(str!=null && str.length>0)ns+=","+str;
				s_gs(ns);
			}	
		}	
		s_dynamicAccountSelection=false;
	}
}
function ezb_debug(){
	if(ezbOMdebug){
		ezbdebug="";
		for (var i=0;i<ezbOmVars.length;i++) {
			ezbdebug+=ezbOmVars[i]+"="+ezbNewValues[i]+" [old:"+ezbOldValues[i]+"]\n";
		}
		ezbdebug+="URLnode="+URLnode.substr(0,75)+"\n"+URLnode.substr(75,150)+"\n"+URLnode.substr(150,225)+"\n";+URLnode.substr(225)+"\n";
		ezbdebug+="redirectURL="+redirectURL.substr(0,75)+"\n"+redirectURL.substr(75,150)+"\n"+redirectURL.substr(150,225)+"\n"+redirectURL.substr(225)+"\n";
		alert(ezbdebug);
	}
}

function sendOmnitureLoad(){
		s_ios=1;
		s_events="event5,event18";
		if(window.EZB.Requests.length && EZB.Requests.length>0){
			if(EZB.Omniture.s_products.indexOf("event18")==-1)
				s_events="event5";
			if(EZB.Omniture.s_products.indexOf("event40")!=-1)
				s_events+=",event40";
			if(EZB.Omniture.s_products.indexOf("event41")!=-1)
				s_events+=",event41";	
			if(EZB.Omniture.s_products.indexOf("event46")!=-1)
				s_events+=",event46";	
			s_events+=",event20";
			
			if(EZB.Omniture.s_products && EZB.Omniture.s_products!=""){
				if(EZB.Omniture.s_products.indexOf("event")!=-1)
					s_products=EZB.Omniture.s_products+"|event20="+EZB.Requests.length;
				else	
					s_products=EZB.Omniture.s_products+";event20="+EZB.Requests.length;
			}else
				s_products="event20="+EZB.Requests.length;
		}
			
		ezb_view="EZB3.0 View";
		var old_ezb_s_account=ezb_s_account;
		SetEZBvarCommon();
		SetEZBvar(["s_pageName",ezb_view+" | "+l4+" | "+l7+" | "+l8+" | "+l9+" | "+l2+"/"+ l3,"s_eVar21",l_indPriceOrder]);
		ezb_s_account=old_ezb_s_account;
		s_sendAnalyticsEventWrap('');
		ezb_debug();
		UnsetEZB();
		ezbloaded=true;
}
function sendOmnitureFIFLoad(myPartnr) {
		s_ios=1;

		ezb_FIF=true;
		// called by Flash only if "enableTracking" option is set-up
		var ezb_view="EZB3.0 FIF View" + " | version " + iCodeVer;
		s_products = ";" + myPartnr + ";0;0;event18=1";
		(_sw.ezb_omnitureTitle&&ezb_omnitureTitle.length>0)?l3=_sw.ezb_omnitureTitle:0;
		SetEZBvarCommon();
		SetEZBvarFIF();

		s_usePlugins=false;
		SetEZBvar(["s_pageName",ezb_view+" | "+l4+" | "+l7+" | "+l8+" | "+l9+" | "+l2+"/"+ l3]);

		s_sendAnalyticsEventWrap('');
		
		ezb_debug();
		UnsetEZB();
		s_usePlugins=true;
		ezbloaded=true;
}

function sendOmnitureFIF() {
	ezb_FIF=true;
	SetEZBvarCommon();
	SetEZBvarFIF();
	sendOmnitureCommon_ezb(sendOmnitureFIF.arguments);		
}

function sendOmniture(){
	SetEZBvarCommon();
	var local_args=[];
	for (var i=0;i<sendOmniture.arguments.length;i++) {
		if(sendOmniture.arguments[i].indexOf('event15,event17')!=-1){ /*change if flash send this*/
			local_args[local_args.length]="event13,event17";
			local_args[local_args.length]="s_eVar31";
			local_args[local_args.length]="Buy Offline SC2"; 
		}else{
			if(sendOmniture.arguments[i].indexOf('event13,event17')!=-1){
				local_args[local_args.length]="event13,event17";
				local_args[local_args.length]="s_eVar31";
				local_args[local_args.length]="Buy Offline SC1"; 
			}else{
				local_args[local_args.length]=sendOmniture.arguments[i];
			}
		}
	}	
	sendOmnitureCommon_ezb(local_args);
}

function sendOmnitureCommon_ezb(arr){
	s_ios=1;
	var pn_i;//pagename index
	var newOmnitureArgs="";
	var OmAction="";
	for (var i=0;i<arr.length;i++) {
		newOmnitureArgs+=arr[i].toString()+':';
		if(arr[i].indexOf('s_pageName')!=-1)
			pn_i=i;
	}
	/* if lead and lead origin not a cookie */
	if((s_events.indexOf('scAdd')!=-1 || newOmnitureArgs.indexOf('scAdd')!=-1) && document.cookie.indexOf("_ezb_o")==-1){
		var theDate = new Date();
		var oneMonthLater = new Date( theDate.getTime() + 30*24*3600*1000 );
		var expiryDate = oneMonthLater.toGMTString();
		document.cookie = "_ezb_o="+l4+";path=/;domain=.hp.com;expires="+expiryDate;
	}	

	if(window.EZBACTION && EZBACTION!=""){
		arr[pn_i+1]=arr[pn_i+1].replace("EZB","EZB SC");//update pageName
	}
	//if(!window.s_eVar21){//Flash Direct call
	//	s_eVar21='buy';
	//	if(window.EZBACTION){
	//		if(EZBACTION=='buy' || EZBACTION=='1'){s_eVar21='SmartChoice_buy';OmAction='Buy';}
	//		if(EZBACTION=='config' || EZBACTION=='2'){s_eVar21='SmartChoice_config';OmAction='Config';}
	//		if(EZBACTION=='buy_or_config' || EZBACTION=='3'){s_eVar21='SmartChoice_buy_or_config';OmAction='Buy/Config';}
			
	//		newOmnitureArgs+='s_eVar21:'+s_eVar21;
	//		arr[pn_i+1]=arr[pn_i+1].replace("Buy",OmAction);
	//		arr[pn_i+1]=arr[pn_i+1].replace("Lead","Lead "+OmAction);
	//	}
	//	SetEZBvar(["s_eVar21",s_eVar21]);
	//}
	SetEZBvar(arr);
	s_usePlugins=false;
	if (oldOmnitureArgs != newOmnitureArgs){
		s_sendAnalyticsEventWrap('');
	}
	s_usePlugins=true;
	ezb_debug();
	UnsetEZB();
	oldOmnitureArgs=newOmnitureArgs;
	if(redirectURL != "empty"){
		var RURL=redirectURL;
		redirectURL="empty";
		if(!redirectURLNewW)
			_sw.setTimeout('window.top.location="'+RURL+'"',1250);
		else{
			redirectURLNewW=false;
			_sw.setTimeout('window.open("'+RURL+'","new")',1250);
		}
	}
}

function utf8(wide) {
  var c, s;
  var enc = "";
  var i = 0;
  while(i<wide.length) {
    c= wide.charCodeAt(i++);
    // handle UTF-16 surrogates
    if (c>=0xDC00 && c<0xE000) continue;
    if (c>=0xD800 && c<0xDC00) {
      if (i>=wide.length) continue;
      s= wide.charCodeAt(i++);
      if (s<0xDC00 || c>=0xDE00) continue;
      c= ((c-0xD800)<<10)+(s-0xDC00)+0x10000;
    }
    // output value
    if (c<0x80) enc += String.fromCharCode(c);
    else if (c<0x800) enc += String.fromCharCode(0xC0+(c>>6),0x80+(c&0x3F));
    else if (c<0x10000) enc += String.fromCharCode(0xE0+(c>>12),0x80+(c>>6&0x3F),0x80+(c&0x3F));
    else enc += String.fromCharCode(0xF0+(c>>18),0x80+(c>>12&0x3F),0x80+(c>>6&0x3F),0x80+(c&0x3F));
  }
  return enc;
}
var hexchars = "0123456789ABCDEF";
function toHex(n) {
  return hexchars.charAt(n>>4)+hexchars.charAt(n & 0xF);
}
var okURIchars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_-.";
function encodeURIComponentNew(s) {
  var s = utf8(s);
  var c;
  var enc = "";
  for (var i= 0; i<s.length; i++) {
    if (okURIchars.indexOf(s.charAt(i))==-1)
      enc += "%"+toHex(s.charCodeAt(i));
    else
      enc += s.charAt(i);
  }
  return enc;
}

// Prepare Omniture variables for add to basket
// Called by HTML templates
// Deal with start from price

function ezb_AddBasket(id,type,formname,partnr,price,pname,clientID){
	//partnr id
	//formname for real-time on click form get qty
	//partnr in format pn|qty,pn|qty
	//price: individual price if single product, total_price if multiple products
	var action="buy";
	if(window.EZBACTION && EZBACTION!="")
		action="SmartChoice_"+EZBACTION;
	
	var Om_action="";
	(action.toLowerCase().indexOf("buy")!=-1)?((action.toLowerCase().indexOf("config")!=-1)?Om_action="Buy/Config":Om_action="Buy"):Om_action="Config";

	var r,a,b,c;
	s_products='';
	
	if(type=='hp')
		s_events='event10,event16,scAdd';
	else
		s_events='event14,event16,scAdd';
		
	var np=0;
	var tpagename="";
	var tprice=0;
	partnr_a=partnr.split(',');
	price_a=price.toString().split(',');
	
	var ezb_pn=partnr_a[0].split('|')[0];
	
	for (var k = 0; k < partnr_a.length; k++){//loop on products
		partnr_i=partnr_a[k].split('|');//split product/qty
		if(partnr_i.length>1){//if qty exists
			if(partnr_i[1]>0){//if qty>0
				np++;
				if(k>0){
					s_products+=',';
					tpagename+='_';
				}
				lprice=0;
				
				if(partnr_i[1]<99){
					for(var l=0; l < price_a.length; l++){
						price_i=price_a[l].split('|');
						if(price_i.length>1){
							if(price_i[0]==partnr_i[0]){
								lprice=price_i[1];
								break;
							}
						}else{
							lprice=price_i[0];
						}
					}
				}
				if(lprice!=0 || partnr_i[1]>=99){
					s_products+=';'+partnr_i[0]+';'+partnr_i[1]+';'+lprice*partnr_i[1];
					s_products+=";event16="+lprice*partnr_i[1];
					tpagename+=partnr_i[0]+'-'+partnr_i[1];
					tprice=tprice+lprice*partnr_i[1];
				}
			}
		}
	}
	//s_products+=";event16="+tprice;
	tpagename+='|'+tprice;

	l4 = clientID;
	
	if(type=='hp')
		if(np>1)
			tpagename='EZB3.0 Buyn HP | '+(clientID?clientID:l4)+' | '+l7+' | '+l8+' | '+l9+' | '+tpagename;
		else
			tpagename='EZB3.0 '+Om_action+' HP | '+(clientID?clientID:l4)+' | '+l7+' | '+l8+' | '+l9+' | '+tpagename;
	else
		if(np>1)
			tpagename='EZB3.0 Leadn | '+(clientID?clientID:l4)+' | '+l7+' | '+l8+' | '+l9+' | '+pname + ' | ' +tpagename;
		else
			tpagename='EZB3.0 Lead '+Om_action+' | '+(clientID?clientID:l4)+' | '+l7+' | '+l8+' | '+l9+' | '+pname + ' | ' +tpagename;
	sendOmniture('s_pageName',tpagename,'s_eVar2',id,'s_eVar3',ezb_pn,'s_eVar21',l_indPriceOrder,'s_prop4',clientID?clientID:l4,'s_eVar4',clientID?clientID:l4);
}

// Prepare Omniture variables for find a partner
// Called by HTML templates - showDirectTemplate option on
// Price could be null or have whatever value


function ezb_FindPartner(partnr,price,clientID){
	//partnr in format pn
	//price: individual price only
	var screen="1";
	s_events='event13,event17';
	s_eVar31="Buy Offline SC1";
	
	var action="buy";
		
	if(window.EZBACTION && EZBACTION!="")
		action="SmartChoice_"+EZBACTION;

	
	if(window.which_screen && window.which_screen=="2"){
		screen="2";
		s_eVar31="Buy Offline SC2";
	}	
	var Om_action="";
	(action.toLowerCase().indexOf("buy")!=-1)?((action.toLowerCase().indexOf("config")!=-1)?Om_action="Buy/Config":Om_action="Buy"):Om_action="Config";

	if (price=="null") 
		price=0;
	s_products = ';'+partnr+';0;'+price+';event17='+price;		
	tpagename = 'EZB3.0 '+Om_action+' Offline SC'+screen+' | '+l7+' | '+l8+' | '+l9+' | '+ partnr + ' | ' + price;
	redirectURLNewW=true;
	sendOmniture('s_pageName',tpagename,'s_eVar3',partnr,'s_eVar21',l_indPriceOrder,'s_eVar31',s_eVar31,'s_prop4',clientID?clientID:l4,'s_eVar4',clientID?clientID:l4);
}

function ezb_BuyPartner(partnr,price,clientID){
	//partnr in format pn
	//price: individual price only
	s_events="",tpagename="";
	s_products="";
	s_events='event11';
	
	var action="buy";
	
	if(window.EZBACTION && EZBACTION!="")
		action="SmartChoice_"+EZBACTION;

	var Om_action="";
	(action.toLowerCase().indexOf("buy")!=-1)?((action.toLowerCase().indexOf("config")!=-1)?Om_action="Buy/Config":Om_action="Buy"):Om_action="Config";
	
	if (price=="null") 
	price=0;
	
	s_products = ';'+partnr+';0;'+price;		
	tpagename = 'EZB3.0 '+Om_action+' Partner | '+l7+' | '+l8+' | '+l9+' | '+ partnr + ' | ' + price;
	sendOmniture('s_pageName',tpagename,'s_eVar3',partnr,'s_eVar21',l_indPriceOrder,'s_prop4',clientID?clientID:l4,'s_eVar4',clientID?clientID:l4);
}

/* PAGE VIEW & LOAD */
if ((_sw.countrysettingsLoaded!=false) && (EZB.Settings.enableTracking!=-1) )
{
	addLoadEvent(function() {
			sendOmnitureLoad();
	});
}