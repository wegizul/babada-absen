<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pendidikan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		$this->load->library('upload');
		$this->load->model('Model_Pendidikan', 'pendidikan');
		$this->load->model('Model_Karyawan', 'karyawan');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil($id)
	{
		$this->session->set_userdata("judul", "Data Pendidikan Karyawan");
		$ba = [
			'judul' => "Data Pendidikan Karyawan",
			'subjudul' => "Pendidikan Karyawan",
			'foto' => $this->karyawan->ambil_karyawan($this->session->userdata('id_karyawan')),
		];
		$d = [
			'id' => $id,
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('karyawan_pendidikan', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_pendidikan_karyawan($id)
	{
		$list = $this->pendidikan->get_datatables($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pendidikan) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $pendidikan->pdd_last_education;
			$row[] = $pendidikan->pdd_keahlian;
			$row[] = $pendidikan->pdd_school_name;
			$row[] = $pendidikan->pdd_jurusan;
			$row[] = $pendidikan->pdd_thn_masuk;
			$row[] = $pendidikan->pdd_thn_lulus;
			$row[] = "<a href='#' onClick='ubah_pendidikan(" . $pendidikan->pdd_id . ")' class='btn btn-default btn-sm' title='Ubah Pendidikan'><i class='fa fa-edit'></i></a> <a href='#' onClick='hapus_pendidikan(" . $pendidikan->pdd_id . ")' class='btn btn-danger btn-sm' title='Hapus Pendidikan'><i class='fa fa-trash'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->pendidikan->count_all(),
			"recordsFiltered" => $this->pendidikan->count_filtered($id),
			"data" => $data,
			"query" => $this->pendidikan->getlastquery(),
		);
		//output to json format
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('pdd_id');
		$data = $this->pendidikan->cari_pendidikan($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('pdd_id');
		$data = $this->input->post();

		$nmfile = "ijazah_" . $data['pdd_kry_id'];

		$config['upload_path'] = 'aset/foto/ijazah/';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['file_name'] = $nmfile;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if ($_FILES['pdd_ijazah']['name']) {
			if (!$this->upload->do_upload('pdd_ijazah')) {
				$error = array('error' => $this->upload->display_errors());
				$resp['errorFoto'] = $error;
			} else {
				$data['pdd_ijazah'] = $this->upload->data('file_name');
			}
		}

		if ($id == 0) {
			$insert = $this->pendidikan->simpan("ba_karyawan_pendidikan", $data);
		} else {
			$insert = $this->pendidikan->update("ba_karyawan_pendidikan", array('pdd_id' => $id), $data);
		}

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Data Pendidikan berhasil disimpan";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function hapus($id)
	{
		$delete = $this->pendidikan->delete('ba_karyawan_pendidikan', 'pdd_id', $id);
		if ($delete) {
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-check-circle text-success'></i>&nbsp;&nbsp;&nbsp; Data Pendidikan berhasil dihapus";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "<i class='fa fa-exclamation-triangle text-warning'></i>&nbsp;&nbsp;&nbsp; Data gagal dihapus";
		}
		echo json_encode($resp);
	}
}