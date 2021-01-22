function Calcular()
{
	var carga = txt_carga.value.replace(txt_carga.attributes["unidade"].value, "").trim();
		carga = carga.replace(",", ".");
	var corrente = txt_corrente.value.replace(txt_corrente.attributes["unidade"].value, "").trim();
		corrente = corrente.replace(",", ".");
	var potencia = txt_potencia.value.replace(txt_potencia.attributes["unidade"].value, "").trim();
		potencia = potencia.replace(",", ".");
	
	var potencial = potencia / corrente;
	var capacitancia = carga / potencial;

	txt_capacitancia.value = capacitancia.toFixed(3).replace(".", ",") + " " + txt_capacitancia.attributes["unidade"].value;
}