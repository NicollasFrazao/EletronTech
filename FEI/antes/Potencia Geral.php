<?php
	include "php/Conexao.php";
	
	session_start();
	
	$codigoFerramenta = mysql_escape_string($_GET['codigoFerramenta']);
	$codigoUsuario	= $_SESSION['EletronTech']['codigo'];
	
	include "php/Utilizacao.php";
?>

<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<title>Capacitância Elétrica</title>
		<style type="text/css">
		@import url("css/FEI_CSS3.css");
		
		#fases
		{
			margin-left: -110px;
		}
		
		#sistemaFornecimento
		{
			margin-left:10px;
			background-color: #10376d;
			padding: 10px;
			margin-bottom: 15px;
		}
		
		#sistemaFornecimento input
		{
			margin:0;
			margin-left: -100px;
			margin-right: -90px;
			
		}
		
		#tri
		{
			margin-left: -180px;
		}
		
		#sisFor
		{
			display: inline-block;
			font-weight: bold;
			font-size: 18px;
			padding-top:10px;
			padding-bottom: 5px;
		}
		
		h1
		{
			margin-top: -40px;
		}
		
		form
		{
			margin-left: 20px;
			margin-left: -260px;
		}
		</style>
	</head>
	<body>
		<form id="Frm_Dados" onsubmit="if (submit == 0) {return false;}">
			<table>
				<h1>Potência Geral</h1>
				</br>
				<div id="fornecimento">
				<tr>
				
					<td colspan="2">
						<label id="sisFor">Sistema de Fornecimento de Energia</label>
						</br>
						<div id="sistemaFornecimento">
							<label>Monofásico</label>
							<input type="radio" name="fase" value="1" onclick="fases('1')" checked="true">
							<label>Bifásico</label>
							<input type="radio" name="fase" value="2" onclick="fases('2')">
							<label>Trifásico</label>
							<input type="radio" name="fase" value="3" onclick="fases('3')">
						</div>
					</td>
				
				</tr>
				</div>
				<tr>
					<td>
					</td>
				</tr>
				
				<tr>
					<td>
						<label>Corrente Elétrica (A)</label>
					</td>
					
					<td>
						<label>Potência Ativa (P)</label>
					</td>
				</tr>
				<tr>
					<td>
						<input type="text" id="txt_corrente">
					</td>
					
					<td>						
						<input type="text" id="txt_potenciaAtiva" DISABLED>
					</td>
				</tr>
				
				<tr>
				
					<td>
						<label>Tensão Máxima(V)</label>						
					</td>
					<td>
						<label>Potência Reativa (Q)</label>
					</td>
				</tr>
				<tr>
					<td>
						<input type="text" id="txt_tensao">
					</td>
					<td>
						<input type="text" id="txt_potenciaReativa" DISABLED>
					</td>
				</tr>
				
				<tr>
					<td>
						<label>Fator de Potência</label>
					</td>
					<td>
						<label>Potência Aparente (S)</label>
					</td>
				</tr>
				
				<tr>
					<td>
						<input type="text" id="txt_fatorPotencia">
					</td>
					<td>
						<input type="text" id="txt_potenciaAparente" DISABLED>
					</td>
				</tr>
					<tr>
						<td align="right">
							<label id="lbl_ajuda">Ajuda</label>
							<input type="image" src="imagens/btn_ajuda.png" value="Ajuda" id="btn_ajuda" OnClick="submit = 0; Ajuda(); return false;"></input>
						</td>
						<td>
							<input type="button" value="Limpar" id="btn_limpar" onclick="limpar()">
							<input type="button" value="Calcular" id="btn_calcular" onclick="calcular()">
						</td>
					</tr>
			</table>
		</form>
		<script type="text/javascript">
		window.onload = function()
		{
			fase = 1;
			submit = 0;
		}
		
		function calcular()
		{
			submit = 1;
			
			corrente = parseFloat(txt_corrente.value);
			tensao = parseFloat(txt_tensao.value);
			fp = parseFloat(txt_fatorPotencia.value);
			
			P =	corrente * tensao * fp;
			Q =	corrente * tensao * (1 - fp);
			S = P + Q;
			
			if(fase == 3)
			{
				P = P * 1,73;
				Q = P * 1,73;
				S = P + Q;
			}
			else{}
			
			txt_potenciaAtiva.value = P.toFixed(2);
			txt_potenciaReativa.value = Q.toFixed(2);
			txt_potenciaAparente.value = S.toFixed(2);
		}
		
		function fases(recebe)
		{
			switch(recebe)
			{
				case "1":
					fase = 1;
				break;
				
				case "2":
					fase = 1;
				break;
				case "3":
					fase = 3;
				break;
				default:
					fase = 0;
			}
		}

		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>