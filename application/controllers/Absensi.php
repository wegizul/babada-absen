<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		$this->load->library('upload');
		$this->load->model('Model_Absensi', 'absensi');
		$this->load->model('Model_Karyawan', 'karyawan');
		$this->load->model('Model_Company', 'company');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$this->session->set_userdata("judul", "Data Absensi");
		$ba = [
			'judul' => "Data Absensi",
			'subjudul' => "History Absensi",
		];
		$d = [
			'karyawan' => $this->karyawan->get_karyawan(),
			'company' => $this->company->get_company(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('absensi', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_absensi($karyawan, $bln, $cpy)
	{
		$list = $this->absensi->get_datatables($karyawan, $bln, $cpy);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $absensi) {
			$no++;
			$status = "";
			switch ($absensi->abs_status) {
				case 1:
					$status = "<span class='badge badge-success'>Hadir</span>";
					break;
				case 2:
					$status = "<span class='badge badge-warning'>Terlambat</span>";
					break;
				case 3:
					$status = "<span class='badge badge-danger'>Sakit</span>";
					break;
				case 4:
					$status = "<span class='badge badge-info'>Izin</span>";
					break;
			}

			$row = array();
			$row[] = $no;
			$row[] = $absensi->abs_tanggal;
			$row[] = $absensi->kry_nama;
			$row[] = $absensi->abs_jam_masuk;
			$row[] = $absensi->abs_jam_pulang;
			$row[] = $absensi->cpy_nama;
			$row[] = $status;
			$row[] = $absensi->abs_ket;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->absensi->count_all(),
			"recordsFiltered" => $this->absensi->count_filtered($karyawan, $bln, $cpy),
			"data" => $data,
			"query" => $this->absensi->getlastquery(),
		);
		//output to json format
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('abs_id');
		$data = $this->absensi->cari_absensi($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('abs_id');
		$jml_terlambat = $this->input->post('abs_terlambat');
		$data = $this->input->post();
		$data['abs_terlambat'] = floor($jml_terlambat / 60);
		$data['abs_denda'] = floor($data['abs_terlambat'] * 1000);

		$waktu_absen = $this->input->post('abs_jam_masuk');

		$cek_absensi = $this->absensi->cek_absensi($data['abs_kry_id'], $data['abs_tanggal']);

		$absen_pulang = [
			'abs_jam_pulang' => $waktu_absen,
		];
		$where = [
			'abs_kry_id' => $data['abs_kry_id'],
			'abs_tanggal' => $data['abs_tanggal'],
		];

		if (!$cek_absensi) {
			$insert = $this->absensi->simpan("ba_absensi", $data);
		} else {
			$insert = $this->absensi->update("ba_absensi", $where, $absen_pulang);
		}

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil melakukan absen";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function hapus($id)
	{
		$delete = $this->absensi->delete('ba_absensi', 'abs_id', $id);
		if ($delete) {
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-check-circle text-success'></i>&nbsp;&nbsp;&nbsp; Berhasil menghapus data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "<i class='fa fa-exclamation-triangle text-warning'></i>&nbsp;&nbsp;&nbsp; Data gagal dihapus";
		}
		echo json_encode($resp);
	}
}
