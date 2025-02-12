<?php

namespace App\Models;

use CodeIgniter\Model;

class UploadModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tbl_file_upload';
    protected $primaryKey       = 'id_upload';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['file', 'id_perizinan'];

    protected bool $allowEmptyInserts = true;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getFiles($id_perizinan = false)
    {
        if ($id_perizinan == false) {
            return $this->db->table('tbl_file_upload')
                ->select('tbl_file_upload.*')
                ->orderBy('tbl_file_upload.id_upload', 'ASC')
                ->get();
        } else {
            return $this->db->table('tbl_file_upload')
                ->select('tbl_file_upload.file as uploadFiles')
                ->orderBy('tbl_file_upload.id_upload', 'ASC')
                ->Where(['tbl_file_upload.id_perizinan' => $id_perizinan])
                ->get();
        }
    }

    public function searchFile($name = false)
    {
        return $this->db->table('tbl_file_upload')
            ->select('*')
            ->like(['tbl_file_upload.file' => $name])
            ->get();
    }
}
