<style>
  #qrcode {
    display: block;
    margin-left: auto;
    margin-right: auto;
  }
</style>
<div class="container">
  <div class="row">
    <div class="col-lg">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Arahkan Kamera ke QR Code !</h3>
        </div>
        <div class="panel-body text-center">
          <input type="hidden" id="lat" value="">
          <input type="hidden" id="long" value="">
          <form method="POST">
            <input type="hidden" id="id_karyawan" name="abs_kry_id" value="<?= $this->session->userdata('id_karyawan') ?>">
            <input type="hidden" id="waktu_in" name="abs_jam_masuk" value="<?= date('H:i:s') ?>">
            <input type="hidden" id="tanggal" name="abs_tanggal" value="<?= date('Y-m-d') ?>">
          </form>
          <div id="qrcode" style="width: 50%;"></div>
        </div>
        <div class="panel-footer">
          <center><a class="btn btn-default" href="../"><i class="fa fa-reply"></i> Kembali</a> <a class="btn btn-default" href="#" onClick="titik()"><i class="fa fa-map-pin"></i> Sesuaikan Titik</a></center>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/1.2.4/html5-qrcode.min.js"></script>

<!-- Sweet alert -->
<script src="<?= base_url(); ?>aset/plugins/sweetalert2/sweetalert2.all.min.js"></script>

<script type="text/javascript">
  function titik() {
    navigator.geolocation.getCurrentPosition(function(position) {
      tampilLokasi(position);
    }, function(e) {
      alert('Geolocation Tidak Mendukung Pada Perangkat Anda');
    }, {
      enableHighAccuracy: true
    });
  }

  $(document).ready(function() {
    navigator.geolocation.getCurrentPosition(function(position) {
      tampilLokasi(position);
    }, function(e) {
      alert('Geolocation Tidak Mendukung Pada Browser Anda');
    }, {
      enableHighAccuracy: true
    });
  });

  function tampilLokasi(posisi) {
    var latitude = posisi.coords.latitude;
    var longitude = posisi.coords.longitude;
    $('#lat').val(latitude);
    $('#long').val(longitude);
  }

  const qrCodeSuccessCallback = (kode) => {
    var lat = $('#lat').val();
    var long = $('#long').val();
    if (!lat) lat = 0;
    if (!long) long = 0;

    var id_karyawan = $('#id_karyawan').val();
    var waktu_in = $('#waktu_in').val();
    var tanggal = $('#tanggal').val();

    $.ajax({
      type: "POST",
      url: "<?= base_url('Absensi/simpan_absen_pulang/') ?>",
      data: {
        abs_kry_id: id_karyawan,
        abs_jam_masuk: waktu_in,
        abs_tanggal: tanggal,
        lat: lat,
        long: long
      },
      dataType: "json",
      success: function(data) {
        if (data.status == 1) {
          Swal.fire(
            'Sukses',
            data.desc,
            'success'
          ).then((result) => {
            if (!result.isConfirmed) {
              window.location.href = "<?= base_url('Dashboard') ?>";
            } else {}
          })
        } else {
          toastr.error(data.desc);
        }
      },
      error: function(jqXHR, namaStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  };

  const config = {
    fps: 10,
    qrbox: {
      width: 250,
      height: 250
    }
  };

  const html5QrCode = new Html5Qrcode("qrcode");
  html5QrCode.start({
    facingMode: "environment"
  }, config, qrCodeSuccessCallback);
</script>