<input type="hidden" name="pdd_kry_id" id="pdd_kry_id" value="<?= $id ?>">
<div class="row">
	<div class="col-md-2 col-xs-6">
		<div class="form-group">
			<a href="javascript:tambah()" class="btn btn-default btn-block"><i class="fa fa-plus-circle"></i> Tambah</a>
		</div>
	</div>
	<div class="col-md-2 col-xs-6">
		<div class="form-group">
			<a href="javascript:drawTable()" class="btn btn-default btn-block"><i class="fa fa-refresh"></i> Refresh</a>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="card-box table-responsive">
			<div class="row" id="isidata">
				<h3 class="m-t-0 header-title"><a href="javascript:window.history.back()" class="btn btn-default btn-xs"><i class="fas fa-share fa-flip-horizontal"></i> Back</a><b> Data Pendidikan Karyawan</b></h3>
				<h3 class="m-t-10 row"></h3>
				<table id="tabel-data" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th width="5%">No</th>
							<th>Pendidikan</th>
							<th>Keahlian</th>
							<th>Sekolah / Universitas</th>
							<th>Jurusan</th>
							<th>Tahun Masuk</th>
							<th>Tahun Lulus</th>
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
<div class="modal fade" id="modal_pendidikan" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><i class="fas fa-user-graduate fa-xs"></i> Form Data Pendidikan</h3>
			</div>
			<form role="form col-lg-6" name="Pendidikan" id="frm_pendidikan">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" id="pdd_id" name="pdd_id" value="">
						<input type="hidden" id="pdd_kry_id" name="pdd_kry_id" value="<?= $id ?>">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Tingkat Pendidikan</label>
								<select class="form-control" name="pdd_last_education" id="pdd_last_education" required>
									<option value="SMA/SMK">SMA/SMK</option>
									<option value="D1">D1</option>
									<option value="D2">D2</option>
									<option value="D3">D3</option>
									<option value="S1">S1</option>
									<option value="S2">S2</option>
									<option value="S3">S3</option>
									<option value="Lainnya">Lainnya</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Keahlian</label>
								<input type="text" class="form-control" name="pdd_keahlian" id="pdd_keahlian" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nama Sekolah/Universitas</label>
								<input type="text" class="form-control" name="pdd_school_name" id="pdd_school_name">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Jurusan / Bidang Studi</label>
								<input type="text" class="form-control" name="pdd_jurusan" id="pdd_jurusan">
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<label>Tahun Masuk</label>
								<input type="number" min="0" class="form-control" name="pdd_thn_masuk" id="pdd_thn_masuk" required>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<label>Tahun Lulus</label>
								<input type="number" min="0" class="form-control" name="pdd_thn_lulus" id="pdd_thn_lulus" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Foto Ijazah</label><small><i> (ukuran foto 1080 x 1080 pixel)</i></small>
								<div id="preview"></div>
								<input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="pdd_ijazah" id="pdd_ijazah">
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
	var id = $('#pdd_kry_id').val();

	function drawTable() {
		$('#tabel-data').DataTable({
			"destroy": true,
			dom: 'Bfrtip',
			lengthMenu: [
				[10, 25, 50, -1],
				['10 rows', '25 rows', '50 rows', 'Show all']
			],
			buttons: [],
			"responsive": true,
			"sort": true,
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.
			// Load data for the table's content from an Ajax source
			"ajax": {
				"url": "../ajax_list_pendidikan_karyawan/" + id,
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
		$("#pdd_id").val(0);
		$("frm_pendidikan").trigger("reset");
		$('#modal_pendidikan').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	$("#frm_pendidikan").submit(function(e) {
		e.preventDefault();
		$("#simpan").html("Menyimpan...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "../simpan",
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
					$("#modal_pendidikan").modal("hide");
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

	function hapus_pendidikan(id) {
		event.preventDefault();
		$("#pdd_id").val(id);
		$("#jdlKonfirm").html("Konfirmasi hapus data");
		$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
		$("#frmKonfirm").modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	function ubah_pendidikan(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "../cari",
			data: "pdd_id=" + id,
			dataType: "json",
			success: function(data) {
				var obj = Object.entries(data);
				obj.map((dt) => {
					if (dt[0] == "pdd_ijazah") {
						$("#preview").append('<img src="<?= base_url('aset/foto/ijazah/') ?>' + dt[1] + '" width="100px">');
						$("#pdd_ijazah").val();
					} else {
						$("#" + dt[0]).val(dt[1]);
					}
				});
				$(".inputan").attr("disabled", false);
				$("#modal_pendidikan").modal({
					show: true,
					keyboard: false,
					backdrop: 'static'
				});
				return false;
			}
		});
	}

	function reset_form() {
		$("#pdd_id").val(0);
		$("#frm_pendidikan")[0].reset();
		$("#preview").html('');
	}

	$("#yaKonfirm").click(function() {
		var id = $("#pdd_id").val();

		$("#isiKonfirm").html("Sedang menghapus data...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "GET",
			url: "../hapus/" + id,
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