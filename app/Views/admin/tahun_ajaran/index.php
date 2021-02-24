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
                <h5>Tahun Ajaran Aktif, adalah tahun dimana proses akademik dan keseluruhan sistem dijalankan. mengubah data tahun ajaran akan berdampak secara GLOBAL pada sistem.</h5>
                <table id="tahun-table" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tahun</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tahun as $key) : ?>
                            <tr>
                                <td><?= $key['tingkat']; ?></td>
                                <td><?= $key['tahun'] ?></td>
                                <td><?= $key['status'] == 1 ? "<span class='badge badge-success'>Aktif</span>" : "<span class='badge badge-danger'>Non-Aktif</span>"; ?></td>
                                <td>
                                    <?php if ($key['status'] == 0) : ?>
                                        <button data-toggle="modal" data-target="#modal-confirm" data-nilai="<?= $key['id']; ?>" class="btn btn-sm btn-primary btn-confirm"><i class="fas fa-cog"></i> Set Aktif</button>
                                    <?php else : ?>
                                        <span class="btn btn-sm btn-success"><i class="fas fa-check-square"></i></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-confirm" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Apakah kamu yakin ?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Tahun ajaran ini akan aktif dan menonaktifkan tahun yang lainnya! </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                <form action="/tahunajaran/setAktif" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="ta_id" id="ta_id">
                    <button type="submit" class="btn btn-sm btn-primary">Lanjutkan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section("myScript"); ?>
<script>
    $('#tahun-table').DataTable();
    myAlert("Tahun Ajaran");
    $(document).on("click", ".btn-confirm", function() {
        $('#ta_id').val($(this).data('nilai'));
    });
</script>
<?= $this->endSection(); ?>