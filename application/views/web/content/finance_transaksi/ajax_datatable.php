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
		$table = "finance_transaksi a";
		$column_order = array(null,"a.tgl_transaksi","a.no_transaksi","b.nama_akun","a.nominal","a.keterangan","a.flag_aktif");
		$column_search = array("a.tgl_transaksi","a.no_transaksi","b.nama_akun","a.nominal","IF(a.flag_aktif=1,'Ya Aktif','Tidak Aktif')");
		$order_by = array('a.tgl_input' => 'DESC'); // default order
		$where_default = ""; 
		$field_tbl = "a.*, b.nama_akun";
		$join_table = array("finance_akun b" => "b.id_akun=a.id_akun");
		$list = $this->get_datatables($table,$column_order,$column_search,$order_by,$where_default,$field_tbl,$join_table);
		$data = array();
		if(isset($_POST['start'])){$no = $_POST['start'];} else {$no="";}
		foreach ($list as $person) {
			$no++;
			if($person->flag_aktif == 1){$aktif='<span class="label label-info">Ya Aktif</span>';} else
									    {$aktif='<span class="label label-danger">Tidak</span>';}
			$row = array();
			$row[] = $no.".";
			$row[] = $this->tgl_indo($person->tgl_transaksi);
			$row[] = $person->no_transaksi;
			$row[] = $person->nama_akun;
			$row[] = 'Rp. <span style="float:right;">'.$this->rupiah($person->nominal).'</span>';
			//$row[] = $person->keterangan;
			if($person->flag_aktif==1){
			$row[] ='<a class="" href="javascript:void(0)" title="Reversal data" onclick="reversal('."'".$person->id_ft."'".')"><i class="icon-exclamation text-warning"></i> '.$aktif.'</a>';
			} else {
			$row[] = $aktif;
			}
			//add html for action
			if($person->flag_aktif == 1){
			$row[] = '<a class="" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$person->id_ft."'".')"><i class="glyphicon glyphicon-pencil"></i></a> &nbsp; 
				  <a class="" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$person->id_ft."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			} else {$row[] ='-';}
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