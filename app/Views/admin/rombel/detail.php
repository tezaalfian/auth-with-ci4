<?= $this->extend("layout/template"); ?>
<?= $this->section("content"); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Data Rombongan Belajar Tahun Ajaran <?= tahun_aktif()['tahun'] ?>
                </div>
                <div class="card-tools">
                    <button type="button" class="btn btn-sm" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0">Kelas : <b><?= $rombel['kelas']; ?></b></li>
                            <li class="list-group-item px-0">Jumlah Santri : <b><?= $rombel['jumlah']; ?></b></li>
                            <li class="list-group-item px-0">Jumlah Wali Kelas : <b><?= $rombel['jumlah_walas']; ?></b></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush list-walas">
                            <li class="list-group-item px-0">Wali Kelas : </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Daftar Santri
                </div>
                <div class="card-tools">
                    <button type="button" class="btn btn-sm" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table id="santri-table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section("myScript"); ?>
<script>
    myAlert(" Data Rombel");
    $(document).ready(function() {
        $.ajax({
            url: "/api/administrator/listWalasRombel",
            dataType: 'json',
            data: {
                rombel_id: "<?= $rombel['id']; ?>",
                select: "users.nama"
            },
            success: function(result) {
                result.forEach(el => {
                    $('.list-walas').append(`
                        <li class="list-group-item px-0"><b>${el.nama}</b></li>
                    `);
                });
            }
        });
        $('#santri-table').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            autoWidth: false,
            order: [],
            ajax: {
                url: `/santri/listSantri`,
                data: {
                    rombel_id: "<?= $rombel['id'] ?>",
                    column: ['foto', 'nis', 'nama', 'jk']
                },
                type: "get"
            }
        });
    });
</script>
<?= $this->endSection(); ?>