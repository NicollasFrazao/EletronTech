<?php 
			/* esse bloco de código em php verifica se existe a sessão, pois o usuário pode simplesmente não fazer o login e digitar na barra de endereço do seu navegador o caminho para a página principal do site (sistema), burlando assim a obrigação de fazer um login, com isso se ele não estiver feito o login não será criado a session, então ao verificar que a session não existe a página redireciona o mesmo para a index.php. */
			session_start();
			
			include "php/Conexao.php";
			
			mysql_set_charset('utf8');
			ini_set('default_charset','UTF-8');
			
			if((!isset ($_SESSION['EletronTech']['login']) == true) and (!isset ($_SESSION['EletronTech']['senha']) == true)) 
			{ 
				unset($_SESSION['EletronTech']);
				header('location:../'); 
			}
			else
			{
				if ($_SESSION['EletronTech']['admin'] == 0)
				{
					header('location:../ET.php'); 
				}
			}
			
			$logado = $_SESSION['EletronTech']['login']; 
?>
<html>
	<head>
		<meta charset ="UTF-8">
		<title>Eletron Tech - Área Administrativa</title>
		<style>
			*
			{
				margin: 0;
				padding: 0;
				font-family: century gothic;
			}
			
			#divMenu { font:normal 20pt Calibri; border:1px dotted blue; width:200px; padding:0; position:absolute; background:rgba(133, 192, 242, 0.54) url('background.jpg'); background-position:-1100px -200px; visibility:hidden; }


			body
			{
				background-color: black;
			}
			
			#superior
			{
				display: inline-block;
				background-color: red;
				width: 100%;
			}
			
			#barra
			{
				display: inline-block;
				background-color: black;
				width: 100%;
				box-shadow: 0px 0px 5px 0px gray;
			}
			
			#btnmaster
			{
				display: inline-block;
				background-color: blue;
				width: 5%;
				box-shadow: 0px 0px 0px 0px #0ca3ff;
				z-index: 9998;
			}
			
			#btnmaster input
			{
				display: inline-block;
				background-color: #0ca3ff;
				width: 100%;
				z-index: 9998;
			}
			
			#barraLateral
			{
				display: none;
				position: absolute;
				background-color: black;
				width: 5%;
				height: 90%;
				margin-top: 50px;
				margin-bottom: 0;
				left: 0;
				box-shadow: 0px 0px 3px 0px gray;
			}
			
			#barraLateral input
			{
				display: inline-block;
				width: 100%;
				margin-top: 20px;
				border: none;
				background-color: black;
				padding: 2px;
			}
			
			#barraLateral input:hover
			{
				background-color: #0ca3ff;
				width: 100%;
			}
			
			#barraLateral input:active
			{
				background-color: #676767;
				width: 100%;
				padding: 3px;
				margin-top: 20px;
				border: none;
				box-shadow: 0 0 0 0;
				border: 0 none;
				outline: 0;
			}
			
			#barraLateral input:focus
			{
				background-color: #0ca3ff;
				width: 100%;
				padding: 2.5px;
				margin-top: 20px;
				border: none;
				box-shadow: 0 0 0 0;
				border: 0 none;
				outline: 0;
			}
			
			#barraLateral label
			{
				display: none;
				position: absolute;
				color: #0ca3ff;
				margin-left: 2px;
				font-weight: bold;
				background-color: black;
				padding: 15px;
				margin-top: -14px;
				width: 160px;
				z-index: 9999;
				opacity: 0.7;
			}
			
			#inferior
			{
				display: inline-block;
				position: absolute;
				width: 100%;
				height: 5%;
				background-color: black;
				bottom: 0;
				color: white;
				font-size: 10px;
				box-shadow: 0px 0px 2px 0px gray;
				z-index: 9998;
			}
			
			
			
			#paineis div
			{
				display: none;
				position: absolute;
				background-color: transparent;
				width: 90%;
				height: 75%;
				margin-top: -25%;
				margin-left: -42%;
				top:50%;
				left:50%;
			}
			
			#painelFerramentas #tbl_ferramentas
			{
				display: inline-block;
				position: absolute;
				width: 900px;
				height: 450px;
				top: 50%;
				left: 50%;
				margin-left: -450px;
				margin-top: -200px;
			}
			
			#painelFerramentas input
			{
				width: 100px;
				height: 100px;
				background-color: black;
				box-shadow: 0px 0px 2px 0px gray;
			}
			
			#all
			{
				background-color: #eeeeee;
				display: inline-block;
				position: absolute;
				width: 100%;
				height: 100%;
				
			}
			
			#rock
			{
				display: none;
				background-color: gray;
				position: absolute;
				width: 700px;
				height: 500px;
				margin-left: -350px;
				margin-top: -250px;
				top:50%;
				left:50%;
				border: 0px;
				color: white;
				box-shadow: 0px 0px 1px 1px #00428b;
			}
			
			#el
			{
				background-color: black;
				display: none;
				position: absolute;
				width: 100%;
				height: 90%;
				opacity: 0.8;
				top:50px;
			}
			
			#btn_fecharFei, #btn_fecharFei2
			{
				position: absolute;
				margin-left: 49%;
				width: 30px;
				heigth: 30px;
				margin-top: 0%;
				display: inline-block;
				position: absolute;
				width: 26px;
				margin-left: 0px;
				background-color: #0ca3ff;
				font-size: 22px;
				border: 0 none;
				padding: 0px;
				z-index: 9999;
				margin-left: 324px;
				left: 50%;
				margin-top: -300px;
				top: 50%;
				font-weight: bold;
				opacity: 1;
			}
			
			
			#btn_fecharFei:hover
			{
				background-color: #00428b;
			}
			
			#et
			{
				display: inline;
				position: absolute;
				height: 4%;
				top: 0;
				margin: 1.5%;
				margin-left: 75%;
			}
			
			#nm_Fei label
			{
				display: inline-block;
				background-color: transparent;
				width: 400px;
				height: 100px;
				margin-left: 50px;
				color: #676767;
				font-size: 35px;
				text-align: left;
				font-weight: bold;
				text-shadow: 1px 1px 1px gray;
			}
			
			#ds_Fei label
			{
				display: inline-block;
				width: 400px;
				height: 100px;
				margin-left: 50px;
				text-align: justify;
				font-size: 18px;
			}
			
			#pageNow
			{
				margin-left: 10%;
				margin-top: 3%;
				color: #0ca3ff;
				font-weight: normal;
			}
			
			#paineis iframe
			{
				display: none;
				position: absolute;
				background-color: transparent;
				width: 90%;
				height: 80%;
				left: 50%;
				margin-left: -40%;
				border: 0px;
			}
			
			#mouseMenu
			{
				display: none;
				width: 250px;
				height: 250px;
				position: absolute;
				border: 0px;
				opacity: 0.5;
			}
			
			
		</style>
	</head>
	<body oncontextmenu="mostrarMenu(); return false;">
		<input class="oculto" id="txt_url" name="url" type="hidden" value="">
		<div id="all">
			<div id="superior">
				<div id="barra">
					<div id="btnmaster">
						<input type="image" src="imagens/logo.png" onclick="barralateral()" id="btn_EletronTech">
						<img src="imagens/logoeletrontech.png" id="et">
					</div>
				</div>
			</div>
			<div id="barraLateral">
				<table border="0px">
					<tr>
						<td>
							<input type="image" src="imagens/admin.png" id="btn_admin">
						</td>
						
						<td>
							<label id="lbl_admin">Administrador</label>
						</td>
					</tr>
					
					<tr>
						<td>
							<input type="image" src="imagens/usuarios.png" id="btn_usuarios">
						</td>
						
						<td>
							<label id="lbl_usuarios">Gestão de Usuários</label>
						</td>
					</tr>
					
					<tr>
						<td>
							<input type="image" src="imagens/pacotes.png" id="btn_pacotes">
						</td>
						
						<td>
							<label id="lbl_pacotes">Gestão de Pacotes</label>
						</td>
					</tr>
					
					<tr>
						<td>
							<input type="image" src="imagens/ferramentas.png" id="btn_ferramentas">
						</td>
						
						<td>
							<label id="lbl_ferramentas">Ferramentas Administrativas</label>
						</td>
					</tr>
					
					<tr>
						<td>
							<input type="image" src="imagens/arquivos.png" id="btn_arquivos">
						</td>
						
						<td>
							<label id="lbl_arquivos">Arquivos</label>
						</td>
					</tr>
					
					<tr>
						<td>
							<input type="image" src="imagens/estatisticas.png" id="btn_estatisticas">
						</td>
						
						<td>
							<label id="lbl_estatisticas">Estatísticas</label>
						</td>
					</tr>
					
					<tr>
						<td>
							<input type="image" src="imagens/sair.png" id="btn_sair">
						</td>
						
						<td>
							<label id="lbl_sair">Sair</label>
						</td>
					</tr>
				</table>
			</div>
			
			


			<div id="inferior">
				<br>
				<center><label>Ⓒ  Copyright - Todos Os Direitos Reservados a All Technology Systems<label></center>
			</div>
			<div id="paineis">
				<h1 id="pageNow">Bem-Vindo <?php echo "$logado"; ?></h1>
				<iframe id="painelAdmin">
				</iframe>
				
				<iframe id="painelUsuario" src="Administrativo.php">
				</iframe>
				
				<iframe id="painelPacotes">
				</iframe>
				
				<iframe id="painelFerramentas">
				</iframe>
				
				<iframe id="painelArquivos" src="Arquivos.php">
				</iframe>
				
				<iframe id="painelEstatisticas" src="Estatisticas.php">
				</iframe>
				
			</div>
		</div>
		
		<div id="el">
			<input type="image" src="FEI/imagens/voltar.png" id="btn_fecharFEI"/>
		</div>
		
		<iframe id="mouseMenu" src="../mouseMenu.html" >
		</iframe>
		
	</body>
	
	<script>
		window.onload = function()
		{
			
			var navegador = navigator.userAgent;
			
			if(navegador.indexOf("Firefox") == -1)
			{
				barraLateral.style.marginTop = "0px";
			}
			else
			{
				tbl_ferramentas.style.marginTop = "-220px";
				barraLateral.style.marginTop = "50px";
			}
			
			barraLateralOnOff = 0;
			btn_admin.style.backgroundColor = "#0ca3ff";
			myFei();
			
		}
		

		function barralateral()
		{
			i=0;
			if(barraLateralOnOff == 0)
			{
				barraLateralOnOff = 1;
				barraLateral.style.display = "inline-block";
				dropDownBarraLateral();
				
			}
			
			else
			{
				barraLateralOnOff = 0;
				barraLateral.style.display = "none";
			}
			i=0;
		}
		
		
		barraLateral.onmouseover = function()
		{
			btn_admin.onmouseover = function()
			{
				lbl_admin.style.display = "inline-block";
			}
			
			btn_usuarios.onmouseover = function()
			{
				lbl_usuarios.style.display = "inline-block";
			}
			
			btn_pacotes.onmouseover = function()
			{
				lbl_pacotes.style.display = "inline-block";
			}
			
			btn_ferramentas.onmouseover = function()
			{
				lbl_ferramentas.style.display = "inline-block";
			}
			
			btn_arquivos.onmouseover = function()
			{
				lbl_arquivos.style.display = "inline-block";
			}
			
			btn_estatisticas.onmouseover = function()
			{
				lbl_estatisticas.style.display = "inline-block";
			}
			
			btn_sair.onmouseover = function()
			{
				lbl_sair.style.display = "inline-block";
			}
		}
		
		barraLateral.onmouseout = function()
		{
			lbl_admin.style.display = "none";
			lbl_usuario.style.display = "none";
			lbl_pacotes.style.display = "none";
			lbl_ferramentas.style.display = "none";
			lbl_arquivos.style.display = "none";
			lbl_sair.style.display = "none";
		}
		
		btn_pacotes.onmouseout = function()
		{
			lbl_pacotes.style.display="none";
		}
		
		btn_arquivos.onmouseout = function()
		{
			lbl_arquivos.style.display="none";
		}
		
		btn_estatisticas.onmouseout = function()
		{
			lbl_estatisticas.style.display="none";
		}
		
		btn_usuarios.onmouseout = function()
		{
			lbl_usuarios.style.display="none";
		}
		
		btn_ferramentas.onmouseout = function()
		{
			lbl_ferramentas.style.display="none";
		}
		
		btn_sair.onmouseout = function()
		{
			lbl_sair.style.display="none";
		}
		
		btn_admin.onclick = function()
		{
			pageNow.innerHTML="Administrador";
			barraLateralSelect = 1;
			barraSelecionado();
		}
		
		btn_usuarios.onclick = function()
		{
			pageNow.innerHTML= "Gestão de Usuários";
			barraLateralSelect = 2;
			barraSelecionado();
		}
		
		btn_pacotes.onclick = function()
		{
			pageNow.innerHTML="Gestão de Pacotes";
			barraLateralSelect = 3;
			barraSelecionado();
		}
		
		btn_ferramentas.onclick = function()
		{
			pageNow.innerHTML="Ferramentas";
			barraLateralSelect = 4;
			barraSelecionado();
		}
		
		btn_arquivos.onclick = function()
		{
			pageNow.innerHTML="Arquivos";
			barraLateralSelect = 5;
			barraSelecionado();
		}
		
		btn_estatisticas.onclick = function()
		{
			pageNow.innerHTML="Estatisticas";
			barraLateralSelect = 6;
			barraSelecionado();
		}
		
		btn_sair.onclick = function()
		{
			/*pageNow.innerHTML="sair";
			barraLateralSelect = 6;
			barraSelecionado();*/
			
			window.location.href='../php/Logout.php';
		}
		
		function barraSelecionado()
		{
			painelAdmin.style.display="none";
			painelUsuario.style.display="none";
			painelPacotes.style.display="none";
			painelFerramentas.style.display="none";
			painelArquivos.style.display="none";
			painelEstatisticas.style.display="none";
			
			btn_admin.style.backgroundColor="black";
			btn_usuarios.style.backgroundColor="black";
			btn_pacotes.style.backgroundColor="black";
			btn_ferramentas.style.backgroundColor="black";
			btn_arquivos.style.backgroundColor="black";
			btn_estatisticas.style.backgroundColor="black";
			switch(barraLateralSelect)
			{
				case 1:
					btn_admin.style.backgroundColor = "#0ca3ff";
					painelAdmin.style.display="inline-block";
				break;
				case 2:
					btn_usuarios.style.backgroundColor = "#0ca3ff";
					painelUsuario.style.display="inline-block";
				break;
				case 3: 
					btn_pacotes.style.backgroundColor = "#0ca3ff";
					painelPacotes.style.display="inline-block";
				break;
				case 4:
					btn_ferramentas.style.backgroundColor = "#0ca3ff";
					painelFerramentas.style.display="inline-block";
				break;
				case 5:
					btn_arquivos.style.backgroundColor = "#0ca3ff";
					painelArquivos.style.display="inline-block";
				break;
				case 6:
					btn_estatisticas.style.backgroundColor = "#0ca3ff";
					painelEstatisticas.style.display="inline-block";
				break;
				default:
			}
		}
		
		
		function dropDownBarraLateral()
		{
			if(i+1 <= 100)
				{
					i++;
					setTimeout("dropDownBarraLateral()",1);
					opa = parseFloat(i);
					barraLateral.style.opacity = opa *0.03;
				}
		}
		
		all.onmousedown = function()
		{
			teste(event)
		}
		
		function teste(event)
		{
		   if(event.which == 1){
			     mouseMenu.style.display="none";
		   }
		}
		
		function mostrarMenu()
		{
			var X = event.clientX - 100;
			var Y = event.clientY - 100;
			var menu = document.getElementById("mouseMenu");
			menu.style.top = Y.toString() + "px";
			menu.style.left = X.toString() + "px";
			menu.style.display = "inline-block";
		}
			

	function fechaMenu()
	{
		mouseMenu.style.display="none";
	}
		
		
		
	</script>
</html>

<?php
	mysql_close($conexao);
?>