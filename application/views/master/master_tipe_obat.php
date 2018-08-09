<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">

    <section class="content-header">
      <h1>
        Pasien <span><button type="button" class="btn btn-primary pull-right btn-flat" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle"></i>  Registrasi Pasien Baru</button></span>
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
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-circle"></i>  Registrasi Pasien Baru</h4>
          </div>
          <?php echo form_open(base_url().'pasien/pendaftaran-pasien');?>
          <div class="modal-body">
              <div class="form-group has-feedback">
                <label>Nama Lengkap</label>
                <input value="" name="nama_lengkap" type="text" class="form-control" placeholder="Masukkan Nama Lengkap" required>
              </div>
              <div class="form-group has-feedback">
                <label>Nama Chinese</label>
                <input value="" name="nama_chinese" type="text" class="form-control" placeholder="Masukkan Nama Chinese" required>
              </div>
              <div class="form-group has-feedback">
                <label>Nama Panggilan</label>
                <input value="" name="nama_panggilan" type="text" class="form-control" placeholder="Masukkan Nama Panggilan" required>
              </div>
              <div class="form-group has-feedback">
                <label>Jenis Kelamin</label>
                <div class="radio">
                  <label>
                    <input type="radio" name="jenis_kelamin" id="optionsRadios1" value="L" checked>
                    Laki-laki
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="jenis_kelamin" id="optionsRadios2" value="P">
                    Perempuan
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label>Tanggal Lahir</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="tanggal_lahir" class="form-control pull-right" id="datepicker" required="required">
                </div>
                <!-- /.input group -->
              </div>
              <div class="form-group has-feedback">
                <label>Alamat</label>
                <textarea value="" name="alamat" type="text" class="form-control" placeholder="Masukkan Alamat" required></textarea>
              </div>
              <div class="form-group has-feedback">
                <label>Telepon</label>
                <input value="" name="telepon" type="number" class="form-control" placeholder="Masukkan Telepon" required>
              </div>
              <div class="form-group has-feedback">
                <label>Status</label>
                <div class="radio">
                  <label>
                    <input type="radio" name="status" id="optionsRadios1" value="1" required>
                    Belum Menikah
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="status" id="optionsRadios2" value="2">
                    Menikah
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="status" id="optionsRadios2" value="3">
                    Tidak Tahu
                  </label>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
            <input type="submit" class="btn btn-success btn-flat">
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
                    <th>Nama</th>
                    <th>Nama Panggilan</th>
                    <th>Nama Chinese</th>
                    <th>Detail</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach ($pasien as $key) {
                    ?>
                    <tr>
                      <td><?php echo $no;?></td>
                      <td><?php echo $key->nama_lengkap;?></td>
                      <td><?php echo $key->nama_panggilan;?></td>
                      <td><?php echo $key->nama_chinese;?></td>
                      <td>
                        <?php echo form_open(base_url().'pasien/hapus-pasien') ?>
                        <button type="button" onclick="logbook_detail(<?php echo $key->id.','."'view'";?>)" class="btn btn-info btn-flat" data-toggle="modal" data-target="#myModal2">
                          <i class="fa fa-search"></i>
                        </button>
                        <button type="button" onclick="logbook_detail(<?php echo $key->id.','."'edit'";?>)" class="btn btn-warning btn-flat" data-toggle="modal" data-target="#myModal2">
                          <i class="fa fa-edit"></i>
                        </button>
                        <input type="hidden" name="id" value="<?php echo $key->id;?>">
                        <button type="submit" onclick="confirm('Apakah anda yakin untuk menghapus data pasien berikut?')" class="btn btn-danger btn-flat">
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
