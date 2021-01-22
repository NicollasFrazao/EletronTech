function calcular()
{
	var Intencidade = document.querySelector("#txt_intencidade");
	var Tensao = document.querySelector("#txt_tensao");
	var Condutancia = document.querySelector("#txt_condutancia");
	
	var intencidade = Intencidade.value.replace("A", "").trim();
		intencidade = intencidade.replace(",", ".");
	var tensao = Tensao.value.replace("V", "").trim();
		tensao = tensao.replace(",", ".");
	var condutancia = Condutancia.value.replace("S", "").trim();
		condutancia = condutancia.replace(",", ".");
	
	//verificando qual das variáveis está vazia
	if(Condutancia.value == "")
	{	
		condutancia = parseFloat(intencidade)/parseFloat(tensao);
		
		Condutancia.value = condutancia.toFixed(2).toString().replace(".", ",") + " S";
		
		verificarCondutancia();
	}			
	else if(Tensao.value == "")
	{
		tensao = parseFloat(intencidade)/parseFloat(condutancia);
		
		Tensao.value = tensao.toFixed(2).toString().replace(".", ",") + " V";
		
		verificarTensao();
	}	
	else if(Intencidade.value == "")
	{
		intencidade = parseFloat(condutancia)*parseFloat(tensao);
		
		Intencidade.value = intencidade.toFixed(2).toString().replace(".", ",") + " A";
		
		verificarIntensidade();
	}
	else
	{
		alert("Nenhum valor calculado!");
	}
}