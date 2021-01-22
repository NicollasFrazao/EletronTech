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
	
	$cdEvento = mysql_escape_string($_POST['cdEvento']);
	$nome = mysql_escape_string($_POST['evento']);
	$data = mysql_escape_string($_POST['data']);
	$descricao = mysql_escape_string($_POST['descricao']);
	
	/*$replace = str_replace("/","-",$data);
	$split = explode("-",$replace);
	$data = $split[2].'-'.$split[1].'-'.$split[0];*/
	
?>
<html>
	<head>
	<meta charset="UTF-8">
		<title>Editando...</title>
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
				$query = mysql_query("select nm_evento, dt_evento from tb_evento where cd_evento = $cdEvento") or die(mysql_error());
				$linha = mysql_fetch_assoc($query);
				
				$nomeAntigo = $linha['nm_evento'];
				$dataAntiga = date("d/m/Y", strtotime($linha['dt_evento']));
				
				$query = mysql_query("update tb_evento set nm_evento = '$nome', dt_evento = '$data', ds_evento = '$descricao' where cd_evento = $cdEvento") or die(mysql_error());
				
				$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigoUsuario'");
					
				$nmUsuario = mysql_fetch_array($aux);
				
				$acao = ' alterou o evento "'.$nomeAntigo.'" da data "'.$dataAntiga.'" para "'.$nome.'" da data "'.date("d/m/Y", strtotime($data)).'".';
				
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
				
				if (!$query)
				{
					echo '
						parent.lbl_mensagem.innerHTML = "Erro ao alterar o evento!";
						parent.mensagem.style.display = "inline-block";
						parent.all.style.display = "none"';
				}
				else
				{	
					echo '
						parent.lbl_mensagem.innerHTML = "Evento alterado com sucesso!";
						parent.mensagem.style.display = "inline-block";
						parent.all.style.display = "none";';
				}
			?>
		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>