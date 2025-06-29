<font size="20"><b>CLIENTESss</b></font><p>

<?php

$dbHost = getenv('DB_HOST');
$dbName = "empresa";
$dbUser = getenv('DB_USER');
$dbPass = getenv('DB_PASSWORD');
echo getenv('DB_HOST')."   ".getenv('DB_USER')."   ".getenv('DB_PASSWORD');



//Conectamos con la base de datos
$con=mysqli_connect($dbHost,$dbUser,$dbPass,$dbName);

//Lanzamos una consulta para ver si existe algún agente con el login y passowrd escritos en el formulario
$sql="select * from agentes where login='".$_POST['usuario']."' and password='".$_POST['contrasena']."'";
$resul=mysqli_query($con,$sql);

//Si no ha devuelto un resultado
if (mysqli_num_rows($resul)==0)    
	//Datos incorrectos
   	echo "<font size='14' color='red'>Nombre de usuario o contraseña erroneos</font><p>\n\n";    
//Sí ha devuelto un resultado
else{
	//recupero el resultado y escribo el nombre y el apellido del agente
	$arr_resul= mysqli_fetch_array($resul,MYSQLI_NUM);
	echo "Bienvenido <u><b>".$arr_resul[1]." ".$arr_resul[2]."</u></b>. Estos son tus clientes:<p>\n\n";
     	// recupero el NIF del agente y construyo la siguiente consulta
	$NIF=$arr_resul[0];
	$sql="select * from clientes where NIFAgente='$NIF'";
     	//Lanzo la consulta para ver si existe algún cliente para ese agente
	$resul=mysqli_query($con,$sql);
     	echo "<table border=1>\n<tr><td><b>NIF</b></td><td><b>Nombre</b></td><td><b>Apellidos</b></td><td><b>Telefono</b></td><td><b>Saldo</b></td></tr>\n";
     	//recorro la respuesta fila por fila, escribiendo en una tabla cada cliente de ese agente
	while ($arr_resul=mysqli_fetch_array($resul,MYSQLI_NUM))
		echo "<tr><td>".$arr_resul[0]."</td><td>".$arr_resul[1]."</td><td>".$arr_resul[2]."</td><td>".$arr_resul[3]."</td><td>".$arr_resul[4]."</td></tr>\n";
		echo "</table><p>\n\n";
     }
         
// Liberamos espacio ocupado con el resultado de la consulta
mysqli_free_result($resul);
// Cerramos la conexión con el servidor de BD
mysqli_close($con);
?>
<a href="index.html">Volver a la página anterior</a>
