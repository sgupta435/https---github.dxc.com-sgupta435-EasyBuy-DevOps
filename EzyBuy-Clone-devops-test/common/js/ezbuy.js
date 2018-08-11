var cc = 'fr';
var lc = 'fr';
var partnr = 'CM749A';
var guistyle = 'normal';
var ezbuyExperience = 'direct';
var ezb_segment = 'hho';


function vPrepareEzBuyParameters(psCc, psLc, psSku, psGuistyle, psEzbuyExperience, psEzBuySegment)
{
  guistyle = psGuistyle;
  partnr = psSku;
  cc = psCc;
  lc = psLc;
  ezbuyExperience = psEzbuyExperience;
  ezb_segment = psEzBuySegment;
}


function vRenderEzBuyLayout()
{
  // render the EzBuy-layout by invoking the default function
  ezb();
 
  document.write("<link href='/country/configurator/css/ezbuy.css' rel='stylesheet' type='text/css' />");
  // remove inline styles from HTML elements
  setTimeout( "vFixLayoutIssues()", 1500);
}





  /**
   * hideTooltip()
   * 
   * Hide the tooltip after the mouse has left the tooltip div
   * 
   * @param event e
   *
   * @return void
   * 
   */
function hideTooltip(e)
{
    if (!e) var e = window.event;
    var tg = (window.event) ? e.srcElement : e.target;
    var relTarg = e.relatedTarget || e.toElement;
	
    if(relTarg.className != 'toolcontent' && relTarg.className != 'header')
    {
      document.getElementById('tooltip').style.visibility = "hidden";
    }
    if (tg.className != 'toolcontent' && tg.className != 'header')
    {
      document.getElementById('tooltip').style.visibility = "hidden";
	}
}





  /**
   * vRemoveInlineStyles()
   * 
   * Remove inline styles in order to prevent the use of the !important attribute in CSS
   *
   * @return void
   * 
   */
