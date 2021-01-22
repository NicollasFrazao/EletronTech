<?php
	include "php/Conexao.php";
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );

	date_default_timezone_set( 'America/Sao_Paulo' );
	
	session_start();
	$codigo = $_SESSION['EletronTech']['codigo'];
	
	$query_Busca_Evento = "select * from tb_evento where dt_evento >= curdate() and cd_usuario = '$codigo' order by dt_evento";
	$result_Busca_Evento = mysql_query($query_Busca_Evento) or die(mysql_error());
	$linha_Busca_Evento = mysql_fetch_assoc($result_Busca_Evento);
	$totalLinha_Busca_Evento = mysql_num_rows($result_Busca_Evento);
	
	$query_Busca_Evento_Menor = "select * from tb_evento where dt_evento >= curdate() and cd_usuario = '$codigo' order by dt_evento limit 1";
	$result_Busca_Evento_Menor = mysql_query($query_Busca_Evento_Menor) or die(mysql_error());
	$linha_Busca_Evento_Menor = mysql_fetch_assoc($result_Busca_Evento_Menor);
	$totalLinha_Busca_Evento_Menor = mysql_num_rows($result_Busca_Evento_Menor);
	
	$query_Busca_Evento_Maior = "select * from tb_evento where dt_evento >= curdate() and cd_usuario = '$codigo' order by dt_evento desc limit 1";
	$result_Busca_Evento_Maior = mysql_query($query_Busca_Evento_Maior) or die(mysql_error());
	$linha_Busca_Evento_Maior = mysql_fetch_assoc($result_Busca_Evento_Maior);
	$totalLinha_Busca_Evento_Maior = mysql_num_rows($result_Busca_Evento_Maior);

	if ($linha_Busca_Evento['dt_evento'] != "")
	{
		$anoMaior = date("Y", strtotime($linha_Busca_Evento_Maior['dt_evento']));
		$anoMenor = date("Y", strtotime($linha_Busca_Evento_Menor['dt_evento']));
		
		$mesMaior = date("m", strtotime($linha_Busca_Evento_Maior['dt_evento']));
		$mesMenor = date("m", strtotime($linha_Busca_Evento_Menor['dt_evento']));
	}
	else
	{
		$anoMaior = date("Y");
		$anoMenor = date("Y");
		
		$mesMaior = date("m");
		$mesMenor = date("m");
	}
	
	$cont = 0;
	echo '<script> 
			classes = new Array;
		</script>';
	$class = array();
	do
	{
		if ($linha_Busca_Evento['dt_evento'] != "")
		{
			if (!in_array(date("m", strtotime($linha_Busca_Evento['dt_evento'])).date("Y", strtotime($linha_Busca_Evento['dt_evento'])), $class) == -1)
			{
				$class[$cont] = date("m", strtotime($linha_Busca_Evento['dt_evento'])).date("Y", strtotime($linha_Busca_Evento['dt_evento']));
				echo '<script> if (classes.indexOf("'.$class[$cont].'") == -1) {classes.push("'.$class[$cont].'");} </script>';
				$cont = $cont + 1;
			}
		}
		else
		{
			$class[$cont] = $mesMenor.$anoMenor;
			echo '<script> if (classes.indexOf("'.$class[$cont].'") == -1) {classes.push("'.$class[$cont].'");} </script>';
			$cont = $cont + 1;
		}
	}
	while ($linha_Busca_Evento = mysql_fetch_assoc($result_Busca_Evento));
	
	function TransformaMes($mes)
	{
		switch ($mes)
		{
			case 1:
			{
				$mes = 'Janeiro';
			}
			break;
			
			case 2:
			{
				$mes = 'Fevereiro';
			}
			break;
			
			case 3:
			{
				$mes = 'Março';
			}
			break;
			
			case 4:
			{
				$mes = 'Abril';
			}
			break;
			
			case 5:
			{
				$mes = 'Maio';
			}
			break;
			
			case 6:
			{
				$mes = 'Junho';
			}
			break;
			
			case 7:
			{
				$mes = 'Julho';
			}
			break;
			
			case 8:
			{
				$mes = 'Agosto';
			}
			break;
			
			case 9:
			{
				$mes = 'Setembro';
			}
			break;
			
			case 10:
			{
				$mes = 'Outubro';
			}
			break;
			
			case 11:
			{
				$mes = 'Novembro';
			}
			break;
			
			case 12:
			{
				$mes = 'Dezembro';
			}
			break;
		}
		return $mes;
	}
	
	function DiaDaSemana($dia)
	{
		$dias = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira','Quinta-feira','Sexta-feira', 'Sábado');
		
		return $dias[$dia - 1];
	}
	
	echo '<script> meses = new Array; </script>';
	echo '<script> anos = new Array; </script>';
	
	$contMes = 0;
	$contAno = 0;
	$ano = array();
	$mes = array();
	
	if ($mesMaior > $mesMenor && $anoMaior == $anoMenor)
	{
		$query_Busca_Evento = "select * from tb_evento where dt_evento >= curdate() and cd_usuario = '$codigo' order by dt_evento";
		$result_Busca_Evento = mysql_query($query_Busca_Evento) or die(mysql_error());
		$linha_Busca_Evento = mysql_fetch_assoc($result_Busca_Evento);
		$totalLinha_Busca_Evento = mysql_num_rows($result_Busca_Evento);

		do
		{
			if (!in_array(date("m", strtotime($linha_Busca_Evento['dt_evento'])), $mes) == -1)
			{
				$mes[$contMes] = TransformaMes(date("m", strtotime($linha_Busca_Evento['dt_evento'])));
				echo '<script> if (meses.indexOf("'.$mes[$contMes].'") == -1) {meses.push("'.$mes[$contMes].'");} </script>';
				$contMes = $contMes + 1;
			}
			
			if (!in_array(date("Y", strtotime($linha_Busca_Evento['dt_evento'])), $ano) == -1)
			{
				$anos[$contAno] = date("Y", strtotime($linha_Busca_Evento['dt_evento']));
				echo '<script> if (anos.indexOf("'.$anos[$contAno].'") == -1) {anos.push("'.$anos[$contAno].'");} </script>';
				$contAno = $contAno + 1;
			}
		}
		while ($linha_Busca_Evento = mysql_fetch_assoc($result_Busca_Evento));
	}
	else if ($anoMaior > $anoMenor)
	{
		$query_Busca_Evento = "select * from tb_evento where dt_evento >= curdate() and cd_usuario = '$codigo' order by dt_evento";
		$result_Busca_Evento = mysql_query($query_Busca_Evento) or die(mysql_error());
		$linha_Busca_Evento = mysql_fetch_assoc($result_Busca_Evento);
		$totalLinha_Busca_Evento = mysql_num_rows($result_Busca_Evento);
		
		do
		{
			if (!in_array(date("m", strtotime($linha_Busca_Evento['dt_evento'])), $mes) == -1)
			{
				$mes[$contMes] = TransformaMes(date("m", strtotime($linha_Busca_Evento['dt_evento'])));
				echo '<script> if (meses.indexOf("'.$mes[$contMes].'") == -1) {meses.push("'.$mes[$contMes].'");} </script>';
				$contMes = $contMes + 1;
			}
			
			if (!in_array(date("Y", strtotime($linha_Busca_Evento['dt_evento'])), $ano) == -1)
			{
				$anos[$contAno] = date("Y", strtotime($linha_Busca_Evento['dt_evento']));
				echo '<script> if (anos.indexOf("'.$anos[$contAno].'") == -1) {anos.push("'.$anos[$contAno].'");} </script>';
				$contAno = $contAno + 1;
			}
		}
		while ($linha_Busca_Evento = mysql_fetch_assoc($result_Busca_Evento));		
	}
	else if ($mesMaior > $mesMenor)
	{
		$query_Busca_Evento = "select * from tb_evento where dt_evento >= curdate() and cd_usuario = '$codigo' order by dt_evento";
		$result_Busca_Evento = mysql_query($query_Busca_Evento) or die(mysql_error());
		$linha_Busca_Evento = mysql_fetch_assoc($result_Busca_Evento);
		$totalLinha_Busca_Evento = mysql_num_rows($result_Busca_Evento);
		
		do
		{
			if (!in_array(date("m", strtotime($linha_Busca_Evento['dt_evento'])), $mes) == -1)
			{
				$mes[$contMes] = TransformaMes(date("m", strtotime($linha_Busca_Evento['dt_evento'])));
				echo '<script> if (meses.indexOf("'.$mes[$contMes].'") == -1) {meses.push("'.$mes[$contMes].'");} </script>';
				$contMes = $contMes + 1;
			}
			
			if (!in_array(date("Y", strtotime($linha_Busca_Evento['dt_evento'])), $ano) == -1)
			{
				$anos[$contAno] = date("Y", strtotime($linha_Busca_Evento['dt_evento']));
				echo '<script> if (anos.indexOf("'.$anos[$contAno].'") == -1) {anos.push("'.$anos[$contAno].'");} </script>';
				$contAno = $contAno + 1;
			}
		}
		while ($linha_Busca_Evento = mysql_fetch_assoc($result_Busca_Evento));
	}
	else
	{
		$ano[0] = $anoMenor;
		echo '<script> anos.push("'.$ano[0].'"); </script>';
		$mes[0] = TransformaMes($mesMenor);
		echo '<script> meses.push("'.$mes[0].'"); </script>';
	}
	
	$tipo = 0;
	$valorBusca = "";
	
	if (isset($_GET['buscar']))
	{
		if ($_GET['tipo'] == 1)
		{
			$valorBusca = mysql_escape_string($_GET['valorBusca']);
		
			$query_Busca = "select * from tb_evento 
								where nm_evento like '%$valorBusca%'
									and cd_usuario = '$codigo'
								order by dt_evento";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
			
		}
		else if ($_GET['tipo'] == 2)
		{
			$valorBusca = mysql_escape_string($_GET['valorBusca']);
			$valorBusca = split('/', $valorBusca);
			$aux = $valorBusca[2].'-'.$valorBusca[1].'-'.$valorBusca[0];
			
			$query_Busca = "select * from tb_evento 
								where dt_evento = '$aux'
									and cd_usuario = '$codigo'
								order by dt_evento";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
		}
		else if ($_GET['tipo'] == 3)
		{
			$valorBusca = mysql_escape_string($_GET['valorBusca']);
		
			$query_Busca = "select * from tb_evento 
								where ds_evento like '%$valorBusca%'
									and cd_usuario = '$codigo'
								order by dt_evento";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
		}
		
		$pesquisou = 1;
		$slider = $_GET['slider'];
	}
	else
	{
		$query_Busca = "select * from tb_evento 
							where cd_usuario = '$codigo'
								order by dt_evento limit 0";
			
		$result_Busca = mysql_query($query_Busca) or die(mysql_error());
		$linha_Busca = mysql_fetch_assoc($result_Busca);
		$totalLinha_Busca = mysql_num_rows($result_Busca);
		
		$pesquisou = 0;
		$slider = 0;
	}
	
	$url = $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING'];
	$url = str_replace("/sites", "", $url);
	$url = str_replace("/EletronTech/", "", $url);
	$url = str_replace("/eletrontech/", "", $url);
	
	echo '<script> parent.txt_urlEventos.value = "'.$url.'"; </script>';
	
	function ConfereQuebra()
	{
		switch (strtoupper(substr(PHP_OS, 0, 3))) 
		{
			// Windows
			case 'WIN':
			{
				$quebra = "\r\n";
			}
			break;

			// Mac
			case 'DAR':
			{
				$quebra = "\r";
			}
			break;

			// Unix
			default:
			{
				$quebra = "\n";
			}
		}
		
		return $quebra;
	}
	
	$query = mysql_query("delete from tb_evento where dt_evento < curdate() and cd_usuario = '$codigo'");
