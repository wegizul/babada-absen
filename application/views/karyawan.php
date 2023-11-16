<style>
	.lihatfoto {
		display: block;
		margin-left: auto;
		margin-right: auto;
	}

	.tutup {
		margin-left: 95%;
	}
</style>
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
			<select class="form-control select2" id="company" onChange="filter_cpy(this.value)">
				<option value="">Filter Company</option>
				<?php foreach ($company as $q) { ?>
					<option value="<?= $q->cpy_kode ?>"><?= $q->cpy_nama ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="card-box table-responsive">
			<div class="row" id="isidata">
				<h3 class="m-t-0 header-title"><b>Data Karyausahawan</b></h3>
				<h3 class="m-t-10 row"></h3>
				<table id="tabel-data" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th width="5%">No</th>
							<th>Foto</th>
							<th>Nama</th>
							<th>Jenis Kelamin</th>
							<th>No. Handphone</th>
							<th>Perusahaan</th>
							<th>Status</th>
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
<div class="modal fade" id="modal_tambah" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Form Karyausahawan</h3>
			</div>
			<form role="form" name="Tambah" id="frm_tambah">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" id="kry_id" name="kry_id" value="">
						<div class="col-lg-4">
							<div class="form-group">
								<label>NIK</label>
								<input type="text" class="form-control" name="kry_kode" id="kry_kode" required>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Nomor KTP</label>
								<input type="number" min="0" class="form-control" name="kry_no_ktp" id="kry_no_ktp" required>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Nama Lengkap</label>
								<input type="text" class="form-control" name="kry_nama" id="kry_nama" required>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Jenis Kelamin</label>
								<select class="form-control" name="kry_jk" id="kry_jk">
									<option value="1">Laki-laki</option>
									<option value="2">Perempuan</option>
								</select>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>No. Handphone</label>
								<input type="number" min="0" class="form-control" name="kry_notelp" id="kry_notelp" required>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Alamat</label>
								<input type="text" class="form-control" name="kry_alamat" id="kry_alamat" required>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Tempat Lahir</label>
								<input type="text" class="form-control" name="kry_tpt_lahir" id="kry_tpt_lahir">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Tanggal Lahir</label>
								<input type="date" class="form-control" name="kry_tgl_lahir" id="kry_tgl_lahir">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Golongan Darah</label>
								<select class="form-control" name="kry_gol_darah" id="kry_gol_darah">
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="AB">AB</option>
									<option value="O">O</option>
									<option value="Tidak Tahu">Tidak Tahu</option>
								</select>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Riwayat Penyakit</label>
								<input type="text" class="form-control" name="kry_penyakit" id="kry_penyakit">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Status Pernikahan</label>
								<select class="form-control" name="kry_status_nikah" id="kry_status_nikah">
									<option value="Belum Menikah">Belum Menikah</option>
									<option value="Menikah">Menikah</option>
									<option value="Janda">Janda</option>
									<option value="Duda">Duda</option>
								</select>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Tanggal Masuk</label>
								<input type="date" class="form-control" name="kry_tgl_masuk" id="kry_tgl_masuk">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Perusahaan</label>
								<select class="form-control" name="kry_cpy_kode" id="kry_cpy_kode" required>
									<option value="">Pilih Perusahaan</option>
									<?php foreach ($company as $com) { ?>
										<option value="<?= $com->cpy_kode ?>"><?= $com->cpy_nama ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Divisi</label>
								<select class="form-control" name="kry_dvi_id" id="kry_dvi_id" required>
									<option value="">Pilih Divisi</option>
									<?php foreach ($divisi as $dvi) { ?>
										<option value="<?= $dvi->dvi_id ?>"><?= $dvi->dvi_nama ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Jabatan</label>
								<select class="form-control" name="kry_jab_id" id="kry_jab_id" required>
									<option value="">Pilih Jabatan</option>
									<?php foreach ($jabatan as $jab) { ?>
										<option value="<?= $jab->jab_id ?>"><?= $jab->jab_nama ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Foto</label><small><i> (ukuran foto 1080 x 1080 pixel)</i></small>
								<div id="preview"></div>
								<input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="kry_foto" id="kry_foto">
							</div>
						</div>
						<div class="col-lg-8">
							<div class="form-group">
								<label>Link Map Rumah</label>
								<input type="text" class="form-control" name="kry_map_rumah" id="kry_map_rumah">
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

<div class="modal fade" id="modal_resign" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><i class="fas fa-user-slash fa-xs"></i> Form Resign</h3>
			</div>
			<form role="form" name="Resign" id="frm_resign">
				<div class="modal-body form">
					<input type="hidden" id="kry_id2" name="kry_id" value="">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label>Apakah Karyawan ini Resign ?</label>
								<select class="form-control" name="kry_status" id="kry_status" required>
									<option value="1">Tidak</option>
									<option value="3">Iya</option>
								</select>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label>Keterangan Resign</label>
								<input type="text" class="form-control" name="kry_resign" id="kry_resign">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="simpan_resign" class="btn btn-default">Simpan</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="reset_form()">Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_foto" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<button type="button" class="btn btn-default tutup" data-dismiss="modal" onclick="reset_form()">X</button>
			<div class="modal-body form">
				<div id="preview2"></div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_lihat" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><i class="fas fa-user-tie fa-xs"></i> Data Karyausahawan <small><i>(id karyausahawan : <span id="kry_id3"></span>)</i></small></h3>
			</div>
			<form role="form" name="Lihat" id="frm_lihat">
				<div class="modal-body form">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<div id="preview3"></div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>No. Induk Karyausahawan</label><br>
								<input type="text" class="form-control" id="kry_kode3" disabled></input>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Perusahaan</label><br>
								<select class="form-control" id="kry_cpy_kode3" disabled>
									<?php foreach ($company as $c) { ?>
										<option value="<?= $c->cpy_kode ?>"><?= $c->cpy_nama ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Divisi</label><br>
								<select class="form-control" id="kry_dvi_id3" disabled>
									<?php foreach ($divisi as $dvi) { ?>
										<option value="<?= $dvi->dvi_id ?>"><?= $dvi->dvi_nama ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Jabatan</label><br>
								<select class="form-control" id="kry_jab_id3" disabled>
									<?php foreach ($jabatan as $j) { ?>
										<option value="<?= $j->jab_id ?>"><?= $j->jab_nama ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Tanggal Masuk</label><br>
								<input type="text" class="form-control" id="kry_tgl_masuk3" disabled></input>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nama Karyausahawan</label><br>
								<span id="kry_nama3"></span>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Status Nikah</label><br>
								<span id="kry_status_nikah3"></span>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Jenis Kelamin</label><br>
								<span id="kry_jk3"></span>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Golongan Darah</label><br>
								<span id="kry_gol_darah3"></span>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nomor Handphone</label><br>
								<span id="kry_notelp3"></span>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Riwayat Penyakit</label><br>
								<span id="kry_penyakit3"></span>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Tempat, Tanggal Lahir</label><br>
								<span id="kry_tpt_lahir3"></span>, <span id="kry_tgl_lahir3"></span>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Map Rumah</label><br>
								<span id="kry_map_rumah3"></span>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nomor KTP</label><br>
								<span id="kry_no_ktp3"></span>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Status</label><br>
								<span id="kry_status3"></span>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Alamat</label><br>
								<span id="kry_alamat3"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="reset_form()">Tutup</button>
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
		var company = $('#company').val();
		if (!karyawan) karyawan = null;
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
				"url": "Karyawan/ajax_list_karyawan/" + karyawan + "/" + company,
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
		$("#kry_id").val(0);
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
			url: "Karyawan/simpan",
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

	function hapus_karyawan(id) {
		event.preventDefault();
		$("#kry_id").val(id);
		$("#jdlKonfirm").html("Konfirmasi hapus data");
		$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
		$("#frmKonfirm").modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	function ubah_karyawan(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "Karyawan/cari",
			data: "kry_id=" + id,
			dataType: "json",
			success: function(data) {
				var obj = Object.entries(data);
				obj.map((dt) => {
					if (dt[0] == "kry_foto") {
						$("#preview").append('<img src="<?= base_url('aset/foto/karyawan/') ?>' + dt[1] + '" width="100px">');
						$("#kry_foto").val();
					} else {
						$("#" + dt[0]).val(dt[1]);
					}
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

	function resign_karyawan(id) {
		$.ajax({
			type: "POST",
			url: "Karyawan/cari",
			data: "kry_id=" + id,
			dataType: "json",
			success: function(data) {
				if (data) {
					var obj = Object.entries(data);
					$("#kry_id2").val(data.kry_id);
					$("#kry_status").val(data.kry_status);
					$("#kry_resign").val(data.kry_resign);
				}
				$(".inputan").attr("disabled", false);
				$("#modal_resign").modal({
					show: true,
					keyboard: false,
					backdrop: 'static'
				});
				return false;
			}
		});
	}

	$("#frm_resign").submit(function(e) {
		e.preventDefault();
		$("#simpan_resign").html("Menyimpan...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "Karyawan/simpan_resign",
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
					$("#modal_resign").modal("hide");
				} else {
					toastr.error(res.desc);
				}
				$("#simpan_resign").html("Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#simpan_resign").html("Simpan");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});

	function lihat_foto(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "Karyawan/cari",
			data: "kry_id=" + id,
			dataType: "json",
			success: function(data) {
				var obj = Object.entries(data);
				obj.map((dt) => {
					if (dt[0] == "kry_foto") {
						$("#preview2").append('<img src="<?= base_url('aset/foto/karyawan/') ?>' + dt[1] + '" width="100%" class="lihatfoto">');
					} else {
						$("#" + dt[0]).val(dt[1]);
					}
				});
				$("#modal_foto").modal({
					show: true,
					keyboard: false,
					backdrop: 'static'
				});
				return false;
			}
		});
	}

	function reset_form() {
		$("#kry_id").val(0);
		$("#frm_tambah")[0].reset();
		$("#preview").html('');
		$("#preview2").html('');
		$("#preview3").html('');
	}

	$("#yaKonfirm").click(function() {
		var id = $("#kry_id").val();

		$("#isiKonfirm").html("Sedang menghapus data...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "GET",
			url: "Karyawan/hapus/" + id,
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

	function filter(fil) {
		drawTable();
	}

	function filter_cpy(ftr) {
		drawTable();
	}

	function lihat_karyawan(id) {
		$.ajax({
			type: "POST",
			url: "Karyawan/cari",
			data: "kry_id=" + id,
			dataType: "json",
			success: function(data) {
				var obj = Object.entries(data);
				obj.map((dt) => {
					if (dt[0] == "kry_foto") {
						if (dt[1] != null) {
							$("#preview3").append('<img src="<?= base_url('aset/foto/karyawan/') ?>' + dt[1] + '" width="80%">');
						} else {
							$("#preview3").append('<img src="<?= base_url('aset/assets/images/users/avatar-1.png') ?>" width="80%">');
						}
					} else {
						if (dt[0] == "kry_kode" || dt[0] == "kry_cpy_kode" || dt[0] == "kry_tgl_masuk" || dt[0] == "kry_dvi_id" || dt[0] == "kry_jab_id") {
							$("#" + dt[0] + "3").val(dt[1]);
						} else {
							$("#" + dt[0] + "3").text(dt[1]);
						}

						if (dt[1] == 1) {
							if (dt[0] == "kry_jk") {
								$("#" + dt[0] + "3").text("Laki-laki");
							}
							if (dt[0] == "kry_status") {
								$("#" + dt[0] + "3").text("Aktif");
							}
						} else {
							if (dt[0] == "kry_jk") {
								$("#" + dt[0] + "3").text("Perempuan");
							}
							if (dt[0] == "kry_status") {
								$("#" + dt[0] + "3").text("Tidak Aktif");
							}
						}
					}
				});
				$("#modal_lihat").modal({
					show: true,
					keyboard: false,
					backdrop: 'static'
				});
				return false;
			}
		});
	}

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