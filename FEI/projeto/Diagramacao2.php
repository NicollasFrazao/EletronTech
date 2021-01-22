<?php
	include "../php/Conexao.php";
	
	session_start();
	
	$captURL = $_SERVER['REQUEST_URI'];
	$spr = explode('?',$captURL);
	
	$codigoFerramenta = $spr[1];
	$codigoUsuario	= $_SESSION['codigo'];
	
	include "../php/Utilizacao.php";
	
	$nm_projeto = $_POST['nm_projeto'];
	$altura = $_POST['altura'];
	$largura = $_POST['largura'];
	$comprimento = $_POST['comprimento'];

	$desen = $_POST['desenvolvimento'];
	$sistema = $_POST['sistema_fornecimento'];
	
	$query = "select nm_projeto, cd_usuario from tb_projeto where nm_projeto = '$nm_projeto' and cd_usuario = '$codigoUsuario'";
	
	if (!mysql_query($query))
	{
		$query = mysql_query("insert into tb_projeto values(NULL, '$nm_projeto', '$desen', $altura, $largura, $comprimento, '$sistema', $codigoUsuario)") or die ("Já existe um projeto com esse nome. ERRO: " . mysql_error());
	}
	
?>

<html>
	<head>
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
			display: inline-block;
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
								<tr>
									<td>
										<label>Posicionamento:</label>
									</td>
									<td>
										<input id="posTomadaD">
									</td>
								</tr>
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
							  <?php
								$query =  mysql_query("select cd_comodo, nm_comodo from tb_comodo where cd_projeto = 1 order by nm_comodo") or die(mysql_error());
								$cont=0;
								while($comodosAll = mysql_fetch_array($query))
								{
									$cdComodo = $comodosAll["cd_comodo"];	
									$nomeComodo = $comodosAll["nm_comodo"];	
									$cont++;									
								?>
								<option value="<?php echo $cdComodo; ?>" onclick="comodo()"><?php echo $nomeComodo; ?></option>
								<?php
								echo "<script> selectComodos.size = $cont;</script>";
								}
								?>
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
							  <?php
								$query =  mysql_query("select cd_tomada, nm_tomada from tb_tomada
														inner join tb_ponto_eletrico on tb_ponto_eletrico.cd_ponto_eletrico = tb_tomada.cd_ponto_eletrico
														inner join tb_comodo on tb_ponto_eletrico.cd_comodo = tb_comodo.cd_comodo
														where cd_projeto = 1 order by nm_tomada") or die(mysql_error());
								$cont=0;
								while($tomadasAll = mysql_fetch_array($query))
								{
									$cdTomada = $tomadasAll["cd_esquadria"];
									$nomeTomada = $tomadasAll["nm_esquadria"];
									$cont++;
								?>
								<option value="<?php echo $cdTomada; ?>"><?php echo $nomeTomada; ?></option>
								<?php
								echo "<script> selectTomadas.size = $cont;</script>";
								}
								?>
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
</body>
<script type="text/javascript" src="js/etMenuClick.js"></script>
<script src="kinetic.js"></script>
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
		limpaVar();	
		
		//DEFINIÇÃO DE ESCALA
		escala = 1;		
		larguraTotal = 25 * 5;
		alturaTotal = 3.5;
		comprimentoTotal = 80 * 5;
		comDraw = 1;
		pdes = 1;
		myS = 1;
		com = 0;		
		hist = [];
		hi = 0;
		gerar();
		
		//menu = 9;
		//selecionarMenu();
		
		var minX= 0;
		var maxX= (760 - comprimentoTotal) - 20;
		var minY=0;
		var maxY=(570 - larguraTotal) - 20;
		
		Comodos = [];
		btn_desenhar_2.click();
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
	
	painelDesenho.onmousedown = function()
	{		
		if(comDraw == 1)
		{
			//X1 = parseInt((event.clientX)) - ((screen.width/2) - (pjtW/2))+75/myS;
			//Y1 = parseInt((event.clientY)) - ((screen.height/2) - (pjtH/2))+30/myS;
			coordenadas_mouse_painel = painel.getPointerPosition();
			X1 = coordenadas_mouse_painel.x;
			Y1 = coordenadas_mouse_painel.y;
			//alert(X1+","+Y1);
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
		coordenadas_mouse_painel = painel.getPointerPosition();
		X2 = coordenadas_mouse_painel.x;
		Y2 = coordenadas_mouse_painel.y;
		
		//DESENHAR COMODO
		if(menu == 2 && pdes == 1)
		{		
			//INSERINDO A CAMADA DO COMODO
			var camada = new Kinetic.Layer
			(
				{
					id:'camada'+com
				}
			);	
			camada.setDraggable(false);
			painel.add(camada);
			camada.draw();
			
			//INSERINDO O COMODO
			var comodo = new Kinetic.Rect
			(
				{
					id: 'com',
					x: X1,
					y: Y1,
					width: X2-X1,
					height: Y2-Y1, 
					fill: 'white' 
				}
			);
			
			camada.add(comodo);			
			
			//Criando os pontos ancoras do comodo
			var point1 = new Kinetic.Rect
			(
				{			
					x: X1-5,
					y: Y1-5,
					width: 10,
					height: 10,
					fill: 'blue',
					draggable: false
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
					draggable: false
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
					draggable: false
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
					draggable: false
				}
			);		
			camada.add(point1);
			camada.add(point2);
			camada.add(point3);
			camada.add(point4);
			camada.draw();
			
			//ADICIONAR NO ARRAY DE COMODOS
		}
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
	
	function comodo()
	{
		comodoNow = selectComodos.value;		
		
	}
	
	function exibirPropriedadesComodo(nmCom)
	{
		ComodoSelecionado = Comodos[getIndexOf(Comodos, "nome", iddd)];
		nomeComodoD.value = ComodoSelecionado.nome;
		//tipoComodoD.value = ComodoSelecionado.tipo;
		//alturaComodoD.value = ;
		largComodoD.value = ComodoSelecionado.largura+"m";
		compComodoD.value = ComodoSelecionado.comprimento+'m';
		areaComodoD.value = ComodoSelecionado.area+"m";
		perimetroComodoD.value = ComodoSelecionado.perimetro+"m";
	}
</script>
</html>