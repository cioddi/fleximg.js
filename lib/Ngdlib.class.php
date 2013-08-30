<?php
/**
* class Ngdlib
* 
* @description  incomplete Imagemagick interface on top of GD lib
* @author       Max Tobias Weber (Maxtobiasweber@gmail.com)
* 
*/

class Ngdlib{
	var $originalwidth;
	var $originalheight;
	var $imageType;
	var $imageobj;

	public function __construct($filename){
		list($this->originalwidth,$this->originalheight,$this->imageType) = getimagesize($filename);

		switch ($this->imageType) {
			case IMAGETYPE_GIF:
				$this->imageobj = imagecreatefromgif($filename);
				break;
			case IMAGETYPE_JPEG:
				$this->imageobj = imagecreatefromjpeg($filename);
				break;
			case IMAGETYPE_PNG:
				$this->imageobj = imagecreatefrompng($filename);
				break;
		}
	}

	public function getImageWidth(){
		return $this->originalwidth;
	}

	public function getImageHeight(){
		return $this->originalheight;
	}

	public function thumbnailImage($width,$height){

		$this->new_imageobj = imagecreatetruecolor(intval($width), intval($height));

		imagecopyresampled($this->new_imageobj, $this->imageobj, 0, 0, 0, 0, intval($width), intval($height), $this->originalwidth, $this->originalheight);

		$this->imageobj = $this->new_imageobj;

	}

	public function writeImage(){

		switch ($this->imageType) {
			case IMAGETYPE_GIF:
				imagegif($this->imageobj,$this->targetpath);
				break;
			case IMAGETYPE_JPEG:
				imagejpeg($this->imageobj,$this->targetpath);
				break;
			case IMAGETYPE_PNG:
				imagepng($this->imageobj,$this->targetpath);
				break;
		}

	}
}