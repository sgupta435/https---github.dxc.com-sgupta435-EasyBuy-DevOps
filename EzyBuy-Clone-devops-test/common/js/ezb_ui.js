/**
 * EZBuy Prototype
 * @author  Silke Stolle 
 */

var is_rtl=false;
if(window.ezb_css_force)
	ezb_css_s='http://cdn-h41213.www4.hp.com';
var ezb_css_img_path='/ezbuy/html/img/ezb.v3/';
var ezb_css_img_location=ezb_css_s+ezb_css_img_path;

var icon_close='icon.close.g'+'if';
var icon_info='icon.info.g'+'if';
var icon_btn_basket='icon.btn-basket.g'+'if';

/**
 * Default settings for all ezBuy Boxes - adopt to your needs
 */
function EZDefaults() {

  //
  // EzBuy Frame
  //
  this.ezframeWhite = true;
  this.ezframeRTL = false;
  
  //
  // Elements
  //
  this.elements = new Array();

  // Price (badge)
  this.elements.pricelasts = true;
  this.elements.strikeThrough = true;
  this.elements.prff = false;
  
  // Logo
  this.elements.logo = true;
  
  // Shopping area
  this.elements.shopping = true;
  this.elements.basket = true;  
  this.elements.customiseLink = true;
  
  // Footer
  this.elements.footer = true;
  this.elements.buyFromPartner = false;
  
  
  //
  // Texts
  //
  this.text = new Array();
  
  // Header
  this.text.intro = 'HP Best Buy';
  
  // Price information
  this.text.oldprice = '666,- \u20ac';
  this.text.price = '5,- \u20ac';
  this.text.pricevat = 'Ex. VAT';
  this.text.priceinfo = 'Tooltip Non-Promo';
  this.text.pricelasts = 'Last 5 days';  
  this.text.priceXinfo = 'info';  

  // Logo
  this.text.logosource = 'img/amd_64.g'+'if';
  //this.text.logolink = 'http://www.intel.com';
  this.text.logoalt = 'Image description: Intel Centrino';  
  
  // Shopping area
  this.text.addToBasket = 'Add to basket';
  this.text.delivery = 'Normally within 2 weeks';
  this.text.customiseButton = 'Customise and buy directly from HP';
  this.text.customise = 'Customise';
  this.text.customiseLink = 'Customise this product';
  this.text.buyOnlineFromPartner = 'Buy online from an HP preferred partner';
  this.text.buyFromPartner = 'Buy from partner';  
  this.text.selectAShop = 'Select a shop to buy online:';
  this.text.limitedStock = '* limited stock';
  this.text.buyNow = 'Buy now';
  this.text.noShopping = 'Call HP for availbility <br />0845 270 4212';
  this.text.errSelDealer = 'Please select a shop';
  
  // Footer
  this.text.localPartner = 'Find a local partner';
  this.text.localPartnerButton = 'Find a local partner';
  
	//Screen 2 (Dealerselection)
	dealer[this.id] = new Array();

  // Screen 3 (leave HP website)
  this.text.thankYou = 'Thank you for selecting an e-Preferred Specialist';
  this.text.leaveHPInfo = 'In 5 seconds you will leave the HP website';
  this.text.goNow = 'Go now';
  this.text.backButton = 'back';
  this.text.partnerimage = ezb_css_img_location+'pref_ptnr.j'+'pg';
  
  
  //
  // Actions
  //
  this.actions = new Array();  

  // Specify target script for order here
  this.actions.formTarget = 'http://www.hp.com/orderTarget';

  // Specify 'customise product' link here
  this.actions.customiseButton = 'http://www.hp.com/customiseButton';

  // Specify 'find a local partner' link here
  this.actions.localPartner = 'http://www.hp.com/findALocalPartner';

  // Specify 'customise' link here (in shopping area/below basket)
  this.actions.customiseLink = 'http://www.hp.com/customiseLink';  

}

/*******************************************************************************************************
   YOU SHOULD NOT HAVE TO CHANGE ANYTHING BELOW HERE 
 *******************************************************************************************************/

/**
 * Draw function
 */
