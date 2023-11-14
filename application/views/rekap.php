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
	<div class="col-md-2 col-xs-6">
		<div class="form-group">
			<a href="javascript:drawTable()" class="btn btn-default btn-block"><i class="fa fa-refresh"></i> &nbsp;&nbsp;&nbsp; Refresh</a>
		</div>
	</div>
	<div class="col-md-2 col-xs-6">
		<a href="javascript:cetak()" class="btn btn-success btn-block"><i class="fa fa-print"></i> &nbsp;&nbsp;&nbsp; Cetak</a>
	</div>
	<?php if ($this->session->userdata('level') < 3) { ?>
		<div class="col-md-3 col-xs-12">
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
				<select class="form-control select2" id="company" onChange="filter_cpy(this.value)">
					<option value="">Filter Company</option>
					<?php foreach ($company as $q) { ?>
						<option value="<?= $q->cpy_kode ?>"><?= $q->cpy_nama ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
	<?php } else if ($this->session->userdata('level') == 3) { ?>
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
	<?php } ?>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="card-box table-responsive">
			<div class="row" id="isidata">
				<h3 class="m-t-0 header-title"><b>Rekap Absensi</b></h3>
				<h3 class="m-t-10 row"></h3>
				<table id="tabel-data" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th width="5%">No</th>
							<th>Nama</th>
							<th>Bulan</th>
							<th>Hadir</th>
							<th>Sakit</th>
							<th>Izin</th>
							<th>Alfa</th>
							<th>Cuti</th>
							<th>Terlambat</th>
							<th>Denda</th>
							<th>Edit</th>
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

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_edit" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Edit Data</h3>
			</div>
			<form role="form col-lg-6" name="Edit" id="frm_edit">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" name="rkp_id" id="rkp_id" value="">
						<div class="col-lg-3">
							<div class="form-group">
								<label>Jumlah Sakit</label>
								<input type="number" min="0" class="form-control" name="rkp_sakit" id="rkp_sakit">
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<label>Jumlah Izin</label>
								<input type="number" min="0" class="form-control" name="rkp_izin" id="rkp_izin">
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<label>Jumlah Alfa</label>
								<input type="number" min="0" class="form-control" name="rkp_alfa" id="rkp_alfa">
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<label>Jumlah Cuti</label>
								<input type="number" min="0" class="form-control" name="rkp_cuti" id="rkp_cuti">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="simpan" class="btn btn-default">Simpan</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="reset_form()">Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>

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
				"url": "Rekap/ajax_list_rekap/" + karyawan + '/' + bulan + '/' + company,
				"type": "POST"
			},
			//Set column definition initialisation properties.
			"columnDefs": [{
				"targets": [-1], //last column
				"orderable": false, //set not orderable
			}, ],
			"initComplete": function(settings, json) {
				$("#process").html("<i class='fas fa-refresh'></i> Process")
				$(".btn").attr("disabled", false);
				$("#isidata").fadeIn();
			}
		});
	}

	function ubah_data(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "Rekap/cari",
			data: "rkp_id=" + id,
			dataType: "json",
			success: function(data) {
				var obj = Object.entries(data);
				obj.map((dt) => {
					$("#" + dt[0]).val(dt[1]);
				});
				$(".inputan").attr("disabled", false);
				$("#modal_edit").modal({
					show: true,
					keyboard: false,
					backdrop: 'static'
				});
				return false;
			}
		});
	}

	$("#frm_edit").submit(function(e) {
		e.preventDefault();
		$("#simpan").html("Menyimpan...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "Rekap/simpan",
			data: new FormData(this),
			processData: false,
			contentType: false,
			success: function(d) {
				var res = JSON.parse(d);
				var msg = "";
				if (res.status == 1) {
					toastr.success(res.desc);
					drawTable();
					$("#modal_edit").modal("hide");
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

	function filter(fil) {
		drawTable();
	}

	function filter_bln(filter) {
		drawTable();
	}

	function filter_cpy(ftr) {
		drawTable();
	}

	function cetak() {
		var kry = $('#karyawan').val();
		var bln = $('#bulan').val();
		var cpy = $('#company').val();
		if (!kry) kry = null;
		if (!bln) bln = null;
		if (!cpy) cpy = null;
		window.open("<?= base_url('Rekap/cetak/') ?>" + kry + "/" + bln + "/" + cpy, "_blank");
		window.location.href = "<?= base_url('Rekap') ?>";
	}

	$('.select2').select2({
		className: "form-control"
	});

	$(document).ready(function() {
		drawTable();
	});
</script>