<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <div class="card-box">
                <?php foreach ($hasil as $h) {
                    if (($lat < ($h->cpy_lat + (0.00008)) && $lat > ($h->cpy_lat - (0.00008))) && ($long < ($h->cpy_lang + (0.00008)) && $long > ($h->cpy_lang - (0.00008))) && $all_akses == 1) {
                ?>
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>Nama Karyawan</th>
                                <td><?= $nama_karyawan ?></td>
                            </tr>
                            <tr>
                                <th>Lokasi Absen</th>
                                <td><?= $h->cpy_nama ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Absen</th>
                                <td><?= date('Y-m-d') ?></td>
                            </tr>
                            <tr>
                                <th>Waktu Absen</th>
                                <td><?= $waktu_in ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><?= $status == 1 ? "<span class='badge badge-success'>HADIR</span>" : "<span class='badge badge-warning'>TERLAMBAT</span>"; ?></td>
                            </tr>
                        </table>
                        <div class="row">
                            <form method="post" action="<?= base_url('Absensi/simpan') ?>" id="frm_tambah">
                                <input type="hidden" name="abs_kry_id" value="<?= $karyawan ?>">
                                <input type="hidden" name="abs_cpy_kode" value="<?= $lokasi ?>">
                                <input type="hidden" name="abs_jam_masuk" value="<?= $waktu_in ?>">
                                <input type="hidden" name="abs_tanggal" value="<?= date('Y-m-d') ?>">
                                <input type="hidden" name="abs_status" value="<?= $status ?>">
                                <input type="hidden" name="abs_terlambat" value="<?= $terlambat ?>">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Tambahkan Keterangan</label><small><i> (Optional)</i></small>
                                        <input type="text" class="form-control" name="abs_ket">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <button class="btn btn-success" id="simpan" type="submit"><i class="fa fa-check-circle"></i> Simpan Absen</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php } else { ?>
                        <div class="text-center">
                            <img src="<?= base_url('aset/assets/images/place.png') ?>" width="150px">
                            <h3 style="color:brown; font-weight:bold;">LOKASI TIDAK DITEMUKAN</h3>
                            <h6>Pastikan anda berada di lokasi kantor/unit kerja untuk melakukan absensi !!</h6>
                            <div class="form-group">
                                <a href="<?= base_url('Dashboard/scan') ?>" class="btn btn-success form-control"><i class="fa fa-camera"></i> Ulangi Scan</a>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
        </div>
    </div>
</div>

<!-- jQuery  -->
<script src="<?= base_url('aset/') ?>assets/js/jquery.min.js"></script>

<!-- Toastr -->
<script src="<?= base_url("aset"); ?>/plugins/toastr/toastr.min.js"></script>

<!-- Sweet alert -->
<script src="<?= base_url(); ?>aset/plugins/sweetalert2/sweetalert2.all.min.js"></script>

<script>
    $("#frm_tambah").submit(function(e) {
        e.preventDefault();
        $("#simpan").html("Menyimpan...");
        $(".btn").attr("disabled", true);
        $.ajax({
            type: "POST",
            url: "<?= base_url('Absensi/simpan/') ?>",
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
                            window.location.href = "<?= base_url('Dashboard') ?>";
                        } else {}
                    });
                } else {
                    toastr.error(res.desc);
                }
                $("#simpan").html("Proses simpan ...");
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