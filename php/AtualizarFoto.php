<?php
	include ("Conexao.php");
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
		
	session_start();

	if ((!isset ($_SESSION['EletronTech']['login']) == true) and (!isset ($_SESSION['EletronTech']['senha']) == true)) 
	{ 
		header('location:Login.php');
	}
	
	$codigo = $_SESSION['EletronTech']['codigo'];
					
	$caminho = 'Users/'.$codigo.'/imagem-perfil/';
	$auxcaminho = 'Users/'.$codigo.'/imagem-perfil';
	$auxFoto = 0;
	
	$query = mysql_query("select cd_pasta from tb_pasta where nm_caminho = '$auxcaminho'");
		
	$codigoPasta = mysql_fetch_array($query);
	
	$auxpasta = '../Users/'.$codigo;
	$auxpastabanco = 'Users/'.$codigo;
	$auxpastaimagem = '../Users/'.$codigo.'/imagem-perfil';
	$auxnome = 'imagem-perfil';
	$pastaRaiz = $_SESSION['EletronTech']['pastaRaiz'];
			
	$_UP['pasta'] = '../Users/'.$codigo.'/imagem-perfil/';
	
	$users = mysql_query("select cd_pasta from tb_pasta where nm_caminho = 'Users' and cd_usuario is null and cd_subpasta is null");
	$result_users = mysql_fetch_array($users);
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Atualizando Foto...</title>
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
				if(!file_exists($auxpasta))
				{
					$pasta = mkdir($auxpasta);
					$query = mysql_query("insert into tb_pasta(dt_data_criacao, nm_pasta, nm_caminho, cd_usuario, cd_subpasta) values(now(), '$codigo[0]', '$auxpastabanco', '$codigo[0]', '$result_users[0]')");
					
					$pastaimagem = mkdir($auxpastaimagem);
					$query = mysql_query("insert into tb_pasta(dt_data_criacao, nm_pasta, nm_caminho, cd_subpasta, cd_usuario) values(now(), '$auxnome', '$auxcaminho', '$pastaRaiz', '$codigo')") or die(mysql_error());
				}
				
				if(!file_exists($auxpastaimagem))
				{
					$pastaimagem = mkdir($auxpastaimagem);
					$query = mysql_query("insert into tb_pasta(dt_data_criacao, nm_pasta, nm_caminho, cd_subpasta, cd_usuario) values(now(), '$auxnome', '$auxcaminho', '$pastaRaiz', '$codigo')") or die(mysql_error());
				}
				
				$query = mysql_query("select cd_pasta from tb_pasta where nm_caminho = '$auxcaminho'");
		
				$codigoPasta = mysql_fetch_array($query);
				
				if (isset($_FILES['foto']))
				{
					$_UP['tamanho'] = 1024 * 1024 * 20; // 20MB
					$_UP['extensoes'] = array('jpg', 'jpeg', 'png');
					$_UP['renomeia'] = false;
					
					$_UP['erros'][0] = 'Não houve erro';
					$_UP['erros'][1] = 'O arquivo no upload é maior que o limite do PHP';
					$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especificado no HTML';
					$_UP['erros'][3] = 'O upload foi feito parcialmente';
					$_UP['erros'][4] = 'Não foi feito o upload do arquivo';
					
					if ($_FILES['foto']['error'] != 0) //&& $_FILES['foto']['error'] != 4)
					{
						echo "Não foi possivel fazer o upload, erro: <br/>" . $_UP['erros'][$_FILES['foto']['error']];
					}
					
					$tmp = explode('.', $_FILES['foto']['name']);
					$extensao = strtolower(end($tmp));
					
					if (array_search($extensao, $_UP['extensoes']) === false)
					{
						if ($_FILES['foto']['error'] != 0) //&& $_FILES['foto']['error'] != 4)
						{
							//echo '<script>alert ("Por favor, envie arquivos com as seguintes extensões: jpg, jpeg ou png."); window.location.href = "../User.php";</script>';
							echo '
								lbl_mensagem.innerHTML = "Por favor, envie arquivos com as seguintes extensões: jpg, jpeg ou png.";
								exibirMensagem(1);';
						}
						else
						{
							//echo '<script>alert ("Por favor, envie arquivos com as seguintes extensões: jpg, jpeg ou png."); window.location.href = "../User.php";</script>';
							echo '
								lbl_mensagem.innerHTML = "Por favor, envie arquivos com as seguintes extensões: jpg, jpeg ou png."; 
								exibirMensagem(1);';
						}
						
					}
					else if ($_UP['tamanho'] < $_FILES['foto']['size'])
					{
						//echo '<script>alert ("O arquivo enviado é muito grande, envie arquivos de até 20MB."); window.location.href = "../User.php";</script>';
						echo '
							lbl_mensagem.innerHTML = "O arquivo enviado é muito grande, envie arquivos de até 20MB.";
							exibirMensagem(1);';
					}
					else
					{
						if ($_UP['renomeia'] == true)
						{
							$nome_final = time() . '.'.$extensao;
						}
						else
						{
							$nome_final = $_FILES['foto']['name'];
						}
						
						$nome_final = preg_replace( '/[´¨`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $nome_final ) );
						
						$query_Busca = "select nm_arquivo from tb_arquivo where cd_pasta = '$codigoPasta[0]' and nm_arquivo = '$nome_final'";
						
						$result_Busca = mysql_query($query_Busca) or die(mysql_error());
						$linha_Busca = mysql_fetch_assoc($result_Busca);
						$totalLinha_Busca = mysql_num_rows($result_Busca);
						
						if ($totalLinha_Busca > 0)
						{
							$nomeArquivoBanco = $linha_Busca['nm_arquivo'];
							$aux = strpos($nomeArquivoBanco, ")");
							if ($aux == "a")
							{
								echo "entro";
							}
							else
							{
								$contDiferente = 1;
								$aux = 0;
								$nomeArquivoBanco = explode(".", $nomeArquivoBanco);
								$tamanho = count($nomeArquivoBanco);
								
								
								do
								{
									$novoNome = "";
									$diferente = "($contDiferente).";
									
									for ($cont = 0; $cont <= $tamanho - 1; $cont = $cont + 1)
									{
										if ($cont == $tamanho - 1 - 1)
										{
											$novoNome = $novoNome . $nomeArquivoBanco[$cont] . $diferente;
										}
										else if ($cont == $tamanho - 1)
										{
											$novoNome = $novoNome . $nomeArquivoBanco[$cont];
										}
										else
										{
											$novoNome = $novoNome . $nomeArquivoBanco[$cont] . ".";
										}
										
									}
									
									$query_Busca = "select nm_arquivo from tb_arquivo where cd_pasta = '$codigoPasta[0]' and nm_arquivo = '$novoNome'";
						
									$result_Busca = mysql_query($query_Busca) or die(mysql_error());
									$linha_Busca = mysql_fetch_assoc($result_Busca);
									$totalLinha_Busca = mysql_num_rows($result_Busca);
									
									if ($totalLinha_Busca > 0)
									{
										$aux = 0;
									}
									else
									{
										$aux = 1;
									}
									
									$contDiferente = $contDiferente + 1;
								}
								while ($aux == 0);
								
								$nome_final = $novoNome;
							}
						}
						
						if (move_uploaded_file($_FILES['foto']['tmp_name'], $_UP['pasta'] . $nome_final))
						{
							//echo '<script>alert("Upload feito com sucesso!"); parent.favoritos.src="favoritos.php";</script>';
							$auxFoto = 1;
							
							$auxcaminho = $auxcaminho . '/' . $nome_final;
							
							$query = mysql_query("insert into tb_arquivo(dt_data_criacao, nm_arquivo, nm_tipo, nm_caminho, cd_pasta) values(now(), '$nome_final', '$extensao', '$auxcaminho', '$codigoPasta[0]')");
							
							$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigo'");
						
							$nmUsuario = mysql_fetch_array($aux);
							
							$acao = " atualizou a foto de perfil.";
							
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
							
							echo '
								lbl_mensagem.innerHTML = "Upload feito com sucesso!"; 
								parent.inicio.src = "Inicio.php";
								parent.arquivos.src = parent.txt_url.value;';
						}
						else
						{
							$auxFoto = 0;
							
							if ($_FILES['foto']['error'] != 0 && $_FILES['foto']['error'] != 4)
							{
								//echo '<script>alert("Não foi possivel enviar o arquivo, tente novamente"); window.location.href = "../User.php";</script>';
								echo '
									lbl_mensagem.innerHTML = "Não foi possivel enviar o arquivo, tente novamente"; 
									exibirMensagem(1);';
							}							
						}
						
						
					}
				
					if ($_FILES['foto']['name'] != "" && $auxFoto == 1)
					{
						$foto = $caminho . $nome_final;
					}
					
					if ($_FILES['foto']['error'] == 0 && $auxFoto == 1)
					{
						$query = mysql_query("update tb_usuario set im_usuario = '$foto' where cd_usuario = '$codigo'");
						//echo '<script>window.location.href = "../User.php";</script>';
						echo 'exibirMensagem(1);';
					}
				}
			?>
		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>