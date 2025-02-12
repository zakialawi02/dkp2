<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;

class PermohonanController extends BaseController
{
    protected $db;
    protected $setting;
    protected $user;
    protected $kegiatan;
    protected $zona;
    protected $izin;
    protected $uploadFiles;

    public function __construct()
    {
        $this->db = db_connect();
        $this->setting = new \App\Models\SettingModel();
        $this->user = new \App\Models\UserModel();
        $this->kegiatan = new \App\Models\KegiatanModel();
        $this->zona = new \App\Models\ZonaModel();
        $this->izin = new \App\Models\IzinModel();
        $this->uploadFiles = new \App\Models\UploadModel();
    }

    public function permohonanDisetujui()
    {
        $data = [
            'title' => 'Permohonan Disetujui',
            // 'tampilIzin' => $this->izin->getIzin()->getResult(),
        ];

        if ($this->request->isAJAX()) {
            $db = \Config\Database::connect();
            $builder = $db->table('tbl_perizinan')
                ->select([
                    'tbl_perizinan.id_perizinan AS id_perizinan',
                    'tbl_perizinan.nama AS nama',
                    'tbl_perizinan.nik AS nik',
                    'tbl_perizinan.alamat AS alamat',
                    'tbl_perizinan.id_kegiatan AS id_kegiatan',
                    'tbl_perizinan.created_at AS created_at',
                    'tbl_perizinan.updated_at AS updated_at',
                    'tbl_status_appv.id_perizinan AS status_id_perizinan',
                    'tbl_status_appv.stat_appv AS stat_appv',
                    'tbl_status_appv.date_updated AS date_updated',
                    'users.username AS username',
                    'tbl_kegiatan.nama_kegiatan AS nama_kegiatan',
                ])
                ->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan = tbl_perizinan.id_kegiatan', 'LEFT')
                ->join('tbl_status_appv', 'tbl_status_appv.id_perizinan = tbl_perizinan.id_perizinan', 'LEFT')
                ->join('users', 'users.id = tbl_status_appv.user', 'LEFT')
                ->where('tbl_status_appv.stat_appv', "1");

            return DataTable::of($builder)
                ->addNumbering('DT_RowIndex')
                ->edit('nik', function ($row) {
                    return empty($row->nik) ? '-' : $row->nik;
                })
                ->edit('created_at', function ($row) {
                    return date('d M Y', strtotime($row->created_at));
                })
                ->edit('date_updated', function ($row) {
                    return date('d M Y', strtotime($row->date_updated));
                })
                ->add('action', function ($row) {
                    return '
                    <a href="/dashboard/data/permohonan/' . $row->id_perizinan . '/edit" class="btn btn-sm btn-warning" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="edit data" target="_blank"><i class="bi bi-pencil-square"></i></a>
                    <a href="/dashboard/data/permohonan/' . ($row->stat_appv == '1' ? 'telah-disetujui' : 'tidak-disetujui') . '/lihat/' . $row->id_perizinan . '" class="btn btn-sm btn-primary" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="view data" target="_blank"><i class="bi bi-eye"></i></a>
                    <form action="/dashboard/data/permohonan/delete/' . $row->id_perizinan . '" method="post" class="d-inline deleteData" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="delete data">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i></button>
                    </form>
                    ';
                })
                ->setSearchableColumns(['nik', 'nama', 'alamat', 'nama_kegiatan'])
                ->toJson(true);
        }

        return view('Pages/dashboard/permohonan/permohonanDisetujui', $data);
    }

