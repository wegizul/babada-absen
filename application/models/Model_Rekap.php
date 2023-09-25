<?php
class Model_Rekap extends CI_Model
{
	var $table = 'karyawan';
	var $column_order = array('kry_id', 'kry_foto', 'kry_nama', 'kry_telp'); //set column field database for datatable orderable
	var $column_search = array('kry_id', 'kry_foto', 'kry_nama', 'kry_telp'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('kry_nama' => 'asc'); // default order  	private $db_sts;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($kry, $bln)
	{
		$this->db->from($this->table);
		$this->db->join('history', 'his_id_karyawan = kry_id', 'left');
		if ($kry != 'null') {
			$this->db->where('his_id_karyawan', $kry);
		}
		if ($bln != 'null') {
			$this->db->where('MONTH(his_tanggal)', $bln);
		}
		$this->db->group_by('kry_id');
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

	function get_datatables($kry, $bln)
	{
		$this->_get_datatables_query($kry, $bln);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($kry, $bln)
	{
		$this->_get_datatables_query($kry, $bln);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);

		return $this->db->count_all_results();
	}

	public function get_hadir($kry, $bln)
	{
		$this->db->from("history");
		$this->db->where('his_id_karyawan', $kry);
		if ($bln == 'null') {
			$bln = date('n');
		}
		$this->db->where('MONTH(his_tanggal)', $bln);
		$this->db->where('his_status < 3');
		$query = $this->db->get();

		return $query->num_rows();
	}
	public function get_terlambat($kry, $bln)
	{
		$this->db->from("history");
		$this->db->where('his_id_karyawan', $kry);
		if ($bln == 'null') {
			$bln = date('n');
		}
		$this->db->where('MONTH(his_tanggal)', $bln);
		$this->db->where('his_status', 2);
		$query = $this->db->get();

		return $query->num_rows();
	}
	public function get_sakit($kry, $bln)
	{
		$this->db->from("history");
		$this->db->where('his_id_karyawan', $kry);
		if ($bln == 'null') {
			$bln = date('n');
		}
		$this->db->where('MONTH(his_tanggal)', $bln);
		$this->db->where('his_status', 3);
		$query = $this->db->get();

		return $query->num_rows();
	}
	public function get_izin($kry, $bln)
	{
		$this->db->from("history");
		$this->db->where('his_id_karyawan', $kry);
		if ($bln == 'null') {
			$bln = date('n');
		}
		$this->db->where('MONTH(his_tanggal)', $bln);
		$this->db->where('his_status', 4);
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function get_bulan($bln)
	{
		$this->db->select("MONTH(his_tanggal) as bulan");
		$this->db->from("history");
		if ($bln == 'null') {
			$bln = date('n');
		}
		$this->db->where('MONTH(his_tanggal)', $bln);
		$query = $this->db->get();

		return $query->row();
	}

	public function ambil_rekap($kry, $bln)
	{
		$this->db->from("karyawan");
		$this->db->join('history', 'his_id_karyawan = kry_id', 'left');
		if ($kry != 'null') {
			$this->db->where('his_id_karyawan', $kry);
		}
		if ($bln != 'null') {
			$this->db->where('MONTH(his_tanggal)', $bln);
		}
		$this->db->group_by('kry_id');
		$query = $this->db->get();

		return $query->result();
	}

	public function bulan($bln)
	{
		$arr = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		return $arr[$bln];
	}

	public function getlastquery()
	{
		$query = str_replace(array("\r", "\n", "\t"), '', trim($this->db->last_query()));

		return $query;
	}
}
