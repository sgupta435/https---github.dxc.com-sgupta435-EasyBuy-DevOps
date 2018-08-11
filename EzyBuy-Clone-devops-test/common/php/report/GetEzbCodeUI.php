<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">


<style type="text/css">
/*margin and padding on body element
  can introduce errors in determining
  element position and are not recommended;
  we turn them off as a foundation for YUI
  CSS treatments. */
body {
	margin:0;
	padding:0;
}

.textSmall {examples.php (line 12)
color:#666666;
font-family:Verdana,Arial,Helvetica,sans-serif;
font-size:9px;
font-weight:900;
}

.dbg-obj,
.dbg-arr {
  border-width:0px;
  margin:0px;
}
.dbg-label,
.dbg-value {
  padding:3px;
  font-size:12px;
  color:#333;
}
.dbg-label {
  font-weight:bold;
  background-color:#cba;
}
.dbg-obj td,
.dbg-arr td {
  border-top:1px solid #cba;
}
.dbg-value .dbg-toggle {
  display : list-item;
  margin-left : 15px;
  text-decoration : underline;
  cursor : pointer;
}
.dbg-value .dbg-toggle-open .dbg-toggle {
  list-style-image : url("minus.gif");
}
.dbg-value .dbg-toggle-closed .dbg-toggle {
  list-style-image : url("plus.gif");
}
</style>

<link rel="stylesheet" type="text/css" href="../../js/utils/yui/build/fonts/fonts-min.css?_yuiversion=2.4.1" />
<link rel="stylesheet" type="text/css" href="../../js/utils/yui/build/button/assets/skins/sam/button.css?_yuiversion=2.4.1" />
<script type="text/javascript" src="../../js/utils/yui/build/yahoo-dom-event/yahoo-dom-event.js?_yuiversion=2.4.1"></script>
<script type="text/javascript" src="../../js/utils/yui/build/element/element-beta-min.js?_yuiversion=2.4.1"></script>

<script type="text/javascript" src="../../js/utils/yui/build/button/button-min.js?_yuiversion=2.4.1"></script>
<script type="text/javascript" src="../../js/utils/yui/build/get/get-min.js?_yuiversion=2.4.1"></script>

<script type="text/javascript" src="../../js/utils/json/JsonTree.js"></script>
<script type="text/javascript" src="../../js/utils/json/JsonString.js"></script>

<!--begin custom header content for this example-->
<style type="text/css">
#container ol {
	/*bringing lists on to the page with breathing room */
	margin-left:2em !important;
}

#container ol li {
	/*giving OL's LIs generated numbers*/
	list-style: decimal outside !important;
}

#container h3 {
	margin-top: 1em;
}
</style>

</head>

<body class=" yui-skin-sam">


<!--BEGIN SOURCE CODE FOR EXAMPLE =============================== -->

<div id="container_code">

	<!--Use a real form that works without JavaScript:-->
	<form method="GET" id="EzbExplorerCode">

 <table border="0" cellpadding="4" cellspacing="2" width="600">
	      <tbody>
	        <tr bgcolor="#f3f3f3" valign="middle">
	          <td colspan="2" align="center" bgcolor="#dddddd" class="textBold">Choose your preferences</td>
	        </tr>

	        <tr bgcolor="#eeeeee" valign="middle">
	          <td width="300" class="text">Country/language</td>
	          <td width="300"><div align="left">
	            <select name="ctrysettings" id="cc_ll_code">
	              <option value="" selected="selected">Select... </option>
	              <?php
	              include("include/GetCountries.inc.php");
	              ?>	            </select>
	          </div></td>
	        </tr>
	        	<tr bgcolor="#eeeeee" valign="middle">
				<td class="text">Template</td>
				<td width="300">
					<div align="left">
						<select name="template" id="template_code">
							<option value="normal">Normal</option>
							<option value="small">Small</option>
							<option value="simple">Simple</option>
							<option value="start">Start From</option>
						</select>
					</div>
				</td>
			</tr>

	        <tr bgcolor="#eeeeee" valign="middle">
	          <td class="text">Market segment</td>
	          <td width="300"><div align="left">
	            <select name="segment" id="m_s_code">
					<option value="" selected="selected">Select... </option>
					<option value="smb">smb (Small &amp; Medium Business)</option>
					
	            </select>
	          </div></td>
	        </tr>
	        <tr bgcolor="#eeeeee" valign="middle">
	          <td class="text">No Javascript Buy Online text</td>
	          <td><div align="left" style="font-family:HP Simplified, Verdana, Arial, Helvetica, sans-serif;">
	            <textarea name="js" cols="20" rows="1" id="js_code" style="font-family:HP Simplified, Verdana, Arial, Helvetica, sans-serif;">Buy Online</textarea>
	          </div></td>
	        </tr>
		<tr bgcolor="#eeeeee" valign="middle">
          <td class="text">Partnumber<br />
            <span class="textSmall" style="font-family:'HP Simplified', Verdana, Arial, Helvetica, sans-serif;">Separate by carriage returns, comma, semicolon or spaces for multiple products.<br/>Multiple products will force start from template</span></td>

          <td width="300"><div align="left" >
            <textarea name="partnumber"  cols="20" rows="5" id="partnumber_code" style="font-family:HP Simplified, Verdana, Arial, Helvetica, sans-serif;"></textarea>
          </div></td>
        </tr>


	        <tr bgcolor="#f3f3f3" valign="middle">
	          <td colspan="2" align="right" bgcolor="#dddddd"><div align="center">
	            <input type="submit" id="getEzbExplorerCodeBtn" value="Get HTML Implementation Code">
	          </div></td>
	        </tr>
	      </tbody>
	    </table>


    </form>

	<div id="results_code_error" style="font-family:HP Simplified, Verdana, Arial, Helvetica, sans-serif;"></div>
	<div id="results_code" style="visibility:hidden">
    	<!--JSON output will be written to the DOM here-->
