<?php
/**
 * Created by BMT Solutions.
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
// proses login
$error="0";
if($this->post('login',true)){
	$ip = $_SERVER['REMOTE_ADDR'];
	$username_login = $this->escapeString($this->post('username'));
	$password_login = hash('sha1',$this->escapeString($this->post('password')));
	$arr_login=$this->data_array("bmt_user ","username='$username_login' AND password='$password_login' AND flag_aktif='1'");
	// jika ada login ditemukan
	if(!empty($arr_login->id_user)){
		$data_session = array("id_admin" => $arr_login->id_user,
							  "level" => $arr_login->level,
							  "nama" => $arr_login->nama,
							  "username" => $arr_login->username,
							  "password" => $arr_login->password
							  );
		$this->set_session($data_session);
		// input log login
		$arrdata = array("id_user" => $arr_login->id_user,
					     "tgl_login" => date("Y-m-d H:i:s"),
					     "ip" => $ip);
		$this->db_insert($arrdata,"tbl_log_login");
		// sukses login
		echo "ok";
	} 
	// jika login GAGAL
	else {
		echo "username atau password salah";
	}
}
?>