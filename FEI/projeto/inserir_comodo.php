<?php
	$captURL = $_SERVER['REQUEST_URI'];
	$spr = explode('?',$captURL);
	$nomeComodo = $spr[1];
	$cix = $spr[2];
	$ciy = $spr[3];
	$cfx = $spr[4];
	$cfy = $spr[5];
	$comprimentoComodo = $spr[6];
	$larguraComodo = $spr[7];	
	$areaComodo = $spr[8];
	$perimetroComodo = $spr[9];
	$cod = $spr[10];
	
	//$alturaComodo = $_POST["alturaComodo"];
	
	$host = "localhost";
	$user = "root";
	$pass = "root";
	$banco = "db_eletrontech";
	
	
	$conexao = mysql_connect($host, $user, $pass) or die(mysql_error());
	mysql_select_db($banco) or die(mysql_error());
	$query = mysql_query("insert into tb_comodo values(NULL,'$nomeComodo', '$comprimentoComodo', '0.50', '$larguraComodo','$areaComodo','$perimetroComodo','$cix','$cfx', '$ciy','$cfy','$cod', 'indefinido')") or die(mysql_error());
	
	if ($query)
	{
		echo "Foi";
	}
	else
	{
		echo "Erro";
	}
	
	mysql_close($conexao);
?>