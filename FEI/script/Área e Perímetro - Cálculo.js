function calcular()
{
	var largura = txt_largura.value;
	var comprimento = txt_comprimento.value;
	var c = document.getElementById("cmb_calculo");
	var itemSelecionado = c.options[c.selectedIndex].value;
	var r = null;
	
	largura = largura.replace("m", "").trim();
	comprimento = comprimento.replace("m", "").trim();
	
	largura = largura.replace(",", ".");
	comprimento = comprimento.replace(",", ".");
	
	largura = parseFloat(largura);
	comprimento = parseFloat(comprimento);
	
	if(itemSelecionado == 1)
	{
		r = comprimento * largura;		
		
		r = r.toFixed(2).toString().replace(".", ",");
		txt_resultado.value = r + " m²";
	}
	else if(itemSelecionado == 2){
		r = (comprimento * 2) + (largura * 2);
		r = r.toFixed(2).toString().replace(".", ",");
		
		txt_resultado.value = r + " m";
	}
}