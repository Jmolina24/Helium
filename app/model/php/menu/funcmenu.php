<?php
	header("Content-Type: text/html;charset=utf-8");
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	$function = $request->function;
	$function();
	function obtenerMenu(){
	  require_once('../config/dbcon.php');
	  global $request;
		$myparams['UsersId'] = $_SESSION['IDUSUARIO'];
	  $procedure_params = array(array(&$myparams['UsersId'],SQLSRV_PARAM_IN));
	  $consulta = "EXEC sp_listar_users_menu @UsersId =?";
	  $stmt = sqlsrv_query($con, $consulta, $procedure_params);
	  $row = array();
	  $rows= array();
	  if( $stmt === false) {
	    die( print_r( sqlsrv_errors(), true) );
	  }
	  while($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC))
	  {
	    $rows[] = $row;
	  }
	  echo json_encode($rows, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
	  sqlsrv_free_stmt($stmt);
		sqlsrv_close( $con );
	}
?>
