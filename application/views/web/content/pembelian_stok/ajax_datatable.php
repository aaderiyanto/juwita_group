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
		$table = "gudang_pembelian a";
		$column_order = array(null,"a.tgl_invoice","a.no_invoice","b.nama","a.total_nominal","a.flag_aktif","a.flag_lunas");
		$column_search = array("a.tgl_invoice","a.no_invoice","b.nama","a.total_nominal","IF(a.flag_aktif='1','Ya','Tidak')","IF(a.flag_lunas='1','Sdh Lunas','Blm Lunas')");
		$order_by = array('tgl_invoice'=>'DESC'); // default order
		$field_tbl = "a.*, b.nama";
		$join_table = array("pos_vendor b" => "b.id_vendor=a.bill_to");
		$list = $this->get_datatables($table,$column_order,$column_search,$order_by,$where_default,$field_tbl,$join_table);
		$data = array();
		if(isset($_POST['start'])){$no = $_POST['start'];} else {$no="";}
		foreach ($list as $person) {
			$no++;
			if($person->flag_aktif == 1){$aktif='<span class="label label-info">Ya</span>';} else
									    {$aktif='<span class="label label-danger">Tidak</span>';}
			if($person->flag_lunas == 1){$lunas='<span class="label label-success">Sdh Lunas</span>';} else
									    {$lunas='<span class="label label-danger">Blm Lunas</span>';}
			$row = array();
			//$row[] = $no.".";
			$row[] = $person->id_gudangpembelian;
			$row[] = $this->tgl_indo($person->tgl_invoice);
			$row[] = $person->no_invoice;
			$row[] = $person->nama;
			$row[] = 'Rp. <span style="float:right;">'.$this->rupiah($person->total_nominal,2).'</span>';
			$row[] = $aktif;
			$row[] = $lunas;
			//add html for action
			if($person->flag_lunas == 0){
			$row[] = '<a class="btn btn-sm bg-teal" href="'.$this->base_url($config["folder_apps"]).'pembelian_stok/pembayaran/'.$person->id_gudangpembelian.'" title="Pembayaran"><i class="icon-check2"></i></a>';
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