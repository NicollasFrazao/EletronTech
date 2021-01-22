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
		<title>Área e Perímetro</title>
		<style type="text/css">
		@import url("css/FEI_CSS.css");
		</style>
	</head>
	<body>
		<div id="all">
		<form id="Frm_Dados" onsubmit="if (submit == 0) {return false;}">
			<table>
				<h1>Área e Perímetro</h1>
				</br></br>
				<tr>
					<td>
						<label>Largura (m)</label>
					</td>
					<td>
						<label>Cálculo</label>
					</td>
				</tr>
				
				<tr>
					<td>
						<input type="text" id="txt_largura" maxLength="7" required></input>
					</td>
					<td>
						<select id="cmb_calculo" required>
						  <option value="0">Selecione uma Opção</option>
						  <option value="1">Área</option>
						  <option value="2">Perímetro</option>
						</select>
					</td>
				</tr>
				
				<tr>
					<td>
						<label>Comprimento (m)</label>
					</td>
					<td>
						<label>Resultado</label>
					</td>
				</tr>
				
				<tr>
					<td>
						<input type="text" id="txt_comprimento" maxLength="7" required></input>
					</td>
					<td>
						<input type="text" id="txt_resultado" DISABLED></input>
					</td>
				</tr>
				
				<tr>
					<td align="right">
						<label id="lbl_ajuda">Ajuda</label>
						<input type="image" src="imagens/btn_ajuda.png" value="Ajuda" id="btn_ajuda" title="Clique para solicitar ajuda." onclick="Ajuda(); submit = 0; return false;"></input>
					</td>
					<td>
						<input type="reset" value="Limpar" id="btn_limpar" OnClick="LimparBorda()"></input>
						<input type="button" value="Calcular" id="btn_calcular" OnClick="Validar(this)"></input>
					</td>
				</tr>
			</table>
		</form>
		<iframe id="frameCalculo" style="display: none;"></iframe>
		</div>
		<script type="text/javascript" src="script/Área e Perímetro - Validação.js"></script>
		<script type="text/javascript" src="script/Área e Perímetro - Cálculo.js"></script>
		<script>
			window.onload = function()
			{
				submit = 0;
			}
		
			/*function calcular()
			{
				submit = 1;
				
				aux = txt_largura.value;
				var largura = parseFloat(aux).toFixed(2);
				
				aux = txt_comprimento.value;
				var comprimento = parseFloat(aux).toFixed(2);
				
				var tipoCalculo = cmb_calculo.value;
				
				frameCalculo.src = "php/PegaValores.php?cdFerramenta=<?php echo $codigoFerramenta; ?>&largura=" + largura + "&comprimento=" + comprimento + "&calculo=" + tipoCalculo;
 			}*/
			
			Frm_Dados.onkeypress = function(e,args)
			{
				if (e.keyCode == 13)
				{
					btn_calcular.click();
				}
			}
		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>