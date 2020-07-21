<?php
if($set->flag_maintenance == 1 OR $this->baca_session("level") == "admin"){
if($this->cek_login()== TRUE){
if(count($url_system)>0 AND $url_system[1] == "ajax"){
	$direktori = "";
	$no=0;
	foreach($url_system as $loc_file){
		$no++;
		if($no>1){ $direktori .= $loc_file."/"; }
	}
	$direktori = rtrim($direktori,"/");
	$this->isi_content($direktori,$web="front",$max_folder="2");
} else {
?>
<?php $this->loadView("template/header"); ?>
<style>
.tr:hover {
  background-color: lightyellow;
}
</style>
<body class="navbar-top" onLoad="load()">
	<!-- Main navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-header">
			<a class="navbar-brand" href="<?php echo $this->base_url($config["folder_apps"]); ?>">
                <!--<span style="font-size:16px; color:#FFF; font-weight:bold;">Waterbooom Pekanbaru</span>-->
                <img src="<?php echo $this->base_url($config["folder_apps"]); ?>images/logo_admin.png" style="width:150px; height:25px; margin-top:-2px;">
            </a>
			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>
        <?php $this->loadView("template/top_menu"); ?>
	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">
		<!-- Page content -->
		<div class="page-content" style="background:url(<?= $this->base_url($config['folder_apps']); ?>images/bg_body.jpg)">
			<!-- Main sidebar -->
            <?php if(!in_array($url_system[1],array("pos"))){ $this->loadView("template/left_menu"); } ?>
			<!-- /main sidebar -->
			<!-- Main content -->
            <?php $this->loadControl("main"); ?>
			<!-- /main content -->
		</div>
		<!-- /page content -->
	</div>
    
				<div id="logout" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;Modal Dialog</h5>
								</div>

								<div class="modal-body-logout" style="padding:20px;">
									<div class="alert alert-danger alert-styled-left text-blue-800 content-group">
						                Apakah akan keluar dari panel System...?
						                <button type="button" class="close" data-dismiss="alert">×</button>
						            </div>
								</div>

								<div class="modal-footer">
									<button class="btn btn-danger" data-dismiss="modal"><i class="icon-cross"></i> Close</button>
									<button class="btn btn-primary" onClick="window.location='<?php echo $this->base_url($config["folder_apps"]); ?>logout'"><i class="icon-switch2"></i> Ya Keluar</button>
								</div>
							</div>
						</div>
					</div>
	<!-- /page container -->
<script type="text/javascript">
$(function() {
    // Table setup
    // ------------------------------
    // Setting datatable defaults
    $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        /*columnDefs: [{ 
            orderable: false,
            width: '100px',
            targets: [ 0 ]
        }],*/
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        drawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function() {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        }
    });


    // Datatable 'length' options
    $('.datatable-show-all').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });


    // DOM positioning
    $('.datatable-dom-position').DataTable({
        dom: '<"datatable-header length-left"lp><"datatable-scroll"t><"datatable-footer info-right"fi>',
    });


    // Highlighting rows and columns on mouseover
    var lastIdx = null;
    var table = $('.datatable-highlight').DataTable();
     
    $('.datatable-highlight tbody').on('mouseover', 'td', function() {
        var colIdx = table.cell(this).index().column;

        if (colIdx !== lastIdx) {
            $(table.cells().nodes()).removeClass('active');
            $(table.column(colIdx).nodes()).addClass('active');
        }

    }).on('mouseleave', function() {
        $(table.cells().nodes()).removeClass('active');
    });


    // Columns rendering
    $('.datatable-columns').dataTable({
        columnDefs: [ 
            {
                // The `data` parameter refers to the data for the cell (defined by the
                // `data` option, which defaults to the column being worked with, in
                // this case `data: 0`.
                render: function (data, type, row) {
                    return data +' ('+ row[3]+')';
                },
                targets: 0
            },
            { visible: false, targets: [ 3 ] }
        ]
    });
    // External table additions
    // ------------------------------
    // Add placeholder to the datatable filter option
    $('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');
    // Enable Select2 select for the length option
    $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: 'auto'
    });
    

	var someTableDT = $(".table").on("draw.dt", function () {
		$(this).find(".dataTables_empty").html('<span style="color:#FAA;">No data available in table</span> <br>'+
			    '<img src="<?php echo $this->base_url($config["folder_apps"]); ?>images/img_file.png" style="width:120px;"><br>'+
				'<span class="text-primary"> <i class="icon icon-arrow-left8"></i> '+
				'Add new record or search with different keyword</span>');
	});

});

