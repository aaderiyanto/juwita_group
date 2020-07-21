<?php
/**
 * Created by BMT Solutions.
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
$data_coockies = array("id_admin" => 'xxx', "level" => NULL, "nama" => NULL, "username" => NULL, "password" => NULL);
$this->set_cookie($data_coockies,true); // END DELETE COOCKIE
session_destroy();
echo "1";
?>