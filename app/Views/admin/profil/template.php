<?= $this->extend("admin/template"); ?>
<?= $this->section("content"); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-with-nav">
            <div class="card-header">
                <div class="row row-nav-line">
                    <?php $uri = new \CodeIgniter\HTTP\URI(base_url(uri_string()));
                    $url = $uri->getSegment(2) ?>
                    <ul class="nav nav-tabs nav-line nav-color-secondary w-100 pl-4" role="tablist">
                        <li class="nav-item"> <a class="nav-link <?= $url == "" ? "active show" : ""; ?>" href="/profil">Overview</a> </li>
                        <li class="nav-item"> <a class="nav-link <?= $url == "changePassword" ? "active show" : ""; ?>" href="/profil/changePassword">Ubah Password</a> </li>
                        <!-- <li class="nav-item"> <a class="nav-link <?= $url == "edit" ? "active show" : ""; ?>" href="/profil/edit">Edit Profil</a> </li> -->
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <?= $this->renderSection("profil"); ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section("myScript"); ?>
<?= $this->renderSection('profilScript'); ?>
<?= $this->endSection(); ?>