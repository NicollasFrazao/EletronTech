var camposCorretos = new Array(12);

//----------- Data camposCorretos[2]

var campoDatanasFisica = document.querySelector ("#txt_datanas_fisica");
campoDatanasFisica.onfocus = function datanasfoco()
{
	campoDatanasFisica.style.border = "2px solid blue";
}

function mascaraData(valorCampo)
{
	var auxtroca,auxvetor;
	
	if (valorCampo.length == 3 && valorCampo.charAt(2) != '/')
	{
		auxvetor = valorCampo.split("");
		aux = auxvetor[2];
		auxvetor[2] = "/";
		auxvetor[3] = aux;
		
		valorCampo = "";	
		for (cont = 0; cont <= auxvetor.length - 1; cont = cont + 1)
		{
			valorCampo = valorCampo + auxvetor[cont];
		}
	}
	
	if (valorCampo.length == 6 && valorCampo.charAt(5) != '/')
	{
		auxvetor = valorCampo.split("");
		aux = auxvetor[5];
		auxvetor[5] = "/";
		auxvetor[6] = aux;
		
		valorCampo = "";	
		for (cont = 0; cont <= auxvetor.length - 1; cont = cont + 1)
		{
			valorCampo = valorCampo + auxvetor[cont];
		}
	}
	
	if (valorCampo.length == 8 && valorCampo.indexOf('/') == -1)
	{
		auxvetor = "##/##/####";
		auxvetor = auxvetor.split("");
		aux = valorCampo.split("");
		
		auxvetor[0] = aux[0];
		auxvetor[1] = aux[1];
		
		auxvetor[3] = aux[2];
		auxvetor[4] = aux[3];
		
		auxvetor[6] = aux[4];
		auxvetor[7] = aux[5];
		auxvetor[8] = aux[6];
		auxvetor[9] = aux[7];
		
		valorCampo = "";	
		for (cont = 0; cont <= auxvetor.length - 1; cont = cont + 1)
		{
			valorCampo = valorCampo + auxvetor[cont];
		}
	}
	
	return valorCampo;
}

campoDatanasFisica.onkeyup = function()
{
	var valorCampo = campoDatanasFisica.value;
	var valorFiltrado = "";
	var quant = 0;
	
	aux = mascaraData(valorCampo);
	valorCampo = aux;
	
	for (cont = 0; cont <= valorCampo.length - 1; cont = cont + 1)
	{
		if (valorCampo.charAt(cont) >= 0 && valorCampo.charAt(cont) <= 9 && valorCampo.charAt(cont) != " ")
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
		}
		
		if (valorCampo.charAt(cont) == '/' && (cont == 2 || cont == 5))
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
		}
		
		/*if (valorCampo.charAt(cont) == '.')
		{
			quant = quant + 1;
			if (quant <= 2)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
		}*/
		
	}
	campoDatanasFisica.value = valorFiltrado;
}

function verificarDataFisica()
{
	aux = campoDatanasFisica.value;
	aux =  aux.replace('/', "");
	aux =  aux.replace('/', "");
	
	//Ignora essa parte
	if (campoDatanasFisica.value.indexOf("-") == 2 || campoDatanasFisica.value.indexOf("-") == 4)
	{
		var separa = campoDatanasFisica.value.split("-");
		var ano = separa[0];
			ano = parseInt(ano);
		var mes = separa[1];
			mes = parseInt(mes);
		var dia = separa[2];
			dia = parseInt(dia);
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
			if ((bi4 == 0 || bi400 == 0) && bi100 != 0)
			{
				if ((mes == 2 && dia <= 29) || (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 10 || mes == 12 && dia <= 31) || (mes == 4 || mes == 6 || mes == 8 || mes == 9 || mes == 11 && dia <= 30))
				{
					campoDatanasFisica.style.border = "2px solid green";
					//campo[7] = 1;
				}
				else
				{
					campoDatanasFisica.style.border = "2px solid red";
					//campo[7] = 0;
				}
			}
			else
			{
				if ((mes == 2 && dia <= 28) || (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 10 || mes == 12 && dia <= 31) || (mes == 4 || mes == 6 || mes == 8 || mes == 9 || mes == 11 && dia <= 30))
				{
					campoDatanasFisica.style.border = "2px solid green";
					//campo[7] = 1;
				}
				else
				{
					campoDatanasFisica.style.border = "2px solid red";
					//campo[7] = 0;
				}
			}
		}
		else
		{
			campoDatanasFisica.style.border = "2px solid red";
			//campo[7] = 0;
		}
	}
	else //Começa daqui
	{
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
			
			var hoje = new Date();
			var anoAtual = hoje.getFullYear();
			var mesAtual = hoje.getMonth() + 1;
			var diaAtual = hoje.getDate();
			var idade;
			
			if ((mesAtual >= mes) && (diaAtual >= dia))
			{
				idade = anoAtual - ano;
			}
			else
			{
				idade = anoAtual - ano - 1;
			}
			
			if ((dia >= 1 && dia <= 31) && (mes >= 1 && mes <= 12))
			{
				if ((bi4 == 0 || bi400 == 0) && bi100 != 0)
				{
					if (((mes == 2 && dia <= 29) || (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 10 || mes == 12 && dia <= 31) || (mes == 4 || mes == 6 || mes == 8 || mes == 9 || mes == 11 && dia <= 30)) && (idade >= 15 && idade <= 80))
					{
						campoDatanasFisica.style.border = "2px solid green";
						camposCorretos[2] = 1;
					}
					else
					{
						campoDatanasFisica.style.border = "2px solid red";
						camposCorretos[2] = 0;
					}
				}
				else
				{
					if (((mes == 2 && dia <= 28) || (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 10 || mes == 12 && dia <= 31) || (mes == 4 || mes == 6 || mes == 8 || mes == 9 || mes == 11 && dia <= 30)) && (idade >= 15 && idade <= 80))
					{
						campoDatanasFisica.style.border = "2px solid green";
						camposCorretos[2] = 1;
					}
					else
					{
						campoDatanasFisica.style.border = "2px solid red";
						camposCorretos[2] = 0;
					}
				}
			}
			else	
			{
				campoDatanasFisica.style.border = "2px solid red";
				camposCorretos[2] = 0;
			}
		}
		else
		{
			campoDatanasFisica.style.border = "2px solid red";
			camposCorretos[2] = 0;
		}
	}
}
			 
campoDatanasFisica.onblur = function()
{
	verificarDataFisica();
}

