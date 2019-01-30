<?php
$serverName = "sql5013.site4now.net"; //serverName\instanceName
$connectionInfo = array( "Database"=>"DB_A3B2C9_aion", "UID"=>"DB_A3B2C9_aion_admin", "PWD"=>"aion*2018");
$con = sqlsrv_connect( $serverName, $connectionInfo);
SESSION_START();
if( $con ) {

}else{
     echo "Connection Fallo.<br />";
     die( print_r( sqlsrv_errors(), true));
}
?>
