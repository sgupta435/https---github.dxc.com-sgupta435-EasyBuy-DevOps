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
	margin: 0;
	padding: 0;
}

#container .bd:after {
	content: ".";
	display: block;
	clear: left;
	height: 0;
	visibility: hidden;
}
</style>
<link rel="stylesheet" type="text/css" href="../../js/utils/yui/build/container/assets/skins/sam/container.css" />
<link rel="stylesheet" type="text/css" href="../../js/utils/yui/build/fonts/fonts-min.css?_yuiversion=2.4.1" />
<link rel="stylesheet" type="text/css" href="../../js/utils/yui/build/button/assets/skins/sam/button.css?_yuiversion=2.4.1" />

<script type="text/javascript" src="../../js/utils/yui/build/yahoo-dom-event/yahoo-dom-event.js?_yuiversion=2.4.1"></script>
<script type="text/javascript" src="../../js/utils/yui/build/element/element-beta-min.js?_yuiversion=2.4.1"></script>
<script type="text/javascript" src="../../js/utils/yui/build/button/button-min.js?_yuiversion=2.4.1"></script>
<script type="text/javascript" src="../../js/utils/yui/build/get/get-min.js?_yuiversion=2.4.1"></script>
<script type="text/javascript" src="../../js/utils/yui/build/utilities/utilities.js"></script>
<script type="text/javascript" src="../../js/utils/yui/build/container/container-min.js"></script>

<script type="text/javascript" src="../../js/utils/json/JsonString.js?ss"></script>

<script type="text/javascript" language="JavaScript" src="http://welcome.hp-ww.com/country/uk/en/js/hpweb_utilities.js"></script>

</head>

<body class=" yui-skin-sam">
<a name="start"></a>
<script>
if (!window.scLoaded){
	document.write("<"+"script language=\"JavaScript\" type=\"text/javascript\" src=\"../loadjs.php?country=uk&lang=en\"><"+"/script>");
}
</script>

<form method="GET" id="EzbExplorerTemplate">
	<table border="0" cellpadding="4" cellspacing="2" width="600">
		<tbody>
			<tr bgcolor="#f3f3f3" valign="middle">
				<td colspan="2" align="center" bgcolor="#dddddd" class="textBold">Choose your preferences</td>
			</tr>
			<tr bgcolor="#eeeeee" valign="middle">
				<td width="300" class="text">Country/language</td>
				<td width="300">
					<div align="left">
						<select name="ctrysettings" id="cc_ll_template">
							<option value="" selected="selected">Select...</option>
	              <?php
	              include("include/GetCountries.inc.php");
	              ?>
						</select>
					</div>
				</td>
			</tr>
			<tr bgcolor="#eeeeee" valign="middle">
				<td class="text">Market segment</td>
				<td width="300">
					<div align="left">
	          	<INPUT id="m_s_template_smb" type="radio" name="segment" value="smb" checked>smb
	          	
					</div>
				</td>
			</tr>
			<tr bgcolor="#eeeeee" valign="middle">
				<td class="text">Template</td>
				<td width="300">
					<div align="left">
						<select name="template" id="template_template">
							<option value="normal">Normal</option>
							<option value="small">Small</option>
							<option value="simple">Simple</option>
							<option value="start">Start From</option>
						</select>
					</div>
				</td>
			</tr>
			<tr bgcolor="#eeeeee" valign="middle">
				<td class="text">Experience</td>
				<td width="300">
					<div align="left">
						<select name="experience" id="experience_template">
							<option value="neutral">Neutral</option>
							<option value="channel">Channel</option>
							<option value="direct">Direct</option>
						</select>
					</div>
				</td>
			</tr>
			<tr bgcolor="#eeeeee" valign="middle">
				<td class="text">Price publisher</td>
				<td>
					<div align="left">
						<select name="client" id="client_template">
							<option value="hp.com">hp.com (general)</option>
							<option value="SureSupply">SureSupply</option>
							<option value="Report">Report (e.g no options set)</option>
						</select>
					</div>
				</td>
			</tr>
			<tr bgcolor="#eeeeee" valign="middle">
				<td class="text">Partnumber<br />
					<span class="textSmall">Separate by carriage returns, comma, semicolon or spaces for multiple products.<br />
					</span>
				</td>
				<td width="300">
					<div align="left">
						<textarea name="partnumber" cols="20" rows="5" id="partnumber_template"></textarea>
					</div>
				</td>
			</tr>
			<tr bgcolor="#eeeeee" valign="middle">
          <td class="text">Product Line<br />
            <span class="textSmall">Product line [optional. uses PL specific country settings if defined].<br/></span></td>
          <td width="300"><div align="left">
           <input id="pl_template" type="text" maxlength="2" size="2" name="pl_template"/>
          </div></td>
        </tr>

			<tr bgcolor="#f3f3f3" valign="middle">
				<td colspan="2" align="right" bgcolor="#dddddd">
					<div align="center">
						<input type="submit" id="getEzbExplorerTemplateBtn" value="View EZB Templates.">
					</div>
				</td>
			</tr>
			<tr bgcolor="#f3f3f3" valign="middle">
				<td colspan="2" align="right" bgcolor="#dddddd">
					<div id="getEzbModifyTemplateBtn"></div>
				</td>
			</tr>
		</tbody>
	</table>
