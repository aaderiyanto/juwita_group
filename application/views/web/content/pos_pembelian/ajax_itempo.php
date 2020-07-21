<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if($this->cek_login()== TRUE){
	$id_po 	= $this->post("id_po");
	$arr 	= $this->data_array("pos_po","id_po='".$id_po."'");
	$html 	= '';
	if(!empty($id_po)){
		$list_sql = $this->db_array("pos_po_detail a, pos_produk b",$field="a.*,b.nama_produk",$where="1 AND a.id_produk=b.id_produk AND id_po='".$id_po."'");
		$no=0;
		$total=0;
		foreach($list_sql as $raw):
		$no++;
		$subtotal = $raw->jumlah * $raw->nominal;
		$total = $total + $subtotal;
		$html .='<tr>';
		$html .='<td>'.$no.'.</td>';
		$html .='<td>';
		$html .='<input type="hidden" name="urutan'.$no.'" value="'.$no.'"/>';
		$html .='<span id="produk_info'.$no.'" class="text-primary">'.$raw->nama_produk.'</span>';
		$html .='<input type="hidden" name="id_barang[]" value="'.$raw->id_produk.'" id="id_produk'.$no.'" class="id_barang_awal brg'.$no.'"/>';
		$html .='</td>';
		$html .='<td align="right">'.$raw->jumlah;
		$html .='<input type="hidden" name="jumlah[]" class="form-control qty1" id="jumlah_awal" value="'.$raw->jumlah.'" required placeholder="masukkan isian data" required onblur="subtotal(1),findTotal(1)">';
		$html .='</td>';
		$html .='<td align="right" style="display:none;">'.$this->rupiah($raw->nominal);
		$html .='<input type="hidden" name="nominal[]" class="form-control nominal_awal nominal'.$no.'" value="'.$raw->nominal.'" required placeholder="masukkan isian data" id="non_idr'.$no.'" onkeyup="LoadIDRupiah('.$no.')" onblur="subtotal('.$no.'),findTotal('.$no.')">';
		$html .='</td>';
		$html .='<td align="right" style="display:none;">'.$this->rupiah($subtotal);
		$html .='<input type="hidden" name="subtotal_modal[]" class="form-control subtotal_modal" required placeholder="masukkan isian data" style="text-align:right; cursor:not-allowed;" value="'.$subtotal.'" readonly="readonly" id="subtotal_modal'.$no.'">';
		$html .='</td>';
		$html .='</tr>';
		endforeach;
		// CEK ADA PPN
		if($arr->flag_ppn==1){
			$nilai_ppn = $total * 0.1;
			$grand_total = $total + $nilai_ppn;
		} else { $grand_total = $total; }
		$html .='<tr style="display:none;">';
		$html .='<td align="right" colspan="4">Sub Total : </td>';
		$html .='<td align="right"><span id="grandtotal">Rp. '.$this->rupiah($total).'</span>';
		$html .='<input type="hidden" name="grandtotal" class="form-control grandtotal-form" id="grandtotal-form" required placeholder="masukkan isian data" style="text-align:right;" value="'.$total.'">';
		$html .='</td>';
		$html .='</tr>';
		$html .='<tr style="display:none;">';
		$html .='<td colspan="4" align="right">PPN 10% : </td>';
		$html .='<td align="right"><span id="ppn_rupiah">Rp. '.$this->rupiah($nilai_ppn).'</span></td>';
		$html .='</tr>';
		$html .='<tr style="display:none;">';
		$html .='<td colspan="4" align="right">Grand Total : </td>';
		$html .='<td align="right"><span id="grandmaster">Rp. '.$this->rupiah($grand_total).'</span>';
		$html .='<input type="hidden" name="grandmaster" id="grandmaster-form" value="'.$grand_total.'"/>';
		$html .='</td>';
		$html .='</tr>';		
		echo $html;
	} 
}
?>