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
		$where_default = array("a.flag_gudang='1'");
		$table = "pos_po a";
		$column_order = array(null,"a.tgl_po","a.nomor_po","b.nama","a.nominal","a.flag_po");
		$column_search = array("a.tgl_po","a.nomor_po","b.nama","a.nominal","CASE WHEN a.flag_po='1' THEN 'Sdh Disetujui' WHEN a.flag_po='2' THEN 'Pending' WHEN a.flag_po='0' THEN 'Batal' END");
		$order_by = array('a.tgl_po'=>'DESC'); // default order
		$field_tbl = "a.*, b.nama";
		$join_table = array("pos_vendor b" => "b.id_vendor=a.bill_to");
		$list = $this->get_datatables($table,$column_order,$column_search,$order_by,$where_default,$field_tbl,$join_table);
		$data = array();
		if(isset($_POST['start'])){$no = $_POST['start'];} else {$no="";}
		foreach ($list as $person) {
			$no++;
			if($person->flag_po == 1){$flag_po='<span class="label label-info">Sdh Disetujui</span>';} else
			if($person->flag_po == 2){$flag_po='<span class="label label-warning">Pending</span>';} else
									 {$flag_po='<span class="label label-danger">Batal</span>';}
			$row = array();
			//$row[] = $no.".";
			$row[] = $person->id_po;
			$row[] = $this->tgl_indo($person->tgl_po);
			$row[] = $person->nomor_po;
			$row[] = $person->nama;
			$row[] = 'Rp. <span style="float:right;">'.$this->rupiah($person->nominal,2).'</span>';
			if($person->flag_po == 2 && in_array($this->baca_session("level"),array("admin","pimpinan","administrasi"))){
				$row[] = '<a class="" href="'.$this->base_url($config["folder_apps"]).'purchase_order/validasi/'.$person->id_po.'" title="Validasi Data"><i class="glyphicon glyphicon-check"></i> '.$flag_po.'</a>';
			} else {
				$row[] = $flag_po;
			}
			//add html for action
			if($person->flag_po == 2){
			$row[] = '<a class="" href="'.$this->base_url($config["folder_apps"]).'purchase_order/edit/'.$person->id_po.'" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a> &nbsp;
				      <a class="" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$person->id_po."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
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