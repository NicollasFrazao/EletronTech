<?php
	session_start();
	include "Conexao.php";
	
	if ((!isset ($_SESSION['EletronTech']['login']) == true) and (!isset ($_SESSION['EletronTech']['senha']) == true)) 
	{ 
		header('location:Login.php');
	}
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );

	date_default_timezone_set( 'America/Sao_Paulo' );
	
	$codigoUsuario = $_SESSION['EletronTech']['codigo'];
	
	$cdEvento = mysql_escape_string($_GET['cdEvento']);
?>

<html>
	<head>
	<meta charset="UTF-8">
		<title>Excluindo...</title>
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
					history.back(1);
				}
			}
			
			btn_OK.onclick = function()
			{
				mensagemOK();
			}
			
			<?php
				$aux = mysql_query("select * from tb_evento where cd_usuario = '$codigoUsuario' and cd_evento = '$cdEvento'");
				
				if (mysql_num_rows($aux) <= 0)
				{
					echo '
						lbl_mensagem.innerHTML = "Evento não pertence à esse usuário!";
						exibirMensagem(1);';
				}
				else
				{
					$aux = mysql_query("select nm_evento from tb_evento where cd_evento = '$cdEvento'");
					$nomeEvento = mysql_fetch_array($aux);
					
					$aux = mysql_query("select dt_evento from tb_evento where cd_evento = '$cdEvento'");
					$dataEvento = mysql_fetch_array($aux);
					
					$query_Excluir = "delete from tb_evento where cd_evento = '$cdEvento'";
					$result_Excluir = mysql_query($query_Excluir) or die(mysql_error());
						
					if ($result_Excluir)
					{
						$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigoUsuario'");
						
						$nmUsuario = mysql_fetch_array($aux);
							
						$acao = ' excluiu o evento "'.$nomeEvento[0].'", na data "'.date("d/m/Y", strtotime($dataEvento[0])).'".';
						
						$aux = mysql_query("select ic_admin from tb_usuario where cd_usuario = '$codigoUsuario'");
							
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
						
						$query = mysql_query("insert into tb_atividade(cd_usuario, nm_usuario, ds_atividade, dt_atividade) values('$codigoUsuario', '$nmUsuario[0]', '$descricao', now())") or die(mysql_error());
						
						echo '
							lbl_mensagem.innerHTML = "Evento excluido com sucesso!";
							parent.inicio.src = parent.inicio.src;
							parent.perfil.src = parent.perfil.src;
							exibirMensagem(1);';
					}
				}
			?>
		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>