<?php
$file = fopen("../txt/tickets.txt", "r") or die("Error al abrir el fichero tickets.txt");

	while(!feof($file))//Leer hasta el fin del fichero
	{	
		$line = fgets($file);
		
		echo $line;
}

?>