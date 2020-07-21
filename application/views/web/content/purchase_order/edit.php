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

// CEK LEVEL AKSES
if(in_array($this->baca_session("level"),array("gudang"))){ $this->loadView("web/content/purchase_order/edit_gudang"); } 
else {

$arr = $this->data_array("pos_po","id_po='".$url_system[3]."'");
if(!empty($arr->id_po) && $arr->flag_po==2){
if($this->post('simpan',true)){
	//$id_primary		= "PPO".$this->kode_uniq(14).rand(100,999);
	$from_replace 	= [".",","]; $to_replace = ["","."];
	$batas_tempo 	= date('Y-m-d', strtotime($this->post("tgl_po").'+'.$this->post("terms").' days'));
	// Save
	$data_array = array("bill_to" => $this->post("bill_to"),
						"nominal" => $this->post("grandmaster"),
						"tgl_po" => $this->post("tgl_po"),
						"flag_ppn" => $this->post("flag_ppn"),
						"terms" => $this->post("terms"),
						"batas_tempo" => $batas_tempo,
						"ship_to" => $this->post("ship_to"),
						"tgl_update" => date("Y-m-d H:i:s"),
						"user_update" => $this->baca_session('id_admin')
					    );
	$sql = $this->db_update($data_array,"pos_po","id_po='".$arr->id_po."'");
  	if($sql == TRUE) { 
		//Delete data lama
		$this->SqlQuery("INSERT INTO pos_po_detail_delete SELECT * FROM pos_po_detail WHERE id_po='".$arr->id_po."'");
		$this->db_delete(array("pos_po_detail"),"id_po='".$arr->id_po."'");
		// END delete data lama //
		$arr_barang = $this->post("id_barang");
		$arr_jumlah = $this->post("jumlah");
		$arr_nominal = $this->post("nominal");
		$no=0;
		foreach($arr_barang as $id_produk){
			$nominal = str_replace($from_replace,$to_replace,$arr_nominal[$no]);
			$jumlah = $arr_jumlah[$no];
			$id_primary_sub	= "POD".$this->kode_uniq(14).rand(100,999);
			// Save
			$data_array = array("id_podetail" => $id_primary_sub,
								"id_po" => $arr->id_po,
								"id_produk" => $id_produk,
								"jumlah" => $jumlah,
								"nominal" => $nominal,
								"tgl_input" => date("Y-m-d H:i:s"),
								"user_input" => $this->baca_session('id_admin')
								);
			$this->db_insert($data_array,"pos_po_detail");
			$no++;
		}
		$this->redirect($folder_grid."/home/2"); 
	} else { $error=1; }
}
?>
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
							<h5 class="panel-title">Form Data - <?= $title_grid; ?></h5>
                            <hr />
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                	</ul>
		                	</div>
						</div>

					<div class="panel-body">
                            <form class="form-horizontal form-validate-jquery" action="" method="post" autocomplete="off" enctype="multipart/form-data">
                            <!--<div class="info_error"></div>-->
								<fieldset class="content-group">
                                    <div class="form-group">
										<label class="control-label col-lg-2">Nomor PO </label>
										<div class="col-lg-10">
										<input type="text" name="nomor_po" value="<?= $arr->nomor_po; ?>" id="nomor_po" class="form-control" placeholder="jika kosong, akan di generate otomatis" disabled="disabled"/>
                                        </div>                                       
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Tanggal PO <span class="text-danger">*</span></label>
										<div class="col-lg-10">
										<input type="text" name="tgl_po" id="date_balqon1" class="form-control" placeholder="text input..." required="required" value="<?= $arr->tgl_po; ?>"/>
                                        </div>                                       
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Vendor <span class="text-danger">*</span></label>
										<div class="col-lg-9">
                                        <select name="bill_to" data-placeholder="Pilih :" class="select-size-lg required" id="bill_to">
                                            <option value="">Pilih :</option>
                                        <?php
										$list_sql = $this->db_array("pos_vendor",$field="",$where="1 ORDER BY nama");
										foreach($list_sql as $raw):
										if($arr->bill_to==$raw->id_vendor){$pilih='selected';} else {$pilih='';}
										?>
                                        	<option value="<?php echo $raw->id_vendor; ?>" <?= $pilih; ?>><?php echo $raw->nama; ?></option>
                                        <?php
										endforeach;
										?>                                        
										</select>
                                        </div>
                                        <div class="col-lg-1">
                                        	<button type="button" class="btn btn-default" title="tambah bill to" onclick="AddBillto()"><span class="icon-plus2 text-primary"></span></button>
                                        </div>                         
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Flag PPN <span class="text-danger">*</span></label>
										<div class="col-lg-10">
                                        <select name="flag_ppn" data-placeholder="Pilih :" class="select-size-lg required" id="flag_ppn" onchange='findTotal(1)'>
                                            <option value="">Pilih :</option>
                                        <?php
										$array_ppn = array("1"=>"Ya","0"=>"Tidak");
										foreach($array_ppn as $id_val=>$val_data){
											if($id_val==$arr->flag_ppn){$pilih='selected';} else {$pilih='';}
										?>
                                        	<option value="<?php echo $id_val; ?>" <?= $pilih; ?>><?php echo $val_data; ?></option>
                                        <?php
										}
										?>                                        
										</select>
                                        </div>                                       
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Terms <span class="text-danger">*</span></label>
										<div class="col-lg-10">
										<input type="number" name="terms" id="terms" class="form-control" placeholder="text input..." required="required" value="<?= $arr->terms; ?>"/>
                                        </div>                                       
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Ship To <span class="text-danger">*</span></label>
										<div class="col-lg-10">
											<textarea name="ship_to" id="ship_to" class="form-control" rows="3" placeholder="masukkan isian data" required="required"><?= $arr->ship_to; ?></textarea>
										</div>
									</div>

<div style="overflow:auto;">
			<a id="add_row" title="add row" class="btn btn-sm btn-warning"><i class="icon-plus2"></i></a>  
            <a id="delete" title="delete row" class="btn btn-sm btn-warning"><i class="icon-minus2"></i></a>
            <div style="padding:5px;"></div>
                <table class="table table-bordered" id="row_table">
				<thead>
					<tr class="bg-teal">
						<th class="text-center" width="4%">No</th>
						<th class="text-center">
							Item Description <span class="text-danger">*</span>
						</th>
						<th class="text-center" width="10%">
							Qty <span class="text-danger">*</span>
						</th>
						<th class="text-center" width="16%">
							Unit Price (Rp) <span class="text-danger">*</span>
						</th>
                        <th class="text-center" width="18%">
							Sub Total (Rp) <span class="text-danger">*</span>
						</th>
					</tr>

				</thead>

				<tbody>
<?php
$no=0; $grand_total=0;
$list_sql = $this->db_array("pos_po_detail",$field="",$where="1 AND id_po='".$arr->id_po."'");
foreach($list_sql as $raw):
$no++;
$arr_produk = $this->data_array("pos_produk","id_produk='".$raw->id_produk."'");
$subtotal = $raw->jumlah * $raw->nominal;
$grand_total = $grand_total + $subtotal;
?>
					<tr id='addr<?= $no; ?>'>
						<td><?= $no; ?>.</td>
						<td>
                        <input type="hidden" name="urutan<?= $no; ?>" value="<?= $no; ?>"/>
						<div class="input-group">
							<input type="text" name='produk[]' value="<?= $arr_produk->nama_produk; ?>" id="produk<?= $no; ?>" placeholder='masukkan isian data' class="form-control produk" required="required" onclick="nokeyup()" style="cursor:not-allowed;"/>
                            <span class="input-group-addon modal-produk" data-toggle="modal" data-target="#modal_informasi" data-id="<?= $no; ?>" data-backdrop="static" data-keyboard="false" style="cursor:pointer;" title='pilih produk'><i class="icon-list"></i></span>
						</div>
                        <div style="padding:3px;"></div>
                        <span id="produk_info<?= $no; ?>" class="text-primary"><?= $arr_produk->nama_produk; ?></span>
                        <input type="hidden" name="id_barang[]" value="<?= $raw->id_produk; ?>" id="id_produk<?= $no; ?>" class="id_barang_awal brg1"/>
                        <input type='hidden' name='stok_info[]' id="stok_info<?= $no; ?>"/>
						</td>
                        <td>
						<input type="text" name="jumlah[]" class="form-control qty<?= $no; ?>" id="jumlah_awal" value="<?= $raw->jumlah; ?>" required placeholder="masukkan isian data" required onblur='subtotal(<?= $no; ?>),findTotal(<?= $no; ?>)'>
						</select>

						</td>
						<td>
						<input type="text" name="nominal[]" class="form-control nominal_awal nominal<?= $no; ?>" value="<?= $this->rupiah($raw->nominal); ?>" required placeholder="masukkan isian data" id="non_idr<?= $no; ?>" onkeyup="LoadIDRupiah(<?= $no; ?>)" onblur="subtotal(<?= $no; ?>),findTotal(<?= $no; ?>)">
						</td>
                        <td>
                        <!-- SUB TOTAL -->
						<input type="text" name="subtotal_modal[]" class="form-control subtotal_modal" required placeholder="masukkan isian data" style="text-align:right; cursor:not-allowed;" value="<?= $this->rupiah($subtotal); ?>" readonly="readonly" id="subtotal_modal<?= $no; ?>">
						</td>
					</tr>
<?php
endforeach;
if($arr->flag_ppn==1){
	$nilai_ppn = $grand_total * 0.1;
	$grand_total_akhir = $grand_total + $nilai_ppn;
} else { $grand_total_akhir = $grand_total; }
?>
				</tbody>
                </div>
                	<tr>
                    	<td align="right" colspan="4">Sub Total : </td>
                        <td align="right"><span id="grandtotal">Rp. <?= $this->rupiah($grand_total); ?></span>
                        <input type="hidden" name="grandtotal" class="form-control grandtotal-form" id="grandtotal-form" required placeholder="masukkan isian data" style="text-align:right;" value="<?= $this->rupiah($grand_total); ?>">
                        </td>
                    </tr>
                    <tr>
                    	<td colspan="4" align="right">PPN 10% : </td>
                        <td align="right"><span id="ppn_rupiah">Rp. <?= $this->rupiah($nilai_ppn); ?></span></td>
                    </tr>
                	<tr>
                    	<td colspan="4" align="right">Grand Total : </td>
                        <td align="right"><span id="grandmaster">Rp. <?= $this->rupiah($grand_total_akhir); ?></span>
                        <input type="hidden" name="grandmaster" id="grandmaster-form" value="<?= $grand_total_akhir; ?>"/>
                        </td>
                    </tr>
			</table>
            </div>
            <input type="hidden" id="jml_count" value="<?= $no; ?>">
            <div style="padding:12px;"></div>
								</fieldset>
								<div class="text-right">
									<button type="button" class="btn btn-danger" onclick="window.location='<?php echo $this->base_url($config["folder_apps"]).$folder_grid."/home"; ?>'"><i class="icon-arrow-left13 position-left"></i> Back</button>
									<button type="submit" class="btn btn-primary" name="simpan">Simpan <i class="icon-checkbox-checked position-right"></i></button>
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


                <div id="modal_detail" class="modal fade">
					<div class="modal-dialog modal-full">
						<div class="modal-content">
							<div class="modal-header bg-primary">
								<button type="button" class="close close_modal">&times;</button>
								<h6 class="modal-title">Detail Data</h6>
							</div>
                                <div class="modal-detail-data"></div>
							<!--<div class="modal-footer">
                                <button type="button" class="btn btn-danger close_modal"><i class="icon-close2"></i> Close</button>
							</div>-->
						</div>
					</div>
				</div>

<script>
	$(document).ready(function(){
	  var jml_awal = $("#jml_count").val();
	  var i=parseFloat(jml_awal);
	  var d1=(2+i);
	  var d2=(80+i);
	  $("#add_row").click(function(){
		var data="<tr id='addr"+(i+1)+"'><td>"+ (i+1) +".</td>";
		data   +="<td style='vertical-align:top;'>"+
				"<input type='hidden' name='urutan"+(i+1)+"' value='"+(i+1)+"'/>"+
				"<div class='input-group'>"+
				"<input type='text' name='produk[]' id='produk"+(i+1)+"' placeholder='masukkan isian data' class='form-control produk' onclick='nokeyup()' style='cursor:not-allowed;' required='required'/>"+
				"<span class='input-group-addon modal-produk' data-toggle='modal' data-target='#modal_informasi' data-id='"+(i+1)+"' data-backdrop='static' data-keyboard='false' style='cursor:pointer;' title='pilih produk'>"+
				"<i class='icon-list'></i></span>"+
				"</div>"+
				"<div style='padding:3px;'></div>"+
				"<span id='produk_info"+(i+1)+"' class='text-primary'></span>"+
				"<input type='hidden' name='id_barang[]' id='id_produk"+(i+1)+"' class='id_barang_awal brg"+(i+1)+"'/>"+
				"<input type='hidden' name='stok_info[]' id='stok_info"+(i+1)+"'/>"+
				"</td>"+
				 "<td><input  name='jumlah[]' type='text' placeholder='masukkan isian data' value='0' class='form-control qty"+(i+1)+"' required='required' onblur='subtotal("+(i+1)+"),findTotal("+(i+1)+")'></td>"+
				 "<td><input  name='nominal[]' type='text' placeholder='masukkan isian data' value='0' class='form-control nominal"+(i+1)+"' required='required' id='non_idr"+(i+1)+"' onkeyup='LoadIDRupiah("+(i+1)+")' onblur='subtotal("+(i+1)+"),findTotal("+(i+1)+"),marginNominal("+(i+1)+")'></td>"+
				 "</td>"+
				 "<td>"+
				 "<input  name='subtotal_modal[]' type='text' placeholder='masukkan isian data'  class='form-control subtotal_modal' required='required' style='text-align:right; cursor:not-allowed;' value='0' readonly='readonly' id='subtotal_modal"+(i+1)+"'>"+
				 "</td>"+
				 
				 "</tr>";
		//$('table').append(data);
		$('#row_table').append(data);
		row = i ;
		// Select Form	
		$('.select-size-lg').select2({
			containerCssClass: 'select-ls'
		});
	
		i++;
		d1=d1+2;
		d2=d2+2;
		$("#tot_data").val(i);
		});
	  
		// Delete ROW Cell
		$("#delete").on('click', function() {
			 if(i>1){
			 $("#addr"+(i)).remove();
			 i--;
			 d1=d1-2;
			 d2=d2-2;
			 findTotal();
			 }
			 $("#tot_data").val(i);
		});
	});

		function formatCurrency(num) {
			var p = num.toFixed(2).split(".");
			return p[0].split("").reverse().reduce(function(acc, num, i, orig) {
				return  num=="-" ? acc : num + (i && !(i % 3) ? "." : "") + acc;
			}, "") + "," + p[1];
		}

		function subtotal($id){
			var subtotal_rp1 = $(".nominal"+$id).val().replace(/\./g, "");
			var subtotal_rp = subtotal_rp1.replace(/\,/g, ".");
			var qty = $(".qty"+$id).val();
			var total = subtotal_rp * qty;
			var nilai_subnominal = formatCurrency(total);
			var rupiah = '';
			var angkarev = total.toString().split('').reverse().join('');
			for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
			var total_rupiah =rupiah.split('',rupiah.length-1).reverse().join('');
			if(total_rupiah=='NaN'){
				$("#subtotal_modal"+$id).val(0);
			} else {
				$("#subtotal_modal"+$id).val(nilai_subnominal);
			}
		}

		function findTotal($id){
			var arr = document.getElementsByClassName('subtotal_modal');
			var tot=0;
			for(var i=0;i<arr.length;i++){
				var sub_awal = arr[i].value.replace(/\./g, "");
				var hitung_sub = (sub_awal.replace(/\,/g, "."));
				tot += parseFloat(hitung_sub);
			}
			// cheklist PPN
			var tax_item = $("#flag_ppn").val();				
			var total = tot;
			// ada PPN
			if(tax_item > 0){ var nominal_ppn_grand = (total* (10/100)); } else { var nominal_ppn_grand=0; }
			var ppn_rupiah = formatCurrency(nominal_ppn_grand);
			var total_rupiah = formatCurrency(tot);
			var total_awal = parseFloat(nominal_ppn_grand) + parseFloat(total);
			var total_akhir = formatCurrency(total_awal);

			$("#grandtotal").html("Rp. "+total_rupiah);
			$("#grandtotal-form").val(total_rupiah);
			$("#ppn_rupiah").html("Rp. "+ppn_rupiah);
			$("#grandmaster").html("Rp. "+total_akhir);
			$("#grandmaster-form").val(total_awal);
		}

// PENTING ******************************************************* //
var save_method; //for save method string
function AddBillto()
{
    save_method = 'add';
	$(".info_error").html('');
	// fa fa-angle-left
	$('#fa').removeClass('fa').addClass('icon-user');
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
	$("#kategori_vendor").val('').trigger("change");
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Data'); // Set Title to Bootstrap modal title
	$("#notif_success").html('');
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
	$(".info_error").html('');
    var url;
    if(save_method == 'add') {
        url = "<?= $this->base_url($config['folder_apps']).'ajax/'.$url_system[1]; ?>/ajax_add_vendor";
    }
	//var formData = new FormData($('#form')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
				$("#notif_success").html('<div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">'+
						 '<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>'+
					     '<span class="text-semibold"><b>Sukses...!</b></span> data berhasil di proses.</div>');
				idVendor();
            }
			// gagal simpan data
			else {
				$(".info_error").html('<div class="alert alert-danger alert-styled-left alert-arrow-left alert-bordered">'+
						 '<button type="button" class="close" data-dismiss="alert"><span>&times;</span>'+
						 '<span class="sr-only">Close</span></button>'+
					     '<span class="text-semibold"><b>Field (*)</b></span> wajib di isi.</div>');
				// fungsi validasi form ******************* //
				var notif_required='This field is required';
			}
            $('#btnSave').html('save <i class="icon-checkbox-checked position-right"></i>'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
			//alert("Info : "+textStatus);
            alert('Error adding / update data');
            $('#btnSave').html('save <i class="icon-checkbox-checked position-right"></i>');
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}

function loadVendor() {
	var client_primary = $('#vendor_id').val();
	$("#bill_to").html("<option value=''>Loading....<option");
	var nama = $('#nama').val();
	$.ajax({
		type: 'POST',
		url: '<?= $this->base_url($config['folder_apps']).'ajax/'.$url_system[1]; ?>/ajax_load_vendor',
		data: {nama:nama},
		success: function(data){
			$('#bill_to').html(data);
			$("#bill_to").val(client_primary).trigger("change");
		}
	});
}

function idVendor() {
	var id_primary;
	var nama = $('#nama').val();
	$.ajax({
		type: 'POST',
		url: '<?= $this->base_url($config['folder_apps']).'ajax/'.$url_system[1]; ?>/ajax_load_vendor',
		data: {nama:nama, id:1},
		success: function(data){
			$('#vendor_id').val(data);
			loadVendor();
		}
	});
}

		// Load Produk
        $(function(){
			$(".modal-detail-data").html("<img src='<?= $this->base_url($config['folder_apps']); ?>images/load_img.gif' style='width:50px;'> Loading...");
			// view modal produk 
			$(document).on('click','.modal-produk',function(e){
                //e.preventDefault();
				$(".modal-title").html("Data Produk");
				var class_modal = $('.modal-full');
				class_modal.addClass('modal-lg');
				class_modal.removeClass('modal-full');
                $("#modal_detail").modal('show');
				var data_id = $(this).attr('data-id');
				var table;
                $.post('<?= $this->base_url($config['folder_apps']).'ajax/'.$url_system[1]; ?>/ajax_grid_produk',
                    {id:$(this).attr('data-id')},
                    function(html){
						//alert(data_id);
                        $(".modal-detail-data").html(html);
						// Data Table In Modal 
						table = $('#table_modal').DataTable({
							"processing": true,
							"serverSide": true,
							"order": [],
							// Load data for the table's content from an Ajax source
							"ajax": {
								"url": "<?= $this->base_url($config['folder_apps']).'ajax/'.$url_system[1]; ?>/ajax_produk",
								"type": "POST"
							},
							//Set column definition initialisation properties.
							"columnDefs": [
							{
								"targets": [-6,-1],
								"visible": false,
								"searchable": false
							},
							// add atribut column in table
							{
								"targets": [-5,-4,-3,-2],
								"createdCell":  function (td, cellData, rowData, row, col) {
									//$(td).attr('id', 'susanto'); 
									//if(rowData[3]>0){
									$(td).attr({
										  'onClick' : "masuk('"+rowData[0]+"','"+rowData[2]+"','"+data_id+"','"+rowData[1]+"','"+rowData[3]+"','"+rowData[5]+"')",
										  'style'   : "cursor:pointer;",
										  'title'	: "pilih item"
									});
									//} else {
									//$(td).attr({
									//	  'style'   : "cursor:not-allowed;",
									//	  'title'	: "stok tidak mencukupi"
									//});
									//}
								}
							 }
							],
					
						});						
						// Add placeholder to the datatable filter option
						$('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');
						// Enable Select2 select for the length option
						$('.dataTables_length select').select2({
							minimumResultsForSearch: Infinity,
							width: 'auto'
						});
                    }   
                );
            });

			$(document).on('click','.close_modal',function(e){
				$("#modal_detail").modal("hide");
				$("#modal_rekening").modal("hide");
				$(".modal-detail-data").html("<img src='images/load_img.gif' style='width:50px;'> Loading...");
            });
        });
		
		// id barang, nama, urutan, brand, stok
		function masuk(id_primary, value_name, id, brand, stok, harga_modal) {
			//alert(id_primary+'#'+value_name+'#'+id+'#'+brand+'#'+stok);
			var modal_harga = formatCurrency(parseFloat(harga_modal));
			$(".nominal"+id).val(modal_harga); // harga modal
			$("#id_produk"+id).val(id_primary);
			$("#produk"+id).val(value_name);
			$("#produk_info"+id).html(value_name);
			$("#stok_info"+id).val(stok);
			$(".qty"+id).attr("disabled",false);
			$(".nominal"+id).attr("disabled",false);
			$(".disc"+id).attr("disabled",false);
			$(".nominal_modal"+id).attr("disabled",false);
			$(".margin_item"+id).attr("disabled",false);
			$("#deskripsi_item"+id).attr("disabled",false);
			$("#modal_detail").modal("hide");
			$(".modal-detail-data").html("<img src='images/load_img.gif' style='width:50px;'> Loading...");
			subtotal(id); findTotal(id);
		}
</script>

			<div id="modal_form" class="modal fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header bg-primary">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h6 class="modal-title">Form</h6>
							</div>

							<div class="modal-body form">

                <form action="#" id="form" class="form-horizontal" autocomplete="off">
                <input type="hidden" id="vendor_id"/>
                	<div class="info_error"></div>
                    <input type="hidden" value="" name="id"/>
                        <div class="form-group">
                            <label class="control-label col-md-3">Kategori Vendor <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                        <select class="select-size-lg" name="kategori_vendor" id="kategori_vendor" data-live-search="true" data-width="100%" required>
                                        <option value="">Pilih : </option>
                                        <?php
										$arr_kat=array("PT","CV","Perorangan","Lainnya");
										foreach($arr_kat as $kat_vendor):
										?>
                                        <option value="<?= $kat_vendor; ?>"><?= $kat_vendor; ?></option>
                                        <?php
										endforeach;
										?>
										</select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Vendor <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" name="nama" id="nama" class="form-control" required placeholder="masukkan isian data">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">No. Handphone <span class="text-danger">*</span></label>
                            <div class="col-md-9">
								<input type="text" name="no_hp" id="no_hp" class="form-control" required placeholder="masukkan isian data" maxlength="13" onKeyPress="return numericOnly(event)">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Email </label>
                            <div class="col-md-9">
								<input type="email" name="email" id="email" class="form-control" placeholder="masukkan isian data">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Alamat <span class="text-danger">*</span></label>
                            <div class="col-md-9">
								<textarea class="form-control" name="alamat" id="alamat" rows="3" placeholder="masukkan isian data" required></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                </form>
							</div>

							<div class="modal-footer text-right">
                                <button type="submit" id="btnSave" onClick="save()" class="btn btn-primary">Save <i class="icon-checkbox-checked position-right"></i></button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="icon-cancel-circle2 position-right"></i></button>
							</div>
						</div>
					</div>
				</div>
<?php
} else { $this->redirect($folder_grid."/home"); }

}

} else { $this->redirect("home"); }