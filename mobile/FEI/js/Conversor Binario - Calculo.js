Txt_Bin = document.getElementById("txt_binario");
Txt_Dec = document.getElementById("txt_decimal");
Txt_Oct = document.getElementById("txt_octal");
Txt_Hex = document.getElementById("txt_hexa");

var valor;
var hexadecimal;
var decimal;
var octal;
var binario;

Txt_Bin.onkeyup = function()
{	
	this.onblur();
	
	//------------- Binario para Decimal
	
	valor = Txt_Bin.value;			
	//var caracteres = valor.split("").reverse();
	//var tamanho = caracteres.length - 1;
	var decimal = parseInt(valor, 2);

	
	/*for (i= 0; i <= tamanho; i++)
	{				
		if (caracteres[i] != 0){
			decimal += Math.pow(2, i);
		}			
	}*/
	
	Txt_Dec.value = decimal;
	Txt_Dec.value = Txt_Dec.value.toString().trim();
		
	//----------------- Decimal para Hexadecimal
	
	var hexadecimal = decimal.toString(16).toUpperCase();		
	Txt_Hex.value = hexadecimal;
	Txt_Hex.value = Txt_Hex.value.toString().trim();
	
	//---------------- Decimal para Octal
	
	var octal = decimal.toString(8);
	Txt_Oct.value = octal;
	Txt_Oct.value = Txt_Oct.value.toString().trim();
	
	if(Txt_Bin.value == "")
	{
		Txt_Dec.value = "";
		Txt_Hex.value = "";
		Txt_Oct.value = "";
	}
	
	btn_calcular.value = "Limpar";
} 

Txt_Dec.onkeyup = function()
{	
	this.onblur();
	
	//--------------- Decimal para Binario
	
	var valor = parseInt(this.value.trim());	
	/*var modulo = 0;	
	var resultado = "";
	var acumulaMod="";
	
	do
	{
		modulo = valor % 2;				
		valor = parseInt(valor / 2);					
		acumulaMod += modulo+"'";	
	}
	while(valor >= 1);
	
	binario = acumulaMod.split("'").reverse();			
	
	tamanho = binario.length;
	
	for(i=0; i<tamanho;i++)
	{				
		resultado += binario[i]; 				
	}*/
	
	//Txt_Bin.value = resultado;
	
	Txt_Bin.value = valor.toString(2);
	Txt_Bin.value = Txt_Bin.value.toString().trim();
	
	//---------------- Decimal para Hexadecimal
	decimal = parseInt(Txt_Dec.value);
	hexadecimal = decimal.toString(16).toUpperCase();	
	
	Txt_Hex.value = hexadecimal;
	Txt_Hex.value = Txt_Hex.value.toString().trim();
	
	//------------------- Decimal para Octal
	
	var octal = decimal.toString(8);
	
	Txt_Oct.value = octal;
	Txt_Oct.value = Txt_Oct.value.toString().trim();
	
	if(Txt_Dec.value == "")
	{
		Txt_Bin.value = "";
		Txt_Hex.value = "";
		Txt_Oct.value = "";
	}
	
	btn_calcular.value = "Limpar";
}
	
Txt_Oct.onkeyup = function()
{
	this.onblur();
	
	var octal = Txt_Oct.value;

	//------------------- Octal para Decimal
	
	var decimal = parseInt(octal,8);
	
	Txt_Dec.value = decimal;
	Txt_Dec.value = Txt_Dec.value.toString().trim();
	
	//------------------- Decimal para Hexadecimal
	
	var decimal = parseInt(Txt_Dec.value);
	var hexadecimal = decimal.toString(16).toUpperCase();	
	
	Txt_Hex.value = hexadecimal;	
	Txt_Hex.value = Txt_Hex.value.toString().trim();
	
	//----------------- Decimal para Binario
	
	/*var valor = Txt_Dec.value;	
	var modulo = 0;	
	var resultado = "";
	var acumulaMod="";
	
	do
	{
		modulo = valor % 2;				
		valor = parseInt(valor / 2);					
		acumulaMod += modulo+"'";	
	}
	while(valor >= 1);
	
	var binario = acumulaMod.split("'").reverse();			
	
	tamanho = binario.length;
	
	for(i=0; i<tamanho;i++)
	{				
		resultado += binario[i]; 				
	}*/
	
	//Txt_Bin.value = resultado;
	
	var binario = decimal.toString(2);
	
	Txt_Bin.value = binario;
	Txt_Bin.value = Txt_Bin.value.toString().trim();
	
	if(Txt_Oct.value == "")
	{
		Txt_Bin.value = "";
		Txt_Hex.value = "";
		Txt_Dec.value = "";
	}
	
	btn_calcular.value = "Limpar";
}

Txt_Hex.style.textTransform = 'uppercase';
Txt_Hex.onkeyup = function()
{
	this.onblur();
	
	if(this.value == "")
	{
		Txt_Bin.value = "";
		Txt_Oct.value = "";
		Txt_Dec.value = "";
	}
	else
	{
		var decimal = parseInt(this.value, 16);
		
		Txt_Dec.value = decimal;
		Txt_Bin.value = decimal.toString(2).trim();
		Txt_Oct.value = decimal.toString(8).trim();
	}
	
	btn_calcular.value = "Limpar";
}

function Calcular()
{
	btn_calcular.value = "Limpar";
}

	

