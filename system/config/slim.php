<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by BMT Solutions.
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
abstract class SlimStatus {
    const FAILURE = 'failure';
    const SUCCESS = 'success';
}

class Slim extends MethodFungsi{

	public static function getImages($inputName) {
        $values = Slim::getPostData($inputName);

        // test for errors
        if ($values === false) {
            return false;
        }

        // determine if contains multiple input values, if is singular, put in array
        $data = array();
        if (!is_array($values)) {
            $values = array($values);
        }

        // handle all posted fields
        foreach ($values as $value) {
            $inputValue = Slim::parseInput($value);
            if ($inputValue) {
                array_push($data, $inputValue);
            }
        }

        // return the data collected from the fields
        return $data;

    }

    // $value should be in JSON format
    private static function parseInput($value) {

        // if no json received, exit, don't handle empty input values.
        if (empty($value)) {return null;}

        // If magic quotes enabled
        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }

        // The data is posted as a JSON String so to be used it needs to be deserialized first
        $data = json_decode($value);

        // shortcut
        $input = null;
        $actions = null;
        $output = null;
        $meta = null;

        if (isset ($data->input)) {

            $inputData = null;
            if (isset($data->input->image)) {
                $inputData = Slim::getBase64Data($data->input->image);
            }
            else if (isset($data->input->field)) {
                $filename = $_FILES[$data->input->field]['tmp_name'];
                if ($filename) {
                    $inputData = file_get_contents($filename);
                }
            }

            $input = array(
                'data' => $inputData,
                'name' => $data->input->name,
                'type' => $data->input->type,
                'size' => $data->input->size,
                'width' => $data->input->width,
                'height' => $data->input->height,
            );

        }

        if (isset($data->output)) {

            $outputDate = null;
            if (isset($data->output->image)) {
                $outputData = Slim::getBase64Data($data->output->image);
            }
            else if (isset ($data->output->field)) {
                $filename = $_FILES[$data->output->field]['tmp_name'];
                if ($filename) {
                    $outputData = file_get_contents($filename);
                }
            }

            $output = array(
                'data' => $outputData,
                'name' => $data->output->name,
                'type' => $data->output->type,
                'width' => $data->output->width,
                'height' => $data->output->height
            );
        }

        if (isset($data->actions)) {
            $actions = array(
                'crop' => $data->actions->crop ? array(
                    'x' => $data->actions->crop->x,
                    'y' => $data->actions->crop->y,
                    'width' => $data->actions->crop->width,
                    'height' => $data->actions->crop->height,
                    'type' => $data->actions->crop->type
                ) : null,
                'size' => $data->actions->size ? array(
                    'width' => $data->actions->size->width,
                    'height' => $data->actions->size->height
                ) : null,
                'rotation' => $data->actions->rotation,
                'filters' => $data->actions->filters ? array(
                    'sharpen' => $data->actions->filters->sharpen
                ) : null
            );
        }

        if (isset($data->meta)) {
            $meta = $data->meta;
        }