function EZDraw(ret,rtl) {

if(rtl) is_rtl=true;

rtl?rtl_add=' dir = "rtl" align = "right" ':rtl_add='';

  this.content = "";

	if (this.promo == "noprice") {
		this.content = '<div id="'+this.id+'" class="box"'+rtl_add+'><strong>'+this.text.noShopping+'</strong></div><div class="line"></div>';
      
	} else {
  
    if (!document.getElementById('tooltip')){ 
      this.content += '<div class="tooltip" id="tooltip"></div>';
    }
  this.content += '<div id="'+this.id+'" class="box"'+rtl_add+'>';
  this.content += this.promo ? '<div class="promo">' : '<div class="nonpromo">';
  if (this.promo == "simple") {
    if (this.elements.logo == true){
      this.content += '<div class="simple" style="text-align: left;">'
    }else {
      this.content += '<div class="simple" style="text-align: center !important;">'
    }
  } else {
  this.content += this._drawHeader();  
  }
  
  this.content += this._drawScreenOne();
  this.content += this._drawScreenTwo();
  this.content += this._drawScreenThree();
  
  if (this.promo != "simple") {
  
    this.content += this.ezframeWhite ? '<div class="boxend" style="background: url('+this.imageUrlWhite+'footer.png) top left no-repeat;"></div>' : '<div class="boxend" style="background: url('+this.imageUrlGrey+'footer.png) top left no-repeat;"></div>';
  }
  this.content += '</div></div></div>';
	}

  if (!document.getElementById('tooltip')){ 
      this.content += '<div class="tooltip" id="tooltip"></div>';
    }
  
  if (ret == true) {
    return(this.content);
  }else{
    document.write(this.content);
  }
    
  return true;
}

function EZHeader() {
  var headercolor = '#000000';

  var img = '';
  
  if (this.text.intro) {
    
    if (this.promo) {
      img = 'header.'+this.theme+'.png';
      if (this.theme == 'FFCC00'){
        headercolor = '#000000';
      } else {
        headercolor = '#FFFFFF';
      }
    } else {
      img = 'header.grey.png';
    }
    //var img = this.promo ? 'header.'+this.theme+'.png' : 'header.grey.png';
  }
  else {
    img = 'header.none.png';
  }
  
  
  var str = this.ezframeWhite ? '<div class="header" style="background: white url('+this.imageUrlWhite+'headers/'+img+') top left no-repeat; color:'+headercolor+'"><h1>'+this.text.intro+'</h1></div>' : '<div class="header" style="background: white url('+this.imageUrlGrey+'headers/'+img+') top left no-repeat; color:'+headercolor+'"><h1>'+this.text.intro+'</h1></div>';

  return (str);
}


function EZScreenOne() {
  var str  = '<div id="'+this.id+'_sc1">';
  str += '<div class="content">';
  str += this._drawPriceContainer();
  if (this.elements.shopping == true) {
    str += this.elements.basket == true ? this._drawAddToBasket() : this._drawCustomiseButton();
			
  } else {
  	if(this.elements.store_available){
	    str += '<div style="clear:both;"></div>';
	    str += '<strong><br />'+this.text.noShopping+'</strong>';
    }
  }
  	if (this.elements.footer == true &&( this.elements.shopping == true || this.elements.store_available) && this.promo != "simple") {
			str += '<div class="line"></div>';
		}

  if (this.elements.footer == true) {
    str += (dealer[this.id].length > 0 && this.elements.buyFromPartner == true) ? this._drawFooter() : this._drawFooter2();
  }
  str += '</div>';
  str += '</div>';

  return (str);
}

function EZPriceContainer() {
    
    var str = '';
    
    
    
    if (this.elements.logo == true){
      str += '<div class="priceContainer" style="color:#'+this.theme+';height:90px;">';
    }
    else if (this.promo == "simple") {
      str +='<div class="priceContainer">';
    }
    else {
      str +='<div class="priceContainer" style="color:#'+this.theme+';">';
    }
    
    
    
  //var str  = '<div class="priceContainer" style="color:#'+this.theme+'">';
  if (this.promo == true) {
    str += this._drawPriceBadgeContainer();
  } else {
  	if(this.elements.price_has){
  	  str += this._drawPriceHeader();
  	  str += this._drawPriceNum();
  	  str += this._drawPriceVat();
  	  }
   } 
	if (this.elements.logo == true) {
    str += this._drawLogo();
  }
  str += '</div>';

  return (str);
}

