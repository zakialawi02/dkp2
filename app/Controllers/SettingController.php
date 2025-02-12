<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SettingController extends BaseController
{
    protected $db;
    protected $setting;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->setting = new \App\Models\SettingModel();
    }

    public function viewPeta()
    {
        $data = [
            'title' => 'Setting View Peta',
            'tampilData' => $this->db->table('tbl_setting')->Where(['id' => 1])->get()->getFirstRow(),
        ];

        return view('Pages/dashboard/setting/viewPeta', $data);
    }

    public function updateSettingMap()
    {
        $data = [
            'id' => 1,
            'coordinat_wilayah' => $this->request->getPost('coordinat_wilayah'),
            'zoom_view' => $this->request->getPost('zoom_view'),
        ];
        $this->setting->save($data);
        if ($this) {
            session()->setFlashdata('success', 'Data Berhasil disimpan.');
            return $this->response->redirect(route_to('admin.setting.viewPeta'));
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui data.');
            return $this->response->redirect(route_to('admin.setting.viewPeta'));
        }
    }
}
