<?php 
foreach ($_REQUEST as $key => $value) 
 {
  $$key = $value;
 }
  if (!isset($sigue)) 
  {
   $sigue = 0;
  }

include ("conexion.php"); 

$login_=trim($login_);
$password_=md5($password_);

$sql="select * from tbl_usuario where strlogin = '$login_' and strpass='$password_'";
$rs2=pg_query($sql);

while ($row =pg_fetch_array($rs2)){

$log=$row["strlogin"];
$pass=$row["strpass"];

}




if ($log==$login_ && $pass==$password_){

 ini_set("session.cookie_lifetime",20); 
 ini_set("session.gc_maxlifetime", 20);
 
session_start();

$_SESSION['login_']=$login_;

echo "<script>location.href='../seleccion.php'</script>";
}else{
echo "<script>alert('Error: usuario o contrasena')</script>";
 echo "<script>location.href='index.php'</script>";
} 



?>

