<?php

	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=".$nombre.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");

?>


<?php

	if(isset($export_bloque_notaria)){
		echo $export_bloque_notaria;
	}

?>