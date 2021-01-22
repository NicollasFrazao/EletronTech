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
		<title>Indutância Elétrica</title>
		
		<script type="text/javascript">
			function calcular()
			{
				submit = 1;
				
				var Espirrais = document.querySelector("#txt_espirais");
				var Corrente = document.querySelector("#txt_corrente");
				var Indutancia = document.querySelector("#txt_indutancia");
				
				//verificando qual das variáveis está vazia
				if(Indutancia.value == "")
					{	
						Indutancia.value = parseFloat(Espirrais.value)/parseFloat(Corrente.value);
					}			
				else
				{
					if(Corrente.value == "")
						{
							Corrente.value = parseFloat(Espirrais.value)/parseFloat(Indutancia.value);
						}	
					else
						{
							Espirrais.value = parseFloat(Indutancia.value) * parseFloat(Corrente.value);
						}	
				}
				Indutancia.value+=" H";
				Corrente.value+=" A";
			}
				
		</script>
		<style>
			@import url("css/FEI_CSS.css");
		</style>
	</head>
	<body>
		<form id="Frm_Dados">
			<table>
				<h1>Indutância Elétrica</h1>
				</br></br>
				<tr>
					<td>
						<label>Numero de Espirais</label>
					</td>
					<td>
						<label>Indutância Elétrica</label>
						
					</td>
				</tr>
				
				<tr>
					<td>
						<input type="text" id="txt_espirais"></input>
					</td>
					<td>
						<input type="text" id="txt_indutancia"></input>
					</td>
				</tr>
				
				<tr>
					<td>
						<label>Corrente Elétrica</label>
					</td>
				</tr>	
				<tr>
					<td>
						<input type="text" id="txt_corrente"></input>
					</td>
					<td>
						<input type="button" value="Limpar" id="btn_limpar"></input>
						<input type="button" value="Calcular" id="btn_calcular" onclick="calcular()"></input>
					</td>
				</tr>
				<tr>
						<td align="right">
							<label id="lbl_ajuda">Ajuda</label>
							<input type="image" src="imagens/btn_ajuda.png" value="Ajuda" id="btn_ajuda" OnClick="submit = 0; Ajuda(); return false;"></input>
						</td>
						<td>
						
						</td>
					
				</tr>
			</table>
		</form>
		<script type="text/javascript" src="script/Indutância Elétrica - Validação.js"></script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>