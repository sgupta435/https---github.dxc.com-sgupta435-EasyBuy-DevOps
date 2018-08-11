<?php
$ezb_partner = "test-sl";
$country_code = "uk";
$language_code = "en";
$currency_code = "GBP";
$customer_segment = "smb";
$is_debug= "false";
$order_details = "";
$go=0;

/*
 * Include Utils Library
 */
require_once "../common/php/include/ezb_utils.ProcessParams.php.inc";
/*
 * Process parameters
 */
$debug=true;
$_req_mandatory_var_names = array(); //mandatory parameters
$_req_optional_var_names = array("is_https","go","ezb_partner","country_code","language_code","currency_code","customer_segment","is_debug","order_details"); //optional parameters
$param_ok=UtilsProcessParams($_req_mandatory_var_names, $_req_optional_var_names,"debug");


if($go){
	echo <<<____ORDER
		<form name="outputform" method="post">
		<textarea name="output" cols="150" rows="25"></textarea>
		</form>
		<script>
		var is_debug=$is_debug;
		var is_https=$is_https?$is_https:0;
		var debug_output=true;
		var country_code="$country_code";
		var language_code="$language_code";
		var customer_segment="$customer_segment"; /* This is for Consumers */
		var currency_code="$currency_code"; /* Swiss Franc */
		var order_details="$order_details";
		</script>
____ORDER;
	if($is_https){
		echo "<script src=https://".$_SERVER['HTTP_HOST']."/ezbuy/ecom/$ezb_partner/ezbpartner.js></script>";
	}else{
		echo "<script src=http://".$_SERVER['HTTP_HOST']."/ezbuy/ecom/$ezb_partner/ezbpartner.js></script>";
	}
}else{
	$script=$_SERVER["PHP_SELF"];
	echo <<<____FORM1
	<HTML>
	<HEAD>
	</HEAD>
	<BODY>
	<SCRIPT>
		_rn1 = new String (Math.random());
		_rns1 = _rn1.substring (2, 4)+"."+_rn1.substring (2, 4);
		_rn2 = new String (Math.random());
		_rns2 = _rn2.substring (2, 4)+"."+_rn2.substring (2, 4);
		var order_details=';TEST-1;1;'+_rns1+','+';TEST-2;2;'+_rns2;
		is_debug=window.is_debug?is_debug:1;
		is_https=window.is_https?is_https:0;

		function log(arg){
			if(window.console)
				console.log(arg);
		}

		var country_code,language_code,customer_segment,currency_code,ezb_partner,order_details;
		function order(){
			country_code=document.getElementById("ctrysettings").value.split("/")[0];
			language_code=document.getElementById("ctrysettings").value.split("/")[1];
			customer_segment=document.getElementById("segment").value;
			currency_code=document.getElementById("currency").value;
			ezb_partner=document.getElementById("ezb_partner").value;
			order_details=document.getElementById("order_details").value;
			var debug_output=true;
			log("debug:"+is_debug);
			log("https:"+is_https);
			log("cc:"+country_code);
			log("ll:"+language_code);
			log("cur:"+currency_code);
			log("partner:"+ezb_partner);
			log("order:"+order_details);

			if((window.top.location.protocol.toLowerCase().indexOf('https')>=0)){
				//is_https=true;
				url="https://";
			}else{
				url="http://";
				//is_https=false;
			}
			url=url+window.top.location.hostname+"$script?go=1&ezb_partner="+ezb_partner+"&country_code="+country_code+"&language_code="+language_code+"&currency_code="+currency_code+"&customer_segment="+customer_segment+"&order_details="+escape(order_details);
			url+="&is_debug="+(is_debug?is_debug:0);
			url+="&is_https="+(is_https?is_https:0);
			frames[0].location=url;
		}
	</SCRIPT>
	<form name="form" method="post" action="javascript:order();">
	    <table border="0" cellpadding="4" cellspacing="2" width="1000">
	      <tbody><tr bgcolor="#f3f3f3" valign="middle">
	        <td colspan="2" class="textBold" align="center" bgcolor="#dddddd">Choose your test order settings</td>
	      </tr>
	      <tr bgcolor="#eeeeee" valign="middle">
	        <td class="text" width="300">Country/language</td>
	        <td width="300">
	          <select id="ctrysettings" name="ctrysettings" class="text" style="width: 300px;">
____FORM1;


		           	// Get the file settings into an array.
				   					$lines =  file('../configuration/country_lang_deployed.ini');
				   					$lines2 = file('../configuration/country_lang_planned.ini');
				   					// Loop through our array
				   					echo '<option  style="background-color:orange;" value="">Deployed:</option>';
				   					foreach ($lines as $line_num => $line)
				   					{
				   						if($line_num % 2 == 0)
				   						{
				   							$word =  $line;
				   							$pos = strpos($word, '[');
				   							$pos1 = strrpos($word, ']');
				   							$word = substr($word, $pos+1, $pos1-$pos-1);
				   							echo '<option value="'.$word.'">';
				   						}
				   						else
				   						{
				   							$word =  $line;
				   							$pos = strpos($word, '"');
				   							$pos1 = strrpos($word, '"');
				   							$word = substr($word, $pos+1, $pos1-$pos-1);
				   							echo $word.'</option>';
				   						}
				   					}
				   					echo '<option  style="background-color:orange;" value="">Planned:</option>';
				   					// Loop through our array
				   					foreach ($lines2 as $line_num => $line)
				   					{
				   						if($line_num % 2 == 0)
				   						{
				   							$word =  $line;
				   							$pos = strpos($word, '[');
				   							$pos1 = strrpos($word, ']');
				   							$word = substr($word, $pos+1, $pos1-$pos-1);
				   							echo '<option value="'.$word.'">';
				   						}
				   						else
				   						{
				   							$word =  $line;
				   							$pos = strpos($word, '"');
				   							$pos1 = strrpos($word, '"');
				   							$word = substr($word, $pos+1, $pos1-$pos-1);
				   							echo $word.'</option>';
				   						}
					}

echo <<<____FORM2
	</select>
        </td>
      </tr>
      <tr bgcolor="#eeeeee" valign="middle">
        <td class="text">Market segment</td>
        <td width="300">
          <select id="segment" name="segment" class="text" style="width: 300px;">
		<option value="smb" selected="selected">smb (Small &amp; Medium Business)</option><option value="hho">hho (Consumer)</option>          </select>

        </td>
      </tr>
      <tr bgcolor="#eeeeee" valign="middle">
        <td class="text">Currency<br>
          <span class="textSmall">use code</span></td>
        <td width="300">
          <input id="currency" name="currency" type="text" size="3" value="EUR"></input>
        </td>

      </tr>

      <tr bgcolor="#eeeeee" valign="middle">
        <td class="text">Partner<br>
          <span class="textSmall">use partner ID</span></td>
        <td width="300">
          <input id="ezb_partner" name="ezb_partnr" type="text" size="10" value="test-sl"></input>
        </td>

      </tr>

      <tr bgcolor="#eeeeee" valign="middle">
        <td class="text">Partnumber<br>
          <span class="textSmall">use Omniture format</span></td>
        <td width="600">
          <input id="order_details" name="partnrs" type="text" size="100" value=";TEST-SL1;1;10.0,;TEST-SL2;1;20.0"></input>
          <script>document.getElementById("order_details").value=order_details;</script>
        </td>

      </tr>

      <tr bgcolor="#eeeeee" valign="middle">
        <td class="text">Debug (Default is Yes )<br>

          <span class="textSmall"><font color="red">Please note!: If valid MerchantID and No is selected here, then the order is submitted to Omniture PRO!</font></span></td>
        <td width="300">
        	<table border="0" cellpadding="4" cellspacing="2" width="100%"><tbody><tr valign="middle">
			<td class="text" align="left" width="100"><input id="debugyes" name="debug" value="1" checked="checked" type="radio" onclick="javascript:is_debug=1;">Yes</td>
						<td class="text" align="left" width="140"><input name="debug" id="debugno" value="0" type="radio" onclick="javascript:is_debug=0;">No</td>
        	</tr></tbody></table>
        </td>

      </tr>
      <tr bgcolor="#eeeeee" valign="middle">
        <td class="text">Https (Default is Http)<br>

          <span class="textSmall"></span></td>
        <td width="300">
        	<table border="0" cellpadding="4" cellspacing="2" width="100%"><tbody><tr valign="middle">
			<td class="text" align="left" width="100"><input id="httpsno" name="ishttps" value="0" checked="checked" type="radio" onclick="javascript:is_https=0;">Http</td>
						<td class="text" align="left" width="140"><input id="httpsyes" name="ishttps" value="1" type="radio" onclick="javascript:is_https=1;">Https</td>
        	</tr></tbody></table>
        </td>

      </tr>
            <tr bgcolor="#f3f3f3" valign="middle">

        <td colspan="2" class="textBold" align="center" bgcolor="#dddddd">
          <input name="Submit" value="Submit" class="button" type="submit">
        </td>
      </tr>
    </tbody></table>
  </form>

<iframe width="100%" height="500"></iframe>

</BODY>
</HTML>
____FORM2;
}

?>