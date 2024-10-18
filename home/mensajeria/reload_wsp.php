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

require('../librerias/PHPExcel-1.8/Classes/PHPExcel.php');

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
    $url_conect_wsp              =  $result_configuracion['url_wsp'];



    if ($_POST['action'] == 'iniciar_campana') {

      //CODIGO PARA INGRESAR EN CAMAPAÑA PARA SACAR EL ID Y CON ESE ID JUGAR
            $mensaje               = $_POST['descripcion'];
            $intervalo_tiempo      = $_POST['intervalo_tiempo'];

            $incluir_nombre      = (isset($_REQUEST['incluir_nombre'])) ? $_REQUEST['incluir_nombre'] : '';

            $query_insert_mensajes_masivos =mysqli_query($conection,"INSERT INTO mensajes_masivos_wsp (iduser,empresa,mensaje,intervalo_tiempo,estado,incluir_nombre)
                                VALUES('$iduser','$empresa','$mensaje','$intervalo_tiempo','Iniciado','$incluir_nombre') ");

          if ($query_insert_mensajes_masivos) {

            $query_mensajes_masivos = mysqli_query($conection, "SELECT * FROM mensajes_masivos_wsp
               WHERE mensajes_masivos_wsp.iduser ='$iduser'
               AND mensajes_masivos_wsp.estatus = '1'
               AND mensajes_masivos_wsp.empresa = '$empresa'
               ORDER BY mensajes_masivos_wsp.fecha DESC ");

            $data_mensajes_masivos = mysqli_fetch_array($query_mensajes_masivos);
            $id_mensajes_masivos    = $data_mensajes_masivos['id'];

            //echo "este es el id $id_mensajes_masivos";

            //CODIGO PARA CATEGORIAS
            $categoria          =  mysqli_real_escape_string($conection,$_POST['categoria']);
            $datos_categoria    = 0;

            if ($categoria != 'Ninguna') {
              $query_consulta_categoria = mysqli_query($conection, "SELECT usuarios_wsp.numero,usuarios_wsp.nombres,usuarios_wsp.email,
                categorias_wsp.nombre as 'categoria',categorias_wsp.descripcion as 'descripcion',usuarios_wsp.id FROM usuarios_wsp
                INNER JOIN categorias_wsp ON categorias_wsp.id = usuarios_wsp.categoria
                 WHERE usuarios_wsp.iduser ='$iduser'  AND usuarios_wsp.estatus = '1' AND usuarios_wsp.categoria = '$categoria'
              ORDER BY `usuarios_wsp`.`fecha` ASC ");

              $existencia_datos_categoria = mysqli_num_rows($query_consulta_categoria);

              if ($existencia_datos_categoria>0) {

                  while ($data_lista_categoria = mysqli_fetch_array($query_consulta_categoria)) {

                      $numero_categoria = $data_lista_categoria['numero'];
                      $nombres          = $data_lista_categoria['nombres'];

                    $query_insert_datos_mensajes_masivos =mysqli_query($conection,"INSERT INTO datos_mensajes_masivos (iduser,empresa,id_mensajes_masivos,numero,nombre,tipo)
                                              VALUES('$iduser','$empresa','$id_mensajes_masivos','$numero_categoria','$nombres','categoria') ");

                      if ($query_insert_datos_mensajes_masivos) {
                          $datos_categoria = $datos_categoria+1;
                      }

                }

              }

            }

            //CODIGO PARA QUE SE PUEDA ANALIZAR EL FORMATO EXCEL

            $datos_excel = 0 ;
            if (!empty($_FILES['usuarios_wsp']['name'])) {


              $usuarios_wsp           =    $_FILES['usuarios_wsp'];
              $nombre_usuarios_wsp    =    $usuarios_wsp['name'];
              $type 				          =    $usuarios_wsp['type'];
              $url_temp               =    $usuarios_wsp['tmp_name'];

              $extension = 'xlsx';

              $nombre_usuarios_wsp = 'excel_wsp'.md5(date('d-m-Y H:m:s').$iduser);
              $nombre_usuarios_wsp = $nombre_usuarios_wsp.'.'.$extension;

              $destino = '../librerias/';
              $src = $destino.$nombre_usuarios_wsp;
              move_uploaded_file($url_temp,$src);
              $archivos = '../librerias/'.$nombre_usuarios_wsp;

              $excel = PHPExcel_IOFactory::load($archivos);
              $excel -> setActiveSheetIndex(0);
              $numerofila = $excel ->setActiveSheetIndex(0)->getHighestRow();





              // Función que procesa una fila específica en la hoja de Excel
              function procesarFila($i) {
                  global $excel, $conection, $iduser, $empresa, $mensaje, $id_mensajes_masivos, $datos_excel;

                  // Obtener los valores de la fila
                  $numero = $excel->getActiveSheet(0)->getCell('A' . $i)->getCalculatedValue();
                  $nombres = $excel->getActiveSheet(0)->getCell('B' . $i)->getCalculatedValue();
                  $correo = $excel->getActiveSheet(0)->getCell('C' . $i)->getCalculatedValue();


                  // Insertar los datos en la base de datos
                  $query_insert_datos_mensajes_masivos = mysqli_query($conection, "INSERT INTO datos_mensajes_masivos (iduser, empresa, id_mensajes_masivos, numero, nombre, tipo)
                                              VALUES('$iduser', '$empresa',  '$id_mensajes_masivos', '$numero', '$nombres','Excel')");

                  if ($query_insert_datos_mensajes_masivos) {
                      // Incrementar el contador de filas procesadas
                      $datos_excel++;
                  }
              }





              $intervalos_excel = mysqli_real_escape_string($conection, $_POST['intervalos_excel']);

                    // Separar los intervalos por el delimitador ';'
                    $bloques = explode(';', $intervalos_excel);


                    foreach ($bloques as $bloque) {
                        // Eliminar espacios en blanco alrededor del bloque
                        $bloque = trim($bloque);

                        // Verificar si es un rango como '3-4'
                        if (strpos($bloque, '-') !== false) {
                            // Separar el inicio y fin del rango
                            list($inicio, $fin) = explode('-', $bloque);

                            // Asegurarse de que inicio y fin sean enteros y recorrer las filas dentro del rango
                            for ($i = (int)$inicio; $i <= (int)$fin; $i++) {
                                procesarFila($i); // Llamamos a la función para procesar la fila
                            }
                        } else {
                            // Si no es un rango, procesar un solo número de fila
                            $i = (int)$bloque;
                            procesarFila($i); // Llamamos a la función para procesar la fila
                        }
                    }




                  unlink($src);




            }

            //AHORA HAGAMOS DEL GRUPOS DE whatsapp


            $datos_grupos = 0;

            if (isset($_POST['selected_groups'])) {

              //PRIMERA API VERIFICAR LA SESION
              $ch = curl_init();
              $url_grupos = ''.$url_conect_wsp.'/get-groups';

              $postData = array(
                  'sessionId' => $key_user  // Asegúrate de enviar los datos requeridos por la API
              );

              // Configurar cURL para hacer la solicitud POST
              curl_setopt($ch, CURLOPT_URL, $url_grupos);
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
              $groups = json_decode($response, true);

              $selectedGroups = $_POST['selected_groups'];

                  // Recorrer cada grupo seleccionado
                  foreach ($selectedGroups as $groupId) {
                      // Verificar si el ID del grupo existe en $groups
                      if (isset($groups[$groupId])) {
                          $group = $groups[$groupId]; // Obtener el grupo correspondiente

                        //  echo "Grupo: " . htmlspecialchars($group['subject']) . "<br>";

                          // Recorrer los participantes del grupo
                          if (isset($group['participants'])) {
                              foreach ($group['participants'] as $participant) {
                              //    echo "ID del participante: " . htmlspecialchars($participant['id']) . "<br>";
                              //    echo "Rol de administración: " . htmlspecialchars($participant['admin']) . "<br>";

                                  $numero = $participant['id'];
                                  $numero = str_replace('@s.whatsapp.net', '', $numero);

                                  $query_insert_datos_mensajes_masivos = mysqli_query($conection, "INSERT INTO datos_mensajes_masivos (iduser, empresa,  id_mensajes_masivos, numero, tipo)
                                                              VALUES('$iduser', '$empresa',  '$id_mensajes_masivos', '$numero','grupos')");

                                  if ($query_insert_datos_mensajes_masivos) {
                                      $datos_grupos++;
                                    // code...
                                  }
                              }
                          } else {
                            //  echo "No hay participantes en este grupo.<br>";
                          }

                          //echo "<hr>";
                      } else {
                        //  echo "El grupo con ID $groupId no existe en los datos del JSON.<br>";
                      }
                  }



          }


          //CODIGO PARA SACAR EL NUMERO DE CONTACTOS SELECCIONADOS

          $datos_selected = 0;

          $selected_contacts = mysqli_real_escape_string($conection, $_POST['selected_contacts']);

          // Separar los contactos por coma
          $contactsArray = explode(',', $selected_contacts);

          // Recorrer el array de contactos y hacer lo que necesites con cada uno
          foreach ($contactsArray as $contact) {
              // Eliminar espacios en blanco alrededor de cada contacto (si los hay)
              $contact = trim($contact);
              $contact = str_replace('@s.whatsapp.net', '', $contact);

              // Aquí puedes hacer algo con el contacto, por ejemplo, mostrarlo o guardarlo en la base de datos
            //  echo "Procesando contacto: " . htmlspecialchars($contact) . "<br>";

              $query_insert_contact = mysqli_query($conection, "INSERT INTO datos_mensajes_masivos (iduser, empresa , id_mensajes_masivos, numero, tipo)
                                          VALUES('$iduser', '$empresa' , '$id_mensajes_masivos', '$contact' , 'numeros')");

              if ($query_insert_contact) {
                 $datos_selected++;
              }
          }

          $total_datos_subidos = $datos_selected + $datos_grupos + $datos_excel + $datos_categoria;

          if ($total_datos_subidos > 0) {


            //CONTAR LA CANTIDAD PARA QUE SE HAGA EL IF , ES DECIR CANTIDAD DE DATOS

            $query_cantidad_datos = mysqli_query($conection,"SELECT COUNT(*) as  cantidad_datos  FROM
            datos_mensajes_masivos WHERE datos_mensajes_masivos.id_mensajes_masivos  = '$id_mensajes_masivos'");

            $data_cantidad_datos = mysqli_fetch_array($query_cantidad_datos);
            $cantidad_datos = $data_cantidad_datos['cantidad_datos'];


            $arrayName = array('noticia' =>'procesar_datos','mensaje_masivo' =>$id_mensajes_masivos,'cantidad_datos' =>$cantidad_datos,'intervalo_tiempo' =>$intervalo_tiempo);
                        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            // code...
          }else {

            $arrayName = array('noticia' =>'no_procesar_no_datos','mensaje_masivo' =>$id_mensajes_masivos);
                        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            // code...
          }



            // code...
          }else {
            $arrayName = array('noticia' =>'error_isnertar_mensajes_masivos','contenido_error' => mysqli_error($conection));
                        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }








    }



 ?>
