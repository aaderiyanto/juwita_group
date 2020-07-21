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
		$where_default = array("a.flag_aktif='1'","a.jenis_data='stok'");
		$table = "pos_produk a";
		$column_order = array(null,"b.brand","a.nama_produk","a.stok","a.nominal");
		$column_search = array("b.brand","a.nama_produk","a.stok","a.nominal");
		$order_by = array('b.brand'=>'ASC','a.nama_produk'=>'ASC'); // default order
		$field_tbl = "a.*, b.brand";
		$join_table = array("pos_brand b" => "b.id_brand=a.id_brand");
		$list = $this->get_datatables($table,$column_order,$column_search,$order_by,$where_default,$field_tbl,$join_table);
		$data = array();
		if(isset($_POST['start'])){$no = $_POST['start'];} else {$no="";}
		foreach ($list as $person) {
			$no++;
			$row = array();
			//$row[] = $no.".";
			$row[] = $person->id_produk;
			$row[] = $person->brand;
			$row[] = $person->nama_produk;
			$row[] = $person->stok_gudang;
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