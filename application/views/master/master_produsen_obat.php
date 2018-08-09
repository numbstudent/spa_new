<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">

    <section class="content-header">
      <h1>
          Master / Master Produsen Obat <span><button type="button" class="btn btn-primary pull-right btn-flat" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle"></i>  Tambah Produsen Obat Baru</button></span>
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
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-circle"></i>  Tambah Produsen Obat</h4>
          </div>
          <?php echo form_open(current_url());?>
          <div class="modal-body">
              <div class="form-group has-feedback">
                <label>Kode Produsen Obat</label>
                <input value="" name="kode_produsen" type="text" maxlength="5" class="form-control" placeholder="Masukkan Kode Produsen" required>
              </div>
              <div class="form-group has-feedback">
                <label>Nama Produsen Obat</label>
                <input value="" name="nama_produsen" type="text" class="form-control" placeholder="Masukkan Nama Produsen" required>
              </div>
              <div class="form-group has-feedback">
                <label>Alamat / Kota Produsen Obat</label>
                <input value="" name="kota_produsen" type="text" class="form-control" placeholder="Masukkan Kota Produsen" required>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
            <input type="submit" class="btn btn-success btn-flat" value="Tambahkan">
          </div>
        </form>
        </div>
      </div>
    </div>
    <div class="modal fade modal-secondary" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <span id="judul"></span>Detail Produsen
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
            <div class="box-body box-profile table-responsive">
              <?php echo $this->session->flashdata('message'); ?>
              <table class="table table-bordered table-hover" id="example1">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode Produsen</th>
                    <th>Nama Produsen</th>
                    <th>Alamat Produsen</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach ($query as $row) {
                    ?>
                    <tr>
                      <td><?php echo $no;?></td>
                      <td><?php echo $row->kode_produsen;?></td>
                      <td><?php echo $row->nama_produsen;?></td>
                      <td><?php echo $row->kota_produsen;?></td>
                      <td>
                        <form class="" action="index.html" method="post">
                          <a disabled href="#" class="btn btn-flat btn-info btn-sm">Detail</a>
                          <a disabled href="#" class="btn btn-flat btn-warning btn-sm">Ubah</a>
                          <a disabled href="#" class="btn btn-flat btn-danger btn-sm">Hapus</a>
                        </form>
                      </td>
                    </tr>
                    <?php
                    $no++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
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
