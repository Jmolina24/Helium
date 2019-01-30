<?php
	header("Content-Type: text/html;charset=utf-8");
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	$function = $request->function;
	$function();
	//Codifica caracteres para poder realizar el json_encode
	function encode_all_strings($arr) {
	   foreach($arr as $key => $value) {
			$arr[$key] = utf8_encode($value);
	   }
	   return $arr;
	}
	function obtenerSesion(){
	   session_start();
		 $ses = json_encode($_SESSION);
		 echo $ses;
	}
	function marcarSesion(){
    require_once('config/dbcon_local.php');
    global $request;
    $myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		$myparams['UsersId'] = $_SESSION['IDUSUARIO'];
    $myparams['ModuloId'] = $_SESSION['MODULO'];
    $myparams['Accion'] = $request->estado;
    $myparams['strTituloError'] = '';
    $myparams['strMessageError'] ='';
    $myparams['intValorError'] ='';
    $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
															array(&$myparams['UsersId'], SQLSRV_PARAM_IN),
                              array(&$myparams['ModuloId'], SQLSRV_PARAM_IN),
                              array(&$myparams['Accion'], SQLSRV_PARAM_IN),
                              array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
                              array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
                              array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
    $consulta = "EXEC sp_actualizar_sesion_users @EmpresaId = ?,
																								 @UsersId = ?,
					                                       @ModuloId  = ?,
					                                       @Accion = ?,
					                                       @strTituloError = ?,
					                                       @strMessageError = ?,
					                                       @intValorError = ?";
    $stmt = sqlsrv_prepare($con, $consulta, $procedure_params);
    if( !$stmt ) {
      die( print_r( sqlsrv_errors(), true));
    }
    if(sqlsrv_execute($stmt)){
      while($res = sqlsrv_next_result($stmt)){
        // make sure all result sets are stepped through, since the output params may not be set until this happens
      }
      print_r(json_encode(array("Codigo"=>$myparams['intValorError'],"Mensaje"=>$myparams['strMessageError'])));
    }
    else{
      die( print_r( sqlsrv_errors(), true));
    }
    sqlsrv_close( $con );
  }
	function listarTipoDocumento(){
		require_once('config/dbcon_local.php');
		global $request;
		$consulta = "EXEC sp_listar_tipo_documento";
		$stmt = sqlsrv_query($con, $consulta);
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
	function listarDepartamento(){
		require_once('config/dbcon_local.php');
		global $request;
		$consulta = "EXEC sp_listar_departamento_dane";
		$stmt = sqlsrv_query($con, $consulta);
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
	function listarMunicipio(){
		 require_once('config/dbcon_local.php');
		 global $request;
		 $myparams['DepartamentoId'] = $request->dpto;
		 $procedure_params = array(array(&$myparams['DepartamentoId'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_listar_municipio_dane @DepartamentoId=?";
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
	function listarUsuario(){
		 require_once('config/dbcon_local.php');
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
	function listarEmpresa(){
		 require_once('config/dbcon_local.php');
		 global $request;
		 $myparams['NitEmpresa'] = $request->nit;
		 $myparams['estado'] = $request->estado;
		 $procedure_params = array(array(&$myparams['NitEmpresa'],SQLSRV_PARAM_IN),
												 array(&$myparams['estado'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_listar_empresas   @NitEmpresa=?, @estado=?";
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
	function listarSede(){
		 require_once('config/dbcon_local.php');
		 global $request;
		 $myparams['EmpresaId'] = $request->empresa;
		 $myparams['estado'] = $request->estado;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
												 array(&$myparams['estado'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_listar_sedes  @EmpresaId=?, @estado=?";
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
	function listarOficina(){
		 require_once('config/dbcon_local.php');
		 global $request;
		 $myparams['EmpresaId'] = $request->empresa;
		 $myparams['SedeId'] = $request->sede;
		 $myparams['estado'] = $request->estado;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
															 array(&$myparams['SedeId'],SQLSRV_PARAM_IN),
															 array(&$myparams['estado'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_listar_oficinas  @EmpresaId=?, @SedeId=?, @estado=?";
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
	function listarArea(){
		 require_once('config/dbcon_local.php');
		 global $request;
		 $myparams['EmpresaId'] = $request->empresa;
		 $myparams['SedeId'] = $request->sede;
		 $myparams['OficinaId'] = $request->oficina;
		 $myparams['estado'] = $request->estado;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
															 array(&$myparams['SedeId'],SQLSRV_PARAM_IN),
															 array(&$myparams['OficinaId'],SQLSRV_PARAM_IN),
															 array(&$myparams['estado'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_listar_areas_oficina  @EmpresaId=?, @SedeId=?, @OficinaId=?, @estado=?";
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
	function listarCargo(){
		 require_once('config/dbcon_local.php');
		 global $request;
		 $myparams['EmpresaId'] = $request->empresa;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_listar_cargo_empresa  @EmpresaId=?";
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
	function listarTerceros(){
		 require_once('config/dbcon_local.php');
		 global $request;
		 $myparams['EmpresaId'] = $request->empresa;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_listar_remitente  @EmpresaId=?";
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
	function listarUnidad(){
		 require_once('config/dbcon_local.php');
		 global $request;
		 $myparams['EmpresaId'] = $request->empresa;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_listar_unidad_medida @EmpresaId=?";
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
	function listarServicio(){
		 require_once('config/dbcon_local.php');
		 global $request;
		 $myparams['EmpresaId'] = $request->empresa;
		 $myparams['MotivoEmpresaId'] = $request->motivo;
		 $myparams['estado'] = $request->estado;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
  														 array(&$myparams['MotivoEmpresaId'],SQLSRV_PARAM_IN),
															 array(&$myparams['estado'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_listar_motivo_empresa  @EmpresaId=?, @MotivoEmpresaId = ?, @estado=?";
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
	function listarMotivo(){
		 require_once('config/dbcon_local.php');
		 global $request;
		 $myparams['EmpresaId'] = $request->empresa;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_listar_motivo_documento  @EmpresaId=?";
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
	function listarPreferencia(){
		 require_once('config/dbcon_local.php');
		 global $request;
		 $myparams['EmpresaId'] = $request->empresa;
		 $myparams['estado'] = $request->estado;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
															 array(&$myparams['estado'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_listar_preferencia_empresa  @EmpresaId=?, @estado=?";
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
	function listarRol(){
		 require_once('config/dbcon_local.php');
		 global $request;
		 $myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		 $myparams['RolId'] = $request->rol;
		 $myparams['Estado'] = $request->estado;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
															 array(&$myparams['RolId'],SQLSRV_PARAM_IN),
															 array(&$myparams['Estado'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_listar_rol_empresa  @EmpresaId=?, @RolId=?, @Estado=?";
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
	function validarusuario(){
		require_once('config/dbcon_local.php');
		global $request;
		$consulta = "select *  from UsersRol";
		$stmt = sqlsrv_query($con, $consulta);
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
	function obtenerMenuEmpresa(){
		require_once('config/dbcon_local.php');
		global $request;
		$myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		$procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN));
		$consulta = "EXEC sp_listar_rol_admin_empresa  @EmpresaId=?";
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
	function listarMensajeria(){
		 require_once('config/dbcon_local.php');
		 global $request;
		 $myparams['EmpresaId'] = $request->empresa;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_listar_mensajeria  @EmpresaId=?";
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
	function listarOrigen(){
		 require_once('config/dbcon_local.php');
		 global $request;
		 $myparams['EmpresaId'] = $request->empresa;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_listar_tipo_correspondencia  @EmpresaId=?";
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
	function listarCategoria(){
		 require_once('config/dbcon_local.php');
		 global $request;
		 $myparams['EmpresaId'] = $request->empresa;
		 $myparams['CategoriaId'] = $request->codigo;
		 $myparams['estado'] = $request->estado;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
		 						   array(&$myparams['CategoriaId'],SQLSRV_PARAM_IN),
		 						   array(&$myparams['estado'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_listar_categoria  @EmpresaId=?, @CategoriaId = ?, @estado=?";
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
	function listarEstadoTipoCorrespondecias(){
		 require_once('config/dbcon_local.php');
		 global $request;
		 $myparams['EmpresaId'] = $request->empresa;
		 $myparams['TipoCorrespondenciaDocumentalId'] = $request->tipocorrespondencia;
		 $myparams['EstadoCorrespondenciaDocumentalId'] = $request->estadocorrespondencia;
		 $myparams['estado'] = $request->estado;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
		 						   array(&$myparams['TipoCorrespondenciaDocumentalId'],SQLSRV_PARAM_IN),
		 						   array(&$myparams['EstadoCorrespondenciaDocumentalId'],SQLSRV_PARAM_IN),
		 						   array(&$myparams['estado'],SQLSRV_PARAM_IN));
		 $consulta="EXEC sp_listar_estado_tipo_correspondencia_documental @EmpresaId=?, @TipoCorrespondenciaDocumentalId=?, @EstadoCorrespondenciaDocumentalId=?, @estado=?";
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
	function listarTipoDocumentos(){ //esta es la de tipo documental
	 require_once('config/dbcon_local.php');
	 global $request;
	 $myparams['EmpresaId'] = $request->empresa;
	 $myparams['TipoDocumentalId'] = $request->codigo;
	 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
 														 array(&$myparams['TipoDocumentalId'],SQLSRV_PARAM_IN));
	 $consulta = "EXEC sp_listar_tipo_documental  @EmpresaId=?, @TipoDocumentalId=?";
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
	function listarOrigenDocumentos(){ //esta es la de tipo documental
	 require_once('config/dbcon_local.php');
	 global $request;
	 $myparams['EmpresaId'] = $request->empresa;
	 $myparams['TipoCorrespondenciaDocumentalId'] = $request->tipocorrespondenciadocumentalid;
	 $myparams['TipoDocumentalId'] = $request->tipodocumentalid;
	 $myparams['TipoCorrespondenciaId'] = $request->tipocorrespondenciaid;
	 $myparams['estado'] = $request->estado;
	 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
														 array(&$myparams['TipoCorrespondenciaDocumentalId'],SQLSRV_PARAM_IN),
														 array(&$myparams['TipoDocumentalId'],SQLSRV_PARAM_IN),
													   array(&$myparams['TipoCorrespondenciaId'],SQLSRV_PARAM_IN),
														 array(&$myparams['estado'],SQLSRV_PARAM_IN));
	 $consulta = "EXEC sp_listar_tipo_correspondencia_documental  @EmpresaId=?, @TipoCorrespondenciaDocumentalId=?, @TipoDocumentalId=?, @TipoCorrespondenciaId=?, @estado=?";
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

	function listarSubmotivo(){
		 require_once('config/dbcon_local.php');
		 global $request;
		 $myparams['EmpresaId'] = $request->empresa;
		 $myparams['MotivoId'] = $request->codigo;
		 $myparams['SubMotivoId'] = $request->motivo;
		 $myparams['estado'] = $request->estado;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
									 array(&$myparams['MotivoId'],SQLSRV_PARAM_IN),
									 array(&$myparams['SubMotivoId'],SQLSRV_PARAM_IN),
								 	 array(&$myparams['estado'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_listar_submotivo_documento  @EmpresaId=?, @MotivoId = ?, @SubMotivoId=?, @estado=? ";
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

	function listarecepcion(){
		 require_once('config/dbcon_local.php');
		 global $request;
		 $myparams['EmpresaId'] = $request->empresa;
		 $myparams['UserAsignado'] = $request->usuario;
		 $myparams['AreaAsignadoDocumentoId'] = $request->area;
		 $myparams['TipoCorrespondenciaDocumentalId'] = $request->origen;
		 $myparams['EstadoCorrespondenciaDocumentalId'] = $request->estado;
		 $procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
												 array(&$myparams['UserAsignado'],SQLSRV_PARAM_IN),
												 array(&$myparams['AreaAsignadoDocumentoId'],SQLSRV_PARAM_IN),
												array(&$myparams['TipoCorrespondenciaDocumentalId'],SQLSRV_PARAM_IN),
												array(&$myparams['EstadoCorrespondenciaDocumentalId'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_listar_correspondencia_general  @EmpresaId=?, @UserAsignado = ?, @AreaAsignadoDocumentoId=?, @TipoCorrespondenciaDocumentalId=? ,@EstadoCorrespondenciaDocumentalId=?";
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
	function listarUsuarioArea(){
		 require_once('config/dbcon_local.php');
		 global $request;
		 $myparams['AreaId'] = $request->area;
		 $myparams['UsersId'] = $request->user;
		 $myparams['Documento'] = $request->documento;
		 $myparams['estado'] = $request->estado;
		 $procedure_params = array(array(&$myparams['AreaId'],SQLSRV_PARAM_IN),
															 array(&$myparams['UsersId'],SQLSRV_PARAM_IN),
															 array(&$myparams['Documento'],SQLSRV_PARAM_IN),
															 array(&$myparams['estado'],SQLSRV_PARAM_IN));
		 $consulta = "EXEC sp_listar_users_area @AreaId=?, @UsersId=?, @Documento=?, @estado=?";
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
