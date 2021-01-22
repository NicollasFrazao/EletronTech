var camposCorretos = "000";
var camposCorretos = camposCorretos.split("");
var poten_util = "";
var poten_dis = "";
var poten_tot = "";

var PotUtil = document.querySelector("#txt_potutil");

PotUtil.onfocus = function()
{
	PotUtil.style.border="1px solid blue";
	PotUtil.style.backgroundColor="#edfaff";
	PotUtil.value = PotUtil.value.replace("W", "").trim();
}

function verificarPotUtil()
{
	var valorCampo = PotUtil.value;
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
	 PotUtil.value = valorFiltrado;

    PotUtil.style.border = "1px solid red";
	PotUtil.style.backgroundColor = "#fdf8f8";
	
	if(PotUtil.value == "" ){
		camposCorretos[0] = 0;
	}
	else
	{
		PotUtil.style.border = "1px solid green";
		PotUtil.style.backgroundColor = "#f2fff1";
		txt_potutil.value = txt_potutil.value + " W";
		camposCorretos[0] = 1;
	}
}

PotUtil.onkeypress = function(e,args)
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
		var valorCampo = PotUtil.value;
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

PotUtil.onblur = function()
{
	verificarPotUtil();
}

//------------------------------------- Potência dissipada
var PotDissipada = document.querySelector("#txt_potdissipada");


PotDissipada.onfocus = function()
{
	PotDissipada.style.border="1px solid blue";
	PotDissipada.style.backgroundColor="#edfaff";
	PotDissipada.value = (PotDissipada.value.replace("W", "").trim());
}

function verificarPotDissipada()
{
	var valorCampo = PotDissipada.value;
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
	PotDissipada.value = valorFiltrado;

	PotDissipada.style.border = "1px solid red";
	PotDissipada.style.backgroundColor = "#fdf8f8";
	if(PotDissipada.value == "" ){
		camposCorretos[1] = 0;
	}else{
		PotDissipada.style.border = "1px solid green";
		PotDissipada.style.backgroundColor = "#f2fff1";
		txt_potdissipada.value = txt_potdissipada.value + " W";
		camposCorretos[1] = 1;
	}
}

PotDissipada.onkeypress = function(e,args)
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
		var valorCampo = PotDissipada.value;
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

PotDissipada.onblur = function()
{
	verificarPotDissipada();
}

//-------------------------------------------Potência Total


var PotTotal = document.querySelector("#txt_pottotal");

PotTotal.onfocus = function()
{
	PotTotal.style.border="1px solid blue";
	PotTotal.style.backgroundColor="#edfaff";
	PotTotal.value = (PotTotal.value.replace("W", "").trim());
}

function verificarPotTotal()

{
	var valorCampo = PotTotal.value;
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
	PotTotal.value = valorFiltrado;

	PotTotal.style.border = "1px solid red";
	PotTotal.style.backgroundColor = "#fdf8f8";
	if(PotTotal.value == "" )
	{
		camposCorretos[2] = 0;
	}
	else
	{
		PotTotal.style.border = "1px solid green";
		PotTotal.style.backgroundColor = "#f2fff1";
		txt_pottotal.value = txt_pottotal.value + " W";
		camposCorretos[2] = 1;
	}
}

PotTotal.onkeypress = function(e,args)
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
		var valorCampo = PotTotal.value;
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

PotTotal.onblur = function()
{
	verificarPotTotal();
}

//-------------------------------------------Rendimento do Motor


var Rendimento = document.querySelector("#txt_rendimento");

Rendimento.onfocus = function()
{
	Rendimento.style.border="1px solid blue";
	Rendimento.style.backgroundColor="#edfaff";
	Rendimento.value = (Rendimento.value.replace("W", "").trim());
}

function verificarRendimento()

{
	var valorCampo = Rendimento.value;
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
	Rendimento.value = valorFiltrado;

	if(Rendimento.value == "" )
	{
		Rendimento.style.border = "1px solid red";
		Rendimento.style.backgroundColor = "#fdf8f8";
		camposCorretos[3] = 0;
	}
	else
	{
		Rendimento.style.border = "1px solid green";
		Rendimento.style.backgroundColor = "#f2fff1";
		Rendimento.value = Rendimento.value + " W";
		camposCorretos[3] = 1;
	}
}

Rendimento.onkeypress = function(e,args)
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
		var valorCampo = Rendimento.value;
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

Rendimento.onblur = function()
{
	verificarRendimento();
}

function numpont( obj , e )
{
    var tecla = ( window.event ) ? e.keyCode : e.which;
    if ( tecla == 8 || tecla == 0 || tecla == 46)
        return true;
    if (  tecla < 48 || tecla > 57 )
        return false;
}

function Limpar()
{
	txt_pottotal.value = "";
	txt_potdissipada.value = "";
	txt_potutil.value = "";
	txt_rendimento.value= "";
	var limpa_potutil= document.querySelector("#txt_potutil");
	var limpa_potdissipada = document.querySelector("#txt_potdissipada");
	var limpa_pottotal= document.querySelector("#txt_pottotal");
	limpa_pottotal.style.border = "";
	limpa_potdissipada.style.border = "";
	limpa_potutil.style.border = "";
	poten_util ="";
	poten_dis = "";
	poten_tot = "";
	
	return poten_util;
	return poten_dis;
	return poten_tot;
}

function Validar(frm)
{
	verificarPotTotal();
	verificarPotDissipada();
	verificarPotUtil();
	verificarRendimento();
	
	var aux = 0;
	for (cont = 0; cont <= camposCorretos.length - 1; cont = cont + 1)
	{
		aux = aux + parseInt(camposCorretos[cont]);
	}
	if ((PotTotal.value != "" && Rendimento.value != "" && aux == 2) || (aux < 2) || (aux == camposCorretos.length))
	{
		alert("Alguns campos estão inválidos, verifique e tente novamente!\n\n");
		return false;
	}
	else
	{
		Calcular();
	}
}