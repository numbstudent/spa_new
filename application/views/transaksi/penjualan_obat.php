<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">

    <section class="content-header">
      <h1>
        Transasksi / Penjualan Obat
    </section>
    <!-- Modal -->
    <div class="modal fade modal-primary" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-circle"></i>  Tambah Penjualan</h4>
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
            <h4 class="modal-title" id="myModalLabel">Detail Penjualan</h4>
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
              <div class="form-group has-feedback col-lg-12">
                <label>Nama Customer</label>
                <input id="id_pasien1" onfocus="$(this).val('');" type="text" value="Customer Bebas" class="form-control" value="1">
              </div>
              <div class="form-group has-feedback col-lg-2">
                <label>Nama Obat</label>
                <input id="obat" type="text" onfocus="removeValue();" class="form-control" placeholder="Masukkan Nama Item" required>
                <input id="kode_obat" type="hidden">
                <input id="nama_obat" type="hidden">
              </div>
              <div class="form-group has-feedback col-lg-2">
                <label>Stok Grosir</label>
                <input id="min_stok" type="hidden" class="form-control">
                <input id="stok" type="text" class="form-control" readonly>
              </div>
              <div class="form-group has-feedback col-lg-2">
                <label>Satuan</label>
                <input id="satuan_obat" type="text" class="form-control" readonly>
              </div>
              <div class="form-group has-feedback col-lg-2">
                <label>Harga</label>
                <input id="harga_jual" readonly type="text" class="form-control">
              </div>
              <div class="form-group has-feedback col-lg-2">
                <label>Jumlah</label>
                <input onclick="cekInput();" id="jumlah" type="text" min="1" class="form-control number" required>
              </div>
              <div class="form-group has-feedback col-lg-2">
                <label>Tambah</label>
                <button onclick="tambah_item()" type="submit" class="pull-right btn btn-primary btn-flat" name="button"><i class="fa fa-plus-circle"></i> Tambahkan Item</button>
              </div>
              <!-- jasa -->
              <div class="form-group has-feedback col-lg-6">
                <label>Nama Jasa</label>
                <input id="jasa" type="text" onfocus="removeValue();" class="form-control" placeholder="Masukkan Nama Jasa" required>
                <input id="kode_jasa" type="hidden">
                <input id="nama_jasa" type="hidden">
              </div>
              <div class="form-group has-feedback col-lg-4">
                <label>Harga</label>
                <input id="harga_jual2" readonly type="text" class="form-control">
              </div>
              <div class="form-group has-feedback col-lg-2">
                <label>Tambah</label>
                <button onclick="tambah_jasa()" type="submit" class="pull-right btn btn-primary btn-flat" name="button"><i class="fa fa-plus-circle"></i> Tambahkan Jasa</button>
              </div>
              <!--end-->
              <div class="row">
                <hr>
              </div>
              <div id="section-to-print">
                <h3>Nomor Faktur Jual: <?php echo $no_faktur_jual; ?><span class="pull-right">Customer: <span id="nama_customer">Customer Bebas</span></span></h3>
                <form onsubmit="return checkform();" action="<?php echo current_url();?>" method="post">
                  <table class="table">
                    <thead>
                      <tr>
                        <td>Nama Item</td>
                        <td>Satuan</td>
                        <td>Harga Jual</td>
                        <td>Jumlah Item</td>
                        <td>PPN</td>
                        <td>Total</td>
                      </tr>
                    </thead>
                    <tbody id="pilihan">

                    </tbody>
                    <tfoot>
                      <tr>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>Total</td>
                        <td><b><span id="totalbeli">0</span></b></td>
                      </tr>
                    </tfoot>
                  </table>
                  <input id="id_pasien2" name="id_pasien" type="hidden" value="1">
                  <input type="hidden" id="jumlahitem" name="jumlahitem" value="0">
                  <input type="hidden" name="no_faktur_jual" value="<?php echo $no_faktur_jual; ?>">
                  <div class="pull-right">
                    <button class="no-print btn btn-secondary btn-flat" onclick="window.location.reload(true)"><i class="fa fa-refresh"></i> Reset</button>
                    <button type="submit" class="no-print btn btn-primary btn-flat"><i class="fa fa-check"></i> Cetak Struk</button>
                  </div>
                </form>
              </div>
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
                    <th>No Penjualan</th>
                    <th>Tanggal</th>
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
                      <td><?php echo str_pad($row->no_faktur_jual,7,"0",'0');?></td>
                      <td><?php echo $row->tgl_transaksi;?></td>
                      <td>
                        <form onsubmit="return confirm('Apakah yakin akan dihapus?');" action="<?php echo base_url().'master/delete-po'?>" method="post">
                          <button type="button" onclick="lihat_detail('<?php echo $row->no_faktur_jual;?>')" class="btn btn-flat btn-info btn-sm" data-toggle="modal" data-target="#myModal2">Detail</button>
                          <a href="#" class="btn btn-flat btn-warning btn-sm">Ubah</a>
                          <input type="hidden" name="no_faktur_jual" value="<?php echo $row->no_faktur_jual;?>">
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
    condition2 =  confirm('Apakah yakin akan melakukan penjualan?');
  }

  if(!condition||!condition2) {
    return false;
  }else{
    window.print();
  }
}

