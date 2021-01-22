<?php
	ob_start();
	session_start();
	include "Conexao.php";

	if ((!isset ($_SESSION['EletronTech']['login']) == true) and (!isset ($_SESSION['EletronTech']['senha']) == true)) 
	{ 
		header('location:Login.php');
	}
	
	$aux = 0;
	
	$server = $_SERVER['SERVER_NAME']; 
	$arquivo = mysql_escape_string($_GET["arquivo"]);
	$codigo = $_SESSION['EletronTech']['codigo'];
	
	$auxPesquisa = mysql_query("select * 
									from tb_pasta inner join tb_arquivo 
										on tb_pasta.cd_pasta = tb_arquivo.cd_pasta
											where tb_pasta.cd_usuario = '$codigo' and tb_arquivo.nm_caminho = '$arquivo'") or die(mysql_error());		

	if (mysql_num_rows($auxPesquisa) <= 0)
	{
		exit;
	}
	
	$tudo = "http://".$server.'/eletrontech/'.$arquivo;
	$tudo = str_replace(':', "%3A", $tudo);
	$tudo = str_replace(" ", "%20", $tudo);
	$tudo = str_replace('/', "%2F", $tudo);
	
	header("location:"."https://view.officeapps.live.com/op/view.aspx?src=".$tudo);
?>

<?php
	mysql_close($conexao);
?>