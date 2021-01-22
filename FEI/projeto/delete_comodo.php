<?php
	$captURL = $_SERVER['REQUEST_URI'];
	$spr = explode('?',$captURL);
	
	$nomeComodo = $spr[1];
	$host = "localhost";
	$user = "root";
	$pass = "root";
	$banco = "db_eletrontech";
	$cod = 1;
	
	$conexao = mysql_connect($host, $user, $pass) or die(mysql_error());
	mysql_select_db($banco) or die(mysql_error());
	$query = mysql_query("delete from tb_comodo where nm_comodo = '$nomeComodo';") or die(mysql_error());
	mysql_close($conexao);
?>