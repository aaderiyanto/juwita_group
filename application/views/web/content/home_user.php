<?php
if(in_array($this->baca_session("level"),array("gudang","funding_officer"))){
?>
			<div class="content-wrapper">
				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">                        	
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Dashboard</h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="<?php echo $this->base_url($config["folder_apps"]); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Dashboard</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">

					<!-- Info alert -->
					<div class="alert alert-info alert-styled-left alert-arrow-left alert-component">
						<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
						<h6 class="alert-heading text-semibold"><b>Selamat Datang</b>,</h6>
						Hai <code><?php echo $this->baca_session('nama'); ?></code>, anda login dengan username <code><?php echo $this->baca_session('username'); ?></code> dengan hak akses user anda sebagai <code><?php echo $this->baca_session('level'); ?></code>.
				    </div>
					<!-- Footer -->
                    <?php $this->loadView("template/footer"); ?>
					<!-- /footer -->

				</div>
				<!-- /content area -->
			</div>
            

                <div id="modal_informasi" class="modal fade">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header bg-primary">
								<button type="button" class="close close_modal">&times;</button>
								<h6 class="modal-title">Detail Data</h6>
							</div>
							<div class="modal-view"></div>
						</div>
					</div>
				</div>
<?php } ?>