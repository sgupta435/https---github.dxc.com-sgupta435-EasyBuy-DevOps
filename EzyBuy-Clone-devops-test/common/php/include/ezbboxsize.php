<?php

/*
 * +======================================================================================================+
 * | EZB box size
 * +======================================================================================================+
 * +------------------------------------------------------------------------------------------------------+
 * | Code Structure:
 * | --------------
 * | Define the ezb box size template through PHP function
 * | FIF = true -> eval PHP function
 * | FIF != true -> generate JS function
 * |
 * +------------------------------------------------------------------------------------------------------+
 * | Usage:
 * | ------
 * | ezbboxsize.php is included from countrysettings.php
 * | - when FIF=true is passed on to the query string, fulfill $boxWidth and $boxHeight variables
 * | - when FIF= is empty output JS functions to calculate ezbuy box sizes
 * |
 * +------------------------------------------------------------------------------------------------------+
 * | Glossary:
 * | ---------
 * +------------------------------------------------------------------------------------------------------+
 * | Internals:
 * | ----------
 * | 01/11/2007: increase template height by 20 pixels for channel, neutral and direct experiences
 * +------------------------------------------------------------------------------------------+
 * | Debug:
 * | --------
 * |
 * +------------------------------------------------------------------------------------------+
 * | Assumptions:
 * | ------------
 * |
 * +------------------------------------------------------------------------------------------+
 * | JS Context used:
 * | ---------------
 * | none
 * +------------------------------------------------------------------------------------------+
 * | JS Context defined:
 * | ------------------
 * | getGuiWidth,getEzbExpHeight,getGuiHeight
 * +------------------------------------------------------------------------------------------+
 * | exceptions:
 * | -----------
 * +==========================================================================================+
 *
 **/

// Variables that need to be defined are
// $guistyle : ezbuy interface : "small", "normal" or "large"
// $ezbExp : "direct", "neutral" or "channel"


function get_template_boxsize($par_guiwidth,$switch_guiwidth,$par_getezbexpheight,$switch_getezbexpheight,$par_guiheight,$switch_guiheight)
{

$template_code = '
function getGuiWidth ('.$par_guiwidth.') {
	switch ('.$switch_guiwidth.') {
		case "small":
			return "90";
			break;
		case "normal":
			return "185";
			break;
		case "large":
			return "270";
			break;
		default:
			return "185";
	}
}

function getEzbExpHeight ('.$par_getezbexpheight.') {
	switch('.$switch_getezbexpheight.') {
		case "channel":
			return "210";
		case "neutral":
			return "250";
		case "direct":
			return "190";
	}
}

function getGuiHeight ('.$par_guiheight.') {
	switch ('.$switch_guiheight.') {
		case "small":
			return "30";
		case "large":
			return getEzbExpHeight('.$par_getezbexpheight.');
		default:
			return getEzbExpHeight('.$par_getezbexpheight.');
	}
}
';
return $template_code;
}

if ($FIF == "true") {
	$PHP_ezbboxsize = get_template_boxsize ('$guistyle','$guistyle','$ezbExp','$ezbExp','$guistyle,$ezbExp','$guistyle');
	eval($PHP_ezbboxsize);
	$boxWidth = getGuiWidth($guistyle);
	$boxHeight = getGuiHeight ($guistyle,$ezbExp);
}
else {
	$JS_ezbboxsize = get_template_boxsize ("","guistyle","","ezbuyExperience","","guistyle");
}

?>