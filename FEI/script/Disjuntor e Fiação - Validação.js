var campoCorrente = document.querySelector("#txt_corrente");
var camposCorretos = new Array(4);

campoCorrente.onfocus = function()
{
	campoCorrente.style.border = "1px solid blue";
	campoCorrente.style.backgroundColor = "#edfaff";
	campoCorrente.value = campoCorrente.value.replace("m","").trim();
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

function verificarCampo()
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
		campoCorrente.value = campoCorrente.value + " A";
		camposCorretos[0] = 1;		
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
	verificarCampo();
}

//____________________________________Campo Potencia

var campoPotencia = document.querySelector("#txt_potencia");

campoPotencia.onfocus = function()
{
	campoPotencia.style.border = "1px solid blue";
	campoPotencia.style.backgroundColor = "#edfaff";
	campoPotencia.value = campoPotencia.value.replace("m","").trim();
}

campoPotencia.onkeypress = function(e,args)
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
		var valorCampo = campoPotencia.value;
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

function verificarIntensidade()
{
	var valorCampo = campoPotencia.value;
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
	campoPotencia.value = valorFiltrado;
	
	if (campoPotencia.value != "")
	{
		campoPotencia.style.border = "1px solid green";
		campoPotencia.style.backgroundColor = "#f2fff1";
		campoPotencia.value = campoPotencia.value + " VA";
		camposCorretos[0] = 1;
	}
	else
	{
		campoPotencia.style.border = "1px solid red";
		campoPotencia.style.backgroundColor = "#fdf8f8";
		camposCorretos[0] = 0;
	}
}

//___________Campo Bitola

var campoBitola = document.querySelector("#cmb_bitola");

	campoBitola.onfocus = function()
	{
		campoBitola.style.border = "1px solid blue";
		campoBitola.style.backgroundColor = "#edfaff";
	}

	function verificarBitola()
	{
		if (campoBitola.value != 0)
		{
			campoBitola.style.border = "1px solid green";
			campoBitola.style.backgroundColor = "#f2fff1";
			camposCorretos[0] = 1;
		}
		else
		{
			campoBitola.style.border = "1px solid red";
			campoBitola.style.backgroundColor = "#fdf8f8";
			camposCorretos[0] = 0;
		}
	}

	campoBitola.onblur = function()
	{
		verificarBitola();
	}

	campoBitola.onchange = function()
	{
		verificarBitola();
	}
	
//______________________________Campo Tensão

	var campoTensao = document.querySelector("#cmb_tensao");

	campoTensao.onfocus = function()
	{
		campoTensao.style.border = "1px solid blue";
		campoTensao.style.backgroundColor = "#edfaff";
	}

	function verificarTensao()
	{
		if (campoTensao.value != 0)
		{
			campoTensao.style.border = "1px solid green";
			campoTensao.style.backgroundColor = "#f2fff1";
			camposCorretos[0] = 1;
		}
		else
		{
			campoTensao.style.border = "1px solid red";
			campoTensao.style.backgroundColor = "#fdf8f8";
			camposCorretos[0] = 0;
		}
	}

	campoTensao.onblur = function()
	{
		verificarTensao();
	}

	campoTensao.onchange = function()
	{
		verificarTensao();
	}

campoPotencia.onblur = function()
{
	verificarIntensidade();
}

function Limpar()
{
	campoBitola.disabled = false;
	campoTensao.disabled = false;
	campoPotencia.disabled = false;
	campoCorrente.disabled = false;
}

function Zerar()
{
	var frm = document.querySelector("#Frm_Dados");
	frm.reset();
	Limpar();
}

function LimparBorda()
{
	campoCorrente.style.border = "";
	campoPotencia.style.border = "";
	campoTensao.style.border = "";
	campoBitola.style.border = "";
}


