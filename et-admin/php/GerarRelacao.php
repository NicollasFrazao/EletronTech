<?php
	include "Conexao.php";
	
	include "../../pdf/mpdf.php";
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	
	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );

	date_default_timezone_set( 'America/Sao_Paulo' );
	
	session_start();
	$codigo = $_SESSION['EletronTech']['codigo'];
	
	$nomeLog = date("d-m-Y H-i-s");
	
	$extensao = "pdf";
	
	$auxpasta = "Users/Relacao de Usuarios";
				
	$caminho = $auxpasta.'/'.$nomeLog.".$extensao";
	
	if ($_GET['tipo'] != 0)
	{
		$tipo = mysql_escape_string($_GET['tipo']);
		$valorBusca = $_GET['valorBusca'];
	
		if ($_GET['tipo'] == 1)
		{
			$valorBusca = mysql_escape_string($_GET['valorBusca']);
		
			$query_Busca = "select * from tb_usuario 
								where nm_usuario like '%$valorBusca%'";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
			
		}
		else if ($_GET['tipo'] == 2)
		{
			$valorBusca = mysql_escape_string($_GET['valorBusca']);
		
			$query_Busca = "select * from tb_usuario 
								where cd_usuario like '$valorBusca'";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
		}
		else if ($_GET['tipo'] == 3)
		{
			$valorBusca = mysql_escape_string($_GET['valorBusca']);
		
			$query_Busca = "select * from tb_usuario 
								where nm_email like '%$valorBusca'%";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
		}
		else if ($_GET['tipo'] == 4)
		{
			$valorBusca = mysql_escape_string($_GET['valorBusca']);
		
			$query_Busca = "select * from tb_usuario 
								where cd_cpf like '%$valorBusca%'";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
		}
		
	}
	else
	{
		$query_Busca = "select * from tb_usuario";
			
		$result_Busca = mysql_query($query_Busca) or die(mysql_error());
		$linha_Busca = mysql_fetch_assoc($result_Busca);
		$totalLinha_Busca = mysql_num_rows($result_Busca);
	}
	
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Gerando Log do Eletron Tech...</title>
		<style>
			@import url("msg.css");
		</style>
	</head>
	<body>
		<input type="hidden" id="txt_caminho">
		<div id="mensagem">
			<label id="lbl_avisosImagem"></label>
			<label id="lbl_mensagem">Aqui vai uma mensagem gerada com innerHTML</label><br/> 
			<input type="button" value="Sim" id="btn_Sim">
			<input type="button" value="Não" id="btn_Nao">
		</div>
		<iframe id="baixar" style="display: none;">Iframe não suportado</iframe>
		<script>
			var auxRedireciona = 0;
			
			function exibirMensagem()
			{
				mensagem.style.display = "inline-block";
			}
			
			function mensagemOK()
			{
				mensagem.style.display = "none";
				
				if (auxRedireciona == 1)
				{
					auxRedireciona = 0;
					baixar.src = "BaixarRelacao.php?arquivo=" + txt_caminho.value;
					//sleep(2000);
					window.location.href = "../Administrativo.php";
				}
				else
				{
					window.location.href = "../Administrativo.php";
				}				
			}
			
			function sleep(milliseconds) 
			{
                var start = new Date().getTime();
                for (var i = 0; i < 1e7; i++) 
				{
                    if ((new Date().getTime() - start) > milliseconds)
					{
                        break;
                    }
                }
            }
			
			btn_Sim.onclick = function()
			{
				auxRedireciona = 1;
				mensagemOK();
			}
			
			btn_Nao.onclick = function()
			{
				auxRedireciona = 0;
				mensagemOK();
			}
			
			
			<?php				
				$users = mysql_query("select cd_pasta from tb_pasta where nm_caminho = 'Users' and cd_usuario is null and cd_subpasta is null");
				$result_users = mysql_fetch_array($users);
				
				if(!file_exists("../../".$auxpasta))
				{
					$pasta = mkdir("../../".$auxpasta);
					
					$query = mysql_query("insert into tb_pasta(dt_data_criacao, nm_pasta, nm_caminho, cd_subpasta) values(now(), 'Relacao de Usuarios', '$auxpasta', '$result_users[0]')");
				}
				
				$aux = mysql_query("select * from tb_pasta where nm_caminho = '$auxpasta' and cd_usuario is null and cd_subpasta = '$result_users[0]'");
				$result = mysql_fetch_assoc($aux);
				$cdPasta = $result['cd_pasta'];
				
				if ($_GET['tipo'] == 1)
				{
					$mensagem = 'EletronTech - Relação de usuários pesquisado por nome "'.$valorBusca.'"';
				}
				else if ($_GET['tipo'] == 2)
				{
					$mensagem = 'EletronTech - Relação de usuários pesquisado por código "'.$valorBusca.'"';
				}
				else if ($_GET['tipo'] == 3)
				{
					$mensagem = 'EletronTech - Relação de usuários pesquisado por email "'.$valorBusca.'"';
				}
				else if ($_GET['tipo'] == 4)
				{
					$mensagem = 'EletronTech - Relação de usuários pesquisado por CPF "'.$valorBusca.'"';
				}
				else
				{
					$mensagem = 'EletronTech - Relação de usuários de todos os usuários';
				}
				
				$html = 
					"<html>
						<body>
							<div id='barra'>
								<img src='../imagens/logoeletrontech.png' id='et'>
							</div>
							<br/>
							<h1 align='center'>$mensagem</h1><br/>";
						
				do
				{
					if ($linha_Busca['cd_usuario'] != "") 
					{
						/*$html = $html.$linha_Busca['ds_atividade'].'['.date("d/m/Y H:i:s", strtotime($linha_Busca['dt_atividade'])).']'."<br/><br/>";*/
						
						$nome = $linha_Busca['nm_usuario'];
						
						if ($linha_Busca['im_usuario'] == "") 
						{
							$imagem =  "../usuario.png";
						} 
						else 
						{
							$imagem = "../../".$linha_Busca['im_usuario'];
						}
						
						$cpf = $linha_Busca['cd_cpf'];
						$datanas = $linha_Busca['cd_datanas'];
						$telefone1 = $linha_Busca['cd_telefone1'];
						$telefone2 = $linha_Busca['cd_telefone2'];
						$sexo = $linha_Busca['nm_sexo'];
						$email = $linha_Busca['nm_email'];
						$senha = $linha_Busca['cd_senha'];
						$codigo = $linha_Busca['cd_usuario'];
						
						if ($linha_Busca['ic_admin'] == 1) 
						{
							$admin =  "Sim";
						}
						else 
						{
							$admin = "Não";
						}
						
						$html = $html."<div id='user'>
											<table>
											<br/>
												<h1>$nome</h1>
												
												<tr>
													
													<td rowspan='10'>
														<img id='imgUser' src='$imagem'>
													</td>
												</tr>
												<tr>
													<td>
														<label>Documento (CPF)</label>
													</td>
													<td>
														<label id='data'>$cpf</label>
													</td>
												</tr>
												
												<tr>
													<td>
														<label>Data de Nascimento</label>
													</td>
													<td>
														<label id='data'>$datanas</label>
													</td>
												</tr>
												
												<tr>
													<td>
														<label>Telefone</label>
													</td>
													<td>
														<label id='data'>$telefone1</label>
													</td>
												</tr>
												
												<tr>
													<td>
														<label>Telefone 2</label>
													</td>
													<td>
														<label id='data'>$telefone2</label>
													</td>
												</tr>
												
												<tr>
													<td>
														<label>Sexo</label>
													</td>
													<td>
														<label id='data'>$sexo</label>
													</td>
												</tr>
												
												<tr>
													<td>
														<label>Email</label>
													</td>
													<td>
														<label id='data'>$email</label>
													</td>
												</tr>
												
												<tr>
													<td>
														<label>Senha</label>
													</td>
													<td>
														<label id='data'>$senha</label>
													</td>
												</tr>
												
												<tr>
													<td>
														<label>Usuário/Administrador</label>
													</td>
													<td>
														<label id='data'>$admin</label>
													</td>
												</tr>
												<tr>
													<td>
														<label>Código de Usuário</label>
													</td>
													<td>
														 <label id='data'>$codigo</label>
													</td>
												</tr>												
											</table>
										</div>
										<br/>";
					}
				}
				while ($linha_Busca = mysql_fetch_assoc($result_Busca));
						
				$html = $html."
						<h5 align='center'>Ⓒ  Copyright - Todos Os Direitos Reservados a All Technology Systems</h5>	
						</body>
					</html>
					";
				//echo $html;	
				//$html = utf8_encode($html);
				
				$mpdf = new mPDF();
				
				$mpdf->allow_charset_conversion=true;
				// permite a conversao (opcional)
				$mpdf->charset_in='UTF-8';
				// converte todo o PDF para utf-8

				// carrega uma folha de estilo - MAGICA!!!
				$stylesheet = file_get_contents('estilosRelacaoPDF.css');
				// incorpora a folha de estilo ao PDF
				// O parâmetro 1 diz que este é um css/style e deverá ser interpretado como tal
				$mpdf->WriteHTML($stylesheet,1);
				
				/*$saida = 
				"<html>
					<body>
						<h1>MEU PRIMEIRO PDF</h1>
						<ul>
							<li>PHP</li>
							<li>HTML</li>
							<li>PDF</li>
						</ul>
						<h5><i>Mais em http://www.programatche.net</h5>
					</body>
				</html>
				";*/
				
				$mpdf->WriteHTML($html,2);
				/*
				 * F - salva o arquivo NO SERVIDOR
				 * I - abre no navegador E NÃO SALVA
				 * D - chama o prompt E SALVA NO CLIENTE
				 */
				
				$mpdf->Output("../../".$caminho, 'F');
				
				$nmArquivo = $nomeLog.".".$extensao;
				$aux = mysql_query("insert into tb_arquivo(dt_data_criacao, nm_arquivo, nm_tipo, nm_caminho, cd_pasta) values(now(), '$nmArquivo', '$extensao', '$caminho', '$cdPasta')");
				
				/*$ponteiro = fopen('../../'.$caminho, 'w');
				
				$conteudo = "";
				
				$quebra = "";
				
				switch (strtoupper(substr(PHP_OS, 0, 3))) 
				{
					// Windows
					case 'WIN':
					{
						$quebra = "\r\n";
					}
					break;

					// Mac
					case 'DAR':
					{
						$quebra = "\r";
					}
					break;

					// Unix
					default:
					{
						$quebra = "\n";
					}
				}
				
				
				do
				{
					if ($linha_Busca['ds_atividade'] != "") 
					{
						$conteudo = $conteudo.$linha_Busca['ds_atividade'].'['.date("d/m/Y H:i:s", strtotime($linha_Busca['dt_atividade'])).']'.$quebra.$quebra;
					}
				}
				while ($linha_Busca = mysql_fetch_assoc($result_Busca));
				
				$escreve = fwrite($ponteiro, $conteudo);*/
				
				sleep(3);
				
				echo '
					lbl_mensagem.innerHTML = "Registro gerado com sucesso! Deseja baixar?";
					exibirMensagem();
					txt_caminho.value = "'.$caminho.'";
					parent.painelArquivos.src = parent.txt_url.value;';
			?>
		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>