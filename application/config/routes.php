<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'logistic/master_obat';
$route['master'] = 'logistic';
$route['master/obat'] = 'logistic/master_obat';
$route['ajax/get-kode-obat'] = 'logistic/get_ajax_kode_obat';
$route['master/golongan-obat'] = 'logistic/master_golongan_obat';
$route['master/delete-golongan-obat'] = 'logistic/delete_golongan_obat';
$route['master/tipe-obat'] = 'logistic/master_tipe_obat';
$route['master/produsen-obat'] = 'logistic/master_produsen_obat';
$route['master/pbf'] = 'logistic/master_pbf';
$route['master/pasien'] = 'logistic/master_pasien';
$route['master/akun'] = 'transaksi/master_akun';
$route['master/jasa'] = 'logistic/master_jasa';

$route['transaksi/pembelian-obat'] = 'transaksi/pembelian_obat';
$route['transaksi/penjualan-obat'] = 'transaksi/penjualan_obat';
$route['transaksi/purchase-order'] = 'transaksi/purchase_order';
$route['transaksi/pembayaran-pelunasan'] = 'transaksi/pembayaran';
$route['transaksi/jurnal-umum'] = 'transaksi/jurnal_umum';
$route['transaksi/pembayaran-beban'] = 'transaksi/pembayaran_beban';
$route['transaksi/pembayaran/(:num)'] = 'transaksi/pembayaran/$1';
$route['report/laporan-harian'] = 'report/laporan_harian';
$route['report/laporan-bulanan'] = 'report/laporan_bulanan';
$route['report/laporan-stok'] = 'report/laporan_stok';
$route['report/laporan-pendapatan'] = 'report/laporan_pendapatan';
$route['report/laporan-labarugi'] = 'report/laporan_labarugi';
$route['report/dashboard'] = 'report/dashboard';
$route['ajax/get-obat'] = 'transaksi/get_ajax_obat';
$route['ajax/get-obat-penjualan'] = 'transaksi/get_ajax_obat_penjualan';
$route['ajax/get-jasa-penjualan'] = 'transaksi/get_ajax_jasa_penjualan';
$route['ajax/get-detail-po'] = 'transaksi/get_ajax_detail_po';
$route['ajax/get-detail-pembelian'] = 'transaksi/get_ajax_detail_pembelian';
$route['ajax/get-detail-pembayaran'] = 'transaksi/get_ajax_detail_pembayaran';
$route['ajax/get-po-pembelian'] = 'transaksi/get_ajax_po_pembelian';
$route['ajax/get-detail-jual'] = 'transaksi/get_ajax_detail_penjualan';
$route['ajax/get-pasien'] = 'transaksi/get_ajax_pasien';
$route['ajax/insert-temporary-po'] = 'transaksi/insert_temporary_po';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