<table border="0" cellpadding="5">
<tr>
<td>

<table width="600" border="0" cellpadding="4" cellspacing="2">
      <tr valign="middle" bgcolor="#eeeeee">
	          <td class="textBold">Instructions<br>
	            <span class="textSmall" style="font-family:'HP Simplified', Verdana, Arial, Helvetica, sans-serif;">copy and paste the code below directly into your HTML page header at the top of the page <font color="red">(recommended for better performance)</font></span>
	          </td>
      </tr>

      <tr>
      	<td><img src="http://welcome.hp-ww.com/img/s.gif" width="1" height="5" alt=""></td>
      </tr>
      <tr valign="middle" bgcolor="#f3f3f3">
        <td align="left" bgcolor="#dddddd" class="textBold">EZBuy common header (once in the page)</td>
      </tr>
	  <tr valign="middle" bgcolor="#eeeeee">
        <td class="text">

<!-- delete any tab before ezbuy_implementation_code_include -->
		<textarea name="ezbuycode" rows="3" cols="100" readonly style="font-family:HP Simplified, Verdana, Arial, Helvetica, sans-serif;">
<script language="JavaScript" type="text/javascript">
//ezbpartnr contains a semicolon separated list of all ezbuy partnumbers called in the page
var ezbpartnr='C6656AE';
</script></textarea>
        </td>
      </tr>
</table>

</td>
</tr>
<tr>
<td>


<table width="600" border="0" cellpadding="4" cellspacing="2">
      <tr valign="middle" bgcolor="#eeeeee">

	          <td class="textBold">Instructions<br>
	            <span class="textSmall" style="font-family:'HP Simplified', Verdana, Arial, Helvetica, sans-serif;">copy and paste the code below directly into your HTML page at the place you want to get EZBuy</span>
	          </td>
      </tr>
      <tr>
      	<td><img src="http://welcome.hp-ww.com/img/s.gif" width="1" height="5" alt=""></td>
      </tr>
      <tr valign="middle" bgcolor="#f3f3f3">

        <td align="left" bgcolor="#dddddd" class="textBold">EZBuy implementation code (for every product/start from price)</td>
      </tr>
	  <tr valign="middle" bgcolor="#eeeeee">
        <td class="text">
<!-- delete any tab before ezbuy_implementation_code_include -->
		<textarea name="ezbuycode" rows="12" cols="100" readonly style="font-family:HP Simplified, Verdana, Arial, Helvetica, sans-serif;">
<!-- BEGIN EZBUY LITE -->
<script language="JavaScript" type="text/javascript">
partnr='C6656AE';
guistyle="normal";
if(!window.scLoaded)
	document.write("<"+"script language=\"JavaScript\" type=\"text/javascript\" src=\"http://h41213.www4.hp.com/ezbuy/common/php/loadjs.php?m_s=smb&country=uk&lang=en\"><"+"/script>");
