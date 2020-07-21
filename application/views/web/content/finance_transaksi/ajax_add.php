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
		$validation = $this->set_validation(array("jenis_data","id_akun","tgl_transaksi","nominal","keterangan"));
		if($validation == true){
			$arr = $this->data_array("finance_transaksi","LEFT(tgl_transaksi,7)='".substr($this->post("tgl_transaksi"),0,7)."' AND jenis_data='".$this->post("jenis_data")."' ORDER BY RIGHT(no_transaksi,4) DESC");
			if(!empty($arr->no_transaksi)){
				$urutan = substr($arr->no_transaksi,-4);
				$no_transaksi='TR-'.$this->post("jenis_data").'/'.substr($this->post("tgl_transaksi"),2,2).substr($this->post("tgl_transaksi"),5,2).'/'.substr('000'.($urutan+1),-4);
			} else { $no_transaksi='TR-'.$this->post("jenis_data").'/'.substr($this->post("tgl_transaksi"),2,2).substr($this->post("tgl_transaksi"),5,2).'/0001'; }
			$from_replace = [".",","]; $to_replace = ["","."];
			$nominal = str_replace($from_replace,$to_replace,$this->post("nominal"));
			$id_primary	= "TRN".$this->kode_uniq(14).rand(100,999);
			$data_array = array("id_ft" => $id_primary,
								"jenis_data" => $this->post("jenis_data"),
								"id_akun" => $this->post("id_akun"),
								"tgl_transaksi" => $this->post("tgl_transaksi"),
								"nominal" => $nominal,
								"no_transaksi" => strtoupper($no_transaksi),
								//"flag_aktif" => $this->post("flag_aktif"),
								"keterangan" => $this->post("keterangan"),
								"tgl_input" => date("Y-m-d H:i:s"),
								"user_input" => $this->baca_session("id_admin")
								);
			$save=$this->db_insert($data_array, $table);
			if($save==TRUE){
				// Update saldo akun
				$arr_akun = $this->data_array("finance_akun","id_akun='".$this->post("id_akun")."'");
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
				echo json_encode(array("status" => TRUE));
			}
		} else { echo json_encode(array("status" => FALSE)); }

}
?>