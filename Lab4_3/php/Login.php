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
			header("location: http://vlana001sw.esy.es/SistemasWeb/Lab4_3/php/login.php?message=$logMessage");
		}else
		{
			$query = "SELECT * FROM Usuario WHERE EMAIL='$email' AND PASSWORD='$password'";
			$result = $mysqli->query($query);
			$cont = mysqli_num_rows($result);

			if($cont == 1)//Login exitoso
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
			
				//Dirigir  a la pagina de preguntas
				header("location: http://localhost/SistemasWeb/Lab4_3/php/insertarPregunta.php");//local			
			}else
			{
				$loginMessage = "Correo y/o contraseña incorrectos";
				header("location: http://vlana001sw.esy.es/SistemasWeb/Lab4_3/php/login.php?message=$loginMessage&varLogin=1");//local
			}		
		}
		
		$mysqli->close();
	?>