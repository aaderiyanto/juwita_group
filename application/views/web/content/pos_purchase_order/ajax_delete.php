<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if($this->cek_login()== TRUE){
	$arr = $this->data_array("pos_po","id_po='".$url_system[4]."'");
	if(!empty($arr->id_po)){
		$this->db_delete(array("pos_po","pos_po_detail"),"id_po='".$arr->id_po."'");
		echo json_encode(array("status" => TRUE));
	} else { echo json_encode(array("status" => FALSE)); }
}
?>