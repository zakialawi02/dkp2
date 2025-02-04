<?php $this->extend('Layouts/dashboardTemplate') ?>

<?php $this->section('title') ?>
Dashboard
<?php $this->endSection() ?>

<?php $this->section('og_title') ?>
Dashboard
<?php $this->endSection() ?>

<?php $this->section('css') ?>
<!-- Code here -->
<?php $this->endSection() ?>


<?php $this->section('content') ?>

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
                                <h6>145</h6>
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
                                <h6>4</h6>
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
                                <h6>1244</h6>
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
                                        <th scope="col">No. Permohonan</th>
                                        <th scope="col" style="min-width: 120px; max-width: 170px;">Tanggal Masuk</th>
                                        <th scope="col" style="min-width: 180px; max-width: 280px;">Nama Pemohon</th>
                                        <th scope="col" style="min-width: 200px; max-width: 300px;">Jenis Kegiatan</th>
                                        <th scope="col" style="min-width: 120px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>2023-10-02</td>
                                        <td>Jane Doe</td>
                                        <td>Usaha pembudidayaan ikan laut (kerapu, kakap, baronang)</td>
                                        <td>
                                            <a href="/dashboard/permohonan/edit/1" class="btn btn-sm btn-warning"><i class="bi bi-binoculars"></i> Periksa</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>2023-10-03</td>
                                        <td>Robert Smith</td>
                                        <td>Jasa Wisata Tirta (bahari)</td>
                                        <td>
                                            <a href="/dashboard/permohonan/edit/1" class="btn btn-sm btn-warning"><i class="bi bi-binoculars"></i> Periksa</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="#" class="btn btn-sm btn-primary">Lihat Lebih Banyak</a>
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
                                        <th scope="col">No. Permohonan</th>
                                        <th scope="col" style="min-width: 120px; max-width: 170px;">Tanggal Masuk</th>
                                        <th scope="col" style="min-width: 120px; max-width: 170px;">Tanggal Dibalas</th>
                                        <th scope="col" style="min-width: 180px; max-width: 280px;">Nama Pemohon</th>
                                        <th scope="col" style="min-width: 200px; max-width: 300px;">Jenis Kegiatan</th>
                                        <th scope="col" style="min-width: 120px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>2023-10-02</td>
                                        <td>2023-10-03</td>
                                        <td>Jane Doe</td>
                                        <td>Usaha pembudidayaan ikan laut (kerapu, kakap, baronang)</td>
                                        <td>
                                            <a href="/dashboard/permohonan/view/1" class="btn btn-sm btn-primary" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="view data"><i class="bi bi-eye"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>2023-10-03</td>
                                        <td>2023-10-04</td>
                                        <td>Robert Smith</td>
                                        <td>Jasa Wisata Tirta (bahari)</td>
                                        <td>
                                            <a href="/dashboard/permohonan/view/1" class="btn btn-sm btn-primary" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="view data"><i class="bi bi-eye"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="#" class="btn btn-sm btn-primary">Lihat Lebih Banyak</a>
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
                        <tr>
                            <td>john_doe</td>
                            <td>2023-09-15</td>
                            <td><span class="badge bg-primary">Admin</span></td>
                        </tr>
                        <tr>
                            <td>jane_smith</td>
                            <td>2023-09-20</td>
                            <td><span class="badge bg-secondary">User</span></td>
                        </tr>
                        <tr>
                            <td>alice_jones</td>
                            <td>2023-09-25</td>
                            <td><span class="badge bg-success">Editor</span></td>
                        </tr>
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