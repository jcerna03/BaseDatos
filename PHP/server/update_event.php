<?php
require('./lib.php');
$con = new ConectorBD();
$response['conexion']= $con->initConexion('dbagenda');
if($response['conexion']=='OK')
{   session_start();
    $datos['fecha_inicio'] = "'".$_POST['start_date']."'";
    $datos['hora_inicio'] = "'".$_POST['start_hour']."'";
    $datos['fecha_fin'] = "'".$_POST['end_date']."'";
    $datos['hora_fin'] = "'".$_POST['end_hour']."'";


        if($con->actualizarRegistro('eventos',$datos,'id="'.$_POST['id'].'"'))
        {
            $response['msg']="OK";
        }
        else{
            $response['msg']="Error al insertar registros";
        }
 
      
}

echo json_encode($response);
$con->cerrarConexion();
 ?>