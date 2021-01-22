function Calcular()
{
	var area = txt_area.value.replace(txt_area.getAttribute('unidade'), "").trim();
	var peop = txt_pessoas.value.replace(txt_pessoas.getAttribute('unidade'), "").trim();
	var elet = txt_eletronicos.value.replace(txt_eletronicos.getAttribute('unidade'), "").trim();
	
	area = parseInt(area);
	areaBTU = area * 600;
	if(peop > 1){
		peopBTU = (peop-1)*600;
	}
	else{
		peopBTU = 600;
	}
	
	eletBTU = elet * 600;
	
	BTU = eletBTU + peopBTU + areaBTU;
	
	txt_btu.value =  BTU+" BTU";
}