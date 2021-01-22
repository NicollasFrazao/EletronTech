function Calcular()
{
	var PotUtil = txt_potencia_util.value;
	var PotDissipada = txt_potencia_dissipada.value;
	var Rendimento = null;
	
	txt_rendimento.value = PotUtil / PotDissipada;
}