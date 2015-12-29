<?php 
	session_start();
	
	$email = $_SESSION['user'];
	
	include 'conn_DB.php';
	
	$query_preguseractual= "SELECT Texto_pregunta, Texto_respuesta, Complejidad, Tematica FROM Preguntas WHERE Email_autor = '$email'";
	$result1 = $mysqli->query($query_preguseractual);
	$cont_preguntas_useractual = mysqli_num_rows($result1);

	
	
	
 
	if($cont_preguntas_useractual != 0)
	{
	
		echo "<table id='tablapreguntas'><tr><th id='th1'>Pregunta</th><th id='th2'>Respuesta</th><th id='th2'>Complejidad</th><th id='th2'>Tematica</th>";
		 
		for($cont=0; $cont < $cont_preguntas_useractual; $cont++)
		{
			$row = $result1->fetch_row();
			echo "<tr><td id='td1'>". $row[0]."</td><td id='td2'>".$row[1]."</td><td id='td2'>".$row[2]."</td><td id='td2'>".$row[3]."</td></tr>";
		}
	}else
		echo "La tabla de preguntas se encuentra vacia";
		
		//Una vez realizadas las querys cerramos la conexion con la BD
		$mysqli->close();
?>
		
			