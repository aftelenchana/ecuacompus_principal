<?php

$host='localhost';

$user='ecuacomp_wsp';

$password='N0yB0Dh3JILz';

$db='ecuacomp_wsp';

$conection = @mysqli_connect($host,$user,$password,$db);

if (!$conection) {

  echo "Error en la coneccion";

}



 ?>