/*
var campoDatanasJuridica = document.querySelector ("#txt_datanas_juridica");
campoDatanasJuridica.onfocus = function datanasfoco()
{
	campoDatanasJuridica.style.border = "2px solid blue";
}

campoDatanasJuridica.onkeyup = function()
{
	var valorCampo = campoDatanasJuridica.value;
	var valorFiltrado = "";
	var quant = 0;
	
	aux = mascaraData(valorCampo);
	valorCampo = aux;
	
	for (cont = 0; cont <= valorCampo.length - 1; cont = cont + 1)
	{
		if (valorCampo.charAt(cont) >= 0 && valorCampo.charAt(cont) <= 9 && valorCampo.charAt(cont) != " ")
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
		}
		
		if (valorCampo.charAt(cont) == '/' && (cont == 2 || cont == 5))
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
		}
		
		/*if (valorCampo.charAt(cont) == '.')
		{
			quant = quant + 1;
			if (quant <= 2)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
		}
		
	}
	campoDatanasJuridica.value = valorFiltrado;
}

function datanasvalidjuridica()
{
	aux = campoDatanasJuridica.value;
	aux =  aux.replace('/', "");
	aux =  aux.replace('/', "");
	
	if (campoDatanasJuridica.value.indexOf("-") == 2 || campoDatanasJuridica.value.indexOf("-") == 4)
	{
		var separa = campoDatanasJuridica.value.split("-");
		var ano = separa[0];
			ano = parseInt(ano);
		var mes = separa[1];
			mes = parseInt(mes);
		var dia = separa[2];
			dia = parseInt(dia);
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
			if ((bi4 == 0 || bi400 == 0) && bi100 != 0)
			{
				if ((mes == 2 && dia <= 29) || (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 10 || mes == 12 && dia <= 31) || (mes == 4 || mes == 6 || mes == 8 || mes == 9 || mes == 11 && dia <= 30))
				{
					campoDatanasJuridica.style.border = "2px solid green";
					//campo[7] = 1;
				}
				else
				{
					campoDatanasJuridica.style.border = "2px solid red";
					//campo[7] = 0;
				}
			}
			else
			{
				if ((mes == 2 && dia <= 28) || (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 10 || mes == 12 && dia <= 31) || (mes == 4 || mes == 6 || mes == 8 || mes == 9 || mes == 11 && dia <= 30))
				{
					campoDatanasJuridica.style.border = "2px solid green";
					//campo[7] = 1;
				}
				else
				{
					campoDatanasJuridica.style.border = "2px solid red";
					//campo[7] = 0;
				}
			}
		}
		else
		{
			campoDatanasJuridica.style.border = "2px solid red";
			//campo[7] = 0;
		}
	}
	else
	{
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
				if ((bi4 == 0 || bi400 == 0) && bi100 != 0)
				{
					if ((mes == 2 && dia <= 29) || (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 10 || mes == 12 && dia <= 31) || (mes == 4 || mes == 6 || mes == 8 || mes == 9 || mes == 11 && dia <= 30))
					{
						campoDatanasJuridica.style.border = "2px solid green";
						//campo[7] = 1;
					}
					else
					{
						campoDatanasJuridica.style.border = "2px solid red";
						//campo[7] = 0;
					}
				}
				else
				{
					if ((mes == 2 && dia <= 28) || (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 10 || mes == 12 && dia <= 31) || (mes == 4 || mes == 6 || mes == 8 || mes == 9 || mes == 11 && dia <= 30))
					{
						campoDatanasJuridica.style.border = "2px solid green";
						//campo[7] = 1;
					}
					else
					{
						campoDatanasJuridica.style.border = "2px solid red";
						//campo[7] = 0;
					}
				}
			}
			else	
			{
				campoDatanasJuridica.style.border = "2px solid red";
				//campo[7] = 0;
			}
		}
		else
		{
			campoDatanasJuridica.style.border = "2px solid red";
			//campo[7] = 0;
		}
	}
}
			 
campoDatanasJuridica.onblur = function()
{
	datanasvalidjuridica();
}
*/


function mascaraCPF(valorCampo)
{
	var auxtroca,auxvetor;
	
	if (valorCampo.length == 4 && valorCampo.charAt(3) != '.')
	{
		auxvetor = valorCampo.split("");
		aux = auxvetor[3];
		auxvetor[3] = ".";
		auxvetor[4] = aux;
		
		valorCampo = "";
		for (cont = 0; cont <= auxvetor.length - 1; cont = cont + 1)
		{
			valorCampo = valorCampo + auxvetor[cont];
		}
	}
	
	if (valorCampo.length == 8 && valorCampo.charAt(7) != '.')
	{
		auxvetor = valorCampo.split("");
		aux = auxvetor[7];
		auxvetor[7] = ".";
		auxvetor[8] = aux;
		
		valorCampo = "";
		for (cont = 0; cont <= auxvetor.length - 1; cont = cont + 1)
		{
			valorCampo = valorCampo + auxvetor[cont];
		}
	}
	
	if (valorCampo.length == 12 && valorCampo.charAt(11) != '-')
	{
		auxvetor = valorCampo.split("");
		aux = auxvetor[11];
		auxvetor[11] = "-";
		auxvetor[12] = aux;
		
		valorCampo = "";
		for (cont = 0; cont <= auxvetor.length - 1; cont = cont + 1)
		{
			valorCampo = valorCampo + auxvetor[cont];
		}
	}
	
	if (valorCampo.length == 11 && valorCampo.indexOf('.') == -1 && valorCampo.indexOf('-') == -1)
	{
		auxvetor = "###.###.###-##";
		auxvetor = auxvetor.split("");
		aux = valorCampo.split("");
		
		auxvetor[0] = aux[0];
		auxvetor[1] = aux[1];
		auxvetor[2] = aux[2];
		
		auxvetor[4] = aux[3];
		auxvetor[5] = aux[4];
		auxvetor[6] = aux[5];
		
		auxvetor[8] = aux[6];
		auxvetor[9] = aux[7];
		auxvetor[10] = aux[8];
		
		auxvetor[12] = aux[9];
		auxvetor[13] = aux[10];
			
		valorCampo = "";
		for (cont = 0; cont <= auxvetor.length - 1; cont = cont + 1)
		{
			valorCampo = valorCampo + auxvetor[cont];
		}
	}
		
	return valorCampo;
}


//------- Validação CPF camposCorretos[1]

var campoCPF = document.querySelector("#txt_cpf");
	
