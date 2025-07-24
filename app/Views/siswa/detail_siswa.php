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
