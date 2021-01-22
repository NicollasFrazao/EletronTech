<?php
	session_start();
	include "Conexao.php";
	
	if ((!isset ($_SESSION['EletronTech']['login']) == true) and (!isset ($_SESSION['EletronTech']['senha']) == true)) 
	{ 
		header('location:Login.php');
	}
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );

	date_default_timezone_set( 'America/Sao_Paulo' );
	
	$tipo = mysql_escape_string($_GET['tipo']);
	$nomeExcluirPasta = mysql_escape_string($_GET['excluirPasta']);
	$caminhoPastaAtual = mysql_escape_string($_GET['pastaAtual']);
	$codigoExcluirPasta = mysql_escape_string($_GET['codigoExcluirPasta']);
	$codigoUsuario = $_SESSION['EletronTech']['codigo'];
	$caminhoExcluirPasta = $caminhoPastaAtual . '/' . $nomeExcluirPasta;
	
	function ExcluiDir($Dir)
	{
    
		if ($dd = opendir($Dir)) 
		{
			if ($Arq = readdir($dd))
			{
				while (false !== ($Arq = readdir($dd))) 
				{
					if ($Arq != "." && $Arq != "..")
					{
						$Path = "$Dir/$Arq";
						
						if(is_dir($Path))
						{
							ExcluiDir($Path);
						}
						else if (is_file($Path))
						{
							unlink($Path);
						}
					}
				}
				closedir($dd);
			}
		}
		rmdir($Dir);
	}
	
	/*function ExcluiDir($path)
	{
		if (!is_dir($path)) {return false;}
		$stack = Array($path);
		while ($dir = array_pop($stack))
		{
			if (@rmdir($dir)) {continue;}
			$stack[] = $dir;
			$dh = opendir($dir);
			while (($child = readdir($dh)) !== false)
			{
				if ($child[0] == '.') {continue;}
				$child = $dir . DIRECTORY_SEPARATOR . $child;
				if (is_dir($child)) {$stack[] = $child;}
				else {unlink($child);}
			}
		}
	return true;
	}*/
?>

<html>
	<head>
	<meta charset="UTF-8">
		<title>Excluindo...</title>
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
				if ($tipo == 1)
				{
					$auxPesquisa = mysql_query("select * 
													from tb_pasta
														where tb_pasta.cd_usuario = '$codigoUsuario' and tb_pasta.nm_caminho = '$caminhoExcluirPasta'") or die(mysql_error());
				}
				else
				{
					$auxPesquisa = mysql_query("select * 
													from tb_pasta inner join tb_arquivo 
														on tb_pasta.cd_pasta = tb_arquivo.cd_pasta
															where tb_pasta.cd_usuario = '$codigoUsuario' and tb_arquivo.nm_caminho = '$caminhoExcluirPasta'") or die(mysql_error());		
				}	
				
				if (mysql_num_rows($auxPesquisa) <= 0)
				{
					echo '
						lbl_mensagem.innerHTML = "Arquivo não pertence à esse usuário!";
						exibirMensagem(1);';
				}
				else
				{
					if ($tipo == 1)
					{
						$aux = mysql_query("select cd_subpasta from tb_pasta where cd_pasta = '$codigoExcluirPasta'");
							
						$cdSubPasta = mysql_fetch_array($aux);
						
						$aux = mysql_query("select cd_pasta from tb_pasta where cd_subpasta is null and cd_usuario is null");
							
						$compara = mysql_fetch_array($aux);
						
						if ($cdSubPasta[0] == $compara[0])
						{
							$aux = mysql_query("select nm_pasta from tb_pasta where cd_pasta = '$cdSubPasta[0]' and cd_usuario is null");
							
							$nmSubPasta = mysql_fetch_array($aux);
						}
						else
						{
							
							$aux = mysql_query("select nm_pasta from tb_pasta where cd_pasta = '$cdSubPasta[0]' and cd_usuario = '$codigoUsuario'");
							
							$nmSubPasta = mysql_fetch_array($aux);
						}
						
						$query_Excluir = "delete from tb_pasta where cd_pasta = '$codigoExcluirPasta'";
						$result_Excluir = mysql_query($query_Excluir) or die(mysql_error());
						
						$aux = ExcluiDir("../" . $caminhoExcluirPasta);
						
						if ($result_Excluir)
						{
							$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigoUsuario'");
							
							$nmUsuario = mysql_fetch_array($aux);
								
							$acao = ' excluiu a pasta "'.$nomeExcluirPasta.'" no diretório "'.$nmSubPasta[0].'".';
							
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
								lbl_mensagem.innerHTML = "Pasta excluida com sucesso!";
								exibirMensagem(1);';
						}
					}
					else
					{
						$aux = mysql_query("select cd_pasta from tb_arquivo where cd_arquivo = '$codigoExcluirPasta'");
							
						$cdSubPasta = mysql_fetch_array($aux);
						
						$aux = mysql_query("select cd_pasta from tb_pasta where cd_subpasta is null and cd_usuario is null");
							
						$compara = mysql_fetch_array($aux);
						
						if ($cdSubPasta[0] == $compara[0])
						{
							$aux = mysql_query("select nm_pasta from tb_pasta where cd_pasta = '$cdSubPasta[0]' and cd_usuario is null");
							
							$nmSubPasta = mysql_fetch_array($aux);
						}
						else
						{
							
							$aux = mysql_query("select nm_pasta from tb_pasta where cd_pasta = '$cdSubPasta[0]' and cd_usuario = '$codigoUsuario'");
							
							$nmSubPasta = mysql_fetch_array($aux);
						}
						
						$query_Excluir = "delete from tb_arquivo where cd_arquivo = '$codigoExcluirPasta'";
						$result_Excluir = mysql_query($query_Excluir) or die(mysql_error());
						
						$aux = unlink("../" . $caminhoExcluirPasta);
						
						if ($result_Excluir)
						{
							$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigoUsuario'");
							
							$nmUsuario = mysql_fetch_array($aux);
								
							$acao = ' excluiu o arquivo "'.$nomeExcluirPasta.'" no diretório "'.$nmSubPasta[0].'".';
							
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
								lbl_mensagem.innerHTML = "Arquivo excluido com sucesso!";
								exibirMensagem(1);';
						}
					}
				}
			?>
		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>