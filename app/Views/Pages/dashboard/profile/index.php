<?php $this->extend('Layouts/dashboardTemplate') ?>

<?php $this->section('title') ?>
Dashboardss
<?php $this->endSection() ?>

<?php $this->section('og_title') ?>
Dashboard
<?php $this->endSection() ?>

<?php $this->section('css') ?>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.min.css" rel="stylesheet">
<?php $this->endSection() ?>


<?php $this->section('content') ?>

<div class="row">

    <!-- Left side columns -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column align-items-center mt-2 pt-3 text-center">
                    <img class="img-fluid" id="current-photo" src="<?= base_url('assets/img/profile/' . user()->user_image) ?>" alt="Current Photo Profile" style="max-width: 130px; height: 100px; object-fit: cover; border-radius: 50%;" onerror="this.onerror=null; this.src='https://placehold.co/100x100';">
                    <div class="mt-3">
                        <h4><?= user()->full_name; ?></h4>
                        <p class="text-secondary mb-0"><?= user()->username; ?></p>
                        <p class="text-secondary mb-0"><?= user()->email; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Left side columns -->

    <!-- Right side columns -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body py-3">
                <h3 class="fs-4">Photo Profile</h3>
                <p>Update your account's photo profile</p>
                <div class="mt-3">
                    <form action="<?= route_to('admin.profile.updatePhoto'); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>

                        <div class="form-group mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="">
                                    <label for="current-photo">Current Photo Profile</label><br>
                                    <!-- Display the current photo profile here -->
                                    <img class="img-fluid" id="current-photo" src="<?= base_url('assets/img/profile/' . user()->user_image) ?>" alt="Current Photo Profile" style="max-width: 100px; height: 100px; object-fit: cover; border-radius: 50%;" onerror="this.onerror=null; this.src='https://placehold.co/100x100';">
                                </div>

                                <div class="ml-2" id="preview-block" style="display: none;">
                                    <label for="preview-photo">Preveiw New Photo</label><br>
                                    <!-- Space between current photo and the preview image -->
                                    <img class="img-fluid ms-3" id="preview" src="#" alt="Image Preview" style="max-width: 100px; height: 100px; object-fit: cover; border-radius: 50%;" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="photo_profile">New Photo Profile</label>
                            <input class="form-control" id="photo_profile" name="photo_profile" type="file" accept="image/*" />
                            <span class="text-danger small" role="alert">
                                <?= session('errors.photo_profile') ?>
                            </span>
                            <p class="text-danger" id="file-error" style="display: none;"></p> <!-- Error message for file size -->
                        </div>

                        <div class="d-flex align-items-baseline flex-row">
                            <button class="btn btn-primary" type="submit">Save</button>
                            <?php if (session('status') === 'photo-profile-updated'): ?>
                                <div class="alert alert-success" role="alert">
                                    Saved.
                                </div>
                            <?php endif ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body py-3">
                <h3 class="fs-4">Profile Information</h3>
                <p>Update your account's profile information and email address.</p>
                <div class="mt-3">
                    <form action="<?= route_to('admin.profile.update'); ?>" method="post">
                        <?= csrf_field(); ?>

                        <div class="form-group mb-3">
                            <label class="form-label" for="full_name"> Full Name </label>
                            <input class="form-control" id="full_name" name="full_name" type="text" value="<?= user()->full_name ?? old('full_name'); ?>" required>
                            <span class="text-danger small" role="alert">
                                <?= session('errors.full_name') ?>
                            </span>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" for="email"> Email address </label>
                            <input class="form-control" id="email" name="email" type="email" value="<?= user()->email ?? old('email'); ?>" required>
                            <span class="text-danger small" role="alert">
                                <?= session('errors.email') ?>
                            </span>
                        </div>
                        <?php if (session('status') === 'profile-updated'): ?>
                            <div class="small text-success mb-2">
                                <?= session('success') ?>
                            </div>
                        <?php endif ?>
                        <div class="mb-2">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body py-3">
                <h3 class="fs-4">Update Password</h3>
                <p>Ensure your account is using a long, random password to stay secure.</p>
                <div class="mt-3">
                    <form action="<?= route_to('admin.profile.updatePassword'); ?>" method="post">
                        <?= csrf_field(); ?>

                        <div class="form-group mb-3">
                            <label class="form-label" for="password"> Current Password </label>
                            <input class="form-control" id="password" name="current_password" type="password" data-eye value="" required>
                            <?php if (session('status') == "password-no-match"): ?>
                                <span class="text-danger small" role="alert">
                                    <?= session('errors') ?>
                                </span>
                            <?php endif ?>
                            <span class="text-danger small" role="alert">
                                <?= session('errors.current_password') ?>
                            </span>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" for="password"> New Password </label>
                            <input class="form-control" id="password" name="password" type="password" data-eye value="" required>
                            <span class="text-danger small" role="alert">
                                <?= session('errors.password') ?>
                            </span>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" for="pass_confirm"> Confirm Password </label>
                            <input class="form-control" id="password" name="pass_confirm" type="password" data-eye value="" required>
                            <span class="text-danger small" role="alert">
                                <?= session('errors.pass_confirm') ?>
                            </span>
                        </div>
                        <?php if (session('status') === 'password-updated'): ?>
                            <div class="small text-success mb-2">
                                <?= session('success') ?>
                            </div>
                        <?php endif ?>
                        <div class="mb-2">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body py-3">
                <h3 class="fs-4">Delete Account</h3>
                <p>
                    Once your account is deleted, all of its resources and data will be permanently deleted.
                    Before deleting your account, please download any data or information that you wish to retain.
                </p>
                <?php if (session('status') == "password-confirm-no-match"): ?>
                    <span class="text-danger small" role="alert">
                        <?= session('errors') ?>
                    </span>
                <?php endif ?>
                <div class="mt-3">
                    <div class="mb-2">
                        <!-- Button to trigger the modal -->
                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for password confirmation -->
        <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="<?= route_to('admin.profile.destroy') ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteAccountModalLabel">Confirm Account Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>To confirm the deletion of your account, please enter your password below:</p>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <?php if (session('status') == "password-confirm-no-match"): ?>
                                    <span class="text-danger small" role="alert">
                                        <?= session('errors') ?>
                                    </span>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>

