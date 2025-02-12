<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Beranda',
        ];

        return view('Pages/front/home', $data);
    }
}
