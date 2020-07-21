<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if($this->cek_login()== TRUE){
	$table = "finance_transaksi";
	$arr = $this->data_array("finance_transaksi","id_ft='".$url_system[4]."'");
	if(!empty($arr->id_ft)){
		$data_array = array("flag_aktif" => 0,
							"tgl_update" => date("Y-m-d H:i:s"),
							"user_update" => $this->baca_session("id_admin")
							);
		$save=$this->db_update($data_array,$table,"id_ft='".$arr->id_ft."'");
		if($save == TRUE){
			// Update saldo akun
			if($arr->jenis_data == "d"){
				$this->data_update("finance_akun","debit=debit-".$arr->nominal.", saldo=saldo-".$arr->nominal,"id_akun='".$arr->id_akun."'");
			}
			// Kredit - Pengeluaran
			else {
				$this->data_update("finance_akun","kredit=kredit-".$arr->nominal.", saldo=saldo+".$arr->nominal,"id_akun='".$arr->id_akun."'");
			}
			echo json_encode(array("status" => TRUE));
		}
	} else { echo json_encode(array("status" => FALSE)); }
}
?>