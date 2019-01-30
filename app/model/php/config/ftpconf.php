<?php
	// $ftp_server = "ftp.smarterasp.net";
	// $con_id = ftp_connect($ftp_server);
	// $lr = ftp_login($con_id, "helium","helium*2018");
	// if ((!$con_id) || (!$lr)) {
	// 	echo "Fallo en la conexión"; die;
	// } else {
	// 	return $con_id;
	// }
	$ftp_server = "files.000webhost.com";
	$con_id = ftp_connect($ftp_server);
	$lr = ftp_login($con_id, "aionhelium","aion*2018.");
	if ((!$con_id) || (!$lr)) {
		echo "Fallo en la conexión"; die;
	} else {
		return $con_id;
	}
?>
