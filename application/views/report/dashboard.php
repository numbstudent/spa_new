<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">

    <section class="content-header">
      <h1>
        Report / Laporan Harian
      </h1>
      <h1>

      </h1>
    </section>
    <!-- Modal -->
    <div class="modal fade modal-primary" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-circle"></i>  Tambah Golongan Obat</h4>
          </div>
          <div class="modal-body">
              <div class="form-group has-feedback">
                <label>ID Golongan</label>
                <input value="" name="kode_golongan" maxlength="5" type="text" class="form-control" placeholder="Masukkan Kode Golongan" required>
              </div>
              <div class="form-group has-feedback">
                <label>Nama Golongan</label>
                <input value="" name="nama_golongan" type="text" class="form-control" placeholder="Masukkan Nama Golongan" required>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
            <input type="submit" class="btn btn-success btn-flat" value="Tambahkan">
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade modal-secondary" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <span id="judul"></span>Detail Golongan Obat
          </div>
          <div class="modal-body" id="isimodal">
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-lg-12">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Pilih Tanggal</h3>
            </div>
            <div id="section-to-print">
            <div class="box-body box-profile table-responsive">
              <h3 class="box-title">Laporan Harian Tanggal <?php echo $tanggal; ?></h3>
              <table class="table table-bordered table-hover" id="">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Transaksi</th>
                    <th>Pemasukan</th>
                    <th>Pengeluaran</th>
                  </tr>
                </thead>
                <tbody>

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
<script type="text/javascript">

function logbook_detail(id,doing)
{
  $.ajax({
    type: 'POST',
    url: '<?php echo base_url()."pasien/ajax-get-pasien-details"?>',
    data: {
      'id':id,
      'do':doing
    },
    success: function(resp) {
      var obj = jQuery.parseJSON(resp);
      $("#isimodal").html(obj.val1);
      if (doing=='edit') {
        $("#judul").html('Ubah ');
      }
    },
    error: function(xhr, status, error) {
      var err = eval("(" + xhr.responseText + ")");
      alert(err.Message);
      $("#isimodal").html(err.Message);
    }
  });
}
</script>
