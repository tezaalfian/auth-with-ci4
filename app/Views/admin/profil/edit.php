<?= $this->extend('admin/profil/template'); ?>
<?= $this->section("profil"); ?>
<div class="row">
    <div class="col-md-4 text-center">
        <form action="/dashboard/profil" method="post" enctype="multipart/form-data">
            <img src="<?= CLOUD_URL . "w_200/" . $user['foto'] ?>" alt="Photo Profile" class="img-thumbnail">
            <div class="form-group">
                <div class="custom-file my-2">
                    <input type="file" class="custom-file-input" id="foto" name="foto" onchange="imagePreview()">
                    <label class="custom-file-label">Choose file</label>
                </div>
            </div>
    </div>
    <div class="col-md-8">
        </form>
    </div>
</div>
<?= $this->endSection(); ?>