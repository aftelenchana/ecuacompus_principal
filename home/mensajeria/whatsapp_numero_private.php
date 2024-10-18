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
  mysqli_set_charset($conection, 'utf8mb4'); //linea a colocar



    if ($_SESSION['rol'] == 'cuenta_empresa') {
    include "../sessiones/session_cuenta_empresa.php";
    $empresa = 1;

    }

    if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
    include "../sessiones/session_cuenta_usuario_venta.php";

    }

    $query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
    $result_configuracion = mysqli_fetch_array($query_configuracioin);
    $ambito_area          =  $result_configuracion['ambito'];
    $envio_wsp            =  $result_configuracion['envio_wsp'];
    $url                  =  $result_configuracion['url_wsp'];


  if ($_POST['action'] == 'informacion_session') {

    $key_wsp_numero_private = $_POST['key_wsp_numero_private'];

    //PRIMERA API VERIFICAR LA SESION
    $ch = curl_init();

    $url_verificacion_session = ''.$url.'/check-session';

    $postData = array(
        'sessionId' => $key_wsp_numero_private  // Asegúrate de enviar los datos requeridos por la API
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

    //var_dump($response);

    // Convertir la respuesta JSON en un array de PHP
    $data = json_decode($response, true);

    // Verificar si la respuesta contiene un error
    if (isset($data['error']) && $data['error'] == 'Sesión no encontrada.') {
        $arrayName = array('noticia' => 'Sesión no encontrada.', 'accion' => 'init_session');
        echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
        exit;
    }

    if (isset($data['status']) && $data['status'] == 'inactiva') {
        $url_vie = ' '.$url.'/get-qr/'.$key_wsp_numero_private.'';
        $arrayName = array('noticia' => 'Inactiva', 'accion' => 'vizualisar_qr', 'url_vie' => $url_vie);
        echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
        exit;
    }

    if (isset($data['status']) && $data['status'] == 'activa') {
        $arrayName = array('noticia' => 'activa', 'accion' => 'quitar_el_login_ver_contactos');
        echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
        exit;
    }


  }


  if ($_POST['action'] == 'iniciar_session') {

    $key_wsp_numero_private = $_POST['key_wsp_numero_private'];

    //PRIMERA API VERIFICAR LA SESION
    $ch = curl_init();
    $url_iniciar_session = ''.$url.'/start-session';

    $postData = array(
        'sessionId' => $key_wsp_numero_private  // Asegúrate de enviar los datos requeridos por la API
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

    //var_dump($response);

    // Convertir la respuesta JSON en un array de PHP
    $data = json_decode($response, true);

    // Verificar si la respuesta contiene un error
    if ($data['success'] == true) {
      $arrayName = array('noticia' =>'Sesión no encontrada.','accion'=>'init_session');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }

    if ($data['success'] == true) {
      $arrayName = array('noticia' =>'Sesión no encontrada.','accion'=>'init_session');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }

  }



  if ($_POST['action'] == 'estado_session') {

    $key_wsp_numero_private = $_POST['key_wsp_numero_private'];

    //PRIMERA API VERIFICAR LA SESION
    $ch = curl_init();
    $url_check_session = ''.$url.'/check-session';

    $postData = array(
        'sessionId' => $key_wsp_numero_private  // Asegúrate de enviar los datos requeridos por la API
    );

    // Configurar cURL para hacer la solicitud POST
    curl_setopt($ch, CURLOPT_URL, $url_check_session);
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

    //var_dump($response);

    // Convertir la respuesta JSON en un array de PHP
    $data = json_decode($response, true);

    if (isset($data['status'])) {
      if ($data['status'] == 'activa') {
          $arrayName = array('noticia' => 'estado_activa', 'accion' => 'ninguna');
          echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
          exit;
      }

      if ($data['status'] == 'inactiva') {
          $arrayName = array('noticia' => 'estado_inactiva', 'accion' => 'ninguna');
          echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
          exit;
      }
  }



  }


  if ($_POST['action'] == 'sacar_contactos') {


    $key_wsp_numero_private = $_POST['key_wsp_numero_private'];

    //PRIMERA API VERIFICAR LA SESION
    $ch = curl_init();
    $url_contactos = ''.$url.'/get-contacts';

    $postData = array(
        'sessionId' => $key_wsp_numero_private  // Asegúrate de enviar los datos requeridos por la API
    );

    // Configurar cURL para hacer la solicitud POST
    curl_setopt($ch, CURLOPT_URL, $url_contactos);
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

    // Retornar los contactos como respuesta JSON
    if (isset($data) && is_array($data)) {
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'No se encontraron contactos.']);
    }



  }
 ?>
