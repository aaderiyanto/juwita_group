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
		$table = "pos_vendor";
		$column_order = array(null,"nama","kategori_vendor","no_hp","alamat");
		$column_search = array("nama","kategori_vendor","no_hp","alamat");
		$order_by = array('tgl_input' => 'DESC'); // default order
		$where_default = ""; 
		$field_tbl = "";
		$join_table = "";
		$list = $this->get_datatables($table,$column_order,$column_search,$order_by,$where_default,$field_tbl,$join_table);
		$data = array();
		if(isset($_POST['start'])){$no = $_POST['start'];} else {$no="";}
		foreach ($list as $person) {
			$no++;
			//if($person->flag_aktif == 1){$aktif='<span class="badge badge-success">Aktif</span>';} else
			//if($person->flag_aktif == 0){$aktif='<span class="badge badge-danger">Tidak Aktif</span>';}
			$row = array();
			$row[] = $no.".";
			$row[] = $person->nama;
			$row[] = $person->kategori_vendor;
			$row[] = $person->no_hp;
			$row[] = $person->alamat;
			//add html for action
			$row[] = '<a class="" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$person->id_vendor."'".')"><i class="glyphicon glyphicon-pencil"></i></a> &nbsp; 
				  <a class="" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$person->id_vendor."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
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