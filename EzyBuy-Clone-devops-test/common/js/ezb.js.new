/**
 * @ezb.js
 * Provides all EZB class definition
 **/

/**
 * ezb() implementation code proxy/gateway to EZB3.0
 * @param myPjson {JSON} optional Product Json
 * @param el_id {String} optional HTML element id for display
 * @return {}
 * @method ezb()
 * @public
 * @static
 */
function ezb(myCjson,myPjson,el_id){
		EZB.Log("INFO","OLD ezb() call");
	if(ezb.arguments.length==0){/* this is normal Html implementation code ezb()*/
		if(EZB.Settings.options.indexOf("disableEZBuy")==-1){
			EZB.Instance.Process();
		}else{ /* this is for tests */
			EZB.Log("WARN:global","DisableEZBuy is set!!!");
			ezb=function(){};/* make sure next ones do no process */
		}
	}else{
		var this_instance=EZB.Instances.length;	
		EZB.Log("WARN:global","for ezb() with given Pjson");
		EZB.Context.ForcedDisplayId=el_id;
		EZB.Config.Initial=myCjson;
		EZB.Instance._Init();
		EZB.Instances[this_instance]={this_i:this_instance,products:window.partnr,style:window.guistyle,id:el_id,gid:el_id};
		EZB.Render.Trigger(myPjson,this_instance);
	}
}

EZB.Instances=[];/* each EZB implementation code call {this_i:0, id:EZB_0, products:C6656AE, style:small, pjson: Pjson} */
EZB.Requests=[];/* each data request {this_i:0, first_instance_i:3, products: C6656AE, n_instances:10, Callback: function} */
EZB.RequestMaxProd=30; /* limit triggering several Requests. When limit is reached several calls made to back-end. Configuration is a best strategy between performance and browser limitation as more than 500 products would cause the URL to be too long */

EZB.Settings=window.EZB.Settings || {}; /* this is all country settings information */

EZB.Loaded=window.EZB.Loaded || {};
EZB.Loaded.Defered=false; /* set when defered event will be fired */

EZB.Config={}; /* this is all config xml information */

EZB.Paths=window.EZB.Paths || {};
EZB.Paths.addBasket=EZB.Paths.php+"/"+"addbasket.php";
EZB.Paths.logoClick=EZB.Paths.php+"/"+"logo.php";
EZB.Paths.logoFolder="/ezbuy/html/img/logos/";


/**
 * Clean EZB in such a way it can be called again with a clean status.
 * @param {}
 * @return {}
 * @method EZB.Clean
 * @public
 * @static
 */
EZB.Clean= function(){
	EZB.Instances.length=0;
	EZB.Requests.length=0;
};

/**
 * Copy JSON object
 * @param {JSON} the json object to copy
 * @return {JSON} newly created JSON object
 * @method EZB.Utils.JSONcopy
 * @public
 * @static
 */
EZB.Utils.JSONcopy= function(json) {
	for(var p in json)
		this[p] = ((json[p] instanceof Object) && !(json[p] instanceof Array))? new EZB.Utils.JSONcopy(json[p]) : json[p];	
};

/**
 * Insert remote CSS src in page
 * @param url {String} the url for the remote CSS to include
 * @return {}
 * @method insertRemoteCSS
 * @public
 * @static
 */
EZB.Utils.insertRemoteCSS= function( url) {
	EZB.Log("INFO:EZB.Utils.InsertRemoteCSS:",url);
	document.write(['<link TYPE="text/css" REL="STYLESHEET" HREF="', url, '"></link>'].join(''));

};

/** 
 * Inject remote CSS src in page (DOM)
 * @param url {string} the url for remote CSS to inject
 * @param win {Window} optional window to create the element in
 * @return {}
 * @method injectRemoteCSS
 * @public
 * @static
 */
EZB.Utils.injectRemoteCSS= function( url, win) {
	
	var w = win || window, d=w.document, n=d.createElement("link"), h = d.getElementsByTagName("head")[0];
	if(h){
		n.id='ezbuy_css';
		n.rel='stylesheet';
		n.href=url;
		n.type='text/css';
		h.appendChild(n);
		EZB.Log("INFO:EZB.Utils.InjectRemoteCSS:",url);
	}

};

/** 
 * Insert remote iframe src in page. THIS IS CURRENTLY NOT USED
 * @param url {String} the url for remote iframe to insert
 * @param id {String} optional iframe id
 * @return {}
 * @method insertRemoteIframe
 * @public
 * @static
 */
EZB.Utils.insertRemoteIframe= function(url,id){ /* this is for tests so far only */
	!id?id="EZB_IFRAME":0;
	document.domain="hp.com";
	document.write([
				'<iframe id="',
				id,
				'" style="display:none;position:absolute;" ',
				'src="', url,
				'" frameborder="0" scrolling="no"></iframe>'
				].join(''));
	EZB.Log("INFO:EZB.Utils.InsertRemoteIframe:",id+" " +url);
};

/** 
 * Inject remote iframe src in page. THIS IS CURRENTLY NOT USED
 * @param url {String} the url for remote iframe to insert
 * @param id {String} optional iframe id
 * @return {}
 * @method insertRemoteIframe
 * @public
 * @static
 */
EZB.Utils.injectRemoteIframe= function(url,id){
	document.domain="hp.com";
	var w = window, d=w.document, n=d.createElement("iframe"), h = d.getElementsByTagName("head")[0];
	if(h){
		n.src = url;
		h.appendChild(n);
		EZB.Log("INFO:EZB.Utils.InsertRemoteIframe2:",id+" " +url);
	}	
};

/** 
 * Defer execution until some event fires
 * @param func {Function} the function to defer execution for
 * @return {}
 * @method EZB.Utils.Defer
 * @public
 * @static
 */
EZB.Utils.Defer= function(func){ /* used to defer until page rendering Hook or onload event */
	if(EZB.Context.RenderingHookUse){ /* case where this library is in Html implementation page */
		addRenderingHookEvent(false, func);
		EZB.Log("INFO:EZB.Utils.Defer:","To RenderingHook event");
	}else{ /* defer to page onload event */
		EZB.Utils.AddLoadEvent(func);
		EZB.Log("INFO:EZB.Utils.Defer:","To onload event");
	}
};
/** 
 * Defer execution of a function until onload event fires
 * @param func {Function} the function to defer execution for
 * @return {}
 * @method EZB.Utils.AddLoadEvent
 * @public
 * @static
 */
EZB.Utils.AddLoadEvent=function(func){
	var w=window, oldonload = w.onload;
	if (typeof w.onload != 'function') {
		w.onload = func;
	} else {
		w.onload = function() {
			oldonload();
			func();
		}
	}
};

