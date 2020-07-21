<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
$title_grid = ucwords(strtolower(str_replace('_',' ',$url_system[1])));
$error=0;
if($this->cek_login()== TRUE){
if($this->baca_session("level") == "admin"){$where="id_user='".$url_system[3]."'";} else 
									       {$where="id_user='".$this->baca_session("id_admin")."'";}
$arr = $this->data_array("bmt_user",$where);
if(!empty($arr->id_user)){
if($this->post('simpan',true)){
	if($this->baca_session("level") == "admin"){$flag_aktif=$this->post("flag_aktif");} else 
											   {$flag_aktif=$arr->flag_aktif;}
	if($this->post("password")!=""){$password=hash('sha1',$this->post("password"));} else {$password=$arr->password;}
	if(hash('sha1',$this->post("password_lama")) == $arr->password || $this->baca_session("level") == "admin"){
	$data_array = array("nama" => strtoupper($this->post("nama")),
						"password" => $password,
						"flag_aktif" => $flag_aktif,
						"tgl_update" => date("Y-m-d H:i:s"),
						"user_update" => $this->baca_session('id_admin')
					    );
	$sql = $this->db_update($data_array,"bmt_user","id_user='".$arr->id_user."'");
	if($sql == TRUE){ $this->redirect($url_system[1]."/home/2"); } // akhir update data
	} else { $error=2; }
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
<?php if($error == 2){ ?>
<div class="alert alert-danger alert-styled-left alert-arrow-left alert-bordered">
	<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
	<span class="text-semibold"><b>Oopss...!</b></span> data gagal di update. Password lama anda salah.
</div>
<?php } ?>

                <form class="form-horizontal form-validate-jquery" action="" method="post" autocomplete="off" enctype="multipart/form-data">
                            <div class="info_error"></div>
								<fieldset class="content-group">
                                    <div class="form-group">
										<label class="control-label col-lg-2">Username <span class="text-danger">*</span></label>
										<div class="col-lg-10">
										<input type="text" name="x" value="<?php echo $arr->username; ?>" class="form-control" placeholder="text input..." required="required" disabled="disabled"/>
                                        </div>
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Nama <span class="text-danger">*</span></label>
										<div class="col-lg-10">
										<input type="text" name="nama" value="<?php echo $arr->nama; ?>" class="form-control" placeholder="text input..." required="required"/>
                                        </div>
									</div>
                                    <?php if($this->baca_session("level") == "admin"){ ?>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Aktif Login <span class="text-danger">*</span></label>
										<div class="col-lg-10">
											<select class="select-size-lg" name="flag_aktif" data-live-search="true" data-width="100%" required>
                                            <option value="">Pilih :</option>
                                        <?php
										$list_sql = array("1"=>"Ya, Aktif","0"=>"Tidak Aktif");
										foreach($list_sql as $id_raw => $raw){
										if($arr->flag_aktif == $id_raw){$pilih="selected";} else {$pilih="";}
										?>
                                        	<option value="<?php echo $id_raw; ?>" <?php echo $pilih; ?>><?php echo $raw; ?></option>
                                        <?php
										}
										?>                                        
										</select>
										</div>
									</div>
                                    <?php } ?>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Ubah Password</label>
										<div class="col-lg-10">
                                        <div class="input-group">
											<input type="password" name="password" id="password" class="form-control" placeholder="kosongkan jika tidak di update">
                                            <span class="input-group-addon" title="show password"><i toggle="#password" class="toggle-password icon-eye"></i></span>
                                        </div>
										</div>
									</div> 
<?php
if($this->baca_session("level") != "admin"){
?> 
                                    <div class="form-group">
										<label class="control-label col-lg-2">Password Lama <span class="text-danger">*</span></label>
										<div class="col-lg-10">
										<input type="password" name="password_lama" class="form-control" placeholder="text input..." required="required"/>
                                        </div>
									</div>
<?php } ?>
								</fieldset>
								<div class="text-right">
									<button type="button" class="btn btn-danger" onclick="window.location='<?php echo $this->base_url($config["folder_apps"]).$url_system[1]."/home"; ?>'"><i class="icon-arrow-left13 position-left"></i> Back</button> &nbsp;
									<button type="submit" class="btn btn-primary" name="simpan">Submit <i class="icon-checkbox-checked position-right"></i></button>
								</div>
							</form> 
					</div>
                    
					</div>
                        
					</div>
					<!-- /page length options -->

					<!-- Footer -->
					<?php $this->loadView("template/footer"); ?>
					<!-- /footer -->

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
</script>
<?php
} else { $this->redirect($url_system[1]."/home"); }
} else { $this->redirect("home"); }