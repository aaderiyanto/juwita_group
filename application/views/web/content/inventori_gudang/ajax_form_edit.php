<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
// akses login tidak ditemukan
if($this->cek_login()== TRUE){
	$table = "bmt_info_asset";
	$field = "id_infoasset";
	$data = $this->data_array($table,"$field = '".$url_system[4]."'");
	echo json_encode($data);
}
?>