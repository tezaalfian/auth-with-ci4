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