var ezb_FIF = false; var ezbloaded = false; if (window.ezbloaded_not_needed) { ezbloaded = true } var ezbOmVars = new Array; var ezbOldValues = new Array; var ezbNewValues = new Array; var ezb_s_account = "hphqglobal,hphqemea,devhphqeasybuyv2"; var s_account; var s_account_mem = s_account; var na = "-"; var _sw = window; var redirectURL = "empty"; var redirectURLNewW = false; var pageURL = window.top.location.toString(); var ezbOMdebug = (pageURL.lastIndexOf("ezbomdebug=") != -1) ? true : false; var oldOmnitureArgs = "empty"; var ezbdebug = ""; var URLnode = ""; var l_indPriceOrder = (window.EZB && EZB.Settings && EZB.Settings.indPriceOrder != "") ? EZB.Settings.indPriceOrder : "-"; (_sw.l4 && l4.length > 1) ? 0 : l4 = "-"; (_sw.l7 && l7.length > 1) ? 0 : l7 = "-"; (_sw.l8 && l8.length > 1) ? 0 : l8 = "-"; (_sw.l9 && l9.length > 1) ? 0 : l9 = "-"; (_sw.l2 && l2.length > 1) ? 0 : l2 = "-"; (_sw.l3 && l3.length > 1) ? 0 : l3 = "-"; var ezb_debug_overwrite_alert = false; function overwrite_alert() { if (ezb_debug_overwrite_alert) { _sw.alert = function(a) { _sw.document.outputform.output.value = _sw.document.outputform.output.value + a + "\n" } } } overwrite_alert(); function addLoadEvent(a) { if (!ezbloaded) { var b = _sw.onload; if (typeof _sw.onload != "function") { _sw.onload = a } else { _sw.onload = function() { b(); a() } } } else { a() } } function SetEZBaccount() { s_pageName = escape(window.s_pageName || ""); if (_sw.ezb_FIF == false && !ezbloaded) { ezb_s_account = "hphqglobal,devhphqeasybuyv2" } if (ezb_s_account != "hphqglobal,devhphqeasybuyv2" && ezb_s_account != "devhphqeasybuyv2") { if (_sw.s_account && _sw.s_account.indexOf("hphq") != -1) { if (s_account == "hphqglobal" && s_account_mem.indexOf("hp") != -1) { ezb_s_account = s_account_mem + ",devhphqeasybuyv2" } else { ezb_s_account = s_account + ",devhphqeasybuyv2" } } } s_dynamicAccountList = "devhphqeasybuyv2=localhost,127.0.0.1,ezbserver,ezbomdebug,hpqcorp,cpqcorp,stage,ezbhtml,debug"; s_dynamicAccountMatch = window.top.location.toString() } function SetEZBvar(arr) { for (var i = 0; i < arr.length / 2; i++) { var k = ezbOmVars.length; ezbOmVars[k] = arr[2 * i]; ezbNewValues[k] = arr[2 * i + 1]; if (ezbNewValues[k].indexOf("\u2122") > 1) { ezbNewValues[k] = ezbNewValues[k].split("\u2122").join("&#193;") } if (ezbNewValues[k].indexOf("\u2019\u2019") > 1) { ezbNewValues[k] = ezbNewValues[k].split("\u2019\u2019").join("&#148;") } if (eval("_sw." + ezbOmVars[k])) { ezbOldValues[k] = eval(ezbOmVars[k]) } else { ezbOldValues[k] = "" } if (ezbOmVars[k] == "s_eVar2") { ezbNewValues[k] = ezbNewValues[k] + " | " + l7 + " | " + l8 + " | " + l9 } eval(ezbOmVars[k] + '="' + ezbNewValues[k].split('"').join("") + '"') } } function SetEZBvarFIF() { if (_sw.s_account && _sw.s_account.indexOf("hphq") == -1) { EmptyEZBvar(); l4 = "ezb_FIF_remote_catalog"; l2 = "ezb_FIF_remote_catalog"; l3 = "_" } else { } SetEZBvar(["s_eVar16", "in_R2790_" + l9 + "_" + l7 + "_" + l8 + "/fif/" + l2 + "/" + l3, "s_eVar20", "in_R2790_" + l9 + "_" + l7 + "_" + l8 + "/" + l2 + "/" + l3]) }

