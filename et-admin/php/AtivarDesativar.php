<?php
	session_start();
	
	include "Conexao.php";
	
	$codigo = mysql_escape_string($_GET['codigo']);
	
	$codigoAdmin = $_SESSION['EletronTech']['codigo'];
	
	$aux = mysql_query("select ic_ativado from tb_usuario where cd_usuario = '$codigo'");
			
	$ativo = mysql_fetch_array($aux);
	
	$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigo'");
			
	$nome = mysql_fetch_array($aux);
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
					window.location.href = "../Administrativo.php";
				}					
			}
			
			btn_OK.onclick = function()
			{
				mensagemOK();
			}
			
			<?php				
				if ($ativo[0] == 1)
				{
					$query = "update tb_usuario set ic_ativado = 0 where cd_usuario = '$codigo'";
					$result = mysql_query($query) or die(mysql_error());
					
					$diasReativar = 30;
					$diasReativar = 60*60*24*$diasReativar;
					$dataAgora = date("Y-m-d H:i:s");
					$dataAgora = strtotime($dataAgora);
					$dataReativar = $dataAgora + $diasReativar;
					$dataReativar = date("Y-m-d H:i:s", $dataReativar);
					
					$query = "update tb_usuario set dt_reativar = '$dataReativar' where cd_usuario = '$codigo'";
					$result_query = mysql_query($query);
					
					if ($result)
					{
						$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigoAdmin'");
									
						$nmUsuario = mysql_fetch_array($aux);
							
						$acao = ' desativou o usuário "'.$nome[0].'".';
						
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
						
						/*echo "<script language='javascript' type='text/javascript'>
									alert('Usuário desativo com sucesso!');
									window.location.href='../Administrativo.php'
								</script>";*/
								
						echo '
							lbl_mensagem.innerHTML = "Usuário desativo com sucesso!";
							exibirMensagem(1);';
					}
				}
				else
				{
					$result = mysql_query("update tb_usuario set ic_ativado = 1, dt_reativar = null where cd_usuario = '$codigo'") or die(mysql_error());
					
					if ($result)
					{
						$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigoAdmin'");
									
						$nmUsuario = mysql_fetch_array($aux);
							
						$acao = ' ativou o usuário "'.$nome[0].'".';
						
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
						
						/*echo "<script language='javascript' type='text/javascript'>
									alert('Usuário ativado com sucesso!');
									window.location.href='../Administrativo.php'
								</script>";*/
						
						echo '
							lbl_mensagem.innerHTML = "Usuário ativado com sucesso!";
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