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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><?= $title ?></h4>
                        <div>
                            <a href="<?= base_url('siswa') ?>" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <a href="<?= base_url('siswa/edit/' . $siswa['id']) ?>" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <div class="row">
                            <!-- Foto Siswa -->
                            <div class="col-md-4 text-center mb-4">
                                <?php if ($siswa['foto']): ?>
                                    <img src="<?= base_url('uploads/siswa/' . $siswa['foto']) ?>" 
                                         alt="Foto <?= $siswa['nama'] ?>" 
                                         class="img-fluid rounded-circle border border-3 border-primary" 
                                         style="width: 200px; height: 200px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center border border-3 border-primary mx-auto" 
                                         style="width: 200px; height: 200px;">
                                        <i class="fas fa-user fa-5x text-white"></i>
                                    </div>
                                <?php endif; ?>
                                <h5 class="mt-3 mb-1"><?= esc($siswa['nama']) ?></h5>
                                <span class="badge <?= $siswa['jenis_kelamin'] == 'Laki-laki' ? 'bg-primary' : 'bg-danger' ?> fs-6">
                                    <?= $siswa['jenis_kelamin'] ?>
                                </span>
                            </div>
                            
                            <!-- Detail Informasi -->
                            <div class="col-md-8">
                                <h5 class="mb-3">
                                    <i class="fas fa-user-circle text-primary"></i> Informasi Pribadi
                                </h5>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong><i class="fas fa-id-card text-muted"></i> ID Siswa:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <span class="badge bg-info">#<?= str_pad($siswa['id'], 4, '0', STR_PAD_LEFT) ?></span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong><i class="fas fa-user text-muted"></i> Nama Lengkap:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= esc($siswa['nama']) ?>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong><i class="fas fa-venus-mars text-muted"></i> Jenis Kelamin:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <span class="badge <?= $siswa['jenis_kelamin'] == 'Laki-laki' ? 'bg-primary' : 'bg-danger' ?>">
                                            <?= $siswa['jenis_kelamin'] ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong><i class="fas fa-map-marker-alt text-muted"></i> Tempat Lahir:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= esc($siswa['tempat_lahir']) ?>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong><i class="fas fa-calendar-alt text-muted"></i> Tanggal Lahir:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= date('d F Y', strtotime($siswa['tanggal_lahir'])) ?>
                                        <small class="text-muted">
                                            (<?= date_diff(date_create($siswa['tanggal_lahir']), date_create('today'))->y ?> tahun)
                                        </small>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong><i class="fas fa-home text-muted"></i> Alamat:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= nl2br(esc($siswa['alamat'])) ?>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong><i class="fas fa-calendar-check text-muted"></i> Tanggal Bergabung:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= date('d F Y', strtotime($siswa['tanggal_bergabung'])) ?>
                                        <small class="text-muted">
                                            (<?= date_diff(date_create($siswa['tanggal_bergabung']), date_create('today'))->days ?> hari yang lalu)
                                        </small>
                                    </div>
                                </div>

                                <?php if ($siswa['created_at']): ?>
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong><i class="fas fa-clock text-muted"></i> Dibuat:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <small class="text-muted">
                                                <?= date('d F Y H:i', strtotime($siswa['created_at'])) ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($siswa['updated_at']): ?>
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong><i class="fas fa-edit text-muted"></i> Terakhir Diupdate:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <small class="text-muted">
                                                <?= date('d F Y H:i', strtotime($siswa['updated_at'])) ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Informasi Tabungan -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-3">
                                    <i class="fas fa-piggy-bank text-success"></i> Informasi Tabungan
                                </h5>
                                
                                <!-- Saldo dan Statistik -->
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="card bg-success text-white">
                                            <div class="card-body text-center">
                                                <i class="fas fa-wallet fa-2x mb-2"></i>
                                                <h6>Saldo Saat Ini</h6>
                                                <h4>Rp <?= number_format($saldo, 0, ',', '.') ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-primary text-white">
                                            <div class="card-body text-center">
                                                <i class="fas fa-arrow-up fa-2x mb-2"></i>
                                                <h6>Total Setoran</h6>
                                                <h5>Rp <?= number_format($totalSetoran, 0, ',', '.') ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-danger text-white">
                                            <div class="card-body text-center">
                                                <i class="fas fa-arrow-down fa-2x mb-2"></i>
                                                <h6>Total Penarikan</h6>
                                                <h5>Rp <?= number_format($totalPenarikan, 0, ',', '.') ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Transaksi -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header bg-success text-white">
                                                <h6 class="mb-0"><i class="fas fa-plus"></i> Setor Tabungan</h6>
                                            </div>
                                            <div class="card-body">
                                                <form action="<?= base_url('siswa/setor/' . $siswa['id']) ?>" method="post">
                                                    <div class="mb-3">
                                                        <label for="jumlah_setor" class="form-label">Jumlah Setoran</label>
                                                        <input type="number" class="form-control" id="jumlah_setor" name="jumlah" 
                                                               placeholder="Masukkan jumlah" min="1000" step="1000" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="keterangan_setor" class="form-label">Keterangan</label>
                                                        <input type="text" class="form-control" id="keterangan_setor" name="keterangan" 
                                                               placeholder="Keterangan (opsional)">
                                                    </div>
                                                    <button type="submit" class="btn btn-success w-100">
                                                        <i class="fas fa-save"></i> Setor
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header bg-danger text-white">
                                                <h6 class="mb-0"><i class="fas fa-minus"></i> Tarik Tabungan</h6>
                                            </div>
                                            <div class="card-body">
                                                <form action="<?= base_url('siswa/tarik/' . $siswa['id']) ?>" method="post">
                                                    <div class="mb-3">
                                                        <label for="jumlah_tarik" class="form-label">Jumlah Penarikan</label>
                                                        <input type="number" class="form-control" id="jumlah_tarik" name="jumlah" 
                                                               placeholder="Masukkan jumlah" min="1000" step="1000" 
                                                               max="<?= $saldo ?>" required>
                                                        <small class="text-muted">Maksimal: Rp <?= number_format($saldo, 0, ',', '.') ?></small>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="keterangan_tarik" class="form-label">Keterangan</label>
                                                        <input type="text" class="form-control" id="keterangan_tarik" name="keterangan" 
                                                               placeholder="Keterangan (opsional)">
                                                    </div>
                                                    <button type="submit" class="btn btn-danger w-100" 
                                                            <?= $saldo <= 0 ? 'disabled' : '' ?>>
                                                        <i class="fas fa-money-bill-wave"></i> Tarik
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Riwayat Transaksi Terbaru -->
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0"><i class="fas fa-history"></i> Riwayat Transaksi Terbaru</h6>
                                        <a href="<?= base_url('siswa/riwayat/' . $siswa['id']) ?>" class="btn btn-sm btn-outline-primary">
                                            Lihat Semua
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <?php if (empty($riwayatTerbaru)): ?>
                                            <div class="text-center py-3">
                                                <i class="fas fa-receipt fa-2x text-muted mb-2"></i>
                                                <p class="text-muted mb-0">Belum ada transaksi</p>
                                            </div>
                                        <?php else: ?>
                                            <div class="table-responsive">
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Tanggal</th>
                                                            <th>Jenis</th>
                                                            <th>Jumlah</th>
                                                            <th>Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($riwayatTerbaru as $r): ?>
                                                            <tr>
                                                                <td><?= date('d/m/Y', strtotime($r['tanggal'])) ?></td>
                                                                <td>
                                                                    <?php if ($r['jenis'] == 'setoran'): ?>
                                                                        <span class="badge bg-success">Setoran</span>
                                                                    <?php else: ?>
                                                                        <span class="badge bg-danger">Penarikan</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <span class="<?= $r['jenis'] == 'setoran' ? 'text-success' : 'text-danger' ?>">
                                                                        <?= $r['jenis'] == 'setoran' ? '+' : '-' ?> Rp <?= number_format($r['jumlah'], 0, ',', '.') ?>
                                                                    </span>
                                                                </td>
                                                                <td><?= esc($r['keterangan']) ?></td>
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

                        <!-- Action Buttons -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="<?= base_url('siswa') ?>" class="btn btn-secondary">
                                        <i class="fas fa-list"></i> Daftar Siswa
                                    </a>
                                    <div>
                                        <a href="<?= base_url('siswa/edit/' . $siswa['id']) ?>" class="btn btn-warning me-2">
                                            <i class="fas fa-edit"></i> Edit Data
                                        </a>
                                        <a href="<?= base_url('siswa/delete/' . $siswa['id']) ?>" 
                                           class="btn btn-danger"
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus data siswa <?= esc($siswa['nama']) ?>?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
