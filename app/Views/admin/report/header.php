<!DOCTYPE html>
<html>

<head>
</head>

<body>
    <div style="text-align: center;">
        <h3 style='margin-bottom: 0;padding: 0;'><b><?= $title ?></b></h3>
        <b style='font-size: 16px;'>Pesantren Tahfizh Al-Quran Daarul Uluum Lido</b><br>
        <small>Jl. Mayjen HR Edi Sukma KM 22 Muara Ciburuy Cigombong Bogor 16110 Jawa Barat</small>
    </div>
    <br>
    <?php foreach ($header as $key) : ?>
        <p style="margin: 0;font-size:12px;"><b><?= $key ?></b></p>
    <?php endforeach; ?>
</body>

</html>