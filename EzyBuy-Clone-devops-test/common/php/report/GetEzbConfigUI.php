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
/*
.dbg-value .dbg-toggle-open .dbg-toggle {
  list-style-image : url("minus.gif");
}
.dbg-value .dbg-toggle-closed .dbg-toggle {
  list-style-image : url("plus.gif");
*/
}
</style>

<link rel="stylesheet" type="text/css" href="../../js/utils/yui/build/fonts/fonts-min.css?_yuiversion=2.4.1" />
<link rel="stylesheet" type="text/css" href="../../js/utils/yui/build/button/assets/skins/sam/button.css?_yuiversion=2.4.1" />
<script type="text/javascript" src="../../js/utils/yui/build/yahoo-dom-event/yahoo-dom-event.js?_yuiversion=2.4.1"></script>
<script type="text/javascript" src="../../js/utils/yui/build/element/element-beta.js?_yuiversion=2.4.1"></script>

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

<div id="container_config">

	<!--Use a real form that works without JavaScript:-->
	<form id="EzbExplorerConfig">

 <table border="0" cellpadding="4" cellspacing="2" width="600">
	      <tbody>
	        <tr bgcolor="#f3f3f3" valign="middle">
	          <td colspan="2" align="center" bgcolor="#dddddd" class="textBold">Choose your preferences</td>
	        </tr>

	        <tr bgcolor="#eeeeee" valign="middle">
	          <td width="300" class="text">Country/language</td>
	          <td width="300"><div align="left">
	            <select name="ctrysettings" id="cc_ll">
	              <option value="" selected="selected">Select... </option>
	              <?php
				  	              include("include/GetCountries.inc.php");
	              ?>
	            </select>
	          </div></td>
	        </tr>
	        <tr bgcolor="#eeeeee" valign="middle">
	          <td class="text">Market segment</td>
	          <td width="300"><div align="left">
	          	<INPUT id="m_s_smb" type="radio" name="segment" value="smb" checked>smb
	          	
	          </div></td>
	        </tr>
	        <tr bgcolor="#eeeeee" valign="middle">
	          <td class="text">Price publisher</td>
	          <td><div align="left">
	            <select name="client" id="client">
					<option value="hp.com">hp.com (general)</option>
					<option value="SureSupply">Others</option>
				</select>
	          </div></td>
	        </tr>



	        <tr bgcolor="#f3f3f3" valign="middle">
	          <td colspan="2" align="right" bgcolor="#dddddd"><div align="center">
	            <input type="submit" id="getEzbExplorerConfigBtn" value="Get Country Configuration">
	          </div></td>
	        </tr>
	      </tbody>
	    </table>


    </form>

	<div id="results_config" style="font-family:HP Simplified, Verdana, Arial, Helvetica, sans-serif;">
    	<!--JSON output will be written to the DOM here-->

    </div>
</div>

<script type="text/javascript">
//DO NOT REMOVE THE FOLLOWING LINE THAT IS A MARKER
//<!--START-->
EZB=window.EZB || {};
EZB.EzbExplorerConfig = function() {

	var Event = YAHOO.util.Event,
	Dom = YAHOO.util.Dom,
	Button = YAHOO.widget.Button,
	Get = YAHOO.util.Get,
	elResults;

	var onEzbExplorerConfigSuccess = function() {
		elResults.innerHTML= "------------>Config Loaded" + elResults.innerHTML;
	}

	var getEzbExplorerConfig = function() {
		elResults = document.getElementById("results_config");
		cc=(Dom.get("cc_ll").value.split("/"))[0];
		lc=(Dom.get("cc_ll").value.split("/"))[1];
		//ms=Dom.get("m_s_hho").checked?"hho":"smb";
		ms=Dom.get("m_s_smb").checked?"smb":"hho";
		
		client=Dom.get("client").value;

		if(!cc || !lc || !ms || !client){
			elResults.innerHTML = "<h3 style=\"font-weight:bold;\">Please select all input parameters<h3>";
		}else{
			//Load the transitional state of the results section:
			elResults.innerHTML = "<h3 style=\"font-weight:bold;\">Retrieving EZB data for " +
				Dom.get("cc_ll").value + ":</h3>" +
				"<img src='http://l.yimg.com/us.yimg.com/i/nt/ic/ut/bsc/busybar_1.gif' " +
				"alt='Please wait...'>";

			var sURL = "../GetEzbConfig.php"+"?cc="+cc+"&lc="+lc+"&ms="+ms+"&clientId="+client+"&format=JSON&callback=EZB.EzbExplorerConfig.callback";

			var transactionObj = Get.script(sURL, {
				onSuccess: onEzbExplorerConfigSuccess,
				scope    : this
			});
		}
	};
	return {
		init: function() {
			Event.on("EzbExplorerConfig", "submit", function(e) {
				Event.preventDefault(e);
				getEzbExplorerConfig();
			}, this, true);
			var oButton = new Button("getEzbExplorerConfigBtn");
			oButton.focus();
			oButton.blur();
		},
		callback: function(results_config) {
			var json_string=JSON.stringify(results_config);
			var new_json_string=(decodeURIComponent(json_string)).replace(/\+/g," ").replace(/@P@/g,"+").replace(/@Q@/g,"\\\"").replace(/@B@/g,"\\\\");
			var d = new DebuggableObject(JSON.parse(new_json_string));
	    	d.render(elResults);
			elResults.innerHTML+= "<HR>"+new_json_string;
		}
	}
}();
//DO NOT REMOVE THE FOLLOWING LINE THAT IS A MARKER
//<!--END-->

//Initialize the example when the DOM is completely loaded:
YAHOO.util.Event.onDOMReady(
	EZB.EzbExplorerConfig.init,
	EZB.EzbExplorerConfig, 		//pass this object to init and...
	true);								//...run init in the passed object's
										//scope


</script>

<!--END SOURCE CODE FOR EXAMPLE =============================== -->


</body>
</html>