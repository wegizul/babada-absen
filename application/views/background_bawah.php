</div> <!-- container -->

</div> <!-- content -->

<footer class="footer text-right">
  © 2023. PT. Digital Solution and Information Technology
</footer>

</div>
</div>
<!-- END wrapper -->

<script>
  var resizefunc = [];

  var path = window.location.pathname.split("/");
  // var base_link = window.location.protocol + "//" + window.location.hostname + ":" + window.location.port + "/" + path[1] + "/";
  var x;
  var n = 0;
  var base_link = $("#base_link").val();

  function buka_changelog() {
    event.preventDefault();
    $.ajax({
      url: base_link + "Changelog.txt",
      dataType: "text",
      success: function(data) {
        console.log(data);
        var string = data.replace(/\n/g, "<br>");
        $("#pesan_info_ok").html(string);
        $('#info_ok').modal({
          show: true,
          keyboard: false,
          backdrop: 'static'
        });
      }
    });
  }

  $(document).ready(function() {
    $("#up_passlama").focusout(function() {
      var isi = $(this).val();
      var nama = $(this).attr("nama");
      alert(nama);
      if (isi == "") {
        $(this).prop("tooltiptext", nama + "tidak boleh kosong");
        $(this).tooltip();
      }
    });

  });

  $("#up_infoalert").hide();


  $("#frm_ubahpass").on("submit", function(e) {
    e.preventDefault();
    $('#up_simpan').text('Menyimpan...'); //change button text
    $('.btn').attr('disabled', true); //set button enable 
    $.ajax({
      url: "../Login/ubah_pass",
      type: "POST",
      data: $('#frm_ubahpass').serialize(),
      dataType: "JSON",
      success: function(data) {

        if (data.status) //if success close modal and reload ajax table
        {
          $("#up_infoalert").removeClass("alert-danger");
          $("#up_infoalert").addClass("alert-success");
          $("#up_pesan").html(data.pesan);
          $("#up_infoalert").fadeIn();
          setTimeout(function() {
            document.location.href = '';
          }, 2000);
        } else {
          $("#up_infoalert").removeClass("alert-success");
          $("#up_infoalert").addClass("alert-danger");
          $("#up_pesan").html(data.pesan);
          $("#up_infoalert").fadeIn().delay(2000).fadeOut();
          $('.btn').attr('disabled', false); //set button enable 
        }
        $('#up_simpan').text('Simpan'); //change button text
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR + " - " + textStatus + " - " + errorThrown);
        $('#up_simpan').text('Simpan'); //change button text
        $('.btn').attr('disabled', false); //set button enable 

      }
    });
  })
</script>

<!-- jQuery  -->
<script src="<?= base_url('aset/') ?>assets/js/bootstrap.min.js"></script>
<script src="<?= base_url('aset/') ?>assets/js/detect.js"></script>
<script src="<?= base_url('aset/') ?>assets/js/fastclick.js"></script>
<script src="<?= base_url('aset/') ?>assets/js/jquery.slimscroll.js"></script>
<script src="<?= base_url('aset/') ?>assets/js/jquery.blockUI.js"></script>
<script src="<?= base_url('aset/') ?>assets/js/waves.js"></script>
<script src="<?= base_url('aset/') ?>assets/js/wow.min.js"></script>
<script src="<?= base_url('aset/') ?>assets/js/jquery.nicescroll.js"></script>
<script src="<?= base_url('aset/') ?>assets/js/jquery.scrollTo.min.js"></script>

<!-- Counterup  -->
<script src="<?= base_url('aset/') ?>assets/plugins/waypoints/lib/jquery.waypoints.js"></script>
<script src="<?= base_url('aset/') ?>assets/plugins/counterup/jquery.counterup.min.js"></script>

<script src="<?= base_url('aset/') ?>assets/plugins/raphael/raphael-min.js"></script>

<script src="<?= base_url('aset/') ?>assets/js/jquery.core.js"></script>
<script src="<?= base_url('aset/') ?>assets/js/jquery.app.js"></script>


</body>

</html>