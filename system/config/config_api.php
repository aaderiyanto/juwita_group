<?php
/**
 * Created by BMT Solutions.
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
class waterboom_api extends MethodFungsi{
	
	public function cek_key($userkey,$passkey)
	{
		//$sql=$this->db_array("pos_brand",$field="",$where="1 ORDER BY brand");
		//foreach($sql as $raw):
		if(($userkey=='gate001') && ($passkey=='waterboom!@#2020')) {return TRUE;} else {return FALSE;}
		//endforeach;
	}

	public function json_opengate($v)
	{
		$arr_tiket=$this->data_array("bmt_tiket_masuk","qr_code='".$v."'");
		$return_json = array();
		if(empty($arr_tiket->qr_code))
		{
			$row_array['data'] = '0';
			$row_array['kode_error'] = '14';
			$row_array['msg'] = 'No Referensi tidak ada';
			$kode_error='14';
		} else
		if(!empty($arr_tiket->qr_code)){
			if($arr_tiket->flag_scan==0){
				$row_array['qr_code'] = $arr_tiket->qr_code;
				$row_array['hari'] = $arr_tiket->hari;
				$row_array['harga'] = $arr_tiket->harga_tiket;
				//$row_array['info'] = 'tiket aktif';
				$row_array['data'] = '1';
				$row_array['kode_error'] = '00';
				$row_array['msg'] = '';
				//$kode_error='00';
			} 
			// 
			else {
				$row_array['data'] = '0';
				$row_array['kode_error'] = '88';
				$row_array['msg'] = 'Tiket tidak aktif';
				//$kode_error='88';
			}
		}
		array_push($return_json,$row_array);
		return json_encode($return_json);
	}

}

$api = new waterboom_api();
?>