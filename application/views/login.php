<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
	<meta name="author" content="Coderthemes">

	<link rel="shortcut icon" href="aset/assets/images/logo.png">

	<title>Absensi Mobile | Login</title>

	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url("aset"); ?>/plugins/fontawesome-free/css/all.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="<?= base_url("aset"); ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Toastr -->
	<link rel="stylesheet" href="<?= base_url("aset"); ?>/plugins/toastr/toastr.min.css">

	<link href="<?= base_url("aset"); ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url("aset"); ?>/assets/css/core.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url("aset"); ?>/assets/css/components.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url("aset"); ?>/assets/css/icons.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url("aset"); ?>/assets/css/pages.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url("aset"); ?>/assets/css/responsive.css" rel="stylesheet" type="text/css" />

	<!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

	<script src="<?= base_url("aset"); ?>/assets/js/modernizr.min.js"></script>
	<style>
		#logoo {
			display: block;
			margin-left: auto;
			margin-right: auto;
		}

		.container {
			font-family: arial;
			font-size: 24px;
			height: 600px;
			/* Setup */
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.child {
			margin-top: 2%;
			width: 100%;
			height: 90%;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="child">
			<div class="wrapper-page">
				<div class="card-box">
					<div class="panel-heading">
						<img src="<?= base_url('aset/assets/images/logo.png') ?>" width="100px" id="logoo">
						<h3 class="text-center"> Login<br> <strong class="text-custom" style="color: #0d5595;">Absensi Mobile</strong> </h3>
					</div>
					<div class="panel-body">
						<form class="form-horizontal m-t-20" action="<?= base_url('Login/proses'); ?>" method="post" id="frm_login">

							<div class="form-group ">
								<div class="col-xs-12">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-user"></i></span>
										<input class="form-control" type="text" required="" id="username" name="username" placeholder="Username">
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-xs-12">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-lock"></i></span>
										<input class="form-control" type="password" required="" id="password" name="password" placeholder="Password">
									</div>
								</div>
							</div>

							<div class="form-group text-center m-t-40">
								<div class="col-xs-12">
									<button class="btn btn-block text-uppercase waves-effect waves-light" type="submit" style="background-color: #0d5595; color: white;">Log In</button>
								</div>
							</div>

							<div class="form-group m-t-30 m-b-0">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		var resizefunc = [];
	</script>

	<!-- jQuery -->
	<script src="<?= base_url("aset"); ?>/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?= base_url("aset"); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- Toastr -->
	<script src="<?= base_url("aset"); ?>/plugins/toastr/toastr.min.js"></script>

	<!-- jQuery  -->
	<script src="<?= base_url("aset"); ?>/assets/js/jquery.min.js"></script>
	<script src="<?= base_url("aset"); ?>/assets/js/bootstrap.min.js"></script>
	<script src="<?= base_url("aset"); ?>/assets/js/detect.js"></script>
	<script src="<?= base_url("aset"); ?>/assets/js/fastclick.js"></script>
	<script src="<?= base_url("aset"); ?>/assets/js/jquery.slimscroll.js"></script>
	<script src="<?= base_url("aset"); ?>/assets/js/jquery.blockUI.js"></script>
	<script src="<?= base_url("aset"); ?>/assets/js/waves.js"></script>
	<script src="<?= base_url("aset"); ?>/assets/js/wow.min.js"></script>
	<script src="<?= base_url("aset"); ?>/assets/js/jquery.nicescroll.js"></script>
	<script src="<?= base_url("aset"); ?>/assets/js/jquery.scrollTo.min.js"></script>

	<script src="<?= base_url("aset"); ?>/assets/js/jquery.core.js"></script>
	<script src="<?= base_url("aset"); ?>/assets/js/jquery.app.js"></script>

	<script>
		$(function() {
			$('.list-inline li > a').click(function() {
				var activeForm = $(this).attr('href') + ' > form';
				//console.log(activeForm);
				$(activeForm).addClass('magictime swap');
				//set timer to 1 seconds, after that, unload the magic animation
				setTimeout(function() {
					$(activeForm).removeClass('magictime swap');
				}, 1000);
			});

		});

		$("#frm_login").submit(function(e) {
			e.preventDefault();
			$(".btn").attr("disabled", true);
			$.ajax({
				type: "POST",
				url: "Login/proses",
				data: new FormData(this),
				processData: false,
				contentType: false,
				success: function(d) {
					var res = JSON.parse(d);
					console.log("wow");
					if (res.status == 1) {
						toastr.success('Login Berhasil!<br/>' + res.desc);
						setTimeout(function() {
							document.location.href = "Dashboard";
						}, 1000);
					} else {
						$(".btn").attr("disabled", false);
						toastr.error('Login Gagal!<br/>' + res.desc);
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					$(".btn").attr("disabled", false);
					toastr.error('Error! ' + errorThrown);
				}
			});
		});
	</script>
</body>

</html>