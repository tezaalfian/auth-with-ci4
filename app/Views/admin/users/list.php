<?= $this->extend("admin/template"); ?>
<?= $this->section("content"); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <a href="/users/add" class="btn btn-primary" style="color: white;">
                        <i class="fa fa-plus"></i>
                        Tambah Data
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="users-table" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No Hp</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($users as $key) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $key['username']; ?></td>
                                    <td><?= ucfirst($key['nama']); ?></td>
                                    <td><?= $key['email']; ?></td>
                                    <td><?= $key['no_hp']; ?></td>
                                    <td>
                                        <a href="/users/edit/<?= $key['id']; ?>" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>
                                        <button style="display:inline;" type="button" class="btn btn-sm btn-danger btn-delete" data-nilai="<?= $key['id']; ?>" data-toggle="modal" data-target="#modal-delete"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section("myScript"); ?>
<script>
    $('#users-table').DataTable({});
    $(document).on('click','.btn-delete',function(){
        $("#modal-delete form").attr("action",`/users/delete/${$(this).data("nilai")}`);
    });
    myAlert("Data User");
</script>
<?= $this->endSection(); ?>