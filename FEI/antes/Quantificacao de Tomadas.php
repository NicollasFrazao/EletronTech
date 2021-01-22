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
		<title>Quantificação de Tomadas</title>
	</head>
	
	<style type="text/css">
		@import url("css/FEI_CSS.css");
	</style>	
	<body onload="Zerar()">
		<form id="Frm_Dados">
			<table>
				<h1>Quantificação de Tomadas</h1>
				</br>
				<tr>
					<td>
						<label>Cômodo</label>
					</td>
					<td>
						<label>Número de Tomadas</label>
					</td>
				</tr>
				
				<tr>
					<td>
						<select id="cmb_comodo">
						  <option value="0">Selecione uma Opção</option>
						  <option value="1">Área de Serviço</option>
						  <option value="2">Banheiro</option>
						  <option value="3">Copa</option>
						  <option value="4">Cozinha</option>
						  <option value="5">Garagem</option>
						  <option value="6">Lavanderia</option>
						  <option value="7">Quarto</option>
						  <option value="8">Sala</option>
						  <option value="9">Sótão</option>
						  <option value="10">Subsolo</option>
						  <option value="11">Varanda</option>
						</select>
					</td>
					<td>
						<input type="text" id="txt_tomadas" disabled></input>
					</td>
				</tr>
				
				<tr>
					<td>
						<label>Largura (m)</label>
					</td>
					<td>
						<label>Potência por Tomada (VA)</label>
					</td>
				</tr>
				
				<tr>
					<td>
						<input type="text" id="txt_largura" required ></input>
					</td>
					<td>
						<input type="text" id="txt_potenciaTomada" DISABLED></input>
					</td>
				</tr>
				
				<tr>
					<td>
						<label>Comprimento (m)</label>
					</td>
					<td>
						<label>Potência Total (VA)</label>
					</td>
				</tr>
				
				<tr>
					<td>
						<input type="text" id="txt_comprimento" required></input>
					</td>
					<td>
						<input type="text" id="txt_potenciaTotal" DISABLED></input>
					</td>
				</tr>
				
				<tr>
					<td align="right">
						<label id="lbl_ajuda">Ajuda</label>
						<input type="image" src="imagens/btn_ajuda.png" value="Ajuda" id="btn_ajuda" OnClick="Ajuda(); return false;"></input>
					</td>
					<td>
						<input onclick="LimparBorda()" type="reset" value="Limpar" id="btn_limpar"></input>
						<input onclick="Validar(this)" type="button" value="Calcular" id="btn_calcular"></input>
					</td>
				</tr>
			</table>
		</form>
		<script type="text/javascript" src="script/Quantificação de Tomadas - Validação.js">
		</script>
		<script type="text/javascript" src="script/Quantificação de Tomadas - Cálculo.js">
		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>