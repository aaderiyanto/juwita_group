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
	$table = "finance_transaksi";
	$field = "id_ft";
	$data = $this->data_array($table,"$field = '".$url_system[4]."'");
	echo json_encode($data);
}
?>