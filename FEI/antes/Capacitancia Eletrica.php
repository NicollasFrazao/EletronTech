<?php
	include "php/Conexao.php";
	
	session_start();
	
	$codigoFerramenta = mysql_escape_string($_GET['codigoFerramenta']);
	$codigoUsuario	= $_SESSION['EletronTech']['codigo'];
	
	include "php/Utilizacao.php";
?>

<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<title>Capacitância Elétrica</title>
		<style type="text/css">
		@import url("css/FEI_CSS.css");
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
		<iframe id="frameCalculo" style="display: none;"></iframe>
	</body>
	<script type="text/javascript" src="script/Capacitância Elétrica - Validação.js"></script>
	<script type="text/javascript" src="script/Capacitância Elétrica - Cálculo.js"></script>
	<script>
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