<?php
/**
 * Created by BMT Solutions.
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if($this->cek_login()== TRUE){
	$id_provinsi = $this->post("id_provinsi");
	$id_kabupaten = $this->post("id_kabupaten");
	$id_kecamatan = $this->post("id_kecamatan");
	if(isset($id_provinsi)) {
		$sql=$this->db_array("tbl_kabupaten",$field="",$where="id_propinsi='$id_provinsi' ORDER BY nama_kabupaten");
		foreach($sql as $raw){
			echo "<option value=".$raw->id_kabupaten.">".$raw->nama_kabupaten."</option>\n";
		}
	}
	
	if(isset($id_kabupaten)) {
		$sql=$this->db_array("tbl_kecamatan",$field="",$where="id_kabupaten='$id_kabupaten' ORDER BY nama_kecamatan");
		foreach($sql as $raw){
			echo "<option value=".$raw->id_kecamatan.">".$raw->nama_kecamatan."</option>\n";
		}
	}
	
	if (isset($id_kecamatan)) {
		$sql=$this->db_array("tbl_kelurahan",$field="",$where="id_kecamatan='$id_kecamatan' ORDER BY nama_kelurahan");
		foreach($sql as $raw){
			echo "<option value=".$raw->id_kelurahan.">".$raw->nama_kelurahan."</option>\n";
		}
	}
}
?>