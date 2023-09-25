<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lokasi extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		$this->load->library('upload');
		$this->load->model('Model_Lokasi', 'lokasi');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$this->session->set_userdata("judul", "Data Lokasi");
		$ba = [
			'judul' => "Data Lokasi",
			'subjudul' => "Lokasi Patroli",
		];
		$d = [];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('lokasi', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_lokasi()
	{
		$list = $this->lokasi->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $lokasi) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = '<img width="100" src="' . base_url("aset/foto/qr-code/{$lokasi->lok_qr_code}") . '" alt="">';
			$row[] = $lokasi->lok_nama;
			$row[] = $lokasi->lat;
			$row[] = $lokasi->lang;
			$row[] = "<a href='" . base_url('LokasiDetil/tampil/') . $lokasi->lok_id . "' class='btn btn-success btn-sm' title='Detail Lokasi Patroli'><i class='fa fa-list'></i></a> <a href='#' onClick='ubah_lokasi(" . $lokasi->lok_id . ")' class='btn btn-default btn-sm' title='Ubah data lokasi'><i class='fa fa-edit'></i></a> <a href='#' onClick='hapus_lokasi(" . $lokasi->lok_id . ")' class='btn btn-danger btn-sm' title='Hapus data lokasi'><i class='fa fa-trash'></i></a>";
			// <a href='" . base_url('Lokasi/download/') . $lokasi->lok_id . "' class='btn btn-default btn-sm' title='Detail Lokasi Patroli'><i class='fa fa-download'></i></a>
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->lokasi->count_all(),
			"recordsFiltered" => $this->lokasi->count_filtered(),
			"data" => $data,
			"query" => $this->lokasi->getlastquery(),
		);
		//output to json format
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('lok_id');
		$data = $this->lokasi->cari_lokasi($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('lok_id');
		$data = $this->input->post();

		if ($id == 0) {
			$kode = date('His');
			$data['lok_kode'] = $kode;

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

			$data['lok_qr_code'] = $image_name;

			$insert = $this->lokasi->simpan("lokasi", $data);
		} else {
			$insert = $this->lokasi->update("lokasi", array('lok_id' => $id), $data);
		}

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil menyimpan data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function hapus($id)
	{
		$delete = $this->lokasi->delete('lokasi', 'lok_id', $id);
		$old_image = $this->lokasi->ambil_qrcode($id);
		if ($delete) {
			if ($old_image) unlink("aset/foto/qr-code/" . $old_image->lok_qr_code);
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
		$ambil_gambar = $this->lokasi->ambil_qrcode($urlFile);
		if ($ambil_gambar) {
			$filename    = $ambil_gambar->lok_qr_code;
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
				redirect(base_url('Lokasi/tampil'));
			}
		} else {
			print_r("haha");
		}
	}
}
