<!--
/**
 * Created by BMT Solutions.
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
-->
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Page Login - <?php echo $meta["meta_title"]; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $this->base_url($config['folder_apps']); ?>images/favicon.png">
	<!-- Global stylesheets -->
    <!--
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    -->
	<link href="<?php echo $this->base_url($config['folder_apps']); ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $this->base_url($config['folder_apps']); ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $this->base_url($config['folder_apps']); ?>assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $this->base_url($config['folder_apps']); ?>assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $this->base_url($config['folder_apps']); ?>assets/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
    <script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/core/libraries/bootstrap.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
    <script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/plugins/forms/validation/validate.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/core/app.js"></script>
    <script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/login.js"></script>
	<!-- /theme JS files -->

</head>

<body class="login-cover">

	<!-- Page container -->
	<div class="page-container login-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Content area -->
				<div class="content">

					<!-- Form with validation -->
					<form action="" class="form-validate" method="post" autocomplete="off">
                    <input type="hidden" id="url" value="<?php echo $this->base_url($config['folder_apps']); ?>">
						<div class="panel panel-body login-form">
							<div class="text-center">
								<div class="icon-object border-slate-300 text-slate-300">
                                	<i class="icon-users4"></i>
                                </div>
								<h5 class="content-group">Login Aplikasi Juwita Group</h5>
							</div>
                            <div id="error"></div>
							<div class="form-group has-feedback has-feedback-left">
                            	<div class="form-control-feedback">
									<i class="icon-envelope text-muted"></i>
								</div>
								<input type="text" class="form-control" placeholder="Username" name="username" id="username" required>
							</div>

							<div class="form-group has-feedback has-feedback-left">
                            	<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
								<input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
							</div>
							<div class="form-group">
								<button type="submit" name="login" id="login" class="btn bg-blue btn-block">Login <i class="icon-arrow-right14 position-right"></i></button>
							</div>
						</div>
					</form>
					<!-- /form with validation -->


					<!-- Footer -->
					<div class="footer text-white">
						&copy; 2020. <a href="#" class="text-white" target="_blank">ERP Juwita Group V1</a>
					</div>
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->
<!-- </body> </html> -->
</body>
</html>