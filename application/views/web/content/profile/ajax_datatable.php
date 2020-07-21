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
		if($this->baca_session("level") != "admin"){
			$where_default = array("username='".$this->baca_session("username")."'"); 
		} else { $where_default = ''; }
		$table = "bmt_user";
		$column_order = array(null,"username","nama","level","flag_aktif");
		$column_search = array("username","nama","level","IF(flag_aktif='1','Ya','Tidak')");
		$order_by = array('tgl_input' => 'DESC'); // default order
		$field_tbl = "";
		$join_table = "";
		$list = $this->get_datatables($table,$column_order,$column_search,$order_by,$where_default,$field_tbl,$join_table);
		$data = array();
		if(isset($_POST['start'])){$no = $_POST['start'];} else {$no="";}
		foreach ($list as $person) {
			$no++;
			if($person->flag_aktif==1){$aktif='<span class="label label-info">Ya</span>';} else
			if($person->flag_aktif==0){$aktif='<span class="label label-danger">Tidak</span>';}
			//if($person->id_user == "USR11213453HGTTD"){$level='Superadmin';} else {$level=$person->level;}
			$level = ucwords(str_replace("_"," ",$person->level));
			$row = array();
			//$row[] = $no.".";
			$row[] = $person->id_user;
			$row[] = $person->username;
			$row[] = $person->nama;
			$row[] = $level;
			$row[] = $aktif;
			//add html for action
			if(!in_array($this->baca_session("level"),$not_access)){
			$row[] = '<a class="btn btn-xs btn-info" href="'.$this->base_url($config["folder_apps"]).'profile/edit/'.$person->id_user.'" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>';
			} else { $row[] = '-'; }
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