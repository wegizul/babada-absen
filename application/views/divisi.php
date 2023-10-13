<div class="row">
	<div class="col-md-2 col-xs-6">
		<div class="form-group">
			<a href="javascript:tambah()" class="btn btn-default btn-block"><i class="fa fa-plus-circle"></i> &nbsp;&nbsp;&nbsp; Tambah</a>
		</div>
	</div>
	<div class="col-md-2 col-xs-6">
		<div class="form-group">
			<a href="javascript:drawTable()" class="btn btn-default btn-block"><i class="fa fa-refresh"></i> &nbsp;&nbsp;&nbsp; Refresh</a>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="card-box table-responsive">
			<div class="row" id="isidata">
				<h3 class="m-t-0 header-title"><b>Data Divisi</b></h3>
				<h3 class="m-t-10 row"></h3>
				<table id="tabel-data" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th width="5%">No</th>
							<th>Kode Divisi</th>
							<th>Nama Divisi</th>
							<th>Aksi</th>
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
<div class="modal fade" id="modal_divisi" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Form Divisi</h3>
			</div>
			<form role="form col-lg-6" name="Divisi" id="frm_divisi">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" id="dvi_id" name="dvi_id" value="">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Kode Divisi</label>
								<input type="text" class="form-control" name="dvi_kode" id="dvi_kode" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nama Divisi</label>
								<input type="text" class="form-control" name="dvi_nama" id="dvi_nama" required>
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
<script src="<?= base_url("aset"); ?>/plugins/select2/select2.js"></script>

<!-- Toastr -->
<script src="<?= base_url("aset"); ?>/plugins/toastr/toastr.min.js"></script>

<!-- Custom Java Script -->
<script>
	var save_method; //for save method string
	var table;

	function drawTable() {
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
				"url": "ajax_list_divisi/",
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

	function tambah() {
		reset_form();
		$("#dvi_id").val(0);
		$("frm_divisi").trigger("reset");
		$('#modal_divisi').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	$("#frm_divisi").submit(function(e) {
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
					toastr.success(res.desc);
					drawTable();
					reset_form();
					$("#modal_divisi").modal("hide");
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

	function hapus_divisi(id) {
		event.preventDefault();
		$("#dvi_id").val(id);
		$("#jdlKonfirm").html("Konfirmasi hapus data");
		$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
		$("#frmKonfirm").modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	function ubah_divisi(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "cari",
			data: "dvi_id=" + id,
			dataType: "json",
			success: function(data) {
				var obj = Object.entries(data);
				obj.map((dt) => {
					$("#" + dt[0]).val(dt[1]);
				});
				$(".inputan").attr("disabled", false);
				$("#modal_divisi").modal({
					show: true,
					keyboard: false,
					backdrop: 'static'
				});
				return false;
			}
		});
	}

	function reset_form() {
		$("#dvi_id").val(0);
		$("#frm_divisi")[0].reset();
	}

	$("#yaKonfirm").click(function() {
		var id = $("#dvi_id").val();

		$("#isiKonfirm").html("Sedang menghapus data...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "GET",
			url: "hapus/" + id,
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

	$(document).ready(function() {
		drawTable();
	});
</script>