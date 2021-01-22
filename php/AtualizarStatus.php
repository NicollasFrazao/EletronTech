<?php
	session_start();
	
	if (isset($_SESSION['EletronTech']['login']))
	{
		include "Conexao.php";
		
		$codigo = $_SESSION['EletronTech']['codigo'];
		
		$query = "select nm_usuario from tb_usuario where cd_usuario = '$codigo'";
		$result = mysql_query($query);
		$linha = mysql_fetch_assoc($result);
		
		$nome = $linha['nm_usuario'];
		
		mysql_close($conexao);
		
		header("Content-type: application/xml; charset=utf-8");
		echo '<?xml version="1.0" encoding="UTF-8" ?>';
		
		echo '<nome id="nome">'.$nome.'</nome>';
	}
	else
	{
		exit();
	}
?>