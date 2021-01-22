<?php
	include ("php/Conexao.php");
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );

	date_default_timezone_set( 'America/Sao_Paulo' );
	
	session_start();
	$codigo = $_SESSION['EletronTech']['codigo'];
		
	$query_Busca = "select * from tb_usuario where cd_usuario = '$codigo'";
			
	$result_Busca = mysql_query($query_Busca) or die(mysql_error());
	$linha_Busca = mysql_fetch_assoc($result_Busca);
	$totalLinha_Busca = mysql_num_rows($result_Busca);

	$query_Busca_Utilizacao = "select tb_ferramenta.cd_ferramenta, tb_ferramenta.nm_ferramenta, tb_ferramenta.nm_url_imagem, tb_ferramenta.nm_url_ferramenta, count(tb_utilizacao.cd_ferramenta) as utilizacoes
									from tb_usuario inner join usuario_pacote
										on tb_usuario.cd_usuario = usuario_pacote.cd_usuario
											inner join tb_pacote
												on usuario_pacote.cd_pacote = tb_pacote.cd_pacote
													inner join pacote_ferramenta
														on tb_pacote.cd_pacote = pacote_ferramenta.cd_pacote
															inner join tb_ferramenta
																on pacote_ferramenta.cd_ferramenta = tb_ferramenta.cd_ferramenta
																	inner join tb_utilizacao
																		on tb_ferramenta.cd_ferramenta = tb_utilizacao.cd_ferramenta
																			where tb_usuario.cd_usuario = '$codigo' and tb_utilizacao.cd_usuario = '$codigo'
																				group by tb_utilizacao.cd_ferramenta
																					order by utilizacoes desc limit 5;";
			
	$result_Busca_Utilizacao = mysql_query($query_Busca_Utilizacao) or die(mysql_error());
	$linha_Busca_Utilizacao = mysql_fetch_assoc($result_Busca_Utilizacao);
	$totalLinha_Busca_Utilizacao = mysql_num_rows($result_Busca_Utilizacao);
	
	$query_Busca_Utilizacao3 = "select tb_ferramenta.cd_ferramenta, tb_ferramenta.nm_ferramenta, tb_ferramenta.nm_url_imagem, tb_ferramenta.nm_url_ferramenta, count(tb_utilizacao.cd_ferramenta) as utilizacoes
									from tb_usuario inner join usuario_pacote
										on tb_usuario.cd_usuario = usuario_pacote.cd_usuario
											inner join tb_pacote
												on usuario_pacote.cd_pacote = tb_pacote.cd_pacote
													inner join pacote_ferramenta
														on tb_pacote.cd_pacote = pacote_ferramenta.cd_pacote
															inner join tb_ferramenta
																on pacote_ferramenta.cd_ferramenta = tb_ferramenta.cd_ferramenta
																	inner join tb_utilizacao
																		on tb_ferramenta.cd_ferramenta = tb_utilizacao.cd_ferramenta
																			where tb_usuario.cd_usuario = '$codigo' and tb_utilizacao.cd_usuario = '$codigo'
																				group by tb_utilizacao.cd_ferramenta
																					order by utilizacoes desc limit 3;";
			
	$result_Busca_Utilizacao3 = mysql_query($query_Busca_Utilizacao3) or die(mysql_error());
	$linha_Busca_Utilizacao3 = mysql_fetch_assoc($result_Busca_Utilizacao3);
	$totalLinha_Busca_Utilizacao3 = mysql_num_rows($result_Busca_Utilizacao3);
	
	$query_Busca_Evento = "select * from tb_evento where dt_evento >= curdate() and cd_usuario = '$codigo' order by dt_evento";
	$result_Busca_Evento = mysql_query($query_Busca_Evento) or die(mysql_error());
	$linha_Busca_Evento = mysql_fetch_assoc($result_Busca_Evento);
	$totalLinha_Busca_Evento = mysql_num_rows($result_Busca_Evento);
	
	
	$query_Busca_Projeto = "select tb_usuario.cd_usuario, tb_usuario.nm_usuario, tb_projeto.cd_projeto, tb_projeto.nm_projeto
							  from tb_usuario inner join tb_projeto
								on tb_usuario.cd_usuario = tb_projeto.cd_usuario
								  where tb_usuario.cd_usuario = '$codigo'";
								  
	$result_Busca_Projeto = mysql_query($query_Busca_Projeto) or die(mysql_error());
	$linha_Busca_Projeto = mysql_fetch_assoc($result_Busca_Projeto);
	$totalLinha_Busca_Projeto = mysql_num_rows($result_Busca_Projeto);
	
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Favoritos</title>
		<style>
		*
		{
			margin: 0;
			padding: 0;
			font-family: Century Gothic;
			outline: none;
			cursor: hand;
			font-size: 10px;
			
		}
		
		body
		{
			background-color: transparent;
			overflow: hidden;
		}
		
		#all
		{
			display: inline-block;
			position: absolute;
			width: 1000px;
			height: 500px;
			margin-left: -500px;
			margin-top: -270px;
			left: 50%;
			top: 50%;
			background-color: transparent;
			
		}
		
		#player
		{
			display: inline-block;
			background-color: #000000;
			width: 700px;
			height: 350px;
			margin: 25px;
			box-shadow: 0px 0px 5px 0px gray;
		}
		
		#barraDireita
		{
			display: inline-block;
			width: 230px;
			position: absolute;
			margin-top: 25px;
			background-color: transparent;
		}
		
		#mensagens, #projetos, #eventos, #recentes
		{
			display: inline-block;
			width: 225px;
			height: 100px;
			background-color: #1F5CB1;
			margin-bottom: 25px;
			box-shadow: 0px 0px 5px 0px gray;
		}
		
		<?php
			if ($totalLinha_Busca_Evento == 0)
			{
		?>
				#eventos
				{
					background-color: black !important;
				}
				
				#eventos:hover
				{
					background: black !important;
				}
		<?php
			}
		?>
		
		<?php
			if ($totalLinha_Busca_Projeto == 0)
			{
		?>
				#projetos
				{
					background-color: black !important;
				}
				
				#projetos:hover
				{
					background: black !important;
				}
		<?php
			}
		?>
		
		#recentes
		{
			background-color: black;
			z-index: 9999;
		}
		
		
		#mensagens:hover, #projetos:hover, #eventos:hover
		{
			background: linear-gradient(#167ff6, #1F5CB1);
		}
		
		
		#recentes:hover
		{
			background-color: black;
		}
		
		#barradireita img
		{
			display: inline-block;
			height: 70%;
		}
		
		#barradireita label
		{
			display: inline-block;
			color: white;
			width: 100%;
			
		}
		
		#feiRecentes, #feiRecentes3
		{
			display: inline-block;
			width: 700px;
			height: 100px;
			position: absolute;
			background-color: black;
			margin-left: -725px;
			margin-top: 400px;
		}
		
		#saudacao
		{
			font-size: 36px;
			color: #167ff6;
			margin-left: 25px;
		}
		
		#video
		{
			display: inline-block;
			width: 100%;
			height: 100%;
			cursor: hand;
		}
		
		#subMensagens
		{
			display: none;
			background-color: black;
			width: 225px;
			height:225px;
			position: absolute;
			margin-top: 150px;
			z-index: 9999;
			overflow-x: hidden;
		}
		
		#subMensagens img
		{
			display: inline-block;
			height: 70%;
		}
		
		#msg
		{
			display: inline-block;
			width: 205px;
			height: 50px;
			padding: 10px;
		}	
		
		#msg label
		{
			color: white;
		}
		
		#msg:hover
		{
			background: linear-gradient(#167ff6, #1F5CB1);
		}
		
		#subProjetos
		{
			display: none;
			background-color: black;
			width: 225px;
			height:225px;
			position: absolute;
			margin-top: 150px;
			overflow-x: hidden;
			margin-top: 275px;
			z-index: 9999;
		}
		
		#subProjetos img
		{
			display: inline-block;
			height: 70%;
		}
		
		#pjt
		{
			display: inline-block;
			width: 205px;
			height: 50px;
			padding: 10px;
		}	
		
		#pjt label
		{
			color: white;
		}
		
		#pjt:hover
		{
			background: linear-gradient(#167ff6, #1F5CB1);
		}
		
		#subEventos
		{
			display: none;
			background-color: black;
			width: 225px;
			height:225px;
			position: absolute;
			margin-top: 150px;
			overflow-x: hidden;
			margin-top: 25px;
			z-index: 9999;
		}
		
		#subEventos img
		{
			display: inline-block;
			height: 70%;
		}
		
		#evt
		{
			display: inline-block;
			width: 205px;
			height: 50px;
			padding: 10px;
		}	
		
		#evt label
		{
			color: white;
		}
		
		#evt:hover
		{
			background: linear-gradient(#167ff6, #1F5CB1);
		}
		
		#play
		{
			display: inline-block;
			width: 100px;
			height: 100px;
			position: absolute;
			margin-top: 145px;
			margin-left: -425px;
		}
		
		#playing
		{
			width:  100px;
			border: 0px;
			font-size: 100px;
			color: #167ff6;
			background-color: transparent;
		}
		
		#playing:hover
		{
			color: #7dd4f6;
			text-shadow: 0px 0px 50px #167ff6;
		}
		
		#feiRecentes, #feiRecentes3
		{
			display: inline-block;
			background-color: #292929;
			width: 950px;
			height: 100px;
			z-index: 9999;
			box-shadow: 0px 0px 4px 0px gray;
		}
		
		#feiRecentes img
		{
			display: inline-block;
			height: 70%;
		}
		
		#feiRecentes3 img
		{
			display: inline-block;
			height: 70%;
		}
		
		#feiTop
		{
			display: inline-block;
			width: 157px;
			height: 100px;
			padding-left: 15px;
			padding-right:15px;
			position: relative;
		}	
		
		#feiTop label
		{
			color: white;
		}
		
		#feiTop:hover
		{
			background: linear-gradient(#167ff6, #1F5CB1);
		}
		
		
		
		#etLogo
		{
			margin-left: 20px;
			width: 50px;
			margin-bottom: -15px;
		}
				
		::-webkit-scrollbar
		{
			height: 100px;
			width: 10px;
			background: #383838;
			
		}
		
		::-webkit-scrollbar-thumb
		{
			background: #167ff6;
			-webkit-box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.75);
		}

		::-webkit-scrollbar-corner
		{
			background: #000;
		}
		
		</style>
	</head>
	<body>
		<input id="ss" type="hidden" value="<?php echo $linha_Busca['nm_usuario']; ?>">
		<div id="all">
			<img id="etLogo" src="imagens/logo/logoblue.png">
				<label id="saudacao"></label>
			<div id="player">
				<video src="ET.mp4" id="video">
			</div>
			
			<!-- Ferramentas Recentes-->
			
			<div id="feiRecentes">
				<!--Codigo a ser utilizado para gerar links-->
				<?php
					do
					{
				?>
					<div id="feiTop" align="center" <?php if ($linha_Busca_Utilizacao['nm_ferramenta'] == "") {echo "style='display: none;'";} ?> onclick="parent.ferramentas.src = 'ferramentas.php?urlFerramenta=<?php $aux = str_replace("/", "barra", $linha_Busca_Utilizacao['nm_url_ferramenta']); $aux = str_replace(".", "ponto", $aux); echo $aux; ?>&codigoFerramenta=<?php echo $linha_Busca_Utilizacao['cd_ferramenta']; ?>'; parent.ferramentasOPT.click();">
						<img src="<?php echo $linha_Busca_Utilizacao['nm_url_imagem']; ?>"><br>
						<label><?php echo $linha_Busca_Utilizacao['nm_ferramenta']; ?></label>
					</div>
				<?php
					}
					while ($linha_Busca_Utilizacao = mysql_fetch_assoc($result_Busca_Utilizacao));
				?>
				<!--Fim-->
			</div>
			
			<!-- Limit 3 -->
			<div id="feiRecentes3" style="display: none;">
				<!--Codigo a ser utilizado para gerar links-->
				<?php
					do
					{
				?>
					<div id="feiTop" align="center" <?php if ($linha_Busca_Utilizacao3['nm_ferramenta'] == "") {echo "style='display: none;'";} ?> onclick="parent.ferramentas.src = 'ferramentas.php?urlFerramenta=<?php $aux = str_replace("/", "barra", $linha_Busca_Utilizacao3['nm_url_ferramenta']); $aux = str_replace(".", "ponto", $aux); echo $aux; ?>&codigoFerramenta=<?php echo $linha_Busca_Utilizacao3['cd_ferramenta']; ?>'; parent.ferramentasOPT.click();">
						<img src="<?php echo $linha_Busca_Utilizacao3['nm_url_imagem']; ?>"><br>
						<label><?php echo $linha_Busca_Utilizacao3['nm_ferramenta']; ?></label>
					</div>
				<?php
					}
					while ($linha_Busca_Utilizacao3 = mysql_fetch_assoc($result_Busca_Utilizacao3));
				?>
				<!--Fim-->
			</div>
			
			<!--Fim-->
			
			<div id="barraDireita">
				<div id="mensagens" align="center">								
					<img src="icones/mensagem.png"><br>
					<label>0 Mensagens</label>
				</div>
				
				<div id="projetos" align="center">
					<img src="icones/projetos.png"><br>
					<label><?php if ($totalLinha_Busca_Projeto == 0) {echo $totalLinha_Busca_Projeto." Projetos";} else if ($totalLinha_Busca_Projeto == 1) {echo $totalLinha_Busca_Projeto." Projeto";} else {echo $totalLinha_Busca_Projeto." Projetos";} ?></label>
				</div>
				
				<div id="eventos" align="center">
					<img src="icones/eventos.png"><br>
					<label><?php if ($totalLinha_Busca_Evento == 0) {echo $totalLinha_Busca_Evento." Eventos";} else if ($totalLinha_Busca_Evento == 1) {echo $totalLinha_Busca_Evento." Evento";} else {echo $totalLinha_Busca_Evento." Eventos";} ?></label>
				</div>
			</div>
			
			<!-- DIV SUB MENUS limite de 5 opções-->
				<div id="subMensagens" align="center">
					<div id="msg" align="center">
						<img src="icones/mensagem.png"><br>
						<label>Quem foi?</label>
					</div>
				</div>
				
				
				<div id="subProjetos">
					<?php
						do
						{
							if ($totalLinha_Busca_Projeto != 0)
							{
					?>
								<div id="pjt" align="center">
									<img src="icones/projetos.png"><br>
									<label><?php echo $linha_Busca_Projeto['nm_projeto']; ?></label>
								</div>
					<?php
							}
						}
						while ($linha_Busca_Projeto = mysql_fetch_assoc($result_Busca_Projeto));
					?>
				</div>
				
				<div id="subEventos">
					<?php
						do
						{
							if ($totalLinha_Busca_Evento != 0)
							{
					?>
								<div id="evt" align="center" onclick="parent.eventos.src = 'Eventos.php?cdevento=<?php echo $linha_Busca_Evento['cd_evento']; ?>'; parent.eventosOPT.click();">
									<img src="icones/eventos.png"><br>
									<label><?php echo $linha_Busca_Evento['nm_evento']; ?></label>
								</div>
					<?php
							}
						}
						while ($linha_Busca_Evento = mysql_fetch_assoc($result_Busca_Evento));
					?>
				</div>
				
				<div id="play">
					<input id="playing" type="button" src="icones/play.png" value="►">
				</div>
		</div>
	</body>
	<script>
		window.onload = function()
		{
			ativaMensagens = 0;
			ativaProjetos = 0;
			ativaEventos = 0;
			vidPlay = 0;
			time = 16;
			seg = 0;
			timer();
			sonoCheOre();
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
			
			horario = horaS+":"+minutoS;
			
			if(mes < 10)
			{
				dataHoje = dia+"/0"+mes+"/"+ano;
			}
			else
			{
				dataHoje = dia+"/"+mes+"/"+ano;
			}
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
			nm = ss.value;
			primeiroNome = nm.split(" ");
			saudacao.innerHTML = ora + primeiroNome[0];
		}
		
		mensagens.onmouseup = function()
		{
			if(ativaMensagens == 0)
			{
				limpaSub();
				subMensagens.style.display="inline-block";
				ativaMensagens = 1;
				mensagens.style.backgroundColor = "#167ff6";
			}
			else
			{
				subMensagens.style.display="none";
				ativaMensagens = 0;
				mensagens.style.backgroundColor = "#1F5CB1";
			}
		}
		
		<?php
			if ($totalLinha_Busca_Projeto != 0)
			{
		?>
				projetos.onmouseup = function()
				{
					if(ativaProjetos == 0)
					{
						limpaSub();
						subProjetos.style.display="inline-block";
						ativaProjetos= 1;
						projetos.style.backgroundColor = "#167ff6";
						feiRecentes3.style.width = "700px";
						feiRecentes.style.display = "none";
						feiRecentes3.style.display = "inline-block";
					}
					else
					{
						subProjetos.style.display="none";
						ativaProjetos = 0;
						projetos.style.backgroundColor = "#1F5CB1";
						feiRecentes.style.width = "950px";
						feiRecentes.style.display = "inline-block";
						feiRecentes3.style.display = "none";
					}
				}
		<?php
			}
		?>
		
		<?php
			if ($totalLinha_Busca_Evento != 0)
			{
		?>
				eventos.onmouseup = function()
				{
					if(ativaEventos == 0)
					{
						limpaSub();
						subEventos.style.display = "inline-block";
						ativaEventos = 1;
						eventos.style.backgroundColor = "#167ff6";
					}
					else
					{
						subEventos.style.display = "none";
						ativaEventos = 0;
						eventos.style.backgroundColor = "#1F5CB1";
					}
				}
		<?php
			}
		?>
		
		function limpaSub()
		{
			feiRecentes.style.width = "950px";
			ativaMensagens = 0;
			ativaProjetos = 0;
			ativaEventos = 0;
			subProjetos.style.display="none";
			subMensagens.style.display="none";
			subEventos.style.display = "none";
			mensagens.style.backgroundColor = "#1F5CB1";
			projetos.style.backgroundColor = "#1F5CB1";
			eventos.style.backgroundColor = "#1F5CB1";
		}
		
		playing.onclick = function()
		{
			playpause();
		}
		
		video.onclick = function()
		{
			playpause();
		}
		
		playing.onmouseover = function()
		{
			enterPlay();
		}
		
		playing.oumouseout = function()
		{
			outPlay();
		}
		
		video.onmouseover = function()
		{
			enterPlay();
		}
		
		video.onmouseout = function()
		{
			outPlay();
		}
		
		function enterPlay()
		{
			if(vidPlay == 1)
			{
				playing.style.opacity = "0.5";
			}
		}
		
		function outPlay()
		{
			if(vidPlay == 1)
			{
				playing.style.opacity = "0.0";
			}
		}
		
		
		function playpause()
		{
			if(vidPlay == 0)
			{
				playVideo();
			}
			else
			{
				pauseVideo();
			}
		}
		
		function playVideo()
		{
			playing.style.opacity = "0.0";
			video.play();
			vidPlay = 1;
			playing.value = "■";
			playing.style.fontSize = "140px";
			play.style.marginTop = "105px";
			play.style.marginLeft = "-430px";
			finalizar();
		}
		
		function pauseVideo()
		{
			playing.style.opacity = "1";
			video.pause();
			vidPlay = 0;
			playing.style.fontSize = "100px";
			play.style.marginTop = "145px";
			play.style.marginLeft = "-425px";
			playing.value = "►";
		}
		
		function finalizar()
		{
			if(seg <= time)
			{
				if(vidPlay == 1)
				{
					setTimeout('finalizar()',1000);
					seg++;
				}
			}
			else
			{
				pauseVideo();
				seg = 0;
			}
		}
		
		document.onkeydown = KeyCheck;
		function KeyCheck()
		{
		   var KeyID = event.keyCode;
		   switch(KeyID)
		   {
			  case 40:
			  //parent.ativarMenu();
				parent.perfilOPT.click();
				parent.perfil.focus();
			  break;
			  default:
			  break;
		   }
		}
		
		window.onclick = function()
		{
			parent.desativarMenu();
		}
	</script>
</html>

<?php
	mysql_close($conexao);
?>