<div class="container">
  <div class="row">
    <div class="col-lg">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Arahkan Kamera ke QR Code !</h3>
        </div>
        <div class="panel-body text-center">
          <!-- <input type="hidden" id="lat" value="">
          <input type="hidden" id="long" value=""> -->
          <form method="POST">
            <input type="hidden" id="id_karyawan" name="abs_kry_id" value="<?= $this->session->userdata('id_karyawan') ?>">
            <input type="hidden" id="waktu_in" name="abs_jam_masuk" value="<?= date('H:i:s') ?>">
            <input type="hidden" id="tanggal" name="abs_tanggal" value="<?= date('Y-m-d') ?>">
          </form>
          <canvas style="width: 80%;"></canvas>
          <hr>
          <select></select>
        </div>
        <div class="panel-footer">
          <center><a class="btn btn-default" href="../"><i class="fa fa-reply"></i> Kembali</a> <a class="btn btn-default" href="#" onClick="titik()"><i class="fa fa-map-pin"></i> Sesuaikan Titik</a></center>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Js Lib -->
<script type="text/javascript" src="<?= base_url() ?>aset/scan/js/jquery.js"></script>
<script type="text/javascript" src="<?= base_url() ?>aset/scan/js/qrcodelib.js"></script>
<script type="text/javascript" src="<?= base_url() ?>aset/scan/js/webcodecamjquery.js"></script>

<!-- Sweet alert -->
<script src="<?= base_url(); ?>aset/plugins/sweetalert2/sweetalert2.all.min.js"></script>

<script type="text/javascript">

</script>

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
  var arg = {
    resultFunction: function(result) {
      var lat = $('#lat').val();
      var long = $('#long').val();
      if (!lat) lat = 0;
      if (!long) long = 0;

      var id_karyawan = $('#id_karyawan').val();
      var waktu_in = $('#waktu_in').val();
      var tanggal = $('#tanggal').val();

      $.ajax({
        type: "POST",
        url: "<?= base_url('Absensi/simpan/') ?>",
        data: {
          abs_kry_id: id_karyawan,
          abs_jam_masuk: waktu_in,
          abs_tanggal: tanggal
        },
        dataType: "json",
        success: function(data) {
          console.log(data.status);
          if (data.status == 1) {
            Swal.fire(
              'Sukses',
              data.desc,
              'success'
            ).then((result) => {
              if (!result.isConfirmed) {
                window.location.href = "<?= base_url('Dashboard/tampil') ?>";
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
    }
  };

  var decoder = $("canvas").WebCodeCamJQuery(arg).data().plugin_WebCodeCamJQuery;
  decoder.buildSelectMenu("select");
  decoder.play();
  /*  Without visible select menu
      decoder.buildSelectMenu(document.createElement('select'), 'environment|back').init(arg).play();
  */
  $('select').on('change', function() {
    decoder.stop().play();
  });

  // jquery extend function
  $.extend({
    redirectPost: function(location, args) {
      var form = '';
      $.each(args, function(key, value) {
        form += '<input type="hidden" name="' + key + '" value="' + value + '">';
      });
      $('<form action="' + location + '" method="POST">' + form + '</form>').appendTo('body').submit();
    }
  });
</script>