</form>
<div id="results_template"></div>
<div id="getEzbModifyTemplateForm">
	<div class="hd">Modify Product/Configuration</div>
	<div class="bd">
		<div id="res">
				<table>
					<tr bgcolor="#eeeeee" valign="middle">
						<td class="text">Partnumber<br />
						<span class="textSmall">Modify Product Data<br />
						</span></td>

						<td width="300">
						<div align="left"><textarea name="PJSON" cols="80"
							rows="10" id="PJSON"></textarea></div>
						</td>
					</tr>

					<tr bgcolor="#eeeeee" valign="middle">
						<td class="text">Partnumber<br />
						<span class="textSmall">Modify Country Congfiguration<br />
						</span></td>

						<td width="300">
						<div align="left"><textarea name="CJSON" cols="80" rows="10"
							id="CJSON"></textarea></div>
						</td>
					</tr>
				</table>
		</div>
	</div>
</div>

<div id="help"></div>

<script type="text/javascript">
//DO NOT REMOVE THE FOLLOWING LINE THAT IS A MARKER
//<!--START-->

var PJSON,CJSON,mypartnr,cc,style,experience,lc,ms,client,partnra;
EZB=window.EZB || {};

EZB.EzbExplorerTemplate = function() {
	var Event = YAHOO.util.Event,
		Dom = YAHOO.util.Dom,
		Button = YAHOO.widget.Button,
		Get = YAHOO.util.Get;

	var results_memory="";

	var getEzbExplorerTemplate = function() {

		/* form data */
		elResults = Dom.get("results_template");
		cc=(Dom.get("cc_ll_template").value.split("/"))[0];
		style=Dom.get("template_template").value;
		experience=Dom.get("experience_template").value;
		lc=(Dom.get("cc_ll_template").value.split("/"))[1];
		//ms=Dom.get("m_s_template_hho").checked?"hho":"smb";
		ms=Dom.get("m_s_template_smb").checked?"smb":"hho";
		client=Dom.get("client_template").value;

		pl=Dom.get("pl_template").value.toUpperCase();

		mypartnr=Dom.get("partnumber_template").value.toUpperCase();
		mypartnr=mypartnr.replace(/\n/g,";");
		mypartnr=mypartnr.replace(/\r/g,"");
		mypartnr=mypartnr.replace(/\t/g,"");
		mypartnr=mypartnr.replace(/,/g,";");
		mypartnr=mypartnr.replace(/ /g,";");
		mypartnr=mypartnr.replace(/\;+/g,";");
		partnra=mypartnr.split(";");

		var onEzbExplorerTemplateSuccess = function() {
		CJSON=(new EZB.Utils.JSONcopy(EZB.Config.Initial))
		if(CJSON.Response.status.code!=1 && PJSON.Response.status.code!=1){
			elResults.innerHTML= "Errors:"+CJSON.Response.status.message+" "+PJSON.Response.status.message;
		}else{

		//update dialog form
			document.getElementById('CJSON').value=JSON.stringify(CJSON);
			document.getElementById('PJSON').value=JSON.stringify(PJSON);

			elResults.innerHTML= "------------>Products Loaded:.";

			ezbpartnr=mypartnr;
			EZB.Clean();
			EZB.Context.ForcedDisplayId="results_template";
			EZB.Context.ezbpartnr=mypartnr;
			EZB.Context.ezbuyExperience=experience;
			ezbuyExperience=experience;
			EZB.Context.cc=cc;
			EZB.Context.lc=lc;
			EZB.Context.m_s=ms;
			EZB.Context.clientID=client;
			EZB.Loaded.Defered=true;
		//EZB.Patch.Init();
			EZB.Settings.options+=",showAMDLogo,showIntelLogo";
			guistyle=style;
			var mem="";
			var el_id;

			if(style!="start"){/* not start from */
				for(var i=0;i< partnra.length;i++){/* display for all products */
					partnr=partnra[i];
					el_id=['EZBox_ezb_',i,'_',partnra[i],'_',guistyle].join('');
					ezb(CJSON,PJSON,'results_template');
				}

				var last_el_id=el_id;

				YAHOO.util.Event.onAvailable(last_el_id, function(){ /* display around products when all are available */
					for(var i=0;i< partnra.length;i++){ /* loop again through all products */
						var el_id=['EZBox_ezb_',i,'_',partnra[i],'_',guistyle].join('');
						var pn=el_id.replace(/EZBox_ezb_[^_]*/g,"").replace(/_/,"").replace(/_.*/g,"");
						var e=document.getElementById(el_id);
						if(e){
							mem+=[pn," | "].join('');
							e.innerHTML="<span style='background:orange none repeat scroll 0%;height:10px;width:200px;'>["+cc+"/"+lc+"/"+ms+"] "+pn+"</span><div width='101%;' id='"+el_id+"_container' style='width:101%;border:1px solid orange'>"+e.innerHTML+"</div>";
						}else{
							mem+=["<font color='red'>",pn,"</font>"," | "].join('');
						}
					}
					var temp=elResults.innerHTML;
					temp=temp.replace(
						/Products Loaded:[^.]*/g,
						["Products Loaded:", mem ].join(''));
					elResults.innerHTML= temp;
				},this);
			}else{
				partnr=mypartnr;
				if(partnr.indexOf(";")==-1)
					partnr=partnr+";"+partnr; /* start from price unique product trick */
				var temp=elResults.innerHTML;
				temp=temp.replace(
					/Products Loaded:[^.]*/g,
					["Products Loaded:", mypartnr,"<BR>","DONE" ].join(''));
				elResults.innerHTML= temp;
				ezb(CJSON,PJSON,'results_template');
			}
			//before leaving switch modification button to on
			if(!window.PushButtonTemplate){
				PushButtonTemplate = new YAHOO.widget.Button({
    	                       		label:"Modify/Simulate Products Data/ Country Configuration",
        	                   		id:"pushbuttontemplate",
            	               		container:"getEzbModifyTemplateBtn"
	        	});
				PushButtonTemplate.focus();
				PushButtonTemplate.blur();
				Event.on("pushbuttontemplate", "click", function(e) {
						Event.preventDefault(e);
						EZB.EzbModifyTemplate.dialog.show();
					}, this, true);
			}
			}
		};

		if(!cc || !lc || !ms || !client || !mypartnr){
			elResults.innerHTML = "<h3 style=\"font-weight:bold;\">Please select all input parameters "+results_memory+"</h3>";
			results_memory=results_memory+".";
		}else{
			elResults.innerHTML = "<h3 style=\"font-weight:bold;\">Retrieving EZB data for " +
				Dom.get("cc_ll_template").value + ":</h3>" +
				"<img src='http://l.yimg.com/us.yimg.com/i/nt/ic/ut/bsc/busybar_1.gif' " +
				"alt='Please wait...'>";
			CJSON={};
			PJSON={};
			EZB.Context.ForcedDisplayId=false;
			var sURL0 = [
						"../EzbProcess.php?cc=", cc,
						"&lc=", lc,
						"&ms=",ms,
						"&clientID=",client,
						"&version=999"].join('');
			var sURL1 = [
						"../GetEzbConfig.php?cc=", cc,
						"&lc=", lc,
						"&ms=",ms,
						"&clientId=hp.com",
						"&format=JSON&callback=EZB.EzbExplorerTemplate.callback_config"].join('');
			var sURL2 = [
						"../GetEzbData.php?cc=", cc,
						"&browse=1",
						"&lc=", lc,
						"&ms=", ms,
						"&partnr=", mypartnr,
						"&format=json&callback=EZB.EzbExplorerTemplate.callback_data&clientId=", client,
						"&JSparam=PL|",pl,
						"&type=",experience=="direct"?"hp":""
						].join('');
			var transactionObj = Get.script([sURL0,sURL2], {
				onSuccess: onEzbExplorerTemplateSuccess,
				scope    : this
			});
		}
	};
	return {
		init: function() {
			Event.on("EzbExplorerTemplate", "submit", function(e) {
				Event.preventDefault(e);
				getEzbExplorerTemplate();
			}, this, true);
			var oButton = new Button("getEzbExplorerTemplateBtn");
			oButton.focus();
			oButton.blur();
		},
		callback_data: function(results) {
			PJSON=(new EZB.Utils.JSONcopy(results));
		},
		callback_config: function(results) {
			CJSON=(new EZB.Utils.JSONcopy(results));
		}
	}
}();


