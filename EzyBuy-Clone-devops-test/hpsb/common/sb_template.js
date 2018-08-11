/*** Initialize ***/
var html=[
	'<div id="shoppingbasket" style="display: none;" onmouseout="DivSetUnVisible(this);" onmouseover="DivSetVisible(this);">',
	'</div>'
].join('');

document.write(html);

function DivSetVisible() 
  { 
   var DivRef = document.getElementById("shoppingbasket");  
   if(DivRef.style.display == "none")
   {  
    DivRef.style.display = "block";
   }
  } 
  
  function DivSetUnVisible(mydiv) 
  { 
   if(mydiv.style.display == "block")
   {  
    mydiv.style.display = "none";
   }
  } 

var hpsb_sb_img_path='http://h41213.www4.hp.com/ezbuy/hpsb/common/basket.gif';

function get_basket_item(condition, message, currency, price){
	var html="";
	if(condition){
		html=[
			'<div class="new-line"></div>',					//new line
			'<div class="sb-messaging">'+message+': </div>',		//for example total excluding VAT
			'<div class="sb-currency">'+currency+' </div>',			//currency
			'<div class="sb-price">'+price+'</div>'				//price
			].join('');
	}
	return(html);
}
function get_basket(position, segment, SB){
	var html="";
	var is_left= (position.toLowerCase().indexOf("left") != -1)?true:false;
	var is_right= (position.toLowerCase().indexOf("right") != -1)?true:false;
	var is_small= (position.toLowerCase().indexOf("small") != -1)?true:false;
	var is_top= (position.toLowerCase().indexOf("top") != -1)?true:false;
	var is_top2= (position.toLowerCase().indexOf("toop") != -1)?true:false;
	if(is_small){
		html=[
			'<div class="shopping-basket-small">',		//shopping basket container
				'<div class="sb-image-small"><img src="'+hpsb_sb_img_path+'"></div>',	//shopping basket image
				'<div class="sb-link-small"><a href="#storeUrl#" class="bold">'+ltitle+'</a></div>',			//shopping basket link
			'<div class="sb-small">',
				'<div class="sb-messaging-small">'+lItemName+':&nbsp;</div>',	//number of items
				'<div class="sb-messaging-small-nopadding" style="padding-right:10px;">#quantity#</div>',		//quantity 
				'<div class="sb-messaging-small-nopadding">&nbsp;&nbsp;'+lGrossAmount+':&nbsp;'+currency+'</div>',	//gross amount
				'<div class="sb-messaging-small-nopadding">#grossAmount#</div>',	//price and currency
			'</div>',
			(SB.quantity>0)?'<div class="sb-button"><a href="#storeUrl#" class="commButton">'+lCheckout+'&nbsp;&raquo;&nbsp;</a></div>':'',
			'</div>',
			'<div class="hard-line"></div>'
		].join('');
	}else{
		if(is_left || is_right) {
			html=[
				is_left?'<div class="shopping-basket-left">':'<div class="shopping-basket-right">',													//shopping basket container
				'<div class="sb-image"><img src="'+hpsb_sb_img_path+'"></div>',						//shopping basket image
				'<div class="sb-link"><a href="#storeUrl#" class="bold">'+ltitle+'</a></div>',	//shopping basket link
				'<div class="sb">',
				'<div class="sb-pricing">'
			].join('');

			if(diNumberOfItems == true) {
				html+=[
					'<div class="new-line"></div>',						//new line
					'<div class="sb-messaging">'+lItemName+': </div>',	//number of items
					'<div class="sb-price">#quantity#</div>'			//quantity
					].join('');
			}

			html+=get_basket_item(diNetAmount == true || verbose == true, lNetAmount, currency, '#netAmount#');
			html+=get_basket_item(diVat == true || verbose == true, lVat, currency, '#vat#');
			html+=get_basket_item(diSchippingCharge == true || verbose == true, lShippingCharge, currency, '#shippingCharge#');
			html+=get_basket_item(diVatShippingCharge == true || verbose == true, lVatShippingCharge, currency, '#vatShippingCharge#');
			html+=get_basket_item(diGrossAmount == true || verbose == true, lGrossAmount, currency, '#grossAmount#');
			html+=get_basket_item(diGrossShippingCharge == true || verbose == true, lGrossShippingCharge, currency, '#grossShippingCharge#');
			html+=get_basket_item(diTotalAmount == true || verbose == true, lTotalAmount, currency, '#totalAmount#');

			html+=[
				'</div>',
				'</div>',
				(SB.quantity>0)?'<div class="sb-button"><a href="#storeUrl#" class="commButton">'+lCheckout+'&nbsp;&raquo;&nbsp;</a></div>':'',
				'</div>',
				'<div class="hard-line"></div>' //hard line
			].join('');	
		}else{
			
			if(is_top && segment=="smb"){
				html=[
					'<img src="http://welcome.hp-ww.com/img/shopping_cart_icon_black.gif" alt="'+ltitle2+'" width="14" height="13" border="0" />',
					'<a href="#" onmouseover="DivSetVisible(this);">&nbsp;'+ltitle2+'&nbsp;&nbsp;</a>',
					'<img src="http://h41213.www4.hp.com/ezbuy/html/img/hpsb/whitearrow.gif" onmouseover="DivSetVisible(this);" alt="'+ltitle2+'" width="9" height="5" border="0" /><br />',
					'<span id="sb_total_q">#quantity#</span> '+lItemName+' '+lItemsName	//number of items
				].join('');
				
				if(document.getElementById('shoppingbasket'))
					document.getElementById('shoppingbasket').innerHTML+='<a href="'+storeUrl+'">'+ltitle_ms_smb+': '+sb_quantity+' '+lItemName+'</a>';

			}
			if(is_top && segment=="hho"){
				if(document.getElementById('sb_total_q'))
					document.getElementById('sb_total_q').innerHTML=sb_total_q;
				else{
					html=[
						'<img src="http://welcome.hp-ww.com/img/shopping_cart_icon_black.gif" alt="'+ltitle2+'" width="14" height="13" border="0" />',
						'<a href="#" onmouseover="DivSetVisible(this);">&nbsp;'+ltitle2+'&nbsp;&nbsp;</a>',
						'<img src="http://h41213.www4.hp.com/ezbuy/html/img/hpsb/whitearrow.gif" onmouseover="DivSetVisible(this);" alt="'+ltitle2+'" width="9" height="5" border="0" /><br />',
						'<span id="sb_total_q">#quantity#</span> '+lItemName+' '+lItemsName	//number of items
					].join('');
				}
				if(document.getElementById('shoppingbasket'))
					document.getElementById('shoppingbasket').innerHTML+='<a href="'+storeUrl+'">'+ltitle_ms_hho+': '+sb_quantity+' '+lItemName+'</a>';
			}
		}
	}
	return(html);
}

function get_basket_phone_number(position, segment){
	var html="";
	if(diPhone){
		if(position.toLowerCase()=="left"){
			html=[
				'<div class="sbc-phone">',			//container
					'<div class="sb-phone">'+lOrder+'</div>',	//text
					'<div class="sb-phone">'+lPhoneNumber+'</div>',	//phone number
				'</div>',
				'<div class="sb-line-container">',
					'<div class="sb-line"></div>',
				'</div>'
			].join('');
		}
	}
	return html;
}

function get_buy_partner_link(position, segment){
	var html="";
	html=[
		'<div style="padding-left:10px;" class="h3">',
		'<font class="color003366">&raquo;</font>',
		' ',
		,'#BuyPartnerUrl#',
		'</div>'
	].join('');
	return(html);
}
