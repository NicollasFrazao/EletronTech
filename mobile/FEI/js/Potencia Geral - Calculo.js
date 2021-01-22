function Calcular()
{
	var corrente = txt_corrente.value.replace("A","").trim();
	var tensao = txt_tensao.value.replace("V","").trim();
	var fatorPotencia = txt_fatorPotencia.value.replace("%","").trim();
	fatorPotencia = (fatorPotencia * 0.01);
	var sistemaFornecimento = cmb_sistema.value;
	
	var potenciaAtiva = corrente * tensao * fatorPotencia;
	var potenciaReativa = corrente * tensao * (1 - fatorPotencia);
	var potenciaAparente = potenciaAtiva + potenciaReativa;
	
	if( sistemaFornecimento == 3)
	{
		potenciaAtiva = potenciaAtiva * 1.73;
		potenciaReativa = potenciaReativa * 1.73;
		potenciaAparente = potenciaAparente * 1.73;
	}
	
	txt_potenciaAtiva.value = potenciaAtiva.toFixed(3).replace(".", ",") + " W";
	txt_potenciaReativa.value = potenciaReativa.toFixed(3).replace(".", ",") + " VAr";
	txt_potenciaAparente.value = potenciaAparente.toFixed(3).replace(".", ",") + " VA";
}