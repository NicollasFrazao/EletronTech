<?php 
	/* esse bloco de código em php verifica se existe a sessão, pois o usuário pode simplesmente não fazer o login e digitar na barra de endereço do seu navegador o caminho para a página principal do site (sistema), burlando assim a obrigação de fazer um login, com isso se ele não estiver feito o login não será criado a session, então ao verificar que a session não existe a página redireciona o mesmo para a index.php. */
	session_start();
	
	if((isset ($_SESSION['EletronTech']['login']) == true) and (isset ($_SESSION['EletronTech']['senha']) == true)) 
	{ 
		/*
		if ($_SESSION['EletronTech']['admin'] == 0)
		{
			header('location:ET.php');
		}
		else
		{
			header('location:et-admin');
		}
		*/
		
		header('location: StatusLogin.php');
	}
	else if ((isset($_COOKIE['EletronTech']['email']) == true) and (isset($_COOKIE['EletronTech']['senha']) == true))
	{
		$cookie = 1;
		$emailCookie = $_COOKIE['EletronTech']['email'];
		$senhaCookie = base64_decode($_COOKIE['EletronTech']['senha']);
	}
	else
	{
		$cookie = 0;
		$emailCookie = "";
		$senhaCookie = "";
	}
	
	//$logado = $_SESSION['login']; 
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="shortcut icon" href="imagens/logo/logo.ico" />
		<title>EletronTech - Login</title>
		
		<style>
			*
			{
				margin: 0;
				padding: 0;
				font-family: Century Gothic;
				outline:none;
			}
			
			body
			{
				background-color: black;
				font-family: century gothic;
				
			}
			
			#all
			{
				position: absolute;
				background-color: transparent;
				display: inline-block;
				width: 500px;
				height: 200px;
				top: 50%;
				left: 50%;
				margin-Top: -100px;
				margin-left: -250px;
			}
			
			#logo
			{
				position: absolute;
				width: 50%;
				top: 50%;
				left:50%;
				margin-top: -25%;
				margin-left: -25%;
				background-color: #0ca3ff;
			}
			
			#logo img
			{
				position: absolute;
				width: 100%;
				background-color: #0ca3ff;
				box-shadow: 0px 0px 1px 3px #00101a;
			}
			
			#login
			{
				display: none;
				background-color: transparent;
				position: absolute;
				width: 200px;
				height: 150px;
				top:53%;
				left: 60%;
				margin-top: -130px;
				margin-left: -65px;
				padding: 10px;
				font-size: 10px;
			}
			
			#login label
			{
				color: #ffffff;
				font-size: 16px;
			}
			
			#btn_acessar
			{
				background-color: #0ca3ff;
				border: 0px;
				padding: 5px;
				color: white;
				align: right;
				width: 50%;
				margin-left: 20px;
				font-family: century gothic;
			}
			
			#btn_fp
			{
				background-color: transparent;
				border: 0px;
				padding: 5px;
				color: white;
				align: right;
				font-size: 12px;
				font-family: century gothic;
			}
			
			#btn_fp1
			{
				background-color: transparent;
				border: 0px;
				padding: 5px;
				color: #0ca3ff;
				align: right;
				width: 40%;
				outline: none;
				font-family: century gothic;
			}
			
			#btn_fp
			{
				font-size: 12px;
			}
			
			#btn_fp:focus, #btn_fp:active
			{
				border: none;
				box-shadow: 0 0 0 0;
				border: 0 none;
				outline: 0;
			}
			
			#btn_fp:hover
			{
				color: #0ca3ff;
			}
			
			#btn_acessar:hover
			{
				color: black;
			}
			
			#login #txt_senha, #login #txt_usuario
			{
				width: 250px;
				height: 30px;
				font-size: 16px;
				font-family: Century Gothic;
				padding: 5px;
			}
			
			#carregamento
			{
				display: none;
				background-color: black;
				position: absolute;
				width: 580px;
				height: 260px;
				margin-left: -290px;
				margin-top: -130px;
				top: 50%;
				left: 50%;
				z-index: 9999;
			}
			
			#carregamento img
			{
				position: absolute;
				width: 200px;
				left: 50%;
				top:20%;
				margin-left: -100px;
			}
			
			#carregamento label
			{
				position: absolute;
				width: 200px;
				left: 50%;
				top:65%;
				margin-left: -80px;
				color: white;
			}
		</style>
	</head>
	<body>
		<div id="all">
			<div id="logo">
				<img src="imagens/logo/logo.png">
			</div>
			<div id="login">
				<form id="Frm_Login" action="php/Login.php" method="POST">
					<table>
						<tr>
							<td>
								<label>E-mail</label>
							</td>
						</tr>
						
						<tr>
							<td>
								<input name="email" type="text" id="txt_usuario" maxlength="50" value="<?php echo $emailCookie; ?>">
							</td>
						</tr>
						
						<tr>
							<td>
								<label>Senha</label>
							</td>
						</tr>
						
						<tr>
							<td>
								<input name="senha" type="password" id="txt_senha" maxlength="12" value="<?php echo $senhaCookie; ?>">
							</td>
						</tr>
						
						<tr>
							<td>
								<br/>
								<input name="continuar" type="checkbox" id="chk_continuar" value="1"> <label>Manter-me conectado.</label>
							</td>
						</tr>
						
						<tr>
							<td align="right">
							<br>
								<input type="button" id="btn_fp1" value="Cadastre-se" onclick="Cadastro();">
								<input type="button" id="btn_acessar" value="Entrar" onclick="Login();">
							</td>
						</tr>
						
							
						<tr>
							<td align="right" id="fP">
							</br>
								<input type="button" id="btn_fp" value="Não consigo acessar minha conta!" onclick="window.location.href = 'EsqueceuSenha.php';">
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<div id="carregamento">
			<img src="imagens/load.gif">
			<label>Realizando Login</label>
		</div>
	</body>
	<script type="text/javascript" src="script/Login.js"></script>
	
	<script>
		window.onload = function()
		{
			i = 0;
			j = 25;
			exibir();
			
			if (<?php echo $cookie; ?> == 1)
			{
				Login();
			}
		}
		
		function exibir()
		{
				if(i+1 <= 100)
				{
					i++;
					setTimeout("exibir()",20);
					opa = parseFloat(i);
					logo.style.opacity = opa *0.01;
					all.style.opacity = opa * 0.01;
					
				}
				
				if (i == 99)
				{
					deslizar();
				}		
			
		}
		
		function deslizar()
		{
			if(j+1 <= 55)
			{
				j++;
				setTimeout("deslizar()",20);
				logo.style.marginLeft = "-"+j+"%";
			}
			else
			{
				exibirLogin();
			}
		}
		
		function exibirLogin()
		{
			login.style.display = "inline-block";
		}
		
		var Form = document.querySelector("#Frm_Login");

		Form.onkeypress = function(e,args)
		{
			if (e.keyCode == 13)
			{
				btn_acessar.focus();
				btn_acessar.click();
			}
		}
	</script>
</html>