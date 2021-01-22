var mensagem = "Segundo às normas da NBR 5410, corrente não está compatível com o cabo atual.\n\nDejesa ajustar o cabo?";

var corrente = 0, potencia = 0, potencia110, potencia220, corrente110, corrente220, resulttensao, cont, tensao, bitola, resultajuste = 0, X, Y, calc;

var campoBitola = document.querySelector("#cmb_bitola");
var campoTensao = document.querySelector("#cmb_tensao");
var campoCorrente = document.querySelector("#txt_corrente");
var campoPotencia = document.querySelector("#txt_potencia");

function calcTensao()
{
	resulttensao = potencia / corrente;
	resulttensao = parseInt(resulttensao.toFixed(0));
	
	if (resulttensao >= 220)
	{
		campoTensao.value = 2;
	}
	else if (resulttensao >= 110)
	{
		campoTensao.value = 1;
	}
	else
	{
		campoTensao.value = 0;
	}
}

function calcPotencia()
{
	potencia110 = 110 * corrente;
	potencia220 = 220 * corrente;
	switch (parseInt(campoTensao.value))
	{
		case 1:
			{
				campoPotencia.value = potencia110.toFixed(2).toString().replace(".", ",") + " VA";
			}
			break;
		case 2:
			{
				campoPotencia.value = potencia220.toFixed(2).toString().replace(".", ",") + " VA";
			}
			break;
	}
	potencia = parseFloat(campoPotencia.value.replace("VA", "").trim().replace(",", "."));
}

function calcCorrente()
{
	corrente110 = potencia / 110;
	corrente220 = potencia / 220;
	
	switch (parseInt(campoTensao.value))
	{
		case 1:
			{
				campoCorrente.value = corrente110.toFixed(2).toString().replace(".", ",") + " A";
			}
			break;
		case 2:
			{
				campoCorrente.value = corrente220.toFixed(2).toString().replace(".", ",") + " A";
			}
			break;
	}
	corrente = parseFloat(campoCorrente.value.replace('A', ' ').trim().replace(",", "."));
}

function ajusteBitola()
{
	var r;
	if (corrente > 0 && corrente <= 12)
	{
		if (bitola != 1)
		{
			r = confirm(mensagem);
			if (r == true)
			{
				campoBitola.value = 1;
				resultajuste = 1;
			}
			else
			{
				resultajuste = 0;
				campoBitola.value = 0;
			}
		}
	}
	else if (corrente > 12 && corrente <= 15.5)
	{
		if (bitola != 2)
		{
			r = confirm(mensagem);
			if (r == true)
			{
				campoBitola.value = 2;
				resultajuste = 1;
			}
			else
			{
				resultajuste = 0;
				campoBitola.value = 0;
			}
		}
	}
	else if (corrente > 15.5 && corrente <= 21)
	{
		if (bitola != 3)
		{
			r = confirm(mensagem);
			if (r == true)
			{
				campoBitola.value = 3;
				resultajuste = 1;
			}
			else
			{
				resultajuste = 0;
				campoBitola.value = 0;
			}
		}
	}
	else if (corrente > 21 && corrente <= 28)
	{
		if (bitola != 4)
		{
			r = confirm(mensagem);
			if (r == true)
			{
				campoBitola.value = 4;
				resultajuste = 1;
			}
			else
			{
				resultajuste = 0;
				campoBitola.value = 0;
			}
		}
	}
	else if (corrente > 28 && corrente <= 36)
	{
		if (bitola != 5)
		{
			r = confirm(mensagem);
			if (r == true)
			{
				campoBitola.value = 5;
				resultajuste = 1;
			}
			else
			{
				resultajuste = 0;
				campoBitola.value = 0;
			}
		}
	}
	else if (corrente > 36 && corrente <= 50)
	{
		if (bitola != 6)
		{
			r = confirm(mensagem);
			if (r == true)
			{
				campoBitola.value = 6;
				resultajuste = 1;
			}
			else
			{
				resultajuste = 0;
				campoBitola.value = 0;
			}
		}
	}
	else if (corrente > 50 && corrente <= 68)
	{
		if (bitola != 7)
		{
			r = confirm(mensagem);
			if (r == true)
			{
				campoBitola.value = 7;
				resultajuste = 1;
			}
			else
			{
				resultajuste = 0;
				campoBitola.value = 0;
			}
		}
	}
	else
	{
		//alert("Corrente Muito Alta Para as Bitolas Atuais!");
		txt_error.innerHTML = "Corrente muito alta para as definições atuais do cabo!";
		error_in();
		resultajuste = 0;
		campoBitola.value = 0;
	}
}

