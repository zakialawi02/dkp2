<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModulModel;
use CodeIgniter\HTTP\ResponseInterface;

class ModulController extends BaseController
{
    protected $modul;

    public function __construct()
    {
        $this->modul = new ModulModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Modul',
            'dataModul' => $this->modul->getModul()->getResult(),
        ];

        return view('Pages/dashboard/modul/index', $data);
    }

    public function indexFront()
    {
        $data = [
            'title' => 'Modul',
            'dataModul' => $this->modul->getModul()->getResult(),
        ];

        return view('Pages/front/modul', $data);
    }

    public function create()
    {
        return view('Pages/dashboard/modul/addModul');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Modul',
            'dataModul' => $this->modul->getModul($id)->getRow(),
        ];

        return view('Pages/dashboard/modul/editModul', $data);
    }

    public function store()
    {
        $data = [
            'judul_modul' => $this->request->getPost('judul_modul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'file_modul' => $this->request->getFile('file_modul'),
        ];

        if (!$this->validate($this->modul->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        if (!$this->validate([
            'file_modul' => [
                'rules' => 'uploaded[file_modul]|max_size[file_modul,51200]|ext_in[file_modul,jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx]',
                'errors' => [
                    'uploaded' => 'Pilih file terlebih dahulu',
                    'max_size' => 'Ukuran file melebihi 20MB',
                    'ext_in' => 'Format file harus .jpg, .jpeg, .png, .gif, .pdf, .doc, .docx, .xls, .xlsx',
                ]
            ],
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('file_modul');
        if ($file->isValid() && !$file->hasMoved()) {
            $originalName = $file->getName();
            $uploadFiles = date('YmdHis') . "_" . $originalName;
            $data['file_modul'] = $uploadFiles;
            if (!$file->move('dokumen/modul/', $uploadFiles)) {
                return redirect()->back()->with('error', 'File gagal diunggah');
            }
        }

        // Debugging sebelum simpan
        // dd($data);

        $modul = $this->modul->insert($data);
        if ($modul) {
            return redirect()->to(route_to('admin.modul.index'))->with('success', 'Data Modul berhasil ditambahkan');
        } else {
            return redirect()->to(route_to('admin.modul.index'))->with('error', 'Data Modul gagal ditambahkan');
        }
    }


    public function update($id)
    {
        $data = [
            'judul_modul' => $this->request->getPost('judul_modul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'file_modul' => $this->request->getFile('file_modul'),
        ];

        if (!$this->validate($this->modul->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        if (!$this->validate([
            'file_modul' => [
                'rules' => 'uploaded[file_modul]|max_size[file_modul,51200]|ext_in[file_modul,jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx]',
                'errors' => [
                    'uploaded' => 'Pilih file terlebih dahulu',
                    'max_size' => 'Ukuran file melebihi 20MB',
                    'ext_in' => 'Format file harus .jpg, .jpeg, .png, .gif, .pdf, .doc, .docx, .xls, .xlsx',
                ],
            ],
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('file_modul');
        if ($file->isValid() && !$file->hasMoved()) {
            $originalName = $file->getName();
            $uploadFiles = date('YmdHis') . "_" . $originalName;
            $data['file_modul'] = $uploadFiles;
            if (!$file->move('dokumen/modul/', $uploadFiles)) {
                return redirect()->back()->with('error', 'File gagal diunggah');
            }
        }

        $modul = $this->modul->update($id, $data);
        if ($modul) {
            return redirect()->to(route_to('admin.modul.index'))->with('success', 'Data Modul berhasil diperbarui');
        } else {
            return redirect()->to(route_to('admin.modul.index'))->with('error', 'Data Modul gagal diperbarui');
        }
    }

    public function destroy($id)
    {
        $data = $this->modul->getModul($id)->getRow();
        if (!empty($data->file_modul)) {
            $file = 'dokumen/modul/' . $data->file_modul;
            if (file_exists($file)) {
                unlink($file);
            }
        }
        $delete = $this->modul->delete($id);
        if ($delete) {
            return redirect()->to(route_to('admin.modul.index'))->with('success', 'Data Modul berhasil dihapus');
        } else {
            return redirect()->to(route_to('admin.modul.index'))->with('error', 'Data Modul gagal dihapus');
        }
    }
}
