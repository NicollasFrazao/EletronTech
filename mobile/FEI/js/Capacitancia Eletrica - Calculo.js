function Calcular()
{
	var carga = txt_carga.value.replace(txt_carga.getAttribute('unidade'), "").trim();
		carga = carga.replace(",", ".");
	var corrente = txt_corrente.value.replace(txt_corrente.getAttribute('unidade'), "").trim();
		corrente = corrente.replace(",", ".");
	var potencia = txt_potencia.value.replace(txt_potencia.getAttribute('unidade'), "").trim();
		potencia = potencia.replace(",", ".");
	
	var potencial = potencia / corrente;
	var capacitancia = carga / potencial;

	txt_capacitancia.value = capacitancia.toFixed(3).replace(".", ",") + " " + txt_capacitancia.getAttribute('unidade');
}