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
	$validation = $this->set_validation(array("jenis_data","id_akun","tgl_transaksi","nominal","flag_aktif","keterangan"));
	$arr = $this->data_array("finance_transaksi","id_ft='".$this->post("id")."'");
	if(!empty($arr->id_ft)){
		if($validation == true){
			$from_replace = [".",","]; $to_replace = ["","."];
			$nominal = str_replace($from_replace,$to_replace,$this->post("nominal"));
			$data_array = array("id_ft" => $id_primary,
								"jenis_data" => $this->post("jenis_data"),
								"id_akun" => $this->post("id_akun"),
								"tgl_transaksi" => $this->post("tgl_transaksi"),
								"nominal" => $nominal,
								"flag_aktif" => $this->post("flag_aktif"),
								"keterangan" => $this->post("keterangan"),
								"tgl_update" => date("Y-m-d H:i:s"),
								"user_update" => $this->baca_session("id_admin")
								);
			$save=$this->db_update($data_array,$table,"id_ft='".$this->post("id")."'");
			if($save == TRUE){
				// Update saldo akun
				$arr_akun = $this->data_array("finance_akun","id_akun='".$this->post("id_akun")."'");
				$arr_akun_awal = $this->data_array("finance_akun","id_akun='".$arr->id_akun."'");
					if($arr->jenis_data == "d"){
						$this->data_update("finance_akun","debit=debit-".$nominal.", saldo=saldo-".$nominal,"id_akun='".$arr_akun->id_akun."'");
					}
					// Kredit - Pengeluaran
					else {
						$this->data_update("finance_akun","kredit=kredit-".$nominal.", saldo=saldo+".$nominal,"id_akun='".$arr_akun->id_akun."'");
					}
				// Proses baru
				// ********************************************************* //
				if($arr->flag_aktif==1){
					if(!empty($arr_akun->id_akun)){
						// Debit-Pemasukan
						if($this->post("jenis_data") == "d"){
							$this->data_update("finance_akun","debit=debit+".$nominal.", saldo=saldo+".$nominal,"id_akun='".$arr_akun->id_akun."'");
						}
						// Kredit - Pengeluaran
						else {
							$this->data_update("finance_akun","kredit=kredit+".$nominal.", saldo=saldo-".$nominal,"id_akun='".$arr_akun->id_akun."'");
						}
					}
				} 
				// DATA di aktifkan kembali
				else {
					if(!empty($arr_akun->id_akun)){
						// Debit-Pemasukan
						if($this->post("jenis_data") == "d"){
							$this->data_update("finance_akun","debit=debit+".$nominal.", saldo=saldo+".$nominal,"id_akun='".$arr_akun->id_akun."'");
						}
						// Kredit - Pengeluaran
						else {
							$this->data_update("finance_akun","kredit=kredit+".$nominal.", saldo=saldo-".$nominal,"id_akun='".$arr_akun->id_akun."'");
						}
					}
				}
				echo json_encode(array("status" => TRUE));
			}
		} else { echo json_encode(array("status" => FALSE)); }
	} else { echo json_encode(array("status" => FALSE)); }
}
?>