<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KegiatanModel;
use App\Models\ZonaKawasanModel;
use App\Models\ZonaModel;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;

class KesesuaianController extends BaseController
{
    protected $kegiatan;
    protected $zona;
    protected $zonaKawasan;

    public function __construct()
    {
        $this->kegiatan = new KegiatanModel();
        $this->zona = new ZonaModel();
        $this->zonaKawasan = new ZonaKawasanModel();
    }

    public function petaKesesuaian()
    {
        $data = [
            'title' => 'Peta Kesesuaian',
        ];

        return view('Pages/front/petaKesesuaian', $data);
    }

    public function kegiatan()
    {
        $data = [
            'title' => 'Data Kegiatan',
        ];

        if ($this->request->isAJAX()) {
            $builder = $this->kegiatan->select('kode_kegiatan, nama_kegiatan');

            return DataTable::of($builder)->addNumbering('DT_RowIndex')
                ->setSearchableColumns(['kode_kegiatan', 'nama_kegiatan'])
                ->toJson(true);
        }

        return view('Pages/dashboard/kesesuaian/kegiatan', $data);
    }

    public function tambahKegiatan()
    {
        try {
            $newToken = csrf_hash();
            $data = $this->request->getPost();

            $insert = $this->kegiatan->insert($data);
            if ($insert) {
                return response()->setStatusCode(ResponseInterface::HTTP_OK)
                    ->setJSON([
                        'success' => true,
                        'message' => 'Data Kegiatan berhasil ditambahkan',
                        'token' => $newToken
                    ]);
            } else {
                return response()->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                    ->setJSON([
                        'success' => false,
                        'message' => 'Data Kegiatan gagal ditambahkan',
                        'errors' => $this->kegiatan->errors(),
                        'token' => $newToken
                    ]);
            }
        } catch (\Throwable $th) {
            return response()->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'success' => false,
                    'message' => 'Data Kegiatan gagal ditambahkan',
                    'errors' => $this->kegiatan->errors(),
                    'token' => $newToken
                ]);
        }
    }

    public function zona()
    {
        $data = [
            'title' => 'Data Zona',
        ];

        if ($this->request->isAJAX()) {
            $builder = $this->zona->select('nama_zona');

            return DataTable::of($builder)->addNumbering('DT_RowIndex')
                ->setSearchableColumns(['nama_zona'])
                ->toJson(true);
        }

        return view('Pages/dashboard/kesesuaian/zona', $data);
    }

    public function kawasan()
    {
        $data = [
            'title' => 'Data Kawasan',
            'dataZona' => $this->zona->getZona()->getResultArray(),
        ];

        if ($this->request->isAJAX()) {
            $id_zona = $this->request->getPost('id_zona');
            $builder = $this->zonaKawasan->getZKawasan($id_zona);

            return DataTable::of($builder)->addNumbering('DT_RowIndex')
                ->setSearchableColumns(['kode_kawasan', 'nama_zona'])
                ->add('aksi', function ($row) {
                    return '
                    <button type="submit" class="btn btn-primary btn-sm editData" data-id="' . $row->id_znkwsn . '"><i class="bi bi-pencil-square"></i></button>
                    <button type="submit" class="btn btn-danger btn-sm deleteData" data-id="' . $row->id_znkwsn . '"><i class="bi bi-trash3"></i></button>';
                })
                ->toJson(true);
        }

        return view('Pages/dashboard/kesesuaian/kawasan', $data);
    }

    public function showDataKawasan($id)
    {
        try {
            $newToken = csrf_hash();
            $data = $this->zonaKawasan->getZKawasan('', $id)->get()->getFirstRow();

            return response()->setStatusCode(ResponseInterface::HTTP_OK)
                ->setJSON([
                    'success' => true,
                    'data' => $data,
                    'token' => $newToken
                ]);
        } catch (\Throwable $th) {
            return response()->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'success' => false,
                    'message' => 'Data kawasan gagal ditambahkan',
                    'errors' => $this->zonaKawasan->errors(),
                    'token' => $newToken
                ]);
        }
    }

    public function tambahZonaKawasan()
    {
        try {
            $newToken = csrf_hash();
            $data = [
                'id_zona' => $this->request->getPost('zona'),
                'kode_kawasan' => $this->request->getPost('kode_kawasan'),
            ];

            $insert = $this->zonaKawasan->insert($data);
            if ($insert) {
                return response()->setStatusCode(ResponseInterface::HTTP_OK)
                    ->setJSON([
                        'success' => true,
                        'message' => 'Data kawasan berhasil ditambahkan',
                        'token' => $newToken
                    ]);
            } else {
                return response()->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                    ->setJSON([
                        'success' => false,
                        'message' => 'Data kawasan gagal ditambahkan',
                        'errors' => $this->zonaKawasan->errors(),
                        'token' => $newToken
                    ]);
            }
        } catch (\Throwable $th) {
            return response()->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'success' => false,
                    'message' => 'Data kawasan gagal ditambahkan',
                    'errors' => $this->zonaKawasan->errors(),
                    'token' => $newToken
                ]);
        }
    }

    public function updateKawasan($id)
    {
        try {
            $newToken = csrf_hash();
            $data = $this->request->getPost();

            $update = $this->zonaKawasan->update($id, $data);
            if ($update) {
                return response()->setStatusCode(ResponseInterface::HTTP_OK)
                    ->setJSON([
                        'success' => true,
                        'message' => 'Data kawasan berhasil diubah',
                        'token' => $newToken
                    ]);
            } else {
                return response()->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                    ->setJSON([
                        'success' => false,
                        'message' => 'Data kawasan gagal diubah',
                        'errors' => $this->zonaKawasan->errors(),
                        'token' => $newToken
                    ]);
            }
        } catch (\Throwable $th) {
            return response()->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'success' => false,
                    'message' => 'Data kawasan gagal diubah',
                    'errors' => $this->zonaKawasan->errors(),
                    'token' => $newToken
                ]);
        }
    }

    public function deleteKawasan($id)
    {
        try {
            $newToken = csrf_hash();
            $delete = $this->zonaKawasan->delete($id);
            if ($delete) {
                return response()->setStatusCode(ResponseInterface::HTTP_OK)
                    ->setJSON([
                        'success' => true,
                        'message' => 'Data kawasan berhasil dihapus',
                        'token' => $newToken
                    ]);
            } else {
                return response()->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                    ->setJSON([
                        'success' => false,
                        'message' => 'Data kawasan gagal dihapus',
                        'errors' => $this->zonaKawasan->errors(),
                        'token' => $newToken
                    ]);
            }
        } catch (\Throwable $th) {
            return response()->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'success' => false,
                    'message' => 'Data kawasan gagal dihapus',
                    'errors' => $this->zonaKawasan->errors(),
                    'token' => $newToken
                ]);
        }
    }

    public function kesesuaian()
    {
        $data = [
            'title' => 'Data Kesesuaian',
        ];

        return view('Pages/dashboard/kesesuaian/kesesuaian', $data);
    }
}
