			<div class="sidebar sidebar-main">
				<div class="sidebar-content">

					<!-- User menu -->
					<div class="sidebar-user">
						<div class="category-content">
							<div class="media">
								<?php if(empty($arr_login->foto)){ ?>
                                <a href="<?php echo $this->base_url($config["folder_apps"]); ?>image_upload/no_image.jpg" class="media-left" data-popup="lightbox" rel="gallery" title="click for more detail">
                                    <img src="<?php echo $this->base_url($config["folder_apps"]); ?>image_upload/no_image.jpg" class="img-circle img-sm" alt="">
                                <?php } else {  ?>
                                <a href="<?php echo $this->base_url($config["folder_apps"]); ?>image_upload/<?php echo $arr_login->foto; ?>" class="media-left" data-popup="lightbox" rel="gallery" title="click for more detail">
                                    <img src="<?php echo $this->base_url($config["folder_apps"]); ?>image_upload/<?php echo $arr_login->foto; ?>" class="img-circle img-sm" alt="">
                                <?php } ?>                                	
                                </a>
								<div class="media-body">
									<span class="media-heading text-semibold"><?php echo strtolower($this->baca_session('nama')); ?></span>
									<div class="text-size-mini text-muted">
										<i class="icon-user text-size-small"></i> &nbsp; <?php echo $this->baca_session('level'); ?>
									</div>
								</div>

								<div class="media-right media-middle">
									<!--<ul class="icons-list">
										<li>
											<a href="#"><i class="icon-cog3"></i></a>
										</li>
									</ul>-->
								</div>
							</div>
						</div>
					</div>
					<!-- /user menu -->

					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
						<?php
                        if($this->baca_session('level')=="admin"){
							$this->loadView("template/menu/menu_admin");
						} else 
						if(in_array($this->baca_session('level'),array("administrasi","pimpinan"))){
							$this->loadView("template/menu/menu_administrasi");
						} else 
						if($this->baca_session('level')=="gudang"){
							$this->loadView("template/menu/menu_gudang");
						} else 
						if($this->baca_session('level')=="cashier"){
							$this->loadView("template/menu/menu_cashier");
						} else 
						if($this->baca_session('level')=="kepala_kantin"){
							$this->loadView("template/menu/menu_kepala_kantin");
						} else
						if($this->baca_session('level')=="funding_officer"){
							$this->loadView("template/menu/menu_funding_officer");
						}
                        ?>
						</div>
					</div>
					<!-- /main navigation -->

				</div>
			</div>