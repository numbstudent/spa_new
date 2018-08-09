<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logistic extends CI_Controller {

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
	public function master_obat()
	{
		$this->cekposisi();
		$this->load->model('pos_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="info">', '</div>');
		$this->form_validation->set_rules('kode_obat', 'Kode Obat', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data['query'] = $this->pos_model->get_obat();
			$data['query2'] = $this->pos_model->get_produsen();
			$data['query3'] = $this->pos_model->get_supplier();
			$data['query4'] = $this->pos_model->get_golongan();
			$this->load->view('template/header');
			$this->load->view('template/navigation');
			$this->load->view('master/master_obat',$data);
			$this->load->view('template/footer');
		}else{
			$harga_jual = str_replace( '.', '', $this->input->post('harga_jual'));
			$harga_beli = str_replace( '.', '', $this->input->post('harga_beli'));
			$stok_obat = str_replace( '.', '', $this->input->post('stok_awal'));
			$min_stok = str_replace( '.', '', $this->input->post('min_stok'));
			$isi = str_replace( '.', '', $this->input->post('isi'));
			$data = array(
				'kode_obat' => $this->input->post('kode_obat'),
				'nama_obat' => $this->input->post('nama_obat').' ('.$this->input->post('satuan').')',
				'kode_jenis' => $this->input->post('kode_jenis'),
				'kode_produsen' => $this->input->post('kode_produsen'),
				'kode_supplier' => $this->input->post('kode_supplier'),
				'harga_jual' => $harga_jual,
				'harga_beli' => $harga_beli,
				'stok_obat' => $stok_obat,
				'min_stok' => $min_stok,
				'kena_pajak' => '1', // gonna delete it
				'satuan' => $this->input->post('satuan'),
				'isi' => $isi,
				'tgl_input' => date('Y/m/d'),
			);
			$this->pos_model->insert_obat($data);
			$data2 = array(
				'kode_obat' => $this->input->post('kode_obat').'_b',
				'nama_obat' => $this->input->post('nama_obat').' ('.$this->input->post('satuan_isi').')',
				'kode_jenis' => $this->input->post('kode_jenis'),
				'kode_produsen' => $this->input->post('kode_produsen'),
				'kode_supplier' => $this->input->post('kode_supplier'),
				'harga_jual' => $harga_jual/$isi,
				'harga_beli' => $harga_beli/$isi,
				'obat_referensi' => $this->input->post('kode_obat'),
				'stok_obat' => 0,
				'min_stok' => 0,
				'satuan' => $this->input->post('satuan_isi'),
				'isi' => 1,
				'tgl_input' => date('Y/m/d')
			);
			$this->pos_model->insert_obat($data2);
			redirect(base_url().'master/obat');
		}
	}
	public function master_jasa()
	{
		$this->cekposisi();
		$this->load->model('pos_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="info">', '</div>');
		$this->form_validation->set_rules('kode_jasa', 'Kode Obat', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data['query'] = $this->pos_model->get_jasa();
			$this->load->view('template/header');
			$this->load->view('template/navigation');
			$this->load->view('master/master_jasa',$data);
			$this->load->view('template/footer');
		}else{
			$harga_jual = str_replace( '.', '', $this->input->post('harga_jual'));
			$data = array(
				'kode_jasa' => $this->input->post('kode_jasa'),
				'nama_jasa' => $this->input->post('nama_jasa'),
				'harga_jual' => $harga_jual
			);
			$this->pos_model->insert_jasa($data);
			redirect(base_url().'master/jasa');
		}
	}
	public function master_tipe_obat()
	{
		echo "belum ada";
	}
	public function master_golongan_obat()
	{
		$this->cekposisi();
		$this->load->model('pos_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="info">', '</div>');
		$this->form_validation->set_rules('kode_golongan', 'Nama Jenis', 'required');
		$this->form_validation->set_rules('nama_golongan', 'Nama Jenis', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data['query'] = $this->pos_model->get_golongan();
			$this->load->view('template/header');
			$this->load->view('template/navigation');
			$this->load->view('master/master_golongan_obat',$data);
			$this->load->view('template/footer');
		}else{
			$data = array(
				'kode_jenis' => htmlspecialchars($this->input->post('kode_golongan')),
				'nama_jenis' => htmlspecialchars($this->input->post('nama_golongan'))
			);
			$this->pos_model->insert_golongan($data);
			$this->session->set_flashdata('message', 'Data berhasil ditambahkan');
			redirect(current_url());
		}
	}
	public function delete_golongan_obat()
	{
		$this->cekposisi();
		$this->load->model('pos_model');
		$kode_jenis =  htmlspecialchars($this->input->post('kode_golongan'));
		$this->pos_model->delete_golongan($kode_jenis);
		$this->session->set_flashdata('message', 'Data '.$kode_jenis.' berhasil dihapus');
		redirect(base_url().'master/golongan-obat');
	}
	public function master_produsen_obat()
	{
		$this->cekposisi();
		$this->load->model('pos_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="info">', '</div>');
		$this->form_validation->set_rules('kode_produsen', 'Nama Produsen', 'required');
		$this->form_validation->set_rules('nama_produsen', 'Kode Produsen', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data['query'] = $this->pos_model->get_produsen();
			$this->load->view('template/header');
			$this->load->view('template/navigation');
			$this->load->view('master/master_produsen_obat',$data);
			$this->load->view('template/footer');
		}else{
			$data = array(
				'kode_produsen' => htmlspecialchars($this->input->post('kode_produsen')),
				'nama_produsen' => htmlspecialchars($this->input->post('nama_produsen')),
				'kota_produsen' => htmlspecialchars($this->input->post('kota_produsen'))
			);
			$this->pos_model->insert_produsen($data);
			$this->session->set_flashdata('message', 'Data berhasil ditambahkan');
			redirect(current_url());
		}
	}
	public function master_pbf()
	{
		$this->cekposisi();
		$this->load->model('pos_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="info">', '</div>');
		$this->form_validation->set_rules('kode_supplier', 'Kode Supplier', 'required');
		$this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data['query'] = $this->pos_model->get_supplier();
			$this->load->view('template/header');
			$this->load->view('template/navigation');
			$this->load->view('master/master_pbf',$data);
			$this->load->view('template/footer');
		}else{
			$data = array(
				'kode_supplier' => htmlspecialchars($this->input->post('kode_supplier')),
				'nama_supplier' => htmlspecialchars($this->input->post('nama_supplier')),
				'kota_supplier' => htmlspecialchars($this->input->post('kota_supplier')),
				'alamat_supplier' => htmlspecialchars($this->input->post('alamat_supplier')),
				'telepon_supplier' => htmlspecialchars($this->input->post('telepon_supplier')),
				'contact_supplier' => htmlspecialchars($this->input->post('contact_supplier'))
			);
			$this->pos_model->insert_supplier($data);
			$this->session->set_flashdata('message', 'Data berhasil ditambahkan');
			redirect(current_url());
		}
	}

	public function master_pasien()
	{
		$this->cekposisi();
		$this->load->model('pos_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="info">', '</div>');
		$this->form_validation->set_rules('nama_customer', 'Nama Lengkap', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data['pasien'] = $this->pos_model->get_pasien();
			$this->load->view('template/header');
			$this->load->view('template/navigation');
			$this->load->view('master/master_pasien',$data);
			$this->load->view('template/footer');
		}else{
			$tgl = explode('/',htmlspecialchars($this->input->post('tanggal_lahir')));
			$tgl = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
			$data = array(
				'nama_customer' => htmlspecialchars($this->input->post('nama_customer')),
				'alamat_customer' => htmlspecialchars($this->input->post('alamat_customer')),
				'telepon_customer' => htmlspecialchars($this->input->post('telepon_customer'))
			);
			$this->pos_model->insert_pasien($data);
			redirect(current_url());
		}
	}

	public function get_ajax_kode_obat()
	{
		$this->load->model('pos_model');
		$kode_jenis = htmlspecialchars($this->input->post('kode_jenis'));
		$kode = $this->pos_model->get_kode_obat($kode_jenis);
		// $kode = var_dump($kode);
		if($kode_jenis!=""){
			if(is_null($kode)){
				$kode = $kode_jenis."_".'1';
			}else{
				$kode = explode('_',$kode);
				$kode = $kode_jenis."_".($kode[1]+1);
			}
		}else{
			$kode="";
		}
		echo json_encode(array(
			'val1' => $kode
		));
	}
}
