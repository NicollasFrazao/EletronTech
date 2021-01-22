<?php
	session_start();
	
	include "php/Conexao.php";
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	
	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );

	date_default_timezone_set( 'America/Sao_Paulo' );
	
	if((!isset ($_SESSION['EletronTech']['login']) == true) and (!isset ($_SESSION['EletronTech']['senha']) == true)) 
	{ 
		unset($_SESSION['EletronTech']); 
		header('location:../Login.php'); 
	} 
	
	$logado = $_SESSION['EletronTech']['login'];
	$codigo = $_SESSION['EletronTech']['codigo'];
	
	$query_Busca = "select tb_usuario.nm_usuario as 'Usuário', tb_pacote.nm_pacote as 'Pacote', usuario_pacote.dt_inicio as 'Data de Início', usuario_pacote.dt_termino as 'Data de Término', usuario_pacote.qt_dias as 'Dias Restantes', tb_pacote.im_pacote as 'Imagem', tb_pacote.ds_pacote as 'Descrição', tb_pacote.cd_pacote as 'codigoPacote', tb_pacote.ic_custom as 'icCustom'
					  from tb_usuario inner join usuario_pacote
						on tb_usuario.cd_usuario = usuario_pacote.cd_usuario
						  inner join tb_pacote
							on usuario_pacote.cd_pacote = tb_pacote.cd_pacote
								where tb_usuario.cd_usuario = '$codigo'";
								
	$result_Busca = mysql_query($query_Busca) or die(mysql_error());
	$linha_Busca = mysql_fetch_assoc($result_Busca);
	$totalLinha_Busca = mysql_num_rows($result_Busca);
	
	if ($linha_Busca['icCustom'] == 0) 
	{
		$codigoPacote = $linha_Busca['codigoPacote'];
	}
	else
	{
		$codigoPacote = 8;
	}
	
	$query_Busca_Outros = "select * from tb_pacote where cd_pacote != 1 and ic_custom = 0 order by nm_pacote";
			
	$result_Busca_Outros = mysql_query($query_Busca_Outros) or die(mysql_error());
	$linha_Busca_Outros = mysql_fetch_assoc($result_Busca_Outros);
	$totalLinha_Busca_Outros = mysql_num_rows($result_Busca_Outros);
?>

