<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Divisi extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		$this->load->library('upload');
		$this->load->model('Model_Divisi', 'divisi');
		$this->load->model('Model_Karyawan', 'karyawan');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$this->session->set_userdata("judul", "Data Divisi");
		$ba = [
			'judul' => "Data Divisi",
			'subjudul' => "Divisi",
			'foto' => $this->karyawan->ambil_karyawan($this->session->userdata('id_karyawan')),
		];
		$d = [];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('divisi', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_divisi()
	{
		$list = $this->divisi->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $divisi) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $divisi->dvi_kode;
			$row[] = $divisi->dvi_nama;
			$row[] = "<a href='#' onClick='ubah_divisi(" . $divisi->dvi_id . ")' class='btn btn-default btn-sm' title='Ubah data divisi'><i class='fa fa-edit'></i></a> <a href='#' onClick='hapus_divisi(" . $divisi->dvi_id . ")' class='btn btn-danger btn-sm' title='Hapus data divisi'><i class='fa fa-trash'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->divisi->count_all(),
			"recordsFiltered" => $this->divisi->count_filtered(),
			"data" => $data,
			"query" => $this->divisi->getlastquery(),
		);
		//output to json format
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('dvi_id');
		$data = $this->divisi->cari_divisi($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('dvi_id');
		$data = $this->input->post();

		if ($id == 0) {
			$insert = $this->divisi->simpan("ba_divisi", $data);
		} else {
			$insert = $this->divisi->update("ba_divisi", array('dvi_id' => $id), $data);
		}

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Data Divisi berhasil disimpan";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function hapus($id)
	{
		$delete = $this->divisi->delete('ba_divisi', 'dvi_id', $id);
		if ($delete) {
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-check-circle text-success'></i>&nbsp;&nbsp;&nbsp; Data Divisi berhasil dihapus";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "<i class='fa fa-exclamation-triangle text-warning'></i>&nbsp;&nbsp;&nbsp; Data gagal dihapus";
		}
		echo json_encode($resp);
	}
}
