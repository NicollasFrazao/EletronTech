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
	
	$codigo = $_SESSION['EletronTech']['codigo'];
	$codigoDesativar = mysql_escape_string($_GET['codigoUsuario']);
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Desativando conta...</title>
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
					parent.location.href = "Logout.php";
				}
				else
				{
					history.back(1);
				}
			}
			
			btn_OK.onclick = function()
			{
				mensagemOK();
			}
			
			<?php
				if ($codigo != $codigoDesativar)
				{
					echo '
						lbl_mensagem.innerHTML = "Não foi possível desativar sua conta. <p>Erro: Essa conta é a mesma conta logada.</p>";
						exibirMensagem(0);';
				}
				else
				{
					$query = "update tb_usuario set ic_ativado = 0 where cd_usuario = '$codigoDesativar'";
					$result_query = mysql_query($query) or die(mysql_error());
					
					$diasReativar = 30;
					$diasReativar = 60*60*24*$diasReativar;
					$dataAgora = date("Y-m-d H:i:s");
					$dataAgora = strtotime($dataAgora);
					$dataReativar = $dataAgora + $diasReativar;
					$dataReativar = date("Y-m-d H:i:s", $dataReativar);
					
					$query = "update tb_usuario set dt_reativar = '$dataReativar' where cd_usuario = '$codigoDesativar'";
					$result_query = mysql_query($query);
					
					if ($result_query)
					{
						$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigoDesativar'");
							
						$nmUsuario = mysql_fetch_array($aux);
						
						$acao = " desativou sua conta.";
						
						$aux = mysql_query("select ic_admin from tb_usuario where cd_usuario = '$codigoDesativar'");
						
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
						
						$query = mysql_query("insert into tb_atividade(cd_usuario, nm_usuario, ds_atividade, dt_atividade) values('$codigoDesativar', '$nmUsuario[0]', '$descricao', now())") or die(mysql_error());
						
						echo '
							lbl_mensagem.innerHTML = "Sua conta foi desativada com sucesso! Esperamos seu retorno.";
							exibirMensagem(1);';
					}
					else
					{
						echo '
							lbl_mensagem.innerHTML = "Não foi possível desativar sua conta. <p>Erro: '.mysql_error().'</p>";
							exibirMensagem(0);';
					}
				}
			?>
		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>