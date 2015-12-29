<?php 
	
	header('Content-Type:text/plain');
	session_start();
	
	include 'conn_DB.php';
	
	$pregunta = operateInput($_POST['pregunta']);
	$respuesta = operateInput($_POST['respuesta']);
	$tematica = operateInput($_POST['tematica']);
	$complejidad = operateInput($_POST['complejidad']);
	
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
	if(empty($pregunta) || empty($respuesta) || empty($tematica))
		$inserteMessage = "Algunos de los campos requeridos están vacios";


	if(strcmp($inserteMessage, "") != 0)
	{		
		echo "<div id='tmessageError'>".$inserteMessage."</div>";
	}else
	{
		$query_preguntas = "INSERT INTO Preguntas(Email_autor, Texto_pregunta, Texto_respuesta, Complejidad, Tematica) VALUES ('$email', '$pregunta', '$respuesta', '$complejidad', '$tematica')";
		$result1 = $mysqli->query($query_preguntas);
		
		$numestado = 1;
		
		if (!$result1)//Inserccion incorrecta
		{
			$inserteMessage = "Error al insertar la pregunta en la BD";
			echo "<div id='tmessageError'>".$inserteMessage."</div>";
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
			
			
			//Guardar la pregunta en preguntas.xml
			$fich_xml = simplexml_load_file("http://vlana001sw.esy.es/SistemasWeb/Lab6/xml/preguntas.xml");

			$newAssessmentItem = $fich_xml->addChild("assessmentItem");		
			$newAssessmentItem->addAttribute("complexity",$complejidad);			
			$newAssessmentItem->addAttribute("subject",$tematica);
		
			$itemBody = $newAssessmentItem->addChild("itemBody");
			$itemBody->addChild("p",$pregunta);
			
			$correctResponse = $newAssessmentItem->addChild("correctResponse");
			$correctResponse->addChild("value",$respuesta);
			
			$result3 = $fich_xml->asXML("../xml/preguntas.xml");//http://localhost/SistemasWeb/Lab4_3/xml/preguntas.xml
			//print_r($fich_xml);
			
			//echo $fich_xml->asXML("http://localhost/SistemasWeb/Lab4_3/xml/preguntas.xml");
			
			if($result3 == true)
			{
				$inserteMessage = "Insercion de la pregunta en la BD y el fich XML correcta";
				echo "<div id='tmessageCorrecto'>".$inserteMessage."</div><p><a href=\"../php/verPreguntasXML.php\" id=\"link1\" >Ver preguntas</a></p>";
				
			}
			else 
			{
				$inserteMessage = "Error al insertar la pregunta en el fichero XML";
				echo "<div id='tmessageError'>".$inserteMessage."</div>";
			}
					
		}
			
		$mysqli->close();
		//header("location: http://localhost/SistemasWeb/Lab4_3/php/insertarPreguznta.php?message=$inserteMessage&estado=$numestado");
	}
?>
