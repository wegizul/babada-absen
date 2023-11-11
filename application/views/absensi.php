<?php
$bulan = [
	'1' => 'Januari',
	'2' => 'Februari',
	'3' => 'Maret',
	'4' => 'April',
	'5' => 'Mei',
	'6' => 'Juni',
	'7' => 'Juli',
	'8' => 'Agustus',
	'9' => 'September',
	'10' => 'Oktober',
	'11' => 'November',
	'12' => 'Desember',
]
?>
<div class="row">
	<?php if ($this->session->userdata('level') > 2) { ?>
		<div class="col-md-4 col-xs-12">
			<div class="form-group">
				<div class="card-box">Total Denda Terlambat : <b>Rp <?= $total_denda ?></b></div>
			</div>
		</div>
	<?php } ?>
	<?php if ($this->session->userdata('level') < 3) { ?>
		<?php if ($this->session->userdata('id_user') == 509) { ?>
			<div class="col-md-1 col-xs-12">
				<div class="form-group">
					<a href="javascript:tambah()" class="btn btn-default btn-block"><i class="fa fa-plus-circle"></i> Add</a>
				</div>
			</div>
		<?php } ?>
		<div class="col-md-2 col-xs-12">
			<div class="form-group">
				<select class="form-control select2" id="karyawan" onChange="filter(this.value)">
					<option value="">Filter Karyausahawan</option>
					<?php foreach ($karyawan as $p) { ?>
						<option value="<?= $p->kry_id ?>"><?= $p->kry_nama ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-md-2 col-xs-12">
			<div class="form-group">
				<select class="form-control" id="bulan" onChange="filter_bln(this.value)">
					<option value="">Filter Bulan</option>
					<?php foreach ($bulan as $key => $b) { ?>
						<option value="<?= $key ?>"><?= $b ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-md-2 col-xs-12">
			<div class="form-group">
				<select class="form-control select2" id="company" onChange="filter_cpy(this.value)">
					<option value="">Filter Company</option>
					<?php foreach ($company as $q) { ?>
						<option value="<?= $q->cpy_kode ?>"><?= $q->cpy_nama ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
	<?php } ?>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="card-box table-responsive">
			<div class="row" id="isidata">
				<h3 class="m-t-0 header-title"><b>Riwayat Absensi</b></h3>
				<h3 class="m-t-10 row"></h3>
				<table id="tabel-data" class="table table-striped table-bordered" style="font-size: small;">
					<thead>
						<tr>
							<th width="5%">No</th>
							<th>Tanggal</th>
							<th>Nama</th>
							<th>Masuk</th>
							<th>Pulang</th>
							<th>Lokasi Masuk</th>
							<th>Lokasi Pulang</th>
							<th>Status</th>
							<th>Keterangan</th>
							<?php if ($this->session->userdata('level') < 3) { ?>
								<th>Aksi</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="3" align="center">Tidak ada data</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_tambah" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Form Absensi</h3>
			</div>
			<form role="form col-lg-6" name="Tambah" id="frm_tambah">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" id="abs_id" name="abs_id" value="">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nama Karyausahawan</label>
								<select class="form-control select2" name="abs_kry_id" id="abs_kry_id" style="width:100%;line-height:100px;" required>
									<option value="">Pilih Karyausahawan</option>
									<?php foreach ($karyawan as $p) { ?>
										<option value="<?= $p->kry_id ?>"><?= $p->kry_nama ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Lokasi Masuk</label>
								<select class="form-control select2" name="abs_cpy_kode" id="abs_cpy_kode" required>
									<option value="">Pilih Perusahaan</option>
									<?php foreach ($company as $com) { ?>
										<option value="<?= $com->cpy_kode ?>"><?= $com->cpy_nama ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Tanggal</label>
								<input type="date" class="form-control" name="abs_tanggal" id="abs_tanggal" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Pilih Shift</label>
								<select class="form-control" name="abs_shift_id" id="abs_shift_id">
									<option value="0">Bukan Shift</option>
									<option value="1">Shift Pagi</option>
									<option value="2">Shift Siang</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Jam Masuk</label>
								<input type="time" class="form-control" name="abs_jam_masuk" id="abs_jam_masuk" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Jam Pulang</label>
								<input type="time" class="form-control" name="abs_jam_pulang" id="abs_jam_pulang">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Tambahkan Keterangan</label><small><i> (Optional)</i></small>
								<input type="text" class="form-control" name="abs_ket" id="abs_ket">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Lokasi Pulang</label>
								<select class="form-control select2" name="abs_cpy_pulang" id="abs_cpy_pulang">
									<option value="">Pilih Perusahaan</option>
									<?php foreach ($company as $com) { ?>
										<option value="<?= $com->cpy_kode ?>"><?= $com->cpy_nama ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="simpan" class="btn btn-default">Simpan</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="reset_form()">Batal</button>
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
<script src="<?= base_url("aset"); ?>/plugins/select2/js/select2.full.js"></script>

<!-- Toastr -->
<script src="<?= base_url("aset"); ?>/plugins/toastr/toastr.min.js"></script>

<!-- Custom Java Script -->
<script>
	var save_method; //for save method string
	var table;

	function drawTable() {
		var karyawan = $('#karyawan').val();
		var bulan = $('#bulan').val();
		var company = $('#company').val();
		if (!karyawan) karyawan = null;
		if (!bulan) bulan = null;
		if (!company) company = null;
		$('#tabel-data').DataTable({
			"destroy": true,
			dom: 'Bfrtip',
			lengthMenu: [
				[10, 25, 50, -1],
				['10 rows', '25 rows', '50 rows', 'Show all']
			],
			buttons: [
				'pageLength'
			],
			"responsive": true,
			"sort": true,
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.
			// Load data for the table's content from an Ajax source
			"ajax": {
				"url": "Absensi/ajax_list_absensi/" + karyawan + '/' + bulan + '/' + company + '/' + 1,
				"type": "POST"
			},
			//Set column definition initialisation properties.
			"columnDefs": [{
				"targets": [-1, -3], //last column
				"orderable": false, //set not orderable
			}, ],
			"initComplete": function(settings, json) {
				$("#process").html("<i class='fas fa-refresh'></i> Process")
				$(".btn").attr("disabled", false);
				$("#isidata").fadeIn();
			}
		});
	}

	function filter(fil) {
		drawTable();
	}

	function filter_bln(filter) {
		drawTable();
	}

	function filter_cpy(ftr) {
		drawTable();
	}

	function tambah() {
		reset_form();
		$("#abs_id").val(0);
		$("frm_tambah").trigger("reset");
		$('#modal_tambah').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	$("#frm_tambah").submit(function(e) {
		e.preventDefault();
		$("#simpan").html("Menyimpan...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "Absensi/simpan_absen_manual",
			data: new FormData(this),
			processData: false,
			contentType: false,
			success: function(d) {
				var res = JSON.parse(d);
				var msg = "";
				if (res.status == 1) {
					toastr.success(res.desc);
					drawTable();
					reset_form();
					$("#modal_tambah").modal("hide");
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

	function hapus_absensi(id) {
		event.preventDefault();
		$("#abs_id").val(id);
		$("#jdlKonfirm").html("Konfirmasi hapus data");
		$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
		$("#frmKonfirm").modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	function ubah_absensi(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "Absensi/cari",
			data: "abs_id=" + id,
			dataType: "json",
			success: function(data) {
				var obj = Object.entries(data);
				obj.map((dt) => {
					$("#" + dt[0]).val(dt[1]);
				});
				$(".inputan").attr("disabled", false);
				$("#modal_tambah").modal({
					show: true,
					keyboard: false,
					backdrop: 'static'
				});
				return false;
			}
		});
	}

	function reset_form() {
		$("#abs_id").val(0);
		$("#frm_tambah")[0].reset();
	}

	$("#yaKonfirm").click(function() {
		var id = $("#abs_id").val();

		$("#isiKonfirm").html("Sedang menghapus data...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "GET",
			url: "Absensi/hapus/" + id,
			success: function(d) {
				var res = JSON.parse(d);
				var msg = "";
				if (res.status == 1) {
					toastr.success(res.desc);
					$("#frmKonfirm").modal("hide");
					drawTable();
				} else {
					toastr.error(res.desc + "[" + res.err + "]");
				}
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});
	});

	$('.tgl').daterangepicker({
		locale: {
			format: 'DD/MM/YYYY'
		},
		showDropdowns: true,
		singleDatePicker: true,
		"autoAplog": true,
		opens: 'left'
	});

	$('.select2').select2({
		className: "form-control"
	});

	$(document).ready(function() {
		drawTable();
	});
</script>