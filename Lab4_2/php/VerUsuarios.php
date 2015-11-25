<!DOCTYPE html>
<html>
<head>
    <title>Ver Usuarios</title>
    <link rel="stylesheet" type="text/css" href="../estilos/styles.css">
	<meta name="author" content="Victor Lana">
	<meta name="description" content="Usuarios en la BD">
	<meta name="keywords" content="Usuarios">
</head>	
	<body>
	<h1>Lista de usuarios</h1>
	<?php

		//En local
		/*$host = "localhost:3306";
		$user = "root";
		$password = "naia1";
		$dbname = "Quiz";
		*/
		//En hostinger
		$host = "mysql.hostinger.es";
		$user = "u697091525_vlana";
		$password = "password1212";
		$dbname = "u697091525_quiz";
		

		mysql_connect($host, $user, $password) or die(mysql_error());
		mysql_select_db($dbname) or die(mysql_error());
		
		
	
		echo'<table id="tablaUsuarios"> <tr><th>Nombre</th><th>Correo</th><th>Tel&eacutefono</th><th>Especialidad</th><th>Intereses</th></tr>';
		
		$sql=mysql_query("SELECT * from Usuario");
		while($linea=mysql_fetch_array($sql))
		{
			echo'<tr><td>'.$linea['NOMBRE'].'</td><td>'.$linea['EMAIL'].'</td><td>'.$linea['TELEFONO'].'</td><td>'.$linea['ESPECIALIDAD'].'</td><td>'.$linea['INTERESES'].'</td></tr>';
		}
		echo'</table>';
		
		//cerrar la conexion
		mysql_close();
	?>
	</body>
</html>

