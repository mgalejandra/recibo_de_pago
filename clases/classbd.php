<?php 
class conexion{
 function conectar(){
foreach ($_REQUEST as $key => $value) 
 {
  $$key = $value;
 }
  if (!isset($sigue)) 
  {
   $sigue = 0;
  }
if($ano==2012){   
 $conex = @pg_connect("host=192.168.0.246 dbname=db_inder_2012 port=5432 user=postgres password=inder*admin+prod2010"); 
}else if($ano==2018) {
 $conex = @pg_connect("host=localhost dbname=corpo port=5432 user=postgres password=postgres"); 
}
return($conex);
 }
}

class conexion2{
 function conectar2(){
    $conex2 = @pg_connect("host=localhost dbname=db_usuarios port=5432 user=postgres password=postgres"); 
return($conex2);
 }
}

?>

