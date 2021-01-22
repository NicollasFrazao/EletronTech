var camposCorretos = new Array(14);

var ajust = 1;

//---------- Pé Direito

var campoPeDireito = document.querySelector("#txt_peDireito");

campoPeDireito.onfocus = function()
{
	campoPeDireito.style.border = "1px solid blue";
	//campoPeDireito.value = campoPeDireito.value.replace(" ","");
	campoPeDireito.value = campoPeDireito.value.replace("m","").trim();
}

campoPeDireito.onkeypress = function(e,args)
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
		var valorCampo = campoPeDireito.value;
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

function verificarPeDireito()
{
	var valorCampo = campoPeDireito.value;
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
	campoPeDireito.value = valorFiltrado;
	
	if (campoPeDireito.value != "")
	{
		campoPeDireito.style.border = "1px solid green";
		camposCorretos[0] = 1;
		campoPeDireito.value = campoPeDireito.value + " m";
	}
	else
	{
		campoPeDireito.style.border = "1px solid red";
		campoPeDireito.style.backgroundColor = "#fdf8f8";
		camposCorretos[0] = 0;
	}
	
	verificarSuspensaoLuminaria();
}
			  
campoPeDireito.onblur = function()
{
	verificarPeDireito();
}

//------------ Largura

var campoLargura = document.querySelector("#txt_largura");

campoLargura.onfocus = function()
{
	campoLargura.style.border = "1px solid blue";
	//campoLargura.value = campoLargura.value.replace(" ","");
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
		camposCorretos[1] = 1;
		campoLargura.value = campoLargura.value + " m";
	}
	else
	{
		campoLargura.style.border = "1px solid red";
		campoLargura.style.backgroundColor = "#fdf8f8";
		camposCorretos[1] = 0;
	}
}
			  
campoLargura.onblur = function()
{
	verificarLargura();
}

//----------- Comprimento

var campoComprimento = document.querySelector("#txt_comprimento");

campoComprimento.onfocus = function()
{
	campoComprimento.style.border = "1px solid blue";
	//campoComprimento.value = campoComprimento.value.replace(" ","");
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
		camposCorretos[2] = 1;
		campoComprimento.value = campoComprimento.value + " m";
	}
	else
	{
		campoComprimento.style.border = "1px solid red";
		campoComprimento.style.backgroundColor = "#fdf8f8";
		camposCorretos[2] = 0;
	}
}

campoComprimento.onblur = function()
{
	verificarComprimento();
}

//--------- Iluminância

var campoIluminancia = document.querySelector("#txt_iluminancia");

campoIluminancia.onfocus = function()
{
	campoIluminancia.style.border = "1px solid blue";
	//campoIluminancia.value = campoIluminancia.value.replace(" ","");
	campoIluminancia.value = campoIluminancia.value.replace("lx","").trim();
}

campoIluminancia.onkeypress = function(e,args)
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
		var valorCampo = campoIluminancia.value;
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

function verificarIluminancia()
{
	var valorCampo = campoIluminancia.value;
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
	campoIluminancia.value = valorFiltrado;
	
	if (campoIluminancia.value != "")
	{
		campoIluminancia.style.border = "1px solid green";
		camposCorretos[3] = 1;
		campoIluminancia.value = campoIluminancia.value + " lx";
	}
	else
	{
		campoIluminancia.style.border = "1px solid red";
		campoIluminancia.style.backgroundColor = "#fdf8f8";
		camposCorretos[3] = 0;
	}
}
			  
campoIluminancia.onblur = function()
{
	verificarIluminancia();
}

//------------- Ambiente

var campoAmbiente = document.querySelector("#cmb_ambiente");

campoAmbiente.onfocus = function()
{
	campoAmbiente.style.border = "1px solid blue";
}

function verificarAmbiente()
{
	if (campoAmbiente.value != 0)
	{
		campoAmbiente.style.border = "1px solid green";
		camposCorretos[4] = 1;
	}
	else
	{
		campoAmbiente.style.border = "1px solid red";
		campoAmbiente.style.backgroundColor = "#fdf8f8";
		camposCorretos[4] = 0;
	}
}

campoAmbiente.onblur = function()
{
	verificarAmbiente();
}

campoAmbiente.onchange = function()
{
	verificarAmbiente();
}

//-------- Manutenção

var campoManutencao = document.querySelector("#cmb_manutencao");

campoManutencao.onfocus = function()
{
	campoManutencao.style.border = "1px solid blue";
}

function verificarManutencao()
{
	if (campoManutencao.value != 0)
	{
		campoManutencao.style.border = "1px solid green";
		camposCorretos[5] = 1;
	}
	else
	{
		campoManutencao.style.border = "1px solid red";
		campoManutencao.style.backgroundColor = "#fdf8f8";
		camposCorretos[5] = 0;
	}
}

