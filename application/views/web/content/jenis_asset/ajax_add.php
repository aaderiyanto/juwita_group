<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if($this->cek_login()== TRUE){
		$table = "bmt_asset";
		$id_primary	= "AST".$this->kode_uniq(10).rand(100,999);
		$validation = $this->set_validation(array("nama_asset","keterangan"));
		if($validation == true){
			$data_array = array("id_asset" => $id_primary,
								"nama_asset" => $this->post("nama_asset"),
								"keterangan" => $this->post("keterangan"),
								"tgl_input" => date("Y-m-d H:i:s"),
								"user_input" => $this->baca_session('id_admin')
								);
			$this->db_insert($data_array, $table);
			echo json_encode(array("status" => TRUE));
		} else { echo json_encode(array("status" => FALSE)); }

}
?>