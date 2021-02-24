<?= $this->extend("layout/template"); ?>
<?= $this->section("content"); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Data Rombongan Belajar Tahun Ajaran <?= tahun_aktif()['tahun'] ?>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kelas</label>
                            <select id="kelas" class="form-control">
                                <option value="0">All</option>
                                <?php foreach ($kelas as $key) : ?>
                                    <option value='<?= $key['id'] ?>' <?= isset($_GET['kelas_id']) ? $_GET['kelas_id'] == $key['id'] ? "selected" : "" : "" ?>><?= $key['nama_kelas'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id=" rombel-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Rombel</th>
                                <th>Jumlah Santri</th>
                                <th>Jumlah Walas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            $kelas_id = "";
                            foreach ($rombel as $key) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $key['nama_kelas'] . " - " . $key['nama_rombel'] ?></td>
                                    <td><?= $key['jumlah'] ?> Santri</td>
                                    <td><?= $key['jumlah_walas'] ?> Orang</td>
                                    <td>
                                        <a href="/rombel/detail/<?= $key['id']; ?>" class="btn btn-primary btn-sm"><i class="fas fa-bars"></i> Detail</a>
                                        <a href="/rombel/setSantri/<?= $key['id']; ?>" class="btn btn-success btn-sm"><i class="fas fa-user"></i> Atur Santri</a>
                                        <a href="/rombel/setWalas/<?= $key['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-user-tie"></i> Atur Walas</a>
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
<?= $this->endSection(); ?>

<?= $this->section("myScript"); ?>
<script>
    myAlert("Data Rombel");
    $(document).on('change', '#kelas', function() {
        const id = $(this).val();
        if (id == 0) {
            window.location.href = `/rombel/aktif`;
        } else {
            window.location.href = `/rombel/aktif?kelas_id=${id}`;
        }
    });
</script>
<?= $this->endSection(); ?>