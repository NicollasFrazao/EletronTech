<?php
	//Esse é o código pra usar o db_eletrontech
	session_start(); //Ativa Sessão
	
	include "Conexao.php";
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	
	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );

	date_default_timezone_set( 'America/Sao_Paulo' );
	//Termina aqui
	
	if((!isset ($_SESSION['EletronTech']['login']) == true) and (!isset ($_SESSION['EletronTech']['senha']) == true)) 
	{ 
		unset($_SESSION['EletronTech']); 
		header('location:../Login.php'); 
	}//Verificar sessão
	
	$codigoUsuario = $_SESSION['EletronTech']['codigo']; //Isso que eu falei sobre sessão
	$nmUsuario = $_SESSION['EletronTech']['login'];
?>

<!doctype html>
 <html>
	<head>
		<meta charset="utf-8" />
		<title>Agenda Eletron tech</title> 		
		<!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />-->
		<!--<link rel="stylesheet" type="text/css" href="estilo.css">-->
		<!--<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
		<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>-->
		<style>
			*
			{
				margin:0;
				padding: 0;
				font-family: century Gothic;
			}
			
			h1
			{
				font-weight: normal;
				font-size:26px;
				color: white;
				margin-top:5px;
			}
			
			#agenda
			{
				display:inline-block;
				width: 100%;
				height: 100%;
			}
			
			form
			{
				width: 100%;
			}
			
			#agenda table
			{
				display:inline-block;
				width: 70%;
				margin: 10%;
			}
			
			#evento
			{
				display:inline-block;
				width:230px;
				padding: 2px;
				font-size: 14px;
			}
			
			#data
			{
				display:inline-block;
				width:230px;
				font-size: 14px;
				padding: 2px;
			}
			
			#agenda textarea
			{
				width: 230px;
				height: 100px;				
				resize: none;
				padding: 5px;
				border: 0px;
				font-family: Century Gothic;
			}
			
			#btnCancel, #btnConfirma
			{
				display: inline-block;
				width: 100%;
				height: 25px;
				font-family: Century Gothic;
				font-size: 12px;
				background-color: #0b61b0;
				color: white;
				border: 0px;
			}
			
			#agenda img
			{
				display: inline-block;
				height: 25px;
				position: absolute;
				background-color: #2da0e5;
			}

			#agenda label
			{
				display: inline-block;
				color: white;
				font-size: 14px;
			}

			#ui-datepicker-div
			{
				transform: scale(0.8);				
				margin-left: -35px;
				margin-top:180px;
			}
		</style>
	</head>
	
	<body>

	<div id="agenda">
		<form id="Frm_Dados" method="POST" action="code.php">
			<table>
				<tr>
					<td colspan="2"  align="left">
						<h1>Novo Evento</h1><br>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<label>Evento</label>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="text" id="evento" name="evento"/>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<label>Data</label>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="date" id="data" name="data" />
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<label>Descrição</label>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<textarea name="descricao" rows="10" cols="40" id="dss"></textarea>
					</td>
				</tr>
				
				<tr>
					<td>
						<input id="btnCancel" type="reset" onclick="Limpar()" value="  Limpar  " >
					</td>
					<td>
						<input id="btnConfirma" type="button" value="Agendar" onclick="Validar();">
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<label id="ds_erro"></label>
					</td>
				</tr>
			</table>
		</form>
	</div>
		<script>
			/*$(function() {
				$("#data").datepicker({
					showOn: "button",
					buttonImage: "../imagens/calendario.png",
					buttonImageOnly: true,
					dateFormat: 'dd/mm/yy',
				});
			});*/
			
			camposCorretos = new Array(3);
			
			function VerificarEvento()
			{
				if (evento.value == "")
				{
					evento.style.border = "1px solid red";
					camposCorretos[0] = 0;
				}
				else
				{
					evento.style.border = "";
					camposCorretos[0] = 1;
				}
			}
			
			function VerificarData()
			{
				/*barra = 0;
				
				for (cont = 0; cont <= data.value.length - 1; cont = cont + 1)
				{
					if (data.value.charAt(cont) == "/")
					{
						barra = barra + 1;
					}
				}
				
				if (data.value == "")
				{
					data.style.border = "1px solid red";
					camposCorretos[1] = 0;
				}
				else if (barra != 2)
				{
					data.style.border = "1px solid red";
					camposCorretos[1] = 0;
				}
				else if (data.value.length != 10)
				{
					data.style.border = "1px solid red";
					camposCorretos[1] = 0;
				}
				else
				{
					data.style.border = "";
					camposCorretos[1] = 1;
				}*/
				
				if (data.value != "")
				{
					var dataEvento = data.value;
					dataEvento = dataEvento.split('-');
					dataEvento = dataEvento[2] + '/' + dataEvento[1] + '/' + dataEvento[0];
					
					aux = dataEvento;
					aux =  aux.replace('/', "");
					aux =  aux.replace('/', "");
					
					if (aux.indexOf("-") == -1 && aux.length == 8)
					{
						var separa = aux;
							separa = separa.split("",8);
						var dia = separa[0] + separa[1];
							dia = parseInt(dia);
						var mes = separa[2] + separa[3];
							mes = parseInt(mes);
						var ano = separa[4] + separa[5] + separa[6] + separa[7];
							ano = parseInt(ano);
						var bi4 = ano;
							bi4 = bi4%4;
							bi4 = parseInt(bi4);
						var bi400 = ano;
							bi400 = bi400%400;
							bi400 = parseInt(bi400);
						var bi100 = ano;
							bi100 = bi100%100;
							bi100 = parseInt(bi100);
						
						if ((dia >= 1 && dia <= 31) && (mes >= 1 && mes <= 12))
						{
							if (((bi4 == 0 && bi100 != 0) || (bi100 == 0 && bi400 == 0)))
							{
								if (((mes == 2 && dia <= 29) || (mes == 1 || mes == 3 || mes == 5 || mes == 7 ||  mes == 8 || mes == 10 || mes == 12 && dia <= 31) || (mes == 4 || mes == 6 || mes == 9 || mes == 11 && dia <= 30)))
								{
									data.style.border = "1px solid green";
									camposCorretos[1] = 1;
								}
								else
								{
									data.style.border = "1px solid red";
									camposCorretos[1] = 0;
								}
							}
							else
							{
								if (((mes == 2 && dia <= 28) || (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 8 ||  mes == 10 || mes == 12 && dia <= 31) || (mes == 4 || mes == 6 ||mes == 9 || mes == 11 && dia <= 30)))
								{
									data.style.border = "1px solid green";
									camposCorretos[1] = 1;
								}
								else
								{
									data.style.border = "1px solid red";
									camposCorretos[1] = 0;
								}
							}
						}
						else	
						{
							data.style.border = "1px solid red";
							camposCorretos[1] = 0;
						}
					}
					else
					{
						campoDatanasFisica.style.border = "1px solid red";
						camposCorretos[1] = 0;
					}
				}
				else
				{
					data.style.border = "1px solid red";
					camposCorretos[1] = 0;
				}
			}
			
			function VerificarDescricao()
			{
				if (dss.value == "")
				{
					dss.style.border = "1px solid red";
					camposCorretos[2] = 0;
				}
				else
				{
					dss.style.border = "";
					camposCorretos[2] = 1;
				}
			}
			
			evento.onblur = function()
			{
				VerificarEvento();
			}
			
			dss.onblur = function()
			{
				VerificarDescricao();
			}
			
			function Validar()
			{
				VerificarEvento();
				VerificarData();
				VerificarDescricao();
				
				var aux = 0;
				for (cont = 0; cont <= camposCorretos.length - 1; cont = cont + 1)
				{
					aux = aux + parseInt(camposCorretos[cont]);
				}
				if (aux != camposCorretos.length)
				{
					//alert("Alguns campos estão inválidos, verifique e tente novamente!\n\n");
					ds_erro.innerHTML = "Alguns campos estão inválidos!";
					ds_erro.style.color = "red";
					return false;
				}
				else
				{
					ds_erro.innerHTML = "";
					Frm_Dados.submit();
				}
			}
			
			function Limpar()
			{
				/*evento.value = "";
				data.value = "";
				dss.value = "";*/
				
				evento.style.border = "";
				data.style.border = "";
				dss.style.border = "";
				
				ds_erro.innerHTML = "";
			}
		</script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>