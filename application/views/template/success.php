<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Info
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?php echo $message; ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body text-center">
          <h1><small><?php echo $messagedetails; ?></small></h1>
          <a href="<?php echo base_url().(isset($link)?$link:'');?>" class="btn btn-lg btn-primary btn-flat">Kembali Ke Halaman Awal</a>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->
