<!-- Sidebar -->
<?php
$userModel = new \App\Models\UserModel();
$menuModel = new \App\Models\MenuModel();
$url = new \CodeIgniter\HTTP\URI(base_url(uri_string()));
$user = $userModel->getUser(session()->get("id_user"));
$listMenu = $menuModel->listMenu();
?>
<div class="sidebar sidebar-style-2" data-background-color="dark2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="<?= CLOUD_URL . "/w_100/" . $user['foto'] ?>" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            <?= ucwords($user['nama']) ?>
                            <span class="user-level">@<?= $user['username']; ?></span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <ul class="nav nav-primary">
                <?php foreach ($listMenu as $key) : ?>
                    <li class="nav-item <?= $url->getSegment(1) == strtolower($key['menu']) ? "active" : "" ?>">
                        <a data-toggle="<?= count($key['sub_menu']) > 0 ? "collapse" : "" ?>" href="<?= count($key['sub_menu']) > 0 ? "#" . strtolower($key['menu']) : "/" . strtolower($key['menu']) ?>">
                            <i class="<?= $key['icon']; ?>"></i>
                            <p><?= ucwords($key['menu']) ?></p>
                            <?= count($key['sub_menu']) > 0 ? "<span class='caret'></span>" : ""; ?>
                        </a>
                        <div class="collapse <?= $url->getSegment(1) == strtolower($key['menu']) ? "show" : "" ?>" id="<?= strtolower($key['menu']) ?>">
                            <ul class="nav nav-collapse">
                                <?php foreach ($key['sub_menu'] as $val) : ?>
                                    <li class="<?= $val['url'] == uri_string() ? "active" : "" ?>">
                                        <a href="/<?= $val['url'] ?>">
                                            <span class="sub-item"><?= ucwords($val['title']); ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->