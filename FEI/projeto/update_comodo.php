<?php
	$captURL = $_SERVER['REQUEST_URI'];
	$spr = explode('?',$captURL);
	
	//ComodoFuncs.src = "update_comodo.php?"+uNmComodo+"?"+uXiComodo+"?"+uYiComodo+"?"+uYiComodo+"?"+uYfComodo;
	$nomeComodo = $spr[1];
	$cix = $spr[2];
	$ciy = $spr[3];
	$cfx = $spr[4];
	$cfy = $spr[5];
	
	$host = "localhost";
	$user = "root";
	$pass = "root";
	$banco = "db_eletrontech";
	$cod = 1;
	
	$conexao = mysql_connect($host, $user, $pass) or die(mysql_error());
	mysql_select_db($banco) or die(mysql_error());
	$query = mysql_query("update tb_comodo set cd_comodo_xI = $cix,
												cd_comodo_xF = $cfx,
												cd_comodo_yI = $ciy,
												cd_comodo_yF = $cfy
												where nm_comodo = '$nomeComodo';") or die(mysql_error());
	mysql_close($conexao);
?>