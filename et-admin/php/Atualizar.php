<?php
	session_start();
	
	include ("Conexao.php");
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );

	date_default_timezone_set( 'America/Sao_Paulo' );
	
	$codigo = mysql_escape_string($_POST['codigo']);
	$codigoAdmin = $_SESSION['EletronTech']['codigo'];
				
	$caminho = 'Users/'.$codigo.'/imagem-perfil/';
	$auxcaminho = 'Users/'.$codigo.'/imagem-perfil';
	$auxFoto = 0;
	
	$avisoImagem = "";
	$contAviso = 0;
	
	$query = mysql_query("select cd_pasta from tb_pasta where nm_caminho = '$auxcaminho'");
		
	$codigoPasta = mysql_fetch_array($query);
	
	$auxpasta = '../../Users/'.$codigo;
	$auxpastaimagem = '../../Users/'.$codigo.'/imagem-perfil';
			
	$_UP['pasta'] = '../../Users/'.$codigo.'/imagem-perfil/';
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
					history.back(1);
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
					$pastaimagem = mkdir($auxpastaimagem);
				}
				
				if(!file_exists($auxpastaimagem))
				{
					$pastaimagem = mkdir($auxpastaimagem);
				}
				
				$_UP['tamanho'] = 1024 * 1024 * 20; // 20MB
				$_UP['extensoes'] = array('jpg', 'jpeg', 'png');
				$_UP['renomeia'] = false;
				
				$_UP['erros'][0] = 'Não houve erro';
				$_UP['erros'][1] = 'O arquivo no upload é maior que o limite do PHP';
				$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especificado no HTML';
				$_UP['erros'][3] = 'O upload foi feito parcialmente';
				$_UP['erros'][4] = 'Não foi feito o upload do arquivo';
				
				if ($_FILES['foto']['error'] != 0 && $_FILES['foto']['error'] != 4)
				{
					$avisoImagem = $avisoImagem."- ".$_UP['erros'][$_FILES['foto']['error']]."\n";
					$contAviso = $contAviso + 1;
				}
				
				$extensao = strtolower(end(explode('.', $_FILES['foto']['name'])));
				
				if (array_search($extensao, $_UP['extensoes']) === false)
				{
					if ($_FILES['foto']['error'] != 0 && $_FILES['foto']['error'] != 4)
					{
						//echo '<script>alert ("Por favor, envie arquivos com as seguintes extensões: jpg, jpeg ou png.");</script>';
						
						/*echo '
							lbl_mensagem.innerHTML = "Por favor, envie arquivos com as seguintes extensões: jpg, jpeg ou png.";
							exibirMensagem(0);';*/
							
						$avisoImagem = $avisoImagem."<p>- Por favor, envie arquivos com as seguintes extensões: jpg, jpeg ou png.</p>";
						$contAviso = $contAviso + 1;
					}
					else if ($_FILES['foto']['error'] != 4)
					{
						//echo '<script>alert ("Por favor, envie arquivos com as seguintes extensões: jpg, jpeg ou png.");</script>';
						
						/*echo '
							lbl_mensagem.innerHTML = "Por favor, envie arquivos com as seguintes extensões: jpg, jpeg ou png.";
							exibirMensagem(0);';*/
						
						$avisoImagem = $avisoImagem."<p>- Por favor, envie arquivos com as seguintes extensões: jpg, jpeg ou png.</p>";
						$contAviso = $contAviso + 1;						
					}			
				}
				else if ($_UP['tamanho'] < $_FILES['foto']['size'])
				{
					//echo '<script>alert ("O arquivo enviado é muito grande, envie arquivos de até 20MB."); history.back(1);</script>';
					
					/*echo '
						lbl_mensagem.innerHTML = "O arquivo enviado é muito grande, envie arquivos de até 20MB.";
						exibirMensagem(0);';*/
						
					$avisoImagem = $avisoImagem."<p>- O arquivo enviado é muito grande, envie arquivos de até 20MB.</p>";
					$contAviso = $contAviso + 1;
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
						//echo '<script>alert("Upload feito com sucesso!");</script>';
						$auxFoto = 1;
						
						$auxcaminho = $auxcaminho . '/' . $nome_final;
						
						$query = mysql_query("insert into tb_arquivo(dt_data_criacao, nm_arquivo, nm_tipo, nm_caminho, cd_pasta) values(now(), '$nome_final', '$extensao', '$auxcaminho', '$codigoPasta[0]')");
						
						/*echo '
							lbl_mensagem.innerHTML = "Upload feito com sucesso!";
							exibirMensagem(0);';*/
						
						$avisoImagem = $avisoImagem."<p>- Upload feito com sucesso!</p>";
						$contAviso = $contAviso + 1;
					}
					else
					{
						if ($_FILES['foto']['error'] != 0 && $_FILES['foto']['error'] != 4)
						{
							//echo '<script>alert("Não foi possivel enviar o arquivo, tente novamente");</script>';
							
							/*echo '
								lbl_mensagem.innerHTML = "Não foi possivel enviar o arquivo, tente novamente";
								exibirMensagem(0);';*/
								
							$avisoImagem = $avisoImagem."<p>- Não foi possivel enviar o arquivo, tente novamente!</p>";
							$contAviso = $contAviso + 1;
						}
						$auxFoto = 0;
					}
				}
				
				if ($contAviso != 0)
				{
					echo 'lbl_avisosImagem.innerHTML = "Avisos sobre a imagem ('.$contAviso.'):'.$avisoImagem.'";';
				}
				
				if ($_FILES['foto']['name'] != "" && $auxFoto == 1)
				{
					$foto = $caminho . $nome_final;
				}
				
				
				$admin = $_POST['admin'];
				$nome = $_POST['nome'];
				//$cpf = $_POST['cpf'];
				//$datanas = $_POST['datanas'];
				$tipoTelefone1 = $_POST['tipo_telefone1'];
				$telefone1 = $_POST['telefone1'];
				
				if (isset($_POST['tipo_telefone2']))
				{
					$tipoTelefone2 = $_POST['tipo_telefone2'];
				}
				else
				{
					$tipoTelefone2 = 0;
				}
				
				if (isset($_POST['telefone2']))
				{
					$telefone2 = $_POST['telefone2'];
					$telefone2 = str_replace("(","",$telefone2);
					$telefone2 = str_replace(")","",$telefone2);
					$telefone2 = str_replace("-","",$telefone2);
					$telefone2 = str_replace(" ","",$telefone2);
				}
				else
				{
					$telefone2 = null;
				}
				
				$sexo = $_POST['sexo'];
				$email = $_POST['email'];
				
				if ($_POST['senha'] != "")
				{
					$senha = $_POST['senha'];
				}
				else
				{
					$senha = $_POST['senha_antiga'];
				}
				
				
				//$cpf = str_replace(".","",$cpf);
				//$cpf = str_replace("-","",$cpf);
				
				//$datanas = str_replace("/","",$datanas);
				
				$telefone1 = str_replace("(","",$telefone1);
				$telefone1 = str_replace(")","",$telefone1);
				$telefone1 = str_replace("-","",$telefone1);
				$telefone1 = str_replace(" ","",$telefone1);
				
				if ($_FILES['foto']['error'] == 0 && $auxFoto == 1)
				{
					/*$query = mysql_query("update tb_usuario set nm_usuario = '$nome', cd_cpf = '$cpf', cd_datanas = '$datanas', cd_tipo_telefone1 = '$tipoTelefone1', cd_telefone1 = '$telefone1', cd_tipo_telefone2 = '$tipoTelefone2', cd_telefone2 = '$telefone2', nm_sexo = '$sexo', ic_admin = '$admin', nm_email = '$email', cd_senha = '$senha', im_usuario = '$foto' where cd_usuario = '$codigo'");*/
					
					$query = mysql_query("update tb_usuario set nm_usuario = '$nome', cd_tipo_telefone1 = '$tipoTelefone1', cd_telefone1 = '$telefone1', cd_tipo_telefone2 = '$tipoTelefone2', cd_telefone2 = '$telefone2', nm_sexo = '$sexo', ic_admin = '$admin', nm_email = '$email', cd_senha = '$senha', im_usuario = '$foto' where cd_usuario = '$codigo'");
				}
				else
				{
					/*$query = mysql_query("update tb_usuario set nm_usuario = '$nome', cd_cpf = '$cpf', cd_datanas = '$datanas', cd_tipo_telefone1 = '$tipoTelefone1', cd_telefone1 = '$telefone1', cd_tipo_telefone2 = '$tipoTelefone2', cd_telefone2 = '$telefone2', nm_sexo = '$sexo', ic_admin = '$admin', nm_email = '$email', cd_senha = '$senha' where cd_usuario = '$codigo'");*/
					
					$query = mysql_query("update tb_usuario set nm_usuario = '$nome', cd_tipo_telefone1 = '$tipoTelefone1', cd_telefone1 = '$telefone1', cd_tipo_telefone2 = '$tipoTelefone2', cd_telefone2 = '$telefone2', nm_sexo = '$sexo', ic_admin = '$admin', nm_email = '$email', cd_senha = '$senha' where cd_usuario = '$codigo'");
				}
				
				if ($query)
				{
					/*echo "<script language='javascript' type='text/javascript'>
							alert('Usuário atualizado com sucesso!');
							history.back(1);
						</script>";*/
						
					$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigoAdmin'");
									
					$nmUsuario = mysql_fetch_array($aux);
						
					$acao = ' atualizou os dados do usuário "'.$nome.'".';
					
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
						lbl_mensagem.innerHTML = "Usuário atualizado com sucesso!";
						exibirMensagem(1);';
				}
				else
				{
					/*echo "<script language='javascript' type='text/javascript'>
							alert('Não foi possível atualizar os dados desse usuário, talvez o email ou CPF já estejam cadastrados.');
							history.back(1);</script>";*/
							
					echo '
						lbl_mensagem.innerHTML = "Não foi possível atualizar os dados desse usuário, talvez o email ou CPF já estejam cadastrados.";
						exibirMensagem(1);';
				}
			?>
		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>