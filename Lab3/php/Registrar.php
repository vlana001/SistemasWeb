<!DOCTYPE html>
<html>
<head>
	<title>Añadir nuevo usuario</title>
	<link rel="stylesheet" type="text/css" href="../estilos/styles.css">
	<meta name="author" content="Victor Lana">
	<meta name="description" content="Registro de Usuarios">
	<meta name="keywords" content="Usuarios, registro">
</head>
<body>

<?php

	//En local
	$host = "localhost:3306";
	$user = "root";
	$password = "naia1";
	$dbname = "Quiz";

	//En hostinger
	/*$host = "mysql.hostinger.es";
	$user = "root";
	$password = "naia1";
	$dbname = "Quiz";
	*/

	mysql_connect($host, $user, $password) or die(mysql_error());
	mysql_select_db($dbname) or die(mysql_error());

	$sql="INSERT INTO Usuario(NOMBRE,EMAIL,PASSWORD,TELEFONO,ESPECIALIDAD,INTERESES) 
	VALUES ('$_POST[nombreyApellidos]','$_POST[correoElectronico]','$_POST[password]','$_POST[numTelefono]',
		'$_POST[Especialidad]','$_POST[texto]')";
	
	if(!mysql_query($sql))
	{
		die('Error: Al guardar los datos en la BD' .mysql_error()); //Mensaje de error, si la inserción no es posible
	}
	else
	{
		?>
		<p id="parUsers">Usuario dado de alta correctamente</p> <!--ensaje de confirmación, en caso de ser correcta la inserción-->
	
		<?php
	}

	//cerrar la conexion
	mysql_close();
?>
<a id="linkUsers" href="VerUsuarios.php">Ver lista de usuarios de la BD</a>  <!--Enlace que permita la visualización de todos los usuarios
insertados en la BD-->
</body>
</html>
