function Calcular(){
	var intensidadeCorrente = txt_intensidade.value.replace("A","").replace(",", ".").trim();
	var tensaoEletrica = txt_tensao.value.replace("V","").replace(",", ".").trim();
	var condutanciaEletrica = txt_condutancia.value.replace("S","").replace(",", ".").trim();

	if(condutanciaEletrica == "")
	{
		condutanciaEletrica =  intensidadeCorrente / tensaoEletrica;
		 txt_condutancia.value = condutanciaEletrica.toFixed(3).replace(".", ",") + " S";
	}

	else if(intensidadeCorrente == "")
	{
		intensidadeCorrente = condutanciaEletrica * tensaoEletrica;
		txt_intensidade.value = intensidadeCorrente.toFixed(3).replace(".", ",") + " A";
	}

	else if(tensaoEletrica == "")
	{
		tensaoEletrica = intensidadeCorrente / condutanciaEletrica;
		txt_tensao.value = tensaoEletrica.toFixed(3).replace(".", ",") + " V";
	}
}
