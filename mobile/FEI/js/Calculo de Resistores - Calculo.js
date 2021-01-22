function Calcular()
{
	var Calc = document.querySelector("#cmb_calculo").value;
	
	if (Calc == 1)
	{//Calculo opcao 1 - 1º Lei de Ohm 
		var Tensao = document.querySelector("#txt_tensao_c1");
		var Corrente = document.querySelector("#txt_corrente_c1");
		var Resistencia = document.querySelector("#txt_resistencia_c1");
		var Potencia = document.querySelector("#txt_potencia_c1");

		var resistencia = Resistencia.value.replace(Resistencia.attributes["unidade"].value, "").trim();
			resistencia = resistencia.replace(",", ".");
		var corrente = Corrente.value.replace(Corrente.attributes["unidade"].value, "").trim();
			corrente = corrente.replace(",", ".");
			var potencia = Potencia.value.replace(Potencia.attributes["unidade"].value, "").trim();
			potencia = potencia.replace(",", ".");
		var tensao = Tensao.value.replace(Tensao.attributes["unidade"].value, "").trim();
			tensao = tensao.replace(",", ".");	


		if (potencia ==  "" &&  resistencia == "")
		{
			resistencia = tensao/corrente;
			potencia = tensao*corrente;
			
			Resistencia.value = resistencia.toFixed(3).replace(".", ",") + " " + Resistencia.attributes["unidade"].value;
			Potencia.value = potencia.toFixed(3).replace(".", ",") + " " + Potencia.attributes["unidade"].value;
		}
		else if (potencia == "" && tensao == "")
		{
			tensao = resistencia * corrente;
			potencia = tensao*corrente;
			
			Tensao.value = tensao.toFixed(3).replace(".", ",") + " " + Tensao.attributes["unidade"].value;
			Potencia.value = potencia.toFixed(3).replace(".", ",") + " " + Potencia.attributes["unidade"].value;		
		}
		else if (potencia == "" && corrente == "")
		{
			corrente =  tensao/ resistencia;
			potencia = tensao*corrente;
			
			Corrente.value = corrente.toFixed(3).replace(".", ",") + " " + Corrente.attributes["unidade"].value;
			Potencia.value = potencia.toFixed(3).replace(".", ",") + " " + Potencia.attributes["unidade"].value;	
		}
		else if (resistencia == "" && tensao == "" )
		{
			tensao = potencia/corrente;
			resistencia = tensao/corrente;
			
			Tensao.value = tensao.toFixed(3).replace(".", ",") + " " + Tensao.attributes["unidade"].value;
			Resistencia.value = resistencia.toFixed(3).replace(".", ",") + " " + Resistencia.attributes["unidade"].value;	
		}
		else if (resistencia == "" && corrente=="")
		{
			corrente = potencia/tensao;
			resistencia = (Math.pow(tensao, 2))/potencia;
			
			Corrente.value = corrente.toFixed(3).replace(".", ",") + " " + Corrente.attributes["unidade"].value;
			Resistencia.value = resistencia.toFixed(3).replace(".", ",") + " " + Resistencia.attributes["unidade"].value;
		}
		else if (tensao == "" && corrente == "")
		{
			corrente = Math.sqrt(potencia/resistencia);
			tensao = resistencia * corrente;
			
			Corrente.value = corrente.toFixed(3).replace(".", ",") + " " + Corrente.attributes["unidade"].value;
			Tensao.value = tensao.toFixed(3).replace(".", ",") + " " + Tensao.attributes["unidade"].value;
		}
		else if (potencia == "")
		{
			potencia = tensao*corrente;
			
			Potencia.value = potencia.toFixed(3).replace(".", ",") + " " + Potencia.getAttribute('unidade');
		}
		else if (tensao == "")
		{
			tensao = resistencia*corrente;
			
			Tensao.value = tensao.toFixed(3).replace(".", ",") + " " + Tensao.getAttribute('unidade');
		}
		else if (corrente == "")
		{
			corrente = tensao/resistencia;
			
			Corrente.value = corrente.toFixed(3).replace(".", ",") + " " + Corrente.getAttribute('unidade');
		}
		else if (resistencia == "")
		{
			resistencia = tensao/corrente;
			
			Resistencia.value = resistencia.toFixed(3).replace(".", ",") + " " + Resistencia.getAttribute('unidade');
		}
	}
	else if (Calc == 2)
	{//Calculo opcao 2 - 2º Lei de Ohm 
		var Resistividade = document.querySelector("#txt_resistividade_c2");
		var Area = document.querySelector("#txt_area_c2");
		var Resistencia = document.querySelector("#txt_resistencia_c2");
		var Comprimento = document.querySelector("#txt_comprimento_c2");

		var resistencia = Resistencia.value.replace(Resistencia.attributes["unidade"].value, "").trim();
			resistencia = resistencia.replace(",", ".");
		var resistividade = Resistividade.value.replace(Resistividade.attributes["unidade"].value, "").trim();
			resistividade = resistividade.replace(",", ".");
		var area = Area.value.replace(Area.attributes["unidade"].value, "").trim();
			area = area.replace(",", ".");
		var comprimento = Comprimento.value.replace(Comprimento.attributes["unidade"].value, "").trim();
			comprimento = comprimento.replace(",", ".");	

		if (resistencia == "")
		{
			result = (resistividade*comprimento)/area;
			Resistencia.value = result.toFixed(3).replace(".", ",") + " " + Resistencia.attributes["unidade"].value;
		}
		else if (resistividade == "")
		{
			result = (area*resistencia)/comprimento;
			Resistividade.value = result.toFixed(3).replace(".", ",") + " " + Resistividade.attributes["unidade"].value;
		}
		else if (comprimento == "")
		{
			result = (area*resistencia)/resistividade;
			Comprimento.value = result.toFixed(3).replace(".", ",") + " " + Comprimento.attributes["unidade"].value;
		}
		else if (area == "")
		{
			result = (resistividade*comprimento)/resistencia;
			Area.value = result.toFixed(3).replace(".", ",") + " " + Area.attributes["unidade"].value;
		}
	}	
	//Calculo opção 3 - Cores
	if (Calc == 3)
	{
		var Resistencia = document.querySelector("#txt_resistencia_c3");
		var Tolerancia = document.querySelector("#txt_tolerancia_c3");
		
		var resistencia = Resistencia.value.replace(Resistencia.attributes["unidade"].value, "").trim();
			resistencia = resistencia.replace(",", ".");
		var tolerancia = Tolerancia.value.replace(Tolerancia.attributes["unidade"].value, "").trim();
			tolerancia = tolerancia.replace(",", ".");
		
		var tabelaFaixas = 
		{
			faixa1: ["", 1, 2, 3, 4, 5, 6, 7, 8, 9, "", ""],
			faixa2: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "", ""],
			faixa3: [Math.pow(10, 0), Math.pow(10, 1), Math.pow(10, 2), Math.pow(10, 3), Math.pow(10, 4), Math.pow(10, 5), Math.pow(10, 6), Math.pow(10, 7), Math.pow(10, 8), Math.pow(10, 9), Math.pow(10, -1), Math.pow(10, -2)],
			faixa4: ["", 1, 2, "", "", "", "", "", "", "", 5, 10]
		}
		
		/*if (tolerancia == "")
		{
			if (cmb_faixa4.value != "")
			{
				tolerancia = tabelaFaixas.faixa4[cmb_faixa4.value];
				
				Tolerancia.value = tolerancia + " " + ((tolerancia != "") ? Tolerancia.attributes["unidade"].value : "");
			}
		}
		else if (tolerancia != "")
		{
			cmb_faixa4.value = tabelaFaixas.faixa4.indexOf(parseFloat(tolerancia));
			
			try
			{
				cmb_faixa4.onchange();
			}
			catch (exe)
			{
				cmb_faixa4.value = '';
				cmb_faixa4.onchange();
			}
		}
		
		if (resistencia == "")
		{
			if (cmb_faixa1.value != "" && cmb_faixa2.value != "" && cmb_faixa3.value != "")
			{
				resistencia = parseInt(tabelaFaixas.faixa1[cmb_faixa1.value].toString() + tabelaFaixas.faixa2[cmb_faixa2.value].toString())*tabelaFaixas.faixa3[cmb_faixa3.value];
				
				Resistencia.value = resistencia.toString().replace(".", ",") + " " + Resistencia.attributes["unidade"].value;
			}
		}
		else if (resistencia != "")
		{
			var cont;
			var aux;
			
			for (cont = 0; cont <= tabelaFaixas.faixa3.length - 1; cont = cont + 1)
			{
				aux = resistencia/tabelaFaixas.faixa3[cont];
				if (aux >= 10 && aux < 100)
				{
					break;
				}
			}
			
			aux = (resistencia/tabelaFaixas.faixa3[cont]);
			aux = aux.toFixed(0);
			
			cmb_faixa1.value = aux[0];
			cmb_faixa2.value = aux[1];
			cmb_faixa3.value = cont;
			
			cmb_faixa1.onchange();
			cmb_faixa2.onchange();
			cmb_faixa3.onchange();
		}*/
		
		if (cmb_calculo_c3.value == 0)
		{
			if (cmb_faixa1.value != "" && cmb_faixa2.value != "" && cmb_faixa3.value != "")
			{
				resistencia = parseInt(tabelaFaixas.faixa1[cmb_faixa1.value].toString() + tabelaFaixas.faixa2[cmb_faixa2.value].toString())*tabelaFaixas.faixa3[cmb_faixa3.value];
				
				Resistencia.value = resistencia.toString().replace(".", ",") + " " + Resistencia.attributes["unidade"].value;
			}
			
			if (cmb_faixa4.value != "")
			{
				tolerancia = tabelaFaixas.faixa4[cmb_faixa4.value];
				
				Tolerancia.value = tolerancia + " " + ((tolerancia != "") ? Tolerancia.attributes["unidade"].value : "");
			}
		}
		else
		{
			var cont;
			var aux;
			
			for (cont = 0; cont <= tabelaFaixas.faixa3.length - 1; cont = cont + 1)
			{
				aux = resistencia/tabelaFaixas.faixa3[cont];
				if (aux >= 10 && aux < 100)
				{
					break;
				}
			}
			
			aux = (resistencia/tabelaFaixas.faixa3[cont]);
			aux = aux.toFixed(0);
			
			cmb_faixa1.value = aux[0];
			cmb_faixa2.value = aux[1];
			cmb_faixa3.value = cont;
			
			cmb_faixa1.onchange();
			cmb_faixa2.onchange();
			cmb_faixa3.onchange();
			
			cmb_faixa4.value = tabelaFaixas.faixa4.indexOf(parseFloat(tolerancia));
			
			try
			{
				cmb_faixa4.onchange();
			}
			catch (exe)
			{
				cmb_faixa4.value = '';
				cmb_faixa4.onchange();
			}
		}
	}
	else if (Calc == 4)
	{//Calculo opção 4 - Resistores em Série
		var R1 = document.querySelector("#txt_r1_c4");
		var R2 = document.querySelector("#txt_r2_c4");
		var Req = document.querySelector("#txt_req_c4");

		var r1 = R1.value.replace(R1.attributes["unidade"].value, "").trim();
			r1 = r1.replace(",", ".");
		var r2 = R2.value.replace(R2.attributes["unidade"].value, "").trim();
			r2 = r2.replace(",", ".");
		var req = Req.value.replace(Req.attributes['unidade'].value, "").trim();
			req = req.replace(",", ".");
			
		if (r1 == "")
		{
			r1= req - r2;
			R1.value = r1.toFixed(3).replace(".", ",") + " " + R1.attributes['unidade'].value;
		}
		else if (r2 == "")
		{
			r2 = req - r1;
			R2.value = r2.toFixed(3).replace(".", ",") + " " + R2.attributes['unidade'].value;
		}
		else
		{
			r1 = parseFloat(r1);
			r2 = parseFloat(r2);
			
			req = r1 + r2;
			Req.value = req.toFixed(3).replace(".", ",") + " " + Req.attributes['unidade'].value;
		}
	}	
	//Calculo opção 5 - Resistores em Paralelo
	else if (Calc == 5)
	{
		var R1 = document.querySelector("#txt_r1_c5");
		var R2 = document.querySelector("#txt_r2_c5");
		var Req = document.querySelector("#txt_req_c5");

		var r1 = R1.value.replace(R1.attributes["unidade"].value, "").trim();
			r1 = r1.replace(",", ".");
		var r2 = R2.value.replace(R2.attributes["unidade"].value, "").trim();
			r2 = r2.replace(",", ".");
		var req = Req.value.replace(Req.attributes['unidade'].value, "").trim();
			req = req.replace(",", ".");

		if (r1 == "")
		{
			r1= req * r2/(r2-req);
			R1.value = r1.toFixed(3).replace(".", ",") + " " + R1.attributes['unidade'].value;
		}
		else if (r2 == "")
		{
			r2 = req * r1/(r1-req);
			R2.value = r2.toFixed(3).replace(".", ",") + " " + R2.attributes['unidade'].value;
		}
		else
		{
			r1 = parseFloat(r1);
			r2 = parseFloat(r2);
			
			req = r1 * r2/(r1+r2);
			Req.value = req.toFixed(3).replace(".", ",") + " " + Req.attributes['unidade'].value;
		}
	}	
}