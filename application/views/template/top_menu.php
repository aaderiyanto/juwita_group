		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
                    <?php if(empty($arr_login->foto)){ ?>
						<img src="<?php echo $this->base_url($config["folder_apps"]); ?>image_upload/no_image.jpg" alt="">
                    <?php } else {  ?>
                    	<img src="<?php echo $this->base_url($config["folder_apps"]); ?>image_upload/<?php echo $arr_login->foto; ?>" alt="">
                    <?php } ?>
						<span><?php echo $this->baca_session('nama'); ?></span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="<?php echo $this->base_url($config["folder_apps"]); ?>profile/home"><i class="icon-user-plus"></i> My profile</a></li>
						<li class="divider"></li>
                        <?php
						if($this->baca_session('level')=="admin"){
						?>
                        <li><a href="<?php echo $this->base_url($config["folder_apps"]); ?>setting/home"><i class="icon-cog5"></i> Settings App.</a></li>
                        <!--<li><a href="<?php echo $this->base_url($config["folder_apps"]); ?>loglogin"><i class="icon-users4"></i> <span> Log Login</span></a></li>-->
                        <?php } ?>
						<li><a href="" data-toggle="modal" data-target="#logout"><i class="icon-switch2"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>