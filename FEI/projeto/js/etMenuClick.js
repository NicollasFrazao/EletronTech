

//onclick
function captID(myID)
{
	separa = myID.split("_");
	finalID = separa[0];
	menu = separa[2];
	
	if(finalID == "btn")
	{
		selecionarMenu();
	}
}
//fim onclick
//habilitando Submenu

btn_esquadria_3.ondblclick = function()
{
	if(esquadriaBin == 0)
	{
		limpaSubMenus();
		limpaVar();
		subMenuEsquadria.style.display="inline-block";
		esquadriaBin = 1;
	}
	else
	{
		subMenuEsquadria.style.display="none";
		esquadriaBin = 0;
	}
}

function subEsquadria(optEsquadria)
{
	esquadriasSM = optEsquadria;
	esquadriaF(optEsquadria);
}

btn_lampada_4.ondblclick = function()
{
	if(lampadasBin == 0)
	{
		limpaSubMenus();
		limpaVar();
		subMenuLampadas.style.display="inline-block";
		lampadasBin = 1;
	}
	else
	{
		subMenuLampadas.style.display="none";
		lampadasBin = 0;
	}
}

function subLampadas(optLampada)
{
	lampadaSM = optLampada;
	lampadaF();
}

btn_tomada_5.ondblclick = function()
{
	if(tomadasBin == 0)
	{
		limpaSubMenus();
		limpaVar();
		subMenuTomadas.style.display="inline-block";
		tomadasBin = 1;
	}
	else
	{
		subMenuTomadas.style.display="none";
		tomadasBin = 0;
	}
}

function subTomadas(optTomada)
{
	tomadaSM = optTomada;
	tomadaF();
}

btn_interruptor_6.ondblclick = function()
{
	if(interruptorBin == 0)
	{;
		limpaSubMenus();
		limpaVar();
		subMenuInterruptores.style.display="inline-block";
		interruptorBin = 1;
	}
	else
	{
		subMenuInterruptores.style.display="none";
		interruptorBin = 0;
	}
}

function subInterruptores(optInterruptores)
{
	interruptorSM = optInterruptores;
	interruptorF();
}

//Sub Menu Esquadrias
btn_condutor_7.ondblclick = function()
{
	if(condutorBin == 0)
	{
		limpaSubMenus();
		limpaVar();
		subMenuCondutores.style.display="inline-block";
		condutorBin = 1;
	}
	else
	{
		subMenuCondutores.style.display="none";
		condutorBin = 0;
	}
}

function subCondutores(optCondutores)
{
	condutorSM = optCondutores;
	condutorF();
}

btn_quadro_8.ondblclick = function()
{
	if(quadroBin == 0)
	{
		limpaSubMenus();
		limpaVar();
		subMenuQuadros.style.display="inline-block";
		quadroBin = 1;
	}
	else
	{
		subMenuQuadros.style.display="none";
		quadroBin = 0;
	}
}

function subQuadro(optQuadro)
{
	quadroSM = optQuadro;
	quadroF(optQuadro);
}

//Sub Menu Esquadrias
btn_conduite_9.ondblclick = function()
{
	if(conduiteBin == 0)
	{	
		limpaSubMenus();
		limpaVar();
		subMenuConduites.style.display="inline-block";
		conduiteBin = 1;
	}
	else
	{
		subMenuConduites.style.display="none";
		conduiteBin = 0;
	}
}

function subEletrodutos(optEletrodutos)
{
	eletrodutosSM = optEletrodutos;
	eletrodutoF();
}

//Sub Menu Esquadrias
btn_zoom_11.ondblclick = function()
{
	if(zoomBin == 0)
	{
		limpaSubMenus();
		limpaVar();
		subMenuZoom.style.display="inline-block";
		zoomBin = 1;
	}
	else
	{
		subMenuZoom.style.display="none";
		zoomBin = 0;
	}
}

function subZoom(optZoom)
{
	zoomSM = optZoom;
	zoomF();
}

function limpaVar()
{
	esquadriaBin = 0;
	lampadasBin = 0;
	tomadasBin = 0;
	interruptorBin = 0;
	condutorBin = 0;
	quadroBin = 0;
	conduiteBin = 0;
	zoomBin = 0;
}

function limpaSubMenus()
{
	subMenuEsquadria.style.display="none";
	subMenuLampadas.style.display="none";
	subMenuTomadas.style.display="none";
	subMenuInterruptores.style.display="none";
	subMenuCondutores.style.display="none";
	subMenuQuadros.style.display="none";
	subMenuConduites.style.display="none";
	subMenuZoom.style.display="none";
}

