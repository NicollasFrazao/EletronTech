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

<html>
	<head>
		<meta charset = "UTF-8">
		<title>Rendimento do Motor</title>
		<script type="text/javascript" src="script/Rendimento de Motor - Cálculo.js"></script>
		<style>
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
		<form>
			<table>
				<h1>Rendimento de Motor</h1>
				</br></br></br>
				<tr>
					<td>
						<label>Potência Útil (W)</label>
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
						<input type="text" id="txt_rendimento"></input>
					</td>
				</tr>
				<tr>
					<td align="right">
						<label id="lbl_ajuda">Ajuda</label>
						<input type="image" src="imagens/btn_ajuda.png" value="Ajuda" id="btn_ajuda" OnClick="Ajuda(); return false;"></input>
					</td>
					<td>
						<input type="button" value="Limpar" id="btn_limpar" onClick="Limpar();"></input>
						<input type="button" value="Calcular" id="btn_calcular" onclick="Validar();"></input>
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
						<td>
							<p id="texto">"<?php echo $linha_Busca['ds_ajuda']; ?>"</p>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<script type="text/javascript" src="script/Rendimento de Motor - Validação.js"></script>
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