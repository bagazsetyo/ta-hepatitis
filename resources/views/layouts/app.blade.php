<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SIPAKAR</title>
    <link rel="icon" href="/assets/img/logo.png" type="image/x-icon">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="/assets/bower_components/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="/assets/dist/css/AdminLTE.min.css">
    <link href="/assets/css/datapicker/datepicker3.css"  rel="stylesheet"> 
    <link rel="stylesheet" href="/assets/select2/select2.min.css">
    <link rel="stylesheet" href="/assets/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="/assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link href="/assets/css/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/plugins/iCheck/all.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-purple layout-top-nav">
    <div class="wrapper">
        @include('layouts.top_nav')
        <div class="content-wrapper">
            <div class="container">
                <section class="content">
                    @yield('content')
                </section>
            </div>
        </div>
        @include('layouts.left_nav')
    </div>

    <script src="/assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/assets/bower_components/fastclick/lib/fastclick.js"></script>
    <script src="/assets/dist/js/adminlte.min.js"></script>
    <script src="/assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
    <script src="/assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="/assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="/assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/assets/bower_components/chart.js/Chart.js"></script>
    <script src="/assets/dist/js/pages/dashboard2.js"></script>
    <script src="/assets/dist/js/demo.js"></script>
    <script src="https://cdn.rawgit.com/igorescobar/jQuery-Mask-Plugin/1ef022ab/dist/jquery.mask.min.js"></script>
    <script type="text/javascript" src="/assets/css/numeral.js"></script>
    <script src="/assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="/assets/select2/select2.full.min.js"></script>
    <script src="/assets/bower_components/moment/min/moment.min.js"></script>
    <script src="/assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript" src="/assets/css/toastr.min.js"></script>
    <script src="/assets/plugins/datapicker/bootstrap-datepicker.js"></script>
    <script src="/assets/plugins/iCheck/icheck.min.js"></script>

    <script>
        $('.dataTab').dataTable();
        $(".select2").select2();
        $('.daterange').daterangepicker();

        $('.maxdate').datepicker({
            todayHighlight: true,
            autoclose: true,
            format: 'dd-mm-yyyy',
            language: 'id',
            endDate: '0d'
        });

        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass   : 'iradio_flat-green'
        });
        
    </script>
    @yield('kmeans')
</body>
</html>
