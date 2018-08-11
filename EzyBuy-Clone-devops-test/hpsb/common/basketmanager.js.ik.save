//if universal minicart not already defined
if(!window.minicartLocation){

if (window.top.location.search.indexOf("new_sb") !=-1 || document.cookie.indexOf("new_sb_")!=-1){
	document.cookie = "new_sb_=1;path=/;domain=.hp.com;";
	
//	(the_cookie+document.cookie).indexOf("hpstore_"+s_prop7+"_"+s_prop8+"_hho")!=-1?print_cookie=(the_cookie+document.cookie).replace(new RegExp('(.*)(hpstore.......hho[^;]*);(.*)', 'g'), '$2'):print_cookie="";
//	(the_cookie+document.cookie).indexOf("hpstore_"+s_prop7+"_"+s_prop8+"_smb")!=-1?print_cookie+='&&'+(the_cookie+document.cookie).replace(new RegExp('(.*)(hpstore.......smb[^;]*);(.*)', 'g'), '$2'):print_cookie+='&&'+"";
	
	document.write('<div id="ezb_splash_screen" style="position: absolute; top: 0px; left: 0px; background: pink; width: 50%; height: 10%; opacity: 1; filter: alpha(opacity=100); -moz-opacity: 1">This is testing the new buy partner link!.<BR>'+(window.ab_testing_splash?ab_testing_splash:'')+'</div>');
}
document.write('<link href="http://h41213.www4.hp.com/ezbuy/html/css/sb.css" type="text/css" rel="stylesheet">');
document.write('<script src="http://h41213.www4.hp.com/ezbuy/hpsb/common/sb_template.js"></script>');

/**
 *
 * Revision 1.15.56.1  2006/10/25 14:37:50  slechner
 * - added jumpid synonym for channel and partner forced experience as per new marketing campaigns request
 *
 * /ezbuy/hpsb/common/basketmanager.js
 * $Date: 2009/03/24 08:13:39 $
 * $Revision: 1.2 $
 * $Author: ezbuydev $
 * $Id: basketmanager-full.js,v 1.2 2009/03/24 08:13:39 ezbuydev Exp $
 * $Log: basketmanager-full.js,v $
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
 * Revision 1.5  2007/09/12 15:38:49  ezbuy
 * - fixed bug for context options handling
 *
 * Revision 1.4.4.1  2007/09/12 15:30:47  ezbuy
 * - fixed bug for context options handling
 *
 * Revision 1.4  2007/09/03 14:42:08  ezbuy
 * PSC JP
 *
 * Revision 1.3.2.1  2007/09/03 07:01:50  ezbuy
 * PSC japan template mofidication
 *
 * Revision 1.3  2007/08/21 17:58:11  ezbuy
 * enabled PSC R8 release based on frame by changing JS location use to window.top.location
 *
 * Revision 1.2.2.1  2007/08/21 17:51:52  ezbuy
 * enabled PSC R8 release based on frame by changing JS location use to window.top.location
 *
 * Revision 1.2  2007/08/15 11:33:56  ezbuy
 * -made most of JS minified
 * -introduce option for ImageBuilder to display banners containing ezbuy
 * -made shopping basket compliant with "any" market segment
 *
 * Revision 1.1.2.1  2007/08/15 10:30:06  ezbuy
 * -made most of JS minified
 * -introduce option for ImageBuilder to display banners containing ezbuy
 * -made shopping basket compliant with "any" market segment
 *
 * Revision 1.25  2007/06/16 19:55:35  ezbuy
 * ecom DBC: add info u1 for DBC
 * add cdn testing parameters
 * fix logo presentation display message
 * introduced se SB settings
 * prepare for SB with force segment
 *
 * Revision 1.24.22.1  2007/06/16 19:42:20  ezbuy
 * ecom DBC: add info u1 for DBC
 * add cdn testing parameters
 * fix logo presentation display message
 * introduced se SB settings
 * prepare for SB with force segment
 *
 * Revision 1.24  2007/03/02 16:55:55  ezbuy
 * new prff functionality for ireland templates
 * new omniture vars
 * update config from prod
 *
 * Revision 1.23.26.1  2007/03/02 16:47:15  ezbuy
 * new prff functionality for ireland templates
 * new omniture vars
 *
 * Revision 1.23  2007/01/31 09:03:52  ezbuy
 * CH HHO HP store integration exception fix
 *
 * Revision 1.22  2007/01/09 14:30:25  ezbuy
 * release 946 with
 * - Change hotline price/min for SB DE SMB/HHO from 12ct/min to 14ct/min
 * - updated content from operations on precedent releases (configuration)
 *
 * Revision 1.19  2006/11/16 13:00:28  ezbuy
 * REL_873_E_877_PROD with:
 * - SmartChoice
 * - new CSS
 * - new SB with partner specific sessions
 * - new EPP
 * - performance improvement on PSC with delayed rendering
 *
 * Revision 1.18.2.2  2006/11/16 11:58:28  ezbuy
 * - prepare files for later compression (clean javascript)
 * - new DBC partners
 * - new jumpid for hpsb
 *
 * Revision 1.18.2.1  2006/11/09 22:35:25  slechner
 * merge with REL_803_E
 *
 * Revision 1.15.40.15  2006/10/18 06:33:15  slechner
 * - new option to allow to have with/without SB implementation code and call
 * - fix for storeId undefined if only ezbexpdetect.js executed
 * - old SB bugs re-tested and code modified when needed
 *
 * Revision 1.15.40.14  2006/10/17 10:43:06  slechner
 * - ezbeppStoreId renamed into ezbStoreId
 * - ezbStoreId published when experience is direct
 * - fix for t_segment undefined
 *
 * Revision 1.15.40.13  2006/10/16 14:28:26  slechner
 * issue solved : for suresupply, SB parameters should be initialized even if showBasket function is not called, as parameters used for add to basket call. Issue identified will be solved this week.
 * issue solved : currency is not defined, due to use of function in banners.js whereas basket parameters are not defined in this case. Issue identified will be solved this week.
 *
 * Revision 1.15.40.12  2006/10/12 08:40:14  slechner
 * remove trace of local server
 *
 * Revision 1.15.40.11  2006/10/11 15:56:15  slechner
 * wrong SB parameters assignement according to page segment
 *
 * Revision 1.15.40.10  2006/09/12 15:27:19  slechner
 * version finalized
 *
 * Revision 1.15.40.9  2006/09/08 15:52:57  slechner
 * private store new cookie and forced_partner and forced_channel segment independant
 *
 * Revision 1.15.40.8  2006/08/31 18:51:57  slechner
 * OK but all experiences are segment independant (forced_partner, forced_channel, direct, direct_epp)
 *
 * Revision 1.15.40.7  2006/08/31 10:41:44  slechner
 * epp read from cookie
 *
 * Revision 1.15.40.6  2006/08/30 16:48:38  slechner
 * version split between ezbexpdetect.js and basketmanager.js
 *
 * Revision 1.15.40.4  2006/08/23 16:00:18  slechner
 * before meeting with Stephane on Thursday
 *
 * Revision 1.15.40.3  2006/08/22 15:30:42  slechner
 * development on-going : need to update partner jumpIDlist with merchants and
 * also develop what need to be done in EZBuy
 *
 * Revision 1.15.40.2  2006/08/21 16:01:00  slechner
 * new function setExperience on-going
 *
 * Revision 1.15.40.1  2006/08/18 16:02:40  slechner
 * Shopping Basket forced partner session - on-going
 *
 * Revision 1.15  2006/06/23 12:55:28  slechner
 * REL_724_C_PROD_732
 * new intel logos
 * new doubleclcik partners in production
 * new config from prod
 *
 * Revision 1.14.2.1  2006/06/23 12:46:02  slechner
 * new intel logos
 * new doubleclcik partners in production
 *
 * Revision 1.14  2006/06/10 21:19:00  slechner
 * added new experience "forced_channel" triggered by r_channel in URL that will turn the filetr to ebus partner only on and will therefore be a channel experience
 *
 * Revision 1.13.4.1  2006/06/10 21:14:21  slechner
 * added new experience "forced_channel" triggered by r_channel in URL that will turn the filetr to ebus partner only on and will therefore be a channel experience
 *
 * Revision 1.13  2006/06/08 21:29:25  slechner
 * REL_718_C_PROD_720
 * - fr hho shopping basket live
 * - updated currency rates for doubleclick
 * - fixed issue of wrong Omniture account for page load
 *
 * Revision 1.12.10.1  2006/06/08 21:18:55  slechner
 * - fr hho shopping basket live
 * - updated currency rates for doubleclick
 * - fixed issue of wrong Omniture account for page load
 *
 * Revision 1.12  2006/05/24 12:50:33  slechner
 * REL_708_B_PROD_7111
 * Fixes:
 * - redefined defalut values treatment for Omniture s_popn in shopping basket, ezb_metrics and GoEzbPartner following Omniture FIF project
 * - fixed a typo in template name for template.html
 * - introduced P3P for cookie set by set_order (omniture revenue tracking)
 * Added:
 * - latest files from Prod
 * - new DoubleClick Partner live FR Wstore
 *
 * Revision 1.11.8.1  2006/05/24 12:40:30  slechner
 * Fixes:
 * - redefined defalut values treatment for Omniture s_popn in shopping basket, ezb_metrics and GoEzbPartner following Omniture FIF project
 * - fixed a typo in template name for template.html
 * - introduced P3P for cookie set by set_order (omniture revenue tracking)
 * Added:
 * - latest files from Prod
 * - new DoubleClick Partner live FR Wstore
 *
 * Revision 1.11  2006/05/05 23:55:12  slechner
 *  Omniture FIF implementation update:
 * -EmptyEZBvar() for not sending page variables if not an hp page (case for RichFX)
 * -Set Omniture vars for FIF non HP page catalogs
 * -Added two vars to be sent for FIF: s_evar16 and s_evar20 to track campaigns
 * -Do send Omniture data for FIF to emea account not only ezbuy account
 * -Do not sent Omniture data to any other account than HP
 * -Temporarily send FIF Omniture data to dev account for FIF remote catalogs
 * - Fixed bug preventing sendOmnitureLoad to work if a normal ezbuy was following a FIF movie!
 * - Fixed bug causing no Omniture tracking/AMD logos in countrysettings
 * - updated latest config from prod files
 * - added small Shopping basket template
 *
 * Revision 1.10.4.1  2006/05/05 23:52:01  slechner
 *  Omniture FIF implementation update:
 * -EmptyEZBvar() for not sending page variables if not an hp page (case for RichFX)
 * -Set Omniture vars for FIF non HP page catalogs
 * -Added two vars to be sent for FIF: s_evar16 and s_evar20 to track campaigns
 * -Do send Omniture data for FIF to emea account not only ezbuy account
 * -Do not sent Omniture data to any other account than HP
 * -Temporarily send FIF Omniture data to dev account for FIF remote catalogs
 * - Fixed bug preventing sendOmnitureLoad to work if a normal ezbuy was following a FIF movie!
 * - Fixed bug causing no Omniture tracking/AMD logos in countrysettings
 * - updated latest config from prod files
 * - added small Shopping basket template
 *
 * Revision 1.9  2006/03/30 15:36:04  slechner
 * REL_675_E2_PROD_676 Enhancements in:
 * - DoubleClick/Omniture proxy tagging to avoid multiple submission using cookies
 * - Shopping basket display in case segment page is undefined
 * - GetEzbdata back-end service improved proxy management
 * - report.php new features to check exclusion
 * - new ezcomploader from ClientID recognition bug
 *
 * Revision 1.8.20.1  2006/03/30 15:31:42  slechner
 * Enhancements in:
 * - DoubleClick/Omniture proxy tagging to avoid multiple submission using cookies
 * - Shopping basket display in case segment page is undefined
 * - GetEzbdata back-end service improved proxy management
 * - report.php new features to check exclusion
 * - new ezcomploader from ClientID recognition bug
 *
 * Revision 1.8  2006/03/03 16:18:58  slechner
 * REL_664_C_PROD_665 with:
 * - latest config
 * - change phone number for shopping basket
 *
 * Revision 1.7.8.1  2006/03/03 16:15:11  slechner
 * REL_664_C_PROD_665 with:
 * - latest config
 * - change phone number for shopping basket
 *
 * Revision 1.7  2006/02/27 10:46:58  slechner
 * REL_650_E_PROD_656 with:
 * - latest config from Ops
 * - new Shopping basket
 *
 * Revision 1.6.6.1  2006/02/27 10:41:45  slechner
 * REL_650_E_PROD_656 with:
 * - latest config from Ops
 * - new Shopping basket
 *
 * Revision 1.5  2005/12/22 13:55:51  slechner
 * REL_602_C and REL_602_E merge into main + cofig update from Prod
 * Changes:
 * - limit quantity input inHTML template to 99
 * - new metrics as per Omniture instructions
 * - new back-end services
 * - new FR shopping basket config
 *
 * Revision 1.4.16.1  2005/12/22 13:41:17  slechner
 * FR Shopping basket config preparation (store still closed)
 *
 * Revision 1.3  2005/11/14 08:46:07  slechner
 * REL_565_B_PROD_566
 *
 * Revision 1.2.4.1  2005/11/14 08:40:31  slechner
 * Fixed bug when Shpstore Cookie was set second: the hpstore cookie could not be found. Case where direct experienced was forced.
 *
 * Revision 1.2  2005/11/13 21:29:08  slechner
 * REL_563_C_PROD_564
 *
 * Revision 1.1.1.1  2005/11/13 20:48:09  slechner
 * initial import
 *
 * $Name: HEAD $
 * $State: Exp $
 *
 * +======================================================================================================+
 * | EZB Shopping basket configuration main
 * +======================================================================================================+
 * +------------------------------------------------------------------------------------------------------+
 * | Code Structure:
 * | --------------
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
 * |02/03/2005: default segment to smb
 * |11/13/2005: StoreHomePage fix to allow for StoreHomeUrl to contain query string
 * |11/14/2005: Fixed bug when two cookies were available and the one not expected was set second
 * |10/25/2005: Added Jumpid synonyms for direct/channel
 * +------------------------------------------------------------------------------------------+
 * | Debug:
 * | --------
 * |
 * +------------------------------------------------------------------------------------------+
 * | Assumptions:
 * | ------------
 * |
 * +------------------------------------------------------------------------------------------+
 * | JS Context used:
 * | ---------------
 * |
 * +------------------------------------------------------------------------------------------+
 * | JS Context defined:
 * | ------------------
 * |
 * +------------------------------------------------------------------------------------------+
 * | exceptions:
 * | -----------
 * |
 * +==========================================================================================+
 *
 **/
var openedSites = "se_sv_smb_psc|se_sv_hho_psc|ch_de_smb_psc|ch_fr_smb_psc|uk_en_smb_psc|uk_en_smb_pri|fr_fr_smb_psc|fr_fr_smb_pri|";
openedSites += "de_de_smb_pri|ch_de_smb_pri|ch_fr_smb_pri|es_es_smb_pri|es_es_smb_psc|";
openedSites += "de_de_smb_psc|de_de_hho_psc|uk_en_hho_psc|";
openedSites += "ch_de_hho_psc|ch_fr_hho_psc|fr_fr_hho_psc";
openedSites += "|es_es_hho_psc|";
if (window.m_s)
	m_s!="hho"?(m_s!="smb"?m_s="smb":0):0;

// ***************************
// *** JUMP ID DEFINITION
// ***************************
var DirectjumpIDList = new Array("r1129","r11219","ezb_direct","direct");
var ChanneljumpIDList = new Array("ezb_channel","channel");
var SingleStoreList = new Array("ch_fr","ch_de","se_sv"); // smb store alsways
var ForcedSegmentList = new Array("se_sv"); // keep first visited segment where SB script was found

var forced_channel=false;
function JS_ScriptFileInclude(scriptFile)
{
	document.write(["<scr", "ipt language=javas", "cript s","rc='", scriptFile, "'></scr", "ipt>\n"].join(''));
}


var ezbexpdetectLoaded;
var s_prop9;
if(window.s_prop9 && s_prop9!="smb" && s_prop9!="hho"){
	old_s_prop9=s_prop9;
	window.s_prop9="smb";
	ezbexpdetectLoaded=false;
}	
var the_server="http://h41213.www4.hp.com";
var hpsb_path="/ezbuy/hpsb/common/";
if (!ezbexpdetectLoaded) JS_ScriptFileInclude(the_server+hpsb_path+"ezbexpdetect-min.js");

// ***************************
// *** VARIABLES DEFINITION
// *** ddVar stands for default display Var
// *** diVar stands for display Var
// *** dlVar stands for default l Var
// *** lVar stands for l Var
// *** dName stands for defaultName
// ***************************

// variables
var separator = ";";
var SB,SB_hho,SB_smb; // when equals null, it means there is no SB to display
var ezbuyFlag = false;

// all l/display/options
var InitParam=new Array("checkoutUrl","catalogUrl","storeUrl","storeUrlAdd","storeId","siteId","globalSiteId","diPhone","diProductName","diNumberOfItems","diNetAmount","diVat","diSchippingCharge","diVatShippingCharge","diGrossAmount","diGrossShippingCharge","diTotalAmount","diCurrency","diCheckout","imageName","lBuyPartner","ltitle","ltitle2","ltitle_ms","lItemName","lItemsName","lNetAmount","lVat","lShippingCharge","lVatShippingCharge","lGrossAmount","lGrossShippingCharge","lTotalAmount","lCurrency","lhpStoreButtonTitle","lOrder","lPhoneNumber","currency","lButtonTitle","storeHomeUrl","lCheckout");

// all l/display/options default values
var dInitParam=new Array("checkoutUrl","catalogUrl","storeUrl","dstoreUrlAdd","storeId","siteId","globalSiteId","ddPhone","ddProductName","ddNumberOfItems","ddNetAmount","ddVat","ddSchippingCharge","ddVatShippingCharge","ddGrossAmount","ddGrossShippingCharge","ddTotalAmount","ddCurrency","ddCheckout","dImageName","dlBuyPartner","dltitle","dltitle2","dltitle_ms","dlItemName","dlItemsName","dlNetAmount","dlVat","dlShippingCharge","dlVatShippingCharge","dlGrossAmount","dlGrossShippingCharge","dlTotalAmount","dlCurrency","dlhpStoreButtonTitle","dlOrder","dlPhoneNumber","dCurrency","dlButtonTitle","dstoreHomeUrl","dlCheckout");
var catalogUrl,storeUrl,storeId,siteId,globalSiteId;
// default display preferences
var ddProductName = true;
var ddNumberOfItems = true;
var ddNetAmount = true;
var ddVat = true;
var ddSchippingCharge = true;
var ddVatShippingCharge = true;
var ddGrossAmount = true;
var ddGrossShippingCharge = true;
var ddTotalAmount = true;
var ddCurrency = true;
var ddCheckout = true;
var ddPhone = true;

var dImageName = the_server+hpsb_path+"basket.gif";
var dstoreHomeUrl = "http://h41162.www4.hp.com/home";
var dstoreUrlAdd;
var dCurrency = "&euro;";

var dlBuyPartner = "Buy from an HP partner";
var dltitle = "shopping basket";
var dltitle2= "shopping basket";
var dltitle_ms = "Consumer";
var dlItemName = "items";
var dlItemsName = "In my basket";
var dlNetAmount = "Net Amount";
var dlVat = "VAT";
var dlShippingCharge = "Shipping Charge";
var dlVatShippingCharge = "VAT Shipping Charge";
var dlGrossAmount = "Gross Amount";
var dlGrossShippingCharge = "Gross Shipping Charge";
var dlTotalAmount = "Total Amount";
var dlCurrency = "Currency";

var dlhpStoreButtonTitle = "hp smb store home &raquo";
var dlOrder = "to order by phone :";
var dlPhoneNumber = "0845 270 4215";
var dlCheckout = "checkout";


// debug mode and other dev variables
var dVerbose = false;
var debug = false;
var list = false;
var integration = false;

var dLeftTableSize = 170;
var dRightTableSize = 180;

var dlButtonTitle = "Checkout";

var dColor = "#E7E7E7";

var sb_total_q=0;

if(!storeMeans_hho)
{var storeMeans_hho=false;}

(window.s_prop4&&s_prop4.length>0)?l4=window.s_prop4:l4="-";
if ((l4=="hpstore") && storeMeans_hho)
storeMeans_hho = false;

if(!storeMeans_smb)
{var storeMeans_smb=false;}

(window.s_prop4&&s_prop4.length>0)?l4=window.s_prop4:l4="-";
if ((l4=="hpstore") && storeMeans_smb)
storeMeans_smb = false;

function dw(string){document.write(string);}

// ***************************
// *** BACKEND METHODS        
// ***************************
// use to get specific parameters (if they are not empty)
function InitParamSet(Param,dParam,segment){
	try {
		if (eval(Param+'_'+segment+'==null') || (eval(Param+'_'+segment+'==""') && eval(Param+'_'+segment+'!=false'))) {
			eval(Param+'='+ dParam);
			if (verbose) dw(Param+'_'+segment+' use default value <br>');
		}else{
			eval(Param+'='+Param+'_'+segment);	
		}
	} catch (error) {
		if (verbose) dw(Param+'_'+segment+' variable does not exist, use default value <br>');
		eval(Param+'='+dParam);	
	}
}

function initializeParameters(segment) {
	for (var i = 0; i < InitParam.length; i++){
		InitParamSet(InitParam[i],dInitParam[i],segment);
		(verbose)?dw(InitParam[i]+'='+eval(InitParam[i])+'<br>'):"";
	}
	if(window.ezbuyExperience && ezbuyExperience=="epp" && window.ltitle_epp)
		ltitle=ltitle_epp;
} 

// ***************************
// *** OTHER METHODS
// ***************************
// Set ezbuyFlag to true if store is opened
function setEzbuyFlag() {
	ezbuyFlag=false;
	if(window.siteId){
		if (openedSites.indexOf(siteId)!=-1) {
			ezbuyFlag = true;
		}
		else {
			if (integration || debug) ezbuyFlag = true;
		}	
		if (verbose) dw('Store open status: ezbuyFlag='+ezbuyFlag+'<br><br>');
	}
	
	ezbuyExperience="channel";
	if (ezbuyFlag) {
		ezbuyExperience="neutral";
	}
}

// set execution mode (verbose, debug, list and/or integration) regarding http param
function setMode() {

	try {
		if (verbose==null || (verbose=="" && verbose!=false))
			verbose = dVerbose;
	} catch (error) {
		verbose = dVerbose;
	}

	if (window.top.location.search.indexOf("verbose=true") !=-1)
		verbose = true;

	if (window.top.location.search.indexOf("debug=true") !=-1)
		debug = true;

	if (window.top.location.search.indexOf("list=true") !=-1)
		list = true;
		
	if (window.top.location.search.indexOf("integration=true") !=-1)
		integration = true;
		
}

function HPStore_jumpID_detect (segment) {
	
	var expdate = new Date();
	// expiration date set-up 1 week later
	expdate.setTime(expdate.getTime() +  (7 * 24 * 3600 * 1000));
	var expdate_str = expdate.getFullYear() + ':' + twoDigit(expdate.getMonth()+1) + ':' + twoDigit(expdate.getDate()) + ':' + twoDigit(expdate.getHours()) + ':' + twoDigit(expdate.getMinutes());	
	
	var name = 'hpstore_'+globalSiteId;
	var value = '['+'sid='+storeId+'|t='+expdate_str+'|c='+currency+'|pp=hp]';
	value=value.replace(/;/g,"@#@");
	write_cookie (name,value,null,"/","hp.com");
	SB = new SBo(storeId,expdate_str,0,0,0,0,0,0,0,0,currency,false,"","hp");
	if(segment=="hho"){
		SB_hho = new SBo();
		SB_hho = SB;
	}else{
		SB_smb = new SBo();
		SB_smb = SB;
	}
}

function storeId_publish (segment,page_segment) {
	if ((ezbuyExperience == "direct")&&(segment==page_segment)) {
		ezbStoreId = storeId;
		if(verbose)dw("ezbStoreId :" +ezbStoreId+'<br>');
	}
}


// *************************************
// *** INITIALIZE METHODS IF NO DISPLAY
// *************************************

var t_segment;
var ezb_segment;
(window.top.location.toString().indexOf("/ho")==-1)?t_segment="smb":t_segment="hho";
var ezbuyExperienceForced;
if(window.ezbuyExperience && ezbuyExperience!="direct" && ezbuyExperienceForced=="direct"){
	(t_segment=="smb")?HP_Store_JumpID_SMB=true:HP_Store_JumpID_HHO=true;
}
var ezbstoreId;
setMode();
initializeParameters((window.s_prop9)?window.s_prop9:t_segment);

var ForcedSegment=false;
var SingleStore=false;
if(openedSites.indexOf(globalSiteId)!=-1){
	for (var i = 0; i < ForcedSegmentList.length; i++){
		if(globalSiteId.indexOf(ForcedSegmentList[i])!=-1){
			ForcedSegment=ForcedSegmentList[i];
			break;
		}
	}
	if(ForcedSegment){
		if (document.cookie.indexOf("ezb_segment")!=-1){
			var aC = document.cookie.split("; ");
			for (var i=0; i < aC.length; i++){
				var aCt = aC[i].split("=");
				if ("ezb_segment" == aCt[0]){
					var aSC = aCt[1].split("|");
					var found=false;
					for (var ii=0; ii < aSC.length; ii++){
						if(aSC[ii].substr(0,5)==globalSiteId.substr(0,5)){
							ezb_segment_a=aSC[ii].split("_");
							ezb_segment=ezb_segment_a[2];
							found=true;
						}
					}
					if(!found){
						ezb_segment=(window.s_prop9)?window.s_prop9:t_segment;
						document.cookie = "ezb_segment="+ForcedSegment+"_"+ezb_segment+";path=/;domain=.hp.com;";
					}
					break;
				}
			}
		}else{
			ezb_segment=(window.s_prop9)?window.s_prop9:t_segment;
			document.cookie = "ezb_segment="+ForcedSegment+"_"+ezb_segment+";path=/;domain=.hp.com;";
		}
		initializeParameters(ezb_segment);
	}

	for (var i = 0; i < SingleStoreList.length; i++){
		if(globalSiteId.indexOf(SingleStoreList[i])!=-1){
			SingleStore=true;
			break;
		}
	}	
}


// ***************************
// *** DISPLAY METHODS
// ***************************
// print the shopping basket

// public method to call basket manager
function showBasket(place) {		
		(!window.globalSiteId)?globalSiteId="-":"";
		(window.globalSiteId)?printBasket(place?place.toLowerCase():''):"";
}

var s_prop5;
var ezbuyFlag_hho,ezbuyFlag_smb;
//////////////////////////////////////
function basket_publish(str){
		var str_r=str;
		str_r=str_r.replace(/#currency#/g,SB.currency);
		str_r=str_r.replace(/#netAmount#/g,SB.netAmount);
		str_r=str_r.replace(/#vat#/g,SB.vat);
		str_r=str_r.replace(/#shippingCharge#/g,SB.shippingCharge);
		str_r=str_r.replace(/#vatShippingCharge#/g,SB.vatShippingCharge);
		str_r=str_r.replace(/#grossAmount#/g,SB.grossAmount);
		str_r=str_r.replace(/#grossShippingCharge#/g,SB.grossShippingCharge);
		str_r=str_r.replace(/#totalAmount#/g,SB.totalAmount);
		str_r=str_r.replace(/#quantity#/g,SB.quantity);
		str_r=str_r.replace(/#storeUrl#/g,storeUrl.indexOf("?")!=-1?storeUrl+'&s='+siteId+'&p='+SB.storeId:storeUrl+'?s='+siteId+'&p='+SB.storeId);		
		return(str_r);
}
function EZB_SetNeutral(){
	var country = (window.s_prop7)?window.s_prop7:"";
	var lang = (window.s_prop8)?window.s_prop8:"";
	var expdate = new Date();
	var name = 'hpstore_'+country+'_'+lang;
	document.cookie = name + "_hho=" + ";path=/" + ";domain=.hp.com" + ";expires=Thu, 01-Jan-1970 00:00:01 GMT";
	document.cookie = name + "_smb=" + ";path=/" + ";domain=.hp.com" + ";expires=Thu, 01-Jan-1970 00:00:01 GMT";
}
function printBasket(place,eid) {
    var sb_print=true;
    if(eid!=false){
        dw('<div id="SB_PRINT_'+place+'"></div>');
    }
    if(self.location!=window.top.location || place==''){
        dw=function(){};
        sb_print=false;
    }
    if(place=='left_partner'){
        //var country = (window.s_prop7)?window.s_prop7:"";
        //var lang = (window.s_prop8)?window.s_prop8:"";
        //if (document.cookie.indexOf("hpstore_"+country+"_"+lang)!=-1){
         //   if(sb_print && document.getElementById('SB_PRINT_'+place)){
	//	t=basket_publish(get_buy_partner_link(place, ""));
	//	document.getElementById('SB_PRINT_'+place).innerHTML+=t;
        //   }
        //}
        dw=function(){};
        return(false);
    }

    DrawBasket=function(place, segment, SB){
	if(sb_print && document.getElementById('SB_PRINT_'+place)){
	        t=basket_publish(get_basket(place, segment,SB));
            	document.getElementById('SB_PRINT_'+place).innerHTML+=t;
        }    	
    };
    DrawPhone=function(place, segment){
        if(sb_print && document.getElementById('SB_PRINT_'+place)){
       		t=get_basket_phone_number(place, segment);
       		document.getElementById('SB_PRINT_'+place).innerHTML+=t;
       	}	
    };
    setMode();
    var m_s = (window.s_prop9)?window.s_prop9:t_segment;
    (ezb_segment)?m_s=ezb_segment:0;
    // SMB
    SB=null;
    initializeParameters("smb");
    setEzbuyFlag();
    ezbuyFlag_smb=ezbuyFlag;
    setExperience("smb",m_s);
    if (debug && !SB) {
        SB = new SBo(storeId,"2004:04:04:08","10","1000","19.60","10","1.96","3000","0.50","130.56","EUR",false,"fa104a:q2232a","hp");
        ezbuyExperience="direct";
        SB_smb=SB;
    }
    if(HP_Store_JumpID_SMB){HPStore_jumpID_detect("smb");ezbuyExperience = "direct";}
    storeId_publish("smb",m_s);
    if(SingleStore){
        if (HP_Store_JumpID_HHO) {
            HPStore_jumpID_detect("smb");
            ezbuyExperience = "direct";
            storeId_publish("smb","smb");
            } else if ((forced_partner)||(forced_channel)) {
            	ezbuyExperience = "channel";
        }
    }
    SB=SB_smb;
    ezbuyExperience_smb=ezbuyExperience;
    if (SB && ezbuyFlag) {
        SB_smb=true;
        sb_quantity=SB.quantity;
        sb_total_q=SB.quantity*1.0;
        storeUrl=storeUrl.indexOf("?")!=-1?storeUrl+'&s='+siteId+'&p='+SB.storeId:storeUrl+'?s='+siteId+'&p='+SB.storeId
        DrawBasket(place,"smb",SB);
    }
    if(SingleStore){
        ezbuyExperience_hho=ezbuyExperience;
        ezbuyFlag_hho=false;
    }
    // HHO
    SB=null;
    if(!SingleStore){
        initializeParameters("hho");
        setEzbuyFlag();
        ezbuyFlag_hho=ezbuyFlag;
        setExperience("hho",m_s);
        if (debug && !SB) {
            SB = new SBo(storeId,"2004:04:04:08","10","1000","19.60","10","1.96","3000","0.50","130.56","EUR",false,"fa104a:q2232a","hp");
            ezbuyExperience="direct";
            SB_hho=SB;
        }
        if(HP_Store_JumpID_HHO){HPStore_jumpID_detect("hho");ezbuyExperience = "direct";}
        storeId_publish("hho",m_s);
        SB=SB_hho;
        ezbuyExperience_hho=ezbuyExperience;
        if (SB && ezbuyFlag ) {
            SB_hho=true;
            sb_total_q=1.0*sb_total_q+1.0*SB.quantity;
            sb_quantity=SB.quantity;
            storeUrl=storeUrl.indexOf("?")!=-1?storeUrl+'&s='+siteId+'&p='+SB.storeId:storeUrl+'?s='+siteId+'&p='+SB.storeId
            DrawBasket(place,"hho",SB);
        }
    }
    if (storeMeans_hho&&storeMeans_smb&&place=='left'&&ezbuyExperience_hho!="epp"&&ezbuyExperience_hho!="epp") {
        if(SB_smb&&ezbuyFlag_smb){
            initializeParameters("smb");           
            DrawPhone(place,"smb");
        }
        if(SB_hho&&ezbuyFlag_hho){
            initializeParameters("hho");
            DrawPhone(place,"hho");
        }
        if(sb_total_q==0 && (document.cookie.indexOf("new_sb")!=-1 || (window.ab_testing_splash && ab_testing_splash!=""))){
		var country = (window.s_prop7)?window.s_prop7:"";
		var lang = (window.s_prop8)?window.s_prop8:"";
		if (document.cookie.indexOf("hpstore_"+s_prop7+"_"+s_prop8)!=-1){
			if(sb_print && document.getElementById('SB_PRINT_'+place)){
				t=get_buy_partner_link(place, "");
				t=t.replace(/#BuyPartnerUrl#/g,'<a href="javascript:EZB_SetNeutral();window.location.href=window.location.href;">'+lBuyPartner+'</a>');
				document.getElementById('SB_PRINT_'+place).innerHTML+=t;
			}
		}
	    }
	}
    // for add to basket script
    initializeParameters(m_s);
    ezbuyExperience=(m_s=="hho")?ezbuyExperience_hho:ezbuyExperience_smb;
    (ezbuyExperience=="channel")?catalogUrl="":"";
    if(SB_smb&&SB_hho){
        if(window.s_prop5){
            s_prop5="DualBasket|"+s_prop5;
            }else{
            s_prop5="DualBasket";
        }
    }
}
//alert('not empty');
}
//else{alert('empty');}