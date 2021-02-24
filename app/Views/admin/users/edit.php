<?= $this->extend("layout/template"); ?>
<?= $this->section("content"); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Edit User</div>
                <button type="button" class="btn btn-danger btn-reset float-right" data-nilai="<?= $users['id']; ?>" data-toggle="modal" data-target="#modal-delete">Reset Password</button>
            </div>
            <div class="card-body">
                <?php if (session()->getFlashdata('newPassword')) : ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Password baru setelah direset : </strong><?= session()->getFlashdata('newPassword') ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <form action="/users/update/<?= $users['id']; ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group <?= $validation->hasError("username") ? "has-error" : "" ?>">
                                <label for="username">Username*</label>
                                <input type="text" class="form-control" name="username" placeholder="Username" value="<?= old('username') ? old('username') : $users["username"] ?>">
                                <small id="emailHelp" class="form-text text-muted"><?= $validation->getError("username"); ?></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group <?= $validation->hasError("nama") ? "has-error" : "" ?>">
                                <label for="nama">Nama Lengkap*</label>
                                <input type="text" class="form-control" name="nama" placeholder="Nama lengkap" value="<?= (old('nama')) ? old('nama') : $users["nama"] ?>">
                                <small id="emailHelp" class="form-text text-muted"><?= $validation->getError("nama"); ?></small>
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
                                <input type="email" class="form-control" name="email" placeholder="Email" value="<?= (old('email')) ? old('email') : $users["email"] ?>">
                                <small id="emailHelp" class="form-text text-muted"><?= $validation->getError("email"); ?></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group <?= $validation->hasError("no_hp") ? "has-error" : "" ?>">
                                <label for="no_hp">No Hp</label>
                                <input type="text" class="form-control" name="no_hp" placeholder="No hp" value="<?= (old('no_hp')) ? old('no_hp') : $users["no_hp"] ?>">
                                <small id="emailHelp" class="form-text text-muted"><?= $validation->getError("no_hp"); ?></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="avatar avatar-xxl">
                                        <img src="<?= CLOUD_URL . "w_200/" . $users['foto'] ?>" alt="..." class="img-thumbnail">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group <?= $validation->hasError("foto") ? "has-error" : "" ?>">
                                        <label for="foto">Foto</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="foto" name="foto" onchange="imagePreview()">
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                        <small id="emailHelp" class="form-text text-muted"><?= $validation->getError("foto"); ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Role</label>
                                <?php foreach ($role as $key) : ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="<?= $key['id']; ?>" name="role[]" <?= in_array($key['id'], $users['role']) ? "checked" : "" ?>>
                                        <label class="form-check-label"><?= $key['role']; ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" value="1" <?= $users['status'] == 1 ? "checked" : ""; ?>>
                                    <label class="form-check-label">Aktif</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" value="0" <?= $users['status'] == 0 ? "checked" : ""; ?>>
                                    <label class="form-check-label">Non-Aktif</label>
                                </div>
                            </div>
                        </div>
                    </div>
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
    $(document).on('click', '.btn-reset', function() {
        $('#modal-delete .modal-body p').text("Password akan direset dengan yang baru!");
        $("#modal-delete form").attr("action", `/users/reset/${$(this).data("nilai")}`);
    });
</script>
<?= $this->endSection(); ?>