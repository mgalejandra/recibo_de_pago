<?php 

session_start();

$host = "localhost";
$port = "5432";
$data = "db_usuarios";
$user = "postgres"; 
$pass = "postgres"; 

$conn_string = "host=". $host . " port=" . $port . " dbname= " . $data . " user=" . $user . " password=" . $pass;
 
$dbconn = pg_connect($conn_string) or die;
 
if(!$dbconn) {
echo "Error al conectar a la Base de datos";
exit;
}


?>
