<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
$not_access = array("");
if($this->cek_login()== TRUE && !in_array($this->baca_session("level"),$not_access)){
$title_grid = ucwords(strtolower(str_replace('_',' ',$url_system[1])));
$folder_grid = strtolower($url_system[1]);

// CEK LEVEL AKSES
if(in_array($this->baca_session("level"),array("gudang"))){ $this->loadView("web/content/purchase_order/add_gudang"); } 
else {

if($this->post('simpan',true)){
	$id_primary	= "MAN".$this->kode_uniq(14).rand(100,999);
	//$from_replace = [".",","]; $to_replace = ["","."];
	$batas_tempo = date('Y-m-d', strtotime($this->post("tgl_po").'+'.$this->post("terms").' days'));
	$arr_po = $this->data_array("bmt_manufacture","LEFT(tgl_buat,7)='".substr($this->post("tgl_buat"),0,7)."' ORDER BY RIGHT(nomor_mo,4) DESC");
	if(!empty($arr_po->nomor_po)){
		$urutan = substr($arr_po->nomor_mo,-4);
		$nomor_mo='MO/'.substr($this->post("tgl_buat"),2,2).substr($this->post("tgl_buat"),5,2).'/'.substr('000'.($urutan+1),-4);
	} else { $nomor_mo='MO/'.substr($this->post("tgl_buat"),2,2).substr($this->post("tgl_buat"),5,2).'/0001'; }
	// Save
	$data_array = array("id_manufacture" => $id_primary,
						"id_vendor" => $this->post("bill_to"),
						"nama_produk" => $this->post("nama_produk"),
						"jumlah" => $this->post("jumlah_produk"),
						"nomor_mo" => $nomor_mo,
						"tgl_buat" => $this->post("tgl_buat"),
						"tgl_selesai" => $this->post("tgl_selesai"),
						"keterangan" => $this->post("keterangan"),
						"tgl_input" => date("Y-m-d H:i:s"),
						"user_input" => $this->baca_session('id_admin')
					    );
	$sql = $this->db_insert($data_array,"bmt_manufacture");
  	if($sql == TRUE) { 
		$arr_barang = $this->post("id_barang");
		$arr_jumlah = $this->post("jumlah");
		$no=0;
		foreach($arr_barang as $id_produk){
			$jumlah = $arr_jumlah[$no];
			$id_primary_sub	= "MOD".$this->kode_uniq(14).rand(100,999);
			// Save
			$data_array = array("id_manufacture_detail" => $id_primary_sub,
								"id_manufacture" => $id_primary,
								"id_produk" => $id_produk,
								"jumlah" => $jumlah,
								"tgl_input" => date("Y-m-d H:i:s"),
								"user_input" => $this->baca_session('id_admin')
								);
			$this->db_insert($data_array,"bmt_manufacture_detail");
			$no++;
		}
		$this->redirect($folder_grid."/home/1"); 
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
										<label class="control-label col-lg-2">Nomor WO </label>
										<div class="col-lg-10">
										<input type="text" name="nomor_wo" id="nomor_wo" class="form-control" placeholder="jika kosong, akan di generate otomatis" autofocus="autofocus"/>
                                        </div>                                       
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Reff Quot<span class="text-danger">*</span></label>
										<div class="col-lg-10">
										<input type="text" name="refquot" id="refquot" class="form-control" placeholder="text input..." required="required"/>
                                        </div>                                       
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Reff SO<span class="text-danger">*</span></label>
										<div class="col-lg-10">
										<input type="text" name="refso" id="refso" class="form-control" placeholder="text input..." required="required"/>
                                        </div>                                       
									</div>
                                   
                                    <div class="form-group">
										<label class="control-label col-lg-2">Nomor Manufacture <span class="text-danger">*</span></label>
										<div class="col-lg-9">
                                        <select name="mo" data-placeholder="Pilih :" class="select-size-lg required" id="mo">
                                            <option value="">Pilih :</option>
                                        <?php
										$list_sql = $this->db_array("bmt_manufacture",$field="",$where="");
										foreach($list_sql as $raw):
										?>
                                        	<option value="<?php echo $raw->id_manufacture; ?>" <?= $pilih; ?>><?php echo $raw->nomor_mo; ?></option>
                                        <?php
										endforeach;
										?>                                        
										</select>
                                        </div>               
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Nomor Bill Off Quantity <span class="text-danger">*</span></label>
										<div class="col-lg-9">
                                        <select name="boq" data-placeholder="Pilih :" class="select-size-lg required" id="boq">
                                            <option value="">Pilih :</option>
                                        <?php
										$list_sql = $this->db_array("bmt_boq",$field="",$where="");
										foreach($list_sql as $raw):
										?>
                                        	<option value="<?php echo $raw->id_boq ; ?>" <?= $pilih; ?>><?php echo $raw->nomor_order ; ?></option>
                                        <?php
										endforeach;
										?>                                        
										</select>
                                        </div>               
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Tanggal Buat <span class="text-danger">*</span></label>
										<div class="col-lg-10">
										<input type="text" name="tgl_buat" id="date_balqon1" class="form-control" placeholder="text input..." required="required" value="<?= $config['tgl']; ?>"/>
                                        </div>                                       
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Estimasi Kerja <span class="text-danger">*</span></label>
										<div class="col-lg-10">
										<input type="text" name="tgl_estimasi" id="date_balqon2" class="form-control" placeholder="text input..." required="required" value="<?= $config['tgl']; ?>"/>
                                        </div>                                       
									</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Customer <span class="text-danger">*</span></label>
										<div class="col-lg-9">
                                        <select name="bill_to" data-placeholder="Pilih :" class="select-size-lg required" id="bill_to">
                                            <option value="">Pilih :</option>
                                        <?php
										$list_sql = $this->db_array("pos_vendor",$field="",$where="1 AND id_vendor!='".$set->default_vendor."' ORDER BY nama");
										foreach($list_sql as $raw):
										?>
                                        	<option value="<?php echo $raw->id_vendor; ?>" <?= $pilih; ?>><?php echo $raw->nama; ?></option>
                                        <?php
										endforeach;
										?>                                        
										</select>
                                        </div>
                                        <div class="col-lg-1">
                                        	<button type="button" class="btn btn-success" title="tambah vendor" onclick="AddBillto()"><span class="icon-plus2 text-white"></span></button>
                                        </div>                         
									</div>
										
                                    <div class="form-group">
										<label class="control-label col-lg-2">Site<span class="text-danger">*</span></label>
										<div class="col-lg-10">
										<input type="text" name="site" id="site" class="form-control" placeholder="text input..." required="required"/>
                                        </div>                                       
									</div>
									
                                    <div class="form-group">
										<label class="control-label col-lg-2">Create By <span class="text-danger">*</span></label>
										<div class="col-lg-9">
                                        <select name="bill_to" data-placeholder="Pilih :" class="select-size-lg required" id="bill_to">
                                            <option value="">Pilih :</option>
                                        <?php
										$list_sql = $this->db_array("bmt_user",$field="",$where="");
										foreach($list_sql as $raw):
										?>
                                        	<option value="<?php echo $raw->id_user; ?>" <?= $pilih; ?>><?php echo $raw->nama; ?> - (<?php echo $raw->username; ?>)</option>
                                        <?php
										endforeach;
										?>                                        
										</select>
                                        </div>
                                	</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Leader Produksi 2 <span class="text-danger">*</span></label>
										<div class="col-lg-9">
                                        <select name="bill_to" data-placeholder="Pilih :" class="select-size-lg required" id="bill_to">
                                            <option value="">Pilih :</option>
                                        <?php
										$list_sql = $this->db_array("bmt_user",$field="",$where="");
										foreach($list_sql as $raw):
										?>
                                        	<option value="<?php echo $raw->id_user; ?>" <?= $pilih; ?>><?php echo $raw->nama; ?> - (<?php echo $raw->username; ?>)</option>
                                        <?php
										endforeach;
										?>                                        
										</select>
                                        </div>
                                	</div>
                                    <div class="form-group">
										<label class="control-label col-lg-2">Leader Produksi 3 <span class="text-danger">*</span></label>
										<div class="col-lg-9">
                                        <select name="bill_to" data-placeholder="Pilih :" class="select-size-lg required" id="bill_to">
                                            <option value="">Pilih :</option>
                                        <?php
										$list_sql = $this->db_array("bmt_user",$field="",$where="");
										foreach($list_sql as $raw):
										?>
                                        	<option value="<?php echo $raw->id_user; ?>" <?= $pilih; ?>><?php echo $raw->nama; ?> - (<?php echo $raw->username; ?>)</option>
                                        <?php
										endforeach;
										?>                                        
										</select>
                                        </div>
                                	</div>
									
                                    <div class="form-group">
										<label class="control-label col-lg-2">Keterangan <span class="text-danger">*</span></label>
										<div class="col-lg-10">
											<textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="masukkan isian data" required="required"></textarea>
										</div>
									</div>


				
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
								"targets": [-4],
								"visible": false,
								"searchable": false
							},
							// add atribut column in table
							{
								"targets": [-3,-2],
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
<?php } ?>
<?php } else { $this->redirect("home"); } ?>