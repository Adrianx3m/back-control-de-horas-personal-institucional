<?php

header("Access-Control-Allow-Origin: *");

   $method = $_SERVER['REQUEST_METHOD'];
    $respuesta = array();
    date_default_timezone_set('America/Mexico_City');
    
   if($method=="POST" && isset($_SERVER['HTTP_USER_AUTH'])){
    
    require_once "../../../conexion.php";
    
    $hoy = date("w");

    if($hoy>0){
        $pkey=$_POST['user'];
        $token = $_SERVER['HTTP_USER_AUTH'];
        $fechaHoy = date('Y-m-d');
        $horaHoy = date('H:i:s');

    $sql1 = "INSERT INTO asistencia (fecha, personal_key) SELECT '$fechaHoy', (SELECT personal_key FROM personal) FROM DUAL WHERE NOT EXISTS (SELECT * FROM `asistencia` WHERE `fecha`='$fechaHoy' AND `personal_key`=(SELECT personal_key FROM personal) LIMIT 1)";
    mysqli_query($conex,$sql1);

    $sql2 = "SELECT p.personal_key FROM personal p WHERE p.personal_key='$pkey' AND p.token='$token'";
    $resultado1 = mysqli_query($conex,$sql2);
    while($row=mysqli_fetch_array($resultado1)){
        if(count($row)<=0){
            $respuesta[]=array(
                'status'=>400,
                'message'=>"Datos ingresados no validos, Favor de comunicarse con recursos humanos"
            );
            break;
        }else{
            $hora=date('G');
            $usuario = $row['personal_key'];
            $sql3="";
            if($hora>=6 && $hora<=9){
                $sql3="UPDATE asistencia SET entrada_m='$horaHoy' WHERE personal_key='$pkey' AND fecha='$fechaHoy' AND entrada_m IS NULL";
                $query=mysqli_query($conex,$sql3);
                if($verify=mysqli_affected_rows($conex)>0){
                    $respuesta[]=array(
                        'status'=>200,
                        'message'=>"Entrada de la mañana registrada correctamente"
                    );
                }else{
                    $respuesta[]=array(
                        'status'=>400,
                        'message'=>"Entrada de la mañana registrada con anterioridad"
                    );
                }
            }elseif($hora>=12 && $hora<=15){
                $sql3="UPDATE asistencia SET salida_m='$horaHoy' WHERE personal_key='$pkey' AND fecha='$fechaHoy' AND salida_m IS NULL";
                $query=mysqli_query($conex,$sql3);
                if($verify=mysqli_affected_rows($conex)>0){
                    $respuesta[]=array(
                        'status'=>200,
                        'message'=>"Salida de la mañana registrada correctamente"
                    );
                }else{
                    $respuesta[]=array(
                        'status'=>400,
                        'message'=>"Salida de la mañana registrada con anterioridad"
                    );
                }
            }elseif($hora>=16 && $hora<=17){
                $sql3="UPDATE asistencia SET entrada_t='$horaHoy' WHERE personal_key='$pkey' AND fecha='$fechaHoy' AND entrada_t IS NULL";
                $query=mysqli_query($conex,$sql3);
                if($verify=mysqli_affected_rows($conex)>0){
                    $respuesta[]=array(
                        'status'=>200,
                        'message'=>"Entrada de la tarde registrada correctamente"
                    );
                }else{
                    $respuesta[]=array(
                        'status'=>400,
                        'message'=>"Entrada de la tarde registrada con anterioridad"
                    );
                }
            }elseif($hora>=18 && $hora<=20){
                $sql3="UPDATE asistencia SET salida_t='$horaHoy' WHERE personal_key='$pkey' AND fecha='$fechaHoy' AND salida_t IS NULL";
                $query=mysqli_query($conex,$sql3);
                if($verify=mysqli_affected_rows($conex)>0){
                    $respuesta[]=array(
                        'status'=>200,
                        'message'=>"Salida de la tarde registrada correctamente"
                    );
                }else{
                    $respuesta[]=array(
                        'status'=>400,
                        'message'=>"Salida de la tarde registrada con anterioridad"
                    );
                }
            }else{
                    $respuesta[]=array(
                        'status'=>400,
                        'message'=>"No cumples con el horario establecido para registrarte"
                    );
                }
            }
        }
    }else{
        $respuesta[]=array(
            'status'=>400,
            'message'=>"Hoy no se trabaja"
        );
    }   
}else{
    $respuesta[]=array(
        'status'=>400,
        'message'=>"Error en la solicitud"
    );
   }
   echo json_encode($respuesta);
   mysqli_close($conex);

?>