<?php
/**
 * Created by BMT Solutions
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
$in_access = array("admin");
if(in_array($this->baca_session("level"),$in_access)){
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
				<?php $this->loadView("template/notif"); ?>
					<!-- Page length options -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">Grid Data - <?= $title_grid; ?></h5>
							<div class="heading-elements">
    <a href="#" class="btn btn-warning" onClick="reload_table()"><i class="icon-loop3 text-white-400"></i></a>
		                	</div>
						</div>


                                <table id="table_bmt" class="table table-striped table-bordered" cellspacing="0" width="100%" style="font-size:12px;">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="14%">Meta Title</th>
                                            <th>Deskripsi</th>
                                            <th width="18%">Keyword</th>
                                            <th width="15%">Perusahaan</th>
                                            <th width="20%">Alamat</th>
                                            <th width="12%">Lokasi</th>
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
                e.preventDefault();
                $("#modal_informasi").modal('show');
                $.post('<?php echo $this->base_url($config['folder_apps']); ?>ajax/<?= $url_system[1]; ?>/detail',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-view").html(html);
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
            "url": "<?php echo $this->base_url($config["folder_apps"]); ?>ajax/<?= $url_system[1]; ?>/ajax_datatable",
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
            "targets": [ -8 ],
            "visible": false,
        	"searchable": false
		},
		// add atribut column in table
		{
			"targets": [-7,-6,-5,-4,-3,-2],
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

});

function reload_table(kondisi='')
{
	if(kondisi==""){$("div.alert.alert-success").remove();}
    table.ajax.reload(null,false); //reload datatable ajax 
}
</script>

<?php } else { $this->redirect("home"); } ?>