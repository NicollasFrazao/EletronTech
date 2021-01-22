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
		<title>Iluminação Geral</title>
	</head>
	<style>
	@import url("css/FEI_CSS2.css");
	#paletaCores input
	{
		width: 20px;
		height: 20px;
		background-color: black;
		border: 0px;
		color: transparent;
	}
	
	#ambiente
	{
		display: inline-block;
		width: 540px;
		height: 300px;
		background-color: #10376d;
		padding: 15px;
		margin-left: -80px;
	}
	
	#iluminacao
	{
		display: none;
		width: 540px;
		height: 300px;
		background-color: #10376d;
		padding: 15px;
		margin-left: -80px;
	}
	
	#coeficienteReflexao
	{
		display: none;
		width: 540px;
		height: 300px;
		background-color: #10376d;
		padding: 15px;
		margin-left: -80px;
	}
	
	#botoes
	{
		display: inline-block;
		width: 540px;
	}
	
	#btn_reflexao
	{
		margin-right: 46px;
	}
	
	#opts
	{
		position: absolute;
		margin-top: -80px;
		margin-left: -70px;
	}
	
	#lbl_ajuda
	{
		margin-left: 100px;
	}
	
	#btn_ajuda
	{
		margin-left: 150px;
	}
	
	#paletaCores
	{
		
		width: 250px;
		padding: 0px;
		margin-left: 10px;
		padding-top: 10px;
		padding-left: 30px;
		
	}
	
	#resultados
	{
		display: inline-block;
		position:absolute;
		background-color: #10376d;
		margin-top: -333px;
		height:330px;
		width: 380px;
		margin-left: -60px;
	}
	
	h2
	{
		margin-left: 14px;
		margin-top: 10px;
	}
	
	h1
	{
		margin-left: -80px;
		margin-top: -40px;
	}
	
	#resultados label
	{
		font-size: 16px;
	}
	</style>
	<body>
		<div id="all">
		<h1>Iluminação Geral</h1>
		</br>
		<div id="ambiente">
			<form id="Frm_Ambiente">
				<table>
					<tr>
						<td>
							<label>Pé Direito (m)</label>
						</td>
						<td>
							<label>Comprimento</label>
						</td>
					</tr>
					
					<tr>
						<td>
							<input type="text" id="txt_peDireito" required></input>
						</td>
						<td>
							<input type="text" id="txt_comprimento" required></input>
						</td>
					</tr>
					
					<tr>
						<td>
							<label>Largura(m)</label>
						</td>
						<td>
							<label>Iluminância (lx)</label>
						</td>
					</tr>
					
					<tr>
						<td>
							<input type="text" id="txt_largura" required></input>
						</td>
						<td>
							<input type="text" id="txt_iluminancia" required></input>
						</td>
					</tr>
					
					<tr>
						<td>
							<label>Ambiente</label>
						</td>
						<td>
							<label>Manutenção</label>
						</td>
					</tr>
					
					<tr>
						<td>
							<select id="cmb_ambiente" required>
							  <option value="0">Selecione uma Opção</option>
							  <option value="1">Limpo</option>
							  <option value="2">Normal</option>
							  <option value="3">Sujo</option>
							</select>
						</td>
						<td>
							<select id="cmb_manutencao" required>
							  <option value="0">Selecione uma Opção</option>
							  <option value="1">2500h</option>
							  <option value="2">5000h</option>
							  <option value="3">7500h</option>
							</select>
						</td>
					</tr>
					
					<!--<tr>
						<td>
							
						</td>
						<td>
							<input type="button" value="Avançar" id="btn_avancarAmbiente"></input>
						</td>
					</tr>-->
				</table>
			</form>
		</div>
		
		<div id="iluminacao">
			<form id ="Frm_Iluminacao">
				<table>
					<tr>
						<td>
							<label>Sistema de Iluminação</label>
						</td>
						<td>
							<label>Suspensão da Luminária (m)</label>
						</td>
					</tr>
					
					<tr>
						<td>
							<select id="cmb_sistemaIluminacao" required>
							  <option value="0">Selecione uma Opção</option>
							  <option value="1">Direta</option>
							  <option value="2">Difusa</option>
							  <option value="3">Indireta</option>
							  <option value="4">Semi-direta</option>
							  <option value="5">Semi-indireta</option>
							</select>
						</td>
						<td>
							<input type="text" id="txt_suspensaoLuminaria" required disabled value="0"></input>
						</td>
					</tr>
					
					<tr>
						<td>
							<label>Potência (V)</label>
						</td>
						<td>
							<label>Fluxo Luminoso (lm)</label>
						</td>
					</tr>
					
					<tr>
						<td>
							<input type="text" id="txt_potencia" required></input>
						</td>
						<td>
							<input type="text" id="txt_fluxoLuminosoInicial" required></input>
						</td>
					</tr>
					
					<!--<tr>
						<td>
							
						</td>
						<td>
							<input type="button" value="Avançar" id="btn_avancarIluminacao"></input>
						</td>
					</tr>-->
				</table>
			</form>
		</div>
		
		<div id="coeficienteReflexao">
			<form id="Frm_Coeficiente">
				<table>
					<tr>
						<td>
							<label>Plano</label>
						</td>
						<td>
							<label>Plano de Trabalho (m)</label>
						</td>
					</tr>
					
					<tr>
						<td>
							<select id="cmb_plano" required>
							  <option value="0">Selecione uma Opção</option>
							  <option value="1">Teto</option>
							  <option value="2">Paredes</option>
							  <option value="3">Plano de Trabalho</option>
							</select>
						</td>
						<td>
							<input type="text" id="txt_alturaPlanoTrabalho"></input>
						</td>
					</tr>
					
					<tr>
						<td>
							<table id="paletaCores">
								<tr>
									<td>
										<input type="button" value="1" style="background-color:#025a4f">
										<input type="button" value="2" style="background-color:#56b40d">
										<input type="button" value="3" style="background-color:#91b40d">
										<input type="button" value="4" style="background-color:#cdec2d">
										<input type="button" value="5" style="background-color:#fdff00">
									</td>
								</tr>
								
								<tr>
									<td>
										<input type="button" value="1" style="background-color:#722808">
										<input type="button" value="2" style="background-color:#a55a0d">
										<input type="button" value="3" style="background-color:#c98f04">
										<input type="button" value="4" style="background-color:#f4c01e">
										<input type="button" value="5" style="background-color:#ffdc71">
									</td>
								</tr>
								
								<tr>
									<td>
										<input type="button" value="1" style="background-color:#4f4f4e">
										<input type="button" value="2" style="background-color:#7c7b79">
										<input type="button" value="3" style="background-color:#abaaa6">
										<input type="button" value="4" style="background-color:#dbd9d6">
										<input type="button" value="5" style="background-color:#ffffff">
									</td>
								</tr>
								
								<tr>
									<td>
										<input type="button" value="1" style="background-color:#004a9c">
										<input type="button" value="2" style="background-color:#00699c">
										<input type="button" value="3" style="background-color:#0198e1">
										<input type="button" value="4" style="background-color:#6ccfff">
										<input type="button" value="5" style="background-color:#b8e5fb">
									</td>
								</tr>
								
								<tr>
									<td>
										<input type="button" value="1" style="background-color:#c30649">
										<input type="button" value="2" style="background-color:#c51a8a">
										<input type="button" value="3" style="background-color:#d660ae">
										<input type="button" value="4" style="background-color:#e3a5ce">
										<input type="button" value="5" style="background-color:#f2d3e7">
									</td>
								</tr>
							</table>
						</td>
						<td>
							<div id="resReflexao">
								<label id="lbl_teto">Teto</label></br>
								<label id="lbl_parede">Parede</label></br>
								<label id="lbl_planoTrabalho">Plano de Trabalho</label></br>
							</div>
						</td>
						<td>
							
						</td>
					</tr>
				</table>
			</form>
		</div>
		</br>
		
		<div id="botoes">
			<table>
				<tr>
					<td>
						<div id="opts">
						<input type="image" src="imagens/ambiente_1.png" value="Ajuda" id="btn_ambiente" OnClick="Ajuda()"></input>
						<input type="image" src="imagens/iluminacao_1.png" value="Ajuda" id="btn_iluminacao" OnClick="Ajuda()"></input>
						<input type="image" src="imagens/reflexao_1.png" value="Ajuda" id="btn_reflexao" OnClick="Ajuda()"></input>
						</div>
					</td>
					<td>
						<label id="lbl_ajuda">Ajuda</label>
						<input type="image" src="imagens/btn_ajuda.png" value="Ajuda" id="btn_ajuda" OnClick="Ajuda(); return false;"></input>
					</td>
					<td>
						<input type="reset" value="Limpar" id="btn_limpar" onclick="LimparBorda()"></input>
						<input type="button" value="Calcular" id="btn_calcular" onclick="Validar(this)"></input>
					</td>
				</tr>
				<tr>
					<td align="right">
						
					</td>
					<td>
						
					</td>
				</tr>
			</table>
		</div>
		
		<div id="resultados">
			<table>
				<h2>Propriedades</h2>
				</br>
				<tr>
					<td>
						<label>Altura Útil</label>
					</td>
					<td>
						<label id="lbl_alturaUtil"></label>
					</td>
				</tr>
				
				<tr>
					<td>
						<label>Área</label>
					</td>
					<td>
						<label id="lbl_area"></label>
					</td>
				</tr>
				
				<tr>
					<td>
						<label>Coeficiente de Utilização (μ)</label>
					</td>
					<td>
						<label id="lbl_coeficienteUtilizacao"></label>
					</td>
				</tr>
				
				<tr>
					<td>
						<label>Fator de Depreciação</label>
					</td>
					<td>
						<label id="lbl_fatorDepreciacao"></label>
					</td>
				</tr>
				
				<tr>
					<td>
						<label>Fluxo Luminoso Total</label>
					</td>
					<td>
						<label id="lbl_fluxoLuminosoTotal"></label>
					</td>
				</tr>
				
				<tr>
					<td>
						<label>Índice Local</label>
					</td>
					<td>
						<label id="lbl_indiceLocal"></label>
					</td>
				</tr>
				
				<tr>
					<td>
						<label>Número de Pontos de Luz</label>
					</td>
					<td>
						<label id="lbl_numeroPontosLuz"></label>
					</td>
				</tr>
				
				<tr>
					<td>
						<label>Perímetro</label>
					</td>
					<td>
						<label id="lbl_perimetro"></label>
					</td>
				</tr>
				
				<tr>
					<td>
						<label>Potência Total</label>
					</td>
					<td>
						<label id="lbl_potenciaTotal"></label>
					</td>
				</tr>
			</table>
		</div>
		</div>
		<script type="text/javascript" src="script/Iluminação Geral - Validação.js" onload="Zerar();"></script>
		<script type="text/javascript" src="script/Iluminação Geral - Cálculo.js">		
		
			
		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>