    public function permohonanDisetujuiDgLampiran()
    {
        $data = [
            'title' => 'Permohonan Disetujui Dengan Lampiran',
        ];

        if ($this->request->isAJAX()) {
            $db = \Config\Database::connect();
            $builder = $db->table('tbl_perizinan')
                ->select([
                    'tbl_perizinan.id_perizinan AS id_perizinan',
                    'tbl_perizinan.nama AS nama',
                    'tbl_perizinan.nik AS nik',
                    'tbl_perizinan.alamat AS alamat',
                    'tbl_perizinan.id_kegiatan AS id_kegiatan',
                    'tbl_perizinan.created_at AS created_at',
                    'tbl_perizinan.updated_at AS updated_at',
                    'tbl_status_appv.id_perizinan AS status_id_perizinan',
                    'tbl_status_appv.stat_appv AS stat_appv',
                    'tbl_status_appv.date_updated AS date_updated',
                    'tbl_status_appv.dokumen_lampiran AS dokumen_lampiran',
                    'users.username AS username',
                    'tbl_kegiatan.nama_kegiatan AS nama_kegiatan',
                ])
                ->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan = tbl_perizinan.id_kegiatan', 'LEFT')
                ->join('tbl_status_appv', 'tbl_status_appv.id_perizinan = tbl_perizinan.id_perizinan', 'LEFT')
                ->join('users', 'users.id = tbl_status_appv.user', 'LEFT')
                ->where('tbl_status_appv.stat_appv', "1")
                ->where('tbl_status_appv.dokumen_lampiran IS NOT NULL');

            return DataTable::of($builder)
                ->addNumbering('DT_RowIndex')
                ->edit('nik', function ($row) {
                    return empty($row->nik) ? '-' : $row->nik;
                })
                ->edit('created_at', function ($row) {
                    return date('d M Y', strtotime($row->created_at));
                })
                ->edit('date_updated', function ($row) {
                    return date('d M Y', strtotime($row->date_updated));
                })
                ->add('action', function ($row) {
                    return '
                    <a href="/dashboard/data/permohonan/' . $row->id_perizinan . '/edit" class="btn btn-sm btn-warning" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="edit data" target="_blank"><i class="bi bi-pencil-square"></i></a>
                    <a href="/dashboard/data/permohonan/' . ($row->stat_appv == '1' ? 'telah-disetujui' : 'tidak-disetujui') . '/lihat/' . $row->id_perizinan . '" class="btn btn-sm btn-primary" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="view data" target="_blank"><i class="bi bi-eye"></i></a>
                    <form action="/dashboard/data/permohonan/delete/' . $row->id_perizinan . '" method="post" class="d-inline deleteData" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="delete data">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i></button>
                    </form>
                    ';
                })
                ->setSearchableColumns(['nik', 'nama', 'alamat', 'nama_kegiatan'])
                ->toJson(true);
        }

        return view('Pages/dashboard/permohonan/permohonanDisetujuiDgLampiran', $data);
    }

    public function permohonanDisetujuiTnpLampiran()
    {
        $data = [
            'title' => 'Permohonan Disetujui Dengan Lampiran',
        ];

        if ($this->request->isAJAX()) {
            $db = \Config\Database::connect();
            $builder = $db->table('tbl_perizinan')
                ->select([
                    'tbl_perizinan.id_perizinan AS id_perizinan',
                    'tbl_perizinan.nama AS nama',
                    'tbl_perizinan.nik AS nik',
                    'tbl_perizinan.alamat AS alamat',
                    'tbl_perizinan.id_kegiatan AS id_kegiatan',
                    'tbl_perizinan.created_at AS created_at',
                    'tbl_perizinan.updated_at AS updated_at',
                    'tbl_status_appv.id_perizinan AS status_id_perizinan',
                    'tbl_status_appv.stat_appv AS stat_appv',
                    'tbl_status_appv.date_updated AS date_updated',
                    'tbl_status_appv.dokumen_lampiran AS dokumen_lampiran',
                    'users.username AS username',
                    'tbl_kegiatan.nama_kegiatan AS nama_kegiatan',
                ])
                ->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan = tbl_perizinan.id_kegiatan', 'LEFT')
                ->join('tbl_status_appv', 'tbl_status_appv.id_perizinan = tbl_perizinan.id_perizinan', 'LEFT')
                ->join('users', 'users.id = tbl_status_appv.user', 'LEFT')
                ->where('tbl_status_appv.stat_appv', "1")
                ->where('tbl_status_appv.dokumen_lampiran IS NULL');

            return DataTable::of($builder)
                ->addNumbering('DT_RowIndex')
                ->edit('nik', function ($row) {
                    return empty($row->nik) ? '-' : $row->nik;
                })
                ->edit('created_at', function ($row) {
                    return date('d M Y', strtotime($row->created_at));
                })
                ->edit('date_updated', function ($row) {
                    return date('d M Y', strtotime($row->date_updated));
                })
                ->add('action', function ($row) {
                    return '
                    <a href="/dashboard/data/permohonan/' . $row->id_perizinan . '/edit" class="btn btn-sm btn-warning" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="edit data" target="_blank"><i class="bi bi-pencil-square"></i></a>
                    <a href="/dashboard/data/permohonan/' . ($row->stat_appv == '1' ? 'telah-disetujui' : 'tidak-disetujui') . '/lihat/' . $row->id_perizinan . '" class="btn btn-sm btn-primary" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="view data" target="_blank"><i class="bi bi-eye"></i></a>
                    <form action="/dashboard/data/permohonan/delete/' . $row->id_perizinan . '" method="post" class="d-inline deleteData" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="delete data">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i></button>
                    </form>
                    ';
                })
                ->setSearchableColumns(['nik', 'nama', 'alamat', 'nama_kegiatan'])
                ->toJson(true);
        }

        return view('Pages/dashboard/permohonan/permohonanDisetujuiTnpLampiran', $data);
    }

