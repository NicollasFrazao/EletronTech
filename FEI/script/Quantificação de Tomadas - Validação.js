var camposCorretos = "000";
var camposCorretos = camposCorretos.split("");
var largura = "";
var comprimento = "";

var campoLargura = document.querySelector("#txt_largura");

campoLargura.onfocus = function()
{
	campoLargura.style.border = "1px solid blue";
	campoLargura.style.backgroundColor = "#edfaff";
	campoLargura.value = (campoLargura.value.replace("m","").trim());
}

campoLargura.onkeypress = function(e,args)
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
		var valorCampo = campoLargura.value;
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

function verificarLargura()
{
	var valorCampo = campoLargura.value;
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
	campoLargura.value = valorFiltrado;

	campoLargura.style.border = "1px solid red";
	campoLargura.style.backgroundColor = "#fdf8f8";
	
	if(campoLargura.value == "" )
	{
		camposCorretos[0] = 0;
	}
	else
	{
		campoLargura.style.border = "1px solid green";
		campoLargura.style.backgroundColor = "#f2fff1";
		campoLargura.value = campoLargura.value + " m";
		camposCorretos[0] = 1;
	}
}
			  
campoLargura.onblur = function()
{
	verificarLargura();
}

//------------------------- Comprimento


var campoComprimento = document.querySelector("#txt_comprimento");

campoComprimento.onfocus = function()
{
	campoComprimento.style.border = "1px solid blue";
	campoComprimento.style.backgroundColor = "#edfaff";
	campoComprimento.value = (campoComprimento.value.replace("m","").trim());
}

function verificarComprimento()
{
	var valorCampo = campoComprimento.value;
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
	campoComprimento.value = valorFiltrado;

	campoComprimento.style.border = "1px solid red";
	campoComprimento.style.backgroundColor = "#fdf8f8";
	
	if (campoComprimento.value == "" )
	{
		camposCorretos[1] = 0;
	}
	else
	{
		campoComprimento.style.border = "1px solid green";
		campoComprimento.style.backgroundColor = "#f2fff1";
		txt_comprimento.value = txt_comprimento.value + " m";
		camposCorretos[1] = 1;
	}	
}

campoComprimento.onblur = function()
{
	verificarComprimento();
}			 


var campoComodo = document.querySelector("#cmb_comodo");

campoComodo.onfocus = function()
{
	campoComodo.style.border = "1px solid blue";
	campoComodo.style.backgroundColor = "#edfaff";
}

function verificarComodo()
{
	if (campoComodo.value != 0)
	{
		campoComodo.style.border = "1px solid green";
		campoComodo.style.backgroundColor = "#f2fff1";
		camposCorretos[2] = 1;
	}
	else
	{
		campoComodo.style.border = "1px solid red";
		campoComodo.style.backgroundColor = "#fdf8f8";
		camposCorretos[2] = 0;
	}
}

campoComodo.onblur = function()
{
	verificarComodo();
}

campoComodo.onchange = function()
{
	verificarComodo();
}

function LimparBorda()
{
	txt_largura.value = "";
	txt_comprimento.value = "";

	var limpa_largura = document.querySelector("#txt_largura");
	var limpa_comprimento = document.querySelector("#txt_comprimento");
	limpa_comprimento.style.border = "";
	limpa_largura.style.border = "";
	campoComodo.style.border = "";
	largura = "";
	comprimento = "";
	for(cont = 0; cont <= camposCorretos.length - 1; cont = cont + 1)
	{
		camposCorretos[cont] = 0;
	}
	return largura;
	return comprimento;
}

function Validar(frm)
{
	verificarLargura();
	verificarComprimento();
	verificarComodo();
	
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

function Ajuda()
{
	alert("Apartir da seleção do cômodo e da inserção da Largura(m) e Comprimento(m), são calculados os valores de quantidade de tomadas, potência por tomada e potência total, para o ambiente.");
}
//OnSubmit="Validar(this); return false;"

function numpont( obj , e )
{
    var tecla = ( window.event ) ? e.keyCode : e.which;
    if ( tecla == 8 || tecla == 0 || tecla == 46)
        return true;
    if (  tecla < 48 || tecla > 57 )
        return false;
}