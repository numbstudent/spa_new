<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">

    <section class="content-header">
      <h1>
        Transasksi / Master Akun
    </section>
    <!-- Modal -->
    <div class="modal fade modal-primary" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form class="" onsubmit="return cek_pembayaran()" action="<?php echo current_url();?>" method="post">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-circle"></i>  Pembayaran</h4>
            </div>
            <div class="modal-body">
              <div id="isimodal2">

              </div>
              <label> Total Biaya</label>
              <input type="text" readonly id="totalbiaya" class="form-control">
              <label> Kekurangan Pembayaran</label>
              <input type="text" readonly id="kekurangan" class="form-control">
              <label> Jumlah Pembayaran</label>
              <input type="hidden" id="no_faktur_beli" class="form-control" name="no_faktur_beli">
              <input type="number" id="jumlahbayar" required class="form-control" name="jumlah_bayar">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
              <input type="submit" class="btn btn-success btn-flat" value="Bayar">
            </div>
          </form>
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
            <div class="box-body box-profile table-responsive">
              <table class="table table-bordered table-hover" id="example1">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode Akun</th>
                    <th>Nama Akun</th>
                    <th>Kategori</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach ($query as $row) {
                    ?>
                    <tr>
                      <?php
                      switch ($row->kategori) {
                        case '1':
                        $kategori = "Aktiva";
                        break;
                        case '2':
                        $kategori = "Utang";
                        break;
                        case '3':
                        $kategori = "Modal";
                        break;
                        case '4':
                        $kategori = "Pendapatan";
                        break;
                        case '5':
                        $kategori = "Beban";
                        break;
                        default:
                        # code...
                        break;
                      }
                      ?>
                      <td><?php echo $no;?></td>
                      <td><?php echo $row->kode_akun;?></td>
                      <td><?php echo $row->nama_akun;?></td>
                      <td><?php echo $kategori;?></td>
                      <td>
                          <button type="button" onclick="lihat_detail('<?php echo $row->kode_akun;?>')" class="btn btn-flat btn-info btn-sm" data-toggle="modal" data-target="#myModal2">Detail</button>
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

function cek_pembayaran()
{
  var cek=false;
  if (parseInt($("#jumlahbayar").val())>parseInt($("#kekurangan").val())) {
    alert('Jumlah pembayaran terlalu besar');
    $("#jumlahbayar").val('');
  }else{
    cek = confirm('Apakah anda ingin melakukan pembayaran?');
  }
  return cek;
}

function lihat_detail(id)
{
  $.ajax({
    type: 'POST',
    url: '<?php echo base_url()."ajax/get-detail-pembayaran"?>',
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
function lihat_detail2(id,totalbiaya,kekurangan,no_faktur_beli)
{
  $.ajax({
    type: 'POST',
    url: '<?php echo base_url()."ajax/get-detail-pembayaran"?>',
    data: {
      'id':id
    },
    success: function(resp) {
      var obj = jQuery.parseJSON(resp);
      $("#isimodal2").html(obj.val1);
      $("#kekurangan").val(kekurangan);
      $("#totalbiaya").val(totalbiaya);
      $("#no_faktur_beli").val(no_faktur_beli);
    },
    error: function(xhr, status, error) {
      var err = eval("(" + xhr.responseText + ")");
      $("#isimodal2").html(err.Message);
    }
  });
}
</script>
