
<!DOCTYPE html>
<html>
    <head>
		<title></title>
		<script src="RGraph/libraries/RGraph.common.core.js" ></script>
		<script src="RGraph/libraries/RGraph.common.annotate.js" ></script>
		<script src="RGraph/libraries/RGraph.common.context.js" ></script>
		<script src="RGraph/libraries/RGraph.common.tooltips.js" ></script>
		<script src="RGraph/libraries/RGraph.common.resizing.js" ></script>
		<script src="RGraph/libraries/RGraph.bar.js" ></script>
		
		<?php
			include "php/Conexao.php";
			
			mysql_set_charset('utf8');
			ini_set('default_charset','UTF-8');
			
			$myQuery = "select dt_data as 'Data', count(dt_data) as 'Visitas' from tb_visita group by dt_data order by dt_data desc limit 7";
			$consultar = mysql_query($myQuery);
			 
			$i = 1;
			while($resultado = mysql_fetch_array($consultar)){
				$visita[$i] = $resultado['Visitas'];
				$datasvisita[$i] = $resultado['Data'];
				$i++;
			}
		 
			$dadosVisitas = join(",", array($visita[1],$visita[2],$visita[3],$visita[4],$visita[5],$visita[6],$visita[7]));
			$dadosVisitas = "[$dadosVisitas]";
			
			echo "<script>" . "\n";
			echo "var visitadata = new Array(8);";
			echo "dadosVisitas = $dadosVisitas;" . "\n";
			echo "visitadata[1] = $visita[1];";
			echo "visitadata[2] = $visita[2];";
			echo "visitadata[3] = $visita[3];";
			echo "visitadata[4] = $visita[4];";
			echo "visitadata[5] = $visita[5];";
			echo "visitadata[6] = $visita[6];";
			echo "visitadata[7] = $visita[7];";
			echo "</script>"  . "\n";
			
			$myQuery = "select dt_cadastro as 'Data', count(dt_cadastro) as 'Cadastros' from tb_usuario group by dt_cadastro order by dt_cadastro desc limit 7";
			$consultar = mysql_query($myQuery);
			 
			$i = 1;
			while($resultado = mysql_fetch_array($consultar)){
				$cadastro[$i] = $resultado['Cadastros'];
				$datascadastro[$i] = $resultado['Data'];
				$i++;
			}
		 
			$dadosCadastros = join(",", array($cadastro[1],$cadastro[2],$cadastro[3],$cadastro[4],$cadastro[5],$cadastro[6],$cadastro[7]));
			$dadosCadastros = "[$dadosCadastros]";
			
			echo "<script>" . "\n";
			echo "var cadastrodata = new Array(8);";
			echo "dadosCadastros = $dadosCadastros;" . "\n";
			echo "cadastrodata[1] = $cadastro[1];";
			echo "cadastrodata[2] = $cadastro[2];";
			echo "cadastrodata[3] = $cadastro[3];";
			echo "cadastrodata[4] = $cadastro[4];";
			echo "cadastrodata[5] = $cadastro[5];";
			echo "cadastrodata[6] = $cadastro[6];";
			echo "cadastrodata[7] = $cadastro[7];";
			echo "</script>"  . "\n";
			
			$myQuery = "select nm_ferramenta, count(tb_ferramenta.cd_ferramenta) as utilizacoes
								  from tb_utilizacao inner join tb_ferramenta
									on tb_utilizacao.cd_ferramenta = tb_ferramenta.cd_ferramenta
									  group by tb_ferramenta.cd_ferramenta
										order by utilizacoes desc limit 7";
			$consultar = mysql_query($myQuery);
			 
			$i = 1;
			while($resultado = mysql_fetch_array($consultar)){
				$utilizacoes[$i] = $resultado['utilizacoes'];
				$ferramentasUtilizacoes[$i] = $resultado['nm_ferramenta'];
				$i++;
			}
		 
			$dadosUtilizacoes = join(",", array($utilizacoes[1],$utilizacoes[2],$utilizacoes[3],$utilizacoes[4],$utilizacoes[5],$utilizacoes[6],$utilizacoes[7]));
			$dadosUtilizacoes = "[$dadosUtilizacoes]";
			
			echo "<script>" . "\n";
			echo "var ferramentautilizacao = new Array(12);";
			echo "dadosUtilizacoes = $dadosUtilizacoes;" . "\n";
			echo "ferramentautilizacao[1] = $utilizacoes[1];";
			echo "ferramentautilizacao[2] = $utilizacoes[2];";
			echo "ferramentautilizacao[3] = $utilizacoes[3];";
			echo "ferramentautilizacao[4] = $utilizacoes[4];";
			echo "ferramentautilizacao[5] = $utilizacoes[5];";
			echo "ferramentautilizacao[6] = $utilizacoes[6];";
			echo "ferramentautilizacao[7] = $utilizacoes[7];";
			echo "</script>"  . "\n";
		?>
		
		<script>		
	        window.onload = function ()
			{
				var meuGraficoVisitas = new RGraph.Bar('meuCanvasGraficoVisitas', dadosVisitas);
				meuGraficoVisitas.Set('chart.background.barcolor1', 'white');
				meuGraficoVisitas.Set('chart.background.barcolor2', 'white');
				meuGraficoVisitas.Set('chart.title', 'Acessos do Eletron Tech');
				meuGraficoVisitas.Set('chart.title.vpos', 0.6);
				meuGraficoVisitas.Set('chart.labels', ['<?php echo date("d/m/Y", strtotime($datasvisita[1])); ?>','<?php echo date("d/m/Y", strtotime($datasvisita[2])); ?>','<?php echo date("d/m/Y", strtotime($datasvisita[3])); ?>','<?php echo date("d/m/Y", strtotime($datasvisita[4])); ?>','<?php echo date("d/m/Y", strtotime($datasvisita[5])); ?>','<?php echo date("d/m/Y", strtotime($datasvisita[6])); ?>','<?php echo date("d/m/Y", strtotime($datasvisita[7])); ?>']);
				meuGraficoVisitas.Set('chart.tooltips', ['<?php echo date("d/m/Y", strtotime($datasvisita[1])); ?> tem ' + visitadata[1] + ' acesso(s)', '<?php echo date("d/m/Y", strtotime($datasvisita[2])); ?> tem ' + visitadata[2] + ' acesso(s)', '<?php echo date("d/m/Y", strtotime($datasvisita[3])); ?> tem ' + visitadata[3] + ' acesso(s)', '<?php echo date("d/m/Y", strtotime($datasvisita[4])); ?> tem ' + visitadata[4] + ' acesso(s)', '<?php echo date("d/m/Y", strtotime($datasvisita[5])); ?> tem ' + visitadata[5] + ' acesso(s)', '<?php echo date("d/m/Y", strtotime($datasvisita[6])); ?> tem ' + visitadata[6] + ' acesso(s)', '<?php echo date("d/m/Y", strtotime($datasvisita[7])); ?> tem ' + visitadata[7] + ' acesso(s)']);
				meuGraficoVisitas.Set('chart.text.angle', 45);
				meuGraficoVisitas.Set('chart.gutter', 35);
				meuGraficoVisitas.Set('chart.shadow', true);
				meuGraficoVisitas.Set('chart.shadow.blur', 5);
				meuGraficoVisitas.Set('chart.shadow.color', '#aaa');
				meuGraficoVisitas.Set('chart.shadow.offsety', -3);
				meuGraficoVisitas.Set('chart.colors', ['#00CED1']);
				meuGraficoVisitas.Set('chart.key.position', 'gutter');
				meuGraficoVisitas.Set('chart.text.size', 10);
				meuGraficoVisitas.Set('chart.text.font', 'Century Gothic');
				meuGraficoVisitas.Set('chart.text.angle', 0);
				meuGraficoVisitas.Set('chart.grouping', 'stacked');
				meuGraficoVisitas.Set('chart.strokecolor', 'rgba(0,0,0,0)');
				meuGraficoVisitas.Draw(); 

				var meuGraficoCadastros = new RGraph.Bar('meuCanvasGraficoCadastros', dadosCadastros);
				meuGraficoCadastros.Set('chart.background.barcolor1', 'white');
				meuGraficoCadastros.Set('chart.background.barcolor2', 'white');
				meuGraficoCadastros.Set('chart.title', 'Cadastros do Eletron Tech');
				meuGraficoCadastros.Set('chart.title.vpos', 0.6);
				meuGraficoCadastros.Set('chart.labels', ['<?php echo date("d/m/Y", strtotime($datascadastro[1])); ?>','<?php echo date("d/m/Y", strtotime($datascadastro[2])); ?>','<?php echo date("d/m/Y", strtotime($datascadastro[3])); ?>','<?php echo date("d/m/Y", strtotime($datascadastro[4])); ?>','<?php echo date("d/m/Y", strtotime($datascadastro[5])); ?>','<?php echo date("d/m/Y", strtotime($datascadastro[6])); ?>','<?php echo date("d/m/Y", strtotime($datascadastro[7])); ?>']);
				meuGraficoCadastros.Set('chart.tooltips', ['<?php echo date("d/m/Y", strtotime($datascadastro[1])); ?> tem ' + cadastrodata[1] + ' cadastro(s)', '<?php echo date("d/m/Y", strtotime($datascadastro[2])); ?> tem ' + cadastrodata[2] + ' cadastro(s)', '<?php echo date("d/m/Y", strtotime($datascadastro[3])); ?> tem ' + cadastrodata[3] + ' cadastro(s)', '<?php echo date("d/m/Y", strtotime($datascadastro[4])); ?> tem ' + cadastrodata[4] + ' cadastro(s)', '<?php echo date("d/m/Y", strtotime($datascadastro[5])); ?> tem ' + cadastrodata[5] + ' cadastro(s)', '<?php echo date("d/m/Y", strtotime($datascadastro[6])); ?> tem ' + cadastrodata[6] + ' cadastro(s)', '<?php echo date("d/m/Y", strtotime($datascadastro[7])); ?> tem ' + cadastrodata[7] + ' cadastro(s)']);
				meuGraficoCadastros.Set('chart.text.angle', 45);
				meuGraficoCadastros.Set('chart.gutter', 35);
				meuGraficoCadastros.Set('chart.shadow', true);
				meuGraficoCadastros.Set('chart.shadow.blur', 5);
				meuGraficoCadastros.Set('chart.shadow.color', '#aaa');
				meuGraficoCadastros.Set('chart.shadow.offsety', -3);
				meuGraficoCadastros.Set('chart.colors', ['#00CED1']);
				meuGraficoCadastros.Set('chart.key.position', 'gutter');
				meuGraficoCadastros.Set('chart.text.size', 10);
				meuGraficoCadastros.Set('chart.text.font', 'Century Gothic');
				meuGraficoCadastros.Set('chart.text.angle', 0);
				meuGraficoCadastros.Set('chart.grouping', 'stacked');
				meuGraficoCadastros.Set('chart.strokecolor', 'rgba(0,0,0,0)');
				meuGraficoCadastros.Draw();

				var meuGraficoUtilizacoes = new RGraph.Bar('meuCanvasGraficoUtilizacoes', dadosUtilizacoes);
				meuGraficoUtilizacoes.Set('chart.background.barcolor1', 'white');
				meuGraficoUtilizacoes.Set('chart.background.barcolor2', 'white');
				meuGraficoUtilizacoes.Set('chart.title', 'As sete ferramentas mais utilizadas do Eletron Tech');
				meuGraficoUtilizacoes.Set('chart.title.vpos', 0.6);
				meuGraficoUtilizacoes.Set('chart.labels', ['<?php echo $ferramentasUtilizacoes[1]; ?>','<?php echo $ferramentasUtilizacoes[2]; ?>','<?php echo $ferramentasUtilizacoes[3]; ?>','<?php echo $ferramentasUtilizacoes[4]; ?>','<?php echo $ferramentasUtilizacoes[5]; ?>','<?php echo $ferramentasUtilizacoes[6]; ?>','<?php echo $ferramentasUtilizacoes[7]; ?>']);
				meuGraficoUtilizacoes.Set('chart.tooltips', ['<?php echo $ferramentasUtilizacoes[1]; ?> tem ' + ferramentautilizacao[1] + ' utilização(s)', '<?php echo $ferramentasUtilizacoes[2]; ?> tem ' + ferramentautilizacao[2] + ' utilização(s)', '<?php echo $ferramentasUtilizacoes[3]; ?> tem ' + ferramentautilizacao[3] + ' utilização(s)', '<?php echo $ferramentasUtilizacoes[4]; ?> tem ' + ferramentautilizacao[4] + ' utilização(s)', '<?php echo $ferramentasUtilizacoes[5]; ?> tem ' + ferramentautilizacao[5] + ' utilização(s)', '<?php echo $ferramentasUtilizacoes[6]; ?> tem ' + ferramentautilizacao[6] + ' utilização(s)', '<?php echo $ferramentasUtilizacoes[7]; ?> tem ' + ferramentautilizacao[7] + ' utilização(s)']);
				meuGraficoUtilizacoes.Set('chart.text.angle', 45);
				meuGraficoUtilizacoes.Set('chart.gutter', 35);
				meuGraficoUtilizacoes.Set('chart.shadow', true);
				meuGraficoUtilizacoes.Set('chart.shadow.blur', 5);
				meuGraficoUtilizacoes.Set('chart.shadow.color', '#aaa');
				meuGraficoUtilizacoes.Set('chart.shadow.offsety', -3);
				meuGraficoUtilizacoes.Set('chart.colors', ['#00CED1']);
				meuGraficoUtilizacoes.Set('chart.key.position', 'gutter');
				meuGraficoUtilizacoes.Set('chart.text.size', 10);
				meuGraficoUtilizacoes.Set('chart.text.font', 'Century Gothic');
				meuGraficoUtilizacoes.Set('chart.text.angle', 0);
				meuGraficoUtilizacoes.Set('chart.grouping', 'stacked');
				meuGraficoUtilizacoes.Set('chart.strokecolor', 'rgba(0,0,0,0)');
				meuGraficoUtilizacoes.Draw();
			}
		</script>
	</head>
    <body>
		<table>
			<tr>
				<td>
					<canvas id="meuCanvasGraficoVisitas" width="700" height="350" style="background-color: transparent;">[No canvas support]</canvas>
				</td>
				<td align="right">
						<canvas id="meuCanvasGraficoCadastros" width="700" height="350">[No canvas support]</canvas>
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td>
						<canvas id="meuCanvasGraficoUtilizacoes" width="1405" height="350">[No canvas support]</canvas>
				</td>
			</tr>
		</table>
    </body>
</html>

<?php
	mysql_close($conexao);
?>