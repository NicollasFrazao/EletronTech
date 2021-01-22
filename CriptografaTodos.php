<?php
	include "php/Conexao.php";
	
	$query_Busca = "select cd_usuario, cd_senha from tb_usuario";
				
	$result_Busca = mysql_query($query_Busca) or die(mysql_error());
	$linha_Busca = mysql_fetch_assoc($result_Busca);
	$totalLinha_Busca = mysql_num_rows($result_Busca);
	
	do
	{
		if ($linha_Busca['cd_senha'] != "")
		{
			$cdUsuario = $linha_Busca['cd_usuario'];
			$cripSenha = base64_encode($linha_Busca['cd_senha']);
			
			echo $cdUsuario." ".$cripSenha."<br/>";
		
			$aux = mysql_query("update tb_usuario set cd_senha = '$cripSenha' where cd_usuario = '$cdUsuario'") or die(mysql_error());
		}
	}
	while ($linha_Busca = mysql_fetch_array($result_Busca));
	
	//$cripSenha = base64_encode("1391796392");
	//$aux = mysql_query("update tb_usuario set cd_senha = '$cripSenha' where cd_usuario = '1'") or die(mysql_error());
?>