<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/profil" class="nav-link"><i class="fas fa-user"></i> Profil</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/logout" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </li>
    </ul>
    <?php
    $userModel = new \App\Models\UserModel();
    $user = $userModel->getUser(session()->get("id_user"));
    ?>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <?php if (count($user['role']) > 1) : ?>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-bars"></i>
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
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>