    public function permohonanTidakDisetujui()
    {
        $data = [
            'title' => 'Permohonan Tidak Disetujui',
        ];

        if ($this->request->isAJAX()) {
            $db = \Config\Database::connect();
            $builder = $db->table('tbl_perizinan')
                ->select([
                    'tbl_perizinan.id_perizinan AS id_perizinan',
                    'tbl_perizinan.nama AS nama',
                    'tbl_perizinan.nik AS nik',
                    'tbl_perizinan.alamat AS alamat',
                    'tbl_perizinan.id_kegiatan AS id_kegiatan',
                    'tbl_perizinan.created_at AS created_at',
                    'tbl_perizinan.updated_at AS updated_at',
                    'tbl_status_appv.id_perizinan AS status_id_perizinan',
                    'tbl_status_appv.stat_appv AS stat_appv',
                    'users.username AS username',
                    'tbl_kegiatan.nama_kegiatan AS nama_kegiatan',
                ])
                ->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan = tbl_perizinan.id_kegiatan', 'LEFT')
                ->join('tbl_status_appv', 'tbl_status_appv.id_perizinan = tbl_perizinan.id_perizinan', 'LEFT')
                ->join('users', 'users.id = tbl_status_appv.user', 'LEFT')
                ->where('tbl_status_appv.stat_appv', "2");

            return DataTable::of($builder)
                ->addNumbering('DT_RowIndex')
                ->edit('nik', function ($row) {
                    return empty($row->nik) ? '-' : $row->nik;
                })
                ->edit('created_at', function ($row) {
                    return date('d M Y', strtotime($row->created_at));
                })
                ->add('action', function ($row) {
                    return '
                    <a href="/dashboard/permohonan/edit/' . $row->id_perizinan . '" class="btn btn-sm btn-warning" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="edit data" target="_blank"><i class="bi bi-pencil-square"></i></a>
                    <a href="/dashboard/permohonan/view/' . $row->id_perizinan . '" class="btn btn-sm btn-primary" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="view data" target="_blank"><i class="bi bi-eye"></i></a>
                    <form action="/dashboard/data/permohonan/delete/' . $row->id_perizinan . '" method="post" class="d-inline deleteData" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="delete data">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i></button>
                    </form>
                    ';
                })
                ->setSearchableColumns(['nik', 'nama', 'alamat', 'nama_kegiatan'])
                ->toJson(true);
        }

        return view('Pages/dashboard/permohonan/permohonanTidakDisetujui', $data);
    }

