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
		<title>Disjuntor e Fiação</title>
		<style type="text/css">
		@import url("css/FEI_CSS.css");
		</style>
	</head>
	<body onload="Zerar()">
		<form id="Frm_Dados">
			<table>
				<h1>Disjuntor e Fiação</h1>
				</br></br>
				<tr>
					<td>
						<label>Bitola (mm²)</label>
					</td>
					<td>
						<label>Corrente (A)</label>
					</td>
				</tr>
				
				<tr>
					<td>
						<select id="cmb_bitola">
						  <option value="0">Selecione uma Opção</option>
						  <option value="1">1,0 mm²</option>
						  <option value="2">1,5 mm²</option>
						  <option value="3">2,5 mm²</option>
						  <option value="4">4,0 mm²</option>
						  <option value="5">6,0 mm²</option>
						  <option value="6">10,0 mm²</option>
						  <option value="7">16,0 mm²</option>
						</select>
					</td>
					<td>
						<input type="text" id="txt_corrente">
					</td>
				</tr>
				
				<tr>
					<td>
						<label>Tensão (V)</label>
					</td>
					<td>
						<label>Potência (VA)</label>
					</td>
				</tr>
				
				<tr>
					<td>
						<select id="cmb_tensao">
						  <option value="0">Selecione uma Opção</option>
						  <option value="1">110 V</option>
						  <option value="2">220 V</option>
						</select>
					</td>
					<td>
						<input type="text" id="txt_potencia"></input>
					</td>
				</tr>
				
				<tr>
					<td align="right">
						<label id="lbl_ajuda">Ajuda</label>
						<input type="image" src="imagens/btn_ajuda.png" value="Ajuda" id="btn_ajuda" OnClick="Ajuda(); return false;"></input>
					</td>
					<td>
						<input type="reset" value="Limpar" id="btn_limpar" OnClick="Limpar(); LimparBorda()"></input>
						<input type="button" value="Calcular" id="btn_calcular" OnClick="Calcular()"></input>
					</td>
				</tr>
			</table>
		</form>
		<script type="text/javascript" src="script/Disjuntor e Fiação - Cálculo.js"></script>
		<script type="text/javascript" src="script/Disjuntor e Fiação - Validação.js"></script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>	