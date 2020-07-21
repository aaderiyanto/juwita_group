<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
$not_access = array("cashier");
if($this->cek_login()== TRUE && !in_array($this->baca_session("level"),$not_access)){
$id_manufacture = $url_system[4];
$arr_po = $this->data_array("bmt_manufacture","id_manufacture='".$id_manufacture."'");
if(!empty($arr_po->id_manufacture) && $arr_po->flag_data!=0){
$arr_vendor = $this->data_array("pos_vendor","id_vendor='".$arr_po->id_vendor."'");
$arr_input = $this->data_array("bmt_user","id_user='".$arr_po->user_input."'");
$arr_validasi = $this->data_array("bmt_user","id_user='".$arr_po->user_update."'");
?>
<title>Cetak</title>
<link href="<?php echo $this->base_url($config["folder_apps"]); ?>assets/css/print/style.css" rel="stylesheet" type="text/css">
<style>
/*body {
	width:750px;
	font-size:12px;
}
table {
	font-size:12px;
}*/
.hr {
	border-bottom:solid 1px #666666; padding:2px;
}
.spasi {
	padding:8px;
}
.border-head {
	border-top:dashed 1px #333333;
	border-bottom:dashed 1px #333333;
	padding:8px;
}
p.pagebreakhere {page-break-before:always}
hr.style-one {
    border: 0;
    height: 1px;
    background: #333;
    background-image: linear-gradient(to right, #ccc, #333, #ccc);
}
</style>
<div class="page-potrait">
<table class="table" width="100%" border="0">
<tr>
	<td width="60%">
    Produk : <b><?= $arr_po->nama_produk; ?></b><br />
    Jumlah : <?= $this->rupiah($arr_po->jumlah); ?>
    </td>
    <td>
    <div style="font-size:20px; font-weight:bold; text-transform:uppercase;">Manufacturing Order</div>
    </td>
</tr>
</table>
<div class="spasi"></div>
<hr class="style-one">
<div class="spasi"></div>
<table class="table" width="100%" border="0">
<tr>
	<td width="60%" rowspan="4" style="vertical-align:top;">
    <div style="margin-bottom:5px; font-weight:bold;">Kepada:</div>
    <div style="padding:5px; border:solid 1px #999999; border-radius:4px;">
	<b><?= $arr_vendor->nama; ?></b><br>
    <?= str_replace("\n","<br>",$arr_vendor->alamat); ?>
    </div>
    </td>
    <td width="5%"></td>
    <td width="10%">Nomor M.O.</td>
    <td width="2%">:</td>
    <td><?= $arr_po->nomor_mo; ?></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Tanggal Buat</td>
    <td	>:</td>
    <td><?= $this->tgl_indo($arr_po->tgl_buat); ?></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Estimasi</td>
    <td	>:</td>
    <td><?= $this->tgl_indo($arr_po->tgl_selesai); ?></td>
</tr>
</table>
<div class="spasi"></div>
<table class="table" width="100%" border="1">
<tr>
	<th width="4%">NO</th>
    <th>ITEM DESKRIPSI</th>
    <th width="10%">QTY</th>
</tr>
<?php
$sql = $this->db_array("bmt_manufacture_detail a, pos_produk b",$field="a.*, b.nama_produk",$where="1 AND a.id_produk=b.id_produk AND a.id_manufacture='".$id_manufacture."' ORDER BY b.nama_produk");
$no=0;
$subtotal=0;
foreach($sql as $raw):
$no++;
?>
<tr>
	<td align="center"><?php echo $no; ?></td>
	<td><?php echo $raw->nama_produk; ?></td>
	<td align="right"><?php echo $this->rupiah($raw->jumlah); ?></td>
</td>
</tr>
<?php 
endforeach; 
?>
</table>
<div class="spasi"></div>

<table class="table" width="100%" border="0">
<tr>
	<td width="35%">&nbsp;</td>
    <td width="30%">&nbsp;</td>
    <td align="center"><?= $set->lokasi; ?>, <?php echo $this->tgl_indo($config["tgl"]); ?></td>
</tr>
<tr>
	<td align="center">
    	Disetujui Oleh
        <br /><br /><br /><br /><br /><br />
        <!--<div style="padding:34px;"></div>-->
        ( .....................................
        <!--<b><?php echo $arr_validasi->nama; ?></b>--> )<br>
        <hr class="style-one">
        Tanggal : <!--<?= date("d/m/Y H:i",strtotime($arr_po->tgl_update)); ?>-->
        		  .....................................
    </td>
    <td>&nbsp;</td>
	<td align="center">
    	Dibuat Oleh,
        <br /><br /><br /><br /><br /><br />
        <!--<div style="padding:34px;"></div>-->
        ( <b><?php echo $arr_input->nama; ?></b> )<br>
        <hr class="style-one">
        Tanggal : <?= date("d/m/Y H:i",strtotime($arr_po->tgl_input)); ?>
    </td>
</tr>
</table>
</div>
<?php
}
}
?>