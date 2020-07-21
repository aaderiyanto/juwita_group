<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
$title_grid = ucwords(strtolower(str_replace('_',' ',$url_system[1])));
$in_access = array("admin");
if($this->cek_login()== TRUE && in_array($this->baca_session("level"),$in_access)){
if($this->post('simpan',true)){
	$id_primary	= "USR".$this->kode_uniq(10).rand(100,999);
	$data_array = array("id_user" => $id_primary,
						"nama" => strtoupper($this->post("nama")),
						"username" => $this->post("username"),
						"password" => hash('sha1',$this->post("password")),
						"level" => $this->post("level"),
						"tgl_input" => date("Y-m-d H:i:s"),
						"user_input" => $this->baca_session('id_admin')
					    );
	$sql = $this->db_insert($data_array, "bmt_user");
  	if($sql == TRUE) { $this->redirect($url_system[1]."/home/1"); } else { $error=1; }
}
?>
		<div class="content-wrapper">
				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-grid position-left"></i> <span class="text-semibold">Page </span> - Data <?= $title_grid; ?></h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="<?php echo $this->base_url($config["folder_apps"]); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Data <?= $title_grid; ?></li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
					<!-- Page length options -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">Form Data - <?= $title_grid; ?></h5>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                	</ul>
		                	</div>
						</div>

					<div class="panel-body">
                            <form class="form-horizontal form-validate-jquery" action="" method="post" autocomplete="off" enctype="multipart/form-data">
                            <div class="info_error"></div>
								<fieldset class="content-group">
                                    <div class="form-group">
										<label class="control-label col-lg-2">Nama <span class="text-danger">*</span></label>
										<div class="col-lg-10">
										<input type="text" name="nama" class="form-control" placeholder="text input..." required="required"/>
                                        </div>
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Username <span class="text-danger">*</span></label>
										<div class="col-lg-10">
										<input type="text" name="username" id="username" class="form-control" placeholder="text input..." required="required" onblur="loadPrimary()"/>
                                        </div>
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Password <span class="text-danger">*</span></label>
										<div class="col-lg-10">
                                        <div class="input-group">
											<input type="password" name="password" id="password" class="form-control" placeholder="text input..." required="required">
                                            <span class="input-group-addon" title="show password"><i toggle="#password" class="toggle-password icon-eye"></i></span>
                                        </div>
										</div>
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Level <span class="text-danger">*</span></label>
										<div class="col-lg-10">
										<select name="level" id="level" data-placeholder="Pilih :" class="select-size-lg required" required>
					                    	<option value="">Pilih : </option>
                                        <?php
										$arr_level = array("cashier","kepala_kantin","administrasi","pimpinan","gudang","funding_officer");
										foreach($arr_level as $val_data){
										?>
                                        	<option value="<?php echo $val_data; ?>"><?php echo ucwords(str_replace("_"," ",$val_data)); ?></option>
                                        <?php
										}
										?>  
										</select>
                                        </div>                                       
									</div>
								</fieldset>
								<div class="text-right">
									<button type="button" class="btn btn-danger" onclick="window.location='<?php echo $this->base_url($config["folder_apps"]).$url_system[1]."/home"; ?>'"><i class="icon-arrow-left13 position-left"></i> Back</button> &nbsp;
									<button type="submit" class="btn btn-primary" name="simpan">Submit <i class="icon-checkbox-checked position-right"></i></button>
								</div>
							</form>


                    </div>
                    
                        
					</div>
					<!-- /page length options -->

					<!-- Footer -->
					<?php $this->loadView("template/footer"); ?>
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
				<!-- /content area -->

			</div>
<script>
$(document).ready(function() {
		$(".toggle-password").click(function() {
		  $(this).toggleClass("icon-eye icon-eye-blocked");
		  var input = $($(this).attr("toggle"));
		  if (input.attr("type") == "password") {
			input.attr("type", "text");
		  } else {
			input.attr("type", "password");
		  }
		});
});

function loadPrimary(){
	//alert(1);
	   var username = $('#username').val();
	   $.ajax({
		type: 'POST',
		url: '<?php echo $this->base_url($config["folder_apps"]); ?>/ajax/<?= $url_system[1]; ?>/keyup',
		data: {username:username},
		success: function(data){
		 if(data.length > 0){
			alert("OOpssss...! Username :"+username+" sudah digunakan.");
			$('#username').val("");
		 }
		}
	   });
}
</script>

<?php } else { $this->redirect("home"); } ?>