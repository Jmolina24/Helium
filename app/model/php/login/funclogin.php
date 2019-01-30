<?php
	header("Content-Type: text/html;charset=utf-8");
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	$function = $request->function;
	$function();
	function autenticar(){
	  require_once('../config/dbcon_local.php');
	  global $request;
		$myparams['UsersName'] = $request->user;
		$myparams['UsersPass'] = $request->pass;
	  $procedure_params = array(array(&$myparams['UsersName'],SQLSRV_PARAM_IN),
	                      array(&$myparams['UsersPass'],SQLSRV_PARAM_IN));
	  $consulta = "EXEC sp_login_users @UsersName=?, @UsersPass=?";
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
	function obtieneSesion(){
	 require_once('../config/dbcon_local.php');
	 global $request;
	 $myparams['EmpresaId'] = $request->empresa;
	 $myparams['UsersId'] = $request->user;
	 $myparams['Documento'] = $request->documento;
	 $myparams['estado'] = $request->estado;
	 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
											 array(&$myparams['UsersId'],SQLSRV_PARAM_IN),
											 array(&$myparams['Documento'],SQLSRV_PARAM_IN),
											 array(&$myparams['estado'],SQLSRV_PARAM_IN));
	 $consulta = "EXEC sp_listar_users  @EmpresaId=?, @UsersId=?, @Documento=?, @estado=?";
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
	function SesionPantalla(){
	  global $request;
		session_start();
		$_SESSION['SOCKETID'] = $request->id;
		echo $_SESSION['SOCKETID'];
	}
	function creaSesion(){
	  global $request;
		$data = json_decode($request->data);
		session_start();
		$_SESSION['IDUSUARIO'] = $data->UsersId;
		$_SESSION['USUARIO'] = $data->UserAcces;
		$_SESSION['SEDE'] = $data->SedeId;
		$_SESSION['OFICINA'] = $data->OficinaId;
		$_SESSION['AREA'] = $data->AreaId;
		$_SESSION['CARGO'] = $data->CargoEmpresa;
		$_SESSION['ROL'] = $data->NombreRol;
		$_SESSION['CODROL'] = $data->RolId;
    $_SESSION['NOMBRE_USUARIO'] = $data->NombresApellido;
		$_SESSION['IDEMPRESA'] = $data->EmpresaId;
		$_SESSION['RAZON_SOCIAL'] = $data->Empresa;
		echo 1;
	}
	function estadoUsuarioSesion(){
	  global $request;
		session_start();
		$_SESSION['ESTADOUSUARIO'] = $request->estado;
		echo 1;
	}
	function obtenerVarSesion(){
	   session_start();
		 $ses = json_encode($_SESSION);
		 echo $ses;
	}
?>
