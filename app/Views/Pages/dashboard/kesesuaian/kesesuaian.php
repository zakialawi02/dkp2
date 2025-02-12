<?php $this->extend('Layouts/dashboardTemplate') ?>

<?php $this->section('title') ?>
<?= $title ?? ""; ?> • Dashboard
<?php $this->endSection() ?>

<?php $this->section('og_title') ?>
<?= $title ?? ""; ?> • Dashboard
<?php $this->endSection() ?>

<?php $this->section('css') ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<?php $this->endSection() ?>


<?php $this->section('content') ?>
<?php $status_enum = ['diperbolehkan', 'diperbolehkan bersyarat', 'tidak diperbolehkan'] ?>

<div class="">
    <div class="mb-3">
        <h1 class="fs-3">Data Kesesuaian</h1>
    </div>

    <div class="card mb-3 py-3">
        <div class="card-body">
            <form id="tambahForm" method="post">
                <?= csrf_field(); ?>
                <div class="row">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="tambahZona" class="form-label">Zona</label>
                                        <select class="form-select select2" name="tambahZona" id="tambahZona" style="width: 100%;" required>
                                            <option></option>
                                            <?php foreach ($dataZona as $Z) : ?>
                                                <option value="<?= $Z->id_zona; ?>"><?= esc($Z->nama_zona); ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 tambahSubZona d-none">
                                    <div class="mb-3">
                                        <label for="tambahSubZona" class="form-label">Sub Zona</label>
                                        <select class="form-select form-select-sm" name="tambahSubZona" id="tambahSubZona" style="width: 100%;">
                                            <option value="Inti">Zona Inti</option>
                                            <option value="ZPT">Zona Pemanfaatan Terbatas</option>
                                            <option value="Lainnya">Zona Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="tambahKegiatan" class="form-label">Jenis Kegiatan</label>
                                        <select class="form-select select2" name="tambahKegiatan" id="tambahKegiatan" style="width: 100%;" required>
                                            <option> </option>
                                            <?php foreach ($dataKegiatan as $kg) : ?>
                                                <option value="<?= $kg->kode_kegiatan; ?>"><?= esc($kg->kode_kegiatan); ?> - <?= esc($kg->nama_kegiatan); ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="tambahStatus" class="form-label">Status Kesesuaian</label>
                                        <select class="form-select form-select-sm" name="tambahStatus" id="tambahStatus" required>
                                            <option>-- Pilih Status --</option>
                                            <?php foreach ($status_enum as $S) : ?>
                                                <option value="<?= $S; ?>"><?= $S; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-text" id="textHelp" style="color: red;"></div>
                    </div>
                    <div class="col-md-2 align-self-center">
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary" id="tambahkan">Tambahkan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card p-3">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae at est, pariatur veritatis dolor repudiandae.</p>
    </div>
</div>

<?php $this->endSection() ?>


<?php $this->section('javascript') ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $("#pilihZona").select2({
        placeholder: "Pilih Kegiatan",
        allowClear: true
    });
    $("#tambahZona").select2({
        placeholder: "Pilih Zona",
        allowClear: true
    });
    $("#tambahKegiatan").select2({
        placeholder: "Pilih Kegiatan",
        allowClear: true
    });

    let subzona;
    let strictZone = ["Kawasan Konservasi Lainnya", "Taman", "Kawasan Konservasi Maritim", "Pencadangan/Indikasi Kawasan Konservasi"];
    $("#tambahZona").change(function() {
        let valueZona = $("#tambahZona").find(":selected").text();
        if (strictZone.includes(valueZona)) {
            $(".tambahSubZona").removeClass("d-none");
            $("#tambahSubZona").prop("required", true);
            subzona = true;
        } else {
            $(".tambahSubZona").addClass("d-none");
            $("#tambahSubZona").prop("required", false);
            subzona = false;
        }
    });
    $("#tambahkan").click(function(e) {
        e.preventDefault();
        $("#tambahForm #textHelp").html("");
        let tambahZona = $("#tambahZona").val();
        let tambahSubZona = null;
        if (subzona) {
            tambahSubZona = $("#tambahSubZona").val();
        }
        let tambahKegiatan = $("#tambahKegiatan").val();
        let tambahStatus = $("#tambahStatus").val();
        let isValid = true;
        $("#tambahForm select[required]").each(function() {
            if ($(this).val() == "" || $(this).val() == null) {
                isValid = false;
                return;
            }
        });
        if (!isValid) {
            $("#tambahForm #textHelp").html("Harap isi semua kolom yang ada");
            return;
        }
        $.ajax({
            method: "POST",
            url: `/admin/tambahAturanKesesuaian`,
            data: {
                tambahZona,
                tambahSubZona,
                tambahKegiatan,
                tambahStatus
            },
            dataType: "html",
        }).done(function(response) {
            loadTabelKesesuaian();
            ToastSuccess.fire({
                icon: 'success',
                title: 'Berhasil Menambahkan Data'
            })
        }).fail(function(error) {
            console.error('Error:', error);
            ToastSuccess.fire({
                icon: 'error',
                title: 'Gagal Menambahkan Data'
            })
        });
    });
</script>
<?php $this->endSection() ?>