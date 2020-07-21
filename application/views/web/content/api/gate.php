<?php
/**
 * Created by BMT Solutions.
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
// FUNGSI API OPEN GATE
if($api->post("userkey")!='' && $api->post("passkey")!='') {
$userkey=$api->post("userkey");
$passkey=$api->post("passkey");
$d=$api->post("d");
$v=$api->post("v");
} else {$userkey='';$passkey='';}
// Pengecekan Userkey dan Passkey
if($api->cek_key($userkey,$passkey)==FALSE) {exit();}

if($d=='open') {echo $api->json_opengate($v);}
//echo $api->json_opengate("YRRMGDMM4KMH5SSFFYR7x");
?>