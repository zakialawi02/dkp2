<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KegiatanModel;
use App\Models\KesesuaianModel;
use App\Models\SettingModel;
use App\Models\ZonaKawasanModel;
use App\Models\ZonaModel;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;

class KesesuaianController extends BaseController
{
    protected $setting;
    protected $kegiatan;
    protected $zona;
    protected $zonaKawasan;
    protected $kesesuaian;

    public function __construct()
    {
        $this->setting = new SettingModel();
        $this->kegiatan = new KegiatanModel();
        $this->zona = new ZonaModel();
        $this->zonaKawasan = new ZonaKawasanModel();
        $this->kesesuaian = new KesesuaianModel();
    }

    public function petaKesesuaian()
    {
        $data = [
            'title' => 'Peta Kesesuaian',
            'tampilData' => $this->setting->Where(['id' => 1])->get()->getRow(),
            'jenisKegiatan' => $this->kegiatan->getJenisKegiatan()->getResult(),
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
                ->add('aksi', function ($row) {
                    return '
                    <button type="button" class="btn btn-primary btn-sm editData" data-kode="' . $row->kode_kegiatan . '"><i class="bi bi-pencil-square"></i></button>
                    <button type="button" class="btn btn-danger btn-sm deleteData" data-kode="' . $row->kode_kegiatan . '"><i class="bi bi-trash3"></i></button>';
                })
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

    public function showDataKegiatan($kode_kegiatan)
    {
        try {
            $data = $this->kegiatan->where('kode_kegiatan', $kode_kegiatan)->first();
            return response()->setStatusCode(ResponseInterface::HTTP_OK)
                ->setJSON([
                    'success' => true,
                    'data' => $data,
                    'token' => csrf_hash()
                ]);
        } catch (\Throwable $th) {
            return response()->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'success' => false,
                    'message' => 'Data Kegiatan gagal ditampilkan',
                    'errors' => $this->kegiatan->errors(),
                    'token' => csrf_hash()
                ]);
        }
    }

