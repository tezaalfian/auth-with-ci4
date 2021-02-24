<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<?php $url = new \CodeIgniter\HTTP\URI(base_url(uri_string())); ?>
<?php if ($url->getTotalSegments() > 0) : ?>
    <title><?= SITE_NAME . " : " . ucfirst($url->getSegment(1)) . '-' . ucfirst($url->getSegment(2)) ?></title>
<?php else : ?>
    <title><?= SITE_NAME ?></title>
<?php endif; ?>
<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="<?= CLOUD_URL . "/h_30/" . LOGO_IMG ?>" type="image/x-icon" />

<!-- Fonts and icons -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="/assets/css/fontawesome-free/css/all.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="/assets/css/adminlte.min.css">
<link rel="stylesheet" href="/assets/css/pace-theme-flat-top.css">
<link rel="stylesheet" href="/assets/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/css/style.css">
<style>
    #loading-overlay {
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        right: 0;
        display: none;
        align-items: center;
        background-color: #000;
        z-index: 999999;
        opacity: 0.5;
    }

    .loading-icon {
        position: absolute;
        border-top: 2px solid #fff;
        border-right: 2px solid #fff;
        border-bottom: 2px solid #fff;
        border-left: 2px solid #767676;
        border-radius: 25px;
        width: 25px;
        height: 25px;
        margin: 0 auto;
        position: absolute;
        left: 50%;
        margin-left: -20px;
        top: 50%;
        margin-top: -20px;
        z-index: 4;
        -webkit-animation: spin 1s linear infinite;
        -moz-animation: spin 1s linear infinite;
        animation: spin 1s linear infinite;
    }

    @-moz-keyframes spin {
        100% {
            -moz-transform: rotate(360deg);
        }
    }

    @-webkit-keyframes spin {
        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        -o-object-fit: cover;
        object-fit: cover;
    }
</style>