campoManutencao.onblur = function()
{
	verificarManutencao();
}

campoManutencao.onchange = function()
{
	verificarManutencao();
}

//----------- Sistema de iluminação

var campoSistemaIluminacao = document.querySelector("#cmb_sistemaIluminacao");

campoSistemaIluminacao.onfocus = function()
{
	campoSistemaIluminacao.style.border = "1px solid blue";
}

function verificarSistemaIluminacao()
{
	if (campoSistemaIluminacao.value != 0)
	{
		campoSistemaIluminacao.style.border = "1px solid green";
		camposCorretos[6] = 1;
	}
	else
	{
		campoSistemaIluminacao.style.border = "1px solid red";
		campoSistemaIluminacao.style.backgroundColor = "#fdf8f8";
		camposCorretos[6] = 0;
	}
	
	if (campoSistemaIluminacao.value == 3 || campoSistemaIluminacao.value == 5)
	{
		campoSuspensaoLuminaria.style.border = "";
		camposCorretos[7] = 1;
	}
}

campoSistemaIluminacao.onblur = function()
{
	verificarSistemaIluminacao();
}

campoSistemaIluminacao.onchange = function()
{
	verificarSistemaIluminacao();
}

//--------- Suspensao da luminária

var campoSuspensaoLuminaria = document.querySelector("#txt_suspensaoLuminaria");

campoSuspensaoLuminaria.onfocus = function()
{
	campoSuspensaoLuminaria.style.border = "1px solid blue";
	//campoSuspensaoLuminaria.value = campoSuspensaoLuminaria.value.replace(" ","");
	campoSuspensaoLuminaria.value = campoSuspensaoLuminaria.value.replace("m","").trim();
}

campoSuspensaoLuminaria.onkeypress = function(e,args)
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
		var valorCampo = campoSuspensaoLuminaria.value;
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

function verificarSuspensaoLuminaria()
{
	var valorCampo = campoSuspensaoLuminaria.value;
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
	campoSuspensaoLuminaria.value = valorFiltrado;
	
	var aux;
	
	if (!parseFloat(parseFloat(campoAlturaPlanoTrabalho.value.replace(",", ".").replace("m", "").trim())) > 0)
	{
		aux = parseFloat(parseFloat("0") + parseFloat(campoSuspensaoLuminaria.value.replace(",", ".").replace("m", "").trim()))
	}
	else
	{
		aux = parseFloat(parseFloat(campoAlturaPlanoTrabalho.value.replace(",", ".").replace("m", "").trim()) + parseFloat(campoSuspensaoLuminaria.value.replace(",", ".").replace("m", "").trim()))
	}
	
	if (campoSuspensaoLuminaria.value.replace(",", ".").replace("m", "").trim() > 0 &&  aux < parseFloat(campoPeDireito.value.replace(",", ".").replace("m", "").trim()))
	{
		campoSuspensaoLuminaria.style.border = "1px solid green";
		camposCorretos[7] = 1;
		campoSuspensaoLuminaria.value = campoSuspensaoLuminaria.value + " m";
		
		if (campoAlturaPlanoTrabalho.value != "" && campoAlturaPlanoTrabalho.value != 0 && ajust == 1)
		{
			ajust = ajust + 1;
			verificarAlturaPlanoTrabalho();
		}
	}
	else
	{
		campoSuspensaoLuminaria.style.border = "1px solid red";
		campoSuspensaoLuminaria.style.backgroundColor = "#fdf8f8";
		camposCorretos[7] = 0;
		
		if (campoAlturaPlanoTrabalho.value != "" && campoAlturaPlanoTrabalho.value != 0 && ajust == 1)
		{
			ajust = ajust + 1;
			verificarAlturaPlanoTrabalho();
		}
	}
	
	ajust = 1;
}
			  
campoSuspensaoLuminaria.onblur = function()
{
	verificarSuspensaoLuminaria();
}

//----------- Potência

var campoPotencia = document.querySelector("#txt_potencia");

campoPotencia.onfocus = function()
{
	campoPotencia.style.border = "1px solid blue";
	//campoPotencia.value = campoPotencia.value.replace(" ","");
	campoPotencia.value = campoPotencia.value.replace("V","").trim();
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

function verificarPotencia()
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
		camposCorretos[8] = 1;
		campoPotencia.value = campoPotencia.value + " V";
	}
	else
	{
		campoPotencia.style.border = "1px solid red";
		campoPotencia.style.backgroundColor = "#fdf8f8";
		camposCorretos[8] = 0;
	}
}
			  
campoPotencia.onblur = function()
{
	verificarPotencia();
}

//---------- Fluxo Luminoso

