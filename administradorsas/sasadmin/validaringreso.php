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
$user=trim($user);
$clave=md5($clave);
$sql="select str_nombreusuario, str_contrasena from tbl_ares_usuario where str_nombreusuario = '$user' and str_contrasena='$clave'";
$result=pg_query($conex,$sql);
$cadena=pg_fetch_object($result);
$grupo=$cadena->grupo; 


if (@$cadena->str_nombreusuario==$user && $cadena->str_contrasena==$clave){
 session_start();
 $_SESSION['user']=$user;
 echo "<script>location.href='ingresarusuario.php'</script>";
}else{
 echo "<script>alert('Error: usuario o contrasena')</script>";
 echo "<script>location.href='index.html'</script>";
} 
?>

