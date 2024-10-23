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

    $query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
    $result_configuracion = mysqli_fetch_array($query_configuracioin);
    $ambito_area          =  $result_configuracion['ambito'];
    $envio_wsp            =  $result_configuracion['envio_wsp'];
    $url              =  $result_configuracion['url_wsp'];


    if ($_POST['action'] == 'consultar_datos') {

      $query_consulta = mysqli_query($conection, "SELECT * FROM servidores_wsp
         WHERE   servidores_wsp.estatus = '1'
      ORDER BY `servidores_wsp`.`fecha` DESC ");

      $data = array();
      while ($row = mysqli_fetch_assoc($query_consulta)) {
          // Código para sacar la información de cada número extra según el ID
          $url_server = $row['url'];

        $ch = curl_init();

        $url_verificacion_session = $url_server . '/check-session';
        $postData = array(
            'sessionId2' => 'hola mundo'  // Asegúrate de enviar los datos requeridos por la API
        );

        // Configurar cURL para hacer la solicitud POST
        curl_setopt($ch, CURLOPT_URL, $url_verificacion_session);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));  // Convertir el array PHP a JSON

        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if(curl_errno($ch)) {
            $estado_api = 'Error en cURL: ' . curl_error($ch);
            $row['mensaje'] = $estado_api;
            $row['estado'] = 'No Disponible';
            $row['http_code'] = '404';
        } else {
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $row['http_code'] = $http_code;
            // Verifica si json_decode devolvió null y si hubo un error en la conversión
            if (json_last_error() === JSON_ERROR_NONE) {


                $data_api = json_decode($response, true);


                // La respuesta es un JSON válido
                if (isset($data_api['error']) && $data_api['error'] === 'El sessionId es requerido.') {
                    $row['estado'] = 'Disponible';
                    $row['mensaje'] = 'Servidor Disponible';
                    // Aquí puedes agregar más código si es necesario
                } else {

                  if ($row['http_code'] == 400) {
                    $row['estado'] = 'Disponible';
                    $row['mensaje'] = 'Servidor Disponible';
                    // code...
                  }else {
                    $row['estado'] = 'No Disponible';
                    $row['mensaje'] = 'Servidor no disponible Servidor Caido';
                    // code...
                  }

                }
            } else {

              if ($row['http_code'] == 400) {
                $row['estado'] = 'Disponible';
                $row['mensaje'] = 'Servidor Disponible';
                // code...
              }else {
                // Maneja el caso donde la respuesta no es un JSON válido
                $row['mensaje'] = 'Error: Respuesta no válida';
                $row['estado'] = 'No Disponible';
                $row['mensaje'] = 'Servidor no  creado.';
                // code...
              }

            }

        }

        // Cerrar cURL
        curl_close($ch);


          // Agregar el array modificado a $data
          $data[] = $row;
      }


   echo json_encode(array("data" => $data));
      // code...
    }



 if ($_POST['action'] == 'agregar_servidor_wsp') {


           $nombre_servidor    = $_POST['nombre_servidor'];
           $url_servidor       = $_POST['url_servidor'];
           $tipo_servidor      = $_POST['tipo_servidor'];

           $rol_sistem      = $_POST['rol_sistem'];


   $query_insert=mysqli_query($conection,"INSERT INTO servidores_wsp (nombre,url,tipo,rol)
                                 VALUES('$nombre_servidor','$url_servidor','$tipo_servidor','$rol_sistem') ");

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


   $query_delete=mysqli_query($conection,"UPDATE servidores_wsp SET estatus= 0  WHERE id='$numero_extra' ");

   if ($query_delete) {


       $arrayName = array('noticia'=>'insert_correct','cliente'=> $numero_extra);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error','contenido_error' => mysqli_error($conection));
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }







 ?>
