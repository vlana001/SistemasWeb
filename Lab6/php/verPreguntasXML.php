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
			
			$preguntas = simplexml_load_file("http://vlana001sw.esy.es/SistemasWeb/Lab6/xml/preguntas.xml");
			
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
	<?php $cont_preguntas = count($preguntas);
		if($cont_preguntas != 0)
		{
		?>
			<tr>
				<th id="th0">Tem&aacute;tica</td>
				<th id="th1">Pregunta</td>
				<th id="th2">Complejidad</td>
			</tr>
		<?php  
			foreach($preguntas as $pregunta)
			{	
			?>
				<tr>
					<td id="td2"><?php echo $pregunta[subject]; ?></td>
					<td id="td1"><?php echo $pregunta->itemBody->p; ?></td>
					<td id="td2"><?php echo $pregunta[complexity]; ?></td>		
				</tr>
		<?php 
			}
		}else
			echo "La tabla de preguntas se encuentra vacia";
	?>
		</tr>
	</table>		
</body>			
			