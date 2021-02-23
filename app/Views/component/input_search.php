<script>
    function pencarian(url, key) {
        let typingTimer;
        let doneTypingInterval = 1000;
        $(document).on('keyup', '#input-cari', function() {
            const data = {
                search: {
                    key: key,
                    value: $(this).val()
                },
                status: "aktif"
            };
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                $('.list-search ul').html("");
                if ($(this).val().trim() !== "") {
                    $.ajax({
                        url: url,
                        type: "get",
                        dataType: "json",
                        data: data,
                        success: function(result) {
                            // console.log(result);
                            if (result.length > 0) {
                                result.forEach((el) => {
                                    $(".list-search ul").append(`
                                        <li data-id="${el.id}" data-nama="${el.nama}">
                                            <div class="img-cover">
                                                <img loading="lazy" src="${el.foto}" class="w-100">
                                            </div>
                                            <div class="content">
                                                <h6><b>${el.nama}</b></h6>
                                                <small>${el.nis !== undefined ? `${el.nis} - ${el.kelas}` : ""}</small>
                                            </div>
                                        </li>
                                    `);
                                });
                            } else {
                                $(".list-search ul").html(`
                                    <li>
                                        <div class="img-cover">
                                            <img loading="lazy" src="https://res.cloudinary.com/dehterav1/image/upload/h_100/v1608328548/spu-app/speaker.svg" class="w-100">
                                        </div>
                                        <div class="content">
                                            <h6><b>Tidak Ditemukan</b></h6>
                                            <small>Maaf, kami tidak bisa menemukan yang dicari!</small>
                                        </div>
                                    </li>
                                `);
                            }
                        }
                    });
                }
            }, doneTypingInterval);
        });
        $(document).on('keydown', '#input-cari', function() {
            clearTimeout(typingTimer);
        });
        $(document).on('focus', '#input-cari', function() {
            $('.list-search').css('display', 'block');
        });
        $('html').click(function(e) {
            if (e.target.id !== "input-cari") {
                $('.list-search').css('display', 'none');
            }
        });
        $(document).on('click', '.list-search ul li', function() {
            $('#input-cari').val($(this).data('nama'));
            $('.list-search ul').html("");
        });
    }
</script>