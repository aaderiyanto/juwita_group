<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if($this->cek_login()== TRUE){
?>
<form action="#" method="post" class="form-horizontal" autocomplete="off">
							<div class="modal-body">
                        	<fieldset class="content-group">
                                <div class="form-group">
									<label class="control-label col-sm-2">Jurusan</label>
									<div class="col-sm-10">
									<select class="select-size-lg" name="jurusan" id="jurusan" data-live-search="true" data-width="100%">
                                        <option value="">Pilih : </option>
                                        <?php
										$sql=$this->db_array("sikad_jurusan",$field="",$where="1 ORDER BY jurusan");
										foreach($sql as $row){
										?>
                                        <option value="<?php echo $row->id_jurusan; ?>"><?php echo $row->jurusan." - (".$row->jenjang.")"; ?></option>
                                        <?php
										}
										?>
									</select>
									</div>
								</div>
							</fieldset>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger close_modal"><i class="icon-close2 position-left"></i> Close</button> 
                                <button type="button" class="btn btn-primary" name="cari" id="cari" onClick="goToURL()">Download Data <i class="icon-download"></i></button>
							</div>
</form>

<?php
}
?>