<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if($this->cek_login()== TRUE){
	$table = "finance_akun";
	$validation = $this->set_validation(array("jenis_akun","nama_akun","rekening"));
	if($validation == true){
		$from_replace = [".",","]; $to_replace = ["","."];
		$harga = str_replace($from_replace,$to_replace,$this->post("harga"));
		$data_array = array("jenis_akun" => $this->post("jenis_akun"),
							"nama_akun" => $this->post("nama_akun"),
							"rekening" => $this->post("rekening"),
							"tgl_update" => date("Y-m-d H:i:s"),
							"user_update" => $this->baca_session("id_admin")
							);
		$this->db_update($data_array,$table,"id_akun='".$this->post("id")."'");
		echo json_encode(array("status" => TRUE));
	} else { echo json_encode(array("status" => FALSE)); }
}
?>