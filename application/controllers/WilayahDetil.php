<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WilayahDetil extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		$this->load->library('upload');
		$this->load->model('Model_WilayahDetil', 'wilayah_detil');
		$this->load->model('Model_Karyawan', 'karyawan');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil($id)
	{
		$this->session->set_userdata("judul", "Data Wilayah Detil");
		$ba = [
			'judul' => "Data Wilayah Detil",
			'subjudul' => "Wilayah Detil",
			'foto' => $this->karyawan->ambil_karyawan($this->session->userdata('id_karyawan')),
		];
		$d = [
			'id' => $id,
			'cabang' => $this->wilayah_detil->ambil_cabang(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('wilayah_detil', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_wilayah_detil($id)
	{
		$list = $this->wilayah_detil->get_datatables($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $wilayah_detil) {
			$status = "";
			switch ($wilayah_detil->wad_status) {
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
			$row[] = $wilayah_detil->wam_nama_wilayah;
			$row[] = $wilayah_detil->wad_nama;
			$row[] = $status;
			$row[] = "<a href='#' onClick='ubah_wilayah_detil(" . $wilayah_detil->wad_id . ")' class='btn btn-default btn-sm' title='Ubah data wilayah'><i class='fa fa-edit'></i></a> <a href='#' onClick='hapus_wilayah_detil(" . $wilayah_detil->wad_id . ")' class='btn btn-danger btn-sm' title='Hapus data wilayah'><i class='fa fa-trash'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->wilayah_detil->count_all(),
			"recordsFiltered" => $this->wilayah_detil->count_filtered($id),
			"data" => $data,
			"query" => $this->wilayah_detil->getlastquery(),
		);
		//output to json format
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('wad_id');
		$data = $this->wilayah_detil->cari_wilayah_detil($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('wad_id');
		$data = $this->input->post();

		if ($id == 0) {
			$insert = $this->wilayah_detil->simpan("ba_wilayah_detil", $data);
		} else {
			$insert = $this->wilayah_detil->update("ba_wilayah_detil", array('wad_id' => $id), $data);
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
		$delete = $this->wilayah_detil->delete('ba_wilayah_detil', 'wad_id', $id);
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
