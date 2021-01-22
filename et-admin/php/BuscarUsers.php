<?php
	include "Conexao.php";
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	
	session_start();

	header("Content-type: application/xml; charset=utf-8");
	echo '<?xml version="1.0" encoding="UTF-8" ?>';
	
	$op = 0;
	$valorBusca = "";
	
	if (isset($_GET['buscar']))
	{
		$valorBusca = mysql_escape_string($_GET['valorBusca']);
		
		if ($_GET['op'] == 1)
		{
			$query_Busca = "select * from tb_usuario 
								where nm_usuario like '%$valorBusca%'
									order by nm_usuario";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
		}
		else if ($_GET['op'] == 2)
		{
			$query_Busca = "select * from tb_usuario 
								where cd_usuario like '$valorBusca'";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
		}
		else if ($_GET['op'] == 3)
		{
			$query_Busca = "select * from tb_usuario 
								where nm_email like '%$valorBusca'%";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
		}
		else if ($_GET['op'] == 4)
		{
			$query_Busca = "select * from tb_usuario 
								where cd_cpf like '%$valorBusca%'";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
		}
		
	}
	else
	{
		$query_Busca = "select * from tb_usuario order by nm_usuario";
			
		$result_Busca = mysql_query($query_Busca) or die(mysql_error());
		$linha_Busca = mysql_fetch_assoc($result_Busca);
		$totalLinha_Busca = mysql_num_rows($result_Busca);
	}
	
	function TransformaMes($mes)
	{
		switch ($mes)
		{
			case 1:
			{
				$mes = 'Janeiro';
			}
			break;
			
			case 2:
			{
				$mes = 'Fevereiro';
			}
			break;
			
			case 3:
			{
				$mes = 'Março';
			}
			break;
			
			case 4:
			{
				$mes = 'Abril';
			}
			break;
			
			case 5:
			{
				$mes = 'Maio';
			}
			break;
			
			case 6:
			{
				$mes = 'Junho';
			}
			break;
			
			case 7:
			{
				$mes = 'Julho';
			}
			break;
			
			case 8:
			{
				$mes = 'Agosto';
			}
			break;
			
			case 9:
			{
				$mes = 'Setembro';
			}
			break;
			
			case 10:
			{
				$mes = 'Outubro';
			}
			break;
			
			case 11:
			{
				$mes = 'Novembro';
			}
			break;
			
			case 12:
			{
				$mes = 'Dezembro';
			}
			break;
		}
		return $mes;
	}
