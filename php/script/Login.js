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
	carregamento.style.display="inline-block";
}