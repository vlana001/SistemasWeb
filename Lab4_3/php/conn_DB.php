<?php 

	//En local
	/*$host = "localhost";
	$user = "root";
	$password = "naia1";
	$dbname = "Quiz";
	*/
	
	//En hostinger
	$host = "mysql.hostinger.es";
	$user = "u697091525_vlana";
	$password = "password1212";
	$dbname = "u697091525_quiz";
	
	
	$mysqli = new mysqli($host, $user, $password, $dbname);
	
	if ($mysqli->connect_errno)
	{
		echo "No podemos conectar con la BD" . PHP_EOL;
		echo "No podemos conectar con la BD - errno - " . mysqli_connect_errno() . PHP_EOL;
		echo "No podemos conecta con la BD - error - " . mysqli_connect_error() . PHP_EOL;
		exit(1);
	}
	
php?>