function MenuSelected()
{	
	limpaBotao();
	switch(optMenu)
	{
		case 1:
			btn_selecionar.style.backgroundColor="#075ab8";
		break;
		case 2:
			btn_desenhar.style.backgroundColor="#075ab8";
		break;
		case 3:
			btn_esquadria.style.backgroundColor="#075ab8";
		break;
		case 4:
			btn_lampada.style.backgroundColor="#075ab8";
		break;
		case 5:
			btn_tomada.style.backgroundColor="#075ab8";
		break;
		case 6:
			btn_interruptor.style.backgroundColor="#075ab8";
		break;
		case 7:
			btn_condutor.style.backgroundColor="#075ab8";
		break;
		case 8:
			btn_quadro.style.backgroundColor="#075ab8";
		break;
		case 9:
			btn_conduite.style.backgroundColor="#075ab8";
		break;
		case 10:
			btn_circuito.style.backgroundColor="#075ab8";
		break;
		case 11:
			btn_zoom.style.backgroundColor="#075ab8";
		break;
		case 12:
			btn_excluir.style.backgroundColor="#075ab8";
		break;
		case 13:
			btn_desfazer.style.backgroundColor="#075ab8";
		break;
		case 14:
			btn_refazer.style.backgroundColor="#075ab8";
		break;
		case 15:
			btn_sair.style.backgroundColor="#075ab8";
		break;
		default:
	}
}



function limpaBotao()
{
	btn_selecionar_1.style.backgroundColor="transparent";
	btn_desenhar_2.style.backgroundColor="transparent";
	btn_esquadria_3.style.backgroundColor="transparent";
	btn_lampada_4.style.backgroundColor="transparent";
	btn_tomada_5.style.backgroundColor="transparent";
	btn_interruptor_6.style.backgroundColor="transparent";
	btn_condutor_7.style.backgroundColor="transparent";
	btn_quadro_8.style.backgroundColor="transparent";
	btn_conduite_9.style.backgroundColor="transparent";
	btn_circuito_10.style.backgroundColor="transparent";
	btn_zoom_11.style.backgroundColor="transparent";
	btn_excluir_12.style.backgroundColor="transparent";
	btn_desfazer_13.style.backgroundColor="transparent";
	btn_refazer_14.style.backgroundColor="transparent";
	btn_sair_15.style.backgroundColor="transparent";
	
	
}

function selecionarMenu()
{
	
	//Seleção de selecionar =D
	if(menu == 1)
	{
		selecionarF();
	}

	else if(menu == 2)
	{
		desenharF();
	}

	//Seleção de esquadrias
	else if(menu == 3)
	{
		esquadriaF();
	}

	//Seleção de lampada
	else if(menu == 4)
	{
		lampadaF();
	}
	//Seleção de tomadas
	else if(menu == 5)
	{
		tomadaF();
	}

	//Seleção de interruptores
	else if(menu == 6)
	{
		interruptorF();
	}

	//Seleção de Condutores
	else if(menu == 7)
	{
		condutorF();
	}

	//Seleção de quadros de Luz
	else if(menu == 8)
	{
		quadroF();
	}

	//Seleção de eletrodutos
	else if(menu == 9)
	{
		eletrodutoF();
	}
	//Seleção de circuito
	else if(menu == 10)
	{
		//seleção de circuitos
		circuitoF();
	}
	//Seleção de zoom
	else if(menu == 11)
	{
		zoomF();
	}
	else if(menu == 12)
	{
		excluirF();
	}
	else if(menu == 13)
	{
		desfazerF();
	}
	else if(menu == 14)
	{
		refazerF();
	}
	else if(menu == 15)
	{
		sairF();
	}
	else{}
}

//Funções do Menu
function selecionarF()
{
	limpaBotao();
	btn_selecionar_1.style.backgroundColor = "#0b9fe7";
	optAtual = "Selecionar";
	opcaoAtual();
}

function desenharF()
{
	limpaBotao();
	btn_desenhar_2.style.backgroundColor = "#0b9fe7";
	optAtual = "Desenhar Cômodo";
	opcaoAtual();
}

function esquadriaF()
{
	limpaBotao();
	btn_esquadria_3.style.backgroundColor = "#0b9fe7";
	if(esquadriasSM == 1)
	{
		//porta
		optAtual = "Porta";
	}
	else if(esquadriasSM == 2)
	{
		//janela
		optAtual = "Janela";
	}
	else{}
	opcaoAtual();
}

function lampadaF()
{
	limpaBotao();
	btn_lampada_4.style.backgroundColor = "#0b9fe7";
	if(lampadaSM == 1)
	{
		//incandescente na parede
		optAtual = "Lâmpada incandescente na parede";
	}
	else if(lampadaSM == 2)
	{
		//fluorescente na parede
		optAtual = "Lâmpada fluorescente na parede";
	}	
	else if(lampadaSM == 3)
	{
		//incandescente no teto
		optAtual = "Lâmpada incandescente no teto";
	}
	else if(lampadaSM == 4)
	{
		//fluorescente no teto
		optAtual = "Lâmpada fluorescente no teto";
	}
	else if(lampadaSM == 5)
	{
		//fluorescente embutida no teto
		optAtual = "Lâmpada fluorescente embutida no teto";
	}
	else if(lampadaSM == 6)
	{
		//incandescente embutida no teto
		optAtual = "Lâmpada incandescente embutida no teto";
	}
	else{}
	opcaoAtual();
}

