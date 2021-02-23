<?= $this->extend("layout/template"); ?>
<?= $this->section("content"); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Cari Akun Santri
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
                        <div class="form-group">
                            <label>Masukkan Nama Santri</label>
                            <div style="position: relative;">
                                <input type="text" class="form-control" id="input-cari">
                                <div class="list-search">
                                    <ul></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (!is_null($santri)) : ?>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <img src="<?= $santri['foto']; ?>" alt="foto santri" class="img-thumbnail mx-auto">
                                </div>
                                <div class="col-md-8">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0"><b>Nama Santri : </b><?= $santri['nama']; ?></li>
                                        <li class="list-group-item px-0"><b>NIS : </b><?= $santri['nis']; ?></li>
                                        <li class="list-group-item px-0"><b>Password : </b><?= $santri['password']; ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Berdasarkan Rombel
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
                        <div class="form-group">
                            <label>Masukkan Nama Santri</label>
                            <div style="position: relative;">
                                <input type="text" class="form-control" id="input-cari">
                                <div class="list-search">
                                    <ul></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section("myScript"); ?>
<?= $this->include('component/input_search'); ?>
<script>
    $(document).ready(function() {
        pencarian("/api/administrator/cariSantri", "santri.nama");
    });
    $(document).on('click', '.list-search ul li', function() {
        if ($(this).data('id') !== undefined) {
            window.location.href = `/santri/search/${$(this).data('id')}`;
        } else {
            window.location.href = `/santri/search`;
        }
    });
</script>
<?= $this->endSection(); ?>