@if(Request::segment(2) == 'inventory')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
@endif

<!-- Tagsinput -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous"></script>
<!-- /. Tagsinput -->

<script src="{{URL::asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
<script src="{{URL::asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{URL::asset('assets/vendor/chart.js/chart.umd.js')}}"></script>
<script src="{{URL::asset('assets/vendor/echarts/echarts.min.js')}}"></script>
<script src="{{URL::asset('assets/vendor/quill/quill.min.js')}}"></script>
<script src="{{URL::asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
<script src="{{URL::asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
<script src="{{URL::asset('assets/vendor/php-email-form/validate.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.min.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery-confirm.js')}}"></script>

<!-- Moment -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<!-- /. Moment -->

<!-- Template Main JS File -->
<script src="{{URL::asset('assets/js/main.js')}}"></script>

<!-- endinject -->
<script type="text/javascript">
	var BASE_URL = "{{URL('/')}}";
	var ITEM_ID = '{{ Request::segment(3) }}';
	var USER_ROLE = "<?php echo auth()->guard()->user()->user_role; ?>";
</script>

<?php if (isset($customJS) && !empty($customJS)) { ?>
	<script src="{{URL::asset('assets/js/custom/'.$customJS.'.js')}}"></script>
<?php } ?>
<!-- Custom js for this page -->
@if(Session::has('success_message'))
<script>
	var mesage = "{{ Session::get('success_message') }}";
	alertMessage(mesage);
</script>
@endif
@if(Session::has('danger_message'))
<script>
	var mesage = "{{ Session::get('danger_message') }}";
	alertMessage(mesage, 'danger');
</script>
@endif

<!-- End custom js for this page -->