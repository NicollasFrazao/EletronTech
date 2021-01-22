<?PHP
/*$dadosPC = array('SERVER_ADDR', 'SERVER_NAME', 'REMOTE_ADDR', 'HTTP_USER_AGENT','SERVER_PORT');
foreach ($dadosPC as $arg)
{
	echo $_SERVER[$arg]."<br>";	
}
*/

$IPRemoto = $_SERVER['REMOTE_ADDR'];
$IPServidor = $_SERVER['SERVER_ADDR'];
$Server = $_SERVER['SERVER_NAME'];
$Navegador = $_SERVER['HTTP_USER_AGENT'];
$Porta = $_SERVER['SERVER_PORT'];
$PortaRemota = $_SERVER['REMOTE_PORT'];

/*$DADOS = array($IPRemoto, $IPServidor, $Server, $Navegador, $Porta, $PortaRemota);
foreach ($DADOS as $k)
{
	echo $k."<br>";
}*/

/*
if(preg_match('|MSIE ([0-9].[0-9]{1,2})|',$Navegador,$vrs))
{
    $Nvgdr_versao=$vrs[1];
    $Nvgdr = 'IE';
}

elseif(preg_match( '|Opera/([0-9].[0-9]{1,2})|',$Navegador,$vrs))
{
    $Nvgdr_versao=$vrs[1];
    $Nvgdr = 'Opera';
}
elseif(preg_match('|Firefox/([0-9\.]+)|',$Navegador,$vrs))
{
    $Nvgdr_versao=$vrs[1];
    $Nvgdr = 'Firefox';
}
elseif(preg_match('|Chrome/([0-9\.]+)|',$Navegador,$vrs))
{
    $Nvgdr_versao=$vrs[1];
    $Nvgdr = 'Chrome';
}
elseif(preg_match('|Safari/([0-9\.]+)|',$Navegador,$vrs))
{
    $Nvgdr_versao=$vrs[1];
    $Nvgdr = 'Safari';
}
else
{   
    $Nvgdr_versao = 0;
    $Nvgdr= 'other';
}*/

if(preg_match('|MSIE|',$Navegador))
{
    $Nvgdr = 'IE';
}

elseif(preg_match('|Opera|',$Navegador))
{
    $Nvgdr = 'Opera';
}
elseif(preg_match('|Firefox|',$Navegador))
{
    $Nvgdr = 'Firefox';
}
elseif(preg_match('|Chrome|',$Navegador))
{
    $Nvgdr = 'Chrome';
}
elseif(preg_match('|Safari|',$Navegador))
{
    $Nvgdr = 'Safari';
}
else
{   
    $Nvgdr_versao = 0;
    $Nvgdr= 'other';
}

echo "IP Remoto - ".$IPRemoto;
echo "<br>";
echo "IP Servidor - ".$IPServidor;
echo "<br>";
echo "Servidor - ".$Server;
echo "<br>";
echo "Navegador - ".$Nvgdr;
echo "<br>";
echo "Porta - ".$Porta;
echo "<br>";
echo "Porta Remota - ".$PortaRemota;

if($Nvgdr != "Chrome")
{
	echo "<br><a href=\"http://www.google.com.br/chrome/browser/desktop/index.html#\">Instala o Chrome ae!</a>";
}



?> 