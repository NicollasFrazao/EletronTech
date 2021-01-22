var arrayCampos = document.getElementsByClassName("txt_value");
	arrayCampos = Array.prototype.slice.call(arrayCampos);

var arrayResultados = document.getElementsByClassName("txt_result");
	arrayResultados = Array.prototype.slice.call(arrayResultados);

var camposCorretos = Array(arrayCampos.length);

for (cont = 0; cont <= camposCorretos.length - 1; cont = cont + 1)
{
	camposCorretos[cont] = 0;
		
	arrayCampos[cont].onfocus = function()
	{
		OnFocus(this, this.getAttribute('unidade'));
	}

	arrayCampos[cont].onblur = function()
	{
		OnBlur(this, this.getAttribute('unidade'));
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
	
	arrayCampos[cont].oninput = arrayCampos[cont].onkeypress;	
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
			var tipo = campo.getAttribute('tipo');
	
			if (!(tipo == 'bin' || tipo == 'dec' || tipo == 'oct'))
			{
				campo.value = campo.value + " " + unidade;
			}
			
			campo.value = campo.value.trim();
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
		valor = campo.value.split(" ");
		
		if (campo.getAttribute('vFEI') != 0)
		{
			campo.type = 'number';
		}
		
		campo.value = valor[0].replace(',', '.').trim();				
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
		
		if (campo.getAttribute('tipo') == 'hex' && ('ABCDEF').indexOf(valorCampo.charAt(cont).toUpperCase()) != -1)
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
		}
		else if (((campo.type == 'number' && valorCampo.charAt(cont) == '.') || (campo.type == 'text' && valorCampo.charAt(cont) == ',')) && campo.getAttribute('inteiro') == 'false')
		{
			quant = quant + 1;
			if (quant == 1)
			{
				valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
			}
		}
	}
	
	//alert(valorFiltrado);
	var tipo = campo.getAttribute('tipo');
	
	if (!(tipo == 'bin' || tipo == 'dec' || tipo == 'oct'))
	{
		campo.type = 'text';
	}
	
	campo.value = valorFiltrado.replace('.', ',');
}

function OnKeyPress(campo, e)
{
	tipoCampo = campo.tagName.toLowerCase();
	index = arrayCampos.indexOf(campo);
	
	if (tipoCampo == "input")
	{
		var tipo = campo.getAttribute('tipo');
		
		if (tipo == 'bin' || tipo == 'hex' || tipo == 'oct')
		{
			if (document.all) // caso seja IE
			{
				var evt=e.keyCode;
			}			
			else // do contrário deve ser Mozilla ou Google
			{
				var evt = e.charCode;
			}
			
			var valid_chars = '';      // criando a lista de teclas permitidas
			
			if (tipo == 'bin')
			{
				valid_chars = '01';
			}
			else if (tipo == 'hex')
			{
				valid_chars = '0123456789ABCDEFabcdef';
			}
			else if (tipo == 'oct')
			{
				valid_chars = '01234567';
			}
			
			var chr= String.fromCharCode(evt);      // pegando a tecla digitada
			
			if (valid_chars.indexOf(chr) > -1)
			{
				var valorCampo = campo.value;
				var valorFiltrado = "";
				var quant = 0;
				
				var index = valid_chars.indexOf(chr);
				var tecla = valid_chars.charAt(index);
				
				var tamanho = valorCampo.length;
				
				return true;
			}
		
			return false;   // do contrário nega
		}
		else if (campo.getAttribute('inteiro') == "true")
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
		OnBlur(arrayCampos[cont], arrayCampos[cont].getAttribute('unidade'));
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

function Validar(botao, corretos, campo, calculo)
{
	var cont;
	
	for (cont = 0; cont <= arrayCampos.length - 1; cont = cont + 1)
	{
		if (calculo != '')
		{
			if (calculo == arrayCampos[cont].getAttribute('calculo'))
			{
				OnBlur(arrayCampos[cont], arrayCampos[cont].getAttribute('unidade'));
			}
		}
		else
		{
			OnBlur(arrayCampos[cont], arrayCampos[cont].getAttribute('unidade'));
		}
	}
	
	var aux = 0;
	
	for (cont = 0; cont <= camposCorretos.length - 1; cont = cont + 1)
	{
		if (calculo != '')
		{
			if (calculo == arrayCampos[cont].getAttribute('calculo'))
			{
				aux = aux + parseInt(camposCorretos[cont]);
			}
		}
		else
		{
			aux = aux + parseInt(camposCorretos[cont]);
		}
	}
	
	if (eval(aux + " " + corretos))
	{
		botao.value = "Limpar";
		Calcular(campo);
	}
	else
	{
		error_in();
	}
}

function Limpar(botao, calculo)
{
	var cont = 0;
	
	botao.value = "Calcular";
	
	for (cont = 0; cont <= arrayCampos.length - 1; cont = cont + 1)
	{
		var campo = arrayCampos[cont];
		var tipoCampo = arrayCampos[cont].tagName.toLowerCase();
		
		if (tipoCampo == "input")
		{
			if (calculo != '')
			{
				if (calculo == campo.getAttribute('calculo'))
				{
					campo.value = "";
				}
			}
			else
			{
				campo.value = "";
			}
		}
		else if (tipoCampo == "select")
		{
			if (calculo != '')
			{
				if (calculo == campo.getAttribute('calculo'))
				{
					campo.selectedIndex = 0;
				}
			}
			else
			{
				campo.selectedIndex = 0;
			}
		}
		
		camposCorretos[cont] = 0;
	}
	
	for (cont = 0; cont <= arrayResultados.length - 1; cont = cont + 1)
	{
		var campo = arrayResultados[cont];
		var tipoCampo = arrayResultados[cont].tagName.toLowerCase();
		
		if (tipoCampo == "input")
		{
			if (calculo != '')
			{
				if (calculo == campo.getAttribute('calculo'))
				{
					campo.value = "";
				}
			}
			else
			{
				campo.value = "";
			}
		}
		else if (tipoCampo == "select")
		{
			if (calculo != '')
			{
				if (calculo == campo.getAttribute('calculo'))
				{
					campo.selectedIndex = 0;
				}
			}
			else
			{
				campo.selectedIndex = 0;
			}
		}
	}
}