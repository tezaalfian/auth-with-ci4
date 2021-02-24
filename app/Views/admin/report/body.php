<!DOCTYPE html>
<html>

<head>
    <link rel="icon" href="<?= CLOUD_URL . "/h_30/" . LOGO_IMG ?>" type="image/x-icon" />
    <title>LAPORAN</title>
    <style type="text/css">
        table th {
            padding: 8px;
            text-align: center;
            background-color: #0275d8;
            color: white;
        }

        table {
            page-break-before: unset;
            page-break-inside: avoid;
            margin: 0;
        }

        td {
            font-size: 12px;
            padding: 8px;
        }

        b {
            font-weight: bold;
        }

        .title {
            font-size: 16px;
        }

        h3 {
            margin-bottom: 0;
            padding: 0;
        }

        .success {
            color: #5cb85c;
        }

        .primary {
            color: #0275d8;
        }

        .danger {
            color: #d9534f;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        tbody,
        td,
        tfoot,
        th,
        thead,
        tr {
            border: 1px solid #000;
            border-width: 0 0 1px 0;
        }

        p {
            margin: 3px 0;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <!-- <div class="row">
            <div class="col-md-12">
                <?php foreach ($header as $key) : ?>
                    <p><b><?= $key ?></b></p>
                <?php endforeach; ?>
            </div>
        </div><br> -->
        <div class="row">
            <div class="col-md-12">
                <table border="1" width="100%" style="page-break-inside: avoid;">
                    <!-- <thead> -->
                    <tr>
                        <?php foreach ($data['title'] as $key) : ?>
                            <th> <?= $key ?> </th>
                        <?php endforeach; ?>
                    </tr>
                    <!-- </thead> -->
                    <!-- <tbody> -->
                    <?php $no = 1; ?>
                    <?php foreach ($data['row'] as $key) : ?>
                        <tr>
                            <?php foreach ($key as $val) : ?>
                                <td><?= $val ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                    <!-- </tbody> -->
                </table>
            </div>
        </div></br></br>
        <div class="row">
            <div class="col-md-12">
                <table border="1" width="100%" style="page-break-inside: avoid;">
                    <?php foreach ($footer as $key => $val) : ?>
                        <tr>
                            <td><?= $key ?></td>
                            <td><?= $val ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</body>

</html>