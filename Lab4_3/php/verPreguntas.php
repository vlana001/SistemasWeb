<!DOCTYPE html>
<html lang="es">
<head>
	<title>Ver preguntas</title>
	<link rel="stylesheet" type="text/css" href="../estilos/stylesLogin.css">
	<meta name="author" content="Victor Lana">
	<meta name="description" content="Ver Preguntas">
	<meta name="keywords" content="Ver, pregunta">
	<meta charset="UTF-8">
</head>

<body>
	<h1 id="encabezado1">Preguntas</h1>
	<?php 
			session_start();
			
			include 'conn_DB.php';
			
			$query_pregycompl = "SELECT Texto_pregunta, Complejidad FROM Preguntas";
			$result1 = $mysqli->query($query_pregycompl);
			$cont_preguntas = mysqli_num_rows($result1);
			
			
			//Insertar en la tabla Acciones
			$hora = date('Y-m-d H:i:s');
			$tipo_accion = 0;
			$ip_conexion = $_SERVER['REMOTE_ADDR'];		
			$id_conexion;
			$email;
			
			if(isset($_SESSION['user']))
			{
				$email = $_SESSION['user'];
				$id_conexion = $_SESSION['idconexion'];
				$query_acciones = "INSERT INTO Acciones(ID_conexion, Email_usuario, Tipo_accion, Hora_accion, IP_conexion) VALUES('$id_conexion','$email','$tipo_accion', '$hora','$ip_conexion')";
			}
			else 
			{
				$query_acciones = "INSERT INTO Acciones(ID_conexion, Email_usuario, Tipo_accion, Hora_accion, IP_conexion) VALUES(null, null, '$tipo_accion', '$hora','$ip_conexion')";
			}
					
			$result2 = $mysqli->query($query_acciones);
			
			if(!$result2)
			{
				die('Error: ' . $mysqli->error);
			}
			
			//Una vez realizadas las querys cerramos la conexion con la BD
			$mysqli->close();
	
	?>
	<table id="tablapreguntas">
	<?php 
		if($cont_preguntas != 0)
		{
		?>
			<tr>
				<th id="th1">Pregunta</td>
				<th id="th2">Complejidad</td>
			</tr>
		<?php  
			for($cont=0; $cont < $cont_preguntas; $cont++)
			{
				$row = $result1->fetch_row();
				
			?>
				<tr>
					<td id="td1"><?php echo $row[0]; ?></td>
					<td id="td2"><?php echo $row[1]; ?></td>
				</tr>
		<?php 
			}
		}else
			echo "La tabla de preguntas se encuentra vacia";
	?>
		</tr>
	</table>		
</body>			
			