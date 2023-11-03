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
		$this->load->model('Model_Rekap', 'rekap');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$this->session->set_userdata("judul", "Data Absensi");
		$user = $this->session->userdata('id_karyawan');
		$total_denda = 0;
		$hitung_denda = $this->absensi->total_denda($user, date('m'));
		if ($hitung_denda->total) $total_denda = number_format($hitung_denda->total, 0);
		
		$ba = [
			'judul' => "Data Absensi",
			'subjudul' => "History Absensi",
			'foto' => $this->karyawan->ambil_karyawan($user),
		];
		$d = [
			'karyawan' => $this->karyawan->get_karyawan(),
			'company' => $this->company->get_company(),
			'total_denda' => $total_denda
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
			$ket_shift = "";
			if ($absensi->abs_shift_id == 1) {
				$ket_shift = "<i style='font-size: 10px;'>Shift Pagi</i>";
			} else if ($absensi->abs_shift_id == 2) {
				$ket_shift = "<i style='font-size: 10px;'>Shift Siang</i>";
			}
			switch ($absensi->abs_status) {
				case 1:
					$status = "<span class='badge badge-success' style='font-size: 10px;'>Hadir</span><br>$ket_shift";
					break;
				case 2:
					$status = "<span class='badge badge-warning' style='font-size: 10px;'>Terlambat</span><br>$ket_shift";
					break;
				case 3:
					$status = "<span class='badge badge-danger' style='font-size: 10px;'>Tidak Absen Masuk</span>";
					break;
				case 4:
					$status = "<span class='badge badge-danger' style='font-size: 10px;'>Pulang Cepat<br>$ket_shift</span>";
					break;
				case 5:
					$status = "<span class='badge badge-info' style='font-size: 10px;'>Sakit</span>";
					break;
			}

			$lok_masuk = 'Lokasi Tidak Diketahui';
			$lok_pulang = 'Lokasi Tidak Diketahui';
			$ambil_masuk = $this->company->ambil_company($absensi->abs_cpy_kode);
			$ambil_pulang = $this->company->ambil_company($absensi->abs_cpy_pulang);
			if ($ambil_masuk) $lok_masuk = $ambil_masuk->cpy_nama;
			if ($ambil_pulang) $lok_pulang = $ambil_pulang->cpy_nama;

			$row = array();
			$row[] = $no;
			$row[] = $absensi->abs_tanggal;
			$row[] = $absensi->kry_nama;
			$row[] = $absensi->abs_jam_masuk;
			$row[] = $absensi->abs_jam_pulang;
			$row[] = $lok_masuk;
			$row[] = $lok_pulang;
			$row[] = $status;
			$row[] = $absensi->abs_ket;
			if ($this->session->userdata('level') < 3) {
				$row[] = "<a href='#' onClick='hapus_absensi(" . $absensi->abs_id . ")' class='btn btn-danger btn-xs' title='Hapus Absensi'><i class='fa fa-trash'></i></a>";
			}
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
		$jml_terlambat = $this->input->post('abs_terlambat');
		$data = $this->input->post();
		$data['abs_terlambat'] = floor($jml_terlambat / 60);
		$data['abs_denda'] = floor($data['abs_terlambat'] * 1000);
		
		$str = $data['abs_tanggal'];
		$explode = explode("-", $str);

		$cek_rekap = $this->rekap->cek_rekap($data['abs_kry_id'], $explode[1]);

		$terlambat = 0;
		$denda = 0;
		$total_terlambat = 0;
		$total_denda = 0;
		if ($cek_rekap) $terlambat = $cek_rekap->rkp_terlambat;
		if ($cek_rekap) $denda = $cek_rekap->rkp_denda;
		if ($data['abs_terlambat']) $total_terlambat = $data['abs_terlambat'];
		if ($data['abs_denda']) $total_denda = $data['abs_denda'];

		$data2 = [
			'rkp_bulan' => $explode[1],
			'rkp_kry_id' => $data['abs_kry_id'],
			'rkp_cpy_kode' => $data['abs_cpy_kode'],
			'rkp_terlambat' => $terlambat + $total_terlambat,
			'rkp_denda' => $denda + $total_denda,
		];

		$where2 = [
			'rkp_kry_id' => $data['abs_kry_id'],
			'rkp_bulan' => $explode[1],
		];

		$insert = $this->absensi->simpan("ba_absensi", $data);

		if (!$cek_rekap) {
			$this->absensi->simpan("ba_rekap", $data2);
		} else {
			$this->absensi->update("ba_rekap", $where2, $data2);
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

	public function simpan_absen_pulang()
	{
		$data = $this->input->post();

		$waktu_absen = $this->input->post('abs_jam_masuk');

		$cek_absensi = $this->absensi->cek_absensi($data['abs_kry_id'], $data['abs_tanggal']);

		// $lata = $data['lat'] + (0.018);
		// $latb = $data['lat'] - (0.018);
		// $longa = $data['long'] + (0.018);
		// $longb = $data['long'] - (0.018);

		// $ambil_cpy = $this->company->ambil_kode($lata, $latb, $longa, $longb);
		
		// $cpy_kode = "0";
		// if ($ambil_cpy) $cpy_kode = $ambil_cpy->cpy_kode;

		$absen_pulang = [
			'abs_jam_pulang' => $waktu_absen,
			'abs_cpy_pulang' => $data['abs_cpy_kode'],
		];

		$simpan_absen_pulang = [
			'abs_kry_id' => $data['abs_kry_id'],
			'abs_tanggal' => $data['abs_tanggal'],
			'abs_jam_pulang' => $waktu_absen,
			'abs_cpy_pulang' => $data['abs_cpy_kode'],
			'abs_status' => 3,
		];

		$where = [
			'abs_kry_id' => $data['abs_kry_id'],
			'abs_tanggal' => $data['abs_tanggal'],
		];

		if ($cek_absensi) {
			$insert = $this->absensi->update("ba_absensi", $where, $absen_pulang);
		} else {
			$insert = $this->absensi->simpan("ba_absensi", $simpan_absen_pulang);
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
