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
$usr = new usuario;

if ($consultar==1){
		
		$rs_buscar_usuario=pg_query($usr->conexionbd(), $usr->consultar_usuario($login));
		$vusuario = pg_fetch_object($rs_buscar_usuario);
		if (!$vusuario->id){
			
		}
}//fin consultar
if ($guardar==1){
	$usr->registrar_usuario($login,$cedula,$contrasena,$nombre,$apellido,$estatus,$cclave);
	$login='';
	$cedula='';
	$contrasena='';
	$nombre='';
	$apellido='';
	$estatus='';
	$cclave='';
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Creación de usuario</title>
<link rel="stylesheet" type="text/css" href="css/view.css" media="all">
<link rel="stylesheet" type="text/css" href="css/mensajes.css" media="all">
<script type="text/javascript" src="js/view.js"></script>
<script type="text/javascript" src="js/validacion.js"></script>
<link type="text/css" href="jquery-ui/css/smoothness/jquery-ui-1.8.7.custom.css" rel="Stylesheet" />	
<script type="text/javascript" src="jquery-ui/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="jquery-ui/js/jquery-ui-1.8.7.custom.min.js"></script>
<script type="text/javascript" src="jquery-1.7.2.js"></script>
<!--  <script type="text/javascript" src="js/mensajes_js.js"></script>-->
<style type="text/css">
#error{
color: #D8000C;  
background-color: #FFBABA;  
background-image: url('error.png');
display: none;
font-family:Arial, Helvetica, sans-serif;   
font-size:13px;  
border: 1px solid;  
margin: 10px 0px;  
padding:15px 10px 15px 50px;  
background-repeat: no-repeat;  
background-position: 10px center;  
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$('#save').click(function(){
		$('#error').show();
	});
});
</script>
<div class="info  mensajes" style="display: none;">Mensaje de informacion que deseamos mostrar al usuario</div>   
<div class="exito  mensajes" style="display: none;">Mensaje de exito de la operacion realizada</div>  
<div class="alerta  mensajes" style="display: none;">Mensaje de alerta que deseamos mostrar al usuario</div>   
<div id="error">El campo no debe estar vacio</div>
</head>
<body id="main_body" >
	
	<img id="top" src="imagenes/top.png" alt="">
	<div id="form_container">
	
		<h1><a>form</a></h1>
		<form id="form" class="appnitro"  method="post" action="" name="form">
					<div class="form_description">
			<h2>Creación de usuario</h2>
			<p></p>
		</div>						
			<ul >
			
					<li id="li_1" >
		<label class="description" for="login">Login del usuario </label>
		<div>
			<input id="element_1" name="login" class="element text medium" type="text" maxlength="50" value="<?php echo $login; ?>"/> 
			<input id="buscar_usuario" class="button_text" type="button" name="buscar_usuario" value="Buscar" onclick="javascript: buscar_nombre_usuario();" />
		</div><p class="guidelines" id="guide_1"><small>Debe ser el mismo usuario que se creo en el correo institucional</small></p> 
		</li>		<li id="li_2" >
		<label class="description" for="cedula">Cedula </label>
		<div>
			<input id="element_2" name="cedula" class="element text medium" type="text" maxlength="10" value="<?php echo $cedula;?>" onkeypress="return validarnumero(event); javascript:this.value=this.value.toUpperCase();"/> 
		</div><p class="guidelines" id="guide_1"><small>V-000000000, E-00000000</small></p>
		<div class="error  mensajes">Mensaje de alerta que deseamos mostrar al usuario</div> 
		</li>		<li id="li_3" >
		<label class="description" for="contrasena">Contraseña </label>
		<div>
			<input id="element_3" name="contrasena" class="element text medium" type="password" maxlength="50" value="<?php echo $contrasena;?>"/> 
		</div> 
		</li>		<li id="li_4" >
		<label class="description" for="nombre">Nombre </label>
		<div>
			<input id="element_4" name="nombre" class="element text medium" type="text" maxlength="50" value="<?php echo $nombre;?>" onkeypress="javascript:this.value=this.value.toUpperCase()"/> 
		</div> 
		</li>		<li id="li_5" >
		<label class="description" for="apellido">Apellido </label>
		<div>
			<input id="element_5" name="apellido" class="element text medium" type="text" maxlength="50" value="<?php echo $apellido;?>" onkeypress="javascript:this.value=this.value.toUpperCase()"/> 
		</div> 
		</li><li id="li_7" >
		<label class="description" for="element_7">Estatus </label>
		<span>
			<input id="element_7_1" name="estatus" class="element checkbox" type="checkbox" value="$estatus" />
<label class="choice" for="element_7_1">Activo</label>

		</span> 
		</li>		<li id="li_8" >
		<label class="description" for="element_8">Cambiar clave </label>
		<span>
			<input id="element_8_1" name="cclave" class="element checkbox" type="checkbox" value="<?php echo $cclave;?>" />
<label class="choice" for="element_8_1">Si</label>

		</span> 
		</li>
			
					<li class="buttons">
			    <input type="hidden" name="form_id" value="442408" />
			    
				 <!--<input id="saveForm" class="button_text" type="button" name="guardar" value="Guardar" onclick="javascript: guardar_usuario();" />-->
				<input id="save" class="button_text" type="button" name="guardar" value="Guardar"  /> 
		</li>
			</ul>
		</form>	

	</div>
	<img id="bottom" src="imagenes/bottom.png" alt="">
	</body>
</html>