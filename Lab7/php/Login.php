	<?php 	
		session_start();
		
		include 'conn_DB.php';
		
	
		$email = $_POST['email'];
		$password = $_POST['upassword'];
		$loginMessage = "";
		$logMessage = "";
		//$num_rows = 0;
		$result;//
		$varLogin=0;
		
		function operateInput($data) 
		{
			$data = trim($data);
			$data = htmlspecialchars($data);
			return $data;
		}	
		
		$email = operateInput($email);
		$password = operateInput($password);
		
		//Si el campo del email y/o la cotraseña estan vacios mostrar mensaje
		if(empty($email))
			$logMessage = "Inserte una dirección de correo";
		if(empty($password))
			$logMessage = "Inserte una contraseña";
		if(empty($email) && empty($password))
			$logMessage = "Inserte una dirección de correo y una contraseña";
		
		if(strcmp($logMessage, "") != 0)
		{
			header("location: http://vlana001sw.esy.es/SistemasWeb/Lab7/php/login.php?message=$logMessage");
		}else
		{
			$pass = sha1($password);
			$query = "SELECT * FROM Usuario WHERE EMAIL='$email' AND PASSWORD='$pass'";
			$result = $mysqli->query($query);
			$cont = mysqli_num_rows($result);
			
			//Numero de intentos fallidos
			$row1 = $result->fetch_row();
			$cont_intentos_fallidos = $row1[3];
			
			if(($cont == 1) && ($cont_intentos_fallidos < 3))//Login exitoso y cuenta no bloqueada
			{
				//Creamos la sesion
				$_SESSION['user'] = $email;
			  
				//Introducir en la BD el correo del usuario y la hora de conexion
				$hora = date('Y-m-d H:i:s');
				$query_connection = "INSERT INTO Conexiones(Correo_usuario, Hora_conexion) VALUES('$email', '$hora')";
				$result1 = $mysqli->query($query_connection);
				//print_r ($result1);
			
				$query_select = "SELECT ID_conexion FROM Conexiones WHERE Correo_usuario='$email' AND Hora_conexion='$hora'";
				$result2 = $mysqli->query($query_select);
				$row = $result2->fetch_row();
				
				//print_r ($result2);
				$_SESSION['idconexion'] = $row[0];
				
				//Cada vez que el usuario se logea correctamente se resetea el contador
				$query_update = "UPDATE Usuario SET NUM_INTENTOS_FALLIDOS = 0 WHERE EMAIL='$email'";
				$result1 = $mysqli->query($query_update);
				
				
				//Si es profesor @ehu.es/eus dirigimos a la pagina de revisar
				//Si es alumno @ikasle.ehu.es dirigir  a la pagina de preguntas
				
				$arrayEmail = explode("@", $email);
				
				if((strcmp($arrayEmail[1], "ehu.es") == 0) || (strcmp($arrayEmail[1], "ehu.eus") == 0))
					header("location: http://vlana001sw.esy.es/SistemasWeb/Lab7/php/revisar.php");
				else
					header("location: http://vlana001sw.esy.es/SistemasWeb/Lab7/php/GestionPreguntas.php");//local		
						
			}else //login no exitoso y/o cuenta bloqueada
			{
				//Cada intento de login fallido aumentamos en 1 el contador
				$query_update = "UPDATE Usuario SET NUM_INTENTOS_FALLIDOS = NUM_INTENTOS_FALLIDOS + 1 WHERE EMAIL='$email'";
				$result1 = $mysqli->query($query_update);
				
				//Numero de intentos fallidos
				$query = "SELECT NUM_INTENTOS_FALLIDOS FROM Usuario WHERE EMAIL='$email'";
				$result = $mysqli->query($query);
				$row2 = $result->fetch_row();			
				$cont_intentos_fallidos = $row2[0];
				
				if($cont_intentos_fallidos >= 3)
				{
					$loginMessage = "Cuenta bloqueada";
					header("location: http://vlana001sw.esy.es/SistemasWeb/Lab7/php/login.php?message=$loginMessage");//local	
				}	
				else
				{
					$loginMessage = "Correo y/o contraseña incorrectos";
					header("location: http://vlana001sw.esy.es/SistemasWeb/Lab7/php/login.php?message=$loginMessage&varLogin=1");//local
				}
			}		
		}
		
		$mysqli->close();
	?>