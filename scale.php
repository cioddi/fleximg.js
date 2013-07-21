<?php 
class Fleximg{
	var $filename,$originalpath,$targetpath;

	function __construct(){
		$this->getFilename();
		$this->getAnalizeRequest();
		$this->getTargetpath();
	}

	function generate(){
		if(!is_file($this->targetpath)){
			$orig_filepath = getcwd().$this->original_file;


			$image = new Imagick($orig_filepath);

			$image->thumbnailImage(intval($this->width),intval($this->height));

			$image->writeImage($this->targetpath);

		}
	}

	function redirect(){
		header('Location: '.$_SERVER['REQUEST_URI']);
	}

	function getFilename(){
		if(!isset($this->filename)){

			$file = $_SERVER['REQUEST_URI'];
			$file = explode('/',$file);
			$this->filename = $file[(count($file)-1)];
		}
		return $this->filename;
	}

	function getAnalizeRequest(){
		$original_file = $_SERVER['REQUEST_URI'];
		$original_file = explode('img/scale/',$original_file);
		$original_file = $original_file[(count($original_file)-1)];

		$original_file = explode('/',$original_file);

		$this->width = $original_file[0];
		$this->height = $original_file[1];
		unset($original_file[1]);
		unset($original_file[0]);
		$this->original_file = '/'.implode('/',$original_file);
	}

	function getTargetpath(){
		if(!isset($this->targetpath)){
			$file = $_SERVER['REQUEST_URI'];
			$file = explode('/',$file);
			$filename = $file[(count($file)-1)];

			unset($file[(count($file)-1)]);

			$path = $_SERVER['DOCUMENT_ROOT'].implode('/',$file);

			if(!is_dir($path)){
				mkdir($path,0766,true);
			}

			$this->targetpath = $path.'/'.$filename;	
		}
		return $this->targetpath;
	}

}

$fleximgObj = new Fleximg();
$fleximgObj->generate();
$fleximgObj->redirect();

?>
