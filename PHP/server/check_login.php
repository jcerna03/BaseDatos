<?php
require('./lib.php');
session_start();
$con = new ConectorBD();
$response['conexion']= $con->initConexion('dbagenda');
if($response['conexion']=='OK')
{
        $resultado_consulta = $con->consultar(['usuario'], ['id','correo','pass'], ' WHERE correo="'.$_POST['username'].'"');
        if($resultado_consulta->num_rows!=0){
            
            $fila = $resultado_consulta->fetch_assoc();
            $isPasswordCorrect = password_verify($_POST['password'], $fila['pass']);
            if($isPasswordCorrect)
            {
                $_SESSION['usuario'] = $fila['id'];
                $response['msg'] = 'OK';
            }
            
        }else{
            $response['msg'] = 'Rechazado';
        }
}

echo json_encode($response);
$con->cerrarConexion();


 ?>