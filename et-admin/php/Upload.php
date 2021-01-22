<?php
	include ("Conexao.php");
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
		
	session_start();
	
	$codigo = $_SESSION['EletronTech']['codigo'];
					
	$caminho = mysql_escape_string($_POST['pastaAtual'].'/');
	$auxcaminho = mysql_escape_string($_POST['pastaAtual']);
	$cdPastaAtual = mysql_escape_string($_POST['codigoPasta']);
	$url = mysql_escape_string($_POST['url']);
	
	$query = mysql_query("select cd_pasta from tb_pasta where nm_caminho = '$auxcaminho'");
		
	$codigoPasta = mysql_fetch_array($query);
	
	$_UP['pasta'] = '../../'.mysql_escape_string($_POST['pastaAtual']).'/';			
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Fazendo upload do arquivo...</title>
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
					window.location.href = "../<?php echo $url; ?>";
				}
				
			}
			
			btn_OK.onclick = function()
			{
				mensagemOK();
			}
			
			<?php
				if (isset($_FILES['arquivo']))
				{
					$_UP['tamanho'] = 1024 * 1024 * 20; // 20MB
					$_UP['extensoes'] = array('jpg', 'jpeg', 'png', 'pdf', 'doc', 'xls', 'ppt', 'txt', 'docx', 'xlsx', 'pptx',);
					$_UP['renomeia'] = false;		
					$_UP['erros'][0] = 'Não houve erro';
					$_UP['erros'][1] = 'O arquivo no upload é maior que o limite do PHP';
					$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especificado no HTML';
					$_UP['erros'][3] = 'O upload foi feito parcialmente';
					$_UP['erros'][4] = 'Não foi feito o upload do arquivo';
					
					if ($_FILES['arquivo']['error'] != 0 && $_FILES['arquivo']['error'] != 4)
					{
						echo "Não foi possivel fazer o upload, erro: <br/>" . $_UP['erros'][$_FILES['arquivo']['error']];
					}
					
					$tmp = explode('.', $_FILES['arquivo']['name']);
					$extensao = strtolower(end($tmp));
					
					if (array_search($extensao, $_UP['extensoes']) === false)
					{
						if ($_FILES['arquivo']['error'] != 0 && $_FILES['arquivo']['error'] != 4)
						{
							//echo '<script>alert ("Por favor, envie arquivos com as seguintes extensões: jpg, jpeg, png, pdf, doc, xls, ppt ou txt"); </script>';
							
							echo '
								lbl_mensagem.innerHTML = "Por favor, envie arquivos com as seguintes extensões: jpg, jpeg, png, pdf, doc, xls, ppt ou txt";
								exibirMensagem(1);';
						}
						else
						{
							//echo '<script>alert ("Por favor, envie arquivos com as seguintes extensões: jpg, jpeg, png, pdf, doc, xls, ppt ou txt"); </script>';
										
							echo '
								lbl_mensagem.innerHTML = "Por favor, envie arquivos com as seguintes extensões: jpg, jpeg, png, pdf, doc, xls, ppt ou txt";
								exibirMensagem(1);';
						}
						
					}
					else if ($_UP['tamanho'] < $_FILES['arquivo']['size'])
					{
						//echo '<script>alert ("O arquivo enviado é muito grande, envie arquivos de até 20MB.");</script>';
						
						echo '
							lbl_mensagem.innerHTML = "O arquivo enviado é muito grande, envie arquivos de até 20MB.";
							exibirMensagem(1);';
					}
					else
					{
						if ($_UP['renomeia'] == true)
						{
							$nome_final = time() . '.' . $extensao;
						}
						else
						{
							$nome_final = $_FILES['arquivo']['name'];
						}
						
						/*function remover_caracter($string) 
						{
							$string = preg_replace("/[áàâãä]/", "a", $string);
							$string = preg_replace("/[ÁÀÂÃÄ]/", "A", $string);
							$string = preg_replace("/[éèêë]/", "e", $string);
							$string = preg_replace("/[ÉÈÊË]/", "E", $string);
							$string = preg_replace("/[íìïî]/", "i", $string);
							$string = preg_replace("/[ÍÌÎÏ]/", "I", $string);
							$string = preg_replace("/[óòôõö]/", "o", $string);
							$string = preg_replace("/[ÓÒÔÕÖ]/", "O", $string);
							$string = preg_replace("/[úùüû]/", "u", $string);
							$string = preg_replace("/[ÚÙÜÜ]/", "U", $string);
							$string = str_replace('ç', "c", $string);
							$string = str_replace('Ç', "C", $string);
							$string = preg_replace("/[][><}{:;,!?*%~^`&#@]/", "", $string);
							$string = preg_replace("/ /", "_", $string);
							
							return $string;
						}
						
						$nome_final = remover_caracter($nome_final);*/
						
						
						//$nome_final = preg_replace( '/[´¨`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $nome_final ) );
						$nome_final =  strtr(utf8_decode($nome_final), utf8_decode('ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ'),'SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy');
						
						$query_Busca = "select nm_arquivo from tb_arquivo where cd_pasta = '$cdPastaAtual' and nm_arquivo = '$nome_final'";
						
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
									
									$query_Busca = "select nm_arquivo from tb_arquivo where cd_pasta = '$cdPastaAtual' and nm_arquivo = '$novoNome'";
						
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
						
						if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final))
						{
							//echo '<script>alert("Upload feito com sucesso!");</script>';
							$aux = 1;
							
							$auxcaminho = $auxcaminho . '/' . $nome_final;
							
							$query = mysql_query("insert into tb_arquivo(dt_data_criacao, nm_arquivo, nm_tipo, nm_caminho, cd_pasta) values(now(), '$nome_final', '$extensao', '$auxcaminho', '$codigoPasta[0]')");
							
							$aux = mysql_query("select cd_pasta from tb_arquivo where nm_caminho = '$auxcaminho'");
						
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
								
							$acao = ' efetuou upload do arquivo "'.$nome_final.'".';
							
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
								lbl_mensagem.innerHTML = "Upload realizado com sucesso!";
								exibirMensagem(1);';
						}
						else
						{
							if ($_FILES['arquivo']['error'] != 0 && $_FILES['arquivo']['error'] != 4)
							{
								//echo '<script>alert("Não foi possivel enviar o arquivo, tente novamente");</script>';
								
								echo '
									lbl_mensagem = "Não foi possivel enviar o arquivo, tente novamente";
									exibirMensagem(1);';
							}
							$aux = 0;
						}
						
						
					}
				
					/*if ($_FILES['arquivo']['name'] != "" && $aux == 1)
					{
						$foto = $caminho . $nome_final;
					}
					
					if ($_FILES['arquivo']['error'] == 0)
					{
						$query = mysql_query("update tb_usuario set im_usuario = '$foto' where cd_usuario = '$codigo'");
						echo '<script>window.location.href = "../User.php";</script>';
					}*/
				}
				
				
			?>
		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>