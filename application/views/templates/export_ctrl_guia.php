<?php

	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=reporte_control_guia.xls");
	header("Pragma: no-cache");
	header("Expires: 0");

?>

<?php

	if(isset($export_ctrl_guia)){
		echo $export_ctrl_guia;
	}

?>