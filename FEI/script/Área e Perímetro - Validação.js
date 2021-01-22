var camposCorretos = "000";
var camposCorretos = camposCorretos.split("");

var campoLargura = document.querySelector("#txt_largura");

campoLargura.onfocus = function()
{
	campoLargura.style.border = "1px solid blue";
	campoLargura.style.backgroundColor = "#edfaff";
	campoLargura.value = campoLargura.value.replace("m","").trim();
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
	
	if (campoLargura.value != "")
	{
		campoLargura.style.border = "1px solid green";
		campoLargura.style.backgroundColor = "#f2fff1";
		camposCorretos[0] = 1;
		campoLargura.value = campoLargura.value + " m";
	}
	else
	{
		campoLargura.style.border = "1px solid red";
		campoLargura.style.backgroundColor = "#fdf8f8";
		camposCorretos[0] = 0;
	}
}
			  
campoLargura.onblur = function()
{
	verificarLargura();
}

var campoComprimento = document.querySelector("#txt_comprimento");

campoComprimento.onfocus = function()
{
	campoComprimento.style.border = "1px solid blue";
	campoComprimento.style.backgroundColor = "#edfaff";
	campoComprimento.value = campoComprimento.value.replace("m","").trim();
}

campoComprimento.onkeypress = function(e,args)
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
		var valorCampo = campoComprimento.value;
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
	
	if (campoComprimento.value != "")
	{
		campoComprimento.style.border = "1px solid green";
		campoComprimento.style.backgroundColor = "#f2fff1";
		camposCorretos[1] = 1;
		campoComprimento.value = campoComprimento.value + " m";
	}
	else
	{
		campoComprimento.style.border = "1px solid red";
		campoComprimento.style.backgroundColor = "#fdf8f8";
		camposCorretos[1] = 0;
	}
}

campoComprimento.onblur = function()
{
	verificarComprimento();
}			 

var campoCalculo = document.querySelector("#cmb_calculo");

campoCalculo.onfocus = function()
{
	campoCalculo.style.border = "1px solid blue";
	campoCalculo.style.backgroundColor = "#edfaff";
}

function verificarCalculo()
{
	if (campoCalculo.value != 0)
	{
		campoCalculo.style.border = "1px solid green";
		campoCalculo.style.backgroundColor = "#f2fff1";
		camposCorretos[2] = 1;
	}
	else
	{
		campoCalculo.style.border = "1px solid red";
		campoCalculo.style.backgroundColor = "#fdf8f8";
		camposCorretos[2] = 0;
	}
}

campoCalculo.onblur = function()
{
	verificarCalculo();
}

campoCalculo.onchange = function()
{
	verificarCalculo();
}

function LimparBorda()
{
	campoLargura.style.border = "";
	campoComprimento.style.border = "";
	campoCalculo.style.border = "";
	for(cont = 0; cont <= camposCorretos.length - 1; cont = cont + 1)
	{
		camposCorretos[cont] = 0;
	}
}

function Validar(frm)
{
	verificarLargura();
	verificarComprimento();
	verificarCalculo();
	
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
		calcular();
	}
}

function Zerar()
{
	var frm = document.querySelector("#Frm_Dados");
	frm.reset();
}

function Ajuda()
{
	alert("Inserindo os valores de Largura (m) e Comprimento (m), é possível selecionar e calcular os resultados de Área (m²) ou Perímetro(m).");
}
//OnSubmit="Validar(this); return false;"

