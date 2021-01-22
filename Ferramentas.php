<?php
	include "php/Conexao.php";
	
	session_start();
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	
	$codigo = $_SESSION['EletronTech']['codigo'];
	
	$query_Busca_Ferramenta = "select tb_ferramenta.cd_ferramenta, nm_ferramenta, nm_pacote, nm_usuario, nm_url_imagem, ds_ferramenta, nm_url_ferramenta
								  from tb_ferramenta inner join pacote_ferramenta
									on tb_ferramenta.cd_ferramenta = pacote_ferramenta.cd_ferramenta
									  inner join tb_pacote
										on pacote_ferramenta.cd_pacote = tb_pacote.cd_pacote
										  inner join usuario_pacote
											on tb_pacote.cd_pacote = usuario_pacote.cd_pacote
											  inner join tb_usuario
												on usuario_pacote.cd_usuario = tb_usuario.cd_usuario
												   where tb_usuario.cd_usuario = '$codigo' order by nm_ferramenta";
			
	$result_Busca_Ferramenta = mysql_query($query_Busca_Ferramenta) or die(mysql_error());
	$linha_Busca_Ferramenta = mysql_fetch_assoc($result_Busca_Ferramenta);
	$totalLinha_Busca_Ferramenta = mysql_num_rows($result_Busca_Ferramenta);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="shortcut icon" href="imagens/logo/logo.ico" />
		<title>Ferramentas</title>
	</head>
	<style>
		*
		{
			margin: 0;
			padding: 0;
			outline:none;
			font-family: Century Gothic;
			overflow: hidden;
		}
		
		body
		{
			font-family: Century Gothic;
		}
		
		::-webkit-scrollbar
		{
			height: 12px;
			width: 12px;
			background: white;
			
		}
		
		::-webkit-scrollbar-thumb
		{
			background: #000;
			-webkit-box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.75);
		}

		::-webkit-scrollbar-corner
		{
			background: #000;
		}
		
		#all
		{
			display: inline-block;
			position: absolute;
			width: 1000px;
			height: 640px;
			margin-left: -500px;
			margin-top: -270px;
			left: 50%;
			top: 50%;
			background-color: transparent;
		}
		
		#topo
		{
			display: inline-block;
			width: 100%;
			height: 10%;
			background-color: transparent;
		}
		
		#topo label
		{
			display: inline-block;
			font-size: 26px;
			margin-left: 5%;
			margin-top:2%;
		}
		
		#centro
		{
			display: inline-block;
			width: 90%;
			height:95%;
			margin-left: 20px;
			background-color: transparent;
		}
		
		#esq
		{
			display: inline-block;
			width: 50%;
			height: 100%;
			background-color: transparent;
			overflow: auto;
			
		}
		
		#dir
		{
			display: inline-block;
			width: 500px;
			height: 445px;
			background-color: #356eae;
			position: absolute;
			margin-top:10px;
		}
		
		#destraTopo
		{
			display: inline-block;
			background-color: transparent;
			width: 100%;
			height: 20%;
			color: white;
			vertical-align: middle;
		}
		
		
		#destraMezzo
		{
			display: inline0block;
			background-color: transparent;
			height: 50%;
			margin-top:2%;
			margin-bottom:2%;
			color: white;
		}
		
		#destraGiu
		{
			display: inline0block;
			background-color: black;
			width: 100%;
			height: 25%;
		}
		
		#nomeFEI
		{
			display: inline-block;
			width: 90%;
			margin-left: 5%;
			margin-top:5%;
			font-size: 26px;
		}
		
		#descFEI
		{
			display: inline-block;
			width: 90%;
			margin-left: 5%;
			font-size: 18px;
		}
		
		#relogioData table
		{
			width: 100%;
		}
		
		#relogioData #hora
		{
			display: inline-block;
			width: 100%;
			color: white;
			font-size: 40px;
			margin-top:5%;
		}
		
		#relogioData #data
		{
			display: inline-block;
			width: 100%;
			font-size: 20px;
			color: white;
		}
		
		#FEI
		{
			display: inline-block;
			width: 20%;
			background-color: #292929;
			margin: 2%;
		}
		
		#FEI input
		{
			display: inline-block;
			width: 100%;
			
			box-shadow: 0px 0px 5px 0px gray;
		}
		
		#FEI input:hover
		{
			background-color: #0ca3ff;
		}
		
		#FEI:hover
		{
			background-color: #00e4f6;
		}
		
		#openFEI
		{
			display: none;
			width: 73%;
			height: 80%;
			position: absolute;
			margin-left:12%;
			margin-top:5%;
			border: 0px;
			z-index: 9999;
		}
		
		#es
		{
			display: none;
			width: 100%;
			height: 100%;
			background-color: black;
			opacity: 0.8;
			position: fixed;
		}
		
		#voltar
		{
			display: inline-block;
			width: 5%;
			position: aboslute;
			margin-left: 80%;
			outline: none;
		}
		
		#voltar:hover
		{
			background-color: #00428b;
		}
		
		#etLogo
		{
			display: inline-block;
			margin-left: 20px;
			width: 50px;
			margin-bottom: 25px;
		}
		
		#saudacao
		{
			display: inline-block;
			font-size: 36px;
			color: #167ff6;
			margin-left: 25px;
			margin-bottom: 30px;
		}
	</style>
	<body>
		<div id="all">
				<img id="etLogo" src="imagens/logo/logoblue.png">
				<label id="saudacao">Ferramentas</label>
			<div id="centro">
				<div id="esq">
					<!--É ESSE AQUI QUE TEM QUE CRIAR-->
					<?php
						do
						{
					?>
							<div id="FEI" <?php if($linha_Busca_Ferramenta['nm_ferramenta'] == "") {echo "style='display: none;'";} ?>>
								<input type="image" src="<?php echo $linha_Busca_Ferramenta['nm_url_imagem']; ?>" onclick="openFEI.src = '<?php echo $linha_Busca_Ferramenta['nm_url_ferramenta']; ?>?codigoFerramenta=<?php echo $linha_Busca_Ferramenta['cd_ferramenta']; ?>'; abreFEI();" onmouseover="nomeFEI.innerHTML = '<?php echo $linha_Busca_Ferramenta['nm_ferramenta']; ?>'; descFEI.innerHTML = '<?php echo $linha_Busca_Ferramenta['ds_ferramenta']; ?>';" onmouseout="nomeFEI.innerHTML = 'Selecione uma ferramenta'; descFEI.innerHTML = '';">
							</div>
					<?php
						}
						while ($linha_Busca_Ferramenta = mysql_fetch_assoc($result_Busca_Ferramenta));
					?>
					<!--OK?-->
				</div>
				<div id="dir">
					<div id="destraTopo" align="center">
						<label id="nomeFEI">Selecione uma ferramenta</label>
					</div>
					<div id="destraMezzo" align="justify">
						<label id="descFEI"></label>
					</div>
					
				</div>
			</div>
		
		</div>
		<div id="es">
			<input type="image" src="imagens/voltar.png" id="voltar" onclick="fecharFEI()">
		</div>
		<!-- A FEI que vai abrir-->
		<iframe id="openFEI" src=""></iframe>
		
		
	</body>
	<script>
		window.onload =function()
		{
			//timer();
		}
		
		/*function timer()
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
			data.innerHTML = dataHoje;
			hora.innerHTML = horario;
			setTimeout("timer()",1000);
		}*/
		
		function abreFEI()
		{
			parent.inicio.src = "inicio.php";
			es.style.display="inline-block";
			openFEI.style.display="inline-block";
		}
		
		function fecharFEI()
		{
			openFEI.style.display="none";
			es.style.display="none";
			//Eu coloquei esse comando aqui para ele zerar a ferramenta por segurança...
			openFEI.src="";
		}
		
		<?php
			if (isset($_GET['codigoFerramenta']))
			{
				$codigoFerramenta = $_GET['codigoFerramenta'];
				$urlFerramenta = $_GET['urlFerramenta'];
				$urlFerramenta = str_replace("barra", "/", $urlFerramenta);
				$urlFerramenta = str_replace("ponto", ".", $urlFerramenta);
				
				
				echo "openFEI.src = '".$urlFerramenta."?codigoFerramenta=".$codigoFerramenta."';";
				
				echo "abreFEI();";
			}
		?>
		
		document.onkeydown = KeyCheck;
		function KeyCheck()
		{
		   var KeyID = event.keyCode;
		   switch(KeyID)
		   {
			  case 38:
				//parent.ativarMenu();
				parent.licencaOPT.click();
				parent.licenca.focus();
			  break; 
			  case 40:
				//parent.ativarMenu();
				parent.arquivosOPT.click();
				parent.arquivos.focus();
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