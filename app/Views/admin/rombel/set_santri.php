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
                            <p class="mb-2 message"></p>
                        </div>
                        <input type="text" class="form-control search mb-2" placeholder="Cari santri...">
                        <div class="list-santri h-100" ondragover="onDragOver(event);" ondrop="dragAdd(event);"></div>
                    </div>
                    <div class="col-6" id="source">
                        <div class="text"></div>
                        <input type="text" class="form-control search mb-2 d-none" placeholder="Cari santri...">
                        <div class="list-santri h-100" ondragover="onDragOver(event);" ondrop="dragRemove(event);"></div>
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
                select: `santri.nama, santri.jk, santri.id`,
                ...send
            },
            success: function(result) {
                result.forEach(el => {
                    $(`${id} .list-santri`).append(`
                        <div class="alert alert-primary px-2 py-1 mb-1 santri-drag" style="cursor: all-scroll;" draggable="true" id=${el.id} ondragstart="onDragStart(event);">
                            ${el.nama} (${el.jk})
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
        $('#source .text').html(`
            <h6 class="mb-2 font-weight-bold">Santri yang belum masuk rombel</h6>
        `);
        $('#source .search').removeClass('d-none');
        loadSantri('#source', {
            rombel_id: null,
            status: 'aktif'
        });
    });

    $(document).on('click', '#btn-old-santri', function() {
        $('#source .text').html(`
            <h6 class="mb-2 font-weight-bold">Santri Rombel Tahun Lalu</h6>
            <input type="text" class="form-control search mb-2" placeholder="Cari santri...">
        `);
        $('#source .search').removeClass('d-none');
        loadSantri('#source', {
            rombel_id: '<?= $rombel['id']; ?>',
            status: 'aktif',
            rombel_lama: true
        });
    });
    $(document).on('keyup', '.search', function() {
        var value = $(this).val().toLowerCase();
        $(this).siblings(".list-santri").children(".santri-drag").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    function onDragStart(event) {
        event.dataTransfer.setData('text/plain', event.target.id);
    }

    function dragAdd(event) {
        const id = event
            .dataTransfer
            .getData('text');
        const draggableElement = document.getElementById(id);
        $.ajax({
            url: '/rombel/addSantri',
            type: 'post',
            dataType: "json",
            data: {
                rombel_id: "<?= $rombel['id']; ?>",
                santri_id: id
            },
            success: function(result) {
                $('#rombel_awal .jumlah').text(parseInt($('#rombel_awal .jumlah').text()) + 1);
                $('#rombel_awal .message').text(result.message);
                $('#rombel_awal .list-santri').append(draggableElement);
                event
                    .dataTransfer
                    .clearData();
            }
        })
    }

    function dragRemove(event) {
        const id = event
            .dataTransfer
            .getData('text');
        const draggableElement = document.getElementById(id);
        $.ajax({
            url: '/rombel/removeSantri',
            type: 'post',
            dataType: "json",
            data: {
                rombel_id: "<?= $rombel['id']; ?>",
                santri_id: id
            },
            success: function(result) {
                $('#rombel_awal .jumlah').text(parseInt($('#rombel_awal .jumlah').text()) - 1);
                $('#source .message').text(result.message);
                $('#source .list-santri').append(draggableElement);
                event
                    .dataTransfer
                    .clearData();
            }
        })
    }

    function onDragOver(event) {
        event.preventDefault();
    }
</script>
<?= $this->endSection(); ?>