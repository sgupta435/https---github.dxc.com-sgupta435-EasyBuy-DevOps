<?php
require_once("../include/ezb_utils.ProcessParams.php.inc");
$_req_mandatory_var_names = array("");
$_req_optional_var_names = array("view","app");
$param_ok=UtilsProcessParams($_req_mandatory_var_names,$_req_optional_var_names,"ezbdebug");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>EZB Reporting Page</title>

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

.dbg-obj,.dbg-arr {
	border-width: 0px;
	margin: 0px;
}

.dbg-label,.dbg-value {
	padding: 3px;
	font-size: 12px;
	color: #333;
}

.dbg-label {
	font-weight: bold;
	background-color: #cba;
}

.dbg-obj td,.dbg-arr td {
	border-top: 1px solid #cba;
}

.dbg-value .dbg-toggle {
	display: list-item;
	margin-left: 15px;
	text-decoration: underline;
	cursor: pointer;
}

.dbg-value .dbg-toggle-open .dbg-toggle {
	list-style-image: url("minus.gif");
}

.dbg-value .dbg-toggle-closed .dbg-toggle {
	list-style-image: url("plus.gif");
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

<link rel="stylesheet" type="text/css"
	href="../../js/utils/yui/build/fonts/fonts-min.css?_yuiversion=2.4.1" />
<link rel="stylesheet" type="text/css"
	href="../../js/utils/yui/build/button/assets/skins/sam/button.css?_yuiversion=2.4.1" />
<link rel="stylesheet" type="text/css"
	href="../../js/utils/yui/build/tabview/assets/skins/sam/tabview.css?_yuiversion=2.4.1" />


<script type="text/javascript" src="../../js/utils/json/JsonTree.js"></script>

<script type="text/javascript" src="../../js/utils/yui/build/yahoo-dom-event/yahoo-dom-event.js?_yuiversion=2.4.1"></script>
<script type="text/javascript" src="../../js/utils/yui/build/element/element-beta-min.js?_yuiversion=2.4.1"></script>
<script type="text/javascript" src="../../js/utils/yui/build/button/button-min.js?_yuiversion=2.4.1"></script>
<script type="text/javascript" src="../../js/utils/yui/build/get/get-min.js?_yuiversion=2.4.1"></script>
<script type="text/javascript" src="../../js/utils/yui/build/utilities/utilities.js"></script>
<script type="text/javascript" src="../../js/utils/yui/build/container/container-min.js"></script>
<script type="text/javascript" src="../../js/utils/yui/build/tabview/tabview-min.js?_yuiversion=2.4.1"></script>

<script type="text/javascript" language="JavaScript" src="http://welcome.hp-ww.com/country/uk/en/js/hpweb_utilities.js"></script>


<script type="text/javascript" src="../../js/utils/json/JsonString.js?ss"></script>

<script language="javascript" src="GetEzbReport/reportTableFunctions.js" ></script>
<script language="javascript" src="GetEzbReport/sarissa.js" ></script>
<link href="GetEzbReport/reportStyle.css" rel="stylesheet" type="text/css" />


<style>
.yui-skin-sam .yui-navset .yui-content {
	background: white none repeat scroll 0%;
}
</style>
</head>

<body class=" yui-skin-sam">


<!--BEGIN SOURCE CODE FOR EXAMPLE =============================== -->
<script language="JavaScript" type="text/javascript">
if (!window.scLoaded) {
	document.write ('<'+'script language=\'JavaScript\' type=\'text/javascript\' src=\'../loadjs.php?country=uk&lang=en \'><'+'/script>');
}
</script>
<div id="container_all">
</div>

<script type="text/javascript">
    var tabView = new YAHOO.widget.TabView();
    tabView.addTab( new YAHOO.widget.Tab({
        //label: 'Browse/Simulate<br/>EZB Product(s) Templates',
        label: 'EZB Demo Tool<BR/>&nbsp;',
        dataSrc: 'GetEzbTemplateUI.php?#start',
        cacheData: true
    }));
    tabView.addTab( new YAHOO.widget.Tab({
        //label: 'Get EZB template<br/>HTML implementation code',
        label: 'Get EZB<BR/>Implementation Code',
        dataSrc: 'GetEzbCodeUI.php?',
        cacheData: true
    }));
    tabView.addTab( new YAHOO.widget.Tab({
        //label: 'Get EZB Prices<br/>Table',
        label: 'Get EZB Price<BR/>Indication Summary',
        dataSrc: 'GetEzbReportUI.php?',
        cacheData: true
    }));
    tabView.addTab( new YAHOO.widget.Tab({
        //label: 'Browse EZB<br/>Country Settings',
        label: 'Browse EZB Country<BR/>Business Rules (Ops)',
        dataSrc: 'GetEzbSettingsUI.php',
        cacheData: true,
        active: true
    }));
    tabView.addTab( new YAHOO.widget.Tab({
        //label: 'Browse EZB<br/>Country Configuration',
        label: 'Browse EZB Country<BR/>Translations (Ops)',
        dataSrc: 'GetEzbConfigUI.php',
        cacheData: true,
        active: true
    }));
    tabView.addTab( new YAHOO.widget.Tab({
        //label: 'Browse EZB<br/>Product(s) Prices Tree',
        label: 'Browse EZB Product(s)<BR/>Price Tree (Ops)',
        dataSrc: 'GetEzbDataUI.php',
        cacheData: true
    }));
    tabView.addTab( new YAHOO.widget.Tab({
        //label: 'View/Simulate<br/>EZB Scenarios',
        label: 'Get EZB Country<BR/>Scenarios (Ops)',
        dataSrc: 'GetEzbScenarioUI.php?',
        cacheData: true
    }));
    tabView.appendTo('container_all');


</script>


<script type="text/javascript">
/*
 * GetEzbSettingsUI *************************************************
 */
<?php
echo preg_replace("/.*\/\/<!--START-->(.*)\/\/<!--END-->.*/s","//<!--STARTR-->$1//<!--ENDR-->",file_get_contents("GetEzbSettingsUI.php"));
?>

/*
 * GetEzbConfigUI *************************************************
 */
<?php
echo preg_replace("/.*\/\/<!--START-->(.*)\/\/<!--END-->.*/s","//<!--STARTR-->$1//<!--ENDR-->",file_get_contents("GetEzbConfigUI.php"));
?>

/*
 * GetEzbDataUI ********************************************************
 */
<?php
echo preg_replace("/.*\/\/<!--START-->(.*)\/\/<!--END-->.*/s","//<!--STARTR-->$1//<!--ENDR-->",file_get_contents("GetEzbDataUI.php"));
?>

/*
 * GetEzbTemplateUI ***********************************************************
 */
<?php
echo preg_replace("/.*\/\/<!--START-->(.*)\/\/<!--END-->.*/s","//<!--STARTR-->$1//<!--ENDR-->",file_get_contents("GetEzbTemplateUI.php"));
?>


/*
 * GetEzbCodeUI **********************************************************
 */

<?php
echo preg_replace("/.*\/\/<!--START-->(.*)\/\/<!--END-->.*/s","//<!--STARTR-->$1//<!--ENDR-->",file_get_contents("GetEzbCodeUI.php"));
?>

/*
 * GetEzbReportUI ********************************************************************
 */

<?php
echo preg_replace("/.*\/\/<!--START-->(.*)\/\/<!--END-->.*/s","//<!--STARTR-->$1//<!--ENDR-->",file_get_contents("GetEzbReportUI.php"));
?>


/*
 * GetEzbScenarioUI ********************************************************************
 */
<?php
echo preg_replace("/.*\/\/<!--START-->(.*)\/\/<!--END-->.*/s","//<!--STARTR-->$1//<!--ENDR-->",file_get_contents("GetEzbScenarioUI.php"));
?>
/* the first initialization seems to be required to activate the first button!!! */
tabView.getTab(6).addListener('contentChange', function(){});
tabView.getTab(3).addListener('contentChange', EZB.EzbExplorerSettings.init);
tabView.getTab(4).addListener('contentChange', EZB.EzbExplorerConfig.init);
tabView.getTab(5).addListener('contentChange', EZB.EzbExplorerData.init);
tabView.getTab(0).addListener('contentChange', EZB.EzbExplorerTemplate.init);
tabView.getTab(0).addListener('contentChange', function(){EZB.EzbModifyTemplate.dialog=EZB.EzbModifyTemplate.init()});
tabView.getTab(1).addListener('contentChange', EZB.EzbExplorerCode.init);
tabView.getTab(2).addListener('contentChange', EZB.EzbExplorerReport.init);
tabView.getTab(6).addListener('contentChange', EZB.EzbExplorerScenario.init);
tabView.getTab(6).addListener('contentChange', function(){EZB.EzbModifyScenario.dialog=EZB.EzbModifyScenario.init()});

<?php
	if($view && $view!=""){
		echo "view=\"$view\".toLowerCase();";
	}
	if($app && $app!=""){
		echo "view=\"$app\".toLowerCase();";
		echo "app=\"$app\".toLowerCase();";
	}else{
		echo "app=false;";
	}
?>
	viewi=0;
	if(window.view){
		switch(view){
			case "settings": viewi=3;break;
			case "config": viewi=4;break;
			case "price": viewi=5;break;
			case "template": viewi=0;break;
			case "code": viewi=1;break;
			case "report": viewi=2;break;
			case "scenario": viewi=6;break;
			default:viewi=0;
		}
    }
    tabView.set('activeIndex', viewi); // make tab at index 0 active

if(window.app){
	t=tabView.get('tabs');
	s=t.length;
	for(i=0;i<s;i++){
		if(i<viewi)
			tabView.removeTab(t[0]);
		if(i>viewi)
			tabView.removeTab(t[1]);
	}
}
</script>

</body>
</html>
