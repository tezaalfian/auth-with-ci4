<?php $url = new \CodeIgniter\HTTP\URI(base_url(uri_string())); ?>
<?php if($url->getTotalSegments() > 0) : ?>
<h4 class="page-title"><?= !empty(ucfirst($url->getSegment(2))) ? ucfirst($url->getSegment(2)) : ucfirst($url->getSegment(1)); ?></h4>
<ul class="breadcrumbs">
    <li class="nav-home">
        <a href="/admin/dashboard">
            <i class="flaticon-home"></i>
        </a>
    </li>
    <?php foreach ($url->getSegments() as $segment) : ?>
        <?php
        $uri = substr(uri_string(), 0, strpos(uri_string(), $segment)) . $segment;
        $is_active =  $uri == uri_string();
        ?>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item <?= $is_active ? "active" : ""; ?>">
            <?php if ($is_active) : ?>
                <?php echo ucfirst($segment) ?>
            <?php else : ?>
                <a href="<?php echo base_url($uri) ?>"><?php echo ucfirst($segment) ?></a>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
<?php else: ?>
    <h4 class="page-title"><?= SITE_NAME ?></h4>
<?php endif; ?>