<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PermohonanController extends BaseController
{
    public function permohonanDisetujui()
    {
        $data = [
            'title' => 'Permohonan Disetujui',
        ];

        return view('Pages/dashboard/permohonan/permohonanDisetujui', $data);
    }

    public function permohonanTidakDisetujui()
    {
        $data = [
            'title' => 'Permohonan Tidak Disetujui',
        ];

        return view('Pages/dashboard/permohonan/permohonanTidakDisetujui', $data);
    }

    public function permohonanMasuk()
    {
        $data = [
            'title' => 'Permohonan Masuk',
        ];

        return view('Pages/dashboard/permohonan/permohonanMasuk', $data);
    }
}
