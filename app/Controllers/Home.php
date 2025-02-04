<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Home | SIMATALAUT KALTIM | Sistem Informasi Tata Ruang Laut Kaltim',
        ];

        return view('Pages/front/home', $data);
    }
}
