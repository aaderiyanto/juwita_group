<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if($this->cek_login()== TRUE){
	$table = "bmt_info_asset";
	$validation = $this->set_validation(array("id_asset","tanggal","kondisi","keterangan"));
	if($validation == true){
		$data_array = array("id_asset" => $this->post("id_asset"),
							"jenis_asset" => 'gudang',
							"tanggal" => $this->post("tanggal"),
							"kondisi" => $this->post("kondisi"),
							"keterangan" => $this->post("keterangan"),
							"flag_aktif" => $this->post("flag_aktif"),
							"tgl_update" => date("Y-m-d H:i:s"),
							"user_update" => $this->baca_session('id_admin')
							);
		$this->db_update($data_array,$table,"id_infoasset='".$this->post("id")."'");
		echo json_encode(array("status" => TRUE));
	} else { echo json_encode(array("status" => FALSE)); }
}
?>