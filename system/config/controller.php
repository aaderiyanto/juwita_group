<?php
/**
 * Created by BMT Solutions.
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
class Controller extends MethodFungsi
{
    public function __construct()
    {
		global $loadFile, $config;
    }

    public function loadView($template)
    {
		global $loadFile, $config, $conf, $url_system, $set, $meta, $image_crop, $arr_login, $send_mailer, $api;
		if(file_exists(APPS_DIR.'views/'.$template.'.php')){
			require(APPS_DIR.'views/'.$template.'.php');
		} else { require (APPS_DIR.'views/web/404/home.php'); }
    }

    public function loadControl($template)
    {
		global $loadFile, $config, $conf, $url_system, $set, $meta, $api;
        require(APPS_DIR.'controller/'.$template.'.php');
    }

    public function redirect($loc="")
    {
        global $config;
		$url_loc = "URL='".$this->base_url($config['folder_apps']).$loc."'";
		echo '<meta http-equiv="refresh" content="0;'.$url_loc.'" />';
    }

	public function get_url()
	{
		global $loadFile, $config, $conf, $url_system, $set, $meta, $api;
		$url_dinamis = explode("/",$_SERVER["REQUEST_URI"]); 
		$get_n=1;
		$get_url = array();
		foreach ($url_dinamis as $get_urls) {
			if(!empty($get_urls)){
				if($get_urls == $config["folder_apps"]){
					$get_n=1;
				} else {
					$get_url[$get_n] = $get_urls;
					$get_n++;
				}
			}
		}
		return $get_url;
	}
	
	public function isi_content($template,$web="front",$max_folder="")
	{
		if(empty($max_folder)){$max_folder=2;} else {$max_folder=$max_folder;}
		$array_foder = explode("/",$template);
		$direktori = "";
		$no=0;
		foreach($array_foder as $loc_file){
			$no++;
			if($no<=$max_folder){
			$direktori .= $loc_file."/";
			}
		}
		$template = rtrim($direktori,"/");
		if($web == "front"){$template="web/content/".$template;} else 
		if($web == "admin"){$template="admin/content/".$template;}
		return $this->loadView($template);
	}
}

$loadFile = new Controller;
