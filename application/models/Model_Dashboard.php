<?php
class Model_Dashboard extends CI_Model
{
	var $table = 'history';
	var $column_order = array('his_id', 'his_tanggal', 'his_id_karyawan', 'his_lok_id', 'his_waktu_in', 'his_waktu_out', 'his_ket'); //set column field database for datatable orderable
	var $column_search = array('his_id', 'his_tanggal', 'his_id_karyawan', 'his_lok_id', 'his_waktu_in', 'his_waktu_out', 'his_ket'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('his_id' => 'desc'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$this->db->from($this->table);
		$this->db->join('karyawan', 'kry_id = his_id_karyawan', 'left');
		$this->db->join('lokasi', 'lok_kode = his_lok_kode', 'left');
		$this->db->where('his_tanggal', date('Y-m-d'));
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
		$this->db->join('karyawan', 'kry_id = his_id_karyawan', 'left');
		$this->db->join('lokasi', 'lok_kode = his_lok_kode', 'left');
		$this->db->where('his_tanggal', date('Y-m-d'));
		$query = $this->db->get();

		return $query->result();
	}

	public function get_karyawan()
	{
		$this->db->from("karyawan");
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function ambil_karyawan($id)
	{
		$this->db->from("karyawan");
		$this->db->where("kry_id", $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_hadir()
	{
		$this->db->from("history");
		$this->db->where("his_tanggal", date('Y-m-d'));
		$this->db->where("his_status != 3");
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function get_terlambat()
	{
		$this->db->from("history");
		$this->db->where("his_tanggal", date('Y-m-d'));
		$this->db->where("his_status", 2);
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function get_tidak_hadir()
	{
		$this->db->from("history");
		$this->db->where("his_tanggal", date('Y-m-d'));
		$this->db->where("his_status > 2");
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function ambil_lokasi($kode)
	{
		$this->db->from("lokasi");
		$this->db->where('lok_kode', $kode);
		$query = $this->db->get();

		return $query->result();
	}

	public function cek_absen($id, $jam_masuk)
	{
		$this->db->from("history");
		$this->db->where("his_id_karyawan", $id);
		$this->db->where("his_tanggal", date('Y-m-d'));
		$this->db->where("his_waktu_in >", $jam_masuk);
		$this->db->where("his_status <", 3);
		$query = $this->db->get();

		return $query->row();
	}

	public function cek_jam_pulang($id, $jam_pulang)
	{
		$this->db->from("history");
		$this->db->where("his_id_karyawan", $id);
		$this->db->where("his_tanggal", date('Y-m-d'));
		$this->db->where("his_waktu_out >=", $jam_pulang);
		$this->db->where("his_status <", 3);
		$query = $this->db->get();

		return $query->row();
	}

	public function cek_sakit_izin($id)
	{
		$this->db->from("history");
		$this->db->where("his_id_karyawan", $id);
		$this->db->where("his_tanggal", date('Y-m-d'));
		$this->db->where("his_status >", 2);
		$query = $this->db->get();

		return $query->row();
	}

	public function getlastquery()
	{
		$query = str_replace(array("\r", "\n", "\t"), '', trim($this->db->last_query()));

		return $query;
	}
}
