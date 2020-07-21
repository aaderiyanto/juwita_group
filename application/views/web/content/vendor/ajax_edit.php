<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if($this->cek_login()== TRUE){
	$table = "pos_vendor";
	$validation = $this->set_validation(array("nama","kategori_vendor","alamat","no_hp"));
	if($validation == true){
		$data_array = array("nama" => $this->post("nama"),
							"kategori_vendor" => $this->post("kategori_vendor"),
							"alamat" => $this->post("alamat"),
							"no_hp" => $this->post("no_hp"),
							"email" => $this->post("email"),
							"tgl_update" => date("Y-m-d H:i:s"),
							"user_update" => $this->baca_session('id_admin')
							);
		$this->db_update($data_array,$table,"id_vendor='".$this->post("id")."'");
		echo json_encode(array("status" => TRUE));
	} else { echo json_encode(array("status" => FALSE)); }
}
?>