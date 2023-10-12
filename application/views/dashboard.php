<?php
$day = date('D');
$dayList = array(
	'Sun' => 'Minggu',
	'Mon' => 'Senin',
	'Tue' => 'Selasa',
	'Wed' => 'Rabu',
	'Thu' => 'Kamis',
	'Fri' => 'Jumat',
	'Sat' => 'Sabtu'
);

if ($this->session->userdata('level') < 3) { ?>
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-sm-4">
				<div class="widget-panel widget-style-2 bg-white">
					<i class="fas fa-user-check text-custom"></i>
					<h2 class="m-0 text-dark counter font-600"><span data-plugin="counterup"><?= number_format($hadir, 0, ",", "."); ?></span></h2>
					<div class="text-muted m-t-5">Jumlah Hadir</div>
				</div>
			</div>
			<div class="col-lg-4 col-sm-4">
				<div class="widget-panel widget-style-2 bg-white">
					<i class="fas fa-user-clock text-custom"></i>
					<h2 class="m-0 text-dark counter font-600"><span data-plugin="counterup"><?= number_format($terlambat, 0, ",", "."); ?></span></h2>
					<div class="text-muted m-t-5">Jumlah Terlambat</div>
				</div>
			</div>
			<div class="col-lg-4 col-sm-4">
				<div class="widget-panel widget-style-2 bg-white">
					<i class="fas fa-user-times text-custom"></i>
					<h2 class="m-0 text-dark counter font-600"><span data-plugin="counterup"><?= number_format($cuti, 0, ",", "."); ?></span></h2>
					<div class="text-muted m-t-5">Jumlah Karyawan Cuti</div>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="card-box table-responsive">
					<div class="row" id="isidata">
						<h3 class="m-t-0 header-title"><b>Riwayat Absensi Hari Ini</b></h3>
						<h3 class="m-t-10 row"></h3>
						<table class="table table-striped table-bordered" width="100%">
							<thead>
								<tr>
									<th width="5%">No</th>
									<th>Tanggal</th>
									<th>Nama Karyawan</th>
									<th>Jam Masuk</th>
									<th>Jam Pulang</th>
									<th>Lokasi Absen</th>
									<th>Status</th>
									<th>Keterangan</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								if ($data) {
									foreach ($data as $dt) {
										$status = "";
										switch ($dt->abs_status) {
											case 1:
												$status = "<span class='badge badge-success'>Hadir</span>";
												break;
											case 2:
												$status = "<span class='badge badge-warning'>Terlambat</span>";
												break;
											case 3:
												$status = "<span class='badge badge-danger'>Sakit</span>";
												break;
											case 4:
												$status = "<span class='badge badge-info'>Izin</span>";
												break;
										} ?>
										<tr>
											<td><?= $no++ ?></td>
											<td><?= $dt->abs_tanggal ?></td>
											<td><?= $dt->kry_nama ?></td>
											<td><?= $dt->abs_jam_masuk ?></td>
											<td><?= $dt->abs_jam_pulang ?></td>
											<td><?= $dt->cpy_nama ?></td>
											<td><?= $status ?></td>
											<td><?= $dt->abs_ket ?></td>
										</tr>
									<?php }
								} else { ?>
									<tr>
										<td colspan="3" align="center">Tidak ada data</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } else { ?>
	<div class="container">
		<div class="row">
			<?php if (!$cek && !$cek_sakit_izin) { ?>
				<div class="col-sm-12">
					<h4><b><?= $dayList[$day] ?></b>, <?= date('d/m/Y') ?></h4>
					<div class="card-box">
						<div class="row">
							<div class="col-lg-3">
							</div>
							<div class="col-lg-6 text-center">
								<img src="<?= base_url('aset/assets/images/qr-scan.png') ?>" width="100px" style="margin-bottom: 20px">
								<div class="form-group">
									<a href="<?= base_url('Dashboard/scan') ?>" class="btn btn-success form-control"><i class="fa fa-camera"></i> Scan QR Code Absensi</a>
								</div>
							</div>
							<div class="col-lg-3">
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="card-box">
						<div class="row">
							<div class="col-lg-3">
							</div>
							<div class="col-lg-6 text-center">
								<div class="form-group">
									<a href="javascript:absen_sakit()" class="btn btn-success form-control"><i class="fa fa-exclamation-circle"></i> Absen Sakit/Izin</a>
								</div>
							</div>
							<div class="col-lg-3">
							</div>
						</div>
					</div>
				</div>
			<?php } else if ((strtotime($jam_sekarang) > strtotime($jam_pulang)) && !$cek_pulang) { ?>
				<div class="col-sm-12">
					<h4><b><?= $dayList[$day] ?></b>, <?= date('d/m/Y') ?></h4>
					<div class="card-box">
						<div class="row">
							<div class="col-lg-3">
							</div>
							<div class="col-lg-6 text-center">
								<img src="<?= base_url('aset/assets/images/qr-scan.png') ?>" width="100px" style="margin-bottom: 20px">
								<div class="form-group">
									<a href="<?= base_url('Dashboard/scan_pulang') ?>" class="btn btn-success form-control"><i class="fa fa-camera"></i> Scan QR Code Absensi</a>
								</div>
							</div>
							<div class="col-lg-3">
							</div>
						</div>
					</div>
				</div>
			<?php } else if ($cek_pulang) { ?>
				<div class="col-sm-12">
					<h4><b><?= $dayList[$day] ?></b>, <?= date('d/m/Y') ?></h4>
					<div class="card-box">
						<div class="row">
							<div class="col-lg-2">
							</div>
							<div class="col-lg-8 text-center">
								<img src="<?= base_url('aset/assets/images/done.png') ?>" width="100px" style="margin-bottom: 20px">
								<div class="form-group">
									Terimakasih atas kerja kerasnya hari ini. <br>Selamat istirahat agar besok kembali dengan semangat baru
								</div>
							</div>
							<div class="col-lg-2">
							</div>
						</div>
					</div>
				</div>
			<?php } else if ($cek_sakit_izin) { ?>
				<div class="col-sm-12">
					<h4><b><?= $dayList[$day] ?></b>, <?= date('d/m/Y') ?></h4>
					<div class="card-box">
						<div class="row">
							<div class="col-lg-2">
							</div>
							<div class="col-lg-8 text-center">
								<i class="fas fa-exclamation-circle text-warning fa-3x"></i>
								<div class="form-group">
									Anda sudah melakukan absen Sakit/Izin
								</div>
							</div>
							<div class="col-lg-2">
							</div>
						</div>
					</div>
				</div>
			<?php } else { ?>
				<div class="col-sm-12">
					<h4><b><?= $dayList[$day] ?></b>, <?= date('d/m/Y') ?></h4>
					<div class="card-box">
						<div class="row">
							<div class="col-lg-3">
							</div>
							<div class="col-lg-6 text-center">
								<img src="<?= base_url('aset/assets/images/done.png') ?>" width="100px" style="margin-bottom: 20px">
								<div class="form-group">
									Anda sudah absen masuk. <br>Silahkan tunggu waktu pulang untuk melakukan absen pulang
								</div>
							</div>
							<div class="col-lg-3">
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			<div class="col-lg-6">
				<div class="card-box">
					<div class="card-header">
						<span class="fa fa-user text-custom"></span> Identitas Diri
						<hr>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-2 p-2">
								<img class="img-thumbnail" src="<?= ($karyawan->kry_foto == NULL ? base_url('assets/img/default-profile.png') : base_url("aset/foto/karyawan/{$karyawan->kry_foto}")); ?>" class="card-img" style="width:100%;">
							</div>
							<div class="col-md-10" style="margin-top: 5px;">
								<div class="table-responsive">
									<table class="table table-bordered" style="width: 100%;">
										<tr>
											<th>Nama Lengkap</th>
											<td><?= $karyawan->kry_nama ?></td>
										</tr>
										<tr>
											<th>Ho. Handphone</th>
											<td><?= $karyawan->kry_notelp ?></td>
										</tr>
										<tr>
											<th>Alamat</th>
											<td><?= $karyawan->kry_alamat ?></td>
										</tr>
										<tr>
											<th>Company</th>
											<td><?= $karyawan->cpy_nama ?></td>
										</tr>
										<tr>
											<th>Divisi</th>
											<td><?= $karyawan->dvi_nama ?></td>
										</tr>
										<tr>
											<th>Jabatan</th>
											<td><?= $karyawan->jab_nama ?></td>
										</tr>
									</table>
								</div>
							</div>
						</div>
						<div class="card-footer">
							<hr>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<div class="modal fade" id="modal_tambah" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Absen Sakit/Izin</h3>
			</div>
			<form role="form col-lg-6" name="Tambah" id="frm_tambah">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" name="abs_kry_id" value="<?= $id_karyawan ?>">
						<input type="hidden" name="abs_tanggal" value="<?= date('Y-m-d') ?>">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Status</label>
								<select class="form-control" name="abs_status" id="abs_status">
									<option value="3">Sakit</option>
									<option value="4">Izin</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Keterangan</label>
								<input type="text" class="form-control" name="abs_ket" id="abs_ket" required>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="simpan" class="btn btn-success"><i class="fas fa-check-circle"></i> Simpan</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="reset_form()"><i class="fas fa-times-circle"></i> Batal</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- jQuery  -->
<script src="<?= base_url('aset/') ?>assets/js/jquery.min.js"></script>

<!-- DataTable -->
<script src="<?= base_url("aset"); ?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url("aset"); ?>/assets/plugins/datatables/dataTables.bootstrap.js"></script>

<script src="<?= base_url("aset"); ?>/assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?= base_url("aset"); ?>/assets/plugins/datatables/buttons.bootstrap.min.js"></script>
<script src="<?= base_url("aset"); ?>/assets/plugins/datatables/jszip.min.js"></script>
<script src="<?= base_url("aset"); ?>/assets/plugins/datatables/pdfmake.min.js"></script>
<script src="<?= base_url("aset"); ?>/assets/plugins/datatables/vfs_fonts.js"></script>
<script src="<?= base_url("aset"); ?>/assets/plugins/datatables/buttons.html5.min.js"></script>
<script src="<?= base_url("aset"); ?>/assets/plugins/datatables/buttons.print.min.js"></script>
<script src="<?= base_url("aset"); ?>/assets/plugins/datatables/dataTables.fixedHeader.min.js"></script>
<script src="<?= base_url("aset"); ?>/assets/plugins/datatables/dataTables.keyTable.min.js"></script>
<script src="<?= base_url("aset"); ?>/assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="<?= base_url("aset"); ?>/assets/plugins/datatables/responsive.bootstrap.min.js"></script>
<script src="<?= base_url("aset"); ?>/assets/plugins/datatables/dataTables.scroller.min.js"></script>
<script src="<?= base_url("aset"); ?>/assets/plugins/datatables/dataTables.colVis.js"></script>
<script src="<?= base_url("aset"); ?>/assets/plugins/datatables/dataTables.fixedColumns.min.js"></script>

<script src="<?= base_url("aset"); ?>/assets/pages/datatables.init.js"></script>

<!-- date-range-picker -->
<script src="<?= base_url("aset"); ?>/plugins/moment/moment.min.js"></script>
<script src="<?= base_url("aset"); ?>/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<script src="<?= base_url("aset"); ?>/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url("aset"); ?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Select 2 -->
<script src="<?= base_url("aset"); ?>/plugins/select2/select2.js"></script>

<!-- Toastr -->
<script src="<?= base_url("aset"); ?>/plugins/toastr/toastr.min.js"></script>

<!-- Sweet alert -->
<script src="<?= base_url(); ?>aset/plugins/sweetalert2/sweetalert2.all.min.js"></script>

<!-- Custom Java Script -->
<script>
	var save_method; //for save method string
	var table;

	function drawTable() {

	}

	function absen_sakit() {
		reset_form();
		$("frm_tambah").trigger("reset");
		$('#modal_tambah').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	function reset_form() {
		$("#frm_tambah")[0].reset();
	}

	$("#frm_tambah").submit(function(e) {
		e.preventDefault();
		$("#simpan").html("Menyimpan...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "simpan",
			data: new FormData(this),
			processData: false,
			contentType: false,
			success: function(d) {
				var res = JSON.parse(d);
				var msg = "";
				if (res.status == 1) {
					Swal.fire(
						'Sukses',
						res.desc,
						'success'
					).then((result) => {
						if (!result.isConfirmed) {
							reset_form();
							$("#modal_tambah").modal("hide");
							window.location.href = "<?= base_url('Dashboard/tampil') ?>";
						} else {}
					})
				} else {
					toastr.error(res.desc);
				}
				$("#simpan").html("Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#simpan").html("Simpan");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});

	$(document).ready(function() {
		drawTable();
	});
</script>