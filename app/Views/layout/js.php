<script src="/assets/js/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/assets/js/adminlte.min.js"></script>
<script src="/assets/js/pace.min.js"></script>
<script src="/assets/js/jquery.dataTables.min.js"></script>
<script src="/assets/js/dataTables.bootstrap4.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ajaxStart(function() {
        Pace.restart();
    });

    function myAlert(title) {
        const flashdata = $('.flash-data').attr('data');
        if (flashdata) {
            Swal.fire(
                title,
                "<?= session()->getFlashdata('success') ?>",
                'success'
            );
        }
        const error = $('.flash-error').attr('data');
        if (error) {
            Swal.fire(
                title,
                "<?= session()->getFlashdata('error') ?>",
                'error'
            )
        }
    }
</script>