<?php
	include "Conexao.php";
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	
	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );

	date_default_timezone_set( 'America/Sao_Paulo' );
	
	session_start();
	$codigo = $_SESSION['EletronTech']['codigo'];
	
	if ((!isset ($_SESSION['EletronTech']['login']) == true) and (!isset ($_SESSION['EletronTech']['senha']) == true)) 
	{ 
		header('location:Login.php');
	}
	
	$nome = "Eventos_".date("d-m-Y H-i-s");
	
	$extensao = "txt";
	
	$auxpasta = "Users/".$codigo."/et-eventos";
				
	$caminho = $auxpasta.'/'.$nome.".$extensao";
				
	$query_Busca = "select * from tb_evento where cd_usuario = '$codigo' order by dt_evento";
			
	$result_Busca = mysql_query($query_Busca) or die(mysql_error());
	$linha_Busca = mysql_fetch_assoc($result_Busca);
	$totalLinha_Busca = mysql_num_rows($result_Busca);
	
	function TransformaMes($mes)
	{
		switch ($mes)
		{
			case 1:
			{
				$mes = 'Janeiro';
			}
			break;
			
			case 2:
			{
				$mes = 'Fevereiro';
			}
			break;
			
			case 3:
			{
				$mes = 'Março';
			}
			break;
			
			case 4:
			{
				$mes = 'Abril';
			}
			break;
			
			case 5:
			{
				$mes = 'Maio';
			}
			break;
			
			case 6:
			{
				$mes = 'Junho';
			}
			break;
			
			case 7:
			{
				$mes = 'Julho';
			}
			break;
			
			case 8:
			{
				$mes = 'Agosto';
			}
			break;
			
			case 9:
			{
				$mes = 'Setembro';
			}
			break;
			
			case 10:
			{
				$mes = 'Outubro';
			}
			break;
			
			case 11:
			{
				$mes = 'Novembro';
			}
			break;
			
			case 12:
			{
				$mes = 'Dezembro';
			}
			break;
		}
		return $mes;
	}
	
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Gerando Eventos do Eletron Tech...</title>
		<style>
			@import url("msg.css");
		</style>
	</head>
	<body>
		<input type="hidden" id="txt_caminho">
		<div id="mensagem">
			<label id="lbl_avisosImagem"></label>
			<label id="lbl_mensagem">Aqui vai uma mensagem gerada com innerHTML</label><br/> 
			<input type="button" value="Não" id="btn_Nao">
			<input type="button" value="Sim" id="btn_Sim">
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
					baixar.src = "BaixarEventos.php?arquivo=" + txt_caminho.value;
					//window.location.href = "BaixarLog.php?arquivo=" + txt_caminho.value;
					//sleep(2000);
					parent.eventos.src = parent.txt_urlEventos.value;
				}
				else
				{
					parent.eventos.src = parent.txt_urlEventos.value;
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
				
				$aux = mysql_query("select cd_pasta from tb_pasta where nm_caminho = 'Users/$codigo' and cd_usuario = '$codigo' and cd_subpasta = '$result_users[0]'");
				$result_pastaRaiz = mysql_fetch_array($aux);
				
				if(!file_exists("../".$auxpasta))
				{
					$pasta = mkdir("../".$auxpasta);
					
					$query = mysql_query("insert into tb_pasta(dt_data_criacao, nm_pasta, nm_caminho, cd_subpasta, cd_usuario) values(now(), 'et-eventos', '$auxpasta', '$result_pastaRaiz[0]', $codigo)");
				}
				
				$aux = mysql_query("select * from tb_pasta where nm_caminho = '$auxpasta' and cd_usuario = '$codigo' and cd_subpasta = '$result_pastaRaiz[0]'");
				$result = mysql_fetch_assoc($aux);
				$cdPasta = $result['cd_pasta'];
				
				$ponteiro = fopen('../'.$caminho, 'w');
				
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
				
				$mes = 0;
				
				do
				{
					if ($linha_Busca['nm_evento'] != "") 
					{
						if ($mes != date("m", strtotime($linha_Busca['dt_evento'])))
						{
							$mes = date("m", strtotime($linha_Busca['dt_evento']));
							
							$conteudo = $conteudo."--------- ".TransformaMes($mes)." ".date("Y", strtotime($linha_Busca['dt_evento'])).$quebra.$quebra;
							$conteudo = $conteudo."Nome do evento: ".$linha_Busca['nm_evento'].$quebra."Data do evento: ".date("d/m/Y", strtotime($linha_Busca['dt_evento'])).$quebra."Descrição do evento: ".$linha_Busca['ds_evento'].$quebra.$quebra;
						}
						else
						{
							$conteudo = $conteudo."Nome do evento: ".$linha_Busca['nm_evento'].$quebra."Data do evento: ".date("d/m/Y", strtotime($linha_Busca['dt_evento'])).$quebra."Descrição do evento: ".$linha_Busca['ds_evento'].$quebra.$quebra;
						}
					}
				}
				while ($linha_Busca = mysql_fetch_assoc($result_Busca));
				
				$escreve = fwrite($ponteiro, $conteudo);

				$nmArquivo = $nome.".".$extensao;

				$aux = mysql_query("insert into tb_arquivo(dt_data_criacao, nm_arquivo, nm_tipo, nm_caminho, cd_pasta) values(now(), '$nmArquivo', '$extensao', '$caminho', '$cdPasta')") or die(mysql_error());
				
				sleep(3);
				
				echo '
					lbl_mensagem.innerHTML = "Eventos gerados com sucesso! Deseja baixar?";
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