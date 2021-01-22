<?php
	include "Conexao.php";
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	
	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );

	date_default_timezone_set( 'America/Sao_Paulo' );
	
	session_start();
	$codigo = $_SESSION['EletronTech']['codigo'];
	
	$icCustom = mysql_escape_string($_POST['icCustom']);
	
	$diasUso = mysql_escape_string($_POST['diasUso']);
	$timeDiasUso = 60*60*24*$diasUso;
	$dataInicio = strtotime(date("Y-m-d H:i:s"));
	$dataTermino = $dataInicio + $timeDiasUso;
	$dataTermino = date("Y-m-d H:i:s",$dataTermino);
	$dataInicio = date("Y-m-d H:i:s",$dataInicio);
	
	$cdPacote = mysql_escape_string($_POST['pacote']);
	
	$nmCustom = "Eletron Tech Custom Pack";
	$dsCustom = "O pacote Custom lhe oferece a possibilidade de escolher quais as ferramentas que você deseja utilizar, criando assim seu pacote personalizado.";
	$imCustom = "imagens/pacotes/custom.png";
	$imFundoCustom = "imagens/shop/custom.jpg";
	$nmCor = "gray";
	
	$query = "delete from usuario_pacote where cd_usuario = '$codigo'";
								
	$result_query = mysql_query($query) or die(mysql_error());
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
		<div id="mensagem" align="center">
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
					window.location.href = "../../ET.php";
				}					
			}
			
			btn_OK.onclick = function()
			{
				mensagemOK();
			}
			
			<?php				
				if ($icCustom == 0)
				{
					$query = "insert into usuario_pacote(cd_usuario, cd_pacote, qt_dias, dt_inicio, dt_termino) values
							  ('$codigo', '$cdPacote', '$diasUso', '$dataInicio', '$dataTermino')";
											
					$result_query = mysql_query($query) or die(mysql_error());
					
					$aux = mysql_query("select nm_pacote from tb_pacote where cd_pacote = '$cdPacote'");
						
					$nmPacote = mysql_fetch_array($aux);
					
					$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigo'");
						
					$nmUsuario = mysql_fetch_array($aux);
						
					$acao = ' comprou o pacote "'.$nmPacote[0].'" por '.$diasUso.' dia(s) ('.date("d/m/Y H:i:s", strtotime($dataInicio)).' ~ '.date("d/m/Y H:i:s", strtotime($dataTermino)).').';
					
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
					
					//header('location:../../Home.php');
					
					echo '
						lbl_mensagem.innerHTML = "Compra efetuada com sucesso!";
						exibirMensagem(1);';
				}
				else if ($icCustom == 1)
				{
					$query = "insert into tb_pacote(nm_pacote, im_pacote, ds_pacote, ic_custom, cd_usuario, im_fundo, nm_cor) values
							  ('$nmCustom', '$imCustom', '$dsCustom', '$icCustom', '$codigo', '$imFundoCustom', '$nmCor')";
											
					$result_query = mysql_query($query);
					
					$query_Busca = "select cd_pacote from tb_pacote where cd_usuario = '$codigo'";
											
					$result_Busca = mysql_query($query_Busca) or die(mysql_error());
					$linha_Busca = mysql_fetch_assoc($result_Busca);
					$totalLinha_Busca = mysql_num_rows($result_Busca);

					$cdPacote = $linha_Busca['cd_pacote'];
					
					$query = "delete from pacote_ferramenta where cd_pacote = '$cdPacote'";
											
					$result_query = mysql_query($query);
					
					$ferramentas = $_POST['ferramentas'];
					foreach($ferramentas as $cdFerramenta)
					{
						$query = "insert into pacote_ferramenta(cd_pacote, cd_ferramenta) values('$cdPacote', '$cdFerramenta')";
											
						$result_query = mysql_query($query) or die(mysql_error());
					}
					
					$query = "insert into usuario_pacote(cd_usuario, cd_pacote, qt_dias, dt_inicio, dt_termino) values
							  ('$codigo', '$cdPacote', '$diasUso', '$dataInicio', '$dataTermino')";
											
					$result_query = mysql_query($query) or die(mysql_error());
					
					$aux = mysql_query("select nm_pacote from tb_pacote where cd_pacote = '$cdPacote'");
						
					$nmPacote = mysql_fetch_array($aux);
					
					$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigo'");
						
					$nmUsuario = mysql_fetch_array($aux);
						
					$acao = ' comprou o pacote "'.$nmPacote[0].'" por '.$diasUso.' dia(s) ('.date("d/m/Y H:i:s", strtotime($dataInicio)).' ~ '.date("d/m/Y H:i:s", strtotime($dataTermino)).').';
					
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
					
					//header('location:../../Home.php');
					
					echo '
						lbl_mensagem.innerHTML = "Compra efetuada com sucesso!";
						exibirMensagem(1);';
				}
				
				$query_Busca = "select tb_usuario.nm_usuario as 'Usuário', tb_pacote.nm_pacote as 'Pacote', usuario_pacote.dt_inicio as 'Data de Início', usuario_pacote.dt_termino as 'Data de Término', usuario_pacote.qt_dias as 'Dias Restantes', tb_pacote.im_pacote as 'Imagem', tb_pacote.ds_pacote as 'Descrição', tb_pacote.cd_pacote as 'codigoPacote'
								  from tb_usuario inner join usuario_pacote
									on tb_usuario.cd_usuario = usuario_pacote.cd_usuario
									  inner join tb_pacote
										on usuario_pacote.cd_pacote = tb_pacote.cd_pacote
											where tb_usuario.cd_usuario = '$codigo'";
											
				$result_Busca = mysql_query($query_Busca) or die(mysql_error());
				$linha_Busca = mysql_fetch_assoc($result_Busca);
				$totalLinha_Busca = mysql_num_rows($result_Busca);
			?>
		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>