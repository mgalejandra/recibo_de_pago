<head>
<title>..::Recibo de Pago - Index::..</title>
<script type="text/javascript" src="jquery.validate.js"></script>
<script type="text/javascript" src="js/validacion.js"></script>
<?php
foreach ($_REQUEST as $key => $value) 
 {
  $$key = $value;
 }
  if (!isset($sigue)) 
  {
   $sigue = 0;
  }
  
  $ano='2013';
  
//echo "aqui".$ano;


?>
<script language="JavaScript1.1">

	$(document).ready(function() {

	$("#form2").validate({
	
	});

});		

</script>
</head>
<?php include 'comun/header.php'; ?>
<!--<body id="login_body_purple">!-->
<div id="wrapper_header">
<div id="cintillo">
</div></div>
<br>
<br>
<br>
<div id="header">
<div id="logosistema">
<h1>Recibos de Pago</h1>
	</div>
	<div id="form">
      <form id="form2" name="form1" method="post" action="validaringreso.php">
<span class="txt_form">Usuario:</span><input type="text" name="login_" id="login_" class="required" size="2"/><span class="txt_form">Contrase&ntilde;a:</span><input type="password" name="password_" id="password_" class="required" size="2"/>
            <input type="button" name="send_" id="send_" value="Aceptar" onclick="javascript:entrar_sistema('<?php echo $ano;?>');"/>

      
<!--        <table width="530" align="left" cellspacing="0" bgcolor="#CCCCCC" id="tabla_sugerencias">
                    <tr>
            <td width="197" align="left" valign="top"><strong>Usuario</strong></td>
                  <td width="194" valign="top"><strong>Contrase&ntilde;a</strong></td>
                  <td width="101" valign="top">&nbsp;</td>
                </tr>
          <tr>
            <td align="right" valign="top"><input type="text" name="login_" id="login" class="required"/></td>
                  <td valign="top"><input type="password" name="password_" id="password" class="required" /></td>
                  <td valign="top"><input type="submit" name="send_" id="send_" value="Enviar" /></td>
                </tr>
          </table>
-->
<input type="hidden" name="ano" value="<?php echo @$ano; ?>"/>
      </form>
	</div>
</div>
<!--<div style="clear:both;" id="footer"><?php include 'comun/footer.php'; ?></div>-->
<br>
<br>
<!--<div id="wrapper"><div style="clear:both;" id="credits"><?php include 'comun/credits.php'; ?></div></div> !-->
</body>
</html>
</body>
</html>

