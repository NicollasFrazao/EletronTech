var banco = '';

function AbrirBanco()
{
	banco = openDatabase('db_eletrontech', '1.0', 'EletronTech Database', 2 * 1024 * 1024);
	
	CriarTabelas();
}

function DroparTabelas()
{
	banco.transaction
	(
		function (transaction)
		{
			transaction.executeSql('drop table usuario_pacote;');
			transaction.executeSql('drop table pacote_ferramenta;');
			transaction.executeSql('drop table tb_usuario;');
			transaction.executeSql('drop table tb_ferramenta;');
			transaction.executeSql('drop table tb_pacote;');
			transaction.executeSql('drop table tb_sistema;');
			transaction.executeSql('drop table tb_utilizacao;');
		}
	);
}

function CriarTabelas()
{
	banco.transaction
	(
		function (transaction)
		{
			transaction.executeSql
			(
				"create table if not exists tb_usuario(cd_usuario primary key, nm_usuario, nm_nickname, cd_cpf, dt_nascimento, cd_telefone, cd_celular, nm_sexo, nm_email, cd_senha, ic_admin, im_perfil, dt_cadastro, ic_confirmado, ic_ordenar);",
				[],
				function (transaction, results)
				{
					transaction.executeSql
					(
						'create table if not exists tb_ferramenta(cd_ferramenta primary key, nm_ferramenta, im_ferramenta, ds_ferramenta, ds_ajuda, ds_url, ic_ativada, ds_classe_cor, cd_ordem_categoria, qt_utilizacao);',
						[],
						function (transaction, results)
						{
							transaction.executeSql
							(
								'create table if not exists tb_pacote(cd_pacote primary key, nm_pacote, im_pacote, ds_pacote, ic_custom);',
								[],
								function (transaction, results)
								{
									transaction.executeSql
									(
										'create table if not exists tb_utilizacao(cd_utilizacao primary key, cd_ferramenta, cd_usuario, dt_utilizacao, ic_tipo);',
										[],
										function (transaction, results)
										{
											transaction.executeSql
											(
												'create table if not exists usuario_pacote(cd_usuario, cd_pacote, dt_inicio, dt_termino, foreign key (cd_usuario) references tb_usuario(cd_usuario), foreign key (cd_pacote) references tb_pacote(cd_pacote));',
												[],
												function (transaction, results)
												{
													transaction.executeSql
													(
														'create table if not exists pacote_ferramenta(cd_pacote, cd_ferramenta, foreign key (cd_pacote) references tb_pacote(cd_pacote), foreign key (cd_ferramenta) references tb_ferramenta(cd_ferramenta));',
														[],
														function (transaction, results)
														{
															transaction.executeSql
															(
																'create table if not exists tb_sistema(cd_sistema primary key, nm_sistema, ic_menutencao, dt_ultima_sincronizacao);',
																[],
																function (transaction, results)
																{
																	transaction.executeSql
																	(
																		"insert into tb_sistema(cd_sistema, nm_sistema, ic_menutencao) values(1, 'EletronTech', 0);",
																		[],
																		null,
																		null
																	);
																},
																function (transaction, error)
																{
																	alert(error.message);
																}			
															);
														},
														function (transaction, error)
														{
															alert(error.message);
														}			
													);
												},
												function (transaction, error)
												{
													alert(error.message);
												}			
											);
										},
										function (transaction, error)
										{
											alert(error.message);
										}			
									);
								},
								function (transaction, error)
								{
									alert(error.message);
								}
							);
						},
						function (transaction, error)
						{
							alert(error.message);
						}			
					);
				},
				function (transaction, error)
				{
					alert(error.message);
				}			
			);
		}
	);
}

function VerificarLogado()
{
	/*if (window.localStorage.getItem('logado') == null)
	{
		banco.transaction
		(
			function (transaction)
			{
				transaction.executeSql
				(
					'select cd_usuario from tb_usuario;',
					[],
					function (transaction, results)
					{
						if (results.rows.length == 0)
						{
							window.localStorage.setItem('logado', 0);
						}
						else
						{
							window.localStorage.setItem('logado', 1);
							window.localStorage.setItem('codigo', results.rows.item(0).cd_usuario);
						}
						
						VerificarLogado();
					},
					function (transaction, error)
					{
						alert(error.message);
					}
				);
			}
		);
		
		return '?';
	}
	else */if (window.localStorage.getItem('logado') == 1)
	{
		return true;
	}
	else if (window.localStorage.getItem('logado') == 0 || window.localStorage.getItem('logado') == null)
	{
		return false;
	}
}

