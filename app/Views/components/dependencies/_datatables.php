<?= $this->section('css'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.4.47/css/materialdesignicons.css" rel="stylesheet" integrity="sha512-/bZeHtNhCNHsuODhywlz53PIfvrJbAmm7MUXWle/f8ro40mVNkPLz0I5VdiYyV030zepbBdMIty0Z3PRwjnfmg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="<?= base_url('assets/vendor/datatables.net-bs5/dataTables.bootstrap5.css'); ?>" rel="stylesheet">
<?= $this->endSection(); ?>

<?= $this->section('javascript'); ?>
<script src="<?= base_url('assets/vendor/datatables.net/jquery.dataTables.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/datatables.net-bs5/dataTables.bootstrap5.js'); ?>"></script>
<?= $this->endSection(); ?>