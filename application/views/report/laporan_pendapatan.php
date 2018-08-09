<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">

    <section class="content-header">
      <h1>
        Report / Laporan Pendapatan Bulanan
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
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-circle"></i>  Tambah Golongan Obat</h4>
          </div>
          <?php echo form_open(current_url());?>
          <div class="modal-body">
            <div class="form-group has-feedback">
              <label>ID Golongan</label>
              <input value="" name="kode_golongan" maxlength="5" type="text" class="form-control" placeholder="Masukkan Kode Golongan" required>
            </div>
            <div class="form-group has-feedback">
              <label>Nama Golongan</label>
              <input value="" name="nama_golongan" type="text" class="form-control" placeholder="Masukkan Nama Golongan" required>
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
          <span id="judul"></span>Detail Golongan Obat
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
          <div class="box-header">
            <h3 class="box-title">Pilih Bulan</h3>
            <?php echo form_open(base_url().'report/laporan-bulanan');?>
            <div class="col-lg-6 form-group has-feedback">
              <div class="col-lg-6">
                <select class="form-control" name="bulan">
                  <option value="1">Januari</option>
                  <option value="2">Februari</option>
                  <option value="3">Maret</option>
                  <option value="4">April</option>
                  <option value="5">Mei</option>
                  <option value="6">Juni</option>
                  <option value="7">Juli</option>
                  <option value="8">Agustus</option>
                  <option value="9">September</option>
                  <option value="10">Oktober</option>
                  <option value="11">Nopember</option>
                  <option value="12">Desember</option>
                </select>
              </div>
              <div class="col-lg-6">

                <select class="form-control" name="tahun">
                  <?php
                  for ($i=2015; $i <= date("Y"); $i++) {
                    echo '<option>'.$i.'</option>';
                  }
                  ?>
                </select>

              </div>
            </div>
            <input type="submit" class="col-lg-6 btn btn-success btn-flat" value="Cari Laporan">
          </form>
        </div>
        <?php
        $beli="";
        $jasa="";
        $obat="";
        $beban="";

        $nobeli = $nojasa = $noobat= $nobeban = 0;
        $saldobeli = $saldojasa = $saldoobat= $saldobeban = 0;

        foreach ($query as $row) {
          $item = $row->item;
          if(!is_null($row->penjualan)){
            $item = str_replace(" (Pcs)", "", $item);
          }else{
            $item = str_replace(" (Box)", "", $item);
          }
          if ($row->tipe=='beli') {
            $beli.='<tr>';
            $beli.='<td>'.$nobeli.'</td>';
            $beli.='<td>'.$row->tgl_transaksi.'</td>';
            $beli.='<td>'.'Pembayaran kepada '.$row->target.'('.$item.')'.'</td>';
            $beli.='<td class="text-right>'.(is_null($row->pembelian)?'':number_format($row->pembelian,2,",",".")).'</td>';
            $saldobeli += $row->pembelian;
            $nobeli++;
          }
          if ($row->tipe=='jasa') {
            $jasa.='<tr>';
            $jasa.='<td>'.$nojasa.'</td>';
            $jasa.='<td>'.$row->tgl_transaksi.'</td>';
            $jasa.='<td>'.'Penjualan kepada '.$row->target.'('.$item.')'.'</td>';
            $jasa.='<td class="text-right>'.(is_null($row->penjualan)?'':number_format($row->penjualan,2,",",".")).'</td>';
            $saldojasa += $row->penjualan;
            $nojasa++;
          }
          if ($row->tipe=='obat') {
            $obat.='<tr>';
            $obat.='<td>'.$noobat.'</td>';
            $obat.='<td>'.$row->tgl_transaksi.'</td>';
            $obat.='<td>'.'Penjualan kepada '.$row->target.'('.$item.')'.'</td>';
            $obat.='<td class="text-right>'.(is_null($row->penjualan)?'':number_format($row->penjualan,2,",",".")).'</td>';
            $saldoobat += $row->penjualan;
            $noobat++;
          }
          if ($row->tipe=='beban') {
            $beban.='<tr>';
            $beban.='<td>'.$nobeban.'</td>';
            $beban.='<td>'.$row->tgl_transaksi.'</td>';
            $beban.='<td>'.'Pembayaran kepada '.$row->target.'('.$item.')'.'</td>';
            $beban.='<td class="text-right>'.(is_null($row->pembelian)?'':number_format($row->pembelian,2,",",".")).'</td>';
            $saldobeban += $row->pembelian;
            $nobeban++;
          }
        }
          ?>
        <div id="section-to-print">
          <div class="box-body box-profile table-responsive">
            <h3 class="box-title">Laporan Bulan <?php echo $tanggal; ?></h3>
            <table class="table table-bordered table-hover" id="">
              <thead>
                <tr>
                  <th>No</th>
                  <th width="100">Tanggal</th>
                  <th>Nama Transaksi</th>
                  <th>Nilai</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $saldo = 0;
                echo $jasa;
                echo $beban;
                echo $obat;
                echo $beli;
                ?>
                <tr>
                  <td></td>
                  <td></td>
                  <td>Saldo</td>
                  <td><?php echo (is_null($saldo)?'-':number_format($saldo,2,",","."));?></td>
                </tr>
              </tbody>
            </table>
            <button onclick="window.print();" class="no-print btn btn-default"><i class="fa fa-print"></i> Print</button>
          </div>
          <!-- /.box-body -->
        </div>
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
