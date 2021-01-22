<?php
	include "php/Conexao.php";
	
	AbrirConexao("201.76.50.129", "anytech_admin", "anytech.all", "db_eletrontech");
	
	$query_Busca = "select * from tb_usuario";
			
	$result_Busca = mysql_query($query_Busca) or die(mysql_error());
	$linha_Busca = mysql_fetch_assoc($result_Busca);
	$totalLinha_Busca = mysql_num_rows($result_Busca);
	
	FecharConexao();
	
	echo $totalLinha_Busca;
?>