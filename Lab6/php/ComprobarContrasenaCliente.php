<?php

	//incluimos la clase nusoap.php
	require_once('./lib/nusoap.php');
	require_once('./lib/class.wsdlcache.php');

	//Creamos el objeto de tipo soapclient, donde se encuentra el servicio SOAP que vamos a utilizar.
	$soapcliente = new nusoap_client("http://vlana001sw.esy.es/SistemasWeb/Lab6/php/ComprobarContrasena.php?wsdl",true);

	$password = $_POST['password'];
	
	//Llamamos a la función que habíamos implementado en el servicio web
	$result = $soapcliente->call('passVal', array('password'=>$password));
	
	echo $result;
?>