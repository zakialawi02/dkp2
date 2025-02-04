<?php $this->extend('Layouts/authTemplate'); ?>

<?php $this->section('title') ?>
<?= lang('Auth.forgotPasswordTitle') ?>
<?php $this->endSection() ?>

<?php $this->section('meta_description') ?>
<?= lang('Auth.forgotPasswordTitle'); ?>
<?php $this->endSection() ?>

<?php $this->section('meta_keywords') ?>
login, account, login form
<?php $this->endSection() ?>

<?php $this->section('og_title') ?>
<?= lang('Auth.forgotPasswordTitle') ?>
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
                            <h5 class="card-title fs-4 pb-0 text-center"><?= lang('Auth.forgotPasswordTitle') ?></h5>
                        </div>

                        <?= view('App\Views\Auth\_message_block') ?>

                        <div class="alert alert-success mb-4" role="alert"><?= lang('Auth.enterEmailForInstructions') ?></div>

                        <form class="row g-3" method="post" action="<?= url_to('forgot') ?>">
                            <?= csrf_field() ?>

                            <div class="col-12">
                                <label for="email"><?= lang('Auth.emailAddress') ?></label>
                                <input type="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>"
                                    name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>">
                                <div class="invalid-feedback">
                                    <?= session('errors.email') ?>
                                </div>
                            </div>



                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit"><?= lang('Auth.sendInstructions') ?></button>
                            </div>

                            <div class="col-12">
                                <p class="small mb-0"><?= lang('Auth.alreadyRegistered') ?> <a href="<?= url_to('login') ?>"><?= lang('Auth.signIn') ?></a></p>
                            </div>
                            <div class="col-12">
                                <p class="small mb-0"><?= lang('Auth.needAnAccount') ?> <a href="<?= url_to('register') ?>"><?= lang('Auth.createAccount') ?></a></p>
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