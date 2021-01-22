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
	
	$auxpasta = "Users/Logs";
				
	$caminho = $auxpasta.'/'.$nomeLog.".$extensao";
				
	if ($_GET['tipo'] != 0)
	{
		$tipo = mysql_escape_string($_GET['tipo']);
		$valorBusca = $_GET['valorBusca'];
	
		if ($_GET['tipo'] == 1)
		{
			$valorBusca = mysql_escape_string($_GET['valorBusca']);
			
			$query_Busca = "select * from tb_atividade 
								where nm_usuario like '%$valorBusca%'
								order by dt_atividade desc";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
			
		}
		else if ($_GET['tipo'] == 2)
		{
			$valorBusca = mysql_escape_string($_GET['valorBusca']);
			
			$query_Busca = "select * from tb_atividade 
								where cd_usuario like '%$valorBusca%'
								order by dt_atividade desc";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);	
		}
		else  if ($_GET['tipo'] == 3)
		{
			
			$valorBusca = mysql_escape_string($_GET['valorBusca']);
			
			$query_Busca = "select * from tb_usuario inner join tb_atividade
								on tb_usuario.cd_usuario = tb_atividade.cd_usuario
									where tb_usuario.nm_email like '%$valorBusca%'
											order by dt_atividade desc;";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
		}
		else  if ($_GET['tipo'] == 4)
		{
			
			$valorBusca = mysql_escape_string($_GET['valorBusca']);
			
			$query_Busca = "select * from tb_usuario inner join tb_atividade
								on tb_usuario.cd_usuario = tb_atividade.cd_usuario
									where tb_usuario.cd_cpf like '%$valorBusca%'
											order by dt_atividade desc;";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
		}
		
	}
	else
	{
		$query_Busca = "select * from tb_atividade order by dt_atividade desc";
			
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
					baixar.src = "BaixarLog.php?arquivo=" + txt_caminho.value;
					//window.location.href = "BaixarLog.php?arquivo=" + txt_caminho.value;
					//sleep(2000);
					window.location.href = "../Atividade.php";
				}
				else
				{
					window.location.href = "../Atividade.php";
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
					
					$query = mysql_query("insert into tb_pasta(dt_data_criacao, nm_pasta, nm_caminho, cd_subpasta) values(now(), 'Logs', '$auxpasta', '$result_users[0]')");
				}
				
				$aux = mysql_query("select * from tb_pasta where nm_caminho = '$auxpasta' and cd_usuario is null and cd_subpasta = '$result_users[0]'");
				$result = mysql_fetch_assoc($aux);
				$cdPasta = $result['cd_pasta'];
				
				if ($_GET['tipo'] == 1)
				{
					$mensagem = 'EletronTech - Log de atividade pesquisado por nome "'.$valorBusca.'"';
				}
				else if ($_GET['tipo'] == 2)
				{
					$mensagem = 'EletronTech - Log de atividade pesquisado por código "'.$valorBusca.'"';
				}
				else if ($_GET['tipo'] == 3)
				{
					$mensagem = 'EletronTech - Log de atividade pesquisado por email "'.$valorBusca.'"';
				}
				else if ($_GET['tipo'] == 4)
				{
					$mensagem = 'EletronTech - Log de atividade pesquisado por CPF "'.$valorBusca.'"';
				}
				else
				{
					$mensagem = 'EletronTech - Log de atividade de todos os usuários';
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
					if ($linha_Busca['ds_atividade'] != "") 
					{
						$html = $html.$linha_Busca['ds_atividade'].'['.date("d/m/Y H:i:s", strtotime($linha_Busca['dt_atividade'])).']'."<br/><br/>";
					}
				}
				while ($linha_Busca = mysql_fetch_assoc($result_Busca));
						
				$html = $html."
							<br/>
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
				$stylesheet = file_get_contents('estilosLogsPDF.css');
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
					lbl_mensagem.innerHTML = "Log gerado com sucesso! Deseja baixar?";
					exibirMensagem();
					txt_caminho.value = "'.$caminho.'";
					parent.arquivos.src = parent.txt_url.value;';
			?>
		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>