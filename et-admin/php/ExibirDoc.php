<?php
	ob_start();
	
	$aux = 0;
	
	$server = $_SERVER['SERVER_NAME']; 
	$arquivo = mysql_escape_string($_GET["arquivo"]);
	$tudo = "http://".$server.'/'.$arquivo;
	$tudo = str_replace(':', "%3A", $tudo);
	$tudo = str_replace(" ", "%20", $tudo);
	$tudo = str_replace('/', "%2F", $tudo);
	
	header("location:"."https://view.officeapps.live.com/op/view.aspx?src=".$tudo);
?>