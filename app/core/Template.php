<?php


class Template extends Navadmin
{
	protected $obj;
	protected $app;
	public function __construct($app, $obj)
	{
		$this->obj=$obj;
		$this->app=$app;
		$this->info = self::getinfoklinik();
	}
	public function getinfoklinik()
	{
		$d = $this->obj->selectTable('profile_klinik',"klinik_id=1");
		$d->execute();
		$this->info = $d->fetch(PDO::FETCH_BOTH);
		return $this->info;
	}
	public function head($path, $get)
	{
		?>
			<?php 
				$intitle = (!empty($get))?$get:"Klinik untuk indonesia";
			?>
			<!DOCTYPE html>
			<html lang="en">
			<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title><?=$this->info['klinik_name']?> | <?=$intitle?></title>
			<link rel="icon" href="<?=$path?>content/web/<?=$this->info['klinik_icon']?>">
			<meta name="description" content="<?=$this->info['klinik_description']?>" />	

		<?php 
	}
	public function css($path)
	{
		?>
		  <!-- Google Font: Source Sans Pro -->
		  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		  <!-- Font Awesome -->
		  <link rel="stylesheet" href="<?=$path?>themes/adminlte/plugins/fontawesome-free/css/all.min.css">
		  <!-- DataTables -->
		  <link rel="stylesheet" href="<?=$path?>themes/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
		  <link rel="stylesheet" href="<?=$path?>themes/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
		  <link rel="stylesheet" href="<?=$path?>themes/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
		  <!-- Ionicons -->
		  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		  <!-- Tempusdominus Bootstrap 4 -->
		  <link rel="stylesheet" href="<?=$path?>themes/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
		  <!-- iCheck -->
		  <link rel="stylesheet" href="<?=$path?>themes/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
		  <!-- JQVMap -->
		  <link rel="stylesheet" href="<?=$path?>themes/adminlte/plugins/jqvmap/jqvmap.min.css">
		  <!-- Theme style -->
		  <link rel="stylesheet" href="<?=$path?>themes/adminlte/dist/css/adminlte.min.css">
		  <!-- overlayScrollbars -->
		  <link rel="stylesheet" href="<?=$path?>themes/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
		  <!-- Daterange picker -->
		  <link rel="stylesheet" href="<?=$path?>themes/adminlte/plugins/daterangepicker/daterangepicker.css">
		  <!-- summernote -->
		  <link rel="stylesheet" href="<?=$path?>themes/adminlte/plugins/summernote/summernote-bs4.min.css">
		</head>
		<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">

		  <!-- Preloader -->
		  <div class="preloader flex-column justify-content-center align-items-center">
		    <img class="animation__shake" src="<?=$path?>themes/adminlte/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
		  </div>


		<?php 
	}
	public function footer($path)
	{
		?>
		<footer class="main-footer">
			    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
			    All rights reserved.
			    <div class="float-right d-none d-sm-inline-block">
			      <b>Version</b> 3.2.0
			    </div>
			  </footer>

			  <!-- Control Sidebar -->
			  <aside class="control-sidebar control-sidebar-dark">
			    <!-- Control sidebar content goes here -->
			  </aside>
			  <!-- /.control-sidebar -->
			</div>
			<!-- ./wrapper -->

			<!-- jQuery -->
			<script src="<?=$path?>themes/adminlte/plugins/jquery/jquery.min.js"></script>
			<!-- jQuery UI 1.11.4 -->
			<script src="<?=$path?>themes/adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>
			<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
			<script>
			  $.widget.bridge('uibutton', $.ui.button)
			</script>
			<!-- Bootstrap 4 -->
			<script src="<?=$path?>themes/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
			<!-- DataTables  & Plugins -->
			<script src="<?=$path?>themes/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
			<script src="<?=$path?>themes/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
			<script src="<?=$path?>themes/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
			<script src="<?=$path?>themes/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
			<script src="<?=$path?>themes/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
			<script src="<?=$path?>themes/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
			<script src="<?=$path?>themes/adminlte/plugins/jszip/jszip.min.js"></script>
			<script src="<?=$path?>themes/adminlte/plugins/pdfmake/pdfmake.min.js"></script>
			<script src="<?=$path?>themes/adminlte/plugins/pdfmake/vfs_fonts.js"></script>
			<script src="<?=$path?>themes/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
			<script src="<?=$path?>themes/adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
			<script src="<?=$path?>themes/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
			<!-- ChartJS -->
			<script src="<?=$path?>themes/adminlte/plugins/chart.js/Chart.min.js"></script>
			<!-- Sparkline -->
			<script src="<?=$path?>themes/adminlte/plugins/sparklines/sparkline.js"></script>
			<!-- JQVMap -->
			<script src="<?=$path?>themes/adminlte/plugins/jqvmap/jquery.vmap.min.js"></script>
			<script src="<?=$path?>themes/adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
			<!-- jQuery Knob Chart -->
			<script src="<?=$path?>themes/adminlte/plugins/jquery-knob/jquery.knob.min.js"></script>
			<!-- daterangepicker -->
			<script src="<?=$path?>themes/adminlte/plugins/moment/moment.min.js"></script>
			<script src="<?=$path?>themes/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
			<!-- Tempusdominus Bootstrap 4 -->
			<script src="<?=$path?>themes/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
			<!-- Summernote -->
			<script src="<?=$path?>themes/adminlte/plugins/summernote/summernote-bs4.min.js"></script>
			<!-- overlayScrollbars -->
			<script src="<?=$path?>themes/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
			<!-- AdminLTE App -->
			<script src="<?=$path?>themes/adminlte/dist/js/adminlte.js"></script>
			<!-- AdminLTE for demo purposes -->
			<script src="<?=$path?>themes/adminlte/dist/js/demo.js"></script>
			<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
			<script src="<?=$path?>themes/adminlte/dist/js/pages/dashboard.js"></script>
			<script>
			  $(function () {
			    $("#example1").DataTable({
			      "responsive": true, "lengthChange": false, "autoWidth": false,
			      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
			    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
			    $('#example2').DataTable({
			      "paging": true,
			      "lengthChange": false,
			      "searching": true,
			      "ordering": true,
			      "info": true,
			      "autoWidth": false,
			      "responsive": true,
			    });
			  });
			</script>
			</body>
			</html>
		<?php 
	}
	
}



?>