function EZLogo() {
	var str = '';
  
	if (!this.promo && this.ezframeRTL == true) {  
    if (this.elements.priceLasts == true) {
      str += '<div class="logo" style="right:110px!important;top:17px;">'
    }
    else {
      str += '<div class="logo" style="right:110px!important;">';
    }
		str += ''+ ((this.text.logolink)?'<a target="_blank" href="'+this.text.logolink+'">':'') + '<img src="'+this.text.logosource+'" alt="'+this.text.logoalt+'" title="'+this.text.logoalt+'" class="logo" />'+ ((this.text.logolink)?'</a>':'') +'</div>';
	} else {
    if (this.elements.priceLasts == true) {
      str += '<div class="logo" style="top:17px;">';
    }
    else {
      str += '<div class="logo">';
    }
      str += ''+ ((this.text.logolink)?'<a target="_blank" href="'+this.text.logolink+'">':'') + '<img src="'+this.text.logosource+'" alt="'+this.text.logoalt+'" title="'+this.text.logoalt+'" class="logo" />'+ ((this.text.logolink)?'</a>':'') +'</div>';
    }
    return (str);
}




function EZPriceBadgeContainer() {
  var str  = '<div class="priceBadgeContainer">';
  str += this._drawPriceBadge();
  str += '</div>';
  
  return (str);
}

function EZPriceBadge() {

  if (this.promo == true) {
    if (this.text.price.replace(/&[^;]*;/g," ").length <= 6 && this.text.oldprice.replace(/&[^;]*;/g," ").length <= 8 && this.text.pricevat.length <= 7) {
      var str  = '<div class="priceBadge" onMouseOver="tip_it(\''+this.id+'\' ,1,\''+this.text.priceinfo+'\', \''+this.text.priceXinfo+'\',true);" >';
    } else {
      var str  = '<div class="priceBadgeLarge" onMouseOver="tip_it(\''+this.id+'\' ,1,\''+this.text.priceinfo+'\', \''+this.text.priceXinfo+'\',true);" >';
    }    
    if(this.elements.price_has){
        str += this._drawPriceHeader();
        str += this._drawPriceNum();
        str += this._drawPriceVat();
    }
    if (this.elements.priceLasts == true) {
      str += this._drawPriceLasts();
    }
    str += '</div>';
  } 
  
  return (str);
}

function EZPriceHeader() {
  if (this.promo == true){
    var str  = this.text.oldprice ? '<span class="priceHeader" style="padding-top:5px;">' : '<span class="priceHeader">';
    
      /*if (this.elements.strikeThrough == true) {
        str += this.text.oldprice;
      } else {*/
        str += this.text.oldprice;
      //}
    str += '</span>';
    
  } else if  (this.promo == "simple"){
    var str  = this.text.oldprice ? '<div class="priceHeader promomessage">'+this.text.oldprice+'</div>' : '';
    str  += '<div class="price">';
    str  += '<span class="priceHeader">'+this.text.pricedesc;
    if (this.text.priceinfo &&  this.text.priceinfo != ''){
      str += '<a href="#" onmouseover="javascript:tip_it(\''+this.id+'\' ,1,\''+this.text.priceinfo+'\', \''+this.text.priceXinfo+'\');" class="infotip"><img src="'+ezb_css_img_location+icon_info+'" alt="Info" /></a>';
    
    }
    str += '</span>';
  } else {
    var str  = '<span class="priceHeader">'+this.text.pricedesc;
    if (this.text.priceinfo &&  this.text.priceinfo != ''){
      str += '<a href="#" onmouseover="javascript:tip_it(\''+this.id+'\' ,1,\''+this.text.priceinfo+'\', \''+this.text.priceXinfo+'\');" class="infotip"><img src="'+ezb_css_img_location+icon_info+'" alt="Info" /></a>';
    }
    str += '</span>';
  }
  
  return (str);
}

function EZPriceNum() {
  if (this.promo == "simple") {
    var str = '';
  }
  else if (this.elements.logo == true){
   // var str  = '<span class="priceNum" style="width:105px;">';
     var str  = '<span class="priceNum">';
  }
  else {
    var str  = '<span class="priceNum">';
  }
  if (this.promo != "simple") {
    if (this.promo == true) {
     // if (this.text.price.replace(/&[^;]*;/g," ").length <= 9) { 
      if (false) { 
        str += this.text.price;
      } else {
        if(!vat_displayed){
        	str += '<span class="promosmall">'+this.text.price+'</span><br/><span class="priceVat">'+this.text.pricevat+'</span>';
        	vat_displayed=true;
        }	
      }
    } else {
      //if (this.text.price.replace(/&[^;]*;/g," ").length <= 8) {
      if (false) {
        str += this.text.price;
      } else {
        if(!vat_displayed){
        	//str += '<span class="small">'+this.text.price+'</span><br/><span class="priceVat">'+this.text.pricevat+'</span>';
        	str += '<span class="small">'+this.text.price+'</span><span class="priceVat">'+this.text.pricevat+'</span>';
        	vat_displayed=true;
        }	
      }
    }
  
  } else {
   str += ''+this.text.price+' ';
   //if (this.text.price.length >= 10) {
   // str += '<br />';
   //}
   if(!vat_displayed){
   	str += '<span class="priceVat"> '+this.text.pricevat+'</span>';
   	vat_displayed=true;
   }
   str += '</div>';
  }
  
  str += '</span>';

  return (str);
}

