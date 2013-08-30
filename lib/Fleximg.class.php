<?php
/**
* class Fleximg
* 
* @description  Simple Javascript/PHP responsive image loader
* @author       Max Tobias Weber (Maxtobiasweber@gmail.com)
* 
*/

include 'Ngdlib.class.php';

class Fleximg{
	var $filename,$originalpath,$targetpath,$targetpath_web;
	var $originalwidth,$originalheight;
	var $ratio;

	function __construct($options = false){
		$this->applyOptions($this->getDefaultOptions());
		if(is_array($options))$this->applyOptions($options);

		$this->checkImagickInstallation();
		$this->getFilename();
		$this->getAnalizeRequest();
		$this->getTargetpath();
	}

	function getDefaultOptions(){
		return array(
			'steps' => 50,
			'jpeg_quality' => 90,
			'use_gdlib' => false
		);
	}

	function applyOptions($options){
		foreach($options as $key => $option){
			$this->{$key} = $option;
		}
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

				header('Location: '.$this->targetpath_web);
			}else{

				header('Location: '.$this->original_file);
			}

		}
	}

	function writeImageFile(){

		$this->imageobj->thumbnailImage(intval($this->width),intval($this->height));

		$this->imageobj->writeImage($this->targetpath);

	}

	function analizeImage($localpath){
		// get original image width
		if($this->use_gdlib){
			$this->imageobj = new Ngdlib($localpath);
		}else{ //imagick
			$this->imageobj = new Imagick($localpath);
		}

		$this->originalwidth = $this->imageobj->getImageWidth();
		$this->originalheight = $this->imageobj->getImageHeight();
		
		$this->calculateMissingDimension();
		$this->adjustDimensionToSteps();
		$this->adjustTargetPathToDimensions();
		
	}

	function adjustDimensionToSteps(){
		
		if($this->height == 0){
			$rest = $this->steps % $this->width;
			if($rest){
				$this->width = $this->width+($steps-$rest);
				$this->height = 0;
				$this->calculateMissingDimension();
			}

		}elseif($this->width == 0){
			$rest = $this->steps % $this->height;
			if($rest){
				$this->height = $this->height+($steps-$rest);
				$this->width = 0;
				$this->calculateMissingDimension();
			}
		}
	}

	function fitValueToSteps($value){
		$rest = $value % $this->steps;

		if($rest){
			$value = $value+($this->steps-$rest);
		}
		return $value;
	}

	function adjustTargetPathToDimensions(){

		$file = $_SERVER['REQUEST_URI'];
		$file = explode('/',$file);
		$filename = $file[(count($file)-1)];

		unset($file[(count($file)-1)]);

		$file = array_merge($file);

		for ($i=0; $i < count($file); $i++) { 
			if($i !== 0 && $file[$i-1] == 'fleximg_scale'){
				
				$width = $file[$i];
			}
			if($i !== 0 && $file[$i-2] == 'fleximg_scale'){
				
				$height = $file[$i];
			}
		}

		if($width == 0){
			$height = $this->fitValueToSteps($height);
		}else{
			$width = $this->fitValueToSteps($width);
			$height = 0;
		}

		$next = '';
		for ($i=0; $i < count($file); $i++) { 

			if($next === 'height'){
				$file[$i] = $height;
				$next = '';
			}

			if($next === 'width'){
				$file[$i] = $width;
				$next = 'height';
			}

			if($file[$i] === 'fleximg_scale'){
				$next = 'width';
			}
		}
		
		$path = implode('/',$file);

		if(!is_dir($path)){
			mkdir($_SERVER['DOCUMENT_ROOT'].'/'.$path,0766,true);
		}

		$this->targetpath_web = $path.'/'.$filename;
		$this->targetpath = $_SERVER['DOCUMENT_ROOT'].'/'.$path.'/'.$filename;

	}

	function calculateMissingDimension(){
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

			$path = implode('/',$file);

			$this->targetpath_web = $path.'/'.$filename;
			$this->targetpath = $_SERVER['DOCUMENT_ROOT'].'/'.$path.'/'.$filename;

			
			if(!is_dir($path)){
				mkdir($_SERVER['DOCUMENT_ROOT'].'/'.$path,0766,true);
			}
		}

		return $this->targetpath;
	}

}