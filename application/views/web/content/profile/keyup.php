<?php
/**
 * Created by Balqon Media Teknologi.
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@balqon.tech
 * Website : https://balqon.co.id/ OR https://balqon.tech/
 */
if($this->cek_login()== TRUE){
	$username = $this->post("username");
	if(isset($username)) {
		$arr_data=$this->data_array("bmt_user","1 AND username='".$username."'");
		if(!empty($arr_data->username)){
			echo $arr_data->username;
		}
	}	
}
?>