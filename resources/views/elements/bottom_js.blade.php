<script type="text/javascript">
    var httpPath = "{{ url('/') }}/";
</script>

<script src="{{asset('backend/assets/js/bootstrap.bundle.min.js')}}"></script>
	<!--plugins-->
	<!-- for form validation -->
	<script src="{{asset('backend/assets/js/jquery.min.js')}}"></script>
	<script src="{{asset('backend/assets/js/jquery.validate.min.js')}}"></script>

	<script src="{{asset('backend/assets/js/pace.min.js')}}"></script>

<!--plugins-->
	<script src="{{asset('backend/assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
	<script src="{{asset('backend/assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
	<script src="{{asset('backend/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
	<script src="{{asset('backend/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
    <script src="{{asset('backend/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
	<script src="{{asset('backend/assets/plugins/chartjs/js/chart.js')}}"></script>
	<script src="{{asset('backend/assets/js/index.js')}}"></script>
	<!--app JS-->
	<script src="{{asset('backend/assets/js/app.js')}}"></script>

	<script type="text/javascript" src="{{asset('backend/assets/js/toastr.js')}}"></script>
	<script type="text/javascript" src="{{asset('backend/assets/js/toastr.min.js')}}"></script>

	<script>
		new PerfectScrollbar(".app-container")
	</script>
	<!--Password show & hide js -->
	<script type="text/javascript" src="{{asset('backend/assets/js/sweetalert2.all.min.js')}}"></script>
	<!-- <script src="{{asset('backend/assets/js/vendors.min.js')}}"></script> -->

	<script src="{{asset('backend/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('backend/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
	<script>
		$(document).ready(function() {
			$('#example').DataTable();
		  } );
	</script>
	<script>
		$(document).ready(function() {
			var table = $('#example2').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
		} );
	</script>

	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		});
	</script>
	<!--app JS-->
	<script src="{{asset('backend/assets/js/app.js')}}"></script>

	