<!--
/**
 * Created by BMT Solutions.
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
-->
<?php
$not_access = array("cashier");
if($this->cek_login()== TRUE && !in_array($this->baca_session("level"),$not_access)){
$arr = $this->data_array("bmt_qrcode","id_qrcode='".$url_system[4]."'");
if(!empty($arr->id_qrcode)){
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $set->meta_title; ?></title>
    <link href="<?= $this->base_url($config['folder_apps']); ?>assets/css/print/style.css" rel="stylesheet" type="text/css">
</head>
<body>

<div class="page-potrait">
<div style="width:50%; border:solid 1px #999999; border-radius:4px; padding:4px;">
<table width="100%">
<tr>
	<td colspan="2" align="center" style="border-bottom:dotted 1px #999999;">
    	<div style="font-weight:bold; text-transform:uppercase; padding:5px;">Kartu Kantin</div>
    </td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td width="65%" style="vertical-align:top;">
	<b><?= $set->nama_perusahaan; ?></b><br>
    <?= str_replace("\n","<br>",$set->alamat); ?><br>
	<?= str_replace("\n","<br>",$set->lokasi); ?><br><br>
    </td>
    <td align="center">
    <?= '<img src="'.$this->base_url($config['folder_apps']).'system/plugins/qr_code/?code='.$arr->id_qrcode.'" alt="'.$person->qr_code.'"  style="width:150px%; padding:2px; border:solid 2px #CCCCCC;"/>'; ?>
    </td>
</tr>
<tr>
	<td><span style="font-weight:bold; font-style:italic; font-size:9px;">*) Harap di kembalikan jk sudah selesai.</span></td>
    <td align="center"><b style="font-size:9px;">(<?= $arr->id_qrcode; ?>)</b></td>
</tr>
</table>
</div>

</body>
</html>
<?php
$this->data_update("bmt_qrcode","flag_print='1', tgl_print='".date("Y-m-d H:i:s")."', tgl_update='".date("Y-m-d H:i:s")."', user_update='".$this->baca_session("id_admin")."'","id_qrcode='".$arr->id_qrcode."'");
}
}
?>