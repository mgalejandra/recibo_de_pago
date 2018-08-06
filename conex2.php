<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--****************************** CABECERA INICIO **********************************-->
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::Recibo De Pago::..</title>

</head>
<!--****************************** CABECERA FIN *************************************-->


<!--****************************** CUERPO INICIO ************************************-->
<body>
<?php 
///////////////////////////////// CONEX PRODUCCION ////////////////////////////////////////

$user = 'postgres';
$passwd = '123456';
$db = 'db_inder_2013';
$port = '5432';
$host = 'localhost';
$strCnx = "host=$host port=$port dbname=$db user=$user password=$passwd";
$cnx = pg_connect($strCnx) or die ("Error de conexion. ". pg_last_error());
if (!$cnx){
	
	echo "Error";
	exit;
}

///////////////////////////////// CONEX PRODUCCION ////////////////////////////////////////
?>
</body>
<!--****************************** CUERPO FIN ***************************************-->
</html>
