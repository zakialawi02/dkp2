<?php

namespace App\Models;

use CodeIgniter\Model;

class ZonaKawasanModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tbl_zona_kawasan';
    protected $primaryKey       = 'id_znkwsn';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_zona', 'kode_kawasan'];

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
        'kode_kawasan' => 'required|min_length[2]|regex_match[/^[a-zA-Z0-9_-]+$/]|is_unique[tbl_zona_kawasan.kode_kawasan,id_znkwsn,{id_znkwsn}]'
    ];
    protected $validationMessages   = [
        'kode_kawasan' => [
            'regex_match' => 'Kode kawasan hanya boleh mengandung huruf, angka, garis bawah (_), dan tanda hubung (-).',
        ]
    ];
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

    public function getZKawasan($id_zona = false, $id_znkwsn = false)
    {
        if ($id_zona == false && $id_znkwsn == false) {
            return $this->db->table('tbl_zona_kawasan')
                ->select('id_znkwsn, kode_kawasan, nama_zona')
                ->join('tbl_zona', 'tbl_zona.id_zona = tbl_zona_kawasan.id_zona', 'left');
        } elseif ($id_zona == false && $id_znkwsn != false) {
            return $this->db->table('tbl_zona_kawasan')
                ->select('tbl_zona.id_zona, id_znkwsn, kode_kawasan, nama_zona')
                ->join('tbl_zona', 'tbl_zona.id_zona = tbl_zona_kawasan.id_zona', 'left')
                ->Where(['tbl_zona_kawasan.id_znkwsn' => $id_znkwsn]);
        } else {
            return $this->db->table('tbl_zona_kawasan')
                ->select('id_znkwsn, kode_kawasan, nama_zona')
                ->join('tbl_zona', 'tbl_zona.id_zona = tbl_zona_kawasan.id_zona', 'left')
                ->Where(['tbl_zona_kawasan.id_zona' => $id_zona]);
        }
    }

    public function cekDuplikat($id_zona, $kode_kawasan)
    {
        return $this->db->table('tbl_zona_kawasan')
            ->select('tbl_zona_kawasan.*, tbl_zona.*')
            ->join('tbl_zona', 'tbl_zona.id_zona = tbl_zona_kawasan.id_zona', 'LEFT')
            ->orderBy('id_znkwsn', 'ASC')
            ->Where(['tbl_zona_kawasan.id_zona' => $id_zona, 'tbl_zona_kawasan.kode_kawasan' => $kode_kawasan])
            ->get();
    }
}
