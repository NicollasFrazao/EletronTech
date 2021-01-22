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
	$query = mysql_query("select * from tb_comodo where nm_comodo = '$nomeComodo';") or die(mysql_error());
	
	while($comodoP = mysql_fetch_array($query))
	{
		$nomeComodo = $comodoP["nm_comodo"];
		$tipoComodo = $comodoP["nm_tipo"];
		//$alturaComodo = $_POST["alturaComodo"];
		$larguraComodo = $comodoP["cd_largura"];
		$comprimentoComodo = $comodoP["cd_comprimento"];
		$areaComodo = $comodoP["cd_area"];
		$perimetroComodo = $comodoP["cd_perimetro"];
	}
	echo "<script>
	
	parent.nomeComodoD.value = '$nomeComodo';
	parent.tipoComodoD.value = '$tipoComodo';
	parent.largComodoD.value = '$larguraComodo'+'m';
	parent.compComodoD.value = '$comprimentoComodo'+'m';
	parent.areaComodoD.value = '$areaComodo'+'m²';
	parent.perimetroComodoD.value = '$perimetroComodo'+'m';
	parent.ComodosFunc.src = "";
	</script>";
	mysql_close($conexao);
?>