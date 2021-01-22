function Ajax(metodo, url, parametros, retorno)
{
	try
	{
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		    ajax = new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
		    ajax = new ActiveXObject("Microsoft.XMLHTTP");
		}
			
		ajax.onreadystatechange = function()
		{
			if (this.readyState == 4 && this.status == 200)
			{
				if (retorno != "")
				{
					eval(retorno);
				}
			}
		}
		
		if (metodo == "GET")
		{
			ajax.open(metodo, url + ((parametros != "") ? "?" + parametros : ""))
			ajax.send();
		
		}
		else if (metodo == "POST")
		{
			ajax.open(metodo, url)
			ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			ajax.send(parametros);
		}
	}
	catch (exe)
	{
		console.log(exe.message);
	}
}

function AjaxForm(form, espera, retorno)
{
	try
	{
		if (espera != "")
		{
			try
			{
				eval(espera());
			}
			catch (e)
			{
				eval(espera);
			}
		}
		
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		   var ajax = new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
		   var ajax = new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		if (typeof FormData == "undefined")
		{
			var formData = $('#' + form.id).formSerialize();
		}
		else
		{
			var formData = new FormData(form);
		}
		
		ajax.onreadystatechange = function()
		{
			if (this.readyState == 4 && this.status == 200)
			{
				if (retorno != "")
				{
					try
					{
						eval(retorno(this));
					}
					catch (e)
					{
						eval(retorno);
					}
				}
			}
		}
		
		ajax.open(form.method, form.action);
		
		if (typeof FormData == "undefined")
		{
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		}
		
		ajax.send(formData);
	}
	catch (exe)
	{
		console.log(exe.message);
	}
}