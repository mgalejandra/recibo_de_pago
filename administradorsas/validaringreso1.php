<?php 
foreach ($_REQUEST as $key => $value) 
 {
  $$key = $value;
 }
  if (!isset($sigue)) 
  {
   $sigue = 0;
  }

include ("clases/classbd.php"); 
$objConexion = new conexion();
$conex=$objConexion->conectar(); 
$login_=trim($login_);
//$password_=md5($password_);
$password_=$password_;
$sql="select strlogin, intcedula from tblusuarios where strlogin = '$login_' and intcedula='$password_'";
//die ($sql);
$result=pg_query($conex,$sql);
$cadena=pg_fetch_object($result);
$grupo=$cadena->grupo; 


if (@$cadena->strlogin==$login_ && $cadena->intcedula==$password_){
 session_start();
 $_SESSION['login_']=$login_;
 echo "<script>location.href='../reporte.php'</script>";
}else{
echo "<script>alert('Error: usuario o contrasena')</script>";
 echo "<script>location.href='index.php'</script>";
} 
?>

