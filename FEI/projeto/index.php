<?php
	$codigoFerramenta = $_GET['codigoFerramenta'];
?>

<html>
	<head>
		<meta charset = "UTF-8">
		<title>PROJETO</title>
		<style>		
		*
		{
			margin:0;
			padding:0;
			font-family: Century Gothic;
			
		}
		
		body
		{
			background-color: #00428b;
		}
		
		input, select
		{
			width: 100%;
			padding:5px;
		}
		
		#btn_limpar, #btn_criar
		{
			display: inline-block;
			width: 48.5%;
			height:
			border: 1px solid black;
			background-color: black;
			color: white;
		}
		
		form
		{
			display: inline-block;
			width: 500px;
			height: 400px;
			color: white;
			position: absolute;
			margin-left: -250px;
			margin-top: -200px;
			top: 50%;
			left: 50%;
		}
		
		table
		{
			display: inline-block;
			margin-top: 35px;
		}
		
		label
		{
			color: white;
		}
		</style>
	</head>
	<body>
		<form action="Diagramacao.php?cd=<?php echo base64_encode($codigoFerramenta); ?>" target="_top" method="post" name="projeto"  align="center" id="pjr">
			<table>
				<h1>Diagramação de Projetos</h1>
				<tr>
					<td colspan="2">
						<label>Nome do Projeto</label>
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<input type="text" name="nm_projeto" id="nm_projetoI" required></input>
					</td>
				</tr>


				<tr>
					<td>
						<label>Altura (m)</label>
					</td>
					
					<td>
						<label>Largura (m)</label>
					</td>
				</tr>

				<tr>
					<td>
						<input type="text" name="altura" id="alturaI" required></input>
					</td>
					
					<td>
						<input type="text" name="largura" id="larguraI" required></input>
					</td>
				</tr>

				<tr>
					<td>
						<label>Comprimento (m)</label>
					</td>

					<td>
						<label>Desenvolvimento</label>
					</td>
				</tr>
				
				

				<tr>
					
					<td>
						<input type="text" name="comprimento" id="comprimentoI" required></input>
					</td>
					<td>
						<select name="desenvolvimento" id="desenvolvimentoI"required>
						  <option value="null">Selecione uma Opção</option>
						  <option value="Unifilar">Unifilar</option>
						  <option value="Multifilar">Multifilar</option>
						</select>
					</td>
				</tr>
				
			

				<tr>
					<td colspan="2">
						<label>Sistema de Fornecimento</label>
					</td>
				</tr>
				<tr>
					<td>
						<select name="sistema_fornecimento" id="sistema_fornecimentoI" required>
						  <option value="null">Selecione uma Opção</option>
						  <option value="Automatico">Automatico</option>
						  <option value="Monofasico">Monofasico</option>
						  <option value="Bifasico">Bifasico</option>
						  <option value="Trifasico">Trifasico</option>
						</select>
					</td>
					
					<td>
						<input type="reset" value="Limpar" id="btn_limpar" OnClick="LimparBorda()"></input>
						<input type="button" value="Criar" id="btn_criar"></input>
					</td>
				</tr>
				
			</table>
		</form>
	</body>
	<script>
		
		btn_criar.onclick = function()
		{
			if(nm_projetoI.value == "")
			{
				nm_projetoI.focus();
				nm_projetoI.style.border = "2px solid red";
				nm_projetoI.style.backgroundColor = "#fdf8f8";
				alert("Insira o nome do projeto!");
			}
			else if(alturaI.value == "")
			{
				alturaI.focus();
				alert("Insira a altura do projeto!");
			}
			else if(larguraI.value == "")
			{
				larguraI.focus();
				larguraI.style.border = "2px solid red";
				larguraI.style.backgroundColor = "#fdf8f8";
				alert("Insira a largura do projeto!");
			}
			else if(comprimentoI.value == "")
			{
				comprimentoI.focus();
				comprimentoI.style.border = "2px solid red";
				comprimentoI.style.backgroundColor = "#fdf8f8";
				alert("Insira o comprimento do projeto!");
			}
			else if(desenvolvimentoI.value == "null")
			{
				desenvolvimentoI.focus();
				desenvolvimentoI.style.border = "2px solid red";
				desenvolvimentoI.style.backgroundColor = "#fdf8f8";				
				alert("Selecione uma forma de desenvolvimento!");
			}
			else if(sistema_fornecimentoI.value == "null")
			{
				sistema_fornecimentoI.focus();
				sistema_fornecimentoI.style.border = "2px solid red";
				sistema_fornecimentoI.style.backgroundColor = "#fdf8f8";
				alert("Selecione um sistema de fornecimento!");
			}
			else
			{
				document.getElementById("pjr").submit();
			}
		}
		
		
		larguraI.onblur = function()
		{			
			vLargura = parseFloat(larguraI.value);
			vAltura = parseFloat(alturaI.value);		
			vComprimento = parseFloat(comprimentoI.value);
			
			if(vLargura < 6 || vLargura > 40 || larguraI.value == "")
			{
				larguraI.style.border = "2px solid red";
				larguraI.style.backgroundColor = "#fdf8f8";
			}
			else
			{
				larguraI.style.border = "2px solid green";
				larguraI.style.backgroundColor = "#f2fff1";
			}
		}
		
		comprimentoI.onblur = function()
		{			
			vComprimento = parseFloat(comprimentoI.value);
			
			if(vComprimento < 10 || vComprimento > 80 || comprimentoI.value == "")
			{
				comprimentoI.style.border = "2px solid red";
				comprimentoI.style.backgroundColor = "#fdf8f8";
			}
			else
			{
				comprimentoI.style.border = "2px solid green";
				comprimentoI.style.backgroundColor = "#f2fff1";
			}
		}
		
		alturaI.onblur = function()
		{			
			vAltura = parseFloat(alturaI.value);
			
			if(vAltura < 3 || vAltura > 4.5 || alturaI.value == "")
			{
				alturaI.style.border = "2px solid red";
				alturaI.style.backgroundColor = "#fdf8f8";
			}
			else
			{
				alturaI.style.border = "2px solid green";
				alturaI.style.backgroundColor = "#f2fff1";
			}
		}
		
		nm_projetoI.onblur = function()
		{			
			if(nm_projetoI.value == "")
			{
				nm_projetoI.style.border = "2px solid red";
				nm_projetoI.style.backgroundColor = "#fdf8f8";
			}
			else
			{
				nm_projetoI.style.border = "2px solid green";
				nm_projetoI.style.backgroundColor = "#f2fff1";
			}
		}
		
		desenvolvimentoI.onchange = function()
		{
			des = desenvolvimentoI.value;
			if(des == "null")
			{
				desenvolvimentoI.style.border = "2px solid red";
				desenvolvimentoI.style.backgroundColor = "#fdf8f8";
			}
			else
			{
				desenvolvimentoI.style.border = "2px solid green";
				desenvolvimentoI.style.backgroundColor = "#f2fff1";
			}
		}
		
		sistema_fornecimentoI.onclick = function()
		{
			sis = sistema_fornecimentoI.value;
			if(sis == "null")
			{
				sistema_fornecimentoI.style.border = "2px solid red";
				sistema_fornecimentoI.style.backgroundColor = "#fdf8f8";
			}
			else
			{
				sistema_fornecimentoI.style.border = "2px solid green";
				sistema_fornecimentoI.style.backgroundColor = "#f2fff1";
			}
		}
		
	</script>
</html>