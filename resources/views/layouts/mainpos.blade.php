<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>@yield('title')</title>

  <!-- Custom fonts for this template -->
  <link rel="icon" href="{{ asset('uploads') }}/settings/logo.png">
  <link href="{{ asset('starbootstrap') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="{{ asset('starbootstrap') }}/css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('starbootstrap') }}/css/custom.css">

  <!-- Custom styles for this page -->
  <link href="{{ asset('starbootstrap') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="{{ asset('dropzone') }}/dist/dropzone.css" rel="stylesheet">
  
  @toastr_css

  @yield('css')

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        @include('layouts.partials.navbarpos')
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">@yield('page-head')</h1>
          <p class="mb-4">@yield('page-head-desc')</p>

          <!-- DataTales Example -->
          @yield('content')

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      @include('layouts.partials.footer')
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('starbootstrap') }}/vendor/jquery/jquery.min.js"></script>
  @yield('scripts')
  <script src="{{ asset('starbootstrap') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('starbootstrap') }}/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="{{ asset('js') }}/moment.js"></script>
  <script src="{{ asset('js') }}/sale.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('starbootstrap') }}/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="{{ asset('starbootstrap') }}/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="{{ asset('starbootstrap') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{ asset('starbootstrap') }}/js/demo/datatables-demo.js"></script>

  <script src="{{ asset('vendor') }}/sweetalert/sweetalert.all.js"></script>
  <script src="{{ asset('dropzone') }}/dist/dropzone.js"></script>
  @toastr_js
  @toastr_render
  
  <script>
    $(document).ready(function () {
        var interval = setInterval(function () {
            var momentNow = moment();
            $('#date-part').html(momentNow.format('dddd') + ' ' + momentNow.format('DD MMMM YYYY'));
            $('#time-part').html(momentNow.format('kk:mm:ss'));
        }, 100);
    });
  </script>
  
</body>

</html>
