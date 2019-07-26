<?php
require('./lib.php');
 session_start();
 
 if (isset($_SESSION['usuario'])) {
$con = new ConectorBD();
$response['conexion']= $con->initConexion('dbagenda');
if($response['conexion']=='OK')
{  
    $Evento = $con->getId('eventos');
    $dato = $Evento->fetch_assoc();

    $datos['id']  = ($dato['id']) + 1;
    $datos['id_usuario'] = $_SESSION['usuario'];
    $datos['titulo'] = "'".$_POST['titulo']."'";
    $datos['fecha_inicio'] = "'".$_POST['start_date']."'";
    $datos['hora_inicio'] = "'".$_POST['start_hour']."'";
    $datos['fecha_fin'] = "'".$_POST['end_date']."'";
    $datos['hora_fin'] = "'".$_POST['end_hour']."'";
    $datos['completo'] = $_POST['allDay'];
        if($con->insertData('eventos',$datos))
        {
            $response['msg']="OK";
        }
        else{
            $response['msg']="Error al insertar registros";
        }
}
echo json_encode($response);

$con->cerrarConexion();
 }
 else
 {
    header('Location:../client');
 }


 ?>