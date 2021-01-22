<?php
	include "php/Conexao.php";
	
	$query_Busca = "select * from tb_atividade order by dt_atividade desc limit 4";
			
	$result_Busca = mysql_query($query_Busca) or die(mysql_error());
	$linha_Busca = mysql_fetch_assoc($result_Busca);
	$totalLinha_Busca = mysql_num_rows($result_Busca);
	
	$query_Busca_Acessos = "select count(cd_visita) as 'Acessos' from tb_visita";
			
	$result_Busca_Acessos = mysql_query($query_Busca_Acessos) or die(mysql_error());
	$linha_Busca_Acessos = mysql_fetch_assoc($result_Busca_Acessos);
	$totalLinha_Busca_Acessos = mysql_num_rows($result_Busca_Acessos);
	
	$query_Busca_Online = "select cd_usuario from tb_usuario order by cd_usuario";
			
	$result_Busca_Online = mysql_query($query_Busca_Online) or die(mysql_error());
	$linha_Busca_Online = mysql_fetch_assoc($result_Busca_Online);
	$totalLinha_Busca_Online = mysql_num_rows($result_Busca_Online);
	
	$cont = 0;
	do
	{
		$totalUsuarios[$cont] = $linha_Busca_Online['cd_usuario'];
		$cont = $cont + 1;
	}
	while ($linha_Busca_Online = mysql_fetch_assoc($result_Busca_Online));
	
	$contOnline = 0;
	
	foreach ($totalUsuarios as $usuario)
	{
		$dataTimeAtual = date("Y-m-d H:i:s");
		$dataTimeAtual = strtotime($dataTimeAtual);
		
		$query_Busca_Atividade = "select dt_atividade from tb_atividade where cd_usuario = '$usuario' order by dt_atividade desc limit 1";
				
		$result_Busca_Atividade = mysql_query($query_Busca_Atividade) or die(mysql_error());
		$linha_Busca_Atividade = mysql_fetch_assoc($result_Busca_Atividade);
		$totalLinha_Busca_Atividade = mysql_num_rows($result_Busca_Atividade);
		
		$query_Busca_Usuario = "select ic_logado from tb_usuario where cd_usuario = '$usuario'";
				
		$result_Busca_Usuario = mysql_query($query_Busca_Usuario) or die(mysql_error());
		$linha_Busca_Usuario = mysql_fetch_assoc($result_Busca_Usuario);
		$totalLinha_Busca_Usuario = mysql_num_rows($result_Busca_Usuario);
		
		$diferenca = $dataTimeAtual - strtotime($linha_Busca_Atividade['dt_atividade']);
		
		if ($diferenca <= 600 && $linha_Busca_Usuario['ic_logado'] == 1)
		{
			$contOnline = $contOnline + 1;
		}
	}
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel="shortcut icon" href="imagens/logo/logoblackwhite.png" />
		<title>EletronTech - DashBoard</title>
		<style>
			*
			{
				margin: 0;
				padding: 0;				
				font-family: Century Gothic;
			}
			
			body
			{
				background-color: #000;
			}
			
			#all
			{
				display: inline-block;
				width: 950px;
				height: 500px;
				position: absolute;
				background-color: black;
				margin-left: -475px;
				margin-top: -250px;
				left: 50%;
				top: 50%;
			}
			
			#graficos
			{
				display: inline-block;
				background: linear-gradient(to top, #272727,#585858);
				width: 370px;
				height: 215px;
				border: 5px solid black;
				position: relative;
			}
			
			#acessos
			{
				display: inline-block;
				background: linear-gradient(to top, #272727,#585858);
				width: 380px;
				height: 100px;
				border: 5px solid black;
				position: relative;
				top: -102px;
			}
			
			#usersonline
			{
				display: inline-block;
				background: linear-gradient(to top, #272727,#585858);
				width: 180px;
				height: 100px;
				position: relative;
				left:385px;
				top: -110px;
				border: 5px solid black;
			}
			
			#atividades
			{
				display: inline-block;
				background: linear-gradient(to top, #272727,#585858);
				width: 360px;
				height: 328px;
				position: absolute;
				left:575px;
				margin-top: -110px;
				border: 5px solid black;
			}
			
			#ot
			{
				display: inline-block;
				width: 565px;
				height: 200px;
				position: absolute;
				left: -2px;
				margin-top: 5px;
			}
			
			#ot div
			{
				border: 5px solid black;
			}
			
			#downloads
			{
				display: inline-block;
				width: 180px;
				height: 100px;
				background: linear-gradient(to top, #272727,#585858);
			}
			
			#calculos
			{
				display: inline-block;
				width: 180px;
				height: 100px;
				background: linear-gradient(to top, #272727,#585858);
			}
			
			#horas
			{
				display: inline-block;
				width: 180px;
				height: 100px;
				background: linear-gradient(to top, #272727,#585858);
			}
			
			#uploads
			{
				display: inline-block;
				width: 180px;
				height: 100px;
				background: linear-gradient(to top, #272727,#585858);
			}
			
			#eventos
			{
				display: inline-block;
				width: 180px;
				height: 100px;
				background: linear-gradient(to top, #272727,#585858);
			}
			
			#grana
			{
				display: inline-block;
				width: 180px;
				height: 100px;
				background: linear-gradient(to top, #272727,#585858);
			}
			
			
			#eventos:hover, #grana:hover, #uploads:hover, #downloads:hover, #horas:hover, #calculos:hover, #usersonline:hover
			{
				background: linear-gradient(to top, #040c53, #0f1fb9);
			}
			
			
			#imgD
			{
				display: inline-block;
				width: 80px;
				margin-top: 15px;
				position: absolute;
			}
			
			.lbl
			{
				display: inline-block;
				color: #059bfb;
				width: 170px;
				font-size: 26px;
				margin-top: 25px;
				position: absolute;
				z-index: 9999;
				text-shadow: 2px 2px #111;
			}
			
			.lble
			{
				display: inline-block;
				color: #059bfb;
				width: 150px;
				font-size: 26px;
				margin-top: 25px;
				position: absolute;
				z-index: 9999;
				text-shadow: 2px 2px #111;
			}
			
			.lbla
			{
				display: inline-block;
				color: #059bfb;
				width: 250px;
				font-size: 40px;
				margin-top: 25px;
				position: absolute;
				z-index: 9999;
				text-shadow: 2px 2px #111;
			}
			
			.lblnm
			{
				display: inline-block;
				color: gray;
				width: 170px;
				font-size: 12px;
				bottom: 25px;
				position: absolute;
				text-shadow: 2px 2px #111;
			}
			
			.lblnmo
			{
				display: inline-block;
				color: gray;
				width: 170px;
				font-size: 12px;
				margin-top:60px;
				position: absolute;
				text-shadow: 2px 2px #111;
			}
			
			.lblnmoe
			{
				display: inline-block;
				color: gray;
				width: 150px;
				font-size: 12px;
				margin-top:60px;
				position: absolute;
				text-shadow: 2px 2px #111;
			}
			
			.lblnmoa
			{
				display: inline-block;
				color: gray;
				width: 250px;
				font-size: 14px;
				margin-top:75px;
				position: absolute;
				text-shadow: 2px 2px #111;
			}
			#etLogo
			{
				width: 40px;
				margin-top: 2px;
				position: absolute;
			}
			
			#saudacao
			{
				font-size: 36px;
				color: gray;
				margin-left: 55px;
				text-shadow: 1px 1px #222;
			}
			
			#mensagens
			{
				display: inline-block;
				width: 160px;
				height: 100px;
				background: linear-gradient(to top, #272727,#585858);
				position: absolute;
				top: 49px;
			}
			
			#log
			{
				display: inline-block;
				width: 90%;
				height: 70%;
				margin-left: 5%;
				margin-top: 30px;
				overflow: hidden;
			}
			
			.lblnmat
			{
				display: inline-block;
				color: gray;
				width: 170px;
				font-size: 12px;
				bottom: 25px;
				position: absolute;
				text-shadow: 2px 2px #111;
				right: 20px;
			}
			
			#datalog
			{
				display: inline-block;
				color: #059bfb;
				width: 100%;
				font-size: 10px;
				bottom: 25px;
				text-shadow: 1px 1px #111;
				right: 20px;
			}
			
			#msglog
			{
				display: inline-block;
				color: #aaa;
				width: 100%;
				font-size: 12px;
				bottom: 25px;
				text-shadow: 1px 1px #111;
				right: 20px;
			}
			
			#atv
			{
				margin-bottom: 20px;
			}
		</style>
	</head>
	<script>
		var ultimaAtividade = new Array;
	</script>
	<script src="RGraph/libraries/RGraph.common.core.js" ></script>
	<script src="RGraph/libraries/RGraph.common.annotate.js" ></script>
	<script src="RGraph/libraries/RGraph.common.context.js" ></script>
	<script src="RGraph/libraries/RGraph.common.tooltips.js" ></script>
	<script src="RGraph/libraries/RGraph.common.resizing.js" ></script>
	<script src="RGraph/libraries/RGraph.bar.js" ></script>
	
	<?php
		$myQuery = "select dt_data as 'Data', count(dt_data) as 'Visitas' from tb_visita group by dt_data order by dt_data desc limit 7";
		$consultar = mysql_query($myQuery);
		 
		$i = 1;
		while($resultado = mysql_fetch_array($consultar)){
			$visita[$i] = $resultado['Visitas'];
			$datasvisita[$i] = $resultado['Data'];
			$i++;
		}
	 
		$dadosVisitas = join(",", array($visita[1],$visita[2],$visita[3],$visita[4],$visita[5],$visita[6],$visita[7]));
		$dadosVisitas = "[$dadosVisitas]";
		
		echo "<script>" . "\n";
		echo "var visitadata = new Array(8);";
		echo "dadosVisitas = $dadosVisitas;" . "\n";
		echo "visitadata[1] = $visita[1];";
		echo "visitadata[2] = $visita[2];";
		echo "visitadata[3] = $visita[3];";
		echo "visitadata[4] = $visita[4];";
		echo "visitadata[5] = $visita[5];";
		echo "visitadata[6] = $visita[6];";
		echo "visitadata[7] = $visita[7];";
		echo "</script>"  . "\n";
	?>
	<body>
		<div id="all">
			<div id="titulo">
				<img id="etLogo" src="imagens/logowhite.png">
				<label id="saudacao">DASHBOARD</label>
			</div>
			<div id="dashboard">
				<div id="graficos" align="center">
					<canvas id="meuCanvasGraficoVisitas" width="350" height="200" style="background-color: transparent; margin-top:7.5px;">[No canvas support]</canvas>
					<label class="lblnmat" align="right">Acessos ao EletronTech</label>
				</div>
				
				<div id="acessos">
					<img src="imagens\mouse-dash.png" id="imgD">
					<label id="lbla" class="lbla" align="right"><?php echo $linha_Busca_Acessos['Acessos']; ?></label>
					<label class="lblnmoa" align="right">Acessos</label>
				</div>
				
				<div id="mensagens" align="left">
					<img src="imagens\mensagem-dash.png" id="imgD">
					<label class="lble" align="right">3</label>
					<label class="lblnmoe" align="right">Mensagens</label>
				</div>
				
				<div id="usersonline">
					<img src="imagens\usuarios-dash.png" id="imgD">
					<label id="lbl" class="lbl" align="right"><?php echo $contOnline."/".count($totalUsuarios); ?></label>
					<label class="lblnm" align="right">Usuários Online</label>
				</div>
				
				<div id="atividades">
					<div id="log">
						<!--Atividades-->
						<?php
							do
							{
								if ($linha_Busca['ds_atividade'] != "")
								{
									echo "
										<script>
											log = document.getElementById('log');
											
											atv = document.createElement('div');
											atv.setAttribute('id', 'atv');
											atv.setAttribute('class', 'filho');
											atv.setAttribute('align', 'right');";
											
									$aux = '<label id="datalog">'.date("d/m/Y", strtotime($linha_Busca['dt_atividade'])).' às '.date("H:i", strtotime($linha_Busca['dt_atividade'])).'</label><br><label id="msglog">'.$linha_Busca['ds_atividade'].'</label>';
															
									echo "	atv.innerHTML = '".$aux."';
											
											if (ultimaAtividade.length == 0)
											{
												ultimaAtividade.push('".$linha_Busca['cd_atividade']."');
												
												aux = log.getElementsByClassName('filho');
												
												log.insertAdjacentElement('beforeend', atv);
											}
											
											if (ultimaAtividade[ultimaAtividade.length - 1] != '".$linha_Busca['cd_atividade']."')
											{
												ultimaAtividade.push('".$linha_Busca['cd_atividade']."');
												
												aux = log.getElementsByClassName('filho');
												
												log.insertAdjacentElement('beforeend', atv);
											}
										</script>";
								}
							}
							while ($linha_Busca = mysql_fetch_assoc($result_Busca));
						?>
						<!--Fim-->
					</div>
					<label class="lblnmat" align="right">Últimas Atividades</label>
				</div>
				<div id="ot">
					<table>
						<tr>
							<td>
								<div id="downloads">
									<img src="imagens\download-dash.png" id="imgD">
									<label class="lbl" align="right">260MB</label>
									<label class="lblnmo" align="right">Downloads</label>
								</div>
							</td>
							<td>
								<div id="calculos">
									<img src="imagens\calculos-dash.png" id="imgD">
									<label class="lbl" align="right">1274</label>
									<label class="lblnmo" align="right">Cálculos</label>
								</div>
							</td>
							<td>
								<div id="horas">
									<img src="imagens\horas-dash.png" id="imgD">
									<label class="lbl" align="right">3200h</label>
									<label class="lblnmo" align="right">Logado</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div id="uploads">
									<img src="imagens\upload-dash.png" id="imgD">
									<label class="lbl" align="right">12.4MB</label>
									<label class="lblnmo" align="right">Uploads</label>
								</div>
							</td>
							<td>
								<div id="eventos">
									<img src="imagens\calendario-dash.png" id="imgD">
									<label class="lbl" align="right">72</label>
									<label class="lblnmo" align="right">Eventos Criados</label>
								</div>
							</td>
							<td>
								<div id="grana">
									<img src="imagens\money-dash.png" id="imgD">
									<label class="lbl" align="right">R$59,02</label>
									<label class="lblnmo" align="right">em Pacotes</label>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<iframe id="atualizaDashBoard" src="" style="display: none"></iframe>
	</body>
	<script>
		window.onload = function()
		{
			Atualizar();
			var meuGraficoVisitas = new RGraph.Bar('meuCanvasGraficoVisitas', dadosVisitas);
				meuGraficoVisitas.Set('chart.background.barcolor1', 'transparent');
				meuGraficoVisitas.Set('chart.background.barcolor2', 'transparent');
				
				//meuGraficoVisitas.Set('chart.labels', ['<?php echo date("d/m/Y", strtotime($datasvisita[1])); ?>','<?php echo date("d/m/Y", strtotime($datasvisita[2])); ?>','<?php echo date("d/m/Y", strtotime($datasvisita[3])); ?>','<?php echo date("d/m/Y", strtotime($datasvisita[4])); ?>','<?php echo date("d/m/Y", strtotime($datasvisita[5])); ?>','<?php echo date("d/m/Y", strtotime($datasvisita[6])); ?>','<?php echo date("d/m/Y", strtotime($datasvisita[7])); ?>']);
				meuGraficoVisitas.Set('chart.tooltips', ['<?php echo date("d/m/Y", strtotime($datasvisita[1])); ?> tem ' + visitadata[1] + ' acesso(s)', '<?php echo date("d/m/Y", strtotime($datasvisita[2])); ?> tem ' + visitadata[2] + ' acesso(s)', '<?php echo date("d/m/Y", strtotime($datasvisita[3])); ?> tem ' + visitadata[3] + ' acesso(s)', '<?php echo date("d/m/Y", strtotime($datasvisita[4])); ?> tem ' + visitadata[4] + ' acesso(s)', '<?php echo date("d/m/Y", strtotime($datasvisita[5])); ?> tem ' + visitadata[5] + ' acesso(s)', '<?php echo date("d/m/Y", strtotime($datasvisita[6])); ?> tem ' + visitadata[6] + ' acesso(s)', '<?php echo date("d/m/Y", strtotime($datasvisita[7])); ?> tem ' + visitadata[7] + ' acesso(s)']);
				meuGraficoVisitas.Set('chart.text.angle', 45);
				meuGraficoVisitas.Set('chart.gutter', 35);
				meuGraficoVisitas.Set('chart.shadow', true);
				meuGraficoVisitas.Set('chart.shadow.blur', 5);
				meuGraficoVisitas.Set('chart.shadow.color', '#000');
				meuGraficoVisitas.Set('chart.shadow.offsety', -3);
				meuGraficoVisitas.Set('chart.colors', ['#00CED1']);
				meuGraficoVisitas.Set('chart.key.position', 'gutter');
				meuGraficoVisitas.Set('chart.text.size', 10);
				meuGraficoVisitas.Set('chart.text.font', 'Century Gothic');
				meuGraficoVisitas.Set('chart.text.angle', 0);
				meuGraficoVisitas.Set('chart.grouping', 'stacked');
				meuGraficoVisitas.Draw();
		}
		
		function Atualizar()
		{
			atualizaDashBoard.src = "php/AtualizarDashBoard.php?primeiraAtividade=" + ultimaAtividade[0];
			setTimeout("Atualizar()", 10000);
		}
	</script>
</html>

<?php
	mysql_close($conexao);
?>