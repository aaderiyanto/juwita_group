<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
$not_access = array("cashier");
if($this->cek_login()== TRUE && !in_array($this->baca_session("level"),$not_access)){
$title_grid = ucwords(strtolower(str_replace('_',' ',$url_system[1])));
$folder_grid = strtolower($url_system[1]);
$arr = $this->data_array("pos_produk","id_produk='".$url_system[3]."'");
if(!empty($arr->id_produk)){
$arr_brand = $this->data_array("pos_brand","id_brand='".$arr->id_brand."'");
$arr_kategori = $this->data_array("pos_kategori_produk","id_kategori='".$arr->id_kategori."'");
if($this->post('simpan',true)){
	$id_primary	= "PRD".$this->kode_uniq(14).rand(100,999);
	// Upload Image Produk
	if(!empty($this->post("foto"))){
		$nama_file_upload = "produk_".$id_primary."_".rand(100,999).".png";
		$image_crop->saveimg_base64($this->post("foto"),ROOT_DIR."fupload/produk/",$nama_file_upload);
	} else { $nama_file_upload = ""; }
	$from_replace = [".",","]; $to_replace = ["","."];
	$nominal = str_replace($from_replace,$to_replace,$this->post("nominal"));
	$qr_produk = $this->kode_uniq(20);
	// Save
	$data_array = array("id_produk" => $id_primary,
						"jenis_data" => $this->post("jenis_data"),
						"sku" => $this->post("sku"),
						"nama_produk" => $this->post("nama_produk"),
						"nominal" => $nominal,
						"id_brand" => $this->post("id_brand"),
						"id_kategori" => $this->post("id_kategori"),
						"deskripsi" => $this->post("deskripsi"),
						"spesifikasi" => $this->post("spesifikasi"),
						"qr_produk" => $qr_produk,
						"foto" => $nama_file_upload,
						"tgl_input" => date("Y-m-d H:i:s"),
						"user_input" => $this->baca_session('id_admin')
					    );
	$sql = $this->db_insert($data_array, "pos_produk");
  	if($sql == TRUE) { $this->redirect($folder_grid."/home/1"); } else { $error=1; }
}
?>
<link rel="stylesheet" href="<?php echo $this->base_url($config["folder_apps"]); ?>assets/cropper/css/layout.css">
<link rel="stylesheet" href="<?php echo $this->base_url($config["folder_apps"]); ?>assets/cropper/css/cropper.css">
<script src="<?php echo $this->base_url($config["folder_apps"]); ?>assets/cropper/js/dropzone.js"></script>
<script src="<?php echo $this->base_url($config["folder_apps"]); ?>assets/cropper/js/cropper.js"></script>
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
                            <hr />
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
										<label class="control-label col-lg-2">Nama Produk <span class="text-danger">*</span></label>
										<div class="col-lg-10">
										<input type="text" name="nama_produk" id="nama_produk" class="form-control" placeholder="text input..." required="required" autofocus="autofocus" value="<?= $arr->nama_produk; ?>"/>
                                        </div>                                       
									</div>
<!-- START -->
<div class="row">
<div class="col-lg-8">
                                    <div class="form-group">
										<label class="control-label col-lg-3">Brand <span class="text-danger">*</span></label>
										<div class="col-lg-9">
                                        <select name="id_brand" data-placeholder="Pilih :" class="select-size-lg required" id="brand">
                                            <option value="">Pilih :</option>
                                        <?php
										$list_sql = $this->db_array("pos_brand",$field="",$where="1 ORDER BY brand");
										foreach($list_sql as $raw){
											if($arr->id_brand == $raw->id_brand){$pilih='selected';} else {$pilih='';}
										?>
                                        	<option value="<?php echo $raw->id_brand; ?>" <?php echo $pilih; ?>><?php echo $raw->brand; ?></option>
                                        <?php
										}
										?>                                        
										</select>
                                        </div>                                       
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-3">Kategori <span class="text-danger">*</span></label>
										<div class="col-lg-9">
                                        <select name="id_kategori" data-placeholder="Pilih :" class="select-size-lg required" id="kategori">
                                            <option value="">Pilih :</option>
                                        <?php
										$list_sql = $this->db_array("pos_kategori_produk",$field="",$where="1 ORDER BY kategori");
										foreach($list_sql as $raw){
											if($arr->id_kategori == $raw->id_kategori){$pilih='selected';} else {$pilih='';}
										?>
                                        	<option value="<?php echo $raw->id_kategori; ?>" <?php echo $pilih; ?>><?php echo $raw->kategori; ?></option>
                                        <?php
										}
										?>                                        
										</select>
                                        </div>                                       
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-3">Jenis Produk <span class="text-danger">*</span></label>
										<div class="col-lg-9">
                                        <select name="jenis_data" data-placeholder="Pilih :" class="select-size-lg required">
                                            <option value="">Pilih :</option>
                                        <?php
										$arr_list=array("stok","service");
										foreach($arr_list as $val_data){
											if($arr->jenis_data == $val_data){$pilih='selected';} else {$pilih='';}
										?>
                                        	<option value="<?php echo $val_data; ?>" <?php echo $pilih; ?>><?php echo $val_data; ?></option>
                                        <?php
										}
										?>                                        
										</select>
                                        </div>                                       
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-3">Serial Number <span class="text-danger">*</span></label>
										<div class="col-lg-9">
										<input type="text" name="sku" id="sku" class="form-control" placeholder="text input..." required="required" value="<?= $arr->sku; ?>"/>
                                        </div>                                       
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-3">Harga <span class="text-danger">*</span></label>
										<div class="col-lg-9">
										<input type="text" name="nominal" id="non_idr1" class="form-control" placeholder="text input..." required="required" onkeyup="LoadIDRupiah(1)" value="<?= $this->rupiah($arr->nominal,2); ?>"/>
                                        </div>                                       
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-3">Deskripsi </label>
										<div class="col-lg-9">
											<textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" placeholder="masukkan isian data"><?= $arr->deskripsi; ?></textarea>
										</div>
									</div>
</div>
<div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="col-lg-12">
									<div class="imagearea">
                                        <div class="avatarimage" id="drop-area">
                                        <?php
										if(empty($this->post("foto"))){
										?>
                                        <img src="<?php echo $this->base_url($config['folder_apps']); ?>images/no_pictures.png" alt="avatar"  id="avatarimage" style="width:250px; padding:6px;"/>
                                        <?php } else { ?>
                                        <img src="<?= $this->post("foto"); ?>" alt="avatar"  id="avatarimage"/>
                                        <?php } ?>
                                        <p>Drop your image here</p>
                                        </div>
                                    <div style="text-align:center;">
                                    <input type="hidden" name="foto" value="<?= $this->post("foto"); ?>" id="foto_upload">
                                    <span class="help-block" style="width:310px;">Accepted formats: png, jpg, jpeg. <br />Max file size 1Mb</span>
                                    </div>
                                        <div class="buttonarea" style="margin-left:85px;"> 
                                        <label class="btn btn-sm btn-info upload"> <i class="icon-import"></i> &nbsp; Browse Image<input type="file" class="sr-only" id="input" name="image" accept="image/*"></label>
                                        </div>
                                        <div class="alert" role="alert"></div>
                                    </div> 
                                        </div>
                                    </div>

</div>
</div>
<!-- END -->

                                    <div class="form-group">
										<label class="control-label col-lg-2">Spesifikasi </label>
										<div class="col-lg-10">
											<textarea name="spesifikasi" id="spesifikasi" class="form-control" rows="4" placeholder="masukkan isian data"><?= $arr->spesifikasi; ?></textarea>
										</div>
									</div>
								</fieldset>
								<div class="text-right">
									<button type="button" class="btn btn-danger" onclick="window.location='<?php echo $this->base_url($config["folder_apps"]).$folder_grid."/home"; ?>'"><i class="icon-arrow-left13 position-left"></i> Back</button>
									<button type="submit" class="btn btn-primary" name="simpan">Simpan <i class="icon-checkbox-checked position-right"></i></button>
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


<!-- The Make Selection Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header bg-primary">
        <h4 class="modal-title">Make a selection</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div id="cropimage">
		<img id="imageprev" src="<?php echo $this->base_url($config["folder_apps"]); ?>assets/cropper/img/bg.png"/>
		</div>
		
		<div class="progress">
		  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
		</div>
      </div>
	
      <!-- Modal footer -->
      <div class="modal-footer">
      	<div style="padding:10px;"></div>
		<div class="btngroup">
        <button type="button" class="btn btn-sm btn-danger upload1 float-left" data-dismiss="modal">Close <span class="icon-close2"></span></button>
		<button type="button" class="btn btn-sm btn-primary" id="rotateL" title="Rotate Left"><i class="icon-rotate-ccw3"></i></button>
        <button type="button" class="btn btn-sm btn-primary" id="rotateR" title="Rotate Right"><i class="icon-rotate-cw3"></i></button>
		<button type="button" class="btn btn-sm btn-primary" id="scaleX" title="Flip Horizontal"><i class="icon-move-horizontal"></i></button>
		<button type="button" class="btn btn-sm btn-primary" id="scaleY" title="Flip Vertical"><i class="icon-move-vertical"></i></button>  
		<button type="button" class="btn btn-sm btn-primary" id="reset" title="Reset"><i class="icon-database-refresh"></i></button> 
		<button type="button" class="btn btn-sm btn-success camera1 float-right" id="saveAvatar">Save <span class="icon-checkbox-checked"></span></button>
		</div>
      </div>

    </div>
  </div>
</div>

<script language="JavaScript">	
$('#myModal').on('hide.bs.modal', function () {
	$("#cropimage").html('<img id="imageprev" src="<?php echo $this->base_url($config["folder_apps"]); ?>assets/cropper/img/bg.png"/>');
})

/* UPLOAD Image */	
var input = document.getElementById('input');
var $alert = $('.alert');


/* DRAG and DROP File */
$("#drop-area").on('dragenter', function (e){
	e.preventDefault();
});

$("#drop-area").on('dragover', function (e){
	e.preventDefault();
});

$("#drop-area").on('drop', function (e){
	var image = document.querySelector('#imageprev');
	var files = e.originalEvent.dataTransfer.files;
	
	var done = function (url) {
          input.value = '';
          image.src = url;
          $alert.hide();
		  $("#myModal").modal({backdrop: "static"});
		  cropImage();
        };
		
	var reader;
        var file;
        var url;

        if (files && files.length > 0) {
          file = files[0];

          if (URL) {
            done(URL.createObjectURL(file));
          } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function (e) {
              done(reader.result);
            };
            reader.readAsDataURL(file);
          }
        }	
	
	e.preventDefault();	
	
});

/* INPUT UPLOAD FILE */
input.addEventListener('change', function (e) {
		//alert(1);
		var image = document.querySelector('#imageprev');
        var files = e.target.files;
        var done = function (url) {
          input.value = '';
          image.src = url;
          $alert.hide();
		  $("#myModal").modal({backdrop: "static"});
		  cropImage();
		  
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) {
          file = files[0];

          if (URL) {
            done(URL.createObjectURL(file));
          } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function (e) {
              done(reader.result);
            };
            reader.readAsDataURL(file);
          }
        }
      });
