<?php
/**
 * Created by BMT Solutions.
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
namespace ConfigDB;
class DataBase{
    var $host_db	= "localhost";
    var $user_db 	= "root";
    var $pass_db 	= "";
    var $db		 	= "juwita_group";
	// panggil secara otomatis fungsi koneksi
    function __construct(){
        $koneksi = mysql_connect($this->host_db, $this->user_db, $this->pass_db);
        mysql_select_db($this->db);
        if($koneksi == TRUE){
            //echo "Koneksi database mysql dan php berhasil.";
        } else {
            //echo "Gagal melakukan koneksi ke database";
			define('DIR_DB', realpath(dirname(__FILE__)));
			require(ROOT_DIR."application/views/web/404/db_error.php");
			exit();
        }
    }
}
?>