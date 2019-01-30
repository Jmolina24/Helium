<?php
$serverName = "35.196.129.16"; //serverName\instanceName
$connectionInfo = array( "Database"=>"BD_Maindoc", "UID"=>"struser_aion", "PWD"=>"aion*2018.","CharacterSet" => "UTF-8");
$con = sqlsrv_connect( $serverName, $connectionInfo);
SESSION_START();
if( $con ) {
	//echo 1;
}else{
     echo "Connection Fallo.<br />";
     die( print_r( sqlsrv_errors(), true));
}
?>
