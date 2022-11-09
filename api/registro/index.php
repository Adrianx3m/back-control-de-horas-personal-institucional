<?php

$error = array();
$error[] = array(
'status'=>400,
'message'=>"La ruta especificada no existe"
);

echo json_encode($error);

?>