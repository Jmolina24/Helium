<?php
	header("Content-Type: text/html;charset=utf-8");
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	$function = $request->function;
	$function();
	function encode_all_strings($arr) {
	   foreach($arr as $key => $value) {
			$arr[$key] = utf8_encode($value);
	   }
	   return $arr;
	}
  function uiSede(){
    require_once('../config/dbcon_local.php');
    global $request;
		
    $data = json_decode($request->data);
    $myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		$myparams['SedeId'] = $data->codigo;
    $myparams['Nombre'] = $data->nombre;
    $myparams['SiglaComercial'] = $data->sigla;
    $myparams['Direccion'] = $data->direccion;
    $myparams['Telefono'] = $data->contacto;
    $myparams['CiudadId'] = floatval($data->municipio);
    $myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
    $myparams['strTituloError'] = '';
    $myparams['strMessageError'] ='';
    $myparams['intValorError'] ='';
    $procedure_params = array(array(&$myparams['SedeId'],SQLSRV_PARAM_IN),
															array(&$myparams['EmpresaId'], SQLSRV_PARAM_IN),
                              array(&$myparams['Nombre'], SQLSRV_PARAM_IN),
                              array(&$myparams['SiglaComercial'], SQLSRV_PARAM_IN),
                              array(&$myparams['Direccion'],SQLSRV_PARAM_IN),
                              array(&$myparams['Telefono'],SQLSRV_PARAM_IN),
                              array(&$myparams['CiudadId'], SQLSRV_PARAM_IN),
                              array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
                              array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
                              array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
                              array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
    $consulta = "EXEC sp_insertar_sede @SedeId = ?,
																			 @EmpresaId= ?,
                                       @Nombre = ?,
                                       @SiglaComercial = ?,
                                       @Direccion = ?,
                                       @Telefono = ?,
                                       @CiudadId = ?,
                                       @UsuarioRegistra = ?,
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
  function cambiarEstadoSede(){
    require_once('../config/dbcon_local.php');
    global $request;
    $myparams['SedeId'] = $request->codigo;
    $myparams['Accion'] = $request->estado;
    $myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
    $myparams['strTituloError'] = '';
    $myparams['strMessageError'] = '';
    $myparams['intValorError'] = '';
    $procedure_params = array(array(&$myparams['SedeId'],SQLSRV_PARAM_IN),
                              array(&$myparams['Accion'], SQLSRV_PARAM_IN),
                              array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
                              array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
                              array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
                              array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
    $consulta = "EXEC sp_activar_inactivar_sede  @SedeId  = ?,
                                                 @Accion = ?,
                                                 @UsuarioRegistra = ?,
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
	function uiOficina(){
		require_once('../config/dbcon_local.php');
		global $request;
		$data = json_decode($request->data);
		$myparams['SedeId'] = $data->sede;
		$myparams['OficinaId'] = $data->codigo;
		$myparams['Nombre'] = $data->nombre;
		$myparams['SiglaComercial'] = $data->sigla;
		$myparams['Direccion'] = $data->direccion;
		$myparams['Telefono'] = $data->contacto;
		$myparams['CiudadId'] = floatval($data->municipio);
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] ='';
		$myparams['intValorError'] ='';
		$procedure_params = array(array(&$myparams['SedeId'],SQLSRV_PARAM_IN),
															array(&$myparams['OficinaId'], SQLSRV_PARAM_IN),
															array(&$myparams['Nombre'], SQLSRV_PARAM_IN),
															array(&$myparams['SiglaComercial'], SQLSRV_PARAM_IN),
															array(&$myparams['Direccion'],SQLSRV_PARAM_IN),
															array(&$myparams['Telefono'],SQLSRV_PARAM_IN),
															array(&$myparams['CiudadId'], SQLSRV_PARAM_IN),
															array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
			$consulta = "EXEC sp_insertar_oficina_sede       @SedeId = ?,
																											 @OficinaId = ?,
																											 @Nombre = ?,
																											 @SiglaComercial = ?,
																											 @Direccion = ?,
																											 @Telefono = ?,
																											 @CiudadId = ?,
																											 @UsuarioRegistra = ?,
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
	function cambiarEstadoOficina(){
		require_once('../config/dbcon_local.php');
		global $request;
		$myparams['OficinaId'] = $request->codigo;
		$myparams['Accion'] = $request->estado;
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] = '';
		$myparams['intValorError'] = '';
		$procedure_params = array(array(&$myparams['OficinaId'],SQLSRV_PARAM_IN),
															array(&$myparams['Accion'], SQLSRV_PARAM_IN),
															array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
		$consulta = "EXEC sp_activar_inactivar_oficina   @OficinaId  = ?,
																										 @Accion = ?,
																										 @UsuarioRegistra = ?,
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
	function uiArea(){
		require_once('../config/dbcon_local.php');
		global $request;
		$data = json_decode($request->data);
		$myparams['AreaId'] = $data->codigo;
		$myparams['OficinaId'] = $data->oficina;
		$myparams['Nombre'] = $data->nombre;
		$myparams['SiglaComercial'] = $data->sigla;
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] ='';
		$myparams['intValorError'] ='';
		$procedure_params = array(array(&$myparams['AreaId'],SQLSRV_PARAM_IN),
														  array(&$myparams['OficinaId'], SQLSRV_PARAM_IN),
															array(&$myparams['Nombre'], SQLSRV_PARAM_IN),
															array(&$myparams['SiglaComercial'], SQLSRV_PARAM_IN),
															array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
			$consulta = "EXEC sp_insertar_area_oficina       @AreaId  = ?,
																											 @OficinaId = ?,
																											 @Nombre = ?,
																											 @SiglaComercial = ?,
																											 @UsuarioRegistra = ?,
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
	function cambiarEstadoArea(){
		require_once('../config/dbcon_local.php');
		global $request;
		$myparams['AreaId'] = $request->codigo;
		$myparams['Accion'] = $request->estado;
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] = '';
		$myparams['intValorError'] = '';
		$procedure_params = array(array(&$myparams['AreaId'],SQLSRV_PARAM_IN),
															array(&$myparams['Accion'], SQLSRV_PARAM_IN),
															array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
		$consulta = "EXEC sp_activar_inactivar_area_oficina @AreaId  = ?,
																											  @Accion = ?,
																											  @UsuarioRegistra = ?,
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


	function uiUnidad(){
		require_once('../config/dbcon_local.php');
		global $request;
		$data = json_decode($request->data);
		$myparams['UnidadMedidaId'] = $data->codigo;
		$myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		$myparams['Nombre'] = $data->nombre;
		$myparams['Sigla'] = $data->sigla;
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] ='';
		$myparams['intValorError'] ='';
		$procedure_params = array(array(&$myparams['UnidadMedidaId'],SQLSRV_PARAM_IN),
															array(&$myparams['EmpresaId'], SQLSRV_PARAM_IN),
															array(&$myparams['Nombre'], SQLSRV_PARAM_IN),
															array(&$myparams['Sigla'], SQLSRV_PARAM_IN),
															array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
    $consulta = "EXEC sp_insertar_unidad_medida   @UnidadMedidaId   = ?,
																								  @EmpresaId  = ?,
																								  @Nombre = ?,
																								  @Sigla = ?,
																								  @UsuarioRegistra = ?,
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
	function cambiarEstadoUnidad(){
		require_once('../config/dbcon_local.php');
		global $request;
		$myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		$myparams['UnidadMedidaId'] = $request->codigo;
		$myparams['Accion'] = $request->estado;
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] = '';
		$myparams['intValorError'] = '';
		$procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
															array(&$myparams['UnidadMedidaId'],SQLSRV_PARAM_IN),
															array(&$myparams['Accion'], SQLSRV_PARAM_IN),
															array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
		$consulta = "EXEC sp_activar_inactivar_unidad_medida @EmpresaId = ?,
																												 @UnidadMedidaId = ?,
																												 @Accion = ?,
																												 @UsuarioRegistra = ?,
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


	function uiUser(){
		require_once('../config/dbcon_local.php');
		global $request;
		$data = json_decode($request->data);
		$myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		$myparams['UsersId'] = $data->codigo;
		$myparams['AreaId'] = $data->area;
		$myparams['RolId'] = $data->rol;
		$myparams['CargoEmpresaId'] = $data->cargo;
		$myparams['TipoDocumentoIdentidadId'] = $data->tipodocumento;
		$myparams['Documento'] = $data->documento;
		$myparams['Telefono'] = $data->telefono;
		$myparams['Celular'] = $data->celular;
		$myparams['Nombres'] = $data->nombres;
		$myparams['Apellidos'] = $data->apellidos;
		$myparams['Email'] = $data->email;
		$myparams['UserAcces'] = $data->usuario;
		$myparams['PasswordAcces'] = $data->pass;
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] ='';
		$myparams['intValorError'] ='';
		$procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
															array(&$myparams['UsersId'],SQLSRV_PARAM_IN),
															array(&$myparams['AreaId'],SQLSRV_PARAM_IN),
															array(&$myparams['RolId'],SQLSRV_PARAM_IN),
														  array(&$myparams['CargoEmpresaId'], SQLSRV_PARAM_IN),
															array(&$myparams['TipoDocumentoIdentidadId'], SQLSRV_PARAM_IN),
															array(&$myparams['Documento'], SQLSRV_PARAM_IN),
															array(&$myparams['Telefono'],SQLSRV_PARAM_IN),
															array(&$myparams['Celular'], SQLSRV_PARAM_IN),
															array(&$myparams['Nombres'], SQLSRV_PARAM_IN),
															array(&$myparams['Apellidos'], SQLSRV_PARAM_IN),
															array(&$myparams['Email'], SQLSRV_PARAM_IN),
															array(&$myparams['UserAcces'],SQLSRV_PARAM_IN),
															array(&$myparams['PasswordAcces'], SQLSRV_PARAM_IN),
															array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
			$consulta = "EXEC sp_insertar_user    					@EmpresaId = ?,
																											@UsersId = ?,
																											@AreaId = ?,
																											@RolId = ?,
																											@CargoEmpresaId = ?,
																											@TipoDocumentoIdentidadId = ?,
																											@Documento = ?,
																											@Telefono = ?,
																											@Celular = ?,
																											@Nombres = ?,
																											@Apellidos = ?,
																											@Email = ?,
																											@UserAcces = ?,
																											@PasswordAcces = ?,
																										  @UsuarioRegistra = ?,
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
	function cambiarEstadoUser(){
		require_once('../config/dbcon_local.php');
		global $request;
		$myparams['UsersId'] = $request->codigo;
		$myparams['Accion'] = $request->estado;
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] = '';
		$myparams['intValorError'] = '';
		$procedure_params = array(array(&$myparams['UsersId'],SQLSRV_PARAM_IN),
															array(&$myparams['Accion'], SQLSRV_PARAM_IN),
															array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
		$consulta = "EXEC sp_activar_inactivar_user @UsersId  = ?,
																							  @Accion = ?,
																							  @UsuarioRegistra = ?,
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
	// function uiServicio(){
	// 	require_once('../config/dbcon_local.php');
	// 	global $request;
	// 	$data = json_decode($request->data);
	// 	$myparams['MotivoId'] = $data->codigo;
	// 	$myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
	// 	$myparams['Nombre'] = $data->nombre;
	// 	$myparams['Sigla'] = $data->sigla;
	// 	$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
	// 	$myparams['strTituloError'] = '';
	// 	$myparams['strMessageError'] ='';
	// 	$myparams['intValorError'] ='';
	// 	$procedure_params = array(array(&$myparams['MotivoId'],SQLSRV_PARAM_IN),
	// 														array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
	// 														array(&$myparams['Nombre'], SQLSRV_PARAM_IN),
	// 														array(&$myparams['Sigla'], SQLSRV_PARAM_IN),
	// 														array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
	// 														array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
	// 														array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
	// 														array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
	// 		$consulta = "EXEC sp_insertar_motivo_empresa		@MotivoId = ?,
	// 																										@EmpresaId = ?,
	// 																										@Nombre = ?,
	// 																										@Sigla = ?,
	// 																										@UsuarioRegistra = ?,
	// 																										@strTituloError = ?,
	// 																										@strMessageError = ?,
	// 																										@intValorError = ?";
	// 	$stmt = sqlsrv_prepare($con, $consulta, $procedure_params);
	// 	if( !$stmt ) {
	// 		die( print_r( sqlsrv_errors(), true));
	// 	}
	// 	if(sqlsrv_execute($stmt)){
	// 		while($res = sqlsrv_next_result($stmt)){
	// 			// make sure all result sets are stepped through, since the output params may not be set until this happens
	// 		}
	// 		print_r(json_encode(array("Codigo"=>$myparams['intValorError'],"Mensaje"=>$myparams['strMessageError'])));
	// 	}
	// 	else{
	// 		die( print_r( sqlsrv_errors(), true));
	// 	}
	// 	sqlsrv_close( $con );
	// }
	// function cambiarEstadoServicio(){
	// 	require_once('../config/dbcon_local.php');
	// 	global $request;
	// 	$myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
	// 	$myparams['MotivoEmpresaId'] = $request->codigo;
	// 	$myparams['Accion'] = $request->estado;
	// 	$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
	// 	$myparams['strTituloError'] = '';
	// 	$myparams['strMessageError'] = '';
	// 	$myparams['intValorError'] = '';
	// 	$procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
	// 														array(&$myparams['MotivoEmpresaId'],SQLSRV_PARAM_IN),
	// 														array(&$myparams['Accion'], SQLSRV_PARAM_IN),
	// 														array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
	// 														array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
	// 														array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
	// 														array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
	// 	$consulta = "EXEC sp_activar_inactivar_motivo_empresa @EmpresaId  = ?,
	// 																												@MotivoEmpresaId  = ?,
	// 																												@Accion = ?,
	// 																												@UsuarioRegistra = ?,
	// 																												@strTituloError = ?,
	// 																												@strMessageError = ?,
	// 																												@intValorError = ?";
	// 	$stmt = sqlsrv_prepare($con, $consulta, $procedure_params);
	// 	if( !$stmt ) {
	// 		die( print_r( sqlsrv_errors(), true));
	// 	}
	// 	if(sqlsrv_execute($stmt)){
	// 		while($res = sqlsrv_next_result($stmt)){
	// 			// make sure all result sets are stepped through, since the output params may not be set until this happens
	// 		}
	// 		print_r(json_encode(array("Codigo"=>$myparams['intValorError'],"Mensaje"=>$myparams['strMessageError'])));
	// 	}
	// 	else{
	// 		die( print_r( sqlsrv_errors(), true));
	// 	}
	// 	sqlsrv_close( $con );
	// }
	function uiCargo(){
		require_once('../config/dbcon_local.php');
		global $request;
		$data = json_decode($request->data);
		$myparams['CargoId'] = $data->codigo;
		$myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		$myparams['Nombre'] = $data->nombre;
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] ='';
		$myparams['intValorError'] ='';
		$procedure_params = array(array(&$myparams['CargoId'],SQLSRV_PARAM_IN),
															array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
															array(&$myparams['Nombre'], SQLSRV_PARAM_IN),
															array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
			$consulta = "EXEC sp_insertar_cargo_empresa  		@CargoId = ?,
																											@EmpresaId = ?,
																											@Nombre = ?,
																											@UsuarioRegistra = ?,
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
	function cambiarEstadoCargo(){
		require_once('../config/dbcon_local.php');
		global $request;
		$myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		$myparams['CargoEmpresaId'] = $request->codigo;
		$myparams['Accion'] = $request->estado;
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] = '';
		$myparams['intValorError'] = '';
		$procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
															array(&$myparams['CargoEmpresaId'],SQLSRV_PARAM_IN),
															array(&$myparams['Accion'], SQLSRV_PARAM_IN),
															array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
		$consulta = "EXEC sp_activar_inactivar_cargo_empresa @EmpresaId = ?,
																													@CargoEmpresaId = ?,
																													@Accion = ?,
																													@UsuarioRegistra = ?,
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
	function uiMotivo(){
		require_once('../config/dbcon_local.php');
		global $request;
		$data = json_decode($request->data);
		$myparams['MotivoId'] = $data->codigo;
		$myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		$myparams['Nombre'] = $data->nombre;
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] ='';
		$myparams['intValorError'] ='';
		$procedure_params = array(array(&$myparams['MotivoId'],SQLSRV_PARAM_IN),
															array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
															array(&$myparams['Nombre'], SQLSRV_PARAM_IN),
															array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
			$consulta = "EXEC sp_insertar_motivo_documento	@MotivoId  = ?,
																											@EmpresaId  = ?,
																											@Nombre = ?,
																											@UsuarioRegistra = ?,
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
	function cambiarEstadoMotivo(){
		require_once('../config/dbcon_local.php');
		global $request;
		$myparams['MotivoDocumentoId'] = $request->codigo;
		$myparams['Accion'] = $request->estado;
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] = '';
		$myparams['intValorError'] = '';
		$procedure_params = array(
															array(&$myparams['MotivoDocumentoId'],SQLSRV_PARAM_IN),
															array(&$myparams['Accion'], SQLSRV_PARAM_IN),
															array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
		$consulta = "EXEC sp_activar_inactivar_motivo_documento  @MotivoDocumentoId  = ?,
																													   @Accion = ?,
																													   @UsuarioRegistra = ?,
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
	function uiRol(){
		require_once('../config/dbcon_local.php');
		global $request;
		$data = json_decode($request->data);
		$myparams['RolId'] = $data->codigo;
		$myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		$myparams['Nombre'] = $data->nombre;
		$myparams['Menu'] = $data->json;
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] ='';
		$myparams['intValorError'] ='';
		$procedure_params = array(array(&$myparams['RolId'],SQLSRV_PARAM_IN),
															array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
															array(&$myparams['Nombre'], SQLSRV_PARAM_IN),
															array(&$myparams['Menu'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
			$consulta = "EXEC sp_insertar_rol @RolId = ?,
																				@EmpresaId = ?,
																				@Nombre = ?,
																				@Menu = ?,
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
	function cambiarEstadoRol(){
		require_once('../config/dbcon_local.php');
		global $request;
		$myparams['RolId'] = $request->rol;
		$myparams['Accion'] = $request->estado;
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] = '';
		$myparams['intValorError'] = '';
		$procedure_params = array(array(&$myparams['RolId'],SQLSRV_PARAM_IN),
															array(&$myparams['Accion'], SQLSRV_PARAM_IN),
															array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
		$consulta = "EXEC sp_activar_inactivar_rol @RolId = ?,
																							 @Accion = ?,
																						   @UsuarioRegistra = ?,
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
	function uiMensajeria(){
		require_once('../config/dbcon_local.php');
		global $request;
		$data = json_decode($request->data);
		$myparams['MensajeriaId'] = $data->codigo;
		$myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		$myparams['Nombre'] = $data->nombre;
		$myparams['Url'] = $data->url;
		$myparams['Logo'] = $data->logo;
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] ='';
		$myparams['intValorError'] ='';
		$procedure_params = array(array(&$myparams['MensajeriaId'],SQLSRV_PARAM_IN),
															array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
															array(&$myparams['Nombre'],SQLSRV_PARAM_IN),
															array(&$myparams['Url'], SQLSRV_PARAM_IN),
															array(&$myparams['Logo'], SQLSRV_PARAM_IN),
															array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
		$consulta = "EXEC sp_insertar_mensajeria @MensajeriaId = ?,
																						 @EmpresaId = ?,
																						 @Nombre = ?,
																						 @Url = ?,
																						 @Logo = ?,
																						 @UsuarioRegistra = ?,
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
	function cambiarEstadoMensajeria(){
		require_once('../config/dbcon_local.php');
		global $request;
		$myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		$myparams['MensajeriaId'] = $request->codigo;
		$myparams['Accion'] = $request->estado;
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] = '';
		$myparams['intValorError'] = '';
		$procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
															array(&$myparams['MensajeriaId'],SQLSRV_PARAM_IN),
															array(&$myparams['Accion'], SQLSRV_PARAM_IN),
															array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
		$consulta = "EXEC sp_activar_inactivar_mensajeria @EmpresaId = ?,
																											@MensajeriaId =?,
																										  @Accion = ?,
																									    @UsuarioRegistra = ?,
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
	function uiOrigen(){
		require_once('../config/dbcon_local.php');
		global $request;
		$data = json_decode($request->data);
		$myparams['TipoCorrespondenciaId'] = $data->codigo;
		$myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		$myparams['Nombre'] = $data->nombre;
		$myparams['Abreviatura'] = $data->sigla;
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] ='';
		$myparams['intValorError'] ='';
		$procedure_params = array(array(&$myparams['TipoCorrespondenciaId'],SQLSRV_PARAM_IN),
															array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
															array(&$myparams['Nombre'],SQLSRV_PARAM_IN),
															array(&$myparams['Abreviatura'], SQLSRV_PARAM_IN),
															array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
		$consulta = "EXEC sp_insertar_tipo_correspondencia @TipoCorrespondenciaId = ?,
																						 @EmpresaId = ?,
																						 @Nombre = ?,
																						 @Abreviatura = ?,
																						 @UsuarioRegistra = ?,
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
	function cambiarEstadoOrigen(){
		require_once('../config/dbcon_local.php');
		global $request;
		$myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		$myparams['TipoCorrespondenciaId'] = $request->codigo;
		$myparams['Accion'] = $request->estado;
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] = '';
		$myparams['intValorError'] = '';
		$procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
															array(&$myparams['TipoCorrespondenciaId'],SQLSRV_PARAM_IN),
															array(&$myparams['Accion'], SQLSRV_PARAM_IN),
															array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
		$consulta = "EXEC sp_activar_inactivar_tipo_correspondencia @EmpresaId = ?,
																											@TipoCorrespondenciaId =?,
																											@Accion = ?,
																											@UsuarioRegistra = ?,
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
	function uiCategoria(){
		require_once('../config/dbcon_local.php');
		global $request;
		$data = json_decode($request->data);
		$myparams['CategoriaId'] = $data->codigo;
		$myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		$myparams['Nombre'] = $data->nombre;
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] ='';
		$myparams['intValorError'] ='';
		$procedure_params = array(array(&$myparams['CategoriaId'],SQLSRV_PARAM_IN),
															array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
															array(&$myparams['Nombre'],SQLSRV_PARAM_IN),
															array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
		$consulta = "EXEC sp_insertar_categoria @CategoriaId = ?,
																						 @EmpresaId = ?,
																						 @Nombre = ?,
																						 @UsuarioRegistra = ?,
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
	function cambiarEstadoCategoria(){
		require_once('../config/dbcon_local.php');
		global $request;
		$myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		$myparams['CategoriaId '] = $request->codigo;
		$myparams['Accion'] = $request->estado;
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] = '';
		$myparams['intValorError'] = '';
		$procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
															array(&$myparams['CategoriaId '],SQLSRV_PARAM_IN),
															array(&$myparams['Accion'], SQLSRV_PARAM_IN),
															array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
		$consulta = "EXEC sp_activar_inactivar_categoria @EmpresaId = ?,
														@CategoriaId  =?,
														@Accion = ?,
														@UsuarioRegistra = ?,
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

	function uiTipoDocumento(){
		require_once('../config/dbcon_local.php');
		global $request;
		$data = json_decode($request->data);
		$myparams['TipoDocumentalId'] = $data->codigo;
		$myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		$myparams['Nombre'] = $data->nombre;
		$myparams['Abreviatura'] = $data->sigla;
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] ='';
		$myparams['intValorError'] ='';
		$procedure_params = array(array(&$myparams['TipoDocumentalId'],SQLSRV_PARAM_IN),
															array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
															array(&$myparams['Nombre'],SQLSRV_PARAM_IN),
															array(&$myparams['Abreviatura'], SQLSRV_PARAM_IN),
															array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
		$consulta = "EXEC sp_insertar_tipo_documental @TipoDocumentalId = ?,
																						 @EmpresaId = ?,
																						 @Nombre = ?,
																						 @Abreviatura = ?,
																						 @UsuarioRegistra = ?,
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
	function cambiarEstadotipoDocumento(){
		require_once('../config/dbcon_local.php');
		global $request;
		$myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		$myparams['TipoDocumentalId'] = $request->codigo;
		$myparams['Accion'] = $request->estado;
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] = '';
		$myparams['intValorError'] = '';
		$procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
															array(&$myparams['TipoDocumentalId'],SQLSRV_PARAM_IN),
															array(&$myparams['Accion'], SQLSRV_PARAM_IN),
															array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
		$consulta = "EXEC sp_activar_inactivar_tipo_documental @EmpresaId = ?,
																											@TipoDocumentalId =?,
																											@Accion = ?,
																											@UsuarioRegistra = ?,
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

	function uiEstadoTipoCorrespondencia(){
		require_once('../config/dbcon_local.php');
		global $request;
		$data = json_decode($request->data);
		$myparams['EstadoTipoCorrespondenciaDocumentalId'] = $data->codigo;
		$myparams['TipoCorrespondenciaDocumentalId'] = $data->documento;
		$myparams['Nombre'] = $data->nombretipo;
		$myparams['Secuencia'] = $data->secuencia;
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] ='';
		$myparams['intValorError'] ='';
		$procedure_params = array(array(&$myparams['EstadoTipoCorrespondenciaDocumentalId'],SQLSRV_PARAM_IN),
															array(&$myparams['TipoCorrespondenciaDocumentalId'],SQLSRV_PARAM_IN),
															array(&$myparams['Nombre'],SQLSRV_PARAM_IN),
															array(&$myparams['Secuencia'], SQLSRV_PARAM_IN),
															array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
		$consulta = "EXEC sp_insertar_estado_tipo_correspondencia_documental  @EstadoTipoCorrespondenciaDocumentalId = ?,
																																			 		@TipoCorrespondenciaDocumentalId = ?,
																																					 @Nombre = ?,
																																					 @Secuencia = ?,
																																					 @UsuarioRegistra = ?,
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
	function cambiarEstadoTipoCorrespondencia(){
		require_once('../config/dbcon_local.php');
		global $request;
		$myparams['EstadoTipoDocumentoMotivoDocumentoId'] = $request->codigo;
		$myparams['Accion'] = $request->estado;
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] ='';
		$myparams['intValorError'] ='';
		$procedure_params = array(array(&$myparams['EstadoTipoDocumentoMotivoDocumentoId'],SQLSRV_PARAM_IN),
															array(&$myparams['Accion'], SQLSRV_PARAM_IN),
															array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
															array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
															array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
															array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
		$consulta = "EXEC sp_activar_inactivar_estado_tipo_correspondencia_documental	 @EstadoTipoDocumentoMotivoDocumentoId  =?,
																																									 @Accion = ?,
																																								 	 @UsuarioRegistra = ?,
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

	function uiOrigenDocumento(){
		require_once('../config/dbcon_local.php');
		global $request;
		$data = json_decode($request->data);
		$myparams['TipoCorrespondeciaDocumentalId'] = $data->codigo;
		$myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
		$myparams['TipoDocumentalId'] = $data->documento;
		$myparams['TipoCorrespondenciaId'] = $data->origen;
		$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] ='';
		$myparams['intValorError'] ='';
		$procedure_params = array(array(&$myparams['TipoCorrespondeciaDocumentalId'],SQLSRV_PARAM_IN),
		array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
		array(&$myparams['TipoDocumentalId'],SQLSRV_PARAM_IN),
		array(&$myparams['TipoCorrespondenciaId'], SQLSRV_PARAM_IN),
		array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
		array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
		array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
		array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
		$consulta = "EXEC sp_insertar_tipo_correspondencia_documental  @TipoCorrespondeciaDocumentalId = ?,
		@EmpresaId = ?,
		@TipoDocumentalId = ?,
		@TipoCorrespondenciaId = ?,
		@UsuarioRegistra = ?,
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
	function cambiarEstadoOrigenDocumento(){
			require_once('../config/dbcon_local.php');
			global $request;
			$myparams['TipoCorrespondeciaDocumentalId'] = $request->codigo;
			$myparams['Accion'] = $request->estado;
			$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
			$myparams['strTituloError'] = '';
			$myparams['strMessageError'] = '';
			$myparams['intValorError'] = '';
			$procedure_params = array(array(&$myparams['TipoCorrespondeciaDocumentalId'],SQLSRV_PARAM_IN),
																array(&$myparams['Accion'], SQLSRV_PARAM_IN),
																array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
																array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
																array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
																array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
			$consulta = "EXEC sp_activar_inactivar_tipo_correspondencia_documental  @TipoCorrespondeciaDocumentalId =?,
																																							@Accion = ?,
																																							@UsuarioRegistra = ?,
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
		function uiSubEstadoMotivo(){
			require_once('../config/dbcon_local.php');
			global $request;
			$data = json_decode($request->data);
			$myparams['SubMotivoId'] = $data->codigo;
			$myparams['MotivoId'] = $data->codigomotivo;
			$myparams['Nombre'] = $data->nombre;
			$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
			$myparams['strTituloError'] = '';
			$myparams['strMessageError'] ='';
			$myparams['intValorError'] ='';
			$procedure_params = array(array(&$myparams['SubMotivoId'],SQLSRV_PARAM_IN),
			array(&$myparams['MotivoId'],SQLSRV_PARAM_IN),
			array(&$myparams['Nombre'],SQLSRV_PARAM_IN),
			array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
			array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
			array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
			array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
			$consulta = "EXEC sp_insertar_submotivo_documento @SubMotivoId = ?,
																												@MotivoId = ?,
																												@Nombre = ?,
																												@UsuarioRegistra = ?,
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
	function cambiarEstadoSubMotivo(){
			require_once('../config/dbcon_local.php');
			global $request;
			$myparams['SubMotivoDocumentoId'] = $request->codigo;
			$myparams['Accion'] = $request->estado;
			$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
			$myparams['strTituloError'] = '';
			$myparams['strMessageError'] = '';
			$myparams['intValorError'] = '';
			$procedure_params = array(
																array(&$myparams['SubMotivoDocumentoId'],SQLSRV_PARAM_IN),
																array(&$myparams['Accion'], SQLSRV_PARAM_IN),
																array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
																array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
																array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
																array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
			$consulta = "EXEC sp_activar_inactivar_submotivo_documento  @SubMotivoDocumentoId  = ?,
																														   @Accion = ?,
																														   @UsuarioRegistra = ?,
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
		function uiTercero(){
			require_once('../config/dbcon_local.php');
			global $request;
			$data = json_decode($request->data);
			$myparams['RemitenteId'] = $data->codigo;
			$myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
			$myparams['Nombre'] = $data->nombre;
			$myparams['Ciudad'] = $data->municipio;
			$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
			$myparams['strTituloError'] = '';
			$myparams['strMessageError'] ='';
			$myparams['intValorError'] ='';
			$procedure_params = array(array(&$myparams['RemitenteId'],SQLSRV_PARAM_IN),
																array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
																array(&$myparams['Nombre'],SQLSRV_PARAM_IN),
																array(&$myparams['Ciudad'],SQLSRV_PARAM_IN),
																array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
																array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
																array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
																array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
			$consulta = "EXEC sp_insertar_remitente @RemitenteId = ?,
																												@EmpresaId = ?,
																												@Nombre = ?,
																												@Ciudad = ?,
																												@UsuarioRegistra = ?,
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
	function cambiarEstadoTercero(){
			require_once('../config/dbcon_local.php');
			global $request;
			$myparams['EmpresaId'] = $_SESSION['IDEMPRESA'];
			$myparams['RemitenteId'] = $request->codigo;
			$myparams['Accion'] = $request->estado;
			$myparams['UsuarioRegistra'] = $_SESSION['USUARIO'];
			$myparams['strTituloError'] = '';
			$myparams['strMessageError'] = '';
			$myparams['intValorError'] = '';
			$procedure_params = array(array(&$myparams['EmpresaId'],SQLSRV_PARAM_IN),
																array(&$myparams['RemitenteId'],SQLSRV_PARAM_IN),
																array(&$myparams['Accion'], SQLSRV_PARAM_IN),
																array(&$myparams['UsuarioRegistra'], SQLSRV_PARAM_IN),
																array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
																array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
																array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
			$consulta = "EXEC sp_activar_inactivar_remitente  @EmpresaId = ?,
																																	@RemitenteId = ?,
																															    @Accion = ?,
																															    @UsuarioRegistra = ?,
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
?>
