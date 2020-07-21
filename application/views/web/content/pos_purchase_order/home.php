<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
$not_access = array("funding_officer");
if(!in_array($this->baca_session("level"),$not_access)){
$title_grid = ucwords(strtolower(str_replace('_',' ',$url_system[1])));
$folder_grid = strtolower($url_system[1]);
if($this->baca_session("level")=="gudang"){ $this->loadView("web/content/pos_purchase_order/home_gudang"); } else {
?>
<link rel="stylesheet" href="<?php echo $this->base_url($config["folder_apps"]); ?>assets/css_crop/slim.min.css">
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
				<?php $this->loadView("template/notif"); ?>
					<!-- Page length options -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">Grid Data - <?= $title_grid; ?></h5>
							<div class="heading-elements">
	<?php if(!in_array($this->baca_session("level"),$not_access)){ ?>
    <a href="#" class="btn btn-info" onclick="window.location='<?php echo $this->base_url($config["folder_apps"]); ?><?= $folder_grid; ?>/add'"><i class="icon-plus2 text-white-400"></i></a>
    <!--<a href="#" class="btn btn-success modal-download" data-toggle="modal" data-target="#modal_informasi" data-id="download" data-backdrop="static" data-keyboard="false"><i class="icon-download text-white-400"></i></a>-->
    <?php } ?>
    
    <a href="#" class="btn btn-warning" onClick="reload_table()"><i class="icon-loop3 text-white-400"></i></a>
		                	</div>
						</div>


                                <table id="table_bmt" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="14%">Tanggal P.O</th>
                                            <th width="14%">Nomor P.O</th>
                                            <th>Vendor</th>
                                            <!--<th width="16%">Nominal</th>-->
                                            <th width="11%">Aktif</th>
                                            <th style="width:90px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                    	<td align="center" colspan="6">Loading...</td>
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

                <div id="modal_informasi" class="modal fade">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header bg-primary">
								<button type="button" class="close close_modal">&times;</button>
								<h6 class="modal-title">Detail Data</h6>
							</div>
							<div class="modal-view"></div>
						</div>
					</div>
				</div>

<script>
        $(function(){
			$(".modal-view").html("<img src='<?php echo $this->base_url($config['folder_apps']); ?>images/load_img.gif' style='width:50px;'> Loading...");
            $(document).on('click','.modal-record',function(e){
                $(".modal-title").html("Detail Data");
				e.preventDefault();
                $("#modal_informasi").modal('show');
                $.post('<?php echo $this->base_url($config['folder_apps']); ?>ajax/<?= $folder_grid; ?>/detail',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-view").html(html);
                    }   
                );
            });

			$(document).on('click','.modal-download',function(e){
                e.preventDefault();
				$(".modal-title").html("Form Download File");
                $("#modal_informasi").modal('show');
                $.post('<?php echo $this->base_url($config["folder_apps"]); ?>ajax/<?= $folder_grid; ?>/form_download',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-view").html(html);
						// Select Form	
						$('.select-size-lg').select2({
							containerCssClass: 'select-ls'
						});
                    }   
                );
            });

			$(document).on('click','.close_modal',function(e){
				$("#modal_informasi").modal("hide");
				$(".modal-view").html("<img src='<?php echo $this->base_url($config['folder_apps']); ?>images/load_img.gif' style='width:50px;'> Loading...");
            });
			
        });

// SET DATA TABLE SSP
var table;
$(document).ready(function() {
    //datatables
    table = $('#table_bmt').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo $this->base_url($config["folder_apps"]); ?>ajax/<?= $folder_grid; ?>/ajax_datatable",
            "type": "POST"
        },
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
		// hidden column table
		{
            "targets": [ -6 ],
            "visible": false,
        	"searchable": false
		},
		// add atribut column in table
		{
			"targets": [-5,-4,-3],
			"createdCell":  function (td, cellData, rowData, row, col) {
				//$(td).attr('id', 'susanto'); 
				$(td).attr({
					  'data-toggle'   : "modal",
					  'data-target'   : "#modal_informasi",
					  'data-id'       : rowData[0],
					  'class'         : "modal-record",
					  'data-backdrop' : "static",
					  'data-keyboard' : "false",
					  'style'		  : "cursor:pointer",
					  'title'		  : "Detail Data"
				});
			}
		 }
        ],

    });
	//$('[type="search"]').val("1402500698");
});

function reload_table(kondisi='')
{
	if(kondisi==""){$("div.alert.alert-success").remove();}
    table.ajax.reload(null,false); //reload datatable ajax 
}

function delete_person(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo $this->base_url($config["folder_apps"]); ?>ajax/<?= $folder_grid; ?>/ajax_delete/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
				if(data.status == true){
				// remove notif if show 
				$("div.alert.alert-success").remove();
                //if success reload ajax table
                $('#modal_form').modal('hide');
				$("#notif_success").html('<div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">'+
						 '<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>'+
					     '<span class="text-semibold"><b>Sukses...!</b></span> data berhasil di proses.</div>');
                reload_table(1);
				} else { alert('Error deleting data...'); }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}

function UpdatePembayaran(id_primary)
{
    if(confirm('Are you sure update this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo $this->base_url($config["folder_apps"]); ?>ajax/<?= $folder_grid; ?>/ajax_uppembayaran",
            type: "POST",
            dataType: "JSON",
			data : {npm:id_primary},
            success: function(hasil)
            {
				if(hasil.status == true){
				// remove notif if show 
				$("div.alert.alert-success").remove();
                //if success reload ajax table
				$("#notif_success").html('<div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">'+
						 '<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>'+
					     '<span class="text-semibold"><b>Sukses...!</b></span> data berhasil di proses.</div>');
                reload_table(1);
				} else { alert('Error update data...'); }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error updadte data');
            }
        });

    }
}

function goToURL()
{
	var data_post;
	var jml_post = 0;
	var jurusan = $("#jurusan").val();
	var tahun_angkatan = $("#tahun_angkatan").val();
	var id_semester = $("#id_semester").val();
	if(jurusan){jurusan=jurusan+'-'; jml_post++;} else {jurusan='';}
	if(tahun_angkatan){tahun_angkatan=tahun_angkatan+'-'; jml_post++;} else {tahun_angkatan='';}
	if(id_semester){id_semester=id_semester+'-'; jml_post++;} else {id_semester='';}
	data_post = jurusan+''+tahun_angkatan+''+id_semester;
	location.href = "<?php echo $this->base_url($config["folder_apps"]); ?>ajax/<?= $folder_grid; ?>/xls_report/"+data_post;
}

</script>
<?php } ?>
<?php } else { $this->redirect("home"); } ?>