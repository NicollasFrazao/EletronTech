function Calcular()
{
	var velocidade_1 = txt_velocidade_1.value.replace(txt_velocidade_1.getAttribute('unidade'), "").trim();
		velocidade_1 =velocidade_1.replace(",", ".");
	var velocidade_2 = txt_velocidade_2.value.replace(txt_velocidade_2.getAttribute('unidade'), "").trim();
		velocidade_2 =velocidade_2.replace(",", ".");	
	var altura_1 = txt_altura_1.value.replace(txt_altura_1.getAttribute('unidade'), "").trim();
		altura_1 = altura_1.replace(",", ".");
	var altura_2 = txt_altura_2.value.replace(txt_altura_2.getAttribute('unidade'), "").trim();
		altura_2 = altura_2.replace(",", ".");	
	var pressao_1 = txt_pressao_1.value.replace(txt_pressao_1.getAttribute('unidade'), "").trim();
		pressao_1 = pressao_1.replace(",", ".");
	var pressao_2 = txt_pressao_2.value.replace(txt_pressao_2.getAttribute('unidade'), "").trim();
		pressao_2 = pressao_2.replace(",", ".");	
	var densidade = txt_densidade.value.replace(txt_densidade.getAttribute('unidade'), "").trim();
		densidade = densidade.replace(",", ".");
	
	var parte_oposta = pressao_1+(densidade*velocidade_1*velocidade_1)/2+(densidade*9.8*altura_1);
	var mesma_parte = 0;

	alert(velocidade_2);
	if(velocidade_2 == "")
	{
		alert("v2 vazio");
		mesma_parte = densidade*9.8*altura_2 + pressao_2;
		velocidade_2 = Math.sqrt((2/densidade)*(parte_oposta-mesma_parte));
		txt_velocidade_2.value = velocidade_2.toFixed(3).replace(".", ",") + " " + txt_velocidade_2.getAttribute('unidade');
	}			
	else if(altura_2.value == "")
	{
		alert("a2 vazio");
		mesma_parte = pressao_2 + (densidade*velocidade_2*velocidade_2)/2;
		altura_2 =(parte_oposta - mesma_parte)/densidade*9.8;
		txt_altura_2.value = altura_2.toFixed(3).replace(".", ",") + " " + txt_altura_2.getAttribute('unidade');
	}	
	else
	{
		mesma_parte = (densidade*altura_2*9.8) + (densidade*velocidade_2*velocidade_2)/2;
		pressao_2 = parte_oposta - mesma_parte;
		txt_pressao_2.value = pressao_2.toFixed(3).replace(".", ",") + " " + txt_pressao_2.getAttribute('unidade');
	}
}