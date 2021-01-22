function Calcular()
{
	var Calc = document.querySelector("#cmb_calculo").value;

	if(Calc == 1){//Calculo opcao 1 - Circulo
		var Raio = document.querySelector("#txt_raio_c1");
		var Area = document.querySelector("#txt_area_c1");
		var Perimetro = document.querySelector("#txt_perimetro_c1");

		var raio = Raio.value.replace(Raio.attributes['unidade'].value, "").trim();
			raio = raio.replace(",", ".");
		var area = Area.value.replace(Area.attributes['unidade'].value, "").trim();
			area = area.replace(",", ".");
		var perimetro = Perimetro.value.replace(Perimetro.attributes['unidade'].value, "").trim();
			perimetro = perimetro.replace(",", ".");

		if(raio != "")
		{
			area = Math.PI * (raio*raio);
			Area.value = area.toFixed(3).replace(".", ",") + " " + Area.attributes["unidade"].value;
			perimetro = 2 * Math.PI * raio;
			Perimetro.value = perimetro.toFixed(3).replace(".", ",") + " " + Perimetro.attributes["unidade"].value;
		}		
		else if(area !="")
		{
			raio = Math.sqrt(area/Math.PI);
			Raio.value = raio.toFixed(3).replace(".", ",") + " " + Raio.attributes['unidade'].value;
			perimetro = 2 * Math.PI * raio;
			Perimetro.value = perimetro.toFixed(3).replace(".", ",") + " " + Perimetro.attributes["unidade"].value;
		}
		else{
			raio = perimetro/(2 * Math.PI);
			Raio.value = raio.toFixed(3).replace(".", ",") + " " + Raio.attributes['unidade'].value;
			area = Math.PI * (raio*raio);
			Area.value = area.toFixed(3).replace(".", ",") + " " + Area.attributes["unidade"].value;
		}
			
	}
	if(Calc == 2){//Calculo opcao 2 - Hexagono
		var Area = document.querySelector("#txt_area_c2");
		var Perimetro = document.querySelector("#txt_perimetro_c2");
		var Apotema = document.querySelector("#txt_apotema_c2");

		var apotema = Apotema.value.replace(Apotema.attributes['unidade'].value, "").trim();
			apotema = apotema.replace(",", ".");
		var area = Area.value.replace(Area.attributes['unidade'].value, "").trim();
			area = area.replace(",", ".");
		var perimetro = Perimetro.value.replace(Perimetro.attributes['unidade'].value, "").trim();
			perimetro = perimetro.replace(",", ".");

		if(area == 0)
		{
			area = (perimetro*apotema)/2;
			Area.value = area.toFixed(3).replace(".", ",") + " " + Area.attributes["unidade"].value;
		}
		else if(perimetro == 0)
		{
			perimetro = (2*area)/apotema;
			Perimetro.value = perimetro.toFixed(3).replace(".", ",") + " " + Perimetro.attributes["unidade"].value;
		}	
		else{
			apotema = (2*area)/perimetro;
			Apotema.value = apotema.toFixed(3).replace(".", ",") + " " + Apotema.attributes['unidade'].value;
		}
	}
	if(Calc == 3){//Calculo opcao 3 - Losango
		var Area = document.querySelector("#txt_area_c3");
		var Perimetro = document.querySelector("#txt_perimetro_c3");
		var DiagMaior = document.querySelector("#txt_diagonal_maior_c3");
		var DiagMenor = document.querySelector("#txt_diagonal_menor_c3");

		var diagmaior = Diagmaior.value.replace(Diagmaior.attributes['unidade'].value, "").trim();
			diagmaior = diagmaior.replace(",", ".");
		var diagmenor = Diagmenor.value.replace(Diagmenor.attributes['unidade'].value, "").trim();
			diagmenor = diagmenor.replace(",", ".");	
		var area = Area.value.replace(Area.attributes['unidade'].value, "").trim();
			area = area.replace(",", ".");
		var perimetro = Perimetro.value.replace(Perimetro.attributes['unidade'].value, "").trim();
			perimetro = perimetro.replace(",", ".");

		if(area == 0)
		{
			area =(diagmaior*diagmenor)/2;
			Area.value = area.toFixed(3).replace(".", ",") + " " + Area.attributes["unidade"].value;
		}
		else if(diagmaior == 0)
		{
			diagmaior = (2*area)/diagmenor;
			Diagmaior.value = diagmaior.toFixed(3).replace(".", ",") + " " + Diagmaior.attributes["unidade"].value;

		}	
		else
		{
			diagmenor = (2*area)/diagmaior;
			Diagmenor.value = diagmenor.toFixed(3).replace(".", ",") + " " + Diagmenor.attributes["unidade"].value;
		}
	}

	if(Calc == 4)
	{
		var Area = document.querySelector("#txt_area_c4");
		var Perimetro = document.querySelector("#txt_perimetro_c4");
		var Apotema = document.querySelector("#txt_apotema_c4");

		var apotema = Apotema.value.replace(Apotema.attributes['unidade'].value, "").trim();
			apotema = apotema.replace(",", ".");
		var area = Area.value.replace(Area.attributes['unidade'].value, "").trim();
			area = area.replace(",", ".");
		var perimetro = Perimetro.value.replace(Perimetro.attributes['unidade'].value, "").trim();
			perimetro = perimetro.replace(",", ".");

		if(area == 0)
		{
			area = (perimetro*apotema)/2;
			Area.value = area.toFixed(3).replace(".", ",") + " " + Area.attributes["unidade"].value;
		}
		else if(perimetro == 0)
		{
			perimetro = (2*area)/apotema;
			Perimetro.value = perimetro.toFixed(3).replace(".", ",") + " " + Perimetro.attributes["unidade"].value;
		}	
		else{
			apotema = (2*area)/perimetro;
			Apotema.value = apotema.toFixed(3).replace(".", ",") + " " + Apotema.attributes['unidade'].value;
		}	
	}


	if(Calc == 5){//Calculo opcao 5 - Quadrado
		var Lado = document.querySelector("#txt_lado_c5");
		var Area = document.querySelector("#txt_area_c5");
		var Perimetro = document.querySelector("#txt_perimetro_c5");

		var lado = Lado.value.replace(Lado.attributes["unidade"].value, "").trim();
			lado = lado.replace(",", ".");
		var area = Area.value.replace(Area.attributes['unidade'].value, "").trim();
			area = area.replace(",", ".");
		var perimetro = Perimetro.value.replace(Perimetro.attributes['unidade'].value, "").trim();
			perimetro = perimetro.replace(",", ".");
			
		if(lado != 0)
		{
			area = lado*lado;
			Area.value = area.toFixed(3).replace(".", ",") + " " + Area.attributes["unidade"].value;
			perimetro = 4 * lado;			
			Perimetro.value = perimetro.toFixed(3).replace(".", ",") + " " + Perimetro.attributes["unidade"].value;
		}
		else if(area != 0)
		{
			lado = Math.sqrt(area);
			Lado.value = lado.toFixed(3).replace(".", ",") + " " + Lado.attributes["unidade"].value;
			perimetro = lado*4;
			Perimetro.value = perimetro.toFixed(3).replace(".", ",") + " " + Perimetro.attributes["unidade"].value;
		}
		else{
			lado = perimetro/4;
			Lado.value = lado.toFixed(3).replace(".", ",") + " " + Lado.attributes["unidade"].value;
			area = lado*lado;
			Area.value = area.toFixed(3).replace(".", ",") + " " + Area.attributes["unidade"].value;
		}
	}	

	if(Calc == 6){//Calculo opcao 6 - Retangulo
		var Area = document.querySelector("#txt_area_c6");
		var Perimetro = document.querySelector("#txt_perimetro_c6");
		var Largura = document.querySelector("#txt_largura_c6");
		var Comprimento = document.querySelector("#txt_comprimento_c6");

		var area = Area.value.replace(Area.attributes['unidade'].value, "").trim();
			area = area.replace(",", ".");
		var perimetro = Perimetro.value.replace(Perimetro.attributes['unidade'].value, "").trim();
			perimetro = perimetro.replace(",", ".");
		var largura = Largura.value.replace(Largura.attributes['unidade'].value, "").trim();
			largura = largura.replace(",", ".");
		var comprimento = Comprimento.value.replace(Comprimento.attributes['unidade'].value, "").trim();
			comprimento = comprimento.replace(",", ".");

			
	}	
}