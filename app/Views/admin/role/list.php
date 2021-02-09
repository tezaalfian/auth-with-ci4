<?= $this->extend("admin/template"); ?>
<?= $this->section("content"); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <button id="btn-add" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-save">
                        <i class="fa fa-plus"></i>
                        Tambah Data
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="role-table" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($role as $key) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= ucfirst($key['role']); ?></td>
                                    <td>
                                        <button data-toggle="modal" data-target="#modal-save" data-nilai="<?= $key['id']; ?>" class="btn btn-sm btn-success btn-edit"><i class="fa fa-edit"></i></button>
                                        <a href="/users/user_akses/<?= $key['id']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-info-circle"></i> Akses</a>
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
<div class="modal" tabindex="-1" id="modal-save">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Users Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/menu/save" method="post">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <input type="text" class="form-control" name="role" id="role" placeholder="role" required>
                    </div>
                    <!-- <div class="form-group">
                        <label for="icon">Icon</label>
                        <input type="text" class="form-control" name="icon" id="icon" placeholder="Icon" required>
                    </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <?= $this->endSection(); ?>

    <?= $this->section("myScript"); ?>
    <script>
        $('#role-table').DataTable();
        myAlert("Users Role");
        $(document).on('click', '#btn-add', function() {
            $('#modal-save form').attr("action", "/users/saveRole");
            $("#role").val("");
        });

        $(document).on("click", ".btn-edit", function() {
            $.ajax({
                url: `<?= '/api/users/getRole/' ?>${$(this).data('nilai')}`,
                dataType: "json",
                success: function(result) {
                    $('#modal-save form').attr("action", `/users/saveRole/${result.id}`);
                    $("#role").val(result.role);
                }
            })
        });
    </script>
    <?= $this->endSection(); ?>