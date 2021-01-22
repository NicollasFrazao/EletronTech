<?php
	include "Conexao.php";
	
	if (isset($_GET['codigo']) && isset($_GET['data']))
	{
		$codigoUsuario = mysql_escape_string(base64_decode($_GET['codigo']));
		$dataExpirar = mysql_escape_string(base64_decode($_GET['data']));
		
		$diferenca = (strtotime(date("Y-m-d", strtotime($dataExpirar))) - strtotime(date("Y-m-d")))/(60*60*24);
		
		if ($diferenca > 0)
		{
			$query = "update tb_usuario set ic_confirmado = 1 where cd_usuario = '$codigoUsuario'";
			$result_query = mysql_query($query) or die (mysql_error());
		}
	}
	else
	{
		$diferenca = 0;
	}
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel="shortcut icon" href="../imagens/logo/logo.ico" />
		<title>Confirmando conta...</title>
		
		<style type="text/css">
			@import url("msg.css");
		</style>
	</head>
	<body>
		<div id="mensagem" align="center">
			<label id="lbl_mensagem">Aqui vai uma mensagem gerada com innerHTML</label></br>
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
					//Login();
					window.location.href = "../Login.php";
				}
				else
				{
					history.back(1);
				}
				
			}
			
			<?php
				if ($result_query && isset($_GET['codigo']) && isset($_GET['data']) && $diferenca > 0)
				{
					echo "lbl_mensagem.innerHTML = 'Conta confirmada com sucesso! Retorne ao sistema e efetue login.';
						  exibirMensagem(0);";
				}
				else if ($diferenca <= 0)
				{
					echo "lbl_mensagem.innerHTML = 'Link expirou! Retorne ao sistema e tente novamente.';
						  exibirMensagem(0);";
				}
				else
				{
					echo "lbl_mensagem.innerHTML = 'Não foi possível confirmar sua conta!';
						  exibirMensagem(0);";
				}
			?>
		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>
