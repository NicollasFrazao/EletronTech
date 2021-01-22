function ajusteBitola(corrente)
{
	var r, bitola;
	if (corrente > 0 && corrente <= 12)
	{
		/*
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
		*/
		
		bitola = "1.0 mm²";
	}
	else if (corrente > 12 && corrente <= 15.5)
	{
		/*
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
		*/
		
		bitola = "1.5 mm²";
	}
	else if (corrente > 15.5 && corrente <= 21)
	{
		/*
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
		*/
		
		bitola = "2.5 mm²";
	}
	else if (corrente > 21 && corrente <= 28)
	{
		/*
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
		*/
		
		bitola = "4,0 mm²";
	}
	else if (corrente > 28 && corrente <= 36)
	{
		/*
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
		*/
		
		bitola = "6,0 mm²";
	}
	else if (corrente > 36 && corrente <= 50)
	{
		/*
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
		*/
		
		bitola = "10,0 mm²";
	}
	else if (corrente > 50 && corrente <= 68)
	{
		/*
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
		*/
		
		bitola = "16,0 mm²";
	}
	else
	{
		/*
		alert("Corrente Muito Alta Para as Bitolas Atuais!");
		resultajuste = 0;
		campoBitola.value = 0;
		*/
		
		bitola = "Indefinida!";
	}
	
	return bitola;
}