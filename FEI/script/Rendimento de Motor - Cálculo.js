function CalculaPotUtil()
{
	if (PotUtil.value == "")
	{
		potUtil = potTotal - potDissipada;
		PotUtil.value = potUtil.toFixed(2).toString().replace(".", ",") + " W";
	}
}

function CalculaPotDissipada()
{
	if (PotDissipada.value == "")
	{
		if (PotTotal.value != "")
		{
			potDissipada = potTotal - potUtil;
		}
		
		if (Rendimento.value != "")
		{
			potDissipada = potUtil/rendimento;
		}
		
		PotDissipada.value = potDissipada.toFixed(2).toString().replace(".", ",") + " W";
	}
}

function CalculaRendimento()
{
	if (Rendimento.value == "")
	{
		rendimento = potUtil/potDissipada;
		Rendimento.value = rendimento.toFixed(2).toString().replace(".", ",") + " W";
	}
}

function CalculaPotTotal()
{
	if (PotTotal.value == "")
	{
		potTotal = potUtil + potDissipada;
		PotTotal.value = potTotal.toFixed(2).toString().replace(".", ",") + " W";
	}
}

function Calcular()
{
	var PotUtil = document.querySelector("#txt_potutil");
	var PotDissipada = document.querySelector("#txt_potdissipada");
	var PotTotal = document.querySelector("#txt_pottotal");
	var Rendimento = document.querySelector("#txt_rendimento");
	
	potUtil = parseFloat(PotUtil.value.replace("W", "").trim().replace(",", "."));
	potDissipada = parseFloat(PotDissipada.value.replace("W", "").trim().replace(",", "."));
	potTotal = parseFloat(PotTotal.value.replace("W", "").trim().replace(",", "."));
	rendimento = parseFloat(Rendimento.value.replace("W", "").trim().replace(",", "."));
	
	CalculaPotUtil();
	CalculaPotDissipada();
	CalculaRendimento();
	CalculaPotTotal();
	
	verificarPotTotal();
	verificarPotDissipada();
	verificarPotUtil();
	verificarRendimento();
	
	/*
	if(PotUtil.value == "")
	{
		if(Rendimento.value == "")
		{
			PotUtil.value = PotTotal.value - PotDissipada.value;
			Rendimento.value = PotUtil.value / PotDissipada.value;
		}
		else
		{
			if(PotTotal.value == "")
			{
				PotUtil.value = PotDissipada.value * Rendimento.value;
				PotTotal.value = parseInt(PotUtil.value) +parseInt(PotDissipada.value);
			}
			else
			{
				PotUtil.value = PotDissipada.value * Rendimento.value;
			}
		}
	}
	else
	{
		if(PotDissipada.value == "")
		{
			if(Rendimento.value == "")
			{
				PotDissipada.value = PotTotal.value - PotUtil.value;
				Rendimento.value = PotUtil.value / PotDissipada.value;
			}
			else
			{
				if(PotTotal.value == "")
				{
					PotDissipada.value = PotUtil.value / Rendimento.value;
					PotTotal.value = parseInt(PotUtil.value) +parseInt(PotDissipada.value);
				}
				else
				{
					PotDissipada.value = PotUtil.value / Rendimento.value;
				}
			}
		}
	}

	if(PotTotal.value == "")
	{
		if(Rendimento.value == "")
		{
			Rendimento.value = PotUtil.value / PotDissipada.value;
			PotTotal.value = parseInt(PotUtil.value) +parseInt(PotDissipada.value);
		}
		else
		{
			PotTotal.value = parseInt(PotUtil.value) +parseInt(PotDissipada.value);
		}
	}
	else
	{
		if(Rendimento.value == "")
		{
			Rendimento.value = PotUtil.value / PotDissipada.value;
		}
	}
	*/
}