function Calcular()
{
	potencia = campoPotencia.value.replace("VA","");
	potencia = potencia.replace(",", ".");
	corrente = campoCorrente.value.replace("A","");
	corrente = corrente.replace(",", ".");
	bitola = campoBitola.value;
	tensao = campoTensao.value;
	
	calc = 0;
	
	if (campoPotencia.value != "" && campoCorrente.value != "")
	{
		calcTensao();
		ajusteBitola();
		if (resultajuste != 0)
		{
			//alert("Bitola Ajustada!");
			resultajuste = 0;
		}
		calc = 1;
	}
	else if (campoPotencia.value != "" && campoTensao.value != 0)
	{
		calcCorrente();
		ajusteBitola();
		if (resultajuste != 0)
		{
			//alert("Bitola Ajustada!");
			resultajuste = 0;
		}
		calc = 1;
	}
	else if (campoCorrente.value != "" && campoTensao.value != 0)
	{
		calcPotencia();
		ajusteBitola();
		if (resultajuste != 0)
		{
			//alert("Bitola Ajustada!");
			resultajuste = 0;
		}
		calc = 1;
	}
	else if (campoCorrente.value != "")
	{
		ajusteBitola();
		if (resultajuste != 0)
		{
			//alert("Bitola Ajustada!");
			resultajuste = 0;
			calc = 1;
		}
	}
	
	/*if (campoBitola.value == 0)
	{
		if (campoCorrente.value != "")
		{
			ajusteBitola();
			if (resultajuste != 0)
			{
				alert("Bitola Ajustada!");
				resultajuste = 0;
				calc = 1;
			}
		}
		if (campoPotencia.value != "" && campoTensao.value != 0)
		{
			calcCorrente();
			ajusteBitola();
			if (resultajuste != 0)
			{
				alert("Bitola Ajustada!");
				resultajuste = 0;
			}
			calc = 1;
		}

	}
	if (campoTensao.value == 0)
	{
		if (campoPotencia.value != "" && campoCorrente.value != "")
		{
			calcTensao();
			ajusteBitola();
			if (resultajuste != 0)
			{
				alert("Bitola Ajustada!");
				resultajuste = 0;
			}
			calc = 1;
		}

	}
	if (campoCorrente.value == "")
	{
		if (campoPotencia.value != "" && campoTensao.value != 0)
		{
			calcCorrente();
			ajusteBitola();
			if (resultajuste != 0)
			{
				alert("Bitola Ajustada!");
				resultajuste = 0;
			}
			calc = 1;
		}
	}
	if (campoPotencia.value == "")
	{
		if (campoCorrente.value != "" && campoTensao.value != 0)
		{
			calcPotencia();
			ajusteBitola();
			if (resultajuste != 0)
			{
				alert("Bitola Ajustada!");
				resultajuste = 0;
			}
			calc = 1;
		}
	}*/
	
	if (calc != 0)
	{
		//campoBitola.disabled = true;
		//campoTensao.disabled = true;
		//campoPotencia.disabled = true;
		//campoCorrente.disabled = true;
	}
	else
	{
		//alert("Nenhum cálculo foi realizado!");
		txt_error.innerHTML = "Por favor, preencha todos os campos corretamente.";
		error_in();
	}
}
