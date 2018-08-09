<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">

    <section class="content-header">
      <h1>
        Transasksi / Purchase Order (PO)
    </section>
    <!-- Modal -->
    <div class="modal fade modal-primary" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-circle"></i>  Tambah PO</h4>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
            <input type="submit" class="btn btn-success btn-flat" value="Tambahkan">
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade modal-primary" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Detail PO</h4>
          </div>
          <div class="modal-body" id="isimodal">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
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
            <div class="box-header with-border">
              <h3 class="box-title">Tambah PO</h3>
              <div class="text-danger">
                <div id="anjay"></div>
              </div>
              <?php if ($this->session->flashdata('message')) {
              ?>
              <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-exclamation"></i> Info!</h4>
                <?php echo $this->session->flashdata('message'); ?>
              </div>
              <?php
              } ?>
            </div>
            <div class="box-body box-profile table-responsive">
              <div class="form-group has-feedback col-lg-6">
                <label>Nama Obat</label>
                <input id="obat" type="text" onfocus="removeValue();" class="form-control" placeholder="Masukkan Nama Item" required>
                <input id="kode_obat" type="hidden">
                <input id="nama_obat" type="hidden">
              </div>
              <div class="form-group has-feedback col-lg-2">
                <label>Harga Beli</label>
                <input id="harga_beli" readonly type="number" class="form-control">
              </div>
              <div class="form-group has-feedback col-lg-2">
                <label>Jumlah</label>
                <input id="jumlah" type="text" min="1" class="form-control number" required>
              </div>
              <div class="form-group has-feedback col-lg-2">
                <label>Satuan</label>
                <input id="satuan_obat" type="text" class="form-control" readonly>
              </div>
              <div class="form-group has-feedback">
                <button onclick="tambah_item()" type="submit" class="pull-right btn btn-primary btn-flat" name="button"><i class="fa fa-plus-circle"></i> Tambahkan Item</button>
              </div>
              <div class="row">
                <hr>
              </div>
              <h3>Nomor PO: <?php echo $no_faktur_pesan; ?></h3>
              <form onsubmit="return checkform();" action="<?php echo current_url();?>" method="post">
              <table class="table">
                <thead>
                  <tr>
                    <td>Nama Item</td>
                    <td>Harga Beli</td>
                    <td>Jumlah Item</td>
                    <td>Satuan</td>
                  </tr>
                </thead>
                <tbody id="pilihan">

                </tbody>
              </table>
              <input type="hidden" id="jumlahitem" name="jumlahitem" value="0">
              <input type="hidden" name="no_faktur_pesan" value="<?php echo $no_faktur_pesan; ?>">
              <input type="hidden" name="kode_supplier" id="kode_supplier" value="">
              <button type="submit" class="pull-right btn btn-primary btn-flat"><i class="fa fa-check"></i> Buat PO</button>
            </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <div class="box box-primary">
            <div class="box-body box-profile table-responsive">
              <table class="table table-bordered table-hover" id="example1">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>No PO</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
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
                      <td><?php echo str_pad($row->no_faktur_pesan,7,"0",'0');?></td>
                      <td><?php echo $row->tgl_transaksi;?></td>
                      <td><?php echo $row->nama_supplier;?></td>
                      <td>
                        <form onsubmit="return confirm('Apakah yakin akan dihapus?');" action="<?php echo base_url().'master/delete-po'?>" method="post">
                          <button type="button" onclick="lihat_detail('<?php echo $row->no_faktur_pesan;?>')" class="btn btn-flat btn-info btn-sm" data-toggle="modal" data-target="#myModal2">Detail</button>
                          <a href="#" class="btn btn-flat btn-warning btn-sm">Ubah</a>
                          <input type="hidden" name="no_faktur_pesan" value="<?php echo $row->no_faktur_pesan;?>">
                          <input type="submit" class="btn btn-flat btn-danger btn-sm" value="Hapus">
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
<script src="<?php echo base_url(); ?>asset/plugins/jQueryUI/jquery-ui.min.js"></script>
<script type="text/javascript">
function checkform()    {
  var condition = true;
  var condition2 = true;

  if($('#jumlahitem').val()==0){
    alert("Isi dahulu data.");
    condition = false;
  }else{
    condition2 =  confirm('Apakah yakin akan membuat PO?');
  }

  if(!condition||!condition2) {
    return false;
  }
}

