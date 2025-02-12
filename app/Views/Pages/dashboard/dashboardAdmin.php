<?php $this->extend('Layouts/dashboardTemplate') ?>

<?php $this->section('title') ?>
<?= $title ?? ""; ?> • Dashboard
<?php $this->endSection() ?>

<?php $this->section('og_title') ?>
<?= $title ?? ""; ?> • Dashboard
<?php $this->endSection() ?>

<?php $this->section('css') ?>
<!-- Code here -->
<style>
    body {
        font-size: 0.875rem;
    }
</style>
<?php $this->endSection() ?>


<?php $this->section('content') ?>
<?php
$allData = $allDataPermohonan;
$allDataBaru = [];
$allDataSetujui = [];
$allDataTolak = [];
foreach ($allData as $key => $row) {
    if ($row->stat_appv == 0) {
        $allDataBaru[] = $row;
    } elseif ($row->stat_appv == 1) {
        $allDataSetujui[] = $row;
    } elseif ($row->stat_appv == 2) {
        $allDataTolak[] = $row;
    }
}
$allDataTerjawab = array_merge($allDataSetujui, $allDataTolak);
usort($allDataSetujui, function ($a, $b) {
    return strtotime($b->date_updated) - strtotime($a->date_updated);
});
usort($allDataTolak, function ($a, $b) {
    return strtotime($b->date_updated) - strtotime($a->date_updated);
});
usort($allDataTerjawab, function ($a, $b) {
    return strtotime($b->date_updated) - strtotime($a->date_updated);
});
$countAllPermohonan = count($allData);
// $countAllSetujui = count($allDataSetujui);
$countAllPending = count($allDataBaru);
// $countAllTolak = count($allDataTolak);
$allDataTerjawab = array_slice($allDataTerjawab, 0, 5);
$allDataBaru = array_slice($allDataBaru, 0, 5);
?>

<div class="row">

    <!-- Left side columns -->
    <div class="col-lg-8">
        <div class="row align-items-stretch">
            <!-- Total Permohonan Informasi -->
            <div class="col-xxl-4 col-md-6 align-items-stretch">
                <div class="card info-card h-100 mb-0">
                    <div class="card-body d-flex flex-column justify-content-around">
                        <h5 class="card-title">Total Permohonan Informasi</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-file-earmark-text-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6><?= $countAllPermohonan; ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Total Permohonan Informasi -->

            <!-- Menunggu Tindakan -->
            <div class="col-xxl-4 col-md-6 align-items-stretch">
                <div class="card info-card h-100 mb-0">
                    <div class="card-body d-flex flex-column justify-content-around">
                        <h5 class="card-title">Menunggu Tindakan</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                            <div class="ps-3">
                                <h6><?= $countAllPending; ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Menunggu Tindakan -->

            <!-- Total Pengguna -->
            <div class="col-xxl-4 col-xl-12 align-items-stretch">
                <div class="card info-card h-100 mb-0">
                    <div class="card-body d-flex flex-column justify-content-around">
                        <h5 class="card-title">Total Pengguna</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <h6><?= $countAllUser; ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Total Pengguna -->

            <!-- Daftar Permohonan Baru --->
            <div class="col-12 mt-2 pt-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Permohonan Baru<span> | 5 Terbaru</span></h5>
                        <div class="table-responsive">
                            <table class="table-hover table-striped table" id="myTable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col" style="min-width: 120px; max-width: 170px;">Tanggal Masuk</th>
                                        <th scope="col" style="min-width: 180px; max-width: 280px;">Nama Pemohon</th>
                                        <th scope="col" style="min-width: 200px; max-width: 300px;">Jenis Kegiatan</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($allDataBaru)) : ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Belum ada data</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach ($allDataBaru as $baru) : ?>
                                            <tr>
                                                <td><?= date('d M Y', strtotime($baru->created_at)); ?></td>
                                                <td><?= esc($baru->nama); ?></td>
                                                <td><?= esc($baru->nama_kegiatan); ?></td>
                                                <td><a type="button" role="button" href="/admin/data/permohonan/<?= ($baru->stat_appv == '0') ? 'menunggu-jawaban' : ''; ?>/lihat/<?= $baru->id_perizinan; ?>" class="btn-sm btn btn-info bi bi-binoculars" data-bs-toggle="tooltip" data-bs-placement="top" title="Periksa" target="_blank"></a></td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="<?= route_to('admin.permohonan.masuk'); ?>" class="btn btn-sm btn-primary">Lihat Lebih Banyak</a>
                    </div>
                </div>
            </div>

            <!-- Daftar Permohonan dijawab --->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Permohonan Dijawab<span> | 5 Terbaru</span></h5>
                        <div class="table-responsive">
                            <table class="table-hover table-striped table" id="myTable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col" style="min-width: 120px; max-width: 170px;">Tanggal Masuk</th>
                                        <th scope="col" style="min-width: 120px; max-width: 170px;">Tanggal Dibalas</th>
                                        <th scope="col" style="min-width: 180px; max-width: 280px;">Nama Pemohon</th>
                                        <th scope="col" style="min-width: 200px; max-width: 300px;">Jenis Kegiatan</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($allDataTerjawab as $jawab) : ?>
                                        <tr>
                                            <td><?= date('d M Y', strtotime($jawab->created_at)); ?></td>
                                            <td><?= date('d M Y', strtotime($jawab->date_updated)); ?></td>
                                            <td class="name"><?= esc($jawab->nama); ?></td>
                                            <td class="address"><?= esc($jawab->nama_kegiatan); ?></td>
                                            <td><span class="badge bg-<?= ($jawab->stat_appv == '1') ? 'success' : 'danger'; ?>"> <?= ($jawab->stat_appv == '1') ? 'Disetujui' : 'Tidak Disetujui'; ?> </span></td>
                                            <td>
                                                <a href="/dashboard/permohonan/view/1" class="btn btn-sm btn-primary" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="view data"><i class="bi bi-eye"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="<?= route_to('admin.permohonan.disetujui'); ?>" class="btn btn-sm btn-primary">Lihat Lebih Banyak</a>
                    </div>
                </div>
            </div>

        </div>
    </div><!-- End Left side columns -->

    <!-- Right side columns -->
    <div class="col-lg-4">

        <!-- Recent Users -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pengguna Baru <span>| 30 Hari Terakhir</span></h5>
                <table class="table-hover table-striped table" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">username</th>
                            <th scope="col">tanggal daftar</th>
                            <th scope="col">Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($userMonth)) : ?>
                            <?php foreach ($userMonth as $row) : ?>
                                <tr>
                                    <td><?= esc($row->username); ?></td>
                                    <td><?= date('d M Y', strtotime($row->created_at)); ?></td>
                                    <td><span class="badge bg-primary"><?= $row->name; ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="3" class="text-center small">Tidak ada data</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div><!-- End Recent Users -->
    </div>

</div>

<?php $this->endSection() ?>


<?php $this->section('javascript') ?>
<!-- Code here -->
<?php $this->endSection() ?>