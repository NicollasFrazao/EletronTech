<?php
	ini_set('default_charset','UTF-8');
	
	exec("ipconfig /all", $busca);
	
	foreach($busca as $linha)
	{
		if (preg_match("/(.*)F*sico(.*)/", $linha))
		{
			$captura = $linha;
			$separado = split ("\:", $captura); 
			echo $separado[1]."</br>";
		}
		else
		{
			//echo "nada encontrado";
		}
	}
?>
	
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
	</body>
</html>