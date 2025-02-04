<!-- Header -->
<nav class="navbar navbar-expand-lg  bg-white navbar-light fixed-top p-0 px-4 px-lg-5">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <h1 class="navbar-brand d-flex align-items-center m-0 text-primary navlogo"><img class="img-fluid navbar-logo me-2" src="<?= base_url('assets/img/logo navbar.png') ?>" alt="DINAS KELAUTAN DAN PERIKANAN PROVINSI KALIMANTAN TIMUR" style="max-width: 13rem;"></h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="bi bi-list"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/peta">Cek kesesuaian</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/data/modul">Modul</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/#about">Tentang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/kontak">Kontak</a>
                </li>
            </ul>
            <div class="ms-lg-3">
                <?php if (logged_in()): ?>
                    <a href="/dashboard" class="btn btn-outline-primary fw-bold">Dashboard</a>
                    <a href="<?= base_url('logout'); ?>" class="btn btn-outline-danger fw-bold">Log out</a>
                <?php else: ?>
                    <a href="/login" class="btn btn-outline-primary fw-bold">Login</a>
                <?php endif ?>
            </div>
        </div>
    </div>
</nav>