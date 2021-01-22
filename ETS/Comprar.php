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
		header('location:../Home.php'); 
	} 
	
	$logado = $_SESSION['EletronTech']['login'];
	$codigo = $_SESSION['EletronTech']['codigo'];
	$logado = explode(" ", $logado);
	$codigoPacote = mysql_escape_string($_GET['codigoPacote']);
	
	$query_Busca = "select * from tb_usuario where cd_usuario = '$codigo'";
			
	$result_Busca = mysql_query($query_Busca) or die(mysql_error());
	$linha_Busca = mysql_fetch_assoc($result_Busca);
	$totalLinha_Busca = mysql_num_rows($result_Busca);
	
	$query_Busca_Outros = "select * from tb_pacote where cd_pacote != 1 and ic_custom = 0 order by nm_pacote";
			
	$result_Busca_Outros = mysql_query($query_Busca_Outros) or die(mysql_error());
	$linha_Busca_Outros = mysql_fetch_assoc($result_Busca_Outros);
	$totalLinha_Busca_Outros = mysql_num_rows($result_Busca_Outros);
	
	$query_Busca_Ferramentas = "select * from tb_ferramenta order by nm_ferramenta";
			
	$result_Busca_Ferramentas = mysql_query($query_Busca_Ferramentas) or die(mysql_error());
	$linha_Busca_Ferramentas = mysql_fetch_assoc($result_Busca_Ferramentas);
	$totalLinha_Busca_Ferramentas = mysql_num_rows($result_Busca_Ferramentas);
?>

