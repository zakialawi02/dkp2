<?php

namespace App\Models;

use CodeIgniter\Model;

class ZonaModel extends Model
{
    protected $table            = 'tbl_zona';
    protected $primaryKey       = 'id_zona';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_zona'];

    protected bool $allowEmptyInserts = false;
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
    protected $validationRules      = [
        'nama_zona' => 'required|min_length[3]'
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

    public function getZona($id_zona = false)
    {
        if ($id_zona === false) {
            return $this->db->table('tbl_zona')
                ->select('tbl_zona.*')
                ->orderBy('id_zona', 'ASC')
                ->get();
        } else {
            return $this->db->table('tbl_zona')
                ->select('*')
                ->orderBy('id_zona', 'ASC')
                ->Where(['tbl_zona.id_zona' => $id_zona])
                ->get();
        }
    }

    public function searchZona($key = false)
    {
        return $this->db->table('tbl_zona')
            ->select('*')
            ->orderBy('id_zona', 'ASC')
            ->like(['tbl_zona.nama_zona' => $key])
            ->get();
    }
}
