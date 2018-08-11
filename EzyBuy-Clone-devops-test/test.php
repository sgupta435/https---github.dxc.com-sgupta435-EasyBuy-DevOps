<html>

<head>
<title>Example #1 TDavid's Very First PHP Script ever!</title>
</head>
<?php 
	echo php_uname();
	echo "php position======>" .strpos(strtolower(php_uname()),'g9t0296g');
	if((strpos(php_uname(),'linux')===false)&& (strpos(strtolower(php_uname()),'g9t0296g')>0 || strpos(strtolower(php_uname()),'g9t0295g')>0 ) ) 
	{echo 'Dev server2';}
	else
	{echo 'itg server2';}


?>

<body>
</body>
</html>