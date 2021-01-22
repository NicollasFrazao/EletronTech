var campos = "000";
var campos = campos.split("");
var carga = ""; 
var pot_eletrica = "";
var cor_eletrica = "";

//-----------------------------Campo QtdCarga
var campoQtdCarga = document.querySelector("#txt_carga");

campoQtdCarga.onfocus = function(){
	campoQtdCarga.style.border = "1px solid blue";
	campoQtdCarga.style.backgroundColor = "#edfaff";
	campoQtdCarga.value = (campoQtdCarga.value.replace("C", "").trim());
}

function verificarCarga()
{
	var valorCampo = campoQtdCarga.value;
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
	campoQtdCarga.value = valorFiltrado;
	
	campoQtdCarga.style.border = "1px solid red";
	campoQtdCarga.style.backgroundColor = "#fdf8f8";
	if(campoQtdCarga.value == "" ){
		campos[0] = 0;
	}else{
		campoQtdCarga.style.border = "1px solid green";
		campoQtdCarga.style.backgroundColor = "#f2fff1";
		txt_carga.value = txt_carga.value + " C";
		campos[0] = 1;
	}
}

campoQtdCarga.onblur = function(){
	verificarCarga();
}

//-----------------------------Campo Potencia Eletrica
var campoPotEletrica = document.querySelector("#txt_potencia_eletrica");

campoPotEletrica.onfocus = function(){
	campoPotEletrica.style.border = "1px solid blue";
	campoPotEletrica.style.backgroundColor = "#edfaff";
	campoPotEletrica.value = (campoPotEletrica.value.replace("VA", "").trim());
}

function verificarPotencia()
{
	var valorCampo = campoPotEletrica.value;
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
	campoPotEletrica.value = valorFiltrado;
	
	campoPotEletrica.style.border = "1px solid red";
	campoPotEletrica.style.backgroundColor = "#fdf8f8";
	if(campoPotEletrica.value == "" ){
		campos[1] = 0;
	}else{
		campoPotEletrica.style.border = "1px solid green";
		campoPotEletrica.style.backgroundColor = "#f2fff1";
		txt_potencia_eletrica.value = txt_potencia_eletrica.value + " VA";
		campos[1] = 1;
	}
}

campoPotEletrica.onblur = function(){
	verificarPotencia();
}

//-----------------------------Campo Corrente Elétrica
var campoCorEletrica = document.querySelector("#txt_corrente_eletrica");

campoCorEletrica.onfocus = function(){
	campoCorEletrica.style.border = "1px solid blue";
	campoCorEletrica.style.backgroundColor = "#edfaff";
	campoCorEletrica.value = (campoCorEletrica.value.replace("A", "").trim());
}

function verificarCorrente()
{
	var valorCampo = campoCorEletrica.value;
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
	campoCorEletrica.value = valorFiltrado;
	
	campoCorEletrica.style.border = "1px solid red";
	campoCorEletrica.style.backgroundColor = "#fdf8f8";
	if(campoCorEletrica.value == "" ){
		campos[2] = 0;
	}else{
		campoCorEletrica.style.border = "1px solid green";
		campoCorEletrica.style.backgroundColor = "#f2fff1";
		txt_corrente_eletrica.value = txt_corrente_eletrica.value + " A";
		campos[2] = 1;
	}
}

campoCorEletrica.onblur = function(){
	verificarCorrente();
}

function numpont( obj , e )
{
    var tecla = ( window.event ) ? e.keyCode : e.which;
    if ( tecla == 8 || tecla == 0 || tecla == 46)
        return true;
    if (  tecla < 48 || tecla > 57 )
        return false;
}

function limpar(){
	txt_corrente_eletrica.value = "";
	txt_potencia_eletrica.value = "";
	txt_carga.value = "";
	txt_resultado.value= "";
	var limpa_corrente = document.querySelector("#txt_corrente_eletrica");
	var limpa_potencia = document.querySelector("#txt_potencia_eletrica");
	var limpa_carga = document.querySelector("#txt_carga");
	limpa_corrente.style.border = "";
	limpa_potencia.style.border = "";
	limpa_carga.style.border = "";
	carga = "";
	pot_eletrica = "";
	cor_eletrica = "";
	
	return carga;
	return pot_eletrica;
	return cor_eletrica;
}

//-----------Repetição Ponto

campoQtdCarga.onkeypress = function(e,args)
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
		var valorCampo = campoQtdCarga.value;
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

campoPotEletrica.onkeypress = function(e,args)
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
		var valorCampo = campoPotEletrica.value;
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

campoCorEletrica.onkeypress = function(e,args)
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
		var valorCampo = campoCorEletrica.value;
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


function Validar(frm)
{
	verificarCarga();
	verificarPotencia();
	verificarCorrente();
	
	var aux = 0;
	for (cont = 0; cont <= campos.length - 1; cont = cont + 1)
	{
		aux = aux + parseInt(campos[cont]);
	}
	if (aux != campos.length)
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