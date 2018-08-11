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

<form method="GET" id="EzbExplorerScenario">
	<table border="0" cellpadding="4" cellspacing="2" width="600">
		<tbody>
			<tr bgcolor="#f3f3f3" valign="middle">
				<td colspan="2" align="center" bgcolor="#dddddd" class="textBold">Choose your preferences</td>
			</tr>
			<tr bgcolor="#eeeeee" valign="middle">
				<td width="300" class="text">Country/language</td>
				<td width="300">
					<div align="left">
						<select name="ctrysettings" id="cc_ll_scenario">
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
	          	<INPUT id="m_s_scenario_smb" type="radio" name="segment" value="smb" checked>smb
	          	
					</div>
				</td>
			</tr>
			<tr bgcolor="#eeeeee" valign="middle">
				<td class="text">Template</td>
				<td width="300">
					<div align="left">
						<select name="scenario" id="scenario_scenario">
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
						<select name="experience" id="experience_scenario">
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
						<select name="client" id="client_scenario">
							<option value="hp.com">hp.com (general)</option>
							<option value="SureSupply">SureSupply</option>
							<option value="Report">Report (e.g no options set)</option>
						</select>
					</div>
				</td>
			</tr>
			<tr bgcolor="#eeeeee" valign="middle">
				<td class="text">Scenario<br />
					<span class="textSmall">
					Select scenarios.<br />
					Note that all scenarios are not relevant for all countries...
					</span>
				</td>
				<td width="300">
					<div align="left">
						          <select name="partnumber[]" id="partnumber_scenario" class="text" style="width: 300px" multiple>
            <option value="not*sold*noprice" selected>not_sold_no_price</option>
            <option value="not*sold*price" selected>not_sold_price</option>
            <option value="partners*only">partners_only</option>
            <option value="store*only*in*stock">store_only_in_stock</option>
            <option value="store*only*2weeks">store_only_2weeks</option>
            <option value="store*only*4weeks">store_only_4weeks</option>

            <option value="partners*store*in*stock">partners_store_in_stock</option>
            <option value="partners*store*2weeks">partners_store_2weeks</option>
            <option value="partners*store*4weeks">partners_store_4weeks</option>
          </select>
					</div>
				</td>
			</tr>
			<tr bgcolor="#eeeeee" valign="middle">
          <td class="text">Product Line<br />
            <span class="textSmall">Product line [optional. uses PL specific country settings if defined].<br/></span></td>
          <td width="300"><div align="left">
           <input id="pl_scenario" type="text" maxlength="2" size="2" name="pl_scenario"/>
          </div></td>
        </tr>

			<tr bgcolor="#f3f3f3" valign="middle">
				<td colspan="2" align="right" bgcolor="#dddddd">
					<div align="center">
						<input type="submit" id="getEzbExplorerScenarioBtn" value="View EZB Scenarios.">
					</div>
				</td>
			</tr>
			<tr bgcolor="#f3f3f3" valign="middle">
				<td colspan="2" align="right" bgcolor="#dddddd">
					<div id="getEzbModifyScenarioBtn"></div>
				</td>
			</tr>
		</tbody>
	</table>
</form>
<div id="results_scenario"></div>
<div id="getEzbModifyScenarioForm">
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
							rows="10" id="PJSONScenario"></textarea></div>
						</td>
					</tr>

					<tr bgcolor="#eeeeee" valign="middle">
						<td class="text">Partnumber<br />
						<span class="textSmall">Modify Country Congfiguration<br />
						</span></td>

						<td width="300">
						<div align="left"><textarea name="CJSON" cols="80" rows="10"
							id="CJSONScenario"></textarea></div>
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

var PJSONScenario,CJSONScenario,mypartnr,cc,style,experience,lc,ms,client,partnra;
EZB=window.EZB || {};