var campoFluxoLuminoso = document.querySelector("#txt_fluxoLuminosoInicial");

campoFluxoLuminoso.onfocus = function()
{
	campoFluxoLuminoso.style.border = "1px solid blue";
	//campoFluxoLuminoso.value = campoFluxoLuminoso.value.replace(" ","");
	campoFluxoLuminoso.value = campoFluxoLuminoso.value.replace("lm","").trim();
}

campoFluxoLuminoso.onkeypress = function(e,args)
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
		var valorCampo = campoFluxoLuminoso.value;
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

function verificarFluxoLuminoso()
{
	var valorCampo = campoFluxoLuminoso.value;
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
	campoFluxoLuminoso.value = valorFiltrado;
	
	if (campoFluxoLuminoso.value != "")
	{
		campoFluxoLuminoso.style.border = "1px solid green";
		camposCorretos[9] = 1;
		campoFluxoLuminoso.value = campoFluxoLuminoso.value + " lm";
	}
	else
	{
		campoFluxoLuminoso.style.border = "1px solid red";
		campoFluxoLuminoso.style.backgroundColor = "#fdf8f8";
		camposCorretos[9] = 0;
	}
}
			  
campoFluxoLuminoso.onblur = function()
{
	verificarFluxoLuminoso();
}

//------------ Altura do plano de trabalho

var campoAlturaPlanoTrabalho = document.querySelector("#txt_alturaPlanoTrabalho");

campoAlturaPlanoTrabalho.onfocus = function()
{
	campoAlturaPlanoTrabalho.style.border = "1px solid blue";
	//campoAlturaPlanoTrabalho.value = campoAlturaPlanoTrabalho.value.replace(" ","");
	campoAlturaPlanoTrabalho.value = campoAlturaPlanoTrabalho.value.replace("m","").trim();
}

campoAlturaPlanoTrabalho.onkeypress = function(e,args)
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
		var valorCampo = campoAlturaPlanoTrabalho.value;
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

function verificarAlturaPlanoTrabalho()
{
	var valorCampo = campoAlturaPlanoTrabalho.value;
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
	campoAlturaPlanoTrabalho.value = valorFiltrado;
	
	var aux;
	
	if (!parseFloat(campoSuspensaoLuminaria.value.replace(",", ".").replace("m", "").trim()) > 0)
	{
		aux = parseFloat(parseFloat(campoAlturaPlanoTrabalho.value.replace(",", ".").replace("m", "").trim()) + parseFloat("0"));
	}
	else
	{
		aux = parseFloat(parseFloat(campoAlturaPlanoTrabalho.value.replace(",", ".").replace("m", "").trim()) + parseFloat(campoSuspensaoLuminaria.value.replace(",", ".").replace("m", "").trim()))
	}
	
	if (campoAlturaPlanoTrabalho.value.replace(",", ".").replace("m", "").trim() > 0 && aux < parseFloat(campoPeDireito.value.replace(",", ".").replace("m", "").trim()))
	{
		campoAlturaPlanoTrabalho.style.border = "1px solid green";
		camposCorretos[10] = 1;
		campoAlturaPlanoTrabalho.value = campoAlturaPlanoTrabalho.value + " m";
		
		if (campoSuspensaoLuminaria.value != "" && campoSuspensaoLuminaria.value != 0 && ajust == 1)
		{
			ajust = ajust + 1;
			verificarSuspensaoLuminaria();
		}
	}
	else
	{
		campoAlturaPlanoTrabalho.style.border = "1px solid red";
		campoAlturaPlanoTrabalho.style.backgroundColor = "#fdf8f8";
		camposCorretos[10] = 0;
		
		if (campoSuspensaoLuminaria.value != "" && campoSuspensaoLuminaria.value != 0 && ajust == 1)
		{
			ajust = ajust + 1;
			verificarSuspensaoLuminaria();
		}
	}
	
	ajust = 1;
}
			  
campoAlturaPlanoTrabalho.onblur = function()
{
	verificarAlturaPlanoTrabalho();
}

//------------ Planos

var campoPlano = document.querySelector("#cmb_plano");
var planoTeto = document.querySelector("#lbl_teto");
var planoParede = document.querySelector("#lbl_parede");
var planoPlanoTrabalho = document.querySelector("#lbl_planoTrabalho");
var auxref, auxvalorcombo;

