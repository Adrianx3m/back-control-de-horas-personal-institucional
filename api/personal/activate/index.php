<?php

   error_reporting(0);
   header("Access-Control-Allow-Origin: *");
   $method = $_SERVER['REQUEST_METHOD'];

   if($method=="POST"){

   require_once "../../../conexion.php";


  $personal=$_POST['key'];
$key = substr($personal, 0, 15);
$token = $_POST['token'];
  
$sql="UPDATE personal SET token='$token' WHERE personal_key=(SELECT personal_key FROM personal WHERE personal_key='$key' AND token IS NULL)";
if(!$result=mysqli_query($conex,$sql)) die();
//$cantidad=mysqli_num_rows($result);
	if($verify=mysqli_affected_rows($conex)==0){
		 $error=array();
	$error[]=array(
	   'status'=>400,
	   'message'=>"El usuario ya ha sido registrado con anterioridad"
	);

	echo json_encode($error);
	}else{
		$error=array();
	$error[]=array(
	   'status'=>200,
	   'message'=>"Usuario activado correctamente"
	);

	echo json_encode($error);
	}
 
   }else{
	echo $method;
      $error=array();
	$error[]=array(
	   'status'=>422,
	   'message'=>"El metodo solicitado 'No existe' "
	);
	
	echo json_encode($error);
}

?>