EZB.EzbModifyTemplate = function() {
	var Event = YAHOO.util.Event,
		Dom = YAHOO.util.Dom,
		Button = YAHOO.widget.Button,
		Get = YAHOO.util.Get;
		var dialog;

	//update dialog form
	if(document.getElementById('CJSON'))
		document.getElementById('CJSON').value=JSON.stringify(CJSON);
	if(document.getElementById('PJSON'))
		document.getElementById('PJSON').value=JSON.stringify(PJSON);

	var help=function(){
		var panel= new YAHOO.widget.Panel("panel", { width:"600px", fixedcenter : true, visible:true, draggable:true, close:true } );
		panel.setHeader("Valid product/reseller format example under 'list' node");
		var help_json={ "Response": { "version":"1.0", "status": { "code":"1", "message":"ok" }, "query": { "cc":"il", "lc":"he", "ms":"hho", "clientId":"hp.com", "format":"json", "partnr":"KG665EA", "callback":"EZB.EzbExplorerTemplate.callback_data" }, "results": { "products": { "returned":"1", "rules":"kelkoo.hp.hp.com.json.il.he.hho.options_exclusion.price_indication.options_disable.options_hide", "list": { "KG665EA": { "l":"amd_A","pp":"4323", "pi":"4699", "pro":{"pf":"promotion flag","pt":"1","h":"promo header","te":"promo terms","ur":"urgency","pm":"promo info"},"r":[{"id":"3691423","mp2b":"1","pr":"110","st":"5","t":"hp","n":"en ligne chez HP","u":"http://www.hp.com","m":"BUY from us."},{"id":"6299523","mp2b":"1","pr":"106","st":"2","t":"ebus","n":"Bestprints.com","u":"http:\/\/www.hp.com","m":"this message"}] } } } } } };
		panel.setBody('<PRE>'+JSON.stringify(help_json.Response.results.products.list)+'</PRE>');
		panel.setFooter("End of Example");
		panel.render("help");
	};

	var getEzbModifyTemplate = function() {
		//YAHOO.util.Dom.setStyle('getEzbModifyTemplateForm','display','inline');
		var dialog = new YAHOO.widget.Dialog("getEzbModifyTemplateForm", {
	           								context:["show", "tl", "bl"],
	           								fixedcenter : true,
	           								visible: false,
	           								buttons:[
	           											{text:"Select", isDefault:true, handler: onEzbModifyTemplateSuccess},
	                     								{text:"Cancel", handler: function(){dialog.hide();}},
	                     								{text:"Help", handler: help}
	                     							],
	           								width:"65em",  // Sam Skin dialog needs to have a width defined (7*2em + 2*1em = 16em).
	           								draggable:true,
	           								close:true
		});
		dialog.render();
		return(dialog);
	};


	var onEzbModifyTemplateSuccess = function() {
		try{
			CJSON=JSON.parse(document.getElementById('CJSON').value);
			PJSON=JSON.parse(document.getElementById('PJSON').value);
		}catch(e){
			alert('invalid format');
			return(false);
		}

	//	EZB.Context.ForcedDisplayId='results_template';
	//	var partnr=mypartnr;
	//	ezb(CJSON,PJSON,'results_template');
						var mem="";
			var el_id;

			if(style!="start"){/* not start from */
				for(var i=0;i< partnra.length;i++){/* display for all products */
					partnr=partnra[i];
					el_id=['EZBox_ezb_',i,'_',partnra[i],'_',guistyle].join('');
					if(document.getElementById(el_id+"_container")){
						ezb(CJSON,PJSON,el_id+"_container");
					}else{
						ezb(CJSON,PJSON,'results_template');
					}
				}
			}else{
				partnr=mypartnr;
				if(partnr.indexOf(";")==-1)
					partnr=partnr+";"+partnr; /* start from price unique product trick */
				var temp=elResults.innerHTML;
				temp=temp.replace(
					/Products Loaded:[^.]*/g,
					["Products Loaded:", mypartnr,"<BR>","DONE" ].join(''));
				elResults.innerHTML= temp;
				ezb(CJSON,PJSON,'results_template');
			}
	};

	return {
		init: function() {
				return(getEzbModifyTemplate());

		},
		dialog: getEzbModifyTemplate()
	}
}();
//DO NOT REMOVE THE FOLLOWING LINE THAT IS A MARKER
//<!--END-->

YAHOO.util.Event.onDOMReady(
	EZB.EzbExplorerTemplate.init,
	EZB.EzbExplorerTemplate, 		//pass this object to init and...
	true);								//...run init in the passed object's
YAHOO.util.Event.onDOMReady(
	EZB.EzbModifyTemplate.dialog,
	EZB.EzbModifyTemplate, 		//pass this object to init and...
	true);								//...run init in the passed object's
</script>

<!--END SOURCE CODE FOR EXAMPLE =============================== -->
</body>
</html>