?>
<retorno>
	<lista>
		<!-- lista -->
		<?php
			do
			{
				if ($linha_Busca['nm_usuario'] != "")
				{
					$nome = $linha_Busca['nm_usuario'];
					
					if ($linha_Busca['im_usuario'] != "")
					{						
						$fotoPerfil = "../".$linha_Busca['im_usuario'];
					}
					else
					{
						$fotoPerfil = "../imagens/usuario.png";
					}
					
					$datanas = $linha_Busca['cd_datanas'];
					$datanas = $datanas[0].$datanas[1].'/'.$datanas[2].$datanas[3].'/'.$datanas[4].$datanas[5].$datanas[6].$datanas[7];
					$datanas = "Nascido em ".$datanas;
					
					$sexo = $linha_Busca['nm_sexo'];
					$email = $linha_Busca['nm_email'];
					
					$tipoTelefone1 = $linha_Busca['cd_tipo_telefone1'];
					$tipoTelefone2 = $linha_Busca['cd_tipo_telefone2'];
					
					$mascaraCPF = "###.###.###-##";
					$mascaraTelefoneFixo = "(##) ####-####";
					$mascaraTelefoneCelular = "(##) #####-####";
					
					$aux = $linha_Busca['cd_cpf'];
					$cpf = $aux[0] . $aux[1] . $aux[2] . $mascaraCPF[3] . $aux[3] . $aux[4] . $aux[5] . $mascaraCPF[7] . $aux[6] . $aux[7] . $aux[8] . $mascaraCPF[11] . $aux[9] . $aux[10];
					
					$aux = $linha_Busca['cd_telefone1'];
					$tipo = $linha_Busca['cd_tipo_telefone1'];
					
					if ($tipo != 2)
					{
						$telefone1 = $mascaraTelefoneFixo[0] . $aux[0] . $aux[1] . $mascaraTelefoneFixo[3] . $mascaraTelefoneFixo[4] . $aux[2] . $aux[3] . $aux[4] . $aux[5] . $mascaraTelefoneFixo[9] . $aux[6] . $aux[7] . $aux[8] . $aux[9];
					}
					else
					{
						$telefone1 = $mascaraTelefoneCelular[0] . $aux[0] . $aux[1] . $mascaraTelefoneCelular[3] . $mascaraTelefoneCelular[4] . $aux[2] . $aux[3] . $aux[4] . $aux[5] . $aux[6] . $mascaraTelefoneCelular[10] . $aux[7] . $aux[8] . $aux[9] . $aux[10];
					}
					
					if ($linha_Busca['cd_telefone2'] != "")
					{
						$aux = $linha_Busca['cd_telefone2'];
						$tipo = $linha_Busca['cd_tipo_telefone2'];
						
						if ($tipo != 2)
						{
							$telefone2 = $mascaraTelefoneFixo[0] . $aux[0] . $aux[1] . $mascaraTelefoneFixo[3] . $mascaraTelefoneFixo[4] . $aux[2] . $aux[3] . $aux[4] . $aux[5] . $mascaraTelefoneFixo[9] . $aux[6] . $aux[7] . $aux[8] . $aux[9];
						}
						else
						{
							$telefone2 = $mascaraTelefoneCelular[0] . $aux[0] . $aux[1] . $mascaraTelefoneCelular[3] . $mascaraTelefoneCelular[4] . $aux[2] . $aux[3] . $aux[4] . $aux[5] . $aux[6] . $mascaraTelefoneCelular[10] . $aux[7] . $aux[8] . $aux[9] . $aux[10];
						}
					}
					else
					{
						$telefone2 = "Informação não disponível!";
					}
					
					if ($linha_Busca['ic_admin'] == 1)
					{
						$admin = "Sim";
					}
					else
					{
						$admin = "Não";
					}
					
					$dataCadastro = "Usuário do Eletron Tech desde ".date("d", strtotime($linha_Busca['dt_cadastro']))." de ".TransformaMes(date("m", strtotime($linha_Busca['dt_cadastro'])))." de ".date("Y", strtotime($linha_Busca['dt_cadastro']));
					
					$funcaoJavaScript = "nome.innerHTML = '$nome'; parent.fotoPerfil.src = '$fotoPerfil'; datanas.innerHTML = '$datanas'; sexo.innerHTML = '$sexo'; email.innerHTML = '$email'; if ('$telefone2' == '() -') {trTelefone2.style.display = 'none';} else {trTelefone2.style.display = 'inline-block';} txt_tipoTelefone1.value = '$tipoTelefone1'; txt_tipoTelefone2.value = '$tipoTelefone2'; telefone1.innerHTML = '$telefone1'; telefone2.innerHTML = '$telefone2'; cpf.innerHTML = '$cpf'; admin.innerHTML = '$admin'; dataCadastro.innerHTML = '$dataCadastro'; if (txt_tipoTelefone1.value != 2) {parent.imagemTelefone1.src = 'imagens/telefone.png';} else {parent.imagemTelefone1.src = 'imagens/celular.png';} if (txt_tipoTelefone2.value != 2) {parent.imagemTelefone2.src = 'imagens/telefone.png';} else {parent.imagemTelefone2.src = 'imagens/celular.png';}";
		?>
						<label class="itemResBusca" onclick="<?php echo $funcaoJavaScript; ?>"><?php echo $nome; ?></label>
		<?php
				}
			}
			while ($linha_Busca = mysql_fetch_assoc($result_Busca));
		?>
		<!-- lista -->
	</lista>
	<buscar>
		<?php echo $valorBusca; ?>
	</buscar>
</retorno>

<?php
	mysql_close($conexao);
?>