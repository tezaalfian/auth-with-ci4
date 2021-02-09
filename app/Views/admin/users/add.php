<?= $this->extend("admin/template"); ?>
<?= $this->section("content"); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Tambah User</div>
            </div>
            <div class="card-body">
                <form action="/users/save" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group <?= $validation->hasError("username") ? "has-error" : "" ?>">
                                <label for="username">Username*</label>
                                <input type="text" class="form-control" name="username" placeholder="Username" value="<?= old("username") ?>">
                                <small id="emailHelp" class="form-text text-muted"><?= $validation->getError("username"); ?></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group <?= $validation->hasError("nama") ? "has-error" : "" ?>">
                                <label for="nama">Nama Lengkap*</label>
                                <input type="text" class="form-control" name="nama" placeholder="Nama lengkap" value="<?= old("nama") ?>">
                                <small id="emailHelp" class="form-text text-muted"><?= $validation->getError("nama"); ?></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group <?= $validation->hasError("password") ? "has-error" : "" ?>">
                                <label for="password">Password*</label>
                                <input type="password" class="form-control" name="password" placeholder="Password">
                                <small id="emailHelp" class="form-text text-muted"><?= $validation->getError("password"); ?></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group <?= $validation->hasError("pass_confirm") ? "has-error" : "" ?>">
                                <label for="pass_confirm">Ulangi Password*</label>
                                <input type="password" class="form-control" name="pass_confirm" placeholder="Ulangi password">
                                <small id="emailHelp" class="form-text text-muted"><?= $validation->getError("pass_confirm"); ?></small>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                                <div class="form-check">
                                    <label>Jenis Kelamin</label><br>
									<label class="form-radio-label">
										<input class="form-radio-input" type="radio" name="jk" value="L">
										<span class="form-radio-sign">Laki - Laki</span>
									</label>
									<label class="form-radio-label ml-3">
										<input class="form-radio-input" type="radio" name="jk" value="P">
										<span class="form-radio-sign">Perempuan</span>
                                    </label>
                                </div>
                            </div> -->
                        <div class="col-md-6">
                            <div class="form-group <?= $validation->hasError("email") ? "has-error" : "" ?>">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email" value="<?= old("email") ?>">
                                <small id="emailHelp" class="form-text text-muted"><?= $validation->getError("email"); ?></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group <?= $validation->hasError("no_hp") ? "has-error" : "" ?>">
                                <label for="no_hp">No Hp</label>
                                <input type="text" class="form-control" name="no_hp" placeholder="No hp" value="<?= old("no_hp") ?>">
                                <small id="emailHelp" class="form-text text-muted"><?= $validation->getError("no_hp"); ?></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group <?= $validation->hasError("foto") ? "has-error" : "" ?>">
                                <label for="foto">Foto</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="foto" name="foto" value="<?= old("foto") ?>" onchange="imagePreview()">
                                    <label class="custom-file-label">Choose file</label>
                                </div>
                                <small id="emailHelp" class="form-text text-muted"><?= $validation->getError("foto"); ?></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Role</label>
                                <?php foreach ($role as $key) : ?>
                                    <div class="form-check" style="padding: 0;">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" value="<?= $key['id']; ?>" name="role[]">
                                            <span class="form-check-sign"><?= $key['role']; ?></span>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="card-action">
                <button class="btn btn-primary" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section("myScript"); ?>
<script>
    function imagePreview() {
        const foto = document.querySelector("#foto");
        const label = document.querySelector(".custom-file-label");
        label.textContent = foto.files[0].name;
    }
    myAlert("Data User");
</script>
<?= $this->endSection(); ?>