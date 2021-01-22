<?php
	include "php/Conexao.php";
	
	session_start();
	
	$codigoFerramenta = mysql_escape_string($_GET['codigoFerramenta']);
	$codigoUsuario	= $_SESSION['EletronTech']['codigo'];
	
	include "php/Utilizacao.php";
	
	$query_Busca = "select ds_ajuda from tb_ferramenta where cd_ferramenta = '$codigoFerramenta'";
	$result_Busca = mysql_query($query_Busca) or die(mysql_error());
	$linha_Busca = mysql_fetch_assoc($result_Busca);
?>

<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<title>Capacitância Elétrica</title>
		<style type="text/css">
		@import url("css/FEI_CSS.css");
		
		#ethelp
		{
			display: none;
			width: 600px;
			height: 300px;
			margin-top: -150px;
			margin-left: -300px;
			top: 50%;
			left: 50%;
			z-index: 9999;
			position: absolute;
			background-color: white;
			background-color: rgba(0,0,0,0.8);
		}
		
		#texto 
		{
			text-align:center;
			position:relative;
			margin-top: 2%;
			margin-left: 2%;
			margin-right: 2%;
		}
		
		#ethelpcima
		{
			display: none;
			width: 100%;
			height: 100%;
			z-index: 9998;
			position: absolute;
			background-color: rgba(0,0,0,0.6);
		}
		
		#lbl_outra_ajuda
		{
			align:center;
		}
		
		#etclose
		{
			margin-top: 1%;
			margin-right: 1%;
			width: 16px;
			height: 16px;
		}
		</style>
	</head>
	<body>
		<form id="Frm_Dados" onsubmit="if (submit == 0) {return false;}">
			<table>
				<h1>Capacitância Elétrica</h1>
				</br></br>
				<tr>
					<td>
						<label>Quantidade de Carga (C)</label>
						
					</td>
					
					<td>
						<label>Potência Elétrica (VA)</label>
					</td>
				</tr>
				<tr>
					<td>
						<input type="text" id="txt_carga" maxLength="9">
					</td>
					
					<td>						
						<input type="text" id="txt_potencia_eletrica" maxLength="9">
					</td>
				</tr>
				
				<tr>
				
					<td>
						<label>Corrente Elétrica (A)</label>
						
					</td>
					<td>
						<label>Capacitância Elétrica (F)</label>
					</td>
				</tr>
				<tr>
					<td>
						<input type="text" id="txt_corrente_eletrica" maxLength="9">
					</td>
					<td>
						<input type="text" id="txt_resultado" DISABLED>
					</td>
				</tr>
					<tr>
						<td align="right">
							<label id="lbl_ajuda">Ajuda</label>
							<input type="image" src="imagens/btn_ajuda.png" value="Ajuda" id="btn_ajuda" title="Clique para solicitar ajuda." onclick="submit = 0; Ajuda(); return false;"></input>
						</td>
						<td>
							<input type="button" value="Limpar" id="btn_limpar" onclick="limpar()">
							<input type="button" value="Calcular" id="btn_calcular" OnClick="Validar(this)">
						</td>
					</tr>
			</table>
		</form>
		<div id="ethelpcima">
			<input type="image" align="right"  id="etclose" src="imagens/close.png" value="Fechar"></input>
			<div id="ethelp">
				<table>
					<br/>
					<br/>
					<tr>
						<td align="center">
							<label>Ajuda</label>
						</td>
					</tr>
					<tr>
						<td >
							<p id="texto">"<?php echo $linha_Busca['ds_ajuda']; ?>"</p>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<iframe id="frameCalculo" style="display: none;"></iframe>
	</body>
	<script type="text/javascript" src="script/Capacitância Elétrica - Validação.js"></script>
	<script type="text/javascript" src="script/Capacitância Elétrica - Cálculo.js"></script>
	<script>
	
		function Ajuda()
		{
			ethelp.style.display = "inline-block";
			ethelpcima.style.display = "inline-block";
		}
		
		ethelpcima.onclick = function()
		{
			ethelp.style.display = "none";
			ethelpcima.style.display = "none";
			
		}
		
		window.load = function()
		{
			submit = 0;
		}
		
		/*function calcular()
		{
			submit = 1;
			
			aux = txt_potencia_eletrica.value;
			aux = aux.replace(" VA", "");
			var auxpotencia = parseFloat(aux).toFixed(2);
			
			aux = txt_carga.value;
			aux = aux.replace(" C", "");
			var auxcarga = parseFloat(aux).toFixed(2);
			
			aux = txt_corrente_eletrica.value;
			aux = aux.replace(" A", "");
			var auxcorrente = parseFloat(aux).toFixed(2);
			
			//frameCalculo.src = "php/PegaValores.php?cdFerramenta=<?php echo $codigoFerramenta; ?>&potencia=" + auxpotencia + "&carga=" + auxcarga + "&corrente=" + auxcorrente;
		}*/
		
		Frm_Dados.onkeypress = function(e,args)
		{
			if (e.keyCode == 13)
			{
				btn_calcular.click();
			}
		}
	</script>
</html>

<?php
	mysql_close($conexao);
?>