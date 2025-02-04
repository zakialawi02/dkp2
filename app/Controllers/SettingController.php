<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SettingController extends BaseController
{
    public function viewPeta()
    {
        $data = [
            'title' => 'Setting View Peta',
        ];

        return view('Pages/dashboard/setting/viewPeta', $data);
    }
}
