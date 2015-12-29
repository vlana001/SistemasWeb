<?php 
	
	header('Content-Type:text/plain');
	session_start();
	
	include 'conn_DB.php';
	
	$pregunta = operateInput($_POST['pregunta']);
	$respuesta = operateInput($_POST['respuesta']);
	$complejidad = operateInput($_POST['complejidad']);
	$numpreg = operateInput($_POST['numpreg']);
	
	$email = $_SESSION['user'];
	
	$logMessage = "";
	
	//Comprobamos datos introducidos
	function operateInput($data)
	{
		$data = trim($data); //Elimina los espacios en blanco antes y despues de la cadena de caracteres
		$data = htmlspecialchars($data);
	
		return $data;
	}
	
	
	//Comprobamos que los campos no estan vacios
	if(empty($pregunta) || empty($respuesta))
	{
		$inserteMessage = "Algunos de los campos requeridos están vacios";
		$tipo = "error";	
		
	}else
	{
		$query_preguntas = "UPDATE Preguntas SET Texto_pregunta = '$pregunta', Texto_respuesta = '$respuesta', Complejidad = '$complejidad' WHERE Numero_pregunta = '$numpreg'";
		$result1 = $mysqli->query($query_preguntas);
		
		
		if (!$result1)//Inserccion incorrecta
		{
			$inserteMessage = "Error al modificar la pregunta en la BD";
			$tipo = "error";
		}
		else
		{
			$inserteMessage = "Pregunta modificada correctamente";
			$tipo = "ok";
		}
	}
	
	$mysqli->close();
	header("location: http://vlana001sw.esy.es/SistemasWeb/Lab7/php/revisar.php?message=$inserteMessage&tipo=$tipo&num=$numpreg");
?>
