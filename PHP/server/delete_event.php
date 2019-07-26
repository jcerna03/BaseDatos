<?php
require('./lib.php');
session_start();
if (isset($_SESSION['usuario'])) {
$con = new ConectorBD();
$response['conexion']= $con->initConexion('dbagenda');
if($response['conexion']=='OK')
{       if($con->eliminarRegistro('eventos','id="'.$_POST['id'].'"'))
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
else{
    header('Location:../client');
}


 ?>