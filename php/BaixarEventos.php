<?php 
	ob_start();
	
	include "Conexao.php";
	
	session_start();
	
	if ((!isset ($_SESSION['EletronTech']['login']) == true) and (!isset ($_SESSION['EletronTech']['senha']) == true)) 
	{ 
		header('location:Login.php');
	}
	
	$codigo = $_SESSION['EletronTech']['codigo'];
	
	$caminhoArquivo = mysql_escape_string($_GET["arquivo"]);
	$arquivo = mysql_escape_string("../".$_GET["arquivo"]);
	
	$auxPesquisa = mysql_query("select * 
							from tb_pasta inner join tb_arquivo 
								on tb_pasta.cd_pasta = tb_arquivo.cd_pasta
									where tb_pasta.cd_usuario = '$codigo' and tb_arquivo.nm_caminho = '$caminhoArquivo'") or die(mysql_error());
	
	if (mysql_num_rows($auxPesquisa) <= 0)
	{
		exit;
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
		  
			
				
			header("Content-Type: ".$tipo); // informa o tipo do arquivo ao navegador
			header("Content-Length: ".filesize($arquivo)); // informa o tamanho do arquivo ao navegador
			header("Content-Disposition: attachment; filename=".basename($arquivo)); // informa ao navegador que é tipo anexo e faz abrir a janela de download, tambem informa o nome do arquivo
			readfile($arquivo); // lê o arquivo
			//echo "<script> history.back(1); </script>";
			//header("location:../Atividade.php");
			//sleep(3);
			
			exit; // aborta pós-ações  
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