/*
 * Prices definitions
 * 
 */
 EZB.Prices={
	/** 
	 * Return start from price by traversing all products and finding the lowest price indication
	 * @param Pjson_list {Array} the Array of JSON products for all products [Response.results.products.list]
	 * @param partnr {String} the products for which strat from price is required. [P1;P2;P3... or P1; or P1]
	 * @return {String} the price or {Boolean} false
	 * @method _StartFromGet
	 * @private
	 * @static
	 */
	_StartFromGet: function(Pjson_list,partnr){
		var sfp=0, sfpi=null, pn=partnr.split(';'), pn_length=pn.length;
		for (var i = 0; i < pn_length; i++){
			prod = pn[i];
			if (Pjson_list[prod]){
				if (Pjson_list[prod] && Pjson_list[prod].pi) {
					sfpi = parseFloat(Pjson_list[prod].pi);
				}
			}
			if(sfpi){
				if(sfp){
					if(sfpi<sfp)
						sfp=sfpi;
				}else{
					sfp=sfpi;
				}
			}
		}
		EZB.Log('INFO:EZB.Prices.StartFromGet',[sfp, 'is lowest price for', partnr].join(''));	
		return(sfp);
	},
	/** 
	 * Return start from price format
	 * @param Cjson {JSON} JSON Config to use []
	 * @param Pjson_list {JSON} the products JSON []
	 * @param pnlist {String} the products for which strat from price is required. [P1;P2;P3... or P1; or P1]
 	 * @param sinlge {Boolena} true for single product start from price
	 * @return {String} the price or {Boolean} false
	 * @method _StartFromFormat
	 * @public
	 * @static
	 */
	StartFromFormat: function(Cjson,Pjson,pnlist,single){
		var sfp = this._StartFromGet(Pjson.Response.results.products.list,pnlist);
		if(sfp){
			var sfpf = this._PriceFormat(Cjson,Pjson,pnlist,sfp,false,true,single) 
			//PSC formatting
			return([
				"<br><span class=\"bold\">",
				sfpf,
				"</span><br>"
				].join('')
				);
		}else{
			return(false);
		}		
	},
	/** 
	 * Return price format
	 * @param Cjson {JSON} JSON Config to use []
	 * @param Pjson_list {JSON} the products JSON []
	 * @param pnlist {String} the products for which strat from price is required. [P1;P2;P3... or P1; or P1]
 	 * @param price {String} price to format
 	 * @param VAT_TextDisplayFlag {Boolean} VAT or not
 	 * @param CurrencyDisplayFlag {Boolean} currency or not
 	 * @param startsingle {Boolean} start single or not
	 * @return {String} the price or {Boolean} false
	 * @method _PriceFormat
	 * @private
	 * @static
	 */
	_PriceFormat: function(Cjson,Pjson,pnlist,price,VAT_TextDisplayFlag,CurrencyDisplayFlag,startsingle){
		if(!price){
			return(false);
		}
		var pfr=null,abbrcharsr=null,currencyr=null,vatr=null,r="",prefix=null,
		config_standard=Cjson.Response.results.standard.config,
		pf = config_standard.priceformat,
		abbrchars = config_standard.abbrchars,
		currency = config_standard.currencychar,
		vat = config_standard.vat;

		if(startsingle)
			prefix = config_standard.startpricesingle;
		else
			prefix = config_standard.startpricemultiple;
	
		pf?pfr=pf+'#AB#':pfr=0;
		vat?vatr=vat:vatr="";
		prefix?prefixr=prefix.replace('#VAT#',vatr).replace('#PF#',pfr):prefixr=0;
		abbrchars?abbrcharsr=abbrchars:abbrcharsr="";
		currency?currencyr=currency:currencyr="";

		(startsingle==true||startsingle==false)?r=prefixr:r=pfr; //detect normal price or start from price
		if(CurrencyDisplayFlag)
			r?r=r.replace('#C#',currencyr):0;
		else
			r?r=r.replace('#C#',""):0;
		r?r=r.replace('#P#',this._digitGroupingDecSymbFormat(Cjson,price)):0;
		r?r=r.replace('#AB#',abbrcharsr):0;
		if(VAT_TextDisplayFlag)
			vatr?r+=' '+vatr:0;

		//
		// Available Direct ?
		//

		if(pnlist!=false){
			prefix = config_standard.startpricedirect;
		if(prefix){
			if(this._HasHPPrices(Pjson,pnlist)){
				r=r.replace(/#DIR#/,prefix);
			}
		}
	}
	r=r.replace(/#DIR#/,"");
	EZB.Log('INFO:EZB.Prices._PriceFormat',r);	
	return (r);
	},
	/** 
	 * Return digit price format
	 * @param Cjson {JSON} JSON Config to use []
 	 * @param price {String} price to format
	 * @return {String} the price or {Boolean} false
	 * @method _digitGroupingDecSymbFormat
	 * @private
	 * @static
	 */
	_digitGroupingDecSymbFormat: function(Cjson,price_input) {
		var price=price_input.toString(),
		config_standard=Cjson.Response.results.standard.config,
		dgs = config_standard.digitgroupingsymbol,
		ds = config_standard.decimalsymbol,
		r,
		priceWholeDecimalsArray = price.split("."),
		leftToDot = priceWholeDecimalsArray[0];
		
		ds=ds?ds:".";
		decimals = priceWholeDecimalsArray[1];

		if (decimals) {
			(decimals.length==1)?decimals+="0":"";
			var keepdecimals="", decimals_length=decimals.length;
			for (var k = 0; k < decimals_length; k++){
				if (decimals.substring(k,k+1) != "0") {
					keepdecimals=true;
					break;
				}
			}
			(!keepdecimals)?decimals="":"";
		}

		if (dgs) {		
			var j=0, priceRes="", leftToDot_length=leftToDot.length;
			for (var i = leftToDot_length; i > 0; i--){
				if (j==3) {
					priceRes = dgs + priceRes;
					j=1;
				} else {
					j++;
				}
				priceRes = leftToDot.substring(i-1,i) + priceRes;
			}
			decimalPart=decimals?ds+decimals:"";
			r= priceRes+decimalPart;
		} else {
			decimalPart=decimals?ds+decimals:"";
			r= price.replace(/\..*/,decimalPart);
		}
		return(r);
		EZB.Log('INFO:EZB.Prices._digitGroupingDecSymbFormat',r);
	},
	/** 
	 * Return single price format
	 * @param Cjson {JSON} JSON Config to use []
 	 * @param pr {String} price to format
	 * @return {String} the price or {Boolean} false
	 * @method SinglePriceFormat
	 * @public
	 * @static
	 */
	SinglePriceFormat: function(Cjson,pr){
		var pr_f="";
		if(pr){
			var conf=Cjson.Response.results.standard.config,
			priceformat=(conf["priceformat"]?conf["priceformat"]+'#AB#':"");
			pr_f=priceformat;
			pr_f?pr_f=pr_f.replace('#VAT#',conf["vat"]).replace('#PF#',priceformat):0;
			pr_f?pr_f=pr_f.replace('#C#',conf["currencychar"]):0;
			pr_f?pr_f=pr_f.replace('#P#',pr?this._digitGroupingDecSymbFormat(Cjson,pr):""):0;
			pr_f?pr_f=pr_f.replace('#AB#',(conf["abbrchars"] ? conf["abbrchars"] : "" )):0;
			pr_f?0:pr_f="";
		}
		EZB.Log('INFO:EZB.Prices.SinglePriceFormat',pr_f);	
		return(pr_f);
	},
	/** 
	 * Return true if HP among resellers selling the product(s)
	 * @param Pjson {JSON} the Pjson
 	 * @param pnlist {String} list of products
	 * @return {Boolean} true if HP in 
	 * @method _HasHPPrices
	 * @private
	 * @static
	 */
	_HasHPPrices: function(Pjson,pnlist){
		var partnrArr = pnlist.split(";"), resellerArray;
		for (var j=0; j<partnrArr.length; j++ ) {
			var partnr=partnrArr[j];
			if (Pjson.Response.results.products.list) { 
				if ( partnr in Pjson.Response.results.products.list) { 
					resellerArray =  Pjson.Response.results.products.list[partnr].r ;
					if (resellerArray) {
						for (var i=0; i<resellerArray.length;i ++) {
							if (resellerArray[i].t == "hp") {
								EZB.Log('INFO:EZB.Prices._HasHPPrices',"HP found");	
								return (true);
							}
						}
					}
				}
			}

		}
		EZB.Log('INFO:EZB.Prices._HasHPPrices',"HP not found");	
		return (false); 
	} 	
};

/*
 * Config definition
 */
/** 
 * Callback function for Config JSON
 * @param Cjson {JSON} the Config Cjson
 * @return {JSON} copy of Config JSON 
 * @method EZB.Config.CallBack
 * @public
 * @static
 */

EZB.Config.CallBack=function(Cjson){
	EZB.Log("INFO:CALLBACK:EZB.Config.Callback","Config returned:"+Cjson.Response.version+" "+Cjson.Response.status.code+" "+Cjson.Response.status.message);
	var json_string=JSONEZB.stringify(Cjson);
	new_json_string=(decodeURIComponent(json_string)).replace(/\+/g," ").replace(/@P@/g,"+").replace(/@Q@/g,"\\\"").replace(/@B@/g,"\\\\");
	return(JSONEZB.parse(new_json_string));
};
/** 
 * Applies dynamic conditions rules to the Products Feed. Traverses all conditions and evaluates until ones is OK
 * @param Pjson {JSON} the Products JSON
 * @param partnr {String} the product number
 * @return {JSON} New Config JSON to be used 
 * @method EZB.Config.ApplyFeedConditions
 * @public
 * @static
 */
EZB.Config.ApplyFeedConditions= function (Pjson, partnr) {
	var the_p = null,
	condArray =  this.Initial.Response.results.dynamic,
	the_p=Pjson.Response.results.products.list && Pjson.Response.results.products.list[partnr],
	pass=false;
	if(the_p && condArray){
		for (var a in condArray) {
			var condition_to_eval="";
			if (condArray[a].cond) {
				conditionArray = condArray[a].cond.split("=");
				var conditionLeft = conditionArray[0], conditionRight = conditionArray[1], res=false;
				condition_to_eval="(the_p." + conditionLeft + "==\"" + conditionRight + "\")?res=true:res=false";
				eval(condition_to_eval);
				if(res){
					pass=true;
					EZB.Log('INFO:EZB.Config._ApplyFeedConditions',"Dynamic evaluation OK:"+condition_to_eval);					
					return(this._replaceDynamic(condArray[a]));
				}	
			}
		}
	}
	if(!pass){
		EZB.Log('INFO:EZB.Config.ApplyFeedConditions',"No Dynamic evaluations");
		return(this.Initial);
	}				 		
};
/** 
 * Applies Context conditions rules. Traverses all conditions and evaluates until ones is OK
 * @param {}
 * @return {} MODIFIES the Config object directly 
 * @method EZB.Config.ApplyContextConditions
 * @public
 * @static
 */
EZB.Config.ApplyContextConditions=function(){
	var condArray =  this.Initial.Response.results.context, pass=false;
 	if(condArray){
	 	for (var a in condArray) {
	 		var condition_to_eval="";
			if (condArray[a].cond) {
				conditionArray = condArray[a].cond.split("=");
				var conditionLeft = conditionArray[0], conditionRight = conditionArray[1], res=false;
				condition_to_eval="(window." + conditionLeft + "==\"" + conditionRight + "\")?res=true:res=false";
				
				eval(condition_to_eval);
				if(res){
					pass=true;
					EZB.Log('INFO:EZB.Config.ApplyContextConditions',"Context evaluation OK:"+condition_to_eval);					
					this._replaceContext(condArray[a]);
				} 
			}
		}
	}	
	if(!pass)
		EZB.Log('INFO:EZB.Config.ApplyContextConditions',"No Context evaluations");			 		
};
/** 
 * Replace sections in the config JSON
 * @param node {JSON} node that neesd to be used as replacement
 * @return {} MODIFIES the Config object directly 
 * @method EZB.Config._replaceContext
 * @private
 * @static
 */
EZB.Config._replaceContext= function(node) {
	var dynamicnode = node.config, lCjson=this.Initial;

	//Start from the experience. Check if the corresponding section is available in the standard section. 
	//Proceed only if present in standard section.
	for (var funcName in dynamicnode ) {
			lCjson.Response.results.standard.config[funcName] = dynamicnode[funcName]; 
	}
};
/** 
 * Replace sections in the config JSON
 * @param node {JSON} node that neesd to be used as replacement
 * @return {JSON} modifed Cjson to use 
 * @method EZB.Config._replaceDynamic
 * @private
 * @static
 */
EZB.Config._replaceDynamic= function(node) {
	var dynamicnode = node.config, lCjson = new EZB.Utils.JSONcopy(this.Initial);
	//Start from the experience. Check if the corresponding section is available in the standard section. 
	//Proceed only if present in standard section.
	for (var experience in dynamicnode ) {
		if (experience in lCjson.Response.results.standard.config) {
			 //Explore the 'func' part
			 funcDetails = dynamicnode[experience];
			 for (var funcName in funcDetails ) {
				if (funcName in lCjson.Response.results.standard.config[experience]) {
					//This means the function is in standard section. Now proceed to replace the variables.
					for (var key in funcDetails[funcName] ) {
						if (key in lCjson.Response.results.standard.config[experience][funcName]) {
							lCjson.Response.results.standard.config[experience][funcName][key] = funcDetails[funcName][key];
						}
					}
				}
			 }
		} 
	}
	return(lCjson);
};


/*
 * Instances definition
 * Instance being defined as one call to ezb()
 */
EZB.Instance={ /* EZB instance display */
	/** 
	 * Set Instance details in global Instances[] Array and preapre the rendering.
	 * @param the_partnr {String} optional partnr for template parameter
	 * @param the_style {String} optional style for template parameter
	 * @return {JSON} EZB instance created  
	 * @method EZB.Instance.Set
	 * @private
	 * @static
	 */
	_Init: function(){
		if(!this.InitPass){/* do for first instance only (once in page) */
			var css_url=[
						EZB.req_protocol, "//", EZB.Context.ezbserver,
						EZB.Settings.css_file,
						"?version=", EZB.Context.version
						].join('');
			EZB.Utils.injectRemoteCSS(css_url);
			this.InitPass=true;
			EZB.Experience();
		}
	},
	_Set: function(the_partnr, the_style){/* define a new instance by its id, products,.... and registers it */
		var id=EZB.Instances.length;
		EZB.Instances[id]={
			this_i: id, //increment
			products :the_partnr ? EZB.Products.Prepare(the_partnr) : EZB.Products.Prepare(window.partnr), // Prepare the products
			style: the_style || window.guistyle,
			id: "EZB_"+id, // decision to use EZB_0 EZB_1 ....
			gid: window.force_ezb_call?force_ezb_call:false,
			clientID: window.s_prop4 || EZB.Context.clientID // tracking individual ezbuy s_prop4
		};
		EZB.Render.Prepare(id); /* prepare rendering by creating divs. Creates accesibility tags as well */
		EZB.Log('INFO:EZB.Instance._Set','EZB_'+id+': ['+EZB.Instances[id].style+']  ['+EZB.Instances[id].products+']');
		return(EZB.Instances[id]);
	},
	/** 
	 * Process Instance. Equivalent to ezb() call
	 * This either immedaitel launches all prices requests as required or accumulate the information to minimize the number of requests
	 * @param the_partnr {String} optional partnr for template parameter
	 * @param the_style {String} optional style for template parameter
	 * @return {} 
	 * @method EZB.Instance.Process
	 * @public
	 * @static
	 */
	Process:function(the_partnr,the_style){
		/* Make sure minimum context is defined. Specificaly for when outside Html container */
		if(EZB.Context.cc=="" && EZB.Context.lc==""){
			return;
		}
		this._Init();
		var this_details=this._Set(the_partnr,the_style); // sets instance details
		
		if(EZB.Context.defer_rendering && !EZB.Loaded.Defered){ /* if defer & defer event not fired */
			if(!this.ProcessPass){ /* register function only once */
				EZB.Log('INFO:EZB.Instance.Process','Defering overall EZB processing to the required event');
				EZB.Utils.Defer(/* the entire function will be triggered later on when required event is fired */
								/* After this point the function is executed when all instances[] details exist
								 * this is why it is possible to create several requests
								 */
					function(){
						var semi=";", ezbpartnr=EZB.Context.ezbpartnr;
						if(ezbpartnr && ezbpartnr.split(semi).length < EZB.RequestMaxProd){ /* All in One GO is possible */
							var req_n=EZB.Requests.length;
							EZB.Log('INFO:EZB.Instance.Process','Defer triggered, only one pricing request required');
							EZB.Request.Set(0,EZB.Products.Prepare(EZB.Context.ezbpartnr),EZB.Instances.length);
							EZB.Request.Run(EZB.Requests[req_n]);
						}else{/* one unique pricing request not possible, do several by detecting when to trigger requests*/
							EZB.Log('INFO:EZB.Instance.Process','Defer triggered, several pricing request required');
							var prodstring_in_loop="",limit=EZB.RequestMaxProd,
							n_instances=EZB.Instances.length,
							prods_in_loop=0, instances_in_loop=0, first_instance_in_loop=0;
							for(var j=0;j<n_instances;j++){/* loop through all instances to detect when enough products
															* have been accumulated to trigger a request
															*/
								instances_in_loop++; /* one more instance that will be rendered in this request */
								//†Fix for RequestMaxProd Issue 20081121 Start†
								var new_instance_prods_nb=0;
								if (EZB.Instances[j].products!=false) {
									var new_instance_prod_a=EZB.Instances[j].products.split(";"),
									new_instance_prods_nb=new_instance_prod_a.length;
								}
								for(var k=0;k<new_instance_prods_nb;k++){
									if(prodstring_in_loop.indexOf(new_instance_prod_a[k])==-1){
										prods_in_loop++;
										prodstring_in_loop+=((prods_in_loop>=2)?";":"")+new_instance_prod_a[k];										
									}
								}
								var request_ready_to_go=false;
								(j==(n_instances-1))?request_ready_to_go=true:0; /* last instance means the requests must go */
								var next_instance_length=0;
								if(j!=(n_instances-1)){
									if (EZB.Instances[j+1].products!=false){
										next_instance_length=EZB.Instances[j+1].products.split(semi).length
									}	
								}		
								request_ready_to_go= request_ready_to_go || (j!=(n_instances-1) && (prods_in_loop+next_instance_length)>limit); /* next instance products added to current products not under limit anymore -> go*/
								if(request_ready_to_go){ /* either last instance or enough products accumulated */
									var req_n=EZB.Requests.length;
									EZB.Request.Set(first_instance_in_loop,prodstring_in_loop,instances_in_loop);
									EZB.Request.Run(EZB.Requests[req_n]);
									prods_in_loop=0; /* set empty for next loop iteration */
									prodstring_in_loop=""; /* set empty for next loop iteration */
									instances_in_loop=0; /* set empty for next loop iteration */
									first_instance_in_loop=j+1; /* next request first instance */
								}
							}
						}
					}
				);
			}
			this.ProcessPass=true;
		}else{
			/* get data immediately and use callback to render immediately.
			 * This means as many requests as instances unless page is already loaded and ezbbartnr available
			 */
		//	if(!this.ProcessPass){
				var semi=";", ezbpartnr=EZB.Context.ezbpartnr;
				if(EZB.Loaded.Defered && ezbpartnr && ezbpartnr.indexOf(this_details.products)!=-1 && ezbpartnr.split(semi).length < EZB.RequestMaxProd){
					var req_n=EZB.Requests.length;
					EZB.Log('INFO:EZB.Instance.Process','Defer Not triggered, but only one pricing request required as page loaded');
					EZB.Request.Set(0,EZB.Products.Prepare(EZB.Context.ezbpartnr),ezbpartnr.split(semi).length);
					EZB.Request.Run(EZB.Requests[req_n]);
					this.ProcessPass=true;
				}else{
					EZB.Log('INFO:EZB.Instance.Process','Immediate EZB processing, no defering');
					var req_n=EZB.Requests.length;
					EZB.Request.Set(this_details.this_i,this_details.products,1);
					EZB.Request.Run(EZB.Requests[req_n]);
				}
		//	}		
		}
	}
};

/*
 * Request for prices
 */
EZB.Request={ /* Price Requests */
	/** 
	 * Prepare Price request taking context information into account
	 * Context influences by potentialy filtering, restricting, excluding 
	 * @param query {String} the query url to be updated
	 * @param partnr {String} the product(s) we want to make the request for
	 * @return {String} the ready to go query 
	 * @method EZB.Request._Prepare
	 * @private
	 * @static
	 */
	_Prepare: function(query,partnr){ /* prepare the request taking all context into account */
		var searchXml = query.replace(/#PN#/,partnr), /* replace partnr */
		settings=EZB.Settings;
		if(EZB.Context.ezbEppId){
				searchXml = searchXml.replace(/m_s=smb/,"m_s=hho");
				searchXml += "&type=hp";
				EZB.Log("INFO:EZB.Request._Prepare","Restricting type to hp for EppId");
		} else {
			if(EZB.Context.forced_channel){
				searchXml += "&type=ebus";
				EZB.Log("INFO:EZB.Request._Prepare","Restricting type to channel for forced_channel");
			}
			if(EZB.Context.forced_partner){
				if (EZB.Context.ezbPartnerList) {
					searchXml += "&m_r=" + ezbPartnerList;
					EZB.Log("INFO:EZB.Request._Prepare","Restricting to defined partners for forced_partner "+ezbPartnerList);
				}
			}else{ /* this is already done on server side */
				if(!(EZB.Context.PLexception && EZB.Context.PLexception==true)){
					if(settings.partnersExcludeIds){
						searchXml+="&m_e="+settings.partnersExcludeIds.replace(/,/g,";");
						EZB.Log("INFO:EZB.Request._Prepare","Excluding defined partners as per Settings "+settings.partnersExcludeIds.replace(/,/g,";"));
					}
					if(settings.partnersRestrictIds){
						searchXml=searchXml+"&m_r="+settings.partnersRestrictIds.replace(/,/g,";");
						EZB.Log("WARN:EZB.Request._Prepare",searchXml);
						EZB.Log("INFO:EZB.Request._Prepare","Restricting defined partners as per Settings "+settings.partnersRestrictIds.replace(/,/g,";"));
					}
				}	
			}
			//if (!EZB.Context.ezbpartnr) {
			//	if (((guistyle.indexOf("small")!=-1) || EZB.Context.ezbuyExperience =="direct") && !settings.showDirectTemplate) {
			//		searchXml += "&filter=price";
			//		EZB.Log("INFO:EZB.Request._Prepare","Filtering to price only");
			//	}
			//}
			if ((EZB.Context.ezbuyExperience =="direct") && !settings.showDirectTemplate) {
				searchXml += "&type=hp";
				EZB.Log("INFO:EZB.Request._Prepare","Filtering to hp type only as per direct experience");
			}
		}
		if(settings.priceDecimal){ /* this is already done on server side */
			searchXml += "&p_format=d";
			EZB.Log("INFO:EZB.Request._Prepare","Format set to decimal as per Settings");
		}
		searchXml += "&clientId="+EZB.Context.clientID;
		EZB.Log("INFO:EZB.Request._Prepare",searchXml);
		return searchXml;
	},
	/** 
	 * Build Price request
	 * @param req {EZB.Request} the Request
	 * @return {String} query or false 
	 * @method EZB.Request._Build
	 * @private
	 * @static
	 */
	_Build: function(Req){/* building the request that will be made to get prices */
		if(Req.products){
			var query=EZB.Urls.dataQueryURL;
			query=
				[
					query,
					"&callback=", "EZB.Requests[", Req.this_i, "].Callback",
					"&browse=1",
					"&version=",EZB.Context.version
				].join('');
			query=this._Prepare(query, Req.products);
			EZB.Log("INFO:EZB.Request._Build","For: "+Req.products+" with CallBack:EZB.Requests["+Req.this_i+"].Callback(Pjson)");
			return(query);
		}else{
			EZB.Log("INFO:EZB.Request._Build","not building request as empty products");
			return(false);
		}
	},
	/** 
	 * Run Price request
	 * @param req {EZB.Request} the Request
	 * @return {} 
	 * @method EZB.Request.Run
	 * @public
	 * @static
	 */
	Run: function(Req){
		EZB.Log("INFO:EZB.Request.Run","Launching prices request for: "+Req.products+" with CallBack:EZB.Requests["+Req.this_i+"].Callback(Pjson)");
		var url=this._Build(Req);
		if(url)
			EZB.Utils.injectRemoteScript(url);
	},
	/** 
	 * Set Price request details including callback function to be used when prices will return
	 * 
	 * @param first_instance_index {Number} the index of the first ezb instance that will be able to be rendered using this query
	 * @param partnr {String} the list of products for the request
	 * @param total_instances {Number} the number of ezb instances that will be able to be rendered using this query
	 * @return {} 
	 * @method EZB.Request.Set
	 * @public
	 * @static
	 */
	Set: function(first_instance_index,partnr,total_instances){
		var request_index=EZB.Requests.length;
		EZB.Log("INFO:EZB.Request.Set","details: "+request_index+" with first instance:"+first_instance_index+" product:"+partnr+" total instances:"+total_instances);
		EZB.Requests[request_index]={
			this_i: request_index,
			first_instance_i: first_instance_index,
			products:partnr,
			n_instances:total_instances,
			Callback:function(Pjson){
				EZB.Log("INFO:CALLBACK:EZB.Request.Set","Callback for request: "+request_index+" with first instance:"+first_instance_index+" product:"+partnr+" total instances:"+total_instances);
				EZB.Log("INFO:CALLBACK:EZB.Request.Set","Got: "+Pjson.Response.results.products.returned + "/" +(partnr.split(";")).length);
				for(var i=this.first_instance_i;i<(this.first_instance_i+EZB.Requests[this.this_i].n_instances);i++){
					EZB.Render.Trigger(Pjson,i);
				}
				// fix layout issues by invoking function
				vFixLayoutIssues();
			}
		}
	}
};

/*
 * Products definitions
 */
EZB.Products={
	/** 
	 * Prepare product list. 
	 * Removes #option, transform to upper case, ...
	 * Applies filtering: Products exclusion, epp,...
	 * @param partnr {String} the list of products to prepare
	 * @return {String} the cleaned products string or false
	 * @method EZB.Products.Prepare
	 * @public
	 * @static
	 */
	Prepare: function(partnr){ /* prepare the request by setting the right products */
		var settings=EZB.Settings,
		mypartnr = partnr.replace(/#[^;]*/g,""); /* remove options */
		mypartnr = mypartnr.toUpperCase();
		mypartnr=mypartnr.replace(/[^;]*PRE[^;]*/g,""); /* remove all products with "PRE" in name */
		mypartnr=mypartnr.replace(/;;/g,";");
		mypartnr=mypartnr.replace(/;$/g,"");
		mypartnr=mypartnr.replace(/^;/g,"");

		if(EZB.Context.ezbEppId){
			mypartnrArray = mypartnr.split(";");
			for (var i = 0; i < mypartnrArray.length; i++){
				mypartnr += ";" + mypartnrArray[i] + "_" + ezbEppId;
			}
		}

		//Remove partnr from start from price if it is excluded
		if (settings.disablePNs) {
			var disablePNsArray = settings.disablePNs.split(";");
			for (var i = 0; i < disablePNsArray.length; i++){
				mypartnr = eval('mypartnr.replace(/'+disablePNsArray[i]+'/g,"");');
				mypartnr = eval('mypartnr.replace(/;;/g,";");');
			}
		}
		if(mypartnr==";")
			mypartnr=false;
		EZB.Log("INFO:EZB.Products.Prepare:",mypartnr);
		return mypartnr;
	},
	/** 
	 * Set products details according to the returned details from price request 
	 * Note that this is only used for when ezb requires to show a single product details.
	 * In other cases (start from prices) there is no need to set the details as
	 * only start from price calcualtion is required
	 * This represents the gateway t othe template display that requires these details 
	 * @param Pjson {JSON} the JSON Products
	 * @param Instance {EZB.Instance} the EZB instance we set product details for
	 * @return {JSON} the product details added to the Instance (could be {} empty )
	 * @method EZB.Products.Set
	 * @public
	 * @static
	 */
	Set: function(Pjson, Instance){
		var myPnJson={},
		pn=Instance.products; /* this contains cleaned up products for this instance */
		if(Pjson.Response.results.products.list && Pjson.Response.results.products.list[pn]){
			var ResultPnJson=Pjson.Response.results.products.list[pn];
			
		 	myPnJson={
		 		pn:pn,
		 		id:ResultPnJson.id,
		 		ind_f:EZB.Prices.SinglePriceFormat(EZB.Config.Initial,ResultPnJson.pi),
		 		ind:ResultPnJson.pi,
		 		_ind:ResultPnJson._pi,
		 		has_hp:false,
		 		has_ebus:false,
		 		l:ResultPnJson.l,
		 		no_hp_price:ResultPnJson.nop?true:false
		 	}
		 	
		 	if(ResultPnJson.pro && ResultPnJson.pro.pf && ResultPnJson.pro.pf==5){
				myPnJson.sp=ResultPnJson.pp;
			}else{
				myPnJson.pro=ResultPnJson.pro;
				myPnJson.pp=ResultPnJson.pp;
				myPnJson.sp=ResultPnJson.sp;
			}
		 	var hp_i=-1;
		 	if(ResultPnJson.r){
		 		myPnJson_r_length=ResultPnJson.r.length;
				for (var i=0; i < myPnJson_r_length; i ++) {
					if(ResultPnJson.r[i].t=="hp"){
						myPnJson.has_hp=true;
						hp_i=i;
						break;
					}
				}
				if((hp_i==-1 && ResultPnJson.r[0]) || (hp_i==0 && ResultPnJson.r[1]) || (hp_i>0))
					myPnJson.has_ebus=true;

				myPnJson.res= new Array();
				var j=((myPnJson.has_hp && EZB.Context.ezbuyExperience=="channel")?1:0);
				for (var i=0; i < myPnJson_r_length; i ++) {
					/* build reseller into array only if he needs to be shown in EZB screen 2 */
					/* which means all lebus resellers and hp only if channel experience */
					if(EZB.Context.ezbuyExperience=="channel" || ResultPnJson.r[i].t=="ebus"){
						var l_j=((ResultPnJson.r[i].t=="hp")?0:j);
						myPnJson.res[l_j]={
							id: ResultPnJson.r[i].id,
							pr: ResultPnJson.r[i].pr,
							mp2b: ResultPnJson.r[i].mp2b,
							st: ResultPnJson.r[i].st,
							t: ResultPnJson.r[i].t,
							n: ResultPnJson.r[i].n,
							u: ResultPnJson.r[i].u,
							m: ResultPnJson.r[i].m
						};
						
						myPnJson.res[l_j].pr_f=EZB.Prices.SinglePriceFormat(EZB.Config.Initial,myPnJson.res[l_j].pr);
						if(ResultPnJson.r[i].t!="hp"){
							j++;
						}
					}
				}
			}
			myPnJson.sto=(myPnJson.has_hp)?ResultPnJson.pi:null;
			myPnJson.hp_mp2b=(myPnJson.has_hp)?1:0;
			myPnJson.hp_st=(myPnJson.has_hp)?ResultPnJson.r[hp_i].st:null;
			myPnJson.hp_id=(myPnJson.has_hp)?ResultPnJson.r[hp_i].id:null;
			myPnJson.hp_n=(myPnJson.has_hp)?ResultPnJson.r[hp_i].n:"";
			myPnJson.hp_m=(myPnJson.has_hp)?ResultPnJson.r[hp_i].m:"";
			(myPnJson.hp_m.toLowerCase().indexOf( "dummy" ) != - 1 )?myPnJson.hp_m="":0;
			myPnJson.hp_u=(myPnJson.has_hp)?ResultPnJson.r[hp_i].u:"";
			EZB.Log('INFO:EZB.Products.Set',"Setting "+pn);
			Instance.Pjson=myPnJson;
		 	return(myPnJson);
		}else{
			EZB.Log('WARN:EZB.Products.Set',"Empty Settings for "+pn);
		}
		Instance.Pjson={};
		return({});
	}	
};
/*
 * Rendering definitions
 */
EZB.Render={
	Patch: function(){
		if (window.parent != self){
			try{
					window.parent.document.getElementById("SupplyAccessoryInfo").height=window.parent.document.getElementById("SupplyAccessoryInfo").Document.body.scrollHeight;
			}catch(e){
				try{
					window.parent.document.getElementById("SupplyAccessoryInfo").height=window.parent.FFextraHeight+window.parent.document.getElementById("SupplyAccessoryInfo").contentDocument.body.offsetHeight;
				}catch(e){}
			};
		} 
	},
	/** 
	 * Prepare rendering by setting DIVS in the page for later insertion of EZB display
	 * Sets <SPAN id=EZB_i></SPAN> mainly but only if EZB.Context.ForcedDisplayId is not set as
	 * in that case tags are already set
	 * @param id {Number} instance id
	 * @return {} 
	 * @method EZB.Render.Prepare
	 * @public
	 * @static
	 */
	Prepare: function(id){
		if(!EZB.Instances[id].gid){
			document.write("<a name=\"ezb\""+id+"\"></a>"+"<a name=\"#ezb\""+id+"\"></a>"); /* accessibility */
			document.write('<span id="EZB_'+id+'" class="EZB_box"></span>'); /* position markup for later writing in it */
			document.write("<a href=\"#ezb"+eval(id+1)+"\"><img src=\"http://welcome.hp-ww.com/img/s.gif\" width=\"1\" height=\"1\" alt=\"Go to Next product\" border=\"0\"></a>"); /* accessibility */
		}
	},
	/** 
	 * Display Html within an element using DOM
	 * Uses either the instance id or the EZB.Context.ForcedDisplayId force id
	 * @param id {Number} instance id
	 * @param html {String} the html to insert
	 * @return {} 
	 * @method EZB.Render._Display
	 * @private
	 * @static
	 */
	_Display: function(id,html){
		var e;
		var gid=EZB.Instances[id].gid?EZB.Instances[id].gid:"EZB_"+id;

		e=document.getElementById(gid);
		EZB.Log('INFO:EZB.Render._Display',"Display in gid:"+gid);
		
		if(e && html){
			var newDiv = document.createElement('div');
			newDiv.innerHTML=html;
			e.appendChild(newDiv);
			EZB.Log('INFO:EZB.Render._Display','Instance '+id+' displayed');
		}else{
			EZB.Log('INFO:EZB.Render._Display','Could not render, empty html or no div');
		}	
		this.Patch();
	},
	/** 
	 * Callback trigger to render instance
	 * This is fired for every instance
	 * @param Pjson {JSON} the entire JSON products
	 * @param id {Number} the instance id
	 * @return {} 
	 * @method EZB.Render.Trigger
	 * @public
	 * @static
	 */
	Trigger: function(Pjson,id){ /* fired after request callback fired, one after the other for all instances */
		EZB.Log('INFO:EZB.Render.Trigger','Got Trigger for instance '+id);
		if(!this.Done){ /* first time: apply contextual conditions */
			EZB.Config.ApplyContextConditions();
			EZB.Log('INFO:EZB.Render.Trigger','Applying Context Processing once');
			this.Done=true;	
		}
		if(EZB.Instances[id] && EZB.Instances[id].products){//case cleaning left products OK
		// instance id may not be defined correctly if forcing ezbuy usage outise implementation code
			EZB.Log('INFO:EZB.Render.Trigger','EZB_'+id+': ['+EZB.Instances[id].style+']  ['+EZB.Instances[id].products+']');
			this._Select(Pjson,id); /* Select right display function */
		}else{
			if(!EZB.Instances[id])
				EZB.Instances[id]={};
			EZB.Log('WARN:EZB.Render.Trigger','Empty (cleaning) EZB_'+id+': ['+EZB.Instances[id].style+']  ['+EZB.Instances[id].products+']');
		}	
	},
	/** 
	 * Select the right tempalte to render
	 * @param Pjson {JSON} the entire JSON products
	 * @param id {Number} the instance id
	 * @return {} 
	 * @method EZB.Render._Select
	 * @private
	 * @static
	 */
	_Select: function(Pjson,id){
		var partnr=EZB.Instances[id].products, clientID=EZB.Context.clientID;
		if(partnr.indexOf(";")>0){ /* doublessly a start from price request */
			if(Pjson.Response.results.products.list){
				EZB.Log('INFO:EZB.Render._Select',"Rendering StartFrom multiple for instance "+id);
				this._StartFrom(Pjson,id,false/*multiple*/);
			}else{
				EZB.Log('WARN:EZB.Render._Select',"Not Rendering StartFrom multiple for instance "+id+" as empty list");
			}	
		}else if(EZB.Instances[id].style=="small" && (clientID=="psc" || clientID.indexOf("product catalog")!=-1) && partnr.indexOf(";")==-1){
			/* case of PSC, small tempalte and one single products-> start from price for single product */
			if(Pjson.Response.results.products.list){
				EZB.Log('INFO:EZB.Render._Select',"Rendering StartFrom single for instance "+id);
				this._StartFrom(Pjson,id,true/*single*/);
			}else{
				EZB.Log('WARN:EZB.Render._Select',"Not Rendering StartFrom single for instance "+id+" as empty list");
			}	
		}else{
			EZB.Log('INFO:EZB.Render._Select',"Rendering Normal for instance "+id);
			/*
			 * Display if no options or
			 * not nostatic disable and nodata
			 */
			if(EZB.Context.ezbdisableoptions==true || !(EZB.Settings.options.toLowerCase().indexOf("nostaticdisable")!=-1 && !(Pjson.Response.results.products.list && Pjson.Response.results.products.list[EZB.Instances[id].products]))){
				/*
				 * no static disable option is already processed in GetEzbdata. Therefore are this stage if there is no product data and the nostaticdisable option is set
				 * this means no display should take place unless we have the ezbdisableoptions set
				 */
				this._Normal(Pjson,id);
			}
			/* Omniture only required for non start from prices */
			EZB.Omniture.SetProducts(EZB.Instances[id]);	
		}	
	},
	/** 
	 * Display start from prices
	 * @param Pjson {JSON} the entire JSON products
	 * @param id {Number} the instance id
	 * @param single {Boolean} single product start from or multiple products start from
	 * @return {} 
	 * @method EZB.Render._StartFrom
	 * @private
	 * @static
	 */
	_StartFrom: function(Pjson,id,single){
		var pf=EZB.Prices.StartFromFormat(EZB.Config.Initial,Pjson,EZB.Instances[id].products,single);
		if(pf){
			EZB.Log('INFO:EZB.Render._StartFrom',pf);
			this._Display(id,pf);
		}else{
			EZB.Log('WARN:EZB.Render._StartFrom',"Start From Price empty (no price/no span id)");
		}	
	},
	/** 
	 * Display normal price template
	 * @param Pjson {JSON} the entire JSON products
	 * @param id {Number} the instance id
	 * @return {} 
	 * @method EZB.Render._Normal
	 * @private
	 * @static
	 */
	_Normal: function(Pjson,id){
		var myPjson={}, Cjson={};
		if(EZB.Context.EppId){ /* check old prices in case of EPP */
			myPjson=EzbPn(Pjson,EZB.Instances[id].products+'_BLIND' );
			if (myPjson && myPjson.ind_f) {
				myPjson.oldprice=myPjson.ind_f;
			}
		}
		myPjson=EZB.Products.Set(Pjson,EZB.Instances[id]); /* sets this instance JSON to the details returned in Pjson */
		Cjson=(EZB.Config.ApplyFeedConditions(Pjson,EZB.Instances[id].products)).Response.results.standard; /* dynamic conditions */
		var display=EZB.Templates.Normal(Cjson,id);
		this._Display(id,display);
		EZB.Log('INFO:EZB.Render._Normal:',"displaying...:"+display);
	}
};

EZB.Omniture={

	s_products:"",
	s_products_event:"event18",
	cpt_ezb_metrics:0,
	/** 
	 * Set Omniture s_products string
	 * @param products {String} the product to add
	 * @return {} . MODIFIES the global this.s_products. 
	 * @method EZB.Render._Normal
	 * @private
	 * @static
	 */
	SetProducts: function(Instance){	      
		function vMapCleansheetMetrics()
{
  // map metrics only once
  if(bMappedCleansheetMetrics != true)
  {
    try
	{
      // define "new" metrics variables (content is generated from the page metadata)
	  // access the hpmmd object, which is present in CS pages (http://www.hp.com)
	  s_prop2      = sGetMetaContents('metatag content', null); // meta name="page_content"
	  s_prop3      = sGetMetaContents('metatag description', null); // meta name="description"
	  s_prop7      = sGetMetaContents('hpmmd.page.country', hpmmd.page.country);
	  s_prop8      = sGetMetaContents('hpmmd.page.language', hpmmd.page.language);
	  s_prop9      = sGetMetaContents('hpmmd.page.segment', hpmmd.page.segment);
	  s_prop10	 = sGetMetaContents('metatag lifecycle', null); // meta name="lifecycle"
	  s_prop16     = sGetMetaContents('metatag bu', null); // meta name="bu" or meta name="business_unit"
	  s_pageName   = sGetMetaContents('hpmmd.page.name', hpmmd.page.name) + sGetMetaContents('hpmmd.page.sectiontaxonomy', hpmmd.page.sectiontaxonomy) + ': ' + s_prop3; // s_pageName = "site area/uk/en: description";
	  s_eVar1      = sGetMetaContents('hpmmd.page.country', hpmmd.page.country) + '/' + sGetMetaContents('hpmmd.page.language', hpmmd.page.language) + '/' + sGetMetaContents('hpmmd.page.segment', hpmmd.page.segment); 	
	  s_eVar10     = sGetMetaContents('hpmmd.user.usersegment', hpmmd.user.usersegment);
	  s_eVar11     = sGetMetaContents('hpmmd.user.hpguid', hpmmd.user.hpguid);
	  s_eVar13     = sGetMetaContents('hpmmd.promo.internal', hpmmd.promo.internal);
	  bMappedCleansheetMetrics = true;
	}
	catch(e)
	{
	
	}
  }
}

function sGetMetaContents(psType, psContent)
{
  sMetaDataValue = '';
  if(psContent != null)
  {
	sMetaDataValue = psContent;
  }
  else
  {
    //fallback for country
	if(psType == 'hpmmd.page.country') 
    {
	  // take country from hpmmd.page.sectiontaxonomy (de/de)
	  aValues = hpmmd.page.sectiontaxonomy.split('/');
	  sMetaDataValue = aValues[1];
	}
	// fallback for language
	if(psType == 'hpmmd.page.language') 
    {
	  // take language from hpmmd.page.sectiontaxonomy (de/de)
	  aValues = hpmmd.page.sectiontaxonomy.split('/');
	  sMetaDataValue = aValues[2];
	}
	
	// fallbacks for segment, content and description
	if(psType == 'hpmmd.page.segment' || psType == 'metatag content' || psType == 'metatag description' || psType == 'metatag lifecycle' || psType == 'metatag bu' ) 
    {
	  // take value from page meta tag ( meta name="segment" )
	  var m = document.getElementsByTagName('meta');
	  for(var i=0; i<m.length; i++)
	  {
	    if(psType == 'hpmmd.page.segment' && m[i].name.toLowerCase() == 'segment') // <meta name="segment" content="hho"/>
		{
		  sMetaDataValue = m[i].content;
		  break;
		}
		// take content from meta tag
		if(psType == 'metatag content' && m[i].name.toLowerCase() == 'page_content') // <meta name="page_content" content="products"/>
		{
		  sMetaDataValue = m[i].content;
		  break;
		}
		// take description from meta tag
		if(psType == 'metatag description' && m[i].name.toLowerCase() == 'description') // <meta name="Description" content="description"/>
		{
		  sMetaDataValue = m[i].content;
		  break;
		}
		// take description from meta tag
		if(psType == 'metatag lifecycle' && m[i].name.toLowerCase() == 'lifecycle') // <meta name="lifecycle" content="buy"/>
		{
		  sMetaDataValue = m[i].content;
		  break;
		}
		// take bu from meta tag
		if(psType == 'metatag bu' && (m[i].name.toLowerCase() == 'bu' || m[i].name.toLowerCase() == 'business_unit')) // <meta name="business_unit" content="ipg"/>
		{
		  sMetaDataValue = m[i].content;
		  break;
		}
	  }
	}
  }
  return sMetaDataValue;
}


		
		/*
		var ezbExp = EZB.Context.ezbuyExperience;
		if(this.cpt_ezb_metrics)
			this.s_products+=",";
		this.cpt_ezb_metrics++;
		this.s_products= this.s_products + ";" + Instance.products + ";0;0;" + this.s_products_event + "=1";
		if(!Instance.Pjson || !Instance.Pjson.has_hp && (!Instance.Pjson.pn || Instance.Pjson.no_hp_price)){
			this.s_products= this.s_products + "|" + "event40=1";
		}
		if(!Instance.Pjson || Instance.no_price_indication_display){
			this.s_products= this.s_products + "|" + "event41=1";
		}
		// adding 'clickable ezbuy event'
		if(Instance.Pjson && (Instance.Pjson.has_hp || (Instance.Pjson.has_ebus && ezbExp!="direct"))){
			this.s_products= this.s_products + "|" + "event46=1";
		}
		EZB.Log('INFO:EZB.Omniture.SetProducts',"updated to:"+this.s_products);

		*/

	}




};

EZB.Templates={};
EZB.Templates.Utils={
	_IsConfigItemDefined: function(val1,val2){
		if(val1){
			if(val1[val2])
				return(val1[val2]);
		}
		return("");
	},
	/** 
	 * Build the HTML form id that will be used for an instance
	 * @param InstanceId {Number} the instance id
	 * @return {String} the form id string
	 * @method EZB.Templates.Utils._FormId
	 * @private
	 * @static
	 */
	_FormId: function (InstanceId){
			return([
				"ezb_",
				InstanceId,
				"_",
				EZB.Instances[InstanceId].products.replace(/-/g,"_"),
				"_",
				EZB.Instances[InstanceId].style
				].join(""));
	},
	/** 
	 * Build the delivery message based on stock level
	 * @param myCjson {JSON} the config Json
	 * @param InstanceId {Number} the instance Id
	 * @return {String} the delivery message
	 * @method EZB.Templates.Utils._DeliveryMessage
	 * @private
	 * @static
	 */
	_DeliveryMessage: function(myCjson,instanceId){ /* stock availability message */
		var myPjson=EZB.Instances[instanceId].Pjson;
		if(EZB.Settings.showDirectTemplate && myPjson.has_ebus) // showDirect template
			return(this._IsConfigItemDefined(myCjson["addbasket"],"txt_0"));
		if(!myPjson.hp_st)
			return("");
		if(myPjson.hp_st==2)
			return(this._IsConfigItemDefined(myCjson["addbasket"],"txt_0"));
		if(myPjson.hp_st==0)
			return(this._IsConfigItemDefined(myCjson["addbasket"],"txt_0")); //WSA
		if(myPjson.hp_st==5)
			return(this._IsConfigItemDefined(myCjson["addbasket"],"txt_1"));
		if(myPjson.hp_st==6)
			return(this._IsConfigItemDefined(myCjson["addbasket"],"txt_2"));
	},
	_CustomizeFormAction: function(){
		return("");
	},
	/** 
	 * Build what gets executed when click on buy partner on normal template
	 * this is executed real time to get the form details (product, selected partner,...)
	 * @param formId {String} the form id
	 * @param selected_partner_index {Number} the index of the selected partner on the screen
	 * @return {} redirection
	 * @method EZB.Templates.Utils._BuyPartnerFormAction
	 * @private
	 * @static
	 */
	_BuyPartnerFormAction: function(formId, selected_partner_index){
		var id_s=selected_partner_index,
		instanceId=formId.replace(/.*ezb_/g,"").replace(/_.*/g,""), /* get the instance back from the form */
		myPjson=EZB.Instances[instanceId].Pjson, /* get the instance Json */
		myPn=EZB.Instances[instanceId].products, /* get the product number from the Json */
		res=myPjson.res, /* get resellers */
		pr=(res[id_s].pr)?res[id_s].pr:(myPjson._ind?myPjson._ind:0), /* get reseller price or deafult to indication price*/
		goXmlQuerySep,
		action="buy";
		
		(EZB.Settings.goXmlQuery.indexOf("?")==-1)?goXmlQuerySep="?":goXmlQuerySep="&";
		var redirect=[
			"http://"+EZB.Settings.kelkooserver, "/", EZB.Settings.goXmlQuery, goXmlQuerySep,
			"m=", res[id_s].id,
			"&pn=", myPn, "|1",
			"&url=", res[id_s].u,
			"&availability=", res[id_s].st,
			"&price=", res[id_s].pr,
			"&pkey=", id_s].join(""),
		js_action=[
			"javascript:",
			(myPjson.pt?"EZBACTION='"+action+"';":""),
			"redirectURL='", redirect,
			"';",
			"ezb_AddBasket('",
				res[id_s].id, "','",
				res[id_s].t, "','','",
				myPn, "|1',", pr,
				",'", res[id_s].n, "'",
				",'", EZB.Instances[instanceId].clientID, "'",
			");"].join("");
		eval(js_action);
	},
	/** 
	 * Build what gets executed when click on add basket on normal template
	 * This is executed at template creation to return the action
	 * @param instanceId {Number} the instance id
	 * @return {String} the action in a string
	 * @method EZB.Templates.Utils._AddBasketFormAction
	 * @private
	 * @static
	 */
	_AddBasketFormAction: function(instanceId){ /* action on add basket button */
		var myPn=EZB.Instances[instanceId].products, /* which product ? */
		myPjson=EZB.Instances[instanceId].Pjson, /* which json */
		url="",
		ezb_id=this._FormId(instanceId);
		
		if(myPjson.has_hp){ /* direct experience */
			var pr=(myPjson.sto)?myPjson.sto:(myPjson._ind?myPjson._ind:0);
			url="javascript:redirectURL=#add_url#;ezb_AddBasket('#id#','hp','','#partnr#|'+eval('#qty#'),'#price#','#pname#','#clientID#');";
			var qty_value=[
				"document.forms.EZBox_",
				ezb_id,
				"_basketForm",
				".",
				"EZBox_",
				ezb_id,
				"_ezb_qty.value"].join(""),
			add_url="'http://#ezbserver##addBasketUrl#&m=#id#&pn=#partnr#|'+eval(\'#qty#\')+'&m_s=#m_s#&url=&country=#country#&lang=#lang#&availability=#stock#&price='+eval(\'#qty#\')*#price#+'&pkey=1'";
			url=url.replace(/#add_url#/g,add_url);
			url=url.replace(/#ezbserver#/g,EZB.Context.ezbserver);
			url=url.replace(/#addBasketUrl#/g,EZB.Urls.AddBasket);
			url=url.replace(/#partnr#/g,myPn);
			url=url.replace(/#qty#/g,qty_value);
			url=url.replace(/#m_s#/g,EZB.Context.m_s);
			url=url.replace(/#country#/g,EZB.Context.cc);
			url=url.replace(/#lang#/g,EZB.Context.lc);
			url=url.replace(/#stock#/g,myPjson.hp_st);
			url=url.replace(/#id#/g,myPjson.hp_id);
			url=url.replace(/#partnr#/g,myPn);
			url=url.replace(/#price#/g,pr);
			url=url.replace(/#pname#/g,myPjson.hp_n);
			url=url.replace(/#clientID#/g,EZB.Instances[instanceId].clientID);
		}else{
			if(EZB.Settings.showDirectTemplate && myPjson.has_ebus){ /* showDirect template */
				var res=myPjson.res;
				var pr=(res[0].pr)?res[0].pr:(myPjson._ind?myPjson._ind:0);
				(EZB.Settings.goXmlQuery.indexOf("?")==-1)?goXmlQuerySep="?":goXmlQuerySep="&";
				var r=[
					"http://", EZB.Settings.kelkooserver, "/", EZB.Settings.goXmlQuery,	goXmlQuerySep,
					"m=", res[0].id,
					"&pn=",	myPn,	"|1",
					"&url=", escape(res[0].u),
					"&availability=", res[0].st,
					"&price=", pr,
					"&pkey=1"].join("");
				url=[
					"javascript:redirectURL='", r,
					"';",
					"ezb_AddBasket('",
						res[0].id,
						"','ebus','','",
						myPn, "|1',",
						pr,
						",'",
						res[0].n,
						"'",
						",'", EZB.Instances[instanceId].clientID, "'",
					");"].join("");
			}
		}
		return(url);
	}
};

/** 
 * Build the html string representing the normal template
 * This is executed at template creation to return the string
 * @param Cjson {JSON} the config json
 * @param id {Number} the instance id
 * @return {String} the html template
 * @method EZB.Templates.Normal
 * @public
 * @static
 */
EZB.Templates.Normal=function(Cjson,id){
	var ezoptions=EZB.Settings.options || "",
	ezb_logos=EZB.Logos.json || {},
	showDirectTemplate=EZB.Settings.showDirectTemplate,
	elocatorURL=EZB.Urls.elocatorURL,
	ezbserver=EZB.Context.ezbserver,
	partnr=EZB.Instances[id].products,
	myPjson=EZB.Instances[id].Pjson,
	country=EZB.Context.cc,
	lang=EZB.Context.lc,
	ezbExp = EZB.Context.ezbuyExperience,
	ezb_id=EZB.Templates.Utils._FormId(id),
	ezb_conf=Cjson.config,
	ezb_conf_exp=ezb_conf[ezbExp],
	Html="",
	res,
	ezbEppId=EZB.Context.EppId,
	ezbuyPNList=EZB.Context.ezbuyPNList,
	_IsConfigItemDefined=EZB.Templates.Utils._IsConfigItemDefined,
	guistyle=EZB.Instances[id].style;
	
	EZB.Instances[id].no_price_indication_display=false;
	if(!myPjson.ind_f){
		EZB.Instances[id].no_price_indication_display=true;
	}
	
	/* Nostatic Disable or disable ezbuy*/
	if(ezoptions.indexOf('disableEZBuy')!=-1 || EZB.Instances[id].Pjson.id=="del"){
		EZB.Instances[id].no_price_indication_display=true;
		return("");
	}

	/*
	 * only if no price and nopricedisable_html option false
	 */
	if(!(ezoptions.indexOf('NoPricedisable_HTML')!=-1 && !((myPjson.ind_f || myPjson.has_ebus)))){
		/* Product added to basket ? */
		if(ezbExp=="direct" && ezbuyPNList && ezbuyPNList.indexOf(partnr)!=-1 && guistyle.indexOf('small')==-1){
			var label=ezb_conf_exp["basketadded"].label,
			text=ezb_conf_exp["basketadded"].txt_0;
			Html+='<div style="width: 180px;padding-bottom:7px;"><strong>'+text+'</strong></div><div><a class="secButtonEnhanced_ezb" href="javascript:window.top.location=\''+((checkoutUrl.indexOf('?')==-1)?(checkoutUrl+'?s='+siteId+'&p='+storeId):(checkoutUrl))+'\'">'+label+'</a></div>';
			return(Html);
		}
		/* Small interface ? */
		if(guistyle.indexOf('small')!=-1){
			if(myPjson.ind_f){
				var vat=Cjson.config.vat?Cjson.config.vat:"";
				Html+='<div id="EZBox_' + ezb_id +'" class="ezb"><div class="ezb-pricing"><div class="ezb-price">'+myPjson.ind_f+'</div><div class="ezb-vat">'+vat+'</div></div></div>';
			}	
			return(Html);
		}
		
		 // all partners needed for display in non-hp specific place, HP being already set anyway (myPjson.hp_id,...)
		if(myPjson.has_hp||myPjson.has_ebus){
			res=myPjson.res;
		}
		
		/* Ezbuy instance */
		var e = new EZBuy(false,ezb_id), _limited=false;
		if((myPjson.has_hp && ezbExp=="channel")||myPjson.has_ebus){
			for(var i=0,len=res.length; i<len; i++){
				var name=res[i].n;
				//if(((res[i].pr_f).length+(res[i].m?1:0)+(res[i].st<2?1:0))>=11){ //adjust reseller name based on price length + stock/message info
					//name=res[i].n.substring(0,10);
				//}
				e.addDealer(name, res[i].pr_f, res[i].m?res[i].m.replace("'","\\'"):"", decodeURIComponent(res[i].u), res[i].st<2?true:false,res[i].t);
				if(res[i].st<2)
					_limited=true;
			}
		}
		var _promo = false;
		if(myPjson.pro && myPjson.pro.pf==4) {
 	 		_promo = false;
		} else if(ezbEppId && myPjson.oldprice) {
			_promo = true;
		} else if(guistyle.indexOf('simple')!=-1) { // && !showDirectTemplate && myEzbPn.has_hp
			_promo = 'simple';
		} else if(myPjson.pp && ezoptions.indexOf("promoPriceHighlight")!=-1) {
 			_promo = true;
		}
		var _force_promo = false;
		if(ezoptions.indexOf("promoPriceForce")!=-1 && myPjson.has_hp && ezbExp != "channel")
			_force_promo = true;
			
		/* Set exceptions */
		var ExceptionsSettings={
			promo: _promo || _force_promo,
			force_promo: _force_promo,
			ezframeRTL: (ezoptions.indexOf("rightToLeftText")!=-1)?true:false
		};
		for (var name in ExceptionsSettings){
			e[name]=ExceptionsSettings[name];
		}
		/* Sets elements */
		var ElementsSettings={
			logo : (myPjson.l && ezb_logos[myPjson.l] && (ezoptions.indexOf("showIntelLogo")!=-1 || (ezoptions.indexOf("showAMDLogo")!=-1) && myPjson.l.indexOf("amd")!=-1))?true:false, // logo ?
			price_has: myPjson.ind_f?true:false, // pricing information ?
			priceLasts : (!ezbEppId && myPjson.pro && myPjson.pro.ur)?true:false,	// Price lasts header on/off in promotional area
			strikeThrough : (ezbEppId && myPjson.oldprice)?true:((!ezbEppId && myPjson.pro && myPjson.pro.pf==1)?true:false),	// Strike through above header for old price in promotional area
			footer : (country!="jp" && (ezbExp!="direct" || showDirectTemplate))?true:false, // footer (buy partner, find local, ...)?
			buyFromPartner : ((myPjson.has_ebus && ezbExp!="direct") || (myPjson.has_hp && ezbExp=="channel"))?true:false, // buy partner button ?
			shopping : (!(country=="jp" && (myPjson.pp || myPjson.sp)) && ((myPjson.has_hp && ezbExp!="channel")||(showDirectTemplate && myPjson.has_ebus)))?true:false, // direct shopping area ?
			qty: showDirectTemplate?false:true, // quantity input in shopping area ?
			store_available: (country!="jp" && ((myPjson.has_hp && ezbExp!="channel" )|| ezbExp!="channel"))?true:false,
			customiseLink: false, // customise link in shopping area ?
			basket: true, // basket in shopping area ?
			customisePartner : false, //(myPjson.pt==CONFIG || myPjson.pt==BUY_CONFIG)?true:false,	// Display / hide customise partner in partner screen 2
			buyPartner : (myPjson.has_ebus || (myPjson.has_hp && ezbExp!="direct"))?true:false,	// Display / hide customise partner in partner screen 2
			localPartner : (ezoptions.indexOf("disableElocator_HTML")!=-1)?false:true,	// Display / hide local partner
			limitedStock: _limited,
			prff: (window.v_f_prod && window.v_f_price && window.v_f_priceless && v_f_prod[partnr])?true:false
		};
		for (var name in ElementsSettings){
			e.elements[name]=ElementsSettings[name];
		}
		/* Set Actions */
			
		var ActionsSettings={
			formTarget : ((myPjson.has_hp && ezbExp!="channel") || (showDirectTemplate && myPjson.has_ebus))?EZB.Templates.Utils._AddBasketFormAction(id):"", //add basket action
			localPartner : "javascript:which_screen='"+((myPjson.has_ebus || (myPjson.has_hp && ezbExp=="channel"))?"2":"1")+"';redirectURL='"+decodeURIComponent(elocatorURL)+"';ezb_FindPartner('"+EZB.Instances[id].products+"','"+(myPjson._ind?myPjson._ind:"0")+"','"+(EZB.Instances[id].clientID)+"');", // find partner action	
			buyPartner : (myPjson.pt && myPjson.pt==2)?"EZB.Templates.Utils._CustomizeFormAction":"EZB.Templates.Utils._BuyPartnerFormAction", // buy partner action
			customiseLink : "", // customise link action
			customiseButton :"", // customise HP action
			customisePartner :"EZB.Templates.Utils._CustomizeFormAction", // customise Partner action
			BuyPartnerClick :"ezb_BuyPartner('"+myPjson.pn+"','"+myPjson._ind+"','"+EZB.Instances[id].clientID+"')" // BuyPartnerClick
		};
		
		if(showDirectTemplate && !myPjson.has_ebus)
			ActionsSettings.formTarget=ActionsSettings.localPartner;
		
		for (var name in ActionsSettings){
			e.actions[name]=ActionsSettings[name];
		}
		/* Set Text */
		var TextSettings={
			price : !(myPjson.pro && myPjson.pro.pf==4 && myPjson.pro.te)?myPjson.ind_f:myPjson.pro.te,
			pricevat : !(myPjson.pro && myPjson.pro.pf==4)?_IsConfigItemDefined(ezb_conf,"vat"):"",
			intro: e.force_promo?ezb_conf.force_promo:(country=="jp" && (myPjson.pp || myPjson.sp))?ezb_conf.promo2:((country=="jp" && myPjson.has_ebus)?ezb_conf.promo:(e.promo?((myPjson.pro && myPjson.pro.h)?myPjson.pro.h.replace(/'/g,"\\'"):(ezb_conf.promo?ezb_conf.promo:(ezb_conf.intro?ezb_conf.intro:""))):(ezb_conf.intro?ezb_conf.intro:""))),
			addToBasket : _IsConfigItemDefined(ezb_conf_exp["addbasket"],"label"),
			buyOnlineFromPartner : (guistyle.indexOf('simple')!=-1)?"":((ezbExp!="channel" || myPjson.has_hp)?_IsConfigItemDefined(ezb_conf_exp["viewshops"],"txt_0"):_IsConfigItemDefined(ezb_conf_exp["viewshops"],"txt_1")),
			buyFromPartner : _IsConfigItemDefined(ezb_conf_exp["viewshops"],"label"),
			selectAShop : ezb_conf.lbintro?ezb_conf.lbintro:"",
			limitedStock : ezb_conf.stock?'* '+ezb_conf.stock:"",
			buyNow : _IsConfigItemDefined(ezb_conf_exp["buy"],"label"),
			noShopping : ezb_conf.telnr?_IsConfigItemDefined(ezb_conf,'telnr'):"",
			customiseLink : _IsConfigItemDefined(ezb_conf_exp["addbasket"],"link"),
			customiseButton : _IsConfigItemDefined(ezb_conf_exp["customize"],"txt_0"),
			customise : _IsConfigItemDefined(ezb_conf_exp["customize"],"label"),
			customisePartner : "config",	// Display / hide customise partner
			localPartner : _IsConfigItemDefined(ezb_conf_exp["findreseller"],"txt_0"),
			localPartnerButton : _IsConfigItemDefined(ezb_conf_exp["findreseller"],"label"),
			thankYou : ezb_conf.bp1?ezb_conf.bp1:"",
			leaveHPInfo : ezb_conf.bp2?ezb_conf.bp2:"",
			goNow : _IsConfigItemDefined(ezb_conf_exp["gonow"],"label"),
			oldprice : (ezbEppId && myPjson.oldprice)?myPjson.oldprice:((myPjson.pro && myPjson.pro.pm)?myPjson.pro.pm:""),
			priceinfo : e.force_promo?"":(myPjson.pro && myPjson.pro.te && myPjson.pro.pf!=4)?myPjson.pro.te.replace(/'/g,"\\'"):((!e.promo && ezb_conf.pricedescinfo)?ezb_conf.pricedescinfo.replace(/'/g,"\\'"):""),
			pricedesc : (guistyle.indexOf('simple')!=-1 && (EZB.Instances[id].clientID.toLowerCase()).indexOf("btbt")!=-1)?"":(ezb_conf.pricedesc?ezb_conf.pricedesc:""),
			pricelasts: (!ezbEppId && myPjson.pro && myPjson.pro.ur)?myPjson.pro.ur.replace(/'/g,"\\'"):'',
			logosource : ezb_logos[myPjson.l]?'http://'+ezbserver+EZB.Paths.logoFolder+ezb_logos[myPjson.l].s:"",
			logolink : (myPjson.l&&ezb_logos[myPjson.l]&&ezb_logos[myPjson.l].page)?('http://'+ezbserver+EZB.Paths.logoClick+'?country='+country+'&lang='+lang+'&logoID=' + myPjson.l+('&page=' + (ezb_logos[myPjson.l]?escape(ezb_logos[myPjson.l].page):""))):"" ,
			logoalt : ezb_logos[myPjson.l]?ezb_logos[myPjson.l].text:"",
			delivery : EZB.Templates.Utils._DeliveryMessage(ezb_conf_exp,id),
			prff1:e.elements['prff']?v_f_price+' '+EZB.Prices.SinglePriceFormat(v_f_prod[partnr].replace(",",".")):0,
			prff2:e.elements['prff']?v_f_priceless+' '+EZB.Prices.SinglePriceFormat(myPjson.ind-v_f_prod[partnr].replace(",",".")):0
		};
			
		
		if(showDirectTemplate && !myPjson.has_ebus)
			TextSettings.addToBasket=TextSettings.localPartnerButton;
		
		if(ezoptions.indexOf("rightToLeftText")!=-1){
			//price
			if(myPjson.ind_f){
				if(myPjson.ind_f.indexOf(' ')!=-1){
					var a=myPjson.ind_f.split(' ');
					TextSettings.price=a[1]+' '+a[0];
				}else{
					if(myPjson.ind_f.indexOf(ezb_conf.currencychar)==0){
						TextSettings.price=myPjson.ind_f.replace(ezb_conf.currencychar,'')+ezb_conf.currencychar;
					}else{
						TextSettings.price=ezb_conf.currencychar+myPjson.ind_f.replace(ezb_conf.currencychar,'');
					}
				}
			}
			//intro
			(TextSettings.intro[0]=='?')?TextSettings.intro=TextSettings.intro.replace('?','')+'?':'';
		}

		for (var name in TextSettings){
			e.text[name]=TextSettings[name];
		}
		
		var elem=document.getElementById("EZB_"+id);
		e.ezframeWhite = false;
		if (elem && elem.parentNode && elem.parentNode.parentNode && elem.parentNode.parentNode.bgColor && elem.parentNode.parentNode.bgColor.toLowerCase() != "#e7e7e7") {
				e.ezframeWhite = true;
		}		
		Html+='<form></form>';
		Html+=e.draw(true,(ezoptions.indexOf("rightToLeftText")!=-1)?true:false);
		return(Html);
	}else{
		EZB.Instances[id].no_price_indication_display=true;
	}
};
/******************************************************************* 
/******************************************************************* 
/******************************************************************* 
 * Set the right initialisation is following
/******************************************************************* 
/******************************************************************* 
/******************************************************************* 
/** 
 * Set the right experience to use in Context
 * @return {} 
 * @method EZB.Experience
 * @public
 * @static
 */
EZB.Experience= function(){
	/*
 	* Set up the ezbuyExperience value to default value if not defined
 	*/
	/* set EZBuyExperience to default value if does not exist */
	var LocalExp=((EZB.Settings.ForceDirectExperience==true && window.ezbuyExperience)?"direct":"") || window.ezbuyExperience || "channel";
	if(EZB.Settings.ForceDirectExperience==true && LocalExp=="direct" && window.ezbuyExperience && ezbuyExperience!="direct"){
		if(window.HPStore_jumpID_detect && typeof HPStore_jumpID_detect == 'function'){
			HPStore_jumpID_detect(EZB.Context.m_s);
			printBasket('left',false);
			printBasket('left_partner',false);
		}
	}
	if(LocalExp!="direct" && LocalExp!="neutral" && LocalExp!="channel")
		LocalExp="channel";
	if (LocalExp == "epp" || EZB.Settings.showDirectTemplate) {
		LocalExp = "direct";
	}
	EZB.Log("INFO:EZB.Experience.Set",LocalExp+" returned ("+EZB.Context.ezbuyExperience+" initialy)");
	EZB.Context.ezbuyExperience=LocalExp;
};

/** 
 * Set the right URLS
 * @return {AddBasket:url} the urls to use 
 * @method EZB.Urls
 * @public
 * @static
 */
EZB.Urls=(function(){
	function _ParseReplace(url){
		url=url.replace(/#PL#/g,EZB.Context.PL);
		return(url);
	}
	function _AddBasket(){
		var Context=EZB.Context,
		storeId=Context.storeId,
		siteId=Context.siteId,
		storeUrl=Context.storeUrl,
		catalogUrl=Context.catalogUrl,
		refererUrl=Context.refererUrl;
		if(!window.storeUrlAdd) storeUrlAdd=storeUrl;
		(EZB.Context.ezbEppId && EZB.Context.ezbStoreId)?storeId=ezbStoreId:"";
		var addBasketUrl= escape(	[
										EZB.Paths.addBasket,
										"?type=hp&siteId=", siteId,
										"&clientId=", EZB.Context.clientID,
										"&storeId=", storeId,
										"&storeUrl=", ((storeUrlAdd.replace(/&/g,"S_AMP_E")).replace(/\?/g/"S_QM_E")).replace(/#/g,"S_POUND_E"), //WSA
										"&catalogUrl=", encodeURIComponent(encodeURIComponent(catalogUrl)),
										"&refererUrl=", encodeURIComponent(encodeURIComponent(refererUrl))
									].join('')
								);
		return(addBasketUrl);
	}
	return{
		AddBasket:_AddBasket(),
		elocatorURL:_ParseReplace(EZB.Settings.elocatorURL),
		dataQueryURL:_ParseReplace(
						[	EZB.req_protocol, "//", window.ezbserver || EZB.Utils.getQueryStringParameter( "ezbserver") || EZB.Settings.HPdataserver,
							EZB.Settings.HPsearchXmlQuery
						].join('')
					)
	}
})();

/*
---New CSS
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
    // hide tooltips, when mouse leaves the corresponding div element
    // Firefox etc.
    if(window.addEventListener && document.getElementById('tooltip') != null)
    {
      document.getElementById('tooltip').addEventListener('mouseout', hideTooltip, true);
    }
    // IE
    if(window.attachEvent && document.getElementById('tooltip') != null)
    {
      document.getElementById('tooltip').attachEvent('onmouseleave', hideTooltip, true);
    }
	 


    // modify links in screen2 container (change used CSS-class)
    var oLinkContainer = document.getElementsByTagName('a');
    for(i=0; i<oLinkContainer.length; i++)
    {
      if(oLinkContainer[i].className == 'secButtonEnhanced_ezb')
      {
        var sParentNode = oLinkContainer[i].parentNode.parentNode.parentNode;
        // screen 3
        if( oLinkContainer[i].parentNode.parentNode.className == 'sc2' )
        {
          if( oLinkContainer[i].href.match(/BuyPartnerFormAction/) )
          {
            // buy partner link
            oLinkContainer[i].className =  oLinkContainer[i].className.replace('secButtonEnhanced_ezb', 'ezbFindPartnerLink');
		          }
          else
          {
            // back link
            oLinkContainer[i].className =  oLinkContainer[i].className.replace('secButtonEnhanced_ezb', 'ezbPartnerBackLink');
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
              oLinkContainer[i].className =  oLinkContainer[i].className.replace('secButtonEnhanced_ezb', 'ezbFindPartnerLink');
		            }
            else
            {
              // back link
              oLinkContainer[i].className =  oLinkContainer[i].className.replace('secButtonEnhanced_ezb', 'ezbBackLink'); 
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


/*
---New CSS
*/





/******************************************************************* 
/******************************************************************* 
/******************************************************************* 
 * Page Load
/******************************************************************* 
/******************************************************************* 
/******************************************************************* 
/** 
 *
 * Event Based Triggered Actions
 */
(function(){
	EZB.Utils.AddLoadEvent(function(){
		EZB.Loaded.Defered=true;
		//EZB.Patch.Onload();
	});
	if(EZB.Context.RenderingHookUse){
			addRenderingHookEvent(false, function(){EZB.Loaded.Defered=true;});
	}
	if(EZB.Context.ezbdebug){
		if(EZB.Context.RenderingHookUse){
			addRenderingHookEvent(false,function(){EZB.Log("INFO:global","rendering Hook event")});
		}
		EZB.Utils.AddLoadEvent(function(){
			EZB.Log("INFO:global","onload event")
			if (!EZB.Context.is_ie){
				var w=window, logs=['global','LogReader','EZB.Settings','EZB.Utils','EZB.Experience','EZB.Logos','EZB.Products','EZB.Instance','EZB.Request','EZB.Config','EZB.Render','EZB.Prices','EZB.Omniture'];
				for(var i=0;i<logs.length;i++){
					(w.parent.EZB && w.parent.EZB.Log)?w.parent.EZBLogReader.hideSource("FRAME_"+logs[i]):EZBLogReader.hideSource("FRAME_"+logs[i]);
					(w.parent.EZB && w.parent.EZB.Log)?w.parent.EZBLogReader.hideSource(logs[i]):EZBLogReader.hideSource(logs[i]);
				}
			}		
		});
	}
})();