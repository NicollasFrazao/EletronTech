var forms = new Array;

function contains(valor, array)
{
	var contAT;
	
	for (contAT = 0; contAT <= array.length - 1; contAT = contAT + 1)
	{
		if (array[contAT].toString().toLowerCase() === valor.toString().toLowerCase())
		{
			return true;
		}
	}
	
	return false;
}

function QunatidadeCamposCorretos(form)
{
	var contAT;
	var campos = form.getElementsByClassName("at-valida");
	campos = Array.prototype.slice.call(campos);
	
	var camposCorretos = 0;
	
	for (contAT = 0; contAT <= campos.length - 1; contAT = contAT + 1)
	{
		var campo = campos[contAT];
		
		if (campo.getAttribute('correto') == 1)
		{
			camposCorretos = camposCorretos + 1;
		}
	}
	
	return camposCorretos;
}

function VerificarForm(form)
{
	AplicarEventos(form);
	
	var contAT;
	var campos = form.getElementsByClassName("at-valida");
	campos = Array.prototype.slice.call(campos);
	
	var totalCamposObrigatorios = 0;
	var camposCorretos = 0;
	
	for (contAT = 0; contAT <= campos.length - 1; contAT = contAT + 1)
	{
		var campo = campos[contAT];
		
		if (campo.required == true)
		{
			totalCamposObrigatorios = totalCamposObrigatorios + 1;
		}
	}
	
	for (contAT = 0; contAT <= campos.length - 1; contAT = contAT + 1)
	{
		var campo = campos[contAT];
		
		try
		{
			campo.onvalidate();
		}
		catch (exe)
		{
			console.log(campo);
			console.log(exe.message);
		}
		
		if (campo.required == true)
		{
			camposCorretos = camposCorretos + parseInt(campo.getAttribute("correto"));
		}
	}
	
	if (camposCorretos >= totalCamposObrigatorios)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function MapearForms()
{
	var body = document.getElementsByTagName('body')[0];
	var forms = body.getElementsByTagName('form');
	var contAT;
	
	for (contAT = 0; contAT <= forms.length - 1; contAT = contAT + 1)
	{
		AplicarEventos(forms[contAT]);
	}
}

function AplicarEventos(form)
{
	var campos = form.getElementsByClassName("at-valida");
	campos = Array.prototype.slice.call(campos);
	
	forms.push
	(
		{
			form: form,
			campos: new Array(campos)
		}
	);
	
	for (contAT = 0; contAT <= campos.length - 1; contAT = contAT + 1)
	{
		try
		{
			var atr = campos[contAT].getAttribute("tipo").toString();
			campos[contAT].setAttribute("correto", 0);
		}
		catch (exe)
		{
			var atr = "";
		}
		
		if (atr == "NomeCompleto")
		{
			campos[contAT].maxLength = 50;
			
			campos[contAT].onvalidate = function()
			{
				var valorCampo = this.value;
				var valorFiltrado = "";
				var filtro = "abcdefghijlmnopqrstuvxzwykçáàâãéèêíìîóòõôúùûQWERTYUIOPASDFGHJKLÇZXCVBNMÁÀÂÃÉÈÊÍÌÎÓÒÕÔÚÙÛ ";
					
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (filtro.indexOf(valorCampo.charAt(contAT)) != -1)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
				}
				
				this.value = valorFiltrado;
				
				var tamanho, contAT;
				var palavra, copia = "";
				
				this.value = this.value.trim();
				
				if (this.value != "")
				{
					tamanho = this.value.length;
					palavra = this.value;
					
					for (contAT = 0; contAT <= tamanho - 1; contAT = contAT + 1)
					{
						if (contAT == 0)
						{
							copia = copia + palavra.charAt(contAT).toUpperCase();
						}
						else if (palavra.charAt(contAT) == " ")
						{
							if (palavra.charAt(contAT + 1) != " ")
							{
								copia = copia + " " + palavra.charAt(contAT + 1).toUpperCase();
								contAT = contAT + 1;
							}
						}
						else
						{
							copia = copia + palavra.charAt(contAT).toLowerCase();
						}
					}
					
					this.value = copia;
					
					if (this.value == '')
					{
						this.setAttribute("correto", 0);
					}
					else if (this.value.indexOf(" ") == -1)
					{
						this.setAttribute("correto", 0);
					}
					else
					{
						this.setAttribute("correto", 1);
					}
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
			
			campos[contAT].onkeypress = function(e,args)
			{
				if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = 'abcdefghijlmnopqrstuvxzwykçáàâãéèêíìîóòõôúùû QWERTYUIOPASDFGHJKLÇZXCVBNMÁÀÂÃÉÈÊÍÌÎÓÒÕÔÚÙÛ´`~^';      // criando a lista de teclas permitidas
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
			
			
		}
		else if (atr == "E-mail")
		{
			campos[contAT].maxLength = 50;
			campos[contAT].style.textTransform = 'lowercase';
			
			campos[contAT].onkeypress = function filtroEmail(e,args)
			{              
				if (document.all) // caso seja IE
				{
					var evt = event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = '0123456789abcdefghijlmnopqrstuvxzwykQWERTYUIOPASDFGHJKLZXCVBNM-_@.';      // criando a lista de teclas permitidas
				var chr = String.fromCharCode(evt);      // pegando a tecla digitada
				
				if (chr == '@' && this.value.indexOf('@') != -1)
				{
					return false;
				}
				
				if (valid_chars.indexOf(chr)>-1 || evt < 9)
				{
					return true;
				}
				
				return false;   // do contrário nega
			}
			
			campos[contAT].onvalidate = function()
			{
				var valorCampo = this.value;
				var valorFiltrado = "";
				var quant = 0;
				var filtro = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM@.-_";
					
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (filtro.indexOf(valorCampo.charAt(contAT)) != -1)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT).toLowerCase();
					}
				}

				this.value = valorFiltrado;
				
				while ((this.value.lastIndexOf(".") == this.value.length - 1) && (this.value.lastIndexOf(".") != -1 && this.value.length != 0))
				{
					aux = this.value.split("");
					aux[this.value.length - 1] = "";
					outraaux = "";
					
					for (contAT = 0; contAT <= this.value.length - 1; contAT = contAT +1)
					{
						outraaux = outraaux + aux[contAT];
					}
					
					this.value = outraaux;
				}
				
				if (this.value.indexOf("@") != -1)
				{
					var aux = this.value.split("@");
					var usuario = aux[0];
					var dominio = aux[1];
					
					if ((usuario.length >= 1) && 
						(dominio.length >= 3) && 
						(dominio.indexOf(".") != -1) &&
						(dominio.indexOf(".") >= 1) &&
						(dominio.lastIndexOf(".") < dominio.length - 1))
					{
						this.setAttribute("correto", 1);
					}
					else
					{
						this.setAttribute("correto", 0);
					}
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
			
			
		}
		else if (atr == "Senha" || atr == "NovaSenha")
		{
			var minimo = 6;
			var maximo = 16
			
			campos[contAT].maxLength = maximo;
			
			campos[contAT].onkeypress = function(e,args)
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
			
			campos[contAT].onvalidate = function()
			{
				var valorCampo = this.value;
				var valorFiltrado = "";
				var quant = 0;
				var filtro = "0123456789abcdefghijlmnopqrstuvxzwykçÇsQWERTYUIOPASDFGHJKLZXCVBNM´`~!@#$%^&*()_-+={}[]\\|:;<>,.?/";
					
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (filtro.indexOf(valorCampo.charAt(contAT)) != -1)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
				}
				
				this.value = valorFiltrado;
				
				if (this.value.length >= minimo && this.value.length <= maximo)
				{
					this.setAttribute("correto", 1);
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
			
			
		}
		else if (atr == "ConfirmarSenha")
		{
			for (linha = 0; linha <= forms.length - 1; linha = linha + 1)
			{
				if (forms[linha].campos[0].indexOf(campos[contAT]) != -1)
				{
					for (coluna = 0; coluna <= forms[linha].campos[0].length - 1; coluna = coluna + 1)
					{
						if (forms[linha].campos[0][coluna].getAttribute("tipo") == "Senha")
						{
							var campoSenha = forms[linha].campos[0][coluna];
							
							var minimo = 6;
							var maximo = 16
							campos[contAT].maxLength = maximo;
							
							campos[contAT].onkeypress = function(e,args)
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
							
							campos[contAT].onvalidate = function()
							{
								var valorCampo = this.value;
								var valorFiltrado = "";
								var quant = 0;
								var filtro = "0123456789abcdefghijlmnopqrstuvxzwykçÇsQWERTYUIOPASDFGHJKLZXCVBNM´`~!@#$%^&*()_-+={}[]\\|:;<>,.?/";
									
								for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
								{
									if (filtro.indexOf(valorCampo.charAt(contAT)) != -1)
									{
										valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
									}
								}
								
								this.value = valorFiltrado;
								
								if (this.value == campoSenha.value && campoSenha.value != "")
								{
									this.setAttribute("correto", 1);
								}
								else
								{
									this.setAttribute("correto", 0);
								}
							}
							
							break;
						}
					}
					
					break;
				}
			}
			
			
		}
		else if (atr.toLowerCase() == "combobox")
		{
			campos[contAT].onvalidate = function()
			{
				if (this.value != "")
				{
					this.setAttribute("correto", 1);
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
			
			
		}
		else if (atr.toLowerCase() == "checkbox")
		{
			campos[contAT].onvalidate = function()
			{
				if (this.checked)
				{
					this.setAttribute("correto", 1);
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
			
			
		}
		else if (atr == "Dia")
		{
			campos[contAT].maxLength = 2;
			
			campos[contAT].onkeypress = function(e,args)
			{
				if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = "1234567890";      // criando a lista de teclas permitidas
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
			
			campos[contAT].onvalidate = function()
			{
				var valorCampo = this.value;
				var valorFiltrado = "";
				var quant = 0;
				var filtro = "1234567890";
					
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (filtro.indexOf(valorCampo.charAt(contAT)) != -1)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
				}
				
				this.value = valorFiltrado;
				
				if (this.value.length > 0)
				{
					this.setAttribute("correto", 1);
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
			
			
		}
		else if (atr == "Ano")
		{
			campos[contAT].maxLength = 4;
			
			campos[contAT].onkeypress = function(e,args)
			{
				if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = "1234567890";      // criando a lista de teclas permitidas
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
			
			campos[contAT].onvalidate = function()
			{
				var valorCampo = this.value;
				var valorFiltrado = "";
				var quant = 0;
				var filtro = "1234567890";
					
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (filtro.indexOf(valorCampo.charAt(contAT)) != -1)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
				}
				
				this.value = valorFiltrado;
				
				if (this.value.length > 0)
				{
					this.setAttribute("correto", 1);
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
			
			
		}
		else if (atr == "Datanas")
		{
			campos[contAT].maxLength = 10;
			
			campos[contAT].onkeypress = function(e,args)
			{
				if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = '1234567890/';      // criando a lista de teclas permitidas
				var chr= String.fromCharCode(evt);      // pegando a tecla digitada
				
				if (valid_chars.indexOf(chr)>-1 || evt < 9)
				{
					var valorCampo = this.value;
					var valorFiltrado = "";
					var quant = 0;
					
					var index = valid_chars.indexOf(chr);
					var tecla = valid_chars.charAt(index);
					
					var tamanho = valorCampo.length;
					
					if (tecla == '/' && (tamanho == 2 || tamanho == 5))
					{
						return true;
					}
					
					if (tecla >= 0)
					{
						if (tamanho == 2 || tamanho == 5)
						{
							valorCampo = mascaraData(valorCampo);
							this.value = valorCampo;
							return true;
						}
						else
						{
							return true;
						}
					}
				}
				
				return false;   // do contrário nega
			}
			
			campos[contAT].onvalidate = function()
			{
				eval(this.getAttribute("antesOnBlur"));
				
				var valorCampo = this.value;
				var valorFiltrado = "";
				var quant = 0;
				
				aux = mascaraData(valorCampo);
				valorCampo = aux;
				
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (valorCampo.charAt(contAT) >= 0 && valorCampo.charAt(contAT) <= 9 && valorCampo.charAt(contAT) != " ")
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
					
					if (valorCampo.charAt(contAT) == '/' && (contAT == 2 || contAT == 5))
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
				}
				this.value = valorFiltrado;
				
				aux = this.value;
				aux =  aux.replace('/', "");
				aux =  aux.replace('/', "");
				
				if (aux.indexOf("-") == -1 && aux.length == 8)
				{
					var separa = aux;
						separa = separa.split("",8);
					var dia = separa[0] + separa[1];
						dia = parseInt(dia);
					var mes = separa[2] + separa[3];
						mes = parseInt(mes);
					var ano = separa[4] + separa[5] + separa[6] + separa[7];
						ano = parseInt(ano);
					var bi4 = ano;
						bi4 = bi4%4;
						bi4 = parseInt(bi4);
					var bi400 = ano;
						bi400 = bi400%400;
						bi400 = parseInt(bi400);
					var bi100 = ano;
						bi100 = bi100%100;
						bi100 = parseInt(bi100);
					
					var hoje = new Date();
					var anoAtual = hoje.getFullYear();
					var mesAtual = hoje.getMonth() + 1;
					var diaAtual = hoje.getDate();
					var idade;
					
					if ((mesAtual >= mes) && (diaAtual >= dia))
					{
						idade = anoAtual - ano;
					}
					else
					{
						idade = anoAtual - ano - 1;
					}
					
					if ((dia >= 1 && dia <= 31) && (mes >= 1 && mes <= 12))
					{
						if (((bi4 == 0 && bi100 != 0) || (bi100 == 0 && bi400 == 0)))
						{
							if (((mes == 2 && dia <= 29) || (mes == 1 || mes == 3 || mes == 5 || mes == 7 ||  mes == 8 || mes == 10 || mes == 12 && dia <= 31) || (mes == 4 || mes == 6 || mes == 9 || mes == 11 && dia <= 30)) && (idade >= 15 && idade <= 80))
							{
								this.setAttribute("correto", 1);
							}
							else
							{
								this.setAttribute("correto", 0);
							}
						}
						else
						{
							if (((mes == 2 && dia <= 28) || (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 8 ||  mes == 10 || mes == 12 && dia <= 31) || (mes == 4 || mes == 6 ||mes == 9 || mes == 11 && dia <= 30)) && (idade >= 15 && idade <= 80))
							{
								this.setAttribute("correto", 1);
							}
							else
							{
								this.setAttribute("correto", 0);
							}
						}
					}
					else	
					{
						this.setAttribute("correto", 0);
					}
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
			
			
		}
		else if (atr == "Data")
		{
			campos[contAT].maxLength = 10;
			
			campos[contAT].onkeypress = function(e,args)
			{
				if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = '1234567890/';      // criando a lista de teclas permitidas
				var chr= String.fromCharCode(evt);      // pegando a tecla digitada
				
				if (valid_chars.indexOf(chr)>-1 || evt < 9)
				{
					var valorCampo = this.value;
					var valorFiltrado = "";
					var quant = 0;
					
					var index = valid_chars.indexOf(chr);
					var tecla = valid_chars.charAt(index);
					
					var tamanho = valorCampo.length;
					
					if (tecla == '/' && (tamanho == 2 || tamanho == 5))
					{
						return true;
					}
					
					if (tecla >= 0)
					{
						if (tamanho == 2 || tamanho == 5)
						{
							valorCampo = mascaraData(valorCampo);
							this.value = valorCampo;
							return true;
						}
						else
						{
							return true;
						}
					}
				}
				
				return false;   // do contrário nega
			}
			
			campos[contAT].onvalidate = function()
			{
				eval(this.getAttribute("antesOnBlur"));
				
				var valorCampo = this.value;
				var valorFiltrado = "";
				var quant = 0;
				
				aux = mascaraData(valorCampo);
				valorCampo = aux;
				
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (valorCampo.charAt(contAT) >= 0 && valorCampo.charAt(contAT) <= 9 && valorCampo.charAt(contAT) != " ")
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
					
					if (valorCampo.charAt(contAT) == '/' && (contAT == 2 || contAT == 5))
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
				}
				this.value = valorFiltrado;
				
				aux = this.value;
				aux =  aux.replace('/', "");
				aux =  aux.replace('/', "");
				
				if (aux.indexOf("-") == -1 && aux.length == 8)
				{
					var separa = aux;
						separa = separa.split("",8);
					var dia = separa[0] + separa[1];
						dia = parseInt(dia);
					var mes = separa[2] + separa[3];
						mes = parseInt(mes);
					var ano = separa[4] + separa[5] + separa[6] + separa[7];
						ano = parseInt(ano);
					var bi4 = ano;
						bi4 = bi4%4;
						bi4 = parseInt(bi4);
					var bi400 = ano;
						bi400 = bi400%400;
						bi400 = parseInt(bi400);
					var bi100 = ano;
						bi100 = bi100%100;
						bi100 = parseInt(bi100);
					
					if ((dia >= 1 && dia <= 31) && (mes >= 1 && mes <= 12))
					{
						if (((bi4 == 0 && bi100 != 0) || (bi100 == 0 && bi400 == 0)))
						{
							if (((mes == 2 && dia <= 29) || (mes == 1 || mes == 3 || mes == 5 || mes == 7 ||  mes == 8 || mes == 10 || mes == 12 && dia <= 31) || (mes == 4 || mes == 6 || mes == 9 || mes == 11 && dia <= 30)))
							{
								this.setAttribute("correto", 1);
							}
							else
							{
								this.setAttribute("correto", 0);
							}
						}
						else
						{
							if (((mes == 2 && dia <= 28) || (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 8 ||  mes == 10 || mes == 12 && dia <= 31) || (mes == 4 || mes == 6 ||mes == 9 || mes == 11 && dia <= 30)))
							{
								this.setAttribute("correto", 1);
							}
							else
							{
								this.setAttribute("correto", 0);
							}
						}
					}
					else	
					{
						this.setAttribute("correto", 0);
					}
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
			
			
		}
		else if (atr == "Nickname")
		{
			campos[contAT].maxLength = 15;
			
			campos[contAT].onvalidate = function()
			{
				var valorCampo = this.value;
				var valorFiltrado = "";
				var filtro = "abcdefghijlmnopqrstuvxzwykQWERTYUIOPASDFGHJKLÇZXCVBNM1234567890";
					
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (filtro.indexOf(valorCampo.charAt(contAT)) != -1)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
				}
				
				this.value = valorFiltrado;
				
				if (this.value == "")
				{
					this.setAttribute("correto", 0);
				}
				else
				{
					this.setAttribute("correto", 1);
				}
			}
			
			campos[contAT].onkeypress = function(e,args)
			{
				if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = 'abcdefghijlmnopqrstuvxzwykQWERTYUIOPASDFGHJKLÇZXCVBNM1234567890';      // criando a lista de teclas permitidas
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
			
			
		}
		else if (atr == "Celular")
		{
			campos[contAT].maxLength = 15;
			
			campos[contAT].onkeypress = function(e,args)
			{
				if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = '1234567890()- ';      // criando a lista de teclas permitidas
				var chr= String.fromCharCode(evt);      // pegando a tecla digitada
				
				if (valid_chars.indexOf(chr)>-1 || evt < 9)
				{
					var valorCampo = this.value;
					var valorFiltrado = "";
					var quant = 0;
					
					var index = valid_chars.indexOf(chr);
					var tecla = valid_chars.charAt(index);
					
					var tamanho = valorCampo.length;
					
					
					if (tecla == '(' && tamanho == 0)
					{
						return true;
					}
					else if (tecla == ')' && tamanho == 3)
					{
						return true;
					}
					else if (tecla == " " && tamanho == 4)
					{
						return true;
					}
					else if (tecla == '-' && tamanho == 10)
					{
						return true;
					}
					else if (tecla >= 0)
					{
						if (tamanho == 0 || tamanho == 3 || tamanho == 4 || tamanho == 10)
						{
							valorCampo = mascaraCelular(valorCampo);
							this.value = valorCampo;
							return true;
						}
						else
						{
							return true;
						}
					}
				}
				
				return false;   // do contrário nega
			}
			
			campos[contAT].onvalidate = function()
			{
				var valorCampo = this.value;
				var valorFiltrado = "";
				var quant = 0;
				
				aux = mascaraCelular(valorCampo);
				valorCampo = aux;
				
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (valorCampo.charAt(contAT) >= 0 && valorCampo.charAt(contAT) <= 9 && valorCampo.charAt(contAT) != " ")
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
					
					if (valorCampo.charAt(contAT) == '(' && contAT == 0)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
					
					if (valorCampo.charAt(contAT) == ')' && contAT == 3)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
					
					if (valorCampo.charAt(contAT) == " " && contAT == 4)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
					
					if (valorCampo.charAt(contAT) == "-" && contAT == 10)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
				}
				this.value = valorFiltrado;
				
				aux = this.value;
				aux =  aux.replace('(', "");
				aux =  aux.replace(')', "");
				aux =  aux.replace(" ", "");
				aux =  aux.replace('-', "");
				
				if (aux.length == 10 || aux.length == 11)
				{
					this.setAttribute("correto", 1);
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
			
			
		}
		else if (atr == "Telefone" || atr == "Fixo")
		{
			campos[contAT].maxLength = 14;
			
			campos[contAT].onkeypress = function(e,args)
			{
				if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = '1234567890()- ';      // criando a lista de teclas permitidas
				var chr= String.fromCharCode(evt);      // pegando a tecla digitada
				
				if (valid_chars.indexOf(chr)>-1 || evt < 9)
				{
					var valorCampo = this.value;
					var valorFiltrado = "";
					var quant = 0;
					
					var index = valid_chars.indexOf(chr);
					var tecla = valid_chars.charAt(index);
					
					var tamanho = valorCampo.length;
					
					
					if (tecla == '(' && tamanho == 0)
					{
						return true;
					}
					else if (tecla == ')' && tamanho == 3)
					{
						return true;
					}
					else if (tecla == " " && tamanho == 4)
					{
						return true;
					}
					else if (tecla == '-' && tamanho == 9)
					{
						return true;
					}
					else if (tecla >= 0)
					{
						if (tamanho == 0 || tamanho == 3 || tamanho == 4 || tamanho == 9)
						{
							valorCampo = mascaraFixo(valorCampo);
							this.value = valorCampo;
							return true;
						}
						else
						{
							return true;
						}
					}
				}
				
				return false;   // do contrário nega
			}
			
			campos[contAT].onvalidate = function()
			{
				var valorCampo = this.value;
				var valorFiltrado = "";
				var quant = 0;
				
				aux = mascaraFixo(valorCampo);
				valorCampo = aux;
				
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (valorCampo.charAt(contAT) >= 0 && valorCampo.charAt(contAT) <= 9 && valorCampo.charAt(contAT) != " ")
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
					
					if (valorCampo.charAt(contAT) == '(' && contAT == 0)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
					
					if (valorCampo.charAt(contAT) == ')' && contAT == 3)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
					
					if (valorCampo.charAt(contAT) == " " && contAT == 4)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
					
					if (valorCampo.charAt(contAT) == "-" && contAT == 9)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
				}
				this.value = valorFiltrado;
				
				aux = this.value;
				aux =  aux.replace('(', "");
				aux =  aux.replace(')', "");
				aux =  aux.replace(" ", "");
				aux =  aux.replace('-', "");
				
				if (aux.length == 10)
				{
					this.setAttribute("correto", 1);
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
			
			
		}
		else if (atr == "Nome")
		{
			campos[contAT].maxLength = 50;
			
			campos[contAT].onvalidate = function()
			{
				var valorCampo = this.value;
				var valorFiltrado = "";
				var filtro = "abcdefghijlmnopqrstuvxzwykçáàâãéèêíìîóòõôúùûQWERTYUIOPASDFGHJKLÇZXCVBNMÁÀÂÃÉÈÊÍÌÎÓÒÕÔÚÙÛ ";
					
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (filtro.indexOf(valorCampo.charAt(contAT)) != -1)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
				}
				
				this.value = valorFiltrado;
				this.value = this.value.trim();
				
				if (this.value != "")
				{
					this.setAttribute("correto", 1);
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
			
			campos[contAT].onkeypress = function(e,args)
			{
				if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = 'abcdefghijlmnopqrstuvxzwykçáàâãéèêíìîóòõôúùû QWERTYUIOPASDFGHJKLÇZXCVBNMÁÀÂÃÉÈÊÍÌÎÓÒÕÔÚÙÛ´`~^';      // criando a lista de teclas permitidas
				var chr= String.fromCharCode(evt);      // pegando a tecla digitada
				
				if (valid_chars.indexOf(chr)>-1 ) // se a tecla estiver na lista de permissão permite-a
				{
					return true;
				}
				
				return false;   // do contrário nega
			}
			
			
		}
		else if (atr == "Endereço" || atr == "Endereco")
		{
			campos[contAT].maxLength = 100;
			
			campos[contAT].onvalidate = function()
			{
				var valorCampo = this.value;
				var valorFiltrado = "";
				var filtro = "1234567890abcdefghijlmnopqrstuvxzwykçáàâãéèêíìîóòõôúùûQWERTYUIOPASDFGHJKLÇZXCVBNMÁÀÂÃÉÈÊÍÌÎÓÒÕÔÚÙÛ ,ªº/.()-&";
					
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (filtro.indexOf(valorCampo.charAt(contAT)) != -1)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
				}
				
				this.value = valorFiltrado;
				this.value = this.value.trim();
				
				if (this.value != "" && this.value.indexOf(',') != -1)
				{
					this.setAttribute("correto", 1);
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
			
			campos[contAT].onkeypress = function(e,args)
			{
				if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = '1234567890abcdefghijlmnopqrstuvxzwykçáàâãéèêíìîóòõôúùûQWERTYUIOPASDFGHJKLÇZXCVBNMÁÀÂÃÉÈÊÍÌÎÓÒÕÔÚÙÛ ,ªº/.()-&´`~^';      // criando a lista de teclas permitidas
				var chr= String.fromCharCode(evt);      // pegando a tecla digitada
				
				if (valid_chars.indexOf(chr)>-1 ) // se a tecla estiver na lista de permissão permite-a
				{
					return true;
				}
				
				return false;   // do contrário nega
			}
			
			
		}
		else if (atr == "CPF")
		{
			campos[contAT].maxLength = 14;
			
			campos[contAT].onvalidate = function()
			{
				var valorCampo = this.value;
				var valorFiltrado = "";
				var quant = 0;
				
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (valorCampo.charAt(contAT) >= 0 && valorCampo.charAt(contAT) <= 9 && valorCampo.charAt(contAT) != " ")
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
					
					if (valorCampo.charAt(contAT) == '.' && (contAT == 3 || contAT == 7))
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);

					}
					
					if (valorCampo.charAt(contAT) == '-' && contAT == 11)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
				}
				
				this.value = mascaraCPF(valorFiltrado);
				this.value = this.value.trim();
				
				if (this.value != "")
				{
					var cpf = this.value;
					xcpf = cpf.replace("-",".");
					vetorcpf = xcpf.split(".");
					
					// Separando por conjuntos
					var conjunto1 = vetorcpf[0];
					var conjunto2 = vetorcpf[1];
					var conjunto3 = vetorcpf[2];
					var conjunto4 = vetorcpf[3];
					
					if (conjunto1 == undefined || conjunto2 == undefined || conjunto3 == undefined || conjunto4 == undefined)
					{
						this.setAttribute("correto", 0);
					}
					else
					{
						// separando os conjuntos em dígitos separados
						vetor_conjunto1 = conjunto1.split("");
						vetor_conjunto2 = conjunto2.split("");
						vetor_conjunto3 = conjunto3.split("");
						vetor_conjunto4 = conjunto4.split("");
						
						var dig1_conj1 = vetor_conjunto1[0];
						var dig2_conj1 = vetor_conjunto1[1];
						var dig3_conj1 = vetor_conjunto1[2];

						var dig1_conj2 = vetor_conjunto2[0];
						var dig2_conj2 = vetor_conjunto2[1];
						var dig3_conj2 = vetor_conjunto2[2];

						var dig1_conj3 = vetor_conjunto3[0];
						var dig2_conj3 = vetor_conjunto3[1];
						var dig3_conj3 = vetor_conjunto3[2];

						var dig1_conj4 = vetor_conjunto4[0];
						var dig2_conj4 = vetor_conjunto4[1];

						// Obtenção primeiro dígito verificador
						 
						var xdig1_conj1 = dig1_conj1 * 10;
						var xdig2_conj1 = dig2_conj1 * 9;
						var xdig3_conj1 = dig3_conj1 * 8;
						
						var xdig1_conj2 = dig1_conj2 * 7;
						var xdig2_conj2 = dig2_conj2 * 6;
						var xdig3_conj2 = dig3_conj2 * 5;
						
						var xdig1_conj3 = dig1_conj3 * 4;
						var xdig2_conj3 = dig2_conj3 * 3;
						var xdig3_conj3 = dig3_conj3 * 2;
						
						var somatorio = xdig1_conj1+xdig2_conj1+xdig3_conj1+xdig1_conj2+xdig2_conj2+xdig3_conj2+xdig1_conj3+xdig2_conj3+xdig3_conj3;
						var resto = somatorio%11;

						if (resto < 2)
						{
							var digito = "0";
						}
						else
						{
							var digito=11-resto;
						}

						//------ Segundo Digito
						
						var xxdig1_conj1 = dig1_conj1 * 11;
						var xxdig2_conj1 = dig2_conj1 * 10;
						var xxdig3_conj1 = dig3_conj1 * 9;
						
						var xxdig1_conj2 = dig1_conj2 * 8;
						var xxdig2_conj2 = dig2_conj2 * 7;
						var xxdig3_conj2 = dig3_conj2 * 6;
						
						var xxdig1_conj3 = dig1_conj3 * 5;
						var xxdig2_conj3 = dig2_conj3 * 4;
						var xxdig3_conj3 = dig3_conj3 * 3;
						
						var xxdig1_conj4 = dig1_conj4 * 2;
						
						var somatorio =xxdig1_conj1+xxdig2_conj1+xxdig3_conj1+xxdig1_conj2+xxdig2_conj2+xxdig3_conj2+xxdig1_conj3+xxdig2_conj3+xxdig3_conj3+xxdig1_conj4;
						var xresto = somatorio%11;
											
						if (xresto < 2)
						{
							var xdigito = "0"
						}
						else 
						{
							var xdigito = 11-xresto;
						}
						
						var aux = this.value;
						
						aux = aux.replace('.', "");
						aux = aux.replace('.', "");
						aux = aux.replace('.', "");
						aux = aux.replace('-', "");
						
						var somaIgual = 0;
						var somaDiferente = 0;
						
						for (contAT = 0; contAT <= aux.length - 1; contAT = contAT + 1)
						{
							if (contAT != 0)
							{
								if (aux.charAt(0) == aux.charAt(contAT))
								{
									somaIgual = 1;
								}
								else
								{
									somaIgual = 0;
									break;
								}
							}
						}
						
						for (contAT = 0; contAT <= aux.length - 1; contAT = contAT + 1)
						{
							somaDiferente = somaDiferente + parseInt(aux.charAt(contAT));
						}
						
						if (somaIgual == 1 || somaDiferente == 54)
						{
							this.setAttribute("correto", 0);
						}
						else
						{
							if ((digito != dig1_conj4 || xdigito != dig2_conj4))
							{
								this.setAttribute("correto", 0);
							}
							else
							{
								this.setAttribute("correto", 1);
							}
						}
					}
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
			
			campos[contAT].onkeypress = function(e,args)
			{
				if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = '1234567890.-';      // criando a lista de teclas permitidas
				var chr= String.fromCharCode(evt);      // pegando a tecla digitada
				
				if (valid_chars.indexOf(chr)>-1 || evt < 9)
				{
					var valorCampo = this.value;
					var valorFiltrado = "";
					var quant = 0;
					
					var index = valid_chars.indexOf(chr);
					var tecla = valid_chars.charAt(index);
					
					var tamanho = valorCampo.length;
					
					if (tecla == '.' && (tamanho == 3 || tamanho == 7))
					{
						return true;
					}
					
					if (tecla == '-' && tamanho == 11)
					{
						return true;
					}
					
					if (tecla >= 0)
					{
						if (tamanho == 3 || tamanho == 7 || tamanho == 11)
						{
							valorCampo = mascaraCPF(valorCampo);
							this.value = valorCampo;
							return true;
						}
						else
						{
							return true;
						}
					}
				}
				
				return false;   // do contrário nega
			}
			
			
		}
		else if (atr == "RG")
		{
			campos[contAT].maxLength = 12;
			
			campos[contAT].onvalidate = function()
			{
				var valorCampo = this.value;
				var valorFiltrado = "";
				var filtro = "12345678909.-";
					
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (filtro.indexOf(valorCampo.charAt(contAT)) != -1)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
				}
				
				this.value = mascaraRG(valorFiltrado);
				this.value = this.value.trim();
				
				if (this.value != "")
				{
					var rg = this.value;
					
					while(rg.indexOf('.') != -1 || rg.indexOf('-') != -1)
					{
						rg = rg.replace('-', '');
						rg = rg.replace('.', '');
					}
					
					if (rg.length == 9)
					{
						var calculo = "";
							calculo = rg.split("");
						var mult = 2;
						var acu = 0;
						var contAT = 0;
						
						for (contAT = 0; contAT <= 7; contAT = contAT + 1)
						{
							calculo[contAT] = rg[contAT];
							calculo[contAT] = parseInt(calculo[contAT]);
							calculo[contAT] = calculo[contAT]*mult;
							acu = acu + calculo[contAT];
							mult = mult + 1;
						}
						
						calculo[8] = rg[8];
						calculo[8] = parseInt(calculo[8]);
						calculo[8] = calculo[8]*100;
						acu = acu + calculo[8];
						acu = acu%11;
						
						if (acu == 0)
						{
							this.setAttribute("correto", 1);
						}
						else
						{
							this.setAttribute("correto", 0);
						}
					}
					else
					{
						this.setAttribute("correto", 0);
					}	
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
			
			campos[contAT].onkeypress = function(e,args)
			{
				if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = '1234567890-.';      // criando a lista de teclas permitidas
				var chr= String.fromCharCode(evt);      // pegando a tecla digitada
				
				if (valid_chars.indexOf(chr)>-1 ) // se a tecla estiver na lista de permissão permite-a
				{
					var valorCampo = this.value;
					var valorFiltrado = "";
					var quant = 0;
					
					var index = valid_chars.indexOf(chr);
					var tecla = valid_chars.charAt(index);
					
					var tamanho = valorCampo.length;
					
					if (tecla == '.' && (tamanho == 2 || tamanho == 6))
					{
						return true;
					}
					else if (tecla == '-' && tamanho == 10)
					{
						return true;
					}
					else if (tecla >= 0)
					{
						if (tamanho == 2 || tamanho == 6 || tamanho == 10)
						{
							valorCampo = mascaraRG(valorCampo);
							this.value = valorCampo;
							return true;
						}
						else
						{
							return true;
						}
					}
				}
				
				return false;   // do contrário nega
			}
			
			
		}
		else if (atr == "TextoNaoObrigatorio")
		{
			campos[contAT].onvalidate = function()
			{
				var valorCampo = this.value;
				var valorFiltrado = "";
				var filtro = "1234567890-&()abcdefghijlmnopqrstuvxzwykçáàâãéèêíìîóòõôúùûQWERTYUIOPASDFGHJKLÇZXCVBNMÁÀÂÃÉÈÊÍÌÎÓÒÕÔÚÙÛ /,.ªº?:*!@#$%_";
					
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (filtro.indexOf(valorCampo.charAt(contAT)) != -1)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
				}
				
				this.value = valorFiltrado;
				this.value = this.value.trim();
				
				this.setAttribute("correto", 1);
				
			}
			
			campos[contAT].onkeypress = function(e,args)
			{
				if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = '1234567890-&()abcdefghijlmnopqrstuvxzwykçáàâãéèêíìîóòõôúùûQWERTYUIOPASDFGHJKLÇZXCVBNMÁÀÂÃÉÈÊÍÌÎÓÒÕÔÚÙÛ /,.ªº?:*!@#$%_';      // criando a lista de teclas permitidas
				var chr= String.fromCharCode(evt);      // pegando a tecla digitada
				
				if (valid_chars.indexOf(chr)>-1 ) // se a tecla estiver na lista de permissão permite-a
				{
					return true;
				}
				
				return false;   // do contrário nega
			}
			
			
		}
		else if (atr == "TextoObrigatorio" || atr == "Texto")
		{
			campos[contAT].onvalidate = function()
			{
				var valorCampo = this.value;
				var valorFiltrado = "";
				var filtro = "1234567890-&()abcdefghijlmnopqrstuvxzwykçáàâãéèêíìîóòõôúùûQWERTYUIOPASDFGHJKLÇZXCVBNMÁÀÂÃÉÈÊÍÌÎÓÒÕÔÚÙÛ /,.ªº?*:$!@#%_";
					
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (filtro.indexOf(valorCampo.charAt(contAT)) != -1)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
				}
				
				this.value = valorFiltrado;
				this.value = this.value.trim();
				
				if (this.value != "")
				{
					//validação de RG
					this.setAttribute("correto", 1);
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
			
			campos[contAT].onkeypress = function(e,args)
			{
				if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = '1234567890-&()abcdefghijlmnopqrstuvxzwykçáàâãéèêíìîóòõôúùûQWERTYUIOPASDFGHJKLÇZXCVBNMÁÀÂÃÉÈÊÍÌÎÓÒÕÔÚÙÛ /,.ªº?:*!@#$%_';      // criando a lista de teclas permitidas
				var chr= String.fromCharCode(evt);      // pegando a tecla digitada
				
				if (valid_chars.indexOf(chr)>-1 ) // se a tecla estiver na lista de permissão permite-a
				{
					return true;
				}
				
				return false;   // do contrário nega
			}
			
			
		}
		else if (atr == "IMEI")
		{
			campos[contAT].maxLength = 19;
			
			campos[contAT].onkeypress = function(e,args)
			{
				if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = "1234567890-";      // criando a lista de teclas permitidas
				var chr = String.fromCharCode(evt);      // pegando a tecla digitada
				
				if (valid_chars.indexOf(chr)>-1 ) // se a tecla estiver na lista de permissão permite-a
				{
					var valorCampo = this.value;
					var index = valid_chars.indexOf(chr);
					var tecla = valid_chars.charAt(index);
					
					var tamanho = valorCampo.length;
					
					if (tecla == '-' && (tamanho == 2 || tamanho == 7 || tamanho == 10 || tamanho == 17))
					{
						return true;
					}
					else if (tecla >= 0)
					{
						if (tamanho == 2 || tamanho == 7 || tamanho == 10 || tamanho == 17)
						{
							valorCampo = mascaraIMEI(valorCampo);
							this.value = valorCampo;
							return true;
						}
						else
						{
							return true;
						}
					}
				}
				
				return false;   // do contrário nega
			}
			
			campos[contAT].onvalidate = function()
			{
				var valorCampo = this.value;
				var valorFiltrado = "";
				var quant = 0;
				var filtro = "1234567890-";
					
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (filtro.indexOf(valorCampo.charAt(contAT)) != -1)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
				}
				
				this.value = mascaraIMEI(valorFiltrado);
				this.value = this.value.trim();
				
				if (this.value.length == this.maxLength)
				{
					var IMEI = this.value;
					
					while(IMEI.indexOf('-') != -1 || IMEI.indexOf('.') != -1)
					{
						IMEI = IMEI.replace('-', '');
						IMEI = IMEI.replace('.', '');
					}
					
					var digitoVerificador = IMEI[IMEI.length - 1];
					var calculo = IMEI.split("");
					calculo.splice(calculo.length - 1, 1);
					var soma = 0;
					var contAT;
					
					for (contAT = calculo.length; contAT >= 1; contAT = contAT - 1)
					{
						if (cont%2 == 0)
						{
							if ((parseInt(calculo[contAT - 1])*2) >= 10)
							{
								aux = (parseInt(calculo[contAT - 1])*2);
								aux = aux.toString().split("");
								
								aux = parseInt(aux[0]) + parseInt(aux[1]);
								
								soma = soma + aux;
							}
							else
							{
								soma = soma + (parseInt(calculo[contAT - 1])*2);
							}
						}
						else
						{
							soma = soma + parseInt(calculo[contAT - 1]);
						}
					}
					
					var calculoDigito = soma%10;
					
					if (calculoDigito != 0)
					{
						calculoDigito = 10 - soma%10;
					}
					
					if (digitoVerificador == calculoDigito)
					{
						this.setAttribute("correto", 1);
					}
					else
					{
						this.setAttribute("correto", 0);
					}
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
			
			
		}
		else if (atr == "Real")
		{
			campos[contAT].maxLength = 11;
			
			campos[contAT].onkeypress = function(e,args)
			{
				if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = "R$1234567890, -";      // criando a lista de teclas permitidas
				var chr = String.fromCharCode(evt).toUpperCase();      // pegando a tecla digitada
				var tecla = chr;
				
				if (valid_chars.indexOf(chr) > -1) // se a tecla estiver na lista de permissão permite-a
				{
					var valorCampo = this.value;
					var index = valid_chars.indexOf(chr);
					
					var tamanho = valorCampo.length;
					
					if (tecla == 'R' && tamanho == 0)
					{
						return true;
					}
					else if (tecla == '$' && tamanho == 1)
					{
						return true;
					}
					else if (tecla == " " && tamanho == 2)
					{
						return true;
					}
					else if (tecla == '-' && tamanho == 3)
					{
						return true;
					}
					else if (tecla == ',' && this.value.indexOf(tecla) == -1)
					{
						return true;
					}
					else if (tecla >= 0)
					{
						if (tamanho == 0)
						{
							valorCampo = mascaraReal(valorCampo);
							this.value = valorCampo;
						}
						
						return true;
					}
				}
				
				return false;   // do contrário nega
			}
			
			campos[contAT].onvalidate = function()
			{
				var valorCampo = this.value;
				var valorFiltrado = "";
				var quant = 0;
				var filtro = "R$1234567890, -";
					
				while(valorCampo.indexOf('.') != -1)
				{
					valorCampo = valorCampo.replace('.', ',');
				}
				
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (valorCampo.charAt(contAT) == 'R' && contAT == 0)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
					else if (valorCampo.charAt(contAT) == '$' && contAT == 1)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
					else if (valorCampo.charAt(contAT) == " " && contAT == 2)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
					else if (valorCampo.charAt(contAT) == '-' && contAT == 3)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
					else if (valorCampo.charAt(contAT) == ',' && valorFiltrado.indexOf(valorCampo.charAt(contAT)) == -1)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
					else if (filtro.indexOf(valorCampo.charAt(contAT)) != -1)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
				}
				
				this.value = mascaraReal(valorFiltrado);
				this.value = this.value.trim();
				
				var real = this.value;
				
				while(real.indexOf('R') != -1 || real.indexOf('$') != -1 || real.indexOf(' ') != -1)
				{
					real = real.replace('R', '');
					real = real.replace('$', '');
					real = real.replace(' ', '');
				}
				
				if (real != '')
				{
					this.setAttribute("correto", 1);
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
			
			
		}
		else if (atr == "Inteiro" || atr == "NumeroInteiro" || atr == "Int" || atr == "int")
		{
			campos[contAT].maxLength = 11;
			
			campos[contAT].onkeypress = function(e,args)
			{
				if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = "1234567890";      // criando a lista de teclas permitidas
				var chr = String.fromCharCode(evt);      // pegando a tecla digitada
				
				if (valid_chars.indexOf(chr)>-1 ) // se a tecla estiver na lista de permissão permite-a
				{
					return true;
				}
				
				return false;   // do contrário nega
			}
			
			campos[contAT].onvalidate = function()
			{
				var valorCampo = this.value;
				var valorFiltrado = "";
				var quant = 0;
				var filtro = "1234567890";
					
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (filtro.indexOf(valorCampo.charAt(contAT)) != -1)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
				}
				
				this.value = valorFiltrado;
				
				if (this.value != '')
				{
					this.setAttribute("correto", 1);
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
			
			
		}
		else if (atr == "numeroSerie")
		{
			campos[contAT].maxLength = 20;
			campos[contAT].style.textTransform = 'uppercase';
			
			campos[contAT].onkeypress = function(e,args)
			{
				if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = "1234567890QWERTYUIOPASDFGHJKLÇZXCVBNMqwertyuiopasdfghjklçzxcvbnm";      // criando a lista de teclas permitidas
				var chr = String.fromCharCode(evt);      // pegando a tecla digitada
				
				if (valid_chars.indexOf(chr)>-1 ) // se a tecla estiver na lista de permissão permite-a
				{
					return true;
				}
				
				return false;   // do contrário nega
			}
			
			campos[contAT].onvalidate = function()
			{
				var valorCampo = this.value;
				var valorFiltrado = "";
				var quant = 0;
				var filtro = "1234567890QWERTYUIOPASDFGHJKLZXCVBNMÇqwertyuiopasdfghjklçzxcvbnm";
					
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (filtro.indexOf(valorCampo.charAt(contAT)) != -1)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
				}
				
				this.value = valorFiltrado;
				
				if (this.value != '')
				{
					this.setAttribute("correto", 1);
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
		}
		else if (atr == "bin")
		{
			//campos[contAT].maxLength = 20;
			campos[contAT].style.textTransform = 'uppercase';
			
			campos[contAT].onkeypress = function(e,args)
			{
				if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = "01";      // criando a lista de teclas permitidas
				var chr = String.fromCharCode(evt);      // pegando a tecla digitada
				
				if (valid_chars.indexOf(chr)>-1 ) // se a tecla estiver na lista de permissão permite-a
				{
					return true;
				}
				
				return false;   // do contrário nega
			}
			
			campos[contAT].onvalidate = function()
			{
				var valorCampo = this.value;
				var valorFiltrado = "";
				var quant = 0;
				var filtro = "01";
					
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (filtro.indexOf(valorCampo.charAt(contAT)) != -1)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
				}
				
				this.value = valorFiltrado;
				
				if (this.value != '')
				{
					this.setAttribute("correto", 1);
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
		}
		else if (atr == "dec")
		{
			//campos[contAT].maxLength = 20;
			campos[contAT].style.textTransform = 'uppercase';
			
			campos[contAT].onkeypress = function(e,args)
			{
				if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = "0123456789";      // criando a lista de teclas permitidas
				var chr = String.fromCharCode(evt);      // pegando a tecla digitada
				
				if (valid_chars.indexOf(chr)>-1 ) // se a tecla estiver na lista de permissão permite-a
				{
					return true;
				}
				
				return false;   // do contrário nega
			}
			
			campos[contAT].onvalidate = function()
			{
				var valorCampo = this.value;
				var valorFiltrado = "";
				var quant = 0;
				var filtro = "0123456789";
					
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (filtro.indexOf(valorCampo.charAt(contAT)) != -1)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
				}
				
				this.value = valorFiltrado;
				
				if (this.value != '')
				{
					this.setAttribute("correto", 1);
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
		}
		else if (atr == "hex")
		{
			//campos[contAT].maxLength = 20;
			campos[contAT].style.textTransform = 'uppercase';
			
			campos[contAT].onkeypress = function(e,args)
			{
				if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = "0123456789ABCDEFabcdef";      // criando a lista de teclas permitidas
				var chr = String.fromCharCode(evt);      // pegando a tecla digitada
				
				if (valid_chars.indexOf(chr)>-1 ) // se a tecla estiver na lista de permissão permite-a
				{
					return true;
				}
				
				return false;   // do contrário nega
			}
			
			campos[contAT].onvalidate = function()
			{
				var valorCampo = this.value;
				var valorFiltrado = "";
				var quant = 0;
				var filtro = "0123456789ABCDEFabcdef";
					
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (filtro.indexOf(valorCampo.charAt(contAT)) != -1)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
				}
				
				this.value = valorFiltrado;
				
				if (this.value != '')
				{
					this.setAttribute("correto", 1);
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
		}
		else if (atr == "oct")
		{
			//campos[contAT].maxLength = 20;
			campos[contAT].style.textTransform = 'uppercase';
			
			campos[contAT].onkeypress = function(e,args)
			{
				if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = "01234567";      // criando a lista de teclas permitidas
				var chr = String.fromCharCode(evt);      // pegando a tecla digitada
				
				if (valid_chars.indexOf(chr)>-1 ) // se a tecla estiver na lista de permissão permite-a
				{
					return true;
				}
				
				return false;   // do contrário nega
			}
			
			campos[contAT].onvalidate = function()
			{
				var valorCampo = this.value;
				var valorFiltrado = "";
				var quant = 0;
				var filtro = "01234567";
					
				for (contAT = 0; contAT <= valorCampo.length - 1; contAT = contAT + 1)
				{
					if (filtro.indexOf(valorCampo.charAt(contAT)) != -1)
					{
						valorFiltrado = valorFiltrado + valorCampo.charAt(contAT);
					}
				}
				
				this.value = valorFiltrado;
				
				if (this.value != '')
				{
					this.setAttribute("correto", 1);
				}
				else
				{
					this.setAttribute("correto", 0);
				}
			}
		}
		//------------------
		
		if (campos[contAT].onblur == null)
		{
			campos[contAT].onblur = campos[contAT].onvalidate;
		}
		
		campos[contAT].oninput = campos[contAT].onkeypress;
	}
}

function mascaraCelular(valorCampo)
{
	var auxtroca,auxvetor;
	
	while(valorCampo.indexOf('(') != -1 || valorCampo.indexOf(')') != -1 || valorCampo.indexOf(' ') != -1 || valorCampo.indexOf('-') != -1)
	{
		valorCampo = valorCampo.replace('(', '');
		valorCampo = valorCampo.replace(')', '');
		valorCampo = valorCampo.replace(' ', '');
		valorCampo = valorCampo.replace('-', '');
	}
	
	for (posicao = 0; posicao <= valorCampo.length; posicao = posicao + 1)
	{
		if (posicao == 0 && valorCampo.charAt(0) != '(')
		{
			auxvetor = valorCampo.split("");
			auxvetor.splice(posicao, 0, '(');
			
			valorCampo = "";
			for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
			{
				valorCampo = valorCampo + auxvetor[contAT];
			}
		}
		
		if (posicao == 3 && valorCampo.charAt(3) != ')')
		{
			auxvetor = valorCampo.split("");
			auxvetor.splice(posicao, 0, ')');
			
			valorCampo = "";
			for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
			{
				valorCampo = valorCampo + auxvetor[contAT];
			}
		}
		
		if (posicao == 4 && valorCampo.charAt(4) != " ")
		{
			auxvetor = valorCampo.split("");
			auxvetor.splice(posicao, 0, ' ');
			
			valorCampo = "";
			for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
			{
				valorCampo = valorCampo + auxvetor[contAT];
			}
		}
		
		if (posicao == 10 && valorCampo.charAt(10) != '-')
		{
			auxvetor = valorCampo.split("");
			auxvetor.splice(posicao, 0, '-');
			
			valorCampo = "";
			for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
			{
				valorCampo = valorCampo + auxvetor[contAT];
			}
		}
	}
	
	return valorCampo;
}

function mascaraReal(valorCampo)
{
	var auxtroca,auxvetor;
	
	valorCampo = valorCampo.toString();
	
	while(valorCampo.indexOf('R') != -1 || valorCampo.indexOf('$') != -1 || valorCampo.indexOf(' ') != -1)
	{
		valorCampo = valorCampo.replace('R', '');
		valorCampo = valorCampo.replace('$', '');
		valorCampo = valorCampo.replace(' ', '');
	}
	
	for (posicao = 0; posicao <= valorCampo.length; posicao = posicao + 1)
	{
		if (posicao == 0 && valorCampo.charAt(0) != 'R')
		{
			auxvetor = valorCampo.split("");
			auxvetor.splice(posicao, 0, 'R');
			
			valorCampo = "";
			for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
			{
				valorCampo = valorCampo + auxvetor[contAT];
			}
		}
		
		if (posicao == 1 && valorCampo.charAt(1) != '$')
		{
			auxvetor = valorCampo.split("");
			auxvetor.splice(posicao, 0, '$');
			
			valorCampo = "";
			for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
			{
				valorCampo = valorCampo + auxvetor[contAT];
			}
		}
		
		if (posicao == 2 && valorCampo.charAt(2) != " ")
		{
			auxvetor = valorCampo.split("");
			auxvetor.splice(posicao, 0, ' ');
			
			valorCampo = "";
			for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
			{
				valorCampo = valorCampo + auxvetor[contAT];
			}
		}
	}
	
	while(valorCampo.indexOf('.') != -1)
	{
		valorCampo = valorCampo.replace('.', ',');
	}
	
	auxvetor = valorCampo.split(',');
	
	while (auxvetor.length > 2)
	{
		auxvetor.splice(auxvetor.length - 1, 1);
	}
	
	if (auxvetor.length == 2)
	{
		var auxdecimal = '';
		
		if (auxvetor[1].toString().length < 2)
		{
			//auxdecimal = auxvetor[1][0] + '0';
		}
		else
		{
			auxdecimal = auxvetor[1][0] + auxvetor[1][1];
			auxvetor.splice(1, 1);
			auxvetor.push(auxdecimal);
		}
		
	}
	
	valorCampo = "";
	for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
	{
		if (contAT == 0)
		{
			valorCampo = valorCampo + auxvetor[contAT];
		}
		else
		{
			valorCampo = valorCampo + ',' + auxvetor[contAT];
		}
	}
	
	return valorCampo;
}

function mascaraFixo(valorCampo)
{
	var auxtroca,auxvetor;
	
	while(valorCampo.indexOf('(') != -1 || valorCampo.indexOf(')') != -1 || valorCampo.indexOf(' ') != -1 || valorCampo.indexOf('-') != -1)
	{
		valorCampo = valorCampo.replace('(', '');
		valorCampo = valorCampo.replace(')', '');
		valorCampo = valorCampo.replace(' ', '');
		valorCampo = valorCampo.replace('-', '');
	}
	
	for (posicao = 0; posicao <= valorCampo.length; posicao = posicao + 1)
	{
		if (posicao == 0 && valorCampo.charAt(0) != '(')
		{
			auxvetor = valorCampo.split("");
			auxvetor.splice(posicao, 0, '(');
			
			valorCampo = "";
			for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
			{
				valorCampo = valorCampo + auxvetor[contAT];
			}
		}
		
		if (posicao == 3 && valorCampo.charAt(3) != ')')
		{
			auxvetor = valorCampo.split("");
			auxvetor.splice(posicao, 0, ')');
			
			valorCampo = "";
			for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
			{
				valorCampo = valorCampo + auxvetor[contAT];
			}
		}
		
		if (posicao == 4 && valorCampo.charAt(4) != " ")
		{
			auxvetor = valorCampo.split("");
			auxvetor.splice(posicao, 0, ' ');
			
			valorCampo = "";
			for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
			{
				valorCampo = valorCampo + auxvetor[contAT];
			}
		}
		
		if (posicao == 9 && valorCampo.charAt(9) != '-')
		{
			auxvetor = valorCampo.split("");
			auxvetor.splice(posicao, 0, '-');
			
			valorCampo = "";
			for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
			{
				valorCampo = valorCampo + auxvetor[contAT];
			}
		}
	}
	
	return valorCampo;
}

function mascaraData(valorCampo)
{
	var auxtroca,auxvetor;
	
	while(valorCampo.indexOf('/') != -1)
	{
		valorCampo = valorCampo.replace('/', '');
	}
	
	for (posicao = 0; posicao <= valorCampo.length; posicao = posicao + 1)
	{
		if (posicao == 2 && valorCampo.charAt(2) != '/')
		{
			auxvetor = valorCampo.split("");
			auxvetor.splice(posicao, 0, '/');
			
			valorCampo = "";	
			for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
			{
				valorCampo = valorCampo + auxvetor[contAT];
			}
		}
		
		if (posicao == 5 && valorCampo.charAt(5) != '/')
		{
			auxvetor = valorCampo.split("");
			auxvetor.splice(posicao, 0, '/');
			
			valorCampo = "";	
			for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
			{
				valorCampo = valorCampo + auxvetor[contAT];
			}
		}
	}
	
	return valorCampo;
}



function mascaraRG(valorCampo)
{
	var auxtroca,auxvetor;
	
	while(valorCampo.indexOf('.') != -1 || valorCampo.indexOf('-') != -1)
	{
		valorCampo = valorCampo.replace('.', '');
		valorCampo = valorCampo.replace('-', '');
	}
	
	for (posicao = 0; posicao <= valorCampo.length; posicao = posicao + 1)
	{
		if (posicao == 2 && valorCampo.charAt(2) != '.')
		{
			auxvetor = valorCampo.split("");
			auxvetor.splice(posicao, 0, '.');
			
			valorCampo = "";
			for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
			{
				valorCampo = valorCampo + auxvetor[contAT];
			}
		}
		
		if (posicao == 6 && valorCampo.charAt(6) != '.')
		{
			auxvetor = valorCampo.split("");
			auxvetor.splice(posicao, 0, '.');
			
			valorCampo = "";
			for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
			{
				valorCampo = valorCampo + auxvetor[contAT];
			}
		}
		
		if (posicao == 10 && valorCampo.charAt(10) != '-')
		{
			auxvetor = valorCampo.split("");
			auxvetor.splice(posicao, 0, '-');
			
			valorCampo = "";
			for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
			{
				valorCampo = valorCampo + auxvetor[contAT];
			}
		}
	}
		
	return valorCampo;
}

function mascaraCPF(valorCampo)
{
	var auxtroca,auxvetor;
	
	while(valorCampo.indexOf('.') != -1 || valorCampo.indexOf('-') != -1)
	{
		valorCampo = valorCampo.replace('.', '');
		valorCampo = valorCampo.replace('-', '');
	}
	
	for (posicao = 0; posicao <= valorCampo.length; posicao = posicao + 1)
	{
		if (posicao == 3 && valorCampo.charAt(3) != '.')
		{
			auxvetor = valorCampo.split("");
			auxvetor.splice(posicao, 0, '.');
			
			valorCampo = "";
			for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
			{
				valorCampo = valorCampo + auxvetor[contAT];
			}
		}
		
		if (posicao == 7 && valorCampo.charAt(7) != '.')
		{
			auxvetor = valorCampo.split("");
			auxvetor.splice(posicao, 0, '.');
			
			valorCampo = "";
			for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
			{
				valorCampo = valorCampo + auxvetor[contAT];
			}
		}
		
		if (posicao == 11 && valorCampo.charAt(11) != '-')
		{
			auxvetor = valorCampo.split("");
			auxvetor.splice(posicao, 0, '-');
			
			valorCampo = "";
			for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
			{
				valorCampo = valorCampo + auxvetor[contAT];
			}
		}
	}
		
	return valorCampo;
}

function mascaraIMEI(valorCampo)
{
	var auxtroca,auxvetor;
	
	while(valorCampo.indexOf('.') != -1 || valorCampo.indexOf('-') != -1)
	{
		valorCampo = valorCampo.replace('.', '');
		valorCampo = valorCampo.replace('-', '');
	}
	
	for (posicao = 0; posicao <= valorCampo.length; posicao = posicao + 1)
	{
		if (posicao == 2 && valorCampo.charAt(2) != '-')
		{
			auxvetor = valorCampo.split("");
			auxvetor.splice(posicao, 0, '-');
			
			valorCampo = "";
			for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
			{
				valorCampo = valorCampo + auxvetor[contAT];
			}
		}
		
		if (posicao == 7 && valorCampo.charAt(7) != '-')
		{
			auxvetor = valorCampo.split("");
			auxvetor.splice(posicao, 0, '-');
			
			valorCampo = "";
			for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
			{
				valorCampo = valorCampo + auxvetor[contAT];
			}
		}
		
		if (posicao == 10 && valorCampo.charAt(10) != '-')
		{
			auxvetor = valorCampo.split("");
			auxvetor.splice(posicao, 0, '-');
			
			valorCampo = "";
			for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
			{
				valorCampo = valorCampo + auxvetor[contAT];
			}
		}
		
		if (posicao == 17 && valorCampo.charAt(17) != '-')
		{
			auxvetor = valorCampo.split("");
			auxvetor.splice(posicao, 0, '-');
			
			valorCampo = "";
			for (contAT = 0; contAT <= auxvetor.length - 1; contAT = contAT + 1)
			{
				valorCampo = valorCampo + auxvetor[contAT];
			}
		}
	}
		
	return valorCampo;
}

function base64_encode(data) 
{
	//  discuss at: http://phpjs.org/functions/base64_encode/
	// original by: Tyler Akins (http://rumkin.com)
	// improved by: Bayron Guevara
	// improved by: Thunder.m
	// improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// improved by: Rafał Kukawski (http://kukawski.pl)
	// bugfixed by: Pellentesque Malesuada
	//   example 1: base64_encode('Kevin van Zonneveld');
	//   returns 1: 'S2V2aW4gdmFuIFpvbm5ldmVsZA=='
	//   example 2: base64_encode('a');
	//   returns 2: 'YQ=='

	var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
	var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
		ac = 0,
		enc = '',
		tmp_arr = [];

	if (!data) 
	{
		return data;
	}

	do 
	{ // pack three octets into four hexets
		o1 = data.charCodeAt(i++);
		o2 = data.charCodeAt(i++);
		o3 = data.charCodeAt(i++);

		bits = o1 << 16 | o2 << 8 | o3;

		h1 = bits >> 18 & 0x3f;
		h2 = bits >> 12 & 0x3f;
		h3 = bits >> 6 & 0x3f;
		h4 = bits & 0x3f;

		// use hexets to index into b64, and append result to encoded string
		tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
	} 
	while (i < data.length);

	enc = tmp_arr.join('');

	var r = data.length % 3;

	return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);
}

function base64_decode(data) {
  //  discuss at: http://phpjs.org/functions/base64_decode/
  // original by: Tyler Akins (http://rumkin.com)
  // improved by: Thunder.m
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  //    input by: Aman Gupta
  //    input by: Brett Zamir (http://brett-zamir.me)
  // bugfixed by: Onno Marsman
  // bugfixed by: Pellentesque Malesuada
  // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  //   example 1: base64_decode('S2V2aW4gdmFuIFpvbm5ldmVsZA==');
  //   returns 1: 'Kevin van Zonneveld'
  //   example 2: base64_decode('YQ===');
  //   returns 2: 'a'

  var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
  var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
    ac = 0,
    dec = '',
    tmp_arr = [];

  if (!data) {
    return data;
  }

  data += '';

  do { // unpack four hexets into three octets using index points in b64
    h1 = b64.indexOf(data.charAt(i++));
    h2 = b64.indexOf(data.charAt(i++));
    h3 = b64.indexOf(data.charAt(i++));
    h4 = b64.indexOf(data.charAt(i++));

    bits = h1 << 18 | h2 << 12 | h3 << 6 | h4;

    o1 = bits >> 16 & 0xff;
    o2 = bits >> 8 & 0xff;
    o3 = bits & 0xff;

    if (h3 == 64) {
      tmp_arr[ac++] = String.fromCharCode(o1);
    } else if (h4 == 64) {
      tmp_arr[ac++] = String.fromCharCode(o1, o2);
    } else {
      tmp_arr[ac++] = String.fromCharCode(o1, o2, o3);
    }
  } while (i < data.length);

  dec = tmp_arr.join('');

  return dec.replace(/\0+$/, '');
}

function ConexaoInternet()
{
	try
	{
		/*if (navigator.connection == undefined)
		{
			
			var page = "https://www.google.com/images/errors/logo_sm.gif"; 
			
			var ImageObject = new Image();
				ImageObject.src = page;

			if (ImageObject.height > 0) 
			{
				return true;
			} 
			else 
			{
				return false;
			}
			
			
			
		}
		else*/
		if (!navigator.connection == undefined)
		{
			var networkState = navigator.connection.type;

			var states = {};
			states[Connection.UNKNOWN]  = 'Unknown connection';
			states[Connection.ETHERNET] = 'Ethernet connection';
			states[Connection.WIFI]     = 'WiFi connection';
			states[Connection.CELL_2G]  = 'Cell 2G connection';
			states[Connection.CELL_3G]  = 'Cell 3G connection';
			states[Connection.CELL_4G]  = 'Cell 4G connection';
			states[Connection.CELL]     = 'Cell generic connection';
			states[Connection.NONE]     = 'No network connection';

			if (states[networkState] == 'No network connection')
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		else if (navigator.onLine) 
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}
	catch (error)
	{
		alert(error.message);
	}
}

function GetParametros()
{
	var array = {};
	
	var parametros = location.search.slice(1);
		parametros = parametros.split('&');
	
	parametros.forEach
	(
		function (parametro)
		{
			var nome = parametro.split('=')[0];
			var valor = parametro.split('=')[1];
			
			array[nome] = valor;
		}
	);
	
	return array;
}