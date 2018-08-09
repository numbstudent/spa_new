<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

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

	public function dashboard()
	{
		$this->load->view('template/header');
		$this->load->view('template/navigation');
		$this->load->view('report/dashboard');
		$this->load->view('template/footer');
	}

	public function laporan_harian()
	{
		$this->cekposisi();
		$this->load->model('report_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="info">', '</div>');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data['query'] = $this->report_model->get_laporan_harian(date("Y/m/d"));
			$data['tanggal'] = date("d/m/Y");
			$this->load->view('template/header');
			$this->load->view('template/navigation');
			$this->load->view('report/laporan_harian',$data);
			$this->load->view('template/footer');
		}else{
			$tanggal = $this->input->post('tanggal');
			$data['query'] = $this->report_model->get_laporan_harian($tanggal);
			$tanggal = explode('/',$tanggal);
			$tanggal = $tanggal[2].'/'.$tanggal[1].'/'.$tanggal[0];
			$data['tanggal'] = $tanggal;
			$this->load->view('template/header');
			$this->load->view('template/navigation');
			$this->load->view('report/laporan_harian',$data);
			$this->load->view('template/footer');
		}
	}

	public function laporan_bulanan()
	{
		$this->cekposisi();
		$this->load->model('report_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="info">', '</div>');
		$this->form_validation->set_rules('bulan', 'Bulan', 'required');
		$this->form_validation->set_rules('tahun', 'Tahun', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data['query'] = $this->report_model->get_laporan_bulanan(date("m"),date("Y"));
			$data['tanggal'] = date("m").' - '.date("Y");
			$this->load->view('template/header');
			$this->load->view('template/navigation');
			$this->load->view('report/laporan_bulanan',$data);
			$this->load->view('template/footer');
		}else{
			$bulan = $this->input->post('bulan');
			$tahun = $this->input->post('tahun');
			$data['query'] = $this->report_model->get_laporan_bulanan($bulan, $tahun);
			$data['tanggal'] = $bulan.' - '.$tahun ;
			$this->load->view('template/header');
			$this->load->view('template/navigation');
			$this->load->view('report/laporan_bulanan',$data);
			$this->load->view('template/footer');
		}
	}

	public function laporan_pendapatan()
	{
		$this->cekposisi();
		$this->load->model('report_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="info">', '</div>');
		$this->form_validation->set_rules('bulan', 'Bulan', 'required');
		$this->form_validation->set_rules('tahun', 'Tahun', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data['query'] = $this->report_model->get_laporan_bulanan(date("m"),date("Y"));
			$data['tanggal'] = date("m").' - '.date("Y");
			$this->load->view('template/header');
			$this->load->view('template/navigation');
			$this->load->view('report/laporan_pendapatan',$data);
			$this->load->view('template/footer');
		}else{
			$bulan = $this->input->post('bulan');
			$tahun = $this->input->post('tahun');
			$data['query'] = $this->report_model->get_laporan_bulanan($bulan, $tahun);
			$data['tanggal'] = $bulan.' - '.$tahun ;
			$this->load->view('template/header');
			$this->load->view('template/navigation');
			$this->load->view('report/laporan_pendapatan',$data);
			$this->load->view('template/footer');
		}
	}

	public function laporan_labarugi()
	{
		$this->cekposisi();
		$this->load->model('report_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="info">', '</div>');
		$this->form_validation->set_rules('bulan', 'Bulan', 'required');
		$this->form_validation->set_rules('tahun', 'Tahun', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data['query'] = $this->report_model->get_laporan_laba_rugi(date("Y"));
			$data['tanggal'] = date("m").' - '.date("Y");
			$this->load->view('template/header');
			$this->load->view('template/navigation');
			$this->load->view('report/laporan_labarugi',$data);
			$this->load->view('template/footer');
		}else{
			$bulan = $this->input->post('bulan');
			$tahun = $this->input->post('tahun');
			$data['query'] = $this->report_model->get_laporan_laba_rugi($tahun);
			$data['tanggal'] = $bulan.' - '.$tahun ;
			$this->load->view('template/header');
			$this->load->view('template/navigation');
			$this->load->view('report/laporan_labarugi',$data);
			$this->load->view('template/footer');
		}
	}

	public function laporan_stok()
	{
		$this->cekposisi();
		$this->load->model('report_model');
		$data['query'] = $this->report_model->get_laporan_stok();
		$data['tanggal'] = date("d/m/Y");
		$this->load->view('template/header');
		$this->load->view('template/navigation');
		$this->load->view('report/laporan_stok',$data);
		$this->load->view('template/footer');
	}

	public function get_ajax_detail_penjualan()
	{

		$no_faktur_jual = htmlspecialchars($this->input->post('id'));
		if($no_faktur_jual){
			$this->load->model('transaksi_model');
			$query = $this->transaksi_model->get_penjualan_detail($no_faktur_jual);
			$total=0;
			$val1 = '';
			$val1 = '<h1>PO '.str_pad($no_faktur_jual,7,"0",'0').'</h1>';
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
}
