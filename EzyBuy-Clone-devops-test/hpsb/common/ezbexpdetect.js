if(!window.ezbexpdetectLoaded){
// ***************************
// *** JUMP ID DEFINITION
// ***************************
var DirectjumpIDList = new Array("hmc_","r1129","r11219","ezb_direct","forced_direct","direct");
var ChanneljumpIDList = new Array("ezb_channel","forced_channel");
var PartnerjumpIDList = new Array("ezb_partner","forced_partner");

var forced_channel=false;
var forced_partner=false;
var ezbPartnerList ="";
// epp store ID
var ezbStoreId = "";
// epp content
var ezbEppId = "";

// EZBuy scenarios are based on these variables
var ezbuyExperience = "";
// list of product numbers
var ezbuyPNList = "";

// ***************************
// *** OBJECTS DEFINITION
// ***************************
// class and method to build a shopping basket object
function SBo(storeId, expirationTime, quantity, netAmount, vat, shippingCharge, vatShippingCharge, grossAmount, grossShippingCharge, totalAmount, currency, bundleFlag, productNumberList, privatePricingMode) {
	this.storeId = storeId;
	this.expirationTime = expirationTime;
	this.quantity = quantity;
	this.netAmount = netAmount;
	this.vat = vat;
	this.shippingCharge = shippingCharge;
	this.vatShippingCharge = vatShippingCharge;
	this.grossAmount = grossAmount;
	this.grossShippingCharge = grossShippingCharge;
	this.totalAmount = totalAmount;
	this.currency = currency;
	this.bundleFlag = bundleFlag;
	this.productNumberList = productNumberList;
	this.privatePricingMode = privatePricingMode;
}

function dw(string){document.writeln(string);}

function write_cookie (name,value) {
	var argv=write_cookie.arguments;
	var argc=write_cookie.arguments.length;
	var expires=(argc > 2) ? argv[2] : null;
	var path=(argc > 3) ? argv[3] : null;
	var domain=(argc > 4) ? argv[4] : null;
	var secure=(argc > 5) ? argv[5] : false;

	(l4=="ez-debug")?domain=null:"";

	document.cookie=name+"="+value+
	((expires==null) ? "" : ("; expires="+expires.toGMTString()))+
	((path==null) ? "" : ("; path="+path))+
	((domain==null) ? "" : ("; domain="+domain))+
	((secure==true) ? "; secure" : "");
}

function twoDigit(str) {
	if (str>9) return str;
	else return '0'+str;
}

function read_cookie (myIndex) {

	var SB_read;
	itemlist=0;

	countbegin=(the_cookie.indexOf('=',myIndex)+1);
	countend=the_cookie.indexOf(';',myIndex);
	if (countend==-1) { countend=the_cookie.length; }
	fulllist=the_cookie.substring(countbegin,countend);

	if (verbose) dw("HPStore Cookie :" + hpstore_cookie_name + '<br>' + fulllist+'<br>');
	// transform line into sb object
	theStoreId=0;theExpirationTime="";theQuantity=0;theNetAmount=0;theVat=0;theShippingCharge=0;
	theShippingChargeVat=0;theTotalAmount=0;theCurrency=0;theBundle=0;theGrossAmount=0;
	theGrossShippingCharge=0;theProductNumberList=0;thePrivatePricingMode=0;

	for (var i=0; i<=fulllist.length;i++) {
		if (fulllist.substring(i,i+1)=='[') {
			itemstart=i+1;
			thisitem=1;
		 } else if (fulllist.substring(i,i+1)=='|'||fulllist.substring(i,i+1)==']') {
			tmpStr=fulllist.substring(itemstart,i);
			tmpl=tmpStr.substring(0,tmpStr.indexOf('='));
			tmpValue=tmpStr.substring(tmpStr.indexOf('=')+1,tmpStr.length);
			if (tmpl=='sid') theStoreId=tmpValue;
			if (tmpl=='t') theExpirationTime=tmpValue;
			if (tmpl=='q') theQuantity=tmpValue;
			if (tmpl=='na') theNetAmount=tmpValue;
			if (tmpl=='vat') theVat=tmpValue;
			if (tmpl=='sc')  theShippingCharge=tmpValue;
			if (tmpl=='scv') theShippingChargeVat=tmpValue;
			if (tmpl=='ga')  theGrossAmount=tmpValue;
			if (tmpl=='gs')  theGrossShippingCharge=tmpValue;
			if (tmpl=='tot') theTotalAmount=tmpValue;
			if (tmpl=='c')   theCurrency=tmpValue.replace("@#@",";");
			if (tmpl=='o')   theBundle=tmpValue;
			if (tmpl=='pn') theProductNumberList=tmpValue;
			if (tmpl=='pp') thePrivatePricingMode=tmpValue;

			tmpStr='';tmpl='';tmpValue='';
			thisitem++; itemstart=i+1; itemlist=1;
		}
	}

	if (escape(theCurrency)=='%80' && window.currency) {//some browsers issue
		theCurrency = window.currency;
	}
	// Create object
	if (itemlist==1) {
		SB_read = new SBo(theStoreId,
				theExpirationTime,
				theQuantity,
				theNetAmount,
				theVat,
				theShippingCharge,
				theShippingChargeVat,
				theGrossAmount,
				theGrossShippingCharge,
				theTotalAmount,
				theCurrency,
				theBundle,
				theProductNumberList,
				thePrivatePricingMode);
	}
	return SB_read;
}


function setExperience (segment,page_segment) {

	var globalSiteId = country + "_" + lang + "_" + segment;
	if (ezbuyExperience!="neutral") {
	ezbuyExperience="channel";}

	(window.the_cookie&&the_cookie.length>0)?0:the_cookie=document.cookie;

	hpstore_cookie_name = 'hpstore_'+globalSiteId;
	forced_channel_cookie_name = 'hpstore_channel_' + globalSiteId;
	forced_partner_cookie_name = 'hpstore_partner_' + globalSiteId;
	epp_cookie_name = 'hpstore_' + globalSiteId.substring(0,globalSiteId.length-3) + 'epp';
	hpstore_segment_free_cookie_name = 'hpstore_' + globalSiteId.substring(0,globalSiteId.length-3);
	forced_channel_segment_free_cookie_name = 'hpstore_channel_' + globalSiteId.substring(0,globalSiteId.length-3);
	forced_partner_segment_free_cookie_name = 'hpstore_partner_' + globalSiteId.substring(0,globalSiteId.length-3);

	index=the_cookie.indexOf(hpstore_cookie_name+'=');
	index_forced_channel=the_cookie.indexOf(forced_channel_cookie_name);
	index_forced_partner=the_cookie.indexOf(forced_partner_cookie_name);
	index_epp=the_cookie.indexOf(epp_cookie_name+'=');

	index_cookie_smb=the_cookie.indexOf(hpstore_segment_free_cookie_name+'smb=');
	index_cookie_hho=the_cookie.indexOf(hpstore_segment_free_cookie_name+'hho=');

	index_forced_channel_segment_free=the_cookie.indexOf(forced_channel_segment_free_cookie_name);
	index_forced_partner_segment_free=the_cookie.indexOf(forced_partner_segment_free_cookie_name);

	// if forced_channel cookie is there, it is alone
	// forced_channel cookie could not be set if HP store cookie or forced_partner cookie
	// So if there is a cookie set by HP Store afterwards, it should be ignored
	if (index_forced_channel!=-1) {
		ezbuyExperience="forced_channel";
		(segment==page_segment)?forced_channel=true:"";
	} else {
		// if forced_partner cookie is there, it is alone
		// forced_partner cookie could not be set if HP store cookie or forced_channel cookie
		// So if there is a cookie set by HP Store afterwards, it should be ignored
		if (index_forced_partner!=-1) {
			ezbuyExperience="forced_partner";

			if (segment==page_segment) {
				forced_partner=true;
				countbegin=(the_cookie.indexOf('=',index_forced_partner)+2);
				countend=the_cookie.indexOf(';',index_forced_partner);
				if (countend==-1) { countend=the_cookie.length; }
				fulllist=the_cookie.substring(countbegin,countend-1);
				fulllist=fulllist.replace(/@#@/g,";");
				ezbPartnerList=fulllist.substring(fulllist.indexOf('=')+1,fulllist.length);
				if(verbose)dw("ezbPartnerList :" +ezbPartnerList+'<br>');
			}
		} else {

				((index_cookie_hho!=-1) || (index_cookie_smb!=-1))?ezbuyExperience="direct":"";

				if ((index_forced_channel_segment_free==-1) && (index_forced_partner_segment_free==-1)) {
					if (index_epp!=-1) {
						ezbuyExperience="epp";
						SB = new SBo();
						SB = read_cookie(index_epp);
						SB_hho = new SBo();
						SB_hho = SB;
						if ((SB_hho.privatePricingMode) && (SB_hho.storeId) && (segment==page_segment)) {
							ezbEppId = SB_hho.privatePricingMode;
							if(verbose)dw('ezbEppId : '+ezbEppId+'<br>');
							ezbStoreId = SB_hho.storeId;
							if(verbose)dw("ezbStoreId :" +ezbStoreId+'<br>');
						}
					} else {
						if (index!=-1) {
							ezbuyExperience="direct";
							SB = new SBo();
							SB = read_cookie(index);

							if(segment.indexOf("hho")!=-1){
								SB_hho = new SBo();
								SB_hho = SB;
							}else{
								SB_smb = new SBo();
								SB_smb = SB;
							}
							ezbStoreId = SB.storeId;
							if(verbose)dw("ezbStoreId :" +ezbStoreId+'<br>');
						}
					}
				} else {
				ezbuyExperience="channel";
				}
		}
	}

	//All the following need to be done for the segment of the page only
	if (segment==page_segment) {

		if (SB) {
			if (SB.productNumberList) {
				ezbuyPNList = SB.productNumberList;
				if(verbose)dw('ezbuyPNList : '+ezbuyPNList+'<br>');
			}
		}

		// Channel JumpId detection
		if ( ezbuyExperience == "channel" || ezbuyExperience == "neutral" ) {
			for (var i = 0; i < ChanneljumpIDList.length; i++){
				if (window.top.location.search.toLowerCase().indexOf(ChanneljumpIDList[i]) !=-1) {
					ezbuyExperience="forced_channel";
					forced_channel=true;

					var expdate = new Date();
					// expiration date set-up 1 week later
					expdate.setTime(expdate.getTime() +  (7 * 24 * 3600 * 1000));
					var expdate_str = expdate.getFullYear() + ':' + twoDigit(expdate.getMonth()+1) + ':' + twoDigit(expdate.getDate()) + ':' + twoDigit(expdate.getHours()) + ':' + twoDigit(expdate.getMinutes());
					var name = 'hpstore_channel_'+globalSiteId;
					var value = '['+'t='+expdate_str+']';
					value=value.replace(/;/g,"@#@");
					write_cookie (name,value,null,"/","hp.com");
					break;
				}
			}
		}

		// Partner JumpId detection
		if ( ezbuyExperience == "channel" || ezbuyExperience == "neutral" ) {
			for (var i = 0; i < PartnerjumpIDList.length; i++){
				mylocation = window.top.location.search.toLowerCase();
				pos_jumpID = mylocation.indexOf(PartnerjumpIDList[i]);
				if (pos_jumpID !=-1) {
					ezbuyExperience="forced_partner";
					forced_partner=true;
					pos_begin=pos_jumpID+15;
					var temp=mylocation.substring(pos_begin);
					pos_end=temp.indexOf("&");
					(pos_end==-1)?pos_end=temp.length:"";
					ezbPartnerList=temp.substring(0,pos_end);
					if(verbose)dw("ezbPartnerList :" +ezbPartnerList+'<br>');

					var expdate = new Date();
					// expiration date set-up 1 week later
					expdate.setTime(expdate.getTime() +  (7 * 24 * 3600 * 1000));
					var expdate_str = expdate.getFullYear() + ':' + twoDigit(expdate.getMonth()+1) + ':' + twoDigit(expdate.getDate()) + ':' + twoDigit(expdate.getHours()) + ':' + twoDigit(expdate.getMinutes());
					var name = 'hpstore_partner_'+globalSiteId;
					var value = '['+'partnerList='+ ezbPartnerList +']';
					value=value.replace(/;/g,"@#@");
					write_cookie (name,value,null,"/","hp.com");
					break;
				}
			}
		}

		// HP Store JumpID detection
		if ((( ezbuyExperience == "neutral" ) || (( ezbuyExperience == "channel" ) && (index_forced_channel_segment_free==-1) && (index_forced_partner_segment_free==-1)) || ( ezbuyExperience == "direct" && !SB ))  ) {

			for (var i = 0; i < DirectjumpIDList.length; i++){
				var s_eVarCheck=""+s_eVar15+s_eVar16+s_eVar17+s_eVar18+s_eVar19+s_eVar20+s_prop12+l4;
				if (window.top.location.search.toLowerCase().indexOf(DirectjumpIDList[i]) !=-1 || s_eVarCheck.toLowerCase().indexOf(DirectjumpIDList[i]) != -1) {
					ezbuyExperience="direct";
					if(page_segment.toLowerCase().indexOf("hho")!=-1){
						HP_Store_JumpID_HHO = true;
					}else{
						HP_Store_JumpID_SMB = true;
					}
					break;
				}
			}
		}
		// end of if
	}

// End of setExperience
}

var t_segment;
(window.top.location.toString().indexOf("ho")==-1)?t_segment="smb":t_segment="hho";
var country = (window.s_prop7)?window.s_prop7:"";
var lang = (window.s_prop8)?window.s_prop8:"";
var m_s = (window.s_prop9)?window.s_prop9:t_segment;
(window.s_prop4&&s_prop4.length>0)?l4=window.s_prop4:l4="-";
var SB=null;
var HP_Store_JumpID_HHO = false;
var HP_Store_JumpID_SMB = false;
var s_eVar15,s_eVar16,s_eVar17,s_eVar18,s_eVar19,s_eVar20,s_prop12;
var ezbuyExperience_smb,ezbuyExperience_hho;
var SB_smb=false,SB_hho=false;

verbose = (window.top.location.search.indexOf("verbose=true") !=-1)?true:false;

setExperience("smb",m_s);
ezbuyExperience_smb=ezbuyExperience;

//alert("banner :" + ezbuyExperience_smb);
setExperience("hho",m_s);
ezbuyExperience_hho=ezbuyExperience;
//alert("banner :" + ezbuyExperience_hho);
ezbuyExperience=(m_s=="hho")?ezbuyExperience_hho:ezbuyExperience_smb;
verbose?dw("EZBuy Experience : " + ezbuyExperience):"";

var ezbexpdetectLoaded = true;
if(window.old_s_prop9)
	s_prop9=old_s_prop9;
}
