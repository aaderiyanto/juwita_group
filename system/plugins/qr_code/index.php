<?php
error_reporting(0);
include("phpqrcode/phpqrcode.php");	
$data=$_GET['code'];
if(!empty($data)){ QRcode::png($data); }
?>