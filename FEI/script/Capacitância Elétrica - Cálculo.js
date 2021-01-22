function Calcular(){
	
	//--------Informação dos campos a serem preenchidos
	var mensagem ="";
	if(campos[0] != "0" && txt_carga.value == ""){
		mensagem= campos[0] + " ";
	}
	
	if(campos[1] != "0" && txt_potencia_eletrica.value == ""){
		mensagem += campos[1] + " ";
	}
	
	if(campos[2] != "0" && txt_corrente_eletrica.value == ""){
		mensagem += campos[2] + " ";
	}
		
	var alerta = "Favor preencher os campos: \n" + mensagem;
	
	//-------------------------------Verifica se pode calcular ou se existem capos em branco
	if(mensagem != ""){
			alert(alerta);
	}
	else
	{
			var pot_eletrica = txt_potencia_eletrica.value.replace("VA", "").trim();
			var cor_eletrica = txt_corrente_eletrica.value.replace("A", "").trim();
			var carga = txt_carga.value.replace("C", "").trim();
			
			pot_eletrica = pot_eletrica.replace(",", ".");
			cor_eletrica = cor_eletrica.replace(",", ".");
			carga = carga.replace(",", ".");
			
			pot_eletrica = parseFloat(pot_eletrica);
			cor_eletrica = parseFloat(cor_eletrica);
			carga = parseFloat(carga);
			
			var potencial = pot_eletrica/cor_eletrica;
			var capacitancia = carga/potencial;
			
			capacitancia = capacitancia.toFixed(2).toString().replace(".", ",");
			txt_resultado.value = capacitancia + " F";
	}
}
