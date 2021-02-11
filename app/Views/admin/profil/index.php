<?= $this->extend('admin/profil/template'); ?>
<?= $this->section("profil"); ?>
<div class="row">
    <div class="col-md-4 text-center">
        <img src="<?= CLOUD_URL . "w_200/" . $user['foto'] ?>" alt="Photo Profile" class="img-thumbnail">
    </div>
    <div class="col-md-8">
        <div class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <th>Username : </th>
                    <td><?= $user['username']; ?></td>
                </tr>
                <tr>
                    <th>Nama : </th>
                    <td><?= $user['nama']; ?></td>
                </tr>
                <tr>
                    <th>Email : </th>
                    <td><?= $user['email']; ?></td>
                </tr>
                <tr>
                    <th>No Hp : </th>
                    <td><?= $user['no_hp']; ?></td>
                </tr>
                <tr>
                    <th>Bergabung sejak :</th>
                    <td><?= my_date_format("d M Y", $user['created_at']) ?></td>
                </tr>
                <tr>
                    <th>Terakhir diupdate :</th>
                    <td><?= my_date_format("d M Y", $user['updated_at']) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>