function SincronizarDados(codigo)
{
	Ajax("GET", "https://www.anytech.com.br/et/php/SincronizarDados.php", "codigo=" + codigo, "try {var retorno = this.responseText; eval(retorno); InserirDadosSincronizados();} catch(exe) {alert(exe.message);}");
}

function InserirDadosSincronizados()
{
	
	DroparTabelas();
	CriarTabelas();
	
	banco.transaction
	(
		function (transaction)
		{
			transaction.executeSql('delete from usuario_pacote');
			transaction.executeSql('delete from pacote_ferramenta');
			transaction.executeSql('delete from tb_pacote');
			transaction.executeSql('delete from tb_ferramenta');
			transaction.executeSql('delete from tb_usuario');
			transaction.executeSql('delete from tb_utilizacao');
			
			transaction.executeSql
			(
				'insert into tb_usuario (cd_usuario, nm_usuario, cd_cpf, dt_nascimento, cd_telefone, nm_sexo, nm_email, cd_senha, ic_admin, im_perfil, dt_cadastro, ic_confirmado, nm_nickname, cd_celular) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
				[Usuario.cd_usuario, Usuario.nm_usuario, Usuario.cd_cpf, Usuario.dt_nascimento, Usuario.cd_telefone, Usuario.nm_sexo, Usuario.nm_email, Usuario.cd_senha, Usuario.ic_admin, Usuario.im_perfil, Usuario.dt_cadastro, Usuario.ic_confirmado, Usuario.nm_nickname, Usuario.cd_celular],
				null,
				function (transaction, error)
				{
					alert(error.message);
				}
			);
			
			transaction.executeSql
			(
				'insert into usuario_pacote(cd_usuario, cd_pacote, dt_inicio, dt_termino) values(?, ?, ?, ?)',
				[UsuarioPacote.cd_usuario, UsuarioPacote.cd_pacote, UsuarioPacote.dt_inicio, UsuarioPacote.dt_termino],
				null,
				function (transaction, error)
				{
					alert(error.message);
				}
			);
		}
	);
	
	InserirPacotes(Pacotes.slice());
}

function InserirFerramentas(ferramentas)
{
	try
	{
		openMessage('synchro;0;Sincronizando ferramentas...\n(' + ((Ferramentas.length - ferramentas.length)/(Ferramentas.length)*100).toFixed(0) + '%)');
	}
	catch (e)
	{
	}
	
	try
	{
		error_in('Sincronizando ferramentas...\n(' + ((Ferramentas.length - ferramentas.length)/(Ferramentas.length)*100).toFixed(0) + '%)', 0, 2);
	}
	catch (e)
	{
	}
	
	if (ferramentas.length > 0)
	{
		banco.transaction
		(
			function (transaction)
			{
				transaction.executeSql
				(
					'insert into tb_ferramenta(cd_ferramenta, nm_ferramenta, im_ferramenta, ds_ferramenta, ds_ajuda, ds_url, ic_ativada, ds_classe_cor, qt_utilizacao, cd_ordem_categoria) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
					[ferramentas[0].cd_ferramenta, ferramentas[0].nm_ferramenta, ferramentas[0].im_ferramenta.replace('imagens/', 'images/'), ferramentas[0].ds_ferramenta, ferramentas[0].ds_ajuda, ferramentas[0].ds_url.replace('FEI/', 'fei/').replace('.php', '.html'), ferramentas[0].ic_ativada, ferramentas[0].ds_classe_cor, ferramentas[0].qt_utilizacao, ferramentas[0].cd_ordem_categoria],
					function (transaction, results)
					{
						ferramentas.splice(0, 1);
						InserirFerramentas(ferramentas.slice());
					},
					function (transaction, error)
					{
						alert(error.message);
					}
				);
			}
		);
	}
	else
	{
		FinalizarSincronizacao(PacoteFerramenta.slice(), Utilizacao.slice());
	}
}

