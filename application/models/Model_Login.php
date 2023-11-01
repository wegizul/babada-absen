<?php
class Model_Login extends CI_Model
{
	var $table = 'ba_user';
	var $column_order = array('usr_id', 'kry_nama', 'usr_username', 'usr_role', 'usr_status',); //set column field database for datatable orderable
	var $column_search = array('usr_id', 'kry_nama', 'usr_username', 'usr_role', 'usr_status'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('kry_nama' => 'asc'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($karyawan, $cpy)
	{
		$this->db->from($this->table);
		$this->db->join('ba_karyawan', 'kry_id = usr_kry_id', 'left');
		$this->db->where('usr_role > 1');
		if ($karyawan != 'null') {
			$this->db->where('kry_id', $karyawan);
		}
		if ($cpy != 'null') {
			$this->db->where('usr_cpy_kode', $cpy);
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

	function get_datatables($karyawan, $cpy)
	{
		$this->_get_datatables_query($karyawan, $cpy);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($karyawan, $cpy)
	{
		$this->_get_datatables_query($karyawan, $cpy);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);

		return $this->db->count_all_results();
	}

	public function get_pengguna()
	{
		$this->db->from("ba_user");
		$query = $this->db->get();

		return $query->result();
	}

	public function cek_pengguna()
	{
		$this->db->from("ba_user");
		$query = $this->db->get();

		return $query->row();
	}

	public function cari_pengguna($id)
	{
		$this->db->from("ba_user");
		$this->db->where('usr_id', $id);
		$query = $this->db->get();

		return $query->row();
	}

	function cek($username, $password)
	{
		$this->db->join('ba_karyawan', 'kry_id = usr_kry_id', 'left');
		$this->db->where("usr_username", $username);
		$this->db->where("usr_password", md5($password));
		return $this->db->get("ba_user");
	}

	function cek_password($id, $password)
	{
		$this->db->where("usr_password", md5($password));
		$this->db->where("usr_id", $id);
		return $this->db->get("ba_user");
	}

	public function ambil_nama($id)
	{
		$this->db->from("ba_karyawan");
		$this->db->where('kry_id', $id);
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
