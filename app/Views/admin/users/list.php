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
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Role</label>
                            <select id="role" class="form-control">
                                <option value="0">All</option>
                                <?php foreach ($role as $key) : ?>
                                    <option value="<?= $key['id']; ?>"><?= ucwords($key['role']); ?></option>
                                <?php endforeach; ?>
                                <option value="null">Donatur</option>
                            </select>
                        </div>
                    </div>
                </div>
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
    $(document).on('click', '.btn-delete', function() {
        $("#modal-delete form").attr("action", `/users/delete/${$(this).data("nilai")}`);
    });
    myAlert("Data User");
    loadTable();

    function loadTable() {
        $('#users-table').DataTable().destroy();
        const input = {};
        if ($('#role').val() != 0) {
            input.role_id = $('#role').val() == 'null' ? null : $('#role').val();
        }
        console.log(input);
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: `/users/listUsers`,
                data: input,
                type: "get"
            }
        });
    }
    $(document).on('change', '#role', function() {
        loadTable();
    });
</script>
<?= $this->endSection(); ?>