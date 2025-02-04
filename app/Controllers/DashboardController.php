<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{

    public function index()
    {
        $data = [
            'title' => 'Dashboard || Starter Pack CI4',
        ];
        // dd($data);

        return view('Pages/dashboard/index', $data);
    }
}
