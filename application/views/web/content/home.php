<?php
if(in_array($this->baca_session("level"),array("gudang","funding_officer"))){ $this->loadView("web/content/home_user"); } else {
?>
			<div class="content-wrapper">
				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
                        	<!--<div class="pull-right" style="cursor:pointer;" onclick="window.location='<?php echo $this->base_url($config["folder_apps"])."pos/home"; ?>'" title="P.O.S System">
                            <div class="btn btn-primary text-white">
                            	<span class="icon-windows2"></span>
                                Aplikasi P.O.S
							</div>
                            </div>-->
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Dashboard</h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="<?php echo $this->base_url($config["folder_apps"]); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Dashboard</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">

					<!-- Info alert -->
					<div class="alert alert-info alert-styled-left alert-arrow-left alert-component">
						<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
						<h6 class="alert-heading text-semibold"><b>Selamat Datang</b>,</h6>
						Hai <code><?php echo $this->baca_session('nama'); ?></code>, anda login dengan username <code><?php echo $this->baca_session('username'); ?></code> dengan hak akses user anda sebagai <code><?php echo $this->baca_session('level'); ?></code>.
				    </div>
        
        <div class="row">
			<div class="col-md-8">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="media">
                                    <div class="media-body">
                                        <div class="pull-left">
                                            <h6 class="panel-heading-title" style="font-size:16px;">Laporan Transaksi</h6>
                                        </div>
                                        <div class="pull-right">
                                            <input type="number" id="tahun" class="input input-xs" style="border-radius: 7px;color: #000" value="<?php echo date("Y"); ?>"/>
                                            <button class="btn btn-sm btn-default" onclick="loadGrafik()" style="border-radius: 25%"><i class="glyphicon glyphicon-search"></i></button>
                                            <button class="btn btn-sm btn-default" data-action="collapse" style="border-radius: 25%"><i class="icon-circle-down2"></i></button>
                                        </div>
                                    </div>
                                </div>
							</div>

							<div class="panel-body">
								<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
							</div>
						</div>
			</div>
            
            
            <div class="col-md-4">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="media">
                                    <div class="media-body">
                                        <div class="pull-left">
                                            <h6 class="panel-heading-title" style="font-size:16px;">Notifikasi Hari Ini</h6>
                                        </div>
                                        <div class="pull-right">
                                            <button class="btn btn-sm btn-default" data-action="collapse" style="border-radius: 25%"><i class="icon-circle-down2"></i></button>
                                        </div>
                                    </div>
                                </div>
							</div>

							<div class="panel-body">
<ul class="nav nav-tabs nav-tabs-highlight">
	<li class="active" id="tab1"><a href="#" data-toggle="tab" onclick="notif_load('piutang')"><span class="icon-list-numbered text-blue"></span> Penjualan</a></li>
	<li><a href="#" data-toggle="tab" onclick="notif_load('hutang')"><span class="icon-clipboard text-green"></span> Pembelian</a></li>
</ul>

<div id="notif_hariini"></div>

							</div>
						</div>
			</div>
            
		</div>

<script src="<?php echo $this->base_url($config["folder_apps"]); ?>assets/js_chart/highcharts.js"></script>
<script src="<?php echo $this->base_url($config["folder_apps"]); ?>assets/js_chart/exporting.js"></script>

<script>
notif_load('piutang');
loadGrafik();
function loadGrafik(){
	var tahun = $("#tahun").val();
	var judul_laporan = 'Laporan Transaksi '+tahun;
	var chart;
	$.getJSON("<?php echo $this->base_url($config["folder_apps"]); ?>ajax/home/ajax_grafik/"+tahun, function(json) {
	chart = new Highcharts.Chart({
	chart: {
		renderTo: 'container',
		type: 'line',
		marginRight: 0,
		marginBottom: 55
	},
		title: {
		text: judul_laporan,
		x: 0 //center
	},
		subtitle: {
		text: '',
		x: 0
	},
	xAxis: {
		categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
	},
	yAxis: {
		labels: {
        formatter: function() {
          //return 'Rp.' + this.axis.defaultLabelFormatter.call(this);
		  return IDRFormatter(this.value, 'Rp. ');
        }
      	},
		title: {
			text: 'Total'
		},
		plotLines: [{
		value: 0,
		width: 1,
		color: '#808080'
		}]
	},
	tooltip: {
		formatter: function() {
			return '<b>'+ this.series.name +'</b><br/>'+
			this.x +': '+IDRFormatter(this.y, 'Rp. ');
		}
	},
	legend: {
		layout: 'horizontal',
		align: 'center',
		verticalAlign: 'middle',
		x: 0,
		y: 190,
		borderWidth: 0
	},
	series: json
	});
	});
}

function IDRFormatter(angka, prefix) {
    var number_string = angka.toString().replace(/[^,\d]/g, ''),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

function notif_load($jenis_data)
{
	$("#notif_hariini").html("<img src='<?php echo $this->base_url($config['folder_apps']); ?>images/load_img.gif' style='width:50px;'> Loading...");
        $.post('<?php echo $this->base_url($config['folder_apps']); ?>ajax/home/ajax_notifnow',
        {jenis_data:$jenis_data},
			function(html){
				if(html != ''){
					$("#notif_hariini").html(html);
				} 
				// data ditemukan
				else {
            		$("#notif_hariini").html('<span class="text-danger">Data tidak ditemukan</span>');
				}
        	}   
    	);	
}
</script>

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
<?php } ?>