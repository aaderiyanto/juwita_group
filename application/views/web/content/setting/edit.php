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
if($this->cek_login()== TRUE AND in_array($this->baca_session("level"),$in_access)){
$arr = $this->data_array("setting_apps","id_setting='".$url_system[3]."'");
if(!empty($arr->id_setting)){
if($this->post('simpan',true)){
	$lokasi_file 		= $_FILES['foto']['tmp_name'];
	$nama_file   		= $_FILES['foto']['name'];
	$temp 				= explode(".", $_FILES["foto"]["name"]);
	$dokumen 			= "logo".$arr->id_setting."_".rand(100,999).".".end($temp);
	if(!empty($lokasi_file)){$conf->UploadWeb($dokumen,$lokasi_file,ROOT_DIR);} else {$dokumen=$arr->logo_kampus;}
	$data_array = array("meta_title" => $this->post("meta_title"),
						"meta_deskripsi" => $this->post("meta_deskripsi"),
						"meta_keyword" => $this->post("meta_keyword"),
						"nama_perusahaan" => $this->post("nama_perusahaan"),
						"pimpinan" => $this->post("pimpinan"),
						"alamat" => $this->post("alamat"),
						"lokasi" => $this->post("lokasi"),
						"email_invoice" => $this->post("email_invoice"),
						"flag_ppn" => $this->post("flag_ppn"),
						"flag_maintenance" => $this->post("flag_maintenance"),
						"default_vendor" => $this->post("default_vendor"),
						"logo_web" => $dokumen
					    );
	$sql = $this->db_update($data_array,"setting_apps","id_setting='".$arr->id_setting."'");
	if($sql == TRUE){ $this->redirect($url_system[1]."/home/2"); } // akhir update data
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
										<label class="control-label col-lg-2">Meta Title <span class="text-danger">*</span></label>
										<div class="col-lg-10">
										<input type="text" name="meta_title" value="<?php echo $arr->meta_title; ?>" class="form-control" placeholder="text input..." required="required"/>
                                        </div>
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Meta Deskripsi <span class="text-danger">*</span></label>
										<div class="col-lg-10">
										<input type="text" name="meta_deskripsi" value="<?php echo $arr->meta_deskripsi; ?>" class="form-control" placeholder="text input..." required="required"/>
                                        </div>
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Meta Keyworrd <span class="text-danger">*</span></label>
										<div class="col-lg-10">
										<input type="text" name="meta_keyword" value="<?php echo $arr->meta_keyword; ?>" class="form-control" placeholder="text input..." required="required"/>
                                        </div>
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Nama Perusahaan <span class="text-danger">*</span></label>
										<div class="col-lg-10">
										<input type="text" name="nama_perusahaan" value="<?php echo $arr->nama_perusahaan; ?>" class="form-control" placeholder="text input..." required="required"/>
                                        </div>
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Pimpinan <span class="text-danger">*</span></label>
										<div class="col-lg-10">
										<input type="text" name="pimpinan" value="<?php echo $arr->pimpinan; ?>" class="form-control" placeholder="text input..." required="required"/>
                                        </div>
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Alamat <span class="text-danger">*</span></label>
										<div class="col-lg-10">
										<input type="text" name="alamat" value="<?php echo $arr->alamat; ?>" class="form-control" placeholder="text input..." required="required"/>
                                        </div>
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Lokasi <span class="text-danger">*</span></label>
										<div class="col-lg-10">
										<input type="text" name="lokasi" value="<?php echo $arr->lokasi; ?>" class="form-control" placeholder="text input..." required="required"/>
                                        </div>
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Flag PPN <span class="text-danger">*</span></label>
										<div class="col-lg-10">
											<select class="select-size-lg" name="flag_ppn" data-live-search="true" data-width="100%" required>
                                            <option value="">Pilih :</option>
                                        <?php
										$list_sql = array("1"=>"ada PPN","0"=>"Tidak ada PPN");
										foreach($list_sql as $id_raw => $raw){
										if($arr->flag_ppn == $id_raw){$pilih="selected";} else {$pilih="";}
										?>
                                        	<option value="<?php echo $id_raw; ?>" <?php echo $pilih; ?>><?php echo $raw; ?></option>
                                        <?php
										}
										?>                                        
										</select>
										</div>
									</div>

                                    <div class="form-group">
										<label class="control-label col-lg-2">Default Vendor <span class="text-danger">*</span></label>
										<div class="col-lg-10">
											<select class="select-size-lg" name="default_vendor" data-live-search="true" data-width="100%" required>
                                            <option value="">Pilih :</option>
                                        <?php
										$list_sql = $this->db_array("pos_vendor",$field="",$where="1 ORDER BY nama");
										foreach($list_sql as $raw):
										if($arr->default_vendor == $raw->id_vendor){$pilih='selected';} else {$pilih='';}
										?>
                                        	<option value="<?php echo $raw->id_vendor; ?>" <?= $pilih; ?>><?php echo $raw->nama; ?></option>
                                        <?php
										endforeach;
										?>                                        
                                            </select>
										</div>
									</div>

                                    <div class="form-group">
										<label class="control-label col-lg-2">Status Portal <span class="text-danger">*</span></label>
										<div class="col-lg-10">
											<select class="select-size-lg" name="flag_maintenance" data-live-search="true" data-width="100%" required>
                                            <option value="">Pilih :</option>
                                        <?php
										$list_sql = array("1"=>"Ya, Aktif","0"=>"Dalam Proses Maintenance");
										foreach($list_sql as $id_raw => $raw){
										if($arr->flag_maintenance == $id_raw){$pilih="selected";} else {$pilih="";}
										?>
                                        	<option value="<?php echo $id_raw; ?>" <?php echo $pilih; ?>><?php echo $raw; ?></option>
                                        <?php
										}
										?>                                        
										</select>
										</div>
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Logo System
    <?php if(!empty($arr->logo_web)){ ?>
    	<a href="<?php echo $this->base_url($config["folder_apps"]); ?>image_upload/<?php echo $arr->logo_kampus; ?>" data-popup="lightbox" rel="gallery" title="click for more detail"> <span class="icon-eye"></span></a>
    <?php } ?>
                                        </label>
										<div class="col-lg-10">
										<input name="foto" type="file" class="file-styled">
                                        <span class="help-block">Accepted formats: png, jpg, jpeg. Max file size 1Mb</span>
										</div>
									</div>
								</fieldset>
								<div class="text-right">
									<button type="button" class="btn btn-danger" onclick="window.location='<?php echo $this->base_url($config["folder_apps"])."setting/home"; ?>'"><i class="icon-arrow-left13 position-left"></i> Back</button> &nbsp;
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

<?php
} else { $this->redirect("setting/home"); }
} else { $this->redirect("home"); }