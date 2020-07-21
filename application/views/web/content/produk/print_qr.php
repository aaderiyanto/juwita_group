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
$title_grid = ucwords(strtolower(str_replace('_',' ',$url_system[1])));
$folder_grid = strtolower($url_system[1]);
?>
<script>
printDivCSS = new String ('<link href="<?= $this->base_url($config['folder_apps']); ?>assets/css/print/style.css" rel="stylesheet" type="text/css">');
function printDiv(divId) {
    window.frames["print_frame"].document.body.innerHTML=printDivCSS + document.getElementById(divId).innerHTML;
    window.frames["print_frame"].window.focus();
    window.frames["print_frame"].window.print();
}
</script>
		<div class="content-wrapper">
				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-grid position-left"></i> <span class="text-semibold">Page </span> - Data <?= $title_grid; ?></h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="<?php echo $this->base_url($config["folder_apps"]); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Data <?= $title_grid; ?></li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
					<!-- Page length options -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">Grid Data - <?= $title_grid; ?></h5>
                            <hr />
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                	</ul>
		                	</div>
						</div>

					<div class="panel-body">
                            <form class="form-horizontal form-validate-jquery" action="" method="post" autocomplete="off" enctype="multipart/form-data">
<!-- PAGE CETAK -->
<div style="width:100%; font-size:11px;" id="div1">
<style>
	p.pagebreakhere {page-break-before: always}
</style>
<table width="100%" style="font-size:11px;">
<tr>
<?php
$list_sql = $this->db_array("pos_produk",$field="",$where="1 ORDER BY jenis_data, nama_produk");
$no=0; $no_break=0;
foreach($list_sql as $raw):
$no++; $no_break++;
//if($no%2 == 0){$break_bawah='</tr><tr>';} else {$break_bawah='';}
if($no == 3){$break_bawah='</tr><tr>'; $no=1;} else {$break_bawah='';}
if($no_break==13){$no_break=1;}
if($no_break == 12){$break_page='</table> <p class="pagebreakhere"></p>
							    <table width="100%" style="font-size:11px;">';} else {$break_page='';}
?>
<td width="33%" style="padding:6px;" style="font-size:11px;">
	<div style="border:solid 1px #999999; border-radius:4px; padding:4px;">
    <table width="100%">
    <tr>
        <td colspan="2" align="center" style="border-bottom:dotted 1px #999999;">
            <div style="font-weight:bold; text-transform:uppercase; padding:5px; font-size:12px;"><?= $raw->nama_produk ?></div>
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td width="50%" style="vertical-align:top;">
        <?php
		if(!empty($raw->foto)){
		?>
        <img src="<?= $this->base_url($config['folder_apps']); ?>fupload/produk/<?= $raw->foto; ?>" style="width:120px;">
        <?php } ?>
        </td>
        <td align="center">
        <?= '<img src="'.$this->base_url($config['folder_apps']).'system/plugins/qr_code/?code='.$raw->qr_produk.'" alt="'.$person->qr_code.'"  style="width:150px%; padding:2px; border:solid 2px #CCCCCC;"/>'; ?>
        </td>
    </tr>
    <tr>
        <td><span style="font-weight:bold; font-style:italic; font-size:11px;">
        Rp. <?= $this->rupiah($raw->nominal); ?>
        </span></td>
        <td align="center">
		<div style="font-size:11px; background:#F1EEC5;">
		<?= $raw->qr_produk; ?>
        </div>
        </td>
    </tr>
    </table>
    </div>
    <div style="padding:16px;"></div>
</td>
<?= $break_bawah; ?>
<?= $break_page; ?>
<!--<td></td>
</tr>-->
<?php 
endforeach; 
?>
</table>
</div>
<!-- END PAGE CETAK -->
<iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>
								<div class="text-right">
									<button type="button" class="btn btn-danger" onclick="window.location='<?php echo $this->base_url($config["folder_apps"]).$folder_grid."/home"; ?>'"><i class="icon-arrow-left13 position-left"></i> Back</button>
                                    <?php if($no>0){ ?>
									<button type="button" class="btn btn-primary" name="print_tiket" onClick="printDiv('div1')">Print <i class="icon-printer position-right"></i></button>
                                    <?php } ?>
								</div>
							</form>

                    </div>
                    
                        
					</div>
					<!-- /page length options -->

					<!-- Footer -->
					<?php $this->loadView("template/footer"); ?>
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
				<!-- /content area -->

			</div>
<?php if($no>0){ ?> <script> //printDiv('div1'); </script> <?php } ?>
<?php } else { $this->redirect("home"); } ?>