function removeValue()
{
  $('#jumlah').val('');
  $('#obat').val('');
  $('#jasa').val('');
}

function cekInput()
{
  if($('#obat').val()==""&&$('#jasa').val()==""){
    alert('isi dahulu obatnya');
    $('#jumlah').val('');
    $('#obat').focus();
  }
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
    url: '<?php echo base_url()."ajax/get-detail-jual"?>',
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
var totalbeli = parseInt($('#totalbeli').text().replace(/\./g,""));
function tambah_item()
{
  var kode_obat = $('#kode_obat').val();
  var nama_obat = $('#nama_obat').val();
  var jumlah = parseInt($('#jumlah').val().replace(/\./g,""));
  var satuan = $('#satuan_obat').val();
  var harga_jual = $('#harga_jual').val();
  var stok = parseInt($('#stok').val().replace(/\./g,""));
  var min_stok = parseInt($('#min_stok').val().replace(/\./g,""));
  var total = ($('#jumlah').val().replace(/\./g,"")*$('#harga_jual').val().replace(/\./g,""));
  var ppn = total/10;
  var total = total+ppn;
  if (stok>min_stok&&jumlah<=stok) {
    if (kode_obat!=''&&jumlah!='') {
      totalbeli += total;
      total = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      var valtotalbeli = totalbeli.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      $('#jumlahitem').val(ctr);
      $('#totalbeli').html(valtotalbeli);
      $('<tr>').appendTo('#pilihan');
      $('<input type="hidden" value="'+kode_obat+'" readonly name="kode_obat'+ctr+'">').appendTo('#pilihan');
      $('<td><input class="form-control" type="text" value="'+nama_obat+'" readonly name="nama_obat'+ctr+'"></td>').appendTo('#pilihan');
      $('<td><input class="form-control" type="text" value="'+satuan+'" readonly name="satuan'+ctr+'"></td>').appendTo('#pilihan');
      $('<td><input class="form-control" type="text" value="'+harga_jual+'" readonly name="harga_jual'+ctr+'"></td>').appendTo('#pilihan');
      $('<td><input class="form-control" type="text" value="'+jumlah+'" readonly name="jumlah'+ctr+'"></td>').appendTo('#pilihan');
      $('<td><input class="form-control" type="text" value="'+ppn+'" disabled"></td>').appendTo('#pilihan');
      $('<td><input class="form-control" type="text" value="'+total+'" disabled"></td>').appendTo('#pilihan');
      $('<input type="hidden" value="obat" name="tipe'+ctr+'">').appendTo('#pilihan');
      $('</tr>').appendTo('#pilihan');
      ctr++;
    }else {
      $("#anjay").html('Silahkan isi dahulu obat dan jumlahnya');
    }
  }else{
    $("#anjay").html('Stok HABIS!');
  }
}

function tambah_jasa()
{
  var kode_jasa = $('#kode_jasa').val();
  var nama_jasa = $('#nama_jasa').val();
  var harga_jual = $('#harga_jual2').val().replace(/\./g,"");
  var total = parseInt($('#harga_jual2').val().replace(/\./g,""));
  if (kode_obat!='') {
    totalbeli += total;
    total = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    var valtotalbeli = totalbeli.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    $('#jumlahitem').val(ctr);
    $('#totalbeli').html(valtotalbeli);
    $('<tr>').appendTo('#pilihan');
    $('<input type="hidden" value="'+kode_jasa+'" readonly name="kode_obat'+ctr+'">').appendTo('#pilihan');
    $('<td><input class="form-control" type="text" value="'+nama_jasa+'" readonly name="nama_obat'+ctr+'"></td>').appendTo('#pilihan');
    $('<td><input class="form-control" type="text" value="-" readonly name="satuan'+ctr+'"></td>').appendTo('#pilihan');
    $('<td><input class="form-control" type="text" value="'+harga_jual+'" readonly name="harga_jual'+ctr+'"></td>').appendTo('#pilihan');
    $('<td><input class="form-control" type="text" value="1" readonly name="jumlah'+ctr+'"></td>').appendTo('#pilihan');
    $('<td><input class="form-control" type="text" value="0" disabled"></td>').appendTo('#pilihan');
    $('<td><input class="form-control" type="text" value="'+total+'" disabled"></td>').appendTo('#pilihan');
    $('<input type="hidden" value="jasa" name="tipe'+ctr+'">').appendTo('#pilihan');
    $('</tr>').appendTo('#pilihan');
    ctr++;
  }else {
    $("#anjay").html('Silahkan isi dahulu jasa');
  }
}


$(function() {
  $("#obat").autocomplete({
    source: function (request, response) {
      $('#kode_obat').val('');
      $('#nama_obat').val('');
      $('#satuan_obat').val('');
      $('#harga_jual').val('');
      $('#stok').val('');
      $('#min_stok').val('');
      $('#stokecer').val('');
      $.ajax({
        type: "POST",
        url:"<?php echo base_url()."ajax/get-obat-penjualan"?>",
        data: request,
        success: response,
        dataType: 'json'
      });
      // console.log($('#kode_obat').val());
    },
    minLength: 3,
    select:function(event, ui){
        $('#kode_obat').val(ui.item.kode_obat);
        $('#nama_obat').val(ui.item.label);
        $('#satuan_obat').val(ui.item.satuan);
        $('#stok').val(ui.item.stok);
        $('#min_stok').val(ui.item.min_stok);
        $('#harga_jual').val(ui.item.harga_jual.replace(/\B(?=(\d{3})+(?!\d))/g, "."));
        $("#anjay").html('');
        // console.log($('#kode_obat').val());,
    },
    focus: function(event, ui) {
      event.preventDefault();
      $('#obat').val(ui.item.label);
    }
  });
  $("#jasa").autocomplete({
    source: function (request, response) {
      $('#kode_jasa').val('');
      $('#nama_jasa').val('');
      $('#harga_jual').val('');
      $.ajax({
        type: "POST",
        url:"<?php echo base_url()."ajax/get-jasa-penjualan"?>",
        data: request,
        success: response,
        dataType: 'json'
      });
      // console.log($('#kode_obat').val());
    },
    minLength: 3,
    select:function(event, ui){
        $('#kode_jasa').val(ui.item.kode_jasa);
        $('#nama_jasa').val(ui.item.label);
        $('#harga_jual2').val(ui.item.harga_jual.replace(/\B(?=(\d{3})+(?!\d))/g, "."));
        $("#anjay").html('');
        // console.log($('#kode_obat').val());,
    },
    focus: function(event, ui) {
      event.preventDefault();
      $('#jasa').val(ui.item.label);
    }
  });
  $("#id_pasien1").autocomplete({
    source: function (request, response) {
      $.ajax({
        type: "POST",
        url:"<?php echo base_url()."ajax/get-pasien"?>",
        data: request,
        success: response,
        dataType: 'json'
      });
    },
    minLength: 3,
    select:function(event, ui){
        $('#id_pasien1').val(ui.item.label);
        $('#id_pasien2').val(ui.item.id_customer);
        $('#nama_customer').html(ui.item.label);
    },
    focus: function(event, ui) {
      event.preventDefault();
      $('#id_pasien1').val(ui.item.label);
    }
  });
});
</script>
