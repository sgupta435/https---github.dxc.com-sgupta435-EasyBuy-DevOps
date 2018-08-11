var checkoutUrl = "http://h20386.www2.hp.com/UKStore/GenericLandingPage.aspx?Action=PSCBasketDisplay&Language=en&Country=uk&Segment=hho";
var displayTotalIncludingVATAmount = true;
var displayTotalExcludingVATAmount = true;
var displayVATAmount = true;
var countrycode = "uk";
var languagecode = "en";
var segmentcode = "hho";

//needed for ezbuy to work
var storeUrl = "http://h20387.www2.hp.com/UKStore/GenericLandingPage.aspx?Action=EZBuyAdd&Language=#lang#&Country=#country#&Segment=#m_s#&Origin=#clientId#&#pn_list#&RefererUrl=#RefUrl#";
var siteId = "uk_en_hho_psc";
var storeId = "1223";
var ezbStoreId = "1223";
var globalSiteId = "uk_en_hho";
var ezbPartnerList = "";
var ezbuyExperience = "";
var ezbuyPNList = "";

//translation section
var totalExcVATLabel = "Total ex VAT: ";
var totalVATLabel = "Total VAT amount: ";                                        
var totalIncVATLabel = "Total inc VAT: ";
var shoppingBasketLabel = "Shopping Basket";			
var orderByPhoneLabel =  "Order by phone";
var orderByPhoneNumber = "0845 601 7611" ;  
var inMyBasket = "in my basket";
var itemsInMyBasket ="Items In my basket";	    
var currency = "&pound";
var items ="Items";
var checkOut = "Checkout";