function verificarCPF()
{
		
		
	var cpf = document.getElementById("txt_cpf").value;
	xcpf = cpf.replace("-",".");
	vetorcpf = xcpf.split(".");
	
	// Separando por conjuntos
	var conjunto1 = vetorcpf[0];
	var conjunto2 = vetorcpf[1];
	var conjunto3 = vetorcpf[2];
	var conjunto4 = vetorcpf[3];
	
	if (conjunto1 == undefined || conjunto2 == undefined || conjunto3 == undefined || conjunto4 == undefined)
	{
		campoCPF.style.border = "2px solid red";
		camposCorretos[1] = 0;
	}
	else
	{
		// separando os conjuntos em dígitos separados
		vetor_conjunto1 = conjunto1.split("");
		vetor_conjunto2 = conjunto2.split("");
		vetor_conjunto3 = conjunto3.split("");
		vetor_conjunto4 = conjunto4.split("");
		
		 var dig1_conj1 = vetor_conjunto1[0];
		 var dig2_conj1 = vetor_conjunto1[1];
		 var dig3_conj1 = vetor_conjunto1[2];
		 
		 var dig1_conj2 = vetor_conjunto2[0];
		 var dig2_conj2 = vetor_conjunto2[1];
		 var dig3_conj2 = vetor_conjunto2[2];
		 
		 var dig1_conj3 = vetor_conjunto3[0];
		 var dig2_conj3 = vetor_conjunto3[1];
		 var dig3_conj3 = vetor_conjunto3[2];
		 
		 var dig1_conj4 = vetor_conjunto4[0];
		 var dig2_conj4 = vetor_conjunto4[1];
		 
		 // Obtenção primeiro dígito verificador
		 
		var xdig1_conj1 = dig1_conj1 * 10;
		var xdig2_conj1 = dig2_conj1 * 9;
		var xdig3_conj1 = dig3_conj1 * 8;
		
		var xdig1_conj2 = dig1_conj2 * 7;
		var xdig2_conj2 = dig2_conj2 * 6;
		var xdig3_conj2 = dig3_conj2 * 5;
		
		var xdig1_conj3 = dig1_conj3 * 4;
		var xdig2_conj3 = dig2_conj3 * 3;
		var xdig3_conj3 = dig3_conj3 * 2;
		
		var somatorio = xdig1_conj1+xdig2_conj1+xdig3_conj1+xdig1_conj2+xdig2_conj2+xdig3_conj2+xdig1_conj3+xdig2_conj3+xdig3_conj3;
		var resto = somatorio%11;


			if(resto < 2){
				var digito = "0";
			} else{
				var digito=11-resto;
			}

			//------ Segundo Digito
			
			var xxdig1_conj1 = dig1_conj1 * 11;
			var xxdig2_conj1 = dig2_conj1 * 10;
			var xxdig3_conj1 = dig3_conj1 * 9;
			
			var xxdig1_conj2 = dig1_conj2 * 8;
			var xxdig2_conj2 = dig2_conj2 * 7;
			var xxdig3_conj2 = dig3_conj2 * 6;
			
			var xxdig1_conj3 = dig1_conj3 * 5;
			var xxdig2_conj3 = dig2_conj3 * 4;
			var xxdig3_conj3 = dig3_conj3 * 3;
			
			var xxdig1_conj4 = dig1_conj4 * 2;
			
			var somatorio =xxdig1_conj1+xxdig2_conj1+xxdig3_conj1+xxdig1_conj2+xxdig2_conj2+xxdig3_conj2+xxdig1_conj3+xxdig2_conj3+xxdig3_conj3+xxdig1_conj4;
			var xresto = somatorio%11;
							
				if(xresto < 2){
					var xdigito = "0"
				} else {
					var xdigito = 11-xresto;
				}
				
				
				if (digito != dig1_conj4 || xdigito != dig2_conj4){
					campoCPF.style.border = "2px solid red";
					camposCorretos[1] = 0;
				}
				else
				{
					campoCPF.style.border = "2px solid green";
					camposCorretos[1] = 1;
				}
	}
	
	
}
	
campoCPF.onblur = function()
{
	verificarCPF();
}

campoCPF.onfocus = function()
{
	campoCPF.style.border = "2px solid blue";
}

campoCPF.onkeyup = function()
{
	var valorCampo = campoCPF.value;
	var valorFiltrado = "";
	var quant = 0;
	
	aux = mascaraCPF(valorCampo);
	valorCampo = aux;
	
	for (cont = 0; cont <= valorCampo.length - 1; cont = cont + 1)
	{
		if (valorCampo.charAt(cont) >= 0 && valorCampo.charAt(cont) <= 9 && valorCampo.charAt(cont) != " ")
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
		}
		
		if (valorCampo.charAt(cont) == '.' && (cont == 3 || cont == 7))
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(cont);

		}
		
		if (valorCampo.charAt(cont) == '-' && cont == 11)
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
		}
		
		/*if (valorCampo.charAt(cont) == '.')
		{
			quant = quant + 1;
			if (quant <= 2)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
		}*/
		
	}
	campoCPF.value = valorFiltrado;
}

var campoTipoTelefone1Fisica = document.querySelector("#cmb_tipo_tel1_fisica");
var campoTipoTelefone2Fisica = document.querySelector("#cmb_tipo_tel2_fisica");
var campoTelefone1Fisica = document.querySelector("#txt_telefone1_fisica");
var campoTelefone2Fisica = document.querySelector("#txt_telefone2_fisica");

var campoTipoTelefone1Juridica = document.querySelector("#cmb_tipo_tel1_juridica");
var campoTipoTelefone2Juridica = document.querySelector("#cmb_tipo_tel2_juridica");
var campoTelefone1Juridica = document.querySelector("#txt_telefone1_juridica");
var campoTelefone2Juridica = document.querySelector("#txt_telefone2_juridica");

//--------------------- Tipo Telefone 1 Fisica camposCorretos[3]

function verificarTipoTelefone1Fisica()
{
	var tipo1;
	
	tipo1 = campoTipoTelefone1Fisica.value;
	
	if (tipo1 == 0)
	{
		campoTelefone1Fisica.placeholder = "";
		campoTelefone1Fisica.disabled = true;
		campoTelefone1Fisica.value = "";
		verificarTelefone1Fisica();
	}
	
	if (tipo1 == 1)
	{
		campoTelefone1Fisica.placeholder = "(99) 9999-9999";
		campoTelefone1Fisica.maxLength = "14";
		campoTelefone1Fisica.disabled = false;
		verificarTelefone1Fisica();
	}
	if (tipo1 == 2)
	{
		campoTelefone1Fisica.placeholder = "(99) 99999-9999";
		campoTelefone1Fisica.maxLength = "15";
		campoTelefone1Fisica.disabled = false;
		verificarTelefone1Fisica();
	}
	if (tipo1 == 3)
	{
		campoTelefone1Fisica.placeholder = "(99) 9999-9999";
		campoTelefone1Fisica.maxLength = "14";
		campoTelefone1Fisica.disabled = false;
		verificarTelefone1Fisica();
	}

	if (campoTipoTelefone1Fisica.value != 0)
	{
		campoTipoTelefone1Fisica.style.border = "2px solid green";
		camposCorretos[3] = 1;
	}
	else
	{
		campoTipoTelefone1Fisica.style.border = "2px solid red";
		camposCorretos[3] = 0;
	}
}

