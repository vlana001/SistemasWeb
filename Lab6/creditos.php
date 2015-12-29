<html>
	<head>
		<title>Creditos</title>
		<link rel="stylesheet" type="text/css" href="estilos/styles.css" />
		<meta name="author" content="Victor Lana">
		<meta name="description" content="Creditos">
		<meta name="keywords" content="creditos, autor">
		<meta charset="UTF-8">
		
		<style>
			body{
				text-align: center; 
			}
			.tableGeo{
				margin: 0 auto;
				border: 1px solid blue;
				border-collapse: collapse;
				width: 20em;
			}
			
			.table-row{
				margin: 0 auto;
				border: 1px solid blue;
			}
			.table-data{
				margin: 0 auto;
				padding-right: 2em;
				border: 1px solid blue;
				font-weight: bold;
			}
			
			.table-data2{
				margin: 0 auto;
				padding-left: 2em;
				padding-right: 1em;
				border: 1px solid blue;
			}
			
			h3{
				margin-top: 3em;
				color: #4078C0;
			}
		</style>
	</head>	
	<body>
		<h1>Autor: Victor Lana</h1>
		<h1><b>Especialidad:</b> Ingenier&iacutea del Software</h1>
		<h1><b>Universidad:</b> UPV/EHU</h1>	
	
		<p align = center> 
			<img src="imagenes/silueta.gif" alt="Imagen Victor Lana" width="300em" height="300em"/>
		</p>
		
		<p align = center> 	
			<a href="layout.html">Ir al Layout</a>
		</p>
		
		<?php 
			
			require_once('./php/geoplugin.class/geoplugin.class.php');
			$geoplugin = new geoPlugin();
			
			//Remote address
			$geoplugin->locate();
			
			$remote_ip_address = $geoplugin->ip;
			$remote_city = $geoplugin->city;
			$remote_country = $geoplugin->countryName;
			$remote_long = $geoplugin->longitude;
			$remote_lat = $geoplugin->latitude;
			
			
			//Local address
			$servlocal = $_SERVER['SERVER_ADDR'];
			$geoplugin->locate($servlocal);
			
			$local_ip_address = $geoplugin->ip;
			$local_city = $geoplugin->city;
			$local_country = $geoplugin->countryName;
			$local_long = $geoplugin->longitude;
			$local_lat = $geoplugin->latitude;

		?>
	
		<h3>Servidor</h3>
		
		<table class="tableGeo">		
			<tr>
				<td class="table-data">IP</td>
				<td class="table-data2"><?php echo $local_ip_address; ?></td>
			</tr>
			<tr class="table-row">
				<td class="table-data">Ciudad</td>
				<td class="table-data2"><?php echo $local_city; ?></td>
			</tr>
			<tr class="table-row">
				<td class="table-data">Pais</td>
				<td class="table-data2"><?php echo $local_country; ?></td>
			</tr>	
			<tr>
				<td class="table-data">Longitud</td>
				<td class="table-data2"><?php echo $local_long;  ?></td>
			</tr>
			<tr>
				<td class="table-data">Latitud</td>
				<td class="table-data2"><?php echo $local_lat; ?></td>
			</tr>
		</table>
		
		<h3>Cliente</h3>
		
		<table class="tableGeo">		
			<tr>
				<td class="table-data">IP</td>
				<td class="table-data2"><?php echo $remote_ip_address; ?></td>
			</tr>
			<tr class="table-row">
				<td class="table-data">Ciudad</td>
				<td class="table-data2"><?php echo $remote_city; ?></td>
			</tr>
			<tr class="table-row">
				<td class="table-data">Pais</td>
				<td class="table-data2"><?php echo $remote_country; ?></td>
			</tr>			
			<tr>
				<td class="table-data">Longitud</td>
				<td class="table-data2"><?php echo $remote_long;  ?></td>
			</tr>
			<tr>
				<td class="table-data">Latitud</td>
				<td class="table-data2"><?php echo $remote_lat; ?></td>
			</tr>
		</table>
		
		</body>
</html>