function SetEZBvarCommon() {
    //Added by Nithiyanandhan on 10/10/2013 - Client id fixes

    _sw.s_prop4 = EZB.Context.clientID;
    l4 == "-" ? ((_sw.s_prop4 && s_prop4.length > 0) ? l4 = _sw.s_prop4 : 0) : 0;
    (l4.indexOf("product catalog") != -1) ? l4 = "psc" : 0;
    //Added by Nithiyanandha on 06/11/2013 - Omniture fixes
    if (_sw.s_prop4 && s_prop4.length > 0) {
        if (_sw.s_prop4 == '') {
            l4 = "cs";
            _sw.s_prop4 = "cs";
        }
        if (_sw.s_prop4 == "hp.com") {
            l4 = "cs";
            _sw.s_prop4 = "cs";
        }
        if (_sw.s_prop4 == "-") {
            l4 = "cs";
        }
    }

    l2 == "-" ? ((_sw.s_prop2 && s_prop2.length > 0) ? l2 = _sw.s_prop2 : 0) : 0;
    l3 == "-" ? ((_sw.s_prop3 && s_prop3.length > 0) ? l3 = _sw.s_prop3 : 0) : 0;
    l7 == "-" ? l7 = EZB.Context.cc : 0; l8 == "-" ? l8 = EZB.Context.lc : 0;
    l9 == "-" ? l9 = EZB.Context.m_s : 0; SetEZBaccount();
    SetEZBvar(["s_currencyCode", EZB.Settings.ezbCurrencyCode, "s_account", ezb_s_account, "s_prop13", ezb_s_account]);
    if (window.s_products) { SetEZBvar(["s_events", s_events, "s_products", s_products]) } SetEZBvar(["s_eVar1", l7 + " | " + l8 + " | " + l9, "s_eVar4", l4]);
    SetEZBvar(["s_eVar32", l7 + " | " + l8 + " | " + l9 + " | " + l4]); 
    SetEZBvar(["s_prop4", l4, "s_prop7", l7, "s_prop8", l8, "s_prop9", l9]); SetEZBvar(["s_eVar30", "HP.com->Buy"]);
    if (window.l_s_eVar16) { SetEZBvar(["s_eVar16", l_s_eVar16]) } 
     
} function EmptyEZBvar() { vars_number = 30; for (var i = 1; i < vars_number + 1; i++) { var k = ezbOmVars.length; ezbOmVars[k] = "s_prop" + i; ezbOmVars[k + vars_number] = "s_eVar" + i; ezbNewValues[k] = ""; ezbNewValues[k + vars_number] = ""; if (eval("_sw." + ezbOmVars[k])) { ezbOldValues[k] = eval(ezbOmVars[k]); ezbOldValues[k + vars_number] = eval(ezbOmVars[k + 20]) } else { ezbOldValues[k] = ""; ezbOldValues[k + vars_number] = "" } eval(ezbOmVars[k] + '="' + ezbNewValues[k].split('"').join("") + '"'); eval(ezbOmVars[k + vars_number] + '="' + ezbNewValues[k + vars_number].split('"').join("") + '"') } } function UnsetEZB() { for (var i = 0; i < ezbOmVars.length; i++) { if (eval("_sw." + ezbOmVars[i])) { eval(ezbOmVars[i] + '="' + ezbOldValues[i] + '"') } } ezbOmVars.length = 0; ezbOldValues.length = 0; ezbNewValues.length = 0; s_pageName = unescape(s_pageName) } function s_sendAnalyticsEventWrap(a) { if (EZB.Settings.enableTracking != -1) { s_dynamicAccountSelection = true; if (window.s_gi && typeof s_gi == "function") { s_sendAnalyticsEvent(null, s_pageName) } else { if (window.s_gs && typeof s_gs == "function") { ns = s_account; if (a != null && a.length > 0) { ns += "," + a } s_gs(ns) } } s_dynamicAccountSelection = false } } function ezb_debug() { if (ezbOMdebug) { ezbdebug = ""; for (var a = 0; a < ezbOmVars.length; a++) { ezbdebug += ezbOmVars[a] + "=" + ezbNewValues[a] + " [old:" + ezbOldValues[a] + "]\n" } ezbdebug += "URLnode=" + URLnode.substr(0, 75) + "\n" + URLnode.substr(75, 150) + "\n" + URLnode.substr(150, 225) + "\n"; +URLnode.substr(225) + "\n"; ezbdebug += "redirectURL=" + redirectURL.substr(0, 75) + "\n" + redirectURL.substr(75, 150) + "\n" + redirectURL.substr(150, 225) + "\n" + redirectURL.substr(225) + "\n"; alert(ezbdebug) } } function sendOmnitureLoad() { s_ios = 1; s_events = "event5,event18"; if (window.EZB.Requests.length && EZB.Requests.length > 0) { if (EZB.Omniture.s_products.indexOf("event18") == -1) { s_events = "event5" } if (EZB.Omniture.s_products.indexOf("event40") != -1) { s_events += ",event40" } if (EZB.Omniture.s_products.indexOf("event41") != -1) { s_events += ",event41" } if (EZB.Omniture.s_products.indexOf("event46") != -1) { s_events += ",event46" } s_events += ",event20"; if (EZB.Omniture.s_products && EZB.Omniture.s_products != "") { if (EZB.Omniture.s_products.indexOf("event") != -1) { s_products = EZB.Omniture.s_products + "|event20=" + EZB.Requests.length } else { s_products = EZB.Omniture.s_products + ";event20=" + EZB.Requests.length } } else { s_products = "event20=" + EZB.Requests.length } } ezb_view = "EZB3.0 View"; var a = ezb_s_account; SetEZBvarCommon(); SetEZBvar(["s_pageName", ezb_view + " | " + l4 + " | " + l7 + " | " + l8 + " | " + l9 + " | " + l2 + "/" + l3, "s_eVar21", l_indPriceOrder]); ezb_s_account = a; s_sendAnalyticsEventWrap(""); ezb_debug(); UnsetEZB(); ezbloaded = true } function sendOmnitureFIFLoad(b) { s_ios = 1; ezb_FIF = true; var a = "EZB3.0 FIF View | version " + iCodeVer; s_products = ";" + b + ";0;0;event18=1"; (_sw.ezb_omnitureTitle && ezb_omnitureTitle.length > 0) ? l3 = _sw.ezb_omnitureTitle : 0; SetEZBvarCommon(); SetEZBvarFIF(); s_usePlugins = false; SetEZBvar(["s_pageName", a + " | " + l4 + " | " + l7 + " | " + l8 + " | " + l9 + " | " + l2 + "/" + l3]); s_sendAnalyticsEventWrap(""); ezb_debug(); UnsetEZB(); s_usePlugins = true; ezbloaded = true } function sendOmnitureFIF() { ezb_FIF = true; SetEZBvarCommon(); SetEZBvarFIF(); sendOmnitureCommon_ezb(sendOmnitureFIF.arguments) } function sendOmniture() { SetEZBvarCommon(); var a = []; for (var b = 0; b < sendOmniture.arguments.length; b++) { if (sendOmniture.arguments[b].indexOf("event15,event17") != -1) { a[a.length] = "event13,event17"; a[a.length] = "s_eVar31"; a[a.length] = "Buy Offline SC2" } else { if (sendOmniture.arguments[b].indexOf("event13,event17") != -1) { a[a.length] = "event13,event17"; a[a.length] = "s_eVar31"; a[a.length] = "Buy Offline SC1" } else { a[a.length] = sendOmniture.arguments[b] } } } sendOmnitureCommon_ezb(a) } function sendOmnitureCommon_ezb(f) { s_ios = 1; var a; var h = ""; var g = ""; for (var e = 0; e < f.length; e++) { h += f[e].toString() + ":"; if (f[e].indexOf("s_pageName") != -1) { a = e } } if ((s_events.indexOf("scAdd") != -1 || h.indexOf("scAdd") != -1) && document.cookie.indexOf("_ezb_o") == -1) { var j = new Date(); var b = new Date(j.getTime() + 30 * 24 * 3600 * 1000); var d = b.toGMTString(); document.cookie = "_ezb_o=" + l4 + ";path=/;domain=.hp.com;expires=" + d } if (window.EZBACTION && EZBACTION != "") { f[a + 1] = f[a + 1].replace("EZB", "EZB SC") } SetEZBvar(f); s_usePlugins = false; if (oldOmnitureArgs != h) { s_sendAnalyticsEventWrap("") } s_usePlugins = true; ezb_debug(); UnsetEZB(); oldOmnitureArgs = h; if (redirectURL != "empty") { var c = redirectURL; redirectURL = "empty"; if (!redirectURLNewW) { _sw.setTimeout('window.top.location="' + c + '"', 1250) } else { redirectURLNewW = false; _sw.setTimeout('window.open("' + c + '","new")', 1250) } } } function utf8(b) { var f, e; var a = ""; var d = 0; while (d < b.length) { f = b.charCodeAt(d++); if (f >= 56320 && f < 57344) { continue } if (f >= 55296 && f < 56320) { if (d >= b.length) { continue } e = b.charCodeAt(d++); if (e < 56320 || f >= 56832) { continue } f = ((f - 55296) << 10) + (e - 56320) + 65536 } if (f < 128) { a += String.fromCharCode(f) } else { if (f < 2048) { a += String.fromCharCode(192 + (f >> 6), 128 + (f & 63)) } else { if (f < 65536) { a += String.fromCharCode(224 + (f >> 12), 128 + (f >> 6 & 63), 128 + (f & 63)) } else { a += String.fromCharCode(240 + (f >> 18), 128 + (f >> 12 & 63), 128 + (f >> 6 & 63), 128 + (f & 63)) } } } } return a } var hexchars = "0123456789ABCDEF"; function toHex(a) { return hexchars.charAt(a >> 4) + hexchars.charAt(a & 15) } var okURIchars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_-."; function encodeURIComponentNew(d) { var d = utf8(d); var e; var a = ""; for (var b = 0; b < d.length; b++) { if (okURIchars.indexOf(d.charAt(b)) == -1) { a += "%" + toHex(d.charCodeAt(b)) } else { a += d.charAt(b) } } return a }

