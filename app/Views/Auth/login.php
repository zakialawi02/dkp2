<?php $this->extend('Layouts/authTemplate'); ?>

<?php $this->section('title') ?>
<?= lang('Auth.loginTitle') ?> | <?= lang('Auth.loginTitleDesc') ?>
<?php $this->endSection() ?>

<?php $this->section('meta_description') ?>
<?= lang('Auth.loginTitleDesc'); ?>
<?php $this->endSection() ?>

<?php $this->section('meta_keywords') ?>
login, account, login form
<?php $this->endSection() ?>

<?php $this->section('og_title') ?>
<?= lang('Auth.loginTitleDesc') ?> | <?= lang('Auth.loginTitleDesc') ?>
<?php $this->endSection() ?>

<?php $this->section('css') ?>
<!-- Code here -->
<?php $this->endSection() ?>

<?php $this->section('content') ?>
<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

				<div class="d-flex justify-content-center py-3">
					<a class=" d-flex align-items-center w-auto" href="<?= base_url('/') ?>">
						<img src="<?= base_url('assets/img/logo navbar.png') ?>" alt="logo" class="" width="200">
						<span class="d-none d-lg-block"></span>
					</a>
				</div><!-- End Logo -->

				<div class="card mb-3">

					<div class="card-body">

						<div class="pb-2 pt-4">
							<h5 class="card-title fs-4 pb-0 text-center"><?= lang('Auth.loginTitle') ?></h5>
							<p class="small text-center"><?= lang('Auth.loginTitleDesc') ?></p>
						</div>

						<?= view('App\Views\Auth\_message_block') ?>

						<form class="row g-3" method="post" action="<?= url_to('login') ?>">
							<?= csrf_field() ?>

							<div class="col-12">
								<label class="form-label" for="login"><?= lang('Auth.emailOrUsername') ?></label>
								<input class="form-control" id="login" name="login" type="text" value="<?= old('login') ?>" placeholder="<?= lang('Auth.emailOrUsername') ?>" autofocus>
								<span class="text-danger small" role="alert">
									<?= session('errors.login') ?>
								</span>
							</div>

							<div class="col-12">
								<div class="row">
									<div class="col-6"> <label class="form-label" for="password"><?= lang('Auth.password') ?></label></div>
									<div class="col-6 text-end">
										<a class="small" href="<?= url_to('forgot') ?>"><?= lang('Auth.forgotYourPassword') ?></a>
									</div>
								</div>

								<input class="form-control" id="password" name="password" data-eye type="password" value="" placeholder="<?= lang('Auth.password') ?>">
								<span class="text-danger small" role="alert">
									<?= session('errors.password') ?>
								</span>
							</div>

							<?php if ($config->allowRemembering): ?>
								<div class="form-check col-12">
									<label class="form-check-label">
										<input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')) : ?> checked <?php endif ?>>
										<?= lang('Auth.rememberMe') ?>
									</label>
								</div>
							<?php endif; ?>


							<div class="col-12">
								<button class="btn btn-primary w-100" type="submit"><?= lang('Auth.loginAction') ?></button>
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