var camposCorretos = "000";
var camposCorretos = camposCorretos.split("");
var resistencia = "";
var capacitancia = "";
var frequencia = "";

//-------------------------------------------------Campo Resistência
var campoResistencia = document.querySelector("#resistencia_eletrica");


function verificarResistencia()
{
	var valorCampo = campoResistencia.value;
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
	campoResistencia.value = valorFiltrado;
	campoResistencia.style.border = "1px solid red";
	campoResistencia.style.backgroundColor = "#fdf8f8";
	if(campoResistencia.value == "" ){
		camposCorretos[0] = 0;
	}else{
		campoResistencia.style.border = "1px solid green";
		campoResistencia.style.backgroundColor = "#f2fff1";
		resistencia_eletrica.value = resistencia_eletrica.value + " Ω";
		camposCorretos[0] = 1;
	}
}
// ------------------------- Campo Frequencia da Corrente
var campoFrequencia = document.querySelector("#frequencia_corrente");

function verificarFrequencia()
{
	var valorCampo = campoFrequencia.value;
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
	campoFrequencia.value = valorFiltrado;

	campoFrequencia.style.border = "1px solid red";
	campoFrequencia.style.backgroundColor = "#fdf8f8";
	if(campoFrequencia.value == "" ){
		camposCorretos[1] = 0;
	}else{
		campoFrequencia.style.border = "1px solid green";
		campoFrequencia.style.backgroundColor = "#f2fff1";
		frequencia_corrente.value = frequencia_corrente.value + " Hz";
		camposCorretos[1] = 1;
	}
}


//-------------------------------------- Campo Capacitancia Elétrica

var campoCapacitancia = document.querySelector("#capacitancia");

function verificarCapacitancia()
{
	var valorCampo = campoCapacitancia.value;
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
	campoCapacitancia.value = valorFiltrado;

	campoCapacitancia.style.border = "1px solid red";
	campoCapacitancia.style.backgroundColor = "#fdf8f8";
	if(campoCapacitancia.value == "" ){
		camposCorretos[2] = 0;
		ALERT("OI");
	}else{
		campoCapacitancia.style.border = "1px solid green";
		campoCapacitancia.style.backgroundColor = "#f2fff1";
		campoCapacitancia.value = campoCapacitancia.value + " F";
		camposCorretos[2] = 1;
	}
}


function Validar(frm)
{
	verificarResistencia();
	verificarFrequencia();
	verificarCapacitancia();
	
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
		calcular();
	}
}

function Limpar(){
	resistencia_eletrica.value = "";
	capacitancia.value = "";
	frequencia_corrente.value = "";
	resultado.value= "";
	var limpa_resistencia = document.querySelector("#resistencia_eletrica");
	var limpa_frequencia = document.querySelector("#frequencia_corrente");
	var limpa_capacitancia = document.querySelector("#capacitancia");
	limpa_resistencia.style.border = "";
	limpa_frequencia.style.border = "";
	limpa_capacitancia.style.border = "";
	var resistencia = "";
	var capacitancia = "";
	var frequencia = "";
	
	return resistencia;
	return capacitancia;
	return frequencia;
}

campoResistencia.onfocus = function()
{
	campoResistencia.style.border="1px solid blue";
	campoResistencia.style.backgroundColor="#edfaff";
	campoResistencia.value = (campoResistencia.value.replace("Ω", "").trim());
}

campoFrequencia.onfocus = function()
{
	campoFrequencia.style.border="1px solid blue";
	campoFrequencia.style.backgroundColor="#edfaff";
	campoFrequencia.value = (campoFrequencia.value.replace("Hz", "").trim());
}

campoCapacitancia.onfocus = function()
{
	campoCapacitancia.style.border="1px solid blue";
	campoCapacitancia.style.backgroundColor="#edfaff";
	campoCapacitancia.value = (campoCapacitancia.value.replace("F", "").trim());
}

campoResistencia.onblur = function()
{
	verificarResistencia();
}

campoFrequencia.onblur = function()
{
	 verificarFrequencia();
}

campoCapacitancia.onblur = function()
{
	verificarCapacitancia();
}

//-----------Repetição Ponto

campoResistencia.onkeypress = function(e,args)
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
		var valorCampo = campoResistencia.value;
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

campoFrequencia.onkeypress = function(e,args)
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
		var valorCampo = campoFrequencia.value;
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

campoCapacitancia.onkeypress = function(e,args)
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
		var valorCampo = campoCapacitancia.value;
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