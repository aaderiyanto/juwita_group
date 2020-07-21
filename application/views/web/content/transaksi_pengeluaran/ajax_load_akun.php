<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if($this->cek_login()== TRUE){
	$id_akun = $this->post("id_akun");
	if($this->post('id') == 1 && isset($id_akun)){
		$arr_data = $this->data_array("finance_akun","id_akun='".$id_akun."'");
		if(!empty($arr_data->id_akun)){
			echo $arr_data->saldo;
		}
	}
}
?>