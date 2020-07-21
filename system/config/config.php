<?php
/**
 * Created by BMT Solutions.
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
include "db/database.php";
$koneksi_db = new \ConfigDB\DataBase();
class MethodFungsi {
	// Data Tables Server Side
	private function _get_datatables_query($table,$column_order,$column_search,$order_by,$where="",$field_tbl="",$join_tb="")
	{
		if(!empty($field_tbl)){$field_data=$field_tbl;} else {$field_data="*";}
		$join_tbl=""; $relasi_join="";
		if(is_array($join_tb)){
			foreach ($join_tb as $table_join => $kondisi_join)
			{
				$join_tbl.="INNER JOIN ".$table_join." ";
				$relasi_join.="AND ".$kondisi_join." ";
			}
		}
		$kondisi_cari="";
		if(!empty($where)){
			foreach ($where as $kondisi_)
			{
				$kondisi_cari.="AND ".$kondisi_." ";
			}
		} else {$kondisi_cari.="";}
		$i = 0; $kondisi_cari_multi="";
		foreach ($column_search as $item) // loop column 
		{
			if(isset($_POST['search']) AND $_POST['search']['value']) // if datatable send POST for search
			{
				$kondisi_cari_multi.=$item." LIKE '%".$_POST['search']['value']."%' OR ";
			}
			$i++;
		}
		if(!empty($kondisi_cari_multi)){ $kondisi_cari.="AND (".rtrim($kondisi_cari_multi," OR ").")"; }

		if(isset($_POST['order'])) // here order processing
		{
			$kondisi_order_by="ORDER BY ".$column_order[$_POST['order']['0']['column']]." ".$_POST['order']['0']['dir'];
		} 
		else if(isset($order_by))
		{
			$kondisi_order="";
			$order = $order_by;
			$query_order= "ORDER BY";
			foreach($order as $column_order=>$order_schema){
				$kondisi_order.=$column_order." ".$order_schema.", ";
			}
			$kondisi_order_by=$query_order." ".rtrim($kondisi_order,", ");
			//$kondisi_order_by="ORDER BY ".key($order)." ".$order[key($order)];
		}
		$sql_query = "SELECT ".$field_data." FROM ".$table." ".$join_tbl." WHERE 1 ".$relasi_join." ".$kondisi_cari." ".$kondisi_order_by;
		return $sql_query;
	}

	public function get_datatables($table,$column_order,$column_search,$order_by,$where="",$field_tbl="",$join="")
	{
		$limit = "";
		$sql = $this->_get_datatables_query($table,$column_order,$column_search,$order_by,$where,$field_tbl,$join);
		if(isset($_POST['length']) AND $_POST['length'] != -1){$limit=" LIMIT ".$_POST['start'].",".$_POST['length'];}
		//$this->db->limit($_POST['length'], $_POST['start']);
		$query_sql = $sql." ".$limit;
		return $this->SqlQuery($query_sql,true);
	}

	public function count_filtered($table,$column_order,$column_search,$order_by,$where="",$field_tbl="",$join="")
	{
		$sql = $this->_get_datatables_query($table,$column_order,$column_search,$order_by,$where,$field_tbl,$join);
		return $this->SqlCount($sql);
	}

	public function count_all($table,$where="",$join="")
	{
		$kondisi_cari=""; $join_tbl=""; $relasi_join="";
		if(!empty($join)){
			if(is_array($join)){
				foreach ($join as $table_join => $kondisi_join)
				{
					$join_tbl.="INNER JOIN ".$table_join." ";
					$relasi_join.="AND ".$kondisi_join." ";
				}
			}
		}
		if(!empty($where)){
			foreach ($where as $kondisi_)
			{
				$kondisi_cari.="AND ".$kondisi_." ";
			}
		} else {$kondisi_cari.="";}
		$sql = "SELECT * FROM ".$table." ".$join_tbl." WHERE 1 ".$relasi_join." ".$kondisi_cari;
		return $this->SqlCount($sql);
	}
	// End Data Table Fungsi

	public function notif_query($query)
	{
		$html = '<div style="padding:10px; background-color:#E9E9E9; box-shadow:#CCC;">
				 <div style="padding-bottom:10px; border-bottom:1px solid #ccc; color:#069">Query Error...!</div>
			     <div style="margin-top:10px;">'.$query.'</div>
				 </div><div style="padding:10px;"></div>';
		return $html;
	}
	
	public function SqlQuery($sql,$json=false){
		$sql_data = mysql_query($sql) or die($this->notif_query($sql));
		if($json == false){ return $sql_data; } else {
			$rows = array();
			while(($obj = mysql_fetch_object($sql_data))!= NULL){
				$rows[] = $obj;
			}
			return $rows;
		}
	}

	public function SqlCount($sql){
		$sql_data = mysql_num_rows($this->SqlQuery($sql));
		return $sql_data;
	}

	public function data_select($tabel,$field,$where)
	{
		if($where=='') {$where='';} else {$where="WHERE $where";}
		$query=$this->SqlQuery("select $field from $tabel $where limit 1");
		$hasil=mysql_fetch_object($query);
		return $hasil->$field; 	
	}

	public function data_array($tabel,$where)
	{
		if($where=='') {$where='';} else {$where="WHERE $where";}
		$query=$this->SqlQuery("SELECT * FROM $tabel $where limit 1");
		$hasil=mysql_fetch_object($query);
		return $hasil; 	
	}

	public function data_update($tabel,$field,$where)
	{
		if($where=='') {$where='';} else {$where="WHERE $where";}
		$this->SqlQuery("UPDATE $tabel SET $field $where");
		return mysql_affected_rows();
	}
	
	public function some_fieldSQL($table,$data="")
	{
		//$data = array("field"=>"description...");
		$where = "";
		if(!empty($data)){
			foreach($data as $id=>$val){
				$list_field.="'$id',";
			}
			$array_option = rtrim($list_field,",");
			$where = "WHERE FIELD NOT IN (".$array_option.")";
		}
		$sql = $this->SqlQuery("SHOW FIELDS FROM ".$table." ".$where);
		while($row=mysql_fetch_object($sql)){
			$html .=$row->Field.", ";
		}
		// SHOW FIELDS FROM `tablename` WHERE FIELD NOT IN ('f1','f2','f3');
		return rtrim($html,", ");
	}
	
	public function anti_injection($data)
	{
		$filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
		return $filter;
	}

	public function escapeString($string)
    {
        return mysql_real_escape_string($string);
    }

	public function replace_string($string,$from='',$to='')
	{
		return(str_replace($from,$to,$string));
	}
	
	public function enter_string($string,$nomor)
	{
		$replace_string = str_replace("\r","",$string);
		$replace_string = str_replace("\n"," ",$replace_string);
		$array_string = explode(" ",$replace_string);
		$no=0; $isi_string="";
		foreach($array_string as $char):
		$no++;
		if($no==$nomor){$no=1; $pindah_baris="<br>";} else {$pindah_baris="";}
		$isi_string .=$char." ".$pindah_baris;
		endforeach;	
		return $isi_string;	
	}
	
	public function db_array($tabel,$field="",$where="")
	{
		if($where=='') {$where='';} else {$where="WHERE $where";}
		if($field=='') {$field='*';} else {$field="$field";}
		$query = "SELECT ".$field." FROM ".$tabel." ".$where;
		$query = $this->SqlQuery($query);
		$rows = array();
        while(($obj = mysql_fetch_object($query))!= NULL){
            $rows[] = $obj;
        }
        return $rows;
		mysql_error($query);
	}

	public function db_insert($data, $tbl) {
		$query = "INSERT INTO ".$tbl." SET ";
		$no=1;
		foreach ($data as $field => $value) {
			if(!empty($value) OR $value=="0"){
			$query .= $field.'="'. $this->escapeString($value) .'", ';
			} else {
			$query .= $field.'=NULL, ';
			}
		$no++;
		}
		$query = rtrim($query, ", ");
		$result = $this->SqlQuery($query);
		return $result;
	}

	public function db_update($data,$tbl,$where) {
		$where = " WHERE $where";
		$query = "UPDATE ".$tbl." SET ";
		$no=1;
		foreach ($data as $field => $value) {
			if(!empty($value) OR $value=="0"){
			$query .= $field.'="'. $this->escapeString($value) .'", ';
			} else {
			$query .= $field.'=NULL, ';
			}
		$no++;
		}
		$query = rtrim($query, ", ").$where;
		$result = $this->SqlQuery($query);
		return $result;
	}

	public function db_delete($arr_table,$kondisi)
	{
		$no=0;
		foreach($arr_table as $tbl){
			$where = "WHERE $kondisi";
			$query = "DELETE FROM ".$tbl." ".$where;
			if($this->SqlQuery($query) == TRUE){ $no++; }
		}
		if($no>0){$result=TRUE;} else {$result=FALSE;}
		return $result;
	}
		
	public function cari($sql)
	{
		return $sql;
	}
	
	public function post($input,$submit=false)
	{
		if($submit==false){
			//if(empty($_POST[$input])){ $data=""; } else
			if(!empty($_POST[$input]) OR $_POST[$input]=="0"){$data=$_POST[$input];} else {$data="";} return $data;
		} else
		if($submit==true){ return isset($_POST[$input]); }
	}

	public function get($input)
	{
		if(!empty($_GET[$input])){$data=$_GET[$input];} else {$data="";}
		return $data;
	}

	public function set_validation($form)
	{
		$no=0; $jml_form=count($form);
		foreach($form as $input){
			if(!empty($this->post($input)) && $this->post($input)!=''){ $no++; }
		}
		if($no == 0 || $no<$jml_form) { return false; } else { return true; }
	}
	
	public function set_session($data)
	{
		foreach($data as $key=>$value){
			$_SESSION[$key] = $value;
		}
	}

	public function baca_session($data)
	{
		if(!empty($_SESSION[$data])){ return $_SESSION[$data]; }
	}
	
	public function set_cookie($data,$delete=false)
	{
		foreach($data as $key=>$value){
			if($delete == false){
				//setcookie($key, $value, time()+(86400*1),"/"); // Set 1 day
				setcookie($key, $value, time()+(86400*1),"/"); // Set 1 day
			}
			if($delete == true){
				setcookie($key, '', time()-(86400*1),"/"); // Set 1 day
			}
		}
	}
	
	public function baca_cookie($data)
	{
		if(!empty($_COOKIE[$data])){ return $_COOKIE[$data]; }
	}
	
	public function session_login($id_user)
	{
		$arr = $this->data_array("sikad_user","id_user='".$id_user."'");
		// set session login ###
		$data_session = array("id_admin" => $arr->id_user,
							  "level" => $arr->level,
							  "nama" => $arr->nama,
							  "username" => $arr->username,
							  "password" => $arr->password
							  );
		$this->set_session($data_session);
	}
	
	public function kode_uniq($length="")
	{
		if(empty($length)){$length="10";} else {$length=$length;}
		$string="";
		$karakter= 'ABCDEFGHJKLMNPQRSTUVWXY3456789'; 
		$string = ''; 
		for ($i = 1; $i <=$length; $i++) { 
			$pos = rand(0, strlen($karakter)-1); 
			$string .= $karakter{$pos};
		} 
		return $string;	
	}
	
	public function rupiah($angka,$koma="")
	{
		if(empty($koma)){$koma="0";} else {$koma=$koma;}
		$rupiah=number_format($angka,$koma,',','.');
		return $rupiah;
	}

	public function nilai_rupiah($satuan)
	{
		$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
		if ($satuan < 12)
			return "".$huruf[$satuan];
		elseif ($satuan < 20)
			return $this->nilai_rupiah($satuan - 10)." Belas";
		elseif ($satuan < 100)
			return $this->nilai_rupiah($satuan / 10)." Puluh ".$this->nilai_rupiah ($satuan % 10);
		elseif ($satuan < 200)
			return " Seratus ".$this->nilai_rupiah($satuan - 100);
		elseif ($satuan < 1000)
			return $this->nilai_rupiah($satuan / 100)." Ratus ".$this->nilai_rupiah($satuan % 100);
		elseif ($satuan < 2000)
			return "Seribu ".$this->nilai_rupiah($satuan - 1000);
		elseif ($satuan < 1000000)
			return $this->nilai_rupiah($satuan / 1000) . " Ribu ".$this->nilai_rupiah ($satuan % 1000);
		elseif ($satuan < 1000000000)
			return $this->nilai_rupiah($satuan / 1000000) . " Juta ".$this->nilai_rupiah($satuan % 1000000);
		elseif ($satuan >= 1000000000)
			return $this->nilai_rupiah($satuan / 1000000000) . " Milyar ".$this->nilai_rupiah($satuan % 1000000000);
	}

	public function seo_title($s)
	{
		$c = array (' ');
		$d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
		$s = str_replace($d, '', $s);
		$s = strtolower(str_replace($c, '-', $s));
		return $s;
	}

	public function UploadWeb($fupload_name,$filename,$direktory)
	{
		$vdir_upload = $direktory."image_upload/";
		$vfile_upload = $vdir_upload . $fupload_name;
		move_uploaded_file($filename, $vfile_upload);
	}
	
	public function UploadInfo($fupload_name,$filename,$direktory)
	{
		$vdir_upload = $direktory;
		$vfile_upload = $vdir_upload . $fupload_name;
		move_uploaded_file($filename, $vfile_upload);
	}
	
	public function nama_browser()
	{
		$browser = "";
		if(eregi("opera", $_SERVER['HTTP_USER_AGENT'])){
			$browser = "Opera Mini";
		}
		elseif(eregi("msie", $_SERVER['HTTP_USER_AGENT'])){
			$browser = "Internet Explorer";
		}
		elseif(eregi("Konqueror", $_SERVER['HTTP_USER_AGENT'])){
			$browser = "Konqueror";
		}
		elseif(eregi("Firefox", $_SERVER['HTTP_USER_AGENT'])){
			$browser = "Mozilla Firefox";
		}
		elseif(eregi("safari", $_SERVER['HTTP_USER_AGENT'])){
			$browser = "Safari / Chrome";
		}
		elseif(eregi("netscape", $_SERVER['HTTP_USER_AGENT'])){
			$browser = "Netscape";
		}
		elseif(eregi("AOL", $_SERVER['HTTP_USER_AGENT'])){
			$browser = "AOL";
		}
		else {
			$browser = "Tidak di ketahui";
		}
		return $browser;
	}

	public function tgl_indo($tgl)
	{
			$tanggal = substr($tgl,8,2);
			$bulan = $this->getBulan(substr($tgl,5,2));
			$tahun = substr($tgl,0,4);
			return $tanggal.' '.$bulan.' '.$tahun;		 
	}	

	public function getBulan($bln)
	{
		switch ($bln){
			case 1: return "Januari"; break;
			case 2: return "Februari"; break;
			case 3: return "Maret"; break;
			case 4: return "April"; break;
			case 5: return "Mei"; break;
			case 6: return "Juni"; break;
			case 7: return "Juli"; break;
			case 8: return "Agustus"; break;
			case 9: return "September"; break;
			case 10: return "Oktober"; break;
			case 11: return "November"; break;
			case 12: return "Desember"; break;
		}
	}

	public function cek_login($mobile=false)
	{
		// Set session baru jika sudah habis...
		if($this->baca_cookie("id_admin")!='' && $this->baca_session("id_admin")==''){
			//$this->session_login($this->baca_cookie("id_admin"));
		}
		if($mobile == true){
			if(!empty($this->baca_session('username_mobile')) AND !empty($this->baca_session('password_mobile'))){$data_login = TRUE;} else {$data_login=FALSE;}
		} else {
			if(!empty($this->baca_session('username')) AND !empty($this->baca_session('password'))){$data_login = TRUE;} else {$data_login=FALSE;}
		}
		return $data_login;
	}

	public function saldo_rekkoran($from,$id_akun)
	{
		$sql = $this->db_array("finance_transaksi a",$field="a.*",$where="1 AND a.tgl_transaksi <'".$from."' AND a.flag_aktif='1' AND a.id_akun='".$id_akun."' ORDER BY a.tgl_transaksi");
		$subdebit=0;
		$subkredit=0;
		$subsaldo=0;
		$no=0;
		foreach($sql as $raw):
			$no++;
			if($raw->jenis_data == "d"){$debit=$raw->nominal; $kredit=0;} else
			if($raw->jenis_data == "k"){$debit=0; $kredit=$raw->nominal;}
			if($no==1){ $sisa_saldo=$debit-$kredit; } else {
				$sisa_saldo = $sisa_saldo + $debit - $kredit;
			}
			//$subdebit  = $subdebit + $debit;
			//$subkredit = $subkredit + $kredit;
			$subsaldo = $subsaldo + $sisa_saldo;
		endforeach;
		return $sisa_saldo;
	}
	
	public function notif_menu_informasi()
	{
		if($this->baca_session("level") == "mahasiswa"){
			$count_notif=$this->data_select("sikad_informasi","COUNT(*)","1 AND tgl_mulai<='".date("Y-m-d")."' AND tgl_selesai>='".date("Y-m-d")."' AND ditujukan_untuk IN ('all','mahasiswa')");
		} else
		if($this->baca_session("level") == "dosen"){
			$count_notif=$this->data_select("sikad_informasi","COUNT(*)","1 AND tgl_mulai<='".date("Y-m-d")."' AND tgl_selesai>='".date("Y-m-d")."' AND ditujukan_untuk IN ('all','dosen')");
		} else {
			$count_notif=$this->data_select("sikad_informasi","COUNT(*)","1 AND tgl_mulai<='".date("Y-m-d")."' AND tgl_selesai>='".date("Y-m-d")."'");
		}
		if($count_notif>0){
			$html_notif='<span class="badge badge-warning">'.$count_notif.'</span>';
		} else { $html_notif=''; }
		return $html_notif;
	}
	
	public function notif_info($class,$info)
	{
		$html='<div class="alert alert-'.$class.'" id="contactError">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$info.'</div>';
		return $html;
	}
	
	public function active_menu($url,$menu)
	{
		$class_active=""; $menu_web="";
		if(count($url)==0){
			$class_active = "active";
			$menu_active = "home";
			
		} else {
			$direktori_active = "";
			$no=0;
			foreach($url as $loc_file){
				$no++;
				if($no==1){
					$direktori_active = $loc_file;
				}
			}
			$menu_active = $direktori_active;
		}
		foreach($menu as $nama_menu){
			if($nama_menu == $menu_active){ $class_active="active"; $menu_web=$nama_menu;}
		}
		if($menu_web == $menu_active){$class_active="active";} else {$class_active="";}
		return $class_active;
	}
	
	public function SendSMS($no_hp,$pesan)
	{
		$userkey = "";
		$passkey = "";
		$isi_pesan=urlencode($pesan);
		$url = "https://reguler.zenziva.net/apps/smsapi.php";
		$curlHandle = curl_init();
		curl_setopt($curlHandle, CURLOPT_URL, $url);
		curl_setopt($curlHandle, CURLOPT_POSTFIELDS,'userkey='.$userkey.'&passkey='.$passkey.'&nohp='.$no_hp.'&pesan='.$isi_pesan);
		curl_setopt($curlHandle, CURLOPT_HEADER, 0);
		curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
		curl_setopt($curlHandle, CURLOPT_POST, 1);
		$results = curl_exec($curlHandle);
		curl_close($curlHandle);
		$XMLdata = new SimpleXMLElement($results);
		$status = $XMLdata->message[0]->text;
		return $status;
	}

	public function base_url($folder=""){
		if(empty($folder)){$folder="";} else {$folder=$folder."/";}
		$base_url  = "http://".$_SERVER['HTTP_HOST']."/";
		$app_name  = $base_url.$folder;
		return $app_name;
	}

}
$conf = new MethodFungsi();
$set = $conf->data_array("setting_apps","id_setting='1'");
$arr_login = $conf->data_array("bmt_user","id_user='".$conf->baca_session("id_admin")."'");
?>