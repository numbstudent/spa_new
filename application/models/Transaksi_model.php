<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model {

        public $title;
        public $content;
        public $date;

        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
        public function get_kas()
        {
          $sql = "SELECT a.kode_akun, nama_akun, COALESCE(SUM(CASE WHEN debit_kredit = 1 then nilai
            WHEN debit_kredit = 2  then  -nilai
            END), 0)  as nilai
            FROM akun c
            RIGHT JOIN jurnal_detail a ON a.kode_akun = c.kode_akun
            JOIN jurnal b ON b.jurnal_id = a.jurnal_id
            WHERE a.kode_akun = 101 or a.kode_akun = 102
            GROUP BY a.kode_akun
          ";
          $query = $this->db->query($sql);
          return $query->result();
        }
        public function get_kode_akun()
        {
          $this->db->select('kode_akun');
          $this->db->select('nama_akun');
          $this->db->select('kategori');
          $query = $this->db->get('akun');
          return $query->result();
        }
        public function get_kode_akun_kas()
        {
          $this->db->select('kode_akun');
          $this->db->select('nama_akun');
          $this->db->select('kategori');
          $this->db->like('nama_akun',"kas");
          $query = $this->db->get('akun');
          return $query->result();
        }
        public function get_kode_akun_beban()
        {
          $this->db->select('kode_akun');
          $this->db->select('nama_akun');
          $this->db->select('kategori');
          $this->db->like('nama_akun',"beban");
          $query = $this->db->get('akun');
          return $query->result();
        }
        public function get_kode_jurnal()
        {
          $this->db->select('jurnal_id');
          $this->db->limit('1');
          $this->db->order_by('jurnal_id','desc');
          $query = $this->db->get('jurnal');
      		$result = $query->row();
          if(is_null($result)){
            return 0;
          }else{
            return $result->jurnal_id;
          }
        }
        public function insert_jurnal($data)
        {
          return $this->db->insert('jurnal', $data);
        }
        public function insert_jurnal_detail($data)
        {
          return $this->db->insert('jurnal_detail', $data);
        }

        public function get_pasien($nama_customer)
        {
          $this->db->select('nama_customer as label');
          $this->db->select('id_customer');
          $this->db->like('nama_customer',$nama_customer);
          $query = $this->db->get('customer');
          return $query->result();
        }
        //pembelian_obat
        public function get_kode_beli()
        {
          $this->db->select('no_faktur_beli');
          $this->db->limit('1');
          $this->db->order_by('no_faktur_beli','desc');
          $query = $this->db->get('beli');
      		$result = $query->row();
          if(is_null($result)){
            return 0;
          }else{
            return $result->no_faktur_beli;
          }
        }
        public function get_pembelian_obat()
        {
          $this->db->join('supplier A', 'A.kode_supplier = beli.kode_supplier');
          $query = $this->db->get('beli');
          return $query->result();
        }
        public function get_harga_beli($kode_obat)
        {
          $this->db->select('harga_beli');
          $this->db->select('isi');
          $this->db->where('kode_obat',$kode_obat);
          $query = $this->db->get('obat');
          $result = $query->row();
          if(is_null($result)){
            return false;
          }else{
            return $result->harga_beli/$result->isi;
          }
        }
        public function get_pembelian_detail($no_faktur_beli)
        {
          $query = $this->db->select('A.nama_obat');
          $query = $this->db->select('beli.discount');
          $query = $this->db->select('beli.pajak');
          $query = $this->db->select('detail_beli.harga_beli');
          $query = $this->db->select('detail_beli.qty_beli');
          $query = $this->db->select('detail_beli.qty_beli');
          $query = $this->db->select('detail_beli.tgl_kadaluwarsa');
          $query = $this->db->join('detail_beli', 'detail_beli.no_faktur_beli = beli.no_faktur_beli');
          $query = $this->db->join('obat A', 'A.kode_obat = detail_beli.kode_obat');
          $query = $this->db->where('beli.no_faktur_beli', $no_faktur_beli);
          $query = $this->db->get('beli');
          return $query->result();
        }
        public function insert_pembelian_obat($data)
        {
          return $this->db->insert('beli', $data);
        }
        public function insert_pembelian_obat_detail($data)
        {
          $this->db->insert('detail_beli', $data);
        }

        public function update_pembelian_obat($data)
        {
          $this->db->where('');
          $this->db->update('beli', $data);
        }
        //pembayaran obat
        public function get_pembayaran_pembelian_obat()
        {
          $sql = "SELECT *
          FROM (
            SELECT beli.no_faktur_beli,
            beli.jenis_bayar,
            beli.discount,
            beli.pajak,
            COALESCE(SUM(B.harga_beli*B.qty_beli), 0) as pembelian
            FROM `beli`
            JOIN `detail_beli` `B` ON `B`.`no_faktur_beli` = `beli`.`no_faktur_beli`
            GROUP BY `beli`.`no_faktur_beli`
          ) `A`
          JOIN (
            SELECT beli.no_faktur_beli,
            beli.jenis_bayar,
            beli.discount,
            beli.pajak,
            COALESCE(SUM(C.jumlah_bayar), 0) as `pembayaran`
            FROM `beli`
            LEFT JOIN `detail_beli_pembayaran` `C` ON `C`.`no_faktur_beli` = `beli`.`no_faktur_beli`
            GROUP BY `beli`.`no_faktur_beli`
          ) `B` ON `B`.`no_faktur_beli` = `A`.`no_faktur_beli`
          WHERE (`pembelian`-`pembayaran` > 0)
          LIMIT 20
          ";
          $query = $this->db->query($sql);
          return $query->result();
        }
        public function get_pembayaran_pembelian_detail($no_faktur_beli)
        {
          $this->db->select('A.nama_obat');
          $this->db->select('detail_beli.harga_beli');
          $this->db->select('detail_beli.qty_beli');
          $this->db->select('detail_beli.tgl_kadaluwarsa');
          $this->db->join('obat A', 'A.kode_obat = detail_beli.kode_obat');
          $this->db->where('no_faktur_beli', $no_faktur_beli);
          $query = $this->db->get('detail_beli');
          return $query->result();
        }

        public function insert_pembayaran_obat_detail($data)
        {
          return $this->db->insert('detail_beli_pembayaran', $data);
        }

        public function update_pembayaran_obat($data)
        {
          $this->db->where('');
          $this->db->update('beli', $data);
        }

        //purchase order
        public function get_kode_po()
        {
          $this->db->select('no_faktur_pesan');
          $this->db->limit('1');
          $this->db->order_by('no_faktur_pesan','desc');
          $query = $this->db->get('pesan');
      		$result = $query->row();
          if(is_null($result)){
            return 0;
          }else{
            return $result->no_faktur_pesan;
          }
        }
        public function get_purchase_order()
        {
          $this->db->join('supplier A', 'A.kode_supplier = pesan.kode_supplier');
          $this->db->order_by('no_faktur_pesan','desc');
          $query = $this->db->get('pesan');
          return $query->result();
        }
        public function get_purchase_order_pembelian()
        {
          $this->db->join('supplier A', 'A.kode_supplier = pesan.kode_supplier');
          $this->db->where('`no_faktur_pesan` not in (select `no_faktur_pesan` from `beli`)');
          $this->db->order_by('no_faktur_pesan','desc');
          $query = $this->db->get('pesan');
          return $query->result();
        }
        public function get_purchase_order_detail($no_faktur_pesan)
        {
          $query = $this->db->select('A.nama_obat');
          $query = $this->db->select('detail_pesan.harga_beli');
          $query = $this->db->select('detail_pesan.qty_pesan');
          $query = $this->db->join('obat A', 'A.kode_obat = detail_pesan.kode_obat');
          $query = $this->db->where('no_faktur_pesan', $no_faktur_pesan);
          $query = $this->db->get('detail_pesan');
          return $query->result();
        }

        public function get_purchase_order_detail_pembelian($no_faktur_pesan)
        {
          $query = $this->db->join('obat A', 'A.kode_obat = detail_pesan.kode_obat');
          $query = $this->db->where('no_faktur_pesan', $no_faktur_pesan);
          $query = $this->db->get('detail_pesan');
          return $query->result();
        }

        public function insert_purchase_order($data)
        {
          return $this->db->insert('pesan', $data);
        }
        public function insert_purchase_order_detail($data)
        {
          $this->db->insert('detail_pesan', $data);
        }

        public function update_purchase_order($data)
        {
          $this->db->where('');
          $this->db->update('pesan', $data);
        }

        //penjualan obat
        public function get_kode_penjualan()
        {
          $this->db->select('no_faktur_jual');
          $this->db->limit('1');
          $this->db->order_by('no_faktur_jual','desc');
          $query = $this->db->get('jual');
      		$result = $query->row();
          if(is_null($result)){
            return 0;
          }else{
            return $result->no_faktur_jual;
          }
        }
        public function get_penjualan()
        {
          $query = $this->db->get('jual');
          return $query->result();
        }
        public function get_penjualan_detail($no_faktur_jual)
        {
          // $query = $this->db->select('A.nama_obat');
          // $query = $this->db->select('detail_jual.harga_jual');
          // $query = $this->db->select('detail_jual.qty_jual');
          // $query = $this->db->join('obat A', 'A.kode_obat = detail_jual.kode_obat');
          // $query = $this->db->where('no_faktur_jual', $no_faktur_jual);
          // $query = $this->db->get('detail_jual');
          // return $query->result();
          $sql = "SELECT * FROM(
          SELECT
           `A`.`nama_obat`,
            `detail_jual`.`harga_jual`,
             `detail_jual`.`qty_jual`
              FROM `detail_jual`
              JOIN `obat` `A`
              ON `A`.`kode_obat` = `detail_jual`.`kode_obat`
              WHERE `no_faktur_jual` = ?
          UNION
          SELECT
           `A`.`nama_obat`,
            `detail_jual`.`harga_jual`,
             `detail_jual`.`qty_jual`
              FROM `detail_jual`
              JOIN `obat` `A`
              ON `A`.`kode_obat` = `detail_jual`.`kode_obat`
              WHERE `no_faktur_jual` = ?
            ) AS A
          ";
          $query = $this->db->query($sql, array($no_faktur_jual,$no_faktur_jual));
          return $query->result();
        }
        public function insert_penjualan($data)
        {
          return $this->db->insert('jual', $data);
        }
        public function insert_penjualan_detail($data)
        {
          return $this->db->insert('detail_jual', $data);
        }
        public function insert_penjualan_jasa_detail($data)
        {
          return $this->db->insert('detail_jual_jasa', $data);
        }

        public function update_penjualan($data)
        {
          $this->db->where('');
          $this->db->update('jual', $data);
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

        public function get_nama_obat($nama_obat)
        {
          $this->db->select('nama_obat as label');
          $this->db->select('harga_beli');
          $this->db->select('harga_jual');
          $this->db->select('kode_supplier');
          $this->db->select('kode_obat');
          $this->db->select('satuan');
          $this->db->where('obat_referensi'); //where obat_referensi IS NULL
          $this->db->like('nama_obat',$nama_obat);
          $query = $this->db->get('obat');
          return $query->result();
        }
        public function get_nama_obat_penjualan($nama_obat)
        {
          $sql = "SELECT (`stok` - `terjual`) AS `stok`,
          `isi`, `label`, `harga_jual`, `kode_supplier`, A.`kode_obat`, `satuan`, `min_stok`
          FROM `stok_kotor` `A`
          LEFT JOIN `stok_terjual` `B` ON `B`.`kode_obat` = `A`.`kode_obat`
          WHERE `A`.`label` LIKE ? ESCAPE '!'
          OR `A`.`kode_obat` LIKE ? ESCAPE '!'
          GROUP BY `A`.`kode_obat`";
          $query = $this->db->query($sql, array('%'.$nama_obat.'%','%'.$nama_obat.'%'));
          return $query->result();
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

        public function get_nama_jasa_penjualan($nama_jasa)
        {
          $sql = "SELECT `nama_jasa` AS `label`, `harga_jual`, A.`kode_jasa`
          FROM `jasa` `A`
          WHERE `A`.`nama_jasa` LIKE ? ESCAPE '!'
          OR `A`.`kode_jasa` LIKE ? ESCAPE '!'";
          $query = $this->db->query($sql, array('%'.$nama_jasa.'%','%'.$nama_jasa.'%'));
          return $query->result();
        }

}
