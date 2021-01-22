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
		<title>Área e Perímetro</title>
		<style type="text/css">
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
						<input type="text" id="txt_largura" maxLength="7" ></input>
					</td>
					<td>
						<select id="cmb_calculo" >
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
						<input type="text" id="txt_comprimento" maxLength="7" ></input>
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
		<div id="ethelpcima">
			<div id="ethelp">
				<input type="image" align="right"  id="etclose" src="imagens/close.png" value="Fechar"></input>
				<table>	
					<br/>
					<br/>
					<tr>
						<td align="center">
							<label>Ajuda</label>
						</td>
					</tr>
					<tr>
						<td >
							<p id="texto">"<?php echo $linha_Busca['ds_ajuda']; ?>"</p>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<script type="text/javascript" src="script/Área e Perímetro - Validação.js"></script>
		<script type="text/javascript" src="script/Área e Perímetro - Cálculo.js"></script>
		<script>
			function Ajuda()
			{
				ethelp.style.display = "inline-block";
				ethelpcima.style.display = "inline-block";
				txt_largura.onblur = function(){};
			}
			
			ethelpcima.onclick = function()
			{
				ethelp.style.display = "none";
				ethelpcima.style.display = "none";
				
			}
			
			etclose.mousehover = function()
			{
				etclose.style.cursor = "hand";
			}
			
			etclose.mouseout = function()
			{
				etclose.style.cursor = "default";
			}
						
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