function Calcular()
{
	var larg = txt_largura.value.replace(txt_largura.attributes["unidade"].value, "").trim();
	var comp = txt_comprimento.value.replace(txt_comprimento.attributes["unidade"].value, "").trim();
	
	larg = larg.replace(",", ".");
	comp = comp.replace(",", ".");
	
	var area = null;
	var perimetro = null;

	area = comp * larg;		
	perimetro = (comp * 2) + (larg * 2);
	
	area = area.toFixed(3).replace(".", ",");
	perimetro = perimetro.toFixed(3).replace(".", ",");
	
	txt_area.value = area + " m²";
	txt_perimetro.value = perimetro + " m";
}