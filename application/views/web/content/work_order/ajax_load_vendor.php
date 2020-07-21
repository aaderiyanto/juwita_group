<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if($this->cek_login()== TRUE){
	$nama_vendor = $this->post("nama");
	if($this->post('id') == 1 && isset($nama_vendor)){
		$arr_data = $this->data_array("pos_vendor","nama='".$nama_vendor."'");
		if(!empty($arr_data->id_vendor)){
			echo $arr_data->id_vendor;
		}
	} else 
	if(isset($nama_vendor)){
		$list_sql = $this->db_array("pos_vendor",$field="",$where="1 ORDER BY nama");
		foreach($list_sql as $raw):
		 if($nama_vendor == $raw->nama){$pilih='selected';} else {$pilih='';}
		echo '<option value="'.$raw->id_vendor.'" '.$pilih.'>'.$raw->nama.'</option>';
		endforeach;
	}
}
?>