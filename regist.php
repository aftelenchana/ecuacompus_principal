
<?php
// Iniciar la salida en buffer
ob_start();

// Incluir la conexión a la base de datos
require "coneccion.php";

// Establecer el conjunto de caracteres a UTF-8 mb4
mysqli_set_charset($conection, 'utf8mb4');

// Iniciar la sesión
session_start();

// Redirigir si la sesión está activa
if (!empty($_SESSION['active'])) {
    header('location:home/');
    exit(); // Siempre es recomendable usar exit después de un redireccionamiento
}

// Obtener el protocolo y el dominio
$protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
$domain = $_SERVER['HTTP_HOST'];

// Consultar la base de datos para obtener los documentos relacionados con el dominio
$query_documentos = mysqli_query($conection, "SELECT * FROM usuarios WHERE url_admin = '$domain'");
$result_documentos = mysqli_fetch_array($query_documentos);

// Comprobar si se encontraron documentos y asignar las variables correspondientes
if ($result_documentos) {
    $url_img_upload = $result_documentos['url_img_upload'];
    $img_facturacion = $result_documentos['img_facturacion'];
    $nombre_empresa = $result_documentos['nombre_empresa'];
    $celular = $result_documentos['celular'];
    $email = $result_documentos['email'];
    $facebook = $result_documentos['facebook'];
    $instagram = $result_documentos['instagram'];
    $whatsapp = $result_documentos['whatsapp'];

    // Ruta de la imagen de facturación
    $img_sistema = $url_img_upload . '/home/img/uploads/' . $img_facturacion;
} else {
    // Si no se encuentra un documento, se asigna una imagen por defecto
    $img_sistema = '/img/guibis.png';
}

// Finalizar el buffer de salida
ob_end_flush();
?>


<!doctype html>

<html
  lang="es"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="/assets/"
  data-template="vertical-menu-template"
  data-style="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Registrarme</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/img/guibis.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
      rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="/assets/vendor/fonts/remixicon/remixicon.css" />
    <link rel="stylesheet" href="/assets/vendor/fonts/flag-icons.css" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="/assets/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/assets/css/demo.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/@form-validation/form-validation.css" />
    <link rel="stylesheet" href="/assets/vendor/css/pages/page-auth.css" />
    <script src="/assets/vendor/js/helpers.js"></script>
    <script src="/assets/vendor/js/template-customizer.js"></script>
    <script src="/assets/js/config.js"></script>
    <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">
  </head>

  <body>
    <!-- Content -->

    <div class="authentication-wrapper authentication-cover">
      <!-- Logo -->
      <a href="/" class="auth-cover-brand d-flex align-items-center gap-2">
        <style media="screen">
          .app-brand-logo img {
            width: 50px;
          }
        </style>
        <span class="app-brand-logo demo">
          <span style="color: var(--bs-primary)">
            <img src="/img/guibis.png" alt="">

          </span>
        </span>
        <span class="app-brand-text demo text-heading fw-semibold">Ecuacompus</span>
      </a>
      <!-- /Logo -->
      <div class="authentication-inner row m-0">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-12 pb-2">
          <img
            src="/assets/img/illustrations/auth-register-illustration-light.png"
            class="auth-cover-illustration w-100"
            alt="auth-illustration"
            data-app-light-img="illustrations/auth-register-illustration-light.png"
            data-app-dark-img="illustrations/auth-register-illustration-dark.png" />
          <img
            src="/assets/img/illustrations/auth-cover-register-mask-light.png"
            class="authentication-image"
            alt="mask"
            data-app-light-img="illustrations/auth-cover-register-mask-light.png"
            data-app-dark-img="illustrations/auth-cover-register-mask-dark.png" />
        </div>
        <!-- /Left Text -->

        <!-- Register -->
        <div
          class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-12 px-12 py-6">
          <div class="w-px-400 mx-auto pt-5 pt-lg-0">
            <h4 class="mb-1">Tu aventura Empieza aqui 🚀</h4>
            <p class="mb-5">Crea una cuenta para que puedas acceder al sistema!</p>

            <form method="post" name="registrar_usuario_at" id="registrar_usuario_at"   onsubmit="event.preventDefault(); sendData_registrar_usuario_at();">
              <div class="form-floating form-floating-outline mb-5">
                <input
                  type="text"
                  class="form-control"
                  id="username"
                  name="nombres"
                  placeholder="Ingresa tus nombres"
                  autofocus />
                <label for="username">Nombres</label>
              </div>
              <div class="form-floating form-floating-outline mb-5">
                <input type="text" required class="form-control" id="email" name="mail_user" placeholder="Ingresa tu email" />
                <label for="email">Email</label>
              </div>
              <div class="mb-5 form-password-toggle">
                <div class="input-group input-group-merge">
                  <div class="form-floating form-floating-outline">
                    <input required
                      type="password"
                      id="password"
                      class="form-control"
                      name="password1"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password" />
                    <label for="password">Contraseña</label>
                  </div>
                  <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                </div>
              </div>
              <div class="mb-5">
                <div class="form-check mt-2">
                  <input required class="form-check-input" type="checkbox" id="terms-conditions" name="terms" />
                  <label class="form-check-label" for="terms-conditions">
                    Yo acepto
                    <a href="javascript:void(0);">los términos y condiciones</a>
                  </label>
                </div>
              </div>
              <button type="submit" class="btn btn-primary d-grid w-100">Registrame</button>
            </form>

            <style media="screen">
              .alerta_registro_usuario_ast{
                text-align: center;
              }
            </style>
            <div class="alerta_registro_usuario_ast">

            </div>

            <p class="text-center">
              <span>Ya tienes una cuenta?</span>
              <a href="login">
                <span>Ingresa aquí</span>
              </a>
            </p>

          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/assets/vendor/libs/popper/popper.js"></script>
    <script src="/assets/vendor/js/bootstrap.js"></script>
    <script src="/assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="/assets/vendor/libs/i18n/i18n.js"></script>
    <script src="/assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="/assets/vendor/js/menu.js"></script>
    <script src="/assets/vendor/libs/@form-validation/popular.js"></script>
    <script src="/assets/vendor/libs/@form-validation/bootstrap5.js"></script>
    <script src="/assets/vendor/libs/@form-validation/auto-focus.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/pages-auth.js"></script>
    <script src="java/registrar_usuario.js?v=6"></script>
  </body>
</html>
