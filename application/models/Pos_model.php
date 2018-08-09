<?php
class Pos_model extends CI_Model {

        public $title;
        public $content;
        public $date;

        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }

        public function get_last_ten_entries()
        {
                $query = $this->db->get('entries', 10);
                return $query->result();
        }

        public function insert_entry()
        {
                $this->title    = $_POST['title']; // please read the below note
                $this->content  = $_POST['content'];
                $this->date     = time();

                $this->db->insert('entries', $this);
        }

        public function update_entry()
        {
                $this->title    = $_POST['title'];
                $this->content  = $_POST['content'];
                $this->date     = time();

                $this->db->update('entries', $this, array('id' => $_POST['id']));
        }
        //supplier
        public function get_supplier()
        {
          $query = $this->db->get('supplier');
          return $query->result();
        }
        public function insert_supplier($data)
        {
          $this->db->insert('supplier', $data);
        }

        public function update_supplier($data)
        {
          $this->db->where('');
          $this->db->update('supplier', $data);
        }
        //pasien
        public function get_pasien()
        {
          $query = $this->db->get('customer');
          return $query->result();
        }
        public function insert_pasien($data)
        {
          $this->db->insert('customer', $data);
        }

        public function update_pasien($data)
        {
          $this->db->where('');
          $this->db->update('customer', $data);
        }
        //produsen
        public function get_produsen()
        {
          $query = $this->db->get('produsen');
          return $query->result();
        }
        public function insert_produsen($data)
        {
          $this->db->insert('produsen', $data);
        }

        public function update_produsen($data)
        {
          $this->db->where('');
          $this->db->update('produsen', $data);
        }
        //golongan obat
        public function get_golongan()
        {
          $query = $this->db->get('jenis_obat');
          return $query->result();
        }
        public function insert_golongan($data)
        {
          $this->db->insert('jenis_obat', $data);
        }

        public function update_golongan($data)
        {
          $this->db->where('');
          $this->db->update('jenis_obat', $data);
        }

        public function delete_golongan($kode_jenis)
        {
          $this->db->where('kode_jenis',$kode_jenis);
          $this->db->delete('jenis_obat');
        }
        //obat
        public function get_obat()
        {
          $this->db->where('obat_referensi',null);
          $query = $this->db->get('obat');
          return $query->result();
        }
        public function get_kode_obat($kode_jenis)
        {
          $this->db->select('kode_obat');
          $this->db->limit('1');
          $this->db->like('kode_jenis',$kode_jenis);
          $this->db->order_by('tgl_input','desc');
          $query = $this->db->get('obat');
      		$result = $query->row();
          if(is_null($result)){
            return $result;
          }else{
            return $result->kode_obat;
          }
        }
        public function search_obat($keyword)
        {
          $this->db->like('kode_obat',$keyword);
          $this->db->or_like('nama_obat',$keyword);
          $query = $this->db->get('obat');
          return $query->result();
        }
        public function insert_obat($data)
        {
          $this->db->insert('obat', $data);
        }

        public function update_obat($data)
        {
          $this->db->where('');
          $this->db->update('obat', $data);
        }

        public function delete_obat($kode_jenis)
        {
          $this->db->where('kode_obat',$kode_jenis);
          $this->db->delete('obat');
        }
        //jasa
        public function get_jasa()
        {
          $query = $this->db->get('jasa');
          return $query->result();
        }
        public function search_jasa($keyword)
        {
          $this->db->like('kode_jasa',$keyword);
          $this->db->or_like('nama_jasa',$keyword);
          $query = $this->db->get('jasa');
          return $query->result();
        }
        public function insert_jasa($data)
        {
          $this->db->insert('jasa', $data);
        }

        public function update_jasa($data)
        {
          $this->db->where('');
          $this->db->update('jasa', $data);
        }

        public function delete_jasa($kode_jasa)
        {
          $this->db->where('kode_jasa',$kode_jasa);
          $this->db->delete('jasa');
        }

}
