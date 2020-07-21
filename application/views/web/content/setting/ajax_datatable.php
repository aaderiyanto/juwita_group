<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
// akses login tidak ditemukan
$title_grid = ucwords(strtolower(str_replace('_',' ',$url_system[1])));
if($this->cek_login()== TRUE){
		$table = "setting_apps";
		$column_order = array(null,"meta_title","meta_deskripsi","meta_keyword","nama_perusahaan","alamat","lokasi");
		$column_search = array("meta_title","meta_deskripsi","meta_keyword","nama_perusahaan","alamat","lokasi");
		$order_by = array('id_setting' => 'DESC'); // default order
		$where_default = ""; 
		$field_tbl = "";
		$join_table = "";
		$list = $this->get_datatables($table,$column_order,$column_search,$order_by,$where_default,$field_tbl,$join_table);
		$data = array();
		if(isset($_POST['start'])){$no = $_POST['start'];} else {$no="";}
		foreach ($list as $person) {
			$no++;
			$row = array();
			//$row[] = $no.".";
			$row[] = $person->id_setting;
			$row[] = $person->meta_title;
			$row[] = $person->meta_deskripsi;
			$row[] = $person->meta_keyword;
			$row[] = $person->nama_perusahaan;
			$row[] = $person->alamat;
			$row[] = $person->lokasi;
			//add html for action
			//if($this->baca_session("level") == "admin"){
			$row[] = '<a class="btn btn-xs btn-info" href="'.$this->base_url($config["folder_apps"]).'setting/edit/'.$person->id_setting.'" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>';
			//} else { $row[] = '-'; }
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