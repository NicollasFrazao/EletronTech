<?php
	//Esse é o código pra usar o db_eletrontech
	session_start(); //Ativa Sessão
	
	include "Conexao.php";
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	
	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );

	date_default_timezone_set( 'America/Sao_Paulo' );
	//Termina aqui
	
	if((!isset ($_SESSION['EletronTech']['login']) == true) and (!isset ($_SESSION['EletronTech']['senha']) == true)) 
	{ 
		unset($_SESSION['EletronTech']); 
		header('location:../Login.php'); 
	}//Verificar sessão
	
	$codigoUsuario = $_SESSION['EletronTech']['codigo']; //Isso que eu falei sobre sessão

	$query = "select * from tb_evento where dt_evento >= curdate() and cd_usuario = '$codigoUsuario' order by dt_evento"; //Eu acho que seria melhor mostrar todos os eventos maiores que a data atual
	$executar = mysql_query($query);
	$row = mysql_fetch_assoc($executar);
	//$totalLinha_Busca = mysql_num_rows($executar);
			
	$nmevento = array();
	$dsevento = array();
	
	do
	{
		$nmevento[] .= $row['nm_evento'];
		$dsevento[] .= $row['ds_evento'];
	}
	while($row = mysql_fetch_assoc($executar));
		  
	$qtd = count($nmevento);
		
	echo '<link href="estilo.verificar.css" rel="stylesheet">';
	
	if ($row['nm_evento'] == "")
	{
		echo "<table style='display: none;'>";
	}
	else
	{
		echo "<table>";
	}
	
	for($i = 0; $i < $qtd;$i++)
	{
		echo "<tr> <p>"."Evento: ".$nmevento[$i]."<br/>".' Descrição: '.$dsevento[$i]."</p></tr>";
	}
	
	echo "</table>";
	echo'<a href="index.php">Início</a>';
	
	mysql_close($conexao);
?>