campoTipoTelefone1Fisica.onchange = function()
{
	verificarTipoTelefone1Fisica();
}

campoTipoTelefone1Fisica.onfocus = function()
{
	campoTipoTelefone1Fisica.style.border = "2px solid blue";
}

campoTipoTelefone1Fisica.onblur = function()
{
	verificarTipoTelefone1Fisica();
}

//------------------Tipo Telefone 2 Fisica camposCorretos[5]

function verificarTipoTelefone2Fisica()
{
	var tipo2;
	
	tipo2 = campoTipoTelefone2Fisica.value;
	
	if (tipo2 == 0)
	{
		campoTelefone2Fisica.placeholder = "";
		campoTelefone2Fisica.disabled = true;
		campoTelefone2Fisica.value = "";
	}
	
	if (tipo2 == 1)
	{
		campoTelefone2Fisica.placeholder = "(99) 9999-9999";
		campoTelefone2Fisica.maxLength = "14";
		campoTelefone2Fisica.disabled = false;
		verificarTelefone2Fisica();
	}
	if (tipo2 == 2)
	{
		campoTelefone2Fisica.placeholder = "(99) 99999-9999";
		campoTelefone2Fisica.maxLength = "15";
		campoTelefone2Fisica.disabled = false;
		verificarTelefone2Fisica();
	}
	if (tipo2 == 3)
	{
		campoTelefone2Fisica.placeholder = "(99) 9999-9999";
		campoTelefone2Fisica.maxLength = "14";
		campoTelefone2Fisica.disabled = false;
		verificarTelefone2Fisica();
	}
	
	if (campoTipoTelefone2Fisica.value != 0)
	{
		campoTipoTelefone2Fisica.style.border = "2px solid green";
		camposCorretos[5] = 1;
	}
	else
	{
		campoTipoTelefone2Fisica.style.border = "";
		campoTelefone2Fisica.style.border = "";
		camposCorretos[5] = 1;
		camposCorretos[6] = 1;
	}
}

campoTipoTelefone2Fisica.onchange = function()
{
	verificarTipoTelefone2Fisica();
}

campoTipoTelefone2Fisica.onfocus = function()
{
	campoTipoTelefone2Fisica.style.border = "2px solid blue";
}

campoTipoTelefone2Fisica.onblur = function()
{
	verificarTipoTelefone2Fisica();
}

//--------------------- Mascara Celular

function mascaraCelular(valorCampo)
{
	var auxtroca,auxvetor;
	
	if (valorCampo.length == 1 && valorCampo.charAt(0) != '(')
	{
		auxvetor = valorCampo.split("");
		aux = auxvetor[0];
		auxvetor[0] = "(";
		auxvetor[1] = aux;
		
		valorCampo = "";
		for (cont = 0; cont <= auxvetor.length - 1; cont = cont + 1)
		{
			valorCampo = valorCampo + auxvetor[cont];
		}
	}
	
	if (valorCampo.length == 4 && valorCampo.charAt(3) != ')')
	{
		auxvetor = valorCampo.split("");
		aux = auxvetor[3];
		auxvetor[3] = ")";
		auxvetor[4] = aux;
		
		valorCampo = "";
		for (cont = 0; cont <= auxvetor.length - 1; cont = cont + 1)
		{
			valorCampo = valorCampo + auxvetor[cont];
		}
	}
	
	if (valorCampo.length == 5 && valorCampo.charAt(4) != " ")
	{
		auxvetor = valorCampo.split("");
		aux = auxvetor[4];
		auxvetor[4] = " ";
		auxvetor[5] = aux;
		
		valorCampo = "";
		for (cont = 0; cont <= auxvetor.length - 1; cont = cont + 1)
		{
			valorCampo = valorCampo + auxvetor[cont];
		}
	}
	
	if (valorCampo.length == 11 && valorCampo.indexOf('(') == -1 && valorCampo.indexOf(')') == -1 && valorCampo.indexOf(" ") == -1 && valorCampo.indexOf('-') == -1)
	{
		auxvetor = "(##) #####-####";
		auxvetor = auxvetor.split("");
		aux = valorCampo.split("");
		
		auxvetor[1] = aux[0];
		auxvetor[2] = aux[1];
		
		auxvetor[5] = aux[2];
		auxvetor[6] = aux[3];
		auxvetor[7] = aux[4];
		auxvetor[8] = aux[5];
		auxvetor[9] = aux[6];
		
		auxvetor[11] = aux[7];
		auxvetor[12] = aux[8];
		auxvetor[13] = aux[9];
		auxvetor[14] = aux[10];
		valorCampo = "";
		for (cont = 0; cont <= auxvetor.length - 1; cont = cont + 1)
		{
			valorCampo = valorCampo + auxvetor[cont];
		}
	}
	else
	{
		if (valorCampo.length == 11 && valorCampo.charAt(10) != '-')
		{
			auxvetor = valorCampo.split("");
			aux = auxvetor[10];
			auxvetor[10] = "-";
			auxvetor[11] = aux;
			
			valorCampo = "";
			for (cont = 0; cont <= auxvetor.length - 1; cont = cont + 1)
			{
				valorCampo = valorCampo + auxvetor[cont];
			}
		}
	}
	
	return valorCampo;
}

//----------------------- Mascara Fixo

function mascaraFixo(valorCampo)
{
	var auxtroca,auxvetor;
	
	if (valorCampo.length == 1 && valorCampo.charAt(0) != '(')
	{
		auxvetor = valorCampo.split("");
		aux = auxvetor[0];
		auxvetor[0] = "(";
		auxvetor[1] = aux;
		
		valorCampo = "";
		for (cont = 0; cont <= auxvetor.length - 1; cont = cont + 1)
		{
			valorCampo = valorCampo + auxvetor[cont];
		}
	}
	
	if (valorCampo.length == 4 && valorCampo.charAt(3) != ')')
	{
		auxvetor = valorCampo.split("");
		aux = auxvetor[3];
		auxvetor[3] = ")";
		auxvetor[4] = aux;
		
		valorCampo = "";
		for (cont = 0; cont <= auxvetor.length - 1; cont = cont + 1)
		{
			valorCampo = valorCampo + auxvetor[cont];
		}
	}
	
	if (valorCampo.length == 5 && valorCampo.charAt(4) != " ")
	{
		auxvetor = valorCampo.split("");
		aux = auxvetor[4];
		auxvetor[4] = " ";
		auxvetor[5] = aux;
		
		valorCampo = "";
		for (cont = 0; cont <= auxvetor.length - 1; cont = cont + 1)
		{
			valorCampo = valorCampo + auxvetor[cont];
		}
	}
	
	if (valorCampo.length == 10 && valorCampo.indexOf('(') == -1 && valorCampo.indexOf(')') == -1 && valorCampo.indexOf(" ") == -1 && valorCampo.indexOf('-') == -1)
	{
		auxvetor = "(##) ####-####";
		auxvetor = auxvetor.split("");
		aux = valorCampo.split("");
		
		auxvetor[1] = aux[0];
		auxvetor[2] = aux[1];
		
		auxvetor[5] = aux[2];
		auxvetor[6] = aux[3];
		auxvetor[7] = aux[4];
		auxvetor[8] = aux[5];
		
		auxvetor[10] = aux[6];
		auxvetor[11] = aux[7];
		auxvetor[12] = aux[8];
		auxvetor[13] = aux[9];
		valorCampo = "";
		for (cont = 0; cont <= auxvetor.length - 1; cont = cont + 1)
		{
			valorCampo = valorCampo + auxvetor[cont];
		}
	}
	else
	{
		if (valorCampo.length == 10 && valorCampo.charAt(9) != '-')
		{
			auxvetor = valorCampo.split("");
			aux = auxvetor[9];
			auxvetor[9] = "-";
			auxvetor[10] = aux;
			
			valorCampo = "";
			for (cont = 0; cont <= auxvetor.length - 1; cont = cont + 1)
			{
				valorCampo = valorCampo + auxvetor[cont];
			}
		}
	}
	
	return valorCampo;
}

