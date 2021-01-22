<?php
	include "../php/Conexao.php";
	
	session_start();
	
	$codigoFerramenta = base64_decode($_GET['cd']);
	$codigoFerramenta = mysql_escape_string($codigoFerramenta);
	
	$codigoUsuario	= $_SESSION['EletronTech']['codigo'];
	
	include "../php/Utilizacao.php";
	
	$nm_projeto = mysql_escape_string($_POST['nm_projeto']);
	$altura = mysql_escape_string($_POST['altura']);
	$largura = mysql_escape_string($_POST['largura']);
	$comprimento = mysql_escape_string($_POST['comprimento']);

	$desen = mysql_escape_string($_POST['desenvolvimento']);
	$sistema = mysql_escape_string($_POST['sistema_fornecimento']);
	
	$query = "select cd_projeto, nm_projeto, cd_usuario from tb_projeto where nm_projeto = '$nm_projeto' and cd_usuario = '$codigoUsuario'";
	$result = mysql_query($query);
	$linha = mysql_fetch_assoc($result);
	
	if (mysql_num_rows($result) == 0)
	{
		$query = mysql_query("insert into tb_projeto values(NULL, '$nm_projeto', '$desen', $altura, $largura, $comprimento, '$sistema', $codigoUsuario)") or die ("Já existe um projeto com esse nome. ERRO: " . mysql_error());
		
		$query = "select cd_projeto, nm_projeto, cd_usuario from tb_projeto where nm_projeto = '$nm_projeto' and cd_usuario = '$codigoUsuario'";
		$result = mysql_query($query);
		$linha = mysql_fetch_assoc($result);
		
		echo '<script> cdProjeto = '.$linha['cd_projeto'].'; </script>';
	}
	else
	{
		echo '<script> cdProjeto = '.$linha['cd_projeto'].'; </script>';
	}
	
?>

