<?= $this->extend("admin/template"); ?>
<?= $this->section("content"); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h4>Role : <?= ucfirst($role['role']) ?></h4>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Menu</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form action="/users/user_akses/<?= $role['id']; ?>" method="post">
                                        <input type="hidden" name="status" value="true">
                                        <?php
                                        csrf_field();
                                        $no = 1;
                                        foreach ($menu as $key) : ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= ucfirst($key['menu']); ?></td>
                                                <td><input type="checkbox" name="menu[]" value="<?= $key['id']; ?>" <?= is_accessed($role['id'], $key['id']) ?>></td>
                                            </tr>
                                        <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-action">
                <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section("myScript"); ?>
<script>
    myAlert("User Akses");
</script>
<?= $this->endSection(); ?>