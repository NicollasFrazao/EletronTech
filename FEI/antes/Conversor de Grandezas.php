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
		<title>Conversor de Grandezas</title>
		<script type="text/javascript" src="script/Conversor de Grandezas - Cálculo.js"></script>
		<style type="text/css">
		@import url("css/FEI_CSS.css");
		</style>
	</head>
	<body onload="Zerar()">
		<form id="Frm_Dados">
			<table>
				<h1>Conversor de Grandezas</h1>
				</br>
				<tr>
					<td>
						<label>Categoria</label>
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<select id="cmb_categoria" onclick="Add();">
						  <option value="0">Selecione uma Opção</option>
						  <option value="1">Carga</option>
						  <option value="2">Condutância</option>
						  <option value="3">Corrente</option>
						  <option value="4">Indutância</option>
						  <option value="5">Potência</option>
						  <option value="6">Resistência</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label>Unidade de Medida Inicial</label>
					</td>
					
					<td>
						<label>Valor Inicial</label>
					</td>
					
				</tr>
				
				<tr>
					
					<td>
					<!--AQUI O COMBO VAI MUDAR DE ACORDO COM A OPÇÃO SELECIONADA NO cmb_categoria...
					DA uma olhada no que fizemos em C#-->
						<select id="cmb_unidadeInicial">
						  <option value="0">Selecione uma Opção</option>
						</select>
					</td>
					
					<td>
						<input type="text" id="txt_valorInicial">
					</td>
					
				</tr>
				
				<tr>
					<td>
						<label>Unidade de Medida Final</label>
					</td>
					
					<td>
						<label>Valor Final</label>
					</td>					
				</tr>
				
				<tr>
				
					<td>
					<!--AQUI TAMBEM, O COMBO VAI MUDAR DE ACORDO COM A OPÇÃO SELECIONADA NO cmb_categoria...-->
						<select id="cmb_unidadeFinal">
						  <option value="0">Selecione uma Opção</option>
						</select>
					</td>
					
					<td>
						<input type="text" id="txt_valorFinal" DISABLED>
					</td>
					
					
				</tr>
				
				<tr>
					<td align="right">
						<label id="lbl_ajuda">Ajuda</label>
						<input type="image" src="imagens/btn_ajuda.png" value="Ajuda" id="btn_ajuda" OnClick="Ajuda(); return false;"></input>
					</td>
					<td>
						<input onclick="LimparBorda()" type="reset" value="Limpar" id="btn_limpar" ></input>
						<input type="button" value="Calcular" id="btn_calcular" onclick="Validar(this)"></input>
					</td>
				</tr>
			</table>
		</form>
		<script type="text/javascript" src="script/Conversor de Grandezas - Validação.js"></script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>