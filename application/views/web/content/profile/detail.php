<?php
/**
 * Created by Balqon Media Teknologi.
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@balqon.tech
 * Website : https://balqon.co.id/ OR https://balqon.tech/
 */
if($this->cek_login() == TRUE){
$id = $this->post("id");
$arr = $this->data_array("bmt_user","id_user='$id'");
if(!empty($arr->id_user)){
if($arr->flag_aktif==1){$aktif='<span class="label label-info">Ya</span>';} else
if($arr->flag_aktif==0){$aktif='<span class="label label-danger">Tidak</span>';}
?>
<div class="panel-body">
	<div class="tabbable">
		<ul class="nav nav-tabs nav-tabs-top">
			<li class="active"><a href="#top-tab1" data-toggle="tab">Data Profile</a></li>
		</ul>
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
	<td style="vertical-align:top; background:#E9E9E9;">Nama</td>
    <td style="vertical-align:top; background:#E9E9E9;">:</td>
    <td><?php echo $arr->nama; ?></td>
</tr>
<tr>
	<td style="background:#E9E9E9;">Username</td>
    <td style="background:#E9E9E9;">:</td>
    <td><?php echo $arr->username; ?></td>
</tr>
<tr>
	<td style="background:#E9E9E9;">Level</td>
    <td style="background:#E9E9E9;">:</td>
    <td><?php echo $arr->level; ?></td>
</tr>
<tr>
	<td style="background:#E9E9E9;">Data Aktif</td>
    <td style="background:#E9E9E9;">:</td>
    <td><?php echo $aktif; ?></td>
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