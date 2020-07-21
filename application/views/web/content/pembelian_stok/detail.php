<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if($this->cek_login() == TRUE){
if(in_array($this->baca_session("level"),array("gudang"))){$display='style="display:none;"';} else {$display="";}
$id = $this->post("id");
$arr = $this->data_array("gudang_pembelian","id_gudangpembelian='$id'");
if(!empty($arr->id_gudangpembelian)){
if($arr->flag_aktif == "1"){$flag_aktif="<span class='label label-success'>Ya</span>";} else 
					       {$flag_aktif="<span class='label label-danger'>Tidak</span>";}
if($arr->flag_lunas == "1"){$flag_lunas="<span class='label label-success'>Ya, Sudah Lunas</span>";} else 
					       {$flag_lunas="<span class='label label-danger'>Belum Lunas</span>";}
$arr_kasir = $this->data_array("bmt_user","id_user='".$arr->user_input."'");
$arr_po = $this->data_array("pos_po","id_po='".$arr->id_po."'");
?>

<link href="<?php echo $this->base_url($config["folder_apps"]); ?>assets/css/ribbon.css" rel="stylesheet" type="text/css">

<div class="panel-body">
	<div class="tabbable">
		<ul class="nav nav-tabs nav-tabs-top">
			<li class="active"><a href="#top-tab1" data-toggle="tab">Data Transaksi</a></li>
		</ul>

<?php if($arr->flag_lunas == "1"){ ?>
<div class="ribbon-wrapper-green"><div class="ribbon-green">LUNAS</div></div>
<?php } else  ?>
<?php if($arr->flag_lunas == "0"){ ?>
<div class="ribbon-wrapper-green"><div class="ribbon-warning">BLM LUNAS</div></div>
<?php } ?>

		<div class="tab-content">
		<div class="tab-pane active" id="top-tab1">
<div style="overflow:auto; z-index:1900px;">
<table class="table">
<tr style="background:#339AA6; color:#FFF; font-weight:bold;">
	<th width="20%">Field</th>
    <th width="2%">&nbsp;</th>
    <th>Value Data</th>
</tr>
<tr>
	<td style="vertical-align:top; background:#E9E9E9;">Tgl. Invoice</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td><?php echo $this->tgl_indo($arr->tgl_invoice); ?></td>
</tr>
<tr>
	<td style="background:#E9E9E9;">Nomor Invoice</td>
    <td style="background:#E9E9E9;">:</td>
    <td><?php echo $arr->no_invoice; ?></td>
</tr>
<tr>
	<td style="background:#E9E9E9;">Nomor P.O</td>
    <td style="background:#E9E9E9;">:</td>
    <td><?php echo $arr_po->nomor_po; ?></td>
</tr>
<tr <?= $display; ?>>
	<td style="vertical-align:top; background:#E9E9E9;">Total Nominal</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td>Rp. <?php echo $this->rupiah($arr->total_nominal,2); ?></td>
</tr>
<tr>
	<td style="vertical-align:top; background:#E9E9E9;">Terms</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td><?php echo $arr->terms; ?> hari</td>
</tr>
<tr>
	<td style="vertical-align:top; background:#E9E9E9;">Batas Tempo</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td><?php echo $this->tgl_indo($arr->batas_tempo); ?></td>
</tr>
<tr>
	<td style="vertical-align:top; background:#E9E9E9;">Status Lunas</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td><?php echo $flag_lunas; ?></td>
</tr>
<tr>
	<td style="vertical-align:top; background:#E9E9E9;">Data Aktif</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td><?php echo $flag_aktif; ?></td>
</tr>
<tr>
	<td style="vertical-align:top; background:#E9E9E9;">Keterangan</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td><?php echo $arr->keterangan; ?></td>
</tr>
</table>

<!-- DETAIL -->
			<table class="table table-bordered table-hover" id="tab_logic" width="100%">
				<thead>
					<tr class="bg-primary">
						<th class="text-center" width="6%">No.</th>
						<th class="text-center">Item</th>
                        <th class="text-center" width="10%">Qty</th>
                        <th class="text-center" width="25%" <?= $display; ?>>Sub Total</th>
					</tr>
				</thead>
				<tbody>
<?php
$list_sql = $this->db_array("gudang_pembelian_detail a, gudang_pembelian b, pos_produk c",$field="a.*,c.nama_produk",$where="1 AND a.id_gudangpembelian=b.id_gudangpembelian AND a.id_produk=c.id_produk AND a.id_gudangpembelian='".$arr->id_gudangpembelian."' ORDER BY c.nama_produk");
$nomor=0;
$total_hg=0;
foreach($list_sql as $raw):
	$nomor++;
	$sub_total = $raw->nominal * $raw->jumlah;
	$total_hg = $total_hg + $sub_total;
?>
					<tr style="border:dotted 1px #999999;">
						<td style='vertical-align:top; text-align:center; border-left:dotted 1px #999999; border-bottom:dotted 1px #999999;'><?= $nomor; ?>.</td>
						<td>
                        <?= $raw->nama_produk; ?>
                        (<span>Rp. </span><?= $this->rupiah($raw->nominal); ?>)</td>
                        <td align="right">
							<?= $raw->jumlah; ?>
                        </td>
                        <td align="right" <?= $display; ?>>
                        	<span style="float:left;">Rp. </span><?= $this->rupiah($sub_total); ?>
                        </td>
					</tr>
<?php
endforeach;
?>
				<tr <?= $display; ?>>
                	<td colspan="3" align="right">Sub Total : </td>
                    <td align="right"><span style="float:left;">Rp. </span><?= $this->rupiah($total_hg); ?></td>
                </tr>
<?php
if($arr->flag_ppn==1){
$ppn_nilai=$total_hg * 0.1;
$grand_total=$total_hg + $ppn_nilai;
?>
				<tr <?= $display; ?>>
                	<td colspan="3" align="right">PPN : </td>
                    <td align="right"><span style="float:left;">Rp. </span><?= $this->rupiah($ppn_nilai); ?></td>
				</tr>
				<tr <?= $display; ?>>
                	<td colspan="3" align="right">Total Tagihan : </td>
                    <td align="right"><span style="float:left;">Rp. </span><?= $this->rupiah($grand_total); ?></td>
				</tr>
<?php
} else { $grand_total=$sub_total; }
?>
				</tbody>
			</table>
</div>

				</div>
				
		</div>
	</div>
</div>

							<div class="modal-footer">
                                <button type="button" class="btn btn-danger close_modal"><span class="icon-close2"></span> Close</button> 
							</div>

<?php
}
}
?>