<?php
	include "php/Conexao.php";
	
	session_start();
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	
	$codigo = $_SESSION['EletronTech']['codigo'];
	$codigoPacote = mysql_escape_string($_GET['codigoPacote']);
	$corPacote = mysql_escape_string($_GET['corPacote']);
	
	$query_Busca_Ferramenta = "select nm_ferramenta, nm_url_imagem, ds_ferramenta
							  from tb_ferramenta inner join pacote_ferramenta
								on tb_ferramenta.cd_ferramenta = pacote_ferramenta.cd_ferramenta
								  inner join  tb_pacote
									on pacote_ferramenta.cd_pacote = tb_pacote.cd_pacote
									   where tb_pacote.cd_pacote = '$codigoPacote' order by nm_ferramenta";
			
	$result_Busca_Ferramenta = mysql_query($query_Busca_Ferramenta) or die(mysql_error());
	$linha_Busca_Ferramenta = mysql_fetch_assoc($result_Busca_Ferramenta);
	$totalLinha_Busca_Ferramenta = mysql_num_rows($result_Busca_Ferramenta);
	
	$query_Busca_Pacote = "select nm_pacote from tb_pacote where cd_pacote = '$codigoPacote'";
			
	$result_Busca_Pacote = mysql_query($query_Busca_Pacote) or die(mysql_error());
	$linha_Busca_Pacote = mysql_fetch_assoc($result_Busca_Pacote);
	$totalLinha_Busca_Pacote = mysql_num_rows($result_Busca_Pacote);
	
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
		$codigoPacoteAtual = $linha_Busca['codigoPacote'];
	}
	else
	{
		$codigoPacoteAtual = 8;
	}
?>

