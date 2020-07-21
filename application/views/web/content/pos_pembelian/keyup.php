<?php
/**
 * Created by Balqon Media Teknologi.
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@balqon.tech
 * Website : https://balqon.co.id/ OR https://balqon.tech/
 */
if($this->cek_login()== TRUE){
	$npm = $this->post("npm");
	if(isset($npm)) {
		$sql=$this->db_array("sikad_mahasiswa",$field="",$where="npm='".$npm."'");
		foreach($sql as $raw):
			echo $raw->npm;
		endforeach;
	}
}
?>