function vFixLayoutIssues()
{
  try
  {
    document.getElementById('tooltip').removeEventListener();
    
    
    // hide tooltips, when mouse leaves the corresponding div element
    // Firefox etc.
    if(window.addEventListener && document.getElementById('tooltip') != null)
    {
      //document.getElementById('tooltip').addEventListener('mouseout', hideTooltip, true);
    }
    // IE
    if(window.attachEvent && document.getElementById('tooltip') != null)
    {
      //document.getElementById('tooltip').attachEvent('onmouseleave', hideTooltip, true);
    }
	 
    // modify links in screen2 container (change used CSS-class)
    var oLinkContainer = document.getElementsByTagName('a');
    for(i=0; i<oLinkContainer.length; i++)
    {
      if(oLinkContainer[i].className == 'secButtonEnhanced')
      {
        var sParentNode = oLinkContainer[i].parentNode.parentNode.parentNode;
        // screen 3
        if( oLinkContainer[i].parentNode.parentNode.className == 'sc2' )
        {
          if( oLinkContainer[i].href.match(/BuyPartnerFormAction/) )
          {
            // buy partner link
            oLinkContainer[i].className =  oLinkContainer[i].className.replace('secButtonEnhanced', 'ezbFindPartnerLink');
          }
          else
          {
            // back link
            oLinkContainer[i].className =  oLinkContainer[i].className.replace('secButtonEnhanced', 'ezbPartnerBackLink');
           }
		  if( oLinkContainer[i].parentNode.className.match(/content/) || oLinkContainer[i].parentNode.className == 'content' )
		  {
		    oLinkContainer[i].parentNode.className =  oLinkContainer[i].parentNode.className.replace('content', 'EzBuyContent');
		  }
         }
         // screen 2
         if( sParentNode.className == 'sc2' )
         {
            if( oLinkContainer[i].href.match(/ezb_FindPartner/) )
            {
              // partner stores
              oLinkContainer[i].className =  oLinkContainer[i].className.replace('secButtonEnhanced', 'ezbFindPartnerLink');
            }
            else
            {
              // back link
              oLinkContainer[i].className =  oLinkContainer[i].className.replace('secButtonEnhanced', 'ezbBackLink'); 
              oLinkContainer[i].style.cssFloat = "";
            }
            if( oLinkContainer[i].parentNode.className == 'footer' )
            {
              oLinkContainer[i].parentNode.className =  oLinkContainer[i].parentNode.className.replace('footer', 'EzBuyFooter');
            }
          }
          // screen 1
          if( oLinkContainer[i].parentNode.className == 'footer')
          {
             oLinkContainer[i].parentNode.className =  oLinkContainer[i].parentNode.className.replace('footer', 'EzBuyFooter');
          }
		  if( oLinkContainer[i].parentNode.parentNode.className == 'content')
		  {
		    oLinkContainer[i].parentNode.parentNode.className =  oLinkContainer[i].parentNode.parentNode.className.replace('content', 'EzBuyContent');
		  }	  
        }
       
        if( oLinkContainer[i].onmouseover != null && oLinkContainer[i].onmouseover.toString().match(/tip_it/) )
        {
          if(window.addEventListener)
          {
            oLinkContainer[i].addEventListener('mouseover', function() {
                 document.getElementById('tooltip').childNodes[0].className = document.getElementById('tooltip').childNodes[0].className.replace('header', 'EzBuyHeader');               
             } , true);
           }
           if(window.attachEvent)
           {
             oLinkContainer[i].attachEvent('onmouseover', function() {
                document.getElementById('tooltip').childNodes[0].className = document.getElementById('tooltip').childNodes[0].className.replace('header', 'EzBuyHeader');
             } , true);
           }
        }
      }
     
    var oDivContainer = document.getElementsByTagName('div');
    for(i=0; i<oDivContainer.length; i++)
    {
      // remove inline styles
      if(oDivContainer[i].className == 'EzBuyHeader')
      {
        oDivContainer[i].style.color = "";
        oDivContainer[i].style.background = "";
	  }
      if(oDivContainer[i].className == 'boxend')
      {
        oDivContainer[i].style.background = "";
      }
      if(oDivContainer[i].className == 'priceContainer')
      {
        oDivContainer[i].style.height = "";
      }
      if(oDivContainer[i].className == 'simple')
      {
        oDivContainer[i].style.textAlign = "";
      }

      // hide tooltip for partner stores, which have no tooltip
      if(oDivContainer[i].className == 'radio')
      {
        if( oDivContainer[i].childNodes[0].onmouseover == null)
        {
          oDivContainer[i].childNodes[0].onmouseover = function()
          {
            document.getElementById('tooltip').style.visibility = "hidden";
          }
        }
      }
 
      if(oDivContainer[i].className == 'promo' || oDivContainer[i].className == 'nonpromo')
      {
        if(oDivContainer[i].childNodes[0].className == 'header') 
        {
          oDivContainer[i].childNodes[0].className =  oDivContainer[i].childNodes[0].className.replace('header', 'EzBuyHeader');
        }   
      }
    }
	// check if the layout fix was succesful
	setTimeout("checkLayoutStyle()", 1500);	
  }
  catch(e)
  { }
}




  /**
   * checkLayoutStyle()
   * 
   * Checks if the layout fix was succesful
   *
   * @return void
   * 
   */
function checkLayoutStyle()
{
  try
  {
	  var oDivContainer = document.getElementsByTagName('div');
	  for(i=0; i<oDivContainer.length; i++)
	  {
		if(oDivContainer[i].className == 'promo' || oDivContainer[i].className == 'nonpromo')
		{
		  // the CSS-class 'header' was replaced with EzBuyHeader
		  if(oDivContainer[i].childNodes[0].className == 'header')
		  {
			vFixLayoutIssues();
		  }  
		}
		var oLinkContainer = document.getElementsByTagName('a');
		if( oLinkContainer[i].parentNode.parentNode.className == 'content')
		{
		  vFixLayoutIssues();
		}
	  }
  }
  catch(e)
  { }
}