    public function updateKegiatan($kode_kegiatan)
    {
        try {
            $kegiatan = $this->kegiatan->where('kode_kegiatan', $kode_kegiatan)->first();
            $id = $kegiatan['id_kegiatan'];
            if (!$kegiatan) {
                return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                    ->setJSON(['success' => false, 'message' => 'Data tidak ditemukan']);
            }

            $data = [
                'id_kegiatan'   => $id,
                'kode_kegiatan' => $this->request->getPost('editKKegiatan'),
                'nama_kegiatan' => $this->request->getPost('editKegiatan'),
            ];

            $this->kegiatan->skipValidation(true);
            $validation = \Config\Services::validation();
            $validation->setRules([
                'kode_kegiatan' => "required|min_length[2]|max_length[12]|alpha_numeric|is_unique[tbl_kegiatan.kode_kegiatan,id_kegiatan,{$id}]",
                'nama_kegiatan' => "required|min_length[3]",
            ],);
            if (!$validation->run($data)) {
                return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                    ->setJSON([
                        'success' => false,
                        'message' => 'Validation failed',
                        'errors' => $validation->getErrors(),
                        'token' => csrf_hash()
                    ]);
            }

            $this->kegiatan->update($id, $data);

            return $this->response->setStatusCode(ResponseInterface::HTTP_OK)
                ->setJSON([
                    'success' => true,
                    'message' => 'Data Kegiatan berhasil diperbarui',
                    'token' => csrf_hash()
                ]);
        } catch (\Throwable $th) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'success' => false,
                    'message' => 'Data Kegiatan gagal diperbarui',
                    'errors' => $th->getMessage(),
                    'token' => csrf_hash()
                ]);
        }
    }

    public function deleteKegiatan($kode_kegiatan)
    {
        try {
            $this->kegiatan->where('kode_kegiatan', $kode_kegiatan)->delete();
            return response()->setStatusCode(ResponseInterface::HTTP_OK)
                ->setJSON([
                    'success' => true,
                    'message' => 'Data Kegiatan berhasil dihapus',
                    'token' => csrf_hash()
                ]);
        } catch (\Throwable $th) {
            return response()->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'success' => false,
                    'message' => 'Data Kegiatan gagal dihapus',
                    'errors' => $this->kegiatan->errors(),
                    'token' => csrf_hash()
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
            $builder = $this->zonaKawasan->getZKawasan();

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

    public function showDataKawasan($id_znkwsn)
    {
        try {
            $data = $this->zonaKawasan->getZKawasan(false, $id_znkwsn)->get()->getFirstRow();

            return response()->setStatusCode(ResponseInterface::HTTP_OK)
                ->setJSON([
                    'success' => true,
                    'data' => $data,
                    'token' => csrf_hash()
                ]);
        } catch (\Throwable $th) {
            return response()->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'success' => false,
                    'message' => 'Data kawasan gagal ditambahkan',
                    'errors' => $this->zonaKawasan->errors(),
                    'token' => csrf_hash()
                ]);
        }
    }

    public function tambahZonaKawasan()
    {
        try {
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
                        'token' => csrf_hash()
                    ]);
            } else {
                return response()->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                    ->setJSON([
                        'success' => false,
                        'message' => 'Data kawasan gagal ditambahkan',
                        'errors' => $this->zonaKawasan->errors(),
                        'token' => csrf_hash()
                    ]);
            }
        } catch (\Throwable $th) {
            return response()->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'success' => false,
                    'message' => 'Data kawasan gagal ditambahkan',
                    'errors' => $this->zonaKawasan->errors(),
                    'token' => csrf_hash()
                ]);
        }
    }

    public function updateKawasan($id_znkwsn)
    {
        try {
            $kawasan = $this->zonaKawasan->where('id_znkwsn', $id_znkwsn)->first();
            if (!$kawasan) {
                return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                    ->setJSON(['success' => false, 'message' => 'Data tidak ditemukan', 'toke' => csrf_hash()]);
            }
            $newKode = $this->request->getPost('editKawasan');
            $oldKode = $kawasan['kode_kawasan'];

            $this->zonaKawasan->skipValidation(true);
            if ($newKode != $oldKode) {
                $validation = \Config\Services::validation();
                $validation->setRules(
                    [
                        'editKawasan' => 'required|min_length[2]|regex_match[/^[a-zA-Z0-9_-]+$/]|is_unique[tbl_zona_kawasan.kode_kawasan,id_znkwsn,{id_znkwsn}]',
                    ],
                    [
                        'editKawasan' => [
                            'regex_match' => 'Kode kawasan hanya boleh mengandung huruf, angka, garis bawah (_), dan tanda hubung (-).',
                        ],
                    ]
                );
                if (!$validation->run($this->request->getPost())) {
                    return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                        ->setJSON([
                            'success' => false,
                            'message' => 'Validation failed',
                            'errors' => $validation->getErrors(),
                            'token' => csrf_hash()
                        ]);
                }
            }

            $data = [
                'id_znkwsn' => $id_znkwsn,
                'id_zona' => $this->request->getPost('editZona'),
                'kode_kawasan' => $this->request->getPost('editKawasan'),
            ];

            $cek = $this->zonaKawasan->cekDuplikat($data['id_zona'], $data['kode_kawasan'])->getRow();
            if (!empty($cek)) {
                return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                    ->setJSON([
                        'success' => false,
                        'message' => 'Data kawasan gagal diubah',
                        'errors' => [
                            'kode_kawasan' => 'Kode kawasan sudah ada',
                        ],
                        'token' => csrf_hash()
                    ]);
            }

            $update = $this->zonaKawasan->save($data);
            if ($update) {
                return response()->setStatusCode(ResponseInterface::HTTP_OK)
                    ->setJSON([
                        'success' => true,
                        'message' => 'Data kawasan berhasil diubah',
                        'token' => csrf_hash()
                    ]);
            } else {
                return response()->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                    ->setJSON([
                        'success' => false,
                        'message' => 'Data kawasan gagal diubah',
                        'errors' => $this->zonaKawasan->errors(),
                        'token' => csrf_hash()
                    ]);
            }
        } catch (\Throwable $th) {
            return response()->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'success' => false,
                    'message' => 'Data kawasan gagal diubah',
                    'errors' => $this->zonaKawasan->errors(),
                    'token' => csrf_hash()
                ]);
        }
    }

    public function deleteKawasan($id)
    {
        try {
            $delete = $this->zonaKawasan->delete($id);
            if ($delete) {
                return response()->setStatusCode(ResponseInterface::HTTP_OK)
                    ->setJSON([
                        'success' => true,
                        'message' => 'Data kawasan berhasil dihapus',
                        'token' => csrf_hash()
                    ]);
            } else {
                return response()->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                    ->setJSON([
                        'success' => false,
                        'message' => 'Data kawasan gagal dihapus',
                        'errors' => $this->zonaKawasan->errors(),
                        'token' => csrf_hash()
                    ]);
            }
        } catch (\Throwable $th) {
            return response()->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'success' => false,
                    'message' => 'Data kawasan gagal dihapus',
                    'errors' => $this->zonaKawasan->errors(),
                    'token' => csrf_hash()
                ]);
        }
    }

    public function kesesuaian()
    {
        $id_zona = $this->request->getVar('zona');
        $data = [
            'title' => 'Data Kesesuaian',
            'zona' => $id_zona,
            'dataZona' => $this->zona->getZona()->getResult(),
            'dataKegiatan' => $this->kegiatan->getJenisKegiatan()->getResult(),
        ];

        if ($this->request->isAJAX()) {
            $db = \Config\Database::connect();
            $builder = $db->table('tbl_kesesuaian')
                ->select([
                    'tbl_kesesuaian.id_kesesuaian AS id_kesesuaian',
                    "CAST(tbl_kesesuaian.status AS TEXT) AS status",
                    'tbl_kesesuaian.kode_kegiatan AS kode_kegiatan',
                    'tbl_kegiatan.nama_kegiatan AS nama_kegiatan',
                    'tbl_kesesuaian.sub_zona AS sub_zona',
                    'tbl_zona.nama_zona AS nama_zona',
                    '(SELECT COUNT(*) FROM tbl_kesesuaian k2 WHERE k2.id_zona = tbl_kesesuaian.id_zona AND k2.kode_kegiatan = tbl_kesesuaian.kode_kegiatan) AS is_duplicate'
                ])
                ->join('tbl_kegiatan', 'tbl_kegiatan.kode_kegiatan = tbl_kesesuaian.kode_kegiatan', 'LEFT')
                ->join('tbl_zona', 'tbl_zona.id_zona = tbl_kesesuaian.id_zona', 'LEFT');

            if (!empty($id_zona)) {
                $builder->where('tbl_kesesuaian.id_zona', $id_zona != "0" ? $id_zona : "");
            }

            return DataTable::of($builder)
                ->addNumbering('DT_RowIndex')
                ->setSearchableColumns([
                    'tbl_zona.nama_zona',
                    'tbl_kesesuaian.sub_zona',
                    'tbl_kesesuaian.kode_kegiatan',
                    'tbl_kegiatan.nama_kegiatan',
                    "CAST(tbl_kesesuaian.status AS TEXT)"
                ])
                ->add('aksi', function ($row) {
                    return '
                    <button type="submit" class="btn btn-primary btn-sm editData" data-kesesuaian="' . $row->id_kesesuaian . '"><i class="bi bi-pencil-square"></i></button>
                    <button type="submit" class="btn btn-danger btn-sm deleteData" data-kesesuaian="' . $row->id_kesesuaian . '"><i class="bi bi-trash3"></i></button>';
                })
                ->toJson(true);
        }

        return view('Pages/dashboard/kesesuaian/kesesuaian', $data);
    }

    public function showKesesuaian($id_kesesuaian)
    {
        try {
            $response = $this->kesesuaian->getKesesuaian($id_kesesuaian)->getResult();
            return $this->response->setStatusCode(ResponseInterface::HTTP_OK)
                ->setJSON([
                    'success' => true,
                    'data' => $response,
                    'token' => csrf_hash(),
                ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'token' => csrf_hash(),
                ]);
        }
    }

    public function tambahAturanKesesuaian()
    {
        try {
            $data = [
                'id_zona' => $this->request->getPost('tambahZona'),
                'kode_kegiatan' => $this->request->getPost('tambahKegiatan'),
                'sub_zona' => $this->request->getPost('tambahSubZona'),
                'status' => $this->request->getPost('tambahStatus'),
            ];
            $this->kesesuaian->save($data);
            return $this->response->setStatusCode(ResponseInterface::HTTP_OK)
                ->setJSON([
                    'success' => true,
                    'message' => 'Data berhasil ditambahkan',
                    'token' => csrf_hash(),
                ]);
        } catch (\Throwable $th) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'success' => false,
                    'message' => 'Data gagal ditambahkan',
                    'errors' => $th->getMessage(),
                    'token' => csrf_hash(),
                ]);
        }
    }

    public function updateAturanKesesuaian($id_kesesuaian)
    {
        try {
            $data = [
                'id_kesesuaian' => $id_kesesuaian,
                'id_zona' => $this->request->getPost('editZona'),
                'kode_kegiatan' => $this->request->getPost('editKegiatan'),
                'sub_zona' => $this->request->getPost('editSubZona'),
                'status' => $this->request->getPost('editStatus'),
            ];
            $this->kesesuaian->save($data);
            return $this->response->setStatusCode(ResponseInterface::HTTP_OK)
                ->setJSON([
                    'success' => true,
                    'message' => 'Data berhasil diperbarui',
                    'token' => csrf_hash(),
                ]);
        } catch (\Throwable $th) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'success' => false,
                    'message' => 'Data gagal diperbarui',
                    'errors' => $th->getMessage(),
                    'token' => csrf_hash(),
                ]);
        }
    }

    public function delete_kesesuaian($id_kesesuaian)
    {
        try {
            $this->kesesuaian->delete(['id_kesesuaian' => $id_kesesuaian]);
            return $this->response->setStatusCode(ResponseInterface::HTTP_OK)
                ->setJSON([
                    'success' => true,
                    'message' => 'Data berhasil dihapus',
                    'token' => csrf_hash(),
                ]);
        } catch (\Throwable $th) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'success' => false,
                    'message' => 'Data gagal dihapus',
                    'errors' => $th->getMessage(),
                    'token' => csrf_hash(),
                ]);
        }
    }

    public function cekStatus()
    {
        // print_r($this->request->getVar());
        $result = [];
        $getOverlapProperties = json_decode($this->request->getVar('getOverlapProperties'), true);
        $valKegiatan = $this->request->getVar('valKegiatan');
        $fecthKegiatan = $this->kegiatan->getJenisKegiatan($valKegiatan)->getFirstRow();
        $KodeKegiatan = $fecthKegiatan->kode_kegiatan;

        if (empty($getOverlapProperties)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data geometri tidak ditemukan/kosong',
                'token' => csrf_hash(),
            ], 404);
        }
        if (!$fecthKegiatan) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data kegiatan tidak ditemukan',
                'token' => csrf_hash(),
            ], 404);
        }

        // Filter unik berdasarkan KODKWS
        $uniqueProperties = [];
        $seenKODKWS = [];

        foreach ($getOverlapProperties as $property) {
            $kodkws = $property['KODKWS'];
            if (!isset($seenKODKWS[$kodkws])) {
                $seenKODKWS[$kodkws] = true;
                $uniqueProperties[] = $property;
            }
        }

        if (!empty($uniqueProperties)) {
            // Mapping nilai SUBZONA
            $replacementName = [
                "Zona Inti" => "Inti",
                "Zona Pemanfaatan Terbatas" => "ZPT",
                "Zona Lainnya" => "Lainnya",
                "KKM" => "Lainnya",
                "KKP3K" => "Lainnya",
            ];

            $OverlapProperties = [];
            $isKonservasi = [];
            $isntKonservasi = [];

            foreach ($uniqueProperties as $property) {
                // Mapping subzona ke properti SUBZONA2 jika ada di daftar mapping
                if (isset($replacementName[$property['SUBZONA']])) {
                    $property['SUBZONA'] = $replacementName[$property['SUBZONA2']];
                } else {
                    // Kalau tidak ada di mapping, isi null
                    $property['SUBZONA'] = null;
                }

                $OverlapProperties[] = $property;

                // Pisahkan berdasarkan NAMOBJ konservasi
                if ($property['NAMOBJ'] === "Kawasan Konservasi") {
                    $isKonservasi[] = $property;
                } else {
                    $isntKonservasi[] = $property;
                }
            }

            // Ambil data zona, subzona, dan kode kawasan
            $namaZona = array_column($OverlapProperties, 'NAMOBJ');
            $subZona = array_column($OverlapProperties, 'SUBZONA');
            $kode_kawasan = array_column($OverlapProperties, 'KODKWS');
            $id_zona = array_map(fn($name) => $this->zona->searchZona($name)->getResult()[0]->id_zona, $namaZona);
            // print_r($namaZona);
            // print_r($subZona);
            // print_r($id_zona);
            // print_r($OverlapProperties);
            // die;
            // Ambil hasil kesesuaian
            foreach ($OverlapProperties as $i => $item) {
                $zonaList = [$id_zona[$i]];
                foreach ($zonaList as $zona) {
                    $kesesuaian = $this->kesesuaian->searchKesesuaian(
                        $KodeKegiatan,
                        $zona,
                        $kode_kawasan[$i],
                        $subZona[$i]
                    )->getResult();
                    foreach ($kesesuaian as $item) {
                        $result[] = $item;
                    }
                }
            }
        }
        // echo 'Memory usage: ' . memory_get_usage() . "\n";;
        // echo 'Data size: ' . strlen(json_encode($result)) . "\n";;
        // exit;
        // Buat responsenya
        $response = [
            'success' => true,
            'message' => 'Data berhasil ditemukan',
            'valueKegiatan' => $valKegiatan,
            'KodeKegiatan' => $KodeKegiatan,
            'valZona' => $id_zona ?? [],
            'nameKegiatan' => $fecthKegiatan->nama_kegiatan,
            'hasil' => $result,
            'token' => csrf_hash(),
        ];

        return $this->response->setJSON($response, 200);
    }
}
