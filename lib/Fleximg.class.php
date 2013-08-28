<?php
/**
* class Fleximg
* 
* @description  Simple Javascript/PHP responsive image loader
* @author       Max Tobias Weber (Maxtobiasweber@gmail.com)
* 
*/

class Fleximg{
	var $filename,$originalpath,$targetpath;
	var $originalwidth,$originalheight;
	var $ratio;
	var $quality = 90;

	var $use_gdlib = false;

	function __construct(){
		$this->checkImagickInstallation();
		$this->getFilename();
		$this->getAnalizeRequest();
		$this->getTargetpath();
	}

	function checkImagickInstallation(){
		if (!extension_loaded('imagick')){
			if (extension_loaded('gd')){
				$this->use_gdlib = true;
			}else{
				header('Location: '.$this->original_file);
			}
		}
	}

	function generate(){
		if(!is_file($this->targetpath) && is_file($this->original_file_absolute)){


			
			if($this->getOriginalwidth($this->original_file_absolute) > $this->width){

				$this->writeImageFile();

				header('Location: '.$_SERVER['REQUEST_URI']);
			}else{

				header('Location: '.$this->original_file);
			}

		}
	}

	function writeImageFile(){
		if($this->use_gdlib){
			$this->new_imageobj = imagecreatetruecolor(intval($this->width), intval($this->height));

			imagecopyresampled($this->new_imageobj, $this->imageobj, 0, 0, 0, 0, intval($this->width), intval($this->height), $this->originalwidth, $this->originalheight);

			switch ($this->imageType) {
        case IMAGETYPE_GIF:
            imagegif($this->new_imageobj,$this->targetpath);
            break;
        case IMAGETYPE_JPEG:
            imagejpeg($this->new_imageobj,$this->targetpath);
            break;
        case IMAGETYPE_PNG:
            imagepng($this->new_imageobj,$this->targetpath);
            break;
    	}
		}else{
			$this->imageobj->thumbnailImage(intval($this->width),intval($this->height));

			$this->imageobj->writeImage($this->targetpath);
		}
	}

	function analizeImage($localpath){
		// get original image width
		if($this->use_gdlib){
			list($this->originalwidth,$this->originalheight,$this->imageType) = getimagesize($localpath);

			switch ($this->imageType) {
        case IMAGETYPE_GIF:
            $this->imageobj = imagecreatefromgif($localpath);
            break;
        case IMAGETYPE_JPEG:
            $this->imageobj = imagecreatefromjpeg($localpath);
            break;
        case IMAGETYPE_PNG:
            $this->imageobj = imagecreatefrompng($localpath);
            break;
    	}
		}else{ //imagick
			$this->imageobj = new Imagick($localpath);

			$this->originalwidth = $this->imageobj->getImageWidth();
			$this->originalheight = $this->imageobj->getImageHeight();
		}
		
		// calculate missing value for gdlib
		if($this->height == 0){
			$this->ratio = $this->width/$this->originalwidth;
			$this->height = intval(round($this->ratio*$this->originalheight));
		}elseif($this->width == 0){
			$this->ratio = $this->height/$this->originalheight;
			$this->width = intval(round($this->ratio*$this->originalwidth));
		}
	}
	function getOriginalwidth($localpath){
		$this->analizeImage($localpath);

		return $this->originalwidth;
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
		$original_file = explode('fleximg_scale/',$original_file);
		$original_file = $original_file[(count($original_file)-1)];

		$original_file = explode('/',$original_file);

		$this->width = $original_file[0];
		$this->height = $original_file[1];
		unset($original_file[1]);
		unset($original_file[0]);
		$this->original_file_absolute = $_SERVER['DOCUMENT_ROOT'].'/'.implode('/',$original_file);
		$this->original_file = '/'.implode('/',$original_file);
	}

	function getTargetpath(){
		if(!isset($this->targetpath)){
			$file = $_SERVER['REQUEST_URI'];
			$file = explode('/',$file);
			$filename = $file[(count($file)-1)];

			unset($file[(count($file)-1)]);

			$path = $_SERVER['DOCUMENT_ROOT'].'/'.implode('/',$file);

			error_log($path);
			if(!is_dir($path)){
				mkdir($path,0766,true);
			}

			$this->targetpath = $path.'/'.$filename;	
		}
		return $this->targetpath;
	}

}