//--------------- Telefone 1 Fisica camposCorretos[4]

campoTelefone1Fisica.onfocus = function()
{
	campoTelefone1Fisica.style.border = "2px solid blue";
}

campoTelefone1Fisica.onkeyup = function()
{
	var valorCampo = campoTelefone1Fisica.value;
	var valorFiltrado = "";
	var quant = 0;
	
	if (campoTipoTelefone1Fisica.value == 2)
	{
		aux = mascaraCelular(valorCampo);
		valorCampo = aux;
	}
	else
	{
		aux = mascaraFixo(valorCampo);
		valorCampo = aux;
	}
	
	for (cont = 0; cont <= valorCampo.length - 1; cont = cont + 1)
	{
		if (valorCampo.charAt(cont) >= 0 && valorCampo.charAt(cont) <= 9 && valorCampo.charAt(cont) != " ")
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
		}
		
		if (campoTipoTelefone1Fisica.value == 2)
		{
			if (valorCampo.charAt(cont) == '(' && cont == 0)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
			
			if (valorCampo.charAt(cont) == ')' && cont == 3)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
			
			if (valorCampo.charAt(cont) == " " && cont == 4)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
			
			if (valorCampo.charAt(cont) == "-" && cont == 10)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
		}
		else
		{
			if (valorCampo.charAt(cont) == '(' && cont == 0)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
			
			if (valorCampo.charAt(cont) == ')' && cont == 3)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
			
			if (valorCampo.charAt(cont) == " " && cont == 4)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
			
			if (valorCampo.charAt(cont) == "-" && cont == 9)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
		}
		
		
		/*if (valorCampo.charAt(cont) == '.' && (cont == 3 || cont == 7))
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(cont);

		}
		
		if (valorCampo.charAt(cont) == '-' && cont == 11)
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
		}
		
		/*if (valorCampo.charAt(cont) == '.')
		{
			quant = quant + 1;
			if (quant <= 2)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
		}*/
		
	}
	campoTelefone1Fisica.value = valorFiltrado;
}

function verificarTelefone1Fisica()
{
	aux = campoTelefone1Fisica.value;
	aux =  aux.replace('(', "");
	aux =  aux.replace(')', "");
	aux =  aux.replace(" ", "");
	aux =  aux.replace('-', "");
	
	if (campoTipoTelefone1Fisica.value == 2)
	{
		if (aux.length == 11)
		{
			campoTelefone1Fisica.style.border = "2px solid green";
			camposCorretos[4] = 1;
		}
		else
		{
			campoTelefone1Fisica.style.border = "2px solid red";
			camposCorretos[4] = 0;
		}
	}
	else if (campoTipoTelefone1Fisica.value != 0)
	{
		if (aux.length == 10)
		{
			campoTelefone1Fisica.style.border = "2px solid green";
			camposCorretos[4] = 1;
		}
		else
		{
			campoTelefone1Fisica.style.border = "2px solid red";
			camposCorretos[4] = 0;
		}
	}
	else
	{
		campoTelefone1Fisica.style.border = "2px solid red";
		camposCorretos[4] = 0;
	}
}

campoTelefone1Fisica.onblur = function()
{
	verificarTelefone1Fisica();
}

//----------------- Telefone 2 Fisica camposCorretos[6]

campoTelefone2Fisica.onfocus = function()
{
	campoTelefone2Fisica.style.border = "2px solid blue";
}

campoTelefone2Fisica.onkeyup = function()
{
	var valorCampo = campoTelefone2Fisica.value;
	var valorFiltrado = "";
	var quant = 0;
	
	if (campoTipoTelefone2Fisica.value == 2)
	{
		aux = mascaraCelular(valorCampo);
		valorCampo = aux;
	}
	else
	{
		aux = mascaraFixo(valorCampo);
		valorCampo = aux;
	}
	
	for (cont = 0; cont <= valorCampo.length - 1; cont = cont + 1)
	{
		if (valorCampo.charAt(cont) >= 0 && valorCampo.charAt(cont) <= 9 && valorCampo.charAt(cont) != " ")
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
		}
		
		if (campoTipoTelefone2Fisica.value == 2)
		{
			if (valorCampo.charAt(cont) == '(' && cont == 0)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
			
			if (valorCampo.charAt(cont) == ')' && cont == 3)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
			
			if (valorCampo.charAt(cont) == " " && cont == 4)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
			
			if (valorCampo.charAt(cont) == "-" && cont == 10)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
		}
		else
		{
			if (valorCampo.charAt(cont) == '(' && cont == 0)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
			
			if (valorCampo.charAt(cont) == ')' && cont == 3)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
			
			if (valorCampo.charAt(cont) == " " && cont == 4)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
			
			if (valorCampo.charAt(cont) == "-" && cont == 9)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
		}
		
		
		/*if (valorCampo.charAt(cont) == '.' && (cont == 3 || cont == 7))
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(cont);

		}
		
		if (valorCampo.charAt(cont) == '-' && cont == 11)
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
		}
		
		/*if (valorCampo.charAt(cont) == '.')
		{
			quant = quant + 1;
			if (quant <= 2)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
		}*/
		
	}
	campoTelefone2Fisica.value = valorFiltrado;
}

