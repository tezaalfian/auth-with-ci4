<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<?php $url = new \CodeIgniter\HTTP\URI(base_url(uri_string())); ?>
<?php if($url->getTotalSegments() > 0) : ?>
<title><?= SITE_NAME . " : " . ucfirst($url->getSegment(1)) . '-' . ucfirst($url->getSegment(2)) ?></title>
<?php else: ?>
<title><?= SITE_NAME ?></title>
<?php endif; ?>
<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="/assets/img/icon.ico" type="image/x-icon" />

<!-- Fonts and icons -->
<script src="/assets/js/plugin/webfont/webfont.min.js"></script>
<script>
    WebFont.load({
        google: {
            "families": ["Lato:300,400,700,900"]
        },
        custom: {
            "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
            urls: ['/assets/css/fonts.min.css']
        },
        active: function() {
            sessionStorage.fonts = true;
        }
    });
</script>

<!-- CSS Files -->
<!-- <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
<link rel="stylesheet" href="/assets/css/atlantis.css"> -->
<link rel="stylesheet" href="/assets/build/css/style.min.css">

<!-- CSS Just for demo purpose, don't include it in your project -->
<!-- <link rel="stylesheet" href="/assets/css/demo.css"> -->