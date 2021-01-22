
var campos="000";
var campos = campos.split("");
var espirais;
var corrente;
var indutancia;

var campoEspirais=  document.querySelector("#txt_espirais");
var campoCorrente=  document.querySelector("#txt_corrente");
var campoIndutancia= document.querySelector("#txt_indutancia");
var btn_limpar= document.querySelector("#btn_limpar");


//-------Campo Espiral

campoEspirais.onkeypress = function(e,args)
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
		var valorCampo = campoEspirais.value;
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

function verificarEspirais()
{
	var valorCampo = campoEspirais.value;
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
	campoEspirais.value = valorFiltrado;
	
	campoEspirais.style.border = "1px solid red";
	campoEspirais.style.backgroundColor = "#fdf8f8";
	if(campoEspirais.value == "" ){
		campos[0] = 0;
	}else{
		campoEspirais.style.border = "1px solid green";
		campoEspirais.style.backgroundColor = "#f2fff1";
		campos[0] = 1;
	}
}

campoEspirais.onfocus = function(){
	campoEspirais.style.border = "1px solid blue";
	campoEspirais.style.backgroundColor = "#f2fff1";
}

campoEspirais.onblur = function(){
	verificarEspirais();
}

//-------Campo Corrente

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

function verificarCorrente()
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
	
	campoCorrente.style.border = "1px solid red";
	campoCorrente.style.backgroundColor = "#fdf8f8";
	if(campoCorrente.value == "" ){
		campos[1] = 0;
	}else{
		campoCorrente.style.border = "1px solid green";
		campoCorrente.style.backgroundColor = "#f2fff1";
		campoCorrente.value = campoCorrente.value + " A";
		campos[1] = 1;
	}
}

campoCorrente.onfocus = function(){
	campoCorrente.style.border = "1px solid blue";
	campoCorrente.style.backgroundColor = "#f2fff1";
	campoCorrente.value = campoCorrente.value.replace("A", "").trim();


}

campoCorrente.onblur = function(){
	verificaCorrente();
}

//-------Campo Indutancia

campoIndutancia.onkeypress = function(e,args)
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
		var valorCampo = campoIndutancia.value;
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

function verificarIndutancia()
{
	var valorCampo = campoIndutancia.value;
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
	campoIndutancia.value = valorFiltrado;
	
	campoIndutancia.style.border = "1px solid red";
	campoIndutancia.style.backgroundColor = "#fdf8f8";
	if(campoIndutancia.value == "" ){
		campos[2] = 0;
	}else{
		campoIndutancia.style.border = "1px solid green";
		campoIndutancia.style.backgroundColor = "#f2fff1";
		txt_indutancia.value = txt_indutancia.value + " H";
		campos[2] = 1;
	}
}


campoIndutancia.onfocus = function(){
	campoIndutancia.style.border = "1px solid blue";
	campoIndutancia.style.backgroundColor = "#f2fff1";
	campoIndutancia.value = campoIndutancia.value.replace("H", "").trim();

}

campoIndutancia.onblur = function(){
	verificarIndutancia();
}

function numpont( obj , e )
{
    var tecla = ( window.event ) ? e.keyCode : e.which;
    if ( tecla == 8 || tecla == 0 || tecla == 46)
        return true;
    if (  tecla < 48 || tecla > 57 )
        return false;
}

 
 btn_limpar.onclick = function(){
	txt_indutancia.value = "";
	txt_corrente.value = "";
	txt_espirais.value = "";
	var limpa_corrente = document.querySelector("#txt_corrente");
	var limpa_espirais = document.querySelector("#txt_espirais");
	var limpa_indutancia = document.querySelector("#txt_indutancia");
	limpa_corrente.style.border = "";
	limpa_espirais.style.border = "";
	limpa_indutancia.style.border = "";
	espirais = "";
	corrente = "";
	indutancia = "";
	return espirais;
	return corrente;
	return indutancia;
}

function Validar()
{
	verificarIndutancia();
	verificarEspirais();
	verificarCorrente();
	
	var aux = 0;
	for (cont = 0; cont <= campos.length - 1; cont = cont + 1)
	{
		aux = aux + parseInt(campos[cont]);
	}
	if (aux == campos.length || aux != campos.length - 1)
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