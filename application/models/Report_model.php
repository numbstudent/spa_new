<?php
class Report_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }

        //laporan
        public function get_laporan_harian($tanggal)
        {
          // $sql = "SELECT * FROM(
          //   SELECT `tgl_transaksi`,
          //   `C`.`nama_supplier` as target,
          //   GROUP_CONCAT(B.nama_obat SEPARATOR ', ') as item,
          //   SUM(A.jumlah_bayar) as pembelian,
          //   NULL as `penjualan`
          //   FROM `beli`
          //   JOIN `detail_beli_pembayaran` `A` ON `A`.`no_faktur_beli` = `beli`.`no_faktur_beli`
          //   JOIN `detail_beli` `D` ON `D`.`no_faktur_beli` = `A`.`no_faktur_beli`
          //   JOIN `obat` `B` ON `B`.`kode_obat` = `D`.`kode_obat`
          //   JOIN `supplier` `C` ON `C`.`kode_supplier` = `beli`.`kode_supplier`
          //   WHERE A.`tgl_bayar` = ?
          //   GROUP BY `beli`.`no_faktur_beli`
          //
          //   UNION
          //   SELECT `tgl_transaksi`,
          //   `C`.`nama_customer` as target,
          //   GROUP_CONCAT(B.nama_obat SEPARATOR ', ') as item,
          //   NULL as `pembelian`,
          //   SUM(A.harga_jual * A.qty_jual)*1.1 as penjualan ".//tambah 10% pajak
          //   "
          //   FROM `jual`
          //   JOIN `detail_jual` `A` ON `A`.`no_faktur_jual` = `jual`.`no_faktur_jual`
          //   JOIN `obat` `B` ON `B`.`kode_obat` = `A`.`kode_obat`
          //   JOIN `customer` `C` ON `C`.`id_customer` = `jual`.`id_customer`
          //   WHERE `tgl_transaksi` = ?
          //   GROUP BY `jual`.`no_faktur_jual`
          //
          //   UNION
          //   SELECT `tgl_transaksi`,
          //   `C`.`nama_customer` as target,
          //   GROUP_CONCAT(B.nama_jasa SEPARATOR ', ') as item,
          //   NULL as `pembelian`,
          //   SUM(A.harga_jual * A.qty_jual) as penjualan
          //   FROM `jual`
          //   JOIN `detail_jual_jasa` `A` ON `A`.`no_faktur_jual` = `jual`.`no_faktur_jual`
          //   JOIN `jasa` `B` ON `B`.`kode_jasa` = `A`.`kode_jasa`
          //   JOIN `customer` `C` ON `C`.`id_customer` = `jual`.`id_customer`
          //   WHERE `tgl_transaksi` = ?
          //   GROUP BY `jual`.`no_faktur_jual`
          //
          //   UNION
          //   SELECT `tgl` as tgl_transaksi,
          //   `keterangan` as target,
          //   NULL as item,
          //   nilai as `pembelian`,
          //   NULL as penjualan
          //   FROM `jurnal`
          //   JOIN `jurnal_detail` `A` ON `A`.`jurnal_id` = `jurnal`.`jurnal_id`
          //   WHERE `tgl` = ?
          //   AND `kode_akun`LIKE ?
          //   GROUP BY `jurnal`.`jurnal_id`) AS A
          //   ORDER BY tgl_transaksi
          // ";
          // $query = $this->db->query($sql, array($tanggal,$tanggal,$tanggal,$tanggal,"5%"));
          $sql = "SELECT * FROM(
            SELECT `tgl` as tgl_transaksi,
            `keterangan` as target,
            NULL as item,
            (CASE WHEN debit_kredit = 2 then `nilai`
              WHEN debit_kredit = 1  then  null
              END
            ) as `pembelian`,
            'beban' as `tipe`,
            (CASE WHEN `debit_kredit` = 1 then `nilai`
              WHEN `debit_kredit` = 2  then  null
              END
            ) as `penjualan`
            FROM `jurnal`
            RIGHT JOIN `jurnal_detail` `A` ON `A`.`jurnal_id` = `jurnal`.`jurnal_id`
            WHERE `tgl` = ?
            AND `kode_akun` = 102
            GROUP BY `jurnal`.`jurnal_id`) AS A
            ORDER BY `tgl_transaksi` ASC
          ";
          $query = $this->db->query($sql, array($tanggal));
          return $query->result();
        }

        public function get_laporan_bulanan($bulan, $tahun)
        {
          $sql = "SELECT * FROM(
            SELECT `tgl` as tgl_transaksi,
            `keterangan` as target,
            /*GROUP_CONCAT(B.harga_jual SEPARATOR ', ')*/null as item,
            (CASE WHEN debit_kredit = 2 then `nilai`
              WHEN debit_kredit = 1  then  null
              END
            ) as `pembelian`,
            'beban' as `tipe`,
            (CASE WHEN `debit_kredit` = 1 then `nilai`
              WHEN `debit_kredit` = 2  then  null
              END
            ) as `penjualan`
            FROM `jurnal`
            RIGHT  JOIN `jurnal_detail` `A` ON `A`.`jurnal_id` = `jurnal`.`jurnal_id`
            /*LEFT  JOIN `detail_jual` `B` ON `B`.`no_faktur_jual` = SUBSTRING(`jurnal`.`jurnal_id`,-7)*/
            WHERE MONTH(`tgl`) = ? AND YEAR(`tgl`) = ?
            AND `kode_akun` = 102
            GROUP BY `jurnal`.`jurnal_id`) AS A
            ORDER BY `tgl_transaksi` ASC
          ";
          $query = $this->db->query($sql, array($bulan, $tahun));
          // $sql = "SELECT * FROM(
          //   SELECT `tgl_transaksi`,
          //   `C`.`nama_supplier` as target,
          //   GROUP_CONCAT(B.nama_obat SEPARATOR ', ') as item,
          //   SUM(A.jumlah_bayar) as pembelian, 'beli' as `tipe`,
          //   NULL as `penjualan`
          //   FROM `beli`
          //   JOIN `detail_beli_pembayaran` `A` ON `A`.`no_faktur_beli` = `beli`.`no_faktur_beli`
          //   JOIN `detail_beli` `D` ON `D`.`no_faktur_beli` = `A`.`no_faktur_beli`
          //   JOIN `obat` `B` ON `B`.`kode_obat` = `D`.`kode_obat`
          //   JOIN `supplier` `C` ON `C`.`kode_supplier` = `beli`.`kode_supplier`
          //   WHERE MONTH(A.`tgl_bayar`) = ? AND YEAR(A.`tgl_bayar`) = ?
          //   GROUP BY `beli`.`no_faktur_beli`
          //
          //   UNION
          //   SELECT `tgl_transaksi`,
          //   `C`.`nama_customer` as target,
          //   GROUP_CONCAT(B.nama_obat SEPARATOR ', ') as item,
          //   NULL as `pembelian`, 'obat' as `tipe`,
          //   SUM(A.harga_jual * A.qty_jual)*1.1 as penjualan /*tambah pajak 10%*/
          //   FROM `jual`
          //   JOIN `detail_jual` `A` ON `A`.`no_faktur_jual` = `jual`.`no_faktur_jual`
          //   JOIN `obat` `B` ON `B`.`kode_obat` = `A`.`kode_obat`
          //   JOIN `customer` `C` ON `C`.`id_customer` = `jual`.`id_customer`
          //   WHERE MONTH(`tgl_transaksi`) = ? AND YEAR(`tgl_transaksi`) = ?
          //   GROUP BY `jual`.`no_faktur_jual`
          //
          //   UNION
          //   SELECT `tgl_transaksi`,
          //   `C`.`nama_customer` as target,
          //   GROUP_CONCAT(B.nama_jasa SEPARATOR ', ') as item,
          //   NULL as `pembelian`, 'jasa' as `tipe`,
          //   SUM(A.harga_jual * A.qty_jual) as penjualan
          //   FROM `jual`
          //   JOIN `detail_jual_jasa` `A` ON `A`.`no_faktur_jual` = `jual`.`no_faktur_jual`
          //   JOIN `jasa` `B` ON `B`.`kode_jasa` = `A`.`kode_jasa`
          //   JOIN `customer` `C` ON `C`.`id_customer` = `jual`.`id_customer`
          //   WHERE MONTH(`tgl_transaksi`) = ? AND YEAR(`tgl_transaksi`) = ?
          //   GROUP BY `jual`.`no_faktur_jual`
          //
          //   UNION
          //   SELECT `tgl` as tgl_transaksi,
          //   `keterangan` as target,
          //   NULL as item,
          //   (CASE WHEN debit_kredit = 1 then nilai
          //     WHEN debit_kredit = 2  then  null
          //     END
          //   ) as `pembelian`,
          //   'beban' as `tipe`,
          //   (CASE WHEN debit_kredit = 2 then nilai
          //     WHEN debit_kredit = 1  then  null
          //     END
          //   ) as penjualan
          //   FROM `jurnal`
          //   JOIN `jurnal_detail` `A` ON `A`.`jurnal_id` = `jurnal`.`jurnal_id`
          //   WHERE MONTH(`tgl`) = ? AND YEAR(`tgl`) = ?
          //   AND `kode_akun`LIKE ?
          //   GROUP BY `jurnal`.`jurnal_id`
          //
          //   UNION
          //   SELECT `tgl` as tgl_transaksi,
          //   `keterangan` as target,
          //   NULL as item,
          //   (CASE WHEN debit_kredit = 1 then `nilai`
          //     WHEN debit_kredit = 2  then  null
          //     END
          //   ) as `pembelian`,
          //   'beban' as `tipe`,
          //   (CASE WHEN `debit_kredit` = 2 then `nilai`
          //     WHEN `debit_kredit` = 1  then  null
          //     END
          //   ) as `penjualan`
          //   FROM `jurnal`
          //   JOIN `jurnal_detail` `A` ON `A`.`jurnal_id` = `jurnal`.`jurnal_id`
          //   WHERE MONTH(`tgl`) = ? AND YEAR(`tgl`) = ?
          //   AND `kode_akun` = 102
          //   AND `keterangan` LIKE 'Pemindahan%'
          //   GROUP BY `jurnal`.`jurnal_id`) AS A
          //   ORDER BY `tgl_transaksi` ASC
          // ";
          // $query = $this->db->query($sql, array($bulan, $tahun,$bulan, $tahun,$bulan, $tahun,$bulan, $tahun,"5%",$tahun,$bulan));
          return $query->result();
        }
        public function get_laporan_mingguan()
        {
          $sql = "SELECT * FROM(
            SELECT `tgl_transaksi`,
            `C`.`nama_supplier`,
            GROUP_CONCAT(B.nama_obat SEPARATOR ', ') as item,
            SUM(A.harga_beli * A.qty_pesan) as pembelian,
            NULL as `penjualan`
            FROM `pesan`
            JOIN `detail_pesan` `A` ON `A`.`no_faktur_pesan` = `pesan`.`no_faktur_pesan`
            JOIN `obat` `B` ON `B`.`kode_obat` = `A`.`kode_obat`
            JOIN `supplier` `C` ON `C`.`kode_supplier` = `B`.`kode_supplier`
            WHERE `tgl_transaksi` BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()
            GROUP BY `pesan`.`no_faktur_pesan`
            UNION
            SELECT `tgl_transaksi`,
            `C`.`nama_supplier`,
            GROUP_CONCAT(B.nama_obat SEPARATOR ', ') as item,
            NULL as `pembelian`,
            SUM(A.harga_jual * A.qty_jual) as penjualan
            FROM `jual`
            JOIN `detail_jual` `A` ON `A`.`no_faktur_jual` = `jual`.`no_faktur_jual`
            JOIN `obat` `B` ON `B`.`kode_obat` = `A`.`kode_obat`
            JOIN `supplier` `C` ON `C`.`kode_supplier` = `B`.`kode_supplier`
            WHERE `tgl_transaksi` BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()
            GROUP BY `jual`.`no_faktur_jual`) AS A
            ORDER BY tgl_transaksi
          ";
          $query = $this->db->query($sql);
          return $query->result();
        }

        public function get_laporan_stok()
        {
          $sql = "SELECT (`stok` - `terjual`) AS `stok`,
          `label` as `nama_obat`, `harga_jual`
          FROM `stok_kotor` `A`
          LEFT JOIN `stok_terjual` `B` ON `B`.`kode_obat` = `A`.`kode_obat`
          GROUP BY `A`.`kode_obat`";
          $query = $this->db->query($sql);
          return $query->result();
        }

        public function get_laporan_laba_rugi($tahun)
        {
  //         $sql = "SELECT `A`.`kode_akun`,
  //         `nama_akun`,
  //         COALESCE(SUM(CASE C.`debit_kredit`
  // WHEN '1' THEN nilai
  // WHEN '2' THEN nilai*-1
  // END), 0) as `nilai`
  //         FROM `jurnal` `B`
  //         LEFT JOIN `jurnal_detail` `C` ON `C`.`jurnal_id` = `B`.`jurnal_id`
  //         RIGHT JOIN `akun` `A` ON `A`.`kode_akun` = `C`.`kode_akun`
  //         WHERE/*
  //         YEAR(`B`.`tgl`) = ?
  //         AND*/
  //         (`A`.`kategori` = 4
  //         OR `A`.`kategori` = 5)
  //         GROUP BY `A`.`kode_akun`
  //         ";
          $sql = "SELECT `A`.`kode_akun`,
          `nama_akun`, COALESCE(SUM(CASE WHEN debit_kredit = 1 AND a.kode_akun like '4%' then -nilai
            WHEN debit_kredit = 2  AND a.kode_akun like '4%' then  nilai
            WHEN debit_kredit = 1  AND a.kode_akun like '5%' then  nilai
            WHEN debit_kredit = 2  AND a.kode_akun like '5%' then - nilai
            END), 0)  as nilai
            FROM akun c
            RIGHT JOIN jurnal_detail a ON a.kode_akun = c.kode_akun
            JOIN jurnal b ON b.jurnal_id = a.jurnal_id
            WHERE YEAR(TGL) = ? AND (kategori = 4 OR kategori = 5)
            GROUP BY a.kode_akun
          ";
          $query = $this->db->query($sql,array($tahun));
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
}
