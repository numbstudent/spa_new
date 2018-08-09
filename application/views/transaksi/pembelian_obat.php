<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">

    <section class="content-header">
      <h1>
        Transasksi / Pembelian Obat
      </h1>
    </section>
    <!-- Modal -->
    <div class="modal fade modal-secondary" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <span id="judul"></span>Detail Pembelian
          </div>
          <div class="modal-body" id="isimodal">
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade modal-secondary" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <?php echo form_open(current_url()); ?>
            <input type="hidden" name="no_faktur_beli" value="<?php echo $no_faktur_beli;?>">
            <div class="modal-header">
              <span id="judul"></span>Pembelian berdasarkan PO
            </div>
            <div class="modal-body">
              <div id="isimodal2">
              </div>
              <div class="form-group has-feedback">
                <label>Jenis Pembayaran</label>
                <div class="radio">
                  <label>
                    <input type="radio" name="jenis_bayar" id="optionsRadios1" value="1" checked>
                    Cash
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="jenis_bayar" id="optionsRadios2" value="2">
                    Kredit
                  </label>
                </div>
              </div>
              <div class="form-group has-feedback col-lg-6">
                <label>Tanggal Jatuh Tempo</label>
                <input type="text" name="jatuh_tempo" id="datepicker" class="form-control" value="" required>
              </div>
              <div class="form-group has-feedback col-lg-6">
                <label>Discount(Rp)</label>
                <input type="text" id="discount" onfocus="$(this).val('');" name="discount" maxlength="10" class="form-control number" value="0" required>
              </div>
              <div class="form-group has-feedback col-lg-6">
                <label>Pajak(%)</label>
                <input type="text" id="pajak" onfocus="$(this).val('');" name="pajak" maxlength="2" class="form-control number" value="0" required>
              </div>
              <div class="form-group has-feedback col-lg-6">
                <label>Harga Akhir</label>
                <h2 id="hargaakhir" class="pull-right"></h2>
              </div>
            </div>
            <div class="modal-footer">
              <input type="submit" class="btn btn-flat btn-success" class="form-control" value="Tambahkan Pembelian">
            </div>
          </form>
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
              <h3 class="box-title">Daftar PO</h3>
            </div>
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
                  foreach ($po as $row) {
                    ?>
                    <tr>
                      <td><?php echo $no;?></td>
                      <td><?php echo str_pad($row->no_faktur_pesan,7,"0",'0');?></td>
                      <td><?php echo $row->tgl_transaksi;?></td>
                      <td><?php echo $row->nama_supplier;?></td>
                      <td>
                          <button type="button" onclick="lihat_detail('<?php echo $row->no_faktur_pesan;?>')" class="btn btn-flat btn-info btn-sm" data-toggle="modal" data-target="#myModal2">Detail</button>
                          <button type="button" onclick="pembelian('<?php echo $row->no_faktur_pesan;?>','<?php echo $row->kode_supplier;?>')" class="btn btn-flat btn-success btn-sm" data-toggle="modal" data-target="#myModal3">Pembelian</button>
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
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Pembelian</h3>
            </div>
            <div class="box-body box-profile table-responsive">
              <?php if ($this->session->flashdata('message')) {
              ?>
              <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-exclamation"></i> Info!</h4>
                <?php echo $this->session->flashdata('message'); ?>
              </div>
              <?php
              } ?>
              <table class="table table-bordered table-hover" id="example1">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>No PO</th>
                    <th>Tanggal PO</th>
                    <th>PBF</th>
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
                      <td><?php echo str_pad($row->no_faktur_beli,7,"0",'0');?></td>
                      <td><?php echo $row->tgl_transaksi;?></td>
                      <td><?php echo $row->nama_supplier;?></td>
                      <td>
                          <button type="button" onclick="lihat_detail_pembelian('<?php echo $row->no_faktur_beli;?>')" class="btn btn-flat btn-info btn-sm" data-toggle="modal" data-target="#myModal2">Detail</button
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
function lihat_detail_pembelian(id)
{
  $.ajax({
    type: 'POST',
    url: '<?php echo base_url()."ajax/get-detail-pembelian"?>',
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
function pembelian(id,kode_supplier)
{
  $.ajax({
    type: 'POST',
    url: '<?php echo base_url()."ajax/get-po-pembelian"?>',
    data: {
      'id':id,
      'kode_supplier':kode_supplier,
    },
    success: function(resp) {
      var obj = jQuery.parseJSON(resp);
      $("#isimodal").html(obj.val1);
      $("#isimodal2").html(obj.val1);
      $('.datepicker').datepicker({
        format: 'yyyy/mm/dd'
      }).on("changeDate", function (date) {
        var selectedDate = date.date;
        var today = new Date();
        var targetDate1= new Date();
        var targetDate2= new Date();
        targetDate1.setDate(today.getDate()+ 30);
        targetDate2.setDate(today.getDate()+ 50);
        if( Date.parse(selectedDate) < Date.parse(targetDate1)){
          alert("Tanggal Kadaluwarsa terlalu mepet");
        }else if( Date.parse(selectedDate) < Date.parse(targetDate2)){
          alert("Tanggal Kadaluwarsa cukup mepet");
          // $('#alertObat').show();
        }else{
          // $('#alertObat').hide();
        }
      });
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
        var hargaakhir = $("#totalbeli").text().replace(/\./g,"");
        var discount = $("#discount").val().replace(/\./g,"");
        var pajak = $("#pajak").val();
        // $("#hargaakhir").val((pajak+1)*(hargaakhir-(hargaakhir*discount/100))/100);
        var hargaakhir2 = (hargaakhir-discount)+((hargaakhir-discount)*pajak/100);
        $("#hargaakhir").text("Rp "+ hargaakhir2);
      });
    },
    error: function(xhr, status, error) {
      var err = eval("(" + xhr.responseText + ")");
      $("#isimodal").html(err.Message);
      $("#isimodal2").html(err.Message);
    }
  });
}
</script>
