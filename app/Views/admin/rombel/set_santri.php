<?= $this->extend("layout/template"); ?>
<?= $this->section("content"); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <a href="/rombel/aktif" class="btn btn-success">Kembali</a>
                    <button id="btn-new-santri" class="btn btn-primary">Baru</button>
                    <button id="btn-old-santri" class="btn btn-warning">Lama</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6" id="rombel_awal">
                        <div class="text">
                            <h6 class="m-0 font-weight-bold">Data Rombongan Belajar Tahun Ajaran <?= tahun_aktif()['tahun'] ?></h6>
                            <p class="m-0 font-weight-bold"><?= $rombel['nama_kelas'] . '-' . $rombel['nama_rombel']; ?></p>
                            <p class="mb-0">Jumlah Santri : <span class="jumlah"><?= $rombel['jumlah']; ?></span></p>
                        </div>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control search" placeholder="Cari santri...">
                            <div class="input-group-append">
                                <button id="btn-remove" class="btn btn-danger" type="button"><i class="fas fa-trash"></i> Hapus Santri</button>
                            </div>
                        </div>
                        <div class="list-santri"></div>
                    </div>
                    <div class="col-6" id="source">
                        <div class="text d-none">
                            <h6 class="m-0 font-weight-bold"></h6>
                            <p class="m-0 font-weight-bold">&nbsp;</p>
                            <p class="mb-0">Jumlah Santri : <span class="jumlah"></span></p>
                        </div>
                        <div class="input-group d-none mb-2">
                            <input type="text" class="form-control search" placeholder="Cari santri...">
                            <div class="input-group-append">
                                <button id="btn-add" class="btn btn-primary" type="button"><i class="fas fa-plus"></i> Tambah Santri</button>
                            </div>
                        </div>
                        <div class="list-santri"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section("myScript"); ?>
<script>
    myAlert(" Data Rombel");

    function loadSantri(id, send) {
        $(`${id} .list-santri`).html(``)
        $.ajax({
            url: '/api/administrator/listSantriRombel',
            dataType: 'json',
            data: {
                select: `santri.nama, santri.jk, santri.id, concat(kelas.nama_kelas,'-',rombel.nama_rombel) as kelas`,
                ...send
            },
            success: function(result) {
                $(`${id} .text .jumlah`).text(result.length);
                result.forEach(el => {
                    $(`${id} .list-santri`).append(`
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input santri-item" id="${el.id}">
                            <label class="custom-control-label" for="${el.id}">${el.nama} (${el.jk}) ${el.kelas !== null ? `${el.kelas}` : ``}</label>
                        </div>
                    `)
                });
            }
        });
    }
    $(document).ready(function() {
        loadSantri('#rombel_awal', {
            rombel_id: '<?= $rombel['id']; ?>'
        });
    });

    $(document).on('click', '#btn-new-santri', function() {
        $('#source .text').removeClass('d-none');
        $('#source .input-group').removeClass('d-none');
        $('#source .text h6').html(`
            Santri yang belum masuk rombel
        `);
        loadSantri('#source', {
            rombel_id: null,
            status: 'aktif'
        });
    });

    $(document).on('click', '#btn-old-santri', function() {
        $('#source .text').removeClass('d-none');
        $('#source .input-group').removeClass('d-none');
        $('#source .text h6').html(`
            Santri Tahun Ajaran Lalu
        `);
        loadSantri('#source', {
            rombel_id: '<?= $rombel['id']; ?>',
            status: 'aktif',
            rombel_lama: true
        });
    });
    $(document).on('keyup', '.search', function() {
        var value = $(this).val().toLowerCase();
        $(this).parents(".input-group").siblings(".list-santri").children(".custom-control").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $(document).on('click', '#btn-add', function() {
        const santriItem = document.querySelectorAll("#source .santri-item");
        const santri = [];
        santriItem.forEach(el => {
            if (el.checked == true) {
                santri.push(el.id);
            }
        });
        console.log(santri);
        if (santri.length > 0) {
            $.ajax({
                url: '/rombel/addSantri',
                type: 'post',
                dataType: "json",
                data: {
                    rombel_id: "<?= $rombel['id']; ?>",
                    santri_id: santri
                },
                success: function(result) {
                    Swal.fire(
                        "Data Rombel",
                        result.message,
                        result.status
                    );
                    if (result.status == 'success') {
                        santri.forEach(el => {
                            document.getElementById(el).parentNode.remove()
                        });
                        loadSantri('#rombel_awal', {
                            rombel_id: '<?= $rombel['id']; ?>'
                        });
                        $(`#source .text .jumlah`).text(parseInt($(`#source .text .jumlah`).text()) - santri.length);
                    }
                }
            });
        } else {
            Swal.fire(
                "Data Rombel",
                "Data tidak ada yg diceklis!",
                'error'
            );
        }
    });

    $(document).on('click', '#btn-remove', function() {
        const santriItem = document.querySelectorAll("#rombel_awal .santri-item");
        const santri = [];
        santriItem.forEach(el => {
            if (el.checked == true) {
                santri.push(el.id);
            }
        });
        if (santri.length > 0) {
            $.ajax({
                url: '/rombel/removeSantri',
                type: 'post',
                dataType: "json",
                data: {
                    rombel_id: "<?= $rombel['id']; ?>",
                    santri_id: santri
                },
                success: function(result) {
                    Swal.fire(
                        "Data Rombel",
                        result.message,
                        result.status
                    );
                    if (result.status == 'success') {
                        loadSantri('#rombel_awal', {
                            rombel_id: '<?= $rombel['id']; ?>'
                        });
                    }
                }
            });
        } else {
            Swal.fire(
                "Data Rombel",
                "Data tidak ada yg diceklis!",
                'error'
            );
        }
    });
</script>
<?= $this->endSection(); ?>