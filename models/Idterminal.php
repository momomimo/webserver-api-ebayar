<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Idterminal extends REST_Controller
{
	public function __construct()
	{
		header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization, Body");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
		parent::__construct();
		$this->load->model('idterminal_model', 'idterminal');
	}
	public function index_get()
	{
		$id = $this->get('id');
		if ($id === null) {
			$idterminal = $this->idterminal->getidterminal();
		} else {
			$idterminal = $this->idterminal->getidterminal($id);
		}

		if ($idterminal) {
			$this->set_response([
				'status' => true,
				'data' => $idterminal
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
		header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE, HEAD");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
		$id = $this->delete('id');
		if ($id === null) {
			$this->set_response([
				'status' => false,
				'message' => 'Membutuhkan ID untuk Proses Ini'
			], REST_Controller::HTTP_BAD_REQUEST);
		} else {
			if ($this->idterminal->deleteidterminal($id) > 0) {
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
			'id' => $this->post('id'),
			'jenis' => $this->post('jenis'),
			'nama_pp' => $this->post('nama'),
			'alamat_pp' => $this->post('alamat'),
			'switching' => $this->post('bank')
		];

		if ($this->idterminal->tambahidterminal($data) > 0) {
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
			'jenis' => $this->put('jenis'),
			'nama_pp' => $this->put('nama'),
			'alamat_pp' => $this->put('alamat'),
			'switching' => $this->put('bank')
		];
		if ($this->idterminal->updateidterminal($data, $id) > 0) {
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
