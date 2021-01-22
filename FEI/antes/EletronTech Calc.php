<?php
	include "php/Conexao.php";
	
	session_start();
	
	$codigoFerramenta = mysql_escape_string($_GET['codigoFerramenta']);
	$codigoUsuario	= $_SESSION['EletronTech']['codigo'];
	
	include "php/Utilizacao.php";
?>

<html>
	<head>
		<meta charset="UTF-8">
		<title>
			Calculadora
		</title>
	</head>
	<style>
		body
		{
			background-color: transparent;
		}
		
		*
		{
			margin: 0;
			padding: 0;
		}
		
		#calc
		{
			width: 200px;
			position: absolute;
			margin-left: -130px;
			left: 50%;
			top: 50%;
			margin-top: -200px;
			background-color: gray;
		}
		
		#calc #resultado
		{
			width: 100%;
			text-align: right;
			font-size: 18px;
		}
		
		#calc input
		{
			display: inline-block;
			font-size: 18px;
			font-family: Century Gothic;
			width: 60px;
			height: 60px;
			padding: 5px;
			background-color:  #000;
			color: white;
			border: 0px;
		}
		
		#calc #resultado:active
		{
			background-color:  #00428b;
		}
		
		#calc input:active
		{
			background-color: #313131;
		}
		
		
	</style>
	<body>
		<table id="calc">
			<tr>
				<td colspan="4">
					<div id="resultados">
						<input type="text" id="resultado" DISABLED>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<input type="button" value="←" onclick="voltar()"/>
				</td>
				<td>
					<input type="button" value="(" onclick="addCalc('(')"/>
				</td>
				
				<td>
					<input type="button" value=")" onclick="addCalc(')')"/>
				</td>
				
				<td>
					<input type="button" value="C" onclick="limpar()"/>
				</td>
			</tr>
			<tr>
				<td>
					<input type="button" value="1" onclick="addCalc('1')"/>
				</td>
				<td>
					<input type="button" value="2" onclick="addCalc('2')"/>
				</td>
				<td>
					<input type="button" value="3" onclick="addCalc('3')"/>
				</td>
				<td>
					<input type="button" value="+" onclick="addCalc('+')"/>
				</td>
			</tr>
			
			<tr>
				<td>
					<input type="button" value="4" onclick="addCalc('4')"/>
				</td>
				<td>
					<input type="button" value="5" onclick="addCalc('5')"/>
				</td>
				<td>
					<input type="button" value="6" onclick="addCalc('6')"/>
				</td>
				<td>
					<input type="button" value="-" onclick="addCalc('-')"/>
				</td>
			</tr>
			
			<tr>
				<td>
					<input type="button" value="7" onclick="addCalc('7')"/>
				</td>
				<td>
					<input type="button" value="8" onclick="addCalc('8')"/>
				</td>
				<td>
					<input type="button" value="9" onclick="addCalc('9')"/>
				</td>
				<td>
					<input type="button" value="X" onclick="addCalc('*')"/>
				</td>
			</tr>
			
			<tr>
				<td>
					<input type="button" value="." onclick="addCalc('.')"/>
				</td>
				<td>
					<input type="button" value="0" onclick="addCalc('0')"/>
				</td>
				<td>
					<input type="button" value="=" onclick="calcular()"/>
				</td>
				<td>
					<input type="button" value="/" onclick="addCalc('/')"/>
				</td>
			</tr>
		</table>
	</body>
	<script>
		function addCalc(digito)
		{
			if(digito == ")")
			{	
				if(resultado.value.indexOf("(") != -1)
				{
					resultado.value=resultado.value+digito;
				}
				else{}
			}
			else if(digito == "+" || digito == "-" || digito == "*" || digito == "/")
			{
				entrada = resultado.value;
				tam = entrada.split("");
				r = tam.length;
				k = r-1;
				if(tam[k] == "+" || tam[k] == "-" || tam[k] == "*" || tam[k] == "/")
				{
					saida="";
					for(i=0; i<k; i++)
					{
						saida = saida+""+tam[i];
					}
					saida = saida + digito;
					resultado.value=saida;
				}
				else
				{
					resultado.value=resultado.value+digito;
				}
				
			}
			else if(digito != "(" && digito != ")" && digito != "+" && digito != "-" && digito != "*" && digito != "/")
			{
				entrada = resultado.value;
				tam = entrada.split("");
				r = tam.length;
				k = r-1;
				if(tam[k] == ")")
				{
					resultado.value= resultado.value+"*"+digito;
				}
				else
				{
					resultado.value=resultado.value+digito;
				}
			}
			else if (digito == "(")
			{
				
				entrada = resultado.value;
				tam = entrada.split("");
				r = tam.length;
				k = r-1;
				if(k < 0)
				{
					resultado.value=resultado.value+digito;
				}
				else
				{
					if(tam[k] == "+" || tam[k] == "-" || tam[k] == "*" || tam[k] == "/")
					{
						resultado.value=resultado.value+digito;
					}
					else if(tam[k] == "(")
					{
					}
					else
					{
						resultado.value=resultado.value+"*"+digito;
					}
				}
			}
			else
			{
				resultado.value=resultado.value+digito;
			}
		}
		
		function calcular()
		{
			conta = "result = "+resultado.value;
			eval(conta);
			resultado.value = result;
		}
		
		function limpar()
		{
			resultado.value="";
		}
		
		function voltar()
		{
			entrada = resultado.value;
			tam = entrada.split("");
			r = tam.length;
			saida="";
			for(i=0; i<r-1; i++)
			{
				saida = saida + tam[i];
			}
			resultado.value = saida;
			
		}
	</script>
</html>

<?php
	mysql_close($conexao);
?>