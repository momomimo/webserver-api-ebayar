<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Anggota extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('anggota_model', 'anggota');
    }
    public function index_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $anggota = $this->anggota->getanggota();
        } else {
            $anggota = $this->anggota->getanggota($id);
        }

        if ($anggota) {
            $this->set_response([
                'status' => true,
                'data' => $anggota
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
        $id = $this->delete('ida');
        if ($id === null) {
            $this->set_response([
                'status' => false,
                'message' => 'Membutuhkan ID untuk Proses Ini'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->anggota->deleteanggota($id) > 0) {
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
            'id_anggota' => $this->post('ida'),
            'id_identitas' => $this->post('idi'),
            'nama_anggota' => $this->post('na'),
            'tgl_masuk' => $this->post('tm'),
            'tgl_lahir' => $this->post('tl'),
            'alamat' => $this->post('alt'),
            'no_telp' => $this->post('nt'),
            'jabatan' => $this->post('jn'),
            'status_pegawai' => $this->post('sp'),
            'estimasi_byr' => $this->post('eb'),
            'status_anggota' => $this->post('sa')
        ];

        if ($this->anggota->tambahanggota($data) > 0) {
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
        $id = $this->put('ida');
        $data = [
            'id_identitas' => $this->put('idi'),
            'nama_anggota' => $this->put('na'),
            'tgl_masuk' => $this->put('tm'),
            'tgl_lahir' => $this->put('tl'),
            'alamat' => $this->put('alt'),
            'no_telp' => $this->put('nt'),
            'jabatan' => $this->put('jn'),
            'status_pegawai' => $this->put('sp'),
            'estimasi_byr' => $this->put('eb'),
            'status_anggota' => $this->put('sa')
        ];
        if ($this->anggota->updateanggota($data, $id) > 0) {
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
