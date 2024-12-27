<!DOCTYPE html>
@php
  \Carbon\Carbon::setLocale('id');
@endphp
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>
    @yield('title', env('APP_NAME'))
  </title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  <link rel="icon" href="{{ asset('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

  {{-- Select2 --}}
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

  {{-- Sweet Alert --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Fonts and icons -->
  <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
  <script>
    WebFont.load({
      google: {
        families: ["Public Sans:300,400,500,600,700"]
      },
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
        ],
        urls: ["{{ asset('assets/css/fonts.min.css') }}"],
      },
      active: function() {
        sessionStorage.fonts = true;
      },
    });
  </script>

  <!-- CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" data-background-color="light">
      <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="white">
          <a href="{{ route('dashboard') }}" class="logo">
            <img src="{{ asset('assets/img/logo-long.svg') }}" alt="navbar brand" class="navbar-brand" width="150px" />
          </a>
          <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
              <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
              <i class="gg-menu-left"></i>
            </button>
          </div>
          <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
          </button>
        </div>
        <!-- End Logo Header -->
      </div>
      <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
          @include('layouts.navigation')
          <div class="mt-auto">
            <ul class="nav nav-secondary">
              <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                @csrf
              </form>
              <li class="nav-item">
                <a href="#" onclick="confirmLogout(event)" aria-expanded="false">
                  <i class="fas fa-sign-out-alt"></i>
                  <p>Keluar</p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- End Sidebar -->

    <div class="main-panel">
      <div class="main-header">
        <div class="main-header-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="white">
            <a href="{{ route('dashboard') }}" class="logo">
              <img src="{{ asset('assets/img/logo-long.svg') }}" alt="navbar brand" class="navbar-brand"
                height="40" />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <!-- Navbar Header -->
        <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
          <div class="container-fluid">
            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
              <li class="nav-item topbar-user dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                  <div class="avatar-sm">
                    <img src="{{ asset('assets/img/profile.svg') }}" alt="..."
                      class="avatar-img rounded-circle" />
                  </div>
                  <span class="profile-username">
                    <span class="op-7">Hi,</span>
                    <span class="fw-bold">{{ Auth::user()->name }}</span>
                  </span>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                  <div class="dropdown-user-scroll scrollbar-outer">
                    <li>
                      <div class="user-box">
                        <div class="avatar-lg">
                          <img src="{{ asset('assets/img/profile.svg') }}" alt="image profile"
                            class="avatar-img rounded" />
                        </div>
                        <div class="u-text">
                          <h4>{{ Auth::user()->name }}</h4>
                          <p class="text-muted">{{ Auth::user()->email }}</p>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="{{ route('profile.edit') }}">My
                        Profile</a>
                      <div class="dropdown-divider"></div>
                      <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                        @csrf
                      </form>
                      <a class="dropdown-item" href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                      </a>
                    </li>
                  </div>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>

      <div class="container">
        @yield('content')
      </div>

      <footer class="footer">
        <div class="container-fluid d-flex justify-content-center">
          <div class="copyright">
            &copy; 2024 {{ env('APP_NAME') }}. All rights reserved.
          </div>
        </div>
      </footer>
    </div>


    <!-- End Custom template -->
  </div>

  <script>
    function confirmLogout(event) {
      event.preventDefault(); // Prevent the default link action

      // SweetAlert2 confirmation
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: 'Anda akan keluar dari aplikasi!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, logout!',
        cancelButtonText: 'Batal',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          // If confirmed, submit the logout form
          document.getElementById('logout-form').submit();
        }
      });
    }
  </script>


  <!--   Core JS Files   -->
  <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

  <!-- jQuery Scrollbar -->
  <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

  <!-- Chart JS -->
  <script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>

  <!-- jQuery Sparkline -->
  <script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

  <!-- Chart Circle -->
  <script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>

  <!-- Datatables -->
  <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>

  <!-- Bootstrap Notify -->
  <script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

  <!-- jQuery Vector Maps -->
  <script src="{{ asset('assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugin/jsvectormap/world.js') }}"></script>

  <!-- Sweet Alert -->
  <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

  <!-- Kaiadmin JS -->
  <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>

  <!-- Select 2 -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

  @yield('script')

  @if (session('success'))
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
    </script>
  @endif

  @if (session('error'))
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
    </script>
  @endif

  @if ($errors->any())
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
          title: 'Validation Error',
          icon: 'error',
          toast: true,
          html: `
              <ul style="text-align: left;">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            `,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
      });
    </script>
  @endif


</body>

</html>
