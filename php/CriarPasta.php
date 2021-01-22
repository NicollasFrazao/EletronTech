<?php
	session_start();
	include "Conexao.php";
	
	if ((!isset ($_SESSION['EletronTech']['login']) == true) and (!isset ($_SESSION['EletronTech']['senha']) == true)) 
	{ 
		header('location:Login.php');
	}
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	
	sleep(3);
	$nomeNovaPasta = mysql_escape_string($_GET['novaPasta']);
	
	$nomeNovaPasta =  strtr(utf8_decode($nomeNovaPasta), utf8_decode('ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ'),'SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy');
	
	$caminhoPastaAtual = mysql_escape_string($_GET['pastaAtual']);
	$codigoPastaAtual = mysql_escape_string($_GET['codigoPasta']);
	$codigoUsuario = $_SESSION['EletronTech']['codigo'];
	$caminhoNovaPasta = $caminhoPastaAtual . '/' . $nomeNovaPasta;
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Criando pasta...</title>
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
					history.back(1);
				}					
			}
			
			btn_OK.onclick = function()
			{
				mensagemOK();
			}

			<?php
				$aux = mysql_query("select nm_pasta from tb_pasta where nm_pasta = '$nomeNovaPasta' and cd_subpasta = '$codigoPastaAtual'");
			
				$nomeRepitido = mysql_fetch_array($aux);
				
				if ($nomeRepitido[0] == "")
				{
					$cdSubPasta = $codigoPastaAtual;
					
					$aux = mysql_query("select cd_pasta from tb_pasta where cd_subpasta is null and cd_usuario is null");
						
					$compara = mysql_fetch_array($aux);
					
					if ($cdSubPasta[0] == $compara[0])
					{
						$aux = mysql_query("select nm_pasta from tb_pasta where cd_pasta = '$cdSubPasta' and cd_usuario is null");
						
						$nmSubPasta = mysql_fetch_array($aux);
					}
					else
					{
						
						$aux = mysql_query("select nm_pasta from tb_pasta where cd_pasta = '$cdSubPasta' and cd_usuario = '$codigoUsuario'");
						
						$nmSubPasta = mysql_fetch_array($aux);
					}
					
					$query = mysql_query("insert into tb_pasta(dt_data_criacao, nm_pasta, nm_caminho, cd_subpasta, cd_usuario) values(now(), '$nomeNovaPasta', '$caminhoNovaPasta', '$codigoPastaAtual', '$codigoUsuario')") or die(mysql_error());
					
					if (!$query)
					{
						echo '
							lbl_mensagem.innerHTML = "Já existe uma pasta com o mesmo nome, por favor digite outro";
							exibirMensagem(1);';
						exit;
					}
					
					$pasta = mkdir("../" . $caminhoNovaPasta);
					
					$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigoUsuario'");
						
					$nmUsuario = mysql_fetch_array($aux);
					
					$acao = ' criou a pasta "'.$nomeNovaPasta.'" no diretório "'.$nmSubPasta[0].'".';
					
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
					
					echo '
						lbl_mensagem.innerHTML = "Pasta criada com sucesso!";
						exibirMensagem(1);';
				}
				else
				{
					echo '
						lbl_mensagem.innerHTML = "Já existe uma pasta com o mesmo nome, por favor digite outro";
						exibirMensagem(1);';
				}
			?>
		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>