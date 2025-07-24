<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use CodeIgniter\HTTP\ResponseInterface;

class Siswa extends BaseController
{
    protected $siswaModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Daftar Siswa',
            'siswa' => $this->siswaModel->findAll()
        ];

        return view('siswa/list_siswa', $data);
    }

    public function detail($id)
    {
        $siswa = $this->siswaModel->find($id);
        
        if (!$siswa) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Siswa tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Siswa',
            'siswa' => $siswa
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
}
