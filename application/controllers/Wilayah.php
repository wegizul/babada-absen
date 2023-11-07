<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wilayah extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		$this->load->library('upload');
		$this->load->model('Model_Wilayah', 'wilayah');
		$this->load->model('Model_Karyawan', 'karyawan');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$this->session->set_userdata("judul", "Data Wilayah");
		$ba = [
			'judul' => "Data Wilayah",
			'subjudul' => "Wilayah",
			'foto' => $this->karyawan->ambil_karyawan($this->session->userdata('id_karyawan')),
		];
		$d = [];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('wilayah_am', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_wilayah_am()
	{
		$list = $this->wilayah->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $wilayah_am) {
			$status = "";
			switch ($wilayah_am->wam_status) {
				case 0:
					$status = "<span class='badge badge-secondary'>Tidak Aktif</span>";
					break;
				case 1:
					$status = "<span class='badge badge-success'>Aktif</span>";
					break;
			}

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $wilayah_am->wam_kode_wilayah;
			$row[] = $wilayah_am->wam_nama_wilayah;
			$row[] = $status;
			$row[] = "<a href='" . base_url('WilayahDetil/tampil/') . $wilayah_am->wam_id . "' class='btn btn-default btn-sm' title='Lihat Cabang'><i class='fas fa-store'></i></a> <a href='#' onClick='ubah_wilayah_am(" . $wilayah_am->wam_id . ")' class='btn btn-default btn-sm' title='Ubah data wilayah'><i class='fa fa-edit'></i></a> <a href='#' onClick='hapus_wilayah_am(" . $wilayah_am->wam_id . ")' class='btn btn-danger btn-sm' title='Hapus data wilayah'><i class='fa fa-trash'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->wilayah->count_all(),
			"recordsFiltered" => $this->wilayah->count_filtered(),
			"data" => $data,
			"query" => $this->wilayah->getlastquery(),
		);
		//output to json format
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('wam_id');
		$data = $this->wilayah->cari_wilayah_am($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('wam_id');
		$data = $this->input->post();

		if ($id == 0) {
			$insert = $this->wilayah->simpan("ba_wilayah_am", $data);
		} else {
			$insert = $this->wilayah->update("ba_wilayah_am", array('wam_id' => $id), $data);
		}

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Data Wilayah berhasil disimpan";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function hapus($id)
	{
		$delete = $this->wilayah->delete('ba_wilayah_am', 'wam_id', $id);
		if ($delete) {
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-check-circle text-success'></i>&nbsp;&nbsp;&nbsp; Data Wilayah berhasil dihapus";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "<i class='fa fa-exclamation-triangle text-warning'></i>&nbsp;&nbsp;&nbsp; Data gagal dihapus";
		}
		echo json_encode($resp);
	}
}