function verificarTelefone2Fisica()
{
	aux = campoTelefone2Fisica.value;
	aux =  aux.replace('(', "");
	aux =  aux.replace(')', "");
	aux =  aux.replace(" ", "");
	aux =  aux.replace('-', "");
	
	if (campoTipoTelefone2Fisica.value == 2)
	{
		if (aux.length == 11)
		{
			campoTelefone2Fisica.style.border = "2px solid green";
			camposCorretos[6] = 1;
		}
		else
		{
			campoTelefone2Fisica.style.border = "2px solid red";
			camposCorretos[6] = 0;
		}
	}
	else if (campoTipoTelefone2Fisica.value != 0)
	{
		if (aux.length == 10)
		{
			campoTelefone2Fisica.style.border = "2px solid green";
			camposCorretos[6] = 1;
		}
		else
		{
			campoTelefone2Fisica.style.border = "2px solid red";
			camposCorretos[6] = 0;
		}
	}
	else
	{
		campoTelefone2Fisica.style.border = "";
			camposCorretos[6] = 1;
	}
}

campoTelefone2Fisica.onblur = function()
{
	verificarTelefone2Fisica();
}

//---------------- Nome Completo camposCorretos[0]

var campoNomeCompleto = document.querySelector("#txt_nome");

function verificarNomeCompleto()
{
	var tamanho, cont;
	var palavra, copia = "";
	
	campoNomeCompleto.value = campoNomeCompleto.value.trim();
	if (campoNomeCompleto.value != "")
	{
		tamanho = campoNomeCompleto.value.length;
		palavra = campoNomeCompleto.value;
		for (cont = 0; cont <= tamanho - 1; cont = cont + 1)
		{
			if (cont == 0)
			{
				copia = copia + palavra.charAt(cont).toUpperCase();
			}
			else if (palavra.charAt(cont) == " ")
			{
				if (palavra.charAt(cont + 1) != " ")
				{
					copia = copia + " " + palavra.charAt(cont + 1).toUpperCase();
					cont = cont + 1;
				}
			}
			else
			{
				copia = copia + palavra.charAt(cont);
			}
		}
		campoNomeCompleto.value = copia;
		
		if (campoNomeCompleto.value.indexOf(" ") == -1)
		{
			campoNomeCompleto.style.border = "2px solid red";
			camposCorretos[0] = 0;
		}
		else
		{
			campoNomeCompleto.style.border = "2px solid green";
			camposCorretos[0] = 1;
		}
	}
	else
	{
		campoNomeCompleto.style.border = "2px solid red";
		camposCorretos[0] = 0;
	}
}

campoNomeCompleto.onkeypress = function(e,args)
{
	if (document.all) // caso seja IE
	{
		var evt=event.keyCode;
	}			
	else // do contrário deve ser Mozilla ou Google
	{
		var evt = e.charCode;
	}
	
	var valid_chars = 'abcdefghijlmnopqrstuvxzwykçáàâãéèêíìîóòõôúùû QWERTYUIOPASDFGHJKLÇZXCVBNM´`~^'+args;      // criando a lista de teclas permitidas
	var chr= String.fromCharCode(evt);      // pegando a tecla digitada
	
	if (valid_chars.indexOf(chr)>-1 ) // se a tecla estiver na lista de permissão permite-a
	{
		return true;
	}
	
	// para permitir teclas como <BACKSPACE> adicionamos uma permissão para
	// códigos de tecla menores que 09 por exemplo 
	
	if (valid_chars.indexOf(chr)>-1 || evt < 9)
	{
		return true;
	}
	
	return false;   // do contrário nega
}

campoNomeCompleto.onkeyup = function()
{
	var valorCampo = campoNomeCompleto.value;
	var valorFiltrado = "";
	var filtro = "abcdefghijlmnopqrstuvxzwykçáàâãéèêíìîóòõôúùû QWERTYUIOPASDFGHJKLÇZXCVBNM ";
		
	for (cont = 0; cont <= valorCampo.length - 1; cont = cont + 1)
	{
		if (filtro.indexOf(valorCampo.charAt(cont)) != -1)
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
		}
	}
	
	campoNomeCompleto.value = valorFiltrado;
}

campoNomeCompleto.onblur = function()
{
	verificarNomeCompleto();
}

campoNomeCompleto.onfocus = function()
{
	campoNomeCompleto.style.border = "2px solid blue";
}

//--------- Sexo  camposCorretos[7]

var bordaSexo = document.querySelector("#sexo");
var campoSexoMasculino = document.querySelector("#rdb_sexo_marculino");
var campoSexoFeminino = document.querySelector("#rdb_sexo_feminino");

function verificarSexo()
{
	if (campoSexoMasculino.checked == false && campoSexoFeminino.checked == false)
	{
		bordaSexo.style.border = "";
		camposCorretos[7] = 0;
	}
	else
	{
		bordaSexo.style.border = "";
		camposCorretos[7] = 1;
	}
}

campoSexoMasculino.onblur = function()
{
	verificarSexo();
}

campoSexoFeminino.onblur = function()
{
	verificarSexo();
}

campoSexoMasculino.onfocus = function()
{
	bordaSexo.style.border = "";
}

campoSexoFeminino.onfocus = function()
{
	bordaSexo.style.border = "";
}

//--------------------- Email camposCorretos[8]

var campoEmail = document.querySelector("#txt_email");

/* KeyPress
campoEmail.onkeypress = function filtroEmail(e,args)
{              
        if (document.all) // caso seja IE
		{
			var evt=event.keyCode;
		}			
        else // do contrário deve ser Mozilla ou Google
		{
			var evt = e.charCode;
		}
		
        var valid_chars = '0123456789abcdefghijlmnopqrstuvxzwyk-_@.'+args;      // criando a lista de teclas permitidas
        var chr= String.fromCharCode(evt);      // pegando a tecla digitada
        
		if (valid_chars.indexOf(chr)>-1 ) // se a tecla estiver na lista de permissão permite-a
		{
			return true;
		}
		
        // para permitir teclas como <BACKSPACE> adicionamos uma permissão para
        // códigos de tecla menores que 09 por exemplo 
		
        if (valid_chars.indexOf(chr)>-1 || evt < 9)
		{
			return true;
		}
		
        return false;   // do contrário nega
}
*/

