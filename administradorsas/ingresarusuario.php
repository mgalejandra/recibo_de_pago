<?php
include_once ("clases/class_gestion_datos.php");
foreach ($_REQUEST as $key => $value) 
 {
  $$key = $value;
 }
  if (!isset($sigue)) 
  {
   $sigue = 0;
  }
?>
<link type="text/css" href="css/style.css" rel="Stylesheet" />
<script type="text/javascript" src="js/validacion.js"></script>
<form action="" method="post" name="form">
<fieldset style="border-collapse: collapse; -moz-border-radius: 10px 10px 10px 10px;"><legend class="texto"><b>DATOS DEL USUARIO A CREAR</b></legend>
<table border="1">
<tr>
<td align="right">Login:</td>
<td><input name="login" id="login" type="text" size="20" value="<?php echo $login; ?>" class="texto"/> mismo usuario que sigesp</td>
</tr>
<tr>
<td align="right">Cedula:</td>
<td><input name="cedula" id="cedula" type="text" size="20" maxlength="9" value="<?php echo $cedula; ?>" class="texto" onkeypress="return acceptNum(event)"/></td>
</tr>
<tr>
<td align="right">Contrasena:</td>
<td><input name="contrasena" id="contrasena" type="password" size="20" value="<?php echo $contrasena; ?>" class="texto"/></td>
</tr>
<tr>
<td align="right">Nombre:</td>
<td><input name="nombre" id="nombre" type="text" size="20" maxlength="9" value="<?php echo $nombre; ?>" class="texto"/></td>
</tr>
<tr>
<td align="right">Apellido:</td>
<td><input name="apellido" id="apellido" type="text" size="20" maxlength="9" value="<?php echo $apellido; ?>" class="texto"/></td>
</tr>
<tr>
<td align="right">Correo:</td>
<td><input name="correo" id="correo" type="text" size="20" maxlength="9" value="<?php echo $correo; ?>" class="texto"/></td>
</tr>
<tr>
<td colspan="2" align="center"><input name="ingresar" id="ingresar" type="button" value="Guardar" onclick="javascript: guardar_usuario();"/></td>
</tr>

</table>
</fieldset>
</form>