<?php
function getRefererUrl($country,$lang,$client_id,$currUrl1)
{

//if ($client_id == "cs"){
//$refererUrl = $currUrl1;


//}

//else {

if ($country == "de" && $lang == "de") {
$refererUrl = "http://h20386.www2.hp.com/GermanyStore/cart.mvc?lang=de-DE";
}
else if ($country == "se" && $lang == "sv") 
{
$refererUrl = "http://h20386.www2.hp.com/SwedenStore/cart.mvc?lang=sv-SE";
}
else if ($country == "fr" && $lang == "fr") 
{
$refererUrl = "http://h20386.www2.hp.com/FranceStore/cart.mvc?lang=fr-FR";
}
else if ($country == "es" && $lang == "es") 
{
$refererUrl = "http://h20386.www2.hp.com/SpainStore/cart.mvc?lang=es-ES";
}
else if ($country == "uk" && $lang == "en") 
{
//$refererUrl = "http://h20386.www2.hp.com/UKStore/cart.mvc";
$refererUrl = "https://itg.store.hp.com/ukstore/merch/cart.aspx";
}
else if ($country == "it" && $lang == "it") 
{
$refererUrl = "https://store.hp.com/ItalyStore/Merch/Cart.aspx";
}
else if ($country == "nl" && $lang == "nl")
{
$refererUrl = "https://store.hp.com/NetherlandsStore/Merch/Cart.aspx";
}
else if ($country == "se" && $lang == "sv") 
{
$refererUrl = "http://h20386.www2.hp.com/SwedenStore/cart.mvc?lang=sv-SE";
}
else if ($country == "ch") 
{
if ($lang == "de")
{
$refererUrl = "http://h20386.www2.hp.com/SwitzerlandStore/cart.mvc?lang=de-CH";
}
else if ($lang=="fr")
{
$refererUrl = "http://h20386.www2.hp.com/SwitzerlandStore/cart.mvc?lang=fr-CH";
}
else if ($country == "sg" && $lang == "en") 
{
$refererUrl = "http://h20386.www2.hp.com/SingaporeStore/cart.mvc?lang=en-SG";
}
else if ($country == "ca" && $lang == "en")
{
$refererUrl = "http://h20386.www2.hp.com/CanadaStore/cart.mvc?lang=en-CA";
}
else if ($country == "ca" && $lang == "fr")
{
$refererUrl = "http://h20386.www2.hp.com/CanadaStore/cart.mvc?lang=fr-CA";
}
else if ($country == "my" && $lang == "en")
{
$refererUrl = "http://h20386.www2.hp.com/MalaysiaStore/cart.mvc?lang=en-MY";
}
else if ($country == "kr" && $lang == "ko")
{
$refererUrl = "http://h20386.www2.hp.com/KoreaStore/cart.mvc?lang=ko-KR";
}

//}


}
return ($refererUrl);

}









