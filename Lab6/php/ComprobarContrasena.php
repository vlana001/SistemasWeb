<?php

//incluimos la clase nusoap.php
require_once('./lib/nusoap.php');
require_once('./lib/class.wsdlcache.php');


//creamos el objeto de tipo soap_server
$ns="http://vlana001sw.esy.es/SistemasWeb/Lab6/php";
$server = new soap_server;
$server->configureWSDL('passVal',$ns);
$server->wsdl->schemaTargetNamespace = $ns;

//registramos la función que vamos a implementar
$server->register('passVal', array('password'=>'xsd:String'), array('x'=>'xsd:String'), $ns);

//implementamos la función
function passVal($password)
{
	$file = fopen("../txt/toppasswords.txt", "r") or die("Error al abrir el fichero toppasswords.txt");
	while(!feof($file))//Leer hasta el fin del fichero
	{	
		$line = fgets($file);
		if (strcmp(substr($line, 0, strlen($line) - 2), $password) == 0)
		{
			fclose($file);
			return "INVALIDA";
		}	
	}
	
	fclose($file);
	
	return "VALIDA";
}

//llamamos al método service de la clase nusoap
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

?>