<?php $this->extend('Layouts/authTemplate'); ?>

<?php $this->section('title') ?>
<?= lang('Auth.registerTitle') ?>
<?php $this->endSection() ?>

<?php $this->section('meta_description') ?>
<?= lang('Auth.registerTitleDesc'); ?>
<?php $this->endSection() ?>

<?php $this->section('meta_keywords') ?>
login, account, login form
<?php $this->endSection() ?>

<?php $this->section('og_title') ?>
<?= lang('Auth.registerTitle') ?> | <?= lang('Auth.registerTitleDesc') ?>
<?php $this->endSection() ?>

<?php $this->section('css') ?>
<!-- Code here -->
<?php $this->endSection() ?>

<?php $this->section('content') ?>
<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                <div class="d-flex justify-content-center py-4">
                    <a class="logo d-flex align-items-center w-auto" href="<?= base_url('/') ?>">
                        <img src="<?= base_url('assets/img/logo-crop.png') ?>" alt="">
                        <span class="d-none d-lg-block">NiceAdmin</span>
                    </a>
                </div><!-- End Logo -->

                <div class="card mb-3">

                    <div class="card-body">

                        <div class="pb-2 pt-4">
                            <h5 class="card-title fs-4 pb-0 text-center"><?= lang('Auth.registerTitle') ?></h5>
                            <p class="small text-center"><?= lang('Auth.registerTitleDesc') ?></p>
                        </div>

                        <?= view('App\Views\Auth\_message_block') ?>

                        <form class="row g-3" method="post" action="<?= url_to('register') ?>">
                            <?= csrf_field() ?>

                            <div class="col-12">
                                <label class="form-label" for="full_name"><?= lang('Auth.name') ?></label>
                                <input class="form-control" id="full_name" name="full_name" type="text" value="<?= old('full_name') ?>" placeholder="<?= lang('Auth.name') ?>" autofocus>
                                <span class="text-danger small" role="alert">
                                    <?= session('errors.full_name') ?>
                                </span>
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="email"><?= lang('Auth.email') ?></label>
                                <input class="form-control" id="email" name="email" type="email" value="<?= old('email') ?>" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" autofocus>
                                <span class="text-danger small" role="alert">
                                    <?= session('errors.email') ?>
                                </span>
                                <small id="emailHelp" class="d-block form-text text-muted"><?= lang('Auth.weNeverShare') ?></small>
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="username"><?= lang('Auth.username') ?></label>
                                <input class="form-control" id="username" name="username" type="text" value="<?= old('username') ?>" placeholder="<?= lang('Auth.username') ?>" autofocus>
                                <span class="text-danger small" role="alert">
                                    <?= session('errors.username') ?>
                                </span>
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="email"><?= lang('Auth.password') ?></label>
                                <input class="form-control" id="password" name="password" data-eye type="password" value="" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
                                <span class="text-danger small" role="alert">
                                    <?= session('errors.password') ?>
                                </span>
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="email"><?= lang('Auth.passwordConfirm') ?></label>
                                <input class="form-control" id="password" name="pass_confirm" data-eye type="password" value="" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
                                <span class="text-danger small" role="alert">
                                    <?= session('errors.pass_confirm') ?>
                                </span>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit"><?= lang('Auth.register') ?></button>
                            </div>

                            <div class="col-12">
                                <p class="small mb-0"><?= lang('Auth.alreadyRegistered') ?> <a href="<?= url_to('login') ?>"><?= lang('Auth.signIn') ?></a></p>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

</section>


<?php $this->section('javascript') ?>
<!-- Code here -->
<?php $this->endSection() ?>

<?php $this->endSection() ?>