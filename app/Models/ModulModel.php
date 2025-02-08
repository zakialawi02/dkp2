<?php

namespace App\Models;

use CodeIgniter\Model;

class ModulModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tbl_modul';
    protected $primaryKey       = 'id_modul';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['judul_modul', 'deskripsi', 'file_modul', 'thumb_modul'];

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
    protected $validationRules = [
        'judul_modul' => 'required|min_length[4]',
        'deskripsi' => 'required|min_length[10]',
        // 'file_modul' => 'uploaded[file_modul]|max_size[file_modul,51200]|ext_in[file_modul,jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx]',
    ];
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

    public function getModul($id_modul = false)
    {
        if ($id_modul == false) {
            return $this->db->table('tbl_modul')
                ->select('tbl_modul.*')
                ->get();
        } else {
            return $this->db->table('tbl_modul')
                ->select('tbl_modul.*')
                ->Where(['tbl_modul.id_modul' => $id_modul])
                ->get();
        }
    }
}