function ezb_AddBasket(n, f, g, t, q, e, m) {
    var s = "buy"; if (window.EZBACTION && EZBACTION != "") {
    s = "SmartChoice_" + EZBACTION
} var h = ""; (s.toLowerCase().indexOf("buy") != -1) ? ((s.toLowerCase().indexOf("config") != -1) ? h = "Buy/Config" : h = "Buy") : h = "Config";
var j, x, w, u; s_products = ""; if (f == "hp") {
s_events = "event10,event16,scAdd"
} else {
s_events = "event14,event16,scAdd"
} var d = 0; var v = ""; var y = 0; partnr_a = t.split(",");
price_a = q.toString().split(","); var i = partnr_a[0].split("|")[0]; 
for (var p = 0; p < partnr_a.length; p++) {
    partnr_i = partnr_a[p].split("|");
    if (partnr_i.length > 1) {
        if (partnr_i[1] > 0) {
            d++;
            if (p > 0) {
                s_products += ","; v += "_"
            } lprice = 0;
            if (partnr_i[1] < 99) {
                for (var o = 0; o < price_a.length; o++) {
                    price_i = price_a[o].split("|");
                    if (price_i.length > 1) {
                        if (price_i[0] == partnr_i[0]) { lprice = price_i[1]; break }
                    }
                    else {
                        lprice = price_i[0]
                    } 
                } 
            }
            if (lprice != 0 || partnr_i[1] >= 99) {
                s_products += ";" + partnr_i[0] + ";" + partnr_i[1] + ";" + lprice * partnr_i[1]; s_products += ";event16=" + lprice * partnr_i[1];
                v += partnr_i[0] + "-" + partnr_i[1]; y = y + lprice * partnr_i[1]
            } 
        } 
    }
}
v += "|" + y;

//Added by Nithiyanandhan on 10/10/2013 - Omniture client id fix
l4 = m;
if (m.length > 0) {
    if (m == '') {
        l4 = "cs";
        m = "cs";
    }
    if (m == "hp.com") {
        l4 = "cs";
        m = "cs";
    }
    if (m == "-") {
        l4 = "cs";
        m = "cs";
    }
}
if (f == "hp") {
    if (d > 1) {
        v = "EZB3.0 Buyn HP | " + (m ? m : l4) + " | " + l7 + " | " + l8 + " | " + l9 + " | " + v
    }
    else { v = "EZB3.0 " + h + " HP | " + (m ? m : l4) + " | " + l7 + " | " + l8 + " | " + l9 + " | " + v } 
}
else {
    if (d > 1) {
        v = "EZB3.0 Leadn | " + (m ? m : l4) + " | " + l7 + " | " + l8 + " | " + l9 + " | " + e + " | " + v
    }
    else { v = "EZB3.0 Lead " + h + " | " + (m ? m : l4) + " | " + l7 + " | " + l8 + " | " + l9 + " | " + e + " | " + v } 
}
sendOmniture("s_pageName", v, "s_eVar2", n, "s_eVar3", i, "s_eVar21", l_indPriceOrder, "s_prop4", m ? m : l4, "s_eVar4", m ? m : l4)
}
function ezb_FindPartner(b, d, f) {
    //Added by nithiyanandhan on 06/11/2013 - Omniture fixes - start
    if (f.length > 0) {
        if (f == '') {
            l4 = "cs";
            f = "cs";
        }
        if (f == "hp.com") {
            l4 = "cs";
            f = "cs";
        }
        if (f == "-") {
            l4 = "cs";
            f = "cs";
        }
    }
    //end
    var a = "1"; s_events = "event13,event17"; s_eVar31 = "Buy Offline SC1"; var e = "buy"; if (window.EZBACTION && EZBACTION != "") {
    e = "SmartChoice_" + EZBACTION
} if (window.which_screen && window.which_screen == "2") { a = "2"; s_eVar31 = "Buy Offline SC2" }
var c = ""; (e.toLowerCase().indexOf("buy") != -1) ? ((e.toLowerCase().indexOf("config") != -1) ? c = "Buy/Config" : c = "Buy") : c = "Config";
if (d == "null") { d = 0 } s_products = ";" + b + ";0;" + d + ";event17=" + d; tpagename = "EZB3.0 " + c + " Offline SC" + a + " | " + l7 + " | " + l8 + " | " + l9 + " | " + b + " | " + d;
redirectURLNewW = true; sendOmniture("s_pageName", tpagename, "s_eVar3", b, "s_eVar21", l_indPriceOrder, "s_eVar31", s_eVar31, "s_prop4", f ? f : l4, "s_eVar4", f ? f : l4)
}
function ezb_BuyPartner(a, c, e) {
//Added by nithiyanandhan on 06/11/2013 - Omniture fixes - start
    if (e.length > 0) {
        if (e == '') {
            l4 = "cs";
            e = "cs";
        }
        if (e == "hp.com") {
            l4 = "cs";
            e = "cs";
        }
        if (e == "-") {
            l4 = "cs";
            e = "cs";
        }
    }
    //end
    s_events = "", tpagename = ""; s_products = ""; s_events = "event11"; var d = "buy"; if (window.EZBACTION && EZBACTION != "") {
    d = "SmartChoice_" + EZBACTION
} var b = ""; (d.toLowerCase().indexOf("buy") != -1) ? ((d.toLowerCase().indexOf("config") != -1) ? b = "Buy/Config" : b = "Buy") : b = "Config";
if (c == "null") { c = 0 } s_products = ";" + a + ";0;" + c; tpagename = "EZB3.0 " + b + " Partner | " + l7 + " | " + l8 + " | " + l9 + " | " + a + " | " + c;
sendOmniture("s_pageName", tpagename, "s_eVar3", a, "s_eVar21", l_indPriceOrder, "s_prop4", e ? e : l4, "s_eVar4", e ? e : l4)
}
if((_sw.countrysettingsLoaded!=false)&&(EZB.Settings.enableTracking!=-1)){addLoadEvent(function(){sendOmnitureLoad()})};
