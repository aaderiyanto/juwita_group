<?php
/**
 * Created by BMT Solutions.
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
date_default_timezone_set('Asia/Jakarta');
$seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
$hari = date("w");
$hari_ini = $seminggu[$hari];
// SET CONFIG
$config = ["folder_apps" => "juwita_group",
           "company_name" => "Juwita Group",
		   "font_google" => "https://fonts.googleapis.com/",
		   "titik" => array("."),
		   "koma" => array(","),
		   "tgl" => date("Y-m-d"),
		   "tgl_jam" => date("Y-m-d H:i:s"),
		   "jam" => date("H:i:s"),
		   "hari_ini" => $hari_ini,
		   "nama_hari" => $seminggu,
		   "lokasi_cetak" => "Banjarmasin"];
		   
$meta = ["meta_title" => $set->meta_title];
