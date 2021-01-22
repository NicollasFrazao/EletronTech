<?php
		include ("Conexao.php");
		
		mysql_set_charset('utf8');
		ini_set('default_charset','UTF-8');
		
		setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );

		date_default_timezone_set( 'America/Sao_Paulo' );
		
		$admin = 0;
		$ativado = 1;
		$nome = mysql_escape_string($_POST['nome']);
		$cpf = mysql_escape_string($_POST['cpf']);
		$datanas = mysql_escape_string($_POST['datanas']);
		$tipoTelefone1 = mysql_escape_string($_POST['tipo_telefone1']);
		$telefone1 = mysql_escape_string($_POST['telefone1']);
		
		if (isset($_POST['tipo_telefone2']))
		{
			$tipoTelefone2 = mysql_escape_string($_POST['tipo_telefone2']);
		}
		else
		{
			$tipoTelefone2 = 0;
		}
		
		if (isset($_POST['telefone2']))
		{
			$telefone2 = mysql_escape_string($_POST['telefone2']);
			$telefone2 = str_replace("(","",$telefone2);
			$telefone2 = str_replace(")","",$telefone2);
			$telefone2 = str_replace("-","",$telefone2);
			$telefone2 = str_replace(" ","",$telefone2);
		}
		else
		{
			$telefone2 = null;
		}
		
		$sexo = mysql_escape_string($_POST['sexo']);
		$email = mysql_escape_string($_POST['email']);
		$senha = mysql_escape_string($_POST['senha']);
		$senha = base64_encode($senha);
		
		$cpf = str_replace(".","",$cpf);
		$cpf = str_replace("-","",$cpf);
		
		$datanas = str_replace("/","",$datanas);
		
		$telefone1 = str_replace("(","",$telefone1);
		$telefone1 = str_replace(")","",$telefone1);
		$telefone1 = str_replace("-","",$telefone1);
		$telefone1 = str_replace(" ","",$telefone1);
		
		$dataAgora = date("Y-m-d H:i:s");
		$dataAgora = strtotime($dataAgora);
		$seteDias = 60*60*24*7;
		$dataSeteDias = $dataAgora + $seteDias;
		$dataSeteDias = date("Y-m-d H:i:s",$dataSeteDias);
?>

<html>
	<head>
		<title>Cadastrando Dados do Eletron Tech...</title>

		<style type="text/css">
		@import url("msg.css");
		</style>
	</head>
	<body>
		<div id="mensagem" align="center">
			<label id="lbl_mensagem">Aqui vai uma mensagem gerada com innerHTML</label></br>
			<input type="button" value="OK" id="btn_OK">
			<form id="Frm_Login" action="Login.php" method="POST">
				<input type="hidden" id="txt_usuario" name="email">
				<input type="hidden" id="txt_senha" name="senha">
			</form>
		</div>
		<div id="carregamento" style="display: none">
			<img src="../imagens/load.gif" style="display: none">
			<label style="display: none">Realizando Login</label>
		</div>
		<script type="text/javascript" src="script/Login.js"></script>
		<script type="text/javascript" src="script/Criptografia.js"></script>
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
					//Login();
					window.location.href = "../Login.php";
				}
				else
				{
					history.back(1);
				}
				
			}
			
			btn_OK.onclick = function()
			{
				mensagemOK();
			}
	
			<?php
				$query = mysql_query("insert into tb_usuario(nm_usuario, cd_cpf, cd_datanas, cd_tipo_telefone1, cd_telefone1, cd_tipo_telefone2, cd_telefone2, nm_sexo, nm_email, cd_senha, ic_admin, ic_ativado, dt_cadastro) values('$nome', '$cpf', '$datanas', '$tipoTelefone1', '$telefone1', '$tipoTelefone2', '$telefone2', '$sexo', '$email', '$senha', '$admin', '$ativado', now())");
				
				if ($query)
				{
					$query_Busca = "select cd_usuario from tb_usuario where nm_email = '$email'";
										
					$result_Busca = mysql_query($query_Busca) or die(mysql_error());
					$linha_Busca = mysql_fetch_assoc($result_Busca);
					$totalLinha_Busca = mysql_num_rows($result_Busca);
					
					$codigo = $linha_Busca['cd_usuario'];
					
					$query = mysql_query("insert into usuario_pacote(cd_usuario, cd_pacote, qt_dias, dt_inicio, dt_termino) values('$codigo', 1, 7, now(), '$dataSeteDias')");
					
					/*echo "<script language='javascript' type='text/javascript'>
							alert('Usuário cadastrado com sucesso!');
							window.location.href='../'
						</script>";*/
						
					$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigo'");
						
					$nmUsuario = mysql_fetch_array($aux);
					
					$acao = " cadastrou-se no EletronTech.";
					
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
					
					//include "EnviarConfirmacao.php";
						
					echo '
						txt_usuario.value = "'.$email.'";
						txt_senha.value = base64_decode("'.$senha.'");
						lbl_mensagem.innerHTML = "Usuário cadastrado com sucesso! Enviamos um e-mail de confirmação para sua caixa de entrada, confirme-o para acessar o sistem.";
						exibirMensagem(1);';
				}
				else
				{
					/*echo "<script language='javascript' type='text/javascript'>
							alert('Não foi possível cadastrar esse usuário, talvez o email ou CPF já estejam cadastrados.');
							history.back(1);</script>";*/
							
					echo '
						lbl_mensagem.innerHTML = "Não foi possível cadastrar esse usuário, talvez o email ou CPF já estejam cadastrados.";
						exibirMensagem(0);';
				}
			?>
		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>