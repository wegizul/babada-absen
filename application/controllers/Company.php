<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Company extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		$this->load->library('upload');
		$this->load->model('Model_Company', 'company');
		$this->load->model('Model_Karyawan', 'karyawan');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$this->session->set_userdata("judul", "Data Perusahaan");
		$ba = [
			'judul' => "Data Perusahaan",
			'subjudul' => "Data Perusahaan",
			'foto' => $this->karyawan->ambil_karyawan($this->session->userdata('id_karyawan')),
		];
		$d = [
			'company' => $this->company->get_company(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('company', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_company()
	{
		$list = $this->company->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $company) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = '<img width="100" src="' . base_url("aset/foto/qr-code/{$company->cpy_qr_code}") . '" alt="">';
			$row[] = $company->cpy_kode;
			$row[] = $company->cpy_nama;
			$row[] = $company->cpy_alamat;
			$row[] = $company->cpy_lat . ' ' . $company->cpy_lang;
			$row[] = "<a href='#' onClick='ubah_company(" . $company->cpy_id . ")' class='btn btn-default btn-sm' title='Ubah data company'><i class='fa fa-edit'></i></a> <a href='#' onClick='hapus_company(" . $company->cpy_id . ")' class='btn btn-danger btn-sm' title='Hapus data company'><i class='fa fa-trash'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->company->count_all(),
			"recordsFiltered" => $this->company->count_filtered(),
			"data" => $data,
			"query" => $this->company->getlastquery(),
		);
		//output to json format
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('cpy_id');
		$data = $this->company->cari_company($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('cpy_id');
		$data = $this->input->post();

		if ($id == 0) {
			$kode = 'CPY' . date('His');
			$data['cpy_kode'] = $kode;

			$this->load->library('ciqrcode'); //pemanggilan library QR CODE

			$config['cacheable']	= true; //boolean, the default is true
			$config['cachedir']		= './aset/'; //string, the default is application/cache/
			$config['errorlog']		= './aset/'; //string, the default is application/logs/
			$config['imagedir']		= './aset/foto/qr-code/'; //direktori penyimpanan qr code
			$config['quality']		= true; //boolean, the default is true
			$config['size']			= '1024'; //interger, the default is 1024
			$config['black']		= array(224, 255, 255); // array, default is array(255,255,255)
			$config['white']		= array(70, 130, 180); // array, default is array(0,0,0)
			$this->ciqrcode->initialize($config);

			$image_name = $kode . '.png'; //buat name dari qr code

			$params['data'] = $kode; //data yang akan di jadikan QR CODE
			$params['level'] = 'H'; //H=High
			$params['size'] = 10;
			$params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder
			$this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

			$data['cpy_qr_code'] = $image_name;

			$insert = $this->company->simpan("ba_company", $data);
		} else {
			$insert = $this->company->update("ba_company", array('cpy_id' => $id), $data);
		}

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Data Company berhasil disimpan";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function hapus($id)
	{
		$delete = $this->company->delete('ba_company', 'cpy_id', $id);
		$old_image = $this->company->ambil_qrcode($id);
		if ($delete) {
			if ($old_image) unlink("aset/foto/qr-code/" . $old_image->cpy_qr_code);
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-check-circle text-success'></i>&nbsp;&nbsp;&nbsp; Berhasil menghapus data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "<i class='fa fa-exclamation-triangle text-warning'></i>&nbsp;&nbsp;&nbsp; Data gagal dihapus";
		}
		echo json_encode($resp);
	}

	function download($urlFile)
	{
		$ambil_gambar = $this->company->ambil_qrcode($urlFile);
		if ($ambil_gambar) {
			$filename    = $ambil_gambar->cpy_qr_code;
			$back_dir    = base_url('aset/foto/qr-code/');
			$file = $back_dir . $filename;

			if (!file_exists($file)) {
				header("Pragma:public");
				header("Expired:0");
				header("Cache-Control:must-revalidate");
				header("Content-Control:public");
				header("Content-Description: File Transfer");
				header("Content-Type: application/octet-stream");
				header("Content-Disposition:attachment; filename=\"" . basename($file) . "\"");
				header("Content-Transfer-Encoding:binary");
				header("Content-Length:" . filesize($file));
				flush();
				readfile($file);
				exit();
			} else {
				redirect(base_url('Company/tampil'));
			}
		} else {
			print_r("haha");
		}
	}
}
