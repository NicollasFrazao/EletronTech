<?php
	include "php/Conexao.php";
	
	session_start();
	
	$codigoFerramenta = mysql_escape_string($_GET['codigoFerramenta']);
	$codigoUsuario	= $_SESSION['EletronTech']['codigo'];
	
	include "php/Utilizacao.php";
	
	$query_Busca = "select ds_ajuda from tb_ferramenta where cd_ferramenta = '$codigoFerramenta'";
	$result_Busca = mysql_query($query_Busca) or die(mysql_error());
	$linha_Busca = mysql_fetch_assoc($result_Busca);
	
	$ajuda = $linha_Busca['ds_ajuda'];
	$titulo = 'Área e Perímetro';
?>

<html>
	<head>
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" type="text/css" href="css/css.css">
	</head>
	<body>
		<div id="all">
			<?php include "Menu.php"; ?>
			<div id="et_tool">
				<table width="100%">					
					<tr width="100%">
						<td width="100%">
							<label class="lbl_title">Comprimento (m)</label>						
							<input type="text" class="txt_value" id="txt_comprimento" title="Comprimento(m)" maxlength="10" unidade="m" inteiro="false">
						</td>
					</tr>
					
					<tr width="100%">
						<td width="100%">
							<label class="lbl_title">Largura (m)</label>						
							<input type="text" class="txt_value" id="txt_largura" title="Largura(m)" maxlength="10" unidade="m" inteiro="false">
						</td>
					</tr>
					
					<tr width="100%">
						<td width="100%">
							<label class="lbl_title">Área (m²)</label>						
							<input type="text" class="txt_result" id="txt_area" title="Área(m²)" disabled >
						</td>
					</tr>
					
					<tr width="100%">
						<td width="100%">
							<label class="lbl_title">Perímetro (m)</label>						
							<input type="text" class="txt_result" id="txt_perimetro" title="Perímetro(m)"disabled>
						</td>
					</tr>
				</table>
			</div>
			<div id="et_bottombar">				
				<input type="button" value="Calcular" id="btn_calcular" onclick="if (this.value == 'Calcular') {Validar(this, '== 2');} else {Limpar(this);}">
			</div>
		</div>
		<div id="help">
			<div id="help_box">
				<label id="txt_help"><?php echo $ajuda; ?></label>
				<input type="button" id="btn_hout" value="OK" onclick="help_out()">
			</div>
		</div>
		
		<div id="error">
			<div id="error_box">
				<label id="txt_error">Por favor, preencha todos os campos corretamente!</label>
				<input type="button" id="btn_eout" value="OK" onclick="error_out()">
			</div>
		</div>
	</body>
	<script type="text/javascript" src="script/Área e Perímetro - Cálculo.js"></script>
	<script type="text/javascript" src="script/Validação - Ferramentas.js"></script>
	<script>
		function help_in()
		{
			help.style.display = "inline-block";
		}
		
		function help_out()
		{
			help.style.display = "none";
		}
		
		function error_in()
		{
			error.style.display = "inline-block";
			txt_area.value = null;
			txt_perimetro.value = null;
		}
		
		function error_out()
		{
			error.style.display = "none";
		}
	</script>
</html>