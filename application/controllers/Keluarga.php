<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keluarga extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		$this->load->library('upload');
		$this->load->model('Model_Keluarga', 'keluarga');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil($id)
	{
		$this->session->set_userdata("judul", "Data keluarga Karyawan");
		$ba = [
			'judul' => "Data Keluarga Karyawan",
			'subjudul' => "Keluarga Karyawan",
		];
		$d = [
			'id' => $id,
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('karyawan_keluarga', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_keluarga_karyawan($id)
	{
		$list = $this->keluarga->get_datatables($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $keluarga) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $keluarga->kga_nama;
			$row[] = $keluarga->kga_hubungan;
			$row[] = $keluarga->kga_notelp;
			$row[] = "<a href='#' onClick='ubah_keluarga(" . $keluarga->kga_id . ")' class='btn btn-default btn-sm' title='Ubah data keluarga'><i class='fa fa-edit'></i></a> <a href='#' onClick='hapus_keluarga(" . $keluarga->kga_id . ")' class='btn btn-danger btn-sm' title='Hapus data keluarga'><i class='fa fa-trash'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->keluarga->count_all(),
			"recordsFiltered" => $this->keluarga->count_filtered($id),
			"data" => $data,
			"query" => $this->keluarga->getlastquery(),
		);
		//output to json format
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('kga_id');
		$data = $this->keluarga->cari_keluarga($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('kga_id');
		$data = $this->input->post();

		if ($id == 0) {
			$insert = $this->keluarga->simpan("ba_karyawan_keluarga", $data);
		} else {
			$insert = $this->keluarga->update("ba_karyawan_keluarga", array('kga_id' => $id), $data);
		}

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Data Keluarga berhasil disimpan";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function hapus($id)
	{
		$delete = $this->keluarga->delete('ba_karyawan_keluarga', 'kga_id', $id);
		if ($delete) {
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-check-circle text-success'></i>&nbsp;&nbsp;&nbsp; Data Keluarga berhasil dihapus";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "<i class='fa fa-exclamation-triangle text-warning'></i>&nbsp;&nbsp;&nbsp; Data gagal dihapus";
		}
		echo json_encode($resp);
	}
}
