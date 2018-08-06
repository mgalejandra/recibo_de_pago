<?php 
class conexion{
 function conectar(){
    $conex = pg_connect("host=localhost dbname=db_ares_prueba port=5432 user=postgres password=12345678"); 
return($conex);
 }
}
?>
