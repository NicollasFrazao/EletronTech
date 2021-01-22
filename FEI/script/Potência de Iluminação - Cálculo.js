function Calcular()
{
	var Largura = document.querySelector("#txt_largura");
	var Comprimento = document.querySelector("#txt_comprimento");
	
	var largura = Largura.value.replace("m", "").trim().replace(",", ".");
	var comprimento = Comprimento.value.replace("m", "").trim().replace(",", ".");
	
	var Resultado = document.querySelector("#txt_potenciaTotal");
	var area = largura * comprimento;
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
	
	Resultado.value = potencia + " W";
}