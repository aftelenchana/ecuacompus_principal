<?php
// Reportar todos los errores de PHP (ver el manual de PHP para más niveles de errores)
error_reporting(E_ALL);

// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);



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

      $query_consulta = mysqli_query($conection, "SELECT numeros_extras.nombre,numeros_extras.numero,numeros_extras.key_wsp,
        servidores_wsp.url as 'url_server',numeros_extras.id
         FROM numeros_extras
        INNER JOIN servidores_wsp ON servidores_wsp.id = numeros_extras.servidor
         WHERE   numeros_extras.estatus = '1' AND numeros_extras.iduser = '$iduser'
      ORDER BY `numeros_extras`.`fecha` DESC ");

      $data = array();
      while ($row = mysqli_fetch_assoc($query_consulta)) {
          // Código para sacar la información de cada número extra según el ID
          $key_wsp = $row['key_wsp'];
          $url_server = $row['url_server'];
          $ch = curl_init();

          $url_verificacion_session = ''.$url_server.'/check-session';

          $postData = array(
              'sessionId' => $key_wsp  // Asegúrate de enviar los datos requeridos por la API
          );

          // Configurar cURL para hacer la solicitud POST
          curl_setopt($ch, CURLOPT_URL, $url_verificacion_session);
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));  // Convertir el array PHP a JSON

          // Ejecutar la solicitud y obtener la respuesta
          $response = curl_exec($ch);

          // Verificar si hubo un error en la solicitud
          if(curl_errno($ch)) {
              echo 'Error en cURL: ' . curl_error($ch);
          }

          // Cerrar cURL
          curl_close($ch);

          // Convertir la respuesta JSON en un array de PHP
          $data_api = json_decode($response, true);

          // Agregar la respuesta a la fila actual
          if (isset($data_api['sessionId'])) {
              // La sesión está activa
              $row['sessionId'] = $data_api['sessionId'];
              $row['status'] = $data_api['status'];
              $row['message'] = $data_api['message'];
              $row['url_qr'] = ''.$url_server.'/get-qr/'.$key_wsp.'';
          } elseif (isset($data_api['error'])) {
              // La sesión no fue encontrada
              $row['error'] = $data_api['error'];
              $row['status'] = 'Session No Creada';
              $row['message'] = 'Ingresa a consola para crearla';
              $row['url_qr'] = '';
          }


          // Agregar el array modificado a $data
          $data[] = $row;
      }


   echo json_encode(array("data" => $data));
      // code...
    }



 if ($_POST['action'] == 'agregar_numero_extra') {


           $nombre    = $_POST['nombre'];
           $numero    = $_POST['numero'];
           $servidor    = $_POST['servidor'];

           // Obtén la fecha y hora actual
            $fecha_hora = date('Y-m-d H:i:s');

            // Concatena las variables
            $cadena = $nombre . $numero . $iduser . $fecha_hora;

            // Genera el hash MD5
            $key_wsp = md5($cadena);


   $query_insert=mysqli_query($conection,"INSERT INTO numeros_extras(nombre,numero,iduser,key_wsp,servidor)
                                 VALUES('$nombre','$numero','$iduser','$key_wsp','$servidor') ");

   if ($query_insert) {


     //SACAMOS LA URL DEL SERVIDOR

     $query_servidor = mysqli_query($conection, "SELECT * FROM servidores_wsp
        WHERE servidores_wsp.estatus = '1' AND servidores_wsp.id = '$servidor' ");
  $data_servidor = mysqli_fetch_array($query_servidor);

  $url_servidor = $data_servidor['url'];

     //CREAR MEDIANTE API

     //PRIMERA API VERIFICAR LA SESION
     $ch = curl_init();
     $url_iniciar_session = ''.$url_servidor.'/start-session';

     $postData = array(
         'sessionId' => $key_wsp  // Asegúrate de enviar los datos requeridos por la API
     );

     // Configurar cURL para hacer la solicitud POST
     curl_setopt($ch, CURLOPT_URL, $url_iniciar_session);
     curl_setopt($ch, CURLOPT_POST, true);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));  // Convertir el array PHP a JSON

     // Ejecutar la solicitud y obtener la respuesta
     $response = curl_exec($ch);

     // Verificar si hubo un error en la solicitud
     if(curl_errno($ch)) {
         echo 'Error en cURL: ' . curl_error($ch);
     }

     // Cerrar cURL
     curl_close($ch);

     $data = json_decode($response, true);



       $arrayName = array('noticia'=>'insert_correct');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error','contenido_error' => mysqli_error($conection));
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }

 if ($_POST['action'] == 'info_cliente') {
      $cliente       = $_POST['cliente'];
      $query_consulta = mysqli_query($conection, "SELECT * FROM numeros_extras
         WHERE numeros_extras.estatus = '1' AND numeros_extras.id = '$cliente' ");
   $data_producto = mysqli_fetch_array($query_consulta);
   echo json_encode($data_producto,JSON_UNESCAPED_UNICODE);
 }


 if ($_POST['action'] == 'editar_clientes') {

   $nombre    = $_POST['nombre'];
   $numero    = $_POST['numero'];

   $id_numero    = $_POST['id_cliente'];


   $query_insert = mysqli_query($conection,"UPDATE numeros_extras SET nombre='$nombre',numero='$numero'
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

   //sacamos la informacion de la instancia

   $query_consulta = mysqli_query($conection, "SELECT * FROM numeros_extras
      WHERE numeros_extras.estatus = '1' AND numeros_extras.id = '$numero_extra' ");
      $data_producto = mysqli_fetch_array($query_consulta);

      $key_wsp = $data_producto['key_wsp'];



   $query_delete=mysqli_query($conection,"UPDATE numeros_extras SET estatus= 0  WHERE id='$numero_extra' ");

   if ($query_delete) {





     $ch = curl_init();
     $url_eliminar_full = ''.$url.'/close-session-full';

     $postData = array(
         'sessionId' => $key_wsp  // Asegúrate de enviar los datos requeridos por la API
     );

     // Configurar cURL para hacer la solicitud POST
     curl_setopt($ch, CURLOPT_URL, $url_eliminar_full);
     curl_setopt($ch, CURLOPT_POST, true);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));  // Convertir el array PHP a JSON

     // Ejecutar la solicitud y obtener la respuesta
     $response = curl_exec($ch);

     // Verificar si hubo un error en la solicitud
     if(curl_errno($ch)) {
         echo 'Error en cURL: ' . curl_error($ch);
     }

     // Cerrar cURL
     curl_close($ch);

     // Convertir la respuesta JSON en un array de PHP
     $data = json_decode($response, true);



       $arrayName = array('noticia'=>'insert_correct','cliente'=> $numero_extra,'response_api'=> $data);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error','contenido_error' => mysqli_error($conection));
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }







 ?>