function EZPriceVat() {
  var str = '';
  if (this.promo != "simple") {
    if(!vat_displayed){
    	str  += '<span class="priceVat">'+this.text.pricevat+'</span>';
    	vat_displayed=true;
    }	
  }
  if(this.elements.prff){
  	str += '<div class="delivery" style="color:black;">'+this.text.prff1+'<br />'+this.text.prff2+'</div>';
  }
  
  return (str);
}

function EZPriceLasts() {
  var str  = '<span class="priceLasts">'+this.text.pricelasts+'</span>';
  
  return (str);
}

function EZAddToBasket() {
  /*if (alreadyinbasket) {
    var str  = '<div class="addToBasket done">';
  } else*/
     
     var str  = '<div class="addToBasket">';
        
  //}
  var t=(this.elements.qty==true)?"text":"hidden";
  var basket=(this.elements.qty==true)?' <img src="'+ezb_css_img_location+icon_btn_basket+'" alt="">':'';
  

  str += '<form method="post" action="'+this.actions.formTarget+'" id="'+this.id+'_basketForm" name="'+this.id+'_basketForm">';
  if (this.ezframeRTL == true) {
    str += '<input class="txt" type="'+t+'" size="1" name="'+this.id+'_ezb_qty" value="1" maxlength="2" style="float:right;margin-left:4px;" />'+'<a class="secButtonEnhanced" href="javascript:document.getElementById(\''+this.id+'_basketForm\').submit()" style="float:right;">'+this.text.addToBasket+basket+' </a><div style="clear:both;"></div><span class="delivery">&nbsp;'+this.text.delivery+'&nbsp;</span><br />';
  } else {
    str += '<input class="txt" type="'+t+'" size="1" name="'+this.id+'_ezb_qty" value="1" maxlength="2" />'+'<a class="secButtonEnhanced" href="javascript:document.getElementById(\''+this.id+'_basketForm\').submit()">'+this.text.addToBasket+basket+' </a><br /><div style="clear:both;"></div><span class="delivery">'+this.text.delivery+'</span><br />';
  }
 
  if (this.elements.customiseLink == true) {
    str += this._drawCustomiseLink();
  }
  str += '</form>';
  str += '</div>';
  
  return (str);
}

function EZCustomiseButton() {
  var str = this.ezframeRTL ? '<div class="customiseButton" style="color:#'+this.theme+'"><p>'+this.text.customiseButton+'</p><a class="secButtonEnhanced" href="'+this.actions.customiseButton+'" style="padding:2px 0 2px 0;">&nbsp;'+this.text.customise+'&nbsp;&raquo;&nbsp;</a></div>' : '<div class="customiseButton" style="color:#'+this.theme+'"><p>'+this.text.customiseButton+'</p><a class="secButtonEnhanced" href="'+this.actions.customiseButton+'">'+this.text.customise+'&nbsp;&raquo;</a></div>';
  
  return (str);
}

function EZCustomiseLink() {
  var str = '<span style="color:#'+this.theme+'">&raquo;&nbsp;</span><a href="'+this.actions.customiseLink+'">'+'<span style="color:#'+this.theme+'">'+this.text.customiseLink+'</span>'+'</a>';
  return (str);
}

