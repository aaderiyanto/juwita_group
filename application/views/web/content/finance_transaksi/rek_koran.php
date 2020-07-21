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
$from = $this->post("from");
$to = $this->post("to");
$id_akun = $this->post("id_akun");
$arr_akun = $this->data_array("finance_akun","id_akun='".$id_akun."'");
if(!empty($arr_akun->id_akun)){
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
	<td align="center">
    <div style="font-weight:bold; font-size:14px;">LAPORAN REKENING KORAN</div>
    <div style="font-weight:bold; font-size:14px; text-transform:uppercase;"><?= $arr_akun->nama_akun; ?></div>
    <div style="font-weight:bold; font-size:14px;"><?= $set->nama_perusahaan; ?></div>
    </td>
</tr>
</table>
<hr class="style-one">
<div class="spasi"></div>
<div style="padding-bottom:5px; font-size:11px;">Dari <?= $this->tgl_indo($from).' s.d '.$this->tgl_indo($to); ?></div>
<table class="table" width="100%" border="1">
<tr>
	<th width="4%">NO</th>
    <th width="12%">TANGGAL</th>
    <th width="14%">NO. TRANSAKSI</th>
    <th width="14%">DEBIT</th>
    <th width="14%">KREDIT</th>
    <th width="14%">SALDO</th>
    <th>DESKRIPSI</th>
</tr>
<?php
$sql = $this->db_array("finance_transaksi a",$field="a.*",$where="1 AND a.tgl_transaksi BETWEEN '".$from."' AND '".$to."' AND a.flag_aktif='1' AND a.id_akun='".$id_akun."' ORDER BY a.tgl_transaksi,a.no_transaksi");
$no=0;
$subdebit=0;
$subkredit=0;
$subsaldo=0;
$saldo_awal = $this->saldo_rekkoran($from,$id_akun);
foreach($sql as $raw):
$no++;
if($raw->jenis_data == "d"){$debit=$raw->nominal; $kredit=0;} else
if($raw->jenis_data == "k"){$debit=0; $kredit=$raw->nominal;}
// saldo akun
if($no==1){ $sisa_saldo = $saldo_awal + $debit - $kredit; } else {
	$sisa_saldo = $sisa_saldo + $debit - $kredit;
}

$subdebit  = $subdebit + $debit;
$subkredit = $subkredit + $kredit;
$subsaldo = $subsaldo + $sisa_saldo;
?>
<tr>
	<td align="center"><?php echo $no; ?></td>
	<td><?php echo $this->tgl_indo($raw->tgl_transaksi); ?></td>
	<td><?php echo $raw->no_transaksi; ?></td>
	<td align="right"><span style="float:left;">Rp. </span> <?php echo $this->rupiah($debit); ?></td>
	<td align="right"><span style="float:left;">Rp. </span> <?php echo $this->rupiah($kredit); ?></td>
	<td align="right"><span style="float:left;">Rp. </span> <?php echo $this->rupiah($sisa_saldo); ?></td>
	<td><?php echo $raw->keterangan; ?></td>
</tr>
<?php 
endforeach; 
if($arr_po->flag_ppn==1){
	$nilai_ppn = $subtotal * 0.1;
	$grand_total = $subtotal + $nilai_ppn;
} else { $grand_total=$subtotal; }
?>
<tr>
	<td colspan="3" align="right">Total</td>
	<td align="right"><span style="float:left;">Rp. </span> <?php echo $this->rupiah($subdebit); ?></td>
	<td align="right"><span style="float:left;">Rp. </span> <?php echo $this->rupiah($subkredit); ?></td>
	<td align="right"><span style="float:left;">&nbsp;</td>
</tr>
</table>
<div class="spasi"></div>

<table class="table" width="100%" border="0">
<tr>
	<td width="35%">&nbsp;</td>
    <td width="30%">&nbsp;</td>
    <td align="center"><?= $set->lokasi; ?>, <?php echo $this->tgl_indo($config["tgl"]); ?></td>
</tr>
<tr>
	<td align="center">&nbsp;</td>
    <td>&nbsp;</td>
	<td align="center">
    	Pimpinan,
        <br /><br /><br /><br /><br /><br />
        <!--<div style="padding:34px;"></div>-->
        ( <b><?php echo $set->pimpinan; ?></b> )<br>
        <hr class="style-one">
    </td>
</tr>
</table>
</div>
<?php
}
}
?>