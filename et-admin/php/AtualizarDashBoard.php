<?php
	//Na página parent existe um array contendo todas as atividades recentes e manda a primeira atividade para o php
	
	include "Conexao.php";
	
	$primeiraAtividade = mysql_escape_string($_GET['primeiraAtividade']);
	
	$query_Busca = "select * from tb_atividade where cd_atividade >= '$primeiraAtividade' order by dt_atividade";
			
	$result_Busca = mysql_query($query_Busca) or die(mysql_error());
	$linha_Busca = mysql_fetch_assoc($result_Busca);
	$totalLinha_Busca = mysql_num_rows($result_Busca);
	
	/*
	echo '
		<script>
			pai = parent.document.getElementById("pai");
			
			while (pai.firstChild)
			{
				pai.removeChild(pai.firstChild);
			}
		</script>';
		
	do
	{
		if ($linha_Busca['ds_atividade'] != "")
		{
			echo "
				<script>
					pai = parent.document.getElementById('pai');
					
					filho = document.createElement('div');
					filho.setAttribute('id', 'filho');
					filho.innerHTML = '".$linha_Busca['ds_atividade']."';
					
					pai.insertAdjacentElement('beforeend', filho);
				</script>";
		}
	}
	while ($linha_Busca = mysql_fetch_assoc($result_Busca));
	*/
	
	do
	{
		echo "
			<script>
				log = parent.document.getElementById('log');
				
				atv = document.createElement('div');
				atv.setAttribute('id', 'atv');
				atv.setAttribute('class', 'filho');
				atv.setAttribute('align', 'right');";
				
				$aux = '<label id="datalog">'.date("d/m/Y", strtotime($linha_Busca['dt_atividade'])).' às '.date("H:i", strtotime($linha_Busca['dt_atividade'])).'</label><br><label id="msglog">'.$linha_Busca['ds_atividade'].'</label>';
				
		echo "	atv.innerHTML = '".$aux."';
		
				if (parent.ultimaAtividade[0] != '".$linha_Busca['cd_atividade']."')
				{
					atividade11 = new Array;
					atividade11.push('".$linha_Busca['cd_atividade']."');
					
					for (cont = 0; cont <= parent.ultimaAtividade.length - 1; cont = cont + 1)
					{
						atividade11.push(parent.ultimaAtividade[cont]);
					}
					
					for (cont = 0; cont <= parent.ultimaAtividade.length - 1; cont = cont + 1)
					{
						parent.ultimaAtividade[cont] = atividade11[cont];
					}
					
					aux = log.getElementsByClassName('filho');
					
					log.insertBefore(atv, aux[0]);
					
					log.removeChild(aux[aux.length - 1]);
				}			
			</script>";
	}
	while ($linha_Busca = mysql_fetch_assoc($result_Busca));
	
	$query_Busca = "select count(cd_visita) as 'Acessos' from tb_visita";
			
	$result_Busca = mysql_query($query_Busca) or die(mysql_error());
	$linha_Busca = mysql_fetch_assoc($result_Busca);
	$totalLinha_Busca = mysql_num_rows($result_Busca);
	
	echo "<script> parent.lbla.innerHTML = '".$linha_Busca['Acessos']."'; </script>";
	
	$query_Busca = "select cd_usuario from tb_usuario order by cd_usuario";
			
	$result_Busca = mysql_query($query_Busca) or die(mysql_error());
	$linha_Busca = mysql_fetch_assoc($result_Busca);
	$totalLinha_Busca = mysql_num_rows($result_Busca);
	
	$cont = 0;
	do
	{
		$totalUsuarios[$cont] = $linha_Busca['cd_usuario'];
		$cont = $cont + 1;
	}
	while ($linha_Busca = mysql_fetch_assoc($result_Busca));
	
	$contOnline = 0;
	
	foreach ($totalUsuarios as $usuario)
	{
		$dataTimeAtual = date("Y-m-d H:i:s");
		$dataTimeAtual = strtotime($dataTimeAtual);
		
		$query_Busca = "select dt_atividade from tb_atividade where cd_usuario = '$usuario' order by dt_atividade desc limit 1";
				
		$result_Busca = mysql_query($query_Busca) or die(mysql_error());
		$linha_Busca = mysql_fetch_assoc($result_Busca);
		$totalLinha_Busca = mysql_num_rows($result_Busca);
		
		$query_Busca_Usuario = "select ic_logado from tb_usuario where cd_usuario = '$usuario'";
				
		$result_Busca_Usuario = mysql_query($query_Busca_Usuario) or die(mysql_error());
		$linha_Busca_Usuario = mysql_fetch_assoc($result_Busca_Usuario);
		$totalLinha_Busca_Usuario = mysql_num_rows($result_Busca_Usuario);
		
		$diferenca = $dataTimeAtual - strtotime($linha_Busca['dt_atividade']);
		
		if ($diferenca <= 600 && $linha_Busca_Usuario['ic_logado'] == 1)
		{
			$contOnline = $contOnline + 1;
		}
	}
	
	$aux = $contOnline."/".count($totalUsuarios);
	echo "<script> parent.lbl.innerHTML = '$aux'; </script>";
?>

<?php
	mysql_close($conexao);
?>