function verificarPlano(ref, valorcombo)
{
	auxref = ref;
	auxvalorcombo = valorcombo;
	
	switch (parseInt(valorcombo))
	{
		case 1:
		{
			if (valorcombo == 1 && ref > 0)
			{
				planoTeto.style.borderBottom = "1px solid green";
				camposCorretos[11] = 1;
			}
			else
			{
				planoTeto.style.borderBottom = "1px solid red";
				camposCorretos[11] = 0;
			}
		}
		break;
		
		case 2:
		{
			if (valorcombo == 2 && ref > 0)
			{
				planoParede.style.borderBottom = "1px solid green";
				camposCorretos[12] = 1;
			}
			else
			{
				planoParede.style.borderBottom = "1px solid red";
				camposCorretos[12] = 0;
			}
		}
		break;
		
		case 3:
		{
			if (valorcombo == 3 && ref > 0)
			{
				planoPlanoTrabalho.style.borderBottom = "1px solid green";
				camposCorretos[13] = 1;
			}
			else
			{
				planoPlanoTrabalho.style.borderBottom = "1px solid red";
				camposCorretos[13] = 0;
			}
		}
		break;
		default:
		{
			planoTeto.style.borderBottom = "1px solid red";
			camposCorretos[11] = 0;
				
			planoParede.style.borderBottom = "1px solid red";
			camposCorretos[12] = 0;
			
			planoPlanoTrabalho.style.borderBottom = "1px solid red";
			
			camposCorretos[13] = 0;
		}
	}
}

function Validar(frm)
{
	verificarPeDireito();
	verificarLargura();
	verificarComprimento();
	verificarIluminancia();
	verificarAmbiente();
	verificarManutencao();
	verificarSistemaIluminacao();
	
	if (campoSistemaIluminacao.value != 0 && campoSistemaIluminacao.value != 3 && campoSistemaIluminacao.value != 5)
	{
		verificarSuspensaoLuminaria();
	}
	
	verificarPotencia();
	verificarFluxoLuminoso();
	verificarAlturaPlanoTrabalho();
	verificarPlano(auxref, auxvalorcombo);
	
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

function Zerar()
{
	var ambiente = document.querySelector("#Frm_Ambiente");
	ambiente.reset();
	
	var iluminacao = document.querySelector("#Frm_Iluminacao");
	iluminacao.reset();
	
	var coeficiente = document.querySelector("#Frm_Coeficiente");
	coeficiente.reset();
}

function LimparBorda()
{
	Zerar();
	
	campoPeDireito.style.border = "";
	campoLargura.style.border = "";
	campoComprimento.style.border = "";
	campoIluminancia.style.border = "";
	campoAmbiente.style.border = "";
	campoManutencao.style.border = "";
	campoSistemaIluminacao.style.border = "";
	campoSuspensaoLuminaria.style.border = "";
	campoPotencia.style.border = "";
	campoFluxoLuminoso.style.border = "";
	campoAlturaPlanoTrabalho.style.border = "";
	planoTeto.style.border = "";
	planoParede.style.border = "";
	planoPlanoTrabalho.style.border = "";
	planoTeto.innerHTML = "Teto";
	planoParede.innerHTML = "Parede";
	planoPlanoTrabalho.innerHTML = "Plano de Trabalho";
	campoSuspensaoLuminaria.value = 0;
	campoSuspensaoLuminaria.disabled = true;

	lbl_alturaUtil.innerHTML = "";
	lbl_area.innerHTML = "";
	lbl_coeficienteUtilizacao.innerHTML = "";
	lbl_fatorDepreciacao.innerHTML = "";
	lbl_fluxoLuminosoTotal.innerHTML = "";
	lbl_indiceLocal.innerHTML = "";
	lbl_numeroPontosLuz.innerHTML = "";
	lbl_perimetro.innerHTML = "";
	lbl_potenciaTotal.innerHTML = "";

	for(cont = 0; cont <= camposCorretos.length - 1; cont = cont + 1)
	{
		camposCorretos[cont] = 0;
	}
}

btn_ambiente.onclick = function()
{
	ambiente.style.display = "inline-block";
	iluminacao.style.display = "none";
	coeficienteReflexao.style.display = "none";
	btn_ambiente.src="imagens/ambiente_2.png";
	btn_iluminacao.src="imagens/iluminacao_1.png";
	btn_reflexao.src="imagens/reflexao_1.png";
}

btn_iluminacao.onclick = function()
{
	ambiente.style.display = "none";
	iluminacao.style.display = "inline-block";
	coeficienteReflexao.style.display = "none";
	btn_ambiente.src="imagens/ambiente_1.png";
	btn_iluminacao.src="imagens/iluminacao_2.png";
	btn_reflexao.src="imagens/reflexao_1.png";
}

btn_reflexao.onclick = function()
{
	ambiente.style.display = "none";
	iluminacao.style.display = "none";
	coeficienteReflexao.style.display = "inline-block";
	btn_ambiente.src="imagens/ambiente_1.png";
	btn_iluminacao.src="imagens/iluminacao_1.png";
	btn_reflexao.src="imagens/reflexao_2.png";
}

