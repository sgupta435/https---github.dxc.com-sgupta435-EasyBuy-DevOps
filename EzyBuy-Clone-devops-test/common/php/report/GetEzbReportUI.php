
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
<script type="text/javascript" src="../../js/utils/yui/build/connection/connection-min.js?_yuiversion=2.4.1"></script>


<script language="javascript" src="GetEzbReport/reportTableFunctions.js" ></script>
<script language="javascript" src="GetEzbReport/sarissa.js" ></script>
<link href="GetEzbReport/reportStyle.css" rel="stylesheet" type="text/css" />

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

<div id="container_report">

	<!--Use a real form that works without JavaScript:-->
	<form method="GET" id="EzbExplorerReport">

 <table border="0" cellpadding="4" cellspacing="2" width="600">
	      <tbody>
	        <tr bgcolor="#f3f3f3" valign="middle">
	          <td colspan="2" align="center" bgcolor="#dddddd" class="textBold">Choose your preferences</td>
	        </tr>

	        <tr bgcolor="#eeeeee" valign="middle">
	          <td width="300" class="text">Country/language</td>
	          <td width="300"><div align="left">
	            <select name="ctrysettings" id="cc_ll_report">
	              <option value="" selected="selected">Select... </option>
	             <?php
				 	              include("include/GetCountries.inc.php");
	              ?>
	            </select>
	          </div></td>
	        </tr>
	        <tr bgcolor="#eeeeee" valign="middle">
	          <td class="text">Market segment</td>
	          <td width="300"><div align="left" style="font-family:HP Simplified, Verdana, Arial, Helvetica, sans-serif;">
	          	<INPUT id="m_s_report_smb" type="radio" name="segment" value="smb" checked>smb
	          	
	          </div></td>
	        </tr>
	        <tr bgcolor="#eeeeee" valign="middle">
	          <td class="text">Price publisher</td>
	          <td><div align="left">
	            <select name="client" id="client_report">
					<option value="Report">hp.com (general)</option>
					<option value="SureSupply">SureSupply</option>
	            </select>
	          </div></td>
	        </tr>
		<tr bgcolor="#eeeeee" valign="middle">
          <td class="text">Partnumber<br />
            <span class="textSmall" style="font-family:'HP Simplified', Verdana, Arial, Helvetica, sans-serif;">Separate by carriage returns, comma, semicolon or spaces for multiple products.<br/></span></td>

          <td width="300"><div align="left" class="text">
            <textarea name="partnumber" style="font-family:HP Simplified, Verdana, Arial, Helvetica, sans-serif;" cols="20" rows="5" id="partnumber_report"></textarea>
          </div></td>
        </tr>


	        <tr bgcolor="#f3f3f3" valign="middle">
	          <td colspan="2" align="right" bgcolor="#dddddd"><div align="center">
	            <input type="submit" id="getEzbExplorerReportBtn" value="Get Prices Table Report">
	          </div></td>
	        </tr>
	      </tbody>
	    </table>


    </form>


    <div id="results_report">
	    	<!--JSON output will be written to the DOM here-->

    </div>
</div>

<script type="text/javascript">
//DO NOT REMOVE THE FOLLOWING LINE THAT IS A MARKER
//<!--START-->
EZB=window.EZB || {};
EZB.EzbExplorerReport = function() {
	var Event = YAHOO.util.Event,
	Dom = YAHOO.util.Dom,
	Button = YAHOO.widget.Button,
	Get = YAHOO.util.Get;

	var onEzbExplorerReportSuccess = {
		success: function(o){
			if (window.ActiveXObject){
				doc=new ActiveXObject("Microsoft.XMLDOM");
				doc.async="false";
				doc.loadXML(o.responseText);
			}else{
				var parser=new DOMParser();
				doc=parser.parseFromString(o.responseText,"text/xml");
			}

			alterTable = 0;
			altTable = 0;
			betTable  = 0;
			if(false && ms == "hho"){
				if(client == "Report"){
					xslStylesheet = "GetEzbReport/reportHPComEpp.xsl";
					alterTable = 1;
				}else{
					 xslStylesheet = "GetEzbReport/reportSureSupplyEpp.xsl";
				}
				altTable = 1;
				betTable = 2;
			}else{
				if(client == "Report"){
					xslStylesheet = "GetEzbReport/reportHPCom.xsl";
					alterTable = 1;
				}else{
					xslStylesheet = "GetEzbReport/reportSureSupply.xsl";
				}
			}

			elResults.innerHTML= "------------>Product(s) Loaded:<BR/>";
			//alert elResults;

			var xslReq = new XMLHttpRequest();
			xslReq.open("GET", xslStylesheet, false);
			xslReq.send(null);

			var xmlParser = new DOMParser();
			var xsldoc = xmlParser.parseFromString(xslReq.responseText, "text/xml");

			var xslDoc = Sarissa.getDomDocument();
			var processor = new XSLTProcessor();
			processor.importStylesheet(xsldoc);
			var resultDocument = processor.transformToDocument(doc);
			elResults.innerHTML+=(Sarissa.serialize(resultDocument));
			addImage();
			jsArray=partnr.split(";");
			changeRankValue(jsArray);
			changeRowBackClr();
			changeStockValue();
			changeMessage();
			attachFilter(document.getElementById('results'), 1);
			Tooltip.init();
		},
		failure: function(o){}
	}

	var getEzbExplorerReport = function() {
		elResults = Dom.get("results_report");
		cc=(Dom.get("cc_ll_report").value.split("/"))[0];
		lc=(Dom.get("cc_ll_report").value.split("/"))[1];
		//ms=Dom.get("m_s_report_hho").checked?"hho":"smb";
		ms=Dom.get("m_s_report_smb").checked?"smb":"hho";
		client=Dom.get("client_report").value;
		partnr=Dom.get("partnumber_report").value.toUpperCase();

		if(!cc || !lc || !ms || !client || !partnr){
			elResults.innerHTML = "<h3>Please select all input parameters ";
		}else{
			elResults.innerHTML = "<h3>Retrieving EZB data for " +
				Dom.get("cc_ll_report").value + ":</h3>" +
				"<img src='http://l.yimg.com/us.yimg.com/i/nt/ic/ut/bsc/busybar_1.gif' " +
				"alt='Please wait...'>";
			partnr=partnr.replace(/\n/g,";");
			partnr=partnr.replace(/\r/g,";");
			partnr=partnr.replace(/\t/g,";");
			partnr=partnr.replace(/,/g,";");
			partnr=partnr.replace(/ /g,";");
			partnr=partnr.replace(/\;+/g,";");
			var sURL =  "../GetEzbData.php";
			var transactionObj = YAHOO.util.Connect.asyncRequest('POST',sURL,onEzbExplorerReportSuccess,"browse=1&partnr="+partnr+"&cc="+cc+"&lc="+lc+"&ms="+ms+"&clientId="+client+"&format=xml");
		}
	};
	return {
		init: function() {
			Event.on("EzbExplorerReport", "submit", function(e) {
				Event.preventDefault(e);
				getEzbExplorerReport();
			}, this, true);

			var oButton = new Button("getEzbExplorerReportBtn");
			oButton.focus();
			oButton.blur();
		}
	}
}();
//DO NOT REMOVE THE FOLLOWING LINE THAT IS A MARKER
//<!--END-->

YAHOO.util.Event.onDOMReady(
	EZB.EzbExplorerReport.init,
	EZB.EzbExplorerReport, 		//pass this object to init and...
	true);								//...run init in the passed object's
</script>

<!--END SOURCE CODE FOR EXAMPLE =============================== -->


</body>
</html>