// don't believe these are needed anymore, but left to prevent any unforseen problems
var lBuyPartner = "Buy from an HP partner";
var lhpStoreButtonTitle_smb = "business offers &raquo";
var storeMeans = true;

    /*
        v1.1
		This Javascript is used to display the Mini Cart.    This Javascript can be used by any pages in HP ie both PSC and Non PSC pages.  
        To use this Javascript any clients need to include the appropriate config file, this javascript file, then call the Javascript Method 
			
		<script src="http://g2w0281.austin.hp.com/Minicart/config/ch_de_smb.js" type="text/javascript"></script>
		<script src="http://g2w0281.austin.hp.com/Minicart/javascript/MiniCart.js" type="text/javascript"></script>
		<script  type="text/javascript">	
			showBasket('left');   //or 'right' or 'top' or 'small' or 'cs'
		 </script>
    */

    //GLOBAL VARIABLES
    var miniCartDetailsObject;
    var forced_channel = false;
    var forced_partner = false;
    var cartCookieAvailable = false;
	var forDisplay_channelcookieAvailable=false;
	var forDisplay_partnercookieAvailable=false;
	var forDisplay_ISCSCartcookieAvailable=false;
	var forDisplay_directcookieAvailable=false;
	var forDisplay_channelcookieValue="";
	var forDisplay_partnercookieValue="";
	var forDisplay_ISCSCartcookieValue="";
	var forDisplay_directcookieValue="";
	 
	// by default every user experience is a neutral experience. Based on URL param this value will change.
    ezbuyExperience = "neutral"; 
	
	// The Variable minicartLocation will tell us location of the javascript files. These javascript files can be published to Dev, ITG , or PRO site 
	// via release manager script and the config file should point accordingly.
    //var minicartLocation = "http://whp-test.extweb.hp.com/hp-minicart"; // uncomment this line if you are using Release Manager Staging Site reference ie for ITG
	var minicartLocation = "http://h10171.www1.hp.com/hp-minicart"; // uncomment this line if you are using Release Manager Production Site reference ie for PRO
	//var minicartLocation = "http://g2w0281.austin.hp.com/Minicart";  //uncomment this line if you are testing on dev environment
 
	//INCLUDE OTHER SUPPORTING JAVASCRIPTS
	document.write( "<script src='" +minicartLocation + "/js/jquery-1.3.2.min.js'></script>" );     
	document.write( "<script src='" +minicartLocation + "/js/CookieLibrary.js'></script>" );     
	document.write( "<script src='" +minicartLocation + "/js/jsonparseminified.js'></script>" );     				

				
	//This function takes in a display position (left/right/top/small/cs) and renders the cart in that format.  
    function showBasket(displayPosition)
    {
        jQuery.noConflict(); 
        (function($) 
        {
			//this is the div which holds the cart HTML.  
			document.write("<div class=\"cart-container\"></div>");
			
			var requestedMiniCart = new MiniCart(displayPosition, countrycode, languagecode, segmentcode);
			var availableCartCookie = new CartCookie (requestedMiniCart);
			
			if((requestedMiniCart.haveValidInputParameters) && (availableCartCookie.haveValidCookieValues))
			{
					miniCartDetailsObject = new MiniCartDetails(availableCartCookie.cookieJSONObject);
					PaintMiniCart($, requestedMiniCart.displayPosition);
			}
			else if ( displayPosition.toLowerCase().indexOf( "cs" ) != - 1 )  
			{
				//if CS display format, we still want to paint cart, even if cookie isn't valid to show ZERO items available
				PaintMiniCart($, requestedMiniCart.displayPosition);
			}
			SetExperience(countrycode, languagecode, segmentcode);			
        })(jQuery);
    }// END OF THE FUNCTION SHOW CART        
	
    function MiniCart(displayPosition, countryCode, languageCode, segmentCode)
    {
        this.countryCode = countryCode;
        this.languageCode = languageCode;
        this.segmentCode = segmentCode;
        this.displayPosition = displayPosition;
        this.haveValidInputParameters = ValidateCartInputParameters(this.displayPosition,this.countryCode,this.languageCode,this.segmentCode); 
    }//END OF FUNCTION MINICART    
    
    function ValidateCartInputParameters(displayPosition, countryCode, languageCode, segmentCode)
    {
        if(((countryCode == null) || (countryCode =="")) ||
        ((languageCode == null) || (languageCode =="")) ||
        ((segmentCode == null) || (segmentCode =="")) ||
        ((displayPosition == null) || (displayPosition ==""))) 
        {
            return false;
        }
        else
        {
            return true;
        }//END OF IF
    }// END OF FUNCTION VALIDINPUTPARAMETERS    
        
    function CartCookie(MiniCartObj)
    {
        this.cookieJSONObject = null;
        this.haveValidCookieValues = false;
        this.cookieConstant = "iscscart_";
        this.cookieName = this.cookieConstant+MiniCartObj.countryCode; 
        this.cookieValue = GetCookie(this.cookieName); 
        if(this.cookieValue)
        {
            this.cookieJSONObject = GetCookieValueAsJSONObject(this.cookieValue);
            this.haveValidCookieValues = ValidateCookieValue(this.cookieJSONObject);
        }    
    }//END OF FUNCTION CART COOKIE
    
    function GetCookieValueAsJSONObject(cookieValue) 
    {
        var jsonCookieObject = null;
        jsonCookieObject = json_parse(cookieValue, null);
        return jsonCookieObject;
    }//END OF FUNCTION GET JSON OBJECT AS COOKIE VALUE
            
    function MiniCartDetails(jsonFormatCookieObject) 
    {
        this.ckValQuantity = jsonFormatCookieObject.q;
        this.ckValTotalIncVAT = jsonFormatCookieObject.tot; // this is grand total AKA total with tax AKA total including tax
        this.ckValTotalIncVAT = CurrencyFormattedForTwoDecimals(this.ckValTotalIncVAT);
        this.ckValTottax = jsonFormatCookieObject.tottax; // this is just the Tax alone on the above total amount.
        this.ckValTottax = CurrencyFormattedForTwoDecimals(this.ckValTottax);
        this.ckValTotalExVAT = this.ckValTotalIncVAT-this.ckValTottax; // this is totalinctax - tax  .toFixed(2)
        this.ckValTotalExVAT = CurrencyFormattedForTwoDecimals(this.ckValTotalExVAT);
        this.ckValTotalIncVAT = (Math.round(this.ckValTotalIncVAT*100)/100); 
        this.ckValTotalIncVAT = CurrencyFormattedForTwoDecimals(this.ckValTotalIncVAT);
        this.ckValTottax = (Math.round(this.ckValTottax*100)/100); 
        this.ckValTottax = CurrencyFormattedForTwoDecimals(this.ckValTottax); 
        this.ckValTotalExVAT = (Math.round(this.ckValTotalExVAT*100)/100); 
        this.ckValTotalExVAT = CurrencyFormattedForTwoDecimals(this.ckValTotalExVAT);
    }//END OF FUNCTION MINI CART DETAILS         
   
    //This function will paint shopping basket
    function PaintMiniCart($, displayPosition) 
    {

		var is_left = ( displayPosition.toLowerCase().indexOf( "left" ) != - 1 ) ? true : false;
        var is_right = ( displayPosition.toLowerCase().indexOf( "right" ) != - 1 ) ? true : false;
        var is_small = ( displayPosition.toLowerCase().indexOf( "small" ) != - 1 ) ? true : false;
        var is_top = ( displayPosition.toLowerCase().indexOf( "top" ) != - 1 ) ? true : false;
        var is_cs = ( displayPosition.toLowerCase().indexOf( "cs" ) != - 1 ) ? true : false;
		
        var html;
		
		//if cleansheet, don't want to include hpweb css as it conflicts with theirs
		if((is_cs))
        {
		        html = [
	            '<link rel="stylesheet" type="text/css" href="' + minicartLocation + '/css/sb.css">',
                '<link rel="stylesheet" type="text/css" href="' + minicartLocation + '/css/style.css">',					
				].join('');   
		}
		else
		{
		        html = [
                '<link rel="stylesheet" type="text/css" href="' + minicartLocation + '/css/hpweb_styles_mac.css">',
	            '<link rel="stylesheet" type="text/css" href="' + minicartLocation + '/css/sb.css">',
                '<link rel="stylesheet" type="text/css" href="' + minicartLocation + '/css/style.css">',					
				].join('');   
		}
  


			
			
		if((is_left) || (is_right))
        {
            html +=                  
             ['<div id="SB_PRINT_right">',
                    '<div class="shopping-basket-right">',
                        '<div class="sb-image" id="ShoppingCartBasketImageURL"><img src="http://h10171.www1.hp.com/hp-minicart/images/basket.gif"/></div>',
                        '<div class="sb-link" id="ShoppingCartBasketLabelAndURL"><a href="'+checkoutUrl+'" class="bold">'+shoppingBasketLabel+'</a></div>',
                        '<div class="sb">',
                            '<div class="sb-pricing">',
                                '<div class="new-line"></div>',
            			        '<div class="sb-messaging" id="ItemsLabel">'+items+'&#58;&#32;</div>',
	       	       		        '<div class="sb-price">'+miniCartDetailsObject.ckValQuantity+'</div>',
	   	       	       	        '<div class="new-line"></div>',
			].join('');

			if(displayTotalExcludingVATAmount)
			{		
				html +=                 
	            ['<div id="DisplayTotalExcludingVAT">',
	                                    '<div class="sb-messaging" id="ExcVATLabel">'+totalExcVATLabel+'</div>',
	                			     	'<div class="sb-currency" id="ExcVATCurrencyLabel">'+currency+'&#32;</div>',
	                				    '<div class="sb-price">'+miniCartDetailsObject.ckValTotalExVAT+'</div>',
	                				    '<div class="new-line"></div>',				        
	            				    '</div>',
				].join('');
			}
			
			if(displayVATAmount)
			{
				html +=                 
	             ['<div id="DisplayVATAmount">',
	                                    '<div class="sb-messaging" id="TotalVATLabel">'+totalVATLabel+'</div>',
	        				            '<div class="sb-currency" id="TotalVATCurrencyLabel">'+currency+'&#32;</div>',
	                                    '<div class="sb-price">'+miniCartDetailsObject.ckValTottax+'</div>',
			      		                '<div class="new-line"></div>',            				    
	            				    '</div>',
				].join('');								
			}
		
			if(displayTotalIncludingVATAmount)
			{
				html +=                 
	            ['<div id="DisplayTotalIncludingVATAmount">',
	                                    '<div class="sb-messaging" id="IncVATLabel">'+totalIncVATLabel+'</div>',
	        				            '<div class="sb-currency" id="IncVATCurrencyLabel">'+currency+'&#32;</div>',
		          			            '<div class="sb-price">'+miniCartDetailsObject.ckValTotalIncVAT+'</div>',
			      	     	            '<div class="new-line"></div>',				        				                
	            				    '</div>',
				].join('');	                              
			}
		
			html +=                 
             ['</div>',
                        '</div>',
                        '<div class="sb-button" id="Checkout"><a href="'+checkoutUrl+'" class="commButton">'+checkOut+'&nbsp;&raquo;&nbsp;</a></div>',
                    '</div>',  
			].join('');	 

        }
    
        if((is_left))    
        {
            html += 
            [ '<div class="hard-line"></div>',
                    '<div class="sbc-phone">',
                        '<div class="sb-phone" id="ConsumerOrderByPhoneLabel">'+orderByPhoneLabel+'</div>',
                        '<div class="sb-phone" id="ConsumerOrderByPhoneNumber">'+orderByPhoneNumber+'</div>',
                    '</div>',
                    '<div class="sb-line-container">',
                    '</div>',                
                    '<div class="sb-line"></div>',
                '</div>',    
            ].join('');
        }                
         
       if((is_small))                    
        {
            html = 
            html + ['<div id="SB_PRINT_small">',
                        '<div class="shopping-basket-small">',
                            '<div class="sb-image-small" id="SmallShoppingCartBasketImageURL"><img src="http://h10171.www1.hp.com/hp-minicart/images/basket.gif"/></div>',
                            '<div class="sb-link-small" id="SmallShoppingCartBasketLabelAndURL"><a href="'+checkoutUrl+'" class="bold">'+shoppingBasketLabel+'</a></div>',
                            '<div class="sb-small">',
                                '<div class="sb-messaging-small" id="SmallItemsLabel">'+items+':</div>',
                                '<div class="sb-messaging-small-nopadding" style="padding-right: 10px;">'+miniCartDetailsObject.ckValQuantity+'</div>',
                                '<div class="sb-messaging-small-nopadding" id="SmallCurrencyIncVATLabel">'+currency+'&#32;</div>'+miniCartDetailsObject.ckValTotalIncVAT,
                            '</div>',
                            '<div class="sb-button" id="Checkout"><a href="'+checkoutUrl+'" class="commButton">'+checkOut+'&nbsp;&raquo;&nbsp;</a></div>',
                        '</div>',
                        '<div class="hard-line"></div>',
                    '</div>',                 
            ].join('');       
        }

        if((is_top))
        {
            html = 
            html + ['<div id="SB_PRINT_top">',
                        '<div id="TopShoppingCartBasketImageURLandShoppingCartBasketLabelAndURL"><img src="http://h10171.www1.hp.com/hp-minicart/images/shopping_cart_icon_black.gif"><a href="'+checkoutUrl+'" class="bold">'+shoppingBasketLabel+'</a></div>',
                        '<div class="sb-messaging">'+miniCartDetailsObject.ckValQuantity+'&nbsp;</div>',            
                        '<div class="sb-messaging" id="TopItemsLabel">'+items+'&nbsp;</div>',                            
                        '<div class="sb-messaging" id="InMyBasket">'+inMyBasket+'</div>', 
                           
                    '</div>',
            ].join('');            
        }           


        if((is_cs))
        {

			html += ['<div id="cartContainerInner">',
					'<div class="shopping_cart">', 
					'	<div class="cart_image"></div>',
					'	<div class="cart_text">'+shoppingBasketLabel+'</div>',
					'</div>     ',         
				 ].join(''); 	

			if (miniCartDetailsObject != null)
			{
				html += [
						//'<div class="saved_basket">'+viewSavedBasketLabel+'</div>',
						'<div class="basket">',
						'<div class="items">',
						'<span>'+items+'&#58;&#32;&nbsp;</span>',
						' <span>'+miniCartDetailsObject.ckValQuantity+'</span>',
					  '</div>',
					 ' <div class="prices">',
					 ].join(''); 

				if(displayTotalExcludingVATAmount)
				{		
					html +=                 
					[ 	'<div class="exc_vat">',
						'	<span class="price_text">'+totalExcVATLabel+'&nbsp;</span>',
						'   <span class="price">'+currency+miniCartDetailsObject.ckValTotalExVAT+'</span>',
						'</div>',
					].join('');
				}
				
				if(displayVATAmount)
				{
					html +=                 
					 [	'<div class="exc_vat">',
						'	<span class="price_text">'+totalVATLabel+'&nbsp;</span>',
						'   <span class="price">'+currency+miniCartDetailsObject.ckValTottax+'</span>',
						'</div>',
					].join('');								
				}
			
				if(displayTotalIncludingVATAmount)
				{
					html +=                 
					[   '  <div class="inc_vat">',
						' 	<span class="price_text">'+totalIncVATLabel+'&nbsp;</span>',
						'    <span class="price">'+currency+miniCartDetailsObject.ckValTotalIncVAT+'</span>',
						' </div>                     ',

					].join('');	                              
				}

					html +=                 
					[ 
					  '</div>',
					  '<div class="checkout_btn">',
					  '    <div class="btn_chrm_l png">',
					  '    <div class="btn_chrm_r png">',
					  '        <div class="btn_chrm_c png">',
					  '            <a title="" href="'+checkoutUrl+'">'+checkOut+'</a>',
					  '          </div>',
					  '    </div>',
					  '	</div>',
					  '</div>',
					  '<div class="order_info">',
					  '    <div>'+orderByPhoneLabel+'</div>',
					  '   <div>'+orderByPhoneNumber+'</div>',
					  '</div>',
					'	</div>',
					'</div>',
				].join(''); 			
			
			}
			else  //no valid cookie, but still want to show no items in cart
			{
				html += [ '<div class="no_items">'+noItemsInCartLabel+'</div>',
				 ].join(''); 
			}

		}

		
		// Use this method instead to replace the div with teh cart contents
  		$('div.cart-container').html( html);
    }//END OF FUNCTION DRAW SHOPPING CART              
   
   function SetExperience(countryCode, languageCode, segmentCode)
    {
 		var userExpDetails = new UserExperienceDetails(countryCode, languageCode, segmentCode);
		CheckCookieExistance(userExpDetails);
		CheckURLQueryStringParameters(userExpDetails);
    }//END OF FUNCTION SETEXPERIENCE
    
    
    function UserExperienceDetails(countryCode, languageCode, segmentCode)
    {
        this.storefrontCartName = "iscscart";
        this.ezbCookieName = "hpstore";
        this.ezbCookieLifeTime = 7;
		this.directCookieLifetime = 42;
        this.cartCookie = this.storefrontCartName+"_"+countryCode; //cookieName        
        this.partnerCookie = this.ezbCookieName+"_partner_"+countryCode;    
        this.channelCookie = this.ezbCookieName+"_channel_"+countryCode; 
		this.directCookie = this.ezbCookieName+"_direct_"+countryCode; 
    }//END OF FUNCTION USER EXPERIENCE VARIABLES
	
   
    function CheckCookieExistance(userExpDetailsObj)
    {
    
        if(GetCookie(userExpDetailsObj.cartCookie))
        {
            forDisplay_ISCSCartcookieAvailable=true;
            forDisplay_ISCSCartcookieValue=GetCookie(userExpDetailsObj.cartCookie);   
        }
        
        if(GetCookie(userExpDetailsObj.channelCookie))
        {
            forDisplay_channelcookieAvailable=true;
            forDisplay_channelcookieValue=GetCookie(userExpDetailsObj.channelCookie);
        }

        if(GetCookie(userExpDetailsObj.partnerCookie))
        {
            forDisplay_partnercookieAvailable=true;
            forDisplay_partnercookieValue=GetCookie(userExpDetailsObj.partnerCookie);
        }
 
        if(GetCookie(userExpDetailsObj.directCookie))
        {
            forDisplay_directcookieAvailable=true;
            forDisplay_directcookieValue=GetCookie(userExpDetailsObj.directCookie);
        } 
        var cartCookie;
        var partnerCookie;
        if(GetCookie(userExpDetailsObj.cartCookie)) //CHECK FOR THE ISCS STORE FRONT COOKIE
        {
            cartCookie = GetCookie(userExpDetailsObj.cartCookie);    
            ezbuyPNList = GetPNList(cartCookie);
            
        }  
        
        if(GetCookie(userExpDetailsObj.channelCookie)) //CHECK FOR THE CHANNEL COOKIE
        {
            ezbuyExperience = "forced_channel";
            forced_channel = true;
        }
        else if(GetCookie(userExpDetailsObj.partnerCookie)) //CHECK FOR THE PARTNER COOKIE
        {
                ezbuyExperience = "forced_partner";
                forced_partner = true;
                partnerCookie = GetCookie(userExpDetailsObj.partnerCookie);
                partnerCookie = partnerCookie.replace(/@#@/g,";");                            
                ezbPartnerList = GetPartnerList(partnerCookie);
        }
        else if(GetCookie(userExpDetailsObj.cartCookie)) //CHECK FOR THE ISCS STORE FRONT COOKIE
        {
                    ezbuyExperience = "direct";
                    cartCookieAvailable = true;                 
        }
        else if(GetCookie(userExpDetailsObj.directCookie)) //CHECK FOR THE direct COOKIE
        {
			   ezbuyExperience = "direct";
        }
				
    }//END OF FUNCTION COOKIE EXISTANCE
    
    function CheckURLQueryStringParameters(userExpDetailsObj)
    {
       /*
            There are two type of approaches we can take here.
            1. By using window.top.location.search.toLowerCase().indexOf() will give you the indexof the particular query
            string item you are looking for in the URL. if the index value is -1 then it says no param name.
            2. The below approach by which you get the query string parameter list from the URL and check for the paramname match.
        */
        var queryString = new Array();
        var parameters = window.location.search.substring(1).split('&'); //GET ALL THE QUERY STRING PARAMETERS IN THE URL 
        var actualParamName;
        var cookieValueEbzPartnerList;
        var ezbPartnerListReplacedSemicolon;        
        
        for (var i=0; i<parameters.length; i++) 
        {
            var pos = parameters[i].indexOf('=');
            if (pos > 0)
            {
                var actualParamName = parameters[i].substring(0,pos); //GET THE PARAMETER NAME
                paramname = actualParamName.toLowerCase();
                var paramval = parameters[i].substring(pos+1); // GET THE PARAMETER VALUE
                queryString[paramname] = unescape(paramval.replace(/\+/g,' '));
                if((paramname == "ezb_channel")|| (paramname == "forced_channel")) //CHECK FOR PARAMNAME FOR CHANNEL
                {
                    ezbuyExperience = "forced_channel";
                    forced_channel = true; 
                    SetCookie(userExpDetailsObj.channelCookie,null,userExpDetailsObj.ezbCookieLifeTime);
                    break;
                } 
                else if ((paramname == "ezb_partner")|| (paramname == "forced_partner")) //CHECK FOR PARAMNAME FOR PARTNER
                {
                    ezbuyExperience = "forced_partner";
                    forced_partner = true;                
                    ezbPartnerList = queryString[paramname];
                    ezbPartnerListReplacedSemicolon = ezbPartnerList.replace(/;/g,"@#@");                
                    cookieValueEbzPartnerList = "[partnerList="+ezbPartnerListReplacedSemicolon+"]";
                    SetCookie(userExpDetailsObj.partnerCookie,cookieValueEbzPartnerList,userExpDetailsObj.ezbCookieLifeTime);
                    break;
                }
                else 
                {
                    if ((cartCookieAvailable) || ((paramname=="direct") || (paramname=="hmc_") || (paramname=="r1129") || (paramname=="r11219") || (paramname=="ezb_direct") || (paramname=="forced_direct") ||(paramval=="direct") || (paramval=="hmc_") || (paramval=="r1129") || (paramval=="r11219") || (paramval=="ezb_direct") || (paramval=="forced_direct")))
					{
						ezbuyExperience = "direct";
						SetCookie(userExpDetailsObj.directCookie,null,userExpDetailsObj.directCookieLifetime);
						break;
					}
                }            
            }
            else 
            {
                //special value when there is a querystring parameter with no value
                queryString[parameters[i]]="" 
            } // END OF IF ELSE                 
        }//END OF FOR LOOP                 
    }//END OF FUNCTION CHECKURLQUERYSTRINGPARAMETERS
 
    


