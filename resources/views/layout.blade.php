<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../../assets/img/profile.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <title>
        Supplier's Information Board
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <!-- Nucleo Icons -->
    <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2"
        id="sidenav-main">
        <div class="text-center py-3">
            <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
                <img src="../../assets/img/logo-aski.png" class="navbar-brand-img w-10" alt="main_logo">
                <span class="ms-1 text-xs text-dark">PT Astra Komponen Indonesia</span>
            </a>
        </div>
        <hr class="horizontal dark my-0">
        <hr class="horizontal dark mt-0 mb-2">
        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link py-3 text-dark" href="{{ asset('/') }}">
                        <i class="material-symbols-rounded opacity-5">home_app_logo</i>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-xs text-dark font-weight-bolder opacity-5">User</h6>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link text-dark" data-bs-toggle="collapse" href="#menuDelivery" role="button"
                        aria-expanded="false" aria-controls="menuDelivery" href="../pages/billing.html">
                        <i class="material-symbols-rounded opacity-5">home_app_logo</i>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                    <div class="collapse" id="menuDelivery">
                        <ul class="nav ms-4 ps-3">

                            <!-- Packing Individual -->
                            <li class="nav-item">
                                <a class="nav-link text-dark" data-bs-toggle="collapse" href="#packingIndividual"
                                    role="button" aria-expanded="false" aria-controls="packingIndividual">
                                    <i class="material-symbols-rounded opacity-5">person</i>
                                    Packing Individual
                                </a>
                                <div class="collapse" id="packingIndividual">
                                    <ul class="nav ms-4 ps-3">
                                        <li class="nav-item">
                                            <a class="nav-link text-dark" href="#">
                                                <i class="material-symbols-rounded opacity-5">label</i>
                                                Preparation
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark" href="#">
                                                <i class="material-symbols-rounded opacity-5">schedule</i>
                                                Packing List
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ asset('/supply/user/reg') }}">
                        <i class="material-symbols-rounded opacity-5">checkbook</i>
                        <span class="nav-link-text ms-1">Registrasi Tiket Antrian</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ asset('/supply/user/monitor') }}">
                        <i class="material-symbols-rounded opacity-5">browse_activity</i>
                        <span class="nav-link-text ms-1">Monitoring Antrian User</span>
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-xs text-dark font-weight-bolder opacity-5">Admin</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ asset('/supply/admin/qc') }}">
                        <i class="material-symbols-rounded opacity-5">editor_choice</i>
                        <span class="nav-link-text ms-1">Quality Control</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ asset('/supply/admin/ppic') }}">
                        <i class="material-symbols-rounded opacity-5">inventory_2</i>
                        <span class="nav-link-text ms-1">PPIC</span>
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-xs text-dark font-weight-bolder opacity-5">Arsip</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ asset('arsip/ng') }}">
                        <i class="material-symbols-rounded opacity-5">gpp_bad</i>
                        <span class="nav-link-text ms-1">Arsip Not Good (NG)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ asset('arsip/hold') }}">
                        <i class="material-symbols-rounded opacity-5">front_hand</i>
                        <span class="nav-link-text ms-1">Arsip Hold</span>
                    </a>
                </li>
                <hr class="horizontal dark my-0 mt-9">
                <hr class="horizontal dark my-0 mb-2">
                <li class="nav-item">
                    <a class="nav-link text-dark"
                        href="https://aspaki.or.id/membership/pt-astra-komponen-indonesia">
                        <img class="opacity-5 w-15 mt-0.5 px-2" src="../../assets/img/web.png" alt="web">
                        <span class="nav-link-text ms-1">Website ASKI</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark"
                        href="https://grin.co.id/">
                        <img class="opacity-5 w-15 mt-0.5 px-1 rounded-full" src="../../assets/img/grin.png" alt="grin">
                        <span class="nav-link-text ms-1">GRIN</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark"
                        href="https://www.instagram.com/aski_innovation?igsh=MTQ1cjB6ZmN6eHFwNw==">
                        <img class="opacity-5 w-15 mt-0.5 px-2" src="../../assets/img/instagram.png" alt="ig">
                        <span class="nav-link-text ms-1">Instagram ASKI</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark"
                        href="https://www.linkedin.com/company/astrakomponenindonesia/?originalSubdomain=id">
                        <img class="opacity-5 w-15 mt-0.5 px-1" src="../../assets/img/linkedin.png" alt="link">
                        <span class="nav-link-text ms-1">LinkedIn ASKI</span>
                    </a>
                </li>
            </ul>

        </div>
    </aside>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <nav class="navbar navbar-main navbar-expand-lg position-sticky mt-4 top-1 px-0 mx-4 shadow-none border-radius-xl z-index-sticky"
            id="navbarBlur" data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <div class="sidenav-toggler sidenav-toggler-inner d-xl-block mx-5">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm">
                            <a class="opacity-7 text-dark" href="{{ asset('/supply/user/reg') }}">
                                Registrasi
                            </a>
                        </li>
                        <li class="breadcrumb-item text-sm"><a class="opacity-7 text-dark"
                                href="{{ asset('/supply/user/monitor') }}">Monitor User</a>
                        </li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">User</li>
                    </ol>
                    <a href="{{ asset('/') }}">
                        <h6 class="font-weight-bolder text-sm mb-0">PT Astra Komponen Indonesia</h6>
                    </a>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex gap-3 align-items-center">
                        <div class="input-group input-group-outline">
                            <div class="input-group input-group-outline mb-2 px-0">
                                <input type="text" name="jam" class="form-control" id="jamInput" readonly>
                            </div>
                        </div>
                        {{-- <div class="input-group input-group-outline">
                            <div class="input-group input-group-outline pt-2" onclick="location.reload();">
                                <button type="button" class="btn btn-outline-primary">Refresh</button>
                            </div>
                        </div> --}}
                    </div>
                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item">
                            <a href="javascript:;" class="nav-link text-body p-0 position-relative"
                                onclick="toggleFullscreen()" id="fullscreen-link">
                                <i class="material-symbols-rounded me-sm-1" id="icon-fullscreen">
                                    fullscreen
                                </i>
                            </a>
                        </li>
                        </li>
                        <li class="nav-item px-3">
                            <a href="javascript:;" class="nav-link text-body p-0">
                                <i class="material-symbols-rounded fixed-plugin-button-nav cursor-pointer">
                                    settings
                                </i>
                            </a>
                        </li>
                    </ul>
                    </li>
                    </ul>
                </div>
            </div>
        </nav>
        @yield('konten')
    </main>
    <div class="fixed-plugin">
        <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
            <i class="material-symbols-rounded py-2">settings</i>
        </a>
        <div class="card shadow-lg">
            <div class="card-header pb-0 pt-3">
                <div class="float-start">
                    <h5 class="mt-3 mb-0">Material UI Configurator</h5>
                    <p>See our dashboard options.</p>
                </div>
                <div class="float-end mt-4">
                    <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                        <i class="material-symbols-rounded">clear</i>
                    </button>
                </div>
                <!-- End Toggle Button -->
            </div>
            <hr class="horizontal dark my-1">
            <div class="card-body pt-sm-3 pt-0">
                <!-- Sidebar Backgrounds -->

                <!-- Sidenav Type -->
                <div class="">
                    <h6 class="mb-0">Sidenav Type</h6>
                    <p class="text-sm">Choose between different sidenav types.</p>
                </div>
                <div class="d-flex">
                    <button class="btn bg-gradient-dark px-3 mb-2" data-class="bg-gradient-dark"
                        onclick="sidebarType(this)">Dark</button>
                    <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent"
                        onclick="sidebarType(this)">Transparent</button>
                    <button class="btn bg-gradient-dark px-3 mb-2  active ms-2" data-class="bg-white"
                        onclick="sidebarType(this)">White</button>
                </div>
                <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
                <!-- Navbar Fixed -->
                <div class="mt-3 d-flex">
                    <h6 class="mb-0">Navbar Fixed</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed"
                            onclick="navbarFixed(this)">
                    </div>
                </div>
                <hr class="horizontal dark my-3">
                <div class="mt-2 d-flex">
                    <h6 class="mb-0">Light / Dark</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version"
                            onclick="darkMode(this)">
                    </div>
                </div>
                <hr class="horizontal dark my-sm-4">
            </div>
        </div>
    </div>
    </div>

