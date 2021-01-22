<?php
	$query = mysql_query("insert into tb_utilizacao(cd_ferramenta, cd_usuario, dt_utilizacao) values('$codigoFerramenta', '$codigoUsuario', now())") or die(mysql_error());
	
	$aux = mysql_query("select nm_ferramenta from tb_ferramenta where cd_ferramenta = '$codigoFerramenta'");
						
	$nmFerramenta = mysql_fetch_array($aux);
	
	$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigoUsuario'");
						
	$nmUsuario = mysql_fetch_array($aux);
		
	$acao = ' utilizou a ferramenta "'.$nmFerramenta[0].'".';
	
	$aux = mysql_query("select ic_admin from tb_usuario where cd_usuario = '$codigoUsuario'");
		
	$icUsuario = mysql_fetch_array($aux);
	
	if ($icUsuario[0] == 1)
	{
		$tipoUsuario = "[ADM]";
	}
	else
	{
		$tipoUsuario = "[USER]";
	}
	
	$descricao = $tipoUsuario." -- O usuário ".$nmUsuario[0].$acao;
	
	$query = mysql_query("insert into tb_atividade(cd_usuario, nm_usuario, ds_atividade, dt_atividade) values('$codigoUsuario', '$nmUsuario[0]', '$descricao', now())") or die(mysql_error());
?>