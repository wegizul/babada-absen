<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NotFound extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		// if (!isset($this->session->userdata['id_user'])) {
		// redirect(base_url("login"));
		// }
		$this->load->model('Model_Dashboard', 'dashboard');
		$this->load->model('Model_Karyawan', 'karyawan');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$ba = [
			'judul' => "Halaman Tidak Ditemukan",
			'subjudul' => "under construction",
			'foto' => $this->karyawan->ambil_karyawan($this->session->userdata('id_karyawan')),
		];
		$this->load->view('background_atas', $ba);
		$this->load->view('maintenance');
		$this->load->view('background_bawah');
	}
}
