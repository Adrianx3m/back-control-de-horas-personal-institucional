<?php

   error_reporting(0);
   header("Access-Control-Allow-Origin: *");
   $method = $_SERVER['REQUEST_METHOD'];

   if($method=="POST"){

   require_once "../../../conexion.php";

 parse_str(file_get_contents("php://input"),$info);

  $personal=$info['key'];
$key = substr($personal, 0, 15);
$token = $info['token'];
  
$sql="UPDATE personal SET token='$token' WHERE personal_key=(SELECT personal_key FROM personal WHERE personal_key='$key' and token=NULL)";

	if($result=mysqli_query($conex,$sql)){
		 $error=array();
	$error[]=array(
	   'status'=>200,
	   'message'=>"Usuario borrado correctamente"
	);

	echo json_encode($error);
	}
 
   }else{
	
      $error=array();
	$error[]=array(
	   'status'=>422,
	   'message'=>"El metodo solicitado 'No existe' "
	);
	echo $method;
	echo json_encode($error);
}

?>