<html>
	<head>
		<link rel="shortcut icon" href="../../imagens/logo/logo.ico" />
		<meta charset="utf-8">
		<title>Diagramação de Projetos</title>
		<style type="text/css">
		@import url("css/diagramacao.css");
		*
		{
			font-family: century Gothic;
		}
		
		::-webkit-scrollbar
		{
			height: 12px;
			width: 12px;
			background: #c0c0c0;
			
		}
		
		::-webkit-scrollbar-thumb
		{
			background: #909090;
			-webkit-box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.75);
		}

		::-webkit-scrollbar-corner
		{
			background: #909090;
		}
		
		#dadodos
		{
			position: absolute;
			background-color: red;
			margin-left: 60%;
			z-index: 9999;
		}
		
		#topo
		{
			display: inline-block;
			background-color: black;
			height: 40px;
			width: 100%;
			position: absolute;
			box-shadow: 0px 0px 4px 0px gray;
			z-index: 9999;
			color: white;
			
		}
		
		#topo label
		{
			display: inline-block;
			color: white;
			font-size: 20px;
			margin-top:5px;
			margin-left: -95px;
		}
		
		#giu
		{
			dispaly: inline-block;
			width: 100%;
			height: 40px;
			color: white;
			background-color: black;
			position: absolute;
			bottom: 0;
			left: 0;
		}
		
		#giu label
		{
			display:inline-block;
			width: 100%;
			font-family: Century Gothic;
			color: white;
			margin-left: -95px;
		}
		
		#propriedades
		{
			display: inline-block;
			width: 100%;
			height:100%;
			background-color: gray;
			margin-top: 17.5%;
		}
		
		#topPro, #topComp
		{
			display: inline-block;
			color: black;
			background-color: #7a7a7a;
			width: 100%;
			font-size: 14px;
			font-weight: bold;
			padding: 5px;
		}
		
		
		#dadosPropriedades
		{
			display: inline-block;
			width: 100%;
			height: 30%;
			background-color: black;
			overflow: hidden;
		}
		
		#dadosComponentes
		{
			display: inline-block;
			width: 100%;
			height: 100%;
			background-color: black;
		}
		
		.buttonComp
		{
			display: inline-block;
			width: 100%;
			background-color: #3e3e3e;
			border: 0px;
			color: #00abff;
			text-align: left;
			padding: 5px;
			margin-bottom: 2px;
		}
		
		#grupoComodo, #grupoEsquadria, #grupoTomada,
		#grupoLampada, #grupoInterruptor, #grupoDisjuntor,
		#grupoCircuito, #grupoConduite, #grupoCondutor, #grupoQuadro
		{
			display: none;
			
		}
		
		.grupoComponentes
		{
			display: inline-block;
			background-color: gray;
			width: 96%;
			height: 15%;
			overflow: auto;
			font-size: 14px;
			padding:2%;
		}
		
		.dadosPro
		{
			display: inline-block;
			width: 100%;
			padding: 5px;
			
		}
		
		.dadosPro table label
		{
			font-size: 12px;
		}
		
		.dadosPro table input
		{
			display: inline-block;
			width: 80%;
			background-color: black;
			border: 0px;
			color: #00abff;
			text-align: left;
			margin-left: 10%;
		}
		
		.dadosPro table .dtito
		{
			width: 100%;
			margin-left: 0%;
			font-size: 16px;
			margin-bottom: 5px;
		}
		
		#dadosComodo, #dadosEsquadria, #dadosTomadas,
		#dadosLampadas, #dadosInterruptores,
		#dadosCircuitos, #dadosConduites, #dadosCondutores
		{
			display: none;
		}
		
		.subButtonsComp
		{
			display: inline-block;
			width: 100%;
			background-color: transparent;
		}
		
		#dadosComodo
		{
			display: none;
		}
		
		.subss
		{
			display: inline-block;
			width: 80%;
			margin-left: 10%;
			margin-top:5px;
		}
		
		.subss img		
		{
			display: inline-block;
			width: 30px;
			height: 30px;
		}
		
		.subss img:hover
		{
			background-color: #00abff;
		}
		
		.selectComp
		{
			display: inline-block;
			width:100%;
			background-color: transparent;
			border: 0px;
			overflow: hidden;
			
		}
		
		.selectComp option
		{
			padding-left: 5%;
			color: black;
			font-weight: normal;
		}
		
		.selectComp option:hover
		{
			background-color: #cccccc;
			color: black;
		}
		
		#menuSave
		{
			display: none;
			width: 500px;
			height:300px;
			margin-left: -250px;
			margin-top: -150px;
			left:50%;
			top: 50%;
			position: absolute;
			background-color: #00abff;
			z-index: 9999;
			box-shadow: 0px 0px 0px 2px #00abff;
		}
		
		#menuSave table
		{
			dsiplay:inline-block;
			width: 500px;
			margin-top:10%;
		}
		
		#menuSave table img
		{
			width: 50%;
		}
		
		#menuSave table img:hover
		{
			background-color: #0095f0;
		}
		
		#savePjt
		{
			display: inline-block;
			margin-top:5%;
			width: 100%;
			font-size: 26px;
			color: white;
		}
		
		
		#legSave
		{
			font-size:12x;
			color: white;
		}
		
		#cbr
		{
			display: none;
			background-color: black;
			position: fixed;
			top: 40px;
			width: 100%;
			height: 100%;
			opacity: 0.7;
			z-index: 9998;
		}
		
		</style>
	</head>
	<body>
		<div id="all">
			<div id="topo" align="center">
				<label>Projeto <?php echo $nm_projeto ?></label>
			</div>
				<div id="menuEsquerda">
					<table id="menu">
						<tr>
							<td>
								<input type="image" src="icones/logo.png" id="master">
							</td>
						</tr>
						
						<!--Botão 1-->
						<tr>
							<td>
								<input type="image" src="icones/selecionar.png" id="btn_selecionar_1" onClick="captID(this.id)">
							</td>
						</tr>
						
						<!--Botão 2-->
						<tr>
							<td>
								<input type="image" src="icones/desenhar.png" id="btn_desenhar_2" onClick="captID(this.id)">
							</td>
						</tr>
						
						<!--Botão 1-->
						<tr>
							<td>
								<input type="image" src="icones/esquadria.png" id="btn_esquadria_3" onClick="captID(this.id)">
							</td>
						</tr>
						
						<!--Botão 1-->
						<tr>
							<td>
								<input type="image" src="icones/lampada.png" id="btn_lampada_4" onClick="captID(this.id)">
							</td>
						</tr>
						
						<!--Botão 1-->
						<tr>
							<td>
								<input type="image" src="icones/tomada.png" id="btn_tomada_5" onClick="captID(this.id)">
							</td>
						</tr>
						
						<!--Botão 1-->
						<tr>
							<td>
								<input type="image" src="icones/interruptor.png" id="btn_interruptor_6" onClick="captID(this.id)">
							</td>
						</tr>
						
						<!--Botão 1-->
						<tr>
							<td>
								<input type="image" src="icones/condutores.png" id="btn_condutor_7" onClick="captID(this.id)">
							</td>
						</tr>
						
						<!--Botão 1-->
						<tr>
							<td>
								<input type="image" src="icones/quadro.png" id="btn_quadro_8" onClick="captID(this.id)">
							</td>
						</tr>
						
						<!--Botão 1-->
						<tr>
							<td>
								<input type="image" src="icones/conduites.png" id="btn_conduite_9" onClick="captID(this.id)">
							</td>
						</tr>
						
						<!--Botão 1-->
						<tr>
							<td>
								<input type="image" src="icones/circuito.png" id="btn_circuito_10" onClick="captID(this.id)">
							</td>
						</tr>
						
						<!--Botão 1-->
						<tr>
							<td>
								<input type="image" src="icones/zoom.png" id="btn_zoom_11" onClick="captID(this.id)">
							</td>
						</tr>
						
						<!--Botão 1-->
						<tr>
							<td>
								<input type="image" src="icones/excluir.png" id="btn_excluir_12" onClick="captID(this.id)">
							</td>
						</tr>
						
						<!--Botão 1-->
						<tr>
							<td>
								<input type="image" src="icones/desfazer.png" id="btn_desfazer_13" onClick="captID(this.id)">
							</td>
						</tr>
						
						<!--Botão 1-->
						<tr>
							<td>
								<input type="image" src="icones/refazer.png" id="btn_refazer_14" onClick="captID(this.id)">
							</td>
						</tr>
						
						<!--Botão 1-->
						<tr>
							<td>
								<input type="image" src="icones/sair.png" id="btn_sair_15" onClick="captID(this.id)">
							</td>
						</tr>
					</table>
				</div>
				
				<table id="subMenuEsquadria">
						<tr>
							<td>
								<input type="image" src="icones/porta.png" onclick="subEsquadria(1)">
							</td>
							<td>
								<input type="image" src="icones/janela.png" onclick="subEsquadria(2)">
							</td>
						</tr>
					</table>
					
					<!--SubmenuLampadas-->
					<table id="subMenuLampadas">
						<tr>
							<td>
								<input type="image" src="icones/ip.png" onclick="subLampadas(1)">
							</td>
							<td>
								<input type="image" src="icones/fp.png" onclick="subLampadas(2)">
							</td>
							<td>
								<input type="image" src="icones/it.png" onclick="subLampadas(3)">
							</td>
							<td>
								<input type="image" src="icones/ft.png" onclick="subLampadas(4)">
							</td>
							<td>
								<input type="image" src="icones/fet.png" onclick="subLampadas(5)">
							</td>
							<td>
								<input type="image" src="icones/iet.png" onclick="subLampadas(6)">
							</td>
						</tr>
					</table>
					
					
					<!--Submenutomadas-->
					<table id="subMenuTomadas">
						<tr>
							<td>
								<input type="image" src="icones/tug_baixa.png" onclick="subTomadas(1)">
							</td>
							<td>
								<input type="image" src="icones/tug_media.png" onclick="subTomadas(2)">
							</td>
							<td>
								<input type="image" src="icones/tug_alta.png" onclick="subTomadas(3)">
							</td>
						</tr>
					</table>
					
					
					<!--SubmenuInterruptores-->
					<table id="subMenuInterruptores">
						<tr>
							<td>
								<input type="image" src="icones/interruptor_s1.png" onclick="subInterruptores(1)">
							</td>
							<td>
								<input type="image" src="icones/interruptor_s2.png" onclick="subInterruptores(2)">
							</td>
							<td>
								<input type="image" src="icones/interruptor_s3.png" onclick="subInterruptores(3)">
							</td>
							<td>
								<input type="image" src="icones/interruptor_s3w.png" onclick="subInterruptores(4)">
							</td>
							<td>
								<input type="image" src="icones/interruptor_s4w.png" onclick="subInterruptores(5)">
							</td>
						</tr>
					</table>
					
					<!--SubmenuCondutores-->
					<table id="subMenuCondutores">
						<tr>
							<td>
								<input type="image" src="icones/condutor_neutro.png" onclick="subCondutores(1)">
							</td>
							<td>
								<input type="image" src="icones/condutor_fase.png" onclick="subCondutores(2)">
							</td>
							<td>
								<input type="image" src="icones/condutor_terra.png" onclick="subCondutores(3)">
							</td>
							<td>
								<input type="image" src="icones/condutor_retorno.png" onclick="subCondutores(4)">
							</td>
						</tr>
					</table>
					
					<!--SubmenuQuadro-->
					<table id="subMenuQuadros">
						<tr>
							<td>
								<input type="image" src="icones/quadro_parcial.png" onclick="subQuadro(1)">
							</td>
							<td>
								<input type="image" src="icones/quadro_geral.png" onclick="subQuadro(2)">
							</td>
						</tr>
					</table>
					
					<!--SubmenuConduites-->
					<table id="subMenuConduites">
						<tr>
							<td>
								<input type="image" src="icones/es.png" onclick="subEletrodutos(1)">
							</td>
							<td>
								<input type="image" src="icones/ed.png" onclick="subEletrodutos(2)">
							</td>
							<td>
								<input type="image" src="icones/eps.png" onclick="subEletrodutos(3)">
							</td>
							<td>
								<input type="image" src="icones/epd.png" onclick="subEletrodutos(4)">
							</td>
						</tr>
					</table>
					
					<!--SubmenuConduites-->
					<table id="subMenuZoom">
						<tr>
							<td>
								<input type="image" src="icones/zoom_mais.png" onclick="subZoom(1)">
							</td>
							<td>
								<input type="image" src="icones/zoom_menos.png" onclick="subZoom(2)">
							</td>
						</tr>
					</table>
					
					<div id="painelDesenho">
					
					</div>
				
				<div id="barraDireita">
					<div id="propriedades">
						<h1 id="topPro">Propriedades</h1>
						<div id="dadosPropriedades">
							<!-- Propriedades: Comodo-->
							<div id="dadosComodo" class="dadosPro">
								<table>
									<tr>
										<td colspan="2">
											<input id="nomeComodoD" class="dtito">
										</td>
									</tr>
									<tr>
										<td>
											<label>Tipo:</label>
										</td>
										<td>
											<input id="tipoComodoD">
										</td>
									</tr>
									<tr>
										<td>
											<label>Altura:</label>
										</td>
										<td>
											<input id="alturaComodoD">
										</td>
									</tr>
									<tr>
										<td>
											<label>Largura:</label>
										</td>
										<td>
											<input id="largComodoD">
										</td>
									</tr>
									<tr>
										<td>
											<label>Comprimento:</label>
										</td>
										<td>
											<input id="compComodoD">
										</td>
									</tr>
									<tr>
										<td>
											<label>Área:</label>
										</td>
										<td>
											<input id="areaComodoD">
										</td>
									</tr>
									<tr>
										<td>
											<label>Perimetro:</label>
										</td>
										<td>
											<input id="perimetroComodoD">
										</td>
									</tr>
								</table>
								<table align="center" class="subss">
									<tr align="center">
										<td>
											<img src="icones/tomada.png" class="cComodosSub" id="comodoSubTomada">
										</td>
										
										<td>
											<img src="icones/lampada.png" class="compComodosSub" id="comodoSubLampada">
										</td>
										
										<td>
											<img src="icones/esquadria.png" class="compComodosSub" id="comodoSubEsquadrias">
										</td>
										
										<td>
											<img src="icones/interruptor.png" class="compComodosSub" id="comodoSubInterruptores">
										</td>
									</tr>
									<tr align="center">
										<td  colspan="4">
											<label id="legendaComodo"></label>
										</td>
									</tr>
								</table>
							</div>
							<!--Fim-->
							
							<!-- Propriedades: Esquadria-->
							<div id="dadosEsquadria" class="dadosPro">
								<table>
									<tr>
										<td colspan="2">
											<input id="nomeEsquadriaD" class="dtito">
										</td>
									</tr>
									<tr>
										<td>
											<label>Tipo:</label>
										</td>
										<td>
											<input id="tipoEsquadriaD">
										</td>
									</tr>
									<tr>
										<td>
											<label>Altura:</label>
										</td>
										<td>
											<input id="alturaEsquadriaD">
										</td>
									</tr>
									<tr>
										<td>
											<label>Largura:</label>
										</td>
										<td>
											<input id="largEsquadriaD">
										</td>
									</tr>
									<tr>
										<td>
											<label>Altura Inicial:</label>
										</td>
										<td>
											<input id="altInicialEsquadriaD">
										</td>
									</tr>
								</table>
							</div>
							<!--Fim-->
							
							<!-- Propriedades: Tomadas-->
							<div id="dadosTomadas" class="dadosPro">
								<table>
									<tr>
										<td colspan="2">
											<input id="nomeTomadaD" class="dtito">
										</td>
									</tr>
									<tr>
										<td>
											<label>Tipo:</label>
										</td>
										<td>
											<input id="tipoTomadaD">
										</td>
									</tr>
									<tr>
										<td>
											<label>Altura:</label>
										</td>
										<td>
											<input id="alturaTomadaD">
										</td>
									</tr>
								<!--	<tr>
										<td>
											<label>Posicionamento:</label>
										</td>
										<td>
											<input id="posTomadaD">
										</td>
									</tr>-->
									<tr>
										<td>
											<label>Potência:</label>
										</td>
										<td>
											<input id="potenciaTomadaD">
										</td>
									</tr>
								</table>
							</div>
							<!--Fim-->
							
							<!-- Propriedades: Lampadas-->
							<div id="dadosLampadas" class="dadosPro">
								<table>
									<tr>
										<td colspan="2">
											<input id="nomeLampadaD" class="dtito">
										</td>
									</tr>
									<tr>
										<td>
											<label>Tipo:</label>
										</td>
										<td>
											<input id="tipoLampadaD">
										</td>
									</tr>
									<tr>
										<td>
											<label>Potência:</label>
										</td>
										<td>
											<input id="potenciaLampadaD">
										</td>
									</tr>
									<tr>
										<td>
											<label>Posição(X):</label>
										</td>
										<td>
											<input id="posLampadaXD">
										</td>
									</tr>
									<tr>
										<td>
											<label>Posição(Y):</label>
										</td>
										<td>
											<input id="posLampadaYD">
										</td>
									</tr>
								</table>
							</div>
							<!--Fim-->
							
							<!-- Propriedades: Interruptores-->
							<div id="dadosInterruptores" class="dadosPro">
								<table>
									<tr>
										<td colspan="2">
											<input id="nomeInterruptorD" class="dtito">
										</td>
									</tr>
									<tr>
										<td>
											<label>Tipo:</label>
										</td>
										<td>
											<input id="tipoInterruptorD">
										</td>
									</tr>
									<tr>
										<td>
											<label>Altura:</label>
										</td>
										<td>
											<input id="alturaInterruptorD">
										</td>
									</tr>
									<tr>
										<td>
											<label>Posição (Y):</label>
										</td>
										<td>
											<input id="posInterruptorYD">
										</td>
									</tr>
								</table>
							</div>
							<!--Fim-->
							
							<!-- Propriedades: Interruptores-->
							<div id="dadosCircuitos" class="dadosPro">
								<table>
									<tr>
										<td colspan="2">
											<input id="nomeCircuitoD" class="dtito">
										</td>
									</tr>
									<tr>
										<td>
											<label>Corrente:</label>
										</td>
										<td>
											<input id="correnteCirD">
										</td>
									</tr>
									<tr>
										<td>
											<label>Potência:</label>
										</td>
										<td>
											<input id="potenciaCirD">
										</td>
									</tr>
									<tr>
										<td>
											<label>Tensão:</label>
										</td>
										<td>
											<input id="tensaoCirD">
										</td>
									</tr>
									<tr>
										<td>
											<label>Pontos:</label>
										</td>
										<td>
											<input id="pECirD">
										</td>
									</tr>
									<tr>
										<td>
											<label>Fios</label>
										</td>
										<td>
											<input id="fiosCirD">
										</td>
									</tr>
									<tr>
										<td>
											<label>Bitola:</label>
										</td>
										<td>
											<input id="bitolaCirD">
										</td>
									</tr>
								</table>
							</div>
							<!--Fim-->
							
							<!-- Propriedades: Conduite-->
							<div id="dadosConduites" class="dadosPro">
								<table>
									<tr>
										<td colspan="2">
											<input id="nomeConduiteD" class="dtito">
										</td>
									</tr>
									<tr>
										<td>
											<label>Tipo:</label>
										</td>
										<td>
											<input id="tipoConduiteD">
										</td>
									</tr>
									<tr>
										<td>
											<label>Comprimento:</label>
										</td>
										<td>
											<input id="CompConduiteD">
										</td>
									</tr>
								</table>
							</div>
							<!--Fim-->
							
							<!-- Propriedades: Conduite-->
							<div id="dadosCondutores" class="dadosPro">
								<table>
									<tr>
										<td colspan="2">
											<input id="nomeCondutorD" class="dtito">
										</td>
									</tr>
									<tr>
										<td>
											<label>Tipo:</label>
										</td>
										<td>
											<input id="tipoCondutorD">
										</td>
									</tr>
									<tr>
										<td>
											<label>Bitola:</label>
										</td>
										<td>
											<input id="bitolaCondutorD">
										</td>
									</tr>
									<tr>
										<td>
											<label>Comprimento:</label>
										</td>
										<td>
											<input id="CompConduiteD">
										</td>
									</tr>
								</table>
							</div>
							<!--Fim-->
						</div>
						<h1 id="topComp">Projeto <?php echo $nm_projeto ?></h1>
						<div id="dadosComponentes" align="left">
							
							<input type="button" value="▼ Cômodos" id="btnComodoComp" class="buttonComp">
							<div id="grupoComodo" class="grupoComponentes">							
								<select class="selectComp" size="5" id="selectComodos"> 								 
								</select>
							</div>
							
							<input type="button" value="▼ Esquadrias" id="btnEsquadriaComp" class="buttonComp">
							<div id="grupoEsquadria" class="grupoComponentes">
								<select class="selectComp" size="5" id="selectEsquadrias"> 
								  <?php
									$query =  mysql_query("select cd_esquadria, nm_esquadria from tb_esquadria
															inner join tb_comodo on tb_comodo.cd_comodo = tb_esquadria.cd_comodo
																where cd_projeto = 1 order by nm_esquadria") or die(mysql_error());
									$cont=0;
									while($esquadriasAll = mysql_fetch_array($query))
									{
										$cdEsquadria = $esquadriasAll["cd_esquadria"];
										$nomeEsquadria = $esquadriasAll["nm_esquadria"];
										$cont++;
									?>
									<option value="<?php echo $cdEsquadria; ?>"><?php echo $nomeEsquadria; ?></option>
									<?php
									echo "<script> selectEsquadrias.size = $cont;</script>";
									}
									?>
								</select>
							</div>
							
							<input type="button" value="▼ Tomadas" id="btnTomadaComp" class="buttonComp">
							<div id="grupoTomada" class="grupoComponentes">
								<select class="selectComp" size="5" id="selectTomadas"> 								 
								</select>
							</div>
							
							<input type="button" value="▼ Lampadas" id="btnLampadaComp" class="buttonComp">
							<div id="grupoLampada" class="grupoComponentes">
								<select class="selectComp" size="5" id="selectLampadas"> 
								  <option value="">Nome da Lampada</option>
								</select>
							</div>
							
							<input type="button" value="▼ Interruptores" id="btnInterruptorComp" class="buttonComp">
							<div id="grupoInterruptor" class="grupoComponentes">
								<select class="selectComp" size="5" id="selectInterruptor"> 
								  <option value="">Nome do Interruptor</option>
								</select>
							</div>
							
							<input type="button" value="▼ Disjuntores" id="btnDisjuntorComp" class="buttonComp">
							<div id="grupoDisjuntor" class="grupoComponentes">
								<select class="selectComp" size="5" id="selectDisjuntores"> 
								  <option value="">Nome do Disjuntor</option>
								</select>
							</div>
							
							<input type="button" value="▼ Circuitos" id="btnCircuitoComp" class="buttonComp">
							<div id="grupoCircuito" class="grupoComponentes">
								<select class="selectComp" size="5" id="selectCircuitos"> 
								  <option value="">Nome do Circuito</option>
								</select>
							</div>
							
							<input type="button" value="▼ Conduites" id="btnConduiteComp" class="buttonComp">
							<div id="grupoConduite" class="grupoComponentes">
								<select class="selectComp" size="5" id="selectconduites"> 
								  <option value="">Nome do Conduíte</option>
								</select>
							</div>
							
							<input type="button" value="▼ Condutores" id="btnCondutorComp" class="buttonComp">
							<div id="grupoCondutor" class="grupoComponentes">
								<select class="selectComp" size="5" id="selectCondutores"> 
								  <option value="">Nome do Condutor</option>
								</select>
							</div>
							
							<input type="button" value="▼ Quadros" id="btnQuadroComp" class="buttonComp">
							<div id="grupoQuadro" class="grupoComponentes">
								<select class="selectComp" size="5" id="selectQuadros"> 
								  <option value="">Nome do Quadro</option>
								</select>
							</div>
						</div>
						
					</div>
				</div>
				
				<div id="giu" align="center">
					<input type="text" id="atual">
					<label id="coordenadas"></label>
				</div>
		</div>
		<div id="dadodos">
			
		</div>
		<div id="neuronios">
			<iframe id="ComodoFuncs" src=""></iframe>
		</div>	
		<div id="menuSave">
			<label id="savePjt" align="center"><?php echo $nm_projeto; ?></label>
			<table>
				<tr align="center">
					<td>
						<img src="icones/Save.png">
					</td>
					
					<td>
						<img src="icones/Listas.png">
					</td>
					
					<td>
						<img src="icones/Images.png">
					</td>
				</tr>
				<tr align="center">
					<td>
						<label id="legSave">Salvar Como...</label>
					</td>
					
					<td>
						<label id="legSave">Visualizar Lista</label>
					</td>
					
					<td>
						<label id="legSave">Gerar Imagem</label>
					</td>
				</tr>
				
			</table>
		</div>
		<div id="cbr"></div>
	</body>
	<script type="text/javascript" src="js/etMenuClick.js"></script>
	<script src="kinetic.js"></script>
	<script src="script/ajax.js"></script>
	<script src="script/Cálculos.js"></script>
	<script>
		window.onload = function()
		{
			
			pjtW =  <?php echo $comprimento ?>*20;
			pjtH = <?php echo $largura ?>*20;
			//pre definindo submenus
			esquadriasSM = 1;
			lampadaSM = 1;
			tomadaSM = 1;
			interruptorSM = 1;
			condutorSM = 1;
			quadroSM = 1;
			eletrodutosSM = 1;
			zoomSM = 1;
			//menu = 9;
			//selecionarMenu();
			limpaVar();
			
			escala = 1;
			
			larguraTotal = 25 * 5;
			alturaTotal = 3.5;
			comprimentoTotal = 80 * 5;
			comDraw = 1;
			pdes = 1;
			myS = 1;
			com = 0;
			cTom = 0;
			cQua = 0;
			cCir = 0;
			hist = [];
			hi = 0;
			gerar();
			
			iV = 0;
			arrayPontos = [];
			
			var minX= 0;
			var maxX= (760 - comprimentoTotal) - 20;
			var minY=0;
			var maxY=(570 - larguraTotal) - 20;
			
			Comodos = [];
			Camadas = [];
			btn_desenhar_2.click();
			
			Tomadas = [];
			lampadasTeto = [];
			contLampadas = 0;
			Ancoras = [];
			Quadros = [];
			Circuitos = [];
			fios = 0;
			
			cDis = 0;
		}
		
		function gerar()
		{
			painelDesenho.style.width = pjtW;
			painelDesenho.style.height = pjtH;
			painelDesenho.style.top = "50%";
			painelDesenho.style.left = "50%";
			painelDesenho.style.marginLeft = ((pjtW/2)* -1)-95;
			painelDesenho.style.marginTop = ((pjtH/2) * -1);
			painelDesenho.style.position = "absolute";
			painelDesenho.style.display = "inline-block";
			
			painel = new Kinetic.Stage
			(
				{
					id:'terreno',
					container: 'painelDesenho',
					width: pjtW,
					height: pjtH,
					fill: '#689cc3',
					stroke: 'blue',
					strokeWidth: 10
				}
			);
			
			
		}
			
			
		//click no painel de desenho
		painelDesenho.onclick = function()
		{
			//Zoom
					
			if(menu == 11)
			{
				if(zoomSM == 1)
				{
					if(escala <3)
					{
						escala = escala + 0.1;
						myS = myS - 0.000068;
					}
				}
				else
				{
					if(escala > 0.5)
					{
						escala = escala - 0.1;
						myS = myS + 0.000068;
					}
				}
				painelDesenho.style.transform="scale("+escala+")";	
			}
		}
		
		
		painelDesenho.onmousemove = function()
		{
			cXc = parseInt((event.clientX)) - ((screen.width/2) - (pjtW/2))+75/myS;
			cYc = parseInt((event.clientY)) - ((screen.height/2) - (pjtH/2))+30/myS;
			if((cXc >= 0 && cXc <= (pjtW*15)) && (cYc >= 0 && cYc <= (pjtH*15)))
			{
				coordenadas.innerHTML = "X, Y ["+cXc.toFixed(0)+", "+cYc.toFixed(0)+"]";
			}
			else if(cXc >= (pjtW))
			{
				//alert("i");
			}
			else{}
			
		}
		
		painelDesenho.onmouseout = function()
		{
			coordenadas.innerHTML = "";
		}
		
		painelDesenho.onmouseover = function()
		{
			
			if(menu == 11)
			{
				
			}
			else if(menu == 12)
			{
				painelDesenho.style.cursor= "pointer";
			}
			else
			{
				painelDesenho.style.cursor= "crosshair";
			}
			
		}
		
		painelDesenho.onmousedown = function()
		{
			
			if(comDraw == 1)
			{
				X1 = parseInt((event.clientX)) - ((screen.width/2) - (pjtW/2))+75/myS;
				Y1 = parseInt((event.clientY)) - ((screen.height/2) - (pjtH/2))+30/myS;
				pdes = 1;
			}
			else
			{	
				painelDesenho.style.cursor= "no-drop";
				pdes = 0;
				comDraw = 1;
			}
		}
		
		painelDesenho.onmouseup = function()
		{
			// capturando as coordenadas finais do desenho
			X2 = parseInt((event.clientX)) - ((screen.width/2) - (pjtW/2)) + 75/myS;
			Y2 = parseInt((event.clientY)) - ((screen.height/2) - (pjtH/2))+30/myS;
			
			if(menu == 2 && pdes == 1)
			{		
				var camada = new Kinetic.Layer
				(
					{
						//dragBoundFunc: function(pos)
						//{
						//	conta = comodo.getName();
							//alert(conta);
							
						//	separar = conta.split('i');
						//	WW = parseInt(separar[0]);
						//	HH = parseInt(separar[1]);
						//	var sp = comodo.getId('e2')[0];
						//	
						//	var nY = pos.y < painel.getAbsolutePosition('camada').y-comodo.getY() ? painel.getAbsolutePosition('camada').y-comodo.getY() : pos.y;
						//	var nX = pos.x < painel.getX()-WW ? painel.getX()-WW : pos.x;
						//	return {
						//			x: nX,
						//			y: nY
						//		};
						// },
						id: "o" + com
					}
				);
				
				CalcularComodo();
				
				//criando o objeto que será desenhado
				var comodo = new Kinetic.Rect
				(
					
					{					
						//determinando nome e id do comodo
						
						id: 'o'+com,
						//name: (X2-X1)+'i'+(Y2-Y1),
						//coordenada inicial
						//x: X1+20,
						//y: Y1+15,	
						x: X1,
						y: Y1,						
						//coordenada final
						width: X2 - X1,
						height: Y2 - Y1,
						fill: 'transparent',
						stroke: 'white',
						strokeWidth: 5,
						draggable: false,
						resize: true,
						nome : nmComodo,
						tipo: null,
						xi : xiComodo,
						yi : yiComodo,
						xf : xfComodo,
						yf : yfComodo,
						width: wComodo,
						height: hComodo,
						altura: alturaTotal,
						comprimento : vComprimento,
						largura : vLargura,
						area : vArea,
						perimetro : vPerimetro
					}
				);
				
				function regHist()
				{
					hist[hi] = Comodos[Comodos.length - 1].getName();
					hist[hi] += "|"+Comodos[Comodos.length - 1].getWidth();
					hist[hi] += "|"+Comodos[Comodos.length - 1].getHeight();
					hist[hi] += "|"+Comodos[Comodos.length - 1].getX()+Camadas[Camadas.length - 1].getX();
					hist[hi] += "|"+Comodos[Comodos.length - 1].getY()+Camadas[Camadas.length - 1].getY();
					hi++;
				}
				
				
				inComodo(comodo, camada);
				
				//setProComodos();
				//setDate();
				regHist();
			}
		}
		
		function DesenharCircuito(camada)
		{
			//alert("entrou");
			var index = getIndexOf(Camadas, "attrs.id", camada.attrs.id);
			var pontos = [];
			
			for (cont = 0; cont <= arrayPontos.length - 1; cont = cont + 1)
			{
				pontos.push(arrayPontos[cont].x);
				pontos.push(arrayPontos[cont].y);
			}
			
			var line = new Kinetic.Line
			(
				{
				  id: "circuito" + cCir,
				  x: -16,
				  y: -24,
				  points: pontos,
				  stroke: 'red',
				  tension: 0,
				  comodo: Camadas[index].attrs.id
				}
			);
			
			for (cont = 0; cont <= arrayPontos.length - 1; cont = cont + 1)
			{
				if (arrayPontos[cont].id.indexOf("tomada") != -1)
				{
					ImagemOriginalPonto(arrayPontos[cont].id);
				}
			}
			
			Camadas[index].add(line);
			Camadas[index].draw();
			Circuitos.push(line);
			
			
			arrayPontos.length = 0;
			cCir = cCir + 1;
			
			setProCircuitos();
		}
		
		function CalcularComodo()
		{
			vEscala = 15;
			//Capturando valores do desenho
			nmComodo = "o"+com;
			xiComodo = X1;
			yiComodo = Y1;
			wComodo = X2 - X1;
			hComodo = Y2 - Y1;
			xfComodo = X1 + wComodo;
			yfComodo = Y1 + hComodo;
			
			//Definindo valores em metros
			vComprimento = wComodo / vEscala;
			vLargura = hComodo / vEscala;
			
			vAltura = alturaTotal.toFixed(2);
			vComprimento = vComprimento.toFixed(2);
			vLargura = vLargura.toFixed(2);
			
			//Área e Perímetro
			vArea = (vComprimento * vLargura).toFixed(2);			
			vPerimetro = ((vComprimento * 2) + (vLargura * 2)).toFixed(2);
		}
		
		function inComodo(comodo, camada)
		{
			vEscala = 15;
			//Capturando valores do desenho
			nmComodo = "o"+com;
			xiComodo = X1;
			yiComodo = Y1;
			wComodo = X2 - X1;
			hComodo = Y2 - Y1;
			xfComodo = X1 + wComodo;
			yfComodo = Y1 + hComodo;
			
			//Definindo valores em metros
			vComprimento = wComodo / vEscala;
			vLargura = hComodo / vEscala;
			
			vAltura = alturaTotal.toFixed(2);
			vComprimento = vComprimento.toFixed(2);
			vLargura = vLargura.toFixed(2);
			
			//Área e Perímetro
			vArea = (vComprimento * vLargura).toFixed(2);			
			vPerimetro = ((vComprimento * 2) + (vLargura * 2)).toFixed(2);

			//ComodoFuncs.src = "inserir_comodo.php?" + nmComodo+"?"+xiComodo+"?"+yiComodo+"?"+xfComodo+"?"+yfComodo+"?"+vComprimento+"?"+vLargura+"?"+vArea+"?"+vPerimetro;
			
			Ajax("GET", "inserir_comodo.php", nmComodo+"?"+xiComodo+"?"+yiComodo+"?"+xfComodo+"?"+yfComodo+"?"+vComprimento+"?"+vLargura+"?"+vArea+"?"+vPerimetro+"?"+cdProjeto, "");
			
			//var junto = nmComodo + ";" + xiComodo + ";" + yiComodo + ";" + xfComodo + ";" + yfComodo + ";" + vComprimento + ";" + vLargura + ";" + vArea + ";" + vPerimetro;
			
			/*Comodos.push(						
							{
								nome : nmComodo,
								tipo: null,
								xi : xiComodo,
								yi : yiComodo,
								xf : xfComodo,
								yf : yfComodo,
								width: wComodo,
								height: hComodo,
								altura: alturaTotal,
								comprimento : vComprimento,
								largura : vLargura,
								area : vArea,
								perimetro : vPerimetro
							}
						);*/

			Camadas.push(camada);
			Comodos.push(comodo);
			
			Comodos[Comodos.length - 1].on('click',function()
			{
				sCom = this.getId();
				index = getIndexOf(Comodos, "attrs.nome", sCom);
				
				if (menu == 12)
				{
					//alert("2");
					Camadas[index].setDraggable(false);
					coma = this.getName();
					dNmComodo = Camadas[index].attrs.id;
					//ComodoFuncs.src = "delete_comodo.php?"+dNmComodo;
					//selcomodo.remove(coma);
					
					if (confirm("Deseja realmente excluir esse cômodo?"))
					{
						DeletarComodo(dNmComodo);
					}
				}
			});
			
			Camadas[Camadas.length - 1].add(Comodos[Comodos.length - 1]); 
			Camadas[Camadas.length - 1].setWidth(Comodos[Comodos.length - 1].getWidth);
			Camadas[Camadas.length - 1].setHeight(Comodos[Comodos.length - 1].getHeight);
			com++;
			
			//Camadas[Camadas.length - 1].add(comodo);	

			//Criando os pontos ancoras do comodo
			var point1 = new Kinetic.Rect
			(
				{			
					x: X1-5,
					y: Y1-5,
					width: 10,
					height: 10,
					fill: 'blue',
					draggable: true,
					comodo: Comodos[Comodos.length - 1].attrs.nome
				}
			);
			
			var point2 = new Kinetic.Rect
			(
				{
					x: X1-5,
					y: Y2-5,
					width: 10,
					height: 10,
					fill: 'blue',
					draggable: true,
					comodo: Comodos[Comodos.length - 1].attrs.nome
				}
			);
			
			var point3 = new Kinetic.Rect
			(
				{
					x: X2-5,
					y: Y1-5,
					width: 10,
					height: 10,
					fill: 'blue',
					draggable: true,
					comodo: Comodos[Comodos.length - 1].attrs.nome
				}
			);
			
			var point4 = new Kinetic.Rect
			(
				{
					x: X2-5,
					y: Y2-5,
					width: 10,
					height: 10,
					fill: 'blue',
					draggable: true,
					comodo: Comodos[Comodos.length - 1].attrs.nome
				}
			);
			
			Ancoras.push([Comodos[Comodos.length - 1], point1, point2, point3, point4]);
			
			//Fixando Ancoras
			point1.on("mouseover", function () 
			{
				sCom = this.attrs.comodo;
				index = getIndexOf(Camadas, "attrs.id", sCom);
				
				Camadas[index].add(point1);
				Camadas[index].add(point2);
				Camadas[index].add(point3);
				Camadas[index].add(point4);
				Camadas[index].draw();
				painelDesenho.style.cursor= "nw-resize";
			});
			
			point2.on("mouseover", function () 
			{
				sCom = this.attrs.comodo;
				index = getIndexOf(Camadas, "attrs.id", sCom);
				
				Camadas[index].add(point1);
				Camadas[index].add(point2);
				Camadas[index].add(point3);
				Camadas[index].add(point4);
				Camadas[index].draw();
				painelDesenho.style.cursor= "nw-resize";
			});
			
			point3.on("mouseover", function () 
			{
				sCom = this.attrs.comodo;
				index = getIndexOf(Camadas, "attrs.id", sCom);
				
				Camadas[index].add(point1);
				Camadas[index].add(point2);
				Camadas[index].add(point3);
				Camadas[index].add(point4);
				Camadas[index].draw();
				painelDesenho.style.cursor= "nw-resize";
			});
			
			point4.on("mouseover", function () 
			{
				sCom = this.attrs.comodo;
				index = getIndexOf(Camadas, "attrs.id", sCom);
				
				Camadas[index].add(point1);
				Camadas[index].add(point2);
				Camadas[index].add(point3);
				Camadas[index].add(point4);
				Camadas[index].draw();
				painelDesenho.style.cursor= "nw-resize";
			});
			
			//fehando fixamento de ancoras
			
			
			point1.on("mousedown", function () 
			{
				sCom = this.attrs.comodo;
				index = getIndexOf(Comodos, "attrs.nome", sCom);
				
				point2.remove();
				point3.remove();
				point4.remove();
				painelDesenho.style.cursor= "crosshair";
				
				point1.on("mouseup", function () {
					var pos = this.getPosition();
					var xN = pos.x;
					var yN = pos.y;
					var cX = Comodos[index].getX();
					var cY = Comodos[index].getY();
					var wT = Comodos[index].getWidth();
					var hT = Comodos[index].getHeight();
					
					point2.setX(xN);
					point3.setY(yN);
					Camadas[index].add(point2);
					Camadas[index].add(point3);
					Camadas[index].add(point4);
					Comodos[index].setX(xN+4);
					Comodos[index].setY(yN+4);
					Comodos[index].setWidth(wT-xN+cX-4);
					Comodos[index].setHeight(hT-yN+cY-4);
					//Isso foi o que eu tentei fazer (não sei se está certo)
					Comodos[index].attrs.xi = xN+4;
					Comodos[index].attrs.yi = yN+4;
					Camadas[index].add(Comodos[index]);
					
					//here
					//porta.x(Comodos[Comodos.length - 1].x()-10);		
					//porta.y(Comodos[Comodos.length - 1].y()+10);							
					Camadas[index].draw();
				});
			});
			
			point2.on("mousedown", function () 
			{
				sCom = this.attrs.comodo;
				index = getIndexOf(Comodos, "attrs.nome", sCom);
				
				point1.remove();
				point3.remove();
				point4.remove();
				painelDesenho.style.cursor= "crosshair";
				
				point2.on("mouseup", function () 
				{
					var pos = this.getPosition();
					var xN = pos.x;
					var yN = pos.y;
					var cX = Comodos[index].getX();
					var cY = Comodos[index].getY();
					var wT = Comodos[index].getWidth();
					var hT = Comodos[index].getHeight();
					
					point1.setX(xN);
					point4.setY(yN);
					Camadas[index].add(point1);
					Camadas[index].add(point3);
					Camadas[index].add(point4);
					Comodos[index].setX(xN+4);
					Comodos[index].setWidth(wT-xN+cX-4);
					Comodos[index].setHeight(yN-cY+4);
					//Isso foi o que eu tentei fazer (não sei se está certo)
					Comodos[index].attrs.xi = xN+4;
					Camadas[index].add(Comodos[index]);
					Camadas[index].draw();
				});
			});
			
			point3.on("mousedown", function () 
			{
				sCom = this.attrs.comodo;
				index = getIndexOf(Comodos, "attrs.nome", sCom);
				
				point1.remove();
				point2.remove();
				point4.remove();
				painelDesenho.style.cursor= "crosshair";
				
				point3.on("mouseup", function () 
				{
					var pos = this.getPosition();
					var xN = pos.x;
					var yN = pos.y;
					var cX = Comodos[index].getX();
					var cY = Comodos[index].getY();
					var wT = Comodos[index].getWidth();
					var hT = Comodos[index].getHeight();
					
					point1.setY(yN);
					point4.setX(xN);
					Camadas[index].add(point1);
					Camadas[index].add(point2);
					Camadas[index].add(point4);
					Comodos[index].setY(yN);
					Comodos[index].setWidth(xN-cX+4);
					Comodos[index].setHeight(hT-(yN-cY));
					//Isso foi o que eu tentei fazer (não sei se está certo)
					Comodos[index].attrs.yi = yN+4;
					Camadas[index].add(Comodos[index]);
					Camadas[index].draw();
				});
			});
			
			point4.on("mousedown", function () 
			{
				sCom = this.attrs.comodo;
				index = getIndexOf(Comodos, "attrs.nome", sCom);
				
				point1.remove();
				point2.remove();
				point3.remove();
				painelDesenho.style.cursor= "crosshair";
				
				point4.on("mouseup", function () 
				{
					var pos = this.getPosition();
					var xN = pos.x;
					var yN = pos.y;
					var cX = Comodos[index].getX();
					var cY = Comodos[index].getY();
					point3.setX(xN);
					point2.setY(yN);
					Camadas[index].add(point1);
					Camadas[index].add(point2);
					Camadas[index].add(point3);
					Comodos[index].setWidth(xN-cX+4);
					Comodos[index].setHeight(yN-cY+4);
					Camadas[index].add(Comodos[index]);
					Camadas[index].draw();
				});
			});
			
			point1.on("mouseout", function () 
			{
				painelDesenho.style.cursor= "crosshair";
			});
			
			point2.on("mouseout", function () 
			{
				painelDesenho.style.cursor= "crosshair";
			});
			
			point3.on("mouseout", function () 
			{
				painelDesenho.style.cursor= "crosshair";
			});
			
			point4.on("mouseout", function () 
			{
				painelDesenho.style.cursor= "crosshair";
			});
				
			Camadas[Camadas.length - 1].on('mouseover', function()
			{
				sCom = this.getId();
				index = getIndexOf(Camadas, "attrs.id", sCom);
				
				if(menu == 1)
				{
					Comodos[index].setStroke("#00abff");
					this.add(point1);
					this.add(point2);
					this.add(point3);
					this.add(point4);
					this.draw();
					//alert("i");
					//setDate();
				}
				
				if(menu == 2)
				{
					comDraw = 0;
				}
			});
			
			Camadas[Camadas.length - 1].on('click', function()
			{
				sNmComodo = this.attrs.id;
				//ComodoFuncs.src = "select_comodoPropriedades.php?"+sNmComodo;
				
				exibirPropriedadesComodo(sNmComodo);
			});
			
			Camadas[Camadas.length - 1].on('mousedown', function(evt)
			{
				sCom = this.getId();
				index = getIndexOf(Camadas, "attrs.id", sCom);
				
				if(menu == 1)
				{
					this.setDraggable(true);	
					this.setZIndex(9998);						
					//Comodos[Comodos.length - 1].setStroke('blue');	
					//CAPTURANDO COORDENADA DO OBJETO RECT =D					
					esqUD = (this.getAbsolutePosition('comodo').x + Comodos[index].getX())-15;
					esqLR = (this.getAbsolutePosition('comodo').y + Comodos[index].getY())-15;
					iddd = this.getId();
					odd = this.getId('comodo');
					//alert(iddd);
					//if(esqUD <=0)
					//{
					//	if(Camadas[Camadas.length - 1].getId('iddd').Comodos[Comodos.length - 1].getId())
					//	{
					//		Comodos[Comodos.length - 1].setStroke('red');
					//	}
					//	else
					//	{
					//		Comodos[Comodos.length - 1].setStroke('blue');
					//	}
					//}
					
					//Camadas[Camadas.length - 1].draw();
					//setDate();

					exibirPropriedadesComodo(iddd);
				}
				
				if(menu == 3)
				{
					this.setDraggable(false);
					if(esquadriasSM == 1)
					{
						//alert("Porta");
						Ax = Comodos[index].attrs.xi;
						Ay = Comodos[index].attrs.yi;
						Dx = Comodos[index].attrs.xf;
						Dy = Comodos[index].attrs.yf;
						Cx = cXc;
						Cy = cYc;
						
						var imgPorta = new Image();
						imgPorta.src = 'icones/portad.png'
						
						if((Cx >= (Dx/2)) && (Cy >= (Dy/2)))
						{
							//alert("BD");
							//baixo e direita
							if((Dx - Cx) <= (Dy - Cy))
							{
								//direita
								//alert("Direita");
								portaDir = new Kinetic.Image
								(
									{
										x: Comodos[index].attrs.xf-24,
										y: Comodos[index].attrs.yf-6,
										image: imgPorta,
										width: 16,
										height: 27,
										fill:'transparent',
										draggable: false,
										rotation: 270
									}
								);		
								portaDir.setZIndex(9999);							
								this.add(portaDir);
								this.draw();
							}
							else
							{
								//baixo
								//alert("Baixo");
								portaDown = new Kinetic.Image
								(
									{
										x: Comodos[index].attrs.xf-22,
										y: Comodos[index].attrs.yf-24,
										image: imgPorta,
										width: 16,
										height: 27,
										fill:'transparent',
										draggable: false
									}
								);		
								portaDown.setZIndex(9999);							
								this.add(portaDown);
								this.draw();
							}
						}
						else if((Cx <= (Dx/2)) && (Cy <= (Dy/2)))
						{
							//alert("CE");
							//cima e esquerda
							if((Cx - Ax) <= (Cy - Ay))
							{
								//esquerda
								//alert("Esquerda");
								portaEsq = new Kinetic.Image
								(
									{
										x: Comodos[index].attrs.xi+24,
										y: Comodos[index].attrs.yi+6,
										image: imgPorta,
										width: 16,
										height: 27,
										fill:'transparent',
										draggable: false,
										rotation: 90
									}
								);		
								portaEsq.setZIndex(9999);							
								this.add(portaEsq);
								this.draw();
							}
							else
							{
								//cima
								//alert("Cima");
								portaUp = new Kinetic.Image
								(
									{
										x: Comodos[index].attrs.xi+22,
										y: Comodos[index].attrs.yi+24,
										image: imgPorta,
										width: 16,
										height: 27,
										fill:'transparent',
										draggable: false,
										rotation: 180
									}
								);		
								portaUp.setZIndex(9999);							
								this.add(portaUp);
								this.draw();
							}
						}	
						else if((Cx <= (Dx/2)) && (Cy >= (Dy/2)))
						{
							alert("BE");
							//baixo e esquerda
							if(((Dx/2)-Cx) >= (Cy - (Dy/2)))
							{
								//esquerda
								//alert("Esquerda");
								portaEsq = new Kinetic.Image
								(
									{
										x: Comodos[index].attrs.xi+24,
										y: Comodos[index].attrs.yf-22,
										image: imgPorta,
										width: 16,
										height: 27,
										fill:'transparent',
										draggable: false,
										rotation: 90
									}
								);		
								portaEsq.setZIndex(9999);							
								this.add(portaEsq);
								this.draw();
							}
							else
							{
								//baixo
								//alert("Baixo");
								portaDown = new Kinetic.Image
								(
									{
										x: Comodos[index].attrs.xi+6,
										y: Comodos[index].attrs.yf-24,
										image: imgPorta,
										width: 16,
										height: 27,
										fill:'transparent',
										draggable: false
									}
								);		
								portaDown.setZIndex(9999);							
								this.add(portaDown);
								this.draw();
							}
						}
						else if((Cx >= (Dx/2)) && (Cy <= (Dy/2)))
						{
							//alert("CD");
							//cima e direita
							if((Dx - Cx) <= (Cy - Ay))
							{
								//direita
								//alert("Direita");
								portaDir = new Kinetic.Image
								(
									{
										x: Comodos[index].attrs.xf-24,
										y: Comodos[index].attrs.yi+24,
										image: imgPorta,
										width: 16,
										height: 27,
										fill:'transparent',
										draggable: false,
										rotation: 270
									}
								);		
								portaDir.setZIndex(9999);							
								this.add(portaDir);
								this.draw();
							}
							else
							{
								//cima
								//alert("Cima");
								portaUp = new Kinetic.Image
								(
									{
										x: Comodos[index].attrs.xf-8,
										y: Comodos[index].attrs.yi+24,
										image: imgPorta,
										width: 16,
										height: 27,
										fill:'transparent',
										draggable: false,
										rotation: 180
									}
								);		
								portaUp.setZIndex(9999);							
								this.add(portaUp);
								this.draw();
							}
						}
						else
						{}						
					}
					else if(esquadriasSM == 2)
					{
						//alert("Janela");
					}
					else
					{
						esquadriasSM = 1;
					}
				}
				if(menu == 4)
				{
					if(lampadaSM > 2 && lampadaSM <=6)
					{
						sl = this.getId();
						selComodo = Comodos[getIndexOf(Comodos,"nome",sl)];
						
						var imgL = new Image();
						if(lampadaSM == 3)
						{
							imgL.src = 'icones/it.png';
						}
						else if(lampadaSM == 4)
						{
							imgL.src = 'icones/ft.png';
						}
						else if(lampadaSM == 5)
						{
							imgL.src = 'icones/fet.png';
						}
						else if(lampadaSM == 6)
						{
							imgL.src = 'icones/iet.png';
						}
						else{}
						
						
						lampadaTeto = new Kinetic.Image
						(
							{
								id: 'lampada' + contLampadas,
								x: (Comodos[Comodos.length - 1].width()/2)+Comodos[Comodos.length - 1].x()-15,
								y: (Comodos[Comodos.length - 1].height()/2)+Comodos[Comodos.length - 1].y()-15,
								width: 30,
								height: 30,
								image: imgL,
								fill: 'transparent',
								comodo: this.attrs.id
							}
						);
						
						contLampadas = contLampadas + 1;
						
						InserirLampadaTeto(lampadaTeto);
						
						this.add(lampadaTeto);
						this.draw();
					}
					else
					{
						//alert("parede");
					}
				}
				
				
				if(menu == 5)
				{
					//alert("ooo");
					//alert("Porta");
					this.setDraggable(false);
					Ax = Comodos[index].attrs.xi;
					Ay = Comodos[index].attrs.yi;
					Dx = Comodos[index].attrs.xf;
					Dy = Comodos[index].attrs.yf;
					Cx = cXc;
					Cy = cYc;
					
					//var shape = Comodos[index].attrs.find('#'+Comodos[index].attrs.id)[0];
					
					var imgTomada = new Image();
					if(tomadaSM == 1)
					{							
						tT = "TB";
						imgTomada.src = 'icones/tug_baixa.png';
					}
					else if(tomadaSM == 2)
					{
						tT = "TM";
						imgTomada.src = 'icones/tug_media.png';
					}
					else if(tomadaSM == 3)
					{
						tT = "TA";
						imgTomada.src = 'icones/tug_alta.png';
					}
					else if(tomadaSM == 4)
					{
						//tue
						//imgTomada.src = 'icones/quadro_geral.png';
					}
					else{}
					
					if((Cx >= (Dx/2)) && (Cy >= (Dy/2)))
					{
						//alert("BD");
						//baixo e direita
						if((Dx - Cx) <= (Dy - Cy))
						{
							//direita
							//alert("Direita");
							//tomadaDir = new Kinetic.Image
							//alert("aqui 1");
							Tomada = new Kinetic.Image
							(
								{
									id: 'tomada'+cTom,
									name: 'tomada'+cTom+'?'+tT,
									x: Comodos[index].attrs.xf-24,
									y: painel.getPointerPosition().y+15,
									image: imgTomada,
									width: 27,
									height: 27,
									fill:'transparent',
									draggable: false,
									rotation:270,
									comodo: this.attrs.id
								}
							);		
							Tomada.setZIndex(9999);							
							this.add(Tomada);
							//tomadaDir.setZIndex(9999);							
							//this.add(tomadaDir);
							this.draw();
							
							InserirTomada(Tomada, 40,10);
						}
						else
						{
							//baixo
							//alert("Baixo");
							
							//tomadaDown = new Kinetic.Image
							//alert("aqui 2");
							Tomada = new Kinetic.Image
							(
								{
									id: 'tomada'+cTom,
									name: 'tomada'+cTom+'?'+tT,
									x: painel.getPointerPosition().x-15,
									y: Comodos[index].attrs.yf-24,
									image: imgTomada,
									width: 27,
									height: 27,
									fill:'transparent',
									draggable: false,
									comodo: this.attrs.id
								}
							);		
							Tomada.setZIndex(9999);							
							//tomadaDown.setZIndex(9999);							
							this.add(Tomada);
							//this.add(tomadaDown);
							this.draw();
							
							InserirTomada(Tomada, 28, 48);
						}
					}
					else if((Cx <= (Dx/2)) && (Cy <= (Dy/2)))
					{
						//alert("CE");
						//cima e esquerda
						if((Cx - Ax) <= (Cy - Ay))
						{
							//esquerda
							//alert("Esquerda");
							//tomadaEsq = new Kinetic.Image
							//alert("aqui 3");
							Tomada = new Kinetic.Image
							(
								{
									id: 'tomada'+cTom,
									name: 'tomada'+cTom+'?'+tT,
									x: Comodos[index].attrs.xi+24,
									y: painel.getPointerPosition().y-15,
									image: imgTomada,
									width: 27,
									height: 27,
									fill:'transparent',
									draggable: false,
									rotation: 90,
									comodo: this.attrs.id
								}
							);	
							Tomada.setZIndex(9999);							
							this.add(Tomada);								
							//tomadaEsq.setZIndex(9999);							
							//this.add(tomadaEsq);
							this.draw();
							
							InserirTomada(Tomada, -8, 38);
						}
						else
						{
							//cima
							//alert("Cima");
							//alert("aqui 4");
							Tomada = new Kinetic.Image
							(
								{
									id: 'tomada'+cTom,
									name: 'tomada'+cTom+'?'+tT,
									x: painel.getPointerPosition().x+15,
									y: Comodos[index].attrs.yi+24,
									image: imgTomada,
									width: 27,
									height: 27,
									fill:'transparent',
									draggable: false,
									rotation: 180,
									comodo:  this.attrs.id
								}
							);
							
							Tomada.setZIndex(9999);							
							this.add(Tomada);
							this.draw();
							
							InserirTomada(Tomada,0 ,0);
						}
					}	
					else if((Cx <= (Dx/2)) && (Cy >= (Dy/2)))
					{
						//alert("BE");
						//baixo e esquerda
						if(((Dx/2)-Cx) >= (Cy - (Dy/2)))
						{
							//esquerda
							//alert("Esquerda");
							//tomadaEsq = new Kinetic.Image
							//alert("aqui 5");
							Tomada = new Kinetic.Image
							(
								{
									id: 'tomada'+cTom,
									name: 'tomada'+cTom+'?'+tT,
									x: Comodos[index].attrs.xi+24,
									y: painel.getPointerPosition().y-15,
									image: imgTomada,
									width: 27,
									height: 27,
									fill:'transparent',
									draggable: false,
									rotation: 90,
									comodo: this.attrs.id
								}
							);		
							Tomada.setZIndex(9999);							
							this.add(Tomada);
							//tomadaEsq.setZIndex(9999);							
							//this.add(tomadaEsq);
							this.draw();
							
							InserirTomada(Tomada, -8, 38);
						}
						else
						{
							//baixo
							//alert("Baixo");
							//tomadaDown = new Kinetic.Image
							//alert("aqui 6");
							Tomada = new Kinetic.Image
							(
								{
									id: 'tomada'+cTom,
									name: 'tomada'+cTom+'?'+tT,
									x: painel.getPointerPosition().x-15,
									y: Comodos[index].attrs.yf-24,
									image: imgTomada,
									width: 27,
									height: 27,
									fill:'transparent',
									draggable: false,
									comodo: this.attrs.id
								}
							);		
							Tomada.setZIndex(9999);							
							this.add(Tomada);
							this.draw();
							
							InserirTomada(Tomada, 28, 48);
						}
					}
					else if((Cx >= (Dx/2)) && (Cy <= (Dy/2)))
					{
						//alert("CD");
						//cima e direita
						if((Dx - Cx) <= (Cy - Ay))
						{
							//direita
							//alert("Direita");
							//tomadaDir = new Kinetic.Image
							//alert("aqui 7");
							Tomada = new Kinetic.Image
							(
								{
									id: 'tomada'+cTom,
									name: 'tomada'+cTom+'?'+tT,
									x: Comodos[index].attrs.xf-24,
									y: painel.getPointerPosition().y+15,
									image: imgTomada,
									width: 27,
									height: 27,
									fill:'transparent',
									draggable: false,
									rotation: 270,
									comodo: this.attrs.id
								}
							);		
							Tomada.setZIndex(9999);							
							this.add(Tomada);
							//tomadaDir.setZIndex(9999);							
							//this.add(tomadaDir);
							this.draw();
							
							InserirTomada(Tomada, 40, 10);
						}
						else
						{
							//cima
							//alert("Cima");
							//alert("aqui 8");
							Tomada = new Kinetic.Image
							(
								{
									id: 'tomada'+cTom,
									name: 'tomada'+cTom+'?'+tT,
									x: painel.getPointerPosition().x+15,
									y: Comodos[index].attrs.yi+24,
									image: imgTomada,
									width: 27,
									height: 27,
									fill:'transparent',
									draggable: false,
									rotation: 180,
									comodo:  this.attrs.id
								}
							);
							
							Tomada.setZIndex(9999);							
							this.add(Tomada);
							this.draw();
							
							InserirTomada(Tomada, 0, 0);
						}
					}
					else
					{}	
					cTom++;
						
					this.setDraggable(false);	
				}
					
				if(menu == 2)
				{
					this.setDraggable(false);
				}
				
				if(menu == 12)
				{
					//Mudei o evento de lugar, na declaraçao do comodo
				}
				
				
				if(menu == 8)
				{
					//alert("ooo");
					//alert("Porta");
					sCom = this.getId();
					Comodos[index] = Comodos[getIndexOf(Comodos, "attrs.nome", sCom)];
					Ax = Comodos[index].attrs.xi;
					Ay = Comodos[index].attrs.yi;
					Dx = Comodos[index].attrs.xf;
					Dy = Comodos[index].attrs.yf;
					Cx = cXc;
					Cy = cYc;
					var imgQuadro = new Image();
					if(quadroSM == 1)
					{							
						imgQuadro.src = 'icones/quadro_parcial.png';
					}
					else
					{
						imgQuadro.src = 'icones/quadro_geral.png';
					}
					
					if((Cx >= (Dx/2)) && (Cy >= (Dy/2)))
					{
						//alert("BD");
						//baixo e direita
						if((Dx - Cx) <= (Dy - Cy))
						{
							//direita
							//alert("Direita");
							quadroDir = new Kinetic.Image
							(
								{
									id: "quadro" + cQua,
									x: Comodos[index].attrs.xf-20,
									y: painel.getPointerPosition().y+10,
									image: imgQuadro,
									width: 20,
									height: 27,
									fill:'transparent',
									draggable: false,
									rotation: 270,
									comodo: this.attrs.id
								}
							);		
							
							InserirQuadro(quadroDir, 36, 12);
							
							//arrayPontos.length = 0;
						}
						else
						{
							//baixo
							//alert("Baixo");
							quadroDown = new Kinetic.Image
							(
								{
									x: painel.getPointerPosition().x,
									y: Comodos[index].attrs.yf-20,
									image: imgQuadro,
									width: 20,
									height: 27,
									fill:'transparent',
									draggable: false
								}
							);		
							quadroDown.setZIndex(9999);							
							this.add(quadroDown);
							this.draw();
						}
					}
					else if((Cx <= (Dx/2)) && (Cy <= (Dy/2)))
					{
						//alert("CE");
						//cima e esquerda
						if((Cx - Ax) <= (Cy - Ay))
						{
							//esquerda
							//alert("Esquerda");
							quadroEsq = new Kinetic.Image
							(
								{
									x: Comodos[index].attrs.xi+20,
									y: painel.getPointerPosition().y-10,
									image: imgQuadro,
									width: 16,
									height: 27,
									fill:'transparent',
									draggable: false,
									rotation: 90
								}
							);		
							quadroEsq.setZIndex(9999);							
							this.add(quadroEsq);
							this.draw();
						}
						else
						{
							//cima
							//alert("Cima");
							quadroUp = new Kinetic.Image
							(
								{
									x: painel.getPointerPosition().x+10,
									y: Comodos[index].attrs.yi+20,
									image: imgQuadro,
									width: 16,
									height: 27,
									fill:'transparent',
									draggable: false,
									rotation: 180
								}
							);		
							quadroUp.setZIndex(9999);							
							this.add(quadroUp);
							this.draw();
						}
					}	
					else if((Cx <= (Dx/2)) && (Cy >= (Dy/2)))
					{
						//alert("BE");
						//baixo e esquerda
						if(((Dx/2)-Cx) >= (Cy - (Dy/2)))
						{
							//esquerda
							//alert("Esquerda");
							quadroEsq = new Kinetic.Image
							(
								{
									x: Comodos[index].attrs.xi+20,
									y: painel.getPointerPosition().y-10,
									image: imgQuadro,
									width: 16,
									height: 27,
									fill:'transparent',
									draggable: false,
									rotation: 90
								}
							);		
							quadroEsq.setZIndex(9999);							
							this.add(quadroEsq);
							this.draw();
						}
						else
						{
							//baixo
							//alert("Baixo");
							quadroDown = new Kinetic.Image
							(
								{
									x: painel.getPointerPosition().x,
									y: Comodos[index].attrs.yf-20,
									image: imgQuadro,
									width: 20,
									height: 27,
									fill:'transparent',
									draggable: false
								}
							);		
							quadroDown.setZIndex(9999);							
							this.add(quadroDown);
							this.draw();
						}
					}
					else if((Cx >= (Dx/2)) && (Cy <= (Dy/2)))
					{
						//alert("CD");
						//cima e direita
						if((Dx - Cx) <= (Cy - Ay))
						{
							//direita
							//alert("Direita");
							quadroDir = new Kinetic.Image
							(
								{
									id: "quadro" + cQua,
									x: Comodos[index].attrs.xf-20,
									y: painel.getPointerPosition().y+10,
									image: imgQuadro,
									width: 20,
									height: 27,
									fill:'transparent',
									draggable: false,
									rotation: 270,
									comodo: this.attrs.id
								}
							);	
							
							InserirQuadro(quadroDir, 36, 12);
						}
						else
						{
							//cima
							//alert("Cima");
							quadroUp = new Kinetic.Image
							(
								{
									x: painel.getPointerPosition().x+10,
									y: Comodos[index].attrs.yi+20,
									image: imgQuadro,
									width: 20,
									height: 27,
									fill:'transparent',
									draggable: false,
									rotation: 180
								}
							);		
							quadroUp.setZIndex(9999);							
							this.add(quadroUp);
							this.draw();
						}
						
					}
					else
					{}		
						
					option = document.createElement("option");
					option.text = "Disjuntor"+cDis;
					selectDisjuntores.add(option);
					
					cDis++;
				}
					
				if(menu == 10)
				{
					//AQUI EU PRECISO CLICAR EM UMA TOMADA, LAMPADA OU INTERRUPTOR e CAPTURAR
					//AS COORDENADAS DELES PARA PODER MONTAR O CIRCUITO LIGANDO OS PONTOS
					
					//A função do Tomada.on deve ser coloca no momento que você cria a instancia do objeto. Usa o localizar para encontrar a variável Tomada.on
					
				}
				
			});
			
			Camadas[Camadas.length - 1].on('mouseup', function()
			{
				sCom = this.getId();
				index = getIndexOf(Camadas, "attrs.id", sCom);
				
				if (menu == 1)
				{					
						this.setDraggable(false);
						uXiComodo = (this.getAbsolutePosition('comodo').x + Comodos[index].getX())-15;
						uYiComodo =  (this.getAbsolutePosition('comodo').y + Comodos[index].getY())-15;
						uWComodo = Comodos[index].getWidth();
						uHComodo = Comodos[index].getHeight();
						uXfComodo = uXiComodo + uWComodo;
						uYfComodo = uYiComodo + uHComodo;
						//uNmComodo = Comodos[Comodos.length - 1].getId();
						uNmComodo = this.attrs.id;
						//alert(uNmComodo);
						//ComodoFuncs.src = "update_comodo.php?"+uNmComodo+"?"+uXiComodo+"?"+uYiComodo+"?"+uXfComodo+"?"+uYfComodo;
						
						AlterarComodo(uNmComodo, uXiComodo, uYiComodo, uXfComodo, uYfComodo);
				}
			});
			
			Camadas[Camadas.length - 1].on('mouseout', function()
			{
				sCom = this.getId();
				index = getIndexOf(Camadas, "attrs.id", sCom);
				
				if(menu == 1)
				{
					this.setDraggable(true);
					Comodos[index].setStroke('white');
					point1.remove();
					point2.remove();
					point3.remove();
					point4.remove();
					this.draw();
				}
				if(menu == 2)
				{
					comDraw = 1;
				}
			});
			
			Camadas[Camadas.length - 1].setDraggable(false);
			painel.add(Camadas[Camadas.length - 1]);
			Camadas[Camadas.length - 1].add(point1);
			Camadas[Camadas.length - 1].add(point2);
			Camadas[Camadas.length - 1].add(point3);
			Camadas[Camadas.length - 1].add(point4);
			point1.remove();
			point2.remove();
			point3.remove();
			point4.remove();
			Camadas[Camadas.length - 1].draw();
			
			setProComodos();
		}
		
		//Função para pegar a posição do comodo no array
		//Exemplo: getIndexOf(Comodos, "attrs.nome", "o3") - Vai retornar o index do objeto comodo, ai é só colocar Comodos[getIndexOf(Comodos, "attrs.nome", "o3")] - vai retornar o comodo específico separados pelos atributos
		function getIndexOf(array, atributo, valor) 
		{
			var tamanho = array.length;
			var cont;
			
			for (cont = 0; cont <= tamanho - 1; cont = cont + 1) 
			{
				if (eval("array[cont]." + atributo + " == valor")) 
				{
					return cont;
				}
			}                      
		  return false;
		}
		
		btnComodoComp.onclick = function()
		{
			if(grupoComodo.style.display == "inline-block")
			{
				grupoComodo.style.display = "none";
				btnComodoComp.value = "▼ Cômodos";
			}
			else
			{
				danoneComp();
				grupoComodo.style.display = "inline-block";
				btnComodoComp.value = "▲ Cômodos";
			}
		}
		
		btnEsquadriaComp.onclick = function()
		{
			if(grupoEsquadria.style.display == "inline-block")
			{
				grupoEsquadria.style.display = "none";
				btnEsquadriaComp.value = "▼ Esquadrias";
			}
			else
			{
				danoneComp();
				grupoEsquadria.style.display = "inline-block";
				btnEsquadriaComp.value = "▲ Esquadrias";
			}
		}
		
		btnTomadaComp.onclick = function()
		{
			if(grupoTomada.style.display == "inline-block")
			{
				grupoTomada.style.display = "none";
				btnTomadaComp.value = "▼ Tomadas";
			}
			else
			{
				danoneComp();
				grupoTomada.style.display = "inline-block";
				btnTomadaComp.value = "▲ Tomadas";
			}
		}
		
		btnLampadaComp.onclick = function()
		{
			if(grupoLampada.style.display == "inline-block")
			{
				grupoLampada.style.display = "none";
				btnLampadaComp.value = "▼ Lampadas";
			}
			else
			{
				danoneComp();
				grupoLampada.style.display = "inline-block";
				btnLampadaComp.value = "▲ Lampadas";
			}
		}
		
		
		btnInterruptorComp.onclick = function()
		{
			if(grupoInterruptor.style.display == "inline-block")
			{
				grupoInterruptor.style.display = "none";
				btnInterruptorComp.value = "▼ Interruptores";
			}
			else
			{
				danoneComp();
				grupoInterruptor.style.display = "inline-block";
				btnInterruptorComp.value = "▲ Interruptores";
			}
		}
		
		btnDisjuntorComp.onclick = function()
		{
			if(grupoDisjuntor.style.display == "inline-block")
			{
				grupoDisjuntor.style.display = "none";
				btnDisjuntorComp.value = "▼ Disjuntores";
			}
			else
			{
				danoneComp();
				grupoDisjuntor.style.display = "inline-block";
				btnDisjuntorComp.value = "▲ Disjuntores";
			}
		}
		
		btnCircuitoComp.onclick = function()
		{
			if(grupoCircuito.style.display == "inline-block")
			{
				grupoCircuito.style.display = "none";
				btnCircuitoComp.value = "▼ Circuitos";
			}
			else
			{
				danoneComp();
				grupoCircuito.style.display = "inline-block";
				btnCircuitoComp.value = "▲ Circuitos";
			}
		}
		
		btnConduiteComp.onclick = function()
		{
			if(grupoConduite.style.display == "inline-block")
			{
				grupoConduite.style.display = "none";
				btnConduiteComp.value = "▼ Conduites";
			}
			else
			{
				danoneComp();
				grupoConduite.style.display = "inline-block";
				btnConduiteComp.value = "▲ Conduites";
			}
		}
		
		btnCondutorComp.onclick = function()
		{
			if(grupoCondutor.style.display == "inline-block")
			{
				grupoCondutor.style.display = "none";
				btnCondutorComp.value = "▼ Condutores";
			}
			else
			{
				danoneComp();
				grupoCondutor.style.display = "inline-block";
				btnCondutorComp.value = "▲ Condutores";
			}
		}
		
		btnQuadroComp.onclick = function()
		{
			if(grupoQuadro.style.display == "inline-block")
			{
				grupoQuadro.style.display = "none";
				btnQuadroComp.value = "▼ Quadros";
			}
			else
			{
				danoneComp();
				grupoQuadro.style.display = "inline-block";
				btnQuadroComp.value = "▲ Quadros";
			}
		}
		
		function danoneComp()
		{
			grupoComodo.style.display = "none";
			btnComodoComp.value = "▼ Cômodos";
			
			grupoEsquadria.style.display = "none";
			btnEsquadriaComp.value = "▼ Esquadrias";
			
			grupoTomada.style.display = "none";
			btnTomadaComp.value = "▼ Tomadas";
			
			grupoLampada.style.display = "none";
			btnLampadaComp.value = "▼ Lampadas";
			
			grupoInterruptor.style.display = "none";
			btnInterruptorComp.value = "▼ Interruptores";
			
			grupoDisjuntor.style.display = "none";
			btnDisjuntorComp.value = "▼ Disjuntores";
			
			grupoCircuito.style.display = "none";
			btnCircuitoComp.value = "▼ Circuitos";
			
			grupoConduite.style.display = "none";
			btnConduiteComp.value = "▼ Conduites";
			
			grupoCondutor.style.display = "none";
			btnCondutorComp.value = "▼ Condutores";
			
			grupoQuadro.style.display = "none";
			btnQuadroComp.value = "▼ Quadros";
		}
		
		comodoSubTomada.onmouseover = function()
		{
			legendaComodo.innerHTML = "Tomadas";
		}
		
		comodoSubLampada.onmouseover = function()
		{
			legendaComodo.innerHTML = "Lâmpadas";
		}
		
		comodoSubEsquadrias.onmouseover = function()
		{
			legendaComodo.innerHTML = "Portas e Janelas";
		}
		
		comodoSubInterruptores.onmouseover = function()
		{
			legendaComodo.innerHTML = "Interruptores";
		}
		
		comodoSubTomada.onmouseout = function()
		{
			limpaLegendaComodo();
		}

		comodoSubLampada.onmouseout = function()
		{
			limpaLegendaComodo();
		}

		comodoSubEsquadrias.onmouseout = function()
		{
			limpaLegendaComodo();
		}

		comodoSubInterruptores.onmouseout = function()
		{
			limpaLegendaComodo();
		}
		
		function limpaLegendaComodo()
		{
			legendaComodo.innerHTML = "";
		}
		
		function exibirPropriedadesComodo(nmCom)
		{
			var ComodoSelecionado = Comodos[getIndexOf(Comodos, "attrs.nome", nmCom)];
			
			nomeComodoD.value = ComodoSelecionado.attrs.nome;
			tipoComodoD.value = ComodoSelecionado.attrs.tipo;
			alturaComodoD.value = ComodoSelecionado.attrs.altura + ' m';
			largComodoD.value = ComodoSelecionado.attrs.largura + " m";
			compComodoD.value = ComodoSelecionado.attrs.comprimento + ' m';
			areaComodoD.value = ComodoSelecionado.attrs.area + " m²";
			perimetroComodoD.value = ComodoSelecionado.attrs.perimetro + " m";
		}
		
		function AlterarComodo(nome, xi, yi, xf, yf)
		{
			var index = getIndexOf(Comodos, "attrs.nome", nome);
			
			Comodos[index].attrs.x = xi;
			Comodos[index].attrs.y = yi;
			Comodos[index].attrs.xi = xi;
			Comodos[index].attrs.yi = yi;
			Comodos[index].attrs.xf = xf;
			Comodos[index].attrs.yf = yf;
		}
		
		function DeletarComodo(nome)
		{
			var index = getIndexOf(Comodos, "attrs.nome", nome);
			
			DeletarPontosComodo(nome);
			
			Comodos[index].destroy();
			Camadas[index].destroy();
			
			Ancoras.splice(index, 1);
			Comodos.splice(index, 1);
			Camadas.splice(index, 1);
			
			setProComodos();
		}

		btn_sair_15.onclick = function()
		{
			if (confirm("Deseja realmente retornar ao sistema?"))
			{
				window.location.href = "../../ET.php";
			}
		}
		
		function openSave()
		{
			if(menuSave.style.display == "inline-block")
			{
				cbr.style.display = "none";
				menuSave.style.display = "none";
			}
			else
			{
				cbr.style.display = "inline-block";
				menuSave.style.display = "inline-block";
			}
		}
		
		function DeletarPontosComodo(nome)
		{
			var contPonto;
			//alert(nome);
			for (contPonto = 0; contPonto <= Tomadas.length - 1; contPonto = contPonto + 1)
			{
				if (Tomadas[contPonto].attrs.comodo == nome)
				{
					//alert(contPonto);
					//alert("achou tomada" + Tomadas[contPonto].attrs.id);
					DeletarArrayPontos(Tomadas[contPonto].attrs.id);
					Tomadas.splice(contPonto, 1);
					
					contPonto = contPonto - 1;
				}
			}

			for (contPonto = 0; contPonto <= lampadasTeto.length - 1; contPonto = contPonto + 1)
			{
				if (lampadasTeto[contPonto].attrs.comodo == nome)
				{
					//alert(contPonto);
					//alert("achou lampada" + lampadasTeto[contPonto].attrs.id);
					DeletarArrayPontos(lampadasTeto[contPonto].attrs.id);
					lampadasTeto.splice(contPonto, 1);
					
					contPonto = contPonto - 1;
				}
			}
			
			for (contPonto = 0; contPonto <= Quadros.length - 1; contPonto = contPonto + 1)
			{
				if (Quadros[contPonto].attrs.comodo == nome)
				{
					//alert(contPonto);
					//alert("achou lampada" + lampadasTeto[contPonto].attrs.id);
					DeletarArrayPontos(Quadros[contPonto].attrs.id);
					Quadros.splice(contPonto, 1);
					
					contPonto = contPonto - 1;
				}
			}
			
			for (contPonto = 0; contPonto <= Circuitos.length - 1; contPonto = contPonto + 1)
			{
				if (Circuitos[contPonto].attrs.comodo == nome)
				{
					//alert(contPonto);
					//alert("achou lampada" + lampadasTeto[contPonto].attrs.id);
					DeletarArrayPontos(Circuitos[contPonto].attrs.id);
					Circuitos.splice(contPonto, 1);
					
					contPonto = contPonto - 1;
				}
			}
			
			setProCircuitos();
			setProQuadros();
			setProTomadas();
			setProLampadas();
		}
		
		function InserirTomada(tomada, xa, ya)
		{
			Tomadas.push(tomada);
									
			Tomadas[Tomadas.length - 1].on('click',function()
			{
				//essaTomada está testando =D
				//essaTomada = Camadas[Camadas.length - 1].find("#tomada1")[0];
				//alert(essaTomada.getId());
				//alert(this.attrs.id);
				if(menu == 10 && Quadros.length != 0)
				{
					/*arrayPontos[iV] = this.attrs.x+4;
					iV++;
					arrayPontos[iV] = this.attrs.y;
					iV++;*/
					
					arrayPontos.push
					(
						{
							id: this.attrs.id,
							x: this.attrs.x + (xa),
							y: this.attrs.y + (ya),
							comodo: this.attrs.comodo
						}
					);
					//imgTomada.src = 'icones/tug_baixa.png';
					var imgTomadaS = new Image();
					var foi;
					
					aux = this.attrs.image.src;
					
					if (aux.indexOf("tug_alta") != -1)
					{
						foi = 1;
						imgTomadaS.src = "icones/tug_altaS.png";
					}
					else if (aux.indexOf("tug_media") != -1)
					{
						foi = 1;
						imgTomadaS.src = "icones/tug_mediaS.png";
					}
					else if (aux.indexOf("tug_baixa") != -1)
					{
						foi = 1;
						imgTomadaS.src = "icones/tug_baixaS.png";
					}
					else{}
					
					if (foi == 1)
					{
						this.image(imgTomadaS);
						
						Camadas[getIndexOf(Camadas, "attrs.id", this.attrs.comodo)].draw();
					}
				}
				//xp[pCir] = Tomada.x();
				//yp[pCir] = Tomada.y();
				//pCir++;
			});
			
			/*Tomadas[Tomadas.length - 1].on('click', function(){
				var imgTomadaS = new Image();
				imgm = imgTomada.src;
				Simg = imgm.split('.');									
				imgTomadas.src = Simg[0]+"S.png";
				this.image(imgTomadaS);
				Camadas[Camadas.length - 1].draw();
			});*/
			
			Tomadas[Tomadas.length - 1].on('mouseover', function(){
				painelDesenho.style.cursor = "hand";
			});
			
			Tomadas[Tomadas.length - 1].on('mouseout', function(){
				painelDesenho.style.cursor = "crosshair";
			});
			
			setProTomadas();
		}
		
		function InserirLampadaTeto(lampadaTeto)
		{
			lampadasTeto.push(lampadaTeto);
			
			lampadasTeto[lampadasTeto.length - 1].on('click',function()
			{
				if(menu == 10)
				{
					/*arrayPontos[iV] = this.attrs.x+30;
					iV++;
					arrayPontos[iV] = this.attrs.y+40;
					iV++;*/
					
					arrayPontos.push
					(
						{
							id: this.attrs.id,
							x: this.attrs.x + 30,
							y: this.attrs.y + 40
						}
					);
				}
			});
			
			setProLampadas();
		}
		
		function DeletarArrayPontos(nome)
		{
			for (cont = 0; cont <= arrayPontos.length - 1; cont = cont + 1)
			{
				if (arrayPontos[cont].id == nome)
				{
					arrayPontos.splice(cont, 1);
				}
			}
		}
		
		//Só chamar a função que ela Faz toda a atualização das propriedades dos comodos
		function setProComodos()
		{
			//Limpa o select
			while(selectComodos.firstElementChild)
			{
				selectComodos.removeChild(selectComodos.firstElementChild);
			}
			
			//reescreve o select
			for (counter = 0; counter <= Comodos.length - 1; counter++)
			{			
				option = document.createElement("option");
				option.text = Comodos[counter].attrs.nome+"";
				selectComodos.add(option);
			}
			
			//determina o taanho final do select
			if(counter <= 1)
			{
				selectComodos.size = "2";
			}
			else
			{
				selectComodos.size = counter+"";
			}
			
		}
		
		//Clicando no comodo nas propriedades ele exibe os detalhes do comodo
		selectComodos.onclick = function()
		{
			comodosMenuAltera();
		}
		
		selectComodos.onchange = function()
		{
			comodosMenuAltera();
		}
		
		
		function comodosMenuAltera()
		{
			var sComodoS = document.getElementById("selectComodos");
			var Csel = sComodoS.options[sComodoS.selectedIndex].innerHTML;
			
			exibirPropriedadesComodo(Csel);
			
			blockDadosPropriedades();
			dadosComodo.style.display = "inline-block";
			//alert(ComodoAttribs.xi);
		}
		
		
		//EXIBINDO PROPRIEDADES DAS TOMADAS
		selectTomadas.onclick = function()
		{
			tomadasMenuAltera();
		}
		
		selectTomadas.onchange = function()
		{
			tomadasMenuAltera();
		}
		
		function tomadasMenuAltera()
		{
			var sTomadaS = document.getElementById("selectTomadas");
			var Tsel = sTomadaS.options[sTomadaS.selectedIndex].innerHTML;
			
			
			exibirPropriedadesTomada(Tsel);
			
			blockDadosPropriedades();
			dadosTomadas.style.display = "inline-block";
		}
		
		
		function exibirPropriedadesTomada(nmTom)
		{
			var TomadaSelecionada = Tomadas[getIndexOf(Tomadas, "attrs.id", nmTom)];
			
			tipoP = TomadaSelecionada.attrs.name;
			tipoF = tipoP.split("?");
			nomeTomadaD.value = tipoF[0];
			
			if(tipoF[1] == "TB")
			{
				nTM = "Tomada baixa";
				aTM = "0.30m";
			}
			else if(tipoF[1] == "TM")
			{
				nTM = "Tomada média";
				aTM = "1.5m";
			}
			else if(tipoF[1] == "TA")
			{
				nTM = "Tomada alta";
				aTM = "2.1m";
			}
			else{}
			tipoTomadaD.value = nTM;
			alturaTomadaD.value = aTM;
		//	posTomadaD.value = "X";
			potenciaTomadaD.value = "600 VA";
		}
		
		
		
		//CIRCUITOS =D
		//EXIBINDO PROPRIEDADES DAS TOMADAS
		selectCircuitos.onclick = function()
		{
			circuitosMenuAltera();
		}
		
		//selectCircuitos.onchange = function()
		//{
		//	circuitosMenuAltera();
		//}
		
		function circuitosMenuAltera()
		{
			var sCircuitoS = document.getElementById("selectCircuitos");
			var Cirsel = sCircuitoS.options[sCircuitoS.selectedIndex].innerHTML;
			
			
			exibirPropriedadesCircuito(Cirsel);
			
			blockDadosPropriedades();
			dadosCircuitos.style.display = "inline-block";
		}
		
		
		function exibirPropriedadesCircuito(nmCir)
		{
			var CircuitoSelecionado = Circuitos[getIndexOf(Circuitos, "attrs.id", nmCir)];
			
			nomeCircuitoD.value = CircuitoSelecionado.attrs.id;
			
			pontosP = CircuitoSelecionado.attrs.points;
			
			
			nPoints = ((CircuitoSelecionado.attrs.points).length)/2;
			
			
			for(conto = 0; conto < nPoints; conto = conto+2)
			{
				Apt = pontosP[conto];
				Bpt = pontosP[conto+1];
				Cpt = pontosP[conto+2];
				Dpt = pontosP[conto+3];
				
				Afnl = Cpt - Apt;
				Bfnl = Bpt - Dpt;
				
				Cfnl = (Afnl * Afnl) + (Bfnl * Bfnl);
				Cfnl = Math.sqrt(Cfnl);
				fios += Cfnl;
			}
			
			pECirD.value = nPoints;
			tensaoCirD.value = "220 V";			
			fios = (fios * 0.15).toFixed(2);
			fiosCirD.value = fios + " m";
			fios = 0;
			potenciaV = nPoints*600;
			correnteV = (potenciaV / 220).toFixed(0)
			potenciaCirD.value = potenciaV + " VA";
			correnteCirD.value = correnteV + " A";			
			bitolaCirD.value = ajusteBitola(correnteV);
		}
		
		
		
		//IDEM PARA TOMADAS
		function setProTomadas()
		{
			//Limpa o select
			while(selectTomadas.firstElementChild)
			{
				selectTomadas.removeChild(selectTomadas.firstElementChild);
			}
			
			//reescreve o select
			for(counter = 0; counter <= Tomadas.length - 1; counter++)
			{			
				option = document.createElement("option");
				option.text = Tomadas[counter].attrs.id+"";
				selectTomadas.add(option);
			}
			
			//determina o taanho final do select
			if(counter <= 1)
			{
				selectTomadas.size = "2";
			}
			else
			{
				selectTomadas.size = counter+"";
			}
		}
		
		function setProLampadas()
		{
			//Limpa o select
			while(selectLampadas.firstElementChild)
			{
				selectLampadas.removeChild(selectLampadas.firstElementChild);
			}
			
			//reescreve o select
			for(counter = 0; counter <= lampadasTeto.length - 1; counter++)
			{			
				option = document.createElement("option");
				option.text = lampadasTeto[counter].attrs.id+"";
				selectLampadas.add(option);
			}
			
			//determina o taanho final do select
			if(counter <= 1)
			{
				selectLampadas.size = "2";
			}
			else
			{
				selectLampadas.size = counter+"";
			}
		}
		
		function blockDadosPropriedades()
		{
			dadosComodo.style.display = "none";
			dadosEsquadria.style.display = "none";
			dadosTomadas.style.display = "none";
			dadosLampadas.style.display = "none";
			dadosInterruptores.style.display = "none";
			dadosCircuitos.style.display = "none";
			dadosConduites.style.display = "none";
			dadosCondutores.style.display = "none";
			//faltam os ultimos
		}
		
		function InserirQuadro(quadro, x, y)
		{
			var index = getIndexOf(Comodos, "attrs.nome", quadro.attrs.comodo);
			
			Quadros.push(quadro);
			
			Quadros[Quadros.length - 1].on('click',function()
			{
				if(menu == 10)
				{
					/*arrayPontos[iV] = this.attrs.x;
					iV++;
					arrayPontos[iV] = this.attrs.y;
					iV++;*/
					
					arrayPontos.push
					(
						{
							id: this.attrs.id,
							x: this.attrs.x + (x),
							y: this.attrs.y + (y)
						}
					);
					
					DesenharCircuito(Camadas[index]);
				}
			});
			
			Quadros[Quadros.length - 1].setZIndex(9999);							
			Camadas[index].add(Quadros[Quadros.length - 1]);
			Camadas[index].draw();
			cQua = cQua + 1;
			
			setProQuadros();
		}
		
		function setProQuadros()
		{
			//Limpa o select
			while(selectQuadros.firstElementChild)
			{
				selectQuadros.removeChild(selectQuadros.firstElementChild);
			}
			
			//reescreve o select
			for(counter = 0; counter <= Quadros.length - 1; counter++)
			{			
				option = document.createElement("option");
				option.text = Quadros[counter].attrs.id+"";
				selectQuadros.add(option);
			}
			
			//determina o taanho final do select
			if(counter <= 1)
			{
				selectQuadros.size = "2";
			}
			else
			{
				selectQuadros.size = counter+"";
			}
		}
		
		function setProCircuitos()
		{
			//Limpa o select
			while(selectCircuitos.firstElementChild)
			{
				selectCircuitos.removeChild(selectCircuitos.firstElementChild);
			}
			
			//reescreve o select
			for(counter = 0; counter <= Circuitos.length - 1; counter++)
			{			
				option = document.createElement("option");
				option.text = Circuitos[counter].attrs.id+"";
				selectCircuitos.add(option);
			}
			
			//determina o taanho final do select
			if(counter <= 1)
			{
				selectCircuitos.size = "2";
			}
			else
			{
				selectCircuitos.size = counter+"";
			}
		}
		
		function ImagemOriginalPonto(id)
		{
			var imgTomadaS = new Image();
			var foi;
			var indexTomada = getIndexOf(Tomadas, "attrs.id", id);
			var indexCamada = getIndexOf(Camadas, "attrs.id", Tomadas[indexTomada].attrs.comodo);
			
			aux = Tomadas[indexTomada].attrs.image.src;
			
			if (aux.indexOf("tug_alta") != -1)
			{
				foi = 1;
				imgTomadaS.src = "icones/tug_alta.png";
			}
			else if (aux.indexOf("tug_media") != -1)
			{
				foi = 1;
				imgTomadaS.src = "icones/tug_media.png";
			}
			else if (aux.indexOf("tug_baixa") != -1)
			{
				foi = 1;
				imgTomadaS.src = "icones/tug_baixa.png";
			}
			else{}
			
			if (foi == 1)
			{
				Tomadas[indexTomada].image(imgTomadaS);
			}
		}
		
		</script>
</html>