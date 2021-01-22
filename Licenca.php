<?php
	include "php/Conexao.php";
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	
	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );

	date_default_timezone_set( 'America/Sao_Paulo' );
	
	session_start();
	$codigo = $_SESSION['EletronTech']['codigo'];
	
	$query_Busca = "select tb_usuario.nm_usuario as 'Usuário', tb_pacote.nm_pacote as 'Pacote', usuario_pacote.dt_inicio as 'Data de Início', usuario_pacote.dt_termino as 'Data de Término', usuario_pacote.qt_dias as 'Dias Restantes', tb_pacote.im_pacote as 'Imagem', tb_pacote.ds_pacote as 'Descrição', tb_pacote.cd_pacote as 'codigoPacote'
					  from tb_usuario inner join usuario_pacote
						on tb_usuario.cd_usuario = usuario_pacote.cd_usuario
						  inner join tb_pacote
							on usuario_pacote.cd_pacote = tb_pacote.cd_pacote
								where tb_usuario.cd_usuario = '$codigo'";
								
	$result_Busca = mysql_query($query_Busca) or die(mysql_error());
	$linha_Busca = mysql_fetch_assoc($result_Busca);
	$totalLinha_Busca = mysql_num_rows($result_Busca);
	
	$dataAgora = date("Y-m-d H:i:s");
	$dataTermino = $linha_Busca['Data de Término'];
	$dataAgora = strtotime($dataAgora);
	$dataTermino = strtotime($dataTermino);
	$diasRestantes = ($dataTermino - $dataAgora)/86400;
	$diasRestantes = ceil($diasRestantes);
	
	$query = mysql_query("update usuario_pacote set qt_dias = '$diasRestantes' where cd_usuario = '$codigo'") or die(mysql_error());
	
	$codigoPacote = $linha_Busca['codigoPacote'];
	
	$query_Busca_Outros = "select * from tb_pacote where cd_pacote != '$codigoPacote' order by nm_pacote";
			
	$result_Busca_Outros = mysql_query($query_Busca_Outros) or die(mysql_error());
	$linha_Busca_Outros = mysql_fetch_assoc($result_Busca_Outros);
	$totalLinha_Busca_Outros = mysql_num_rows($result_Busca_Outros);
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Licença</title>
	</head>
	<style>
		*
		{
			margin: 0;
			padding: 0;
			font-family: Century Gothic;
			outline: none;
			cursor: hand;
			font-size: 12px;
			
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
		
		#etLogo
		{
			margin-left: 20px;
			width: 50px;
			margin-bottom: -15px;
		}
		
	
		
		#licenca
		{
			display: inline-block;
			width: 300px;
			height: 130px;
			margin-top: 25px;
			margin-left: 22.5px;
			background-color: black;
			box-shadow: 0px 0px 4px 0px #222222;
		}
		
		
		
		#etshop
		{
			display: inline-block;
			width: 300px;
			height: 130px;
			margin-top: 35px;
			margin-left: 22.5px;
			background-color: black;
			box-shadow: 0px 0px 4px 0px #222222;
		}
	
		
		#meuPacote
		{
			display: inline-block;
			width: 300px;
			height: 130px;
			margin-top: 35px;
			margin-left: 22.5px;
			background-color: black;
			box-shadow: 0px 0px 4px 0px #222222;
		}
		
		<?php
			if ($diasRestantes > 0)
			{
		?>
				#licenca:hover
				{
					background: linear-gradient(to top, #871c02 , #c52c06);
				}
		<?php
			}
		?>
		
		#etshop:hover
		{
			background: linear-gradient(to top, #058922 , #00c55d);
		}
		
		<?php
			if ($diasRestantes > 0)
			{
		?>
				#meuPacote:hover
				{
					background: linear-gradient(to top, #032247 , #0a59b4);
				}	
		<?php
			}
		?>
		
		label
		{
			display: inline-block;
			color: white;
			font-size: 16px;
			padding: 25px;
			padding-top:0px;
		}
		
		#saudacao
		{
			font-size: 36px;
			color: #167ff6;
			margin-left: 25px;
			padding: 0px;
		}
		
		.subImg
		{
			display: inline-block;
			width: 30%;
		}
		
		#dadosLicenca
		{
			display: none;
			position: absolute;
			width: 625px;
			height: 460px;
			background-color: #292929;
			margin-top: -295px;
			margin-left: 25px;
			
		}
		
		#dd
		{
			font-weight: bold;
			color: #ab0000;
			padding: 0px;
			font-size: 16px;
			margin-top: 20px;
		}
		
		#de
		{
			padding: 0px;
			color: white;
			font-size: 18px;
		}
		
		#dea
		{
			font-size: 20px;
		}
		
		#myPack
		{
			display: none;
			position: absolute;
			width: 575px;
			height: 410px;
			background-color: #292929;
			margin-top: -295px;
			margin-left: 25px;
			padding:25px;
			
		}
		
		#ets
		{
			display: none;
			position: absolute;
			width: 625px;
			height: 460px;
			background-color: #292929;
			margin-top: -295px;
			margin-left: 25px;
		
		}
		
		#mm
		{
			font-weight: bold;
			color: #356eae;
			padding: 0px;
			font-size: 16px;
			margin-top: 20px;
		}
		
		#me
		{
			padding: 0px;
			color: white;
			font-size: 14px;
		}
		
		#mea
		{
			font-size: 20px;
		}
		
		#imgPack
		{
			width: 30%;
		}
		
		#ets img
		{
			margin-top:25px;
			width: 35%;
		}
		
		#eet
		{
			color: #18d02d;
			font-size: 20px;
			margin-top: 25px;
		}
		
		#player
		{
			display: inline-block;
			background-color: #000000;
			width: 500px;
			height: 300px;
			margin: 25px;
			margin-top:0px;
		}
		
		#video
		{
			display: inline-block;
			width: 100%;
			height: 100%;
			cursor: hand;
		}
	</style>
	
	<body>
		<div id="all">
			<img id="etLogo" src="imagens/logo/logoblue.png">
			<label id="saudacao">Licença</label></br>
			<div id="licenca" align="center">
				<img class="subImg" src="imagens/licenca.png"><br>
				<label id="lblLicenca">Licença</label>
			</div><br>
			<div id="etshop" align="center">
				<img class="subImg" src="imagens/compra.png"><br>
				<label id="lblCompra">Compra</label>
			</div><br>
			<div id="meuPacote" align="center">
				<img class="subImg" src="imagens/pacote.png"><br>
				<label id="lblPacote">Meu Pacote</label>
			</div>
			
			<div id="dadosLicenca" align="center">
				<br>
				<label id="dd">Pacote Atual</label><br>
				<label id="dea"><?php echo $linha_Busca['Pacote']; ?></label><br>
				
				<label id="dd">Status</label><br>			
				<label id="de">Ativa</label><br>
			
				<label id="dd">Data de Início</label><br>
				<label id="de"><?php echo date("d/m/Y H:i:s", strtotime($linha_Busca['Data de Início'])); ?></label><br>
			
				<label id="dd">Data de Término</label><br>
				<label id="de"><?php echo date("d/m/Y H:i:s", strtotime($linha_Busca['Data de Término'])); ?></label><br>
		
				<label id="dd">Dias Restantes</label><br>
				<label id="de"><?php echo $diasRestantes; ?> dia(s)</label><br>
						
			</div>
			
			<div id="myPack" align="center">
				<br>
				<label id="mm">Pacote Atual</label><br>
				<label id="mea"><?php echo $linha_Busca['Pacote']; ?></label><br>
				<br>
				<img id="imgPack" src="<?php echo $linha_Busca['Imagem']; ?>">
				</br>
				<label id="mm">Descrição</label><br>			
				<label id="me"><?php echo $linha_Busca['Descrição']; ?></label><br>
			</div>
			
			<div id="ets" align="center">
				<a href="ETS/Eletron Tech Shop.php" title="Acesse o EletronTech Shop!" target="_parent"><label id="eet">Clique aqui para acessar o EletronTech Shop!</label></a><br>	
				<div id="player">
					<video src="ET.mp4" id="video" controls>
				</div>
			</div>
		</div>
	</body>
	<script>
		window.onload = function()
		{
			<?php
				if ($diasRestantes > 0)
				{
			?> 
					licenca.click();
			<?php
				}
				else
				{
			?>
					etshop.click();
			<?php
				}
			?>
		}
		
		<?php
			if ($diasRestantes > 0)
			{
		?>
				licenca.onclick = function()
				{
					limpaSub();
					dadosLicenca.style.display = "inline-block";
					licenca.style.backgroundColor = "#c52c06";
				}
		<?php
			}
		?>
		
		<?php
			if ($diasRestantes > 0)
			{
		?>
				meuPacote.onclick = function()
				{
					limpaSub();
					myPack.style.display = "inline-block";
					meuPacote.style.backgroundColor= "#0a59b4";
				}
		<?php
			}
		?>
		
		etshop.onclick = function()
		{
			limpaSub();
			ets.style.display = "inline-block";
			etshop.style.backgroundColor = "#058922";
		}
		
		
		function limpaSub()
		{
			etshop.style.backgroundColor = "#292929";
			licenca.style.backgroundColor = "#292929";
			meuPacote.style.backgroundColor= "#292929";
			ets.style.display = "none";
			dadosLicenca.style.display = "none";
			myPack.style.display = "none";
		}
		
		document.onkeydown = KeyCheck;
		function KeyCheck()
		{
		   var KeyID = event.keyCode;
		   switch(KeyID)
		   {
			  case 38:
				//parent.ativarMenu();
				parent.eventosOPT.click();
				parent.eventos.focus();
			  break; 
			  case 40:
				//parent.ativarMenu();
				parent.ferramentasOPT.click();
				parent.ferramentas.focus();
				
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