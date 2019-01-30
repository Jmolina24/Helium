<?php
error_reporting(0);
header("Content-Type: text/html;charset=utf-8");
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$function = $request->function;
$function();

function uiCorrespondencia(){
		require_once('../config/dbcon_local.php');
		global $request;
		$data = json_decode($request->data);
		$myparams['AreaOficinaId'] = $_SESSION['AREA']; //$data->area;
		$myparams['TipoCorrespondenciaDocumentalId'] = $data->tipocorrespondencia;
		$myparams['FechaDocumentoExterno'] = $data->fecha; //date("Y-m-d H:i:s");  //
		$myparams['MensajeriaId'] = $data->empresamensajeria;
		$myparams['CategoriaId'] =  $data->categoria;
		$myparams['UnidadMedidaId'] = $data->unidadmedida;
		$myparams['NumeroGuia'] = $data->numeroguia;
		$myparams['NumeroFolio'] = $data->cantidad;
		//$myparams['RemitenteInternoId'] = $data->remitenteinterno;
		if (isset($data->remitenteinterno)) {
			$myparams['RemitenteInternoId'] = $data->remitenteinterno;
		}else{
			$myparams['RemitenteInternoId'] ='';
		}
		$myparams['RemitenteExternoId'] = $data->entidad;
		$myparams['NombreRemitenteExterno'] = $data->nombre;
		if ($data->origendest=='') {
			$myparams['DestinoId'] = '1';
		} else {
			$myparams['DestinoId'] = $data->origendest;
		}



		$myparams['DestinatarioExternoId'] = $data->entidaddest;
		$myparams['DestinatarioInternoId'] = $data->remitenteinternodest;
		$myparams['NombreDestinatarioExterno'] = $data->nombredest;
		$myparams['Asunto'] = $data->asunto;
		$myparams['DocumentoUrl'] = '';
		$myparams['Observacion'] = $data->observacion;
		$myparams['UsuarioRegistra'] = $_SESSION['IDUSUARIO'];
		$myparams['strTituloError'] = '';
		$myparams['strMessageError'] = '';
		$myparams['intValorError'] = '';
		$procedure_params = array(	array(&$myparams['AreaOficinaId'],SQLSRV_PARAM_IN),
									array(&$myparams['TipoCorrespondenciaDocumentalId'],SQLSRV_PARAM_IN),
									array(&$myparams['FechaDocumentoExterno'],SQLSRV_PARAM_IN),
									array(&$myparams['MensajeriaId'],SQLSRV_PARAM_IN),
									array(&$myparams['CategoriaId'],SQLSRV_PARAM_IN),
									array(&$myparams['UnidadMedidaId'],SQLSRV_PARAM_IN),
									array(&$myparams['NumeroGuia'],SQLSRV_PARAM_IN),
									array(&$myparams['NumeroFolio'],SQLSRV_PARAM_IN),
									array(&$myparams['RemitenteInternoId'],SQLSRV_PARAM_IN),
									array(&$myparams['RemitenteExternoId'],SQLSRV_PARAM_IN),
									array(&$myparams['NombreRemitenteExterno'],SQLSRV_PARAM_IN),
									array(&$myparams['DestinoId'],SQLSRV_PARAM_IN),
									array(&$myparams['DestinatarioExternoId'],SQLSRV_PARAM_IN),
									array(&$myparams['DestinatarioInternoId'],SQLSRV_PARAM_IN),
									array(&$myparams['NombreDestinatarioExterno'],SQLSRV_PARAM_IN),
									array(&$myparams['Asunto'],SQLSRV_PARAM_IN),
									array(&$myparams['DocumentoUrl'],SQLSRV_PARAM_IN),
									array(&$myparams['Observacion'],SQLSRV_PARAM_IN),
									array(&$myparams['UsuarioRegistra'],SQLSRV_PARAM_IN),
	                            	array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
                              		array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
                              		array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
	$consulta = "EXEC sp_insertar_correspondencia   @AreaOficinaId=?,
													@TipoCorrespondenciaDocumentalId=?,
													@FechaDocumentoExterno=?,
													@MensajeriaId=?,
													@CategoriaId=?,
													@UnidadMedidaId=?,
													@NumeroGuia=?,
													@NumeroFolio=?,
													@RemitenteInternoId=?,
													@RemitenteExternoId=?,
													@NombreRemitenteExterno=?,
													@DestinoId=?,
													@DestinatarioExternoId=?,
													@DestinatarioInternoId=?,
													@NombreDestinatarioExterno=?,
													@Asunto=?,
													@DocumentoUrl=?,
													@Observacion=?,
													@UsuarioRegistra=?,
													@strTituloError=?,
													@strMessageError=?,
													@intValorError=?";
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


function subirftp(){
	require_once('../config/dbcon_local.php');
	require_once('../config/ftpconf.php');
	include('../upload_file/subir_archivo.php');
	global $request;
	$data = $request->data;
	$nombre = 'S_'.$request->radicado;
	$ext = 'pdf';
	$hoy = date('dmY');
	$path = '/CarguePrueba/Documento/'.$hoy.'/';
	$subio = subirDigitalizacionFTP($data,$path,$nombre,$ext);
	if ($subio != '0 - Error') {
		echo $subio;
	}else {
		echo 0;
	}
}




function uiUrl(){
	require_once('../config/dbcon_local.php');
	global $request;

	$myparams['CorrespondenciaId'] = $request->correspondencia;
	$myparams['UsuarioRegistra'] = $_SESSION['IDUSUARIO'];
	$myparams['UrlCorrespondencia'] = $request->url;
	$myparams['strTituloError'] = '';
	$myparams['strMessageError'] = '';
	$myparams['intValorError'] = '';
	$procedure_params = array(	array(&$myparams['CorrespondenciaId'],SQLSRV_PARAM_IN),
								array(&$myparams['UsuarioRegistra'],SQLSRV_PARAM_IN),
								array(&$myparams['UrlCorrespondencia'],SQLSRV_PARAM_IN),
								array(&$myparams['strTituloError'], SQLSRV_PARAM_OUT),
								array(&$myparams['strMessageError'], SQLSRV_PARAM_OUT),
								array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
	$consulta = "EXEC sp_asignar_url_correspondencia             @CorrespondenciaId=?,
															@UsuarioRegistra=?,
															@UrlCorrespondencia=?,
															@strTituloError=?,
															@strMessageError=?,
															@intValorError=?";
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



//Aldair

function uiEntregaCorrespondencia(){
	require_once('../config/dbcon_local.php');
	global $request;
	$myparams['CorrespondenciaId'] = $request->codigo;
	$myparams['UsuarioRegistra'] = $_SESSION['IDUSUARIO'];
	$myparams['UrlEntregaCorrespondencia'] = $request->url;
	$myparams['strTituloError'] ='';
	$myparams['strMessageError'] ='';
	$myparams['intValorError'] ='';
	$procedure_params = array(array(&$myparams['CorrespondenciaId'],SQLSRV_PARAM_IN),
														array(&$myparams['UsuarioRegistra'],SQLSRV_PARAM_IN),
														array(&$myparams['UrlEntregaCorrespondencia'],SQLSRV_PARAM_IN),
														array(&$myparams['strTituloError'],SQLSRV_PARAM_OUT),
														array(&$myparams['strMessageError'],SQLSRV_PARAM_OUT),
														array(&$myparams['intValorError'],SQLSRV_PARAM_OUT));
	$consulta = "EXEC sp_entregar_correspondencia @CorrespondenciaId=?,
																							  @UsuarioRegistra=?,
																 						    @UrlEntregaCorrespondencia=?,
																							  @strTituloError=?,
																							  @strMessageError=?,
																							  @intValorError=?";
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
function subirftpFirma(){
	require_once('../config/dbcon_local.php');
	require_once('../config/ftpconf.php');
	include('../upload_file/subir_archivo.php');
	global $request;
	$data = $request->data;
	$nombre = 'F_'.$request->codigo;
	$ext = 'png';
	$hoy = date('dmY');
	$path = '/CarguePrueba/Firma/'.$hoy.'/';
	$subio = subirDigitalizacionFTP($data,$path,$nombre,$ext);
	if ($subio != '0 - Error') {
		echo $subio;
	}else {
		echo $subio;
	}
}


function descargaAdjunto(){
	require_once('../config/ftpconf.php');
	global $request;
	$ruta = $request->ruta;
	$name = uniqid();
	$ext = pathinfo($request->ruta, PATHINFO_EXTENSION);
	$name = $name.'.'.$ext;
	$local_file = '../../../temp/'.$name;
	$handle = fopen($local_file, 'w');
	if (ftp_fget($con_id, $handle,$ruta , FTP_BINARY)) {
		 echo $name;
	} else {
		 echo "Error";
	}
	ftp_close($con_id);
	fclose($handle);
}




?>