campoEmail.onkeyup = function()
{
	var valorCampo = campoEmail.value;
	var valorFiltrado = "";
	var quant = 0;
	var filtro = "1234567890qwertyuiopasdfghjklzxcvbnm";
	var filtroEspecial = "@.-_";
		
	for (cont = 0; cont <= valorCampo.length - 1; cont = cont + 1)
	{
		if (filtro.indexOf(valorCampo.charAt(cont)) != -1)
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
		}
		else
		{
			if (valorCampo.charAt(cont) == '.' && cont != 0 && cont ==valorCampo.length - 1)
			{
				aux = valorCampo.charAt(cont - 1);
				if (filtroEspecial.indexOf(aux) == -1)
				{
					valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
				}
			}
			else if (valorCampo.charAt(cont) == '.')
			{
				if (filtroEspecial.indexOf(valorCampo.charAt(cont - 1)) == -1 && filtroEspecial.indexOf(valorCampo.charAt(cont + 1)) != "")
				{
					valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
				}
				
			}
			
			if (valorCampo.charAt(cont) == '-' && cont != 0 && cont == valorCampo.length - 1)
			{
				aux = valorCampo.charAt(cont - 1);
				if (filtroEspecial.indexOf(aux) == -1 && cont < valorCampo.indexOf("@"))
				{
					valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
				}
			}
			else if (valorCampo.charAt(cont) == '-')
			{
				if (filtroEspecial.indexOf(valorCampo.charAt(cont - 1)) == -1 && filtroEspecial.indexOf(valorCampo.charAt(cont + 1)) != "" && cont < valorCampo.indexOf("@"))
				{
					valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
				}
			}
			
			if (valorCampo.charAt(cont) == '_' && cont != 0 && cont == valorCampo.length - 1)
			{
				aux = valorCampo.charAt(cont - 1);
				if (filtroEspecial.indexOf(aux) == -1 && cont < valorCampo.indexOf("@"))
				{
					valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
				}
			}
			else if (valorCampo.charAt(cont) == '_')
			{
				if (filtroEspecial.indexOf(valorCampo.charAt(cont - 1)) == -1 && filtroEspecial.indexOf(valorCampo.charAt(cont + 1)) != "" && cont < valorCampo.indexOf("@"))
				{
					valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
				}
			}
			
			if (valorCampo.charAt(cont) == '@' && cont != 0)
			{
				quant = quant + 1;
				if (quant == 1)
				{
					valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
				}
			}
			
		}
	}
	
	campoEmail.value = valorFiltrado;
}

function verificarEmail()
{
	if (campoEmail.value.lastIndexOf(".") == campoEmail.value.length - 1)
	{
		aux = campoEmail.value.split("");
		aux[campoEmail.value.length - 1] = "";
		outraaux = "";
		
		for (cont = 0; cont <= campoEmail.value.length - 1; cont = cont +1)
		{
			outraaux = outraaux + aux[cont];
		}
		
		campoEmail.value = outraaux;
	}
	
	if (campoEmail.value.indexOf("@") != -1)
	{
		var aux = campoEmail.value.split("@");
		var usuario = aux[0];
		var dominio = aux[1];
		
		if ((usuario.length >= 1) && 
			(dominio.length >= 3) && 
			(dominio.indexOf(".") != -1) &&
			(dominio.indexOf(".") >= 1) &&
			(dominio.lastIndexOf(".") < dominio.length - 1))
		{
			campoEmail.style.border = "2px solid green";
			camposCorretos[8] = 1;
		}
		else
		{
			campoEmail.style.border = "2px solid red";
			camposCorretos[8] = 0;
		}
	}
	else
	{
		campoEmail.style.border = "2px solid red";
		camposCorretos[8] = 0;
	}
}

campoEmail.onblur = function()
{
	verificarEmail();
}

campoEmail.onfocus = function()
{
	campoEmail.style.border = "2px solid blue";
}

//---------------- Senha camposCorretos[10]

var campoSenha = document.querySelector("#txt_senha");

campoSenha.onfocus = function()
{
	campoSenha.style.border = "2px solid blue";
}

campoSenha.onkeypress = function(e,args)
{
	if (document.all) // caso seja IE
		{
			var evt=event.keyCode;
		}			
        else // do contrário deve ser Mozilla ou Google
		{
			var evt = e.charCode;
		}
		
        var valid_chars = "0123456789abcdefghijlmnopqrstuvxzwykçÇsQWERTYUIOPASDFGHJKLZXCVBNM´`~!@#$%^&*()_\"'-+={}[]\\|:;<>,.?/" + args;      // criando a lista de teclas permitidas
        var chr= String.fromCharCode(evt);      // pegando a tecla digitada
        
		if (valid_chars.indexOf(chr)>-1 ) // se a tecla estiver na lista de permissão permite-a
		{
			return true;
		}
		
        // para permitir teclas como <BACKSPACE> adicionamos uma permissão para
        // códigos de tecla menores que 09 por exemplo 
		
        if (valid_chars.indexOf(chr)>-1 || evt < 9)
		{
			return true;
		}
		
        return false;   // do contrário nega
}

campoSenha.onkeyup = function()
{
	var valorCampo = campoSenha.value;
	var valorFiltrado = "";
	var quant = 0;
	var filtro = "0123456789abcdefghijlmnopqrstuvxzwykçÇsQWERTYUIOPASDFGHJKLZXCVBNM´`~!@#$%^&*()_\"'-+={}[]\\|:;<>,.?/";
		
	for (cont = 0; cont <= valorCampo.length - 1; cont = cont + 1)
	{
		if (filtro.indexOf(valorCampo.charAt(cont)) != -1)
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
		}
	}
	
	campoSenha.value = valorFiltrado;
}

function verificarSenha()
{
	if (campoSenha.value.length >=6 && campoSenha.value.length <= 12)
	{
		campoSenha.style.border = "2px solid green";
		camposCorretos[10] = 1;
	}
	else if (campoSenha.value == "")
	{
		campoSenha.style.border = "";
		camposCorretos[10] = 1;
	}
	else
	{
		campoSenha.style.border = "2px solid red";
		camposCorretos[10] = 0;
	}
}

campoSenha.onblur = function()
{
	verificarSenha();
}

//---------------- Confirma Senha camposCorretos[11]

var campoConfirmaSenha = document.querySelector("#txt_conf_senha");

campoConfirmaSenha.onfocus = function()
{
	campoConfirmaSenha.style.border = "2px solid blue";
}

campoConfirmaSenha.onkeypress = function(e,args)
{
	if (document.all) // caso seja IE
		{
			var evt=event.keyCode;
		}			
        else // do contrário deve ser Mozilla ou Google
		{
			var evt = e.charCode;
		}
		
        var valid_chars = "0123456789abcdefghijlmnopqrstuvxzwykçÇsQWERTYUIOPASDFGHJKLZXCVBNM´`~!@#$%^&*()_\"'-+={}[]\\|:;<>,.?/" + args;      // criando a lista de teclas permitidas
        var chr= String.fromCharCode(evt);      // pegando a tecla digitada
        
		if (valid_chars.indexOf(chr)>-1 ) // se a tecla estiver na lista de permissão permite-a
		{
			return true;
		}
		
        // para permitir teclas como <BACKSPACE> adicionamos uma permissão para
        // códigos de tecla menores que 09 por exemplo 
		
        if (valid_chars.indexOf(chr)>-1 || evt < 9)
		{
			return true;
		}
		
        return false;   // do contrário nega
}