function EZFooter () {
  var str = '';
  if (this.promo == 'simple') {
    if (this.elements.logo == true){
      str += '<div class="simplefooter" style="text-align:left;">';
    } else {
      str += '<div class="simplefooter" style="text-align:center;">';
    }
  } 
  else {
    str += '<div class="footer" style="color:#'+this.theme+';">';
  }
    str  += this.ezframeRTL ? '<p>'+this.text.buyOnlineFromPartner+'</p><div style="clear:both;"></div><a class="secButtonEnhanced" href="javascript:'+this.actions.BuyPartnerClick+';EZswitchScreens(\''+this.id+'\',\'2\');" style="padding:2px 0 2px 0;">&nbsp;'+this.text.buyFromPartner+'&nbsp;&raquo;&nbsp;</a></div>' : '<p>'+this.text.buyOnlineFromPartner+'</p><div style="clear:both;"></div><a class="secButtonEnhanced" href="javascript:'+this.actions.BuyPartnerClick+';EZswitchScreens(\''+this.id+'\',\'2\');">'+this.text.buyFromPartner+'&nbsp;&raquo;</a></div>';
  
  return (str);
}

function EZFooter2() {
var str="";
if(this.elements.localPartner)
  var str  = this.ezframeRTL ? '<div class="footer2" style="color:#'+this.theme+'"><p>'+this.text.localPartner+'</p><a class="secButtonEnhanced" href="'+this.actions.localPartner+'" style="padding:2px 0 2px 0;">&nbsp;'+this.text.localPartnerButton+'&nbsp;&raquo;&nbsp;</a></div>' : '<div class="footer2" style="color:#'+this.theme+'"><p>'+this.text.localPartner+'</p><a class="secButtonEnhanced" href="'+this.actions.localPartner+'">'+this.text.localPartnerButton+'&nbsp;&raquo;</a></div>';
  
  return (str);
}

function EZScreenTwo() {
  var str  = '<div style="display: none;" id="'+this.id+'_sc2" class="sc2">';
  str += '<div class="content">';
  str += this._drawDealerSelection();
  str += this._drawFooter_sc2();
  str += '</div></div>';
  
  return (str);
}

function EZDealerSelection() {
  var str  = '<form method="post" action="#" name="'+this.id+'_selectDealerForm"><label id="'+this.id+'_selDealerLabel">'+this.text.selectAShop+'</label><div class="selectDealer">';
  str += this._drawDealers();
  str += '</div>'+(this.elements.limitedStock?this.text.limitedStock:'')+'</form>';
  
  return (str);
}

function EZFooter_sc2() { 
  var str  = '<div class="footer">';
   if(this.elements.buyPartner){
//†IL Bug align issues 20081007 Start†
	if (this.ezframeRTL)
		str += '<a style="float:left;" '
	else
		str += '<a style="float:right;" '
	
   str += 'class="commButtonEnhanced" href="javascript:EZswitchScreens(\''+this.id+'\', \'3\');">'+this.text.buyNow+'&nbsp;&raquo;</a><div style="clear:both;"></div>';
   }
  if(this.elements.customisePartner){
	if (this.ezframeRTL)
		str += '<a style="float:left;" '
	else
		str += '<a style="float:right;" '

	str += 'class="secButtonEnhanced" href="javascript:'+this.actions.customisePartner+'(\''+this.id+'\',selectedDealer[\''+this.id+'\'].value)'+'">'+this.text.customisePartner+'&nbsp;&raquo;</a><br />&nbsp;';
	}
	if (this.ezframeRTL)
		str += '<a style="float:left;" '
	else
		str += '<a style="float:right;" '

	str += 'class="secButtonEnhanced" href="'+this.actions.localPartner+'">'+this.text.localPartnerButton+'&nbsp;&raquo;</a>';
	if (this.ezframeRTL)
		str += '<a style="float:right;" '
	else
		str += '<a style="float:left;" '

  str += 'class="secButtonEnhanced" href="javascript:EZswitchScreens(\''+this.id+'\', \'1\');" title="'+this.text.backButton+'">&laquo;</a>';
  str += '</div><div style="clear:both"></div>';
//†IL Bug align issues 20081007 End†  
  return (str);
}

