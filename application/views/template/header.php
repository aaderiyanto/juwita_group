<!--
/**
 * Created by BMT Solutions.
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
-->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $meta["meta_title"]; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $this->base_url($config['folder_apps']); ?>images/favicon.png">
	<!-- Global stylesheets -->
	<link href="<?php echo $config["font_google"]; ?>css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo $this->base_url($config['folder_apps']); ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $this->base_url($config['folder_apps']); ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $this->base_url($config['folder_apps']); ?>assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $this->base_url($config['folder_apps']); ?>assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $this->base_url($config['folder_apps']); ?>assets/css/colors.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $this->base_url($config['folder_apps']); ?>assets/css/ribbon.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Data Table -->
	<script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/pages/datatables_basic.js"></script>
	
	<script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/plugins/forms/validation/validate.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/plugins/forms/inputs/touchspin.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/plugins/forms/styling/switch.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/core/app.js"></script>
	<script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/pages/form_validation.js"></script>

	<script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/pages/form_select2.js"></script>
    
    <script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/pages/form_inputs.js"></script>

	<script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/plugins/uploaders/fileinput.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/pages/uploader_bootstrap.js"></script>

	<!-- /theme JS files -->
    
		<link rel="stylesheet" href="<?php echo $this->base_url($config['folder_apps']); ?>assets/datepc/css/datepicker.css">
        <script src="<?php echo $this->base_url($config['folder_apps']); ?>assets/datepc/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
				<?php
				for($a=1; $a<=6; $a++){
				?>
				$('#date_balqon<?php echo $a; ?>').datepicker({
					autoclose: true,
					format: "yyyy-mm-dd",
					todayHighlight: true,
					//todayBtn: true,
					todayHighlight: true,  
				});
				<?php } ?>
			});
        </script>
        
	<!-- Material Picker -->
    <link rel="stylesheet" href="<?php echo $this->base_url($config["folder_apps"]); ?>assets/datepc/material_picker/css/bootstrap-material-datetimepicker.css" />
    <script type="text/javascript" src="<?php echo $this->base_url($config["folder_apps"]); ?>assets/datepc/material_picker/js/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->base_url($config["folder_apps"]); ?>assets/datepc/material_picker/js/bootstrap-material-datetimepicker.js"></script>
    <!-- Material Picker -->

        <script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/auto_rp.js"></script>
         <script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/js_rp.js"></script>
        <script type="text/javascript" src="<?php echo $this->base_url($config['folder_apps']); ?>assets/js/plugins/media/fancybox.min.js"></script>
		<script>
        $(function() {
        
            // Initialize lightbox
            $('[data-popup="lightbox"]').fancybox({
                padding: 3
            });
            
        });
        </script>
</head>