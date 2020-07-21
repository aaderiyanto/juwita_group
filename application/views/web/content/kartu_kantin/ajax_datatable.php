<?php
/**
 * Created by BMT Solutions.
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
// akses login tidak ditemukan
if($this->cek_login()== TRUE){
		$table = "bmt_qrcode";
		$column_order = array(null,"id_qrcode","id_qrcode","keterangan","flag_print","flag_aktif");
		$column_search = array("id_qrcode","keterangan","IF(flag_print='1','Sudah di Print','Belum di Print')","IF(flag_aktif='1','Aktif','Tidak Aktif')");
		$order_by = array('tgl_input' => 'DESC'); // default order
		$where_default = ""; 
		$field_tbl = "";
		$join_table = "";
		$list = $this->get_datatables($table,$column_order,$column_search,$order_by,$where_default,$field_tbl,$join_table);
		$data = array();
		if(isset($_POST['start'])){$no = $_POST['start'];} else {$no="";}
		foreach ($list as $person) {
			$no++;
			if($person->flag_aktif == 1){$aktif='<span class="badge badge-success">Aktif</span>';} else
			if($person->flag_aktif == 0){$aktif='<span class="badge badge-danger">Tidak Aktif</span>';}
			if($person->flag_print == 1){$flag_print='<span class="badge badge-success">Sudah di Print</span>';} else
			if($person->flag_print == 0){$flag_print='<span class="badge badge-danger">Belum di Print</span>';}
			$qrcode = '<img src="'.$this->base_url($config['folder_apps']).'system/plugins/qr_code/?code='.$person->id_qrcode.'" alt="'.$person->qr_code.'"  style="width:150px%; padding:2px; border:solid 2px #CCCCCC;"/>';
			$row = array();
			$row[] = $no.".";
			$row[] = $qrcode;
			$row[] = $person->id_qrcode;
			$row[] = $person->keterangan;
			$row[] = $flag_print;
			$row[] = $aktif;
			//add html for action
			$row[] = '<a class="" href="'.$this->base_url($config['folder_apps']).'ajax/kartu_kantin/cetak_kartu/'.$person->id_qrcode.'" title="Cetak" target="_blank"><i class="icon-printer"></i></a> &nbsp;
					  <a class="" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$person->id_qrcode."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			$data[] = $row;
		}
		if(isset($_POST['draw'])){$draw=$_POST['draw'];} else {$draw="";}
		$output = array(
						"draw" => $draw,
						"recordsTotal" => $this->count_all($table,$where_default,$join_table),
						"recordsFiltered" => $this->count_filtered($table,$column_order,$column_search,$order_by,$where_default,$field_tbl,$join_table),
						"data" => $data,
				);
		//output to json format
		header('Content-Type: application/json');
		echo json_encode($output);

}
?>