<?php $this->endSection() ?>


<?php $this->section('javascript') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.all.min.js"></script>

<script>
    <?php if (session()->has('success')): ?>
        Swal.fire({
            icon: 'success',
            title: '<?= session('success') ?>',
            showConfirmButton: true,
            timer: 2000
        })
    <?php endif ?>
    <?php if (session()->has('error')): ?>
        Swal.fire({
            icon: 'error',
            title: '<?= session('error') ?>',
            showConfirmButton: true,
            timer: 2000
        })
    <?php endif ?>
    <?php if (session('status') == "password-confirm-no-match"): ?>
        Swal.fire({
            icon: 'error',
            title: '<?= session('errors') ?>',
            showConfirmButton: true,
            timer: 2000
        })
    <?php endif ?>
</script>

<script>
    // Get file input, image preview, and error message elements
    const fileInput = document.getElementById('photo_profile');
    const previewImage = document.getElementById('preview');
    const previewBlock = document.getElementById('preview-block');
    const fileError = document.getElementById('file-error');

    // Set maximum file size to 1MB (1MB = 1024 * 1024 bytes)
    const MAX_FILE_SIZE = 1 * 1024 * 1024;

    // Add an event listener for file selection
    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (file) {
            // Check if the file size exceeds the limit (1MB)
            if (file.size > MAX_FILE_SIZE) {
                // Display an error message and reset the input
                fileError.style.display = 'block';
                fileError.textContent = 'The file size should not exceed 1MB.';
                fileInput.value = ''; // Clear the input
                previewBlock.style.display = 'none'; // Hide the previous image preview
            } else {
                // Reset the error message
                fileError.style.display = 'none';

                // Create a FileReader to read the selected image
                const reader = new FileReader();

                // When the file is successfully read, update the preview image
                reader.onload = function(e) {
                    previewImage.src = e.target.result; // Set the source to the result from FileReader
                    previewBlock.style.display = 'block'; // Display the preview image
                };

                // Read the file as a data URL (base64)
                reader.readAsDataURL(file);
            }
        }
    });
</script>

<?php $this->endSection() ?>