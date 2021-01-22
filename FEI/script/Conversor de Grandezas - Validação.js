var camposCorretos = "0000";
	camposCorretos = camposCorretos.split("");
	
var campoCategoria = document.querySelector("#cmb_categoria");

	campoCategoria.onfocus = function()
	{
		campoCategoria.style.border = "1px solid blue";
		campoCategoria.style.backgroundColor = "#edfaff";
	}

	function verificarCategoria()
	{
		if (campoCategoria.value != 0)
		{
			campoCategoria.style.border = "1px solid green";
			campoCategoria.style.backgroundColor = "#f2fff1";
			camposCorretos[0] = 1;
		}
		else
		{
			campoCategoria.style.border = "1px solid red";
			campoCategoria.style.backgroundColor = "#fdf8f8";
			camposCorretos[0] = 0;
		}
	}

	campoCategoria.onblur = function()
	{
		verificarCategoria();
	}

	campoCategoria.onchange = function()
	{
		verificarCategoria();
	}
	
var campoUnidadeInicial = document.querySelector("#cmb_unidadeInicial");
	
	campoUnidadeInicial.onfocus = function()
	{
		campoUnidadeInicial.style.border = "1px solid blue";
		campoUnidadeInicial.style.backgroundColor = "#edfaff";
	}

	function verificarUnidadeInicial()
	{
		if (campoUnidadeInicial.value != 0)
		{
			campoUnidadeInicial.style.border = "1px solid green";
			campoUnidadeInicial.style.backgroundColor = "#f2fff1";
			camposCorretos[1] = 1;
		}
		else
		{
			campoUnidadeInicial.style.border = "1px solid red";
			campoUnidadeFinal.style.backgroundColor = "#fdf8f8";
			camposCorretos[1] = 0;
		}
	}

	campoUnidadeInicial.onblur = function()
	{
		verificarUnidadeInicial();
	}

	campoUnidadeInicial.onchange = function()
	{
		verificarUnidadeInicial();
	}
	
var campoValorInicial = document.querySelector("#txt_valorInicial");

	campoValorInicial.onfocus = function()
	{
		campoValorInicial.style.border = "1px solid blue";
		campoValorInicial.style.backgroundColor = "#edfaff";
	}
	
	campoValorInicial.onkeypress = function(e,args)
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
			var valorCampo = campoValorInicial.value;
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
	
	function verificarValorInicial()
	{
		var valorCampo = campoValorInicial.value;
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
		campoValorInicial.value = valorFiltrado;
		
		if (campoValorInicial.value != "")
		{
			campoValorInicial.style.border = "1px solid green";
			campoValorInicial.style.backgroundColor = "#f2fff1";
			camposCorretos[2] = 1;
		}
		else
		{
			campoValorInicial.style.border = "1px solid red";
			campoValorInicial.style.backgroundColor = "#fdf8f8";
			camposCorretos[2] = 0;
		}
	}
				  
	campoValorInicial.onblur = function()
	{
		verificarValorInicial();
	}
	
var campoUnidadeFinal = document.querySelector("#cmb_unidadeFinal");
	
	campoUnidadeFinal.onfocus = function()
	{
		campoUnidadeFinal.style.border = "1px solid blue";
		campoUnidadeFinal.style.backgroundColor = "#edfaff";
	}

	function verificarUnidadeFinal()
	{
		if (campoUnidadeFinal.value != 0)
		{
			campoUnidadeFinal.style.border = "1px solid green";
			campoUnidadeFinal.style.backgroundColor = "#f2fff1";
			camposCorretos[3] = 1;
		}
		else
		{
			campoUnidadeFinal.style.border = "1px solid red";
			campoUnidadeFinal.style.backgroundColor = "#fdf8f8";
			camposCorretos[3] = 0;
		}
	}

	campoUnidadeFinal.onblur = function()
	{
		verificarUnidadeFinal();
	}

	campoUnidadeFinal.onchange = function()
	{
		verificarUnidadeFinal();
	}
	
function LimparBorda()
{
	campoCategoria.style.border = "";
	campoUnidadeInicial.style.border = "";
	campoValorInicial.style.border = "";
	campoUnidadeFinal.style.border = "";
	for(cont = 0; cont <= camposCorretos.length - 1; cont = cont + 1)
	{
		camposCorretos[cont] = 0;
	}
}

function Validar(frm)
{
	verificarCategoria();
	verificarCategoria();
	verificarUnidadeInicial();
	verificarValorInicial();
	verificarUnidadeFinal();
	
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
		Calc();
	}
}

function Zerar()
{
	var frm = document.querySelector("#Frm_Dados");
	frm.reset();
}

function Ajuda()
{
	alert("Selecionando a categoria de grandezas, é possível realizar cálculos de conversão.\n\nDentre os cálculos estão:\n\nCarga, Condutância, Corrente, Indutância, Potência e Resistência.");
}