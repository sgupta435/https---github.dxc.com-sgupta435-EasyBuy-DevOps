/**
 * @ezb_load.js
 * Provides minimum EZB class definition for load
 **/
 
EZB = window.EZB || {}; /* in case script included via HTML implementation code some parameters could have been defined before */
EZB.Log = EZB.Log || function(){}; /* defined as empty by default */

/*
 * server side default values
 */
EZB.req_protocol=EZB.req_protocol || "http:";
EZB.req_server=EZB.req_server || "h41213.www4.hp.com";

EZB.Paths={};
EZB.Paths.php="/ezbuy/common/php";

EZB.Paths.build=EZB.req_self.replace("loadjs.php","EzbProcess.php");

EZB.req_self=EZB.req_self || (EZB.Paths.php + "/" +"loadjs.php");


EZB.Utils=(function(){
 	/**
     * Get Query String parameters for given param & url [case insensitive]
     * @param paramName {String} the name of the query string parameter for which value is sought
     * @param optional url {String} in which query string is looked at. Default to top.location.href
     * @return {String} The paramName value if exists, null otherwise
     * @method getQueryStringParameter
     * @public
     * @static
     */
	function getQueryStringParameter( paramName, url ) {
		var i, len, idx, queryString, params, tokens;
		url = url || top.location.href;
		idx = url.indexOf( "?" );
		queryString = idx >= 0 ? url.substr( idx + 1 ) : url;
		params = queryString.split( "&" );
		for ( i = 0, len = params.length ; i < len ; i++ ) {
			tokens = params[i].split( "=" );
			if ( tokens.length >= 2 ) {
				if ( (tokens[0]).toLowerCase() === paramName.toLowerCase() ) {
					EZB.Log("INFO:EZB.Utils.getQueryStringParameter:",['found: ', unescape(tokens[1]), ' for ',paramName].join());
					return unescape( tokens[1] );
				}
			}
		}
		EZB.Log("INFO:EZB.Utils.getQueryStringParameter:",[paramName, ' not found in query'].join());
		return null;
	}
 	/**
     * Insert remote Javascript src in page
     * @param url {String} the url for the remote javascript to include
     * @return {}
     * @method insertRemoteScript
     * @public
     * @static
     */
	function insertRemoteScript(url) {
		EZB.Log("INFO:EZB.Utils.insertRemoteScript:",url);
		document.write(['<scr', 'ipt type="text/javascript" src="', url, '"></scr', 'ipt>'].join(''));
	}
    /** 
     * Inject remote Javascript src in page (DOM)
     * @param url {string} the url for remote javascript to inject
     * @param win {Window} optional window to create the element in
     * @return {}
     * @public
     * @static
     */
	function injectRemoteScript( url, win ) {
		var w = win || window, d=w.document, n=d.createElement("script"),
		h = d.getElementsByTagName("head")[0];
		if(h){
			n.src = url;
			n.type = "text/javascript";
			h.appendChild(n);
			EZB.Log("INFO:EZB.Utils.injectRemoteScript:",url);
		}	
	}
	return {
		getQueryStringParameter:getQueryStringParameter,
		insertRemoteScript:insertRemoteScript,
		injectRemoteScript:injectRemoteScript
	}
})();

/**
 * Insert/Inject remote build Javascript
 * Script is by default inserted. Injection happens only if EZB.ForcedDisplayId has been set
 * @param {} 
 * @return {}
 * @method EZB.Build
 * @public
 * @static
 */
EZB.Build=function(){
	/*
	 * This is for visual detection during tests. TO BE REMOVED
	 */
	if(window.EZB_load_redirected && EZB.Utils.getQueryStringParameter( "ezbserver")){
		var ezb_splash=[
			'<div id="ezb_splash_screen" style="position: absolute; top: 0px; left: 0px; background: pink; width: 50%; height: 10%; opacity: 1; filter: alpha(opacity=100); -moz-opacity: 1">',
			'This is testing EZB on server:', EZB.Context.ezbserver,
			'</div>'
			].join('');
		document.write(ezb_splash);
	}
	if(window.PL=="-1" || window.PL==""){
		if(window.page_generic_englishname && page_generic_englishname!=""){
			for (var Page in PLexceptions ) {
				if(page_generic_englishname.toLowerCase().indexOf(Page.toLowerCase())!=-1){
					EZB.Context.PL=PLexceptions[Page];
					EZB.Context.PLexception=true;
					PL=EZB.Context.PL;
					break;
				}
			}
		}	
	}
	var BuilderURL=[
					EZB.req_protocol, "//", window.EZB_load_redirected==true?EZB.Context.ezbserver:EZB.req_server,
					EZB.Paths.build,
					"?cc="+EZB.Context.cc,
					"&lc="+EZB.Context.lc,
					"&version="+EZB.Context.version,
					"&ms="+EZB.Context.m_s,
					"&clientID="+EZB.Context.clientID,
					EZB.Context.ezbdebug?"&ezbdebug=1":""
					].join('');
	if(!EZB.Context.ForcedDisplayId)
		EZB.Utils.insertRemoteScript(BuilderURL);// injecting causes an issue on IE as ezb. Potential fix is to add to onload
	else
		EZB.Utils.injectRemoteScript(BuilderURL);// injecting causes an issue on IE as ezb. Potential fix is to add to onload	
};

