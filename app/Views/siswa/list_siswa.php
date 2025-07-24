<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><?= $title ?></h4>
                        <a href="<?= base_url('siswa/create') ?>" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Siswa
                        </a>
                    </div>
                    <div class="card-body">
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (empty($siswa)): ?>
                            <div class="text-center py-4">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada data siswa</h5>
                                <p class="text-muted">Silakan tambah data siswa baru</p>
                                <a href="<?= base_url('siswa/create') ?>" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah Siswa Pertama
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Foto</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Tempat, Tanggal Lahir</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($siswa as $index => $s): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td>
                                                    <?php if ($s['foto']): ?>
                                                        <img src="<?= base_url('uploads/siswa/' . $s['foto']) ?>" 
                                                             alt="Foto <?= $s['nama'] ?>" 
                                                             class="rounded-circle" 
                                                             style="width: 50px; height: 50px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                                             style="width: 50px; height: 50px;">
                                                            <i class="fas fa-user text-white"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('siswa/detail/' . $s['id']) ?>" 
                                                       class="text-decoration-none fw-bold">
                                                        <?= esc($s['nama']) ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge <?= $s['jenis_kelamin'] == 'Laki-laki' ? 'bg-primary' : 'bg-danger' ?>">
                                                        <?= $s['jenis_kelamin'] ?>
                                                    </span>
                                                </td>
                                                <td><?= esc($s['tempat_lahir']) ?>, <?= date('d/m/Y', strtotime($s['tanggal_lahir'])) ?></td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="<?= base_url('siswa/detail/' . $s['id']) ?>" 
                                                           class="btn btn-info btn-sm" 
                                                           title="Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="<?= base_url('siswa/edit/' . $s['id']) ?>" 
                                                           class="btn btn-warning btn-sm" 
                                                           title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="<?= base_url('siswa/delete/' . $s['id']) ?>" 
                                                           class="btn btn-danger btn-sm" 
                                                           title="Hapus"
                                                           onclick="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