<!Doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="shortcut icon" href="imagens/logo/logo.ico" />
		<title>Eletron Tech Shop - Adquira Seu Pacote!</title>
	<style>
		*
		{
			margin:0;
			padding: 0;
			outline: none;
		}
		
		body
		{
			font-family: Century Gothic;
		}
		
		
		::-webkit-scrollbar
		{
			height: 12px;
			width: 12px;
			background: RGBA(255,255,255,0.15);
			
		}
		
		::-webkit-scrollbar-thumb
		{
			background: white;
			-webkit-box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.75);
		}

		::-webkit-scrollbar-corner
		{
			background: black;
		}
		
		#all label
		{
			display: inline-block;
			width: 100%;
			color: white;
		}
		
		#all input, #all select
		{	
			display: inline-block;
			width: 100%;
			height: 36px;
		}
		
		#imgPack
		{
			display: inline-block;
			width: 40%;
			margin-left: 30%;
		}
		
		#btn_cancelar
		{
			background-color: transparent;
			border: 0px;
			color: white;
		}
		
		#btn_comprar
		{
			background-color: green;
			border: 0px;
			color: white;
		}
		
		#confirmar
		{
			display: none;
			width: 42%;
			height: 30%;
			margin-left: 25%;
			margin-top:15%;
			background-color: #319428;
			position: absolute;
			z-index:9999;
			color: white;
			padding:5%;
			opacity: 0.9;
		}
		
		#confirmar label
		{
			font-align:justify;
			font-size: 16px;
		}
		
		#confirmar input
		{
			width: 95%;
			height: 36px;
			margin:5px;
			margin-right: 0px;
			border: 0px;
			font-size: 26px;
		}
		
		#confirmar #btn_confirmar
		{
			display: inline-block;
			margin-left: -10%;
			font-size: 18px;
			padding:5px;
			background-color: black;
			color: white;
		}
		
		#custom
		{
			display: none;
			width: 50%;
			height: 50%;
			margin-top:15%;
			background-color: green;
			position: absolute;
			z-index: 9999;
			opacity: 0.9;
			left: 50px;
		}
		
		#topo
		{
			display: inline-block;
			height: 10%;
			width: 100%;
			background-color: #1e6018;
			color: white;
			z-index: 9999;
		}
		
		#baixo
		{
			display: inline-block;
			background-color: transparent;
			width: 100%;
			height: 90%;
			overflow: auto;
			color: white;
			margin-top:1px;
		}
		
		#FEI
		{
			display: inline-block;
			width: 90%;
			background-color: transparent;
			margin-top: 5%;
			padding: 2%;
		}
		
		#all table
		{
			display: inline-block;
			background-color: #389852;
			position: absolute;
			margin-left:50%;
			margin-top:5%;
			padding: 5%;
			opacity: 0.9;
			z-index: 9998;
			right: 50px;
		}
		
		#logotipo
		{
			display: inline-block;
			width: 10%;
			height: 10%;
			background-color: transparent;
			position: absolute;
			margin-top: 3%;
			margin-left: 3%;
		}

		#logotipo img
		{
			width:100%;
			float:left;
			position:absolute;
			z-index: 9999;
		}

		#propaganda
		{
			display: inline-block;
			width: 50%;
			height: 50%;
			margin-top:20%;
			position: fixed;
			z-index: 9998;
		}

		#propaganda label
		{
			font-size: 60px;
			color: white;
			padding-left: 10%;
		}
		
		#back
		{
			display: inline-block;
			width: 100%;
			height: 100%;
			position: fixed;
		}

		#back img
		{
			width: 100%;
			height: 100%;
			position: fixed;
		}

		#up
		{
			display: inline-block;
			width: 100%;
			height: 100%;
			opacity: 0.5;
			background-color: green;
			position: fixed;
		}
		
		#up2
		{
			display: none;
			width: 100%;
			height: 100%;
			opacity: 0.5;
			background-color: white;
			position: fixed;
			z-index:9998;
		}
		
		#btn_finalizarC
		{
			display: inline-block;
			width: 50%;
			height: 10%;
			background-color: RGBA(0,0,0,0.8);
			color: white;
			border: 0px;
			font-size: 18px;
		}
		
		#btn_finalizarC:hover
		{
			background-color: black;
		}
		
		#btn_voltarC:hover
		{
			background-color: white;
		}
		
		#btn_voltarC
		{
			display: inline-block;
			width: 48%;
			height: 10%;
			background-color: RGBA(255,255,255,0.4);
			color: black;
			border: 0px;
			margin-top: 10px;
			font-size: 18px;
		}
		
		
		
		#confirmar #volta
		{
			display: inline-block;
			width: 7.5%;
			float:right;
			margin: -8%;
			margin-left: 2%;
			align: right;
		}
		
		#FEI input
		{
			display: inline-block;
			width: 20px;
			height: 20px;
		}
		
		#FEI img
		{
			display: inline-block;
			width:100px;
			align: center;
		}	
		
		#FEI:hover
		{
			background-color: RGBA(255, 255, 255, 0.15);
		}	
		
		#FEI label
		{
			text-shadow: 1px 0px black;
		}
	</style>
	</head>
	<body>
			<div id="logotipo">
				<img src="imagens/logo2.png">
			</div>
			
			<div id="menu">
					
			</div>
			
			<div id="propaganda">
				<label>Falta pouco</label><br>
				<label>para finalizar</label><Br>
				<label>sua compra!</label>
			</div>
		<form id="Frm_Compra" method="POST" action="php/CompraPacote.php">
			<div id="all">			
				<table>
					<tr>
						<td colspan="2" align="center">
							<label>Selecione as opções desejadas</label>
						</td>
					</tr>
					
					<tr>
						<td colspan="2">
							<img id="imgPack" src="../imagens/pacotes/advanced.png">
						</td>
					</tr>
					
					<tr>
						<td colspan="2">
							<label>Pacote</label>
						</td>
					</tr>
					
					<tr>
						<td colspan="2">
							<select name="pacote" id="cmb_pacote">
								<option value="0">Selecione...</option>
								<?php
									do
									{
								?>
										<option value="<?php echo $linha_Busca_Outros['cd_pacote']; ?>" <?php if ($linha_Busca_Outros['cd_pacote'] == $codigoPacote) {echo "selected";} ?>><?php $aux = explode(" ",$linha_Busca_Outros['nm_pacote']); echo $aux[2]; ?></option>
								<?php
									}
									while ($linha_Busca_Outros = mysql_fetch_assoc($result_Busca_Outros));
								?>
							</select>
						</td>
					</tr>
					
					<tr>
						<td colspan="2">
							<label>Dias de uso</label>
						</td>
					</tr>
					
					<tr>
						<td colspan="2">
							<input type="number" name="diasUso" id="txt_dias_uso" min="7" max="365">
						</td>
					</tr>
					
					<tr>
						<td colspan="2">
							<label>Término da licença</label>
						</td>
					</tr>
					
					<tr>
						<td colspan="2">
							<input type="text" name="dataTermino" id="txt_data_termino" disabled>
						</td>
					</tr>
					
					<tr>
						<td colspan="2">
							<!--<label>Valor</label>-->
						</td>
					</tr>
					
					<tr>
						<td colspan="2">
							<input type="hidden" disabled>
							<input type="hidden" id="ic_custom" name="icCustom">
						</td>
					</tr>
					
					<tr>
						<td>
							<input id="btn_cancelar" type="button" value="Voltar">
						</td>
						<td>
							<input id="btn_comprar" type="button" value="Comprar">
						</td>
					</tr>
				</table>
			</div>
			<div id="confirmar">
				<input type="image" src="../imagens/fechar2.png" id="volta">
				<table>
					<tr>
						<td colspan="2">
							<label>Confirmação de compra</label>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="justify" style="padding: 10px;">
						</br>
							<label>Olá <?php echo $logado[0]; ?>, Falta pouco para finalizarmos sua compra! Para isso, precisamos que você confirme sua senha no campo abaixo:</label>
						</td>
					</tr>
					<tr>
						<td>
							<input type="password" id="txt_confirma">
						</td>
						<td>
							<input type="button" value="Confirmar" id="btn_confirmar">
						</td>
					</tr>
				</table>
			</div>
			
			<div id="custom">
				<div id="topo" align="center">
					<label>Selecione as ferramentas para seu pacote Custom</label>
				</div>
				<div id="baixo" align="center">
				
				<!--É PRA GERAR ISSO AQUI Ó-->
					<?php
						do
						{
					?>
							<table id="FEI" align="center">
								<tr>
									<td align="center">
										<input type="checkbox" name="ferramentas[]" value="<?php echo $linha_Busca_Ferramentas['cd_ferramenta']; ?>">
									</td>
									<td>
										<img src="<?php echo "../".$linha_Busca_Ferramentas['nm_url_imagem']; ?>">
									</td>
								
									<td align="center">
										<label><?php echo $linha_Busca_Ferramentas['nm_ferramenta']; ?></label>
									</td>
								</tr>
							</table>
					<?php
						}
						while ($linha_Busca_Ferramentas = mysql_fetch_assoc($result_Busca_Ferramentas));
					?>
				<!--OK-->
				
				</div>
				<input type="button" value="Voltar" id="btn_voltarC">
				<input type="button" value="Concluir" id="btn_finalizarC">
				
			</div>
		</form>
		<div id="back">
			<img src="imagens/shop/compra.jpg">
		</div>
		<div id="up">
		
		</div>
		<div id="up2">
		
		</div>
	</body>
	<script type="text/javascript" src="script/Criptografia.js"></script>
	<script>
		var camposCorretos = new Array(3);
		
		window.onload = function()
		{
			nmPacote = new Array(1);
			imPacote = new Array(1);
			cdPacote = new Array(1);
			
			<?php
				$query_Busca_Outros = "select * from tb_pacote where cd_pacote != 1 and ic_custom = 0 order by nm_pacote";
						
				$result_Busca_Outros = mysql_query($query_Busca_Outros) or die(mysql_error());
				$linha_Busca_Outros = mysql_fetch_assoc($result_Busca_Outros);
				$totalLinha_Busca_Outros = mysql_num_rows($result_Busca_Outros);
				
				do
				{
			?>
					nmPacote.push("<?php $aux = explode(" ",$linha_Busca_Outros['nm_pacote']); echo $aux[2]; ?>");
					imPacote.push("<?php echo $linha_Busca_Outros['im_pacote']; ?>");
					cdPacote.push("<?php echo $linha_Busca_Outros['cd_pacote']; ?>");
			<?php
				}
				while ($linha_Busca_Outros = mysql_fetch_assoc($result_Busca_Outros));
			?>
			
			trocaPacote();
		}
		
		function trocaPacote()
		{
			imgPack.src=imPacote[cmb_pacote.selectedIndex];
						
			if (cmb_pacote.selectedIndex != 0)
			{
				imgPack.src = imPacote[cmb_pacote.selectedIndex];
			}
			else
			{
				imgPack.src = "imagens/pacotes/tester.png";
			}
		}
		
		txt_dias_uso.onkeypress = function(e,args)
		{
			if (document.all) // caso seja IE
			{
				var evt=event.keyCode;
			}			
			else // do contrário deve ser Mozilla ou Google
			{
				var evt = e.charCode;
			}
			
			var valid_chars = '0123456789';      // criando a lista de teclas permitidas
			var chr= String.fromCharCode(evt);      // pegando a tecla digitada
			
			if (valid_chars.indexOf(chr)>-1 ) // se a tecla estiver na lista de permissão permite-a
			{
				return true;
			}
			
			// para permitir teclas como <BACKSPACE> adicionamos uma permissão para
			// códigos de tecla menores que 09 por exemplo 
			
			if (valid_chars.indexOf(chr)>-1 || evt < 9)
			{
				return true;
			}
			
			return false;   // do contrário nega
		}
		
		function verificaDiasUso()
		{
			if (txt_dias_uso.value > 0)
			{
				txt_dias_uso.style.border = "1px solid green";
				camposCorretos[1] = 1;
			}
			else
			{
				txt_dias_uso.style.border = "1px solid red";
				camposCorretos[1] = 0;
			}
			
			if (parseInt(txt_dias_uso.value) > 365) 
			{
				txt_dias_uso.value = 365;
			}
			
			if (parseInt(txt_dias_uso.value) < 7) 
			{
				txt_dias_uso.value = 7;
			}
		}
		
		txt_dias_uso.onblur = function()
		{
			verificaDiasUso();
			Termino();
		}
		
		txt_dias_uso.onchange = function()
		{
			verificaDiasUso();			
			Termino();
		}
		
		txt_dias_uso.onfocus = function()
		{
			txt_dias_uso.style.border = "1px solid blue";
		}
		
		function verificaPacote()
		{
			if (cmb_pacote.selectedIndex != 0)
			{
				cmb_pacote.style.border = "1px solid green";
				camposCorretos[0] = 1;
			}
			else
			{
				cmb_pacote.style.border = "1px solid red";
				camposCorretos[0] = 0;
			}
		}
		
		cmb_pacote.onfocus = function()
		{
			cmb_pacote.style.border = "1px solid blue";
		}
		
		cmb_pacote.onblur = function()
		{
			verificaPacote();
			trocaPacote();
		}
		
		cmb_pacote.onchange = function()
		{
			verificaPacote();
			trocaPacote();
		}
		
		txt_confirma.onfocus = function()
		{
			txt_confirma.style.border = "1px solid blue";
		}
		
		function verificaSenha()
		{
			if (txt_confirma.value == base64_decode("<?php echo $linha_Busca['cd_senha']; ?>"))
			{
				txt_confirma.style.border = "1px solid green";
				confirmacaoOk = 1;
				//camposCorretos[4] = 1;
			}
			else
			{
				txt_confirma.style.border = "1px solid red";
				confirmacaoOk = 0;
				//camposCorretos[4] = 0;
			}
		}
		
		txt_confirma.onblur = function()
		{
			verificaSenha();
		}
		
		function Termino()
		{
			if (txt_dias_uso.value > 0)
			{
				dataAgora = new Date();
				qtDias = txt_dias_uso.value;
				qtDias = 60*60*24*qtDias*1000;
				dataTermino = dataAgora.getTime() + qtDias;
				dataTermino = new Date(dataTermino);
				
				var zeroMinutos = "";
				var zeroHoras = "";
				
				if (dataTermino.getHours() < 10)
				{
					zeroHoras = "0";
				}
				
				if (dataTermino.getMinutes() < 10)
				{
					zeroMinutos = "0";
				}
				
				txt_data_termino.value = dataTermino.getDate() + "/" + (dataTermino.getMonth() + 1) + "/" + dataTermino.getFullYear() + " " + zeroHoras + dataTermino.getHours() + ":" + zeroMinutos + dataTermino.getMinutes() + ":" + dataTermino.getSeconds();
				txt_data_termino.style.border = "1px solid green";
				camposCorretos[2] = 1;
			}
			else
			{
				txt_data_termino.value = "";
				txt_data_termino.style.border = "1px solid red";
				camposCorretos[2] = 0;
			}
			
			setTimeout("Termino()", 1000);
		}
		
		function verificaFerramentas()
		{
			var ferramentas = document.getElementsByName("ferramentas[]");
			var acu = 0;

			for (cont = 0; cont <= ferramentas.length - 1; cont = cont + 1)
			{  
				 if (ferramentas[cont].checked == true)
				 {  
					acu = acu + 1;
				 }  
			}
			
			if (acu == 0)
			{
				alert("Selecione as ferramentas para seu Pacote Custom!");
				return false;
			}
			else
			{
				return true;
			}
		}
		
		btn_comprar.onclick = function()
		{
			verificaPacote();
			verificaDiasUso();
			Termino();
			
			var aux = 0;
			for (cont = 0; cont <= camposCorretos.length - 1; cont = cont + 1)
			{
				aux = aux + parseInt(camposCorretos[cont]);
			}
			if (aux != camposCorretos.length)
			{
				alert("Alguns campos estão inválidos, verifique e tente novamente!\n\n");
				return false;
			}
			else
			{
				//frm.submit();
				//calcular();
				if (cmb_pacote.value == 8)
				{
					ic_custom.value = 1;
					up2.style.display = "inline-block";
					custom.style.display = "inline-block";
				}
				else if (cmb_pacote.selectedIndex != 0)
				{
					 ic_custom.value = 0;
					 up2.style.display = "inline-block";
					 confirmar.style.display = "inline-block";
					 txt_confirma.focus();
				}
			}
		}
		
		btn_finalizarC.onclick = function()
		{
			var selecionouFerramentas = verificaFerramentas();
			
			if (selecionouFerramentas == true)
			{
				custom.style.display = "none";
				confirmar.style.display = "inline-block";
				txt_confirma.focus();
			}
		}
		
		btn_confirmar.onclick = function()
		{
			verificaSenha();
			
			if (confirmacaoOk == 1)
			{
				var frm = document.querySelector("#Frm_Compra");
				frm.submit();
			}
		}
		
		volta.onclick = function()
		{
			confirmar.style.display="none";
			up2.style.display = "none";
			return false;
		}
		
		btn_voltarC.onclick = function()
		{
			up2.style.display = "none";
			custom.style.display = "none";
		}
		
		btn_cancelar.onclick = function()
		{
			window.open("Eletron Tech Shop.php","_parent");
		}
		
		txt_confirma.onkeypress = function(e,args)
		{
			if (e.keyCode == 13)
			{
				btn_confirmar.click();
			}
		}
		
		Frm_Compra.onkeypress = function(e,args)
		{
			if (e.keyCode == 13)
			{
				btn_comprar.click();
			}
		}
	</script>
</html>

<?php
	mysql_close($conexao);
?>