// HP Common Metrics Architecture 20050829a 
// Added by ik : FOR LATIN AMERICA
// BEGIN Clickstream:
var s_hp_optOut = false // WARNING: IF SET TO TRUE, PAGE WILL NOT BE TRACKED

// Common Dynamic Account structure - please do not use unless authorized by CKM&A Ops
var s_dynamicAccountSelection=false
var s_dynamicAccountList=""
var s_dynamicAccountMatch=window.location.hostname

if (!(window.s_account)){
	var s_account="hphqglobal,hphqla,hphqlabr"
}

var s_prop7; if (!s_prop7){s_prop7="br";}
var s_prop8; if (!s_prop8){s_prop8="pt";}



var s_trackDownloadLinks=true
var s_trackExternalLinks=true
var s_trackInlineStats=true
var s_linkDownloadFileTypes="exe,zip,wav,mp3,mov,mpg,avi,doc,pdf,xls,cgi,dot,pot,ppt,wmv,asx"
var s_linkInternalFilters="hp,compaq,cpqcorp,javascript:"
var s_linkLeaveQueryString=true
var s_region="LA"

// Common metrics plugin function - do not remove
function s_hp_doMetricsPlugins() { 
} 

/*** DO NOT MODIFY THIS SECTION ***/
/* Under no circumstances should you modify this code */
s_hp_includeJavaScriptFile("welcome.hp-ww.com","/cma/region/la/lacma.js");
//s_hp_includeJavaScriptFile("welcome.hp-ww.com","/cma/metrics/sc/s_code_remote.js");
s_hp_includeJavaScriptFile("welcome.hp-ww.com","/cma/metrics/sc/s_code_remote.js");
function s_hp_includeJavaScriptFile(hp_hostname,hp_path) {
	if(!(window.s_hp_optOut && window.s_hp_optOut == true)) {
		var hp_ssl=(window.location.protocol.toLowerCase().indexOf('https')!=-1)
		if(hp_hostname && hp_hostname.length>0) {
			if(hp_ssl == true && hp_hostname.toLowerCase().indexOf("welcome.") != -1) { hp_hostname = "secure.hp-ww.com"; }
			var fullURL = "http" + (hp_ssl?"s":"") + "://" + hp_hostname + hp_path
		}
		else
			var fullURL=hp_path;
		document.write("<sc" + "ript language=\"JavaScript\" src=\""+fullURL+"\"></sc" + "ript>");
	}
}
// END Clickstream:
