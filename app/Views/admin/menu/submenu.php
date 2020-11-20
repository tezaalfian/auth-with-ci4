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
                    <table id="menu-table" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Menu</th>
                                <th>Title</th>
                                <th>URL</th>
                                <th>Icon</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($submenu as $key) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= ucfirst($key['menu']); ?></td>
                                    <td><?= $key['title']; ?></td>
                                    <td><?= $key['url']; ?></td>
                                    <td><?= $key['icon']; ?></td>
                                    <td><?= $key['is_active'] == 1 ? "Aktif" : "Non-Aktif" ?></td>
                                    <td>
                                        <button data-toggle="modal" data-target="#modal-save" data-nilai="<?= $key['id']; ?>" class="btn btn-sm btn-success btn-edit"><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-nilai="<?= $key['id']; ?>" data-toggle="modal" data-target="#modal-delete"><i class="fa fa-trash"></i></button>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/menu/save" method="post">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="menu">Menu</label>
                        <select name="menu" id="menu" class="form-control">
                            <?php foreach($menu as $key) : ?>
                                <option value="<?= $key['id']; ?>"><?= $key['menu']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="title" required>
                    </div>
                    <div class="form-group">
                        <label for="url">URL</label>
                        <input type="text" class="form-control" name="url" id="url" placeholder="url" required>
                    </div>
                    <div class="form-group">
                        <label for="icon">Icon</label>
                        <input type="text" class="form-control" name="icon" id="icon" placeholder="Icon" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1">Aktif</option>
                            <option value="0">Non-Aktif</option>
                        </select>
                    </div>
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
        $('#menu-table').DataTable();
        $(document).on('click', '.btn-delete', function() {
            $("#modal-delete form").attr("action", `/menu/deleteSub/${$(this).data("nilai")}`);
        });
        myAlert("Sub Menu");
        $(document).on('click', '#btn-add', function() {
            $('#modal-save form').attr("action", "/menu/saveSubmenu");
            $("#icon").val("");
            $("#title").val("");
            $("#url").val("");
            $("#status").val("1");
        });

        $(document).on("click", ".btn-edit", function() {
            $.ajax({
                url: `<?= '/api/menu/subMenu/' ?>${$(this).data('nilai')}`,
                dataType: "json",
                success: function(result) {
                    $('#modal-save form').attr("action", `/menu/saveSubmenu/${result.id}`);
                    $("#menu").val(result.menu_id);
                    $("#icon").val(result.icon);
                    $("#title").val(result.title);
                    $("#url").val(result.url);
                    $("#status").val(result.is_active);
                }
            })
        });
    </script>
    <?= $this->endSection(); ?>