<html lang="pt-br">
<!doctype html>
	
	<head>
		<meta charset="utf-8">
		<title>Eletron Tech Shop - Página Inicial</title>
		<link rel="stylesheet" type="text/css" href="css/estilo.css">
		<link rel="shortcut icon" href="imagens/logo/logo.ico" />
	</head>
	
	<body>
			<div id="all">
			<div id="logotipo">
				<img src="imagens/logo2.png">
			</div>
			<div id="menu">
					<ul>
						<li><a href="../ET.php">Retornar ao Sistema</a></li>
						<li><a href="" id="ss">Login</a></li>	
					</ul>
			</div>
			
			<div id="pacote">
				<div id="lbl_pacote">
					<label>Pacote</label>
				</div>
				
				<div id="lbl_tipo">
					<label>Measure</label>
				</div>	
			</div>

			<div id="tdv">
				<div id="faixa">
					<div id="esquerdad">
						<input type="image" src="imagens/setaE.png" id="esquerda">
					</div>
					<div id="direitad">
						<input type="image" src="imagens/setaD.png" id="direita">
					</div>
				</div>
					

				<div id="img">
					
					<img src="" id="img_pacote">
					<a id="btn_fei">Ver mais!</a>
				</div>

				<div id="descricao">
					<label id="ds_pacote"></label><br>
					
				</div>
			</div>
		</div>
		<div id="slider">
			<img src="" id="sliderImage">
		</div>
		<div id="cobre">
		
		</div>
		
		<div id="cobre2">
			
		</div>
		
		<iframe id="FEI" src=""></iframe>
		<input type="button" id="btn_feiCompra" value="Comprar">
		<input type="hidden" id="saudacao" value="<?php echo $logado; ?>">
		<!--<script type="text/javascript" src="script/script.js"></script>-->
	</body>
	<script>
	window.onload = function()
		{
			sliderValue = 0;
			//nmPacote = new Array ("Tester", "Advanced", "Golden", "Draw", "Custom", "Light", "Measure");
			//colors = new Array ("green", "red", "gold", "blue", "gray", "lightgray", "orange");
			nmPacote = new Array;
			imPacote = new Array;
			imFundo = new Array;
			colors = new Array;
			dsPacote = new Array;
			icPossui = new Array;
			cdPacote = new Array;
			
			<?php
				do
				{
			?>
					nmPacote.push("<?php $aux = explode(" ",$linha_Busca_Outros['nm_pacote']); echo $aux[2]; ?>");
					imPacote.push("<?php echo $linha_Busca_Outros['im_pacote']; ?>");
					imFundo.push("<?php echo $linha_Busca_Outros['im_fundo']; ?>");
					colors.push("<?php echo $linha_Busca_Outros['nm_cor']; ?>");
					dsPacote.push("<?php echo $linha_Busca_Outros['ds_pacote']; ?>");
					cdPacote.push("<?php echo $linha_Busca_Outros['cd_pacote']; ?>");
					<?php
						if ($linha_Busca_Outros['cd_pacote'] == $codigoPacote)
						{
					?>
							icPossui.push(1);
					<?php
						}
						else
						{
					?>
							icPossui.push(0);
					<?php
						}
					?>
			<?php
				}
				while ($linha_Busca_Outros = mysql_fetch_assoc($result_Busca_Outros));
			?>
			
			trocaPacote();
			timer();
			sonoCheOre();
		}
		
		esquerda.onclick = function()
		{
			if(sliderValue == 0)
			{
				sliderValue = nmPacote.length - 1;
			}
			else
			{
				sliderValue--;
			}
			trocaPacote();
		}
		
		direita.onclick = function()
		{
			if(sliderValue == nmPacote.length - 1)
			{
				sliderValue = 0;
			}
			else
			{
				sliderValue++;
			}
			trocaPacote();
		}
		
		function trocaPacote()
		{
			lbl_tipo.innerHTML = nmPacote[sliderValue];
			img_pacote.src=imPacote[sliderValue];
			cobre.style.backgroundColor=colors[sliderValue];
			sliderImage.src = imFundo[sliderValue];
			ds_pacote.innerHTML = dsPacote[sliderValue];
			
			/*if (icPossui[sliderValue] == 1)
			{
				lbl_comprar_estender.innerHTML = "Estender";
			}
			else
			{
				lbl_comprar_estender.innerHTML = "Comprar";
			}*/
			
			if (cdPacote[sliderValue] == 8)
			{
				btn_fei.style.display = "inline-block";
				btn_fei.innerHTML = "Comprar Pacote";
			}
			else
			{
				btn_fei.style.display = "inline-block";
				btn_fei.innerHTML = "Ver mais!";
			}
		}
		
		//Atalhos do sistema
		document.onkeydown = function(e,args)
		{
			if (e.keyCode == 37)
			{
				esquerda.click();
			}
			else if (e.keyCode == 39)
			{
				direita.click();
			}
			else{}
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
			//data.innerHTML = dataHoje;
			//hora.innerHTML = horario;
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
		
		btn_fei.onclick = function()
		{
			if (cdPacote[sliderValue] != 8)
			{
				cobre2.style.display = "inline-block";
				FEI.src = "FerramentaPacote.php?codigoPacote=" + cdPacote[sliderValue] + "&corPacote=" + colors[sliderValue].replace('#', "aux");
				FEI.style.display="inline-block";
			}
			else
			{
				confirmarCompra(cdPacote[sliderValue]);
			}
		}
		
		function fecharFei()
		{
			cobre2.style.display = "none";
			FEI.style.display="none";
			FEI.src = "";
		}
		
		function confirmarCompra(codigoPacote)
		{
			window.open("Comprar.php?codigoPacote=" + codigoPacote,"_parent");
		}
	</script>
	
</html>

<?php
	mysql_close($conexao);
?>