function removeValue()
{
  $('#jumlah').val('');
  $('#obat').val('');
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

function lihat_detail(id)
{
  $.ajax({
    type: 'POST',
    url: '<?php echo base_url()."ajax/get-detail-po"?>',
    data: {
      'id':id
    },
    success: function(resp) {
      var obj = jQuery.parseJSON(resp);
      $("#isimodal").html(obj.val1);
    },
    error: function(xhr, status, error) {
      var err = eval("(" + xhr.responseText + ")");
      $("#isimodal").html(err.Message);
    }
  });
}

// function isi_temporary(kode_obat)
// {
//   $.ajax({
//     type: 'POST',
//     url: '<?php echo base_url()."ajax/insert-temporary-po"?>',
//     data: {
//       'kode_obat':kode_obat
//     },
//     success: function(resp) {
//       var obj = jQuery.parseJSON(resp);
//       $("#pilihan").html(obj.val1);
//     },
//     error: function(xhr, status, error) {
//       var err = eval("(" + xhr.responseText + ")");
//       alert(err.Message);
//       $("#pilihan").html(err.Message);
//     }
//   });
// }

var ctr = 1;
function tambah_item()
{
  var kode_obat = $('#kode_obat').val();
  var nama_obat = $('#nama_obat').val();
  var jumlah = $('#jumlah').val();
  var satuan = $('#satuan_obat').val();
  var harga_beli = $('#harga_beli').val();
  if (kode_obat!=''&&jumlah!='') {
    $('#jumlahitem').val(ctr);
    $('<tr>').appendTo('#pilihan');
    $('<input type="hidden" value="'+kode_obat+'" readonly name="kode_obat'+ctr+'">').appendTo('#pilihan');
    $('<td><input class="form-control" type="text" value="'+nama_obat+'" readonly name="nama_obat'+ctr+'"></td>').appendTo('#pilihan');
    $('<td><input class="form-control" type="text" value="'+harga_beli+'" readonly name="harga_beli'+ctr+'"></td>').appendTo('#pilihan');
    $('<td><input class="form-control" type="text" value="'+jumlah+'" readonly name="jumlah'+ctr+'"></td>').appendTo('#pilihan');
    $('<td><input class="form-control" type="text" value="'+satuan+'" readonly name="satuan'+ctr+'"></td>').appendTo('#pilihan');
    $('</tr>').appendTo('#pilihan');
    ctr++;
  }else {
    $("#anjay").html('Item dipilih berbeda supplier / Silahkan isi dahulu obat dan jumlahnya');
  }
}


$(function() {
  $("#obat").autocomplete({
    source: function (request, response) {
      $.ajax({
        type: "POST",
        url:"<?php echo base_url()."ajax/get-obat"?>",
        data: request,
        success: response,
        dataType: 'json'
      });
      console.log(request);
    },
    minLength: 3,
    select:function(event, ui){
      if ($('#kode_supplier').val()==""||$('#kode_supplier').val()==ui.item.kode_supplier)
      {
        $('#kode_obat').val(ui.item.kode_obat);
        $('#nama_obat').val(ui.item.label);
        $('#satuan_obat').val(ui.item.satuan);
        $('#kode_supplier').val(ui.item.kode_supplier);
        $('#harga_beli').val(ui.item.harga_beli.replace(/\B(?=(\d{3})+(?!\d))/g, "."));
        $("#anjay").html('');
      }else{
        $('#kode_obat').val('');
        $('#nama_obat').val('');
        $('#satuan_obat').val('');
        $('#kode_supplier').val('');
        $('#harga_beli').val('');
        $("#anjay").html('Item dipilih berbeda supplier');
        // alert('Item dipilih berbeda supplier');
      }
      // isi_temporary(ui.item.kode_obat);

        // $('<tr>').appendTo('#pilihan');
        // $('<td><input type="text" value="'+ui.item.kode_obat+'" readonly name="kode_obat'+ctr+'"></td>').appendTo('#pilihan');
        // $('<td><input type="text" value="'+ui.item.nama_obat+'" readonly name="kode_obat'+ctr+'"></td>').appendTo('#pilihan');
        // $('<td><input type="text" value="'+ui.item.kode_obat+'" readonly name="kode_obat'+ctr+'"></td>').appendTo('#pilihan');
        // $('</tr>').appendTo('#pilihan');
        // $('<input class="form-control col-lg-8" type="text" disabled>').val(ui.item.label).appendTo('#pilihan');
        // $('</div>').appendTo('#pilihan');
        // $('<div class="col-lg-4">').appendTo('#pilihan');
        // $('<input class="form-control col-lg-4" type="text" placeholder="jumlah" name="jumlah[]">').appendTo('#pilihan');
        // $('</div>').appendTo('#pilihan');
    },
    focus: function(event, ui) {
      event.preventDefault();
      $('#obat').val(ui.item.label);
    }
  });
});
</script>
