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
                        <a href="<?= base_url('siswa') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        <?php if (session()->has('validation')): ?>
                            <div class="alert alert-danger">
                                <h6>Terjadi kesalahan:</h6>
                                <ul class="mb-0">
                                    <?php foreach (session('validation')->getErrors() as $error): ?>
                                        <li><?= $error ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="<?= isset($siswa) ? base_url('siswa/update/' . $siswa['id']) : base_url('siswa/store') ?>" 
                              method="post" enctype="multipart/form-data">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control <?= session('validation') && session('validation')->hasError('nama') ? 'is-invalid' : '' ?>" 
                                               id="nama" 
                                               name="nama" 
                                               value="<?= old('nama', isset($siswa) ? $siswa['nama'] : '') ?>" 
                                               required>
                                        <?php if (session('validation') && session('validation')->hasError('nama')): ?>
                                            <div class="invalid-feedback">
                                                <?= session('validation')->getError('nama') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select class="form-select <?= session('validation') && session('validation')->hasError('jenis_kelamin') ? 'is-invalid' : '' ?>" 
                                                id="jenis_kelamin" 
                                                name="jenis_kelamin" 
                                                required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki" <?= old('jenis_kelamin', isset($siswa) ? $siswa['jenis_kelamin'] : '') == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                            <option value="Perempuan" <?= old('jenis_kelamin', isset($siswa) ? $siswa['jenis_kelamin'] : '') == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                                        </select>
                                        <?php if (session('validation') && session('validation')->hasError('jenis_kelamin')): ?>
                                            <div class="invalid-feedback">
                                                <?= session('validation')->getError('jenis_kelamin') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control <?= session('validation') && session('validation')->hasError('tempat_lahir') ? 'is-invalid' : '' ?>" 
                                               id="tempat_lahir" 
                                               name="tempat_lahir" 
                                               value="<?= old('tempat_lahir', isset($siswa) ? $siswa['tempat_lahir'] : '') ?>" 
                                               required>
                                        <?php if (session('validation') && session('validation')->hasError('tempat_lahir')): ?>
                                            <div class="invalid-feedback">
                                                <?= session('validation')->getError('tempat_lahir') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <input type="date" 
                                               class="form-control <?= session('validation') && session('validation')->hasError('tanggal_lahir') ? 'is-invalid' : '' ?>" 
                                               id="tanggal_lahir" 
                                               name="tanggal_lahir" 
                                               value="<?= old('tanggal_lahir', isset($siswa) ? $siswa['tanggal_lahir'] : '') ?>" 
                                               required>
                                        <?php if (session('validation') && session('validation')->hasError('tanggal_lahir')): ?>
                                            <div class="invalid-feedback">
                                                <?= session('validation')->getError('tanggal_lahir') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                <textarea class="form-control <?= session('validation') && session('validation')->hasError('alamat') ? 'is-invalid' : '' ?>" 
                                          id="alamat" 
                                          name="alamat" 
                                          rows="3" 
                                          required><?= old('alamat', isset($siswa) ? $siswa['alamat'] : '') ?></textarea>
                                <?php if (session('validation') && session('validation')->hasError('alamat')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('validation')->getError('alamat') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_bergabung" class="form-label">Tanggal Bergabung <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control <?= session('validation') && session('validation')->hasError('tanggal_bergabung') ? 'is-invalid' : '' ?>" 
                                       id="tanggal_bergabung" 
                                       name="tanggal_bergabung" 
                                       value="<?= old('tanggal_bergabung', isset($siswa) ? $siswa['tanggal_bergabung'] : date('Y-m-d')) ?>" 
                                       required>
                                <?php if (session('validation') && session('validation')->hasError('tanggal_bergabung')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('validation')->getError('tanggal_bergabung') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="foto" class="form-label">
                                    Foto <?= !isset($siswa) ? '<span class="text-danger">*</span>' : '' ?>
                                </label>
                                <?php if (isset($siswa) && $siswa['foto']): ?>
                                    <div class="mb-2">
                                        <img src="<?= base_url('uploads/siswa/' . $siswa['foto']) ?>" 
                                             alt="Foto saat ini" 
                                             class="img-thumbnail" 
                                             style="max-width: 150px;">
                                        <small class="text-muted d-block">Foto saat ini</small>
                                    </div>
                                <?php endif; ?>
                                <input type="file" 
                                       class="form-control <?= session('validation') && session('validation')->hasError('foto') ? 'is-invalid' : '' ?>" 
                                       id="foto" 
                                       name="foto" 
                                       accept="image/*"
                                       <?= !isset($siswa) ? 'required' : '' ?>>
                                <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB.</small>
                                <?php if (session('validation') && session('validation')->hasError('foto')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('validation')->getError('foto') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="<?= base_url('siswa') ?>" class="btn btn-secondary me-md-2">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> <?= isset($siswa) ? 'Update' : 'Simpan' ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
