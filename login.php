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

    <title>Entrar a Ecuacompus</title>

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
        <span class="app-brand-logo demo">
          <span style="color: var(--bs-primary)">
            <svg width="268" height="150" viewBox="0 0 38 20" fill="none" xmlns="/img/guibis.png">


            </svg>
          </span>
        </span>
        <span class="app-brand-text demo text-heading fw-semibold">Ecuacompus</span>
      </a>
      <!-- /Logo -->
      <div class="authentication-inner row m-0">
        <!-- /Left Section -->
        <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-12 pb-2">
          <img
            src="/assets/img/illustrations/auth-login-illustration-light.png"
            class="auth-cover-illustration w-100"
            alt="auth-illustration"
            data-app-light-img="illustrations/auth-login-illustration-light.png"
            data-app-dark-img="illustrations/auth-login-illustration-dark.png" />
          <img
            src="/assets/img/illustrations/auth-cover-login-mask-light.png"
            class="authentication-image"
            alt="mask"
            data-app-light-img="illustrations/auth-cover-login-mask-light.png"
            data-app-dark-img="illustrations/auth-cover-login-mask-dark.png" />
        </div>
        <!-- /Left Section -->

        <!-- Login -->
        <div
          class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-12 px-12 py-6">
          <div class="w-px-400 mx-auto pt-5 pt-lg-0">
            <h4 class="mb-1">Bienvendio a Ecuacompus! 👋</h4>
            <p class="mb-5">Ingresa a tu cuenta e inicia tu aventura</p>

            <form id="" method="post" name="login_ecuacompus" id="login_ecuacompus" onsubmit="event.preventDefault(); sendData_login_ecuacompus();">
              <div class="form-floating form-floating-outline mb-5">
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  name="email-username"
                  placeholder="Ingresa tu Email"
                  autofocus />
                <label for="email">Email</label>
              </div>
              <div class="mb-5">
                <div class="form-password-toggle">
                  <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                      <input
                        type="password"
                        id="password"
                        class="form-control"
                        name="password"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="password" />
                      <label for="password">Contraseña</label>
                    </div>
                    <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                  </div>
                </div>
              </div>
              <div class="mb-5 d-flex justify-content-between mt-5">
                <div class="form-check mt-2">
                  <input class="form-check-input" type="checkbox" id="remember-me" />
                  <label class="form-check-label" for="remember-me">Recordar </label>
                </div>
                <a href="auth-forgot-password-cover.html" class="float-end mb-1 mt-2">
                  <span>Olvidaste tu contraseña ?</span>
                </a>
              </div>
              <button type="submit" class="btn btn-primary d-grid w-100">Entrar</button>
            </form>
            <style media="screen">
              .notificacion_login_ecuacompus{
                text-align: center;
              }
            </style>
            <div class="notificacion_login_ecuacompus">

            </div>

            <p class="text-center">
              <span>Eres nuevo en la plataforma?</span>
              <a href="auth-register-cover.html">
                <span>Crear una cuenta </span>
              </a>
            </p>

            <div class="divider my-5">
              <div class="divider-text">o</div>
            </div>

            <div class="d-flex justify-content-center gap-2">
              <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-facebook">
                <i class="tf-icons ri-facebook-fill"></i>
              </a>

              <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-twitter">
                <i class="tf-icons ri-twitter-fill"></i>
              </a>

              <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-github">
                <i class="tf-icons ri-github-fill"></i>
              </a>

              <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-google-plus">
                <i class="tf-icons ri-google-fill"></i>
              </a>
            </div>
          </div>
        </div>
        <!-- /Login -->
      </div>
    </div>


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
    <script src="java/login_usuario.js?v=5"></script>
  </body>
</html>
