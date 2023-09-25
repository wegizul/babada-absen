<?php
defined('BASEPATH') or exit('No direct script access allowed');

class History extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		$this->load->library('upload');
		$this->load->model('Model_History', 'history');
		$this->load->model('Model_Karyawan', 'karyawan');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$this->session->set_userdata("judul", "Data History");
		$ba = [
			'judul' => "Data History",
			'subjudul' => "History Absensi",
		];
		$d = [
			'karyawan' => $this->karyawan->get_karyawan(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('history', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_history($karyawan, $bln)
	{
		$list = $this->history->get_datatables($karyawan, $bln);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $history) {
			$no++;
			$status = "";
			switch ($history->his_status) {
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
			$lokasi = "";
			if ($history->his_lok_kode == "" && $history->his_status > 2) {
				$lokasi = "";
			} else if ($history->his_lok_kode == "") {
				$lokasi = "Di Lapangan";
			} else {
				$lokasi = $history->lok_nama;
			}
			$row = array();
			$row[] = $no;
			$row[] = $history->his_tanggal;
			$row[] = $history->kry_nama;
			$row[] = $history->his_waktu_in;
			$row[] = $history->his_waktu_out;
			$row[] = $lokasi;
			$row[] = $status;
			$row[] = $history->his_ket;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->history->count_all($karyawan, $bln),
			"recordsFiltered" => $this->history->count_filtered($karyawan, $bln),
			"data" => $data,
			"query" => $this->history->getlastquery(),
		);
		//output to json format
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('his_id');
		$data = $this->history->cari_history($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('his_id');
		$data = $this->input->post();
		$waktu_absen = $this->input->post('his_waktu_in');

		$cek_history = $this->history->cek_history($data['his_id_karyawan'], $data['his_tanggal']);

		$absen_pulang = [
			'his_waktu_out' => $waktu_absen,
		];
		$where = [
			'his_id_karyawan' => $data['his_id_karyawan'],
			'his_tanggal' => $data['his_tanggal'],
		];

		if (!$cek_history) {
			$insert = $this->history->simpan("history", $data);
		} else {
			$insert = $this->history->update("history", $where, $absen_pulang);
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
		$delete = $this->history->delete('history', 'his_id', $id);
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
