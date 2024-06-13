<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">

<title>@yield('title')</title>
<meta content="" name="description">
<meta content="" name="keywords">
<meta name="csrf-token" content="{{ csrf_token() }}" />

<!-- Favicons -->
<link href="{{ URL::to('assets/img/favicon.png')}}" rel="icon">
<link href="{{ URL::to('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

<!-- Google Fonts -->
<link href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="{{URL::asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/css/select2.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/css/jquery-confirm.css')}}" rel="stylesheet">

<!-- cdn for yajra datatable -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables CSS and JS CDN -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<!-- /. DataTables CSS and JS CDN -->

<!-- Template Main CSS File -->
<link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet">

<!-- Datepicker -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
<!-- /. Datepicker -->