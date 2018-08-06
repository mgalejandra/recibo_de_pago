<?php

echo "<script>
		alert('La sesi\u00f3n de su usuario ha expirado. Debe iniciar sesi\u00f3n nuevamente');

</script>";

	header("Refresh: 0; URL=http://localhost/recibo_pago_local/administradorsas/index.php");

	//header("Refresh: 0; URL=http://intranet.inder.gob.ve/index.php");
	
?>
