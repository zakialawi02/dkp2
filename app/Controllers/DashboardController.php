<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    private $user;
    private $izin;

    public function __construct()
    {
        $this->user = new \App\Models\UserModel();
        $this->izin = new \App\Models\IzinModel();
    }

    public function index()
    {
        $userid = user_id();
        if (in_groups('SuperAdmin') || in_groups('Admin')) {
            $data = [
                'title' => 'Dashboard',
                'userid' => $userid,
                'countAllUser' => $this->user->countAllResults(),
                'userMonth' => $this->user->userMonth()->getResult(),
                'allDataPermohonan' => $this->izin->getAllPermohonan()->getResult(),
            ];

            return view('Pages/dashboard/dashboardAdmin', $data);
        } elseif (in_groups('User')) {
            return $this->mySubmission();
        } else {
            throw new PageNotFoundException();
        }
    }

    public function mySubmission()
    {
        $userid = user_id();
        $data = [
            'title' => 'Dashboard',
            'userid' => $userid,
            'userSubmitPermohonan' => $this->izin->userSubmitIzin($userid)->getResult(),
        ];

        return view('Pages/dashboard/dashboardUser', $data);
    }
}
