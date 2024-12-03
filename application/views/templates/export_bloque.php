<?php

	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=reporte_bloques.xls");
	header("Pragma: no-cache");
	header("Expires: 0");

?>


<?php

	if(isset($export_bloque)){
		echo $export_bloque;
	}

?>