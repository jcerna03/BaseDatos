<?php
require('./lib.php');
 session_start();
$con = new ConectorBD();
$response['conexion']= $con->initConexion('dbagenda');
if($response['conexion']=='OK')
{  
    $con->eliminarRegistro('usuario','1=1');
    for($i=0;$i<3;$i++)
    {
        $datos['id']  = ($i) + 1;
        $datos['nombre'] = "'"."nombre".$i."'";
        $datos['correo'] = "'"."correo".$i."'";
        $encrypted_data = "'".password_hash("pass".$i, PASSWORD_DEFAULT)."'";
        $datos['pass'] = $encrypted_data;
        $r = $con->insertData('usuario',$datos);

    }
    echo "-".$r;

}




 ?>