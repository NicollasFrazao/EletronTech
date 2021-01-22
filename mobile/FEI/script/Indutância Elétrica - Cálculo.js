function Calcular()
{
	submit = 1;
		
	var Espirais = document.querySelector("#txt_espirais");
	var Corrente = document.querySelector("#txt_corrente");
	var Indutancia = document.querySelector("#txt_indutancia");
	
	var espirais = Espirais.value.replace(Espirais.attributes["unidade"].value, "").trim();
		espirais = espirais.replace(",", ".");
	var corrente = Corrente.value.replace(Corrente.attributes["unidade"].value, "").trim();
		corrente = corrente.replace(",", ".");
	var indutancia = Indutancia.value.replace(Indutancia.attributes["unidade"].value, "").trim();
		indutancia = indutancia.replace(",", ".");
	
	//verificando qual das variáveis está vazia
	if(Indutancia.value == "")
	{	
		result = espirais/corrente;
		Indutancia.value = result.toFixed(3).replace(".", ",") + " " + Indutancia.attributes["unidade"].value;
	}			
	else if(Corrente.value == "")
	{
		result = espirais/indutancia;
		Corrente.value = result.toFixed(3).replace(".", ",") + " " + Corrente.attributes["unidade"].value;
	}	
	else
	{
		result = indutancia*corrente;
		Espirais.value = Math.round(result);
	}
}
