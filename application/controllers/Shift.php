<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shift extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		$this->load->library('upload');
		$this->load->model('Model_Shift', 'data_shift');
		$this->load->model('Model_Karyawan', 'karyawan');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$this->session->set_userdata("judul", "Data Shift Karyawan");
		$ba = [
			'judul' => "Data Shift Karyawan",
			'subjudul' => "Shift Karyawan",
			'foto' => $this->karyawan->ambil_karyawan($this->session->userdata('id_karyawan')),
		];
		$d = [];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('data_shift', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_data_shift()
	{
		$list = $this->data_shift->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $data_shift) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_shift->sft_nama;
			$row[] = $data_shift->sft_jam_masuk;
			$row[] = $data_shift->sft_jam_pulang;
			$row[] = "<a href='#' onClick='ubah_data_shift(" . $data_shift->sft_id . ")' class='btn btn-default btn-sm' title='Ubah data shift'><i class='fa fa-edit'></i></a> <a href='#' onClick='hapus_data_shift(" . $data_shift->sft_id . ")' class='btn btn-danger btn-sm' title='Hapus data shift'><i class='fa fa-trash'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->data_shift->count_all(),
			"recordsFiltered" => $this->data_shift->count_filtered(),
			"data" => $data,
			"query" => $this->data_shift->getlastquery(),
		);
		//output to json format
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('sft_id');
		$data = $this->data_shift->cari_data_shift($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('sft_id');
		$data = $this->input->post();

		if ($id == 0) {
			$insert = $this->data_shift->simpan("ba_data_shift", $data);
		} else {
			$insert = $this->data_shift->update("ba_data_shift", array('sft_id' => $id), $data);
		}

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Data Shift berhasil disimpan";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function hapus($id)
	{
		$delete = $this->data_shift->delete('ba_data_shift', 'sft_id', $id);
		if ($delete) {
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-check-circle text-success'></i>&nbsp;&nbsp;&nbsp; Data Shift berhasil dihapus";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "<i class='fa fa-exclamation-triangle text-warning'></i>&nbsp;&nbsp;&nbsp; Data gagal dihapus";
		}
		echo json_encode($resp);
	}
}
