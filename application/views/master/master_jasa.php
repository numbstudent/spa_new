<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">

    <section class="content-header">
      <h1>
        Master / Master Jasa <span><button type="button" class="btn btn-primary pull-right btn-flat" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle"></i>  Tambah Jasa Baru</button></span>
      </h1>
      <h1>

      </h1>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-circle"></i>  Tambah Jasa Medis</h4>
          </div>
          <?php echo form_open(current_url());?>
          <div class="modal-body">
            <div class="row">
              <div class="form-group has-feedback col-lg-6">
                <label>Kode Jasa</label>
                <input id="kode_jasa" maxlength="5" name="kode_jasa" type="text" class="form-control" placeholder="Masukkan kode jasa" required>
              </div>
              <div class="form-group has-feedback col-lg-6">
                <label>Nama Jasa</label>
                <input value="" name="nama_jasa" type="text" class="form-control" placeholder="Masukkan Nama Jasa" required>
              </div>
              <div class="form-group has-feedback col-lg-6">
                <label>Harga Jual</label>
                <input value="" name="harga_jual" type="text" class="form-control number" placeholder="Masukkan Harga Jual" required>
              </div>
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
          <span id="judul"></span>Tambah Jasa Medis
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
                  <th>Kode Jasa</th>
                  <th>Nama Jasa</th>
                  <th>Harga Jual</th>
                  <!-- <th>Action</th> -->
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($query as $key) {
                ?>
                <tr>
                <td><?php echo $no;?></td>
                <td><?php echo $key->kode_jasa;?></td>
                <td><?php echo $key->nama_jasa;?></td>
                <td><?php echo 'Rp '.number_format($key->harga_jual, 0, ',', '.');?></td>
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
$('input.number').keyup(function(event) {

  // skip for arrow keys
  if(event.which >= 37 && event.which <= 40) return;

  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    ;
  });
});

</script>
