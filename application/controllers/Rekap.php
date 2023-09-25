<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekap extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		$this->load->library('upload');
		$this->load->model('Model_Rekap', 'rekap');
		$this->load->model('Model_Karyawan', 'karyawan');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$this->session->set_userdata("judul", "Rekap Absensi");
		$ba = [
			'judul' => "Rekap Absensi",
			'subjudul' => "Rekap Absensi",
		];
		$d = [
			'karyawan' => $this->karyawan->get_karyawan(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('rekap', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_rekap($karyawan, $bln)
	{
		$list = $this->rekap->get_datatables($karyawan, $bln);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $rekap) {
			$no++;

			$hadir = $this->rekap->get_hadir($rekap->kry_id, $bln);
			$terlambat = $this->rekap->get_terlambat($rekap->kry_id, $bln);
			$sakit = $this->rekap->get_sakit($rekap->kry_id, $bln);
			$izin = $this->rekap->get_izin($rekap->kry_id, $bln);

			$ambil_bulan = $this->rekap->get_bulan($bln);
			$row = array();
			$row[] = $no;
			$row[] = $rekap->kry_nama;
			$row[] = $this->rekap->bulan($ambil_bulan->bulan);
			$row[] = $hadir;
			$row[] = $terlambat;
			$row[] = $sakit;
			$row[] = $izin;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->rekap->count_all($karyawan, $bln),
			"recordsFiltered" => $this->rekap->count_filtered($karyawan, $bln),
			"data" => $data,
			"query" => $this->rekap->getlastquery(),
		);
		//output to json format
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('his_id');
		$data = $this->rekap->cari_rekap($id);
		echo json_encode($data);
	}

	public function cetak($kry, $bln)
	{
		$ambil_rekap = $this->rekap->ambil_rekap($kry, $bln);
		$ambil_bulan = $this->rekap->get_bulan($bln);
		foreach ($ambil_rekap as $rekap) {
			$hadir[$rekap->kry_id] = $this->rekap->get_hadir($rekap->kry_id, $bln);
			$terlambat[$rekap->kry_id] = $this->rekap->get_terlambat($rekap->kry_id, $bln);
			$sakit[$rekap->kry_id] = $this->rekap->get_sakit($rekap->kry_id, $bln);
			$izin[$rekap->kry_id] = $this->rekap->get_izin($rekap->kry_id, $bln);
		}
		$data = [
			'tampil' => $ambil_rekap,
			'bulan' => $this->rekap->bulan($ambil_bulan->bulan),
			'hadir' => $hadir,
			'terlambat' => $terlambat,
			'sakit' => $sakit,
			'izin' => $izin,
		];
		$this->load->view('cetak', $data);
	}
}
