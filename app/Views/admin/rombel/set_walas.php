<?= $this->extend("layout/template"); ?>
<?= $this->section("content"); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <a href="/rombel/aktif" class="btn btn-success">Kembali</a>
                    <button id="btn-list-walas" class="btn btn-primary">Daftar Guru</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6" id="rombel_awal">
                        <div class="text">
                            <h6 class="m-0 font-weight-bold">Data Rombongan Belajar Tahun Ajaran <?= tahun_aktif()['tahun'] ?></h6>
                            <p class="m-0 font-weight-bold"><?= $rombel['nama_kelas'] . '-' . $rombel['nama_rombel']; ?></p>
                        </div>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control search" placeholder="Cari walas...">
                            <div class="input-group-append">
                                <button id="btn-remove" class="btn btn-danger" type="button"><i class="fas fa-trash"></i> Hapus Walas</button>
                            </div>
                        </div>
                        <div class="list-walas"></div>
                    </div>
                    <div class="col-6" id="source">
                        <div class="text d-none">
                            <h6 class="m-0 font-weight-bold"></h6>
                            <p class="m-0 font-weight-bold">&nbsp;</p>
                        </div>
                        <div class="input-group d-none mb-2">
                            <input type="text" class="form-control search" placeholder="Cari walas...">
                            <div class="input-group-append">
                                <button id="btn-add" class="btn btn-primary" type="button"><i class="fas fa-plus"></i> Tambah walas</button>
                            </div>
                        </div>
                        <div class="list-walas"></div>
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

    function loadwalas(id, send) {
        $(`${id} .list-walas`).html(``)
        $.ajax({
            url: '/api/administrator/listWalasRombel',
            dataType: 'json',
            data: {
                select: `users.nama, users.jk, users.id`,
                ...send
            },
            success: function(result) {
                $(`${id} .text .jumlah`).text(result.length);
                result.forEach(el => {
                    $(`${id} .list-walas`).append(`
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input walas-item" id="${el.id}">
                            <label class="custom-control-label" for="${el.id}">${el.nama} ${el.jk == null ? "" : `(${el.jk})`}</label>
                        </div>
                    `)
                });
            }
        });
    }
    $(document).ready(function() {
        loadwalas('#rombel_awal', {
            rombel_id: '<?= $rombel['id']; ?>'
        });
    });

    $(document).on('click', '#btn-list-walas', function() {
        $('#source .text').removeClass('d-none');
        $('#source .input-group').removeClass('d-none');
        $('#source .text h6').html(`
            Guru yang bukan wali kelas
        `);
        loadwalas('#source', {
            rombel_id: null,
            status: 1
        });
    });

    $(document).on('keyup', '.search', function() {
        var value = $(this).val().toLowerCase();
        $(this).parents(".input-group").siblings(".list-walas").children(".custom-control").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $(document).on('click', '#btn-add', function() {
        const walasItem = document.querySelectorAll("#source .walas-item");
        const walas = [];
        walasItem.forEach(el => {
            if (el.checked == true) {
                walas.push(el.id);
            }
        });
        if (walas.length > 0) {
            $.ajax({
                url: '/rombel/addwalas',
                type: 'post',
                dataType: "json",
                data: {
                    rombel_id: "<?= $rombel['id']; ?>",
                    walas_id: walas
                },
                beforeSend: function() {
                    $("#loading-overlay").show();
                },
                success: function(result) {
                    Swal.fire(
                        "Data Rombel",
                        result.message,
                        result.status
                    );
                    if (result.status == 'success') {
                        walas.forEach(el => {
                            document.getElementById(el).parentNode.remove()
                        });
                        loadwalas('#rombel_awal', {
                            rombel_id: '<?= $rombel['id']; ?>'
                        });
                        $(`#source .text .jumlah`).text(parseInt($(`#source .text .jumlah`).text()) - walas.length);
                    }
                    $("#loading-overlay").hide();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $("#loading-overlay").hide();
                    alert("something went wrong");
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
        const walasItem = document.querySelectorAll("#rombel_awal .walas-item");
        const walas = [];
        walasItem.forEach(el => {
            if (el.checked == true) {
                walas.push(el.id);
            }
        });
        if (walas.length > 0) {
            $.ajax({
                url: '/rombel/removeWalas',
                type: 'post',
                dataType: "json",
                data: {
                    rombel_id: "<?= $rombel['id']; ?>",
                    walas_id: walas
                },
                beforeSend: function() {
                    $("#loading-overlay").show();
                },
                success: function(result) {
                    Swal.fire(
                        "Data Rombel",
                        result.message,
                        result.status
                    );
                    if (result.status == 'success') {
                        loadwalas('#rombel_awal', {
                            rombel_id: '<?= $rombel['id']; ?>'
                        });
                    }
                    $("#loading-overlay").hide();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $("#loading-overlay").hide();
                    alert("something went wrong");
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