        // We've sanitized the base64data and will now return the clean file object
        return array(
            'input' => $input,
            'output' => $output,
            'actions' => $actions,
            'meta' => $meta
        );
    }

    // $path should have trailing slash
    //public static function saveFile($data, $name, $path = 'tmp/', $uid = true) {
	public static function saveFile($data, $name, $path , $uid) {
        // Add trailing slash if omitted
        if (substr($path, -1) !== '/') {
            $path .= '/';
        }

        // Test if directory already exists
        if(!is_dir($path)){
            mkdir($path, 0755, true);
        }

        // Sanitize characters in file name
        $name = Slim::sanitizeFileName($name);
		$type_extensi = Slim::extensionFile($name);
        // Let's put a unique id in front of the filename so we don't accidentally overwrite other files
        if ($uid) {
            //$name = "art_".$uid.'_'.rand(100,999).".".$type_extensi;
			$name = $uid.".".$type_extensi;
        }

        // Add name to path, we need the full path including the name to save the file
        $path = $path . $name;

        // store the file
        Slim::save($data, $path);

        // return the files new name and location
        return array(
            'name' => $name,
            'path' => $path
        );
    }

    /**
     * Get data from remote URL
     * @param $url
     * @return string
     */
    public static function fetchURL($url, $maxFileSize) {
        if (!ini_get('allow_url_fopen')) {
            return null;
        }
        $content = null;
        try {
            $content = @file_get_contents($url, false, null, 0, $maxFileSize);
        } catch(Exception $e) {
            return false;
        }
        return $content;
    }

    public static function outputJSON($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    /**
     * http://stackoverflow.com/a/2021729
     * Remove anything which isn't a word, whitespace, number
     * or any of the following characters -_~,;[]().
     * If you don't need to handle multi-byte characters
     * you can use preg_replace rather than mb_ereg_replace
     * @param $str
     * @return string
     */
    public static function sanitizeFileName($str) {
        // Basic clean up
        $str = preg_replace('([^\w\s\d\-_~,;\[\]\(\).])', '', $str);
        // Remove any runs of periods
        $str = preg_replace('([\.]{2,})', '', $str);
        return $str;
    }

    /**
     * Gets the posted data from the POST or FILES object. If was using Slim to upload it will be in POST (as posted with hidden field) if not enhanced with Slim it'll be in FILES.
     * @param $inputName
     * @return array|bool
     */
    private static function getPostData($inputName) {

        $values = array();

        if (isset($_POST[$inputName])) {
            $values = $_POST[$inputName];
        }
        else if (isset($_FILES[$inputName])) {
            // Slim was not used to upload this file
            return false;
        }

        return $values;
    }

    /**
     * Saves the data to a given location
     * @param $data
     * @param $path
     * @return bool
     */
    private static function save($data, $path) {
        if (!file_put_contents($path, $data)) {
            return false;
        }
        return true;
    }

    /**
     * Strips the "data:image..." part of the base64 data string so PHP can save the string as a file
     * @param $data
     * @return string
     */
    private static function getBase64Data($data) {
        return base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
    }

	public function extensionFile($nama_file){
		$str = explode(".",$nama_file);
		$len = count($str);
		$ext = $str[($len-1)];
		return $ext;
	}
	
	// progress upload image ********************
	public function upload_crop($nama_file,$file_imageName,$path)
	{
			try {
				$images = $this->getImages($nama_file);
			}
			catch (Exception $e) {
				$this->outputJSON(array(
					'status' => SlimStatus::FAILURE,
					'message' => 'Unknown'
				));		
				return;
			}
			// No image found under the supplied input name
			if ($images === false) {
				$this->outputJSON(array(
					'status' => SlimStatus::FAILURE,
					'message' => 'No data posted'
				));
				return;
			}
			$image = array_shift($images);
			if (!isset($image)) {
				$this->outputJSON(array(
					'status' => SlimStatus::FAILURE,
					'message' => 'No images found'
				));
				return;
			}
			if (!isset($image['output']['data']) && !isset($image['input']['data'])) {
				$this->outputJSON(array(
					'status' => SlimStatus::FAILURE,
					'message' => 'No image data'
				));
				return;
			}
			if (isset($image['output']['data'])) {
				$name = $image['output']['name'];
				$data = $image['output']['data'];
				$output = $this->saveFile($data,$name,$path,$file_imageName);
			}
			if (isset($image['input']['data'])) {
				$name = $image['input']['name'];
				$data = $image['input']['data'];
				$input = $this->saveFile($data,$name,$path,$file_imageName);
			}
			$response = array(
				'status' => SlimStatus::SUCCESS
			);
			if (isset($output) && isset($input)) {
				$response['output'] = array(
					'file' => $output['name'],
					'path' => $output['path']
				);
				$response['input'] = array(
					'file' => $input['name'],
					'path' => $input['path']
				);
			}
			else {
				$response['file'] = isset($output) ? $output['name'] : $input['name'];
				$response['path'] = isset($output) ? $output['path'] : $input['path'];
			}
			$this->outputJSON($response);
	}

	public function saveimg_base64($img,$path,$nama_file_upload)
	{
		$arr_explode = explode("/",$img);
		$arr_data = explode(";",$arr_explode[1]);
		$img = str_replace('data:image/'.$arr_data[0].';base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$file = $path.$nama_file_upload;
		$success = file_put_contents($file, $data);
		//print $success ? $file : 'Unable to save the file.';
	}

}

$image_crop = new Slim;