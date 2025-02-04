<!-- ======= Sidebar ======= -->
<aside class="sidebar" id="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/') ?>">
                <i class="bi bi-house-door-fill"></i>
                <span>Home</span>
            </a>
            <a class="nav-link <?= uri_string() === 'dashboard' ? 'active' : '' ?>" href="<?= url_to('dashboard') ?>">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
            <a class="nav-link <?= uri_string() === 'peta' ? 'active' : '' ?>" href="<?= url_to('dashboard') ?>">
                <i class="bi bi-pin-map-fill"></i>
                <span>Cek Kesesuaian</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-heading">Data Permohonan</li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#ruang-laut-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-file-earmark-text"></i><span>Informasi Ruang Laut</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul class="nav-content collapse" id="ruang-laut-nav" data-bs-parent="#sidebar-nav">
                <li>
                    <a class="<?= uri_string() === 'dashboard/permohonan/disetujui' ? 'active' : '' ?>" href="<?= url_to('admin.permohonan.disetujui'); ?>">
                        <i class="bi bi-circle"></i><span>Permohonan Disetujui</span>
                    </a>
                </li>
                <li>
                    <a class="<?= uri_string() === 'dashboard/permohonan/tidak-disetujui' ? 'active' : '' ?>" href="<?= url_to('admin.permohonan.tidakDisetujui'); ?>">
                        <i class="bi bi-circle"></i><span>Permohonan Tidak Disetujui</span>
                    </a>
                </li>
            </ul>
        </li>
        <a class="nav-link <?= uri_string() === 'dashboard/permohonan/masuk' ? 'active' : '' ?>" href="<?= url_to('admin.permohonan.masuk') ?>">
            <i class="bi bi-hourglass-split"></i>
            <span>Permohonan Masuk/Baru</span>
        </a>

        <li class="nav-heading">Management</li>


        <li class="nav-item">
            <a class="nav-link <?= uri_string() === 'dashboard/modul' ? 'active' : '' ?>" href="<?= url_to('admin.modul.index'); ?>">
                <i class="bi bi-file-earmark-pdf-fill"></i>
                <span>Modul</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#kesesuaian-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-collection"></i><span>Kesesuaian</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul class="nav-content collapse" id="kesesuaian-nav" data-bs-parent="#sidebar-nav">
                <li>
                    <a class="<?= uri_string() === 'dashboard/kesesuaian/data/kegiatan' ? 'active' : '' ?>" href="<?= url_to('admin.kesesuaian.kegiatan'); ?>">
                        <i class="bi bi-circle"></i><span>Data Kegiatan</span>
                    </a>
                </li>
                <li>
                    <a class="<?= uri_string() === 'dashboard/kesesuaian/data/zona' ? 'active' : '' ?>" href="<?= url_to('admin.kesesuaian.zona'); ?>">
                        <i class="bi bi-circle"></i><span>Data Zona</span>
                    </a>
                </li>
                <li>
                    <a class="<?= uri_string() === 'dashboard/kesesuaian/data/kawasan' ? 'active' : '' ?>" href="<?= url_to('admin.kesesuaian.kawasan'); ?>">
                        <i class="bi bi-circle"></i><span>Data Kawasan</span>
                    </a>
                </li>
                <li>
                    <a class="<?= uri_string() === 'dashboard/kesesuaian/data/kesesuaian' ? 'active' : '' ?>" href="<?= url_to('admin.kesesuaian.kesesuaian'); ?>">
                        <i class="bi bi-circle"></i><span>Data Kesesuaian</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= uri_string() === 'dashboard/users' ? 'active' : '' ?>" href="<?= url_to('admin.users.index'); ?>">
                <i class="bi bi-people-fill"></i>
                <span>Users</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= uri_string() === 'dashboard/setting/view-peta' ? 'active' : '' ?>" href="<?= url_to('admin.setting.viewPeta'); ?>">
                <i class="bi bi-sliders"></i>
                <span>Peta</span>
            </a>
        </li>
    </ul>

</aside><!-- End Sidebar -->