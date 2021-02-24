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
                <h5 class="mb-3 font-weight-bold">Data Rombongan Belajar Tahun Ajaran <?= tahun_aktif()['tahun'] ?></h5>
                <div class="table-responsive">
                    <table id="rombel-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kelas</th>
                                <th>Rombel</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            $kelas_id = "";
                            foreach ($rombel as $key) : ?>
                                <tr>
                                    <?php if ($no == 1 || $kelas_id != $key['kelas_id']) : ?>
                                        <td rowspan="<?= $key['jumlah']; ?>"><?= $no++; ?></td>
                                        <td rowspan="<?= $key['jumlah']; ?>"><?= $key['nama_kelas']; ?></td>
                                    <?php endif; ?>
                                    <td><?= $key['nama_rombel']; ?></td>
                                    <td>
                                        <button data-toggle="modal" data-target="#modal-save" data-nilai="<?= $key['id']; ?>" class="btn btn-sm btn-success btn-edit"><i class="fa fa-edit"></i></button>
                                        <button style="display:inline;" type="button" class="btn btn-sm btn-danger btn-delete" data-nilai="<?= $key['id']; ?>" data-toggle="modal" data-target="#modal-delete"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            <?php $kelas_id = $key['kelas_id'];
                            endforeach; ?>
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
                <h5 class="modal-title">Data Rombel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/rombel/save" method="post">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label>Kelas</label>
                        <select name="kelas_id" id="kelas_id" class="form-control">
                            <?php foreach ($kelas as $key) : ?>
                                <option value="<?= $key['id']; ?>"><?= $key['nama_kelas']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Rombel*</label>
                        <input type="text" class="form-control" name="nama_rombel" id="nama_rombel" placeholder="Ex : IPA" required>
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
    $(document).on('click', '.btn-delete', function() {
        $("#modal-delete form").attr("action", `/rombel/delete/${$(this).data("nilai")}`);
    });
    myAlert("Data Rombel");
    $(document).on('click', '#btn-add', function() {
        $('#modal-save form').attr("action", "/rombel/save");
        $("#nama_rombel").val("");
    });

    $(document).on("click", ".btn-edit", function() {
        $.ajax({
            url: `<?= '/api/administrator/rombelDetail/' ?>${$(this).data('nilai')}`,
            dataType: "json",
            success: function(result) {
                $('#modal-save form').attr("action", `/rombel/save/${result.id}`);
                $("#nama_rombel").val(result.nama_rombel);
                $("#kelas_id").val(result.kelas_id);
            }
        })
    });
</script>
<?= $this->endSection(); ?>