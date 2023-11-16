<?php
class Model_Dashboard extends CI_Model
{
	var $table = 'ba_absensi';
	var $column_order = array('abs_id', 'abs_tanggal', 'kry_nama', 'cpy_nama', 'abs_jam_masuk', 'abs_jam_pulang', 'abs_ket'); //set column field database for datatable orderable
	var $column_search = array('abs_id', 'abs_tanggal', 'kry_nama', 'cpy_nama', 'abs_jam_masuk', 'abs_jam_pulang', 'abs_ket'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('abs_id' => 'desc'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$this->db->from($this->table);
		$this->db->join('ba_karyawan', 'kry_id = abs_kry_id', 'left');
		$this->db->join('ba_company', 'cpy_kode = abs_cpy_kode', 'left');
		$this->db->where('abs_tanggal', date('Y-m-d'));
		$i = 0;

		foreach ($this->column_search as $item) // loop column 
		{
			if ($_POST['search']['value']) // if datatable send POST for search
			{

				if ($i === 0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if (isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			foreach ($this->order as $key => $order) {
				$this->db->order_by($key, $order);
			}
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);

		return $this->db->count_all_results();
	}

	public function get_absen_hari_ini()
	{
		$this->db->from($this->table);
		$this->db->join('ba_karyawan', 'kry_id = abs_kry_id', 'left');
		$this->db->join('ba_company', 'cpy_kode = abs_cpy_kode', 'left');
		$this->db->where('abs_tanggal', date('Y-m-d'));
		$query = $this->db->get();

		return $query->result();
	}

	public function get_karyawan()
	{
		$this->db->from("ba_karyawan");
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function ambil_karyawan($id)
	{
		$this->db->from("ba_karyawan");
		$this->db->join('ba_company', 'cpy_kode = kry_cpy_kode', 'left');
		$this->db->join('ba_divisi', 'dvi_id = kry_dvi_id', 'left');
		$this->db->join('ba_jabatan', 'jab_id = kry_jab_id', 'left');
		$this->db->where("kry_id", $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_hadir()
	{
		$this->db->from("ba_absensi");
		$this->db->where("abs_tanggal", date('Y-m-d'));
		$this->db->where("abs_status < 5");
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function get_terlambat()
	{
		$this->db->from("ba_absensi");
		$this->db->where("abs_tanggal", date('Y-m-d'));
		$this->db->where("abs_status", 2);
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function get_cuti()
	{
		$this->db->from("ba_absensi");
		$this->db->where("abs_tanggal", date('Y-m-d'));
		$this->db->where("abs_status", 7);
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function ambil_lokasi($kode)
	{
		$this->db->from("ba_company");
		$this->db->where('cpy_kode', $kode);
		$query = $this->db->get();

		return $query->result();
	}

	public function cek_absen($id, $jam_masuk)
	{
		$this->db->from("ba_absensi");
		$this->db->where("abs_kry_id", $id);
		$this->db->where("abs_tanggal", date('Y-m-d'));
		$this->db->where("abs_jam_masuk >", $jam_masuk);
		$this->db->where("abs_status <", 4);
		$query = $this->db->get();

		return $query->row();
	}

	public function cek_jam_pulang($id)
	{
		$this->db->from("ba_absensi");
		$this->db->where("abs_kry_id", $id);
		$this->db->where("abs_tanggal", date('Y-m-d'));
		$this->db->where("abs_jam_pulang != ''");
		$this->db->where("abs_status <", 4);
		$query = $this->db->get();

		return $query->row();
	}

	public function cek_sakit_izin($id)
	{
		$this->db->from("ba_absensi");
		$this->db->where("abs_kry_id", $id);
		$this->db->where("abs_tanggal", date('Y-m-d'));
		$this->db->where("abs_status >", 4);
		$query = $this->db->get();

		return $query->row();
	}

	public function getlastquery()
	{
		$query = str_replace(array("\r", "\n", "\t"), '', trim($this->db->last_query()));

		return $query;
	}
}
