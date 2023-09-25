<?php
class Model_History extends CI_Model
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

	private function _get_datatables_query($karyawan, $bln)
	{
		$level = $this->session->userdata('level');
		$user = $this->session->userdata('id_karyawan');
		$this->db->from($this->table);
		$this->db->join('karyawan', 'kry_id = his_id_karyawan', 'left');
		$this->db->join('lokasi', 'lok_kode = his_lok_kode', 'left');
		if ($karyawan != 'null') {
			$this->db->where('kry_id', $karyawan);
		}
		if ($bln != 'null') {
			$this->db->where('MONTH(his_tanggal)', $bln);
		}
		if ($level == 3) {
			$this->db->where('his_id_karyawan', $user);
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

	function get_datatables($karyawan, $bln)
	{
		$this->_get_datatables_query($karyawan, $bln);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($karyawan, $bln)
	{
		$this->_get_datatables_query($karyawan, $bln);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);

		return $this->db->count_all_results();
	}

	public function get_history()
	{
		$this->db->from("history");
		$query = $this->db->get();

		return $query->result();
	}

	public function cari_history($id)
	{
		$this->db->from("history");
		$this->db->where('his_id', $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function cek_history($kry, $tgl)
	{
		$this->db->from("history");
		$this->db->where('his_id_karyawan', $kry);
		$this->db->where('his_tanggal', $tgl);
		$query = $this->db->get();

		return $query->row();
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
