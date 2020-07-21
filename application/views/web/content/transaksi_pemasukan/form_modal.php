<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if($this->cek_login() == TRUE){
?>

<div class="panel-body">
                            <form class="form-horizontal form-validate-jquery" action="<?= $this->base_url($config['folder_apps']); ?>ajax/transaksi_pemasukan/rek_koran" method="post" autocomplete="off" enctype="multipart/form-data" target="_blank">
                            <div class="info_error"></div>
								<fieldset class="content-group">
                                    <div class="form-group">
										<label class="control-label col-lg-3">Akun </label>
										<div class="col-lg-9">
                                        <select name="id_akun" data-placeholder="Pilih :" class="select-size-lg" id="id_akun">
                                            <option value="">Pilih :</option>
                                        <?php
										$list_sql = $this->db_array("finance_akun",$field="",$where="1 ORDER BY nama_akun");
										foreach($list_sql as $raw){
										?>
                                        	<option value="<?php echo $raw->id_akun; ?>"><?php echo $raw->nama_akun; ?></option>
                                        <?php
										}
										?>                                        
										</select>
                                        </div>                                       
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-3">Kategori </label>
										<div class="col-lg-9">
                                        <select name="id_katfinance" data-placeholder="Pilih :" class="select-size-lg" id="id_katfinance">
                                            <option value="">Pilih :</option>
                                        <?php
										$list_sql = $this->db_array("finance_kategori",$field="",$where="1 ORDER BY kategori");
										foreach($list_sql as $raw){
										?>
                                        	<option value="<?php echo $raw->id_katfinance; ?>"><?php echo $raw->kategori; ?></option>
                                        <?php
										}
										?>                                        
										</select>
                                        </div>                                       
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-3">Dari Tanggal <span class="text-danger">*</span></label>
										<div class="col-lg-9">
										<input type="text" name="from" id="date-modal" value="<?= $config['tgl']; ?>" class="form-control" placeholder="text input..." required="required"/>
                                        </div>                                       
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-3">Sampai Tanggal <span class="text-danger">*</span></label>
										<div class="col-lg-9">
										<input type="text" name="to" id="date-modal1" value="<?= $config['tgl']; ?>" class="form-control" placeholder="text input..." required="required"/>
                                        </div>                                       
									</div>
								</fieldset>
								<div class="text-right">
									<button type="submit" class="btn btn-primary" name="simpan">Cetak <i class="icon-printer position-right"></i></button>
                                    <button type="button" class="btn btn-danger close_modal"><span class="icon-close2"></span> Close</button> 
								</div>
							</form>

</div>
<?php
}
?>