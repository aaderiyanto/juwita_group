<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if($this->cek_login()== TRUE){
//if(empty($url_system[4])){$tahun=date("Y");} else {$tahun=$url_system[4];}
$jenis_data=$this->post("jenis_data");
$list_sql = $this->db_array("pos_transaksi",$field="",$where="1 AND jenis_data='".$jenis_data."' AND tgl_invoice='".$config['tgl']."' ORDER BY no_invoice");
$html='';
$nomor=0;
foreach($list_sql as $raw):
	$nomor++;
	if($raw->flag_aktif == 1){
	$html .='<div class="alert alert-info alert-styled-left alert-arrow-left alert-bordered" title="Invoice Aktif">';
	$html .='<button type="button" class="close" data-dismiss="alert"><span>&times;</span>';
	$html .='<span class="sr-only">Close</span></button>';
	$html .='<span class="text-semibold"><b>'.$raw->no_invoice.'</b></span> : Rp. '.$this->rupiah($raw->total_nominal);
	$html .='</div>';
	} else {
	$html .='<div class="alert alert-danger alert-styled-left alert-arrow-left alert-bordered" title="Invoice Batal">';
	$html .='<button type="button" class="close" data-dismiss="alert"><span>&times;</span>';
	$html .='<span class="sr-only">Close</span></button>';
	$html .='<span class="text-semibold"><b>'.$raw->no_invoice.'</b></span> : Rp. '.$this->rupiah($raw->total_nominal);
	$html .='</div>';
	}
endforeach;
echo $html;

/*
<div class="alert alert-info alert-styled-left alert-arrow-left alert-bordered">
	<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
	<span class="text-semibold"><b>POS/12111/001</b></span> : Rp. 200.000
</div>
<div class="alert alert-danger alert-styled-left alert-arrow-left alert-bordered">
	<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
	<span class="text-semibold"><b>POS/12111/001</b></span> : Rp. 200.000
</div>
*/
}
?>