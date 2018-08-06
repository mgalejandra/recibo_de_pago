<?php 

/*
class conexion{
 function conectar(){
    $conex = @pg_connect("host=localhost dbname=inder port=5432 user=postgres password=0000");
return($conex);
 }
}
*/

class conexion{
 function conectar(){
    $conex = @pg_connect("host=localhost dbname=db_usuarios port=5432 user=postgres password=postgres"); 
return($conex2);
 }
}

?>
