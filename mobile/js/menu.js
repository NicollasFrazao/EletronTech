et_menu.onclick = function()
{
	//CloseMenu(); //menuControl();
	
	if (window.location.hash == '#et_menu_bar')
	{
		history.back();
		
		//cover_menu.style.display = "none";
	}
	else if (window.location.hash == '')
	{
		window.location.hash = '#et_menu_bar';
		
		//cover_menu.style.display = "inline-block";
	}
}

function offScroll()
{
	et_medium.style.overflow = "hidden";
}

function onScroll()
{
	et_medium.style.overflow = "auto";
}

cover_menu.onclick = function()
{
	history.back();
}

cover_black.onclick = function()
{
	history.back();
}

window.onkeyup = function()
{
	if (event.keyCode == 27)
	{
		et_menu.onclick();
	}
}

function menuControl()
{
	if(menuActived == 1)
	{
		cover_menu.style.display = "none";
		
		et_menu_bar.style.display = "none";
		
		//et_menu_bar.style.top = "-100%";
		
		menuActived = 0;
		
		//et_back.src="images/back.png";
	}
	else
	{
		cover_menu.style.display = "inline-block";
		
		et_menu_bar.style.display = "inline-block";
		
		//et_menu_bar.style.top = "9%";
		
		menuActived = 1;
		
		//et_back.src="images/eletrontech-anytech-logo-bar.png";	
	}
}

function OpenMenu()
{
	offScroll();
	cover_menu.style.display = "inline-block";

	et_menu_bar.style.display = "inline-block";

	//et_menu_bar.style.display = "inline-box";

	//et_menu_bar.style.top = "9%";

	menuActived = 1;
}

function CloseMenu()
{
	onScroll();
	cover_menu.style.display = "none";

	et_menu_bar.style.display = "none";

	//et_menu_bar.style.top = "-100%";

	//et_menu_bar.style.display = "none";

	menuActived = 0;
}

function etSynchro()
{	
	try
	{
		question_in('Tem certeza que deseja sincronizar com o servidor do EletronTech? Esse processo requer conexão com a internet.', 1);
	}
	catch (e)
	{
		history.back();
		
		console.log(e.message);
	}
}

function etFei()
{
	history.back();
}

function etDeactivate()
{
	history.back();
	
	setTimeout(function(){window.open('Desativar Conta.html','_self');},500);
}

function etProfile()
{
	history.back();
	
	setTimeout(function(){window.open('Perfil.html','_self');},500);
}

function etPassword()
{
	history.back();
	
	CloseMenu(); //menuControl();
	
	setTimeout(function(){window.open('Redefinir Senha.html','_self');},500);
}

function etFeedback()
{
	history.back();
	
	setTimeout(function(){window.open('Feedback.html','_self');}, 500);
}

function etAbout()
{
	history.back();

	setTimeout(function(){window.open('Sobre.html','_self');},500);	
}

function etOrder()
{
	history.back();

	setTimeout(function(){window.location.hash = "#order";},500);	
}

function etLogout()
{
	history.back();
	
	banco.transaction
	(
		function (transaction)
		{
			transaction.executeSql
			(
				'delete from tb_usuario',
				[],
				function (transaction, results)
				{
					window.localStorage.clear();

					window.location.href = 'Login.html';
				},
				null
			);
		}
	);
}