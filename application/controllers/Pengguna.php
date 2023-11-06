<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		if ($this->session->userdata("level") > 2) {
			redirect(base_url("Dashboard"));
		}
		$this->load->library('upload');
		$this->load->model('Model_Login', 'pengguna');
		$this->load->model('Model_Karyawan', 'karyawan');
		$this->load->model('Model_Company', 'company');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$this->session->set_userdata("judul", "Data Pengguna");
		$ba = [
			'judul' => "Data Pengguna",
			'subjudul' => "Pengguna",
			'foto' => $this->karyawan->ambil_karyawan($this->session->userdata('id_karyawan')),
		];
		$d = [
			'karyawan' => $this->karyawan->get_karyawan(),
			'company' => $this->company->get_company(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('pengguna', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_pengguna($karyawan, $cpy)
	{
		$list = $this->pengguna->get_datatables($karyawan, $cpy);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pengguna) {
			$no++;
			$level = "";
			switch ($pengguna->usr_role) {
				case 1:
					$level = "Admin";
					break;
				case 2:
					$level = "DIC";
					break;
				case 3:
					$level = "Karyawan";
					break;
			}
			$row = array();
			$row[] = $no;
			$row[] = $pengguna->kry_nama;
			$row[] = $pengguna->usr_username;
			$row[] = $level;
			$row[] = $pengguna->usr_status == 0 ? "<span class='badge badge-danger'>nonaktif</span>" : "<span class='badge badge-success'>aktif</span>";
			$row[] = "<a href='#' onClick='ubah_pengguna(" . $pengguna->usr_id . ")' class='btn btn-default btn-sm' title='Ubah data Pengguna'><i class='fa fa-edit'></i></a> <a href='#' onClick='hapus_pengguna(" . $pengguna->usr_id . ")' class='btn btn-danger btn-sm' title='Hapus data Pengguna'><i class='fa fa-trash'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->pengguna->count_all(),
			"recordsFiltered" => $this->pengguna->count_filtered($karyawan, $cpy),
			"data" => $data,
			"query" => $this->pengguna->getlastquery(),
		);
		//output to json format
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('usr_id');
		$data = $this->pengguna->cari_pengguna($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('usr_id');
		$pass = $this->input->post('usr_password');
		$data = $this->input->post();

		if (!empty($pass)) {
			$data['usr_password'] = md5($pass);
		} else {
			$data['usr_password'] = md5("12345");
		}

		if ($id == 0) {
			$insert = $this->pengguna->simpan("ba_user", $data);
		} else {
			$insert = $this->pengguna->update("ba_user", array('usr_id' => $id), $data);
		}

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Data Pengguna berhasil disimpan";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function hapus($id)
	{
		$delete = $this->pengguna->delete('ba_user', 'usr_id', $id);
		if ($delete) {
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-exclamation-circle text-success'></i>&nbsp;&nbsp;&nbsp; Data Pengguna berhasil dihapus";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "<i class='fa fa-exclamation-triangle text-warning'></i>&nbsp;&nbsp;&nbsp; Data gagal dihapus !!";
		}
		echo json_encode($resp);
	}
}
