window.onload = function()
		{
			teto = 0;
			parede = 0;
			planoTrabalho = 0;
		}
		
		cmb_sistemaIluminacao.onclick = function()
		{
			
			sis = cmb_sistemaIluminacao.value;
			
			if(sis == 3 || sis == 5 || sis == 0)
			{
				txt_suspensaoLuminaria.value = 0;
				txt_suspensaoLuminaria.disabled = true;	
			}
			else
			{
				txt_suspensaoLuminaria.disabled = false;
				txt_suspensaoLuminaria.value = "";
			}
		}
		
		cmb_sistemaIluminacao.onchange = function()
		{
			
			sis = cmb_sistemaIluminacao.value;
			
			if(sis == 3 || sis == 5 || sis == 0)
			{
				txt_suspensaoLuminaria.value = 0;
				txt_suspensaoLuminaria.disabled = true;	
			}
			else
			{
				txt_suspensaoLuminaria.disabled = false;
				txt_suspensaoLuminaria.value = "";
			}
		}
		
		function calcular()
		{
			//RECEBENDO DADOS
			
			//Pe Direito
			h = parseFloat(txt_peDireito.value.replace(",", ".").replace("m", "").trim());
			
			//Comprimento
			c = parseFloat(txt_comprimento.value.replace(",", ".").replace("m", "").trim());
			
			//Largura
			l = parseFloat(txt_largura.value.replace(",", ".").replace("m", "").trim());
			
			//Iluminancia
			E = parseFloat(txt_iluminancia.value.replace(",", ".").replace("lx", "").trim());
			
			//Ambiente Limpeza
			al = cmb_ambiente.value;
			
			//Manutenção
			mnt = cmb_manutencao.value;
			
			//Sistema de Iluminação
			sistemaIluminacao = cmb_sistemaIluminacao.value;
			
			//Suspensão da Liminária
			suspensaoLuminaria = parseFloat(txt_suspensaoLuminaria.value.replace(",", ".").replace("m", "").trim());
			
			//Potência
			potencia = parseFloat(txt_potencia.value.replace(",", ".").replace("V", "").trim());
			
			//Fluxo Luminoso Inicial
			flI = parseFloat(txt_fluxoLuminosoInicial.value.replace(",", ".").replace("lm", "").trim());
			
			//Altura Plano de Trabalho
			hPT = parseFloat(txt_alturaPlanoTrabalho.value.replace(",", ".").replace("m", "").trim());
			
			//CALCULANDO
			
			//Área
			area = l * c;
			
			//Perímetro
			perimetro = (c*2) + (l*2);
			
			//Altura Util (hu)
			if(sistemaIluminacao == 1 || sistemaIluminacao == 2 || sistemaIluminacao == 4)
			{
				hu = h - (suspensaoLuminaria + hPT);
			}
			else
			{
				hu = h - hPT;
			}
			
			//Indice Local (K)
			K = (c*l)/((c+l) * hu);
			
			//Depreciação
			if (al == 1)
			{
				if (mnt == 1)
				{
					dep = 0.95;
				}
				else if (mnt == 2)
				{
					dep = 0.91;
				}
				else if (mnt == 3)
				{
					dep = 0.88;
				}
				else { }
			}

			else if (al == 2)
			{
				if (mnt == 1)
				{
					dep = 0.91;
				}
				else if (mnt == 2)
				{
					dep = 0.85;
				}
				else if (mnt == 3)
				{
					dep = 0.80;
				}
				else { }
			}

			else if (al == 3)
			{
				if (mnt == 1)
				{
					dep = 0.80;
				}
				else if (mnt == 2)
				{
					dep = 0.66;
				}
				else if (mnt == 3)
				{
					dep = 0.57;
				}
				else { }
			}
			else {}
						
			
			K = parseFloat(K);
			
			
			//Coeficiente de Utilização
			if (K <= 0.60)
			{
				K = 0.60;
				if (teto == 80 && parede == 80 && plano == 30)
				{
					fat = 51;
				}
				else if (teto == 80 && parede == 50 && plano == 30)
				{
					fat = 38;
				}

				else if (teto == 80 && parede == 30 && plano == 30)
				{
					fat = 33;
				}

				else if (teto == 50 && parede == 50 && plano == 30)
				{
					fat = 37;
				}

				else if (teto == 50 && parede == 30 && plano == 30)
				{
					fat = 33;
				}

				else if (teto == 70 && parede == 70 && plano == 20)
				{
					fat = 43;
				}

				else if (teto == 70 && parede == 50 && plano == 20)
				{
					fat = 37;
				}

				else if (teto == 70 && parede == 30 && plano == 20)
				{
					fat = 33;
				}

				else if (teto == 80 && parede == 80 && plano == 10)
				{
					fat = 46;
				}

				else if (teto == 80 && parede == 50 && plano == 10)
				{
					fat = 36;
				}

				else if (teto == 80 && parede == 30 && plano == 10)
				{
					fat = 32;
				}

				else if (teto == 50 && parede == 50 && plano == 10)
				{
					fat = 35;
				}

				else if (teto == 50 && parede == 30 && plano == 10)
				{
					fat = 32;
				}

				else if (teto == 30 && parede == 30 && plano == 10)
				{
					fat = 32;
				}
				else
				{
					fat = 29;
				}
			}

			else if (K > 0.60 && K <= 0.80)
			{

				K = 0.80;
				if (teto == 80 && parede == 80 && plano == 30)
				{
					fat = 58;
				}
				else if (teto == 80 && parede == 50 && plano == 30)
				{
					fat = 45;
				}
				else if (teto == 80 && parede == 30 && plano == 30)
				{
					fat = 41;
				}
				else if (teto == 50 && parede == 50 && plano == 30)
				{
					fat = 44;
				}

				else if (teto == 50 && parede == 30 && plano == 30)
				{
					fat = 40;
				}
				else if (teto == 70 && parede == 70 && plano == 20)
				{
					fat = 49;
				}

				else if (teto == 70 && parede == 50 && plano == 20)
				{
					fat = 43;
				}

				else if (teto == 70 && parede == 30 && plano == 20)
				{
					fat = 40;
				}

				else if (teto == 80 && parede == 80 && plano == 10)
				{
					fat = 51;
				}

				else if (teto == 80 && parede == 50 && plano == 10)
				{
					fat = 43;
				}

				else if (teto == 80 && parede == 30 && plano == 10)
				{
					fat = 39;
				}

				else if (teto == 50 && parede == 50 && plano == 10)
				{
					fat = 42;
				}

				else if (teto == 50 && parede == 30 && plano == 10)
				{
					fat = 39;
				}

				else if (teto == 30 && parede == 30 && plano == 10)
				{
					fat = 38;
				}

				else
				{
					fat = 35;
				}
			}

			else if (K > 0.80 && K <= 1.00)
			{
				K = 1.00;
				if (teto == 80 && parede == 80 && plano == 30)
				{
					fat = 62;
				}
				else if (teto == 80 && parede == 50 && plano == 30)
				{
					fat = 50;
				}
				else if (teto == 80 && parede == 30 && plano == 30)
				{
					fat = 46;
				}
				else if (teto == 50 && parede == 50 && plano == 30)
				{
					fat = 48;
				}

				else if (teto == 50 && parede == 30 && plano == 30)
				{
					fat = 44;
				}

				else if (teto == 70 && parede == 70 && plano == 20)
				{
					fat = 53;
				}

				else if (teto == 70 && parede == 50 && plano == 20)
				{
					fat = 48;
				}

				else if (teto == 70 && parede == 30 && plano == 20)
				{
					fat = 44;
				}

				else if (teto == 80 && parede == 80 && plano == 10)
				{
					fat = 54;
				}

				else if (teto == 80 && parede == 50 && plano == 10)
				{
					fat = 47;
				}

				else if (teto == 80 && parede == 30 && plano == 10)
				{
					fat = 43;
				}

				else if (teto == 50 && parede == 50 && plano == 10)
				{
					fat = 46;
				}

				else if (teto == 50 && parede == 30 && plano == 10)
				{
					fat = 43;
				}

				else if (teto == 30 && parede == 30 && plano == 10)
				{
					fat = 42;
				}

				else
				{
					fat = 39;
				}
			}

			else if (K > 1.00 && K <= 1.25)
			{
				K = 1.25;
				if (teto == 80 && parede == 80 && plano == 30)
				{
					fat = 66;
				}
				else if (teto == 80 && parede == 50 && plano == 30)
				{
					fat = 56;
				}
				else if (teto == 80 && parede == 30 && plano == 30)
				{
					fat = 52;
				}
				else if (teto == 50 && parede == 50 && plano == 30)
				{
					fat = 53;
				}

				else if (teto == 50 && parede == 30 && plano == 30)
				{
					fat = 50;
				}

				else if (teto == 70 && parede == 70 && plano == 20)
				{
					fat = 57;
				}

				else if (teto == 70 && parede == 50 && plano == 20)
				{
					fat = 53;
				}

				else if (teto == 70 && parede == 30 && plano == 20)
				{
					fat = 50;
				}

				else if (teto == 80 && parede == 80 && plano == 10)
				{
					fat = 58;
				}

				else if (teto == 80 && parede == 50 && plano == 10)
				{
					fat = 52;
				}

				else if (teto == 80 && parede == 30 && plano == 10)
				{
					fat = 52;
				}

				else if (teto == 50 && parede == 50 && plano == 10)
				{
					fat = 50;
				}

				else if (teto == 50 && parede == 30 && plano == 10)
				{
					fat = 48;
				}

				else if (teto == 30 && parede == 30 && plano == 10)
				{
					fat = 47;
				}

				else
				{
					fat = 45;
				}
			}

			else if (K > 1.25 && K <= 1.50)
			{
				K = 1.50;
				if (teto == 80 && parede == 80 && plano == 30)
				{
					fat = 68;
				}
				else if (teto == 80 && parede == 50 && plano == 30)
				{
					fat = 60;
				}
				else if (teto == 80 && parede == 30 && plano == 30)
				{
					fat = 56;
				}
				else if (teto == 50 && parede == 50 && plano == 30)
				{
					fat = 56;
				}

				else if (teto == 50 && parede == 30 && plano == 30)
				{
					fat = 53;
				}

				else if (teto == 70 && parede == 70 && plano == 20)
				{
					fat = 60;
				}

				else if (teto == 70 && parede == 50 && plano == 20)
				{
					fat = 56;
				}

				else if (teto == 70 && parede == 30 && plano == 20)
				{
					fat = 53;
				}

				else if (teto == 80 && parede == 80 && plano == 10)
				{
					fat = 59;
				}

				else if (teto == 80 && parede == 50 && plano == 10)
				{
					fat = 54;
				}

				else if (teto == 80 && parede == 30 && plano == 10)
				{
					fat = 55;
				}

				else if (teto == 50 && parede == 50 && plano == 10)
				{
					fat = 53;
				}

				else if (teto == 50 && parede == 30 && plano == 10)
				{
					fat = 51;
				}

				else if (teto == 30 && parede == 30 && plano == 10)
				{
					fat = 50;
				}

				else
				{
					fat = 18;
				}
			}

			else if (K > 1.50 && K <= 2.00)
			{
				K = 2.00;
				if (teto == 80 && parede == 80 && plano == 30)
				{
					fat = 71;
				}
				else if (teto == 80 && parede == 50 && plano == 30)
				{
					fat = 64;
				}
				else if (teto == 80 && parede == 30 && plano == 30)
				{
					fat = 60;
				}
				else if (teto == 50 && parede == 50 && plano == 30)
				{
					fat = 60;
				}

				else if (teto == 50 && parede == 30 && plano == 30)
				{
					fat = 57;
				}

				else if (teto == 70 && parede == 70 && plano == 20)
				{
					fat = 62;
				}

				else if (teto == 70 && parede == 50 && plano == 20)
				{
					fat = 59;
				}

				else if (teto == 70 && parede == 30 && plano == 20)
				{
					fat = 57;
				}

				else if (teto == 80 && parede == 80 && plano == 10)
				{
					fat = 61;
				}

				else if (teto == 80 && parede == 50 && plano == 10)
				{
					fat = 57;
				}

				else if (teto == 80 && parede == 30 && plano == 10)
				{
					fat = 57;
				}

				else if (teto == 50 && parede == 50 && plano == 10)
				{
					fat = 55;
				}

				else if (teto == 50 && parede == 30 && plano == 10)
				{
					fat = 54;
				}

				else if (teto == 30 && parede == 30 && plano == 10)
				{
					fat = 53;
				}

				else
				{
					fat = 51;
				}
			}

			else if (K > 2.00 && K <= 2.50)
			{
				K = 2.50;
				if (teto == 80 && parede == 80 && plano == 30)
				{
					fat = 73;
				}

				else if (teto == 80 && parede == 50 && plano == 30)
				{
					fat = 67;
				}
				else if (teto == 80 && parede == 30 && plano == 30)
				{
					fat = 64;
				}
				else if (teto == 50 && parede == 50 && plano == 30)
				{
					fat = 62;
				}

				else if (teto == 50 && parede == 30 && plano == 30)
				{
					fat = 60;
				}

				else if (teto == 70 && parede == 70 && plano == 20)
				{
					fat = 64;
				}

				else if (teto == 70 && parede == 50 && plano == 20)
				{
					fat = 62;
				}

				else if (teto == 70 && parede == 30 && plano == 20)
				{
					fat = 59;
				}

				else if (teto == 80 && parede == 80 && plano == 10)
				{
					fat = 62;
				}

				else if (teto == 80 && parede == 50 && plano == 10)
				{
					fat = 59;
				}

				else if (teto == 80 && parede == 30 && plano == 10)
				{
					fat = 59;
				}

				else if (teto == 50 && parede == 50 && plano == 10)
				{
					fat = 57;
				}

				else if (teto == 50 && parede == 30 && plano == 10)
				{
					fat = 56;
				}

				else if (teto == 30 && parede == 30 && plano == 10)
				{
					fat = 55;
				}

				else
				{
					fat = 53;
				}
			}

			else if (K > 2.50 && K <= 3.00)
			{
				K = 3.00;
				if (teto == 80 && parede == 80 && plano == 30)
				{
					fat = 74;
				}

				else if (teto == 80 && parede == 50 && plano == 30)
				{
					fat = 69;
				}
				else if (teto == 80 && parede == 30 && plano == 30)
				{
					fat = 66;
				}
				else if (teto == 50 && parede == 50 && plano == 30)
				{
					fat = 64;
				}

				else if (teto == 50 && parede == 30 && plano == 30)
				{
					fat = 62;
				}

				else if (teto == 70 && parede == 70 && plano == 20)
				{
					fat = 66;
				}

				else if (teto == 70 && parede == 50 && plano == 20)
				{
					fat = 63;
				}

				else if (teto == 70 && parede == 30 && plano == 20)
				{
					fat = 62;
				}

				else if (teto == 80 && parede == 80 && plano == 10)
				{
					fat = 63;
				}

				else if (teto == 80 && parede == 50 && plano == 10)
				{
					fat = 61;
				}

				else if (teto == 80 && parede == 30 && plano == 10)
				{
					fat = 60;
				}

				else if (teto == 50 && parede == 50 && plano == 10)
				{
					fat = 59;
				}

				else if (teto == 50 && parede == 30 && plano == 10)
				{
					fat = 58;
				}

				else if (teto == 30 && parede == 30 && plano == 10)
				{
					fat = 57;
				}

				else
				{
					fat = 55;
				}
			}

			else if (K > 3.00 && K <= 4.00)
			{
				K = 4.00;
				if (teto == 80 && parede == 80 && plano == 30)
				{
					fat = 76;
				}

				else if (teto == 80 && parede == 50 && plano == 30)
				{
					fat = 71;
				}
				else if (teto == 80 && parede == 30 && plano == 30)
				{
					fat = 69;
				}
				else if (teto == 50 && parede == 50 && plano == 30)
				{
					fat = 65;
				}

				else if (teto == 50 && parede == 30 && plano == 30)
				{
					fat = 64;
				}

				else if (teto == 70 && parede == 70 && plano == 20)
				{
					fat = 67;
				}

				else if (teto == 70 && parede == 50 && plano == 20)
				{
					fat = 65;
				}

				else if (teto == 70 && parede == 30 && plano == 20)
				{
					fat = 63;
				}

				else if (teto == 80 && parede == 80 && plano == 10)
				{
					fat = 64;
				}

				else if (teto == 80 && parede == 50 && plano == 10)
				{
					fat = 62;
				}

				else if (teto == 80 && parede == 30 && plano == 10)
				{
					fat = 62;
				}

				else if (teto == 50 && parede == 50 && plano == 10)
				{
					fat = 60;
				}

				else if (teto == 50 && parede == 30 && plano == 10)
				{
					fat = 59;
				}

				else if (teto == 30 && parede == 30 && plano == 10)
				{
					fat = 58;
				}

				else
				{
					fat = 56;
				}
			}

			else if (K > 4.00 && K <= 5.00)
			{
				K = 5.00;
				if (teto == 80 && parede == 80 && plano == 30)
				{
					fat = 76;
				}

				else if (teto == 80 && parede == 50 && plano == 30)
				{
					fat = 73;
				}
				else if (teto == 80 && parede == 30 && plano == 30)
				{
					fat = 71;
				}
				else if (teto == 50 && parede == 50 && plano == 30)
				{
					fat = 67;
				}
				else if (teto == 50 && parede == 30 && plano == 30)
				{
					fat = 65;
				}

				else if (teto == 70 && parede == 70 && plano == 20)
				{
					fat = 67;
				}

				else if (teto == 70 && parede == 50 && plano == 20)
				{
					fat = 66;
				}

				else if (teto == 70 && parede == 30 && plano == 20)
				{
					fat = 65;
				}

				else if (teto == 80 && parede == 80 && plano == 10)
				{
					fat = 64;
				}

				else if (teto == 80 && parede == 50 && plano == 10)
				{
					fat = 62;
				}

				else if (teto == 80 && parede == 30 && plano == 10)
				{
					fat = 62;
				}

				else if (teto == 50 && parede == 50 && plano == 10)
				{
					fat = 61;
				}

				else if (teto == 50 && parede == 30 && plano == 10)
				{
					fat = 60;
				}

				else if (teto == 30 && parede == 30 && plano == 10)
				{
					fat = 59;
				}

				else
				{
					fat = 57;
				}
			}

			else { K = 6.00; fat = 0; }
			
			
			fat = parseFloat(fat);
			
			
			//fluxo Luminoso
			flTotal = E * area *((dep*100)/fat);
			
			
			//numero de pontos de luz
			nPontosLuz = flTotal / flI;
		
			//potencia total
			potenciaTotal = nPontosLuz * potencia;
			
			depreciacao = dep *100;
			
			//EXIBIÇÃO
			
			lbl_alturaUtil.innerHTML = hu.toFixed(2).toString().replace(".", ",") + " m";
			lbl_area.innerHTML = area.toFixed(2).toString().replace(".", ",") + " m²";
			lbl_coeficienteUtilizacao.innerHTML = fat.toFixed(2).toString().replace(".", ",") + "%";
			lbl_fatorDepreciacao.innerHTML = depreciacao.toFixed(2).toString().replace(".", ",") + "%";
			lbl_fluxoLuminosoTotal.innerHTML = flTotal.toFixed(2).toString().replace(".", ",") + " lm";
			lbl_indiceLocal.innerHTML = K.toFixed(2).toString().replace(".", ",") + " K";
			lbl_numeroPontosLuz.innerHTML = Math.ceil(nPontosLuz);
			lbl_perimetro.innerHTML = perimetro.toFixed(2).toString().replace(".", ",") + " m";
			lbl_potenciaTotal.innerHTML = potenciaTotal.toFixed(2).toString().replace(".", ",") + " W";
			
			//Calculo de Coeficiente de Reflexão
			if(teto != 0 && parede != 0 && plano != 0)
			{
				
			}			
			else
			{
				
			}
			
			
		}
				
		paletaCores.onclick = function ref(event)
		{
		
			pRef = event.target.value;
			
			if(pRef == 1)
			{
				pRef = 10;
			}
			
			else if(pRef == 2)
			{
				pRef = 30;
			}
			
			else if(pRef == 3)
			{
				pRef = 50;
			}
			
			else if(pRef == 4)
			{
				pRef = 70;
			}
			
			else if(pRef == 5)
			{
				pRef = 80;
			}
			else{}
			
			if(cmb_plano.value == 1)
			{
				teto = pRef;
				lbl_teto.innerHTML = "Teto - "+pRef+"%";
			}
			
			if(cmb_plano.value == 2)
			{
				parede = pRef;
				lbl_parede.innerHTML = "Parede - "+pRef+"%";
			}
			
			if(cmb_plano.value == 3)
			{
				plano = pRef;
				lbl_planoTrabalho.innerHTML = "Plano de Trabalho - "+pRef+"%";
			}
			
			verificarPlano(pRef, cmb_plano.value);
			
		}
		//area
	
		//perimetro
				
		//altura util (hu)
		// alturaUtil = altura - (suspensao + plano de trabalho)
		
		//indice local (K)
		// indiceLocal = (comprimento * largura) / ((comprimento + largura) * alturaUtil);
		
		//depreciacao(d) (Tabela pronta em C#) 
		// tabela...combinação de manutencao e ambiente
		
		
		
		//CoeficienteUtilizacao(u) (Já tem uns ifs gigantescos prontos em C#)
		// tabela... Indice Local e reflexao (teto,paredes,plano de trabalho)
		
		//REFLEXAO
		//primeira coluna - 10%
		//segunda coluna - 30%
		//terceira coluna - 50%;
		//quarta coluna - 70%;
		//quinta coluna - 80%;
		
		
		//iluminancia(E)
		// inserido no form pelo usuario...
		
		//fluxo Luminoso
		// fluxoLuminoso =  iluminancia * area * (depreciacao / CoeficienteUtilizacao);
		
		//numero de pontos de luz
		// numeroPontosLuz = fluxoLuminoso / fluxoLuminosoInicial;
		
		//potencia total
		// potenciaTotal = numeroPontosLuz * potencia