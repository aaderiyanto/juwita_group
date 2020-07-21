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
if(in_array($this->baca_session("level"),array("gudang"))){$display='style="display:none;"';} else {$display="";}
$arr = $this->data_array("gudang_pembelian","id_gudangpembelian='".$url_system[3]."'");
if(!empty($arr->id_gudangpembelian)){
$arr_vendor = $this->data_array("pos_vendor","id_vendor='".$arr->bill_to."'");
$arr_po = $this->data_array("pos_po","id_po='".$arr->id_po."'");
$nilai_cicilan = $this->data_select("gudang_pembelian_cicilan","SUM(nominal)","id_gudangpembelian='".$arr->id_gudangpembelian."' AND flag_aktif='1'");
$sisa_pembayaran = $arr->total_nominal - $nilai_cicilan;

if($this->post('simpan',true)){
	if($this->post("flag_lunas") == 1){$flag_lunas='1'; $tgl_lunas=$this->post("tanggal");} else 
							         {$flag_lunas='0'; $tgl_lunas='';}
	// Save
	$data_array = array("flag_lunas" => $flag_lunas,
						"tgl_lunas" => $tgl_lunas,
						"tgl_update" => date("Y-m-d H:i:s"),
						"user_update" => $this->baca_session('id_admin')
					    );
	$sql = $this->db_update($data_array,"gudang_pembelian","id_gudangpembelian='".$arr->id_gudangpembelian."'");
	if($sql == TRUE){ 
		// Redirect Page 
		$this->redirect($folder_grid."/home/2"); 
	} // akhir update data
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
							<h5 class="panel-title">Form Pembayaran - <?= $title_grid; ?></h5>
                            <hr />
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                	</ul>
		                	</div>
						</div>

					<div class="panel-body">
                            <form class="form-horizontal form-validate-jquery" action="" method="post" autocomplete="off" enctype="multipart/form-data">
                            <!--<div class="info_error"></div>-->
								<fieldset class="content-group">
                                    <div class="form-group">
										<label class="control-label col-lg-2">Nomor Invoice </label>
										<div class="col-lg-10">
										<input type="text" name="x" id="x" class="form-control" placeholder="Jika kosong akan di generate otomatis" disabled="disabled" value="<?= $arr->no_invoice; ?>"/>
                                        </div>                                       
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Vendor <span class="text-danger">*</span></label>
										<div class="col-lg-10">
                                        <input type="text" name="x" id="x" class="form-control" placeholder="Jika kosong akan di generate otomatis" disabled="disabled" value="<?= $arr_vendor->nama; ?>"/>
                                        </div>
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Nomor PO <span class="text-danger">*</span></label>
										<div class="col-lg-10">
                                        <input type="text" name="x" id="x" class="form-control" placeholder="Jika kosong akan di generate otomatis" disabled="disabled" value="<?= $arr_po->nomor_po; ?>"/>
                                        </div>
									</div>
                                    <div class="form-group" <?= $display; ?>>
										<label class="control-label col-lg-2">Nilai Pembelian <span class="text-danger">*</span></label>
										<div class="col-lg-10">
                                        <input type="text" name="x" id="x" class="form-control" placeholder="Jika kosong akan di generate otomatis" disabled="disabled" value="<?= $this->rupiah($arr->total_nominal); ?>"/>
                                        </div>
									</div>
                                    <div class="form-group" <?= $display; ?>>
										<label class="control-label col-lg-2">Sudah Dibayar <span class="text-danger">*</span></label>
										<div class="col-lg-10">
                                        <input type="text" name="x" id="x" class="form-control" placeholder="Jika kosong akan di generate otomatis" disabled="disabled" value="<?= $this->rupiah($nilai_cicilan); ?>"/>
                                        </div>
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Tanggal Pembayaran <span class="text-danger">*</span></label>
										<div class="col-lg-10">
										<input type="text" name="tanggal" id="date-modal" class="form-control" placeholder="text input..." required="required" value="<?= $config['tgl']; ?>"/>
                                        </div>                                       
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Status Data <span class="text-danger">*</span></label>
										<div class="col-lg-10">
                                        <select name="flag_lunas" data-placeholder="Pilih :" class="select-size-lg required" id="flag_lunas" required>
                                            <option value="">Pilih :</option>
                                        <?php
										$arr_lunas = array("0"=>"Belum Lunas","1"=>"Sudah Lunas");
										foreach($arr_lunas as $id_val=>$val_data):
										if($arr->flag_lunas == $id_val){$pilih='selected';} else {$pilih='';}
										?>
                                        	<option value="<?php echo $id_val; ?>" <?= $pilih; ?>><?php echo $val_data; ?></option>
                                        <?php
										endforeach;
										?>                                        
										</select>
                                        </div>
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Keterangan </label>
										<div class="col-lg-10">
											<textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="masukkan isian data"></textarea>
										</div>
									</div>      
								</fieldset>
								<div class="text-right">
									<button type="button" class="btn btn-danger" onclick="window.location='<?php echo $this->base_url($config["folder_apps"]).$folder_grid."/home"; ?>'"><i class="icon-arrow-left13 position-left"></i> Back</button>
									<button type="submit" class="btn btn-primary" name="simpan" id="simpan">Simpan <i class="icon-checkbox-checked position-right"></i></button>
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

<?php
} else { $this->redirect($folder_grid."/home"); }
} else { $this->redirect("home"); }