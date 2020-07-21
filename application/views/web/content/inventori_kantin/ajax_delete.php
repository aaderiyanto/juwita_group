<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if($this->cek_login()== TRUE){
	$this->db_delete(array("bmt_info_asset"),"id_infoasset='".$url_system[4]."'");
	echo json_encode(array("status" => TRUE));
}
?>