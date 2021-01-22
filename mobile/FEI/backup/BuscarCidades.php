<?php
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	
	$codigoEstado = mysql_escape_string($_POST['codigoEstado']);
	
	$result_Cidades = $conexaoPrincipal -> Query("select tb_cidade.cd_cidade,
														 tb_cidade.nm_cidade,
														 tb_cidade.cd_estado,
														 tb_estado.nm_estado
													from tb_estado inner join tb_cidade
														on tb_estado.cd_estado = tb_cidade.cd_estado
														  where tb_estado.cd_estado = '$codigoEstado'
															order by tb_cidade.nm_cidade");
	$linha_Cidades = mysqli_fetch_assoc($result_Cidades);
	$total_Cidades = mysqli_num_rows($result_Cidades);
?>
<option value="">Selecione...</option>
<?php
	if ($total_Cidades > 0)
	{
		do
		{
?>
			<option value="<?php echo $linha_Cidades['cd_cidade']; ?>"><?php echo $linha_Cidades['nm_cidade']; ?></option>
<?php
		}
		while ($linha_Cidades = mysqli_fetch_assoc($result_Cidades));
	}
?>