function tomadaF()
{
	limpaBotao();
	btn_tomada_5.style.backgroundColor = "#0b9fe7";
	if(tomadaSM == 1)
	{
		//tug baixa
		optAtual = "TUG (baixa)";
	}
	else if(tomadaSM == 2)
	{
		//tug media
		optAtual = "TUG (media)";
	}
	else if(tomadaSM == 3)
	{
		//tug alta
		optAtual = "TUG (alta)";
	}
	else if(tomadaSM == 4)
	{
		//tue
		optAtual = "TUE";
	}
	else{}
	opcaoAtual();
}

function interruptorF()
{
	limpaBotao();
	btn_interruptor_6.style.backgroundColor = "#0b9fe7";
	if(interruptorSM == 1)
	{
		//1 seção
		optAtual = "Interruptor de 1 Seção";
	}
	else if(interruptorSM == 2)
	{
		//2 seções
		optAtual = "Interruptor de 2 Seções";
	}
	else if(interruptorSM == 3)
	{
		//3 seções
		optAtual = "Interruptor de 3 Seções";
	}
	else if(interruptorSM == 4)
	{
		//3 seções three-way
		optAtual = "Interruptor de 3 Seções Three-Way";
	}
	else if(interruptorSM == 5)
	{
		//4 seções three-way
		optAtual = "Interruptor de 4 Seções Three-Way";
	}
	else{}
	opcaoAtual();
}

function condutorF()
{
	limpaBotao();
	btn_condutor_7.style.backgroundColor = "#0b9fe7";
	if(condutorSM == 1)
	{
		//neutro
		optAtual = "Condutor Neutro";
	}
	else if(condutorSM == 2)
	{
		//fase
		optAtual = "Condutor Fase";
	}
	else if(condutorSM == 3)
	{
		//terra
		optAtual = "Condutor Terra";
	}
	else if(condutorSM == 4)
	{
		//retorno
		optAtual = "Condutor Retorno";
	}
	else{}
	opcaoAtual();
}

function quadroF()
{
	limpaBotao();
	btn_quadro_8.style.backgroundColor = "#0b9fe7";
	if(quadroSM == 1)
	{
		//parcial
		optAtual = "Quadro Parcial";
	}
	else if(quadroSM == 2)
	{
		//geral
		optAtual = "Quadro Geral";
	}
	else{}
	opcaoAtual();
}

function eletrodutoF(opt)
{
	limpaBotao();
	btn_conduite_9.style.backgroundColor = "#0b9fe7";
	if(eletrodutosSM == 1)
	{
		//sobe
		optAtual = "Eletroduto que Sobe";
	}
	else if(eletrodutosSM == 2)
	{
		//desce
		optAtual = "Eletroduto que Desce";
	}
	else if(eletrodutosSM == 3)
	{
		//passa subindo
		optAtual = "Eletroduto que passa subindo";
	}
	else if(eletrodutosSM == 4)
	{
		//passa descendo
		optAtual = "Eletroduto que passa descendo";
	}
	else{}
	opcaoAtual();
}

function circuitoF()
{
	limpaBotao();
	btn_circuito_10.style.backgroundColor = "#0b9fe7";
	optAtual = "Selecionar Circuito";
	opcaoAtual();
}

function zoomF()
{
	limpaBotao();
	btn_zoom_11.style.backgroundColor = "#0b9fe7";
	if(zoomSM == 1)
	{
		//zoom in
		optAtual = "Zoom in";
		painelDesenho.style.cursor= "zoom-in";
	}
	else if(zoomSM == 2)
	{
		//zoom out
		optAtual = "Zoom out";
		painelDesenho.style.cursor= "zoom-out";
	}
	else{}
	opcaoAtual();
}

function excluirF()
{
	limpaBotao();
	btn_excluir_12.style.backgroundColor = "#0b9fe7";
	optAtual = "Excluir";
	opcaoAtual();
}

function desfazerF()
{
	limpaBotao();
	btn_desfazer_13.style.backgroundColor = "#0b9fe7";
	optAtual = "Desfazer";
	opcaoAtual();
}	

function refazerF()
{
	limpaBotao();
	btn_refazer_14.style.backgroundColor = "#0b9fe7";
	optAtual = "Refazer";
	opcaoAtual();
}

function sairF()
{
	limpaBotao();
	btn_sair_15.style.backgroundColor = "#0b9fe7";
	optAtual = "Sair";
	opcaoAtual();
}

function opcaoAtual()
{
	atual.value = optAtual;
	limpaSubMenus();
	limpaVar();
}