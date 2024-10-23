<?php
require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");
use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones

session_start();



 require '../QR/phpqrcode/qrlib.php';
 include "../../coneccion.php";
  mysqli_set_charset($conection, 'utf8'); //linea a colocar


    if ($_SESSION['rol'] == 'cuenta_empresa') {
    include "../sessiones/session_cuenta_empresa.php";

    }

    if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
    include "../sessiones/session_cuenta_usuario_venta.php";

    }


 if ($_POST['action'] == 'consultar_datos') {

   $query_consulta = mysqli_query($conection, "SELECT * FROM mensajes_masivos_wsp
      WHERE   mensajes_masivos_wsp.estatus = '1' AND mensajes_masivos_wsp.iduser = '$iduser'
   ORDER BY `mensajes_masivos_wsp`.`fecha` DESC ");

   $data = array();
while ($row = mysqli_fetch_assoc($query_consulta)) {
    $data[] = $row;
}

echo json_encode(array("data" => $data));
   // code...
 }


 if ($_POST['action'] == 'agregar_variables_entorno') {


           $variables    = $_POST['variables'];


   $query_insert=mysqli_query($conection,"INSERT INTO variables_globales(iduser,texto)
                                 VALUES('$iduser','$variables') ");

   if ($query_insert) {

       $arrayName = array('noticia'=>'insert_correct');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error','contenido_error' => mysqli_error($conection));
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }

 if ($_POST['action'] == 'info_cliente') {
      $cliente       = $_POST['cliente'];
      $query_consulta = mysqli_query($conection, "SELECT * FROM variables_globales
         WHERE variables_globales.estatus = '1' AND variables_globales.id = '$cliente' ");
   $data_producto = mysqli_fetch_array($query_consulta);
   echo json_encode($data_producto,JSON_UNESCAPED_UNICODE);
 }


 if ($_POST['action'] == 'editar_clientes') {

 $variables    = $_POST['variables'];

   $id_numero    = $_POST['id_cliente'];


   $query_insert = mysqli_query($conection,"UPDATE variables_globales SET texto='$variables'
     WHERE id = '$id_numero'");
   if ($query_insert) {
       $arrayName = array('noticia'=>'insert_correct','id_cliente'=> $id_numero);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

     }else {
       $arrayName = array('noticia' =>'error','contenido_error' => mysqli_error($conection));
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }





 if ($_POST['action'] == 'eliminar_cliente') {

   $numero_extra             = $_POST['cliente'];

   $query_delete=mysqli_query($conection,"UPDATE variables_globales SET estatus= 0  WHERE id='$numero_extra' ");

   if ($query_delete) {
       $arrayName = array('noticia'=>'insert_correct','cliente'=> $numero_extra);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error','contenido_error' => mysqli_error($conection));
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }







 ?>
