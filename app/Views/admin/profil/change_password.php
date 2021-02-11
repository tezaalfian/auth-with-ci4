<?= $this->extend('admin/profil/template'); ?>
<?= $this->section("profil"); ?>
<div class="row">
    <div class="col-md-6">
        <form action="/profil/changePassword" method="post">
            <?= csrf_field() ?>
            <div class="form-group">
                <input type="password" name="pass_old" class="form-control" placeholder="Password lama" required>
            </div>
            <div class="form-group">
                <input type="password" name="pass_new" class="form-control" placeholder="Password baru" required>
                <small class="text-danger"><i>* panjang minimal 8 karakter</i></small>
            </div>
            <div class="form-group">
                <input type="password" name="pass_confirm" class="form-control" placeholder="Ulangi password baru" required>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Ubah Password</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('myScript'); ?>
<script>
    myAlert("Profil");
</script>
<?= $this->endSection(); ?>