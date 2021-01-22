<?php 
	/* esse bloco de código em php verifica se existe a sessão, pois o usuário pode simplesmente não fazer o login e digitar na barra de endereço do seu navegador o caminho para a página principal do site (sistema), burlando assim a obrigação de fazer um login, com isso se ele não estiver feito o login não será criado a session, então ao verificar que a session não existe a página redireciona o mesmo para a index.php. */
	session_start();
	
	include "php/Conexao.php";
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	
	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );

	date_default_timezone_set( 'America/Sao_Paulo' );
	
	if((!isset ($_SESSION['EletronTech']['login']) == true) and (!isset ($_SESSION['EletronTech']['senha']) == true)) 
	{ 
		unset($_SESSION['EletronTech']);
		
		setcookie("email", "", time()-3600, "/");
		setcookie("senha", "", time()-3600, "/");
		
		header('location:Login.php'); 
	} 
	
	$logado = $_SESSION['EletronTech']['login'];
	$codigo = $_SESSION['EletronTech']['codigo'];
	
	
	
	$query = mysql_query("update tb_usuario set ic_logado = 1 where cd_usuario = '$codigo'");
	
	$query_Busca = "select tb_usuario.nm_usuario as 'Usuário', tb_pacote.nm_pacote as 'Pacote', usuario_pacote.dt_inicio as 'Data de Início', usuario_pacote.dt_termino as 'Data de Término', usuario_pacote.qt_dias as 'Dias Restantes', tb_pacote.im_pacote as 'Imagem', tb_pacote.ds_pacote as 'Descrição', tb_pacote.cd_pacote as 'codigoPasta'
					  from tb_usuario inner join usuario_pacote
						on tb_usuario.cd_usuario = usuario_pacote.cd_usuario
						  inner join tb_pacote
							on usuario_pacote.cd_pacote = tb_pacote.cd_pacote
								where tb_usuario.cd_usuario = '$codigo'";
								
	$result_Busca = mysql_query($query_Busca) or die(mysql_error());
	$linha_Busca = mysql_fetch_assoc($result_Busca);
	$totalLinha_Busca = mysql_num_rows($result_Busca);
	
	$query_Busca_User = "select ic_tutorial_desativado as 'Tutorial', ic_noturno as 'Noturno' from tb_usuario where cd_usuario = '$codigo'";
								
	$result_Busca_User = mysql_query($query_Busca_User) or die(mysql_error());
	$linha_Busca_User = mysql_fetch_assoc($result_Busca_User);
	$totalLinha_Busca_User = mysql_num_rows($result_Busca_User);
	
	$tutorial = $linha_Busca_User['Tutorial'];
	$noturno = $linha_Busca_User['Noturno'];
	
	$dataAgora = date("Y-m-d H:i:s");
	$dataTermino = $linha_Busca['Data de Término'];
	$dataAgora = strtotime($dataAgora);
	$dataTermino = strtotime($dataTermino);
	$diasRestantes = ($dataTermino - $dataAgora)/86400;
	$diasRestantes = ceil($diasRestantes);
	
	$query = mysql_query("update usuario_pacote set qt_dias = '$diasRestantes' where cd_usuario = '$codigo'") or die(mysql_error());
	
	if ($diasRestantes <= 0 && $linha_Busca['Data de Término'] != "")
	{
		$aux = mysql_query("select nm_pacote
							  from tb_usuario inner join usuario_pacote
								on tb_usuario.cd_usuario = usuario_pacote.cd_usuario
								 inner join tb_pacote
								   on usuario_pacote.cd_pacote = tb_pacote.cd_pacote
									 where tb_usuario.cd_usuario = '$codigo'");
									 
		$nmPacote = mysql_fetch_array($aux);
		
		$aux = mysql_query("select nm_usuario from tb_usuario where cd_usuario = '$codigo'");
						
		$nmUsuario = mysql_fetch_array($aux);
			
		$acao = " expirou.";
		
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
		
		$descricao = $tipoUsuario.' -- O pacote "'.$nmPacote[0].'" do usuário '.$nmUsuario[0].$acao;
		
		$query = mysql_query("insert into tb_atividade(cd_usuario, nm_usuario, ds_atividade, dt_atividade) values('$codigo', '$nmUsuario[0]', '$descricao', now())") or die(mysql_error());
		
		$query = mysql_query("delete from usuario_pacote where cd_usuario = '$codigo'") or die(mysql_error());
	}
?>

<!Doctype>

<html>
	<head>
		<meta charset="utf-8">
		<link rel="shortcut icon" href="imagens/logo/logo.ico" />
		<title>EletronTech - Área do Usuário</title>
		<style>
		*
		{
			margin: 0;
			padding: 0;
			font-size: 14px;
			font-family: Century Gothic;
			cursor: hand;
			outline: none;
			
		}
		
		#inicio, #perfil, #mensagens, #eventos, #licenca, #ferramentas, #arquivos
		{
			display: none;
			border: 0px;
			width: 100%;
			height: 100%;
			background-color: transparent;
		}
		
		#all
		{
			background-color: white;
		}
		
		
		#menu
		{
			display: none;
			width: 200px;
			height: 100%;
			background-color: black;
			position: absolute;
			opacity: 0.9;
			
		}
		
		table
		{
			display: inline-block;
			width: 100%;
			height: 100%;
		}
		
		table td
		{
			display: inline-block;
			width: 10%;
			color: white;
		}
		
		td
		{
			display: inline-block;
			padding-top:10px;
			padding-bottom:10px;
		}
		
		img
		{
			width: 15%;
		}
		
		#atBar
		{
			display: inlnie-block;
			position: absolute;
			height: 100%;
			width: 1%;
			opacity: 0.0;
		}
		
		tr:hover
		{
			background-color: #0056a5;
		}
		
		#tempo:hover
		{
			background-color: black;
		}
		
		#lblHora
		{
			font-size: 28px;
		}
		
		#lblData
		{
			font-size: 14px;
		}
		
		#logoex
		{
			width: 70%;
		}
		
		#logoex:hover
		{
			background-color: black;
		}		
		
		#tuto
		{
			display: none;
			width: 100%;
			height: 100%;
			background-color: RGBA(0,0,0,0.8);
			position: absolute;
		}
		
		#tuto table
		{
			display: inline-block;
			width: 100%;
			height: 100%;
			border: 0px;
		}
		
		#tuto table td:hover,#tuto table tr:hover
		{
			background-color: RGBA(0,0,0,0.0);
		}
		
		#tuto_menu
		{
			display: inline-block;
			position: absolute;
			width: 250px;
			height: 250px;
			top:50%;
			left:50%;
			margin-left:-300px;
			margin-top:-100px;
		}
		
		#tuto_text
		{
			display: inline-block;
			width: 450px;
			height: 200px;
			font-size: 28px;
			position: absolute;
			top: 50%;
			margin-top: -100px;
			text-shadow: 1px 0px #00b0f0;
		}
		
		#fecha_text_tuto
		{
			display: inline-block;
			height: 40px;
			position: absolute;
			font-size: 18px;
			color:#00b0f0;
			top:50%;
			margin-top: 100px;
			text-shadow: 1px 0px #00b0f0;
		}
		
		#etLamp
		{
			display: inline-block;
			position: absolute;			
			background-color: transparent;
			z-index: 9999;
			bottom: 0px;
			right: 0px;
		}
		
		
		#etLampLuiz
		{
			width: 30px;
			opacity: 0.6;
		}
		
		#etLampLuiz:hover
		{
			width: 30px;
			opacity: 1;
		}
		
		#dnot
		{
			display: none;
			width: 200px;
			background-color: transparent;
			color: black;
			position: absolute;
			right: 30px;
			bottom: 5px;
		}
		
		#uscitaM
		{
			display: inline-block;
			position: absolute;
			width: 300px;
		}
		
		#cbr
		{
			display: none;
			position: absolute;
			width: 100%;
			height: 100%;
			background-color: #00b0f0;
			z-index: 9998;
			opacity: 0.7;
		}
		
		#chat
		{
			display: none;
			width: 80%;
			height: 550px;
			position:absolute;
			margin-left: 10%;
			margin-top: -275px;
			top:50%;
			border: 0px;
			box-shadow: 0px 0px 4px 0px gray;
			z-index: 9999;
		}
		</style>
	</head>
	<body>
	<?php
		if ($tutorial == 0)
		{
	?>
			<div id="tuto">
				<table>
					<tr>
						<td align="right">
							<img src="imagens/tuto/tuto_menu.gif" id="tuto_menu">
						</td>
						<td>
							
							<table>
								<tr>
									<td>
										<label id="tuto_text">Você pode acessar outras funcionalidades do EletronTech no menu! Basta posicionar cursor do mouse no canto esquerdo da tela.</label>
									</td>
								</tr>
								<tr>
									<td>
										<label id="fecha_text_tuto">Clique aqui para finalizar esta mensagem</label>
									</td>
								</tr>
								<tr>
									<td id="uscitaM">
										<input type="checkbox" id="chk_naoMostrar" name="naoMostrar" value="0">
										<label id="lbl_naoMostrar">Ocultar esta mensagem</label>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
	<?php
		}
	?>
	
	<div id="cbr"></div>
	<iframe src="chat.html" id="chat"></iframe>
	<input class="oculto" id="txt_url" type="hidden">
	<input class="oculto" id="txt_urlEventos" type="hidden">
	<div id="all">
		<div id="atBar">
		
		</div>
		<div id="menu" align="center">
			<table>
			
				<!-- <tr>
					<td align="center" id="logoex">
						<img id="logoex" src="imagens/logo/logoeletrontech.png">
					</td>
				</tr> -->
				
				<tr>
					
					<td align="center" id="inicioOPT">
						<img src="imagens/logo/logowhite.png"><br>
						<label>Início<label>
					</td>
				</tr>
				
				
				<tr>
					<td align="center" id="perfilOPT">
						<img src="imagens/usuario.png"><br>
						<label>Perfil<label>
					</td>
				</tr>
				<!--
				<tr>
					<td align="center" id="mensagensOPT">
						<img src="imagens/mensagens.png"><br>
						<label>Mensagens<label>
					</td>
				</tr>
				-->
				
				<input type="hidden" id="mensagensOPT">
				<tr>
					<td align="center" id="eventosOPT">
						<img src="imagens/eventos.png"><br>
						<label>Eventos<label>
					</td>
				</tr>
				
				<tr>
					<td align="center" id="licencaOPT">
						<img src="imagens/licenca.png"><br>
						<label>Licença<label>
					</td>
				</tr>
				
				<tr>
					<td align="center" id="ferramentasOPT">
						<img src="imagens/ferramentas.png"><br>
						<label>Ferramentas<label>
					</td>
				</tr>
				
				<tr>
					<td align="center" id="arquivosOPT">
						<img src="imagens/arquivos.png"><br>
						<label>Arquivos<label>
					</td>
				</tr>
				
				<tr>
					<td align="center" id="sairOPT">
						<img src="imagens/sair.png"><br>
						<label>Sair<label>
					</td>
				</tr>
				
				<tr>
					<td align="center" id="tempo">
						<label id="lblHora"></label><br>
						<label id="lblData"></label>
					</td>
				</tr>
			</table>
		</div>
		<iframe id="inicio" src="Inicio.php"></iframe>
		<iframe id="perfil" src="Perfil.php"></iframe>
		<iframe id="mensagens" src="Mensagens.php"></iframe>
		<iframe id="eventos" src="Eventos.php"></iframe>
		<iframe id="licenca" src="Licenca.php"></iframe>
		<iframe id="ferramentas" src="Ferramentas.php"></iframe>
		<iframe id="arquivos" src="Arquivos.php"></iframe>
	</div>
	<div id="etLamp">
		
				<label id="dnot">Design Noturno Desativado</label>
				<input type="image" src="imagens/etLamp_dark.png" id="etLampLuiz" onclick="ascd();" onmouseover="om();" onmouseout="ob();">
	</div>
	<input type="hidden" id="fullS" onclick="toggleFullScreen()">
	</body>
	<script src="script/jquery.min.js"></script>
	<script src="script/ajax.js"></script>
	<script>
		menuAt = 0;
		
		window.onload = function()
		{
			
			menuAt = 0;
			timer();
			menuVal = 1;
			menuOpcoes();
			Logado();
			//window.close();
			
			<?php
				if ($tutorial == 0)
				{
			?>
					$(function()
					{
						$("#tuto").fadeIn(5000);
					});
			<?php
				}
			?>
			
			if (<?php echo $noturno; ?> == 1)
			{
				ascd();
			}
		}
		
		function Logado()
		{
			Ajax("GET", "php/MudarLogado.php", "", "");
			
			setTimeout("Logado()", 60000);
		}
		
		function desativarMenu()
		{			
			if(menuAt == 0)
			{
				menu.style.display = "none";
			}
			else if(menuAt == 1)
			{
				menu.style.display = "inline-block";
			}
		}
		
		function timer()
		{
			dat = new Date();
            dia = dat.getDate();
			mes = dat.getMonth()+1;
			ano = dat.getFullYear();
			horaN = dat.getHours();
			minuto = dat.getMinutes();
			
			//hora
			if(horaN < 10)
			{
				horaS = "0"+horaN;
			}
			else
			{
				horaS = horaN;
			}
			
			//minuto
			if(minuto < 10)
			{
				minutoS = "0"+minuto;
			}
			else
			{
				minutoS = minuto;
			}
			
			if (lblHora.innerHTML.indexOf(":") != -1)
			{
				horario = horaS+" "+minutoS;
			}
			else
			{
				horario = horaS+":"+minutoS;
			}
			
			if(mes < 10 && dia < 10)
			{
				dataHoje = "0"+dia+"/0"+mes+"/"+ano;
			}
			else if (mes < 10)
			{
				dataHoje = dia+"/0"+mes+"/"+ano;
			}
			else
			{
				dataHoje = dia+"/"+mes+"/"+ano;
			}
			
			lblData.innerHTML = dataHoje;
			lblHora.innerHTML = horario;
			setTimeout("timer()",1000);
		}
		
		function sonoCheOre()
		{
			if(horaS >=6 && horaS <=11)
			{
				ora = "Bom Dia, ";
			}
			else if(horaS >= 12 && horaS <= 17)
			{
				ora = "Boa Tarde, ";
			}
			else if(horaS >= 18 && horaS <= 23)
			{
				ora = "Boa Noite, ";
			}
			else
			{
				ora = "Boa Noite, ";
			}
			nm = saudacao.value;
			primeiroNome = nm.split(" ");
			ss.innerHTML=ora+primeiroNome[0]+"!";
		}
		
		all.onmousemove = function()
		{
			ativarMenu();
		}
		
		menu.onmouseover = function()
		{
			menuAt = 1;
		}
		
		menu.onmouseout = function()
		{
			menuAt = 0;
		}
		
		inicio.onmouseover = function()
		{
			setTimeout("desativarMenu()",1000);
		}
		
		perfil.onmouseover = function()
		{
			setTimeout("desativarMenu()",1000);
		}
		
		mensagens.onmouseover = function()
		{
			setTimeout("desativarMenu()",1000);
		}
		
		eventos.onmouseover = function()
		{
			setTimeout("desativarMenu()",1000);
		}
		
		licenca.onmouseover = function()
		{
			setTimeout("desativarMenu()",1000);
		}
		
		ferramentas.onmouseover = function()
		{
			setTimeout("desativarMenu()",1000);
		}
		
		arquivos.onmouseover = function()
		{
			setTimeout("desativarMenu()",1000);
		}
		
		function ativarMenu()
		{
			menu.style.display = "inline-block";
		}
		
		function menuOpcoes()
		{
			limpaMenu();
			limpaFrames();
			switch(menuVal)
			{
				case 1:
					inicioOPT.style.backgroundColor = "#167ff6";
					inicio.style.display = "inline-block";
				break;
				case 2:
					perfilOPT.style.backgroundColor = "#167ff6";
					perfil.style.display = "inline-block";
				break;
				case 3:
					mensagensOPT.style.backgroundColor = "#167ff6";
					mensagens.style.display = "inline-block";
				break;
				case 4:
					eventosOPT.style.backgroundColor = "#167ff6";
					eventos.style.display = "inline-block";
				break;
				case 5:
					licencaOPT.style.backgroundColor = "#167ff6";
					licenca.style.display = "inline-block";
				break;
				case 6:
					ferramentasOPT.style.backgroundColor = "#167ff6";
					ferramentas.style.display = "inline-block";
				break;
				case 7:
					arquivosOPT.style.backgroundColor = "#167ff6";
					arquivos.style.display = "inline-block";
				break;
				default:
			}	
		}
		
		function limpaMenu()
		{
			inicioOPT.style.backgroundColor = "transparent";
			perfilOPT.style.backgroundColor = "transparent";
			mensagensOPT.style.backgroundColor = "transparent";
			eventosOPT.style.backgroundColor = "transparent";
			licencaOPT.style.backgroundColor = "transparent";
			ferramentasOPT.style.backgroundColor = "transparent";
			arquivosOPT.style.backgroundColor = "transparent";
		}
		
		function limpaFrames()
		{
			inicio.style.display = "none";
			perfil.style.display = "none";
			mensagens.style.display = "none";
			eventos.style.display = "none";
			licenca.style.display = "none";
			ferramentas.style.display = "none";
			arquivos.style.display = "none";
		}
		
		inicioOPT.onclick = function()
		{
			menuVal = 1;
			menuOpcoes();
		}
		
		perfilOPT.onclick = function()
		{
			menuVal = 2;
			menuOpcoes();
		}
		
		mensagensOPT.onclick = function()
		{
			menuVal = 3;
			menuOpcoes();
		}
		
		eventosOPT.onclick = function()
		{
			menuVal = 4;
			menuOpcoes();
		}
		
		licencaOPT.onclick = function()
		{
			menuVal = 5;
			menuOpcoes();
		}
		
		ferramentasOPT.onclick = function()
		{
			menuVal = 6;
			menuOpcoes();
		}
		
		arquivosOPT.onclick = function()
		{
			menuVal = 7;
			menuOpcoes();
		}
		
		sairOPT.onclick = function()
		{
			this.onclick = "";
			window.location.href='php/Logout.php';
		}
		
		
		<?php
			if ($tutorial == 0)
			{
		?>
				chk_naoMostrar.onchange = function()
				{
					if (this.checked)
					{
						this.value = 1;
					}
					else
					{
						this.value = 0;
					}
				}
		<?php
			}
		?>
		
		
		<?php
			if ($tutorial == 0)
			{
		?>
				$("#fecha_text_tuto").click
				(
					function(event)
					{
						event.preventDefault();
						$("#tuto").fadeOut(500);
						Ajax("GET", "php/MudarTutorial.php", "tutorial=" + chk_naoMostrar.value, "");
					}
				);
		<?php
			}
		?>
		
		
		function om()
		{
			dnot.style.display = "inline-block";
		}
		
		function ob()
		{
			dnot.style.display = "none";
		}
		
		function ascd()
		{
			if(all.style.backgroundColor == "rgb(238, 238, 238)" || all.style.backgroundColor == "")
			{
				all.style.backgroundColor = "black";
				dnot.innerHTML = "Design Noturno Ativado";
				dnot.style.color = "white";
				etLampLuiz.src = "imagens/etLamp.png";
				
				noturno = 1;
			}
			else
			{
				all.style.backgroundColor = "rgb(238, 238, 238)";
				dnot.innerHTML = "Design Noturno Desativado";
				dnot.style.color = "black";
				etLampLuiz.src = "imagens/etLamp_dark.png";
				
				noturno = 0;
			}
			
			Ajax("GET", "php/MudarNoturno.php", "noturno=" + noturno, "");
		}
		
		
	</script>
</html>