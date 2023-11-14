<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <link rel="shortcut icon" href="<?= base_url("aset"); ?>/assets/images/logo.png">

    <title>Absensi Online | Cetak Absensi</title>

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
        table td {
            text-align: left;
        }

        table th,
        td {
            text-align: center;
        }

        #judul {
            font-weight: 600;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <table>
                    <tr>
                        <td width="30%"><img src="<?= base_url('aset/assets/images/logo.png') ?>" width="80px;"></td>
                        <td>
                            <h3 id="judul" style="text-transform: uppercase;">LAPORAN ABSENSI KARYAWAN</h3>
                            <table style="font-size: 11px;">
                                <tr>
                                    <td><b>Nama Unit Usaha </b></td>
                                    <td>&nbsp;: <?= $company ?></td>
                                </tr>
                                <tr>
                                    <td><b>Bulan </b></td>
                                    <td>&nbsp;: <?= $bulan ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <hr size="2" width="100%">
                <div class="card-body">
                    <table class="table table-bordered" style="font-size: 11px;">
                        <tr>
                            <th>Nama Karyawan</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Terlambat</th>
                            <th>Denda</th>
                        </tr>
                        <?php foreach ($tampil as $dt) { ?>
                            <tr>
                                <td><?= $dt->kry_nama ?></td>
                                <td><?= $dt->abs_tanggal ?></td>
                                <td><?= $dt->abs_jam_masuk ?></td>
                                <td><?= $dt->abs_jam_pulang ?></td>
                                <td><?= $dt->abs_terlambat ? $dt->abs_terlambat : 0 ?></td>
                                <td>Rp. <?= $dt->abs_denda ? number_format($dt->abs_denda, 0) : 0 ?></td>
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