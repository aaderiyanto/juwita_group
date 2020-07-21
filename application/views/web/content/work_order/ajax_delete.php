<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if($this->cek_login()== TRUE){
	$arr = $this->data_array("bmt_manufacture","id_manufacture='".$url_system[4]."'");
	if(!empty($arr->id_manufacture)){
		$this->db_delete(array("bmt_manufacture","bmt_manufacture_detail"),"id_manufacture='".$arr->id_manufacture."'");
		echo json_encode(array("status" => TRUE));
	} else { echo json_encode(array("status" => FALSE)); }
}
?>