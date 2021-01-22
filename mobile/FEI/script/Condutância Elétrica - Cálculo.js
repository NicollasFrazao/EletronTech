function Calcular()
{
	
	var Intencidade = document.querySelector("#txt_intensidade");
	var Tensao = document.querySelector("#txt_tensao");
	var Condutancia = document.querySelector("#txt_condutancia");
	
	//verificando qual das variáveis está vazia
	if(Condutancia.value == "")
	{	
		var tensao = Tensao.value.replace(Tensao.attributes["unidade"].value, "").trim();
			tensao = tensao.replace(",", ".");
		var intenc = Intencidade.value.replace(Intencidade.attributes["unidade"].value, "").trim();
			intenc = intenc.replace(",", ".");
			
		var result = intenc / tensao;
			result = result.toString().replace(".", ",");
		
		Condutancia.value = result + " " + Condutancia.attributes["unidade"].value;
	}			
	else if(Tensao.value == "")
	{
		var intenc = Intencidade.value.replace(Intencidade.attributes["unidade"].value, "").trim();
			intenc = intenc.replace(",", ".");
		var cond = Condutancia.value.replace(Condutancia.attributes["unidade"].value, "").trim();
			cond = cond.replace(",", ".");
			
		var result = intenc / cond;
			result = result.toString().replace(".", ",");
		
		Tensao.value = result + " " + Tensao.attributes["unidade"].value;
	}	
	else if(Intencidade.value == "")
	{
		var cond = Condutancia.value.replace(Condutancia.attributes["unidade"].value, "").trim();
			cond = cond.replace(",", ".");
		var tensao = Tensao.value.replace(Tensao.attributes["unidade"].value, "").trim();
			tensao = tensao.replace(",", ".");
		
		var result = cond * tensao;
			result = result.toString().replace(".", ",");
			
		Intencidade.value = result + " " + Intencidade.attributes["unidade"].value;
	}
}