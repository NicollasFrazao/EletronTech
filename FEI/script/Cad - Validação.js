var campoDatanasFisica = document.querySelector ("#txt_datanas_fisica");
campoDatanasFisica.onfocus = function datanasfoco()
{
	campoDatanasFisica.style.border = "3px solid blue";
}

var data = document.querySelector("#txt_datanas_fisica");
data.onkeyup = function()
{
	var valorCampo = campoDatanasFisica.value;
	var valorFiltrado = "";
	for (i = 0; i < valorCampo.length; i++)
	{
		if ((valorCampo.charAt(i) >= 0 || valorCampo.charAt(i) >= 9) && campoDatanasFisica.value.indexOf("-") == -1)
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(i);
		}
	}
	campoDatanasFisica.value = valorFiltrado;
}

function datanasvalidfisica()
{
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
					campoDatanasFisica.style.border = "3px solid green";
					//campo[7] = 1;
				}
				else
				{
					campoDatanasFisica.style.border = "3px solid red";
					//campo[7] = 0;
				}
			}
			else
			{
				if ((mes == 2 && dia <= 28) || (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 10 || mes == 12 && dia <= 31) || (mes == 4 || mes == 6 || mes == 8 || mes == 9 || mes == 11 && dia <= 30))
				{
					campoDatanasFisica.style.border = "3px solid green";
					//campo[7] = 1;
				}
				else
				{
					campoDatanasFisica.style.border = "3px solid red";
					//campo[7] = 0;
				}
			}
		}
		else
		{
			campoDatanasFisica.style.border = "3px solid red";
			//campo[7] = 0;
		}
	}
	else
	{
		if (campoDatanasFisica.value.indexOf("-") == -1 && campoDatanasFisica.value.length == 8)
		{
			var separa = campoDatanasFisica.value;
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
						campoDatanasFisica.style.border = "3px solid green";
						//campo[7] = 1;
					}
					else
					{
						campoDatanasFisica.style.border = "3px solid red";
						//campo[7] = 0;
					}
				}
				else
				{
					if ((mes == 2 && dia <= 28) || (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 10 || mes == 12 && dia <= 31) || (mes == 4 || mes == 6 || mes == 8 || mes == 9 || mes == 11 && dia <= 30))
					{
						campoDatanasFisica.style.border = "3px solid green";
						//campo[7] = 1;
					}
					else
					{
						campoDatanasFisica.style.border = "3px solid red";
						//campo[7] = 0;
					}
				}
			}
			else	
			{
				campoDatanasFisica.style.border = "3px solid red";
				//campo[7] = 0;
			}
		}
		else
		{
			campoDatanasFisica.style.border = "3px solid red";
			//campo[7] = 0;
		}
	}
}
			 
campoDatanasFisica.onblur = function()
{
	datanasvalidfisica();
}

var campoDatanasJuridica = document.querySelector ("#txt_datanas_juridica");
campoDatanasJuridica.onfocus = function datanasfoco()
{
	campoDatanasJuridica.style.border = "3px solid blue";
}

var data = document.querySelector("#txt_datanas_juridica");
data.onkeyup = function()
{
	var valorCampo = campoDatanasJuridica.value;
	var valorFiltrado = "";
	for (i = 0; i < valorCampo.length; i++)
	{
		if ((valorCampo.charAt(i) >= 0 || valorCampo.charAt(i) >= 9) && campoDatanasJuridica.value.indexOf("-") == -1)
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(i);
		}
	}
	campoDatanasJuridica.value = valorFiltrado;
}

function datanasvalidjuridica()
{
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
					campoDatanasJuridica.style.border = "3px solid green";
					//campo[7] = 1;
				}
				else
				{
					campoDatanasJuridica.style.border = "3px solid red";
					//campo[7] = 0;
				}
			}
			else
			{
				if ((mes == 2 && dia <= 28) || (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 10 || mes == 12 && dia <= 31) || (mes == 4 || mes == 6 || mes == 8 || mes == 9 || mes == 11 && dia <= 30))
				{
					campoDatanasJuridica.style.border = "3px solid green";
					//campo[7] = 1;
				}
				else
				{
					campoDatanasJuridica.style.border = "3px solid red";
					//campo[7] = 0;
				}
			}
		}
		else
		{
			campoDatanasJuridica.style.border = "3px solid red";
			//campo[7] = 0;
		}
	}
	else
	{
		if (campoDatanasJuridica.value.indexOf("-") == -1 && campoDatanasJuridica.value.length == 8)
		{
			var separa = campoDatanasJuridica.value;
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
						campoDatanasJuridica.style.border = "3px solid green";
						//campo[7] = 1;
					}
					else
					{
						campoDatanasJuridica.style.border = "3px solid red";
						//campo[7] = 0;
					}
				}
				else
				{
					if ((mes == 2 && dia <= 28) || (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 10 || mes == 12 && dia <= 31) || (mes == 4 || mes == 6 || mes == 8 || mes == 9 || mes == 11 && dia <= 30))
					{
						campoDatanasJuridica.style.border = "3px solid green";
						//campo[7] = 1;
					}
					else
					{
						campoDatanasJuridica.style.border = "3px solid red";
						//campo[7] = 0;
					}
				}
			}
			else	
			{
				campoDatanasJuridica.style.border = "3px solid red";
				//campo[7] = 0;
			}
		}
		else
		{
			campoDatanasJuridica.style.border = "3px solid red";
			//campo[7] = 0;
		}
	}
}
			 
campoDatanasJuridica.onblur = function()
{
	datanasvalidjuridica();
}

//------- Validação CPF
	
	function validar(){
		
		
	var cpf = document.getElementById("txt_cpf").value;
	vetorcpf = cpf.split(".");
	
	// Separando por conjuntos
	var conjunto1 = vetorcpf[0];
	var conjunto2 = vetorcpf[1];
	var conjunto3 = vetorcpf[2];
	var conjunto4 = vetorcpf[3];
	
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
				alert("CPF Inválido");
			}
	}