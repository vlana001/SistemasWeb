<!DOCTYPE html>
<html>
<head>
	<title>A&ntilde;adir nuevo usuario</title>
	<link rel="stylesheet" type="text/css" href="../estilos/styles.css">
	<meta name="author" content="Victor Lana">
	<meta name="description" content="Registro de Usuarios">
	<meta name="keywords" content="Usuarios, registro">
</head>
<body>

<?php

	/*ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	*/

	//En local
	/*$host = "localhost:3306";
	$user = "root";
	$password = "naia1";
	$dbname = "Quiz";
	*/

	//En hostinger
	$host = "mysql.hostinger.es";
	$user = "u697091525_quiz";
	$password = "password1212";
	$dbname = "u697091525_quiz";

	mysql_connect($host, $user, $password) or die(mysql_error());
	mysql_select_db($dbname) or die(mysql_error());
	
	function operateInput($data) 
	{
		$data = trim($data); //Elimina los espacios en blanco antes y despues de la cadena de carcateres
		$data = htmlspecialchars($data);
		
		return $data;
	}
	
	//check patterns
	function checkPatterns()
	{
		$bool = true;
		
		$pattern_email = "/^([a-z][a-z]*)[0-9]{3}@ikasle.ehu.(es|eus)$/";
		$pattern_telefono = "/^[0-9]{9}/";
		$pattern_nombreApellidos = "/([a-zA-Z][a-zA-Z]*) ([a-zA-Z][a-zA-Z]*) ([a-zA-Z][a-zA-Z]*)/";
		
		$email_ok = filter_var($_POST[correoElectronico], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>$pattern_email)));
		$telefono_ok = filter_var($_POST[numTelefono], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>$pattern_telefono)));
		$nombre_ok = filter_var($_POST[nombreyApellidos], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>$pattern_nombreApellidos)));
		
		
		//No sigue la expresion regular
		
		$contError = 0;
		
		if($email_ok === false)
			$contError++;
		if($telefono_ok === false)
			$contError++;
		if($nombre_ok === false)
			$contError++;
		
		if($contError > 0)
		{	
			//Mostrar mensajes de error
			if($email_ok === false)
			{
				?>
					<p id="parUsers">Email con formato incorrecto</p> 	
				<?php 	
			}
			
			if($telefono_ok === false)
			{
				?>
					<p id="parUsers">Tel&eacutefono con formato incorrecto</p> 	
				<?php 	
			}
			
			
			if($nombre_ok === false)
			{
				?>
					<p id="parUsers">Nombre con formato incorrecto</p> 	
				<?php 	
			}
			
				
			$bool = false;
		}
			
		return $bool;
	}
	
	
	//Check password
	function checkPassword()
	{
		$bool = true;
		
		if(strlen($_POST[password]) < 6)
		{
			?>
				<p id="parUsers">La contrase&ntilde;a debe tener al menos 6 caracteres</p> 	
			<?php 	
			$bool = false;
		}
		
		return $bool;
	}
	
	//Check Especialidad
	function checkEspecialidad()
	{
		$bool = true;
		
		if(($_POST['Especialidad'] == 4) && (strlen($_POST['otra']) === 0))//Como se comprueba que un campo esta vacio
		{
			?>
				<p id="parUsers">Se debe introducir un valor en el campo de Otra Especialidad</p>  
			<?php 
			$bool = false;
		}
			
		
		return $bool;
	}
	
	
	//Llamadas a las funciones
	$contMensaje = 0;
	
	if(checkPatterns() === false)
		$contMensaje++;
	if(checkPassword() === false)
		$contMensaje++;
	if(checkEspecialidad() === false)
		$contMensaje++;
		
	if($contMensaje > 0)
	{
		?>
			<a id="linkUsers" href="../registro.html">Volver al registro</a> 
		<?php 
	}else
	{
		$_POST[nombreyApellidos] = operateInput($_POST[nombreyApellidos]);
		$_POST[correoElectronico] = operateInput($_POST[correoElectronico]);
		$_POST[password] = operateInput($_POST[password]);
		$_POST[numTelefono] = operateInput($_POST[numTelefono]);
		$_POST[Especialidad] = operateInput($_POST[Especialidad]);
		$_POST[texto] = operateInput($_POST[texto]);
		
		//cifrar password con sha1, 40 caracteres
		$pass = sha1($_POST[password]);
		$num_intentos = 0;
		
		$sql="INSERT INTO Usuario(NOMBRE,EMAIL,PASSWORD,NUM_INTENTOS_FALLIDOS,TELEFONO,ESPECIALIDAD,INTERESES)
		VALUES ('$_POST[nombreyApellidos]','$_POST[correoElectronico]','$pass','$num_intentos','$_POST[numTelefono]',
		'$_POST[Especialidad]','$_POST[texto]')";
		
		if(!mysql_query($sql))
		{
			die('Error: Al guardar los datos en la BD' .mysql_error()); //Mensaje de error, si la inserción no es posible
		}
		else
		{
			?>
			<p id="parUsers">Usuario dado de alta correctamente</p> <!--Mensaje de confirmación, en caso de ser correcta la inserción-->
			<a id="linkUsers" href="VerUsuarios.php">Ver lista de usuarios de la BD</a>  <!--Enlace que permita la visualización de todos los usuarios
			insertados en la BD-->
			<?php
		}

		//cerrar la conexion
		mysql_close();
	}
?>

</body>
</html>