EZB.EzbExplorerScenario = function() {
	var Event = YAHOO.util.Event,
		Dom = YAHOO.util.Dom,
		Button = YAHOO.widget.Button,
		Get = YAHOO.util.Get;

	var results_memory="";

	var getEzbExplorerScenario = function() {

		/* form data */
		elResults = Dom.get("results_scenario");
		cc=(Dom.get("cc_ll_scenario").value.split("/"))[0];
		style=Dom.get("scenario_scenario").value;
		experience=Dom.get("experience_scenario").value;
		lc=(Dom.get("cc_ll_scenario").value.split("/"))[1];
		//ms=Dom.get("m_s_scenario_hho").checked?"hho":"smb";
		ms=Dom.get("m_s_scenario_smb").checked?"smb":"hho";
		client=Dom.get("client_scenario").value;

		pl=Dom.get("pl_scenario").value.toUpperCase();

		mypartnr="";
		l=Dom.get("partnumber_scenario").options.length;
		for(i=0;i<l;i++){
			if(Dom.get("partnumber_scenario").options[i].selected==true)
				mypartnr+=(i>0?";":"")+Dom.get("partnumber_scenario").options[i].value;
		}

		mypartnr=mypartnr.toUpperCase();
		mypartnr=mypartnr.replace(/\n/g,";");
		mypartnr=mypartnr.replace(/\r/g,"");
		mypartnr=mypartnr.replace(/\t/g,"");
		mypartnr=mypartnr.replace(/,/g,";");
		mypartnr=mypartnr.replace(/ /g,"");
		partnra=mypartnr.split(";");

		var onEzbExplorerScenarioSuccess = function() {

		if(CJSONScenario.Response.status.code!=1 && PJSONScenario.Response.status.code!=1){
			elResults.innerHTML= "Errors:"+CJSONScenario.Response.status.message+" "+PJSONScenario.Response.status.message;
		}else{

		//update dialog form
			document.getElementById('CJSONScenario').value=JSON.stringify(CJSONScenario);
			document.getElementById('PJSONScenario').value=JSON.stringify(PJSONScenario);

			elResults.innerHTML= "------------>Products Loaded:.";

			ezbpartnr=mypartnr;
			EZB.Clean();
			EZB.Context.ForcedDisplayId="results_scenario";
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
					ezb(CJSONScenario,PJSONScenario,'results_scenario');
				}

				var last_el_id=el_id;

				YAHOO.util.Event.onAvailable(last_el_id, function(){ /* display around products when all are available */
					for(var i=0;i< partnra.length;i++){ /* loop again through all products */
						var el_id=['EZBox_ezb_',i,'_',partnra[i],'_',guistyle].join('');
						var pn=el_id.replace(/EZBox_ezb_[^_]*/g,"").replace(/_/,"").replace(/_.*/g,"");
						var e=document.getElementById(el_id);
						if(e){
							mem+=[pn," | "].join('');
							e.innerHTML="<span style='background:orange none repeat scroll 0%;height:10px;width:200px;'>"+pn+"</span><div width='101%;' id='"+el_id+"_container' style='width:101%;border:1px solid orange;'>"+e.innerHTML+"</div>";
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
				ezb(CJSONScenario,PJSONScenario,'results_scenario');
			}
			//before leaving switch modification button to on
			if(!window.PushButtonScenario){
				PushButtonScenario = new YAHOO.widget.Button({
    	                       		label:"Modify/Simulate Products Data/ Country Configuration",
        	                   		id:"pushbuttonscenario",
            	               		container:"getEzbModifyScenarioBtn"
	        	});
				PushButtonScenario.focus();
				PushButtonScenario.blur();
				Event.on("pushbuttonscenario", "click", function(e) {
						Event.preventDefault(e);
						EZB.EzbModifyScenario.dialog.show();
					}, this, true);
			}
		}
		};

		if(!cc || !lc || !ms || !client || !mypartnr){
			elResults.innerHTML = "<h3 style=\"font-weight:bold;\">Please select all input parameters "+results_memory+"</h3>";
			results_memory=results_memory+".";
		}else{
			elResults.innerHTML = "<h3 style=\"font-weight:bold;\">Retrieving EZB data for " +
				Dom.get("cc_ll_scenario").value + ":</h3>" +
				"<img src='http://l.yimg.com/us.yimg.com/i/nt/ic/ut/bsc/busybar_1.gif' " +
				"alt='Please wait...'>";
			CJSONScenario={};
			PJSONScenario={};
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
						"&format=json&callback=EZB.EzbExplorerScenario.callback_config"].join('');
			var sURL2 = [
						"../GetEzbData.php?browse=1&cc=", cc,
						"&lc=", lc,
						"&local_file=", "report/GetEzbScenario/Scenarios.xml",
						"&ms=", ms,
						"&partnr=", mypartnr,
						"&format=json&callback=EZB.EzbExplorerScenario.callback_data&clientId=", client,
						"&JSparam=PL|", pl
						].join('');
			var transactionObj = Get.script([sURL0,sURL1,sURL2], {
				onSuccess: onEzbExplorerScenarioSuccess,
				scope    : this
			});
		}
	};
	return {
		init: function() {
			Event.on("EzbExplorerScenario", "submit", function(e) {
				Event.preventDefault(e);
				getEzbExplorerScenario();
			}, this, true);
			var oButton = new Button("getEzbExplorerScenarioBtn");
			oButton.focus();
			oButton.blur();
		},
		callback_data: function(results) {
			PJSONScenario=(new EZB.Utils.JSONcopy(results));
		},
		callback_config: function(results) {
			var json_string=JSON.stringify(results);
			var new_json_string=(decodeURIComponent(json_string)).replace(/\+/g," ").replace(/@P@/g,"+").replace(/@Q@/g,"\\\"").replace(/@B@/g,"\\\\");
			CJSONScenario=(JSON.parse(new_json_string));
		}
	}
}();


EZB.EzbModifyScenario = function() {
	var Event = YAHOO.util.Event,
		Dom = YAHOO.util.Dom,
		Button = YAHOO.widget.Button,
		Get = YAHOO.util.Get;
		var dialog;

	//update dialog form
	if(document.getElementById('CJSONScenario'))
		document.getElementById('CJSONScenario').value=JSON.stringify(CJSONScenario);
	if(document.getElementById('PJSONScenario'))
		document.getElementById('PJSONScenario').value=JSON.stringify(PJSONScenario);

	var help=function(){
		var panel= new YAHOO.widget.Panel("panel", { width:"600px", fixedcenter : true, visible:true, draggable:true, close:true } );
		panel.setHeader("Valid product/reseller format example under 'list' node");
		var help_json_scenario={ "Response": { "version":"1.0", "status": { "code":"1", "message":"ok" }, "query": { "cc":"il", "lc":"he", "ms":"hho", "clientId":"hp.com", "format":"json", "partnr":"KG665EA", "callback":"EZB.EzbExplorerScenario.callback_data" }, "results": { "products": { "returned":"1", "rules":"kelkoo.hp.hp.com.json.il.he.hho.options_exclusion.price_indication.options_disable.options_hide", "list": { "KG665EA": { "l":"amd_A","pp":"4323", "pi":"4699", "pro":{"pf":"promotion flag","pt":"1","h":"promo header","te":"promo terms","ur":"urgency","pm":"promo info"},"r":[{"id":"3691423","mp2b":"1","pr":"110","st":"5","t":"hp","n":"en ligne chez HP","u":"http://www.hp.com","m":"BUY from us."},{"id":"6299523","mp2b":"1","pr":"106","st":"2","t":"ebus","n":"Bestprints.com","u":"http:\/\/www.hp.com","m":"this message"}] } } } } } };
		panel.setBody('<PRE>'+JSON.stringify(help_json_scenario.Response.results.products.list)+'</PRE>');
		panel.setFooter("End of Example");
		panel.render("help");
	};

	var getEzbModifyScenario = function() {
		//YAHOO.util.Dom.setStyle('getEzbModifyScenarioForm','display','inline');
		var dialog = new YAHOO.widget.Dialog("getEzbModifyScenarioForm", {
	           								context:["show", "tl", "bl"],
	           								fixedcenter : true,
	           								visible: false,
	           								buttons:[
	           											{text:"Select", isDefault:true, handler: onEzbModifyScenarioSuccess},
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


	var onEzbModifyScenarioSuccess = function() {
		try{
			CJSONScenario=JSON.parse(document.getElementById('CJSONScenario').value);
			PJSONScenario=JSON.parse(document.getElementById('PJSONScenario').value);
		}catch(e){
			alert('invalid format');
			return(false);
		}

	//	EZB.Context.ForcedDisplayId='results_scenario';
	//	var partnr=mypartnr;
	//	ezb(CJSON,PJSON,'results_scenario');
						var mem="";
			var el_id;

			if(style!="start"){/* not start from */
				for(var i=0;i< partnra.length;i++){/* display for all products */
					partnr=partnra[i];
					el_id=['EZBox_ezb_',i,'_',partnra[i],'_',guistyle].join('');
					if(document.getElementById(el_id+"_container")){
						ezb(CJSONScenario,PJSONScenario,el_id+"_container");
					}else{
						ezb(CJSONScenario,PJSONScenario,'results_scenario');
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
				ezb(CJSONScenario,PJSONScenario,'results_scenario');
			}
	};

	return {
		init: function() {
				return(getEzbModifyScenario());

		},
		dialog: getEzbModifyScenario()
	}
}();
//DO NOT REMOVE THE FOLLOWING LINE THAT IS A MARKER
//<!--END-->

YAHOO.util.Event.onDOMReady(
	EZB.EzbExplorerScenario.init,
	EZB.EzbExplorerScenario, 		//pass this object to init and...
	true);								//...run init in the passed object's
YAHOO.util.Event.onDOMReady(
	EZB.EzbModifyScenario.dialog,
	EZB.EzbModifyScenario, 		//pass this object to init and...
	true);								//...run init in the passed object's
</script>

<!--END SOURCE CODE FOR EXAMPLE =============================== -->
</body>
</html>
