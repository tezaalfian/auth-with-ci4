<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->include("admin/layout/css") ?>
</head>

<body class="login">
    <div class="flash-data" data="<?= session()->getFlashdata('success') ?>"></div>
    <div class="flash-error" data="<?= session()->getFlashdata('error') ?>"></div>
    <div class="wrapper wrapper-login">
        <div class="container container-login animated fadeIn">
            <h3 class="text-center">Sign In To Admin</h3>
            <div class="login-form">
                <form action="/login" method="post">
                    <div class="form-group form-floating-label">
                        <input id="username" name="username" type="text" class="form-control input-border-bottom" value="<?= old("username") ?>" required>
                        <label for="username" class="placeholder">Username</label>
                    </div>
                    <div class="form-group form-floating-label">
                        <input id="password" name="password" type="password" class="form-control input-border-bottom" required>
                        <label for="password" class="placeholder">Password</label>
                    </div>
                    <div class="row form-sub m-0">
                        <!-- <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="rememberme">
                            <label class="custom-control-label" for="rememberme">Remember Me</label>
                        </div> -->

                        <!-- <a href="#" class="link float-right">Forget Password ?</a> -->
                    </div>
                    <div class="form-action mb-3">
                        <button type="submit" class="btn btn-primary btn-rounded btn-login">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?= $this->include("admin/layout/js") ?>
    <script>
        const flashdata = $('.flash-data').attr('data');
        if (flashdata) {
            swal("Login", flashdata, {
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
            swal("Login", error, {
                icon: "error",
                buttons: {
                    confirm: {
                        className: 'btn btn-danger'
                    }
                },
            });
        }
    </script>
</body>

</html>