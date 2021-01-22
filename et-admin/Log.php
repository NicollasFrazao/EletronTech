<?php
	include "php/conexao.php";
	
	if(isset($_GET['valorBusca']))
	{
		$valorBusca = mysql_escape_string($_GET['valorBusca']);
		
		$query_Busca = "select * from tb_atividade where nm_usuario like '%$valorBusca%' order by dt_atividade desc";	
		$result_Busca = mysql_query($query_Busca) or die(mysql_error());
		$linha_Busca = mysql_fetch_assoc($result_Busca);
		$totalLinha_Busca = mysql_num_rows($result_Busca);
	}
	else
	{
	
		$query_Busca = "select * from tb_atividade order by dt_atividade desc";
				
		$result_Busca = mysql_query($query_Busca) or die(mysql_error());
		$linha_Busca = mysql_fetch_assoc($result_Busca);
		$totalLinha_Busca = mysql_num_rows($result_Busca);
	}
?>

<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<style>
			*
			{
				margin: 0;
				padding: 0;				
				font-family: Century Gothic;
				outline: none;
			}
			
			::-webkit-scrollbar
			{
				height: 12px;
				width: 12px;
				background: linear-gradient(to top, #1d1d1d,#575757);
			}
			
			::-webkit-scrollbar-thumb
			{
				background:  gray;
				-webkit-box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.75);
			}

			::-webkit-scrollbar-corner
			{
				background: #000;
			}
			
			body
			{
				background-color: #000;
			}
			
			#all
			{
				display: inline-block;
				width: 950px;
				height: 500px;
				position: absolute;
				background-color: black;
				margin-left: -475px;
				margin-top: -250px;
				left: 50%;
				top: 50%;
			}
			
			.etLogo
			{
				width: 40px;
				margin-top: 2px;
				position: absolute;
			}
			
			.saudacao
			{
				font-size: 36px;
				color: gray;
				margin-left: 55px;
				text-shadow: 1px 1px #222;
			}
			
			.down
			{
				display: inline-block;
				background-color: gray;
				width: 950px;
				height: 450px;
			}
			
			.busca
			{
				display: inline-block;
				width: 950px;
				height: 70px;
				background: linear-gradient(to top, #272727,#585858);
				
			}
			
			.buscatxt
			{
				display: inline-block;
				width: 770px;
				margin-left: 20px;
				height: 30px;
				margin-top: 20px;
				background-color: black;
				border: 0px;
				color: white;
				padding: 5px;
			}
			
			.optS
			{
				display: inline-block;
				width: 30px;
				background-color: transparent;
				margin-top:10px;
			}
			
			.btns
			{
				display: inline-block;
				position: absolute;
				margin-top: 10px;
				margin-left: 5px;
			}
			
			
			.left
			{
				display: inline-block;
				width: 950px;
				height: 380px;
				background: linear-gradient(to top, #272727,#585858);
			}
			
			.resbusca
			{
				display:inline-block;
				width: 930px;
				height: 300px;
				padding: 10px;
				margin-top: 20px;
				overflow: auto;
			}
			
			.itemResBusca
			{
				display: inline-block;
				width: 90%;
				margin-left: 15px;
				margin-bottom: 5px;
				color: white;
				font-size: 14px;
				text-shadow: 2px 2px #111;
			}
			
			.lblnmoe
			{
				display: inline-block;
				color: gray;
				width: 100%;
				right: 10px;
				font-size: 12px;
				text-shadow: 2px 2px #111;
				margin-top: 10px;
			}
		</style>
	</head>
	
	<body>
		<div id="all">
			<div class="titulo">
				<img class="etLogo" src="imagens/logowhite.png">
				<label class="saudacao">LOG DE ATIVIDADES</label>
			</div>
			<div class="down">
				<div class="busca">
					<input type="text"  id="txt_busca" class="buscatxt">
					<div class="btns">
						<input type="image" id="btn_buscar" class="optS"src="imagens/iconesadm/search.png">
						<input type="image" class="optS"src="imagens/iconesadm/buscaav.png">
						<input type="image" class="optS"src="imagens/iconesadm/limpar.png">
						<input type="image" class="optS"src="imagens/iconesadm/download.png">
					</div>
				</div>
				<div class="left">
					<div class="resbusca">
						<?php
							do
							{
								if ($linha_Busca['ds_atividade'] != "")
								{
						?>
									<label class="itemResBusca"><?php echo $linha_Busca['ds_atividade'].' ['.date("d/m/Y H:i:s", strtotime($linha_Busca['dt_atividade'])).']';  ?></label>
						<?php
								}
							}
							while($linha_Busca = mysql_fetch_assoc($result_Busca));
						?>
						
					</div>
					<label class="lblnmoe" align="center">Resultados da busca. <?php echo $totalLinha_Busca; ?> itens encontrados.</label>
				</div>
			</div>
		</div>
	</body>
	<script>
		btn_buscar.onclick = function()
		{
			if (txt_busca.value != "")
			{
				window.location.href="Log.php?valorBusca="+txt_busca.value;
			}
		}
	</script>
	
</html>

<?php
	mysql_close($conexao);
?>