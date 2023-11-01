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
		$this->load->model('Model_Karyawan', 'karyawan');
		$this->load->model('Model_Rekap', 'rekap');
		$this->load->model('Model_Shift', 'shift');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$user = $this->session->userdata('id_karyawan');
		$kode_company = $this->dashboard->ambil_karyawan($user);

		$jam_masuk = "00:00:00";
		$jam_pulang = "17:00:00";

		$jam_sekarang = date('H:i:s');
		$cek = $this->dashboard->cek_absen($user, $jam_masuk);

		if ($this->session->userdata('level') > 1) {
			if ($cek) {
				if (date('D') == "Sat" && $kode_company->cpy_jenis < 3) {
					$jam_pulang = "12:00:00";
				} else if ($kode_company->cpy_jenis == 3 && $cek->abs_jam_masuk < "12:00:00") {
					$jam_pulang = "13:00:00";
				} else if ($kode_company->cpy_jenis == 3 && $cek->abs_jam_masuk > "13:00:00") {
					$jam_pulang = "22:00:00";
				} else {
					$jam_pulang = "15:00:00";
				}
			}
		}

		$cek_pulang = $this->dashboard->cek_jam_pulang($user, $jam_pulang);
		$cek_sakit_izin = $this->dashboard->cek_sakit_izin($user);

		$ba = [
			'judul' => "Dashboard",
			'subjudul' => "",
			'foto' => $this->karyawan->ambil_karyawan($this->session->userdata('id_karyawan')),
		];

		$d = [
			'karyawan' => $this->dashboard->ambil_karyawan($user),
			'data' => $this->dashboard->get_absen_hari_ini(),
			'id_karyawan' => $user,
			'hadir' => $this->dashboard->get_hadir(),
			'terlambat' => $this->dashboard->get_terlambat(),
			'cuti' => $this->dashboard->get_cuti(),
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

	public function scan($x)
	{
		$ba = [
			'judul' => "Dashboard",
			'subjudul' => "",
			'foto' => $this->karyawan->ambil_karyawan($this->session->userdata('id_karyawan')),
		];
		$d = [
			'x' => $x,
		];
		$this->load->view('background_atas', $ba);
		$this->load->view('scan_qr', $d);
		$this->load->view('background_bawah');
	}

	public function hasil_scan($lat, $long, $kode_lokasi, $kode_shift)
	{
		$ambil = $this->dashboard->ambil_lokasi($kode_lokasi);
		$waktu_in = date('H:i:s');

		$batas_masuk = "08:01:00";
		$terlambat = 0;
		$status = 0;
		$shift = $this->session->userdata('shift');

		if ($shift == 1) {
			if (($kode_shift == 1) && (strtotime($waktu_in) < "06:01:00")) {
				$status = 1;
			} else if (($kode_shift == 1) && (strtotime($waktu_in) > "06:01:00")) {
				$terlambat = strtotime($waktu_in) - strtotime("06:01:00");
				$status = 2;
			} else if (($kode_shift == 2) && (strtotime($waktu_in) < "13:01:00") && (strtotime($waktu_in) > "08:01:00")) {
				$status = 1;
			} else if (($kode_shift == 2) && (strtotime($waktu_in) > "13:01:00")) {
				$terlambat = strtotime($waktu_in) - strtotime("13:01:00");
				$status = 2;
			} else {
				$status = 1; 
			}
		} else {
			if (strtotime($waktu_in) < strtotime($batas_masuk)) {
				$status = 1;
			} else {
				$terlambat = strtotime($waktu_in) - strtotime($batas_masuk);
				$status = 2;
			}
		}

		$all_akses = 1;
		if ($this->session->userdata('all_akses') == 0 && $this->session->userdata('cpy_kode') != $kode_lokasi) $all_akses = 0;

		$ba = [
			'judul' => "Hasil Scan",
			'foto' => $this->karyawan->ambil_karyawan($this->session->userdata('id_karyawan')),
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
			'long' => $long,
			'all_akses' => $all_akses,
			'kode_shift' => $kode_shift
		];
		$this->load->view('background_atas', $ba);
		$this->load->view('hasil_scan', $d);
		$this->load->view('background_bawah');
	}

	public function scan_pulang()
	{
		$ba = [
			'judul' => "Dashboard",
			'foto' => $this->karyawan->ambil_karyawan($this->session->userdata('id_karyawan')),
		];
		$this->load->view('background_atas', $ba);
		$this->load->view('scan_qr_pulang');
		$this->load->view('background_bawah');
	}

	public function simpan_absen_sakit()
	{
		$id = $this->input->post('abs_id');
		$data = $this->input->post();

		$ambil_kry = $this->karyawan->cari_karyawan($this->input->post('abs_kry_id'));
		$data['abs_cpy_kode'] = $ambil_kry->kry_cpy_kode;

		$str = $data['abs_tanggal'];
		$explode = explode("-", $str);

		$cek_rekap = $this->rekap->cek_rekap($data['abs_kry_id'], $explode[1]);
		
		$data2 = [
			'rkp_bulan' => $explode[1],
			'rkp_kry_id' => $data['abs_kry_id'],
			'rkp_cpy_kode' => $ambil_kry->kry_cpy_kode,
			'rkp_sakit' => $cek_rekap->rkp_sakit + 1,
		];

		$where2 = [
			'rkp_kry_id' => $data['abs_kry_id'],
			'rkp_bulan' => $explode[1],
		];

		$nmfile = "surat_" . $data['abs_kry_id'] . '_' . $str;

		$config['upload_path'] = 'aset/foto/surat_sakit/';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['file_name'] = $nmfile;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if ($_FILES['abs_foto']['name']) {
			if (!$this->upload->do_upload('abs_foto')) {
				$error = array('error' => $this->upload->display_errors());
				$resp['errorFoto'] = $error;
			} else {
				$data['abs_foto'] = $this->upload->data('file_name');
			}
		}

		if ($id == 0) {
			$insert = $this->absensi->simpan("ba_absensi", $data);
			if (!$cek_rekap) {
				$this->absensi->simpan("ba_rekap", $data2);
			} else {
				$this->absensi->update("ba_rekap", $where2, $data2);
			}
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
