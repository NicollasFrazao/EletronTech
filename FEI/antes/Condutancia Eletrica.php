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
		<title>Condutância Elétrica</title>
		<style type="text/css">
		@import url("css/FEI_CSS.css");
		</style>
	</head>
	<body>
		<form id="Frm_Dados" onsubmit="if (submit == 0) {return false;}">
			<table>
			<h1>Condutância Elétrica</h1>
			</br></br>
				<tr>
					<td>
						<label>Intencidade da Corrente (A)</label>
					</td>
					<td>
						<label>Condutância Elétrica (S)</label>
					</td>
				</tr>
				
				<tr>
					<td>
						<input type="text" id="txt_intencidade"></input>
					</td>
					<td>
						<input type="text" id="txt_condutancia"></input>
						
					</td>
				</tr>
				
				<tr>
					<td>
						<label>Tensão (V)</label>
					</td>
				</tr>	
				<tr>
					<td>
						<input type="text" id="txt_tensao"></input>
					</td>
					<td>
						<input type="button" value="Limpar" id="btn_limpar"></input>
						<input type="button" value="Calcular" id="btn_calcular" onclick="calcular()"></input>
					</td>
				</tr>
				<tr>
					<td align="right">
						<label id="lbl_ajuda">Ajuda</label>
						<input type="image" src="imagens/btn_ajuda.png" value="Ajuda" id="btn_ajuda" OnClick="submit = 0; Ajuda();
						return false;"></input>
					</td>
				</tr>
			</table>
		</form>
	</body>
	<script type="text/javascript">
		window.onload = function()
		{
			submit = 0;
		}
		
		function calcular()
		{
			submit = 1;
			
			var Intencidade = document.querySelector("#txt_intencidade");
			var Tensao = document.querySelector("#txt_tensao");
			var Condutancia = document.querySelector("#txt_condutancia");
			
			//verificando qual das variáveis está vazia
			if(Condutancia.value == "")
			{	
				Condutancia.value = parseFloat(Intencidade.value)/parseFloat(Tensao.value);
			}			
			else if(Tensao.value == "")
			{
				Tensao.value = parseFloat(Intencidade.value)/parseFloat(Condutancia.value);
			}	
			else if(Intencidade.value == "")
			{
				Intencidade.value = parseFloat(Condutancia.value)*parseFloat(Tensao.value);
			}
			else
			{
				alert("Nenhum valor calculado!");
			}
		}
	</script>
</html>

<?php
	mysql_close($conexao);
?>