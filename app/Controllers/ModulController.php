<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ModulController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Modul',
        ];

        return view('Pages/dashboard/modul/index', $data);
    }
}
