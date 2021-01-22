<?php 
	ob_start();
	
	include "Conexao.php";
	
	session_start();
	
	$codigo = $_SESSION['EletronTech']['codigo'];
	
	$aux = 0;
	
	$arquivo = "../../".mysql_escape_string($_GET["arquivo"]);
	
	$pesquisa = mysql_escape_string($_GET["arquivo"]);
	
	$tipo = mysql_escape_string($_GET["tipo"]);
	
	if ($tipo == 1)
	{
		$directory = $arquivo; //diretorio para compactar
		$zipfile = mysql_escape_string($_GET['nomePasta']).'.zip'; // nome do zip gerado

		$filenames = array();
		function browse($dir) {
		global $filenames;
			if ($handle = opendir($dir)) {
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != ".." && is_file($dir.'/'.$file)) {
						$filenames[] = $dir.'/'.$file;
					}
					else if ($file != "." && $file != ".." && is_dir($dir.'/'.$file)) {
						browse($dir.'/'.$file);
					}
				}
				closedir($handle);
			}
			return $filenames;
		}

		browse($directory);
		// cria zip, adiciona arquivos...
		$zip = new ZipArchive();
		if ($zip->open($zipfile, ZIPARCHIVE::CREATE)!==TRUE) {
			exit("Não pode abrir: <$zipfile>\n");
		}

		$cont = 0;

		foreach ($filenames as $filename) 
		{
			$cont = $cont + 1;
		}

		if ($cont != 0)
		{
			foreach ($filenames as $filename) 
			{
				//echo "Arquivo adicionado: <b>" . $filename . "<br/></b>";
				$zip->addFile($filename,$filename);
			}

			//echo "Total de arquivos: <b>" . $zip->numFiles . "</b>\n";
			//echo "Status:" . $zip->status . "\n";
			$zip->close();
			
			rename($zipfile,"../../".mysql_escape_string($_GET['pastaAtual'])."/".$zipfile);
			$arquivo = "../../".mysql_escape_string($_GET['pastaAtual'])."/".$zipfile;
		}
		else
		{
			echo '<script> window.location.href = "'.$_SERVER['HTTP_REFERER'].'"; </script>';
			//header("Location: ".$_SERVER['HTTP_REFERER']."");
			exit;
		}
	}
	
	$testa = pathinfo($arquivo); 
	$bloqueados = array('php','html','htm'); 
	// caso a extensão seja diferente das citadas acima ele 
	// executa normalmente o script 
	
	if(!in_array($testa,$bloqueados))
	{ 
		if(isset($arquivo) && file_exists($arquivo))
		{
			switch(strtolower(substr(strrchr(basename($arquivo),"."),1)))
			{
				case "pdf": $tipo="application/pdf"; break;
				case "exe": $tipo="application/octet-stream"; break;
				case "zip": $tipo="application/zip"; $aux = 1;break;
				case "doc": $tipo="application/msword"; break;
				case "xls": $tipo="application/vnd.ms-excel"; break;
				case "ppt": $tipo="application/vnd.ms-powerpoint"; break;
				case "gif": $tipo="image/gif"; break;
				case "png": $tipo="image/png"; break;
				case "jpg": $tipo="image/jpg"; break;
				case "jpeg": $tipo="image/jpg"; break;
				case "txt": $tipo="text/plain"; break;
				case "mp3": $tipo="audio/mpeg"; break;
				case "php": // deixar vazio por seurança
				case "htm": // deixar vazio por seurança
				case "html": // deixar vazio por seurança
			}
		  
			if ($aux == 1)
			{
				if (headers_sent()) 
				{
					echo 'HTTP header already sent';
				} 
				else 
				{
					if (!is_file($arquivo)) 
					{
						header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
						echo 'File not found';
					} 
					else if (!is_readable($arquivo)) 
					{
						header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
						echo 'File not readable';
					} 
					else 
					{
						$aux = mysql_query("select cd_subpasta from tb_pasta where nm_caminho = '$pesquisa'");
						
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
							
							$aux = mysql_query("select nm_pasta from tb_pasta where cd_pasta = '$cdSubPasta[0]' and cd_usuario = '$codigo'");
							
							$nmSubPasta = mysql_fetch_array($aux);
						}
						
						$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigo'");
						
						$nmUsuario = mysql_fetch_array($aux);
							
						$acao = ' efetuou download da pasta "'.$_GET['nomePasta'].'" no diretório "'.$nmSubPasta[0].'".';
						
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
						
						header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
						header("Content-Type: application/zip");
						header("Content-Transfer-Encoding: Binary");
						header("Content-Length: ".filesize($arquivo));
						header("Content-Disposition: attachment; filename=\"".basename($arquivo)."\"");
						readfile($arquivo);
						$aux = unlink($arquivo);
						exit;
					}
				}
			}
			else
			{
				$aux = mysql_query("select cd_pasta from tb_arquivo where nm_caminho = '$pesquisa'");
						
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
					
					$aux = mysql_query("select nm_pasta from tb_pasta where cd_pasta = '$cdSubPasta[0]' and cd_usuario = '$codigo'");
					
					$nmSubPasta = mysql_fetch_array($aux);
				}
				
				$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigo'");
						
				$nmUsuario = mysql_fetch_array($aux);
					
				$acao = ' efetuou download do arquivo "'.basename($arquivo).'" no diretório "'.$nmSubPasta[0].'".';
				
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
				
				header("Content-Type: ".$tipo); // informa o tipo do arquivo ao navegador
				header("Content-Length: ".filesize($arquivo)); // informa o tamanho do arquivo ao navegador
				header("Content-Disposition: attachment; filename=".basename($arquivo)); // informa ao navegador que é tipo anexo e faz abrir a janela de download, tambem informa o nome do arquivo
				readfile($arquivo); // lê o arquivo
				//echo "<script> history.back(1); </script>";
				exit; // aborta pós-ações  
			}
		   
		}
	}
	else
	{
		echo "Erro!";
		exit;
	}
?>

<?php
	mysql_close($conexao);
?>