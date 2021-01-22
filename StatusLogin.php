<?php
	session_start();
	
	include "php/Conexao.php";
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	
	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );

	date_default_timezone_set( 'America/Sao_Paulo' );
	
	if((!isset ($_SESSION['EletronTech']['login']) == true) and (!isset ($_SESSION['EletronTech']['senha']) == true)) 
	{ 
		unset($_SESSION['EletronTech']);
		
		setcookie("email", "", time()-3600, "/");
		setcookie("senha", "", time()-3600, "/");
		
		header('location:Login.php'); 
	}
	
	$logado = $_SESSION['EletronTech']['login'];
	$email = $_SESSION['EletronTech']['email'];
	$admin = $_SESSION['EletronTech']['admin'];
	$codigo = $_SESSION['EletronTech']['codigo'];
	
	$IPRemoto = $_SERVER['REMOTE_ADDR'];
	$IPServidor = $_SERVER['SERVER_ADDR'];
	$Server = $_SERVER['SERVER_NAME'];
	$Navegador = $_SERVER['HTTP_USER_AGENT'];
	$Porta = $_SERVER['SERVER_PORT'];
	$PortaRemota = $_SERVER['REMOTE_PORT'];
	
	if (preg_match('|MSIE|',$Navegador))
	{
		$Nvgdr = 'IE';
	}

	else if (preg_match('|Opera|',$Navegador))
	{
		$Nvgdr = 'Opera';
	}
	else if (preg_match('|Firefox|',$Navegador))
	{
		$Nvgdr = 'Firefox';
	}
	else if (preg_match('|Chrome|',$Navegador))
	{
		$Nvgdr = 'Chrome';
	}
	else if (preg_match('|Safari|',$Navegador))
	{
		$Nvgdr = 'Safari';
	}
	else
	{   
		$Nvgdr_versao = 0;
		$Nvgdr= 'other';
	}
	
	if ($Nvgdr == 'Chrome')
	{
		$podeAbrir = 1;
		$aviso = "Navegador compatível com o sistema!";
	}
	else
	{
		$podeAbrir = 0;
		$aviso = "Navegador imcompatível com o sistema! Baixe o Google Chrome: <a href=\"http://www.google.com.br/chrome/browser/desktop/index.html#\">Clique aqui</a>";
	}
?>

<!Doctype>

<html>
	<head>
		<link rel="shortcut icon" href="imagens/logo/logo.ico" />
		<link rel="stylesheet" href="css/cssAbrirSistema.css" />
		<meta charset="utf-8">
		<title> EletronTech - Acesso ao Sistema </title>
		
		<style>
			
			#logC
			{
				color: white;
				font-size: 18px;
			}
			
			#userLog
			{
				
				font-size: 30px;
				font-weight: bold;
				color: #00b0f0;
			}
			
			#btn_abrir
			{
				display: inline-block;
				width: 100%;
				background-color: white;
				color: black;
				border: 0px solid transparent;
			}
			
			#btn_sair
			{
				display: inline-block;
				width: 100px;
				background-color: #00b0f0;
				color: white;
				border: 0px solid transparent;
			}
		</style>
	</head>
	<body>
		<div class="all">
			<div class="caixaAbrir">
				<div id="esquerda">
					<input type="image" id="im_logo" src="imagens/logo/logo.png">
				</div>
				
				<div id="direita">
					<!--<h1 id="m1">Logado com <label id="nome"></label></h1>
					<br/>
					<h1 id="m1"> Usuário <?php if ($admin == 0) {echo "Comum";} else {echo "Administrador";} ?> </h1>
					<br/>
					<h1 id="m1"> Clique no botão abaixo para abrir o sistema. </h1>
					<br/>-->
					
					
					<!--<p> Navegador: <?php echo $Nvgdr; ?></p>
					<br/>-->
					
					
					<table>
						<tr>
							<td colspan="2">
								<label id="logC">Logado como</label>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<label id="userLog"><?php echo $logado; ?></label>
							</td>
						</tr>
						<tr align="center">
							<td>
								<br><br>
								<input type="button" id="btn_abrir" value="Abrir Sistema">
							</td>
							<td>
								<br><br>
								<input type="button" id="btn_sair" value="Sair">
							</td>
						</tr>
						<tr>
							<td colspan="2">
							<br>
								<p style="color: <?php if ($podeAbrir == 1) {echo "green";} else {echo "red";} ?>;"> <?php echo $aviso; ?></p>
							</td>
						</tr>
					</table>
					
				</div>
			</div>
			
		</div>
		
		
	</body>
	<script src="script/ajax.js"></script>
	<script language="javascript">
		/*
		window.fechar = function()
		{
			this.close();
		}
		*/
		
		window.onload = function()
		{
			btn_abrir.click();
			VerificaSistemaAberto();
			VerificaNome();
		}
		
		function VerificaNome()
		{
			Ajax("GET", "php/AtualizarStatus.php", "", "userLog.textContent = this.responseXML.getElementById('nome').textContent;");
			
			setTimeout("VerificaNome();", 2000);
		}
		
		function AbrirSistema()
		{
			if (<?php echo $podeAbrir; ?> == 1)
			{
				if (<?php echo $admin; ?> == 0)
				{
					tela = window.open('ET.php', 'Sistema', 'width=' + screen.width + ', height=' + (screen.height - 100));
				}
				else
				{
					tela = window.open('et-admin/', 'Sistema', 'width=' + screen.width + ', height=' + (screen.height - 100));
				}
			}
			
			VerificaSistemaAberto();
		}
		
		function VerificaSistemaAberto()
		{
			if (tela.closed == true || tela.closed == undefined)
			{
				btn_abrir.disabled = false;
			}
			else
			{
				btn_abrir.disabled = true;
			}
			
			setTimeout("if (<?php echo $podeAbrir; ?> == 1) {VerificaSistemaAberto();} else {btn_abrir.disabled = true;}", 1000);
		}
		
		btn_abrir.onclick = function()
		{
			AbrirSistema();
		}
		
		btn_sair.onclick = function()
		{
			this.disabled = true;
			tela.close();
			window.location.href = "php/Sair.php";
		}
	</script>
</html>