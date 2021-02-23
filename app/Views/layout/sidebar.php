<!-- Sidebar -->
<?php
$userModel = new \App\Models\UserModel();
$menuModel = new \App\Models\MenuModel();
$url = new \CodeIgniter\HTTP\URI(base_url(uri_string()));
$user = $userModel->getUser(session()->get("id_user"));
$listMenu = $menuModel->listMenu();
?>
<!-- End Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?= CLOUD_URL . "w_100/" . LOGO_IMG ?>" alt="<?= SITE_NAME ?>" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= SITE_NAME ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
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
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <?php foreach ($listMenu as $key) : ?>
                    <li class="nav-item <?= $url->getSegment(1) == strtolower($key['menu']) ? "menu-open" : "" ?>">
                        <a href="<?= count($key['sub_menu']) > 0 ? "#" . strtolower($key['menu']) : "/" . strtolower($key['menu']) ?>" class="nav-link <?= $url->getSegment(1) == strtolower($key['menu']) ? "active" : "" ?>">
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