<?= $this->extend("layout/template"); ?>
<?= $this->section("content"); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Pindah Rombel
                </div>
            </div>
            <div class="card-body">
                <h6 class="mb-2 font-weight-bold">Data Rombongan Belajar Tahun Ajaran <?= tahun_aktif()['tahun'] ?></h6>
                <div class="row">
                    <div class="col-6" id="rombel-area-1">
                        <select class="form-control select-rombel">
                            <option value="0">Pilih Rombel</option>
                            <?php foreach ($rombel as $key) : ?>
                                <option value="<?= $key['id']; ?>"><?= $key['kelas']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" class="form-control mt-2 search" placeholder="Cari santri...">
                        <p class="mb-2">Jumlah Santri : <span class="font-weight-bold jumlah"></span></p>
                        <div class="list-santri h-100" ondragover="onDragOver(event);" ondrop="onDrop(event);"></div>
                    </div>
                    <div class="col-6" id="rombel-area-2">
                        <select class="form-control select-rombel">
                            <option value="0">Pilih Rombel</option>
                            <?php foreach ($rombel as $key) : ?>
                                <option value="<?= $key['id']; ?>"><?= $key['kelas']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" class="form-control mt-2 search" placeholder="Cari santri...">
                        <p class="mb-2">Jumlah Santri : <span class="font-weight-bold jumlah"></span></p>
                        <div class="list-santri h-100" ondragover="onDragOver(event);" ondrop="onDrop(event);"></div>
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
        $(`#${id}`).children('.list-santri').html(``)
        $.ajax({
            url: '/api/administrator/listSantriRombel',
            dataType: 'json',
            data: {
                select: `santri.nama, santri.jk, santri.id, concat(kelas.nama_kelas,'-',rombel.nama_rombel) as kelas`,
                ...send
            },
            success: function(result) {
                $(`#${id} .jumlah`).text(result.length);
                result.forEach(el => {
                    $(`#${id} .list-santri`).append(`
                        <div class="alert alert-primary px-2 py-1 mb-1 santri-item" style="cursor: all-scroll;" draggable="true" id=${el.id} ondragstart="onDragStart(event);">
                            ${el.nama} (${el.jk}) ${el.kelas !== null ? `${el.kelas}` : ``}
                        </div>
                    `)
                });
            }
        });
    }
    $(document).on('change', '.select-rombel', function() {
        if ($('#rombel-area-1 .select-rombel').val() === $('#rombel-area-2 .select-rombel').val()) {
            Swal.fire(
                "Data Rombel",
                "Data rombel tidak boleh sama!",
                'error'
            );
        } else {
            loadSantri($(this).parent().attr('id'), {
                rombel_id: $(this).val()
            })
        }
    });

    $(document).on('keyup', '.search', function() {
        const value = $(this).val().toLowerCase();
        $(this).siblings(".list-santri").children(".santri-item").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    function onDragOver(event) {
        event.preventDefault();
    }

    function onDragStart(event) {
        event.dataTransfer.setData('text/plain', event.target.id);
    }

    function onDrop(event) {
        const id = event
            .dataTransfer
            .getData('text');
        let dropZone = $(event.target).parents('.col-6').attr('id');
        // console.log(dropZone);
        const draggableElement = document.getElementById(id);
        const data = {
            santri_id: id,
            origin: $(`#${id}`).parents('.list-santri').siblings('.select-rombel').val(),
            dest: $(`#${dropZone}`).children('.select-rombel').val()
        };
        // console.log(data);
        $.ajax({
            url: '/rombel/editSantri',
            type: 'post',
            dataType: "json",
            data: data,
            beforeSend: function() {
                $("#loading-overlay").show();
            },
            success: function(result) {
                $(`#${id}`).parents('.col-6').children('.jumlah').text(parseInt($(`#${id}`).parents('.col-6').children('.jumlah').text()) - 1);
                $(`#${dropZone} .jumlah`).text(parseInt($(`#${dropZone} .jumlah`).text()) + 1);
                $(`#${dropZone} .list-santri`).append(draggableElement);
                event
                    .dataTransfer
                    .clearData();
                $("#loading-overlay").hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $("#loading-overlay").hide();
                alert("something went wrong");
            }
        })
    }
    $(document).on('click', '#btn-add', function() {
        const santriItem = document.querySelectorAll("#source .santri-item");
        const santri = [];
        santriItem.forEach(el => {
            if (el.checked == true) {
                santri.push(el.id);
            }
        });
        if (santri.length > 0) {
            $.ajax({
                url: '/rombel/addSantri',
                type: 'post',
                dataType: "json",
                data: {
                    rombel_id: "",
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
                            rombel_id: ''
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
</script>
<?= $this->endSection(); ?>