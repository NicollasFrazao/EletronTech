function Calcular()
{
	submit = 1;
	
	corrente = parseFloat(txt_corrente.value.replace("A", "").trim().replace(",", "."));
	tensao = parseFloat(txt_tensao.value.replace("V", "").trim().replace(",", "."));
	fp = parseFloat(txt_fatorPotencia.value.replace(",", "."));
	
	P =	corrente * tensao * fp;
	Q =	corrente * tensao * (1 - fp);
	S = P + Q;
	
	if(fase == 3)
	{
		P = P * 1,73;
		Q = P * 1,73;
		S = P + Q;
	}
	
	else{}
	
	txt_potenciaAtiva.value = P.toFixed(2).toString().replace(".", ",") + " P";
	txt_potenciaReativa.value = Q.toFixed(2).toString().replace(".", ",") + " Q";
	txt_potenciaAparente.value = S.toFixed(2).toString().replace(".", ",") + " S";
}