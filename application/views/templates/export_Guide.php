<?php

	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=reporte_guias.xls");
	header("Pragma: no-cache");
	header("Expires: 0");

?>


<?php

	if(isset($export_Guide)){
		echo $export_Guide;
	}

?>