<?php
	session_start();
	
	include "Conexao.php";
	
	$codigo = $_SESSION['EletronTech']['codigo'];
	$tutorial = mysql_escape_string($_GET['tutorial']);
	
	$query = "update tb_usuario set ic_tutorial_desativado = '$tutorial' where cd_usuario = '$codigo'";
	$result = mysql_query($query) or die(mysql_error());
	
	mysql_close($conexao);
	
	echo "<script> parent.tutorial.src = ''; </script>";
?>