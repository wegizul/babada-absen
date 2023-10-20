<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
  <meta name="author" content="Coderthemes">

  <link rel="shortcut icon" href="<?= base_url("aset"); ?>/assets/images/logo.png">

  <title>Absensi Mobile | Dashboard</title>

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

  <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

  <script src="<?= base_url("aset"); ?>/assets/js/modernizr.min.js"></script>

  <!--form validation init-->
  <script src="<?= base_url("aset"); ?>/assets/plugins/tinymce/tinymce.min.js"></script>

  <style>
    #text-nama {
      color: white;
    }
  </style>

</head>

<body class="fixed-left">
  <div class="modal fade" id="frmKonfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="jdlKonfirm">Konfirmasi Hapus</h4>
        </div>
        <div class="modal-body">
          <div id="isiKonfirm"></div>
          <input type="hidden" name="id" id="id">
          <input type="hidden" name="mode" id="mode">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal" id="yaKonfirm"><i class="fa fa-trash"></i> Hapus</button>
          <button data-dismiss="modal" class="btn btn-default" id="tidakKonfirm">Batal</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="konfirmlogout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="jdlKonfirm2">Konfirmasi Logout</h4>
        </div>
        <div class="modal-body">
          <div id="isiKonfirm2"></div>
          <input type="hidden" name="id" id="id2">
          <input type="hidden" name="mode" id="mode2">
        </div>
        <div class="modal-footer">
          <a href="<?= base_url('Login/logout') ?>" type="button" class="btn btn-default"><i class="ti-power-off"></i> Keluar</a>
          <button data-dismiss="modal" class="btn btn-danger" id="tidakKonfirm2">Batal</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="info_ok" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" style="width: 45%;" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="jdlKonfirm">Changelog</h4>
        </div>
        <div class="modal-body">
          <div id="pesan_info_ok"></div>
        </div>
        <div class="modal-footer">
          <button data-dismiss="modal" class="btn btn-danger">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  <input type="hidden" name="base_link" id="base_link" value="<?= base_url() ?>">

  <!-- Bootstrap modal -->
  <div class="modal fade" id="ubah_pass" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title"><i class="ti-lock"></i> Ubah Password</h3>
        </div>
        <form method="post" id="frm_ubahpass">
          <div class="modal-body form">
            <input type="hidden" name="pgnID" value="<?php $this->session->userdata("id_user"); ?>">
            <div class="form-group">
              <label>Password Lama</label>
              <input type="password" class="form-control infonya" name="log_pass" id="log_pass" value="" required>
            </div>
            <div class="form-group">
              <label>Password Baru</label>
              <input type="password" class="form-control infonya" name="log_passBaru" id="log_passBaru" value="" required>

            </div>
            <div class="form-group">
              <label>Konfirmasi Password Baru</label>
              <input type="password" class="form-control infonya" name="log_passBaru2" id="log_passBaru2" value="" required>
            </div>
            <div class="alert alert-danger animated fadeInDown" role="alert" id="up_infoalert">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <div id="up_pesan"></div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" id="up_simpan" class="btn btn-default"><i class="fa fa-check"></i> Simpan</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
          </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <!-- Begin page -->
  <div id="wrapper">

    <!-- Top Bar Start -->
    <div class="topbar">

      <!-- LOGO -->
      <div class="topbar-left">
        <div class="text-center">
          <a href="<?= base_url() ?>" class="logo"><img src="<?= base_url('aset/assets/images/logo.png') ?>" width="40px" id="logoo"><span style="font-size: medium;">ABSENSI MOBILE</span></a>
        </div>
      </div>

      <!-- Button mobile view to collapse sidebar menu -->
      <div class="navbar navbar-default" role="navigation">
        <div class="container">
          <div class="">
            <div class="pull-left">
              <button class="button-menu-mobile open-left waves-effect waves-light">
                <i class="md md-menu"></i>
              </button>
              <span class="clearfix"></span>
            </div>

            <ul class="nav navbar-nav navbar-right pull-right">
              <li class="hidden-xs">
                <a href="#" role="button" onClick="logout(<?= $this->session->userdata("id_user") ?>)"><i class="ti-power-off m-r-10 text-danger" role="button"></i>Logout</a>
              </li>
            </ul>
          </div>
          <!--/.nav-collapse -->
        </div>
      </div>
    </div>
    <!-- Top Bar End -->

    <!-- ========== Left Sidebar Start ========== -->

    <div class="left side-menu">
      <div class="sidebar-inner slimscrollleft">
        <div class="user-details">
          <div class="pull-left">
            <img src="<?= base_url('aset/') ?>assets/images/users/avatar-1.png" alt="" class="thumb-md img-circle">
          </div>
          <div class="user-info">
            <div class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" id="text-nama"><?= $this->session->userdata("nama") ?></a>
              <!-- <ul class="dropdown-menu">
                <li><a href="javascript:void(0)"><i class="md md-face-unlock"></i> Profile<div class="ripple-wrapper"></div></a></li>
                <li><a href="#" onClick="logout(<?= $this->session->userdata("id_user") ?>)"><i class="md md-settings-power"></i> Logout</a></li>
              </ul> -->
            </div>
            <p class="text-muted m-0"><?php if ($this->session->userdata("level") == 2) {
                                        echo "Admin HRD";
                                      } else if ($this->session->userdata("level") == 3) {
                                        echo "Karyawan";
                                      } else {
                                        echo "Administrator";
                                      } ?></p>
          </div>
        </div>
        <!--- Divider -->
        <div id="sidebar-menu">
          <ul>

            <li class="text-muted menu-title">Menu</li>

            <li class="has_sub">
              <a href="<?= base_url('Dashboard') ?>" class="waves-effect"><i class="ti-home"></i> <span> Dashboard </span></a>
            </li>
            <?php if ($this->session->userdata('level') < 3) { ?>
              <li class="has_sub">
                <a href="#menuEcommerce" data-bs-toggle="collapse" class="menu-link">
                  <span class="menu-icon"><i class="fas fa-server"></i></span>
                  <span class="menu-text"> Master Data </span>
                  <span class="menu-arrow"></span>
                </a>
                <ul class="sub-menu">
                  <li class="menu-item">
                    <a href="<?= base_url('Divisi/tampil') ?>" class="waves-effect"><span> Data Divisi </span></a>
                  </li>
                  <li class="menu-item">
                    <a href="<?= base_url('Jabatan/tampil') ?>" class="waves-effect"><span> Data Jabatan </span></a>
                  </li>
                  <li class="menu-item">
                    <a href="<?= base_url('Shift/tampil') ?>" class="waves-effect"><span> Data Shift </span></a>
                  </li>
                </ul>
              </li>
              <li class="has_sub">
                <a href="<?= base_url('Company/tampil') ?>" class="waves-effect"><i class="ti-map-alt"></i> <span> Perusahaan </span></a>
              </li>
              <li class="has_sub">
                <a href="<?= base_url('Karyawan/tampil') ?>" class="waves-effect"><i class="fas fa-users"></i> <span> Data Karyawan </span></a>
              </li>
              <li class="has_sub">
                <a href="<?= base_url('Pengguna/tampil') ?>" class="waves-effect"><i class="ti-user"></i> <span> Data Pengguna</span></a>
              </li>
              <li class="has_sub">
                <a href="<?= base_url('Absensi/tampil') ?>" class="waves-effect"><i class="fa fa-history"></i> <span> Riwayat Absensi </span></a>
              </li>
              <li class="has_sub">
                <a href="<?= base_url('Rekap/tampil') ?>" class="waves-effect"><i class="fa fa-copy"></i> <span> Rekap Absensi </span></a>
              </li>
            <?php } else { ?>
              <li class="has_sub">
                <a href="<?= base_url('Absensi/tampil') ?>" class="waves-effect"><i class="fa fa-history"></i> <span> Riwayat Absensi </span></a>
              </li>
            <?php } ?>
            <li class="has_sub">
              <a href="#" data-target="#ubah_pass" data-toggle="modal" class="waves-effect"><i class="ti-settings"></i> <span> Setting </span></a>
            </li>
            <li class="has_sub">
              <a href="#" class="btn btn-warning" style="margin: 10px;" onClick="logout(<?= $this->session->userdata("id_user") ?>)"><i class="md md-settings-power"></i><span> Logout</span></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
      <!-- Start content -->
      <div class="content">
        <div class="container">

          <script>
            function logout(id) {
              event.preventDefault();
              $("#id_user").val(id);
              $("#jdlKonfirm2").html("Konfirmasi Logout");
              $("#isiKonfirm2").html("Yakin ingin Keluar Aplikasi ?");
              $("#konfirmlogout").modal({
                show: true,
                keyboard: false,
                backdrop: 'static'
              });
            }
          </script>