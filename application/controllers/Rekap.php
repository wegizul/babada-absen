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
		$this->load->model('Model_Company', 'company');
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
			'company' => $this->company->get_company(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('rekap', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_rekap($karyawan, $bln, $cpy)
	{
		$list = $this->rekap->get_datatables($karyawan, $bln, $cpy);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $rekap) {
			$no++;

			$hadir = $this->rekap->get_hadir($rekap->kry_id, $bln, $cpy);

			$bulan = date('n');
			if ($rekap->rkp_bulan) $bulan = $rekap->rkp_bulan;

			$row = array();
			$row[] = $no;
			$row[] = $rekap->kry_nama;
			$row[] = $this->rekap->bulan($bulan);
			$row[] = $hadir;
			$row[] = $rekap->rkp_sakit ? $rekap->rkp_sakit : 0;
			$row[] = $rekap->rkp_izin ? $rekap->rkp_izin : 0;
			$row[] = $rekap->rkp_alfa ? $rekap->rkp_alfa : 0;
			$row[] = $rekap->rkp_cuti ? $rekap->rkp_cuti : 0;
			$row[] = number_format($rekap->rkp_terlambat, 0) . ' Menit';
			$row[] = 'Rp. ' . number_format($rekap->rkp_denda, 0);
			$row[] = "<a href='#' onClick='ubah_data(" . $rekap->rkp_id . ")' class='btn btn-default btn-sm' title='Ubah Data'><i class='fa fa-edit'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->rekap->count_all(),
			"recordsFiltered" => $this->rekap->count_filtered($karyawan, $bln, $cpy),
			"data" => $data,
			"query" => $this->rekap->getlastquery(),
		);
		//output to json format
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('rkp_id');
		$data = $this->rekap->cari_rekap($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('rkp_id');
		$data = $this->input->post();

		$insert = $this->rekap->update("ba_rekap", array('rkp_id' => $id), $data);

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Data Rekap Absensi berhasil disimpan";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function cetak($kry, $bln, $cpy)
	{
		$ambil_rekap = $this->rekap->ambil_rekap($kry, $bln, $cpy);
		foreach ($ambil_rekap as $rekap) {

			$hadir = $this->rekap->get_hadir($rekap->kry_id, $bln, $cpy);

			$bulan = date('n');
			if ($rekap->rkp_bulan) $bulan = $rekap->rkp_bulan;
		}
		$data = [
			'tampil' => $ambil_rekap,
			'bulan' => $this->rekap->bulan($bulan),
			'hadir' => $hadir,
			'sakit' => $rekap->rkp_sakit,
			'izin' => $rekap->rkp_izin,
			'alfa' => $rekap->rkp_alfa,
			'cuti' => $rekap->rkp_cuti,
			'terlambat' => $rekap->rkp_terlambat,
			'denda' => "Rp. " . number_format($rekap->rkp_denda, 0),
		];
		$this->load->view('cetak', $data);
	}
}
