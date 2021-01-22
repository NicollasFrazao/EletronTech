function Calcular()
{
	var largS = txt_largura_s.value.replace(txt_largura_s.getAttribute('unidade'), "").trim();
	var compS = txt_comprimento_s.value.replace(txt_comprimento_s.getAttribute('unidade'), "").trim();
	var largR = txt_largura_r.value.replace(txt_largura_r.getAttribute('unidade'), "").trim();
	var compR = txt_comprimento_r.value.replace(txt_comprimento_r.getAttribute('unidade'), "").trim();
	
	largS = largS.replace(",", ".");
	compS = compS.replace(",", ".");
	
	largR = largR.replace(",", ".");
	compR = compR.replace(",", ".");
	
	largR = largR/100;
	compR = compR/100;
	
	var areaS = null;
	var areaR = null;
	
	areaS = compS * largS;		
	areaR = compR * largR;		
	
	revs = Math.round((areaS * 1.10)/areaR);		
	
	areaS = areaS.toFixed(2).replace(".", ",");	
	
	txt_area.value = areaS + " m²";
	txt_revestimento.value = revs + " unidades";
}