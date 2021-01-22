et_menu.onclick = function(){
	//helpControl();
	
	if (window.location.hash == '')
	{
		window.location.hash = '#help';
	}
}

btn_termos.onclick = function(){
	//helpControl();
	
	history.back();
}

function helpControl(){
	if(helpActived == 1)
	{
		termos.style.opacity = "0";
		termos.style.visibility = "hidden";
		helpActived = 0;
	}
	else
	{
		termos.style.visibility = "visible";	
		termos.style.opacity = "1";	
		helpActived = 1;
	}
}