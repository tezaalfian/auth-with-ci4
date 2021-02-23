<?= $this->extend("layout/template"); ?>
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
                <table id="kelas-table" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Kelas</th>
                            <th>Tingkat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kelas as $key) : ?>
                            <tr>
                                <td><?= strtoupper($key['nama_kelas']); ?></td>
                                <td><?= strtoupper($key['tingkat']); ?></td>
                                <td>
                                    <button data-toggle="modal" data-target="#modal-save" data-nilai="<?= $key['id']; ?>" class="btn btn-sm btn-success btn-edit"><i class="fa fa-edit"></i></button>
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
<div class="modal" tabindex="-1" id="modal-save">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/kelas/save" method="post">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label>Kelas*</label>
                        <input type="text" class="form-control" name="nama_kelas" id="nama_kelas" placeholder="Ex : 1" required>
                    </div>
                    <div class="form-group">
                        <label>Tingkat</label>
                        <select name="tingkat" id="tingkat" class="form-control">
                            <?php $tingkat = [1, 2, 3, 4, 5, 6] ?>
                            <?php foreach ($tingkat as $key) : ?>
                                <option><?= $key; ?></option>
                            <?php endforeach; ?>
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
</div>
<?= $this->endSection(); ?>

<?= $this->section("myScript"); ?>
<script>
    $('#kelas-table').DataTable();
    $(document).on('click', '.btn-delete', function() {
        $("#modal-delete form").attr("action", `/kelas/delete/${$(this).data("nilai")}`);
    });
    myAlert("Data Kelas");
    $(document).on('click', '#btn-add', function() {
        $('#modal-save form').attr("action", "/kelas/save");
        $("#nama_kelas").val("");
    });

    $(document).on("click", ".btn-edit", function() {
        $.ajax({
            url: `<?= '/api/administrator/kelasDetail/' ?>${$(this).data('nilai')}`,
            dataType: "json",
            success: function(result) {
                $('#modal-save form').attr("action", `/kelas/save/${result.id}`);
                $("#nama_kelas").val(result.nama_kelas);
                $("#tingkat").val(result.tingkat);
            }
        })
    });
</script>
<?= $this->endSection(); ?>