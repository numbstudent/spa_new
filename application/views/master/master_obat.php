<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">

    <section class="content-header">
      <h1>
        Master / Master Obat <span><button type="button" class="btn btn-primary pull-right btn-flat" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle"></i>  Tambah Obat Baru</button></span>
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
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-circle"></i>  Tambah Obat Baru</h4>
          </div>
          <?php echo form_open(current_url());?>
          <div class="modal-body">
            <div class="row">
              <div class="form-group has-feedback col-lg-12">
                <label>Golongan Obat</label>
                <select name="kode_jenis" id="kode_jenis" class="form-control" onchange="cari_kode();">
                  <option value="">--Silahkan pilih--</option>
                  <?php
                  foreach ($query4 as $row) {
                    ?>
                    <option value="<?php echo $row->kode_jenis;?>"><?php echo $row->nama_jenis;?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <div class="form-group has-feedback col-lg-6">
                <label>Kode Obat</label>
                <input readonly id="kode_obat" name="kode_obat" type="text" class="form-control" placeholder="Pilih Golongan Obat" required>
              </div>
              <div class="form-group has-feedback col-lg-6">
                <label>Nama Obat</label>
                <input value="" name="nama_obat" type="text" class="form-control" placeholder="Masukkan Nama Obat" required>
              </div>
              <div class="form-group has-feedback col-lg-6">
                <label>Produsen</label>
                <select name="kode_produsen" class="form-control">
                  <option value="">--Silahkan pilih--</option>
                  <?php
                  foreach ($query2 as $row) {
                    ?>
                    <option value="<?php echo $row->kode_produsen;?>"><?php echo $row->nama_produsen;?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <div class="form-group has-feedback col-lg-6">
                <label>PBF</label>
                <select name="kode_supplier" class="form-control">
                  <option value="">--Silahkan pilih--</option>
                  <?php
                  foreach ($query3 as $row) {
                    ?>
                    <option value="<?php echo $row->kode_supplier;?>"><?php echo $row->nama_supplier;?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <div class="form-group has-feedback col-lg-6">
                <label>Harga Beli Kemasan</label>
                <input id="harga_beli2" value="" name="harga_beli" type="number" placeholder="Masukkan Harga Beli" class="form-control" required>
              </div>
              <div class="form-group has-feedback col-lg-6">
                <label>Stok Awal</label>
                <input value="0" readonly name="stok_obat" type="text" class="form-control number" placeholder="Masukkan Stok Awal" required>
              </div>
              <div class="form-group has-feedback col-lg-6">
                <label>Harga Jual Isi</label>
                <input value="" name="harga_jual" type="text" class="form-control number" placeholder="Masukkan Harga Jual" required>
              </div>

              <div class="form-group has-feedback col-lg-6">
                <label>Satuan Kemasan</label>
                <input value="" name="satuan" type="text" class="form-control" placeholder="Masukkan Satuan Kemasan" required>
              </div>
              <div class="form-group has-feedback col-lg-6">
                <label>Isi Kemasan</label>
                <input value="" name="isi" type="text" class="form-control number" placeholder="Masukkan Jumlah Isi Kemasan" required>
              </div>
              <div class="form-group has-feedback col-lg-6">
                <label>Satuan Isi</label>
                <input value="" name="satuan_isi" type="text" class="form-control" placeholder="Masukkan Satuan Isi" required>
              </div>
              <div class="form-group has-feedback col-lg-6">
                <label>Minimum Stok Isi</label>
                <input value="" name="min_stok" type="text" value="0" class="form-control number" placeholder="Masukkan Minimum Stok" required>
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
          <span id="judul"></span>Tambah Obat Baru
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
                  <th>Kode Obat</th>
                  <th>Nama Obat</th>
                  <th>Golongan Obat</th>
                  <th>Harga Beli</th>
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
                <td><?php echo $key->kode_obat;?></td>
                <td><?php echo $key->nama_obat;?></td>
                <td><?php echo $key->kode_jenis;?></td>
                <td><?php echo 'Rp '.number_format($key->harga_beli, 0, ',', '.');?></td>
                <td><?php echo 'Rp '.number_format($key->harga_jual, 0, ',', '.');?></td>
                <!-- <td>
                <?php echo form_open(base_url().'pasien/hapus-pasien') ?>
                <button disabled type="button" onclick="logbook_detail(<?php echo $key->kode_obat.','."'view'";?>)" class="btn btn-info btn-flat" data-toggle="modal" data-target="#myModal2">
                <i class="fa fa-search"></i>
              </button>
              <button disabled type="button" onclick="logbook_detail(<?php echo $key->kode_obat.','."'edit'";?>)" class="btn btn-warning btn-flat" data-toggle="modal" data-target="#myModal2">
              <i class="fa fa-edit"></i>
            </button>
            <input type="hidden" name="id" value="<?php echo $key->kode_obat;?>">
            <button disabled type="submit" onclick="confirm('Apakah anda yakin untuk menghapus data pasien berikut?')" class="btn btn-danger btn-flat">
            <i class="fa fa-trash"></i>
          </button>
        </form>
      </td> -->
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

function cari_kode()
{
  kode_jenis = $('#kode_jenis').val();
  $.ajax({
    type: 'POST',
    url: '<?php echo base_url()."ajax/get-kode-obat"?>',
    data: {
      'kode_jenis':kode_jenis
    },
    success: function(resp) {
      var obj = jQuery.parseJSON(resp);
      $("#kode_obat").val(obj.val1);
    },
    error: function(xhr, status, error) {
      var err = eval("(" + xhr.responseText + ")");
      alert(err.Message);
    }
  });
}
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
