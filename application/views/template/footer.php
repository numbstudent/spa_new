<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- /.content-wrapper -->

<footer class="main-footer no-print">
  <div class="pull-right hidden-xs">
    <b>DamaruStudio</b> 1.0.0
  </div>
  <p style=""class="text-center"><small><strong>asdasd</strong> - 2016</small></p>
  <!-- This Sistem Informasi Kampus is created by Damar Pradiptojati | All rights reserved -->
  <a style="display:none;" href="http://yakobusdamar.com">.</a>
</footer>

<!-- jQuery 2.2.0 -->
<!-- DataTables -->
<script src="<?php echo base_url(); ?>/asset/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>/asset/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>/asset/plugins/select2/select2.full.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo base_url(); ?>/asset/bootstrap/js/bootstrap.min.js"></script>
<!-- datepicker -->
<script src="<?php echo base_url(); ?>/asset/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url(); ?>/asset/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>/asset/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>/asset/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>/asset/dist/js/demo.js"></script>
<script>
// $('#datepicker').datepicker({
//   autoclose: true,
//   format: 'yyyy/mm/dd'
// });


  $(function () {
    $('.datepicker').datepicker({
      autoclose: true,
      format: 'yyyy/mm/dd',
      todayHighlight: true
    });
    $('#datepicker').datepicker({
      autoclose: true,
      format: 'yyyy/mm/dd',
      todayHighlight: true
    });

    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
</body>
</html>
