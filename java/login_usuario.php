<?php



echo "Hola mundo";

exit;
require("../home/mail/PHPMailer-master/src/PHPMailer.php");
require("../home/mail/PHPMailer-master/src/Exception.php");
require("../home/mail/PHPMailer-master/src/SMTP.php");
use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones
$mail = new  PHPMailer ( true );
require "../coneccion.php" ;
  mysqli_set_charset($conection, 'utf8'); //linea a colocar

  $query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
  $result_configuracion = mysqli_fetch_array($query_configuracioin);
  $ambito_area          =  $result_configuracion['ambito'];
    $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url = $protocol . $domain;



    $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url = $protocol . $domain;


    $query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  url_admin  = '$domain'");
    $result_documentos = mysqli_fetch_array($query_doccumentos);
    $regimen = $result_documentos['regimen'];
    $contabilidad             = $result_documentos['contabilidad'];
    $email_empresa_emisor     = $result_documentos['email'];
    $celular_empresa_emisor   = $result_documentos['celular'];
    $telefono_empresa_emisor  = $result_documentos['telefono'];
    $direccion_emisor          = $result_documentos['direccion'];
    $whatsapp                 = $result_documentos['whatsapp'];
    $nombres_user                  = $result_documentos['nombres'];
    $apellidos                = $result_documentos['apellidos'];
    $numero_identificacion_emisor  = $result_documentos['numero_identidad'];
    $contribuyente_especial   = $result_documentos['contribuyente_especial'];
    $estableciminento_f      = $result_documentos['estableciminento_f'];
    $contabilidad            = $result_documentos['contabilidad'];
    $punto_emision_f         = $result_documentos['punto_emision_f'];
    $img_facturacion         = $result_documentos['img_facturacion'];
    $contabilidad         = $result_documentos['contabilidad'];
    $regimen         = $result_documentos['regimen'];
    $url_img_upload                     = $result_documentos['url_img_upload'];

    $nombre_empresa               = $result_documentos['nombre_empresa'];

    $host_envio               = $result_documentos['host_envio'];
    $puerto_email_envio       = $result_documentos['puerto_email_envio'];
    $email_user_name_envio    = $result_documentos['email_user_name_envio'];
    $password_envio_email     = $result_documentos['password_envio_email'];
    $descripcion_envio_email  = $result_documentos['descripcion_envio_email'];
    $user_in  = $result_documentos['id'];



  function getRealIP(){
            if (isset($_SERVER["HTTP_CLIENT_IP"])){
                return $_SERVER["HTTP_CLIENT_IP"];
            }elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                return $_SERVER["HTTP_X_FORWARDED_FOR"];
            }elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
            {
                return $_SERVER["HTTP_X_FORWARDED"];
            }elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
            {
                return $_SERVER["HTTP_FORWARDED_FOR"];
            }elseif (isset($_SERVER["HTTP_FORWARDED"]))
            {
                return $_SERVER["HTTP_FORWARDED"];
            }
            else{
                return $_SERVER["REMOTE_ADDR"];
            }

        }
        if ($url =='http://localhost') {
          $direccion_ip =  '186.42.10.32';
        }else {
          $direccion_ip = (getRealIP());
        }

        $datos = unserialize(file_get_contents('http://ip-api.com/php/'.$direccion_ip.''));

         $pais            = $datos['country'];
         $ciudad            = $datos['city'];
         $provincia         = $datos['regionName'];



         $nombres    =  mb_strtoupper($_POST['nombres']);
         $identificacion    =  mb_strtoupper($_POST['identificacion']);

         $email      =  mb_strtoupper($_POST['mail_user']);



         $password1  =  md5($_POST['password1']);

  $query=mysqli_query($conection,"SELECT *FROM  usuarios WHERE email='$email'");
  $result = mysqli_fetch_array($query);
  if ($result > 0) {
    $arrayName = array('noticia' =>'cuenta_existente');
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }else {




     $codigo_registro = mb_strtoupper(md5($email.date('d-m-Y H:m:s')));
      $query_insert=mysqli_query($conection,"INSERT INTO usuarios(nombres,email,password,codigo_registro,pais,ciudad,provincia,ip,user_in,url_img_upload,numero_identidad)
                                                    VALUES('$nombres','$email','$password1','$codigo_registro','$pais','$ciudad','$provincia','$direccion_ip','$user_in','$url','$identificacion') ");


      if ($query_insert) {


        $query_correo_registro= mysqli_query($conection, "SELECT * FROM credenciales_correos  WHERE area = 'registro'");
        $data_correo_registro = mysqli_fetch_array($query_correo_registro);

        $Host_registro        = $data_correo_registro['Host'];
        $Username_registro    = $data_correo_registro['Username'];
        $Password_registro    = $data_correo_registro['Password'];
        $Port_registro        = $data_correo_registro['Port'];
        $SMTPSecure_registro  = $data_correo_registro['SMTPSecure'];


       try {
        $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
        $mail -> isSMTP ();                                          // Enviar usando SMTP
        $mail -> Host        = "$Host_registro" ;                  // Configure el servidor SMTP para enviar a través de
        $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
        $mail->Username = "$Username_registro";
        $mail->Password = "$Password_registro";                              // Contraseña SMTP
        $mail -> SMTPSecure = "$SMTPSecure_registro";         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
        $mail->Port = "$Port_registro";                            // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba
        // Destinatarios
        $mail -> setFrom ( $Username_registro , 'Ecuacompu' );
        $mail -> addAddress ($email);
        $mail -> addAddress($Username_registro);

        // Contenido
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8'; // Establecer el formato de correo electrónico en HTML
        $mail->Subject = 'Bienvenido/a a '.$nombre_empresa.' - Plataforma de Envíos Masivos de WhatsApp';
        $mail->Body = '
        <body style="background: #f5f5f5;padding: 6px;margin: 25px;">
            <div class="contenedor" style="background: #fff;padding: 20px;margin: 10px;">
                <div class="logo-empresa" style="text-align: center;">
                    <img src="https://ecuacompus.com/img/guibis.png" alt="https://ecuacompus.com/img/guibis.png" style="width: 200px;">
                </div>
                <div class="contenedor-informacion" style="text-align: justify;">
                    <p>¡Hola <span>' . $nombres . '</span>! Te damos una cálida bienvenida a <strong>'.$nombre_empresa.'</strong>, tu nueva plataforma para envíos masivos de mensajes a través de WhatsApp.</p>
                    <p>Nos alegra tenerte como parte de nuestra comunidad. Ahora podrás gestionar de forma eficiente tus campañas de mensajería masiva con nuestras herramientas avanzadas. Con nuestra plataforma, puedes:</p>
                    <ul>
                        <li><strong>Enviar Mensajes Masivos:</strong> Distribuye tus mensajes a cientos o miles de contactos con un solo clic.</li>
                        <li><strong>Programar Mensajes:</strong> Planifica envíos para que tus mensajes lleguen en el momento justo.</li>
                        <li><strong>Personalizar Mensajes:</strong> Agrega un toque personal a cada mensaje usando variables dinámicas para cada contacto.</li>
                        <li><strong>Obtener Reportes Detallados:</strong> Monitorea el rendimiento de tus campañas con informes y estadísticas en tiempo real.</li>
                    </ul>
                    <p>Para comenzar, por favor confirma tu dirección de correo electrónico y activa tu cuenta haciendo clic en el siguiente enlace:</p>
                    <p style="text-align: center;">
                        <a href="' . $url . '/login?codigo_registro=' . $codigo_registro . '" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block;">Confirmar mi Cuenta</a>
                    </p>
                    <p>Si tienes alguna pregunta o necesitas ayuda en cualquier momento, nuestro equipo de soporte está aquí para asistirte. Puedes contactarnos respondiendo a este correo o visitando nuestro centro de ayuda en línea.</p>
                    <p>¡Estamos emocionados de ayudarte a alcanzar a más personas de manera rápida y efectiva usando WhatsApp!</p>
                    <p>Con aprecio,<br>El Equipo de '.$nombre_empresa.'</p>
                </div>
            </div>
        </body>
        ';



                if (!$mail->send()) {
                    // Manejo del caso de fallo en el envío
                    $response = array('noticia_email' => 'error_envio','noticia' =>'cuenta_creaqda');
                    echo json_encode($response, JSON_UNESCAPED_UNICODE);
                } else {
                    // Manejo del caso de éxito en el envío
                    $response = array('noticia_email' => 'envio_exitoso','noticia' =>'cuenta_creaqda');
                    echo json_encode($response, JSON_UNESCAPED_UNICODE);
                }
            } catch (Exception $e) {
                // Manejo de una excepción durante la configuración o el envío
                $response = array('noticia_email' => 'error_excepcion','noticia' =>'cuenta_creaqda','detalle' => 'Ocurrió un error al intentar enviar el correo','error' => $e->getMessage());
                echo json_encode($response, JSON_UNESCAPED_UNICODE);
            }


      }else {
        $arrayName = array('noticia' =>'errror_servidor','error' =>mysqli_error($conection));
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

      }
  }





 ?>
