<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <h3 class="m-t-0 header-title"><i class="fas fa-user-tie fa-sm"></i> <b>Data Karyawan</b></h3>
            <h3 class="m-t-10 row"></h3>
            <form role="form" name="Tambah" id="frm_tambah">
                <div class="modal-body form">
                    <div class="row">
                        <input type="hidden" name="kry_id" id="kry_id" value="<?= $karyawan->kry_id ?>">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>NIK</label>
                                <input type="text" class="form-control" name="kry_kode" id="kry_kode" value="<?= $karyawan->kry_kode ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Nomor KTP</label>
                                <input type="number" min="0" class="form-control" name="kry_no_ktp" id="kry_no_ktp" value="<?= $karyawan->kry_no_ktp ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Nama karyawan</label>
                                <input type="text" class="form-control" name="kry_nama" id="kry_nama" value="<?= $karyawan->kry_nama ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select class="form-control" name="kry_jk" id="kry_jk">
                                    <?php if ($karyawan->kry_jk == 1) { ?>
                                        <option value="1">Laki-laki</option>
                                        <option value="2">Perempuan</option>
                                    <?php } else { ?>
                                        <option value="2">Perempuan</option>
                                        <option value="1">Laki-laki</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>No. Handphone</label>
                                <input type="number" min="0" class="form-control" name="kry_notelp" id="kry_notelp" value="<?= $karyawan->kry_notelp ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" class="form-control" name="kry_alamat" id="kry_alamat" value="<?= $karyawan->kry_alamat ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Tempat Lahir</label>
                                <input type="text" class="form-control" name="kry_tpt_lahir" id="kry_tpt_lahir" value="<?= $karyawan->kry_tpt_lahir ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="date" class="form-control" name="kry_tgl_lahir" id="kry_tgl_lahir" value="<?= $karyawan->kry_tgl_lahir ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Golongan Darah</label>
                                <select class="form-control" name="kry_gol_darah" id="kry_gol_darah">
                                    <option value="<?= $karyawan->kry_gol_darah ?>"><?= $karyawan->kry_gol_darah ?> (dipilih)</option>
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
                                <input type="text" class="form-control" name="kry_penyakit" id="kry_penyakit" value="<?= $karyawan->kry_penyakit ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Status Pernikahan</label>
                                <select class="form-control" name="kry_status_nikah" id="kry_status_nikah">
                                    <option value="<?= $karyawan->kry_status_nikah ?>"><?= $karyawan->kry_status_nikah ?> (dipilih)</option>
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
                                <input type="date" class="form-control" name="kry_tgl_masuk" id="kry_tgl_masuk" value="<?= $karyawan->kry_tgl_masuk ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Perusahaan</label>
                                <select class="form-control" name="kry_cpy_kode" id="kry_cpy_kode" required>
                                    <option value="<?= $karyawan->kry_cpy_kode ?>"><?= $karyawan->cpy_nama ?> (dipilih)</option>
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
                                    <option value="<?= $karyawan->kry_dvi_id ?>"><?= $karyawan->dvi_nama ?> (dipilih)</option>
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
                                    <option value="<?= $karyawan->kry_jab_id ?>"><?= $karyawan->jab_nama ?> (dipilih)</option>
                                    <?php foreach ($jabatan as $jab) { ?>
                                        <option value="<?= $jab->jab_id ?>"><?= $jab->jab_nama ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Foto</label><small><i> (ukuran foto 1080 x 1080 pixel)</i></small>
                                <div><img src="<?= base_url('aset/foto/karyawan/' . $karyawan->kry_foto) ?>" width="100px"></div>
                                <input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="kry_foto" id="kry_foto">
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label>Link Map Rumah</label>
                                <input type="text" class="form-control" name="kry_map_rumah" id="kry_map_rumah" value="<?= $karyawan->kry_map_rumah ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="simpan" class="btn btn-default"><i class="fas fa-check-circle"></i> Simpan</button>
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
<script src="<?= base_url("aset"); ?>/plugins/select2/select2.js"></script>

<!-- Toastr -->
<script src="<?= base_url("aset"); ?>/plugins/toastr/toastr.min.js"></script>

<script>
    $("#frm_tambah").submit(function(e) {
        e.preventDefault();
        $("#simpan").html("Menyimpan...");
        $(".btn").attr("disabled", true);
        $.ajax({
            type: "POST",
            url: "<?= base_url('Karyawan/simpan') ?>",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(d) {
                var res = JSON.parse(d);
                var msg = "";
                if (res.status == 1) {
                    toastr.success(res.desc);
                    setTimeout(function() {
                        window.location.href = '<?= base_url('Dashboard') ?>';
                    }, 2000);
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
</script>