<!doctype html>

<html
  lang="en"
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

    <title>Recuperar Contraseña</title>

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

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/typeahead-js/typeahead.css" />
    <!-- Vendor -->
    <link rel="stylesheet" href="/assets/vendor/libs/@form-validation/form-validation.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="/assets/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="/assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/assets/js/config.js"></script>
    <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">
  </head>

  <body>
    <!-- Content -->

    <div class="authentication-wrapper authentication-cover">
      <style media="screen">
        .app-brand-logo img {
          width: 50px;
        }
      </style>
      <a href="/" class="auth-cover-brand d-flex align-items-center gap-2">
        <span class="app-brand-logo demo">
          <span style="color: var(--bs-primary)">
            <img src="/img/guibis.png" alt="">
          </span>
        </span>
        <span class="app-brand-text demo text-heading fw-semibold">Ecuacompus</span>
      </a>
      <!-- /Logo -->
      <div class="authentication-inner row m-0">
        <!-- /Left Section -->
        <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-12 pb-2">
          <img
            src="/assets/img/illustrations/auth-forgot-password-illustration-light.png"
            class="auth-cover-illustration w-100"
            alt="auth-illustration"
            data-app-light-img="illustrations/auth-forgot-password-illustration-light.png"
            data-app-dark-img="illustrations/auth-forgot-password-illustration-dark.png" />
          <img
            src="/assets/img/illustrations/auth-cover-forgot-password-mask-light.png"
            class="authentication-image"
            alt="mask"
            data-app-light-img="illustrations/auth-cover-forgot-password-mask-light.png"
            data-app-dark-img="illustrations/auth-cover-forgot-password-mask-dark.png" />
        </div>
        <!-- /Left Section -->

        <!-- Forgot Password -->
        <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-12 p-6">
          <div class="w-px-400 mx-auto">
            <h4 class="mb-1">Olvidaste tu contraseña? 🔒</h4>
            <p class="mb-5">Ingresa tu contraseña para que puedas cambiar tu contraseña</p>
            <form class="mb-5" method="post" name="add_form_password" id="add_form_password" onsubmit="event.preventDefault(); sendDatapassword();" >

              <div class="resultado_input_recuperar_contrasena">

                <div class="form-floating form-floating-outline mb-5">
                  <input
                  required
                    type="text"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="Ingresa tu email"
                    autofocus />
                  <label for="email">Email</label>
                </div>
              </div>
               <input type="hidden" name="action" id="action" value="primero_paso_recuperar_password">
              <button type="submit" class="btn btn-primary d-grid w-100">Enviar</button>
            </form>

            <style media="screen">
              .alert_recuperar_contrasena{
                text-align: center;
              }
            </style>
            <div class="alert_recuperar_contrasena">

            </div>
            <div class="text-center">
              <a href="login" class="d-flex align-items-center justify-content-center">
                <i class="ri-arrow-left-s-line scaleX-n1-rtl ri-20px me-1_5"></i>
                Regresar a entrar
              </a>
            </div>
          </div>
        </div>
        <!-- /Forgot Password -->
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
      <script src="java/recuperar_password.js?v=2"></script>
  </body>
</html>
