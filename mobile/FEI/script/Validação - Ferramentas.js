var arrayCampos = document.getElementsByClassName("txt_value");
	arrayCampos = Array.prototype.slice.call(arrayCampos);

var arrayResultados = document.getElementsByClassName("txt_result");
	arrayResultados = Array.prototype.slice.call(arrayResultados);

var camposCorretos = Array(arrayCampos.length);

for (cont = 0; cont <= camposCorretos.length - 1; cont = cont + 1)
{
	camposCorretos[cont] = 0;
	
	arrayCampos[cont].onblur = function()
	{
		OnBlur(this, this.attributes["unidade"].value);
	}
	
	arrayCampos[cont].onfocus = function()
	{
		OnFocus(this, this.attributes["unidade"].value);
	}
	
	arrayCampos[cont].onkeypress = function()
	{
		aux = OnKeyPress(this, event);
		
		if (aux)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

function OnBlur(campo, unidade)
{
	tipoCampo = campo.tagName.toLowerCase();
	index = arrayCampos.indexOf(campo);
	
	if (tipoCampo == "input")
	{
		FiltrarCampo(campo);
		
		if(campo.value == "" || campo.value == ",")
		{
			camposCorretos[index] = 0;
		}
		else
		{
			campo.value = campo.value + " " + unidade;
			camposCorretos[index] = 1;
		}
	}
	else if (tipoCampo == "select")
	{
		if (campo.value == 0 || campo.value == "")
		{
			camposCorretos[index] = 0;
		}
		else
		{
			camposCorretos[index] = 1;
		}
	}
}

function OnFocus(campo, unidade)
{
	tipoCampo = campo.tagName.toLowerCase();
	index = arrayCampos.indexOf(campo);
	
	if (tipoCampo == "input")
	{
		campo.value = (campo.value.replace(unidade,"").trim());
	}
	
	btn_calcular.value = "Calcular";
}

function FiltrarCampo(campo)
{
	var cont = 0;
	var valorCampo = campo.value;
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
	
	campo.value = valorFiltrado;
}

function OnKeyPress(campo, e)
{
	tipoCampo = campo.tagName.toLowerCase();
	index = arrayCampos.indexOf(campo);
	
	if (tipoCampo == "input")
	{
		if (campo.attributes["inteiro"].value == "true")
		{
			if (document.all) // caso seja IE
			{
				var evt=e.keyCode;
			}			
			else // do contrário deve ser Mozilla ou Google
			{
				var evt = e.charCode;
			}
			
			var valid_chars = '1234567890';      // criando a lista de teclas permitidas
			var chr= String.fromCharCode(evt);      // pegando a tecla digitada
			
			if (valid_chars.indexOf(chr)>-1 || evt < 9)
			{
				var valorCampo = campo.value;
				var valorFiltrado = "";
				var quant = 0;
				
				var index = valid_chars.indexOf(chr);
				var tecla = valid_chars.charAt(index);
				
				var tamanho = valorCampo.length;
				
				if (tecla >= 0)
				{
					return true;
				}
			}
		
			return false;   // do contrário nega
		}
		else
		{
			if (document.all) // caso seja IE
			{
				var evt=e.keyCode;
			}			
			else // do contrário deve ser Mozilla ou Google
			{
				var evt = e.charCode;
			}
			
			var valid_chars = '1234567890,';      // criando a lista de teclas permitidas
			var chr= String.fromCharCode(evt);      // pegando a tecla digitada
			
			if (valid_chars.indexOf(chr)>-1 || evt < 9)
			{
				var valorCampo = campo.value;
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
	}
	else
	{
		return false;
	}
}

function Validar(botao, corretos)
{
	var cont;
	
	for (cont = 0; cont <= arrayCampos.length - 1; cont = cont + 1)
	{
		OnBlur(arrayCampos[cont], arrayCampos[cont].attributes["unidade"].value);
	}
	
	var aux = 0;
	
	for (cont = 0; cont <= camposCorretos.length - 1; cont = cont + 1)
	{
		aux = aux + parseInt(camposCorretos[cont]);
	}
	
	if (eval(aux + " " + corretos))
	{
		botao.value = "Limpar";
		Calcular();
	}
	else
	{
		error_in();
	}
}

function Limpar(botao)
{
	var cont = 0;
	
	botao.value = "Calcular";
	
	for (cont = 0; cont <= arrayCampos.length - 1; cont = cont + 1)
	{
		var campo = arrayCampos[cont];
		var tipoCampo = arrayCampos[cont].tagName.toLowerCase();
		
		if (tipoCampo == "input")
		{
			campo.value = "";
		}
		else if (tipoCampo == "select")
		{
			campo.selectedIndex = 0;
		}
		
		camposCorretos[cont] = 0;
	}
	
	for (cont = 0; cont <= arrayResultados.length - 1; cont = cont + 1)
	{
		var campo = arrayResultados[cont];
		var tipoCampo = arrayResultados[cont].tagName.toLowerCase();
		
		if (tipoCampo == "input")
		{
			campo.value = "";
		}
		else if (tipoCampo == "select")
		{
			campo.selectedIndex = 0;
		}
	}
}