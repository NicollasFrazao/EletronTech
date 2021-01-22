var largura, comprimento, divisao, area, mod, comodo, vazio = "",tomadas, cargas, valid = 0, cont = 0;

var campoPotenciaTotal = document.querySelector("#txt_potenciaTotal");
var campoPotenciaTomada = document.querySelector("#txt_potenciaTomada");
var campoTomadas = document.querySelector("#txt_tomadas");

function Calcular()
{
	comodo = campoComodo.value;
	largura = campoLargura.value.replace("m", "").trim().replace(",", ".");
	comprimento = campoComprimento.value.replace("m", "").trim().replace(",", ".");
	
	area = largura*comprimento;
	
	if (comodo == 2)
	{
		tomadas = 1;
	}
	else if (comodo == 4 || comodo == 3 || comodo == 1)
	{
		divisao = area / 3.5;
		mod = area % 3.5;
		tomadas = Math.ceil(divisao);

	}
	else if (comodo == 10 || comodo == 9 || comodo == 5 || comodo == 11)
	{
		tomadas = 1;
	}
	else if (area <= 6)
	{
		tomadas = 1;
	}
	//--------------- Outros Cômodos com Área Maior que 6
	else if (area > 6)
	{
		divisao = 1 + (parseInt(area - 6) / 5);
		mod = Math.ceil(area - 6) % 5;
		if (mod == 0)
		{
			tomadas = Math.ceil(divisao);
		}
		else
		{
			tomadas = Math.ceil(divisao + 1);
		}
	}

	//-------------------------------------------Cargas
	if (comodo == 2 || comodo == 4 || comodo == 3 || comodo == 1 || comodo == 6)
	{
		cargas = tomadas * 600;
		if (tomadas > 3)
		{
			cargas = tomadas * 100;
			cargas = cargas + 1500;
			campoPotenciaTotal.value = cargas;
		}
	}
	else
	{
		cargas = tomadas * 600;
	}
	
	//-----------------Potência por Tomada
	
	var numtomadas = tomadas;
			
	if (comodo == 1 || comodo == 2 || comodo == 3 || comodo == 4 || comodo == 6){
			
			if (numtomadas > 3){
				 cargas = ((numtomadas -3) * 100 ) + 1800;
				 ptomada = "600Va = 3 /100Va = "+ (numtomadas - 3);
			}else if(numtomadas <= 3){
				cargas = numtomadas * 600;
				ptomada = " 600Va = " + numtomadas;
			}
	}
	else{
				cargas = numtomadas * 600;
				ptomada = "600Va = " + numtomadas;
	}
	
	campoTomadas.value = tomadas + " Tomada(s)";
	campoPotenciaTotal.value = cargas + " VA";
	campoPotenciaTomada.value = ptomada;
}