<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if($this->cek_login()== TRUE){
	$arr = $this->data_array("pos_produk","id_produk='".$url_system[4]."'");
	if(!empty($arr->id_produk)){
		$this->db_delete(array("pos_produk"),"id_produk='".$arr->id_produk."'");
		if(!empty($arr->foto)){ unlink(ROOT_DIR."fupload/produk/".$arr->foto); }
		echo json_encode(array("status" => TRUE));
	} else { echo json_encode(array("status" => FALSE)); }
}
?>