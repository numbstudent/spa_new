<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">

    <section class="content-header">
      <h1>
        Transasksi / Jurnal Umum
      </section>
      <!-- Modal -->
      <div class="modal fade modal-primary" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form class="" onsubmit="return cek_posting()" action="<?php //echo current_url();?>" method="post">
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
                <form class="" onsubmit="return cek_posting()" action="<?php echo current_url();?>" method="post">
                <div class="form-group has-feedback">
                  <label>Nomor</label>
                  <input name="no" type="text" value ="<?php echo $no;?>"class="form-control" placeholder="Masukkan Nomor">
                </div>
                <!-- <div class="form-group has-feedback">
                  <label>Tanggal</label>
                  <input value="" name="tgl" type="text" class="datepicker form-control" placeholder="Masukkan Tanggal" required>
                </div> -->
                <div class="form-group has-feedback">
                  <label>Deskripsi</label>
                  <input value="" name="keterangan" type="text" class="form-control" placeholder="Masukkan keterangan" required>
                </div>
                <?php
                $akun='';
                $akun.="<option></option>";
                foreach ($query as $row) {
                  $akun.="<option class=\"form-control\" value=\"".$row->kode_akun."\">".$row->nama_akun."</option>";
                }
                ?>
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Akun</th>
                      <th>Debit</th>
                      <th>Kredit</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <select name="kode_akun1" id="kode_akun1">
                          <?php
                          echo $akun;
                          ?>
                        </select>
                      </td>
                      <td>
                        <div>
                          <input onblur="cekDebit(1)" name="debit1" autocomplete="off" class="number" id="debit1" type="text">
                        </div>
                      </td>
                      <td>
                        <div>
                          <input onblur="cekKredit(1)" name="kredit1" autocomplete="off" class="number" id="kredit1" type="text">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <select name="kode_akun2" id="kode_akun2">
                          <?php
                          echo $akun;
                          ?>
                        </select>
                      </td>
                      <td>
                        <div>
                          <input onblur="cekDebit(2)" name="debit2" class="number" id="debit2" type="text">
                        </div>
                      </td>
                      <td>
                        <div>
                          <input onblur="cekKredit(2)" name="kredit2" class="number" id="kredit2" type="text">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <select name="kode_akun3" id="kode_akun3">
                          <?php
                          echo $akun;
                          ?>
                        </select>
                      </td>
                      <td>
                        <div>
                          <input onblur="cekDebit(3)" name="debit3" class="number" id="debit3" type="text">
                        </div>
                      </td>
                      <td>
                        <div>
                          <input onblur="cekKredit(3)" name="kredit3" class="number" id="kredit3" type="text">
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="pull-right">
                  <input type="reset" class="btn btn-secondary btn-flat" value="Reset">
                  <input type="submit" class="btn btn-success btn-flat" value="Post">
                </div>
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
      .replace(/\B(?=(\d{3})+(?!\d))/g, "")
      ;
    });
  });

  function cek_posting()
  {
    var cek=false;
    var debitSum = 0;
    var kreditSum = 0;
    var akunExist = new Array();
    for (var i = 1; i <= 3; i++) {
      if ($.inArray($("#kode_akun"+i).val(),akunExist)==-1) {
        akunExist[akunExist.length] = $("#kode_akun"+i).val();
			} else {
        alert('Data akun tidak boleh sama'+i);
        return false;
			}
      if($("#debit"+i).val()!='' && $("#debit"+i).val()!=null){
        debitSum+=parseInt($("#debit"+i).val());
      }
      if($("#kredit"+i).val()!='' && $("#debit"+i).val()!=null){
        kreditSum+=parseInt($("#kredit"+i).val());
      }
    }
    if (debitSum!=kreditSum) {
      alert('Jumlah debit dan kredit tidak seimbang');
      alert(debitSum);
      alert(kreditSum);
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

function cekDebit(i) {
	var debit = $("#debit"+i);
	var kredit = $("#kredit"+i);
	if (debit.val() != '' && debit.val() != '0' ) {
		kredit.attr("disabled", "true");
	} else {
		kredit.removeAttr("disabled");
	}
}

function cekKredit(i) {
	var debit = $("#debit"+i);
	var kredit = $("#kredit"+i);
	if (kredit.val() != '' && kredit.val() != '0' ) {
		debit.attr("disabled", "true");
	} else {
		debit.removeAttr("disabled");
	}
}
  </script>
