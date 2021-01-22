window.onhashchange = function()
{
	ControleHash(window.location.hash, event);
}

function LimparHash()
{
	try
	{
		if (desativado == 1)
		{
			Frm_DesativarConta.reset(); Logout();
		}
	}
	catch (e)
	{
		console.log(e.message);
	}
	
	try
	{
		CloseHelp();
	}
	catch (e)
	{
		console.log(e.message);
	}
	
	try
	{
		CloseOrder();
	}
	catch (e)
	{
		console.log(e.message);
	}
	
	try
	{
		CloseQuestion();
	}
	catch (e)
	{
		console.log(e.message);
	}
	
	try
	{
		CloseMenu();
	}
	catch (e)
	{
		console.log(e.message);
	}
	
	try
	{
		CloseAlert();
	}
	catch (e)
	{
		console.log(e.message);
	}
	
	try
	{
		closeRecover();
	}
	catch (e)
	{
		console.log(e.message);
	}
}

function ControleHash(hash, event)
{
	LimparHash();
	
	if (hash == '#et_menu_bar')
	{
		try
		{
			OpenMenu();
		}
		catch (e)
		{
			console.log(e.message);
		}
	}
	else if ((hash == '#alert' || hash == '#loading' || hash == '#synchro'))
	{
		if (event.type == 'hashchange')
		{
			OpenAlert();
		}
		else
		{
			history.back();
		}
	}
	else if (hash == '#et_forgot')
	{
		try
		{
			openRecover();
			CloseAlert();
		}
		catch (e)
		{
			console.log(e.message);
		}
	}
	else if (hash == '#alert_forgot')
	{
		if (event.type == 'hashchange')
		{
			try
			{
				closeRecover();
				openRecover();
				OpenAlert();
				et_cover.style.zIndex = 9980;
			}
			catch (e)
			{
				console.log(e.message);
			}
		}
		else
		{
			history.back();
		}
	}
	else if (hash == '#help' || hash == '#more' || hash == '#termos')
	{
		try
		{
			OpenHelp();
		}
		catch (e)
		{
			console.log(e.message);
		}
	}
	else if (hash == '#question')
	{
		if (event.type == 'hashchange')
		{
			OpenQuestion();
		}
		else
		{
			history.back();
		}
	}
	else if (hash == '#order')
	{
		OpenOrder();
	}
}

function OpenAlert()
{
	try
	{
		et_cover.style.display = "inline-block";
		et_cover.style.visibility = "visible";
		et_cover.style.opacity = "1";
		et_message.style.display = "inline-block";
		et_message.style.visibility = "visible";
		et_message.style.opacity = "1";
	}
	catch (e)
	{
		try
		{
			error.style.display = "inline-block";
			error.style.visibility = "visible";
			error.style.opacity = "1";
		}
		catch (exe)
		{
			console.log(exe.message);
		}
	}
}

function CloseAlert()
{
	try
	{
		if (ic == 1)
		{
			ic = 0;
			SincronizarDados(codigo);
		}
		else if (ic == 2)
		{
			et_cover.style.zIndex = 9960;
			et_cover.style.opacity = "1";
			et_cover.style.display = "inline-block";
			et_cover.style.visibility = "visible";
		}
		else
		{
			et_cover.style.opacity = "0";
			et_cover.style.visibility = "hidden";				
			et_cover.style.display = "none";				
		}
		
		message_ok.style.visibility = "hidden";
		et_message.style.opacity = "0";
		et_message.style.visibility = "hidden";
		et_message.style.display = "none";
	}
	catch (e)
	{
		try
		{
			error.style.opacity = "0";
			error.style.visibility = "hidden";
			error.style.display = "none";
		}
		catch (exe)
		{
			console.log(exe.message);
		}
	}
}

function OpenQuestion()
{
	try
	{
		question.style.display = "inline-block";
		question.style.visibility = "visible";
		question.style.opacity = "1";
	}
	catch (exe)
	{
		console.log(exe.message);
	}
}

function CloseQuestion()
{
	try
	{
		question.style.opacity = "0";
		question.style.visibility = "hidden";
		question.style.display = "none";
	}
	catch (exe)
	{
		console.log(exe.message);
	}
}

function OpenHelp()
{
	termos.style.display = "inline-block";	
	termos.style.visibility = "visible";	
	termos.style.opacity = "1";	
	helpActived = 1;
}

function CloseHelp()
{
	termos.style.opacity = "0";
	termos.style.visibility = "hidden";
	termos.style.display = "none";
	helpActived = 0;
}

function CloseOrder()
{
	document.getElementById('options-fei').style.display = "none";
	cover_black.style.display = "none";
}

function OpenOrder()
{
	et_menu_bar.style.display = "none";
	cover_menu.style.display = "none";			
	cover_black.style.display = "inline-block";			
	document.getElementById('options-fei').style.display = "block";
}