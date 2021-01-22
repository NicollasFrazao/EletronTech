cmb_categoria.onchange = function(){
	Add();
}

function Add(){
	var c = document.getElementById("cmb_categoria");
	var itemSelecionado = c.options[c.selectedIndex].value;
	var u = document.getElementById("cmb_unidadeInicial");
	var uf = document.getElementById("cmb_unidadeFinal");

	if(itemSelecionado == 0){
		while (u.length){
			u.remove(0);
		}

		var opt00 = document.createElement("option");
		opt00.value = "0";
		opt00.text = "Selecione uma Opção";
		cmb_unidadeInicial.add(opt00, cmb_unidadeInicial.options[0]);

		while (uf.length){
			uf.remove(0);
		}
		var opt0 = document.createElement("option");
		opt0.value = "0";
		opt0.text = "Selecione uma Opção";
		cmb_unidadeFinal.add(opt0, cmb_unidadeFinal.options[0]);
	}
	else if(itemSelecionado == 1){
		while (u.length){
			u.remove(0);
		}

		var opt00 = document.createElement("option");
		opt00.value = "0";
		opt00.text = "Selecione uma Opção";
		cmb_unidadeInicial.add(opt00, cmb_unidadeInicial.options[0]);

		while (uf.length){
			uf.remove(0);
		}
		var opt0 = document.createElement("option");
		opt0.value = "0";
		opt0.text = "Selecione uma Opção";
		cmb_unidadeFinal.add(opt0, cmb_unidadeFinal.options[0]);

		var opt1 = document.createElement("option");
		opt1.value = "1";
		opt1.text = "NanoCoulomb (nC)";
		cmb_unidadeInicial.add(opt1, cmb_unidadeInicial.options[1]);

		var op1 = document.createElement("option");
		op1.value = "1";
		op1.text = "NanoCoulomb (nC)";
		cmb_unidadeFinal.add(op1, cmb_unidadeFinal.options[1]);

		var opt2 = document.createElement("option");
		opt2.value = "2";
		opt2.text = "Microcoulomb (µC)";
		cmb_unidadeInicial.add(opt2, cmb_unidadeInicial.options[2]);

		var op2 = document.createElement("option");
		op2.value = "2";
		op2.text = "Microcoulomb (µC)";
		cmb_unidadeFinal.add(op2, cmb_unidadeFinal.options[2]);

		var opt3 = document.createElement("option");
		opt3.value = "3";
		opt3.text = "Milicoulomb (mC)";
		cmb_unidadeInicial.add(opt3, cmb_unidadeInicial.options[3]);

		var op3 = document.createElement("option");
		op3.value = "3";
		op3.text = "Milicoulomb (mC)";
		cmb_unidadeFinal.add(op3, cmb_unidadeFinal.options[3]);

		var opt4 = document.createElement("option");
		opt4.value = "4";
		opt4.text = "Coulomb (C)";
		cmb_unidadeInicial.add(opt4, cmb_unidadeInicial.options[4]);

		var op4 = document.createElement("option");
		op4.value = "4";
		op4.text = "Coulomb (C)";
		cmb_unidadeFinal.add(op4, cmb_unidadeFinal.options[4]);

		var opt5 = document.createElement("option");
		opt5.value = "5";
		opt5.text = "Kilocoulomb (kC)";
		cmb_unidadeInicial.add(opt5, cmb_unidadeInicial.options[5]);

		var op5 = document.createElement("option");
		op5.value = "5";
		op5.text = "Kilocoulomb (kC)";
		cmb_unidadeFinal.add(op5, cmb_unidadeFinal.options[5]);

		var opt6 = document.createElement("option");
		opt6.value = "6";
		opt6.text = "Megacoulomb (MC)";
		cmb_unidadeInicial.add(opt6, cmb_unidadeInicial.options[6]);

		var op6 = document.createElement("option");
		op6.value = "6";
		op6.text = "Megacoulomb (MC)";
		cmb_unidadeFinal.add(op6, cmb_unidadeFinal.options[6]);

		var opt7 = document.createElement("option");
		opt7.value = "7";
		opt7.text = "Abcoulomb (abC)";
		cmb_unidadeInicial.add(opt7, cmb_unidadeInicial.options[7]);

		var op7 = document.createElement("option");
		op7.value = "7";
		op7.text = "Abcoulomb (abC)";
		cmb_unidadeFinal.add(op7, cmb_unidadeFinal.options[7]);

		var opt8 = document.createElement("option");
		opt8.value = "8";
		opt8.text = "Miliampere-hora (mAh)";
		cmb_unidadeInicial.add(opt8, cmb_unidadeInicial.options[8]);

		var opt8 = document.createElement("option");
		opt8.value = "8";
		opt8.text = "Miliampere-hora (mAh)";
		cmb_unidadeFinal.add(opt8, cmb_unidadeFinal.options[8]);

		var opt9 = document.createElement("option");
		opt9.value = "9";
		opt9.text = "Ampère-hora (Ah)";
		cmb_unidadeInicial.add(opt9, cmb_unidadeInicial.options[9]);

		var op9 = document.createElement("option");
		op9.value = "9";
		op9.text = "Ampère-hora (Ah)";
		cmb_unidadeFinal.add(op9, cmb_unidadeFinal.options[9]);

		var opt10 = document.createElement("option");
		opt10.value = "10";
		opt10.text = "Faraday (F)";
		cmb_unidadeInicial.add(opt10, cmb_unidadeInicial.options[10]);

		var op10 = document.createElement("option");
		op10.value = "10";
		op10.text = "Faraday (F)";
		cmb_unidadeFinal.add(op10, cmb_unidadeFinal.options[10]);

		var opt11 = document.createElement("option");
		opt11.value = "11";
		opt11.text = "Statcoulomb (statC)";
		cmb_unidadeInicial.add(opt11, cmb_unidadeInicial.options[11]);

		var op11 = document.createElement("option");
		op11.value = "11";
		op11.text = "Statcoulomb (statC)";
		cmb_unidadeFinal.add(op11, cmb_unidadeFinal.options[11]);

		var opt12 = document.createElement("option");
		opt12.value = "12";
		opt12.text = "Carga elementar (e)";
		cmb_unidadeInicial.add(opt12, cmb_unidadeInicial.options[12]);

		var op12 = document.createElement("option");
		op12.value = "12";
		op12.text = "Carga elementar (e)";
		cmb_unidadeFinal.add(op12, cmb_unidadeFinal.options[12]);
	}
	else if(itemSelecionado == 2){
		while (u.length){
			u.remove(0);
		}

		var opt00 = document.createElement("option");
		opt00.value = "0";
		opt00.text = "Selecione uma Opção";
		cmb_unidadeInicial.add(opt00, cmb_unidadeInicial.options[0]);

		while (uf.length){
			uf.remove(0);
		}
		var opt0 = document.createElement("option");
		opt0.value = "0";
		opt0.text = "Selecione uma Opção";
		cmb_unidadeFinal.add(opt0, cmb_unidadeFinal.options[0]);
		
		var opt1 = document.createElement("option");
		opt1.value = "1";
		opt1.text = "Nanosiemens (nS)";
		cmb_unidadeInicial.add(opt1, cmb_unidadeInicial.options[1]);

		var op1 = document.createElement("option");
		op1.value = "1";
		op1.text = "Nanosiemens (nS)";
		cmb_unidadeFinal.add(op1, cmb_unidadeFinal.options[1]);

		var opt2 = document.createElement("option");
		opt2.value = "2";
		opt2.text = "Microsiemens (µS)";
		cmb_unidadeInicial.add(opt2, cmb_unidadeInicial.options[2]);

		var op2 = document.createElement("option");
		op2.value = "2";
		op2.text = "Microsiemens (µS)";
		cmb_unidadeFinal.add(op2, cmb_unidadeFinal.options[2]);

		var opt3 = document.createElement("option");
		opt3.value = "3";
		opt3.text = "Milisiemens (mS)";
		cmb_unidadeInicial.add(opt3, cmb_unidadeInicial.options[3]);

		var op3 = document.createElement("option");
		op3.value = "3";
		op3.text = "Milisiemens (mS)";
		cmb_unidadeFinal.add(op3, cmb_unidadeFinal.options[3]);

		var opt4 = document.createElement("option");
		opt4.value = "4";
		opt4.text = "Siemens (S)";
		cmb_unidadeInicial.add(opt4, cmb_unidadeInicial.options[4]);

		var op4 = document.createElement("option");
		op4.value = "4";
		op4.text = "Siemens (S)";
		cmb_unidadeFinal.add(op4, cmb_unidadeFinal.options[4]);

		var opt5 = document.createElement("option");
		opt5.value = "5";
		opt5.text = "Kilosiemens (kS)";
		cmb_unidadeInicial.add(opt5, cmb_unidadeInicial.options[5]);

		var op5 = document.createElement("option");
		op5.value = "5";
		op5.text = "Kilosiemens (kS)";
		cmb_unidadeFinal.add(op5, cmb_unidadeFinal.options[5]);

		var opt6 = document.createElement("option");
		opt6.value = "6";
		opt6.text = "Megasiemens (MS)";
		cmb_unidadeInicial.add(opt6, cmb_unidadeInicial.options[6]);

		var op6 = document.createElement("option");
		op6.value = "6";
		op6.text = "Megasiemens (MS)";
		cmb_unidadeFinal.add(op6, cmb_unidadeFinal.options[6]);

		var opt7 = document.createElement("option");
		opt7.value = "7";
		opt7.text = "Gigasiemens (GS)";
		cmb_unidadeInicial.add(opt7, cmb_unidadeInicial.options[7]);

		var op7 = document.createElement("option");
		op7.value = "7";
		op7.text = "Gigasiemens (GS)";
		cmb_unidadeFinal.add(op7, cmb_unidadeFinal.options[7]);

		var opt8 = document.createElement("option");
		opt8.value = "8";
		opt8.text = "Mho (?)";
		cmb_unidadeInicial.add(opt8, cmb_unidadeInicial.options[8]);

		var opt8 = document.createElement("option");
		opt8.value = "8";
		opt8.text = "Mho (?)";
		cmb_unidadeFinal.add(opt8, cmb_unidadeFinal.options[8]);

		var opt9 = document.createElement("option");
		opt9.value = "9";
		opt9.text = "Ampère por volt (A/V)";
		cmb_unidadeInicial.add(opt9, cmb_unidadeInicial.options[9]);

		var op9 = document.createElement("option");
		op9.value = "9";
		op9.text = "Ampère por volt (A/V)";
		cmb_unidadeFinal.add(op9, cmb_unidadeFinal.options[9]);
	}
	else if(itemSelecionado == 3){
		while (u.length){
			u.remove(0);
		}

		var opt00 = document.createElement("option");
		opt00.value = "0";
		opt00.text = "Selecione uma Opção";
		cmb_unidadeInicial.add(opt00, cmb_unidadeInicial.options[0]);

		while (uf.length){
			uf.remove(0);
		}
		var opt0 = document.createElement("option");
		opt0.value = "0";
		opt0.text = "Selecione uma Opção";
		cmb_unidadeFinal.add(opt0, cmb_unidadeFinal.options[0]);

		var opt1 = document.createElement("option");
		opt1.value = "1";
		opt1.text = "Nanoampère (nA)";
		cmb_unidadeInicial.add(opt1, cmb_unidadeInicial.options[1]);

		var op1 = document.createElement("option");
		op1.value = "1";
		op1.text = "Nanoampère (nA)";
		cmb_unidadeFinal.add(op1, cmb_unidadeFinal.options[1]);

		var opt2 = document.createElement("option");
		opt2.value = "2";
		opt2.text = "Microampère (µA)";
		cmb_unidadeInicial.add(opt2, cmb_unidadeInicial.options[2]);

		var op2 = document.createElement("option");
		op2.value = "2";
		op2.text = "Microampère (µA)";
		cmb_unidadeFinal.add(op2, cmb_unidadeFinal.options[2]);

		var opt3 = document.createElement("option");
		opt3.value = "3";
		opt3.text = "Ampère (A)";
		cmb_unidadeInicial.add(opt3, cmb_unidadeInicial.options[3]);

		var op3 = document.createElement("option");
		op3.value = "3";
		op3.text = "Ampère (A)";
		cmb_unidadeFinal.add(op3, cmb_unidadeFinal.options[3]);

		var opt4 = document.createElement("option");
		opt4.value = "4";
		opt4.text = "Kiloampère (kA)";
		cmb_unidadeInicial.add(opt4, cmb_unidadeInicial.options[4]);

		var op4 = document.createElement("option");
		op4.value = "4";
		op4.text = "Kiloampère (kA)";
		cmb_unidadeFinal.add(op4, cmb_unidadeFinal.options[4]);

		var opt5 = document.createElement("option");
		opt5.value = "5";
		opt5.text = "Megaampère (MA)";
		cmb_unidadeInicial.add(opt5, cmb_unidadeInicial.options[5]);

		var op5 = document.createElement("option");
		op5.value = "5";
		op5.text = "Megaampère (MA)";
		cmb_unidadeFinal.add(op5, cmb_unidadeFinal.options[5]);

		var opt6 = document.createElement("option");
		opt6.value = "6";
		opt6.text = "Gigaampère (GA)";
		cmb_unidadeInicial.add(opt6, cmb_unidadeInicial.options[6]);

		var op6 = document.createElement("option");
		op6.value = "6";
		op6.text = "Gigaampère (GA)";
		cmb_unidadeFinal.add(op6, cmb_unidadeFinal.options[6]);

		var opt7 = document.createElement("option");
		opt7.value = "7";
		opt7.text = "Abampère (aA)";
		cmb_unidadeInicial.add(opt7, cmb_unidadeInicial.options[7]);

		var op7 = document.createElement("option");
		op7.value = "7";
		op7.text = "Abampère (aA)";
		cmb_unidadeFinal.add(op7, cmb_unidadeFinal.options[7]);

		var opt8 = document.createElement("option");
		opt8.value = "8";
		opt8.text = "Coulomb (C/s)";
		cmb_unidadeInicial.add(opt8, cmb_unidadeInicial.options[8]);

		var opt8 = document.createElement("option");
		opt8.value = "8";
		opt8.text = "Coulomb (C/s)";
		cmb_unidadeFinal.add(opt8, cmb_unidadeFinal.options[8]); 

		var opt9 = document.createElement("option");
		opt9.value = "9";
		opt9.text ="Milampère (mA)";
		cmb_unidadeInicial.add(opt9, cmb_unidadeInicial.options[9]);

		var op9 = document.createElement("option");
		op9.value = "9";
		op9.text = "Milampère (mA)";
		cmb_unidadeFinal.add(op9, cmb_unidadeFinal.options[9]);
	}
	else if(itemSelecionado == 4){
		while (u.length){
			u.remove(0);
		}

		var opt00 = document.createElement("option");
		opt00.value = "0";
		opt00.text = "Selecione uma Opção";
		cmb_unidadeInicial.add(opt00, cmb_unidadeInicial.options[0]);

		while (uf.length){
			uf.remove(0);
		}
		var opt0 = document.createElement("option");
		opt0.value = "0";
		opt0.text = "Selecione uma Opção";
		cmb_unidadeFinal.add(opt0, cmb_unidadeFinal.options[0]);

		var opt1 = document.createElement("option");
		opt1.value = "1";
		opt1.text = "Nanohenry (nH)";
		cmb_unidadeInicial.add(opt1, cmb_unidadeInicial.options[1]);

		var op1 = document.createElement("option");
		op1.value = "1";
		op1.text = "Nanohenry (nH)";
		cmb_unidadeFinal.add(op1, cmb_unidadeFinal.options[1]);

		var opt2 = document.createElement("option");
		opt2.value = "2";
		opt2.text = "Microhenry (µH)";
		cmb_unidadeInicial.add(opt2, cmb_unidadeInicial.options[2]);

		var op2 = document.createElement("option");
		op2.value = "2";
		op2.text = "Microhenry (µH)";
		cmb_unidadeFinal.add(op2, cmb_unidadeFinal.options[2]);

		var opt3 = document.createElement("option");
		opt3.value = "3";
		opt3.text ="Milihenry (mH)";
		cmb_unidadeInicial.add(opt3, cmb_unidadeInicial.options[3]);

		var op3 = document.createElement("option");
		op3.value = "3";
		op3.text = "Milihenry (mH)";
		cmb_unidadeFinal.add(op3, cmb_unidadeFinal.options[3]);

		var opt4 = document.createElement("option");
		opt4.value = "4";
		opt4.text = "Henry (H)";
		cmb_unidadeInicial.add(opt4, cmb_unidadeInicial.options[4]);

		var op4 = document.createElement("option");
		op4.value = "4";
		op4.text = "Henry (H)";
		cmb_unidadeFinal.add(op4, cmb_unidadeFinal.options[4]);

		var opt5 = document.createElement("option");
		opt5.value = "5";
		opt5.text = "Quilohenry (kH)";
		cmb_unidadeInicial.add(opt5, cmb_unidadeInicial.options[5]);

		var op5 = document.createElement("option");
		op5.value = "5";
		op5.text = "Quilohenry (kH)";
		cmb_unidadeFinal.add(op5, cmb_unidadeFinal.options[5]);

		var opt6 = document.createElement("option");
		opt6.value = "6";
		opt6.text = "Megahenry (MH)";
		cmb_unidadeInicial.add(opt6, cmb_unidadeInicial.options[6]);

		var op6 = document.createElement("option");
		op6.value = "6";
		op6.text = "Megahenry (MH)";
		cmb_unidadeFinal.add(op6, cmb_unidadeFinal.options[6]);

		var opt7 = document.createElement("option");
		opt7.value = "7";
		opt7.text = "Gigahenry (GH)";
		cmb_unidadeInicial.add(opt7, cmb_unidadeInicial.options[7]);

		var op7 = document.createElement("option");
		op7.value = "7";
		op7.text = "Gigahenry (GH)";
		cmb_unidadeFinal.add(op7, cmb_unidadeFinal.options[7]);

		var opt8 = document.createElement("option");
		opt8.value = "8";
		opt8.text = "Abhenry (?)";
		cmb_unidadeInicial.add(opt8, cmb_unidadeInicial.options[8]);

		var opt8 = document.createElement("option");
		opt8.value = "8";
		opt8.text = "Abhenry (?)";
		cmb_unidadeFinal.add(opt8, cmb_unidadeFinal.options[8]); 

		var opt9 = document.createElement("option");
		opt9.value = "9";
		opt9.text ="Weber por ampère (Wb/A)";
		cmb_unidadeInicial.add(opt9, cmb_unidadeInicial.options[9]);

		var op9 = document.createElement("option");
		op9.value = "9";
		op9.text ="Weber por ampère (Wb/A)";
		cmb_unidadeFinal.add(op9, cmb_unidadeFinal.options[9]);
	}
	else if(itemSelecionado == 5){
		while (u.length){
			u.remove(0);
		}

		var opt00 = document.createElement("option");
		opt00.value = "0";
		opt00.text = "Selecione uma Opção";
		cmb_unidadeInicial.add(opt00, cmb_unidadeInicial.options[0]);

		while (uf.length){
			uf.remove(0);
		}
		var opt0 = document.createElement("option");
		opt0.value = "0";
		opt0.text = "Selecione uma Opção";
		cmb_unidadeFinal.add(opt0, cmb_unidadeFinal.options[0]);

		var opt1 = document.createElement("option");
		opt1.value = "1";
		opt1.text = "Nanovolt (nV)";
		cmb_unidadeInicial.add(opt1, cmb_unidadeInicial.options[1]);

		var op1 = document.createElement("option");
		op1.value = "1";
		op1.text = "Nanovolt (nV)";
		cmb_unidadeFinal.add(op1, cmb_unidadeFinal.options[1]);

		var opt2 = document.createElement("option");
		opt2.value = "2";
		opt2.text = "Microvolt (µV)";
		cmb_unidadeInicial.add(opt2, cmb_unidadeInicial.options[2]);

		var op2 = document.createElement("option");
		op2.value = "2";
		op2.text = "Microvolt (µV)";
		cmb_unidadeFinal.add(op2, cmb_unidadeFinal.options[2]);

		var opt3 = document.createElement("option");
		opt3.value = "3";
		opt3.text ="Milivolt (mV)";
		cmb_unidadeInicial.add(opt3, cmb_unidadeInicial.options[3]);

		var op3 = document.createElement("option");
		op3.value = "3";
		op3.text = "Milivolt (mV)";
		cmb_unidadeFinal.add(op3, cmb_unidadeFinal.options[3]);

		var opt4 = document.createElement("option");
		opt4.value = "4";
		opt4.text = "Volt (V)";
		cmb_unidadeInicial.add(opt4, cmb_unidadeInicial.options[4]);

		var op4 = document.createElement("option");
		op4.value = "4";
		op4.text = "Volt (V)";
		cmb_unidadeFinal.add(op4, cmb_unidadeFinal.options[4]);

		var opt5 = document.createElement("option");
		opt5.value = "5";
		opt5.text = "Kilovolt (kV)";
		cmb_unidadeInicial.add(opt5, cmb_unidadeInicial.options[5]);

		var op5 = document.createElement("option");
		op5.value = "5";
		op5.text = "Kilovolt (kV)";
		cmb_unidadeFinal.add(op5, cmb_unidadeFinal.options[5]);

		var opt6 = document.createElement("option");
		opt6.value = "6";
		opt6.text = "Megavolt (MV)";
		cmb_unidadeInicial.add(opt6, cmb_unidadeInicial.options[6]);

		var op6 = document.createElement("option");
		op6.value = "6";
		op6.text = "Megavolt (MV)";
		cmb_unidadeFinal.add(op6, cmb_unidadeFinal.options[6]);

		var opt7 = document.createElement("option");
		opt7.value = "7";
		opt7.text = "Gigavolt (GV)";
		cmb_unidadeInicial.add(opt7, cmb_unidadeInicial.options[7]);

		var op7 = document.createElement("option");
		op7.value = "7";
		op7.text = "Gigavolt (GV)";
		cmb_unidadeFinal.add(op7, cmb_unidadeFinal.options[7]);

		var opt8 = document.createElement("option");
		opt8.value = "8";
		opt8.text = "Watt por ampère (W/A)";
		cmb_unidadeInicial.add(opt8, cmb_unidadeInicial.options[8]);

		var opt8 = document.createElement("option");
		opt8.value = "8";
		opt8.text = "Watt por ampère (W/A)";
		cmb_unidadeFinal.add(opt8, cmb_unidadeFinal.options[8]); 

		var opt9 = document.createElement("option");
		opt9.value = "9";
		opt9.text ="Abvolt (abV)";
		cmb_unidadeInicial.add(opt9, cmb_unidadeInicial.options[9]);

		var op9 = document.createElement("option");
		op9.value = "9";
		op9.text ="Abvolt (abV)";
		cmb_unidadeFinal.add(op9, cmb_unidadeFinal.options[9]);

		var opt10 = document.createElement("option");
		opt10.value = "10";
		opt10.text = "Stavolt (stV)"
		cmb_unidadeInicial.add(opt10, cmb_unidadeInicial.options[10]);

		var op10 = document.createElement("option");
		op10.value = "10";
		op10.text = "Stavolt (stV)";
		cmb_unidadeFinal.add(op10, cmb_unidadeFinal.options[10]);
	}
	else if(itemSelecionado == 6){
		while (u.length){
			u.remove(0);
		}

		var opt00 = document.createElement("option");
		opt00.value = "0";
		opt00.text = "Selecione uma Opção";
		cmb_unidadeInicial.add(opt00, cmb_unidadeInicial.options[0]);

		while (uf.length){
			uf.remove(0);
		}
		var opt0 = document.createElement("option");
		opt0.value = "0";
		opt0.text = "Selecione uma Opção";
		cmb_unidadeFinal.add(opt0, cmb_unidadeFinal.options[0]);

		var opt1 = document.createElement("option");
		opt1.value = "1";
		opt1.text = "Nanoohm (nΩ)";
		cmb_unidadeInicial.add(opt1, cmb_unidadeInicial.options[1]);

		var op1 = document.createElement("option");
		op1.value = "1";
		op1.text = "Nanoohm (nΩ)";
		cmb_unidadeFinal.add(op1, cmb_unidadeFinal.options[1]);

		var opt2 = document.createElement("option");
		opt2.value = "2";
		opt2.text = "Microohm (µΩ)";
		cmb_unidadeInicial.add(opt2, cmb_unidadeInicial.options[2]);

		var op2 = document.createElement("option");
		op2.value = "2";
		op2.text = "Microohm (µΩ)";
		cmb_unidadeFinal.add(op2, cmb_unidadeFinal.options[2]);

		var opt3 = document.createElement("option");
		opt3.value = "3";
		opt3.text = "Miliohm (mΩ)";
		cmb_unidadeInicial.add(opt3, cmb_unidadeInicial.options[3]);

		var op3 = document.createElement("option");
		op3.value = "3";
		op3.text = "Miliohm (mΩ)";
		cmb_unidadeFinal.add(op3, cmb_unidadeFinal.options[3]);

		var opt4 = document.createElement("option");
		opt4.value = "4";
		opt4.text = "Ohm (Ω)";
		cmb_unidadeInicial.add(opt4, cmb_unidadeInicial.options[4]);

		var op4 = document.createElement("option");
		op4.value = "4";
		op4.text = "Ohm (Ω)";
		cmb_unidadeFinal.add(op4, cmb_unidadeFinal.options[4]);

		var opt5 = document.createElement("option");
		opt5.value = "5";
		opt5.text = "Kiloohm (kΩ)";
		cmb_unidadeInicial.add(opt5, cmb_unidadeInicial.options[5]);

		var op5 = document.createElement("option");
		op5.value = "5";
		op5.text = "Kiloohm (kΩ)";
		cmb_unidadeFinal.add(op5, cmb_unidadeFinal.options[5]);

		var opt6 = document.createElement("option");
		opt6.value = "6";
		opt6.text = "Megaohm (MΩ)";
		cmb_unidadeInicial.add(opt6, cmb_unidadeInicial.options[6]);

		var op6 = document.createElement("option");
		op6.value = "6";
		op6.text = "Megaohm (MΩ)";
		cmb_unidadeFinal.add(op6, cmb_unidadeFinal.options[6]);

		var opt7 = document.createElement("option");
		opt7.value = "7";
		opt7.text = "Gigaohm (GΩ)";
		cmb_unidadeInicial.add(opt7, cmb_unidadeInicial.options[7]);

		var op7 = document.createElement("option");
		op7.value = "7";
		op7.text = "Gigaohm (GΩ)";
		cmb_unidadeFinal.add(op7, cmb_unidadeFinal.options[7]);

		var opt8 = document.createElement("option");
		opt8.value = "8";
		opt8.text = "Abohm (Ω)";
		cmb_unidadeInicial.add(opt8, cmb_unidadeInicial.options[8]);

		var opt8 = document.createElement("option");
		opt8.value = "8";
		opt8.text = "Abohm (Ω)";
		cmb_unidadeFinal.add(opt8, cmb_unidadeFinal.options[8]); 

		var opt9 = document.createElement("option");
		opt9.value = "9";
		opt9.text = "Volt por ampère (V/A)";
		cmb_unidadeInicial.add(opt9, cmb_unidadeInicial.options[9]);

		var op9 = document.createElement("option");
		op9.value = "9";
		op9.text = "Volt por ampère (V/A)";
		cmb_unidadeFinal.add(op9, cmb_unidadeFinal.options[9]); 
	}
	//verificarUnidadeInicial();
	//verificarUnidadeFinal();
}

