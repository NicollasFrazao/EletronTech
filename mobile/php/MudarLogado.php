<?php
	include "Conexao.php";
	
	session_start();
	
	$codigo = $_SESSION['EletronTech']['codigo'];
	
	$query = mysql_query("update tb_usuario set ic_logado = 1 where cd_usuario = '$codigo'");

	mysql_close($conexao);
	
	echo "<script> parent.logado.src = ''; </script>";
?>