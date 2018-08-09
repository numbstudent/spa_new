<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
$posisi = $this->session->userdata('ses_posisi');
$belum = '<span class="label label-danger pull-right"><i class="fa fa-bomb"></i></span>';
?>
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar no-print">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
        <?php
        if(true){ ?>
          <ul class="sidebar-menu">
            <li class="header">ADMINISTRATOR</li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-database"></i> <span>Master Data</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url().'master/obat'?>"><i class="fa fa-angle-right"></i> Master Obat</a></li>
                <li><a href="<?php echo base_url().'master/jasa'?>"><i class="fa fa-angle-right"></i> Master Jasa Medis</a></li>
                <li class="bg-black"><a href="<?php echo base_url().'master/golongan-obat'?>"><i class="fa fa-angle-double-right"></i> Master Golongan Obat</a></li>
                <li class="bg-black"><a href="<?php echo base_url().'master/produsen-obat'?>"><i class="fa fa-angle-double-right"></i> Master Produsen Obat</a></li>
                <li><a href="<?php echo base_url().'master/pasien'?>"><i class="fa fa-angle-right"></i> Master Pasien</a></li>
                <li><a href="<?php echo base_url().'master/pbf'?>"><i class="fa fa-angle-right"></i> Master PBF</a></li>
                <li><a href="<?php echo base_url().'master/akun'?>"><i class="fa fa-angle-right"></i> Master Akun</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-exchange"></i> <span>Transaksi</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url().'transaksi/purchase-order'?>"><i class="fa fa-angle-right"></i> Purchase Order</a></li>
                <li><a href="<?php echo base_url().'transaksi/pembelian-obat'?>"><i class="fa fa-angle-right"></i> Pembelian Obat</a></li>
                <li><a href="<?php echo base_url().'transaksi/pembayaran-pelunasan'?>"><i class="fa fa-angle-right"></i> Pembayaran & Pelunasan</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-book"></i> <span>Transaksi Jurnal</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url().'transaksi/jurnal-umum'?>"><i class="fa fa-angle-right"></i> Transaksi non-kasir</a></li>
                <li><a href="<?php echo base_url().'transaksi/pembayaran-beban'?>"><i class="fa fa-angle-right"></i> Pembayaran & Pemindahan</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-exchange"></i> <span>Laporan</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url().'report/laporan-harian'?>"><i class="fa fa-angle-right"></i> Laporan Harian</a></li>
                <li><a href="<?php echo base_url().'report/laporan-bulanan'?>"><i class="fa fa-angle-right"></i> Laporan Bulanan</a></li>
                <li><a href="<?php echo base_url().'report/laporan-stok'?>"><i class="fa fa-angle-right"></i> Laporan Stok</a></li>
                <li><a href="<?php echo base_url().'report/laporan-pendapatan'?>"><i class="fa fa-angle-right"></i> Laporan Pendapatan</a></li>
                <li><a href="<?php echo base_url().'report/laporan-labarugi'?>"><i class="fa fa-angle-right"></i> Laporan Laba Rugi</a></li>
              </ul>
            </li>
            <li class="header">KASIR</li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-exchange"></i> <span>Transaksi</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                 <li><a href="<?php echo base_url().'transaksi/penjualan-obat'?>"><i class="fa fa-angle-right"></i> Penjualan Obat</a></li>
              </ul>
            </li>
          <!== ============================================== ==>
          <!-- <ul class="sidebar-menu">
            <li class="header">P.O.S.</li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-sticky-note"></i> <span>Asesor</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url().'biodata-asesor'?>"><i class="fa fa-user"></i> Biodata Asesor</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-file"></i> <span>Asesmen</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url().'penilaian-dokumen'?>"><i class="fa fa-user-plus"></i> Penilaian Uji Dokumen</a></li>
                <li><a href="<?php echo base_url().'histori-penilaian-dokumen'?>"><i class="fa fa-user-plus"></i> Histori PenDok</a></li>
                <li><a href="<?php echo base_url().'penilaian-praktek'?>"><i class="fa fa-user-plus"></i> Penilaian Uji Praktek</a></li>
                <li><a href="<?php echo base_url().'histori-penilaian-dokumen'?>"><i class="fa fa-user-plus"></i> Histori Praktek</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-user"></i> <span>User</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url().'ganti-password'?>"><i class="fa fa-retweet"></i> Ganti Password</a></li>
                <li><a href="<?php echo base_url().'logout'?>"><i class="fa fa-sign-out"></i> Logout</a></li>
              </ul>
            </li>

          </ul>
          <!== ============================================== ==>
          <ul class="sidebar-menu">
            <li class="header">REGISTRASI</li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-graduation-cap"></i> <span>Mahasiswa</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url().'biodata-mahasiswa'?>"><i class="fa fa-user"></i> Pendaftaran Mahasiswa</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-file"></i> <span>Asesmen</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url().'asesmen'?>"><i class="fa fa-user-plus"></i> Asesmen</a></li>
                <li><a href="<?php echo base_url().'unggah-dokumen'?>"><i class="fa fa-user-plus"></i> Unggah Dokumen</a></li>
                <li><a href="<?php echo base_url().'permohonan-banding'?>"><i class="fa fa-user-plus"></i> Permohonan Banding</a></li>
                <li><a href="<?php echo base_url().'histori-penilaian-dokumen'?>"><i class="fa fa-user-plus"></i> Histori Praktek</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-user"></i> <span>User</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url().'ganti-password'?>"><i class="fa fa-retweet"></i> Ganti Password</a></li>
                <li><a href="<?php echo base_url().'logout'?>"><i class="fa fa-sign-out"></i> Logout</a></li>
              </ul>
            </li>

          </ul> -->
          <?php } ?>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
