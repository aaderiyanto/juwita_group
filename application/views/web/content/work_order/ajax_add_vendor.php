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
		$id_primary	= "VND".$this->kode_uniq(10).rand(100,999);
		$validation = $this->set_validation(array("nama","kategori_vendor","alamat","no_hp"));
		if($validation == true){
			$data_array = array("id_vendor" => $id_primary,
								"nama" => $this->post("nama"),
								"kategori_vendor" => $this->post("kategori_vendor"),
								"alamat" => $this->post("alamat"),
								"no_hp" => $this->post("no_hp"),
								"email" => $this->post("email"),
								"tgl_input" => date("Y-m-d H:i:s"),
								"user_input" => $this->baca_session('id_admin')
								);
			$this->db_insert($data_array, $table);
			echo json_encode(array("status" => TRUE));
		} else { echo json_encode(array("status" => FALSE)); }

}
?>