<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">

    <section class="content-header">
      <h1>
        Report / Laporan Stok
      </h1>
      <h1>

      </h1>
    </section>
    <!--
    <div class="modal fade modal-secondary" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <span id="judul"></span>Detail Stok
          </div>
          <div class="modal-body" id="isimodal">
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>-->
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-lg-12">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div id="section-to-print">
            <div class="box-body box-profile table-responsive">
              <h3 class="box-title">Laporan Stok Tanggal <?php echo $tanggal; ?></h3>
              <table class="table table-bordered table-hover" id="">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Item</th>
                    <th>Jumlah</th>
                    <th>Harga Jual</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach ($query as $row) {
                    ?>
                    <tr>
                      <td><?php echo $no;?></td>
                      <td><?php echo $row->nama_obat;?></td>
                      <td><?php echo $row->stok;?></td>
                      <td><?php echo number_format($row->harga_jual,2,",",".");?></td>
                    </tr>
                    <?php
                    $no++;
                  }
                  ?>
                </tbody>
              </table>
              <button onclick="window.print();" class="no-print btn btn-default"><i class="fa fa-print"></i> Print</button>
            </div>
            <!-- /.box-body -->
          </div>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url().'asset/';?>plugins/jQuery/jQuery-2.2.0.min.js"></script>
