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
$arr = $this->data_array("bmt_manufacture","id_manufacture='$id'");
if(!empty($arr->id_manufacture)){
	if($arr->flag_data == 1){$flag_data='<span class="label label-info">Selesai</span>';} else
	if($arr->flag_data == 2){$flag_data='<span class="label label-warning">Pending</span>';} else
	if($arr->flag_data == 3){$flag_data='<span class="label label-warning">Dalam Proses</span>';} else
						    {$flag_data='<span class="label label-danger">Batal</span>';}
	$arr_vendor=$this->data_array("pos_vendor","id_vendor='".$arr->id_vendor."'");

//if($this->baca_session("level") == "gudang"){$display='style="display:none;"';} else {$display='';}
?>

<link href="<?php echo $this->base_url($config["folder_apps"]); ?>assets/css/ribbon.css" rel="stylesheet" type="text/css">

<div class="panel-body">
	<div class="tabbable">
		<ul class="nav nav-tabs nav-tabs-top">
			<li class="active"><a href="#top-tab1" data-toggle="tab">Data Detail</a></li>
		</ul>
<?php if($arr->flag_data == "1"){ ?>
<div class="ribbon-wrapper-green"><div class="ribbon-green">Selesai</div></div>
<?php } else  ?>
<?php if($arr->flag_data == "2"){ ?>
<div class="ribbon-wrapper-green"><div class="ribbon-warning">Pending</div></div>
<?php } else ?>
<?php if($arr->flag_data == "3"){ ?>
<div class="ribbon-wrapper-green"><div class="ribbon-warning">Dalam Proses</div></div>
<?php } else ?>
<?php if($arr->flag_data == "0"){ ?>
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
	<td style="background:#E9E9E9;">Nomor</td>
    <td style="background:#E9E9E9;">:</td>
    <td><?php echo $arr->nomor_mo; ?></td>
</tr>
<tr>
	<td style="background:#E9E9E9;">Nama Produk</td>
    <td style="background:#E9E9E9;">:</td>
    <td><?php echo $arr->nama_produk; ?></td>
</tr>
<tr>
	<td style="background:#E9E9E9;">Jumlah Produk</td>
    <td style="background:#E9E9E9;">:</td>
    <td><?php echo $this->rupiah($arr->jumlah); ?></td>
</tr>
<tr>
	<td style="vertical-align:top; background:#E9E9E9;">Tanggal Buat</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td><?php echo $this->tgl_indo($arr->tgl_buat); ?></td>
</tr>
<tr>
	<td style="vertical-align:top; background:#E9E9E9;">Estimasi Selesai</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td><?php echo $this->tgl_indo($arr->tgl_selesai); ?></td>
</tr>
<tr>
	<td style="background:#E9E9E9;">Vendor</td>
    <td style="background:#E9E9E9;">:</td>
    <td><?php echo $arr_vendor->nama; ?></td>
</tr>
<tr>
	<td style="vertical-align:top; background:#E9E9E9;">Keterangan</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td><?php echo str_replace("\N","<br>",$arr->keterangan); ?></td>
</tr>
</table>

<!-- DETAIL -->
			<table class="table table-bordered table-hover" id="tab_logic" width="100%">
				<thead>
					<tr class="bg-primary">
						<th class="text-center" width="6%">No.</th>
						<th class="text-center">Item</th>
                        <th class="text-center" width="10%">Qty</th>
					</tr>
				</thead>
				<tbody>
<?php
$list_sql = $this->db_array("bmt_manufacture_detail a, bmt_manufacture b, pos_produk c",$field="a.*,c.nama_produk",$where="1 AND a.id_manufacture=b.id_manufacture AND a.id_produk=c.id_produk AND a.id_manufacture='".$arr->id_manufacture."' ORDER BY c.nama_produk");
$nomor=0;
$total_hg=0;
foreach($list_sql as $raw):
	$nomor++;
?>
					<tr style="border:dotted 1px #999999;">
						<td style='vertical-align:top; text-align:center; border-left:dotted 1px #999999; border-bottom:dotted 1px #999999;'><?= $nomor; ?>.</td>
						<td><?= $raw->nama_produk; ?></td>
                        <td align="right"><?= $raw->jumlah; ?></td>
					</tr>
<?php
endforeach;
?>
				</tbody>
			</table>
</div>

				</div>
				
		</div>
	</div>
</div>

							<div class="modal-footer">
                                <?php if($arr->flag_data!=0){ ?>
                                <a href="<?php echo $this->base_url($config["folder_apps"]).'ajax/manufacturing_order/cetak/'.$arr->id_manufacture; ?>" class="btn btn-primary" target="_blank"><i class="icon-printer position-left"></i> Cetak</a>
                                <?php } ?>
                                <button type="button" class="btn btn-danger close_modal"><span class="icon-close2"></span> Close</button> 
							</div>

<?php
}
}
?>