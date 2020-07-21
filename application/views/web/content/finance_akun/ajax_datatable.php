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
		$table = "finance_akun";
		$column_order = array(null,"jenis_akun","nama_akun","rekening","saldo");
		$column_search = array("jenis_akun","nama_akun","rekening","saldo");
		$order_by = array('jenis_akun' => 'ASC'); // default order
		$where_default = ""; 
		$field_tbl = "";
		$join_table = "";
		$list = $this->get_datatables($table,$column_order,$column_search,$order_by,$where_default,$field_tbl,$join_table);
		$data = array();
		if(isset($_POST['start'])){$no = $_POST['start'];} else {$no="";}
		foreach ($list as $person) {
			$no++;
			$row = array();
			$row[] = $no.".";
			$row[] = $person->jenis_akun;
			$row[] = $person->nama_akun;
			$row[] = $person->rekening;
			$row[] = 'Rp. <span style="float:right;">'.$this->rupiah($person->saldo).'</span>';
			//add html for action
			$row[] = '<a class="" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$person->id_akun."'".')"><i class="glyphicon glyphicon-pencil"></i></a> &nbsp; 
				  <a class="" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$person->id_akun."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
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