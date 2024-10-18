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



    if ($_POST['action'] == 'iniciar_campana') {


      $mensaje             = $_POST['descripcion'];


      $numero_envio           = $_POST['numero_envio'];


      $urlsImagenes = ""; // String para guardar las URLs de las imágenes


          $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;



          // Verificar si hay archivos en la lista y que tengan tamaño mayor a cero
                if (isset($_FILES["lista"]) && is_array($_FILES["lista"]["name"]) && count($_FILES["lista"]["name"]) > 0) {
                    $cont = 0;
                    foreach ($_FILES["lista"]["name"] as $key => $value) {
                        // Verificar que el archivo tenga un tamaño mayor a cero
                        if ($_FILES["lista"]["size"][$key] > 0) {
                            // Procesar cada imagen...
                            $ext = explode('.', $value);
                            $renombrar = $cont . md5(date('d-m-Y H:m:s') . $iduser);
                            $nombre_final = $renombrar . "." . end($ext); // Usa end() para obtener la última parte del array

                            // Mover archivo y construir URL de la imagen
                            if (move_uploaded_file($_FILES["lista"]["tmp_name"][$key], "../img/uploads/" . $nombre_final)) {
                                $urlImagen = $url . '/home/img/uploads/' . $nombre_final;
                                $urlsImagenes .= $urlImagen . "\n";
                            }
                            $cont++;
                        }
                    }
                }


            // Concatenar las URLs de las imágenes con el mensaje, si hay imágenes
            if (!empty($urlsImagenes)) {
                $mensaje .= "\n" . $urlsImagenes;
            }


                          $url_envio_mensajes = ''.$url_conect_wsp.'/send-message ';

                          // Los datos que quieres enviar en formato JSON
                          $data = array(
                              'sessionId' => $key_user,
                              'to' => $numero_envio,
                              'message' => $mensaje
                          );
                          $data_json = json_encode($data);
                          // Inicializa cURL
                          $ch = curl_init($url_envio_mensajes);
                          // Configura las opciones de cURL para POST
                          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                          curl_setopt($ch, CURLOPT_POST, true);
                          curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
                          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                              'Content-Type: application/json',
                              'Content-Length: ' . strlen($data_json)
                          ));
                          // Ejecuta la sesión cURL
                          $response = curl_exec($ch);
                          // Verifica si hubo un error en la solicitud
                          if(curl_errno($ch)){
                              throw new Exception(curl_error($ch));
                          }
                          // Cierra la sesión cURL
                          curl_close($ch);
                          //var_dump($response);
                        // Decodifica la respuesta JSON y la imprime
                        $responseData = json_decode($response, true);


                        if (isset($responseData['message']) && $responseData['message'] === 'Mensaje enviado correctamente.') {
                          $query_insert_historial=mysqli_query($conection,"INSERT INTO envio_mensajes(iduser,producto,mensaje,numero_wsp)
                                                    VALUES('$iduser','5136','$mensaje','$numero_envio') ");

                          $arrayName = array('noticia' =>'mensajes_exitosos');
                         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                        }









    }



 ?>
