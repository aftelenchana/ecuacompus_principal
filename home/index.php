<?php
ob_start();
include "../coneccion.php";
mysqli_set_charset($conection, 'utf8mb4'); //linea a colocar
session_start();


if (empty($_SESSION['active'])) {
    header('location:/');
} else {
    // Asumimos que la sesión está activa y tenemos la información del dominio
    $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
    $domain = $_SERVER['HTTP_HOST'];

    $query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  url_admin  = '$domain'");
    $result_documentos = mysqli_fetch_array($query_doccumentos);

    if ($result_documentos) {
        $url_img_upload = $result_documentos['url_img_upload'];
        $img_facturacion = $result_documentos['img_facturacion'];

        // Asegúrate de que esta ruta sea correcta y corresponda con la estructura de tu sistema de archivos
        $img_sistema = $url_img_upload.'/home/img/uploads/'.$img_facturacion;
    } else {
        // Si no hay resultados, tal vez quieras definir una imagen por defecto
      $img_sistema = '/img/guibis.png';
    }
}

?>

<!doctype html>

<html
  lang="en"
  class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
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

    <title>Home</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/img/guibis.com" />

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
    <link rel="stylesheet" href="/assets/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/swiper/swiper.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="/assets/vendor/css/pages/cards-statistics.css" />
    <link rel="stylesheet" href="/assets/vendor/css/pages/cards-analytics.css" />

    <!-- Helpers -->
    <script src="/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="/assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">



             <?php
            require 'scripts/menu.php';

             ?>
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                <i class="ri-menu-fill ri-22px"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item navbar-search-wrapper mb-0">
                  <a class="nav-item nav-link search-toggler fw-normal px-0" href="javascript:void(0);">
                    <i class="ri-search-line ri-22px scaleX-n1-rtl me-3"></i>
                    <span class="d-none d-md-inline-block text-muted">Buscar</span>
                  </a>
                </div>
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Language -->
                <li class="nav-item dropdown-language dropdown">
                  <a
                    class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <i class="ri-translate-2 ri-22px"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);" data-language="en" data-text-direction="ltr">
                        <span class="align-middle">English</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);" data-language="fr" data-text-direction="ltr">
                        <span class="align-middle">French</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);" data-language="ar" data-text-direction="rtl">
                        <span class="align-middle">Arabic</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);" data-language="de" data-text-direction="ltr">
                        <span class="align-middle">German</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ Language -->

                <!-- Style Switcher -->
                <li class="nav-item dropdown-style-switcher dropdown me-1 me-xl-0">
                  <a
                    class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <i class="ri-22px"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                        <span class="align-middle"><i class="ri-sun-line ri-22px me-3"></i>Light</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                        <span class="align-middle"><i class="ri-moon-clear-line ri-22px me-3"></i>Dark</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                        <span class="align-middle"><i class="ri-computer-line ri-22px me-3"></i>System</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!-- / Style Switcher-->

                <!-- Quick links  -->
                <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-1 me-xl-0">
                  <a
                    class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    aria-expanded="false">
                    <i class="ri-star-smile-line ri-22px"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end py-0">
                    <div class="dropdown-menu-header border-bottom py-50">
                      <div class="dropdown-header d-flex align-items-center py-2">
                        <h6 class="mb-0 me-auto">Shortcuts</h6>
                        <a
                          href="javascript:void(0)"
                          class="btn btn-text-secondary rounded-pill btn-icon dropdown-shortcuts-add text-heading"
                          data-bs-toggle="tooltip"
                          data-bs-placement="top"
                          title="Add shortcuts"
                          ><i class="ri-add-line ri-24px"></i
                        ></a>
                      </div>
                    </div>
                    <div class="dropdown-shortcuts-list scrollable-container">
                      <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="ri-calendar-line ri-26px text-heading"></i>
                          </span>
                          <a href="app-calendar.html" class="stretched-link">Calendar</a>
                          <small class="mb-0">Appointments</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="ri-file-text-line ri-26px text-heading"></i>
                          </span>
                          <a href="app-invoice-list.html" class="stretched-link">Invoice App</a>
                          <small class="mb-0">Manage Accounts</small>
                        </div>
                      </div>
                      <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="ri-user-line ri-26px text-heading"></i>
                          </span>
                          <a href="app-user-list.html" class="stretched-link">User App</a>
                          <small class="mb-0">Manage Users</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="ri-computer-line ri-26px text-heading"></i>
                          </span>
                          <a href="app-access-roles.html" class="stretched-link">Role Management</a>
                          <small class="mb-0">Permission</small>
                        </div>
                      </div>
                      <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="ri-pie-chart-2-line ri-26px text-heading"></i>
                          </span>
                          <a href="index.html" class="stretched-link">Dashboard</a>
                          <small class="mb-0">Analytics</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="ri-settings-4-line ri-26px text-heading"></i>
                          </span>
                          <a href="pages-account-settings-account.html" class="stretched-link">Setting</a>
                          <small class="mb-0">Account Settings</small>
                        </div>
                      </div>
                      <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="ri-question-line ri-26px text-heading"></i>
                          </span>
                          <a href="pages-faq.html" class="stretched-link">FAQs</a>
                          <small class="mb-0">FAQs & Articles</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="ri-tv-2-line ri-26px text-heading"></i>
                          </span>
                          <a href="modal-examples.html" class="stretched-link">Modals</a>
                          <small class="mb-0">Useful Popups</small>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <!-- Quick links -->

                <!-- Notification -->
                <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-4 me-xl-1">
                  <a
                    class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    aria-expanded="false">
                    <i class="ri-notification-2-line ri-22px"></i>
                    <span
                      class="position-absolute top-0 start-50 translate-middle-y badge badge-dot bg-danger mt-2 border"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end py-0">
                    <li class="dropdown-menu-header border-bottom py-50">
                      <div class="dropdown-header d-flex align-items-center py-2">
                        <h6 class="mb-0 me-auto">Notification</h6>
                        <div class="d-flex align-items-center">
                          <span class="badge rounded-pill bg-label-primary fs-xsmall me-2">8 New</span>
                          <a
                            href="javascript:void(0)"
                            class="btn btn-text-secondary rounded-pill btn-icon dropdown-notifications-all"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="Mark all as read"
                            ><i class="ri-mail-open-line text-heading ri-20px"></i
                          ></a>
                        </div>
                      </div>
                    </li>
                    <li class="dropdown-notifications-list scrollable-container">
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar">
                                <img src="/assets/img/avatars/1.png" alt class="rounded-circle" />
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="small mb-1">Congratulation Lettie 🎉</h6>
                              <small class="mb-1 d-block text-body">Won the monthly best seller gold badge</small>
                              <small class="text-muted">1h ago</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                              <a href="javascript:void(0)" class="dropdown-notifications-read"
                                ><span class="badge badge-dot"></span
                              ></a>
                              <a href="javascript:void(0)" class="dropdown-notifications-archive"
                                ><span class="ri-close-line ri-20px"></span
                              ></a>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar">
                                <span class="avatar-initial rounded-circle bg-label-danger">CF</span>
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="mb-1 small">Charles Franklin</h6>
                              <small class="mb-1 d-block text-body">Accepted your connection</small>
                              <small class="text-muted">12hr ago</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                              <a href="javascript:void(0)" class="dropdown-notifications-read"
                                ><span class="badge badge-dot"></span
                              ></a>
                              <a href="javascript:void(0)" class="dropdown-notifications-archive"
                                ><span class="ri-close-line ri-20px"></span
                              ></a>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar">
                                <img src="/assets/img/avatars/2.png" alt class="rounded-circle" />
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="mb-1 small">New Message ✉️</h6>
                              <small class="mb-1 d-block text-body">You have new message from Natalie</small>
                              <small class="text-muted">1h ago</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                              <a href="javascript:void(0)" class="dropdown-notifications-read"
                                ><span class="badge badge-dot"></span
                              ></a>
                              <a href="javascript:void(0)" class="dropdown-notifications-archive"
                                ><span class="ri-close-line ri-20px"></span
                              ></a>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar">
                                <span class="avatar-initial rounded-circle bg-label-success"
                                  ><i class="ri-shopping-cart-2-line"></i
                                ></span>
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="mb-1 small">Whoo! You have new order 🛒</h6>
                              <small class="mb-1 d-block text-body">ACME Inc. made new order $1,154</small>
                              <small class="text-muted">1 day ago</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                              <a href="javascript:void(0)" class="dropdown-notifications-read"
                                ><span class="badge badge-dot"></span
                              ></a>
                              <a href="javascript:void(0)" class="dropdown-notifications-archive"
                                ><span class="ri-close-line ri-20px"></span
                              ></a>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar">
                                <img src="/assets/img/avatars/9.png" alt class="rounded-circle" />
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="mb-1 small">Application has been approved 🚀</h6>
                              <small class="mb-1 d-block text-body"
                                >Your ABC project application has been approved.</small
                              >
                              <small class="text-muted">2 days ago</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                              <a href="javascript:void(0)" class="dropdown-notifications-read"
                                ><span class="badge badge-dot"></span
                              ></a>
                              <a href="javascript:void(0)" class="dropdown-notifications-archive"
                                ><span class="ri-close-line ri-20px"></span
                              ></a>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar">
                                <span class="avatar-initial rounded-circle bg-label-success"
                                  ><i class="ri-pie-chart-2-line"></i
                                ></span>
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="mb-1 small">Monthly report is generated</h6>
                              <small class="mb-1 d-block text-body">July monthly financial report is generated </small>
                              <small class="text-muted">3 days ago</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                              <a href="javascript:void(0)" class="dropdown-notifications-read"
                                ><span class="badge badge-dot"></span
                              ></a>
                              <a href="javascript:void(0)" class="dropdown-notifications-archive"
                                ><span class="ri-close-line ri-20px"></span
                              ></a>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar">
                                <img src="/assets/img/avatars/5.png" alt class="rounded-circle" />
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="mb-1 small">Send connection request</h6>
                              <small class="mb-1 d-block text-body">Peter sent you connection request</small>
                              <small class="text-muted">4 days ago</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                              <a href="javascript:void(0)" class="dropdown-notifications-read"
                                ><span class="badge badge-dot"></span
                              ></a>
                              <a href="javascript:void(0)" class="dropdown-notifications-archive"
                                ><span class="ri-close-line ri-20px"></span
                              ></a>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar">
                                <img src="/assets/img/avatars/6.png" alt class="rounded-circle" />
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="mb-1 small">New message from Jane</h6>
                              <small class="mb-1 d-block text-body">Your have new message from Jane</small>
                              <small class="text-muted">5 days ago</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                              <a href="javascript:void(0)" class="dropdown-notifications-read"
                                ><span class="badge badge-dot"></span
                              ></a>
                              <a href="javascript:void(0)" class="dropdown-notifications-archive"
                                ><span class="ri-close-line ri-20px"></span
                              ></a>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar">
                                <span class="avatar-initial rounded-circle bg-label-warning"
                                  ><i class="ri-error-warning-line"></i
                                ></span>
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="mb-1 small">CPU is running high</h6>
                              <small class="mb-1 d-block text-body"
                                >CPU Utilization Percent is currently at 88.63%,</small
                              >
                              <small class="text-muted">5 days ago</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                              <a href="javascript:void(0)" class="dropdown-notifications-read"
                                ><span class="badge badge-dot"></span
                              ></a>
                              <a href="javascript:void(0)" class="dropdown-notifications-archive"
                                ><span class="ri-close-line ri-20px"></span
                              ></a>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </li>
                    <li class="border-top">
                      <div class="d-grid p-4">
                        <a class="btn btn-primary btn-sm d-flex" href="javascript:void(0);">
                          <small class="align-middle">View all notifications</small>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
                <!--/ Notification -->

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="/assets/img/avatars/1.png" alt class="rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="pages-account-settings-account.html">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-2">
                            <div class="avatar avatar-online">
                              <img src="/assets/img/avatars/1.png" alt class="rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-medium d-block small">John Doe</span>
                            <small class="text-muted">Admin</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="pages-profile-user.html">
                        <i class="ri-user-3-line ri-22px me-3"></i><span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="pages-account-settings-account.html">
                        <i class="ri-settings-4-line ri-22px me-3"></i><span class="align-middle">Settings</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="pages-account-settings-billing.html">
                        <span class="d-flex align-items-center align-middle">
                          <i class="flex-shrink-0 ri-file-text-line ri-22px me-3"></i>
                          <span class="flex-grow-1 align-middle">Billing</span>
                          <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger">4</span>
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="pages-pricing.html">
                        <i class="ri-money-dollar-circle-line ri-22px me-3"></i
                        ><span class="align-middle">Pricing</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="pages-faq.html">
                        <i class="ri-question-line ri-22px me-3"></i><span class="align-middle">FAQ</span>
                      </a>
                    </li>
                    <li>
                      <div class="d-grid px-4 pt-2 pb-1">
                        <a class="btn btn-sm btn-danger d-flex" href="auth-login-cover.html" target="_blank">
                          <small class="align-middle">Logout</small>
                          <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>

            <!-- Search Small Screens -->
            <div class="navbar-search-wrapper search-input-wrapper d-none">
              <input
                type="text"
                class="form-control search-input container-xxl border-0"
                placeholder="Search..."
                aria-label="Search..." />
              <i class="ri-close-fill search-toggler cursor-pointer"></i>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row g-6">
                <!-- Gamification Card -->
                <div class="col-md-12 col-xxl-8">
                  <div class="card">
                    <div class="d-flex align-items-end row">
                      <div class="col-md-6 order-2 order-md-1">
                        <div class="card-body">
                          <h4 class="card-title mb-4">Congratulations <span class="fw-bold">John!</span> 🎉</h4>
                          <p class="mb-0">You have done 68% 😎 more sales today.</p>
                          <p>Check your new badge in your profile.</p>
                          <a href="javascript:;" class="btn btn-primary">View Profile</a>
                        </div>
                      </div>
                      <div class="col-md-6 text-center text-md-end order-1 order-md-2">
                        <div class="card-body pb-0 px-0 pt-2">
                          <img
                            src="/assets/img/illustrations/illustration-john-light.png"
                            height="186"
                            class="scaleX-n1-rtl"
                            alt="View Profile"
                            data-app-light-img="illustrations/illustration-john-light.png"
                            data-app-dark-img="illustrations/illustration-john-dark.png" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--/ Gamification Card -->

                <!-- Statistics Total Order -->
                <div class="col-xxl-2 col-sm-6">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                        <div class="avatar">
                          <div class="avatar-initial bg-label-primary rounded-3">
                            <i class="ri-shopping-cart-2-line ri-24px"></i>
                          </div>
                        </div>
                        <div class="d-flex align-items-center">
                          <p class="mb-0 text-success me-1">+22%</p>
                          <i class="ri-arrow-up-s-line text-success"></i>
                        </div>
                      </div>
                      <div class="card-info mt-5">
                        <h5 class="mb-1">155k</h5>
                        <p>Total Orders</p>
                        <div class="badge bg-label-secondary rounded-pill">Last 4 Month</div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--/ Statistics Total Order -->

                <!-- Sessions line chart -->
                <div class="col-xxl-2 col-sm-6">
                  <div class="card h-100">
                    <div class="card-header pb-0">
                      <div class="d-flex align-items-center mb-1 flex-wrap">
                        <h5 class="mb-0 me-1">$38.5k</h5>
                        <p class="mb-0 text-success">+62%</p>
                      </div>
                      <span class="d-block card-subtitle">Sessions</span>
                    </div>
                    <div class="card-body">
                      <div id="sessions"></div>
                    </div>
                  </div>
                </div>
                <!--/ Sessions line chart -->

                <!-- Total Transactions & Report Chart -->
                <div class="col-12 col-xxl-8">
                  <div class="card h-100">
                    <div class="row row-bordered g-0 h-100">
                      <div class="col-md-7 col-12 order-2 order-md-0">
                        <div class="card-header">
                          <h5 class="mb-0">Total Transactions</h5>
                        </div>
                        <div class="card-body">
                          <div id="totalTransactionChart"></div>
                        </div>
                      </div>
                      <div class="col-md-5 col-12">
                        <div class="card-header">
                          <div class="d-flex justify-content-between">
                            <h5 class="mb-1">Report</h5>
                            <div class="dropdown">
                              <button
                                class="btn btn-text-secondary rounded-pill text-muted border-0 p-1"
                                type="button"
                                id="totalTransaction"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                <i class="ri-more-2-line ri-20px"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalTransaction">
                                <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                <a class="dropdown-item" href="javascript:void(0);">Share</a>
                                <a class="dropdown-item" href="javascript:void(0);">Update</a>
                              </div>
                            </div>
                          </div>
                          <p class="mb-0 card-subtitle">Last month transactions $234.40k</p>
                        </div>
                        <div class="card-body pt-6">
                          <div class="row">
                            <div class="col-6 border-end">
                              <div class="d-flex flex-column align-items-center">
                                <div class="avatar">
                                  <div class="avatar-initial bg-label-success rounded-3">
                                    <div class="ri-pie-chart-2-line ri-24px"></div>
                                  </div>
                                </div>
                                <p class="mt-3 mb-1">This Week</p>
                                <h6 class="mb-0">+82.45%</h6>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="d-flex flex-column align-items-center">
                                <div class="avatar">
                                  <div class="avatar-initial bg-label-primary rounded-3">
                                    <div class="ri-money-dollar-circle-line ri-24px"></div>
                                  </div>
                                </div>
                                <p class="mt-3 mb-1">This Week</p>
                                <h6 class="mb-0">-24.86%</h6>
                              </div>
                            </div>
                          </div>
                          <hr class="my-5" />
                          <div class="d-flex justify-content-around align-items-center flex-wrap gap-2">
                            <div>
                              <p class="mb-1">Performance</p>
                              <h6 class="mb-0">+94.15%</h6>
                            </div>
                            <div>
                              <button class="btn btn-primary" type="button">view report</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--/ Total Transactions & Report Chart -->

                <!-- Performance Chart -->
                <div class="col-12 col-xxl-4 col-md-6">
                  <div class="card h-100">
                    <div class="card-header">
                      <div class="d-flex justify-content-between">
                        <h5 class="mb-1">Performance</h5>
                        <div class="dropdown">
                          <button
                            class="btn btn-text-secondary rounded-pill text-muted border-0 p-1"
                            type="button"
                            id="performanceDropdown"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <i class="ri-more-2-line ri-20px"></i>
                          </button>
                          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="performanceDropdown">
                            <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                      <div id="performanceChart"></div>
                    </div>
                  </div>
                </div>
                <!--/ Performance Chart -->

                <!-- Project Statistics -->
                <div class="col-md-6 col-xxl-4">
                  <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="card-title m-0 me-2">Project Statistics</h5>
                      <div class="dropdown">
                        <button
                          class="btn btn-text-secondary rounded-pill text-muted border-0 p-1"
                          type="button"
                          id="projectStatus"
                          data-bs-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false">
                          <i class="ri-more-2-line ri-20px"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectStatus">
                          <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                          <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                          <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex justify-content-between p-4 border-bottom">
                      <p class="mb-0 fs-xsmall">NAME</p>
                      <p class="mb-0 fs-xsmall">BUDGET</p>
                    </div>
                    <div class="card-body">
                      <ul class="p-0 m-0">
                        <li class="d-flex align-items-center mb-6">
                          <div class="avatar avatar-md flex-shrink-0 me-4">
                            <div class="avatar-initial bg-light-gray rounded-3">
                              <div>
                                <img src="/assets/img/icons/misc/3d-illustration.png" alt="User" class="h-25" />
                              </div>
                            </div>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-1">3D Illustration</h6>
                              <small>Blender Illustration</small>
                            </div>
                            <div class="badge bg-label-primary rounded-pill">$6,500</div>
                          </div>
                        </li>
                        <li class="d-flex align-items-center mb-6">
                          <div class="avatar avatar-md flex-shrink-0 me-4">
                            <div class="avatar-initial bg-light-gray rounded-3">
                              <div>
                                <img src="/assets/img/icons/misc/finance-app-design.png" alt="User" class="h-25" />
                              </div>
                            </div>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-1">Finance App Design</h6>
                              <small>Figma UI Kit</small>
                            </div>
                            <div class="badge bg-label-primary rounded-pill">$4,290</div>
                          </div>
                        </li>
                        <li class="d-flex align-items-center mb-6">
                          <div class="avatar avatar-md flex-shrink-0 me-4">
                            <div class="avatar-initial bg-light-gray rounded-3">
                              <div>
                                <img src="/assets/img/icons/misc/4-square.png" alt="User" class="h-25" />
                              </div>
                            </div>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-1">4 Square</h6>
                              <small>Android Application</small>
                            </div>
                            <div class="badge bg-label-primary rounded-pill">$44,500</div>
                          </div>
                        </li>
                        <li class="d-flex align-items-center mb-6">
                          <div class="avatar avatar-md flex-shrink-0 me-4">
                            <div class="avatar-initial bg-light-gray rounded-3">
                              <div>
                                <img src="/assets/img/icons/misc/delta-web-app.png" alt="User" class="h-25" />
                              </div>
                            </div>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-1">Delta Web App</h6>
                              <small>React Dashboard</small>
                            </div>
                            <div class="badge bg-label-primary rounded-pill">$12,690</div>
                          </div>
                        </li>
                        <li class="d-flex align-items-center">
                          <div class="avatar avatar-md flex-shrink-0 me-4">
                            <div class="avatar-initial bg-light-gray rounded-3">
                              <div>
                                <img src="/assets/img/icons/misc/ecommerce-website.png" alt="User" class="h-25" />
                              </div>
                            </div>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-1">eCommerce Website</h6>
                              <small>Vue + Laravel</small>
                            </div>
                            <div class="badge bg-label-primary rounded-pill">$10,850</div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <!--/ Project Statistics -->

                <!-- Multiple widgets -->
                <div class="col-md-6 col-xxl-4">
                  <div class="row g-4">
                    <!-- Total Revenue chart -->
                    <div class="col-md-6 col-sm-6">
                      <div class="card h-100">
                        <div class="card-header pb-xl-8">
                          <div class="d-flex align-items-center mb-1 flex-wrap">
                            <h5 class="mb-0 me-1">$42.5k</h5>
                            <p class="mb-0 text-danger">-22%</p>
                          </div>
                          <span class="d-block card-subtitle">Total Revenue</span>
                        </div>
                        <div class="card-body">
                          <div id="totalRevenue"></div>
                        </div>
                      </div>
                    </div>
                    <!--/ Total Revenue chart -->

                    <div class="col-md-6 col-sm-6">
                      <div class="card h-100">
                        <div class="card-body">
                          <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div class="avatar">
                              <div class="avatar-initial bg-label-success rounded-3">
                                <i class="ri-handbag-line ri-24px"></i>
                              </div>
                            </div>
                            <div class="d-flex align-items-center">
                              <p class="mb-0 text-success me-1">+38%</p>
                              <i class="ri-arrow-up-s-line text-success"></i>
                            </div>
                          </div>
                          <div class="card-info mt-5 mt-xl-8">
                            <h5 class="mb-1">$13.4k</h5>
                            <p>Total Sales</p>
                            <div class="badge bg-label-secondary rounded-pill">Last Six Month</div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                      <div class="card h-100">
                        <div class="card-body">
                          <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div class="avatar">
                              <div class="avatar-initial bg-label-info rounded-3">
                                <i class="ri-links-line ri-24px"></i>
                              </div>
                            </div>
                            <div class="d-flex align-items-center">
                              <p class="mb-0 text-success me-1">+62%</p>
                              <i class="ri-arrow-up-s-line text-success"></i>
                            </div>
                          </div>
                          <div class="card-info mt-5 mt-xl-8">
                            <h5 class="mb-1">142.8k</h5>
                            <p>Total Impression</p>
                            <div class="badge bg-label-secondary rounded-pill">Last One Year</div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- overview Radial chart -->
                    <div class="col-md-6 col-sm-6">
                      <div class="card h-100">
                        <div class="card-header pb-xl-7">
                          <div class="d-flex align-items-center mb-1 flex-wrap">
                            <h5 class="mb-0 me-1">$67.1k</h5>
                            <p class="mb-0 text-success">+49%</p>
                          </div>
                          <span class="d-block card-subtitle">Overview</span>
                        </div>
                        <div class="card-body pb-xl-8">
                          <div id="overviewChart" class="d-flex align-items-center"></div>
                        </div>
                      </div>
                    </div>
                    <!--/ overview Radial chart -->
                  </div>
                </div>
                <!--/ Multiple widgets -->

                <!-- Sales Country Chart -->
                <div class="col-12 col-xxl-4 col-md-6">
                  <div class="card h-100">
                    <div class="card-header">
                      <div class="d-flex justify-content-between">
                        <h5 class="mb-1">Sales Country</h5>
                        <div class="dropdown">
                          <button
                            class="btn btn-text-secondary rounded-pill text-muted border-0 p-1"
                            type="button"
                            id="salesCountryDropdown"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <i class="ri-more-2-line ri-20px"></i>
                          </button>
                          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesCountryDropdown">
                            <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                          </div>
                        </div>
                      </div>
                      <p class="mb-0 card-subtitle">Total $42,580 Sales</p>
                    </div>
                    <div class="card-body pb-1 px-0">
                      <div id="salesCountryChart"></div>
                    </div>
                  </div>
                </div>
                <!--/ Sales Country Chart -->

                <!-- Top Referral Source  -->
                <div class="col-12 col-xxl-8">
                  <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                      <div>
                        <h5 class="card-title mb-1">Top Referral Sources</h5>
                        <p class="card-subtitle mb-0">Number of Sales</p>
                      </div>
                      <div class="dropdown">
                        <button
                          class="btn btn-text-secondary rounded-pill text-muted border-0 p-1"
                          type="button"
                          id="earningReportsTabsId"
                          data-bs-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false">
                          <i class="ri-more-2-line ri-20px"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsTabsId">
                          <a class="dropdown-item" href="javascript:void(0);">View More</a>
                          <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                        </div>
                      </div>
                    </div>
                    <div class="card-body pb-0">
                      <ul class="nav nav-tabs nav-tabs-widget pb-6 gap-4 mx-1 d-flex flex-nowrap" role="tablist">
                        <li class="nav-item">
                          <a
                            href="javascript:void(0);"
                            class="nav-link btn active d-flex flex-column align-items-center justify-content-center"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-orders-id"
                            aria-controls="navs-orders-id"
                            aria-selected="true">
                            <div class="avatar avatar-sm">
                              <img src="/assets/img/icons/brands/google.png" alt="User" />
                            </div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a
                            href="javascript:void(0);"
                            class="nav-link btn d-flex flex-column align-items-center justify-content-center"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-sales-id"
                            aria-controls="navs-sales-id"
                            aria-selected="false">
                            <div class="avatar avatar-sm">
                              <img src="/assets/img/icons/brands/facebook-rounded.png" alt="User" />
                            </div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a
                            href="javascript:void(0);"
                            class="nav-link btn d-flex flex-column align-items-center justify-content-center"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-profit-id"
                            aria-controls="navs-profit-id"
                            aria-selected="false">
                            <div class="avatar avatar-sm">
                              <img src="/assets/img/icons/brands/instagram-rounded.png" alt="User" />
                            </div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a
                            href="javascript:void(0);"
                            class="nav-link btn d-flex flex-column align-items-center justify-content-center"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-income-id"
                            aria-controls="navs-income-id"
                            aria-selected="false">
                            <div class="avatar avatar-sm">
                              <img src="/assets/img/icons/brands/reddit-rounded.png" alt="User" />
                            </div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a
                            href="javascript:void(0);"
                            class="nav-link btn d-flex align-items-center justify-content-center disabled"
                            role="tab"
                            data-bs-toggle="tab"
                            aria-selected="false">
                            <div class="avatar avatar-sm">
                              <div class="avatar-initial bg-label-secondary text-body rounded">
                                <i class="ri-add-line ri-22px"></i>
                              </div>
                            </div>
                          </a>
                        </li>
                      </ul>
                    </div>
                    <div class="tab-content p-0">
                      <div class="tab-pane fade show active" id="navs-orders-id" role="tabpanel">
                        <div class="table-responsive text-nowrap">
                          <table class="table border-top">
                            <thead>
                              <tr>
                                <th class="bg-transparent border-bottom">Product Name</th>
                                <th class="bg-transparent border-bottom">STATUS</th>
                                <th class="text-end bg-transparent border-bottom">Profit</th>
                                <th class="text-end bg-transparent border-bottom">REVENUE</th>
                              </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                              <tr>
                                <td>Email Marketing Campaign</td>
                                <td>
                                  <div class="badge bg-label-primary rounded-pill">Active</div>
                                </td>
                                <td class="text-success fw-medium text-end">+24%</td>
                                <td class="text-end fw-medium">$42,857</td>
                              </tr>
                              <tr>
                                <td>Google Workspace</td>
                                <td>
                                  <div class="badge bg-label-success rounded-pill">Completed</div>
                                </td>
                                <td class="text-danger fw-medium text-end">-12%</td>
                                <td class="text-end fw-medium">$850</td>
                              </tr>
                              <tr>
                                <td>Affiliation Program</td>
                                <td>
                                  <div class="badge bg-label-primary rounded-pill">Active</div>
                                </td>
                                <td class="text-success fw-medium text-end">+24%</td>
                                <td class="text-end fw-medium">$5,576</td>
                              </tr>
                              <tr>
                                <td>Google Adsense</td>
                                <td>
                                  <div class="badge bg-label-info rounded-pill">In Draft</div>
                                </td>
                                <td class="text-success fw-medium text-end">+0%</td>
                                <td class="text-end fw-medium">0</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="navs-sales-id" role="tabpanel">
                        <div class="table-responsive text-nowrap">
                          <table class="table border-top">
                            <thead>
                              <tr>
                                <th class="bg-transparent border-bottom">Product Name</th>
                                <th class="bg-transparent border-bottom">STATUS</th>
                                <th class="text-end bg-transparent border-bottom">Profit</th>
                                <th class="text-end bg-transparent border-bottom">REVENUE</th>
                              </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                              <tr>
                                <td>facebook Adsense</td>
                                <td>
                                  <div class="badge bg-label-info rounded-pill">In Draft</div>
                                </td>
                                <td class="text-success fw-medium text-end">+5%</td>
                                <td class="text-end fw-medium">$5</td>
                              </tr>
                              <tr>
                                <td>Affiliation Program</td>
                                <td>
                                  <div class="badge bg-label-primary rounded-pill">Active</div>
                                </td>
                                <td class="text-danger fw-medium text-end">-24%</td>
                                <td class="text-end fw-medium">$5,576</td>
                              </tr>
                              <tr>
                                <td>Email Marketing Campaign</td>
                                <td>
                                  <div class="badge bg-label-warning rounded-pill">warning</div>
                                </td>
                                <td class="text-success fw-medium text-end">+5%</td>
                                <td class="text-end fw-medium">$2,857</td>
                              </tr>
                              <tr>
                                <td>facebook Workspace</td>
                                <td>
                                  <div class="badge bg-label-success rounded-pill">Completed</div>
                                </td>
                                <td class="text-danger fw-medium text-end">-12%</td>
                                <td class="text-end fw-medium">$850</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="navs-profit-id" role="tabpanel">
                        <div class="table-responsive text-nowrap">
                          <table class="table border-top">
                            <thead>
                              <tr>
                                <th class="bg-transparent border-bottom">Product Name</th>
                                <th class="bg-transparent border-bottom">STATUS</th>
                                <th class="text-end bg-transparent border-bottom">Profit</th>
                                <th class="text-end bg-transparent border-bottom">REVENUE</th>
                              </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                              <tr>
                                <td>Affiliation Program</td>
                                <td>
                                  <div class="badge bg-label-primary rounded-pill">Active</div>
                                </td>
                                <td class="text-danger fw-medium text-end">-24%</td>
                                <td class="text-end fw-medium">$5,576</td>
                              </tr>
                              <tr>
                                <td>instagram Adsense</td>
                                <td>
                                  <div class="badge bg-label-info rounded-pill">In Draft</div>
                                </td>
                                <td class="text-success fw-medium text-end">+5%</td>
                                <td class="text-end fw-medium">$5</td>
                              </tr>
                              <tr>
                                <td>instagram Workspace</td>
                                <td>
                                  <div class="badge bg-label-success rounded-pill">Completed</div>
                                </td>
                                <td class="text-danger fw-medium text-end">-12%</td>
                                <td class="text-end fw-medium">$850</td>
                              </tr>
                              <tr>
                                <td>Email Marketing Campaign</td>
                                <td>
                                  <div class="badge bg-label-danger rounded-pill">warning</div>
                                </td>
                                <td class="text-danger fw-medium text-end">-5%</td>
                                <td class="text-end fw-medium">$857</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="navs-income-id" role="tabpanel">
                        <div class="table-responsive text-nowrap">
                          <table class="table border-top">
                            <thead>
                              <tr>
                                <th class="bg-transparent border-bottom">Product Name</th>
                                <th class="bg-transparent border-bottom">STATUS</th>
                                <th class="text-end bg-transparent border-bottom">Profit</th>
                                <th class="text-end bg-transparent border-bottom">REVENUE</th>
                              </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                              <tr>
                                <td>reddit Workspace</td>
                                <td>
                                  <div class="badge bg-label-warning rounded-pill">process</div>
                                </td>
                                <td class="text-danger fw-medium text-end">-12%</td>
                                <td class="text-end fw-medium">$850</td>
                              </tr>
                              <tr>
                                <td>Affiliation Program</td>
                                <td>
                                  <div class="badge bg-label-primary rounded-pill">Active</div>
                                </td>
                                <td class="text-danger fw-medium text-end">-24%</td>
                                <td class="text-end fw-medium">$5,576</td>
                              </tr>
                              <tr>
                                <td>reddit Adsense</td>
                                <td>
                                  <div class="badge bg-label-info rounded-pill">In Draft</div>
                                </td>
                                <td class="text-success fw-medium text-end">+5%</td>
                                <td class="text-end fw-medium">$5</td>
                              </tr>
                              <tr>
                                <td>Email Marketing Campaign</td>
                                <td>
                                  <div class="badge bg-label-success rounded-pill">Completed</div>
                                </td>
                                <td class="text-success fw-medium text-end">+50%</td>
                                <td class="text-end fw-medium">$857</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--/ Top Referral Source  -->

                <!-- Weekly Sales Chart-->
                <div class="col-12 col-xxl-4 col-md-6">
                  <div class="card h-100">
                    <div class="card-header">
                      <div class="d-flex justify-content-between">
                        <h5 class="mb-1">Weekly Sales</h5>
                        <div class="dropdown">
                          <button
                            class="btn btn-text-secondary rounded-pill text-muted border-0 p-1"
                            type="button"
                            id="weeklySalesDropdown"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <i class="ri-more-2-line ri-20px"></i>
                          </button>
                          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="weeklySalesDropdown">
                            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                            <a class="dropdown-item" href="javascript:void(0);">Update</a>
                            <a class="dropdown-item" href="javascript:void(0);">Share</a>
                          </div>
                        </div>
                      </div>
                      <p class="mb-0 card-subtitle">Total 85.4k Sales</p>
                    </div>
                    <div class="card-body">
                      <div class="row mb-7 mb-xl-12">
                        <div class="col-6 d-flex align-items-center">
                          <div class="avatar">
                            <div class="avatar-initial bg-label-primary rounded">
                              <i class="ri-funds-line ri-24px"></i>
                            </div>
                          </div>
                          <div class="ms-3 d-flex flex-column">
                            <p class="mb-0">Net Income</p>
                            <h6 class="mb-0">$438.5K</h6>
                          </div>
                        </div>
                        <div class="col-6 d-flex align-items-center">
                          <div class="avatar">
                            <div class="avatar-initial bg-label-warning rounded">
                              <i class="ri-money-dollar-circle-line ri-24px"></i>
                            </div>
                          </div>
                          <div class="ms-3 d-flex flex-column">
                            <p class="mb-0">Expense</p>
                            <h6 class="mb-0">$22.4K</h6>
                          </div>
                        </div>
                      </div>
                      <div id="weeklySalesChart"></div>
                    </div>
                  </div>
                </div>
                <!--/ Weekly Sales Chart-->

                <!-- visits By Day Chart-->
                <div class="col-12 col-xxl-4 col-md-6">
                  <div class="card h-100">
                    <div class="card-header">
                      <div class="d-flex justify-content-between">
                        <h5 class="mb-1">Visits by Day</h5>
                        <div class="dropdown">
                          <button
                            class="btn btn-text-secondary rounded-pill text-muted border-0 p-1"
                            type="button"
                            id="visitsByDayDropdown"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <i class="ri-more-2-line ri-20px"></i>
                          </button>
                          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="visitsByDayDropdown">
                            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                            <a class="dropdown-item" href="javascript:void(0);">Update</a>
                            <a class="dropdown-item" href="javascript:void(0);">Share</a>
                          </div>
                        </div>
                      </div>
                      <p class="mb-0 card-subtitle">Total 248.5k Visits</p>
                    </div>
                    <div class="card-body pt-xl-5">
                      <div id="visitsByDayChart"></div>
                      <div class="d-flex justify-content-between mt-6">
                        <div>
                          <h6 class="mb-0">Most Visited Day</h6>
                          <p class="mb-0 small">Total 62.4k Visits on Thursday</p>
                        </div>
                        <div class="avatar">
                          <div class="avatar-initial bg-label-warning rounded">
                            <i class="ri-arrow-right-s-line ri-24px scaleX-n1-rtl"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--/ visits By Day Chart-->

                <!-- Activity Timeline -->
                <div class="col-12 col-xxl-8">
                  <div class="card h-100">
                    <div class="card-header">
                      <div class="d-flex justify-content-between">
                        <h5 class="mb-0">Activity Timeline</h5>
                      </div>
                    </div>
                    <div class="card-body pt-4">
                      <ul class="timeline card-timeline mb-0">
                        <li class="timeline-item timeline-item-transparent">
                          <span class="timeline-point timeline-point-primary"></span>
                          <div class="timeline-event">
                            <div class="timeline-header mb-3">
                              <h6 class="mb-0">12 Invoices have been paid</h6>
                              <small class="text-muted">12 min ago</small>
                            </div>
                            <p class="mb-2">Invoices have been paid to the company</p>
                            <div class="d-flex align-items-center mb-1">
                              <div class="badge bg-lighter rounded-3">
                                <img src="/assets//img/icons/misc/pdf.png" alt="img" width="15" class="me-2" />
                                <span class="h6 mb-0">invoices.pdf</span>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li class="timeline-item timeline-item-transparent">
                          <span class="timeline-point timeline-point-success"></span>
                          <div class="timeline-event">
                            <div class="timeline-header mb-3">
                              <h6 class="mb-0">Client Meeting</h6>
                              <small class="text-muted">45 min ago</small>
                            </div>
                            <p class="mb-2">Project meeting with john @10:15am</p>
                            <div class="d-flex justify-content-between flex-wrap gap-2">
                              <div class="d-flex flex-wrap align-items-center">
                                <div class="avatar avatar-sm me-2">
                                  <img src="/assets/img/avatars/1.png" alt="Avatar" class="rounded-circle" />
                                </div>
                                <div>
                                  <p class="mb-0 small fw-medium">Lester McCarthy (Client)</p>
                                  <small>CEO of ThemeSelection</small>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li class="timeline-item timeline-item-transparent">
                          <span class="timeline-point timeline-point-info"></span>
                          <div class="timeline-event">
                            <div class="timeline-header mb-3">
                              <h6 class="mb-0">Create a new project for client</h6>
                              <small class="text-muted">2 Day Ago</small>
                            </div>
                            <p class="mb-2">6 team members in a project</p>
                            <ul class="list-group list-group-flush">
                              <li
                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap border-top-0 p-0">
                                <div class="d-flex flex-wrap align-items-center">
                                  <ul class="list-unstyled users-list d-flex align-items-center avatar-group m-0 me-2">
                                    <li
                                      data-bs-toggle="tooltip"
                                      data-popup="tooltip-custom"
                                      data-bs-placement="top"
                                      title="Vinnie Mostowy"
                                      class="avatar pull-up">
                                      <img class="rounded-circle" src="/assets/img/avatars/5.png" alt="Avatar" />
                                    </li>
                                    <li
                                      data-bs-toggle="tooltip"
                                      data-popup="tooltip-custom"
                                      data-bs-placement="top"
                                      title="Allen Rieske"
                                      class="avatar pull-up">
                                      <img class="rounded-circle" src="/assets/img/avatars/12.png" alt="Avatar" />
                                    </li>
                                    <li
                                      data-bs-toggle="tooltip"
                                      data-popup="tooltip-custom"
                                      data-bs-placement="top"
                                      title="Julee Rossignol"
                                      class="avatar pull-up">
                                      <img class="rounded-circle" src="/assets/img/avatars/6.png" alt="Avatar" />
                                    </li>
                                    <li class="avatar">
                                      <span
                                        class="avatar-initial rounded-circle pull-up text-heading"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="bottom"
                                        title="3 more"
                                        >+3</span
                                      >
                                    </li>
                                  </ul>
                                </div>
                              </li>
                            </ul>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <!-- Activity Timeline -->
              </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl">
                <div
                  class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                  <div class="text-body mb-2 mb-md-0">
                    ©
                    <script>
                      document.write(new Date().getFullYear());
                    </script>
                    , made with <span class="text-danger"><i class="tf-icons ri-heart-fill"></i></span> by
                    <a href="https://pixinvent.com" target="_blank" class="footer-link">Pixinvent</a>
                  </div>
                  <div class="d-none d-lg-inline-block">
                    <a href="https://themeforest.net/licenses/standard" class="footer-link me-4" target="_blank"
                      >License</a
                    >
                    <a href="https://1.envato.market/pixinvent_portfolio" target="_blank" class="footer-link me-4"
                      >More Themes</a
                    >

                    <a
                      href="https://demos.pixinvent.com/materialize-html-admin-template/documentation/"
                      target="_blank"
                      class="footer-link me-4"
                      >Documentation</a
                    >

                    <a href="https://pixinvent.ticksy.com/" target="_blank" class="footer-link d-none d-sm-inline-block"
                      >Support</a
                    >
                  </div>
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>

      <!-- Drag Target Area To SlideIn Menu On Small Screens -->
      <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

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

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="/assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="/assets/vendor/libs/swiper/swiper.js"></script>

    <!-- Main JS -->
    <script src="/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="/assets/js/dashboards-analytics.js"></script>
  </body>
</html>
