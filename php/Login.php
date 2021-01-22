<?php
	sleep(3);
	include ("Conexao.php");
	
	session_start();
	unset($_SESSION['EletronTech']);
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	
	$aux = 1;
	$email = mysql_escape_string($_POST['email']);
	$senha = mysql_escape_string($_POST['senha']);
	$senha = base64_encode($senha);
	$auxReativo = 0;
	$mensagem = 0;
	
	if (isset($_POST['continuar']))
	{
		$continuar = $_POST['continuar'];
	}
	else
	{
		$continuar = 0;
	}
	
	$users = mysql_query("select cd_pasta from tb_pasta where nm_caminho = 'Users' and cd_usuario is null and cd_subpasta is null");
	$result_users = mysql_fetch_array($users);
	$cdPastaUsers = $result_users['cd_pasta'];
	
	$verifica = mysql_query("select nm_email from tb_usuario where nm_email = '$email' and cd_senha = '$senha'") or die(mysql_error());
	
	if (mysql_num_rows($verifica) <= 0)
	{
		unset($_SESSION['EletronTech']);
		
		setcookie("EletronTech[email]", "", time()-3600, "/");
		setcookie("EletronTech[senha]", "", time()-3600, "/");
		
		$mensagem = 1;
	}
	else
	{
		if ($continuar == 1)
		{
			setcookie("EletronTech[email]", $email, time() + (86400 * 1), "/"); // 86400 = 1 day
			setcookie("EletronTech[senha]", $senha, time() + (86400 * 1), "/"); // 86400 = 1 day
		}
		
		$aux = mysql_query("select ic_confirmado,ic_ativado,dt_reativar from tb_usuario where nm_email = '$email'");
		
		$result = mysql_fetch_assoc($aux);
		
		$aux = mysql_query("select cd_usuario from tb_usuario where nm_email = '$email'");
			
		$codigo = mysql_fetch_array($aux);
		
		/*if ($result['ic_confirmado'] == 0)
		{
			$mensagem = 2;
			
			$aux = 0;
		}
		else */if ($result['ic_ativado'] == 0)
		{
			$dataReativar = $result['dt_reativar'];
			$dataAgora = date("Y-m-d H:i:s");
			$dataAgora = strtotime($dataAgora);
			$dataReativar = strtotime($dataReativar);
			$diasRestantes = ($dataReativar - $dataAgora)/86400;
			$diasRestantes = ceil($diasRestantes);
			
			if ($diasRestantes <= 0)
			{
				$aux = mysql_query("update tb_usuario set cd_cpf = null where nm_email = '$email'") or die(mysql_error());
				
				$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigo[0]'");
			
				$nmUsuario = mysql_fetch_array($aux);
				
				$acao = " teve sua conta desativa permanentemente.";
				
				$aux = mysql_query("select ic_admin from tb_usuario where cd_usuario = '$codigo[0]'");
				
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
				
				$query = mysql_query("insert into tb_atividade(cd_usuario, nm_usuario, ds_atividade, dt_atividade) values('$codigo[0]', '$nmUsuario[0]', '$descricao', now())") or die(mysql_error());
				
				$mensagem = 3;
				
				$aux = 0;
			}
			else
			{
				$aux = mysql_query("update tb_usuario set ic_ativado = 1, dt_reativar = null where nm_email = '$email'") or die(mysql_error());
				
				$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigo[0]'");
			
				$nmUsuario = mysql_fetch_array($aux);
				
				$acao = " reativou sua conta.";
				
				$aux = mysql_query("select ic_admin from tb_usuario where cd_usuario = '$codigo[0]'");
				
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
				
				$query = mysql_query("insert into tb_atividade(cd_usuario, nm_usuario, ds_atividade, dt_atividade) values('$codigo[0]', '$nmUsuario[0]', '$descricao', now())") or die(mysql_error());
				
				$aux = 1;
				
				$auxReativo = 1;
				
				$mensagem = 4;
			}
		}
		else
		{
			$aux = 1;
		}
		
		if ($aux == 1)
		{
			$aux = mysql_query("select nm_usuario from tb_usuario where nm_email = '$email'");
			
			$nome = mysql_fetch_array($aux);
			
			$_SESSION['EletronTech']['login'] = $nome[0];
			$_SESSION['EletronTech']['email'] = $email;
			$_SESSION['EletronTech']['senha'] = $senha;
			
			$aux = mysql_query("select cd_usuario from tb_usuario where nm_email = '$email'");
			
			$codigo = mysql_fetch_array($aux);
			$_SESSION['EletronTech']['codigo'] = $codigo[0];
			
			$aux = mysql_query("select ic_admin from tb_usuario where nm_email = '$email'");
			
			$admin = mysql_fetch_array($aux);
			$_SESSION['EletronTech']['admin'] = $admin[0];
			
			$auxpasta = '../Users/'.$codigo[0];
			$auxpastaimagem = '../Users/'.$codigo[0].'/imagem-perfil';
			
			$auxpastabanco = 'Users/'.$codigo[0];
			$auxpastaimagembanco = 'Users/'.$codigo[0].'/imagem-perfil';
			
			$auxnome = 'imagem-perfil';
			
			if(!file_exists($auxpasta))
			{
				$pasta = mkdir($auxpasta);
				$query = mysql_query("insert into tb_pasta(dt_data_criacao, nm_pasta, nm_caminho, cd_usuario, cd_subpasta) values(now(), '$codigo[0]', '$auxpastabanco', '$codigo[0]', '$result_users[0]')") or die(mysql_error());
				
				$aux = mysql_query("select cd_pasta from tb_pasta where cd_usuario = '$codigo[0]' and cd_subpasta = '$cdPastaUsers'") or die(mysql_error());
			
				$pastaRaiz = mysql_fetch_array($aux);
				$_SESSION['EletronTech']['pastaRaiz'] = $pastaRaiz[0];
				
				$pastaimagem = mkdir($auxpastaimagem);
				$query = mysql_query("insert into tb_pasta(dt_data_criacao, nm_pasta, nm_caminho, cd_subpasta, cd_usuario) values(now(), '$auxnome', '$auxpastaimagembanco', '$pastaRaiz[0]', '$codigo[0]')") or die(mysql_error());
			}
			else
			{
				$aux = mysql_query("select cd_pasta from tb_pasta where cd_usuario = '$codigo[0]' and cd_subpasta = '$cdPastaUsers'") or die(mysql_error());
			
				$pastaRaiz = mysql_fetch_array($aux);
				$_SESSION['EletronTech']['pastaRaiz'] = $pastaRaiz[0];
			}						
			
			if(!file_exists($auxpastaimagem))
			{
				$pastaimagem = mkdir($auxpastaimagem);
				$query = mysql_query("insert into tb_pasta(dt_data_criacao, nm_pasta, nm_caminho, cd_subpasta, cd_usuario) values(now(), '$auxnome', '$auxpastaimagembanco', '$pastaRaiz[0]', '$codigo[0]')") or die(mysql_error());
			}
			
			$auxpasta = '../Users/'.$codigo[0];
			$auxpastaimagem = '../Users/'.$codigo[0].'/imagem-capa';
			
			$auxpastabanco = 'Users/'.$codigo[0];
			$auxpastaimagembanco = 'Users/'.$codigo[0].'/imagem-capa';
			
			$auxnome = 'imagem-capa';
			
			if(!file_exists($auxpasta))
			{
				$pasta = mkdir($auxpasta);
				$query = mysql_query("insert into tb_pasta(dt_data_criacao, nm_pasta, nm_caminho, cd_usuario, cd_subpasta) values(now(), '$codigo[0]', '$auxpastabanco', '$codigo[0]', '$result_users[0]')") or die(mysql_error());
				
				$aux = mysql_query("select cd_pasta from tb_pasta where cd_usuario = '$codigo[0]' and cd_subpasta = '$cdPastaUsers'") or die(mysql_error());
			
				$pastaRaiz = mysql_fetch_array($aux);
				$_SESSION['EletronTech']['pastaRaiz'] = $pastaRaiz[0];
				
				$pastaimagem = mkdir($auxpastaimagem);
				$query = mysql_query("insert into tb_pasta(dt_data_criacao, nm_pasta, nm_caminho, cd_subpasta, cd_usuario) values(now(), '$auxnome', '$auxpastaimagembanco', '$pastaRaiz[0]', '$codigo[0]')") or die(mysql_error());
			}
			else
			{
				$aux = mysql_query("select cd_pasta from tb_pasta where cd_usuario = '$codigo[0]' and cd_subpasta = '$cdPastaUsers'") or die(mysql_error());
			
				$pastaRaiz = mysql_fetch_array($aux);
				$_SESSION['EletronTech']['pastaRaiz'] = $pastaRaiz[0];
			}
			
			if(!file_exists($auxpastaimagem))
			{
				$pastaimagem = mkdir($auxpastaimagem);
				$query = mysql_query("insert into tb_pasta(dt_data_criacao, nm_pasta, nm_caminho, cd_subpasta, cd_usuario) values(now(), '$auxnome', '$auxpastaimagembanco', '$pastaRaiz[0]', '$codigo[0]')") or die(mysql_error());
			}
			
			$auxpasta = '../Users/'.$codigo[0];
			$auxpastaimagem = '../Users/'.$codigo[0].'/et-eventos';
			
			$auxpastabanco = 'Users/'.$codigo[0];
			$auxpastaimagembanco = 'Users/'.$codigo[0].'/et-eventos';
			
			$auxnome = 'et-eventos';
			
			if(!file_exists($auxpasta))
			{
				$pasta = mkdir($auxpasta);
				$query = mysql_query("insert into tb_pasta(dt_data_criacao, nm_pasta, nm_caminho, cd_usuario, cd_subpasta) values(now(), '$codigo[0]', '$auxpastabanco', '$codigo[0]', '$result_users[0]')") or die(mysql_error());
				
				$aux = mysql_query("select cd_pasta from tb_pasta where cd_usuario = '$codigo[0]' and cd_subpasta = '$cdPastaUsers'") or die(mysql_error());
			
				$pastaRaiz = mysql_fetch_array($aux);
				$_SESSION['EletronTech']['pastaRaiz'] = $pastaRaiz[0];
				
				$pastaimagem = mkdir($auxpastaimagem);
				$query = mysql_query("insert into tb_pasta(dt_data_criacao, nm_pasta, nm_caminho, cd_subpasta, cd_usuario) values(now(), '$auxnome', '$auxpastaimagembanco', '$pastaRaiz[0]', '$codigo[0]')") or die(mysql_error());
			}
			else
			{
				$aux = mysql_query("select cd_pasta from tb_pasta where cd_usuario = '$codigo[0]' and cd_subpasta = '$cdPastaUsers'") or die(mysql_error());
			
				$pastaRaiz = mysql_fetch_array($aux);
				$_SESSION['EletronTech']['pastaRaiz'] = $pastaRaiz[0];
			}
			
			if(!file_exists($auxpastaimagem))
			{
				$pastaimagem = mkdir($auxpastaimagem);
				$query = mysql_query("insert into tb_pasta(dt_data_criacao, nm_pasta, nm_caminho, cd_subpasta, cd_usuario) values(now(), '$auxnome', '$auxpastaimagembanco', '$pastaRaiz[0]', '$codigo[0]')") or die(mysql_error());
			}
			
			$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigo[0]'") or die(mysql_error());
			
			$nmUsuario = mysql_fetch_array($aux);
			
			$acao = " realizou login.";
			
			$aux = mysql_query("select ic_admin from tb_usuario where cd_usuario = '$codigo[0]'") or die(mysql_error());
			
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
			
			$query = mysql_query("insert into tb_atividade(cd_usuario, nm_usuario, ds_atividade, dt_atividade) values('$codigo[0]', '$nmUsuario[0]', '$descricao', now())") or die(mysql_error());	

			$query = mysql_query("insert into tb_visita(dt_data, dt_datetime, cd_usuario) values(now(), now(), '$codigo[0]')");
			
			
			if ($auxReativo == 0)
			{
				/*
				if ($admin[0] == 0)
				{
					//setcookie("login",$email);
					header("Location: ../ET.php");
					//echo 'window.location.href = "../ET.php";';
				}
				else
				{
					//setcookie("login",$email);
					header("Location: ../et-admin");
					//echo 'window.location.href = "../et-admin";';
				}
				*/
				
				header("Location: ../StatusLogin.php");
			}
			else
			{
				//setcookie("login",$email);
			}
		}
		else
		{
			unset($_SESSION['EletronTech']);
			
			setcookie("EletronTech[email]", "", time()-3600, "/");
			setcookie("EletronTech[senha]", "", time()-3600, "/");
		}
	}
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel="shortcut icon" href="../imagens/logo/logo.ico" />
		<title>Entrando no EletronTech...</title>
		
		<style type="text/css">
		@import url("msg.css");
		</style>
	</head>
	<body>
		<div id="mensagem" align="center">
			<label id="lbl_mensagem">Aqui vai uma mensagem gerada com innerHTML</label></br>
			<input type="button" value="OK" id="btn_OK">
		</div>
		<iframe id="EnviarConfirmacao" name="EnviarConfirmacao" src="" style="display: none;">Navegador não suporta IFrame</iframe>
		<script>
			var auxRedireciona = 0;
			var auxReativo = 0;
			
			function exibirMensagem(redireciona)
			{
				mensagem.style.display = "inline-block";
				auxRedireciona = redireciona;
			}
			
			function mensagemOK()
			{
				mensagem.style.display = "none";
				
				if (auxRedireciona == 1)
				{
					auxRedireciona = 0;
					parent.location.href = "../Login.php";
				}
			}
			
			<?php
				if ($mensagem != 0)
				{
					if ($mensagem == 1)
					{
						echo '
							lbl_mensagem.innerHTML = "Login e/ou Senha Incorretos!";
							exibirMensagem(1);';
					}
					else if ($mensagem == 2)
					{
						echo '
							lbl_mensagem.innerHTML = "Email não confirmado! Clique <a href=\'EnviarConfirmacao.php?email='.base64_encode($email).'\' id=\'reenviar\' target=\'EnviarConfirmacao\'>aqui</a> para reenviar um email de confirmação para sua caixa de entrada ou clique no botão abaixo para voltar à página de login."; 
							exibirMensagem(1);
							reenviar.onclick = function()
							{
								btn_OK.disabled = true;
								lbl_mensagem.innerHTML = \'Aguarde...\';
							}';
					}
					else if ($mensagem == 3)
					{
						echo '
							lbl_mensagem.innerHTML = "O tempo para reativação da conta expirou, sua conta desativada permanentemente."; 
							exibirMensagem(1);';
					}
					else if ($mensagem == 4)
					{
						echo 'auxReativo = 1;';
						
						echo '
							lbl_mensagem.innerHTML = "Sua conta foi reativada!"; 
							exibirMensagem(0);';
					}
					else
					{}
				}
			?>
			
			function mensagemOKReativo()
			{
				/*
				if (<?php $auxquery = mysql_query("select ic_admin from tb_usuario where nm_email = '$email'"); $admin = mysql_fetch_array($auxquery); if ($admin[0] != "") {echo $admin[0];} else {echo 0;} ?> == 0)
				{
					window.location.href = "../ET.php";
				}
				else
				{
					window.location.href = "../et-admin";
				}
				*/
				
				window.location.href = "../StatusLogin.php";
			}
			
			btn_OK.onclick = function()
			{
				if (auxReativo == 0)
				{
					mensagemOK();
				}
				else
				{
					mensagemOKReativo();
				}
			}
			
							
							
		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>