/*
 * client side default values
 */
EZB.Context={
	is_ie:false,
	RenderingHookUse:window.RenderingHookUse || false, /* Case when RenderingHook library is in Html page */ 
	ezbuyExperience: "channel", /* could be set later in page, therefore will be checked at first instance */
	ForcedDisplayId:window.force_ezb_call || false,  /* set in page when an Html element id is set to received ezb template */
	ezbEppId:window.ezbEppId,
	forced_channel:window.forced_channel && forced_channel==true, /* set by shopping basket potentialy to force experience */
	forced_partner:window.forced_partner && forced_partner==true, /* set by shopping basket potentialy to restrict to partner */
	ezbPartnerList:window.ezbPartnerList, /* set by shopping basket potentialy to restrict to partner */
	storeId:window.storeId, /* set by shopping basket potentialy */
	ezbpartnr:window.ezbpartnr, /* defined in Html implementation page. Should contained list of all products for which ezb() will be called. Performance improvement if defined */
	PL:window.s_ProductLine || '-1',
	cc:window.country || '',
	lc:window.lang || '',
	clientID: window.s_prop4 || "",
	m_s: window.ezb_segment || window.s_prop9 || (window.ezbEppId?"hho":"smb"),
	EppId: window.ezbEppID?ezbEppID:false,
	version: '999',
	defer_rendering: this.RenderingHookUse?true:false, /* could also be using window on load */
	ezbdebug: EZB.ezbdebug_cookie || EZB.Utils.getQueryStringParameter( "ezbdebug")!==null || window.ezbdebug || false,
	ezbserver: window.ezbserver || EZB.Utils.getQueryStringParameter( "ezbserver") || EZB.req_server,
	ezbdisable: EZB.Utils.getQueryStringParameter( "ezbdisable")!==null?true:false,
	ezbdisableoptions: EZB.Utils.getQueryStringParameter( "ezbdisableoptions")!==null?true:false,
	ezbuyPNList:window.ezbuyPNList||"", /*list of products in basket */
	siteId:window.siteId||"",
	storeUrl:window.storeUrl||"",
	catalogUrl:window.catalogUrl||"",
	refererUrl:window.top.location.toString(),
	theme:window.theme||"#EB5F01"
};
if(EZB.Context.m_s!="smb" && EZB.Context.m_s!="hho"){
	EZB.Context.m_s="smb";
}
if(EZB.Context.ezbdisableoptions){
	EZB.Context.clientID="Report";
}

EZB.Load=function(){
	if(!EZB.Context.ezbdisable){
		/*
		 * Ezbuy not disabled either via cookie or query string param ezbdisable
		 */
		PL=EZB.Context.PL;
		if(!window.EZB_load_redirected && (EZB.Context.ezbdebug || window.ezbserver || EZB.Utils.getQueryStringParameter( "ezbserver") || window.EZB_load_redirect)){
			/*
			 * Redirection required to load either from new server or with debug libraries
			 */
			var r=[
					EZB.req_protocol, "//", EZB.Context.ezbserver,
					EZB.req_entry_uri.replace("PL=-1","PL="+EZB.Context.PL),
					EZB.Context.ezbdebug?"&ezbdebug=1":"",
					"&ezb_redirect=1&version=",EZB.Context.version
					].join('');
			EZB.Log("INFO:global","redirection set to:"+r); /* EZB.Log not defined here but for code readibility... */
			EZB.Utils.insertRemoteScript(r); /* loadjs reinsertion */
		}else{
			/*
			 * Ready to build ezbuy
			 */
			EZB.Log("INFO:global","no redirection set"); /* EZB.Log not defined here but for code readibility... */
			EZB.Build();
		}
	}
};