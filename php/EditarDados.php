<?php
	session_start();
	include ("Conexao.php");
	
	if ((!isset ($_SESSION['EletronTech']['login']) == true) and (!isset ($_SESSION['EletronTech']['senha']) == true)) 
	{ 
		header('location:Login.php');
	}
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );

	date_default_timezone_set( 'America/Sao_Paulo' );
	
	$codigoSessao = $_SESSION['EletronTech']['codigo'];
	$codigo = mysql_escape_string($_POST['codigo']);
	
	if ($codigo != $codigoSessao)
	{
		echo "<script> history.back(1); </script>";
		exit;
	}
	
	$nome = mysql_escape_string($_POST['nome']);
	//$cpf = mysql_escape_string($_POST['cpf']);
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
	
	//$email = mysql_escape_string($_POST['email']);		
	
	//$cpf = str_replace(".","",$cpf);
	//$cpf = str_replace("-","",$cpf);
	
	$datanas = str_replace("/","",$datanas);
	
	$telefone1 = str_replace("(","",$telefone1);
	$telefone1 = str_replace(")","",$telefone1);
	$telefone1 = str_replace("-","",$telefone1);
	$telefone1 = str_replace(" ","",$telefone1);
?>

<html>
	<head>
	<meta charset="UTF-8">
		<title>Atualizando Dados do Eletron Tech...</title>
		<style type="text/css">
		@import url("msg.css");
		</style>
	</head>
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
					window.location.href = "../Perfil.php";
				}
			}
			
			btn_OK.onclick = function()
			{
				mensagemOK();
			}
			
			<?php
				$query = mysql_query("update tb_usuario set nm_usuario = '$nome', cd_tipo_telefone1 = '$tipoTelefone1', cd_telefone1 = '$telefone1', cd_tipo_telefone2 = '$tipoTelefone2', cd_telefone2 = '$telefone2', cd_datanas = '$datanas' where cd_usuario = '$codigo'");
				
				$_SESSION['EletronTech']['login'] = $nome;
				
				if ($query)
				{
					$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigo'");
						
					$nmUsuario = mysql_fetch_array($aux);
						
					$acao = " atualizou seus dados cadastrais.";
					
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
					
					echo 'parent.inicio.src = "Inicio.php"; parent.arquivos.src = parent.arquivos.src;';
					
					echo '
						lbl_mensagem.innerHTML = "Usuário atualizado com sucesso!";
						exibirMensagem(1);';
				}
				else
				{
					echo '
						lbl_mensagem.innerHTML = "Não foi possível atualizar seus dados, talvez o email já esteja cadastrado.";
						exibirMensagem(1);';
				}
			?>
		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>