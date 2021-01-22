function calcular()
{
	resist_eletrica = document.getElementById("resistencia_eletrica").value.replace(",", ".").replace("Ω", "").trim();
	freq_corrente = document.getElementById("frequencia_corrente").value.replace(",", ".").replace("Hz", "").trim();
	capacitancia = document.getElementById("capacitancia").value.replace(",", ".").replace("F", "").trim();
	
	xc = (2*3.14*freq_corrente*capacitancia)/1;
	r2 = resist_eletrica*resist_eletrica;
	xc2 = xc*xc;
	z2 = xc2+r2;
	z = Math.sqrt(z2);
	
	resultado.value = z.toFixed(2).toString().replace(".", ",") + " Ω";
}	
