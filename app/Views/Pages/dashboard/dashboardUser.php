<?php $this->extend('Layouts/dashboardTemplate') ?>

<?php $this->section('title') ?>
<?= $title ?? ""; ?> • Dashboard
<?php $this->endSection() ?>

<?php $this->section('og_title') ?>
<?= $title ?? ""; ?> • Dashboard
<?php $this->endSection() ?>

<?php $this->section('css') ?>
<style>
    .list-group-item {
        padding: 4px;
    }
</style>
<?php $this->endSection() ?>


<?php $this->section('content') ?>

<?php $pendingIzin = []; ?>
<?php $terimaIzin = []; ?>
<?php $tolakIzin = []; ?>
<?php foreach ($userSubmitPermohonan as $submitedData) : ?>
    <?php if ($submitedData->stat_appv == 0) : ?>
        <?php $pendingIzin[] = $submitedData ?>
    <?php elseif ($submitedData->stat_appv == 1) : ?>
        <?php $terimaIzin[] = $submitedData ?>
    <?php else : ?>
        <?php $tolakIzin[] = $submitedData ?>
    <?php endif ?>
<?php endforeach ?>

<?php if (!empty($pendingIzin)) : ?>
    <?php $totalPending = count($pendingIzin); ?>
<?php else : ?>
    <?php $totalPending = 0 ?>
<?php endif ?>
<?php if (!empty($terimaIzin)) : ?>
    <?php $totalTerima = count($terimaIzin); ?>
<?php else : ?>
    <?php $totalTerima = 0 ?>
<?php endif ?>
<?php if (!empty($tolakIzin)) : ?>
    <?php $totalTolak = count($tolakIzin); ?>
<?php else : ?>
    <?php $totalTolak = 0 ?>
<?php endif ?>


