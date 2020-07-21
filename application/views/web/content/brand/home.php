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
    <a href="#" class="btn btn-warning" onClick="reload_table()"><i class="icon-loop3 text-white-400"></i></a>
		                	</div>
						</div>

                                <table id="table_bmt" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Brand</th>
                                            <th width="16%">Status Data</th>
                                            <th style="width:100px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                    	<td align="center" colspan="4">Loading...</td>
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
            "targets": [ -4,-1 ], //last column
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
	$("#id_jt").select2("val",""); // remove selected value
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
            $('[name="id"]').val(data.id_brand);
            $('[name="brand"]').val(data.brand);
            $('[name="flag_aktif"]').val(data.flag_aktif);
			//$('#id_jt').val(data.id_jt).trigger('change'); select2 form
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

</script>

<!-- Bootstrap modal -->
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
                        <div class="form-group">
                            <label class="control-label col-md-3">Brand <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input name="brand" id="brand" placeholder="Text input..." class="form-control" type="text" required>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Status Data <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select name="flag_aktif" id="flag_aktif" class="form-control" type="text" required>
                                <option value="1" selected="selected">Ya, Aktif</option>
                                <option value="0">Tidak Aktif</option>
                                </select>
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