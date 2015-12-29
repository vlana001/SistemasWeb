<?php

//incluimos la clase nusoap.php
require_once('../lib/nusoap.php');
require_once('../lib/class.wsdlcache.php');


//creamos el objeto de tipo soap_server
$ns="http://vlana001sw.esy.es/SistemasWeb/Lab6/php/sw";
$server = new soap_server;
$server->configureWSDL('ticketVal',$ns);
$server->wsdl->schemaTargetNamespace = $ns;

//registramos la función que vamos a implementar
$server->register('ticketVal', array('ticket'=>'xsd:String'), array('z'=>'xsd:String'), $ns);

//implementamos la función
function ticketVal($ticket)
{
	$file = fopen("../../txt/tickets.txt", "r") or die("Error al abrir el fichero tickets.txt");
	while(!feof($file))//Leer hasta el fin del fichero
	{	
		$line = fgets($file);
		
		if (strcmp(substr($line, 0, strlen($line) - 2), $ticket) == 0)
		{	
			fclose($file);
			return "AUTORIZADO";
		}
	}
	
	fclose($file);
	
	return "NOAUTORIZADO";
}

//llamamos al método service de la clase nusoap
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

?>