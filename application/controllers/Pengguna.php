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
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$this->session->set_userdata("judul", "Data Pengguna");
		$ba = [
			'judul' => "Data Pengguna",
			'subjudul' => "Pengguna",
		];
		$d = [
			'karyawan' => $this->karyawan->get_karyawan(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('pengguna', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_pengguna()
	{
		$list = $this->pengguna->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pengguna) {
			$no++;
			$level = "";
			switch ($pengguna->level) {
				case 2:
					$level = "Admin";
					break;
				case 3:
					$level = "Karyawan";
					break;
			}
			$row = array();
			$row[] = $no;
			$row[] = $pengguna->nama;
			$row[] = $pengguna->username;
			$row[] = $level;
			$row[] = "<a href='#' onClick='ubah_pengguna(" . $pengguna->id_user . ")' class='btn btn-default' title='Ubah data Pengguna'><i class='fa fa-edit'></i></a> <a href='#' onClick='hapus_pengguna(" . $pengguna->id_user . ")' class='btn btn-danger' title='Hapus data Pengguna'><i class='fa fa-trash'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->pengguna->count_all(),
			"recordsFiltered" => $this->pengguna->count_filtered(),
			"data" => $data,
			"query" => $this->pengguna->getlastquery(),
		);
		//output to json format
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('id_user');
		$data = $this->pengguna->cari_pengguna($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('id_user');
		$pass = $this->input->post('password');
		$data = $this->input->post();
		$ambil_nama = $this->pengguna->ambil_nama($this->input->post('id_karyawan'));

		$data['nama'] = $ambil_nama->kry_nama;
		$data['status'] = 1;

		if (!empty($pass)) {
			$data['password'] = md5($pass);
		}

		if ($id == 0) {
			if (empty($pass)) {
				$data['password'] = md5("user123");
			}
			$insert = $this->pengguna->simpan("login", $data);
		} else {
			$insert = $this->pengguna->update("login", array('id_user' => $id), $data);
		}
		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil menyimpan data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function hapus($id)
	{
		$delete = $this->pengguna->delete('login', 'id_user', $id);
		if ($delete) {
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-exclamation-circle text-success'></i>&nbsp;&nbsp;&nbsp; Berhasil menghapus data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "<i class='fa fa-exclamation-triangle text-warning'></i>&nbsp;&nbsp;&nbsp; Administrator tidak dapat dihapus";
		}
		echo json_encode($resp);
	}
}
