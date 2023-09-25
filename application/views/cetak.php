<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <link rel="shortcut icon" href="<?= base_url("aset"); ?>/assets/images/logo.png">

    <title>Absensi Online | Cetak</title>

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="<?= base_url("aset"); ?>/assets/plugins/morris/morris.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url("aset"); ?>/plugins/toastr/toastr.min.css">

    <script src="https://kit.fontawesome.com/c1fd40eeb3.js" crossorigin="anonymous"></script>

    <!-- DataTables -->
    <link href="<?= base_url("aset/"); ?>assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url("aset/"); ?>assets/plugins/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url("aset/"); ?>assets/plugins/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url("aset/"); ?>assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url("aset/"); ?>assets/plugins/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url("aset/"); ?>assets/plugins/datatables/dataTables.colVis.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url("aset/"); ?>assets/plugins/datatables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url("aset/"); ?>assets/plugins/datatables/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <link href="<?= base_url("aset"); ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url("aset"); ?>/assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url("aset"); ?>/assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url("aset"); ?>/assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url("aset"); ?>/assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url("aset"); ?>/assets/css/responsive.css" rel="stylesheet" type="text/css" />

    <style>
        table th,
        td {
            text-align: center;
        }

        #judul {
            text-align: center;
            font-weight: 600;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <img src="<?= base_url('aset/assets/images/nanang.png') ?>" width="300px;">
                <hr size="2" width="100%">
                <div class="card-header">
                    <h3 id="judul">LAPORAN REKAP ABSENSI KARYAWAN</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama Karyawan</th>
                            <th>Bulan</th>
                            <th>Hadir</th>
                            <th>Terlambat</th>
                            <th>Sakit</th>
                            <th>Izin</th>
                        </tr>
                        <?php foreach ($tampil as $dt) { ?>
                            <tr>
                                <td style="text-align: left;"><?= $dt->kry_nama ?></td>
                                <td><?= $bulan ?></td>
                                <td><?= $hadir[$dt->kry_id] ?></td>
                                <td><?= $terlambat[$dt->kry_id] ?></td>
                                <td><?= $sakit[$dt->kry_id] ?></td>
                                <td><?= $izin[$dt->kry_id] ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    window.print();
    setTimeout(function() {
        window.close();
    }, 100);
</script>

</html>