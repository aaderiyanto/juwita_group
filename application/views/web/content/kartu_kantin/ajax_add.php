<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if($this->cek_login()== TRUE){
		$table = "bmt_qrcode";
		$validation = $this->set_validation(array("jumlah_cetak","keterangan"));
		if($validation == true){
			for($for=1; $for<=$this->post("jumlah_cetak"); $for++){
				$id_primary	= "QRC".$this->kode_uniq(17);
				$data_array = array("id_qrcode" => $id_primary,
									"keterangan" => $this->post("keterangan"),
									"tgl_input" => date("Y-m-d H:i:s"),
									"user_input" => $this->baca_session('id_admin')
									);
				$this->db_insert($data_array, $table);
			}
			echo json_encode(array("status" => TRUE));
		} else { echo json_encode(array("status" => FALSE)); }

}
?>