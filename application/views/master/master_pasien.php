<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">

    <section class="content-header">
      <h1>
          Master / Master Pasien <span><button type="button" class="btn btn-primary pull-right btn-flat" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle"></i>  Tambah Pasien Baru</button></span>
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
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-circle"></i>  Tambah Pasien</h4>
          </div>
          <?php echo form_open(current_url());?>
          <div class="modal-body">
              <div class="form-group has-feedback">
                <label>Nama Pasien</label>
                <input value="" name="nama_customer" type="text" class="form-control" placeholder="Masukkan Nama Pasien" required>
              </div>
              <div class="form-group has-feedback">
                <label>Alamat Pasien</label>
                <input value="" name="alamat_customer" type="text" class="form-control" placeholder="Masukkan Alamat Pasien" required>
              </div>
              <div class="form-group has-feedback">
                <label>Telepon Pasien</label>
                <input value="" name="telepon_customer" type="number" class="form-control" placeholder="Masukkan Telepon Pasien" required>
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
            <span id="judul"></span>Detail Pasien
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
              <table class="table table-bordered table-hover" id="example1">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Pasien</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach ($pasien as $key) {
                    ?>
                    <tr>
                      <td><?php echo $no;?></td>
                      <td><?php echo $key->nama_customer;?></td>
                      <td><?php echo $key->alamat_customer;?></td>
                      <td><?php echo $key->telepon_customer;?></td>
                      <td>
                        <?php echo form_open(base_url().'master/hapus-pasien') ?>
                        <button disabled type="button" onclick="logbook_detail(<?php echo $key->id_customer.','."'edit'";?>)" class="btn btn-warning btn-flat" data-toggle="modal" data-target="#myModal2">
                          <i class="fa fa-edit"></i>
                        </button>
                        <input type="hidden" name="id" value="<?php echo $key->id_customer;?>">
                        <button disabled type="submit" onclick="return confirm('Apakah anda yakin untuk menghapus data pasien berikut?')" class="btn btn-danger btn-flat">
                          <i class="fa fa-trash"></i>
                        </button>
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