?>

<html>
	<head>
		<meta charset="UTF-8">
		<title>Eventos</title>
		<style type="text/css">
			@import url("php/msg.css");
		</style>
		<style>
			*
			{
				margin: 0;
				padding: 0;
				font-family: Century Gothic;
				border: 0px;
				cursor: hand;
			}
			
			::-webkit-scrollbar
			{
				height: 12px;
				width: 12px;
				background: black;
			}
			
			::-webkit-scrollbar-thumb
			{
				background: #1F5CB1;
				-webkit-box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.75);
			}

			::-webkit-scrollbar-corner
			{
				background: #000;
			}
			
			body
			{
				background-color: transparent;
			}
			
			#all
			{
				display: inline-block;
				width: 600px;
				height: 500px;
				position: absolute;
				margin-left: -475px;
				margin-top: -270px;
				left: 50%;
				top: 50%;
				
			}
			
			#eventoMenu
			{
				display: inline-block;
				width: 600px;
				height: 470px;
				margin-top: 25px;
				margin-left: 330px;
				box-shadow: 0px 0px 4px 0px #222222;
			}
			
			#barraSuperior
			{
				display: inline-block;
				width: 100%;
				height: 50px;
				background-color: #292929;
				
			}
			
			#mesAnterior
			{
				display: inline-block;
				width: 100px;
				height: 100%;
				float: left;
			}
			
			#mesAtual
			{
				display: inline-block;
				color: white;
				width: 380px;
				position: absolute;
			}
			
			#mesProximo
			{
				display: inline-block;
				width: 100px;
				height: 100%;
				float: right;
			}
			
			#mesAnterior:hover, #mesProximo:hover
			{
				background: linear-gradient(#167ff6, #1F5CB1);
			}
			
			#eventos
			{
				display: inline-block;
				width: 100%;
				height: 420px;
				overflow: auto;
				background-color: #222222;
			}
			
			#barraInferior
			{
				display: none;
				width: 100%;
				height: 30px;
				background: linear-gradient(black, #181818);
			}	
			
			#barraSuperior img
			{
				width: 50%;
			}
			
			h1
			{
				padding-top: 10px;
				font-weight: normal;
				font-size: 24px;
			}
			
			#barraInferior table
			{
				float: right;
			}
			#barraInferior img
			{
				display: inline-block;
				width: 35px;
				margin-top: -5px;
			}
			
			#evto
			{
				display: inline-block;
				background: linear-gradient(#1F5CB1, #1F5CB1);
				width: 160px;
				height: 120px;
				margin: 15px;
				color: white;
				background-image: url('imagens/cali.png');
				background-size: 80px 80px;
				background-repeat: no-repeat;
				background-position: 50% 10%; 
			}
			
			#nmEvento
			{
				display: inline-block;
				margin-top: 15px;
				font-size: 16px;
			}
			
			#diaEvento
			{
				display: inline-block;
				margin-top: 35px;
				font-size: 30px;
			}
			
			#evtO:hover
			{
				background-color: #167ff6;
			}
			
			#evtD
			{
				display: none;
				width: 300px;
				background-color: #167ff6;
				height: 470px;
				color: white;
				position: absolute;
				z-index: 99999;
				left: 0;
				top: 70;
				box-shadow: 0px 0px 1px 0px #1F5CB1;
			}
			
			#evtD img
			{
				height: 100px;
			}
			
			#nmEVT
			{
				display: inline-block;
				width: 100%;
				font-weight: bold;
			}
			
			#dtEVT
			{
				display: inline-block;
				width: 100%;
			}
			
			#diaSemana
			{
				display: inline-block;
				width: 100%;
				margin-bottom: 30px;
			}
			
			#ds
			{
				font-weight: bold;
			}
			
			#dsEVT
			{
			}
			
			#down
			{
				display: inline-block;
				bottom: 0;
				height: 20px;
			}
			
			#down table
			{
				display: inline-block;
				width: 100px;
				float: right;
				position: absolute;
				bottom: 0;
				right: 0;
			}
			
			#down img
			{
				height: 25px;
			}
			
			#etLogo
			{
				margin-left: -5px;
				width: 50px;
				margin-bottom: -15px;
			}
			
			#saudacao
			{
				font-size: 36px;
				color: #167ff6;
				margin-left: 25px;
			}
			
			#tp
			{
				display: none;
				background-color: black;
				width: 100%;
				height: 100%;
				z-index: 9997;
				position: absolute;
				opacity: 0.7;
			}
			
			#lblLegenda
			{
				color: white;
			}
			
			#cadNew
			{
				display: none;
				width: 300px;
				height: 420px;
				position: absolute;
				top: 0;
				left: 0;
				background-color: #264476;
				z-index: 9999;
				border: 0px;
				overflow: hidden;
			}
			
			#cadUpdate
			{
				display: none;
				width: 300px;
				height: 420px;
				position: absolute;
				top: 0;
				left: 0;
				background-color: #264476;
				z-index: 9999;
				border: 0px;
				overflow: hidden;
			}
			
			#sinistraD
			{
				display: none;
				width: 300px;
				height: 470px;
				position: absolute;
				top: 70;
				background-color: #167ff6;
			}
			
			#sinistraD gimg
			{
				width: 50px;
			}
			
			#lblCriar
			{
				color: white;
			}
			
			#esquerdaa
			{
				display: inline-block;
				width: 300px;
				height: 470px;
				position: absolute;
				top: 70;
				background-color: #264476;
			}
			
			#giu
			{
				display: inline-block;
				background-color: #0b61b0;
				width: 100%;
				height: 50px;
				position: absolute;
				bottom: 0;
			}
			
			#giu table
			{
				display: inline-block;
				width: 100%;
				height: 50px;
			}
			
			#giu td
			{
				display: inline-block;
				width: 33%;
				height: 100%;
			}
			
			#giu td:hover
			{
				background-color: #0f83ee;
			}
			
			#giu img
			{
				height: 40px;
			}
			
			#buscarEvt
			{
				display: none;
				width: 240px;
				height: 400px;
				position: absolute;
				top: 0;
				left: 0;
				background-color:  #264476;
				padding:10%;
				overflow: hidden;
				border: 0px;
			}
			
			#bcE
			{	
				background-color:  #264476;
				color: white;
			}
			
			#bcE label
			{	
				font-size: 14px;
				color: white;
			}
			
			#titulo
			{
				font-size: 16px;
			}
			
			#txtBusca
			{
				display: inline-block;
				width: 220px;
				font-size: 18px;
				padding 5px;
			}
			
			#btnBusca
			{
				display: inline-block;
				background-color: #2da0e5;
				width: 22px;
				margin-top: 0px;
				margin-left: 0px;
				position: absolute;
			}
			
			#tipoBusca
			{
				display: inline-block;
				width: 240px;
				padding:2px;
			}
			#retornaBusca label
			{
				display: inline-block;
				color: white;
				font-size: 14px;
			}
			
			#resultadoBusca table
			{
				display: inline-block;
				width: 240px;
				background-color: #1f365e;
				margin-top: 5px;
				padding:5px;
			}
			
			#resultadoBusca table label
			{
				color: white;
				font-size: 12px;
			}
			
			#arquivoEVT
			{
				display: inline-block;
				width: 240px;
				height: 400px;
				position: absolute;
				top: 0;
				left: 0;
				background-color:  #264476;
				padding:10%;
				overflow: hidden;
				border: 0px;
			}
			
			#arquivoEVT table
			{
				width: 100%;
				color: white;
			}
			
			#arquivoEVT img
			{
				width: 100%;
			}
			
			#resultadoBusca textarea
			{
				width: 230px;
				height: 100px;				
				resize: none;
				padding: 5px;
				border: 0px;
				font-family: Century Gothic;
			}
			
			#dsEVT
			{
				width: 230px;
				height: 150px;				
				resize: none;
				padding: 5px;
				border: 0px;
				font-family: Century Gothic;
			}
		</style>
	</head>
	<body>
		<div id="mensagem" align="center">
			<label id="lbl_mensagem">Aqui vai uma mensagem gerada com innerHTML</label></br>
			<input type="button" value="OK" id="btn_OK" onclick="rech()">
			</form>
		</div>
		<div id="all">
			<img id="etLogo" src="imagens/logo/logoblue.png">
				<label id="saudacao">Eventos</label>
			<div id="eventoMenu">
				<div id="barraSuperior">
					<div id="mesAnterior" align="center">
						<img src="imagens/setaE.png">
					</div>
					<div id="mesAtual" align="center">
						<h1 id="mesNow"><?php echo $mes[0]." - ".$anoMenor; ?></h1>
					</div>
					<div id="mesProximo" align="center">
						<img src="imagens/setaD.png">
					</div>
				</div>
				<?php
					$query_Busca_Evento = "select * from tb_evento where dt_evento >= curdate() and cd_usuario = '$codigo' order by dt_evento";
					$result_Busca_Evento = mysql_query($query_Busca_Evento) or die(mysql_error());
					$linha_Busca_Evento = mysql_fetch_assoc($result_Busca_Evento);
					$totalLinha_Busca_Evento = mysql_num_rows($result_Busca_Evento);
					
					if ($mesMaior > $mesMenor && $anoMaior == $anoMenor)
					{
						$diferencaMes = $mesMaior - $mesMenor;
						
						for ($cont = 0; $cont <= $diferencaMes; $cont = $cont + 1)
						{
							$query_Busca_Evento = "select * from tb_evento where dt_evento >= curdate() and cd_usuario = '$codigo' order by dt_evento";
							$result_Busca_Evento = mysql_query($query_Busca_Evento) or die(mysql_error());
							$linha_Busca_Evento = mysql_fetch_assoc($result_Busca_Evento);
							$totalLinha_Busca_Evento = mysql_num_rows($result_Busca_Evento);
				?>
							<div id="eventos" class="mesAno<?php echo $class[$cont]; ?>" style="display: none;">
								<?php
									do
									{
										if ($class[$cont] == date("m", strtotime($linha_Busca_Evento['dt_evento'])).date("Y", strtotime($linha_Busca_Evento['dt_evento'])))
										{
								?>
											<?php
												$data = $linha_Busca_Evento['dt_evento'];
												$diaSemana = mysql_query("select dayofweek('$data') as 'Dia'");
												$diaSemana = mysql_fetch_assoc($diaSemana);
												$diaSemana = DiaDaSemana($diaSemana['Dia']);
											?>
											
											<div id="evtO" align="center" 
												onclick="nmEVT.innerHTML = '<?php echo $linha_Busca_Evento['nm_evento']; ?>';
														 dtEVT.innerHTML = '<?php echo date("d/m/Y", strtotime($linha_Busca_Evento['dt_evento'])); ?>';
														 dsEVT.innerHTML = InsereDetalhes('<?php echo str_replace(ConfereQuebra(), "&&quebra&&", $linha_Busca_Evento['ds_evento']); ?>');
														 txt_cdEvento.value = '<?php echo $linha_Busca_Evento['cd_evento']; ?>';
														 diaSemana.innerHTML = '<?php echo $diaSemana; ?>';
														 evtD.style.display = 'inline-block';
											">
												
												<label id="diaEvento"><?php echo date("d", strtotime($linha_Busca_Evento['dt_evento'])); ?></label><br>
												<label id="nmEvento"><?php echo $linha_Busca_Evento['nm_evento']; ?></label>
											</div>
								<?php
										}
									}
									while ($linha_Busca_Evento = mysql_fetch_assoc($result_Busca_Evento));
								?>
							</div>
				<?php
						}
					}
					else if ($anoMaior > $anoMenor)
					{
						for ($cont = 0; $cont <= sizeof($class) - 1; $cont = $cont + 1)
						{
							$query_Busca_Evento = "select * from tb_evento where dt_evento >= curdate() and cd_usuario = '$codigo' order by dt_evento";
							$result_Busca_Evento = mysql_query($query_Busca_Evento) or die(mysql_error());
							$linha_Busca_Evento = mysql_fetch_assoc($result_Busca_Evento);
							$totalLinha_Busca_Evento = mysql_num_rows($result_Busca_Evento);
				?>
							<div id="eventos" class="mesAno<?php echo $class[$cont]; ?>" style="display: none;">
								<?php
									do
									{
										if ($class[$cont] == date("m", strtotime($linha_Busca_Evento['dt_evento'])).date("Y", strtotime($linha_Busca_Evento['dt_evento'])))
										{
								?>
											<?php
												$data = $linha_Busca_Evento['dt_evento'];
												$diaSemana = mysql_query("select dayofweek('$data') as 'Dia'");
												$diaSemana = mysql_fetch_assoc($diaSemana);
												$diaSemana = DiaDaSemana($diaSemana['Dia']);
											?>
											
											<div id="evtO" align="center" 
												onclick="nmEVT.innerHTML = '<?php echo $linha_Busca_Evento['nm_evento']; ?>';
														 dtEVT.innerHTML = '<?php echo date("d/m/Y", strtotime($linha_Busca_Evento['dt_evento'])); ?>';
														 dsEVT.innerHTML = InsereDetalhes('<?php echo str_replace(ConfereQuebra(), "&&quebra&&", $linha_Busca_Evento['ds_evento']); ?>');
														 txt_cdEvento.value = '<?php echo $linha_Busca_Evento['cd_evento']; ?>';
														 diaSemana.innerHTML = '<?php echo $diaSemana; ?>';
														 evtD.style.display = 'inline-block';
											">
												<label id="diaEvento"><?php echo date("d", strtotime($linha_Busca_Evento['dt_evento'])); ?></label><br>
												<label id="nmEvento"><?php echo $linha_Busca_Evento['nm_evento']; ?></label>
											</div>
								<?php
										}
									}
									while ($linha_Busca_Evento = mysql_fetch_assoc($result_Busca_Evento));
								?>
							</div>
				<?php
						}
					}
					else
					{
				?>
						<div id="eventos" class="mesAno<?php echo $class[0]; ?>" style="display: none;">
							<?php
								$query_Busca_Evento = "select * from tb_evento where dt_evento >= curdate() and cd_usuario = '$codigo' order by dt_evento";
								$result_Busca_Evento = mysql_query($query_Busca_Evento) or die(mysql_error());
								$linha_Busca_Evento = mysql_fetch_assoc($result_Busca_Evento);
								$totalLinha_Busca_Evento = mysql_num_rows($result_Busca_Evento);
								
								$cont = 0;
								do
								{
									if ($class[$cont] == date("m", strtotime($linha_Busca_Evento['dt_evento'])).date("Y", strtotime($linha_Busca_Evento['dt_evento'])))
									{
							?>
										<?php
											$data = $linha_Busca_Evento['dt_evento'];
											$diaSemana = mysql_query("select dayofweek('$data') as 'Dia'");
											$diaSemana = mysql_fetch_assoc($diaSemana);
											$diaSemana = DiaDaSemana($diaSemana['Dia']);
										?>
										
										<div id="evtO" align="center" 
											onclick="nmEVT.innerHTML = '<?php echo $linha_Busca_Evento['nm_evento']; ?>';
													 dtEVT.innerHTML = '<?php echo date("d/m/Y", strtotime($linha_Busca_Evento['dt_evento'])); ?>';
													 dsEVT.innerHTML = InsereDetalhes('<?php echo str_replace(ConfereQuebra(), "&&quebra&&", $linha_Busca_Evento['ds_evento']); ?>');
													 txt_cdEvento.value = '<?php echo $linha_Busca_Evento['cd_evento']; ?>';
													 diaSemana.innerHTML = '<?php echo $diaSemana; ?>';
													 evtD.style.display = 'inline-block';
										">
											<label id="diaEvento"><?php echo date("d", strtotime($linha_Busca_Evento['dt_evento'])); ?></label><br>
											<label id="nmEvento"><?php echo $linha_Busca_Evento['nm_evento']; ?></label>
										</div>
							<?php
									}
								}
								while ($linha_Busca_Evento = mysql_fetch_assoc($result_Busca_Evento));
							?>
						</div>
				<?php
					}
				?>
				<div id="barraInferior">
					<table>
						<tr>
							<td>
								<label id="lblLegenda"></label>
							</td>
							<td>
								<img src="imagens/bloco.png" >
							</td>
							<td>
								<img id="btnCalendario" src="imagens/calendario.png">
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div id="evtD" align="center">
				<img src="imagens/calendario.png"><br>
				<label id="nmEVT">Dia do Gold</label>
				<label id="dtEVT">01/11/2015</label>
				<label id="diaSemana">Segunda-feira</label>
				<label id="ds">Descrição</label><br><br>
				<textarea rows="10" cols="40" id="dsEVT" disabled >Hoje é dia de programar!</textarea><br>
				<input type="hidden" id="txt_cdEvento">
				<div id="down">
					<table>
						<tr>
							<td>
								<img id="btnVoltar" src="imagens/voltar.png">
							</td>
							<td>
								<img src="imagens/fechar2.png" onclick="window.location.href = 'php/ExcluirEvento.php?cdEvento=' + txt_cdEvento.value;">
							</td>
							<td>
								<img id="btnEditar" src="imagens/bloco.png" onclick="cadUpdate.src = 'agenda/agenda_UPDATE.php?cdEvento=' + txt_cdEvento.value; cadUpdate.style.display = 'inline-block'; evtD.style.display = 'none';">
							</td>
						</tr>
					</table>
				</div>
			</div>
			
			
			<div id="esquerdaa">
				<iframe src="agenda/agenda_ET.php" id="cadNew"></iframe>
				<iframe src="" id="cadUpdate"></iframe>
				<div id="buscarEvt">
						<div id="bcE">
							<h1>Buscar Evento</h1><br>
							<form id="Frm_Dados" method="GET" onsubmit="Validar(this); return false;">
								<label>Buscar por</label></br>
									<select id="tipoBusca" name="tipo">
										<option value="0" <?php if ($pesquisou == 0) {echo "selected";}?>>Selecione...</option>
										<option value="1" <?php if ($pesquisou == 1) {if ($_GET['tipo'] == 1) {echo "selected";}}?>>Nome</option>
										<option value="2" <?php if ($pesquisou == 1) {if ($_GET['tipo'] == 2) {echo "selected";}}?>>Data</option>
										<option value="3" <?php if ($pesquisou == 1) {if ($_GET['tipo'] == 3) {echo "selected";}}?>>Descrição</option>
									</select><br><br>
								<input id="txtBusca" type="text" name="valorBusca" maxLength="500"><input type="image" id="btnBusca" value="Buscar" name="buscar" src="imagens/buscarevt.png"><br>
								<input type="hidden" id="txt_slider" name="slider" value="<?php echo $slider; ?>">
							</form>
						</div>
						<div id="retornaBusca">
						<br>
							<label>Resultados da busca</label>
							<label id="dadosBusca">(<?php if($totalLinha_Busca == 1) {echo "$totalLinha_Busca Evento";} else {echo "$totalLinha_Busca Eventos";} ?>)</label><br>
							<!-- ESTA PARTE AQUI-->
							<!-- 31 chars -->
							<?php
								do
								{
							?>
									<div id="resultadoBusca" <?php if($totalLinha_Busca == 0) {echo 'style="display: none;"';} ?>>
										<table>
											<tr>
												<td>
													<label id="nmEventoBusca"><?php echo $linha_Busca['nm_evento']; ?></label>
												<td>
											</tr>
											<tr>
												<td>
													<label id="dtEventoBusca"><?php echo date("d/m/Y", strtotime($linha_Busca['dt_evento'])); ?></label>
												<td>
											</tr>
											<tr>
												<td>
													<textarea rows="10" cols="40" id="dsEventoBusca" disabled><?php echo $linha_Busca['ds_evento']; ?></textarea>
												<td>
											</tr>
										</table>
									</div>
							<?php
								}
								while ($linha_Busca = mysql_fetch_assoc($result_Busca));
							?>
							<!--NAO QUEBRE O MEU LAYOUT!-->
						</div>
				</div>
				<div id="arquivoEVT">
					<table>
						<tr>
							<td colspan="2" align="center">
								<label>Gerencie seus eventos</label>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
							<br><br>
								<label>Escolha abaixo o formato que deseja gerar sua lista de eventos futuros</label>
							</td>
						</tr>
						<tr>
							<td align="center">
								<img src="imagens/extensoes/txt.png"><br>
								<label><a href="php/GerarEventosTXT.php" title='Gerar um arquivo ".txt" dos seus eventos.' style="color: white; text-decoration: none;">Salvar</label>
							</td>
							<td align="center"> 
								<img src="imagens/extensoes/pdf.png"><br>
								<label>Salvar</label>
							</td>
						</tr>
					</table>
				</div>
				<div id="giu">
					<table align="center">
						<tr align="center">
							<td  id="btnArquivo">
								<img src="imagens/docs.png">
							</td>
							<td id="btnCriar">
								<img  src="imagens/calendario.png">
							</td>
							<td id="btnBuscarEVT">
								<img  src="imagens/buscarevt.png"><br>
							</td>
							
						</tr>
					</table>
				</div>
				
			</div>
		</div>			
		<div id="tp">
		</div>
		
		
	</body>
	
	<script>	
	
		var campoData = document.querySelector("#txtBusca");
		
	
	window.onload = function()
		{
			sliderValue = parseInt(txt_slider.value);
			MesAno = document.querySelector(".mesAno" + classes[0]);
			MesAno.style.display = "inline-block";
			camposCorretos = new Array(2);
			troca();
			<?php
				if ($pesquisou == 1)
				{
					echo "btnBuscarEVT.click()";
				}
			?>
		}
		
		
		
		btnVoltar.onclick = function()
		{
			tp.style.display = "none";
			evtD.style.display = "none";
			cadUpdate.style.display = "none";
		}
		
		
		
		mesAnterior.onclick = function()
		{
			if(sliderValue == 0)
			{
				sliderValue = classes.length - 1;
			}
			else
			{
				sliderValue--;
			}
			
			txt_slider.value = sliderValue;
			
			troca();
		}
		
		mesProximo.onclick = function()
		{
			if(sliderValue == classes.length - 1)
			{
				sliderValue = 0;
			}
			else
			{
				sliderValue++;
			}
			
			txt_slider.value = sliderValue;
			
			troca();
		}
		
		function troca()
		{
			cadUpdate.style.display = "none";
			aux = classes[sliderValue];
			aux = aux.substring(2,aux.length);
			
			mesNow.innerHTML = meses[sliderValue] + " - " + aux;
			
			if (sliderValue != 0)
			{
				MesAno = document.querySelector(".mesAno" + classes[sliderValue - 1]);
				MesAno.style.display = "none";
				
				if (classes[sliderValue + 1] != undefined)
				{
					MesAno = document.querySelector(".mesAno" + classes[sliderValue + 1]);
					MesAno.style.display = "none";
				}
				else
				{
					MesAno = document.querySelector(".mesAno" + classes[0]);
					MesAno.style.display = "none";
				}
				
				MesAno = document.querySelector(".mesAno" + classes[sliderValue]);
				MesAno.style.display = "inline-block";
			}
			else
			{
				if (classes.length > 1)
				{
					MesAno = document.querySelector(".mesAno" + classes[classes.length - 1]);
					MesAno.style.display = "none";
					
					MesAno = document.querySelector(".mesAno" + classes[sliderValue + 1]);
					MesAno.style.display = "none";
					
					MesAno = document.querySelector(".mesAno" + classes[sliderValue]);
					MesAno.style.display = "inline-block";
				}
			}
			
			/*if (sliderValue != 0)
			{
				MesAno = document.querySelector(".mesAno" + classes[sliderValue - 1]);
				MesAno.style.display = "none";
				
				MesAno = document.querySelector(".mesAno" + classes[sliderValue]);
				MesAno.style.display = "inline-block";
			}
			else
			{
				MesAno = document.querySelector(".mesAno" + classes[classes.length - 1]);
				MesAno.style.display = "none";
				
				MesAno = document.querySelector(".mesAno" + classes[sliderValue]);
				MesAno.style.display = "inline-block";
			}*/
			
			
		}
		
		btnCriar.onmouseover = function()
		{
			lblLegenda.innerHTML = "Novo Evento";
		}
		
		btnCriar.onclick = function()
		{
			cadNew.style.display = "inline-block";
			arquivoEVT.style.display = "none";
			buscarEvt.style.display= "none";
			cadUpdate.style.display = "none";
			
		}
		
		btnBuscarEVT.onclick = function()
		{
			cadNew.style.display = "none";
			arquivoEVT.style.display = "none";
			buscarEvt.style.display= "inline-block";
			cadUpdate.style.display = "none";
		}
		
		btnArquivo.onclick = function()
		{
			cadNew.style.display = "none";
			arquivoEVT.style.display = "inline-block";
			buscarEvt.style.display= "none";
			cadUpdate.style.display = "none";
		}
		
		btnCriar.onmouseout = function()
		{
			lblLegenda.innerHTML = "";
		}
		
		/*lblCriar.onclick = function()
		{
			btnCriar.click();
		}*/
		
		function rech()
		{
			parent.perfil.src = parent.perfil.src;
			parent.inicio.src = parent.inicio.src;
			parent.eventos.src = "Eventos.php";
		}
		
		function MascaraData(valorCampo)
		{
			var auxtroca,auxvetor;
			
			if (valorCampo.length == 3 && valorCampo.charAt(2) != '/')
			{
				auxvetor = valorCampo.split("");
				aux = auxvetor[2];
				auxvetor[2] = "/";
				auxvetor[3] = aux;
				
				valorCampo = "";	
				for (cont = 0; cont <= auxvetor.length - 1; cont = cont + 1)
				{
					valorCampo = valorCampo + auxvetor[cont];
				}
			}
			
			if (valorCampo.length == 6 && valorCampo.charAt(5) != '/')
			{
				auxvetor = valorCampo.split("");
				aux = auxvetor[5];
				auxvetor[5] = "/";
				auxvetor[6] = aux;
				
				valorCampo = "";	
				for (cont = 0; cont <= auxvetor.length - 1; cont = cont + 1)
				{
					valorCampo = valorCampo + auxvetor[cont];
				}
			}
			
			if (valorCampo.length == 8 && valorCampo.indexOf('/') == -1)
			{
				auxvetor = "##/##/####";
				auxvetor = auxvetor.split("");
				aux = valorCampo.split("");
				
				auxvetor[0] = aux[0];
				auxvetor[1] = aux[1];
				
				auxvetor[3] = aux[2];
				auxvetor[4] = aux[3];
				
				auxvetor[6] = aux[4];
				auxvetor[7] = aux[5];
				auxvetor[8] = aux[6];
				auxvetor[9] = aux[7];
				
				valorCampo = "";	
				for (cont = 0; cont <= auxvetor.length - 1; cont = cont + 1)
				{
					valorCampo = valorCampo + auxvetor[cont];
				}
			}
			
			return valorCampo;
		}
		
		function VerificarData()
		{
			aux = campoData.value;
			aux =  aux.replace('/', "");
			aux =  aux.replace('/', "");
			
			//Ignora essa parte
			if (campoData.value.indexOf("-") == 2 || campoData.value.indexOf("-") == 4)
			{
				var separa = campoData.value.split("-");
				var ano = separa[0];
					ano = parseInt(ano);
				var mes = separa[1];
					mes = parseInt(mes);
				var dia = separa[2];
					dia = parseInt(dia);
				var bi4 = ano;
					bi4 = bi4%4;
					bi4 = parseInt(bi4);
				var bi400 = ano;
					bi400 = bi400%400;
					bi400 = parseInt(bi400);
				var bi100 = ano;
					bi100 = bi100%100;
					bi100 = parseInt(bi100);
				if ((dia >= 1 && dia <= 31) && (mes >= 1 && mes <= 12))
				{
					if ((bi4 == 0 || bi400 == 0) && bi100 != 0)
					{
						if ((mes == 2 && dia <= 29) || (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 10 || mes == 12 && dia <= 31) || (mes == 4 || mes == 6 || mes == 8 || mes == 9 || mes == 11 && dia <= 30))
						{
							campoData.style.border = "2px solid green";
							//campo[7] = 1;
						}
						else
						{
							campoData.style.border = "2px solid red";
							//campo[7] = 0;
						}
					}
					else
					{
						if ((mes == 2 && dia <= 28) || (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 10 || mes == 12 && dia <= 31) || (mes == 4 || mes == 6 || mes == 8 || mes == 9 || mes == 11 && dia <= 30))
						{
							campoData.style.border = "2px solid green";
							//campo[7] = 1;
						}
						else
						{
							campoData.style.border = "2px solid red";
							//campo[7] = 0;
						}
					}
				}
				else
				{
					campoData.style.border = "2px solid red";
					//campo[7] = 0;
				}
			}
			else //Começa daqui
			{
				if (aux.indexOf("-") == -1 && aux.length == 8)
				{
					var separa = aux;
						separa = separa.split("",8);
					var dia = separa[0] + separa[1];
						dia = parseInt(dia);
					var mes = separa[2] + separa[3];
						mes = parseInt(mes);
					var ano = separa[4] + separa[5] + separa[6] + separa[7];
						ano = parseInt(ano);
					var bi4 = ano;
						bi4 = bi4%4;
						bi4 = parseInt(bi4);
					var bi400 = ano;
						bi400 = bi400%400;
						bi400 = parseInt(bi400);
					var bi100 = ano;
						bi100 = bi100%100;
						bi100 = parseInt(bi100);
					
					var hoje = new Date();
					var anoAtual = hoje.getFullYear();
					var mesAtual = hoje.getMonth() + 1;
					var diaAtual = hoje.getDate();
					var idade;
					
					if ((mesAtual >= mes) && (diaAtual >= dia))
					{
						idade = anoAtual - ano;
					}
					else
					{
						idade = anoAtual - ano - 1;
					}
					
					if ((dia >= 1 && dia <= 31) && (mes >= 1 && mes <= 12))
					{
						if ((bi4 == 0 || bi400 == 0) && bi100 != 0)
						{
							if ((mes == 2 && dia <= 29) || (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 10 || mes == 12 && dia <= 31) || (mes == 4 || mes == 6 || mes == 8 || mes == 9 || mes == 11 && dia <= 30)) 
							{
								campoData.style.border = "";
								camposCorretos[1] = 1;
							}
							else
							{
								campoData.style.border = "1px solid red";
								camposCorretos[1] = 0;
							}
						}
						else
						{
							if ((mes == 2 && dia <= 28) || (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 10 || mes == 12 && dia <= 31) || (mes == 4 || mes == 6 || mes == 8 || mes == 9 || mes == 11 && dia <= 30))
							{
								campoData.style.border = "";
								camposCorretos[1] = 1;
							}
							else
							{
								campoData.style.border = "1px solid red";
								camposCorretos[1] = 0;
							}
						}
					}
					else	
					{
						campoData.style.border = "1px solid red";
						camposCorretos[1] = 0;
					}
				}
				else
				{
					campoData.style.border = "1px solid red";
					camposCorretos[1] = 0;
				}
			}
		}
		
		function VerificarTipo()
		{
			if (tipoBusca.value != 0)
			{
				tipoBusca.style.border = "";
				camposCorretos[0] = 1;
			}
			else
			{
				tipoBusca.style.border = "1px solid red";
				camposCorretos[0] = 0;
			}
		}
		
		campoData.onkeypress = function(e,args)
		{
			if (tipoBusca.value == 2)
			{
				passou = 0;
				
				if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = "0123456789/";      // criando a lista de teclas permitidas
				var chr= String.fromCharCode(evt);      // pegando a tecla digitada
				
				if (valid_chars.indexOf(chr)>-1) // se a tecla estiver na lista de permissão permite-a
				{
					if (chr == '/' && campoData.value.length == 2)
					{
						passou = 1;
					}
					
					if (chr == '/' && campoData.value.length == 5)
					{
						passou = 1;
					}
					
					if (chr != '/')
					{
						passou = 1;
					}
				}
				
				// para permitir teclas como <BACKSPACE> adicionamos uma permissão para
				// códigos de tecla menores que 09 por exemplo 
				
				if (valid_chars.indexOf(chr) == -1 && evt < 9)
				{
					passou = 1;
				}
				
				/*var valorCampo = campoData.value;
				
				for (cont = 0; cont <= valorCampo.length - 1; cont = cont + 1)
				{
					if (valorCampo.charAt(cont) == '/' && (cont == 2 || cont == 5))
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
					}
				}*/
				
				if (passou == 1)
				{
					campoData.value = MascaraData(campoData.value);
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		
		/*campoData.onkeyup = function()
		{
			if (tipoBusca.value == 2)
			{
				var valorCampo = campoData.value;
				var valorFiltrado = "";
				var quant = 0;
				
				aux = MascaraData(valorCampo);
				valorCampo = aux
				
				campoData.value = valorCampo;
			}
		}*/
		
		function Validar(frm)
		{
			VerificarTipo();
			
			if (tipoBusca.value == 2)
			{
				VerificarData();
			}
			else
			{
				if (txtBusca.value != "")
				{
					txtBusca.style.border = "";
					camposCorretos[1] = 1;
				}
				else
				{
					txtBusca.style.border = "1px solid red";
					camposCorretos[1] = 0;
				}
			}
			var aux = 0;
			for (cont = 0; cont <= camposCorretos.length - 1; cont = cont + 1)
			{
				aux = aux + parseInt(camposCorretos[cont]);
			}
			
			if (aux != camposCorretos.length)
			{
				return false;
			}
			else
			{
				var frm = document.querySelector("#Frm_Dados");
				frm.submit();
			}
		}
		
		tipoBusca.onchange = function()
		{
			if (tipoBusca.value == 2)
			{
				txtBusca.maxLength = "10";
				txtBusca.value = "";
			}
			else
			{
				txtBusca.maxLength = "500";
			}
		}
		var aux;
		function InsereDetalhes(texto)
		{
			aux = texto.split("&&quebra&&");
			dsEVT.value = "";
			
			for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
			{
				dsEVT.value = dsEVT.value + aux[cont] + "\n";
			}
		}
		
		<?php				
			if (isset($_GET['cdevento']))
			{
				$cdEvento = $_GET['cdevento'];
				$query_Busca_Evento2 = "select * from tb_evento where cd_evento = '$cdEvento'";
				$result_Busca_Evento2 = mysql_query($query_Busca_Evento2) or die(mysql_error());
				$linha_Busca_Evento2 = mysql_fetch_assoc($result_Busca_Evento2);
				
				$data2 = $linha_Busca_Evento2['dt_evento'];
				$diaSemana2 = mysql_query("select dayofweek('$data2') as 'Dia'");
				$diaSemana2 = mysql_fetch_assoc($diaSemana2);
				$diaSemana2 = DiaDaSemana($diaSemana2['Dia']);
				
				$nmEvento = $linha_Busca_Evento2['nm_evento'];
				$dtEvento = date("d/m/Y", strtotime($linha_Busca_Evento2['dt_evento']));
				$dsEvento = str_replace(ConfereQuebra(), "&&quebra&&", $linha_Busca_Evento2['ds_evento']);
				
													 
				echo "evtD.style.display = 'inline-block';";
				echo "nmEVT.innerHTML = '$nmEvento';";
				echo "dtEVT.innerHTML = '$dtEvento';";
				echo "dsEVT.innerHTML = InsereDetalhes('$dsEvento');";
				echo "diaSemana.innerHTML = '$diaSemana2';";
				echo "txt_cdEvento.value = '$cdEvento';";
				
			}
		?>
	</script>
</html>



<?php
	mysql_close($conexao);
?>