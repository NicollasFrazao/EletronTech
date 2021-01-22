function Calcular(){
	
	var resistenciaEletrica = document.querySelector("#txt_resistencia");
	var capacitanciaEletrica = document.querySelector("#txt_capacitancia");
	var frequenciaCorrente = document.querySelector("#txt_frequencia");;
	
	var resistencia = resistenciaEletrica.value.replace(resistenciaEletrica.getAttribute('unidade'), "").trim();
		resistencia = resistencia.replace(",", ".");
	var capacitancia = capacitanciaEletrica.value.replace(capacitanciaEletrica.getAttribute('unidade'), "").trim();
		capacitancia = capacitancia.replace(",", ".");
	var frequencia = frequenciaCorrente.value.replace(frequenciaCorrente.getAttribute('unidade'), "").trim();
		frequencia = frequencia.replace(",", ".");
	
	var passoUm = Math.pow((2*3.14*frequencia*capacitancia)/1 , 2);
	var passoDois = Math.pow(resistencia,2);
	var passoTres = passoUm + passoDois;
	var impedancia = Math.sqrt(passoTres);
	
	txt_impedancia.value = impedancia.toFixed(3).replace(".", ",") + " " + resistenciaEletrica.getAttribute('unidade');
}