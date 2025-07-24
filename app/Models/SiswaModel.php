<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table            = 'siswa';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'foto', 'nama', 'jenis_kelamin', 'tempat_lahir', 
        'tanggal_lahir', 'alamat', 'tanggal_bergabung'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nama' => 'required|min_length[3]|max_length[100]',
        'jenis_kelamin' => 'required|in_list[Laki-laki,Perempuan]',
        'tempat_lahir' => 'required|min_length[3]|max_length[100]',
        'tanggal_lahir' => 'required|valid_date',
        'alamat' => 'required|min_length[10]',
        'tanggal_bergabung' => 'required|valid_date'
    ];
    protected $validationMessages   = [
        'nama' => [
            'required' => 'Nama harus diisi',
            'min_length' => 'Nama minimal 3 karakter',
            'max_length' => 'Nama maksimal 100 karakter'
        ],
        'jenis_kelamin' => [
            'required' => 'Jenis kelamin harus dipilih',
            'in_list' => 'Jenis kelamin harus Laki-laki atau Perempuan'
        ],
        'tempat_lahir' => [
            'required' => 'Tempat lahir harus diisi',
            'min_length' => 'Tempat lahir minimal 3 karakter',
            'max_length' => 'Tempat lahir maksimal 100 karakter'
        ],
        'tanggal_lahir' => [
            'required' => 'Tanggal lahir harus diisi',
            'valid_date' => 'Format tanggal lahir tidak valid'
        ],
        'alamat' => [
            'required' => 'Alamat harus diisi',
            'min_length' => 'Alamat minimal 10 karakter'
        ],
        'tanggal_bergabung' => [
            'required' => 'Tanggal bergabung harus diisi',
            'valid_date' => 'Format tanggal bergabung tidak valid'
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
}