/* CROP IMAGE AFTER UPLOAD */	
function cropImage() {
      var image = document.querySelector('#imageprev');
      var minAspectRatio = 0.5;
      var maxAspectRatio = 1.5;
	  
      var cropper = new Cropper(image, {
		aspectRatio: 9 / 10,  
		minCropBoxWidth: 300,
		minCropBoxHeight: 350,

        ready: function () {
          var cropper = this.cropper;
          var containerData = cropper.getContainerData();
          var cropBoxData = cropper.getCropBoxData();
          var aspectRatio = cropBoxData.width / cropBoxData.height;
          //var aspectRatio = 4 / 3;
          var newCropBoxWidth;
		  cropper.setDragMode("move");
          if (aspectRatio < minAspectRatio || aspectRatio > maxAspectRatio) {
            newCropBoxWidth = cropBoxData.height * ((minAspectRatio + maxAspectRatio) / 2);

            cropper.setCropBoxData({
              left: (containerData.width - newCropBoxWidth) / 2,
              width: newCropBoxWidth
            });
          }
        },

        cropmove: function () {
          var cropper = this.cropper;
          var cropBoxData = cropper.getCropBoxData();
          var aspectRatio = cropBoxData.width / cropBoxData.height;

          if (aspectRatio < minAspectRatio) {
            cropper.setCropBoxData({
              width: cropBoxData.height * minAspectRatio
            });
          } else if (aspectRatio > maxAspectRatio) {
            cropper.setCropBoxData({
              width: cropBoxData.height * maxAspectRatio
            });
          }
        },
		
		
      });
	  
	  $("#scaleY").click(function(){ 
		var Yscale = cropper.imageData.scaleY;
		if(Yscale==1){ cropper.scaleY(-1); } else {cropper.scaleY(1);};
	  });
	  
	  $("#scaleX").click( function(){ 
		var Xscale = cropper.imageData.scaleX;
		if(Xscale==1){ cropper.scaleX(-1); } else {cropper.scaleX(1);};
	  });
	  
	  $("#rotateR").click(function(){ cropper.rotate(45); });
	  $("#rotateL").click(function(){ cropper.rotate(-45); });
	  $("#reset").click(function(){ cropper.reset(); });
	  
	  $("#saveAvatar").click(function(){
		  var $progress = $('.progress');
		  var $progressBar = $('.progress-bar');
		  var avatar = document.getElementById('avatarimage');
		  var $alert = $('.alert');
          canvas = cropper.getCroppedCanvas({
            width: 300,
            height: 350,
          });
          $progress.show();
          $alert.removeClass('alert-success alert-warning');
          canvas.toBlob(function (blob) {
            var formData = new FormData();
            formData.append('avatar', blob, 'avatar.jpg');
            $.ajax({
              type: 'POST',
			  url: "<?php echo $this->base_url($config["folder_apps"]); ?>ajax/setting/ajax_x",
              data: formData,
			  //data : {avatar: avatar},
              processData: false,
              contentType: false,
    
	          xhr: function () {
                var xhr = new XMLHttpRequest();

                xhr.upload.onprogress = function (e) {
                  var percent = '0';
                  var percentage = '0%';

                  if (e.lengthComputable) {
                    percent = Math.round((e.loaded / e.total) * 100);
                    percentage = percent + '%';
                    $progressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
                  }
                };

                return xhr;
              },

              success: function (result) {
                //$alert.show().addClass('alert-success').text('Upload success');
				//alert(result+' = OKE');
              },

              error: function () {
                avatar.src = initialAvatarURL;
                $alert.show().addClass('alert-warning').text('Upload error');
              },

              complete: function () {
				$("#myModal").modal('hide');  
                $progress.hide();
				initialAvatarURL = avatar.src;
				avatar.src = canvas.toDataURL();
				$("#foto_upload").val(($('#avatarimage').attr('src')));
              },
            });
          });
	  });
};	
</script>
<?php
} else { $this->redirect($folder_grid."/home"); }
} else { $this->redirect("home"); }