    public function permohonanMasuk()
    {
        $data = [
            'title' => 'Pending List',
        ];

        if ($this->request->isAJAX()) {
            $db = \Config\Database::connect();
            $builder = $db->table('tbl_perizinan')
                ->select([
                    'tbl_perizinan.id_perizinan AS id_perizinan',
                    'tbl_perizinan.nama AS nama',
                    'tbl_perizinan.nik AS nik',
                    'tbl_perizinan.alamat AS alamat',
                    'tbl_perizinan.id_kegiatan AS id_kegiatan',
                    'tbl_perizinan.created_at AS created_at',
                    'tbl_perizinan.updated_at AS updated_at',
                    'tbl_status_appv.id_perizinan AS status_id_perizinan',
                    'tbl_status_appv.stat_appv AS stat_appv',
                    'users.username AS username',
                    'tbl_kegiatan.nama_kegiatan AS nama_kegiatan',
                ])
                ->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan = tbl_perizinan.id_kegiatan', 'LEFT')
                ->join('tbl_status_appv', 'tbl_status_appv.id_perizinan = tbl_perizinan.id_perizinan', 'LEFT')
                ->join('users', 'users.id = tbl_status_appv.user', 'LEFT')
                ->where('tbl_status_appv.stat_appv', "0");

            return DataTable::of($builder)
                ->addNumbering('DT_RowIndex')
                ->edit('nik', function ($row) {
                    return empty($row->nik) ? '-' : $row->nik;
                })
                ->edit('created_at', function ($row) {
                    return date('d M Y', strtotime($row->created_at));
                })
                ->add('action', function ($row) {
                    return '
                    <a href="/dashboard/data/permohonan/' . ($row->stat_appv == '1' ? 'telah-disetujui' : 'tidak-disetujui') . '/lihat/' . $row->id_perizinan . '" class="btn btn-sm btn-info" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="view data" target="_blank"><i class="bi bi-binoculars"></i> Periksa</a>
                    ';
                })
                ->setSearchableColumns(['nik', 'nama', 'alamat', 'nama_kegiatan'])
                ->toJson(true);
        }

        return view('Pages/dashboard/permohonan/permohonanMasuk', $data);
    }

    public function show($status, $id_perizinan)
    {
        $permintaanId = $this->izin->getAllPermohonan($id_perizinan)->getRow();
        $statusArray = ['menunggu-jawaban', 'telah-disetujui', 'tidak-disetujui'];
        $user = user_id();
        if (!in_array($status, $statusArray)) {
            session()->setFlashdata('error', 'Permintaan tidak ditemukan');
            return redirect()->to('/dashboard');
        }

        if (empty($permintaanId)) {
            session()->setFlashdata('error', 'Permintaan tidak ditemukan');
            return redirect()->to('/dashboard');
        }

        if ($permintaanId->user != $user && !in_groups('Admin') && !in_groups('SuperAdmin')) {
            session()->setFlashdata('error', 'Permintaan tidak ditemukan');
            return redirect()->to('/dashboard');
        }

        $uploadFiles = $this->uploadFiles->getFiles($id_perizinan)->getResult();
        $data = [
            'title' => 'Detail Data Pengajuan Informasi',
            'tampilData' => $this->setting->Where(['id' => 1])->get()->getRow(),
            'tampilZona' => $this->zona->getZona()->getResult(),
            'tampilDataIzin' => (object) ((array) $permintaanId + ['uploadFiles' => $uploadFiles]),
        ];

        // dd($data);

        return view('Pages/dashboard/permohonan/showDetailPermohonan', $data);
    }

    public function edit($id_perizinan)
    {
        $user = user_id();
        $dataId = $this->izin->getAllPermohonan($id_perizinan)->getRow();
        if ($dataId->user != $user && !in_groups('Admin') && !in_groups('SuperAdmin')) {
            session()->setFlashdata('error', 'Permintaan tidak ditemukan');
            return redirect()->to('/admin');
        }
        if (empty($dataId)) {
            session()->setFlashdata('error', 'Permintaan tidak ditemukan');
            return redirect()->to('/admin');
        }
        $data = [
            'title' => 'Data Pengajuan',
            'tampilData' => $this->setting->Where(['id' => 1])->get()->getRow(),
            'tampilIzin' => (object) ((array)$this->izin->getAllPermohonan($id_perizinan)->getRow()  + ['uploadFiles' => $this->uploadFiles->getFiles($id_perizinan)->getResult(), 'files' => $this->loadDoc($id_perizinan)]),
            'tampilZona' => $this->zona->getZona()->getResult(),
            'jenisKegiatan' => $this->kegiatan->getJenisKegiatan()->getResult(),
        ];
        // dd($data);
        return view('Pages/dashboard/permohonan/editPermohonan', $data);
    }

