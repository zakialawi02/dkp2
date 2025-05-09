<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanModel extends Model
{
    protected $table      = 'tbl_kegiatan';
    protected $primaryKey = 'id_kegiatan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_kegiatan', 'kode_kegiatan'];

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
    protected $validationRules = [
        "nama_kegiatan"  => 'required|min_length[3]',
        "kode_kegiatan"  => 'required|min_length[2]|max_length[12]|alpha_numeric|is_unique[tbl_kegiatan.kode_kegiatan,id_kegiatan,{id_kegiatan}]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['formatKegiatan'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['formatKegiatan'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function formatKegiatan(array $data)
    {
        $data['data']['kode_kegiatan'] = strtoupper($data['data']['kode_kegiatan']);
        $data['data']['nama_kegiatan'] = ucfirst(strtolower($data['data']['nama_kegiatan']));

        return $data;
    }


    public function getJenisKegiatan($id_kegiatan = false)
    {
        if ($id_kegiatan === false) {
            return $this->db->table('tbl_kegiatan')
                ->select('*')
                ->orderBy('id_kegiatan', 'ASC')
                ->get();
        } else {
            return $this->db->table('tbl_kegiatan')
                ->select('*')
                ->orderBy('id_kegiatan', 'ASC')
                ->Where(['tbl_kegiatan.id_kegiatan' => $id_kegiatan])
                ->get();
        }
    }
}
