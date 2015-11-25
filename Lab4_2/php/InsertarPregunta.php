<?php 
	session_start();
	
	include 'conn_DB.php';
	
	$pregunta = operateInput($_POST['pregunta']);
	$respuesta = operateInput($_POST['respuesta']);
	$complejidad = operateInput($_POST['complejidad']);
	
	//$save = operateInput($_POST['submit']);
	
	$email = $_SESSION['user'];
	
	$logMessage = "";
	
	//Comprobamos datos introducidos
	function operateInput($data)
	{
		$data = trim($data); //Elimina los espacios en blanco antes y despues de la cadena de carcateres
		$data = htmlspecialchars($data);
	
		return $data;
	}
	
	
	//Comprobamos que los campos no estan vacios
	if(empty($pregunta))
		$inserteMessage = "Inserte una pregunta";
	if(empty($respuesta))
		$inserteMessage = "Inserte una respuesta";
	if(empty($pregunta) && empty($respuesta))
		$inserteMessage = "Inserte una pregunta y una respuesta";

	if(strcmp($inserteMessage, "") != 0)
	{
		
		header("location: http://vlana001sw.esy.es/SistemasWeb/Lab4_2/php/insertarPregunta.php?message=$inserteMessage&estado=1");
	}else
	{
		$query_preguntas = "INSERT INTO Preguntas(Email_autor, Texto_pregunta, Texto_respuesta, Complejidad) VALUES ('$email', '$pregunta', '$respuesta', '$complejidad')";
		$result1 = $mysqli->query($query_preguntas);
		
		if (!$result1)//Inserccion incorrecta
		{
			$inserteMessage = "Error al insertar la pregunta";
		}
		else
		{
			//Si insert correcto insertar en la tabla Acciones	
			//$id_conexion = session_id();
			$hora = date('Y-m-d H:i:s');
			$tipo_accion = 1;
			$ip_conexion = $_SERVER['REMOTE_ADDR'];
			
			$id_conexion = $_SESSION['idconexion'];
			$query_acciones = "INSERT INTO Acciones(ID_conexion, Email_usuario, Tipo_accion, Hora_accion, IP_conexion) VALUES('$id_conexion','$email','$tipo_accion', now(),'$ip_conexion')";
			$result2 = $mysqli->query($query_acciones);	
			
			if(!$result2)
			{
				die('Error: ' . $mysqli->error);
			}
			
			$inserteMessage = "Insercion de la pregunta correcta";		
		}
		
		/*if($save == Guardar)
			header("location: ");
		else*/
		
		header("location: http://vlana001sw.esy.es/SistemasWeb/Lab4_2/php/insertarPregunta.php?message=$inserteMessage&estado=2");		
	}
	
?>
