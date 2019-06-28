<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Karyawan extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('karyawan_model', 'karyawan');
	}
	public function index_get()
	{
		$id = $this->get('id');
		if ($id === null) {
			$karyawan = $this->karyawan->getkaryawan();
		} else {
			$karyawan = $this->karyawan->getkaryawan($id);
		}

		if ($karyawan) {
			$this->set_response([
				'status' => true,
				'data' => $karyawan
			], REST_Controller::HTTP_OK);
		} else {
			$this->set_response([
				'status' => false,
				'message' => 'ID Tidak Ditemukan'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}
	public function index_delete()
	{
		$id = $this->delete('id');
		if ($id === null) {
			$this->set_response([
				'status' => false,
				'message' => 'Membutuhkan ID untuk Proses Ini'
			], REST_Controller::HTTP_BAD_REQUEST);
		} else {
			if ($this->karyawan->deletekaryawan($id) > 0) {
				// OK
				$message = [
					'status' => true,
					'id' => $id,
					'message' => 'Data Berhasil Dihapus'
				];
				$this->set_response($message, REST_Controller::HTTP_OK);
			} else {
				// id not found
				$this->set_response([
					'status' => false,
					'message' => 'ID Tidak Ditemukan'
				], REST_Controller::HTTP_BAD_REQUEST);
			}
		}
	}

	public function index_post()
	{
		$data = [
			'kode_cabang' => $this->post('kc'),
			'kode_karyawan' => $this->post('id'),
			'nama_depan' => $this->post('nd'),
			'nama_belakang' => $this->post('nb'),
			'jenis_kelamin' => $this->post('jk')
		];

		if ($this->karyawan->tambahkaryawan($data) > 0) {
			$message = [
				'status' => true,
				'message' => 'Data Berhasil Ditambahkan'
			];
			$this->set_response($message, REST_Controller::HTTP_CREATED);
		} else {
			// id not found
			$this->set_response([
				'status' => false,
				'message' => 'Data Gagal di Simpan'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function index_put()
	{
		$id = $this->put('id');
		$data = [
			'kode_cabang' => $this->put('kc'),
			'nama_depan' => $this->put('nd'),
			'nama_belakang' => $this->put('nb'),
			'jenis_kelamin' => $this->put('jk')
		];
		if ($this->karyawan->updatekaryawan($data, $id) > 0) {
			$message = [
				'status' => true,
				'message' => 'Data Berhasil Dirubah'
			];
			$this->set_response($message, REST_Controller::HTTP_OK);
		} else {
			// id not found
			$this->set_response([
				'status' => false,
				'message' => 'Data Gagal dirubah'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}
}
