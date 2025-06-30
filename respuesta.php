<font size="20"><b>CLIENTES</b></font><p>

<?php

$host = getenv('DB_HOST');
$dbname = "empresa";
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

	//$host = 'mysql-cefire01-juan.mysql.database.azure.com';
	//$dbname = 'empresa';
	//$user = 'cefire';
	//$password = 'Alex1503';

	try {

		//Conectamos con la base de datos
		$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);

		//Lanzamos una consulta para ver si existe algún agente con el login y passowrd escritos en el formulario	
		$sql="select * from agentes where login='".$_POST['usuario']."' and password='".$_POST['contrasena']."'";
		$resul = $pdo->query($sql);
 
		//Si no ha devuelto un resultado
		if (!$agente = $resul->fetch())    
			//Datos incorrectos
   			echo "<font size='14' color='red'>Nombre de usuario o contrase&ntilde;a erroneos</font><p>\n\n";    
		//Sí ha devuelto un resultado
		else{
			//recupero el resultado y escribo el nombre y el apellido del agente
 			echo "Bienvenido <u><b>{$agente["Nombre"]} {$agente["Apellidos"]}</u></b>. Estos son tus clientes:<p>\n\n";
     			// recupero el NIF del agente y construyo la siguiente consulta
			$NIF=$agente["NIF"];
			$sql="select * from clientes where NIFAgente='$NIF'";
     			//Lanzo la consulta para ver si existe algún cliente para ese agente
			$resul=$pdo->query($sql);
     			echo "<table border=1>\n<tr><td><b>NIF</b></td><td><b>Nombre</b></td><td><b>Apellidos</b></td><td><b>Telefono</b></td><td><b>Saldo</b></td></tr>\n";
     			//recorro la respuesta fila por fila, escribiendo en una tabla cada cliente de ese agente
			while ($cliente=$resul->fetch()) {
				echo "<tr><td>".$cliente[0]."</td><td>".$cliente[1]."</td><td>".$cliente[2]."</td><td>".$cliente[3]."</td><td>".$cliente[4]."</td></tr>\n"; }
			echo "</table><p>\n\n";
		}
    
	}   catch (PDOException $e) {
    	// Manejo de errores
    	echo "Error en la conexión o consulta: " . $e->getMessage();
	}
?>
<a href="index.html">Volver a la p&aacute;gina anterior</a>
