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
$arr = $this->data_array("setting_apps","id_setting='$id'");
if(!empty($arr->id_setting)){
if($arr->flag_maintenance==0){$flag_maintenance='<span class="label label-danger">dalam proses Maintenance</span>';} else
						     {$flag_maintenance='<span class="label label-info">Aktif</span>';}
if($arr->flag_ppn==0){$flag_ppn='<span class="label label-danger">Tidak</span>';} else
				     {$flag_ppn='<span class="label label-info">Ya</span>';}
$arr_vendor = $this->data_array("pos_vendor","id_vendor='".$arr->default_vendor."'");
?>
<div class="panel-body">
	<div class="tabbable">
		<ul class="nav nav-tabs nav-tabs-top">
			<li class="active"><a href="#top-tab1" data-toggle="tab">Data Setting Aplikasi</a></li>
		</ul>
		<div class="tab-content">
		<div class="tab-pane active" id="top-tab1">
<div style="overflow:auto; z-index:1900px;">
<table class="table">
<tr style="background:#339AA6; color:#FFF; font-weight:bold;">
	<th width="20%">Field</th>
    <th width="2%">&nbsp;</th>
    <th>Value Data</th>
    <th width="20%">&nbsp;</th>
</tr>
<tr>
	<td style="background:#E9E9E9;">Status Portal</td>
    <td style="background:#E9E9E9;">:</td>
    <td><b><?php echo $flag_maintenance; ?></b></td>
    <td rowspan="4" align="center">
    <?php if(!empty($arr->logo_web)){ ?>
    	<a href="<?php echo $this->base_url($config["folder_apps"]); ?>image_upload/<?php echo $arr->logo_web; ?>" data-popup="lightbox" rel="gallery" title="click for more detail">
    	<img src="<?php echo $this->base_url($config["folder_apps"]); ?>image_upload/<?php echo $arr->logo_web; ?>" style="width:100%; padding:2px; border:solid 2px #CCCCCC;"/><br />
        <span style="text-align:center;">-Logo System-</span>
        </a>
    <?php } else { ?>
    	<img src="<?php echo $this->base_url($config["folder_apps"]); ?>image_upload/no_image.jpg" style="width:100%; padding:2px; border:solid 2px #CCCCCC;"/>
    <?php } ?>
    </td>
</tr>
<tr>
	<td style="background:#E9E9E9;">Meta Title</td>
    <td style="background:#E9E9E9;">:</td>
    <td><b><?php echo $arr->meta_title; ?></b></td>
</tr>
<tr>
	<td style="background:#E9E9E9;">Meta Deskripsi</td>
    <td style="background:#E9E9E9;">:</td>
    <td><b><?php echo $arr->meta_deskripsi; ?></b></td>
</tr>
<tr>
	<td style="background:#E9E9E9;">Meta Keyword</td>
    <td style="background:#E9E9E9;">:</td>
    <td><b><?php echo $arr->meta_keyword; ?></b></td>
</tr>
<tr>
	<td style="background:#E9E9E9;">Nama Perusahaan</td>
    <td style="background:#E9E9E9;">:</td>
    <td colspan="2"><b><?php echo $arr->nama_perusahaan; ?></b></td>
</tr>
<tr>
	<td style="background:#E9E9E9;">Pimpinan</td>
    <td style="background:#E9E9E9;">:</td>
    <td colspan="2"><b><?php echo $arr->pimpinan; ?></b></td>
</tr>
<tr>
	<td style="background:#E9E9E9;">Alamat</td>
    <td style="background:#E9E9E9;">:</td>
    <td colspan="2"><b><?php echo $arr->alamat; ?></b></td>
</tr>
<tr>
	<td style="background:#E9E9E9;">Lokasi</td>
    <td style="background:#E9E9E9;">:</td>
    <td colspan="2"><b><?php echo $arr->lokasi; ?></b></td>
</tr>
<tr>
	<td style="background:#E9E9E9;">PPN</td>
    <td style="background:#E9E9E9;">:</td>
    <td colspan="2"><b><?php echo $flag_ppn; ?></b></td>
</tr>
<tr>
	<td style="background:#E9E9E9;">Default Vendor</td>
    <td style="background:#E9E9E9;">:</td>
    <td colspan="2"><b><?php echo $arr_vendor->nama; ?></b></td>
</tr>
</table>
<p></p>
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