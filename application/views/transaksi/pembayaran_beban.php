<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">

    <section class="content-header">
      <h1>
        Pembayaran & Pemindahan
      </section>
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
                <h3 class="box-title">Pembayaran</h3>
              </div>
              <div class="box-body box-profile table-responsive">
                <form class="" onsubmit="return cek_posting()" action="<?php echo current_url();?>" method="post">
                  <input name="no" type="hidden" value ="<?php echo $no;?>"class="form-control" placeholder="Masukkan Nomor">
                  <div class="form-group has-feedback">
                    <label>Deskripsi</label>
                    <input value="" id="keterangan" name="keterangan" type="text" class="form-control" placeholder="Otomatis" readonly="readonly">
                    <?php
                    $akun='';
                    $akun.="<option></option>";
                    $akun2='';
                    $akun2.="<option></option>";
                    foreach ($query as $row) {
                      $akun.="<option class=\"form-control\" value=\"".$row->kode_akun."\">".$row->nama_akun."</option>";
                    }
                    foreach ($query2 as $row) {
                      $akun2.="<option class=\"form-control\" value=\"".$row->kode_akun."\">".$row->nama_akun."</option>";
                    }
                    ?>
                    <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>Beban yang dibayar</th>
                          <th>Metode pembayaran</th>
                          <th>Jumlah</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <select name="kode_akun" id="kode_akun" class="form-control" onchange="abcd();">
                              <?php
                              echo $akun;
                              ?>
                            </select>
                          </td>
                          <td>
                            <select name="kode_akun_kas" class="form-control">
                              <?php
                              echo $akun2;
                              ?>
                            </select>
                          </td>
                          <td>
                            <div>
                              <input name="nilai" autocomplete="off" class="number form-control" id="nilai" type="text">
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
                </form>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
            <?php
            $kasbesar=0;
            $kaskecil=0;
            foreach ($kas as $row) {
              if ($row->kode_akun==101) {
                $kasbesar=$row->nilai;
              }elseif ($row->kode_akun==102) {
                $kaskecil=$row->nilai;
              }
            }
            ?>
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Pemindahan</h3>
              </div>
              <div class="box-body box-profile table-responsive">
                <form class="" onsubmit="<?php echo($kaskecil>0?'true':'false');?>;" action="<?php echo current_url();?>" method="post">
                  <input name="no" type="hidden" value ="<?php echo $no;?>"class="form-control">
                  <div class="form-group has-feedback">
                    <label>Deskripsi</label>
                    <input name="keterangan" type="text" class="form-control" value="Pemindahan Dana Kasir" readonly="readonly">
                    <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>Dipindah ke</th>
                          <th>Dipindah dari</th>
                          <th>Jumlah</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <input type="hidden" name="kode_akun" value="101">
                            Kas (<?php echo number_format($kasbesar,0,",",".");?>)
                          </td>
                          <td>
                            <input type="hidden" name="kode_akun_kas" value="102">
                            Kas Kecil /Kasir (<?php echo number_format($kaskecil,0,",",".");?>)
                          </td>
                          <td>
                            <div>
                              <input name="nilai" autocomplete="off" value="<?php echo number_format($kaskecil,0,",",".");?>" class="number form-control" id="nilai" type="text" readonly="readonly">
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
                </form>
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

    function abcd()
    {
      $('#keterangan').val('Pembayaran '+$('#kode_akun option:selected').text());
    }
    function cek_posting()
    {
      if($('#nilai').val()>0){
        return true;
      }else{
        return FALSE;
      }
    }

    </script>
