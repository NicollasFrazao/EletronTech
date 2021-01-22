<?php
	//Esse é o código pra usar o db_eletrontech
	session_start(); //Ativa Sessão
	
	include "Conexao.php";
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	
	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );

	date_default_timezone_set( 'America/Sao_Paulo' );
	//Termina aqui
	
	if((!isset ($_SESSION['EletronTech']['login']) == true) and (!isset ($_SESSION['EletronTech']['senha']) == true)) 
	{ 
		unset($_SESSION['EletronTech']); 
		header('location:../Login.php'); 
	}//Verificar sessão
	
	$codigoUsuario = $_SESSION['EletronTech']['codigo']; //Isso que eu falei sobre sessão

	
	if(empty($_POST['data']) || empty($_POST['descricao']) || empty($_POST['evento']))
	{
		header('Location: agenda_ET.php');
		exit;
	} 
	else
	{
		$data = mysql_escape_string($_POST['data']);
		$descricao = mysql_escape_string($_POST['descricao']);
		$evento = mysql_escape_string($_POST['evento']);
		
		/*$replace = str_replace("/","-",$data);
		$split = explode("-",$replace);
		$data = $split[2].'-'.$split[1].'-'.$split[0];*/
		
		
		$sql = mysql_query("insert into tb_evento (dt_evento,ds_evento,nm_evento, cd_usuario, tm_evento) values('$data','$descricao','$evento', '$codigoUsuario', '00:00:00')") or die(mysql_error());
		
		$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigoUsuario'");
			
		$nmUsuario = mysql_fetch_array($aux);
		
		$acao = ' criou um evento "'.$evento.'" para a data "'.$data.'".';
		
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

		sleep(1);
		
		if ($sql)
		{
			echo '<script>
					parent.lbl_mensagem.innerHTML = "Evento cadastrado com sucesso!";
					parent.mensagem.style.display = "inline-block";
					parent.all.style.display = "none";
				 </script>';
		}
		else
		{
			echo '<script>
					parent.lbl_mensagem.innerHTML = "Erro ao cadastrar o evento!";
					parent.mensagem.style.display = "inline-block";
					parent.all.style.display = "none";
				 </script>';
		}
	}

	mysql_close($conexao);
?>