    public function kirimTindakan($id_perizinan)
    {
        // dd($this->request->getPost());
        $infoData = $this->izin->getAllPermohonan($id_perizinan)->getRow();
        $stat_appv = $this->request->getPost('flexRadioDefault');
        if ($stat_appv == 2) {
            $data = [
                'stat_appv' => '2',
                'date_updated' => date('Y-m-d H:i:s'),
            ];
            $this->db->table('tbl_status_appv')->update($data, ['id_perizinan' => $id_perizinan]);
            try {
                $settingNotif = $this->setting->tampilData()->getRow();
                if ($settingNotif->notif_email === "on") {
                    $userID = $infoData->user;
                    $user = $this->user->getUsers($userID)->getRow();
                    $emailTo = $user->email;
                    $username = $user->username;
                    $email = \Config\Services::email();
                    $email->setTo($emailTo);
                    $email->setSubject('Pemberitahuan Status Pengajuan Informasi Simata Laut Kaltim');
                    $message = view('_Layout/_template/_email/statusAjuan');
                    $message = str_replace('{username}', $username, $message);
                    $message = str_replace('{nama_kegiatan}', $infoData->nama_kegiatan, $message);
                    $message = str_replace('{url}', base_url('/data/permohonan/lihat/' . $infoData->id_perizinan), $message);
                    $email->setMessage($message);
                    $email->setMailType('html');
                    $email->send();
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
            if ($this) {
                session()->setFlashdata('success', 'Berhasil Menyimpan Tindakan.');
                return $this->response->redirect(route_to('admin.permohonan.masuk'));
            } else {
                session()->setFlashdata('error', 'Gagal Menyimpan Tindakan.');
                return $this->response->redirect(route_to('admin.permohonan.masuk'));
            }
        } elseif ($stat_appv == 1) {
            $nik = $infoData->nik;
            // ambil file
            $fileLampiran = $this->request->getFile('lampiranFile');
            if ($fileLampiran->isValid() && !$fileLampiran->hasMoved()) {
                //generate random file name
                $extension = $fileLampiran->getExtension();
                $newName = date('YmdHis') . '_' . $nik . '.' . $extension;
                // pindah file to hosting
                $fileLampiran->move('dokumen/lampiran-balasan/', $newName);
                $data = [
                    'stat_appv' => '1',
                    'dokumen_lampiran' => $newName,
                    'date_updated' => date('Y-m-d H:i:s'),
                ];
                $this->db->table('tbl_status_appv')->update($data, ['id_perizinan' => $id_perizinan]);
                if ($this) {
                    session()->setFlashdata('success', 'Berhasil Menyimpan Tindakan.');
                    return $this->response->redirect(route_to('admin.permohonan.masuk'));
                } else {
                    session()->setFlashdata('error', 'Gagal Menyimpan Tindakan.');
                    return $this->response->redirect(route_to('admin.permohonan.masuk'));
                }
            } else {
                $data = [
                    'stat_appv' => '1',
                    'date_updated' => date('Y-m-d H:i:s'),
                ];
                $this->db->table('tbl_status_appv')->update($data, ['id_perizinan' => $id_perizinan]);
                try {
                    $settingNotif = $this->setting->tampilData()->getRow();
                    if ($settingNotif->notif_email === "on") {
                        $userID = $infoData->user;
                        $user = $this->user->getUsers($userID)->getRow();
                        $emailTo = $user->email;
                        $username = $user->username;
                        $email = \Config\Services::email();
                        $email->setTo($emailTo);
                        $email->setSubject('Pemberitahuan Status Pengajuan Informasi Simata Laut Kaltim');
                        $message = view('_Layout/_template/_email/statusAjuan');
                        $message = str_replace('{username}', $username, $message);
                        $message = str_replace('{nama_kegiatan}', $infoData->nama_kegiatan, $message);
                        $message = str_replace('{url}', base_url('/data/permohonan/lihat/' . $infoData->id_perizinan), $message);
                        $email->setMessage($message);
                        $email->setMailType('html');
                        $email->send();
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                }
                if ($this) {
                    session()->setFlashdata('success', 'Berhasil Menyimpan Tindakan.');
                    return $this->response->redirect(route_to('admin.permohonan.masuk'));
                } else {
                    session()->setFlashdata('error', 'Gagal Menyimpan Tindakan.');
                    return $this->response->redirect(route_to('admin.permohonan.masuk'));
                }
            }
        } else if (empty($stat_appv)) {
            $infoData = $this->izin->getAllPermohonan($id_perizinan)->getRow();
            $nik = $infoData->nik;
            // ambil file
            $fileLampiran = $this->request->getFile('lampiranFile');
            if ($fileLampiran->isValid() && !$fileLampiran->hasMoved()) {
                //generate random file name
                $extension = $fileLampiran->getExtension();
                $newName = date('YmdHis') . '_' . $nik . '.' . $extension;
                // pindah file to hosting
                $fileLampiran->move('dokumen/lampiran-balasan/', $newName);

                $data = [
                    'stat_appv' => '1',
                    'dokumen_lampiran' => $newName,
                    'date_updated' => date('Y-m-d H:i:s'),
                ];
                $this->db->table('tbl_status_appv')->update($data, ['id_perizinan' => $id_perizinan]);
                if ($this) {
                    session()->setFlashdata('success', 'Berhasil Mengupload Dokumen.');
                    return $this->response->redirect(route_to('admin.permohonan.disetujui'));
                } else {
                    session()->setFlashdata('error', 'Gagal Mengupload Dokumen.');
                    return $this->response->redirect(route_to('admin.permohonan.disetujui'));
                }
            } else {
                $data = [
                    'stat_appv' => '1',
                    'date_updated' => date('Y-m-d H:i:s'),
                ];
                $this->db->table('tbl_status_appv')->update($data, ['id_perizinan' => $id_perizinan]);
                if ($this) {
                    session()->setFlashdata('success', 'Berhasil Menyimpan Tindakan.');
                    return $this->response->redirect(route_to('admin.permohonan.masuk'));
                } else {
                    session()->setFlashdata('error', 'Gagal Menyimpan Tindakan.');
                    return $this->response->redirect(route_to('admin.permohonan.masuk'));
                }
            }
        } else {
            session()->setFlashdata('error', 'Gagal Menyimpan Tindakan.');
            return $this->response->redirect(route_to('admin.permohonan.masuk'));
        }
    }

    public function destroy($id_perizinan)
    {
        $data = (object) ((array)$this->izin->getAllPermohonan($id_perizinan)->getRow()  + ['uploadFiles' => $this->uploadFiles->getFiles($id_perizinan)->getResult()]);
        if (!empty($data->uploadFiles)) {
            foreach ($data->uploadFiles as $file) {
                $file = 'dokumen/upload-dokumen/' . $file->uploadFiles;
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }
        if (!empty($data->dokumen_lampiran)) {
            $file = 'dokumen/lampiran-balasan/' . $data->dokumen_lampiran;
            if (file_exists($file)) {
                unlink($file);
            }
        }
        // die;
        $this->izin->delete(['id_perizinan' => $id_perizinan]);
        if ($this) {
            session()->setFlashdata('success', 'Data berhasil dihapus.');
            if (in_groups('User')) {
                return $this->response->redirect(site_url('/dashboard'));
            } else {
                return response()->setStatusCode(ResponseInterface::HTTP_OK)
                    ->setJSON([
                        'success' => true,
                        'message' => 'Data berhasil dihapus',
                        'token' => csrf_hash()
                    ]);
            }
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data.');
            if (in_groups('User')) {
                return $this->response->redirect(site_url('/dashboard'));
            } else {
                return response()->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                    ->setJSON([
                        'success' => false,
                        'message' => 'Gagal menghapus data',
                        'errors' => $this->izin->errors(),
                        'token' => csrf_hash()
                    ]);
            }
        }
    }

    private function loadDoc($id_perizinan)
    {
        $fileInfo = $this->uploadFiles->getFiles($id_perizinan)->getResult();
        $fileNames = [];
        foreach ($fileInfo as $info) {
            $fileNames[] = $info->uploadFiles;
        }
        $files = [];
        foreach ($fileNames as $fileName) {
            $filePath = 'dokumen/upload-dokumen/' . $fileName;
            $files[] = [
                'source' => $fileName,
                'options' => [
                    'type' => 'local',
                ],
            ];
        }
        // $result = $this->response->setJSON(['files' => $files]);
        return $files;
    }
}
