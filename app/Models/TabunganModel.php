<?php

namespace App\Models;

use CodeIgniter\Model;

class TabunganModel extends Model
{
    protected $table            = 'tabungan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['siswa_id', 'jumlah', 'jenis', 'tanggal', 'keterangan'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'siswa_id'   => 'required|integer',
        'jumlah'     => 'required|decimal|greater_than[0]',
        'jenis'      => 'required|in_list[setoran,penarikan]',
        'tanggal'    => 'required|valid_date',
        'keterangan' => 'permit_empty|max_length[255]'
    ];
    protected $validationMessages   = [
        'siswa_id' => [
            'required' => 'Siswa harus dipilih',
            'integer'  => 'ID siswa tidak valid'
        ],
        'jumlah' => [
            'required'     => 'Jumlah harus diisi',
            'decimal'      => 'Jumlah harus berupa angka',
            'greater_than' => 'Jumlah harus lebih dari 0'
        ],
        'jenis' => [
            'required' => 'Jenis transaksi harus dipilih',
            'in_list'  => 'Jenis transaksi tidak valid'
        ],
        'tanggal' => [
            'required'   => 'Tanggal harus diisi',
            'valid_date' => 'Format tanggal tidak valid'
        ],
        'keterangan' => [
            'max_length' => 'Keterangan maksimal 255 karakter'
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

    /**
     * Mendapatkan saldo tabungan siswa
     */
    public function getSaldoSiswa($siswaId)
    {
        $setoran = $this->selectSum('jumlah')
                       ->where('siswa_id', $siswaId)
                       ->where('jenis', 'setoran')
                       ->first()['jumlah'] ?? 0;

        $penarikan = $this->selectSum('jumlah')
                         ->where('siswa_id', $siswaId)
                         ->where('jenis', 'penarikan')
                         ->first()['jumlah'] ?? 0;

        return $setoran - $penarikan;
    }

    /**
     * Mendapatkan riwayat tabungan siswa
     */
    public function getRiwayatSiswa($siswaId, $limit = null)
    {
        $builder = $this->where('siswa_id', $siswaId)
                       ->orderBy('tanggal', 'DESC')
                       ->orderBy('created_at', 'DESC');
        
        if ($limit) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Mendapatkan total setoran siswa
     */
    public function getTotalSetoran($siswaId)
    {
        return $this->selectSum('jumlah')
                   ->where('siswa_id', $siswaId)
                   ->where('jenis', 'setoran')
                   ->first()['jumlah'] ?? 0;
    }

    /**
     * Mendapatkan total penarikan siswa
     */
    public function getTotalPenarikan($siswaId)
    {
        return $this->selectSum('jumlah')
                   ->where('siswa_id', $siswaId)
                   ->where('jenis', 'penarikan')
                   ->first()['jumlah'] ?? 0;
    }

    /**
     * Validasi apakah saldo mencukupi untuk penarikan
     */
    public function cekSaldoCukup($siswaId, $jumlahPenarikan)
    {
        $saldo = $this->getSaldoSiswa($siswaId);
        return $saldo >= $jumlahPenarikan;
    }
}
