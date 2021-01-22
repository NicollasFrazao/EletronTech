function Calcular()
{
	var Espirais = document.querySelector("#txt_espirais");
	var Corrente = document.querySelector("#txt_corrente");
	var Indutancia = document.querySelector("#txt_indutancia");
	
	var espirais = Espirais.value.replace(",", ".");
	var corrente = Corrente.value.replace("A", "").trim().replace(",", ".");
	var indutancia = Indutancia.value.replace("H", "").trim().replace(",", ".");
	
	//verificando qual das variáveis está vazia
	if(Indutancia.value == "")
	{	
		indutancia = espirais/corrente;
		Indutancia.style.border = "1px solid green";
		Indutancia.style.backgroundColor = "#fdf8f8";
		Indutancia.value = indutancia.toFixed(2).toString().replace(".", ",") + " H";
	}			
	else
	{
		if(Corrente.value == "")
		{
			corrente = espirais/indutancia;
			Corrente.style.border = "1px solid green";
			Corrente.style.backgroundColor = "#fdf8f8";
			Corrente.value = corrente.toFixed(2).toString().replace(".", ",") + " A";
		}	
		else
		{
			espirais = indutancia*corrente;
			Espirais.style.border = "1px solid green";
			Espirais.style.backgroundColor = "#fdf8f8";
			Espirais.value = Math.ceil(espirais);
		}	
	}
}