<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		$this->load->model('Model_Dashboard', 'dashboard');
		$this->load->model('Model_Absensi', 'absensi');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$jam_masuk = "00:00:00";
		$jam_pulang = "17:00:00";
		$jam_sekarang = date('H:i:s');
		$user = $this->session->userdata('id_karyawan');
		$cek = $this->dashboard->cek_absen($user, $jam_masuk);
		$cek_pulang = $this->dashboard->cek_jam_pulang($user, $jam_pulang);
		$cek_sakit_izin = $this->dashboard->cek_sakit_izin($user);
		$ba = [
			'judul' => "Dashboard",
			'subjudul' => "",
		];

		$d = [
			'karyawan' => $this->dashboard->ambil_karyawan($user),
			'data' => $this->dashboard->get_absen_hari_ini(),
			'id_karyawan' => $this->session->userdata('id_karyawan'),
			'hadir' => $this->dashboard->get_hadir(),
			'terlambat' => $this->dashboard->get_terlambat(),
			'tidak_hadir' => $this->dashboard->get_tidak_hadir(),
			'cek' => $cek,
			'cek_pulang' => $cek_pulang,
			'cek_sakit_izin' => $cek_sakit_izin,
			'jam_pulang' => $jam_pulang,
			'jam_sekarang' => $jam_sekarang,
		];

		$this->load->view('background_atas', $ba);
		$this->load->view('dashboard', $d);
		$this->load->view('background_bawah');
	}

	public function scan()
	{
		$ba = [
			'judul' => "Dashboard",
			'subjudul' => "",
		];
		$this->load->view('background_atas', $ba);
		$this->load->view('scan_qr');
		$this->load->view('background_bawah');
	}

	public function hasil_scan($lat, $long)
	{
		$kode_lokasi = $this->input->post('kode_lokasi');
		$ambil = $this->dashboard->ambil_lokasi($kode_lokasi);
		$waktu_in = date('H:i:s');

		$batas_masuk = "08:00:00";
		$status = 0;
		if (strtotime($waktu_in) < strtotime($batas_masuk)) {
			$status = 1;
		} else {
			$terlambat = strtotime($waktu_in) - strtotime($batas_masuk);
			$status = 2;
		}

		$ba = [
			'judul' => "Hasil Scan",
		];

		$d = [
			'nama_karyawan' => $this->session->userdata('nama'),
			'karyawan' => $this->session->userdata('id_karyawan'),
			'lokasi' => $kode_lokasi,
			'waktu_in' => $waktu_in,
			'status' => $status,
			'hasil' => $ambil,
			'terlambat' => $terlambat,
			'lat' => $lat,
			'long' => $long
		];
		$this->load->view('background_atas', $ba);
		$this->load->view('hasil_scan', $d);
		$this->load->view('background_bawah');
	}

	public function scan_pulang()
	{
		$ba = [
			'judul' => "Dashboard",
			'subjudul' => "",
		];
		$this->load->view('background_atas', $ba);
		$this->load->view('scan_qr_pulang');
		$this->load->view('background_bawah');
	}

	public function simpan()
	{
		$id = $this->input->post('abs_id');
		$data = $this->input->post();

		if ($id == 0) {
			$insert = $this->absensi->simpan("ba_absensi", $data);
		} else {
			$insert = $this->absensi->update("ba_absensi", array('abs_id' => $id), $data);
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
}