<!Doctype html>
<html>
	<head>
		<title></title>
	</head>
	<style>
		*
		{
			margin:0;
			padding:0;
			outline: none;
		}	
		
		body
		{
			font-family: Century Gothic;
		}
		
		#tutto
		{
			display: inline-blokc;
			width: 100%;
			height: 100%;
			background-color: transparent;
			position: fixed;
		}
		
		#topo
		{
			display: inline-blokc;
			width: 100%;
			height: 10%;
			background-color: blue;
		}
		
		#topo label
		{
			display: inline-block;
			background-color: transparent;
			font-size: 26px;
			height: 100%;
			width: 100%;
			padding-top:1%;
			color: black;
		}
		
		#slider
		{
			display: inline-block;
			width: 100%;
			height: 100%;
			background-color: transparent;
		}
		
		#cima
		{
			display: inline-block;
			width: 100%;
			height:10%;
			background-color: transparent;
			align:center;
		}
		
		#meio
		{
			display: inline-block;
			width: 93%;
			height:60%;
			padding-left:7%;
			
			
		}
		
		#baixo
		{
			display: inline-block;
			width: 100%;
			height:30%;
			background-color: transparent;
		}
		
		#cima label
		{
			display: inline-block;
			width: 100%;
			font-size: 24px;
			color: white;
			align: center;
		}
		
		#sinistra, #mezzo, #destra
		{
			display: inline-block;
			width: 30%;
			height: 100%;
			background-color: transparent;
		}
		
		#sinistra input, #destra input
		{
			display: inline-block;
			width: 50%;
			height: 100%;
			outline: none;
			opacity: 0.2;
		}
		
		#sinistra input:hover, #destra input:hover
		{
			opacity: 1;
		}
		
		#mezzoTopo
		{
			display: inline-block;
			width: 100%;
			height: 100%;
			
		}
		
		#mezzoTopo #imagemFerramenta
		{
			display: inline-block;
			width: 20%;
			margin-left: 4.5%;
			margin-top:1%;
			position: absolute;
			outline: none;
		}
		
		#mezzoTopo #btn_comprar
		{
			display: inline-block;
			width: 20%;
			height: 8%;
			margin-left: 4.5%;
			margin-top:35%;
			position: absolute;
			outline: none;
		}
		
		#topoGiu
		{
			display: inline-block;
			width: 100%;
			background-color: transparent;
		}
		
		#topoGiu label
		{
			display: inline-block;
			background-color:  transparent;
			width: 99%;
			color: white;
			padding-left: 1%;
			
		}
		
		#giuGiu label
		{
			color: white;
			font-size: 16px;
			padding:5%;
		}
		
		#nomeFerramenta
		{
			display: inline-block;
			background-color: <?php if ($corPacote[0] == 'a' && $corPacote[1] == 'u' && $corPacote[2] == 'x') {echo str_replace("aux","#",$corPacote);} else {echo $corPacote;} ?>;
		}
		
		#comprar_estender
		{
			font-weight: bold;
			color: <?php if ($corPacote[0] == 'a' && $corPacote[1] == 'u' && $corPacote[2] == 'x') {echo str_replace("aux","#",$corPacote);} else {echo $corPacote;} ?>;
			z-index: 9999;
		}
		
		#voltar
		{
			display: inline-block;
			height: 7%;
			margin: 0;
			position: absolute;
			z-index: 9999;
		}
	</style>
	<body>
		<div id="tutto">
			<div id="slider">
				<div id="cima" align="center">
					<input type="image" src="imagens/voltar.png" id="voltar">
					<label id="nomeFerramenta"></label>
					
				</div>
				<div id="meio">
					<div id="sinistra">
						<input type="image" id="btn_esquerda" src="../imagens/setaE.png">
					</div>
					<div id="mezzo">
						<div id="mezzoTopo">
							<input type="image" id="imagemFerramenta" src="">
							
						</div>
						
					</div>
					<div id="destra" align="right">
						<input type="image" id="btn_direita" src="../imagens/setaD.png">
					</div>
				</div>
				<div id="baixo">
					<div id="topoGiu" align="center">
						<label id="ds_ferramenta">Com base na corrente elétrica e no número de espirais que compõem a bobina de resistência da corrente, realiza o cálculo para determinar a corrente absorvida no circuito e dimensionar corretamente a proteção de condutores acima de 20m, apresentando o resultado em Henry.</label>
						<br/>
						<br/>
						<a href="#" title="Clique aqui para comprar ou estender o pacote." style="text-decoration: none;" id="comprar_estender"><?php if ($codigoPacote != $codigoPacoteAtual) {echo "Comprar Pacote";} else {echo "Estender Pacote";} ?></a>
						
					</div>
					<div id="giuGiu">
						<label id="descricaoPacote"></label>
					</div>
				</div>
			</div>
		</div>
	</body>
	
	<script>
		window.onload = function()
		{
			sliderValue = 0;
			nmFerramenta = new Array;
			imFerramenta = new Array;
			dsFerramenta = new Array;
			<?php
				do
				{
			?>
					nmFerramenta.push("<?php echo $linha_Busca_Ferramenta['nm_ferramenta']; ?>");
					imFerramenta.push("<?php echo $linha_Busca_Ferramenta['nm_url_imagem']; ?>");
					dsFerramenta.push("<?php echo $linha_Busca_Ferramenta['ds_ferramenta']; ?>");
			<?php
				}
				while ($linha_Busca_Ferramenta = mysql_fetch_assoc($result_Busca_Ferramenta));
			?>
			trocaFerramenta();
		}
		
		btn_esquerda.onclick = function()
		{
			if(sliderValue == 0)
			{
				sliderValue = nmFerramenta.length - 1;
			}
			else
			{
				sliderValue--;
			}
			trocaFerramenta();
		}
		
		btn_direita.onclick = function()
		{
			if(sliderValue == nmFerramenta.length - 1)
			{
				sliderValue = 0;
			}
			else
			{
				sliderValue++;
			}
			trocaFerramenta();
		}
		
		function trocaFerramenta()
		{
			nomeFerramenta.innerHTML = nmFerramenta[sliderValue];
			imagemFerramenta.src = "../" + imFerramenta[sliderValue];
			ds_ferramenta.innerHTML = dsFerramenta[sliderValue];
		}
		
		voltar.onclick = function()
		{
			parent.fecharFei();
		}
		
		comprar_estender.onclick = function()
		{
			parent.confirmarCompra(<?php echo $_GET['codigoPacote']; ?>);
			//window.location.href = "compra.php";
		}
	</script>
</html>

<?php
	mysql_close($conexao);
?>