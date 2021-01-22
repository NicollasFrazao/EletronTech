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
		<title>Rendimento do Motor</title>
		<script type="text/javascript" src="script/Rendimento de Motor - Cálculo.js"></script>
		<style>
		@import url("css/FEI_CSS.css");
		</style>
	</head>
	<body>
		<form>
			<table>
				<h1>Rendimento de Motor</h1>
				</br></br></br>
				<tr>
					<td>
						<label>Potência Útil</label>
					</td>
					<td>
						<label>Potência Dissipada</label>
					</td>
				</tr>
				
				<tr>
					<td>
						<input type="text" id="txt_potutil" required></input>
					</td>
					<td>
						<input type="text" id="txt_potdissipada" ></input>
					</td>
				</tr>
				<tr>
					<td>
						<label>Potência Total</label>
					</td>
					<td>
						<label>Rendimento do Motor</label>
					</td>
				</tr>	
				<tr>
					<td>
						<input type="text" id="txt_pottotal" required></input>
					</td>
					<td>
						<input type="text" id="txt_rendimento" disabled></input>
					</td>
				</tr>
				<tr>
					<td align="right">
						<label id="lbl_ajuda">Ajuda</label>
						<input type="image" src="imagens/btn_ajuda.png" value="Ajuda" id="btn_ajuda" OnClick="Ajuda(); return false;"></input>
					</td>
					<td>
						<input type="button" value="Limpar" id="btn_limpar" onClick="Limpar();"></input>
						<input type="button" value="Calcular" id="btn_calcular" onclick="calcular();"></input>
					</td>
				</tr>
			</table>
		</form>
		<script type="text/javascript" src="script/Rendimento de Motor - Validação.js"></script>
		<script>
			function Ajuda()
			{
			
			}
		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>