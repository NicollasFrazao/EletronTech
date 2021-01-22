var camposCorretos = "000";
var camposCorretos = camposCorretos.split("");

var  campoIntensidade = document.querySelector("#txt_intencidade");
var campoTensao = document.querySelector("#txt_tensao");
var campoCondutancia = document.querySelector("#txt_condutancia");

//-------- Condutância

campoCondutancia.onfocus = function()
{
	campoCondutancia.style.border = "1px solid blue";
	campoCondutancia.style.backgroundColor = "#edfaff";
	campoCondutancia.value = campoCondutancia.value.replace("A","").trim();
}

campoCondutancia.onkeypress = function(e,args)
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
		var valorCampo = campoCondutancia.value;
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

function verificarCondutancia()
{
	var valorCampo = campoCondutancia.value;
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
	campoCondutancia.value = valorFiltrado;
	
	if (campoCondutancia.value != "")
	{
		campoCondutancia.style.border = "1px solid green";
		campoCondutancia.style.backgroundColor = "#f2fff1";
		camposCorretos[0] = 1;
		campoCondutancia.value = campoCondutancia.value + " A";
	}
	else
	{
		campoCondutancia.style.border = "1px solid red";
		campoCondutancia.style.backgroundColor = "#fdf8f8";
		camposCorretos[0] = 0;
	}
}

campoCondutancia.onblur = function()
{
	verificarCondutancia();
}

//-------- Intensidade

campoIntensidade.onfocus = function()
{
	campoIntensidade.style.border = "1px solid blue";
	campoIntensidade.style.backgroundColor = "#edfaff";
	campoIntensidade.value = campoIntensidade.value.replace("A","").trim();
}

campoIntensidade.onkeypress = function(e,args)
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
		var valorCampo = campoIntensidade.value;
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
	var valorCampo = campoIntensidade.value;
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
	campoIntensidade.value = valorFiltrado;
	
	if (campoIntensidade.value != "")
	{
		campoIntensidade.style.border = "1px solid green";
		campoIntensidade.style.backgroundColor = "#f2fff1";
		camposCorretos[1] = 1;
		campoIntensidade.value = campoIntensidade.value + " A";
	}
	else
	{
		campoIntensidade.style.border = "1px solid red";
		campoIntensidade.style.backgroundColor = "#fdf8f8";
		camposCorretos[1] = 0;
	}
}

campoIntensidade.onblur = function()
{
	verificarIntensidade();
}

//______________________________ Tensao

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
		camposCorretos[2] = 1;
		campoTensao.value = campoTensao.value + " V";
	}
	else
	{
		campoTensao.style.border = "1px solid red";
		campoTensao.style.backgroundColor = "#fdf8f8";
		camposCorretos[2] = 0;
	}
}
			  
campoTensao.onblur = function()
{
	verificarTensao();
}

function LimparBorda()
{
	campoIntensidade.style.border = "";
	campoCondutancia.style.border = "";
	campoTensao.style.border = "";
	
	campoIntensidade.disabled = false;
	campoCondutancia.disabled = false;
	campoTensao.disabled = false;
	
	for(cont = 0; cont <= camposCorretos.length - 1; cont = cont + 1)
	{
		camposCorretos[cont] = 0;
	}
}

function Validar()
{
	verificarTensao();
	verificarIntensidade();
	verificarCondutancia();
	
	var aux = 0;
	for (cont = 0; cont <= camposCorretos.length - 1; cont = cont + 1)
	{
		aux = aux + parseInt(camposCorretos[cont]);
	}
	if (aux <= 1 || aux == camposCorretos.length)
	{
		alert("Alguns campos estão inválidos ou todos os campos estão preenchidos, verifique e tente novamente!\n\n");
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
	
	LimparBorda();
}