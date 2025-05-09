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
        $data = (object) ((array)$this->izin->getAllPermohonan($id_perizinan)->getRow()
            + ['uploadFiles' => $this->uploadFiles->getFiles($id_perizinan)->getResult()]);

        // Hapus upload files
        if (!empty($data->uploadFiles)) {
            foreach ($data->uploadFiles as $file) {
                $filePath = 'dokumen/upload-dokumen/' . $file->uploadFiles;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        // Hapus lampiran balasan
        if (!empty($data->dokumen_lampiran)) {
            $filePath = 'dokumen/lampiran-balasan/' . $data->dokumen_lampiran;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Hapus data dari database
        $delete = $this->izin->delete(['id_perizinan' => $id_perizinan]);

        // Respon AJAX
        if ($this->request->isAJAX()) {
            if ($delete) {
                return $this->response->setStatusCode(ResponseInterface::HTTP_OK)
                    ->setJSON([
                        'success' => true,
                        'message' => 'Data berhasil dihapus',
                        'token'   => csrf_hash()
                    ]);
            } else {
                return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                    ->setJSON([
                        'success' => false,
                        'message' => 'Gagal menghapus data',
                        'errors'  => $this->izin->errors(),
                        'token'   => csrf_hash()
                    ]);
            }
        }

        // Respon NON-AJAX (biasa)
        if ($delete) {
            session()->setFlashdata('success', 'Data berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data.');
        }

        return redirect()->back();
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


    public function pengajuanPermohonan()
    {
        // Ambil id dari query string
        $id = $this->request->getGet('id');

        // Default data view
        $data = [
            'title' => 'Pengajuan Permohonan',
            'tampilData' => $this->setting->Where(['id' => 1])->get()->getRow(),
            'jenisKegiatan' => $this->kegiatan->getJenisKegiatan()->getResult(),
        ];

        // Kalau ada id di query string, coba ambil data dari cache
        if ($id) {
            $cachedData = cache()->get('ajuan_' . $id);
            if ($cachedData) {
                // Merge cached data ke $data view
                $data = array_merge($data, [
                    'ajuanData' => $cachedData,
                    'cacheId'   => $id, // opsional, kalau mau dipake di view
                ]);
                // dd($data);
            } else {
                // Kalau data cache gak ketemu, bisa kasih flash message atau lewatin aja
                session()->setFlashdata('error', 'Data permohonan tidak ditemukan atau sudah kadaluarsa.');
                // Redirect ke halaman awal atau halaman lain
                return redirect()->to('/peta');
            }
        } else {
            // Redirect ke halaman awal atau halaman lain
            return redirect()->to('/peta');
        }

        // Tampilkan view
        return view('Pages/front/ajuanPermohonan', $data);
    }


    public function isiAjuan()
    {
        $timestamp = time();
        $data = [
            'title' => 'Data Permohonan',
            'kegiatanValue' => $this->request->getVar('kegiatan'),
            'geojson' => $this->request->getPost('geojson'),
            'getOverlap' => $this->request->getPost('getOverlap'),
            'getOverlapProperties' => $this->request->getPost('getOverlapProperties'),
            'valZona' => $this->request->getPost('idZona'),
            'hasilStatus' => $this->request->getPost('hasilStatus'),
        ];

        // Simpan ke cache
        cache()->save('ajuan_' . $timestamp, $data, 3600);

        // Redirect dengan query string id
        return redirect()->to('/data/pengajuan?id=' . $timestamp);
    }

    // TAMBAH DATA PERMOHONAN
    public function tambahAjuan()
    {
        // dd($this->request->getPost());
        $user = user_id();
        $data = [
            'nik' => $this->request->getVar('nik'),
            'nib' => $this->request->getVar('nib'),
            'nama' => $this->request->getVar('nama'),
            'alamat' => $this->request->getVar('alamat'),
            'kontak' => $this->request->getVar('kontak'),
            'id_kegiatan' => $this->request->getVar('idKegiatan'),
            'kode_kawasan' => $this->request->getVar('kawasan'),
            'id_zona' => $this->request->getVar('idZona'),
            'lokasi' => $this->request->getVar('drawFeatures'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if (!$this->validate($this->izin->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        // dd($data);

        $addPengajuan =  $this->izin->save($data);
        $insert_id = $this->db->insertID();

        $files = $this->request->getFiles();
        if (!empty($files['filepond']) && count(array_filter($files['filepond'], function ($file) {
            return $file->isValid() && !$file->hasMoved();
        }))) {
            foreach ($files['filepond'] as $key => $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $originalName = $file->getClientName();
                    $pathInfo = pathinfo($originalName);
                    $fileName = $pathInfo['filename'];
                    $fileExt = $file->guessExtension();
                    $uploadFiles = $fileName . "_" . date('YmdHis') . "." . $fileExt;
                    $dataF = [
                        'id_perizinan' => $insert_id,
                        'file' => $uploadFiles,
                    ];
                    $this->uploadFiles->save($dataF);
                    $file->move('dokumen/upload-dokumen/', $uploadFiles);
                }
            }
        }

        if ($addPengajuan) {
            session()->setFlashdata('success', 'Data Berhasil ditambahkan.');
            return $this->response->redirect(site_url('/dashboard'));
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan data.');
            return $this->response->redirect(site_url('/peta'));
        }
    }
}
