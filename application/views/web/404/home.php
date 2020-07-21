			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - 404</h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="#"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">404</li>
						</ul>

					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
					<!-- Dashboard content -->
					<div class="row">
					<!-- Error wrapper -->
					<div class="container-fluid text-center">
						<h1 class="error-title">404</h1>
						<h6 class="text-semibold content-group">Oops, halaman yang anda akses tidak ditemukan!</h6>

						<div class="row">
							<div class="col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3">
								<form action="#" class="main-search">
									<div class="input-group content-group">
										<input type="text" class="form-control input-lg" placeholder="Search">

										<div class="input-group-btn">
											<button type="submit" class="btn bg-slate-600 btn-icon btn-lg"><i class="icon-search4"></i></button>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-6">
											<a href="<?= $conf->base_url($config["folder_apps"]); ?>" class="btn btn-primary btn-block content-group"><i class="icon-circle-left2 position-left"></i> Go to dashboard</a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<!-- /error wrapper -->

					</div>
					<!-- /dashboard content -->


					<!-- Footer -->
                    <?php $this->loadView("template/footer"); ?>
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>