<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Validasi Ijazah</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= base_url() ?>application/views/scan/css/font-awesome.css">
  <link rel="stylesheet" href="<?= base_url() ?>application/views/scan/css/bootstrap.min.css">
  <script src="<?= base_url() ?>application/views/scan/js/jquery.min.js"></script>
  <script src="<?= base_url() ?>application/views/scan/js/bootstrap.min.js"></script>

<body>
  <nav class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="./">Validasi Ijazah dengan QR Code</a>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-danger">
          <div class="panel-heading">
            <h3 class="panel-title">Arahkan Kode QR Ke Kamera!</h3>
          </div>
          <div class="panel-body text-center">
            <canvas></canvas>
            <hr>
            <select></select>
          </div>
          <div class="panel-footer">
            <center><a class="btn btn-danger" href="../">Kembali</a></center>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Js Lib -->
  <script type="text/javascript" src="<?= base_url() ?>application/views/scan/js/jquery.js"></script>
  <script type="text/javascript" src="<?= base_url() ?>application/views/scan/js/qrcodelib.js"></script>
  <script type="text/javascript" src="<?= base_url() ?>application/views/scan/js/webcodecamjquery.js"></script>
  <script type="text/javascript">
    var arg = {
      resultFunction: function(result) {
        //$('.hasilscan').append($('<input name="noijazah" value=' + result.code + ' readonly><input type="submit" value="Cek"/>'));
        // $.post("../cek.php", { noijazah: result.code} );
        var redirect = '../cek.php';
        $.redirectPost(redirect, {
          noijazah: result.code
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
</body>

</html>