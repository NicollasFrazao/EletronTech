<?php
	session_start();
	
	include "Conexao.php";
	
	$codigo = $_SESSION['EletronTech']['codigo'];
	
	$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigo'");
						
	$nmUsuario = mysql_fetch_array($aux);
		
	$acao = " realizou logout.";
	
	$aux = mysql_query("select ic_admin from tb_usuario where cd_usuario = '$codigo'");
		
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
	
	$query = mysql_query("insert into tb_atividade(cd_usuario, nm_usuario, ds_atividade, dt_atividade) values('$codigo', '$nmUsuario[0]', '$descricao', now())") or die(mysql_error());
	
	$query = mysql_query("update tb_usuario set ic_logado = 0 where cd_usuario = '$codigo'");
	
	setcookie("EletronTech[email]", "", time()-3600, "/");
	setcookie("EletronTech[senha]", "", time()-3600, "/");
	
	unset($_SESSION['EletronTech']);
	
	echo "<script> try {opener.location.reload();} catch(exe) {} if (!(this.close())) {window.location.href = 
	'../Login.php';} </script>";
	
	//header("Location: ../Login.php");
?>

<?php
	mysql_close($conexao);
?>