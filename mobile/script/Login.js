function Login()
{
	if (txt_usuario.value != "" && txt_senha.value != "")
	{
		load();
		var frm = document.querySelector("#Frm_Login");
		frm.submit();
	}
}

function Cadastro()
{
	window.location.href='Cadastro.html';
}

function load()
{
	setTimeout('carregar()',1000);
}	

function carregar()
{
	all.style.display = "none";
	carregamento.style.display = "inline-block";
}

//------------ Campos

var camposCorretos = new Array(2);

//--------------- Email

var campoEmail = document.querySelector("#txt_email");

// KeyPress
campoEmail.onkeypress = function filtroEmail(e,args)
{              
        if (document.all) // caso seja IE
		{
			var evt=event.keyCode;
		}			
        else // do contrário deve ser Mozilla ou Google
		{
			var evt = e.charCode;
		}
		
        var valid_chars = '0123456789abcdefghijlmnopqrstuvxzwykQWERTYUIOPASDFGHJKLZXCVBNM-_@.';      // criando a lista de teclas permitidas
        var chr= String.fromCharCode(evt);      // pegando a tecla digitada
        
		if (valid_chars.indexOf(chr)>-1 || evt < 9)
		{
			return true;
		}
		
        return false;   // do contrário nega
}

function VerificacaoFinalEmail()
{
	var valorCampo = campoEmail.value;
	var valorFiltrado = "";
	var quant = 0;
	var filtro = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM@.-_";
		
	for (cont = 0; cont <= valorCampo.length - 1; cont = cont + 1)
	{
		if (filtro.indexOf(valorCampo.charAt(cont)) != -1)
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(cont).toLowerCase();
		}
	}
	
	campoEmail.value = valorFiltrado;
	
	while ((campoEmail.value.lastIndexOf(".") == campoEmail.value.length - 1) && (campoEmail.value.lastIndexOf(".") != -1 && campoEmail.value.length != 0))
	{
		aux = campoEmail.value.split("");
		aux[campoEmail.value.length - 1] = "";
		outraaux = "";
		
		for (cont = 0; cont <= campoEmail.value.length - 1; cont = cont +1)
		{
			outraaux = outraaux + aux[cont];
		}
		
		campoEmail.value = outraaux;
	}
}

function verificarEmail()
{
	while ((campoEmail.value.lastIndexOf(".") == campoEmail.value.length - 1) && (campoEmail.value.lastIndexOf(".") != -1 && campoEmail.value.length != 0))
	{
		aux = campoEmail.value.split("");
		aux[campoEmail.value.length - 1] = "";
		outraaux = "";
		
		for (cont = 0; cont <= campoEmail.value.length - 1; cont = cont +1)
		{
			outraaux = outraaux + aux[cont];
		}
		
		campoEmail.value = outraaux;
	}
	
	if (campoEmail.value.indexOf("@") != -1)
	{
		var aux = campoEmail.value.split("@");
		var usuario = aux[0];
		var dominio = aux[1];
		
		if ((usuario.length >= 1) && 
			(dominio.length >= 3) && 
			(dominio.indexOf(".") != -1) &&
			(dominio.indexOf(".") >= 1) &&
			(dominio.lastIndexOf(".") < dominio.length - 1))
		{
			campoEmail.style.border = "2px solid green";
			camposCorretos[0] = 1;
		}
		else
		{
			campoEmail.style.border = "2px solid red";
			camposCorretos[0] = 0;
		}
	}
	else
	{
		campoEmail.style.border = "2px solid red";
		camposCorretos[0] = 0;
	}
}

campoEmail.onblur = function()
{
	VerificacaoFinalEmail();
	//verificarEmail();
}

campoEmail.onfocus = function()
{
	//campoEmail.style.border = "2px solid blue";
}

//-------------- Senha

var campoSenha = document.querySelector("#txt_senha");

campoSenha.onfocus = function()
{
	//campoSenha.style.border = "2px solid blue";
}

campoSenha.onkeypress = function(e,args)
{
	if (document.all) // caso seja IE
		{
			var evt=event.keyCode;
		}			
        else // do contrário deve ser Mozilla ou Google
		{
			var evt = e.charCode;
		}
		
        var valid_chars = "0123456789abcdefghijlmnopqrstuvxzwykçÇsQWERTYUIOPASDFGHJKLZXCVBNM´`~!@#$%^&*()_-+={}[]\\|:;<>,.?/";      // criando a lista de teclas permitidas
        var chr= String.fromCharCode(evt);      // pegando a tecla digitada
        
		if (valid_chars.indexOf(chr)>-1 ) // se a tecla estiver na lista de permissão permite-a
		{
			return true;
		}
		
        // para permitir teclas como <BACKSPACE> adicionamos uma permissão para
        // códigos de tecla menores que 09 por exemplo 
		
        if (valid_chars.indexOf(chr)>-1 || evt < 9)
		{
			return true;
		}
		
        return false;   // do contrário nega
}

function VerificacaoFinalSenha()
{
	var valorCampo = campoSenha.value;
	var valorFiltrado = "";
	var quant = 0;
	var filtro = "0123456789abcdefghijlmnopqrstuvxzwykçÇsQWERTYUIOPASDFGHJKLZXCVBNM´`~!@#$%^&*()_-+={}[]\\|:;<>,.?/";
		
	for (cont = 0; cont <= valorCampo.length - 1; cont = cont + 1)
	{
		if (filtro.indexOf(valorCampo.charAt(cont)) != -1)
		{
			valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
		}
	}
	
	campoSenha.value = valorFiltrado;
}

function verificarSenha()
{
	if (campoSenha.value.length >=6 && campoSenha.value.length <= 12)
	{
		campoSenha.style.border = "2px solid green";
		camposCorretos[9] = 1;
	}
	else
	{
		campoSenha.style.border = "2px solid red";
		camposCorretos[9] = 0;
	}
}

campoSenha.onblur = function()
{
	VerificacaoFinalSenha();
	//verificarSenha();
}