function EZScreenThree() {
  var str  = '<div style="display: none;" id="'+this.id+'_sc3" class="sc2">';
//†IL Bug align issues 20081030 End†  
	if (this.ezframeRTL) {
		str += '<div class="content bold">'+this.text.thankYou+'<br /><img src="'+this.text.partnerimage+'" width="160" height="43" alt="" border="0" /><br />'+this.text.leaveHPInfo+'<br />&nbsp;<br />';
		str += '<a class="secButtonEnhanced" style="float:right;" href="javascript:'+this.actions.BuyPartnerClick+';EZswitchScreens(\''+this.id+'\', \'2\');" title="'+this.text.backButton+'">&laquo;</a>';
		str += '<a class="secButtonEnhanced" href="javascript:'+'EZB.Templates.Utils._BuyPartnerFormAction(\''+this.id+'\',selectedDealer[\''+this.id+'\'].value)'+';" >'+this.text.goNow+'&nbsp;&raquo;</a>';
	}
	else {
		str += '<div class="content bold">'+this.text.thankYou+'<br /><img src="'+this.text.partnerimage+'" width="160" height="43" alt="" border="0" /><br />'+this.text.leaveHPInfo+'<br />&nbsp;<br /><a class="secButtonEnhanced" style="float:right;" href="javascript:'+'EZB.Templates.Utils._BuyPartnerFormAction(\''+this.id+'\',selectedDealer[\''+this.id+'\'].value)'+';" >'+this.text.goNow+'&nbsp;&raquo;</a>';
		str += '<a class="secButtonEnhanced" href="javascript:'+this.actions.BuyPartnerClick+';EZswitchScreens(\''+this.id+'\', \'2\');" title="'+this.text.backButton+'">&laquo;</a>';
	}
//†IL Bug align issues 20081030 End†  
  /*if (this.promo == "simple"){
    str += '<a href="javascript:'+this.actions.BuyPartnerClick+';EZswitchScreens(\''+this.id+'\', \'2\');">&laquo; back</a>';
  } else {*/
  //}

  str += '<div style="clear:both"></div></div></div>';
  
  return (str);
}


/**
 * Constructor
 */
