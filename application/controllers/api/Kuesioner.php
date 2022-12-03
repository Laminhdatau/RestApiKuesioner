<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class Kuesioner extends RestController
{
    public function index_get()
    {
        $kd_quisioner = $this->get('kd_quisioner');
        if ($kd_quisioner == null) {
            $quis = $this->m_kuesioner->getKuesioner();
        } else {
            $quis = $this->m_kuesioner->getKuesioner($kd_quisioner);
        }

        if ($quis) {
            $this->response([
                'status' => true,
                'data' => $quis
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'ID Tidak di temukan'
            ], RestController::HTTP_NOT_FOUND);
        }
    }

    public function index_post()
    {
        $data = [
            'quisioner' => $this->post('quisioner'),
            'id_jenis_quisioner' => $this->post('id_jenis_quisioner'),
            'status' => '1'

        ];
        $this->db->set('kd_quisioner', 'UUID()', false);


        if ($this->m_kuesioner->createKuesioner($data) > 0) {
            $this->response(
                [
                    'status' => true,
                    'message' => 'Data berhasil ditambahkan',
                    'data' => $data
                ],
                RestController::HTTP_CREATED
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'message' => 'Data gagal ditambahkan'
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    public function index_put()
    {
        $kd_quis = $this->put('kd_quisioner');
        $data = [
            'quisioner' => $this->put('quisioner'),
            'id_jenis_quisioner' => $this->put('id_jenis_quisioner'),
            'status' => '1'
        ];
        if ($this->m_kuesioner->updateKuesioner($data, $kd_quis) > 0) {
            $this->response(
                [
                    'status' => true,
                    'message' => 'Data Berhasil Di Update',
                    'data'=>$data
                ],
                RestController::HTTP_CREATED
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'message' => 'Data gagal diupdate'
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    public function index_delete()
    {
        $kd_quis = $this->delete('kd_quisioner');
        if ($kd_quis == null) {
            $this->response(
                [
                    'status' => false,
                    'message' => 'Provide id!'
                ],
                RestController::HTTP_BAD_REQUEST
            );
        } else {
            if ($this->m_kuesioner->deleteKuesioner($kd_quis) > 0) {
                // ok
                $this->response(
                    [
                        'status' => true,
                        'kode' => $kd_quis,
                        'message' => 'Terhapus'
                    ],
                    RestController::HTTP_OK
                );
            } else {
                // id not found
                $this->response(
                    [
                        'status' => false,
                        'message' => 'kode tidak di temukan'
                    ],
                    RestController::HTTP_BAD_REQUEST
                );
            }
        }
    }
}
