<!-- ======= Header ======= -->
<header class="header fixed-top d-flex align-items-center" id="header">

    <div class="d-flex align-items-center justify-content-between">
        <a class="logo d-flex align-items-center" href="<?= base_url('/dashboard') ?>">
            <img src="<?= base_url('assets/img/logo-crop.png') ?>" alt="">
            <span class="d-none d-lg-block">Dashboard</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" data-bs-toggle="dropdown" href="#">
                    <img class="rounded-circle"
                        src="<?= user()->profile_photo_path ?? 'https://placehold.co/100x100' ?>"
                        alt="Profile"
                        style="max-width: 100px; object-fit: cover; border-radius: 50%;"
                        width="40"
                        height="40"
                        onerror="this.onerror=null; this.src='https://placehold.co/100x100';">
                    <span class="d-none d-md-block dropdown-toggle ps-2"><?= user()->username ?? 'Guest' ?></span>
                </a><!-- End Profile Image Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?= user()->name ?? 'User Name' ?></h6>
                        <span><?= user()->username ?? 'Username' ?></span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="<?= route_to('admin.profile.index') ?>">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="<?= base_url('/account/settings') ?>">
                            <i class="bi bi-gear"></i>
                            <span>Account Settings</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="<?= base_url('/help') ?>">
                            <i class="bi bi-question-circle"></i>
                            <span>Need Help?</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <form class="d-flex align-items-center" method="GET" action="<?= base_url('logout'); ?>">
                            <?= csrf_field() ?>
                            <button class="dropdown-item d-flex align-items-center" type="submit">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->