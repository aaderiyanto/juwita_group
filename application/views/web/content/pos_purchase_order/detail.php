<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if($this->cek_login() == TRUE){
$id = $this->post("id");
$arr = $this->data_array("pos_po","id_po='$id'");
if(!empty($arr->id_po)){
	if($arr->flag_po == 1){$flag_po='<span class="label label-info">Sdh Disetujui</span>';} else
	if($arr->flag_po == 2){$flag_po='<span class="label label-warning">Pending</span>';} else
						  {$flag_po='<span class="label label-danger">Batal</span>';}
	$arr_vendor=$this->data_array("pos_vendor","id_vendor='".$arr->bill_to."'");
?>

<link href="<?php echo $this->base_url($config["folder_apps"]); ?>assets/css/ribbon.css" rel="stylesheet" type="text/css">

<div class="panel-body">
	<div class="tabbable">
		<ul class="nav nav-tabs nav-tabs-top">
			<li class="active"><a href="#top-tab1" data-toggle="tab">Data Detail</a></li>
		</ul>
<?php if($arr->flag_po == "1"){ ?>
<div class="ribbon-wrapper-green"><div class="ribbon-green">Setujui</div></div>
<?php } else  ?>
<?php if($arr->flag_po == "2"){ ?>
<div class="ribbon-wrapper-green"><div class="ribbon-warning">Pending</div></div>
<?php } else ?>
<?php if($arr->flag_po == "0"){ ?>
<div class="ribbon-wrapper-green"><div class="ribbon-red">Batal</div></div>
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
	<td style="vertical-align:top; background:#E9E9E9;">Tgl. PO</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td><?php echo $this->tgl_indo($arr->tgl_po); ?></td>
</tr>
<tr>
	<td style="background:#E9E9E9;">Nomor PO</td>
    <td style="background:#E9E9E9;">:</td>
    <td><?php echo $arr->nomor_po; ?></td>
</tr>
<tr>
	<td style="background:#E9E9E9;">Vendor</td>
    <td style="background:#E9E9E9;">:</td>
    <td><?php echo $arr_vendor->nama; ?></td>
</tr>
<!--<tr>
	<td style="vertical-align:top; background:#E9E9E9;">Total Nominal</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td>Rp. <?php echo $this->rupiah($arr->nominal,2); ?></td>
</tr>-->
<tr>
	<td style="vertical-align:top; background:#E9E9E9;">Ship To</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td><?php echo str_replace("\N","<br>",$arr->ship_to); ?></td>
</tr>
<tr>
	<td style="vertical-align:top; background:#E9E9E9;">Keterangan</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td><?php echo $arr->keterangan; ?></td>
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
	<td style="vertical-align:top; background:#E9E9E9;">Status PO</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td><?php echo $flag_po ?></td>
</tr>
</table>

<!-- DETAIL -->
			<table class="table table-bordered table-hover" id="tab_logic" width="100%">
				<thead>
					<tr class="bg-primary">
						<th class="text-center" width="6%">No.</th>
						<th class="text-center">Item</th>
                        <th class="text-center" width="10%">Qty</th>
                        <th class="text-center" width="25%" style="display:none;">Sub Total</th>
					</tr>
				</thead>
				<tbody>
<?php
$list_sql = $this->db_array("pos_po_detail a, pos_po b, pos_produk c",$field="a.*,c.nama_produk",$where="1 AND a.id_po=b.id_po AND a.id_produk=c.id_produk AND a.id_po='".$arr->id_po."' ORDER BY c.nama_produk");
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
                        <!--(<span>Rp. </span><?= $this->rupiah($raw->nominal); ?>)-->
                        </td>
                        <td align="right">
							<?= $raw->jumlah; ?>
                        </td>
                        <td align="right" style="border-bottom:dotted 1px #999999; display:none;">
                        	<span style="float:left;">Rp. </span><?= $this->rupiah($sub_total); ?>
                        </td>
					</tr>
<?php
endforeach;
?>
				<tr style="border:dotted 1px #999999; display:none;">
                	<td colspan="3" align="right">Sub Total : </td>
                    <td align="right"><span style="float:left;">Rp. </span><?= $this->rupiah($total_hg); ?></td>
                </tr>
<?php
if($arr->flag_ppn==1){
$ppn_nilai=$total_hg * 0.1;
$grand_total=$total_hg + $ppn_nilai;
?>
				<tr style="display:none;">
                	<td colspan="3" align="right">PPN : </td>
                    <td align="right"><span style="float:left;">Rp. </span><?= $this->rupiah($ppn_nilai); ?></td>
				</tr>
				<tr style="display:none;">
                	<td colspan="3" align="right">Grand Total : </td>
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
                                <?php if($arr->flag_po==1){ ?>
                                <a href="<?php echo $this->base_url($config["folder_apps"]).'ajax/pos_purchase_order/cetak/'.$arr->id_po; ?>" class="btn btn-primary" target="_blank"><i class="icon-printer position-left"></i> Cetak</a>
                                <?php } ?>
                                <button type="button" class="btn btn-danger close_modal"><span class="icon-close2"></span> Close</button> 
							</div>

<?php
}
}
?>