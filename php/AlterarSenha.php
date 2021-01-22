<?php
	include ("Conexao.php");
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	
	session_start();
	$codigo = $_SESSION['EletronTech']['codigo'];
	
	if ((!isset ($_SESSION['EletronTech']['login']) == true) and (!isset ($_SESSION['EletronTech']['senha']) == true)) 
	{ 
		header('location:Login.php');
	}
	
	if (!isset($_POST['senha']))
	{
		echo "<script> history.back(1); </script>";
		exit;
	}
	
	$senha = mysql_escape_string($_POST['senha']);
	$senha = base64_encode($senha);
	
	setcookie("senha", $senha, time() + (86400 * 1), "/"); // 86400 = 1 day
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Alterando a senha...</title>
	</head>
	<style type="text/css">
		@import url("msg.css");
		</style>
	<body>
		<div id="mensagem" align="center">
			<label id="lbl_mensagem">Aqui vai uma mensagem gerada com innerHTML</label></br>
			<input type="button" value="OK" id="btn_OK">
		</div>
		<script>
			var auxRedireciona = 0;
			
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
					history.back(1);
				}
				
			}
			
			btn_OK.onclick = function()
			{
				mensagemOK();
			}
			
			<?php
				$query = mysql_query("update tb_usuario set cd_senha = '$senha' where cd_usuario = '$codigo'");
	
				if ($query)
				{
					$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigo'");
						
					$nmUsuario = mysql_fetch_array($aux);
					
					$acao = " alterou a senha.";
					
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
					
					/*echo "<script language='javascript' type='text/javascript'>
							alert('Senha alterada com sucesso!');
							history.back(1);
						</script>";*/
					
					echo '
						lbl_mensagem.innerHTML = "Senha alterada com sucesso!";
						exibirMensagem(1);';
				}
				else
				{
					/*echo "<script language='javascript' type='text/javascript'>
							alert('Não foi possível alterar a senha.');
							history.back(1);</script>";*/
					
					echo '
						lbl_mensagem.innerHTML = "Não foi possível alterar a senha.";
						exibirMensagem(1);';
				}
			?>
		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>