function EZBuy(type,id) {
	
  vat_displayed=false;	

  // Init attributes
  this.imageUrlWhite = ezb_css_img_location+'white/';
  this.imageUrlGrey = ezb_css_img_location+'grey/';
	switch (type) {
		
		case 'promo':;
		case true:
			this.promo = true;
			break;
		
		case 'simple':
			this.promo = 'simple';
			break;			
    
    /*case 'simpleac':
			this.promo = 'simpleac';
			break;	*/

		case 'noprice':
			this.promo = 'noprice';
			break;			

		default:
			this.promo = false;
	}
	
  this.theme = EZB.Context.theme ? EZB.Context.theme.replace(/#/, "") : '';
  if(id){
  	 this.id = 'EZBox_'+id;
  	}else{ 
  this.id = 'EZBox_'+Math.floor(Math.random() * 1000);
	  }
  this.content = '';

  // Used private methods
  this._drawHeader = EZHeader;
  this._drawScreenOne = EZScreenOne;
  this._drawPriceContainer = EZPriceContainer;
  this._drawLogo = EZLogo;
  this._drawPriceBadgeContainer = EZPriceBadgeContainer;
  this._drawPriceBadge = EZPriceBadge;
  this._drawPriceHeader = EZPriceHeader;
  this._drawPriceNum = EZPriceNum;
  this._drawPriceVat = EZPriceVat;
  this._drawPriceLasts = EZPriceLasts;
  this._drawCustomiseButton = EZCustomiseButton;
  this._drawAddToBasket = EZAddToBasket;
  this._drawCustomiseLink = EZCustomiseLink;
  this._drawFooter = EZFooter;
  this._drawFooter2 = EZFooter2;
  this._drawScreenTwo = EZScreenTwo;
  this._drawDealerSelection = EZDealerSelection;
  this._drawFooter_sc2 = EZFooter_sc2;
  this._drawScreenThree = EZScreenThree;
  this._drawDealers = EZShowDealer;
  this._markSelected = EZmarkSelected;
  this._loadDefaults = EZDefaults;

  // Used public methods
  this.addDealer = EZAddDealer;
  this.draw = EZDraw;

  // Init ezBuy
  this._loadDefaults();
  
}

function EZAddDealer(name, price, info, url, stock,type) {
  if (!dealer[this.id]) {
    dealer[this.id] = new Array();
  }
  var i = dealer[this.id].length;
  if (!i) i = 0;
  if (!dealer[this.id][i]) {
    dealer[this.id][i] = new Array();
  }  
  dealer[this.id][i]['name'] = name;
  dealer[this.id][i]['price'] = price;
  dealer[this.id][i]['info'] = info;
  dealer[this.id][i]['url'] = url;
  dealer[this.id][i]['stock'] = stock ? "*" : "&nbsp;";
  dealer[this.id][i]['type'] = type;
  
}

function EZShowDealer () {
  var strDealer = '';
  if(dealer[this.id]){
  for (var i=0;i<dealer[this.id].length;i++) {
	//†IL Bug align issues 20081008 Start†
	if (this.ezframeRTL) {
		strDealer  += '<div class="unselected" onclick="EZmarkSelected('+(i+1)+', \''+this.id+'\');" id="'+this.id+'_dl_' + (i+1) + '"><!-- #PARTNER --><input type="radio" class="radio" value="' + (i) + '" id ="'+this.id+'_dlradio_' + (i+1) + '" name="dealer">';
		strDealer  += '<div style="float:left;" class="dealerPriceCont"><div style="float:left;" class="dealerStock">'+dealer[this.id][i]["stock"] +'</div>';
		strDealer  += '<div style="float:left;" class="dealerPrice">' + swapIfNotNumeric(dealer[this.id][i]["price"]) +'</div></div>';
		strDealer  += '<div style="float:right;" class="radio"><a href="javascript:EZmarkSelected('+(i+1)+', \''+this.id+'\')" ondblclick="EZmarkSelected('+(i+1)+', \''+this.id+'\');EZswitchScreens(\''+this.id+'\', \'3\');"';
		if (dealer[this.id][i]["info"] != ""){
		  strDealer += ' onmouseover="tip_it(\''+this.id+'\',1,'+i+', \''+this.text.priceXinfo+'\', \''+this.text.priceXinfo+'\');" ';
		}
		
		strDealer += '>' + dealer[this.id][i]["name"] +'</a>';
		
		strDealer +='<\/div><\/label><br /><!-- #PARTNER --><\/div><div style="clear:both"><\/div>';
	}
	else {
		strDealer  += '<div class="unselected" onclick="EZmarkSelected('+(i+1)+', \''+this.id+'\');" id="'+this.id+'_dl_' + (i+1) + '"><!-- #PARTNER --><input type="radio" class="radio" value="' + (i) + '" id ="'+this.id+'_dlradio_' + (i+1) + '" name="dealer"><div class="radio"><a href="javascript:EZmarkSelected('+(i+1)+', \''+this.id+'\')" ondblclick="EZmarkSelected('+(i+1)+', \''+this.id+'\');EZswitchScreens(\''+this.id+'\', \'3\');"';
		if (dealer[this.id][i]["info"] != ""){
		  strDealer += ' onmouseover="tip_it(\''+this.id+'\',1,'+i+', \''+this.text.priceXinfo+'\', \''+this.text.priceXinfo+'\');" ';
		}
		
		strDealer += '>' + dealer[this.id][i]["name"] +'</a>';
		
		strDealer +='<\/div><div class="dealerPriceCont"><div class="dealerPrice">' + dealer[this.id][i]["price"]+'</div><div class="dealerStock">'+dealer[this.id][i]["stock"] +'</div></div><\/label><br /><!-- #PARTNER --><\/div><div style="clear:both"><\/div>';
	}
	//†IL Bug align issues 2008100 End†
  }
  return (strDealer);
  }
}

/* Dealer Selection */
var timeOut = null;
var dealer = new Array();
var selectedDealer = new Array();
var selectedDealerDiv = new Array();

function EZmarkSelected(i, id){
  var div = document.getElementById(id+"_dl_"+i);
  var radio = document.getElementById(id+"_dlradio_"+i);
  radio.checked = true;
  if (selectedDealerDiv[id]) {
    selectedDealerDiv[id].className = 'unselected';
  }
  div.className = 'selected';
  selectedDealer[id] = radio;
  selectedDealerDiv[id] = div;
  
}
function buyFromPartner(id) {
  if (selectedDealer[id]) {
    window.top.location.href = dealer[id][selectedDealer[id].value]['url'];
  }
}


/* switch Screens within EzBuy boxes */
              

function EZswitchScreens(id, screen) {

var s1 = document.getElementById(id+"_sc1");
var s2 = document.getElementById(id+"_sc2");
var s3 = document.getElementById(id+"_sc3");

  window.clearTimeout(timeOut);

  switch (screen){
		
    case '1': s1.style.display = '';
              s2.style.display = 'none';
              s3.style.display = 'none';
							if (selectedDealer[id]){
								selectedDealer[id].selected = false;
								selectedDealerDiv[id].className = "unselected";
								selectedDealer[id] = null;
								selectedDealerDiv[id] = null;
							}
							document.getElementById(id+'_selDealerLabel').className = "";
			  EZB.Render.Patch();
              break;
    case '2': s1.style.display = 'none';
              s2.style.display = '';
              s3.style.display = 'none';
              EZB.Render.Patch();
              break;
    case '3':
              if(dealer[id].length==1){
		EZmarkSelected(1,id);             	
              }
              if (!selectedDealerDiv[id]) {
                document.getElementById(id+'_selDealerLabel').className = "err";
                return;
              }
              if(EZB.Settings.options.toLowerCase().indexOf("no3rdscreen")==-1){
		      if (dealer[id][selectedDealer[id].value]['type']!="hp") {
			      s1.style.display = 'none';
			      s2.style.display = 'none';
			      s3.style.display = '';
		      }
	              var a='EZB.Templates.Utils._BuyPartnerFormAction'+'(\''+id+'\',selectedDealer[\''+id+'\'].value)';
	              timeOut = window.setTimeout(a, dealer[id][selectedDealer[id].value]['type']!="hp"?5000:1000);
      	      }else{
	              var a='EZB.Templates.Utils._BuyPartnerFormAction'+'(\''+id+'\',selectedDealer[\''+id+'\'].value)';
	              timeOut = window.setTimeout(a, dealer[id][selectedDealer[id].value]['type']!="hp"?1000:1000);
	      }
                break;
  }
}

/* Info Tooltip */
var tt_mouse_X;
var tt_mouse_Y;
var tip_active = 0;

function update_tip_pos(is_rtl){
  if(is_rtl)
  	document.getElementById('tooltip').style.left = ""+(tt_mouse_X - 120)+"px";
  else
  	document.getElementById('tooltip').style.left = ""+(tt_mouse_X - 20)+"px";
	document.getElementById('tooltip').style.top  = ""+(tt_mouse_Y + 10)+"px";
}

var tt_ie = document.all?true:false;
if (!tt_ie) document.captureEvents(Event.MOUSEMOVE);
document.onmousemove = getMouseXY;

function getMouseXY(e) {

	try{
		if (tt_ie && document.documentElement && document.documentElement.scrollTop)
		// Explorer 6 Strict
		{
			tt_mouse_X = event.clientX + document.documentElement.scrollLeft;
			tt_mouse_Y = event.clientY + document.documentElement.scrollTop;
		}
		else if (tt_ie && document.body) // all other Explorers
		{
	    tt_mouse_X = event.clientX + document.body.scrollLeft;
	    tt_mouse_Y = event.clientY + document.body.scrollTop;
	  }
		else // all except Explorer
		{
			tt_mouse_X = e.pageX;
			tt_mouse_Y = e.pageY;
		}
	  if(tip_active){update_tip_pos(is_rtl);}
	 }catch(e){} 
}

var ContentInfo = "";
var ContentInfoPromo = "";

function EnterContent(TContent,THeader){
  
  ContentInfo = '<div class="header"><a href="javascript:tip_it(null, 0, \'\');" style="" ><img src="'+ezb_css_img_location+icon_close+'" alt="Close" border="0"><\/a><\/div><div class="toolcontent">'+TContent+'<\/div>';
  ContentInfoPromo = '<div class="header"><a href="javascript:tip_it(null, 0, \'\');" style="" ><img src="'+ezb_css_img_location+icon_close+'" alt="Close" border="0"><\/a></div><div class="toolcontent" style="overflow: auto;">'+TContent+'<\/div>';

}

function tip_it(id, tip_active, i, header, promo){

		update_tip_pos(is_rtl);
		if (tip_active == 1 && String(i).length > 0) {

      document.getElementById('tooltip').style.visibility = "visible";

      
       if (!dealer[id] || !dealer[id][i]){
        EnterContent(i,header);
        document.getElementById('tooltip').innerHTML = promo ? ContentInfoPromo : ContentInfo;
      } else {
        EnterContent(dealer[id][i]["info"],header);
    	  document.getElementById('tooltip').innerHTML = promo ? ContentInfoPromo : ContentInfo;
      }
      
      
    }
	  else{
      document.getElementById('tooltip').style.visibility = "hidden";
	}
}
function swapIfNotNumeric(sVal) {
 //Check whether the first Char is Numeric.
 if (isNaN(sVal.substr(0,1))) {
  sVal=sVal.substr(1,sVal.length) + ' ' + sVal.substr(0,1);
 }
 return sVal;
}