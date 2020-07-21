<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
// akses login tidak ditemukan
if($this->cek_login()== TRUE){
		$where_default = "";
		$table = "bmt_manufacture a";
		$column_order = array(null,"a.tgl_buat","a.nomor_mo","a.nama_produk","b.nama","a.flag_data");
		$column_search = array("a.tgl_po","a.nomor_po","b.nama","a.nominal","CASE WHEN a.flag_data='1' THEN 'Selesai' WHEN a.flag_data='2' THEN 'Pending' WHEN a.flag_data='3' THEN 'Dalam Proses' WHEN a.flag_data='0' THEN 'Batal' END");
		$order_by = array('a.tgl_input'=>'DESC'); // default order
		$field_tbl = "a.*, b.nama";
		$join_table = array("pos_vendor b" => "b.id_vendor=a.id_vendor");
		$list = $this->get_datatables($table,$column_order,$column_search,$order_by,$where_default,$field_tbl,$join_table);
		$data = array();
		if(isset($_POST['start'])){$no = $_POST['start'];} else {$no="";}
		foreach ($list as $person) {
			$no++;
			if($person->flag_data == 1){$flag_data='<span class="label label-info">Selesai</span>';} else
			if($person->flag_data == 2){$flag_data='<span class="label label-warning">Pending</span>';} else
			if($person->flag_data == 3){$flag_data='<span class="label label-warning">Dalam Proses</span>';} else
									   {$flag_data='<span class="label label-danger">Batal</span>';}
			$row = array();
			//$row[] = $no.".";
			$row[] = $person->id_manufacture;
			$row[] = $this->tgl_indo($person->tgl_buat);
			$row[] = $person->nomor_mo;
			$row[] = $person->nama_produk;
			$row[] = $person->nama;
			if(in_array($person->flag_data,array("2","3")) && in_array($this->baca_session("level"),array("admin","pimpinan","administrasi"))){
				$row[] = '<a class="" href="'.$this->base_url($config["folder_apps"]).'manufacturing_order/validasi/'.$person->id_manufacture.'" title="Validasi Data"><i class="glyphicon glyphicon-check"></i> '.$flag_data.'</a>';
			} else {
				$row[] = $flag_data;
			}
			//add html for action
			if(in_array($person->flag_data,array("2","3"))){
			$row[] = '<a class="" href="'.$this->base_url($config["folder_apps"]).'manufacturing_order/edit/'.$person->id_manufacture.'" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a> &nbsp;
				      <a class="" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$person->id_manufacture."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			} else {
			$row[] ='-';
			}
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