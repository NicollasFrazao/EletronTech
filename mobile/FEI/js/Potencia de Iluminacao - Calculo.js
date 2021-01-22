function Calcular()
{
	var largura = txt_largura.value.replace(txt_largura.getAttribute('unidade'), "").trim();
		largura = largura.replace(",", ".");
	var comprimento = txt_comprimento.value.replace(txt_comprimento.getAttribute('unidade'), "").trim();
		comprimento = comprimento.replace(",", ".");
	var Resultado = document.querySelector("#txt_potencia");
	
	var area = largura*comprimento;
	var result;
	var areai;
	var potencia = 0;
	
	if(area <= 6)
	{
		potencia = 100;
	}
	else
	{
		areai = parseInt(area);
		result= (areai-6)/4;
		potencia = 100+(result*60);
	}
	
	Resultado.value = potencia + " " + Resultado.getAttribute('unidade');
}