<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->include("layout/css") ?>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="flash-data" data="<?= session()->getFlashdata('success') ?>"></div>
        <div class="flash-error" data="<?= session()->getFlashdata('error') ?>"></div>
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <img src="<?= CLOUD_URL . "w_100/" . LOGO_IMG ?>" alt="Image" class="img-fluid">
                <h5 class="text-primary mt-1 mb-0"><b><?= SITE_NAME ?></b></h5>
            </div>
            <div class="card-body border-bottom">
                <form action="/login" method="post">
                    <div class="input-group mb-3">
                        <input id="username" name="username" type="text" class="form-control" value="<?= old("username") ?>" placeholder="Username" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input name="password" type="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-action mb-3">
                        <button type="submit" class="btn btn-primary btn-block btn-rounded btn-login">Login</button>
                    </div>
                </form>
                <div class="row">
                    <div class="col-6">
                        <a href="https://api.whatsapp.com/send?phone=6285157768580&text=minta%20akun" class="btn btn-outline-primary btn-block">Minta Akun</a>
                    </div>
                    <div class="col-6">
                        <a href="https://api.whatsapp.com/send?phone=6285157768580&text=lupa%20password" class="btn btn-outline-primary btn-block">Lupa Password</a>
                    </div>
                </div>
            </div>
            <div class="card-body text-center">
                <a href="https://web.facebook.com/tahfizhdulido" class="btn btn-sm btn-outline-secondary"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/tahfizhdulido/" class="btn btn-sm btn-outline-secondary"><i class="fab fa-instagram"></i></a>
                <a href="https://www.youtube.com/channel/UCujpHY6cY-zsId_cTCCS4_g" class="btn btn-sm btn-outline-secondary"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>
    <?= $this->include("layout/js") ?>
    <script>
        myAlert("<?= SITE_NAME ?>")
    </script>
</body>

</html>