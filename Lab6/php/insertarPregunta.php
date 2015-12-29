<!DOCTYPE html>
<html lang="es">
<head>
	<title>Insertar pregunta</title>
	<link rel="stylesheet" type="text/css" href="../estilos/stylesLogin.css">
	<meta name="author" content="Victor Lana">
	<meta name="description" content="Insertar Pregunta">
	<meta name="keywords" content="Insertar, pregunta, respuesta">
	<meta charset="UTF-8">
</head>

<body>

	<?php 
		session_start();
	
		/*Si el usuario no esta logeado se le redirige a la pagina login.php
		 en caso contrario se le permite introducir una pregunta*/
		if(isset($_SESSION['user']))//cambiar
		{		
	?>
		<div style="text-align:right">
			<!-- Logout -->
			<a href=./logout.php id="linkLogout">Cerrar sesi&oacute;n</a>		
		</div>
		
		<h1 id="encabezado1">Insertar Pregunta</h1>
		<form action="InsertarPregunta.php" method="POST" id="insertar">
			<table id="tabla1">
				<tr>
					<td colspan="2" id="thead"></td>
				</tr>
				<tr>
					<td colspan="2" id="tme">
						<?php	
								$message = $_GET['message']; 
								$estado = $_GET['estado'];
								
								if($estado == 2)
									echo "<span id='tmessageError'>" . $message . "</span>";
								else
								{
									echo "<span id='tmessageCorrecto'>" . $message . "</span>";
									
									if(estado == 3)
										echo "<a href=\"../verPreguntasXML.php\" id=\"link1\" >Ver preguntas</a>";
								}
						?>
					</td>
				</tr>
				<tr>
					<td id="fila1">Pregunta:</td> 
					<td><textarea id="textarea1" name="pregunta" rows="4" cols="50"id="texta1" maxlength="200"></textarea>
				</tr>
				<tr>
					<td id="fila1">Respuesta:</td>
					<td><textarea id="textarea2" name="respuesta" rows="4" cols="50" id="texta1" maxlength="150"></textarea>
				</tr>
				<tr>
					<td id="fila1">Complejidad:</td>
					<td>
						<select name="complejidad" id="select1">
							<option value="0">Sin calificar</option>
						  	<option value="1">1</option>
						    <option value="2">2</option>
						    <option value="3">3</option>
						    <option value="4">4</option>
						    <option value="5">5</option>
						</select> 
					</td>
				</tr>
				<tr>
					<td></td>
					<td id="loginsubmit">
						<input type="submit" value="Guardar" id="preguntasubmitbtn1">
						<!--<input type="submit" value="Guardar y Preguntar" id="preguntasubmitbtn2">-->
					</td>
				</tr>
			</table>
		</form>
	<?php			
		}else
		{
			header("location: ./login.php");
		}
	?>
</body>