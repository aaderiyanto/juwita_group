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
		$table = "pos_produk a";
		$column_order = array(null,"b.brand","a.nama_produk","a.stok","a.nominal","a.flag_aktif");
		$column_search = array("b.brand","a.nama_produk","a.stok","a.nominal","IF(a.flag_aktif='1','Ya','Tidak')");
		$order_by = array('b.brand' => 'ASC', 'a.nama_produk'=>'ASC'); // default order
		$field_tbl = "a.*, b.brand, c.kategori";
		$join_table = array("pos_brand b" => "b.id_brand=a.id_brand",
							"pos_kategori_produk c" => "c.id_kategori=a.id_kategori");
		$list = $this->get_datatables($table,$column_order,$column_search,$order_by,$where_default,$field_tbl,$join_table);
		$data = array();
		if(isset($_POST['start'])){$no = $_POST['start'];} else {$no="";}
		foreach ($list as $person) {
			$no++;
			if($person->flag_aktif == 1){$aktif='<span class="label label-info">Ya</span>';} else
									    {$aktif='<span class="label label-danger">Tidak</span>';}
			$row = array();
			//$row[] = $no.".";
			$row[] = $person->id_produk;
			$row[] = $person->brand;
			$row[] = $person->nama_produk;
			$row[] = $person->stok;
			$row[] = $person->stok_gudang;
			$row[] = 'Rp. <span style="float:right;">'.$this->rupiah($person->nominal,2).'</span>';
			$row[] = $aktif;
			//add html for action
			if(in_array($this->baca_session("level"),array("admin","administrasi","pimpinan"))){
			$row[] = '<a class="" href="'.$this->base_url($config["folder_apps"]).'produk/edit/'.$person->id_produk.'" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a> &nbsp;
				      <a class="" href="'.$this->base_url($config["folder_apps"]).'produk/copy/'.$person->id_produk.'" title="Copy"><i class="icon-copy3 text-warning"></i></a> &nbsp; 
				      <a class="" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$person->id_produk."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			} else {
			$row[] = '<a class="" href="'.$this->base_url($config["folder_apps"]).'produk/edit/'.$person->id_produk.'" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a> &nbsp;
				      <a class="" href="'.$this->base_url($config["folder_apps"]).'produk/copy/'.$person->id_produk.'" title="Copy"><i class="icon-copy3 text-warning"></i></a>';
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