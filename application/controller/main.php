<?php
/**
 * Created by BMT Solutions.
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if(count($url_system)==0){
	$this->isi_content("home",$web="front",$level_akses="");
} else { 
	$direktori = "";
	foreach($url_system as $loc_file){
		$direktori .= $loc_file."/";
	}
	$direktori = rtrim($direktori,"/");
	$this->isi_content($direktori,$web="front",$max_folder="2"); 
}
?>