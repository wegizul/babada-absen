<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		$this->load->library('upload');
		$this->load->model('Model_Karyawan', 'karyawan');
		$this->load->model('Model_Company', 'company');
		$this->load->model('Model_Divisi', 'divisi');
		$this->load->model('Model_Jabatan', 'jabatan');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$this->session->set_userdata("judul", "Data Karyawan");
		$ba = [
			'judul' => "Data Karyawan",
			'subjudul' => "Karyawan",
			'foto' => $this->karyawan->ambil_karyawan($this->session->userdata('id_karyawan')),
		];
		$d = [
			'company' => $this->company->get_company(),
			'divisi' => $this->divisi->get_divisi(),
			'jabatan' => $this->jabatan->get_jabatan(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('karyawan', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_karyawan()
	{
		$list = $this->karyawan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $karyawan) {
			$no++;
			$status = "";
			switch ($karyawan->kry_status) {
				case 0:
					$status = "<span class='badge badge-secondary'>Tidak Aktif</span>";
					break;
				case 1:
					$status = "<span class='badge badge-success'>Aktif</span>";
					break;
				case 2:
					$status = "<span class='badge badge-warning'>Cuti</span>";
					break;
				case 3:
					$status = "<span class='badge badge-danger'>Resign</span>";
					break;
			}

			$row = array();
			$row[] = $no;
			$row[] = '<a href="#" onClick="lihat_foto(' . $karyawan->kry_id . ')"><img width="100" src="' . base_url("aset/foto/karyawan/{$karyawan->kry_foto}") . '" alt=""></a>';
			$row[] = $karyawan->kry_nama;
			$row[] = $karyawan->kry_jk == 1 ? "Laki-laki" : "Perempuan";
			$row[] = $karyawan->kry_notelp;
			$row[] = $karyawan->cpy_nama;
			$row[] = $status;
			$row[] = "<a href='#' onClick='ubah_karyawan(" . $karyawan->kry_id . ")' class='btn btn-default btn-xs' title='Ubah data karyawan'><i class='fa fa-edit'></i></a> <a href='" . base_url('Keluarga/tampil/') . $karyawan->kry_id . "' class='btn btn-default btn-xs' title='Keluarga Karyawan'><i class='fas fa-user-group'></i></a> <a href='" . base_url('Pendidikan/tampil/') . $karyawan->kry_id . "' class='btn btn-default btn-xs' title='Pendidikan Karyawan'><i class='fa fa-user-graduate'></i></a> <a href='#' onClick='resign_karyawan(" . $karyawan->kry_id . ")' class='btn btn-warning btn-xs' title='Resign'><i class='fa fa-user-slash'></i></a> <a href='#' onClick='hapus_karyawan(" . $karyawan->kry_id . ")' class='btn btn-danger btn-xs' title='Hapus Karyawan'><i class='fa fa-trash'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->karyawan->count_all(),
			"recordsFiltered" => $this->karyawan->count_filtered(),
			"data" => $data,
			"query" => $this->karyawan->getlastquery(),
		);
		//output to json format
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('kry_id');
		$data = $this->karyawan->cari_karyawan($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('kry_id');
		$data = $this->input->post();

		$nmfile = "foto_" . $data['kry_nama'];

		$config['upload_path'] = 'aset/foto/karyawan/';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['file_name'] = $nmfile;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if ($_FILES['kry_foto']['name']) {
			if (!$this->upload->do_upload('kry_foto')) {
				$error = array('error' => $this->upload->display_errors());
				$resp['errorFoto'] = $error;
			} else {
				$data['kry_foto'] = $this->upload->data('file_name');
			}
		}

		if ($id == 0) {
			$insert = $this->karyawan->simpan("ba_karyawan", $data);
		} else {
			$insert = $this->karyawan->update("ba_karyawan", array('kry_id' => $id), $data);
		}

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Data Karyawan berhasil disimpan";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function hapus($id)
	{
		$delete = $this->karyawan->delete('ba_karyawan', 'kry_id', $id);
		if ($delete) {
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-check-circle text-success'></i>&nbsp;&nbsp;&nbsp; Data Karyawan berhasil dihapus";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "<i class='fa fa-exclamation-triangle text-warning'></i>&nbsp;&nbsp;&nbsp; Data gagal dihapus";
		}
		echo json_encode($resp);
	}

	public function simpan_resign()
	{
		$id = $this->input->post('kry_id');
		$data = $this->input->post();

		if ($id == 0) {
			$insert = $this->karyawan->simpan("ba_karyawan", $data);
		} else {
			$insert = $this->karyawan->update("ba_karyawan", array('kry_id' => $id), $data);
		}

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Status Resign Karyawan berhasil disimpan";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function profil()
	{
		$this->session->set_userdata("judul", "Profil");
		$cari_kry = $this->session->userdata('id_karyawan');

		$ba = [
			'judul' => "Profil",
			'subjudul' => "Profil",
			'foto' => $this->karyawan->ambil_karyawan($this->session->userdata('id_karyawan')),
		];
		$d = [
			'karyawan' => $this->karyawan->ambil_karyawan($cari_kry),
			'company' => $this->company->get_company(),
			'divisi' => $this->divisi->get_divisi(),
			'jabatan' => $this->jabatan->get_jabatan(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('profil', $d);
		$this->load->view('background_bawah');
	}
}
