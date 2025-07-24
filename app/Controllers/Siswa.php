<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\TabunganModel;
use CodeIgniter\HTTP\ResponseInterface;

class Siswa extends BaseController
{
    protected $siswaModel;
    protected $tabunganModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->tabunganModel = new TabunganModel();
    }

    public function index()
    {
        // Ambil parameter sorting dari URL
        $sortBy = $this->request->getGet('sort') ?? 'nama';
        $sortOrder = $this->request->getGet('order') ?? 'asc';
        
        // Validasi parameter sorting
        $allowedSorts = ['nama', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'tanggal_bergabung', 'saldo_tabungan'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'nama';
        }
        
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'asc';
        }
        
        // Jika sorting berdasarkan saldo tabungan, ambil data tanpa sorting dulu
        if ($sortBy === 'saldo_tabungan') {
            $siswa = $this->siswaModel->findAll();
        } else {
            $siswa = $this->siswaModel->orderBy($sortBy, $sortOrder)->findAll();
        }
        
        // Tambahkan saldo tabungan untuk setiap siswa
        foreach ($siswa as &$s) {
            $s['saldo_tabungan'] = $this->tabunganModel->getSaldoSiswa($s['id']);
        }
        
        // Jika sorting berdasarkan saldo tabungan
        if ($sortBy === 'saldo_tabungan') {
            usort($siswa, function($a, $b) use ($sortOrder) {
                if ($sortOrder === 'desc') {
                    return $b['saldo_tabungan'] <=> $a['saldo_tabungan'];
                }
                return $a['saldo_tabungan'] <=> $b['saldo_tabungan'];
            });
        }

        $data = [
            'title' => 'Daftar Siswa',
            'siswa' => $siswa,
            'currentSort' => $sortBy,
            'currentOrder' => $sortOrder
        ];

        return view('siswa/list_siswa', $data);
    }

    public function detail($id)
    {
        $siswa = $this->siswaModel->find($id);
        
        if (!$siswa) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Siswa tidak ditemukan');
        }

        // Ambil data tabungan
        $saldo = $this->tabunganModel->getSaldoSiswa($id);
        $riwayatTerbaru = $this->tabunganModel->getRiwayatSiswa($id, 5); // 5 transaksi terakhir
        $totalSetoran = $this->tabunganModel->getTotalSetoran($id);
        $totalPenarikan = $this->tabunganModel->getTotalPenarikan($id);

        $data = [
            'title' => 'Detail Siswa',
            'siswa' => $siswa,
            'saldo' => $saldo,
            'riwayatTerbaru' => $riwayatTerbaru,
            'totalSetoran' => $totalSetoran,
            'totalPenarikan' => $totalPenarikan
        ];

        return view('siswa/detail_siswa', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Siswa',
            'validation' => \Config\Services::validation()
        ];

        return view('siswa/form_siswa', $data);
    }

    public function store()
    {
        $rules = [
            'nama' => 'required|min_length[3]|max_length[100]',
            'jenis_kelamin' => 'required|in_list[Laki-laki,Perempuan]',
            'tempat_lahir' => 'required|min_length[3]|max_length[100]',
            'tanggal_lahir' => 'required|valid_date',
            'alamat' => 'required|min_length[10]',
            'tanggal_bergabung' => 'required|valid_date',
            'foto' => 'uploaded[foto]|is_image[foto]|max_size[foto,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $foto = $this->request->getFile('foto');
        $fotoName = null;

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $fotoName = $foto->getRandomName();
            $foto->move('uploads/siswa/', $fotoName);
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'alamat' => $this->request->getPost('alamat'),
            'tanggal_bergabung' => $this->request->getPost('tanggal_bergabung'),
            'foto' => $fotoName
        ];

        $this->siswaModel->save($data);

        return redirect()->to('/siswa')->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function edit($id)
    {
        $siswa = $this->siswaModel->find($id);
        
        if (!$siswa) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Siswa tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Siswa',
            'siswa' => $siswa,
            'validation' => \Config\Services::validation()
        ];

        return view('siswa/form_siswa', $data);
    }

    public function update($id)
    {
        $siswa = $this->siswaModel->find($id);
        
        if (!$siswa) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Siswa tidak ditemukan');
        }

        $rules = [
            'nama' => 'required|min_length[3]|max_length[100]',
            'jenis_kelamin' => 'required|in_list[Laki-laki,Perempuan]',
            'tempat_lahir' => 'required|min_length[3]|max_length[100]',
            'tanggal_lahir' => 'required|valid_date',
            'alamat' => 'required|min_length[10]',
            'tanggal_bergabung' => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $foto = $this->request->getFile('foto');
        $fotoName = $siswa['foto']; // Keep existing photo if no new photo uploaded

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            // Delete old photo if exists
            if ($siswa['foto'] && file_exists('uploads/siswa/' . $siswa['foto'])) {
                unlink('uploads/siswa/' . $siswa['foto']);
            }
            
            $fotoName = $foto->getRandomName();
            $foto->move('uploads/siswa/', $fotoName);
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'alamat' => $this->request->getPost('alamat'),
            'tanggal_bergabung' => $this->request->getPost('tanggal_bergabung'),
            'foto' => $fotoName
        ];

        $this->siswaModel->update($id, $data);

        return redirect()->to('/siswa')->with('success', 'Data siswa berhasil diupdate');
    }

    public function delete($id)
    {
        $siswa = $this->siswaModel->find($id);
        
        if (!$siswa) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Siswa tidak ditemukan');
        }

        // Delete photo file if exists
        if ($siswa['foto'] && file_exists('uploads/siswa/' . $siswa['foto'])) {
            unlink('uploads/siswa/' . $siswa['foto']);
        }

        $this->siswaModel->delete($id);

        return redirect()->to('/siswa')->with('success', 'Data siswa berhasil dihapus');
    }

    // Method untuk tabungan
    public function setorTabungan($id)
    {
        $siswa = $this->siswaModel->find($id);
        
        if (!$siswa) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Siswa tidak ditemukan');
        }

        $rules = [
            'jumlah' => 'required|decimal|greater_than[0]',
            'keterangan' => 'permit_empty|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Data tidak valid');
        }

        $data = [
            'siswa_id' => $id,
            'jumlah' => $this->request->getPost('jumlah'),
            'jenis' => 'setoran',
            'tanggal' => date('Y-m-d'),
            'keterangan' => $this->request->getPost('keterangan') ?: 'Setoran tabungan'
        ];

        if ($this->tabunganModel->save($data)) {
            return redirect()->back()->with('success', 'Setoran tabungan berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan setoran tabungan');
        }
    }

    public function tarikTabungan($id)
    {
        $siswa = $this->siswaModel->find($id);
        
        if (!$siswa) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Siswa tidak ditemukan');
        }

        $rules = [
            'jumlah' => 'required|decimal|greater_than[0]',
            'keterangan' => 'permit_empty|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Data tidak valid');
        }

        $jumlahPenarikan = $this->request->getPost('jumlah');
        
        // Cek apakah saldo mencukupi
        if (!$this->tabunganModel->cekSaldoCukup($id, $jumlahPenarikan)) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk penarikan');
        }

        $data = [
            'siswa_id' => $id,
            'jumlah' => $jumlahPenarikan,
            'jenis' => 'penarikan',
            'tanggal' => date('Y-m-d'),
            'keterangan' => $this->request->getPost('keterangan') ?: 'Penarikan tabungan'
        ];

        if ($this->tabunganModel->save($data)) {
            return redirect()->back()->with('success', 'Penarikan tabungan berhasil');
        } else {
            return redirect()->back()->with('error', 'Gagal melakukan penarikan tabungan');
        }
    }

    public function riwayatTabungan($id)
    {
        $siswa = $this->siswaModel->find($id);
        
        if (!$siswa) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Siswa tidak ditemukan');
        }

        $riwayat = $this->tabunganModel->getRiwayatSiswa($id);
        $saldo = $this->tabunganModel->getSaldoSiswa($id);
        $totalSetoran = $this->tabunganModel->getTotalSetoran($id);
        $totalPenarikan = $this->tabunganModel->getTotalPenarikan($id);

        $data = [
            'title' => 'Riwayat Tabungan - ' . $siswa['nama'],
            'siswa' => $siswa,
            'riwayat' => $riwayat,
            'saldo' => $saldo,
            'totalSetoran' => $totalSetoran,
            'totalPenarikan' => $totalPenarikan
        ];

        return view('siswa/riwayat_tabungan', $data);
    }
}
