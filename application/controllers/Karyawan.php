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
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$this->session->set_userdata("judul", "Data Karyawan");
		$ba = [
			'judul' => "Data Karyawan",
			'subjudul' => "Karyawan",
		];
		$d = [
			'company' => $this->company->get_company(),
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
					$status = "Tidak Aktif";
					break;
				case 1:
					$status = "Aktif";
					break;
				case 2:
					$status = "Cuti";
					break;
			}
			$row = array();
			$row[] = $no;
			$row[] = '<img width="100" src="' . base_url("aset/foto/karyawan/{$karyawan->kry_foto}") . '" alt="">';
			$row[] = $karyawan->kry_nama;
			$row[] = $karyawan->kry_jk == 1 ? "Laki-laki" : "Perempuan";
			$row[] = $karyawan->kry_notelp;
			$row[] = $karyawan->cpy_nama;
			$row[] = $status;
			$row[] = "<a href='#' onClick='ubah_karyawan(" . $karyawan->kry_id . ")' class='btn btn-default btn-sm' title='Ubah data karyawan'><i class='fa fa-edit'></i></a> <a href='#' onClick='hapus_karyawan(" . $karyawan->kry_id . ")' class='btn btn-danger btn-sm' title='Hapus data karyawan'><i class='fa fa-trash'></i></a>";
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
}
