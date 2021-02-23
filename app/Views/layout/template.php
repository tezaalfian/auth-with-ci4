<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $userModel = new \App\Models\UserModel();
    $menuModel = new \App\Models\MenuModel();
    $url = new \CodeIgniter\HTTP\URI(base_url(uri_string()));
    $user = $userModel->getUser(session()->get("id_user"));
    $listMenu = $menuModel->listMenu();
    ?>
    <?= $this->include("layout/css") ?>
    <?= $this->renderSection("myStyle"); ?>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- header -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <!-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="/profil" class="nav-link">Profil</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/logout" class="nav-link">Logout</a>
                </li> -->
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if (count($user['role']) > 1) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="far fa-bell"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <span class="dropdown-header"><?= count($user['role']) ?> Modul</span>
                            <div class="dropdown-divider"></div>
                            <?php foreach ($user['role'] as $key) : ?>
                                <a href="#" class="dropdown-item set-role" data-nilai="<?= $key; ?>">
                                    <?php $role = $userModel->getRole($key); ?>
                                    <?= $role['role']; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="/profil">
                        <i class="far fa-user"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- end header -->

        <!-- sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="index3.html" class="brand-link">
                <img src="<?= CLOUD_URL . "w_100/" . LOGO_IMG ?>" alt="<?= SITE_NAME ?>" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><?= SITE_NAME ?></span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= CLOUD_URL . "w_100/" . $user['foto'] ?>" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?= $user['nama'] ?></a>
                    </div>
                </div>
                <!-- SidebarSearch Form -->
                <!-- <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div> -->
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <?php foreach ($listMenu as $key) : ?>
                            <li class="nav-item <?= $url->getSegment(1) == strtolower($key['menu']) ? "menu-open" : "" ?>">
                                <a href="<?= count($key['sub_menu']) > 0 ? "#" . strtolower($key['menu']) : is_null($key['url']) ? "/" . strtolower($key['menu']) : strtolower($key['url']) ?>" class="nav-link <?= $url->getSegment(1) == strtolower($key['menu']) ? "active" : "" ?>">
                                    <i class="nav-icon <?= $key['icon']; ?>"></i>
                                    <p>
                                        <?= ucwords($key['nama_menu']) ?>
                                        <?= count($key['sub_menu']) > 0 ? "<i class='right fas fa-angle-left'></i>" : ""; ?>
                                    </p>
                                </a>
                                <?php if (count($key['sub_menu']) > 0) : ?>
                                    <ul class="nav nav-treeview">
                                        <?php foreach ($key['sub_menu'] as $val) : ?>
                                            <li class="nav-item">
                                                <a href="/<?= $val['url'] ?>" class="nav-link <?= $val['url'] == uri_string() ? "active" : "" ?>">
                                                    <i class="<?= $val['icon']; ?> nav-icon"></i>
                                                    <p><?= ucwords($val['title']); ?></p>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- end sidebar -->
        <div class="flash-data" data="<?= session()->getFlashdata('success') ?>"></div>
        <div class="flash-error" data="<?= session()->getFlashdata('error') ?>"></div>
        <!-- backup -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">
                                <?php if ($url->getTotalSegments() > 0) : ?>
                                    <?= ucfirst($url->getSegment(1)); ?>
                                <?php else : ?>
                                    <?= SITE_NAME ?>
                                <?php endif; ?>
                            </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <?php foreach ($url->getSegments() as $segment) : ?>
                                    <?php
                                    $uri = substr(uri_string(), 0, strpos(uri_string(), $segment)) . $segment;
                                    $is_active =  $uri == uri_string();
                                    ?>
                                    <li class="breadcrumb-item <?= $is_active ? "active" : ""; ?>">
                                        <?php if ($is_active) : ?>
                                            <?php echo ucfirst($segment) ?>
                                        <?php else : ?>
                                            <a href="<?php echo base_url($uri) ?>"><?php echo ucfirst($segment) ?></a>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">
                    <?= $this->renderSection("content"); ?>
                </div>
            </div>
        </div>

        <?= $this->include("layout/footer") ?>
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
    <?= $this->include("layout/js") ?>
    <script>
        $(document).on("click", '.set-role', function() {
            window.location.replace(`/auth/set_role/${$(this).data('nilai')}`)
        });
    </script>
    <?= $this->renderSection("myScript"); ?>
</body>

</html>