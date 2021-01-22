function Calcular()
{
	var altP = txt_altura_p.value.replace(txt_altura_p.getAttribute('unidade'), "").trim();
	var compP = txt_comprimento_p.value.replace(txt_comprimento_p.getAttribute('unidade'), "").trim();
	
	var altT = txt_altura_t.value.replace(txt_altura_t.getAttribute('unidade'), "").trim();
	var compT = txt_comprimento_t.value.replace(txt_comprimento_t.getAttribute('unidade'), "").trim();	
	var junta = txt_junta.value.replace(txt_junta.getAttribute('unidade'), "").trim();
	
	altP = altP.replace(",", ".");
	compP = compP.replace(",", ".");
	altT = altT.replace(",", ".");	
	compT = compT.replace(",", ".");
	junta = junta.replace(",", ".");
	
	altT = altT / 100;	
	compT = compT / 100;
	junta = junta / 100;
	
	var areaP = null;
	var areaT = null;
	var tpm = null;
	var tTotal = null;
	
	areaP = altP * compP;
	
	areaT = (altT+junta)*(compT+junta);
	
	tpm = 1/areaT;
	
	tTotal = Math.round((areaP*tpm)*1.10);

	
	areaP = areaP.toFixed(2).replace(".", ",");	
	
	txt_area.value = areaP + " m²";
	txt_tijolos.value = tTotal + " tijolos";
}