function InserirPacotes(pacotes)
{
	try
	{
		openMessage('synchro;0;Sincronizando pacotes... (' + ((Pacotes.length - pacotes.length)/Pacotes.length*100).toFixed(0) + '%)');
	}
	catch (e)
	{
	}
	
	try
	{
		error_in('Sincronizando pacotes... (' + ((Pacotes.length - pacotes.length)/Pacotes.length*100).toFixed(0) + '%)', 0, 2);
	}
	catch (e)
	{
	}
	
	if (pacotes.length > 0)
	{
		banco.transaction
		(
			function (transaction)
			{
				transaction.executeSql
				(
					'insert into tb_pacote(cd_pacote, nm_pacote, im_pacote, ds_pacote, ic_custom) values(?, ?, ?, ?, ?)',
					[pacotes[0].cd_pacote, pacotes[0].nm_pacote, pacotes[0].im_pacote.replace('imagens/', 'images/'), pacotes[0].ds_pacote, pacotes[0].ic_custom],
					function (transaction, results)
					{
						pacotes.splice(0, 1);
						InserirPacotes(pacotes.slice());
					},
					function (transaction, error)
					{
						alert(error.message);
					}
				);
			}
		);
	}
	else
	{
		InserirFerramentas(Ferramentas.slice());
	}
}

function FinalizarSincronizacao(pacote_ferramenta, utilizacao)
{
	try
	{
		openMessage('synchro;0;Finalizando sincronização... (' + (((Utilizacao.length + PacoteFerramenta.length) - (utilizacao.length + pacote_ferramenta.length))/(Utilizacao.length + PacoteFerramenta.length)*100).toFixed(0) + '%)');
	}
	catch (e)
	{
	}
	
	try
	{
		error_in('Finalizando sincronização... (' + (((Utilizacao.length + PacoteFerramenta.length) - (utilizacao.length + pacote_ferramenta.length))/(Utilizacao.length + PacoteFerramenta.length)*100).toFixed(0) + '%)', 0, 2);
	}
	catch (e)
	{
	}
	
	if (pacote_ferramenta.length > 0)
	{
		banco.transaction
		(
			function (transaction)
			{
				transaction.executeSql
				(
					'insert into pacote_ferramenta(cd_pacote, cd_ferramenta) values(?, ?)',
					[pacote_ferramenta[0].cd_pacote, pacote_ferramenta[0].cd_ferramenta],
					function (transaction, results)
					{
						pacote_ferramenta.splice(0, 1);
						FinalizarSincronizacao(pacote_ferramenta.slice(), utilizacao.slice());
					},
					function (transaction, error)
					{
						alert(error.message);
					}
				);
			}
		);
	}
	else if (utilizacao.length > 0)
	{
		banco.transaction
		(
			function (transaction)
			{
				//alert(utilizacao[0].dt_utilizacao);
				transaction.executeSql
				(
					'insert into tb_utilizacao(cd_utilizacao, cd_ferramenta, cd_usuario, dt_utilizacao, ic_tipo) values(?, ?, ?, ?, ?)',
					[
						utilizacao[0].cd_utilizacao, 
						utilizacao[0].cd_ferramenta,
						utilizacao[0].cd_usuario,
						utilizacao[0].dt_utilizacao,
						utilizacao[0].ic_tipo
					],
					function (transaction, results)
					{
						utilizacao.splice(0, 1);
						FinalizarSincronizacao(pacote_ferramenta.slice(), utilizacao.slice());
					},
					function (transaction, error)
					{
						alert(error.message);
					}
				);
			}
		);
	}
	else
	{
		banco.transaction
		(
			function (transaction)
			{
				transaction.executeSql
				(
					'update tb_sistema set dt_ultima_sincronizacao = ?',
					[new Date().getFullYear() + '-' + ((new Date().getMonth() < 10) ? '0' : '') + (new Date().getMonth() + 1) + '-' + ((new Date().getDate() < 10) ? '0' : '') + new Date().getDate() + ' ' + ((new Date().getHours() < 10) ? '0' : '') + new Date().getHours() + ':' + ((new Date().getMinutes() < 10) ? '0' : '') + new Date().getMinutes() + ':' + ((new Date().getSeconds() < 10) ? '0': '') + new Date().getSeconds()],
					function (transaction, results)
					{
						try
						{
							openMessage('synchro;2;Sincronização finalizada com sucesso!');
						}
						catch (e)
						{
						}

						try
						{
							error_in('Sincronização finalizada com sucesso!', 1, 2);
						}
						catch (e)
						{
						}

						window.localStorage.setItem('logado', 1);
						window.localStorage.setItem('codigo', Usuario.cd_usuario);

						try
						{
							GerarFerramentas();
						}
						catch (e)
						{
							window.location.href = 'Painel.html';
						}
					},
					function (transaction, error)
					{
						alert(error.message);
					}
				);
			}
		);
	}
}