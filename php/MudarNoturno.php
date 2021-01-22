<?php
	session_start();
	
	include "Conexao.php";
	
	$codigo = $_SESSION['EletronTech']['codigo'];
	$noturno = mysql_escape_string($_GET['noturno']);
	
	$query = "update tb_usuario set ic_noturno = '$noturno' where cd_usuario = '$codigo'";
	$result = mysql_query($query) or die(mysql_error());
	
	mysql_close($conexao);
	
	echo "<script> parent.noturno.src = ''; </script>";
?>