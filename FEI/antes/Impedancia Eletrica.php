<?php
	include "php/Conexao.php";
	
	session_start();
	
	$codigoFerramenta = mysql_escape_string($_GET['codigoFerramenta']);
	$codigoUsuario	= $_SESSION['EletronTech']['codigo'];
	
	include "php/Utilizacao.php";
?>

<html>
	<head>
		<meta charset = "UTF-8">
		<title>Impedancia Elétrica</title>
		<script type="text/javascript" src="script/Impedancia Eletrica - Calculo.js"></script>
		<style type="text/css">
		@import url("css/FEI_CSS.css");
		</style>
	</head>
	<body>
		<form id="Frm_Dados" onsubmit="if (submit == 0) {return false;}">
			<table>
				<h1>Impedância Elétrica</h1>
				</br></br>
				<tr>
					<td>
						<label>Resistencia Elétrica (Ω)</label>
					</td>
					
					<td>
						<label>Frequencia da Corrente (Hz)</label>
					</td>
				</tr>
				
				<tr>
					<td>
						<input type="text" id="resistencia_eletrica" required />
					</td>
					<td>
						<input type="text" id="frequencia_corrente" required />
					</td>
				</tr>
				
				
				<tr>
					<td>
						<label>Capacitancia Elétrica (F)</label>
					</td>
					<td>
						<label>Impedância Elétrica (Ω)</label>
					</td>
				</tr>
				
				<tr>
					<td>
						<input type="text" id="capacitancia" required/>
					</td>
					
					<td>
						<input type="text" id="resultado" required disabled/>
					</td>
				</tr>
				<tr>
					<td align="right">
						<label id="lbl_ajuda">Ajuda</label>
						<input type="image" src="imagens/btn_ajuda.png" value="Ajuda" id="btn_ajuda" OnClick="submit = 0; Ajuda(); return false;"></input>
					</td>
					
					<td>
						<input type="reset" value="Limpar" id="btn_limpar" OnClick="Limpar()"></input>
						<input type="button" value="Calcular" id="btn_calcular" OnClick="submit = 1; Validar(this);" >
					</td>
				</tr>
				
			</table>
		</form>
		<script type="text/javascript" src="script/Impedancia Eletrica - Validacao.js"></script>
		<script>
			window.onload = function()
			{
				submit = 0;
			}
		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>