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
	<?php if ($this->session->userdata('level') != 3) { ?>
		<div class="col-md-2 col-xs-12">
			<div class="form-group">
				<select class="form-control" id="karyawan" onChange="filter(this.value)">
					<option value="">Filter Karyawan</option>
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
				<select class="form-control" id="company" onChange="filter_cpy(this.value)">
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
				<h3 class="m-t-0 header-title"><b>Rekap Absensi</b></h3>
				<h3 class="m-t-10 row"></h3>
				<table id="tabel-data" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th width="5%">No</th>
							<th>Nama Karyawan</th>
							<th>Bulan</th>
							<th>Hadir</th>
							<th>Terlambat</th>
							<th>Sakit</th>
							<th>Izin</th>
							<th>Denda</th>
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
				"url": "ajax_list_rekap/" + karyawan + '/' + bulan + '/' + company,
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
		window.location.href = "<?= base_url('Rekap/tampil') ?>";
	}

	$(document).ready(function() {
		drawTable();
	});
</script>