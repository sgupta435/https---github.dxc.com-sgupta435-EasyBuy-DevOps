<?php
//Added By Sunetra Mhaske for display message on 29/10/2015
function displaymessage($lang)
{
	        header("Content-Type: text/html; charset=utf-8");	
			switch($_GET['lang'])
			{
			case "be" : $message='Nous sommes presque là...<br/>Vous allez être redirigé vers votre panier.';
			break;

			case "cz" : $message='Jsme skoro tam ...<br/> Ty jsou přesměrováni do nákupního košíku.';
			break;

			case "de" : $message='Wir sind fast da ... <br/>Sie werden in Ihren Warenkorb weitergeleitet.';
			break;

			case "dk" : $message='Vi er næsten der ...<br/> Du bliver omdirigeret til din indkøbskurv.';
			break;

			case "gr" : $message='Είμαστε σχεδόν εκεί ...<br/> Είστε να κατευθυνθούν στο καλάθι αγορών σας.';
			break;

			case "hu" : $message='Már majdnem ott vagyunk ... <br/>Ön irányították át a kosárban.';
			break;

			case "it" : $message='Ci siamo quasi ... <br/>Stai per essere reindirizzato al tuo carrello.';
			break;

			case "nl" : $message='We zijn er bijna ... <br/>U wordt doorgestuurd naar uw winkelwagen.';
			break;

			case "no" : $message='Vi er nesten der ...<br/> Du blir omdirigert til i handlekurven.';
			break;

			case "pl" : $message='Jesteśmy prawie na miejscu ... <br/>Zostaniesz przekierowany do Twojego koszyka.';
			break;

			case "sk" : $message='Sme skoro tam ... <br/>Tie sú presmerovaní do nákupného košíka.';
			break;

			case "es" : $message='Estamos casi allí ...<br/> Estás siendo redireccionado a su carrito de compras.';
			break;

			case "se" : $message='Vi är nästan där ...<br/> Du omdirigeras till din kundvagn.';
			break;

			case "tr" : $message='Biz Sepetinizde yönlendiriliyorsunuz ...<br/> neredeyse vardır.';
			break;

			case "ru" : $message='Мы почти там ... <br/>Вы будете перенаправлены на корзине.';
			break;

			case "br" : $message='Estamos quase lá ... <br/>Está a ser redireccionado para o seu carrinho de compras.';
			break;

			case "cn" : $message='我们几乎没有......<br/>你将被重定向到您的购物车。';
			break;

			case "kr" : $message='우리는 귀하의 쇼핑 바구니로 리디렉션되고있다 ...<br/> 거의있다.';
			break;

			case "fr" : $message='Nous sommes presque là...<br/>Vous allez être redirigé vers votre panier.';
			break;

			case "pt" : $message='Estamos quase lá...<br/>Está a ser redireccionado para o seu carrinho de compras.';
			break;

			default : $message='We are almost there...<br/>You are being redirected to your shopping cart.';
			break;
			}
			
			 $printmsg = '<div style="color:0096D6;position: fixed;left: 50%;top: 50%;z-index: 100;margin-top: -70px;width: 600px;margin-left: -300px;font-size:25px;text-align:center;">'.$message.'</div>';

  return $printmsg;
}
//end of code 
?>