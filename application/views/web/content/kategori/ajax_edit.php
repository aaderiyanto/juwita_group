<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if($this->cek_login()== TRUE){
	$table = "pos_kategori_produk";
	$validation = $this->set_validation(array("kategori"));
	if($validation == true){
		$data_array = array("kategori" => $this->post("kategori"),
							"flag_aktif" => $this->post("flag_aktif"),
							"tgl_update" => date("Y-m-d H:i:s"),
							"user_update" => $this->baca_session('id_admin')
							);
		$this->db_update($data_array,$table,"id_kategori='".$this->post("id")."'");
		echo json_encode(array("status" => TRUE));
	} else { echo json_encode(array("status" => FALSE)); }
}
?>