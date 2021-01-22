<?php
	session_start();
	
	include "Conexao.php";
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	
	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );

	date_default_timezone_set( 'America/Sao_Paulo' );
	
	$codigo = mysql_escape_string($_GET['codigo']);
	$codigoAdmin = $_SESSION['EletronTech']['codigo'];
	
	$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigo'");
			
	$nome = mysql_fetch_array($aux);
	
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
	
	function ExcluiDir($Dir)
	{
    
		if ($dd = opendir($Dir)) 
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
		rmdir($Dir);
	}
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Atualizando dados do Eletron Tech...</title>
		<style>
			@import url("msg.css");
		</style>
	</head>
	<body>
		<div id="mensagem">
			<label id="lbl_avisosImagem"></label>
			<label id="lbl_mensagem">Aqui vai uma mensagem gerada com innerHTML</label><br/> 
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
					window.location.href = "../Administrativo.php";
				}					
			}
			
			btn_OK.onclick = function()
			{
				mensagemOK();
			}
			
			<?php				
				$query_Excluir = "update tb_visita set cd_usuario = null where cd_usuario = '$codigo'";
				$result_Excluir = mysql_query($query_Excluir) or die(mysql_error());
				
				$query_Excluir = "delete from usuario_pacote where cd_usuario = '$codigo'";
				$result_Excluir = mysql_query($query_Excluir) or die(mysql_error());
				
				$query_Excluir = "update tb_utilizacao set cd_usuario = null where cd_usuario = '$codigo'";
				$result_Excluir = mysql_query($query_Excluir) or die(mysql_error());
				
				$query_Excluir = "delete from tb_pasta where cd_usuario = '$codigo'";
				$result_Excluir = mysql_query($query_Excluir) or die(mysql_error());
				
				$query_Excluir = "update tb_atividade set cd_usuario = null where cd_usuario = '$codigo'";
				$result_Excluir = mysql_query($query_Excluir) or die(mysql_error());
				
				$query_Excluir = "delete from tb_evento where cd_usuario = '$codigo'";
				$result_Excluir = mysql_query($query_Excluir) or die(mysql_error());
				
				$query_Excluir = "delete from tb_usuario where cd_usuario = '$codigo'";
				$result_Excluir = mysql_query($query_Excluir) or die(mysql_error());
				
				$auxpasta = '../../Users/'.$codigo;
				$auxpastaimagem = '../../Users/'.$codigo.'/imagem-perfil';
				
				$aux = ExcluiDir($auxpasta);

				
				if ($result_Excluir)
				{
					/*echo "<script language='javascript' type='text/javascript'>
								alert('Usuário excluido com sucesso!');
								window.location.href='../Administrativo.php'
							</script>";*/
							
					$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigoAdmin'");
									
					$nmUsuario = mysql_fetch_array($aux);
						
					$acao = ' excluiu o usuário "'.$nome[0].'".';
					
					$aux = mysql_query("select ic_admin from tb_usuario where cd_usuario = '$codigoAdmin'");
						
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
					
					$query = mysql_query("insert into tb_atividade(cd_usuario, nm_usuario, ds_atividade, dt_atividade) values('$codigoAdmin', '$nmUsuario[0]', '$descricao', now())") or die(mysql_error());
					
					echo '
						lbl_mensagem.innerHTML = "Usuário excluido com sucesso!";
						exibirMensagem(1);';
				}
			?>
		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>