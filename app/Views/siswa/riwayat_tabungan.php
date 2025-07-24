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
                        <a href="<?= base_url('siswa/detail/' . $siswa['id']) ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Detail
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Informasi Siswa -->
                        <div class="row mb-4">
                            <div class="col-md-3 text-center">
                                <?php if ($siswa['foto']): ?>
                                    <img src="<?= base_url('uploads/siswa/' . $siswa['foto']) ?>" 
                                         alt="Foto <?= $siswa['nama'] ?>" 
                                         class="img-fluid rounded-circle border border-3 border-primary" 
                                         style="width: 120px; height: 120px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center border border-3 border-primary mx-auto" 
                                         style="width: 120px; height: 120px;">
                                        <i class="fas fa-user fa-3x text-white"></i>
                                    </div>
                                <?php endif; ?>
                                <h5 class="mt-2 mb-0"><?= esc($siswa['nama']) ?></h5>
                                <small class="text-muted">#<?= str_pad($siswa['id'], 4, '0', STR_PAD_LEFT) ?></small>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card bg-success text-white">
                                            <div class="card-body text-center">
                                                <i class="fas fa-wallet fa-2x mb-2"></i>
                                                <h5>Saldo Saat Ini</h5>
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
                            </div>
                        </div>

                        <!-- Riwayat Transaksi -->
                        <h5 class="mb-3">
                            <i class="fas fa-history text-primary"></i> Riwayat Transaksi
                        </h5>

                        <?php if (empty($riwayat)): ?>
                            <div class="text-center py-4">
                                <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada transaksi</h5>
                                <p class="text-muted">Riwayat transaksi akan muncul di sini</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Jenis</th>
                                            <th>Jumlah</th>
                                            <th>Keterangan</th>
                                            <th>Waktu Input</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($riwayat as $index => $r): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= date('d/m/Y', strtotime($r['tanggal'])) ?></td>
                                                <td>
                                                    <?php if ($r['jenis'] == 'setoran'): ?>
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-arrow-up"></i> Setoran
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-arrow-down"></i> Penarikan
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <strong class="<?= $r['jenis'] == 'setoran' ? 'text-success' : 'text-danger' ?>">
                                                        <?= $r['jenis'] == 'setoran' ? '+' : '-' ?> Rp <?= number_format($r['jumlah'], 0, ',', '.') ?>
                                                    </strong>
                                                </td>
                                                <td><?= esc($r['keterangan']) ?></td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?= date('d/m/Y H:i', strtotime($r['created_at'])) ?>
                                                    </small>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>

                        <!-- Action Buttons -->
                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <a href="<?= base_url('siswa/detail/' . $siswa['id']) ?>" class="btn btn-secondary me-2">
                                    <i class="fas fa-arrow-left"></i> Kembali ke Detail
                                </a>
                                <a href="<?= base_url('siswa') ?>" class="btn btn-primary">
                                    <i class="fas fa-list"></i> Daftar Siswa
                                </a>
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
