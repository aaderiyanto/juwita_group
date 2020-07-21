<?php
/**
 * Created by BMT Solutions.
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
$this->loadView("web/404/blank");
//session_destroy();
//$this->redirect("");
?>
<script>
$(document).ready(function() {
	del_session();
});
function del_session()
{
	//alert(1);
	$.ajax({
		type: 'POST',
		url: '<?= $this->base_url($config["folder_apps"]); ?>ajax/ajax/logout',
		success: function(data){
		 if(data == 1){
			window.location.href = "<?= $this->base_url($config["folder_apps"]); ?>";
		 }
		}
	});
}
</script>