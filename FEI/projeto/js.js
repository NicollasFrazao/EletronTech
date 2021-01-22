//click no painel de desenho
	painelDesenho.onclick = function()
	{
		//Zoom
				
		if(menu == 11)
		{
			if(zoomSM == 1)
			{
				if(escala <3)
				{
					escala = escala + 0.1;
					myS = myS - 0.000068;
				}
			}
			else
			{
				if(escala > 0.5)
				{
					escala = escala - 0.1;
					myS = myS + 0.000068;
				}
			}
			painelDesenho.style.transform="scale("+escala+")";	
		}
	}
	
	
	painelDesenho.onmousemove = function()
	{
		cXc = parseInt((event.clientX)) - ((screen.width/2) - (pjtW/2))+75/myS;
		cYc = parseInt((event.clientY)) - ((screen.height/2) - (pjtH/2))+30/myS;
		if((cXc >= 0 && cXc <= (pjtW*15)) && (cYc >= 0 && cYc <= (pjtH*15)))
		{
			coordenadas.innerHTML = "X, Y ["+cXc.toFixed(0)+", "+cYc.toFixed(0)+"]";
		}
		else if(cXc >= (pjtW))
		{
			alert("i");
		}
		else{}
		
	}
	
	painelDesenho.onmouseout = function()
	{
		coordenadas.innerHTML = "";
	}
	
	painelDesenho.onmouseover = function()
	{
		
		if(menu == 11)
		{
			
		}
		else if(menu == 12)
		{
			painelDesenho.style.cursor= "pointer";
		}
		else
		{
			painelDesenho.style.cursor= "crosshair";
		}
		
	}
	
	painelDesenho.onmousedown = function()
	{
		
		if(comDraw == 1)
		{
			X1 = parseInt((event.clientX)) - ((screen.width/2) - (pjtW/2))+75/myS;
			Y1 = parseInt((event.clientY)) - ((screen.height/2) - (pjtH/2))+30/myS;
			pdes = 1;
		}
		else
		{	
			painelDesenho.style.cursor= "no-drop";
			pdes = 0;
			comDraw = 1;
		}
	}
	
	painelDesenho.onmouseup = function()
	{
		// capturando as coordenadas finais do desenho
		X2 = parseInt((event.clientX)) - ((screen.width/2) - (pjtW/2)) + 75/myS;
		Y2 = parseInt((event.clientY)) - ((screen.height/2) - (pjtH/2))+30/myS;
		
		if(menu == 2 && pdes == 1)
		{		
			var camada = new Kinetic.Layer
			(
				{
					//dragBoundFunc: function(pos)
					//{
					//	conta = comodo.getName();
						//alert(conta);
						
					//	separar = conta.split('i');
					//	WW = parseInt(separar[0]);
					//	HH = parseInt(separar[1]);
					//	var sp = comodo.getId('e2')[0];
					//	
					//	var nY = pos.y < painel.getAbsolutePosition('camada').y-comodo.getY() ? painel.getAbsolutePosition('camada').y-comodo.getY() : pos.y;
					//	var nX = pos.x < painel.getX()-WW ? painel.getX()-WW : pos.x;
					//	return {
					//			x: nX,
					//			y: nY
					//		};
					// },
					id: "o" + com
				}
			);
			camada.setDraggable(false);
			painel.add(camada);
		}
		
		
		camada.on('mouseover', function(){
				if(menu==1)
				{
					comodo.setStroke("#00abff");
					camada.add(point1);
					camada.add(point2);
					camada.add(point3);
					camada.add(point4);
					camada.draw();
					//alert("i");
					//setDate();
				}
				
				if(menu == 2)
				{
					comDraw = 0;
				}
			});
			
			
		camada.on('click', function(){
			sNmComodo = camada.attrs.id;
			ComodoFuncs.src = "select_comodoPropriedades.php?"+sNmComodo;
		});
			camada.on('mousedown', function(evt){
				if(menu == 1)
				{
					camada.setDraggable(true);	
					camada.setZIndex(9998);						
					//comodo.setStroke('blue');	
					//CAPTURANDO COORDENADA DO OBJETO RECT =D					
					esqUD = (camada.getAbsolutePosition('comodo').x + comodo.getX())-15;
					esqLR = (camada.getAbsolutePosition('comodo').y + comodo.getY())-15;
					iddd = camada.getId();
					odd = camada.getId('comodo');
					//alert(iddd);
					//if(esqUD <=0)
					//{
					//	if(camada.getId('iddd').comodo.getId())
					//	{
					//		comodo.setStroke('red');
					//	}
					//	else
					//	{
					//		comodo.setStroke('blue');
					//	}
					//}
					
					//camada.draw();
					//setDate();
					exibirPropriedadesComodo(iddd);
					
					
					camada.on('mouseup', function(){
						
						uXiComodo = (camada.getAbsolutePosition('comodo').x + comodo.getX())-15;
						uYiComodo =  (camada.getAbsolutePosition('comodo').y + comodo.getY())-15;
						uWComodo = comodo.getWidth();
						uHComodo = comodo.getHeight();
						uXfComodo = uXiComodo + uWComodo;
						uYfComodo = uYiComodo + uHComodo;
						//uNmComodo = comodo.getId();
						uNmComodo = camada.attrs.id;
						//alert(uNmComodo);
						ComodoFuncs.src = "update_comodo.php?"+uNmComodo+"?"+uXiComodo+"?"+uYiComodo+"?"+uYfComodo+"?"+uYfComodo;
						
						
					});
					
				}
				
				if(menu == 3)
				{
					camada.setDraggable(false);
					if(esquadriasSM == 1)
					{
						//alert("Porta");
						sCom = camada.getId();
						ComodoSelecionado = Comodos[getIndexOf(Comodos, "nome", sCom)];
						Ax = ComodoSelecionado.xi;
						Ay = ComodoSelecionado.yi;
						Dx = ComodoSelecionado.xf;
						Dy = ComodoSelecionado.yf;
						Cx = cXc;
						Cy = cYc;
						
						var imgPorta = new Image();
						imgPorta.src = 'icones/portad.png'
						
						if((Cx >= (Dx/2)) && (Cy >= (Dy/2)))
						{
							//alert("BD");
							//baixo e direita
							if((Dx - Cx) <= (Dy - Cy))
							{
								//direita
								alert("Direita");
							}
							else
							{
								//baixo
								//alert("Baixo");
								portaDown = new Kinetic.Image
								(
									{
										x: ComodoSelecionado.xf-36,
										y: ComodoSelecionado.yf-23,
										image: imgPorta,
										width: 16,
										height: 27,
										fill:'transparent',
										draggable: false
									}
								);		
								portaDown.setZIndex(9999);							
								camada.add(portaDown);
								camada.draw();
							}
						}
						else if((Cx <= (Dx/2)) && (Cy <= (Dy/2)))
						{
							alert("CE");
							//cima e esquerda
							if((Cx - Ax) <= (Cy - Ay))
							{
								//esquerda
								alert("Esquerda");
							}
							else
							{
								//cima
								alert("Cima");
							}
						}	
						else if((Cx <= (Dx/2)) && (Cy >= (Dy/2)))
						{
							alert("BE");
							//baixo e esquerda
							if(((Dx/2)-Cx) < (Cy - (Dy/2)))
							{
								//esquerda
								alert("Esquerda");
							}
							else
							{
								//baixo
								alert("Baixo");
							}
						}
						else if((Cx >= (Dx/2)) && (Cy <= (Dy/2)))
						{
							alert("CD");
							//cima e direita
							if((Dx - Cx) <= (Cy - Ay))
							{
								//direita
								alert("Direita");
							}
							else
							{
								//cima
								alert("Cima");
							}
						}
						else
						{}						
					}
					else if(esquadriasSM == 2)
					{
						alert("Janela");
					}
					else
					{
						esquadriasSM = 1;
					}
				}
				if(menu == 4)
				{
					if(lampadaSM > 2 && lampadaSM <=6)
					{
						sl = camada.getId();
						selComodo = Comodos[getIndexOf(Comodos,"nome",sl)];
						var imgL = new Image();
						imgL.src = 'icones/iet.png'
						
						var lampadaTeto = new Kinetic.Image
						(
							{
								x: selComodo('comodo').width-30,
								y: selComodo.height-50,
								width: 30,
								height: 30,
								image: imgL,
								fill: 'blue'
							}
						);
						camada.add(lampadaTeto);
						camada.draw();
					}
					else
					{
						alert("parede");
					}
				}
				
				if(menu == 2)
				{
					camada.setDraggable(false);
				}
				
				if(menu == 12)
				{
					camada.setDraggable(false);
					coma = comodo.getName();
					dNmComodo = camada.attrs.id;
					ComodoFuncs.src = "delete_comodo.php?"+dNmComodo;
					//selcomodo.remove(coma);
					comodo.destroy();
					camada.destroy();
				}
				if(menu == 8)
				{
					var sCamada = painel.getChildren();
					var se = sCamada[2];
					alert(se.height());
				}
			});
			camada.on('mouseout', function(){
				
				setDate();
			});
			camada.on('mouseout', function(){
				if(menu == 1)
				{
					camada.setDraggable(true);
					comodo.setStroke('white');
					point1.remove();
					point2.remove();
					point3.remove();
					point4.remove();
					camada.draw();
				}
				if(menu == 2)
				{
					comDraw = 1;
				}
				
			});
		if(menu == 2 && pdes == 1)
		{
			
			//criando o objeto que será desenhado
			comodo = new Kinetic.Rect
			(
				
				{					
					//determinando nome e id do comodo
					
					id: 'e'+com,
					name: 'e'+com,
					//name: (X2-X1)+'i'+(Y2-Y1),
					//coordenada inicial
					x: X1,
					y: Y1,					
					//coordenada final
					width: X2 - X1,
					height: Y2 - Y1,
					fill: 'transparent',
					stroke: 'white',
					strokeWidth: 5,
					draggable: false,
					resize: true
					
				}
			);
			camada.add(comodo); 
			camada.setWidth(comodo.getWidth);
			camada.setHeight(comodo.getHeight);
			inComodo();
			com++;
			
			//camada.add(comodo);	

				//Criando os pontos ancoras do comodo
				var point1 = new Kinetic.Rect
				(
					{			
						x: X1-5,
						y: Y1-5,
						width: 10,
						height: 10,
						fill: 'blue',
						draggable: true
					}
				);
				
				var point2 = new Kinetic.Rect
				(
					{
						x: X1-5,
						y: Y2-5,
						width: 10,
						height: 10,
						fill: 'blue',
						draggable: true
					}
				);
				
				var point3 = new Kinetic.Rect
				(
					{
						x: X2-5,
						y: Y1-5,
						width: 10,
						height: 10,
						fill: 'blue',
						draggable: true
					}
				);
				
				var point4 = new Kinetic.Rect
				(
					{
						x: X2-5,
						y: Y2-5,
						width: 10,
						height: 10,
						fill: 'blue',
						draggable: true
					}
				);			
			//Fixando Ancoras
				point1.on("mouseover", function () {
					camada.add(point1);
					camada.add(point2);
					camada.add(point3);
					camada.add(point4);
					camada.draw();
					painelDesenho.style.cursor= "nw-resize";
				});
				
				point2.on("mouseover", function () {
					camada.add(point1);
					camada.add(point2);
					camada.add(point3);
					camada.add(point4);
					camada.draw();
					painelDesenho.style.cursor= "ne-resize";
				});
				
				point3.on("mouseover", function () {
					camada.add(point1);
					camada.add(point2);
					camada.add(point3);
					camada.add(point4);
					camada.draw();
					painelDesenho.style.cursor= "ne-resize";
				});
				
				point4.on("mouseover", function () {
					camada.add(point1);
					camada.add(point2);
					camada.add(point3);
					camada.add(point4);
					camada.draw();
					painelDesenho.style.cursor= "nw-resize";
				});
				
				//fehando fixamento de ancoras
				
				
				point1.on("mousedown", function () {
					point2.remove();
					point3.remove();
					point4.remove();
					painelDesenho.style.cursor= "crosshair";
					
					point1.on("mouseup", function () {
						var pos = this.getPosition();
						var xN = pos.x;
						var yN = pos.y;
						var cX = comodo.getX();
						var cY = comodo.getY();
						var wT = comodo.getWidth();
						var hT = comodo.getHeight();
						
						point2.setX(xN);
						point3.setY(yN);
						camada.add(point2);
						camada.add(point3);
						camada.add(point4);
						comodo.setX(xN+4);
						comodo.setY(yN+4);
						comodo.setWidth(wT-xN+cX-4);
						comodo.setHeight(hT-yN+cY-4);
						camada.add(comodo);
						
						//here
						porta.x(comodo.x()-10);		
						porta.y(comodo.y()+10);							
						camada.draw();
						setDate();
					});
				});
				
				point2.on("mousedown", function () {
					point1.remove();
					point3.remove();
					point4.remove();
					painelDesenho.style.cursor= "crosshair";
					point2.on("mouseup", function () {
						var pos = this.getPosition();
						var xN = pos.x;
						var yN = pos.y;
						var cX = comodo.getX();
						var cY = comodo.getY();
						var wT = comodo.getWidth();
						var hT = comodo.getHeight();
						
						point1.setX(xN);
						point4.setY(yN);
						camada.add(point1);
						camada.add(point3);
						camada.add(point4);
						comodo.setX(xN+4);
						comodo.setWidth(wT-xN+cX-4);
						comodo.setHeight(yN-cY+4);
						camada.add(comodo);
						camada.draw();
						setDate();
					});
				});
				
				point3.on("mousedown", function () {
					point1.remove();
					point2.remove();
					point4.remove();
					painelDesenho.style.cursor= "crosshair";
					point3.on("mouseup", function () {
						var pos = this.getPosition();
						var xN = pos.x;
						var yN = pos.y;
						var cX = comodo.getX();
						var cY = comodo.getY();
						var wT = comodo.getWidth();
						var hT = comodo.getHeight();
						
						point1.setY(yN);
						point4.setX(xN);
						camada.add(point1);
						camada.add(point2);
						camada.add(point4);
						comodo.setY(yN);
						comodo.setWidth(xN-cX+4);
						comodo.setHeight(hT-(yN-cY));
						camada.add(comodo);
						camada.draw();
						setDate();
					});
				});
				
				point4.on("mousedown", function () {
					point1.remove();
					point2.remove();
					point3.remove();
					portaDown.remove();
					painelDesenho.style.cursor= "crosshair";
					point4.on("mouseup", function () {
						var pos = this.getPosition();
						var xN = pos.x;
						var yN = pos.y;
						var cX = comodo.getX();
						var cY = comodo.getY();
						
						
						
						point3.setX(xN);
						point2.setY(yN);
						camada.add(point1);
						camada.add(point2);
						camada.add(point3);
						sC = camada.getId();
						CS = Comodos[getIndexOf(Comodos, "nome", sC)];
						
						CS.yf = cYc;
						CS.xf = cXc;
						
						portaDown.setY(CS.yf-5);
						portaDown.setX(CS.xf-10);
						camada.add(portaDown);
						comodo.setWidth(xN-cX+4);
						comodo.setHeight(yN-cY+4);
						camada.add(comodo);
						camada.draw();
						setDate();
					});
				});
				
				point1.on("mouseout", function () {
					painelDesenho.style.cursor= "crosshair";
				}
				);
				point2.on("mouseout", function () {
					painelDesenho.style.cursor= "crosshair";
				}
				);
				point3.on("mouseout", function () {
					painelDesenho.style.cursor= "crosshair";
				}
				);
				point4.on("mouseout", function () {
					painelDesenho.style.cursor= "crosshair";
				}
				);
				
			camada.add(point1);
			camada.add(point2);
			camada.add(point3);
			camada.add(point4);
			point1.remove();
			point2.remove();
			point3.remove();
			point4.remove();
			camada.draw();
			//setDate();
			regHist();
		}
		
		function setDate()
		{
			//nmComodo.value = comodo.getName();
			//tipoComodo.value = "0";
		//	if(comodo.getHeight() > 0)
		//	{
			//	largComodo.value = comodo.getHeight();
		//	}
		//	else
		//	{
			//	largComodo.value = comodo.getHeight()*-1;
		//	}
			
			//if(comodo.getWidth() > 0)
		//	{
			//	compComodo.value = comodo.getWidth();
		//	}
		//	else
		//	{
			//	compComodo.value = comodo.getWidth()*-1;
		//	}			
			//xComodo.value = comodo.getX()+camada.getX();
			//yComodo.value = comodo.getY()+camada.getY();
			
		}
		
		function regHist()
		{
			hist[hi] = comodo.getName();
			hist[hi] += "|"+comodo.getWidth();
			hist[hi] += "|"+comodo.getHeight();
			hist[hi] += "|"+comodo.getX()+camada.getX();
			hist[hi] += "|"+comodo.getY()+camada.getY();
			hi++;
		}
	}
	
	function inComodo()
	{
		vEscala = 15;
		//Capturando valores do desenho
		nmComodo = "o"+com;
		xiComodo = X1;
		yiComodo = Y1;
		wComodo = X2 - X1;
		hComodo = Y2 - Y1;
		xfComodo = X1 + wComodo;
		yfComodo = Y1 + hComodo;
		
		//Definindo valores em metros
		vComprimento = wComodo / vEscala;
		vLargura = hComodo / vEscala;
		
		vComprimento = vComprimento.toFixed(2);
		vLargura = vLargura.toFixed(2);
		
		//Área e Perímetro
		vArea = vComprimento * vLargura;			
		vPerimetro = (vComprimento * 2) + (vLargura * 2);

		//ComodoFuncs.src = "inserir_comodo.php?" + nmComodo+"?"+xiComodo+"?"+yiComodo+"?"+xfComodo+"?"+yfComodo+"?"+vComprimento+"?"+vLargura+"?"+vArea+"?"+vPerimetro;
		
		//var junto = nmComodo + ";" + xiComodo + ";" + yiComodo + ";" + xfComodo + ";" + yfComodo + ";" + vComprimento + ";" + vLargura + ";" + vArea + ";" + vPerimetro;
		
		Comodos.push(						
						{
							nome : nmComodo,
							xi : xiComodo,
							yi : yiComodo,
							xf : xfComodo,
							yf : yfComodo,
							width: wComodo,
							height: hComodo,
							comprimento : vComprimento,
							largura : vLargura,
							area : vArea,
							perimetro : vPerimetro
						}
					);
	}
	
	//Função para pegar a posição do comodo no array
	//Exemplo: getIndexOf(Comodos, "nome", "o3") - Vai retornar o index do objeto comodo, ai é só colocar Comodos[getIndexOf(Comodos, "nome", "o3")] - vai retornar o comodo específico separados pelos atributos
	function getIndexOf(array, atributo, valor) 
	{
		var tamanho = array.length;
		var cont;
		
		for (cont = 0; cont <= tamanho - 1; cont = cont + 1) 
		{
			if (eval("array[cont]." + atributo + " == valor")) 
			{
				return cont;
			}
		}                      
	  return false;
	}
	