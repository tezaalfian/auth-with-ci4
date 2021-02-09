<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->include("admin/layout/css") ?>
</head>

<body>
    <div class="wrapper">
        <?= $this->include("admin/layout/header") ?>

        <?= $this->include("admin/layout/sidebar") ?>
        <div class="flash-data" data="<?= session()->getFlashdata('success') ?>"></div>
        <div class="flash-error" data="<?= session()->getFlashdata('error') ?>"></div>
        <div class="main-panel">
            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        <?= $this->include("admin/layout/breadcumd"); ?>
                    </div>
                    <div class="page-category">
                        <?= $this->renderSection("content"); ?>
                    </div>
                </div>
            </div>
            <?= $this->include("admin/layout/footer") ?>
        </div>
    </div>
    <div class="modal fade" id="modal-delete" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Apakah kamu yakin ?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Data yang dihapus tidak akan dikembalikan!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                    <form action="/users/delete/" method="post">
                        <?= csrf_field(); ?>
                        <input type="hidden" type="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?= $this->include("admin/layout/js") ?>
    <script>
        function myAlert(title) {
            const flashdata = $('.flash-data').attr('data');
            if (flashdata) {
                swal(title, flashdata, {
                    icon: "success",
                    buttons: {
                        confirm: {
                            className: 'btn btn-success'
                        }
                    },
                });
            }
            const error = $('.flash-error').attr('data');
            if (error) {
                swal(title, error, {
                    icon: "error",
                    buttons: {
                        confirm: {
                            className: 'btn btn-danger'
                        }
                    },
                });
            }
        }
        $(document).on("click",'.set-role',function(){
            window.location.replace(`/dashboard/set_role/${$(this).data('nilai')}`)
        });
    </script>
    <?= $this->renderSection("myScript"); ?>
</body>

</html>