campoConfirmaSenha.onkeyup = function()
{
	var valorCampo = campoConfirmaSenha.value;
	var valorFiltrado = "";
	var quant = 0;
	var filtro = "0123456789abcdefghijlmnopqrstuvxzwykçÇsQWERTYUIOPASDFGHJKLZXCVBNM´`~!@#$%^&*()_\"'-+={}[]\\|:;<>,.?/";
		
	for (cont = 0; cont <= valorCampo.length - 1; cont = cont + 1)
	{
		if (filtro.indexOf(valorCampo.charAt(cont)) != -1)
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
		}
	}
	
	campoConfirmaSenha.value = valorFiltrado;
}

function verificarConfirmaSenha()
{
	if (campoConfirmaSenha.value == campoSenha.value && campoSenha.value != "")
	{
		campoConfirmaSenha.style.border = "2px solid green";
		camposCorretos[11] = 1;
	}
	else if (campoSenha.value == "")
	{
		campoConfirmaSenha.style.border = "";
		camposCorretos[11] = 1;
	}
	else
	{
		campoConfirmaSenha.style.border = "2px solid red";
		camposCorretos[11] = 0;
	}
}

campoConfirmaSenha.onblur = function()
{
	verificarConfirmaSenha();
}

//----------- Limpar

function Zerar()
{
	var frm = document.querySelector("#Frm_Fisica");
	frm.reset();
}

function LimparBorda()
{
	campoNomeCompleto.style.border = "";
	campoCPF.style.border = "";
	campoTipoTelefone1Fisica.style.border = "";
	campoTipoTelefone2Fisica.style.border = "";
	campoTelefone1Fisica.style.border = "";
	campoTelefone2Fisica.style.border = "";
	campoDatanasFisica.style.border = "";
	bordaSexo.style.border = "";
	campoEmail.style.border = "";
	campoSenha.style.border = "";
	campoConfirmaSenha.style.border = "";
	
	for(cont = 0; cont <= camposCorretos.length - 1; cont = cont + 1)
	{
		camposCorretos[cont] = 0;
	}
}

//------------------- Enviar Dados

function Validar(frm)
{
	verificarNomeCompleto();
	verificarCPF();
	verificarTipoTelefone1Fisica();
	verificarTelefone1Fisica();
	verificarTipoTelefone2Fisica();
	verificarTelefone2Fisica();
	verificarDataFisica();
	verificarSexo();
	verificarEmail();
	verificarSenhaAntiga();
	verificarSenha();
	verificarConfirmaSenha();
	
	var aux = 0;
	for (cont = 0; cont <= camposCorretos.length - 1; cont = cont + 1)
	{
		aux = aux + parseInt(camposCorretos[cont]);
	}
	
	if (aux != camposCorretos.length)
	{
		alert("Alguns campos estão inválidos, verifique e tente novamente!\n\n");
		return false;
	}
	else
	{
		var frm = document.querySelector("#Frm_Fisica");
		frm.submit();
	}
}

//----------------- Nível da Senha

txt_senha.onkeyup = function()
{
	force = 1;
	valor = txt_senha.value;
	if(valor.length > 5)
	{
		if( valor.indexOf("!") == -1 &&
			valor.indexOf("#") == -1 &&
			valor.indexOf("@") == -1 &&
			valor.indexOf("$") == -1 &&
			valor.indexOf("%") == -1 &&
			valor.indexOf("&") == -1 &&
			valor.indexOf("*") == -1 &&
			valor.indexOf("(") == -1 &&
			valor.indexOf(")") == -1 &&
			valor.indexOf("<") == -1 &&
			valor.indexOf(">") == -1 &&
			valor.indexOf("?") == -1 &&
			valor.indexOf("/") == -1)
		{
			
		}
		else
		{
			force++;
		}
		
		if( valor.indexOf("0") == -1 &&
			valor.indexOf("1") == -1 &&
			valor.indexOf("2") == -1 &&
			valor.indexOf("3") == -1 &&
			valor.indexOf("4") == -1 &&
			valor.indexOf("5") == -1 &&
			valor.indexOf("6") == -1 &&
			valor.indexOf("7") == -1 &&
			valor.indexOf("8") == -1 &&
			valor.indexOf("9") == -1)
		{
			
		}
		else
		{
			force++;
		}
		
		if(valor.length > 10)
		{
			force++;
		}
		else{}
		
		switch(force)
		{
			
			case 1:
				npass.innerHTML = "Fraca";
				npass.style.color="red";
			break;
			case 2:
				npass.innerHTML = "Razoável";
				npass.style.color="white";
			break;
			case 3:
				npass.innerHTML = "Média";
				npass.style.color="blue";
			break;
			case 4:
				npass.innerHTML = "Forte";
				npass.style.color="green";
			break;
			default:
				npass.innerHTML = "";
		}
	}
	else
	{
		npass.innerHTML = "";
	}
}

function Mascara()
{
	var valorCampo = campoCPF.value;
		
	aux = mascaraCPF(valorCampo);
	valorCampo = aux;
	campoCPF.value = valorCampo
	
	valorCampo = campoDatanasFisica.value;
	
	aux = mascaraData(valorCampo);
	valorCampo = aux;
	campoDatanasFisica.value = valorCampo;
	
	valorCampo = campoTelefone1Fisica.value;
	
	if (campoTipoTelefone1Fisica.value == 2)
	{
		aux = mascaraCelular(valorCampo);
		valorCampo = aux;
	}
	else
	{
		aux = mascaraFixo(valorCampo);
		valorCampo = aux;
	}
	
	campoTelefone1Fisica.value = valorCampo;
	
	valorCampo = campoTelefone2Fisica.value;
	
	if (campoTipoTelefone2Fisica.value == 2)
	{
		aux = mascaraCelular(valorCampo);
		valorCampo = aux;
	}
	else
	{
		aux = mascaraFixo(valorCampo);
		valorCampo = aux;
	}
	
	campoTelefone2Fisica.value = valorCampo;
}

//------------------- Senha Antiga camposCorretos[9]

var campoSenhaAntiga = document.querySelector("#txt_senha_antiga");
var campoSenhaAntigaBanco = document.querySelector("#txt_senha_antiga_banco");

campoSenhaAntiga.onfocus = function()
{
	campoSenhaAntiga.style.border = "3px solid blue";
}

function verificarSenhaAntiga()
{
	if (campoSenhaAntiga.value == campoSenhaAntigaBanco.value)
	{
		campoSenhaAntiga.style.border = "3px solid green";
		camposCorretos[9] = 1;
	}
	else
	{
		campoSenhaAntiga.style.border = "3px solid red";
		camposCorretos[9] = 0;
	}
}

campoSenhaAntiga.onblur = function()
{
	verificarSenhaAntiga();
}


