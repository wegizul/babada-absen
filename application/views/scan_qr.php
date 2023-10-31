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
          <input type="hidden" id="xx" value="<?= $x ?>">
          <div style="width: 50%" id="qrcode"></div>
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
    var shift = $('#xx').val();
    if (!lat) lat = 0;
    if (!long) long = 0;

    window.location.href = "<?= base_url('Dashboard/hasil_scan/') ?>" + lat + "/" + long + "/" + kode + "/" + shift;
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