</body>
<script src="../../assets/js/core/popper.min.js"></script>
<script src="../../assets/js/core/bootstrap.min.js"></script>
<script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="../../assets/js/plugins/chartjs.min.js"></script>
<script src="../../assets/js/material-dashboard.min.js?v=3.2.0"></script>


{{-- FUNGSI TOGGLE FULLSCREEN --}}
<script>
    function toggleFullscreen() {
        icon = document.getElementById('icon-fullscreen')

        const link = document.getElementById("fullscreen-link");
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen().then(() => {
                icon.innerText = "fullscreen_exit";
            });
        } else {
            document.exitFullscreen().then(() => {
                icon.innerText = "fullscreen";
            });
        }
    }
</script>
{{-- FUNGSI TOGGLE FULLSCREEN --}}

{{-- FUNGSI COLLAPSE NAVBAR --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.getElementById("iconNavbarSidenav");
        toggleBtn?.addEventListener("click", function () {
            document.body.classList.toggle("g-sidenav-show");
        });
    });
</script>
{{-- FUNGSI COLLAPSE NAVBAR --}}


{{-- FUNGSI REAL TIME JAM VIEWER --}}
<script>
    function updateJam() {
        const now = new Date();
        const jam = now.toLocaleTimeString('id-ID'); // Format HH:mm:ss
        document.getElementById('jamInput').value = jam;
    }

    setInterval(updateJam, 1000); // Update tiap 1 detik
    updateJam(); // Panggil sekali saat pertama
</script>


{{-- FUNGSI REAL TIME JAM VIEWER --}}


<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>


</html>