<?php

	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=".$nombre.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");


	if(isset($export_Guide)){
		echo $export_Guide;
	}

?>