<?php
	include "Conexao.php";
	
	$cdFerramenta = mysql_escape_string($_GET['cdFerramenta']);
	
	if ($cdFerramenta == 6)
	{
		$largura = mysql_escape_string($_GET['largura']);
		$comprimento = mysql_escape_string($_GET['comprimento']);
		$tipoCalculo = mysql_escape_string($_GET['calculo']);
		
		$aux = mysql_query("call sp_area_perimetro_calculo('$largura','$comprimento','$tipoCalculo',@resultado)");
		
		$aux = mysql_query("select @resultado");
		$resultado = mysql_fetch_assoc($aux);
		
		if ($tipoCalculo == 1)
		{
			echo '<script> parent.txt_resultado.value = "'.round($resultado['@resultado'], 2).' m²"; </script>';
		}
		else
		{
			echo '<script> parent.txt_resultado.value = "'.round($resultado['@resultado'], 2).' m"; </script>';
		}
	}
	else if ($cdFerramenta == 9)
	{
		$carga = mysql_escape_string($_GET['carga']);
		$potencia = mysql_escape_string($_GET['potencia']);
		$corrente = mysql_escape_string($_GET['corrente']);
		
		$aux = mysql_query("call sp_capacitancia_eletrica_calculo('$carga','$potencia','$corrente',@resultado)");
		
		$aux = mysql_query("select @resultado");
		$resultado = mysql_fetch_assoc($aux);
		
		echo '<script> parent.txt_resultado.value = "'.round($resultado['@resultado'], 2).' F"; </script>';
	}
?>

<?php
	mysql_close($conexao);
?>