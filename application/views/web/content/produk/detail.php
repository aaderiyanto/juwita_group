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
$arr = $this->data_array("pos_produk","id_produk='$id'");
if(!empty($arr->id_produk)){
if($arr->flag_aktif == "1"){$flag_aktif="<span class='label label-success'>Ya</span>";} else 
					       {$flag_aktif="<span class='label label-danger'>Tidak</span>";}
$arr_brand = $this->data_array("pos_brand","id_brand='".$arr->id_brand."'");
$arr_kategori = $this->data_array("pos_kategori_produk","id_kategori='".$arr->id_kategori."'");
?>
<script src="<?php echo $this->base_url($config["folder_apps"]); ?>assets/js_crop/slim.kickstart.min.js"></script>
<div class="panel-body">
	<div class="tabbable">
		<ul class="nav nav-tabs nav-tabs-top">
			<li class="active"><a href="#top-tab1" data-toggle="tab">Data Detail Produk	</a></li>
		</ul>
		<div class="tab-content">
		<div class="tab-pane active" id="top-tab1">
<div style="overflow:auto; z-index:1900px;">
<table class="table">
<tr style="background:#339AA6; color:#FFF; font-weight:bold;">
	<th width="20%">Field</th>
    <th width="2%">&nbsp;</th>
    <th>Value Data</th>
    <th width="26%">&nbsp;</th>
</tr>
<tr>
	<td style="vertical-align:top; background:#E9E9E9;">Nama Produk</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td><?php echo $arr->nama_produk; ?></td>
    <td rowspan="9" style="vertical-align:top;">
	<?php if(!empty($arr->foto)){ ?>
         <img src="<?php echo $this->base_url($config['folder_apps']); ?>fupload/produk/<?= $arr->foto; ?>" alt="foto" style="width:100%; padding:2px; border:solid 2px #CCCCCC;"/>
         <?php } else { ?>
        <img src="<?php echo $this->base_url($config['folder_apps']); ?>images/no_pictures.png" style="width:100%; padding:2px; border:solid 2px #CCCCCC;"/>
	<?php } ?>
    <div style="text-align:center;">-Foto Produk-</div>
    <div style="padding:6px;"></div>
    <center>
    <img src="<?php echo $this->base_url($config['folder_apps']); ?>system/plugins/qr_code/?code=<?= $arr->qr_produk; ?>" alt="qr code"  style="width:150px%; padding:2px; border:solid 2px #CCCCCC;"/>
    </center>
    <div style="text-align:center; margin-top:5px;"><span style="background:#B1B44B; padding:4px;"><?= $arr->qr_produk; ?></span></div>
    </td>
</tr>
<tr>
	<td style="background:#E9E9E9;">Brand</td>
    <td style="background:#E9E9E9;">:</td>
    <td><?php echo $arr_brand->brand; ?></td>
</tr>
<tr>
	<td style="background:#E9E9E9;">Kategori</td>
    <td style="background:#E9E9E9;">:</td>
    <td><?php echo $arr_kategori->kategori.' ('.$arr->jenis_data.')'; ?></td>
</tr>
<tr>
	<td style="vertical-align:top; background:#E9E9E9;">Serial Number</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td><?php echo $arr->sku; ?></td>
</tr>
<?php
if(in_array($this->baca_session("level"),array("admin","administrasi","pimpinan"))){
?>
<tr>
	<td style="vertical-align:top; background:#E9E9E9;">Harga Modal</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td>Rp. <?php echo $this->rupiah($arr->harga_modal,2); ?></td>
</tr>
<?php } ?>
<tr>
	<td style="vertical-align:top; background:#E9E9E9;">Harga Jual</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td>Rp. <?php echo $this->rupiah($arr->nominal,2); ?></td>
</tr>
<tr>
	<td style="vertical-align:top; background:#E9E9E9;">Stok</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td><?php echo $arr->stok; ?></td>
</tr>
<tr>
	<td style="vertical-align:top; background:#E9E9E9;">Deskripsi</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td><?php echo $arr->deskripsi; ?></td>
</tr>
<tr>
	<td style="vertical-align:top; background:#E9E9E9;">Spesifikasi</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td><?php echo $arr->spesifikasi; ?></td>
</tr>
<tr>
	<td style="vertical-align:top; background:#E9E9E9;">Data Aktif</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td><?php echo $flag_aktif; ?></td>
</tr>
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