</script>
<script language="JavaScript" type="text/javascript">ezb();</script><noscript><span class="color003366">&amp;raquo;&amp;nbsp;</span><a href="http://h41213.www4.hp.com/ezbuy/common/php/shopbot.php?partnr=C6656AE&m_s=smb&country=uk&lang=en">Buy Online</a></noscript>
<!-- END EZBUY LITE -->		</textarea>
        </td>
      </tr>
</table>

</td>
</tr>
</table>
    </div>
</div>


<script type="text/javascript">
//DO NOT REMOVE THE FOLLOWING LINE THAT IS A MARKER
//<!--START-->
var temp_mem="";
EZB=window.EZB || {};
EZB.EzbExplorerCode = function() {
	var Event = YAHOO.util.Event,
	Dom = YAHOO.util.Dom,
	Button = YAHOO.widget.Button,
	Get = YAHOO.util.Get,
	Results;

	var onEzbExplorerCodeSuccess = function() {
		elResults.innerHTML= "------------>EZB Implementation code:" + elResults.innerHTML;
	}

	var getEzbExplorerCode = function() {
		elResults = Dom.get("results_code");
		if(temp_mem=="")
			temp_mem=elResults.innerHTML;
		else
			elResults.innerHTML=temp_mem;
		elResultsError = Dom.get("results_code_error");

		cc=(Dom.get("cc_ll_code").value.split("/"))[0];
		lc=(Dom.get("cc_ll_code").value.split("/"))[1];
		template=Dom.get("template_code").value;
		ms=Dom.get("m_s_code").value;
		js_code=Dom.get("js_code").value;
		partnr=Dom.get("partnumber_code").value.toUpperCase();

		partnr=partnr.replace(/\n/g,";");
		partnr=partnr.replace(/\r/g,";");
		partnr=partnr.replace(/\t/g,";");
		partnr=partnr.replace(/,/g,";");
		partnr=partnr.replace(/ /g,";");
		partnr=partnr.replace(/\;+/g,";");

		if(template=="start" && partnr.indexOf(";")==-1)
			partnr=partnr+";";
		var old_template=template;
		if(partnr.indexOf(";")!=-1)
			template="small";

		if(!cc || !lc || !ms || !js_code || !partnr){
			elResultsError.innerHTML = "<h3 style=\"font-weight:bold;\">Please select all input parameters</h3>";
			YAHOO.util.Dom.setStyle('results_code', 'visibility', 'hidden');
		}else{
			elResultsError.innerHTML = "";
			elResults.innerHTML = elResults.innerHTML.replace(/partnr.*?=.*?['"].*?['"]/g,'partnr=\''+partnr+'\'');
			elResults.innerHTML = elResults.innerHTML.replace(/partnr=.*?&/g,'partnr='+partnr+'&');
			elResults.innerHTML = elResults.innerHTML.replace(/guistyle.*?=.*?['"].*?['"]/g,'guistyle=\''+template+'\'');
			elResults.innerHTML = elResults.innerHTML.replace(/country=.*?&/g,'country='+cc+'&');
			elResults.innerHTML = elResults.innerHTML.replace(/lang=.*?"/g,'lang='+lc+' \\"');
			elResults.innerHTML = elResults.innerHTML.replace(/m_s=.*?&/g,'m_s='+ms+'&');
			if(old_template!="start"){
				var reg=new RegExp("&lt;a href=(.*?)&gt;.*?&lt;\/a&gt;", "g");
				elResults.innerHTML=elResults.innerHTML.replace(reg,"<a href=$1>"+js_code+"</a>");
			}else{
				elResults.innerHTML=elResults.innerHTML.replace(/&lt;noscript.*?noscript&gt;/g,"");
			}

			YAHOO.util.Dom.setStyle('results_code', 'visibility', 'visible');

		}
	};
	return {
		init: function() {
			Event.on("EzbExplorerCode", "submit", function(e) {
				Event.preventDefault(e);
				getEzbExplorerCode();
			}, this, true);

			var oButton = new Button("getEzbExplorerCodeBtn");
			oButton.focus();
			oButton.blur();
		}
	}
}();
//DO NOT REMOVE THE FOLLOWING LINE THAT IS A MARKER
//<!--END-->

YAHOO.util.Event.onDOMReady(
	EZB.EzbExplorerCode.init,
	EZB.EzbExplorerCode, 		//pass this object to init and...
	true);								//...run init in the passed object's
</script>

<!--END SOURCE CODE FOR EXAMPLE =============================== -->


</body>
</html>