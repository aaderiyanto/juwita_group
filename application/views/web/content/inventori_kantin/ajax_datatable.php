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
		$table = "bmt_info_asset a";
		$column_order = array(null,"a.jenis_asset","a.tanggal","b.nama_asset","a.kondisi","a.flag_aktif","a.keterangan");
		$column_search = array("a.jenis_asset","a.tanggal","b.nama_asset","a.kondisi","IF(a.flag_aktif=1,'Aktif','Tidak Aktif')");
		$order_by = array('a.tgl_input' => 'DESC'); // default order
		$where_default = array("a.jenis_asset='kantin'"); 
		$field_tbl = "a.*,b.nama_asset";
		$join_table = array("bmt_asset b" => "b.id_asset=a.id_asset");
		$list = $this->get_datatables($table,$column_order,$column_search,$order_by,$where_default,$field_tbl,$join_table);
		$data = array();
		if(isset($_POST['start'])){$no = $_POST['start'];} else {$no="";}
		foreach ($list as $person) {
			$no++;
			if($person->flag_aktif == 1){$aktif='<span class="badge badge-success">Aktif</span>';} else
			if($person->flag_aktif == 0){$aktif='<span class="badge badge-danger">Tidak Aktif</span>';}
			$row = array();
			//$row[] = $person->id_infoasset;
			$row[] = $no;
			$row[] = $person->jenis_asset;
			$row[] = $this->tgl_indo($person->tanggal);
			$row[] = $person->nama_asset;
			$row[] = $person->kondisi;
			$row[] = $aktif;
			//add html for action
			$row[] = '<a class="" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$person->id_infoasset."'".')"><i class="glyphicon glyphicon-pencil"></i></a> &nbsp; 
				  <a class="" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$person->id_infoasset."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
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