<div class="row">

    <!-- Left side columns -->
    <div class="col-lg-3 small">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data</h5>

                <div class="">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <input type="radio" class="btn-check" name="status-submission" id="data-pending" autocomplete="off" checked>
                            <label class="btn btn-outline-info btn-sm w-100 d-flex justify-content-between align-items-center" for="data-pending">
                                Menunggu Balasan <span class="badge text-bg-light rounded-pill"><?= $totalPending; ?></span>
                            </label>
                        </li>
                        <li class="list-group-item">
                            <input type="radio" class="btn-check" name="status-submission" id="data-disetujui" autocomplete="off">
                            <label class="btn btn-outline-success btn-sm w-100 d-flex justify-content-between align-items-center" for="data-disetujui">
                                Disetujui <span class="badge bg-success rounded-pill"><?= $totalTerima; ?></span>
                            </label>
                        </li>
                        <li class="list-group-item">
                            <input type="radio" class="btn-check" name="status-submission" id="data-ditolak" autocomplete="off">
                            <label class="btn btn-outline-danger btn-sm w-100 d-flex justify-content-between align-items-center" for="data-ditolak">
                                Tidak Disetujui <span class="badge bg-danger rounded-pill"><?= $totalTolak; ?></span>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card d-none d-lg-flex">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                <img src="/img/user/<?= user()->user_image; ?>" alt="Profile" class="rounded-circle">
                <h3 class="m-1 mt-2 text-center fs-4"><?= user()->full_name; ?></h3>

                <?php if (in_groups('Admin' && 'SuperAdmin')) : ?>
                    <a class="badge bg-secondary"><?= user()->username; ?></a>
                <?php else : ?>
                    <a class="badge bg-info"><?= user()->username; ?></a>
                <?php endif ?>
            </div>
            <a href="/MyProfile" class="btn btn-sm btn-outline-primary m-4">Edit My Profile</a>
        </div>
    </div>


    <!-- Right side columns -->
    <div class="col-lg-9 small">
        <div class="row align-items-stretch">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Permohonan Saya</h5>

                        <!-- Sections -->
                        <div class="mt-3">
                            <div id="section-pending" class="status-section">
                                <div class="alert alert-info">Data yang sedang menunggu balasan.</div>

                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table" id="myTable" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">Tanggal Pengajuan</th>
                                                <th scope="col">NIK</th>
                                                <th scope="col">Nama Pemohon</th>
                                                <th scope="col">Jenis Kegiatan</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($pendingIzin)) : ?>
                                                <?php foreach ($pendingIzin as $pIzin) : ?>
                                                    <tr class="">
                                                        <td scope="row"><?= date('d M Y H:i:s', strtotime($pIzin->created_at)); ?></td>
                                                        <td><?= esc($pIzin->nik); ?></td>
                                                        <td><?= esc($pIzin->nama); ?></td>
                                                        <td><?= esc($pIzin->nama_kegiatan) ?>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="edit data">
                                                                <a href="<?= route_to('admin.permohonan.edit', $pIzin->id_perizinan); ?>" class="btn-sm btn btn-primary bi bi-pencil-square" role="button"></a>
                                                            </div>
                                                            <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="hapus data">
                                                                <form id="delete-form-<?= $pIzin->id_perizinan; ?>" class="deleteData" action="<?= route_to('admin.permohonan.destroy', $pIzin->id_perizinan); ?>" method="post">
                                                                    <?= csrf_field(); ?>
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <button type="submit" class="btn-sm btn btn-danger bi bi-trash" data-id="<?= $pIzin->id_perizinan; ?>"></button>
                                                                </form>
                                                            </div>
                                                            <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="lihat data">
                                                                <a type="button" role="button" href="<?= route_to('admin.permohonan.show', ($pIzin->stat_appv == '1') ? 'telah-disetujui' : (($pIzin->stat_appv == '0') ? 'menunggu-jawaban' : 'tidak-disetujui'), $pIzin->id_perizinan); ?>" class="btn-sm btn btn-secondary bi bi-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat" target="_blank"></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">Belum ada data</td>
                                                </tr>
                                            <?php endif ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div id="section-disetujui" class="status-section d-none">
                                <div class="alert alert-success">Data yang telah disetujui.</div>

                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table" id="myTable" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">Tanggal Pengajuan</th>
                                                <th scope="col">NIK</th>
                                                <th scope="col">Nama Pemohon</th>
                                                <th scope="col">Jenis Kegiatan</th>
                                                <th scope="col">Tanggal Dibalas</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($terimaIzin)) : ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">Belum ada data</td>
                                                </tr>
                                            <?php else : ?>
                                                <?php foreach ($terimaIzin as $tIzin) : ?>
                                                    <tr class="">
                                                        <td scope="row"><?= date('d M Y H:i:s', strtotime($tIzin->created_at)); ?></td>
                                                        <td><?= esc($tIzin->nik); ?></td>
                                                        <td><?= esc($tIzin->nama); ?></td>
                                                        <td><?= esc($tIzin->nama_kegiatan) ?>
                                                        <td><?= date('d M Y H:i:s', strtotime($tIzin->date_updated)); ?></td>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="edit data">
                                                                <a href="<?= route_to('admin.permohonan.edit', $tIzin->id_perizinan); ?>" class="btn-sm btn btn-primary bi bi-pencil-square" role="button"></a>
                                                            </div>
                                                            <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="hapus data">
                                                                <form id="delete-form-<?= $tIzin->id_perizinan; ?>" class="deleteData" action="<?= route_to('admin.permohonan.destroy', $tIzin->id_perizinan); ?>" method="post">
                                                                    <?= csrf_field(); ?>
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <button type="submit" class="btn-sm btn btn-danger bi bi-trash" data-id="<?= $tIzin->id_perizinan; ?>"></button>
                                                                </form>
                                                            </div>
                                                            <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="lihat data">
                                                                <a type="button" role="button" href="<?= route_to('admin.permohonan.show', ($tIzin->stat_appv == '1') ? 'telah-disetujui' : (($tIzin->stat_appv == '0') ? 'menunggu-jawaban' : 'tidak-disetujui'), $tIzin->id_perizinan); ?>" class="btn-sm btn btn-secondary bi bi-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat" target="_blank"></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="section-ditolak" class="status-section d-none">
                                <div class="alert alert-danger">Data yang tidak disetujui.</div>

                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Tanggal Pengajuan</th>
                                                <th scope="col">NIK</th>
                                                <th scope="col">Nama Pemohon</th>
                                                <th scope="col">Jenis Kegiatan</th>
                                                <th scope="col">Tanggal Dibalas</th>
                                                <th scope="col" style="width: 7rem;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($tolakIzin)) : ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">Belum ada data</td>
                                                </tr>
                                            <?php else : ?>
                                                <?php foreach ($tolakIzin as $sIzin) : ?>
                                                    <tr class="">
                                                        <td scope="row"><?= date('d M Y H:i:s', strtotime($sIzin->created_at)); ?></td>
                                                        <td><?= esc($sIzin->nik); ?></td>
                                                        <td><?= esc($sIzin->nama); ?></td>
                                                        <td><?= esc($sIzin->nama_kegiatan) ?></td>
                                                        <td><?= date('d M Y H:i:s', strtotime($sIzin->date_updated)); ?></td>

                                                        <td>
                                                            <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="edit data">
                                                                <a href="<?= route_to('admin.permohonan.edit', $sIzin->id_perizinan); ?>" class="btn-sm btn btn-primary bi bi-pencil-square" role="button"></a>
                                                            </div>
                                                            <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="hapus data">
                                                                <form id="delete-form-<?= $sIzin->id_perizinan; ?>" class="deleteData" action="<?= route_to('admin.permohonan.destroy', $sIzin->id_perizinan); ?>" method="post">
                                                                    <?= csrf_field(); ?>
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <button type="submit" class="btn-sm btn btn-danger bi bi-trash" data-id="<?= $sIzin->id_perizinan; ?>"></button>
                                                                </form>
                                                            </div>
                                                            <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="lihat data">
                                                                <a type="button" role="button" href="<?= route_to('admin.permohonan.show', ($sIzin->stat_appv == '1') ? 'telah-disetujui' : (($sIzin->stat_appv == '0') ? 'menunggu-jawaban' : 'tidak-disetujui'), $sIzin->id_perizinan); ?>" class="btn-sm btn btn-secondary bi bi-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat" target="_blank"></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>


<?php $this->section('javascript') ?>
<script>
    $(document).ready(function() {
        $('input[name="status-submission"]').change(function() {
            $('.status-section').addClass('d-none'); // Sembunyikan semua section

            if ($('#data-pending').is(':checked')) {
                $('#section-pending').removeClass('d-none');
            } else if ($('#data-disetujui').is(':checked')) {
                $('#section-disetujui').removeClass('d-none');
            } else if ($('#data-ditolak').is(':checked')) {
                $('#section-ditolak').removeClass('d-none');
            }
        });

        // Delete data
        $(".deleteData").submit(function(e) {
            e.preventDefault();
            const data = $(this).closest('form').attr('action');

            confirmDelete($(this), data);
        })

        function confirmDelete(form, data) {
            Swal.fire({
                title: "Are you sure you want to delete this record?",
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#74788d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonColor: '#5664d2',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.off("submit").submit();
                }
            });
        }
    });
</script>
<?php $this->endSection() ?>