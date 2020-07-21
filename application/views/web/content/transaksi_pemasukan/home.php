<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
if($this->baca_session("level")!="cashier"){
$title_grid = ucwords(strtolower(str_replace('_',' ',$url_system[1])));
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
					<div id="notif_success"></div>
					<!-- Page length options -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">Grid Data - <?= $title_grid; ?></h5>
							<div class="heading-elements">
	<a href="#" class="btn btn-info" onClick="add_person()"><i class="icon-plus2 text-white-400"></i></a>
    <a href="#" class="btn btn-success modal-download" data-toggle="modal" data-target="#modal_informasi" data-id="1"data-backdrop="static" data-keyboard="false"><i class="icon-printer text-white-400"></i></a>
    <a href="#" class="btn btn-warning" onClick="reload_table()"><i class="icon-loop3 text-white-400"></i></a>
		                	</div>
						</div>

                                <table id="table_bmt" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="14%">Tgl. Transaksi</th>
                                            <th width="14%">No. Transaksi</th>
                                            <th width="16%">Akun</th>
                                            <th>Kategori</th>
                                            <th width="16%">Nominal</th>
                                            <th width="12%">Aktif</th>
                                            <th style="width:100px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                    	<td align="center" colspan="8">Loading...</td>
                                    </tr>
                                    </tbody>
                                </table>
                        
					</div>
					<!-- /page length options -->

					<!-- Footer -->
					<?php $this->loadView("template/footer"); ?>
					<!-- /footer -->

				</div>
				<!-- /content area -->
			</div>              


<script type="text/javascript">
var save_method; //for save method string
var table;
$(document).ready(function() {
    //datatables
    table = $('#table_bmt').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo $this->base_url($config["folder_apps"]); ?>ajax/<?= $url_system[1]; ?>/ajax_datatable",
            "type": "POST"
        },
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -8,-1 ], //last column
            "orderable": false, //set not orderable
        },
		// hidden column table
		//{
        //    "targets": [ -7 ],
        //    "visible": false,
        //	"searchable": false
		//},
        ],

    });

});



function add_person()
{
    save_method = 'add';
	$(".info_error").html('');
	// fa fa-angle-left
	$('#fa').removeClass('fa').addClass('icon-user');
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
	$("#id_akun").val("").trigger('change');
	$('#id_katfinance').val("").trigger('change');
	//$("#flag_aktif").select2("val",""); // remove selected value
	//$("#jenis_data").select2("val",""); // remove selected value
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Data'); // Set Title to Bootstrap modal title
	$("#notif_success").html('');
}

function edit_person(id)
{
    save_method = 'update';
	$(".info_error").html('');
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
	$("#notif_success").html('');

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo $this->base_url($config["folder_apps"]); ?>ajax/<?= $url_system[1]; ?>/ajax_form_edit/"+id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
			var nominal = formatCurrency(parseFloat(data.nominal));
            $('[name="id"]').val(data.id_ft);
			$('#id_akun').val(data.id_akun).trigger('change');
			$('#id_katfinance').val(data.id_katfinance).trigger('change');
            $('[name="nominal"]').val(nominal);
            $('[name="tgl_transaksi"]').val(data.tgl_transaksi);
            $('[name="keterangan"]').val(data.keterangan);
			//$('#flag_aktif').val(data.flag_aktif).trigger('change');
			$('[name="jenis_data"]').val(data.jenis_data);
			//$('#jenis_data').val(data.jenis_data).trigger('change');
			$('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Data'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
	$(".info_error").html('');
    var url;
    if(save_method == 'add') {
        url = "<?php echo $this->base_url($config["folder_apps"]); ?>ajax/<?= $url_system[1]; ?>/ajax_add";
    } else {
        url = "<?php echo $this->base_url($config["folder_apps"]); ?>ajax/<?= $url_system[1]; ?>/ajax_edit";
    }

    // ajax adding data to database
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
                reload_table();
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

function delete_person(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo $this->base_url($config["folder_apps"]); ?>ajax/<?= $url_system[1]; ?>/ajax_delete/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
				if(data.status == true){
                //if success reload ajax table
                $('#modal_form').modal('hide');
				$("#notif_success").html('<div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">'+
						 '<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>'+
					     '<span class="text-semibold"><b>Sukses...!</b></span> data berhasil di proses.</div>');
                reload_table(1);
				} else {
					alert('Error deleting data');
					reload_table();
				}
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}

function reversal(id)
{
    if(confirm('Batalkan data ini...?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo $this->base_url($config["folder_apps"]); ?>ajax/<?= $url_system[1]; ?>/ajax_reversal/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
				if(data.status == true){
                //if success reload ajax table
                $('#modal_form').modal('hide');
				$("#notif_success").html('<div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">'+
						 '<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>'+
					     '<span class="text-semibold"><b>Sukses...!</b></span> data berhasil di proses.</div>');
                reload_table(1);
				} else {
					alert('Error update data');
					reload_table();
				}
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error update data');
            }
        });

    }
}