// LOAD Notif AUTO
/*cek_notifkebakaran();
cek_notifmasyarakat();
setInterval(function(){
	cek_notifkebakaran();
	cek_notifmasyarakat();
}, 3000);

function cek_notifkebakaran()
{
	var action = "cek_pending";
	$.ajax({
		url : "<?php echo $conf->base_url($config["folder_apps"]); ?>ajax/notif_menu",
		method : "POST",
		data : {action:action},
		success: function(data)
		{
			if(data>=1){
				$("title").html('('+data+') Admin Sistem');
				$("#notif_kebakaran").html('<span class="badge badge-danger">'+data+'</span>');
				//$('<audio id="chatAudio"><source src="<?php echo $conf->base_url($config["folder_apps"]); ?>assets/notif/notifikasi.mp3" type="audio/mpeg"></audio>').appendTo('body');
				//$('#chatAudio')[0].play();
			} else { $("#notif_kebakaran").html(""); $("title").html('Admin Sistem'); }
		}
	});
}

function cek_notifmasyarakat()
{
	var action = "masyarakat";
	$.ajax({
		url : "<?php echo $conf->base_url($config["folder_apps"]); ?>ajax/notif_menu",
		method : "POST",
		data : {action:action},
		success: function(data)
		{
			if(data>=1){
				$("#notif_masyarakat").html('<span class="badge badge-danger">'+data+'</span>');
			} else { $("#notif_masyarakat").html(""); }
		}
	});
}*/

		// Material Picker
		$(document).ready(function()
		{
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
			$('#date-modal2').bootstrapMaterialDatePicker
			({
				time: false,
				clearButton: true
			});
			$('#date-modal3').bootstrapMaterialDatePicker
			({
				time: false,
				clearButton: true
			});
			$('#time-modal').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});
			$('#time-modal1').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});
			$('#time-modal2').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});
						$('#time-modal3').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});
			$('#time-modal4').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});
			$('#time-modal5').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});
			$('#time-modal6').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});
			
			$('#date-format-modal').bootstrapMaterialDatePicker
			({
				//format: 'dddd DD MMMM YYYY - HH:mm'
				format: 'YYYY-MM-DD HH:mm'
			});
			$('#date-fr').bootstrapMaterialDatePicker
			({
				format: 'DD/MM/YYYY HH:mm',
				lang: 'fr',
				weekStart: 1, 
				cancelText : 'ANNULER',
				nowButton : true,
				switchOnClick : true
			});

			//$.material.init()
		});

</script>
	<!-- CK Editor -->
   <script type="text/javascript" src="<?php echo $this->base_url($config["folder_apps"]); ?>system/plugins/ckeditor/ckeditor.js"></script>
   <script>
      jQuery(document).ready(function() {			
      	// initiate layout and plugins
      	App.init();
      });
   </script>

<!-- </body> </html> -->
</body>
</html>
<?php 
} 
} 
else { 
	if(count($url_system)>0 AND $url_system[1] == "ajax"){
		$this->isi_content("ajax/".$url_system[2],$web="front",$max_folder="2");
	} else {
		$this->loadView("template/login"); 
	}
}
// portal dalam tahap maintenance
} else { $this->loadView("web/404/maintenance"); }
?>