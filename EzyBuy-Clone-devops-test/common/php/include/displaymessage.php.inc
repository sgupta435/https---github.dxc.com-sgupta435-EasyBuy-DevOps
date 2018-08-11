<?php
//Added By Sunetra Mhaske for display message on 29/10/2015
function displaymessage($lang)
{
	        header("Content-Type: text/html; charset=utf-8");	
			switch($_GET['lang'])
			{
			
			case "cz" : $message='Vše je téměř připraveno,<br/> probíhá přesměrování do vašeho nákupního košíku…';
			break;

			case "da" : $message='Du er næsten færdig.<br/> Vi sender dig videre til indkøbskurven…';
			break;
			
			case "de" : $message='Gleich sind Sie fertig. <br/> Sie werden nun zu Ihrem Warenkorb weitergeleitet ...';
			break;
			
			case "es" : $message='Ya falta poco.<br/> Le estamos transfiriendo al carrito de la compra...';
			break;
			
			case "fi" : $message='Melkein valmis,<br/> siirrytään ostoskorisivulle…';
			break;
			
			case "fr" : $message='Vous y êtes presque. <br/> Nous vous redirigeons vers votre panier...';
			break;
			
			case "it" : $message='Ci siamo quasi,<br/> fra poco andrai al carrello degli acquisti...';
			break;
			
			case "ja" : $message='まもなくショッピングカートに移動します….';
			break;
	
			case "ko" : $message='거의 다 되었습니다.<br/> 귀하의 장바구니로 전송 중입니다...';
			break;
			
			case "nl" : $message='Bijna klaar,<br/> we leiden u nu door naar uw winkelwagen ...';
			break;
			
			case "no" : $message='Nesten ferdig,<br/> vi overfører deg til handlekurven...';
			break;
	
			case "pl" : $message='Już prawie gotowe.<br/> Za chwilę nastąpi przejście do Twojego koszyka…';
			break;

			
			case "pt" : $message='Está quase.<br/> Estamos a transferi-lo para o seu carrinho de compras...';
			break;

			case "ru" : $message='Почти готово. <br/> Переходим в корзину...';
			break;

			case "sv" : $message='Din kundvagn <br/> visas alldeles strax …';
			break;
			
			case "tr" : $message='Neredeyse oldu, <br/> sizi alışveriş sepetinize yönlendiriyoruz...';
			break;
			
			case "zh" : $message='就快完成了，我们正在将您转移到您的购物车…';
			break;

			
			case "gr" : $message='Περιμένετε όσο <br/> μεταφέρεστε στο καλάθι αγορών σας…';
			break;

			case "en" : $message='Transferring you now......';
			break;
			
			}
			
			 $printmsg = '<div style="color:0096D6;position: fixed;left: 50%;top: 50%;z-index: 100;margin-top: -70px;width: 600px;margin-left: -300px;font-size:25px;text-align:center;">'.$message.'</div>';

  return $printmsg;
}
//end of code 
?>