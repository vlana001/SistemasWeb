	<?php 
			session_start();
			
			$email = $_SESSION['user'];
			
			include 'conn_DB.php';
			
			$query_preguseractual= "SELECT Texto_pregunta, Complejidad FROM Preguntas WHERE Email_autor = '$email'";
			$result1 = $mysqli->query($query_preguseractual);
			$cont_preguntas_useractual = mysqli_num_rows($result1);
			
			
			$query_pregtotal = "SELECT Texto_pregunta FROM Preguntas";//En vez de seleccionar todos los campos
			$result2 = $mysqli->query($query_pregtotal);
			$cont_preguntas_total = mysqli_num_rows($result2);
			
			
			echo "$cont_preguntas_useractual/$cont_preguntas_total";

			
			//Una vez realizadas las querys cerramos la conexion con la BD
			$mysqli->close();
	
	?>