function formatCurrency(num) {
	var p = num.toFixed(2).split(".");
		return p[0].split("").reverse().reduce(function(acc, num, i, orig) {
			return  num=="-" ? acc : num + (i && !(i % 3) ? "." : "") + acc;
		}, "") + "," + p[1];
}

// Form Pencarian Data
        $(function(){
			$(".modal-view").html("<img src='<?php echo $this->base_url($config['folder_apps']); ?>images/load_img.gif' style='width:50px;'> Loading...");
			$(document).on('click','.modal-download',function(e){
                e.preventDefault();
				$(".modal-title").html("Form Cetak File");
                $("#modal_informasi").modal('show');
                $.post('<?php echo $this->base_url($config["folder_apps"]); ?>ajax/<?= $url_system[1]; ?>/form_modal',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-view").html(html);
						// Select Form	
						$('.select-size-lg').select2({
							containerCssClass: 'select-ls'
						});
						// date
						$('#date-modal').bootstrapMaterialDatePicker
						({
							time: false,
							clearButton: true
						});
						$('#date-modal1').bootstrapMaterialDatePicker
						({
							time: false,
							clearButton: true
						});
						
                    }   
                );
            });

			$(document).on('click','.close_modal',function(e){
				$("#modal_informasi").modal("hide");
				$(".modal-view").html("<img src='<?php echo $this->base_url($config['folder_apps']); ?>images/load_img.gif' style='width:50px;'> Loading...");
            });
			
        });

</script>

<!-- Bootstrap modal -->
                <div id="modal_informasi" class="modal fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header bg-primary">
								<button type="button" class="close close_modal">&times;</button>
								<h6 class="modal-title">Detail Data</h6>
							</div>
							<div class="modal-view"></div>
						</div>
					</div>
				</div>


			<div id="modal_form" class="modal fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header bg-primary">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h6 class="modal-title">Form</h6>
							</div>

							<div class="modal-body form">

                <form action="#" id="form" class="form-horizontal" autocomplete="off">
                	<div class="info_error"></div>
                    <input type="hidden" value="" name="id"/>
                    	<input type="hidden" name="jenis_data" id="jenis_data" value="d"/>
                        <div class="form-group">
                            <label class="control-label col-md-3">Jenis Akun <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select name="id_akun" id="id_akun" data-placeholder="Pilih :" class="select-size-lg required">
                                        <option value="">Pilih :</option>
                                        <?php
										$list_sql = $this->db_array("finance_akun",$field="",$where="1 ORDER BY jenis_akun");
										foreach($list_sql as $raw){
										?>
                                        	<option value="<?php echo $raw->id_akun; ?>"><?php echo $raw->nama_akun; ?></option>
                                        <?php
										}
										?>
								</select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Kategori <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select name="id_katfinance" id="id_katfinance" data-placeholder="Pilih :" class="select-size-lg required">
                                        <option value="">Pilih :</option>
                                        <?php
										$list_sql = $this->db_array("finance_kategori",$field="",$where="1 AND flag_aktif='1' ORDER BY kategori");
										foreach($list_sql as $raw){
										?>
                                        	<option value="<?php echo $raw->id_katfinance; ?>"><?php echo $raw->kategori; ?></option>
                                        <?php
										}
										?>
								</select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Tanggal <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" name="tgl_transaksi" value="<?= $config['tgl']; ?>" id="date-modal" class="form-control" placeholder="date input..." required="required"/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nominal <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" name="nominal" id="non_idr1" class="form-control" placeholder="text input..." required="required" onkeyup="LoadIDRupiah(1)"/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <label class="control-label col-md-3">Aktif <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select name="flag_aktif" id="flag_aktif" data-placeholder="Pilih :" class="select-size-lg required">
                                        <option value="">Pilih :</option>
                                        <option value="1" selected="selected">Ya Aktif </option>
                                        <option value="0">Tidak Aktif</option>
								</select>
                                <span class="help-block"></span>
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label class="control-label col-md-3">Keterangan <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <textarea name="keterangan" class="form-control" placeholder="text input..." required="required" rows="2"></textarea>
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
<!-- /.modal -->
<!-- End Bootstrap modal -->
<?php } else { $this->redirect("home"); } ?>