var camposCorretos = "000";
var camposCorretos = camposCorretos.split("");

//------ Corrente Elétrica

var campoCorrente = document.querySelector("#txt_corrente");

campoCorrente.onfocus = function()
{
	campoCorrente.style.border = "1px solid blue";
	campoCorrente.style.backgroundColor = "#edfaff";
	campoCorrente.value = campoCorrente.value.replace("A","").trim();
}

campoCorrente.onkeypress = function(e,args)
{
	if (document.all) // caso seja IE
	{
		var evt=event.keyCode;
	}			
	else // do contrário deve ser Mozilla ou Google
	{
		var evt = e.charCode;
	}
	
	var valid_chars = '1234567890,';      // criando a lista de teclas permitidas
	var chr= String.fromCharCode(evt);      // pegando a tecla digitada
	
	if (valid_chars.indexOf(chr)>-1 || evt < 9)
	{
		var valorCampo = campoCorrente.value;
		var valorFiltrado = "";
		var quant = 0;
		
		var index = valid_chars.indexOf(chr);
		var tecla = valid_chars.charAt(index);
		
		var tamanho = valorCampo.length;
		
		if (tecla == ',')
		{
			if (valorCampo.indexOf(',') == -1)
			{
				return true;
			}
		}
		
		if (tecla >= 0)
		{
			return true;
		}
	}
	
	return false;   // do contrário nega
}


function verificarCorrente()
{
	var valorCampo = campoCorrente.value;
	var valorFiltrado = "";
	var quant = 0;
	for (cont = 0; cont <= valorCampo.length - 1; cont = cont + 1)
	{
		if (valorCampo.charAt(cont) >= 0 && valorCampo.charAt(cont) <= 9 && valorCampo.charAt(cont) != " ")
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
		}
		
		if (valorCampo.charAt(cont) == ',')
		{
			quant = quant + 1;
			if (quant == 1)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
		}
		
	}
	campoCorrente.value = valorFiltrado;
	
	if (campoCorrente.value != "")
	{
		campoCorrente.style.border = "1px solid green";
		campoCorrente.style.backgroundColor = "#f2fff1";
		camposCorretos[0] = 1;
		campoCorrente.value = campoCorrente.value + " A";
	}
	else
	{
		campoCorrente.style.border = "1px solid red";
		campoCorrente.style.backgroundColor = "#fdf8f8";
		camposCorretos[0] = 0;
	}
}
			  
campoCorrente.onblur = function()
{
	verificarCorrente();
}

//------ Tensão Máxima

var campoTensao = document.querySelector("#txt_tensao");

campoTensao.onfocus = function()
{
	campoTensao.style.border = "1px solid blue";
	campoTensao.style.backgroundColor = "#edfaff";
	campoTensao.value = campoTensao.value.replace("V","").trim();
}

campoTensao.onkeypress = function(e,args)
{
	if (document.all) // caso seja IE
	{
		var evt=event.keyCode;
	}			
	else // do contrário deve ser Mozilla ou Google
	{
		var evt = e.charCode;
	}
	
	var valid_chars = '1234567890,';      // criando a lista de teclas permitidas
	var chr= String.fromCharCode(evt);      // pegando a tecla digitada
	
	if (valid_chars.indexOf(chr)>-1 || evt < 9)
	{
		var valorCampo = campoTensao.value;
		var valorFiltrado = "";
		var quant = 0;
		
		var index = valid_chars.indexOf(chr);
		var tecla = valid_chars.charAt(index);
		
		var tamanho = valorCampo.length;
		
		if (tecla == ',')
		{
			if (valorCampo.indexOf(',') == -1)
			{
				return true;
			}
		}
		
		if (tecla >= 0)
		{
			return true;
		}
	}
	
	return false;   // do contrário nega
}


function verificarTensao()
{
	var valorCampo = campoTensao.value;
	var valorFiltrado = "";
	var quant = 0;
	for (cont = 0; cont <= valorCampo.length - 1; cont = cont + 1)
	{
		if (valorCampo.charAt(cont) >= 0 && valorCampo.charAt(cont) <= 9 && valorCampo.charAt(cont) != " ")
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
		}
		
		if (valorCampo.charAt(cont) == ',')
		{
			quant = quant + 1;
			if (quant == 1)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
		}
		
	}
	campoTensao.value = valorFiltrado;
	
	if (campoTensao.value != "")
	{
		campoTensao.style.border = "1px solid green";
		campoTensao.style.backgroundColor = "#f2fff1";
		camposCorretos[1] = 1;
		campoTensao.value = campoTensao.value + " V";
	}
	else
	{
		campoTensao.style.border = "1px solid red";
		campoTensao.style.backgroundColor = "#fdf8f8";
		camposCorretos[1] = 0;
	}
}
			  
campoTensao.onblur = function()
{
	verificarTensao();
}

//------ Fator de Potência

var campoFator = document.querySelector("#txt_fatorPotencia");

campoFator.onfocus = function()
{
	campoFator.style.border = "1px solid blue";
	campoFator.style.backgroundColor = "#edfaff";
}

campoFator.onkeypress = function(e,args)
{
	if (document.all) // caso seja IE
	{
		var evt=event.keyCode;
	}			
	else // do contrário deve ser Mozilla ou Google
	{
		var evt = e.charCode;
	}
	
	var valid_chars = '1234567890,';      // criando a lista de teclas permitidas
	var chr= String.fromCharCode(evt);      // pegando a tecla digitada
	
	if (valid_chars.indexOf(chr)>-1 || evt < 9)
	{
		var valorCampo = campoFator.value;
		var valorFiltrado = "";
		var quant = 0;
		
		var index = valid_chars.indexOf(chr);
		var tecla = valid_chars.charAt(index);
		
		var tamanho = valorCampo.length;
		
		if (tecla == ',')
		{
			if (valorCampo.indexOf(',') == -1)
			{
				return true;
			}
		}
		
		if (tecla >= 0)
		{
			return true;
		}
	}
	
	return false;   // do contrário nega
}


function verificarFator()
{
	var valorCampo = campoFator.value;
	var valorFiltrado = "";
	var quant = 0;
	for (cont = 0; cont <= valorCampo.length - 1; cont = cont + 1)
	{
		if (valorCampo.charAt(cont) >= 0 && valorCampo.charAt(cont) <= 9 && valorCampo.charAt(cont) != " ")
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
		}
		
		if (valorCampo.charAt(cont) == ',')
		{
			quant = quant + 1;
			if (quant == 1)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
		}
		
	}
	campoFator.value = valorFiltrado;
	
	if (campoFator.value != "")
	{
		campoFator.style.border = "1px solid green";
		campoFator.style.backgroundColor = "#f2fff1";
		camposCorretos[2] = 1;
	}
	else
	{
		campoFator.style.border = "1px solid red";
		campoFator.style.backgroundColor = "#fdf8f8";
		camposCorretos[2] = 0;
	}
}
			  
campoFator.onblur = function()
{
	verificarFator();
}

function LimparBorda()
{
	campoFator.style.border = "";
	campoTensao.style.border = "";
	campoCorrente.style.border = "";
	
	for(cont = 0; cont <= camposCorretos.length - 1; cont = cont + 1)
	{
		camposCorretos[cont] = 0;
	}
}

function Validar()
{
	verificarCorrente();
	verificarFator();
	verificarTensao();
	
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
		//frm.submit();
		Calcular();
	}
}

function Zerar()
{
	var frm = document.querySelector("#Frm_Dados");
	frm.reset();
}