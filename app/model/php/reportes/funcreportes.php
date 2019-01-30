<?php
	header("Content-Type: text/html;charset=utf-8");
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	$function = $request->function;
	$function();
	function obtenerReporteConsolidado(){
		 require_once('../config/dbcon.php');
		 global $request;
		 $myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		 $myparams['OficinaId'] = $request->oficina;
		 $myparams['TipoReporte'] = $request->tipo;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
															 array(&$myparams['OficinaId'],SQLSRV_PARAM_IN),
												 			 array(&$myparams['TipoReporte'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_tablero_control_resumen @EmpresaId =?, @OficinaId =?, @TipoReporte =?";
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
	function obtenerReportePromedioAtencion(){
		 require_once('../config/dbcon.php');
		 global $request;
		 $myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		 $myparams['SedeId'] = $request->sede;
		 $myparams['OficinaId'] = $request->oficina;
		 $myparams['strTipoReporte'] = $request->tipo;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
		 													 array(&$myparams['SedeId'],SQLSRV_PARAM_IN),
															 array(&$myparams['OficinaId'],SQLSRV_PARAM_IN),
												 			 array(&$myparams['strTipoReporte'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_tiempo_promedio_atencion_total @EmpresaId =?, @SedeId=?, @OficinaId =?, @strTipoReporte =?";
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

	function obtenerReportePromedioAtencionAgente(){
		 require_once('../config/dbcon.php');
		 global $request;
		 $myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		 $myparams['SedeId'] = $request->sede;
		 $myparams['OficinaId'] = $request->oficina;
		 $myparams['strTipoReporte'] = $request->tipo;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
		 													 array(&$myparams['SedeId'],SQLSRV_PARAM_IN),
															 array(&$myparams['OficinaId'],SQLSRV_PARAM_IN),
												 			 array(&$myparams['strTipoReporte'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_tiempo_promedio_atencion_por_agente @EmpresaId =?, @SedeId=?, @OficinaId =?, @strTipoReporte =?";
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
	function obtenerReportePromedioAtencionServicioAgente(){
		 require_once('../config/dbcon.php');
		 global $request;
		 $myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		 $myparams['SedeId'] = $request->sede;
		 $myparams['OficinaId'] = $request->oficina;
		 $myparams['UserId'] = $request->user;
		 $myparams['strTipoReporte'] = $request->tipo;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
		 													 array(&$myparams['SedeId'],SQLSRV_PARAM_IN),
															 array(&$myparams['OficinaId'],SQLSRV_PARAM_IN),
															 array(&$myparams['UserId'],SQLSRV_PARAM_IN),
												 			 array(&$myparams['strTipoReporte'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_tiempo_promedio_atencion_por_agente_servicio @EmpresaId =?, @SedeId=?, @OficinaId =?, @UserId=?, @strTipoReporte =?";
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

	function obtenerReportePromedioFila(){
		 require_once('../config/dbcon.php');
		 global $request;
		 $myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		 $myparams['SedeId'] = $request->sede;
		 $myparams['OficinaId'] = $request->oficina;
		 $myparams['strTipoReporte'] = $request->tipo;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
		 													 array(&$myparams['SedeId'],SQLSRV_PARAM_IN),
															 array(&$myparams['OficinaId'],SQLSRV_PARAM_IN),
												 			 array(&$myparams['strTipoReporte'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_tiempo_promedio_espera_enfila_total @EmpresaId =?, @SedeId=?, @OficinaId =?, @strTipoReporte =?";
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
	function obtenerReportePromedioAtencionServicio(){
		 require_once('../config/dbcon.php');
		 global $request;
		 $myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		 $myparams['SedeId'] = $request->sede;
		 $myparams['OficinaId'] = $request->oficina;
		 $myparams['strTipoReporte'] = $request->tipo;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
		 													 array(&$myparams['SedeId'],SQLSRV_PARAM_IN),
															 array(&$myparams['OficinaId'],SQLSRV_PARAM_IN),
												 			 array(&$myparams['strTipoReporte'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_tiempo_promedio_atencion_por_servicio @EmpresaId =?, @SedeId=?, @OficinaId =?, @strTipoReporte =?";
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
	function obtenerReportePromedioFilaServicio(){
		 require_once('../config/dbcon.php');
		 global $request;
		 $myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		 $myparams['SedeId'] = $request->sede;
		 $myparams['OficinaId'] = $request->oficina;
		 $myparams['strTipoReporte'] = $request->tipo;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
		 													 array(&$myparams['SedeId'],SQLSRV_PARAM_IN),
															 array(&$myparams['OficinaId'],SQLSRV_PARAM_IN),
												 			 array(&$myparams['strTipoReporte'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_tiempo_promedio_espera_enfila_servicio @EmpresaId =?, @SedeId=?, @OficinaId =?, @strTipoReporte =?";
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
	function obtenerReportePromedioAtencionEsperaServicio(){
		 require_once('../config/dbcon.php');
		 global $request;
		 $myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		 $myparams['SedeId'] = $request->sede;
		 $myparams['OficinaId'] = $request->oficina;
		 $myparams['strTipoReporte'] = $request->tipo;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
		 													 array(&$myparams['SedeId'],SQLSRV_PARAM_IN),
															 array(&$myparams['OficinaId'],SQLSRV_PARAM_IN),
												 			 array(&$myparams['strTipoReporte'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_tiempo_promedio_espera_enfila_atencion_servicio @EmpresaId =?, @SedeId=?, @OficinaId =?, @strTipoReporte =?";
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
