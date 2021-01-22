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
		<title>Conversor de Grandezas</title>
		<script type="text/javascript" src="script/Conversor de Grandezas - Cálculo.js"></script>
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
						<input type="image" src="imagens/btn_ajuda.png" value="Ajuda" id="btn_ajuda" OnClick="Ajuda(); submit = 0; return false;"></input>
					</td>
					<td>
						<input onclick="LimparBorda()" type="reset" value="Limpar" id="btn_limpar" ></input>
						<input type="button" value="Calcular" id="btn_calcular" onclick="Validar(this)"></input>
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
		<script type="text/javascript" src="script/Conversor de Grandezas - Validação.js"></script>
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