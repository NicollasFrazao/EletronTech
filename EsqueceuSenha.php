<?php
?>

<!Doctype html>

<html>
	<head>
		<link rel="shortcut icon" href="imagens/logo/logo.ico" />
		<title>EletronTech - Recuperação de Senha</title>
		<meta charset="UTF-8">
		<style>
			*
			{
				margin: 0px;
				padding: 0px;
				font-family: Century Gothic;
				outline: none;
			}
			
			#ddeml
			{
				display: inline-block;
				width: 100%;
				height: 100%;
				position: absolute;
				background-color: RGBA(1,109,255,0.9);
			}
			
			#txt_email
			{
				display: inline-block;
				width: 500px;
				font-size: 18px;
				padding:5px;
			}
			
			#btn_limpar, #btn_enviar
			{
				display: inline-block;
				background-color: black;
				color: white;
				border: 0px;
				width: 100%;
				padding: 10px;
				font-size: 12px;
			}
			
			#btn_limpar
			{
				background-color: transparent;
			}
			
			#lbl_email
			{				
				color: white;
				font-size: 22px;
			}
			
			table
			{
				display: inline-block;
				width: 550px;
				margin-top:70px;	
				position: absolute;
				margin-left: 35px;
				border: 0px solid white;
			}
			
			#lbl_aviso
			{
				color: white;
			}
			
			#lbl_aviso a
			{
				text-decoration: blink;
				color: black;
			}
			
			#lbl_aviso a:hover
			{
				color: white;
			}
		</style>
	</head>
	
	<body>
		<div id="ddeml">
			<form id="Frm_Dados" action="php/RecuperarSenha.php" method="POST">
			<table cellspacing="10" cellpadding="10">
				<tr>
					<td colspan="2">
						<label for="email" id="lbl_email">Digite seu email no campo abaixo</label><br><br>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="text" name="email" id="txt_email" required><br><br>
					</td>
				</tr>
				<tr>
					<td>
						<input type="reset" value="Cancelar" id="btn_limpar" onclick="window.location.href = 'Login.php';">
					</td>
					<td>
						<input type="submit" value="Enviar" id="btn_enviar">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<label id="lbl_aviso"></label>
					</td>
				</tr>
			</form>
		</div>
	</body>
	<script src="script/ajax.js"></script>
	<script>
		Frm_Dados.onsubmit = function()
		{
			AjaxForm(this, "lbl_aviso.textContent = 'Aguarde...'; btn_enviar.disabled = true; btn_enviar.style.backgroundColor = 'gray';", "retorno = this.responseText; lbl_aviso.innerHTML = retorno; btn_enviar.disabled = false; btn_enviar.style.backgroundColor = 'black';");
			
			this.reset();
			
			return false;
		}
	</script>
</html>