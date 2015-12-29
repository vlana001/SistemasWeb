<?php

	header('Content-Type: text/html; charset=UTF-8');	
	
	//incluimos la clase nusoap.php
	require_once("./lib/nusoap.php");
	require_once("./lib/class.wsdlcache.php");
	
	$user = new nusoap_client("http://sw14.hol.es/ServiciosWeb/comprobarmatricula.php?wsdl",true);
	
	$err = $user->getError();
	
	if($err)
	{
		echo '<h2>Error</h2><pre>' . $err . '</pre>';
		echo '<h2>Debug</h2><pre>' . htmlspecialchars($user->getDebug(), ENT_QUOTES) . '</pre>';
		exit(1);
	}
	
	
	if(isset($_POST['correo']))
		$email = $_POST['correo'];
	else
		exit(1);
	
	
	$result = $user->call('comprobar',array('x'=>$email));
		
	if ($user->fault)
	{
		echo '<h2>Error</h2><pre>'; 
		print_r($result); 
		echo '</pre>';
	}else 
	{
		$err = $user->getError();
		
		if ($err) 
		{
			echo '<h2>Error</h2><pre>' . $err . '</pre>';
		}else
		{
			echo $result;
			exit(0);
		}
	}
	
	echo '<h2>Request</h2><pre>' . htmlspecialchars($user->request, ENT_QUOTES) . '</pre>';
	echo '<h2>Response</h2><pre>' . htmlspecialchars($user->response, ENT_QUOTES) . '</pre>';
	echo '<h2>Debug</h2><pre>' . htmlspecialchars($user->getDebug(), ENT_QUOTES) . '</pre>';
	
?>
