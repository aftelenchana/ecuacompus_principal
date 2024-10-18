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

    }

    if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
    include "../sessiones/session_cuenta_usuario_venta.php";

    }


    $query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
    $result_configuracion = mysqli_fetch_array($query_configuracioin);
    $ambito_area          =  $result_configuracion['ambito'];
    $envio_wsp            =  $result_configuracion['envio_wsp'];
    $url_conect_wsp              =  $result_configuracion['url_wsp'];



    if ($_POST['action'] == 'enviar_mensaje') {

      $codigo_envio             = $_POST['codigo_envio'];


      //INFORMACION Y CONFIGURACION DEL ENVIO

      $query_configuraciones = mysqli_query($conection,"SELECT *  FROM mensajes_masivos_wsp
                              WHERE mensajes_masivos_wsp.id  = '$codigo_envio'");

      $data_configuraciones = mysqli_fetch_array($query_configuraciones);

      $mensaje          = $data_configuraciones['mensaje'];
      $incluir_nombre   = $data_configuraciones['incluir_nombre'];
      $key_wsp          = $data_configuraciones['key_wsp'];







      $query_mensajes_datos = mysqli_query($conection,"SELECT *  FROM datos_mensajes_masivos
                              WHERE datos_mensajes_masivos.id_mensajes_masivos  = '$codigo_envio'
                              AND datos_mensajes_masivos.estado != 'Procesado'");

      $data_mensajes_datos = mysqli_fetch_array($query_mensajes_datos);
      $numero = $data_mensajes_datos['numero'];
      $nombre = $data_mensajes_datos['nombre'];
      $id     = $data_mensajes_datos['id'];

      if ($incluir_nombre == 'on') {
        // Reemplazar '@name@' con el valor de la variable $nombre
        $mensaje = str_replace('@name@', $nombre, $mensaje);

      }

      // Separar el mensaje en palabras
          $palabras = explode(" ", $mensaje);

          // Recorrer cada palabra
          foreach ($palabras as &$palabra) {
              // Verificar si la palabra empieza y termina con #
              if (substr($palabra, 0, 1) == '#' && substr($palabra, -1) == '#') {
                  // Extraer el número dentro de los ##
                  $codigo_encontrado = substr($palabra, 1, -1);
                  
                  //echo "este es el codigo encontrado $codigo_encontrado";

                  // Realizar la consulta en la base de datos para ese número
                  $query_consulta = mysqli_query($conection, "SELECT texto FROM variables_globales WHERE estatus = '1' AND id = '$codigo_encontrado'");

                  if ($row = mysqli_fetch_assoc($query_consulta)) {
                      // Obtener el campo 'texto', separarlo por comas y elegir un elemento aleatorio
                      $opciones = explode(",", $row['texto']);
                      $texto_reemplazo = trim($opciones[array_rand($opciones)]); // Elegir un valor aleatorio

                      // Reemplazar el valor original entre ## con el texto aleatorio
                      $palabra = $texto_reemplazo;
                  }
              }
          }

        $mensaje = implode(" ", $palabras);


        //echo "$mensaje";
        //exit;


    //PRIMERA API VERIFICAR LA SESION
    $ch = curl_init();
    $url_sen_mensaje = ''.$url_conect_wsp.'/send-message';

    //echo "esta es la key $key_wsp";

    $postData = array(
        'sessionId' => $key_wsp,
        'to' => $numero,
        'message' => $mensaje

    );

    //var_dump($postData);
    //exit;

    // Configurar cURL para hacer la solicitud POST
    curl_setopt($ch, CURLOPT_URL, $url_sen_mensaje);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));  // Convertir el array PHP a JSON

    // Ejecutar la solicitud y obtener la respuesta
    $response = curl_exec($ch);

    //var_dump($response);

    // Verificar si hubo un error en la solicitud
    if(curl_errno($ch)) {
        echo 'Error en cURL: ' . curl_error($ch);
    } else {
        // Convertir la respuesta JSON en un array de PHP
        $data = json_decode($response, true);

        // Verificar si la clave "message" contiene el texto esperado
        if(isset($data['message']) && $data['message'] == 'Mensaje enviado correctamente.') {
            $estatus_mensaje = 'Enviado';
        } else {

          $estatus_mensaje = 'No Enviado';
          //  echo 'Error al enviar el mensaje: ' . (isset($data['message']) ? $data['message'] : 'Respuesta inesperada.');
        }
    }

    // Cerrar cURL
    curl_close($ch);





      $query_udate = mysqli_query($conection,"UPDATE datos_mensajes_masivos SET estado= 'Procesado',  estado_envio = '$estatus_mensaje' WHERE id='$id'  ");

      if ($query_udate) {

        //CONTAMOS LOS DATOS QUE FALTAN

        $query_cantidad_datos = mysqli_query($conection,"SELECT COUNT(*) as  cantidad_datos  FROM
        datos_mensajes_masivos WHERE datos_mensajes_masivos.id_mensajes_masivos  = '$codigo_envio'
        AND datos_mensajes_masivos.estado != 'Procesado'");

        $data_cantidad_datos = mysqli_fetch_array($query_cantidad_datos);
        $cantidad_datos_faltantes = $data_cantidad_datos['cantidad_datos'];



        $arrayName = array('noticia' =>'dato_procesado','numero' =>$numero,'codigo_envio' =>$codigo_envio,'cantidad_datos_faltantes' =>$cantidad_datos_faltantes
      ,'mensaje' =>$mensaje,'estatus_mensaje' =>$estatus_mensaje);
                    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

      }else {
        $arrayName = array('noticia' =>'error_isnertar_mensajes_masivos','contenido_error' => mysqli_error($conection));
                    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      }


    }



 ?>
