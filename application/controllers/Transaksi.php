<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

	/**
	* Index Page for this controller.
	*
	* Maps to the following URL
	* 		http://example.com/index.php/welcome
	*	- or -
	* 		http://example.com/index.php/welcome/index
	*	- or -
	* Since this controller is set as the default controller in
	* config/routes.php, it's displayed at http://example.com/
	*
	* So any other public methods not prefixed with an underscore will
	* map to /index.php/welcome/<method_name>
	* @see https://codeigniter.com/user_guide/general/urls.html
	*/
	public function index()
	{
		$this->load->view('template/header');
		$this->load->view('template/navigation');
		$this->load->view('welcome_message');
		$this->load->view('template/footer');
	}
	public function cekposisi()
	{

	}

	public function master_akun()
	{
		$this->cekposisi();
		$this->load->model('transaksi_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="info">', '</div>');
		$this->form_validation->set_rules('kode_akun', 'Kode Akun', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data['query'] = $this->transaksi_model->get_kode_akun();
			$this->load->view('template/header');
			$this->load->view('template/navigation');
			$this->load->view('transaksi/master_akun',$data);
			$this->load->view('template/footer');
		}else{

			$this->session->set_flashdata('message', 'Penjualan gagal ditambahkan.');

			redirect(base_url().'transaksi/penjualan-obat');
		}
	}

	public function jurnal_umum()
	{
		$this->cekposisi();
		$this->load->model('transaksi_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="info">', '</div>');
		$this->form_validation->set_rules('no', 'Nomor', 'required');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$jurnal_id = $this->transaksi_model->get_kode_jurnal()+1;
			$data['no']  = $jurnal_id;
			$data['query'] = $this->transaksi_model->get_kode_akun();
			$this->load->view('template/header');
			$this->load->view('template/navigation');
			$this->load->view('transaksi/jurnal_umum',$data);
			$this->load->view('template/footer');
		}else{
			$jurnal_id = $this->transaksi_model->get_kode_jurnal()+1;
			$no = $jurnal_id;
			if($this->input->post('no')!=''){
				$no = $this->input->post('no');
			}
			$data = array(
				'jurnal_id' => $jurnal_id,
				'no' => $no,
				'tgl' => date('Y-m-d'),
				// 'tgl' => $this->input->post('tgl'),
				'keterangan' => $this->input->post('keterangan'),
				'login_id' => '1',
				'waktu_post' => date("Y-m-d H:i:s"),
			);
			$result = $this->transaksi_model->insert_jurnal($data);
			if($result){
				for ($i=1; $i <=3 ; $i++) {
					$nilai=0;
					$debit_kredit=0;
					if($this->input->post('debit'.$i)!=''){
						$nilai = $this->input->post('debit'.$i);
						$debit_kredit = 1;
					}elseif ($this->input->post('kredit'.$i)!='') {
						$nilai = $this->input->post('kredit'.$i);
						$debit_kredit = 2;
					}
					if ($nilai!=0||$debit_kredit!=0) {
						$data = array(
							'jurnal_id' => $jurnal_id,
							'kode_akun' => $this->input->post('kode_akun'.$i),
							'item' => $i,
							'debit_kredit' => $debit_kredit,
							'nilai' => $nilai
						);
						$result = $this->transaksi_model->insert_jurnal_detail($data);
					}
				}
			}
			$this->session->set_flashdata('message', 'Item berhasil ditambahkan.');
			redirect(base_url().'transaksi/report/laporan-harian');
		}
	}

	public function pembayaran_beban() //jurnal umum yang dimudahkan :))
	{
		$this->cekposisi();
		$this->load->model('transaksi_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="info">', '</div>');
		$this->form_validation->set_rules('no', 'Nomor', 'required');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$jurnal_id = $this->transaksi_model->get_kode_jurnal()+1;
			$data['no']  = $jurnal_id;
			$data['query'] = $this->transaksi_model->get_kode_akun_beban();
			$data['query2'] = $this->transaksi_model->get_kode_akun_kas();
			$data['kas'] = $this->transaksi_model->get_kas();
			$this->load->view('template/header');
			$this->load->view('template/navigation');
			$this->load->view('transaksi/pembayaran_beban',$data);
			$this->load->view('template/footer');
		}else{
			$jurnal_id = $this->transaksi_model->get_kode_jurnal()+1;
			$no = $jurnal_id;
			if($this->input->post('no')!=''){
				$no = $this->input->post('no');
			}
			$data = array(
				'jurnal_id' => $jurnal_id,
				'no' => $no,
				'tgl' => date('Y-m-d'),
				'keterangan' => $this->input->post('keterangan'),
				'login_id' => '1',
				'waktu_post' => date("Y-m-d H:i:s"),
			);
			$result = $this->transaksi_model->insert_jurnal($data);
			if($result){
				$nilai = str_replace( '.', '', $this->input->post('nilai'));
				if ($nilai>0) {
					$data = array(
						'jurnal_id' => $jurnal_id,
						'kode_akun' => $this->input->post('kode_akun'),
						'item' => 1,
						'debit_kredit' => 1,
						'nilai' => $nilai
					);
					$result = $this->transaksi_model->insert_jurnal_detail($data); //bayar beban
					$data = array(
						'jurnal_id' => $jurnal_id,
						'kode_akun' => $this->input->post('kode_akun_kas'),
						'item' => 2,
						'debit_kredit' => 2,
						'nilai' => $nilai
					);
					$result = $this->transaksi_model->insert_jurnal_detail($data); //kas berkurang
					if($result)$this->session->set_flashdata('message', 'Item berhasil ditambahkan.');
				}
			}
			redirect(base_url().'transaksi/pembayaran-beban');
		}
	}

	public function penjualan_obat()
	{
		$this->cekposisi();
		$this->load->model('transaksi_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="info">', '</div>');
		$this->form_validation->set_rules('no_faktur_jual', 'Kode PO', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data['query'] = $this->transaksi_model->get_penjualan();
			$kode_jual = $this->transaksi_model->get_kode_penjualan() + 1;
			$data['no_faktur_jual'] =  str_pad($kode_jual,7,"0",'0');
			$this->load->view('template/header');
			$this->load->view('template/navigation');
			$this->load->view('transaksi/penjualan_obat',$data);
			$this->load->view('template/footer');
		}else{
			$no_faktur_jual = $this->input->post('no_faktur_jual');
			$tgl_transaksi = date("Y-m-d");
			$jumlahitem = $this->input->post('jumlahitem');
			$id_pasien = $this->input->post('id_pasien');
			$data = array(
				'no_faktur_jual' => $no_faktur_jual,
				'tgl_transaksi' => $tgl_transaksi,
				'id_customer' => $id_pasien
			);
			$result = $this->transaksi_model->insert_penjualan($data);
			if($result){
				$total_harga = 0; //untuk ppn
				$total_harga_jasa = 0; //untuk ppn
				$ppn = 0; //untuk ppn
				$kas = 0; //untuk ppn
				for ($ctr=1; $ctr <= $jumlahitem; $ctr++) {
					$harga_jual = str_replace( '.', '', $this->input->post('harga_jual'.$ctr));
					$kode_obat = $this->input->post('kode_obat'.$ctr);
					$qty_jual = $this->input->post('jumlah'.$ctr);
					$tipe = $this->input->post('tipe'.$ctr);
					$hpp = 0;
					if($tipe=="obat"){
						$harga_beli = $this->transaksi_model->get_harga_beli(str_replace("_b","",$kode_obat));
						$data2 = array(
							'qty_jual' => $qty_jual,
							'kode_obat' => $kode_obat,
							'harga_jual' => $harga_jual,
							'no_faktur_jual' => $no_faktur_jual
						);
						$result = $this->transaksi_model->insert_penjualan_detail($data2);
						if ($result) {
							$hpp = ($qty_jual*$harga_beli);
							$harga = ($qty_jual*$harga_jual);
							$ppn += $harga/10;
							$kas += $harga;
							$total_harga+= $harga+($harga/10);
						}
					}elseif ($tipe=="jasa") {
						$data2 = array(
							'qty_jual' => $qty_jual,
							'harga_jual' => $harga_jual,
							'kode_jasa' => $kode_obat,
							'no_faktur_jual' => $no_faktur_jual
						);
						$result = $this->transaksi_model->insert_penjualan_jasa_detail($data2);
						if ($result) {
							$harga = ($qty_jual*$harga_jual);
							$kas += $harga;
							$total_harga_jasa+=$harga;
						}
					}
				}
				$this->session->set_flashdata('message', 'Penjualan berhasil ditambahkan.');
				$jurnal_id = $this->transaksi_model->get_kode_jurnal()+1;
				$data = array(
					'jurnal_id' => $jurnal_id,
					'no' => $jurnal_id,
					'tgl' => date('Y-m-d'),
					'keterangan' => "Penjualan obat",
					'referensi' => "j_".$no_faktur_jual,
					'login_id' => '1',
					'waktu_post' => date("Y-m-d H:i:s"),
				);
				$result = $this->transaksi_model->insert_jurnal($data);
				$data = array(
					'jurnal_id' => $jurnal_id,
					'kode_akun' => '401',
					'item' => 1,
					'debit_kredit' => 2,
					'nilai' => $total_harga
				);
				$result = $this->transaksi_model->insert_jurnal_detail($data); //insert pendapatan penjualan
				$data = array(
					'jurnal_id' => $jurnal_id,
					'kode_akun' => '402',
					'item' => 1,
					'debit_kredit' => 2,
					'nilai' => $total_harga_jasa
				);
				$result = $this->transaksi_model->insert_jurnal_detail($data); //insert pendapatan penjualan jasa
				$data = array(
					'jurnal_id' => $jurnal_id,
					'kode_akun' => '102',
					'item' => 2,
					'debit_kredit' => 1,
					'nilai' => $kas
				);
				$result = $this->transaksi_model->insert_jurnal_detail($data); //insert kas
				$data = array(
					'jurnal_id' => $jurnal_id,
					'kode_akun' => '301',
					'item' => 3,
					'debit_kredit' => 2,
					'nilai' => $ppn
				);
				$result = $this->transaksi_model->insert_jurnal_detail($data); //insert hutang ppn
				if($tipe=="obat"){
					$data = array(
						'jurnal_id' => $jurnal_id,
						'kode_akun' => '103',
						'item' => 4,
						'debit_kredit' => 2,
						'nilai' => $hpp
					);
					$result = $this->transaksi_model->insert_jurnal_detail($data); //insert kredit persediaan
					$data = array(
						'jurnal_id' => $jurnal_id,
						'kode_akun' => '501',
						'item' => 5,
						'debit_kredit' => 1,
						'nilai' => $hpp
					);
					$result = $this->transaksi_model->insert_jurnal_detail($data); //insert kredit persediaan
				}

				$this->session->set_flashdata('message', 'Item berhasil ditambahkan.');
			}else{
				$this->session->set_flashdata('message', 'Penjualan gagal ditambahkan.');
			}
			redirect(base_url().'transaksi/penjualan-obat');
		}
	}
	public function purchase_order()
	{
		$this->cekposisi();
		$this->load->model('transaksi_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="info">', '</div>');
		$this->form_validation->set_rules('no_faktur_pesan', 'Kode PO', 'required');
		$this->form_validation->set_rules('kode_supplier', 'Kode Supplier', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data['query'] = $this->transaksi_model->get_purchase_order();
			$kode_po = $this->transaksi_model->get_kode_po() + 1;
			$data['no_faktur_pesan'] =  str_pad($kode_po,7,"0",'0');
			$this->load->view('template/header');
			$this->load->view('template/navigation');
			$this->load->view('transaksi/purchase_order',$data);
			$this->load->view('template/footer');
		}else{
			$no_faktur_pesan = $this->input->post('no_faktur_pesan');
			$tgl_transaksi = date("Y/m/d");
			$kode_supplier = $this->input->post('kode_supplier');
			$jumlahitem = $this->input->post('jumlahitem');
			$data = array(
				'no_faktur_pesan' => $no_faktur_pesan,
				'tgl_transaksi' => $tgl_transaksi,
				'kode_supplier' => $kode_supplier
			);
			$result = $this->transaksi_model->insert_purchase_order($data);
			if($result){
				for ($ctr=1; $ctr <= $jumlahitem; $ctr++) {
					$harga_beli = str_replace( '.', '', $this->input->post('harga_beli'.$ctr));
					$kode_obat = $this->input->post('kode_obat'.$ctr);
					$qty_pesan = $this->input->post('jumlah'.$ctr);
					$data2 = array(
						'qty_pesan' => $qty_pesan,
						'kode_obat' => $kode_obat,
						'harga_beli' => $harga_beli,
						'no_faktur_pesan' => $no_faktur_pesan
					);
					$this->transaksi_model->insert_purchase_order_detail($data2);
				}
				$this->session->set_flashdata('message', 'PO berhasil ditambahkan.');
			}else{
				$this->session->set_flashdata('message', 'PO gagal ditambahkan.');
			}
			redirect(base_url().'transaksi/purchase-order');
		}
	}

	public function pembayaran()
	{
		$this->cekposisi();
		$this->load->model('transaksi_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="info">', '</div>');
		$this->form_validation->set_rules('no_faktur_beli', 'No Faktur Beli', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data['query'] = $this->transaksi_model->get_pembayaran_pembelian_obat();
			$this->load->view('template/header');
			$this->load->view('template/navigation');
			$this->load->view('transaksi/pembayaran',$data);
			$this->load->view('template/footer');
		}else{
			$no_faktur_beli = $this->input->post('no_faktur_beli');
			$tgl_transaksi = date("Y/m/d");
			$jumlah_bayar = $this->input->post('jumlah_bayar');
			$data = array(
				'no_faktur_beli' => $no_faktur_beli,
				'jumlah_bayar' => $jumlah_bayar,
				'tgl_bayar' => $tgl_transaksi
			);
			$result = $this->transaksi_model->insert_pembayaran_obat_detail($data);
			if($result){
				$jurnal_id = $this->transaksi_model->get_kode_jurnal()+1;
				$data = array(
					'jurnal_id' => $jurnal_id,
					'no' => $jurnal_id,
					'tgl' => date('Y-m-d'),
					'keterangan' => "Pembayaran hutang obat",
					'referensi' => "by_".$no_faktur_beli,
					'login_id' => '1',
					'waktu_post' => date("Y-m-d H:i:s"),
				);
				$result = $this->transaksi_model->insert_jurnal($data);
				$data = array(
					'jurnal_id' => $jurnal_id,
					'kode_akun' => '302',
					'item' => 2,
					'debit_kredit' => 1,
					'nilai' => $jumlah_bayar
				);
				$result = $this->transaksi_model->insert_jurnal_detail($data); //insert debit utang pembelian
				$data = array(
					'jurnal_id' => $jurnal_id,
					'kode_akun' => '102',
					'item' => 2,
					'debit_kredit' => 2,
					'nilai' => $jumlah_bayar
				);
				$result = $this->transaksi_model->insert_jurnal_detail($data); //insert kredit kas kecil
				$this->session->set_flashdata('message', 'Pembayaran berhasil ditambahkan.');
			}else{
				$this->session->set_flashdata('message', 'Pembayaran gagal ditambahkan.');
			}
			redirect(base_url().'transaksi/pembayaran-pelunasan');
		}
	}

	public function pembelian_obat()
	{
		$this->cekposisi();
		$this->load->model('transaksi_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="info">', '</div>');
		$this->form_validation->set_rules('no_faktur_beli', 'Kode Obat', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data['query'] = $this->transaksi_model->get_pembelian_obat();
			$data['po'] = $this->transaksi_model->get_purchase_order_pembelian();
			$kode_beli = $this->transaksi_model->get_kode_beli() + 1;
			$data['no_faktur_beli'] =  str_pad($kode_beli,7,"0",'0');
			$this->load->view('template/header');
			$this->load->view('template/navigation');
			$this->load->view('transaksi/pembelian_obat',$data);
			$this->load->view('template/footer');
		}else{
			$no_faktur_beli = $this->input->post('no_faktur_beli');
			$tgl_transaksi = date("Y/m/d");
			$kode_supplier = $this->input->post('kode_supplier');
			$jumlahitem = $this->input->post('jumlahitem');
			$jenis_bayar = $this->input->post('jenis_bayar');
			$discount = str_replace( '.', '', $this->input->post('discount'));
			$pajak = $this->input->post('pajak');
			$kode_supplier = $this->input->post('kode_supplier');
			$no_faktur_pesan = $this->input->post('no_faktur_pesan');
			$data = array(
				'no_faktur_beli' => $no_faktur_beli,
				'tgl_transaksi' => $tgl_transaksi,
				'jenis_bayar' => $jenis_bayar,
				'no_faktur_pesan' => $no_faktur_pesan,
				'discount' => $discount,
				'pajak' => $pajak,
				'kode_supplier' => $kode_supplier
			);
			$result = $this->transaksi_model->insert_pembelian_obat($data);
			$total = 0;
			if($result){
				for ($ctr=1; $ctr <= $jumlahitem; $ctr++) {
					$harga_beli = str_replace( '.', '', $this->input->post('harga_beli'.$ctr));
					$kode_obat = $this->input->post('kode_obat'.$ctr);
					$qty_beli = $this->input->post('jumlah'.$ctr);
					$tgl_kadaluwarsa = $this->input->post('tgl_kadaluwarsa'.$ctr);
					$data2 = array(
						'qty_beli' => $qty_beli,
						'kode_obat' => $kode_obat,
						'harga_beli' => $harga_beli,
						'no_faktur_beli' => $no_faktur_beli,
						'tgl_kadaluwarsa' => $tgl_kadaluwarsa
					);
					$this->transaksi_model->insert_pembelian_obat_detail($data2);
					$total = $total+($qty_beli*$harga_beli);
				}
				if($jenis_bayar==1){
					$jumlah_bayar = ($total-$discount)+(($total-$discount)*$pajak/100);
					$data = array(
						'no_faktur_beli' => $no_faktur_beli,
						'jumlah_bayar' => $jumlah_bayar,
						'tgl_bayar' => $tgl_transaksi
					);
					$result = $this->transaksi_model->insert_pembayaran_obat_detail($data);
					//jurnal
					if($result){
						$kas = $jumlah_bayar; //198.000(K)
						$diskon = $discount; //20.000 (K)
						$ppn = ($total-$discount)*$pajak/100; //18.000 (D)
						$persediaan = $total; //200.000 (D)
						$jurnal_id = $this->transaksi_model->get_kode_jurnal()+1;
						$data = array(
							'jurnal_id' => $jurnal_id,
							'no' => $jurnal_id,
							'tgl' => date('Y-m-d'),
							'keterangan' => "Pembelian obat",
							'referensi' => "b_".$no_faktur_beli,
							'login_id' => '1',
							'waktu_post' => date("Y-m-d H:i:s"),
						);
						$result = $this->transaksi_model->insert_jurnal($data);
						$data = array(
							'jurnal_id' => $jurnal_id,
							'kode_akun' => '103',
							'item' => 1,
							'debit_kredit' => 1,
							'nilai' => $persediaan
						);
						$result = $this->transaksi_model->insert_jurnal_detail($data); //insert debit persediaan
						$data = array(
							'jurnal_id' => $jurnal_id,
							'kode_akun' => '102',
							'item' => 2,
							'debit_kredit' => 2,
							'nilai' => $kas
						);
						$result = $this->transaksi_model->insert_jurnal_detail($data); //insert kredit kas
						$data = array(
							'jurnal_id' => $jurnal_id,
							'kode_akun' => '104',
							'item' => 3,
							'debit_kredit' => 1,
							'nilai' => $ppn
						);
						$result = $this->transaksi_model->insert_jurnal_detail($data); //insert debit piutang ppn
						$data = array(
							'jurnal_id' => $jurnal_id,
							'kode_akun' => '514',
							'item' => 4,
							'debit_kredit' => 2,
							'nilai' => $diskon
						);
						$result = $this->transaksi_model->insert_jurnal_detail($data); //insert kredit potongan pembelian
						//jurnal
					}
				}else{
					$jumlah_bayar = ($total-$discount)+(($total-$discount)*$pajak/100);
					$kas = $jumlah_bayar; //198.000(K)
					$diskon = $discount; //20.000 (K)
					$ppn = ($total-$discount)*$pajak/100; //18.000 (D)
					$persediaan = $total; //200.000 (D)
					$jurnal_id = $this->transaksi_model->get_kode_jurnal()+1;
					$data = array(
						'jurnal_id' => $jurnal_id,
						'no' => $jurnal_id,
						'tgl' => date('Y-m-d'),
						'keterangan' => "Pembelian obat",
						'referensi' => "b_".$no_faktur_beli,
						'login_id' => '1',
						'waktu_post' => date("Y-m-d H:i:s"),
					);
					$result = $this->transaksi_model->insert_jurnal($data);
					$data = array(
						'jurnal_id' => $jurnal_id,
						'kode_akun' => '103',
						'item' => 1,
						'debit_kredit' => 1,
						'nilai' => $persediaan
					);
					$result = $this->transaksi_model->insert_jurnal_detail($data); //insert debit persediaan
					$data = array(
						'jurnal_id' => $jurnal_id,
						'kode_akun' => '302',
						'item' => 2,
						'debit_kredit' => 2,
						'nilai' => $kas
					);
					$result = $this->transaksi_model->insert_jurnal_detail($data); //insert kredit utang pembelian
					$data = array(
						'jurnal_id' => $jurnal_id,
						'kode_akun' => '104',
						'item' => 3,
						'debit_kredit' => 1,
						'nilai' => $ppn
					);
					$result = $this->transaksi_model->insert_jurnal_detail($data); //insert debit piutang ppn
					$data = array(
						'jurnal_id' => $jurnal_id,
						'kode_akun' => '514',
						'item' => 4,
						'debit_kredit' => 2,
						'nilai' => $diskon
					);
					$result = $this->transaksi_model->insert_jurnal_detail($data); //insert kredit potongan pembelian
				}
				$this->session->set_flashdata('message', 'Pembelian berhasil ditambahkan.');
			}else{
				$this->session->set_flashdata('message', 'Pembelian gagal ditambahkan.');
			}
			redirect(base_url().'transaksi/pembelian-obat');
		}
	}

	public function get_ajax_obat()
	{
		$this->load->model('transaksi_model');
		$nama = $this->input->post('term');
		$obat = $this->transaksi_model->get_nama_obat($nama);
		//return json data
		// echo json_encode($obat);
		$this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($obat));
	}
	public function get_ajax_obat_penjualan()
	{
		$this->load->model('transaksi_model');
		$nama = $this->input->post('term');
		$obat = $this->transaksi_model->get_nama_obat_penjualan($nama);
		//return json data
		// echo json_encode($obat);
		$this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($obat));
	}
	public function get_ajax_jasa_penjualan()
	{
		$this->load->model('transaksi_model');
		$nama = $this->input->post('term');
		$jasa = $this->transaksi_model->get_nama_jasa_penjualan($nama);
		//return json data
		// echo json_encode($obat);
		$this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($jasa));
	}

	public function get_ajax_pasien()
	{
		$this->load->model('transaksi_model');
		$nama = $this->input->post('term');
		$pasien = $this->transaksi_model->get_pasien($nama);
		//return json data
		// echo json_encode($pasien);
		$this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($pasien));
	}

	public function get_ajax_detail_po()
	{

		$no_faktur_pesan = htmlspecialchars($this->input->post('id'));
		if($no_faktur_pesan){
			$this->load->model('transaksi_model');
			$query = $this->transaksi_model->get_purchase_order_detail($no_faktur_pesan);
			$total=0;
			$val1 = '';
			$val1 = '<h1>PO '.str_pad($no_faktur_pesan,7,"0",'0').'</h1>';
			$val1.= '<table class="table">';
			$val1.= '<thead>';
			$val1.= '<tr>';
			$val1.= '<td>Nama Obat</td>';
			$val1.= '<td>Harga Beli</td>';
			$val1.= '<td>Jumlah</td>';
			$val1.= '<td>Total</td>';
			$val1.= '</tr>';
			$val1.= '</thead>';
			$val1.= '<tbody>';
			foreach($query as $row){
				$val1.= '<tr>';
				$val1.= '<td>'.$row->nama_obat.'</td>';
				$val1.= '<td>'.number_format($row->harga_beli,0,",",".").'</td>';
				$val1.= '<td>'.number_format($row->qty_pesan,0,",",".").'</td>';
				$val1.= '<td>'.number_format($row->qty_pesan*$row->harga_beli,0,",",".").'</td>';
				$total +=$row->qty_pesan*$row->harga_beli;
				$val1.= '</tr>';
			}
			$val1.= '<tr>';
			$val1.= '<td>Total</td>';
			$val1.= '<td>-----</td>';
			$val1.= '<td>-----</td>';
			$val1.= '<td>'.number_format($total,0,",",".").'</td>';
			$val1.= '</tr>';
			$val1.= '</tbody>';
			$val1.= '</table>';
			echo json_encode(array(
				'val1' => $val1
			));
		}
	}
	public function get_ajax_po_pembelian()
	{
		$kode_supplier = htmlspecialchars($this->input->post('kode_supplier'));
		$no_faktur_pesan = htmlspecialchars($this->input->post('id'));
		if($no_faktur_pesan){
			$this->load->model('transaksi_model');
			$query = $this->transaksi_model->get_purchase_order_detail_pembelian($no_faktur_pesan);
			$total=0;
			// $val1 = '<div id="alertObat" class="alert alert-danger alert-dismissible">
			// 	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			// 	<h4><i class="icon fa fa-exclamation"></i> Peringatan</h4>
			// 	Ada obat yang tanggal kadaluwarsanya mepet. Pastikan diskon sesuai.
			// </div>';
			$val1= '<h1>PO '.str_pad($no_faktur_pesan,7,"0",'0').'</h1>';
			// $val1.= '<h1>PO '.str_pad($no_faktur_pesan,7,"0",'0').'</h1>';
			$val1.= '<table class="table">';
			$val1.= '<thead>';
			$val1.= '<tr>';
			$val1.= '<td>Nama Obat</td>';
			$val1.= '<td>Kadaluwarsa</td>';
			$val1.= '<td>Harga Beli</td>';
			$val1.= '<td>Jumlah</td>';
			$val1.= '<td>Total</td>';
			$val1.= '</tr>';
			$val1.= '</thead>';
			$val1.= '<tbody>';
			$ctr=1;
			foreach($query as $row){
				$val1.= '<tr>';
				$val1.= '<td><input type="hidden" name="kode_obat'.$ctr.'" value="'.$row->kode_obat.'"><input type="text" class="form-control" readonly value="'.$row->nama_obat.'"></td>';
				$val1.= '<td><input type="text" class="form-control datepicker" required name="tgl_kadaluwarsa'.$ctr.'"></td>';
				$val1.= '<td><input type="text" class="form-control" readonly name="harga_beli'.$ctr.'" value="'.number_format($row->harga_beli,0,",",".").'"></td>';
				$val1.= '<td><input type="text" class="form-control" readonly name="jumlah'.$ctr.'" value="'.number_format($row->qty_pesan,0,",",".").'"></td>';
				$val1.= '<td><input type="text" class="form-control" readonly value="'.number_format($row->qty_pesan*$row->harga_beli,0,",",".").'"></td>';
				$total +=$row->qty_pesan*$row->harga_beli;
				$val1.= '</tr>';
				$ctr++;
			}
			$val1.= '<tr>';
			$val1.= '<td>Total</td>';
			$val1.= '<td>-----</td>';
			$val1.= '<td>-----</td>';
			$val1.= '<td id="totalbeli">'.number_format($total,0,",",".").'</td>';
			$val1.= '</tr>';
			$val1.= '</tbody>';
			$val1.= '</table>';
			$val1.= '<input type="hidden" name="jumlahitem" value="'.($ctr - 1).'">';
			$val1.= '<input type="hidden" name="no_faktur_pesan" value="'.$no_faktur_pesan.'">';
			$val1.= '<input type="hidden" name="kode_supplier" value="'.$kode_supplier.'">';
			echo json_encode(array(
				'val1' => $val1
			));
		}
	}

	public function get_ajax_detail_penjualan()
	{

		$no_faktur_jual = htmlspecialchars($this->input->post('id'));
		if($no_faktur_jual){
			$this->load->model('transaksi_model');
			$query = $this->transaksi_model->get_penjualan_detail($no_faktur_jual);
			$total=0;
			$val1 = '';
			$val1 = '<h1>Faktur Penjualan '.str_pad($no_faktur_jual,7,"0",'0').'</h1>';
			$val1.= '<table class="table">';
			$val1.= '<thead>';
			$val1.= '<tr>';
			$val1.= '<td>Nama Obat</td>';
			$val1.= '<td>Harga Jual</td>';
			$val1.= '<td>Jumlah</td>';
			$val1.= '<td>Total</td>';
			$val1.= '</tr>';
			$val1.= '</thead>';
			$val1.= '<tbody>';
			foreach($query as $row){
				$val1.= '<tr>';
				$val1.= '<td>'.$row->nama_obat.'</td>';
				$val1.= '<td>'.number_format($row->harga_jual,0,",",".").'</td>';
				$val1.= '<td>'.number_format($row->qty_jual,0,",",".").'</td>';
				$val1.= '<td>'.number_format($row->qty_jual*$row->harga_jual,0,",",".").'</td>';
				$total +=$row->qty_jual*$row->harga_jual;
				$val1.= '</tr>';
			}
			$val1.= '<tr>';
			$val1.= '<td>Total</td>';
			$val1.= '<td>-----</td>';
			$val1.= '<td>-----</td>';
			$val1.= '<td>'.number_format($total,0,",",".").'</td>';
			$val1.= '</tr>';
			$val1.= '</tbody>';
			$val1.= '</table>';
			echo json_encode(array(
				'val1' => $val1
			));
		}
	}
	public function get_ajax_detail_pembelian()
	{

		$no_faktur_beli = htmlspecialchars($this->input->post('id'));
		$diskon=0;
		$pajak=0;
		if($no_faktur_beli){
			$this->load->model('transaksi_model');
			$query = $this->transaksi_model->get_pembelian_detail($no_faktur_beli);
			$total=0;
			$val1 = '';
			$val1 = '<h1>Faktur Pembelian '.str_pad($no_faktur_beli,7,"0",'0').'</h1>';
			$val1.= '<table class="table">';
			$val1.= '<thead>';
			$val1.= '<tr>';
			$val1.= '<td>Nama Obat</td>';
			$val1.= '<td>Kadaluwarsa</td>';
			$val1.= '<td>Harga Beli</td>';
			$val1.= '<td>Jumlah</td>';
			$val1.= '<td>Total</td>';
			$val1.= '</tr>';
			$val1.= '</thead>';
			$val1.= '<tbody>';
			foreach($query as $row){
				$diskon = $row->discount;
				$pajak = $row->pajak;
				$kadaluwarsa = explode('-',$row->tgl_kadaluwarsa);
				$kadaluwarsa = $kadaluwarsa[2].'-'.$kadaluwarsa[1].'-'.$kadaluwarsa[0];
				$val1.= '<tr>';
				$val1.= '<td>'.$row->nama_obat.'</td>';
				$val1.= '<td>'.$kadaluwarsa.'</td>';
				$val1.= '<td>'.number_format($row->harga_beli,0,",",".").'</td>';
				$val1.= '<td>'.number_format($row->qty_beli,0,",",".").'</td>';
				$val1.= '<td>'.number_format($row->qty_beli*$row->harga_beli,0,",",".").'</td>';
				$total +=$row->qty_beli*$row->harga_beli;
				$val1.= '</tr>';
			}
			$val1.= '<tr>';
			$val1.= '<td>Jumlah</td>';
			$val1.= '<td>-----</td>';
			$val1.= '<td>-----</td>';
			$val1.= '<td>-----</td>';
			$val1.= '<td>Rp '.number_format($total,0,",",".").'</td>';
			$val1.= '</tr>';
			$val1.= '<tr>';
			$val1.= '<td></td>';
			$val1.= '<td></td>';
			$val1.= '<td>Discount</td>';
			$val1.= '<td>Rp '.number_format($diskon,0,",",".").'</td>';
			$val1.= '<td>-----</td>';
			$val1.= '</tr>';
			$val1.= '<tr>';
			$val1.= '<td></td>';
			$val1.= '<td></td>';
			$val1.= '<td>Pajak</td>';
			$val1.= '<td>'.number_format($pajak,0,",",".").'%</td>';
			$val1.= '<td>-----</td>';
			$val1.= '</tr>';
			$val1.= '<tr>';
			$val1.= '<td></td>';
			$val1.= '<td></td>';
			$val1.= '<td>Total</td>';
			$val1.= '<td>-----</td>';
			$val1.= '<td><b>Rp '.number_format(($total-$diskon)*(100+$pajak)/100,0,",",".").'</b></td>';
			$val1.= '</tr>';
			$val1.= '</tbody>';
			$val1.= '</table>';
			echo json_encode(array(
				'val1' => $val1
			));
		}
	}
	public function get_ajax_detail_pembayaran()
	{

		$no_faktur_beli = htmlspecialchars($this->input->post('id'));
		if($no_faktur_beli){
			$this->load->model('transaksi_model');
			$query = $this->transaksi_model->get_pembayaran_pembelian_detail($no_faktur_beli);
			$total=0;
			$val1 = '';
			$val1 = '<h1>Faktur Pembelian '.str_pad($no_faktur_beli,7,"0",'0').'</h1>';
			$val1.= '<table class="table">';
			$val1.= '<thead>';
			$val1.= '<tr>';
			$val1.= '<td>Nama Obat</td>';
			$val1.= '<td>Kadaluwarsa</td>';
			$val1.= '<td>Harga Beli</td>';
			$val1.= '<td>Jumlah</td>';
			$val1.= '<td>Total</td>';
			$val1.= '</tr>';
			$val1.= '</thead>';
			$val1.= '<tbody>';
			foreach($query as $row){
				$kadaluwarsa = explode('-',$row->tgl_kadaluwarsa);
				$kadaluwarsa = $kadaluwarsa[2].'-'.$kadaluwarsa[1].'-'.$kadaluwarsa[0];
				$val1.= '<tr>';
				$val1.= '<td>'.$row->nama_obat.'</td>';
				$val1.= '<td>'.$kadaluwarsa.'</td>';
				$val1.= '<td>'.number_format($row->harga_beli,0,",",".").'</td>';
				$val1.= '<td>'.number_format($row->qty_beli,0,",",".").'</td>';
				$val1.= '<td>'.number_format($row->qty_beli*$row->harga_beli,0,",",".").'</td>';
				$total +=$row->qty_beli*$row->harga_beli;
				$val1.= '</tr>';
			}
			$val1.= '<tr>';
			$val1.= '<td>Total</td>';
			$val1.= '<td>-----</td>';
			$val1.= '<td>-----</td>';
			$val1.= '<td>-----</td>';
			$val1.= '<td>'.number_format($total,0,",",".").'</td>';
			$val1.= '</tr>';
			$val1.= '</tbody>';
			$val1.= '</table>';
			echo json_encode(array(
				'val1' => $val1
			));
		}
	}
}
