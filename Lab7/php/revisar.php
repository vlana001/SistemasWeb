<!DOCTYPE html>
<html lang="es">
<head>
	<title>Revisar preguntas</title>
	<link rel="stylesheet" type="text/css" href="../estilos/stylesLogin.css">
	<meta name="author" content="Victor Lana">
	<meta name="description" content="Revisar Pregunta">
	<meta name="keywords" content="Revisar pregunta, respuesta">
	<meta charset="UTF-8">
</head>

<body>

	<?php 
		session_start();
		include 'conn_DB.php';
		//Profesor no podra modificar: Email del autor
		//profesor podra modificar: Pregunta, respuesta, complejidad
	
		/*Si el usuario no esta logeado se le redirige a la pagina login.php
		 en caso contrario se le permite introducir una pregunta*/
		if(isset($_SESSION['user']))//cambiar
		{		
	?>
		<div style="text-align:right">
			<!-- Logout -->
			<a href=./logout.php id="linkLogout">Cerrar sesi&oacute;n</a>		
		</div>
		
		<h1 id="encabezado1">Revisar Preguntas</h1>
		<div style="width: 50%; margin: 0 auto;">
		<?php	
				$query_preg = "SELECT Email_autor, Texto_pregunta, Texto_respuesta, Complejidad, Numero_pregunta FROM Preguntas";
				$result1 = $mysqli->query($query_preg);
				$cont_preguntas = mysqli_num_rows($result1);
				if($cont_preguntas != 0)
				{
					for($cont=0, $contp = 1 ; $cont < $cont_preguntas; $cont++, $contp++)
					{
						$row = $result1->fetch_row();
		?>
		
		<form action="RevisarPregunta.php" method="POST" id="revisar" style="margin-right:auto;">
		
		<input type="hidden" name="numpreg" value="<?php echo $row[4];?>"/>
			<table id="tabla1" >
				<tr>
					<td colspan="2" id="thead"></td>
				</tr>
				<tr>
					<td colspan="2" id="tme">
						
					</td>
					</tr>
					<tr>
						<td colspan="2"
							<?php 
							
								$tipo = $_GET['tipo'];
								$message = $_GET['message'];
								$num = $_GET['num'];
								
								//Mostrar el mensaje solo en la pregunta que has modificado
								if($row[4] == $num)
								{
									if($tipo == "error")
										echo "style='color: red;'>" . "$message";
									else
										echo "style='color: green;'>" . "$message";
								}else 
									echo ">";
							?>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center; font-size: 2em; font-weight:bold; ">
							<?php echo "Pregunta " . "$contp";?>
						</td>
					</tr>
				<tr>
					<td id="fila1">Autor:</td> 
					<td><?php echo $row[0]; ?></td>
				</tr>
				<tr>
					<td id="fila1">Pregunta:</td> 
					<td><textarea id="textarea1" name="pregunta" rows="4" cols="50" id="texta1" maxlength="200"><?php echo $row[1]; ?></textarea>
				</tr>
				<tr>
					<td id="fila1">Respuesta:</td>
					<td><textarea id="textarea2" name="respuesta" rows="4" cols="50" id="texta1" maxlength="150"><?php echo $row[2]; ?></textarea>
				</tr>
				<tr>
					<td id="fila1">Complejidad:</td>
					<td>
						<select name="complejidad" id="select1">
							<option value="0" <?php if ($row[3] == 0) echo "selected"; ?>>Sin calificar</option>
						  	<option value="1" <?php if ($row[3] == 1) echo "selected"; ?>>1</option>
						    <option value="2" <?php if ($row[3] == 2) echo "selected"; ?>>2</option>
						    <option value="3" <?php if ($row[3] == 3) echo "selected"; ?>>3</option>
						    <option value="4" <?php if ($row[3] == 4) echo "selected"; ?>>4</option>
						    <option value="5" <?php if ($row[3] == 5) echo "selected"; ?>>5</option>
						</select> 
					</td>
				</tr>
				<tr>
					<td></td>
					<td id="loginsubmit">
						<input type="submit" value="Modificar" id="preguntasubmitbtn1">
					</td>
				</tr>
			</table>
		</form><?php } ?>
		</div>
		<?php
		$mysqli->close();
		}else
			echo "La tabla de preguntas se encuentra vacia";
			
		}else
		{
			header("location: ./login.php");
		}
	?>
</body>