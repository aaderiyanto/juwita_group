<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if($this->cek_login()== TRUE){
	if(empty($url_system[4])){$tahun=date("Y");} else {$tahun=$url_system[4];}
	function grafik_hp($tahun,$jenis_data)
	{
		global $conf;
		$rows = array();
		if($jenis_data=="piutang"){$jd='Penjualan';} else {$jd='Pembelian';}
		$rows['name'] = ucwords($jd);
		for($bl=1; $bl<=12; $bl++){
			$th_bulan = $tahun."-".substr("0".$bl,-2);
			$nominal = $conf->data_select("pos_transaksi","SUM(total_nominal)","jenis_data='".$jenis_data."' AND LEFT(tgl_invoice,7)='".$th_bulan."' AND flag_aktif='1'");
			if(empty($nominal)){$nominal=0;} else {$nominal=$nominal;}
			$rows['data'][] = $nominal;
		}
		return $rows;
	}
	$result = array();
	array_push($result,grafik_hp($tahun,$jenis_data="piutang"));
	array_push($result,grafik_hp($tahun,$jenis_data="hutang"));
	print json_encode($result, JSON_NUMERIC_CHECK);
}
?>