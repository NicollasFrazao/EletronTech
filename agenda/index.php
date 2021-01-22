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
	$nmUsuario = $_SESSION['EletronTech']['login'];
?>



<!doctype html>
 <html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="estilo.index.css">
	</head>
	<body>
		<div id="logo">
			<img src="logo.png">
		</div>
		
		<div id="botao1">
			 <a href="agenda_ET.php" class="botao">Cadastrar</a>
		</div>
		
		<div id="botao2">
			 <a href="verificar.php" class="botao">Verificar</a>
		</div>
	
	</body>
	<script>
	document.onkeydown = KeyCheck;
	function KeyCheck()
	{
	   var KeyID = event.keyCode;
	   switch(KeyID)
	   {
		  case 38:
			//parent.ativarMenu();
			parent.mensagensOPT.click();
			parent.mensagens.focus();
		  break; 
		  case 40:
			//parent.ativarMenu();
			parent.licencaOPT.click();
			parent.licenca.focus();
			
		  break;
		  default:
		  break;
	   }
	}
	</script>
</html>


