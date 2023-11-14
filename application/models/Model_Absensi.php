<?php
class Model_Absensi extends CI_Model
{
	var $table = 'ba_absensi';
	var $column_order = array('abs_id', 'abs_tanggal', 'kry_nama', 'abs_jam_masuk', 'abs_jam_pulang', 'abs_status'); //set column field database for datatable orderable
	var $column_search = array('abs_id', 'abs_tanggal', 'kry_nama'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('abs_tanggal' => 'desc'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($karyawan, $bln, $cpy, $self)
	{
		$level = $this->session->userdata('level');
		$user = $this->session->userdata('id_karyawan');
		$company = $this->session->userdata('cpy_kode');
		
		$this->db->from($this->table);
		$this->db->join('ba_karyawan', 'kry_id = abs_kry_id', 'left');
		$this->db->join('ba_company', 'cpy_kode = abs_cpy_kode', 'left');

		if ($self == 0) {
			if ($company == "CPY090215") {
				if ($karyawan != 'null' && $bln != 'null') {
					$this->db->where('kry_id', $karyawan);
					$this->db->where('MONTH(abs_tanggal)', $bln);
				} else if ($karyawan != 'null') {
					$this->db->where('kry_id', $karyawan);
				} else if ($bln != 'null') {
					$this->db->where('MONTH(abs_tanggal)', $bln);
				} else {
					$this->db->where("kry_cpy_kode = '$company' OR kry_cpy_kode = 'CPY115933'");
				}
			} else {
				$this->db->where('kry_cpy_kode', $company);
			}
		} else {
			if ($level > 2) {
				$this->db->where('abs_kry_id', $user);
			}
			if ($karyawan != 'null') {
				$this->db->where('kry_id', $karyawan);
			}
			if ($bln != 'null') {
				$this->db->where('MONTH(abs_tanggal)', $bln);
			}
			if ($cpy != 'null') {
				$this->db->where('abs_cpy_kode', $cpy);
			}
		}
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

	function get_datatables($karyawan, $bln, $cpy, $self)
	{
		$this->_get_datatables_query($karyawan, $bln, $cpy, $self);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($karyawan, $bln, $cpy, $self)
	{
		$this->_get_datatables_query($karyawan, $bln, $cpy, $self);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);

		return $this->db->count_all_results();
	}

	public function get_absensi()
	{
		$this->db->from("ba_absensi");
		$query = $this->db->get();

		return $query->result();
	}

	public function cari_absensi($id)
	{
		$this->db->from("ba_absensi");
		$this->db->where('abs_id', $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function cek_absensi($kry, $tgl)
	{
		$this->db->from("ba_absensi");
		$this->db->where('abs_kry_id', $kry);
		$this->db->where('abs_tanggal', $tgl);
		$query = $this->db->get();

		return $query->row();
	}

	public function total_denda($kry, $bln)
	{
		$this->db->select("SUM(abs_denda) as total");
		$this->db->from("ba_absensi");
		$this->db->where('abs_kry_id', $kry);
		$this->db->where('MONTH(abs_tanggal)', $bln);
		$query = $this->db->get();

		return $query->row();
	}

	public function cetak_absensi($kry, $bln, $cpy)
	{
		$company = $this->session->userdata('cpy_kode');

		$this->db->from("ba_absensi");
		$this->db->join("ba_karyawan", "kry_id = abs_kry_id", "left");
		if ($company == "CPY090215") {
			if ($kry != 'null' && $bln != 'null') {
				$this->db->where('kry_id', $kry);
				$this->db->where('MONTH(abs_tanggal)', $bln);
			} else if ($kry != 'null') {
				$this->db->where('kry_id', $kry);
			} else if ($bln != 'null') {
				$this->db->where('MONTH(abs_tanggal)', $bln);
			} else {
				$this->db->where("kry_cpy_kode = '$company' OR kry_cpy_kode = 'CPY115933'");
			}
		} else {
			if ($kry != 'null') {
				$this->db->where('kry_id', $kry);
			}
			if ($bln != 'null') {
				$this->db->where('MONTH(abs_tanggal)', $bln);
			}
			if ($cpy != 'null') {
				$this->db->where('kry_cpy_kode', $cpy);
			}
		}
		$this->db->order_by("kry_nama", "asc");
		$this->db->order_by("abs_tanggal", "desc");
		$query = $this->db->get();

		return $query->result();
	}

	public function getlastquery()
	{
		$query = str_replace(array("\r", "\n", "\t"), '', trim($this->db->last_query()));

		return $query;
	}

	public function update($tbl, $where, $data)
	{
		$this->db->update($tbl, $data, $where);
		return $this->db->affected_rows();
	}

	public function simpan($table, $data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	public function delete($table, $field, $id)
	{
		$this->db->where($field, $id);
		$this->db->delete($table);

		return $this->db->affected_rows();
	}
}
