<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if($this->cek_login()== TRUE){
		$table = "pos_brand";
		$id_primary	= "BRN".$this->kode_uniq(10).rand(100,999);
		$validation = $this->set_validation(array("brand"));
		if($validation == true){
			$data_array = array("id_brand" => $id_primary,
								"brand" => $this->post("brand"),
								"flag_aktif" => $this->post("flag_aktif"),
								"tgl_input" => date("Y-m-d H:i:s"),
								"user_input" => $this->baca_session('id_admin')
								);
			$this->db_insert($data_array, $table);
			echo json_encode(array("status" => TRUE));
		} else { echo json_encode(array("status" => FALSE)); }

}
?>