function Calcular(){
	var c = document.getElementById("cmb_categoria");
	var itemSelecionado = c.options[c.selectedIndex].value;
	var u = document.getElementById("cmb_unidadeInicial");
	var uItem = u.options[u.selectedIndex].value;
	var uf = document.getElementById("cmb_unidadeFinal");
	var ufItem = uf.options[uf.selectedIndex].value;
	var vlInicial = parseFloat(txt_valorInicial.value.replace(",", "."));
	var vlFinal = parseFloat(txt_valorFinal.value);
	cav =  new Array(13);
	condVet = new Array(10);
	corVet = new Array(10);
	indVet = new Array(10);
	potVet = new Array(11);
	resVet = new Array(10);

	//CARGA
	if(itemSelecionado == 1){
		if (uItem == 1){
			cav[1] = vlInicial;
		}
		else if (uItem == 2){
			cav[1] = vlInicial * 1000;
		}
		else if (uItem == 3){
			cav[1] = vlInicial * 1000000;
		}
		else if (uItem == 4){
			cav[1] = vlInicial * 1000000000;
		}
		else if (uItem == 5){
			cav[1] = vlInicial * 1000000000000;
		}
		else if (uItem == 6){
			cav[1] = vlInicial * 1000000000000000;
		}
		else if (uItem == 7){
			cav[1] = vlInicial * 10000000000;
		}
		else if (uItem == 8){
			cav[1] = (vlInicial * 1000000) * 3600;
		}
		else if (uItem == 9){
			cav[1] = (vlInicial * 1000000000) * 3600;
		}
		else if (uItem == 10){
			cav[1] = (vlInicial * 100000000) * 96485.3365;
		}
		else if (uItem == 11){
			cav[1] = (vlInicial * 0.1) * 3.335640952;
		}
		else if (uItem == 12){
			cav[1] = (vlInicial * 100000000) * 1.6021765314;
		}
		else { }

		cav[2] = cav[1] / 1000;
		cav[3] = cav[1] / 1000000;
		cav[4] = cav[1] / 1000000000;
		cav[5] = cav[1] / 1000000000000;
		cav[6] = cav[1] / 1000000000000000;
		cav[7] = cav[1] / 10000000000;
		cav[8] = (cav[1] / 1000000) / 3600;
		cav[9] = (cav[1] / 1000000000) / 3600;
		cav[10] = (cav[1] / 100000000) / 96485.3365;
		cav[11] = (cav[1] / 0.1) / 3.335640952;
		cav[12] = (cav[1] / 100000000) / 1.6021765314;

		txt_valorFinal.value = cav[ufItem].toFixed(2).toString().replace(".", ",");
	}

	//Condutancia
	else if (itemSelecionado == 2)
	{
		if (uItem == 1)
		{
			condVet[1] = vlInicial;
		}

		else if (uItem == 2)
		{
			condVet[1] = vlInicial * 1000; //3
		}

		else if (uItem == 3)
		{
			condVet[1] = vlInicial * 1000000; //6
		}

		else if (uItem == 4)
		{
			condVet[1] = vlInicial * 1000000000; //9
		}

		else if (uItem == 5)
		{
			condVet[1] = vlInicial * 1000000000000; //12
		}

		else if (uItem == 6)
		{
			condVet[1] = vlInicial * 1000000000000000; //15
		}

		else if (uItem == 7)
		{
			condVet[1] = vlInicial * 1000000000000000000; //18
		}

		else if (uItem == 8)
		{
			condVet[1] = vlInicial * 1000000000; //9
		}

		else if (uItem == 9)
		{
			condVet[1] = vlInicial * 1000000000; //9
		}

		else { }

		condVet[2] = condVet[1] / 1000;
		condVet[3] = condVet[1] / 1000000;
		condVet[4] = condVet[1] / 1000000000;
		condVet[5] = condVet[1] / 1000000000000;
		condVet[6] = condVet[1] / 1000000000000000;
		condVet[7] = condVet[1] / 1000000000000000000;
		condVet[8] = condVet[1] / 1000000000;
		condVet[9] = condVet[1] / 1000000000;

		txt_valorFinal.value = condVet[ufItem].toFixed(2).toString().replace(".", ",");
	}

	//corrente
	else if (itemSelecionado == 3)
	{
		if (uItem == 1)
		{
			corVet[1] = vlInicial;
		}

		else if (uItem == 2)
		{
			corVet[1] = vlInicial * 1000; //3
		}

		else if (uItem == 3)
		{
			corVet[1] = vlInicial * 1000000000; //9
		}

		else if (uItem == 4)
		{
			corVet[1] = vlInicial * 1000000000000; //12
		}

		else if (uItem == 5)
		{
			corVet[1] = vlInicial * 1000000000000000; //15
		}

		else if (uItem == 6)
		{
			corVet[1] = vlInicial * 1000000000000000000; //18
		}

		else if (uItem == 7)
		{
			corVet[1] = vlInicial * 10000000000; //10
		}

		else if (uItem == 8)
		{
			corVet[1] = vlInicial * 1000000000; //9
		}

		else if (uItem == 9)
		{
			corVet[1] = vlInicial * 1000000; //6
		}

		else { }

		corVet[2] = corVet[1] / 1000;
		corVet[3] = corVet[1] / 1000000000;
		corVet[4] = corVet[1] / 1000000000000;
		corVet[5] = corVet[1] / 1000000000000000;
		corVet[6] = corVet[1] / 1000000000000000000;
		corVet[7] = corVet[1] / 10000000000;
		corVet[8] = corVet[1] / 1000000000;
		corVet[9] = corVet[1] / 1000000000;
		txt_valorFinal.value = corVet[ufItem].toFixed(2).toString().replace(".", ",");
	}

	//Indutancia
	else if (itemSelecionado == 4)
	{
		if (uItem == 1)
		{
			indVet[1] = vlInicial;
		}

		else if (uItem == 2)
		{
			indVet[1] = vlInicial * 1000; //3
		}

		else if (uItem == 3)
		{
			indVet[1] = vlInicial * 1000000; //6
		}

		else if (uItem == 4)
		{
			indVet[1] = vlInicial * 1000000000; //9
		}

		else if (uItem == 5)
		{
			indVet[1] = vlInicial * 1000000000000; //12
		}

		else if (uItem == 6)
		{
			indVet[1] = vlInicial * 1000000000000000; //15
		}

		else if (uItem == 7)
		{
			indVet[1] = vlInicial * 1000000000000000000; //18
		}

		else if (uItem == 8)
		{
			indVet[1] = vlInicial;
		}

		else if (uItem == 9)
		{
			indVet[1] = vlInicial * 1000000000; //9
		}

		else { }

		indVet[2] = indVet[1] / 1000;
		indVet[3] = indVet[1] / 1000000;
		indVet[4] = indVet[1] / 1000000000;
		indVet[5] = indVet[1] / 1000000000000;
		indVet[6] = indVet[1] / 1000000000000000;
		indVet[7] = indVet[1] / 1000000000000000000;
		indVet[8] = indVet[1];
		indVet[9] = indVet[1] / 1000000000;

		txt_valorFinal.value = indVet[ufItem].toFixed(2).toString().replace(".", ",");
	}

	//Potencia
	else if (itemSelecionado == 5)
	{
		if (uItem == 1)
		{
			potVet[1] = vlInicial;
		}

		else if (uItem == 2)
		{
			potVet[1] = vlInicial * 1000; //3
		}

		else if (uItem == 3)
		{
			potVet[1] = vlInicial * 1000000; //6
		}

		else if (uItem == 4)
		{
			potVet[1] = vlInicial * 1000000000; //9
		}

		else if (uItem == 5)
		{
			potVet[1] = vlInicial * 1000000000000; //12
		}

		else if (uItem == 6)
		{
			potVet[1] = vlInicial * 1000000000000000; //15
		}

		else if (uItem == 7)
		{
			potVet[1] = vlInicial * 1000000000000000000; //18
		}

		else if (uItem == 8)
		{
			potVet[1] = vlInicial * 1000000000; //9
		}

		else if (uItem == 9)
		{
			potVet[1] = vlInicial * 10;
		}

		else if (uItem == 10)
		{
			potVet[1] = vlInicial * 299792458088;
		}
		else { }

		potVet[2] = potVet[1] / 1000;
		potVet[3] = potVet[1] / 1000000;
		potVet[4] = potVet[1] / 1000000000;
		potVet[5] = potVet[1] / 1000000000000;
		potVet[6] = potVet[1] / 1000000000000000;
		potVet[7] = potVet[1] / 1000000000000000000;
		potVet[8] = potVet[1] / 1000000000;
		potVet[9] = potVet[1] / 10;
		potVet[10] = potVet[1] / 299792458088;

		txt_valorFinal.value = potVet[ufItem].toFixed(2).toString().replace(".", ",");
	}

	//Resistencia
	else if (itemSelecionado == 6)
	{
		if (uItem == 1)
		{
			resVet[1] = vlInicial;
		}

		else if (uItem == 2)
		{
			resVet[1] = vlInicial * 1000; //3
		}

		else if (uItem == 3)
		{
			resVet[1] = vlInicial * 1000000; //6
		}

		else if (uItem == 4)
		{
			resVet[1] = vlInicial * 1000000000; //9
		}

		else if (uItem == 5)
		{
			resVet[1] = vlInicial * 1000000000000; //12
		}

		else if (uItem == 6)
		{
			resVet[1] = vlInicial * 1000000000000000; //15
		}

		else if (uItem == 7)
		{
			resVet[1] = vlInicial * 1000000000000000000; //18
		}

		else if (uItem == 8)
		{
			resVet[1] = vlInicial; //9
		}

		else if (uItem == 9)
		{
			resVet[1] = vlInicial * 1000000000;
		}

		else { }

		resVet[2] = resVet[1] / 1000;
		resVet[3] = resVet[1] / 1000000;
		resVet[4] = resVet[1] / 1000000000;
		resVet[5] = resVet[1] / 1000000000000;
		resVet[6] = resVet[1] / 1000000000000000;
		resVet[7] = resVet[1] / 1000000000000000000;
		resVet[8] = resVet[1];
		resVet[9] = resVet[1] / 1000000000;
		
		txt_valorFinal.value = resVet[ufItem].toFixed(2).toString().replace(".", ",");
	}
}
