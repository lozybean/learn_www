<?php
	class Image{
		private $path;

		function __construct($path="./"){
			$this->path = $path;
		}

		function thumb($name, $width, $height, $qz="th_"){
			$imgInfo = $this->getInfo($name);
			$srcImg = $this->getImg($name, $imgInfo);
			$size = $this->getNewSize($name,$width,$height,$imgInfo);
			$newImg = $this->kidOfImage($srcImg,$size,$imgInfo);
			return $this->createNewImage($newImg,$qz.$name,$imgInfo);
		}

		function waterMark($groundName, $waterName, $waterPos=0, $qz="wa_"){
			$curpath = rtrim($this->path, "/")."/";
			$dir = dirname($waterName);
			if($dir == "."){
				$wpath = $curpath;
			}else{
				$wpath = $dir."/";
				$waterName = basename($waterName);
			}

			if(file_exists($curpath.$groundName) && file_exists($wpath.$waterName) ){
				$groundInfo = $this->getInfo($groundName);
				$waterInfo = $this->getInfo($waterName,$dir);
				if(!$pos = $this->position($groundInfo,$waterInfo,$waterPos)){
					echo '水印不应该比背景图片小';
					return false;
				}
				$groundImg = $this->getImg($groundName,$groundInfo);
				$waterImg = $this->getImg($waterName,$waterInfo);
				$groundImg = $this->copyImage($groundImg,$waterImg,$pos,$waterInfo);
				return $this->createNewImage($groundImg,$qz.$groundName,$groundInfo);
			}else{
				echo '图片或者水印图片不存在!';
				return false;
			}
		}

		function cut($name,$x,$y,$width,$height,$qz="cu_"){
			$imgInfo = $this->getInfo($name);
			if( ( ($x+$width) > $imgInfo['width']) || (($y+$height) > $imgInfo['height']) )	{
				echo "裁剪的位置超出了背景图片的范围";
				return false;
			}

			$back = $this->getImg($name, $imgInfo);
			$cutimg = imagecreatetruecolor($width,$height);
			imagecopyresampled($cutimg,$back,0,0,$y,$y,$width,$height,$width,$height);
			imagedestroy($back);
			return $this->createNewImage($cutimg,$qz.$name,$imgInfo);
		}

		private function position($groundInfo, $waterInfo,$waterPos){
			if( ($groundInfo['width'] < $waterInfo['width']) || ($groundInfo['height'] < $waterInfo['height']) ){
				return false;
			}
			switch($waterPos){
				case 1:
					$posX = 0;
					$posY = 0;
					break;
				case 2:
					$posX = ($groundInfo['width'] - $waterInfo['width']) / 2;
					$posY = 0;
					break;
				case 3:
					$posX = $groundInfo['width'] - $waterInfo['width'];
					$posY = 0;
					break;
				case 4:
					$posX = 0;
					$posY = ($groundInfo['height'] - $waterInfo['height']) / 2;
					break;
				case 5:
					$posX = ($groundInfo['width'] - $waterInfo['width']) / 2;
					$posY = ($groundInfo['height'] - $waterInfo['height']) / 2;
					break;
				case 6:
					$posX = $groundInfo['width'] - $waterInfo['width'];
					$posY = ($groundInfo['height'] - $waterInfo['height']) / 2;
					break;
				case 7:
					$posX = 0;
					$posY = $groundInfo['height'] - $waterInfo['height'];
					break;
				case 8:
					$posX = ($groundInfo['width'] - $waterInfo['width']) / 2;
					$posY = $groundInfo['height'] - $waterInfo['height'];
					break;
				case 9:
					$posX = $groundInfo['width'] - $waterInfo['width'];
					$posY = $groundInfo['height'] - $waterInfo['height'];
					break;
				case 0:
				default:
					$posX = rand(0,($groundInfo['width'] - $waterInfo['width']));
					$posY = rand(0,($groundInfo['height'] - $waterInfo['height']));
					break;
			}
			return array("posX"=>$posX,"posY"=>$posY);
		}

		private function getInfo($name, $path="."){
			$spath = $path == "." ? rtrim($this->path,"/")."/" : $path.'/';
			$data = getimagesize($spath.$name);
			$imgInfo['width'] = $data[0];
			$imgInfo['height'] = $data[1];
			$imgInfo['type'] = $data[2];

			return $imgInfo;
		}

		private function getImg($name,$imgInfo,$path="."){
			$spath = $path == "." ? rtrim($this->path,'/').'/' : $path.'/';
			$srcPic = $spath.$name;
			switch ($imgInfo['type']){
				case 1:
					$img = imagecreatefromgif($srcPic);
					break;
				case 2:
					$img = imagecreatefromjpeg($srcPic);
					break;
				case 3:
					$img = imagecreatefrompng($srcPic);
					break;
				default:
					return false;
					break;
			}
			return $img;
		}

		private function getNewSize($name,$width,$height,$imgInfo){
			$size['width'] = $imgInfo['width'];
			$size['height'] = $imgInfo['height'];

			if($width < $imgInfo['width']){
				$size['width'] = $width;
			}
			if($height < $imgInfo['height']){
				$size['height'] = $height;
			}

			if($imgInfo['width']*$size['width'] > $imgInfo['height']*$size['height']){
				$size['height'] = round($imgInfo['height']*$size['width']/$imgInfo['width']);
			}else{
				$size['width'] = round($imgInfo['width']*$size['height']/$imgInfo['height']);
			}

			return $size;
		}

		private function createNewImage($newImg,$newName,$imgInfo){
			$this->path = rtrim($this->path,'/').'/';
			switch ($imgInfo['type']){
				case 1:
					$result = imageGIF($newImg, $this->path.$newName);
					break;
				case 2:
					$result = imageJPEG($newImg, $this->path.$newName);
					break;
				case 3:
					$result = imagePNG($newImg, $this->path.$newName);
					break;
			}
			imagedestroy($newImg);
			return $newName;
		}

		private function copyImage($groundImg,$waterImg,$pos,$waterInfo){
			imagecopy($groundImg,$waterImg,$pos['posX'],$pos['posY'],0,0,$waterInfo['width'],$waterInfo['height']);
			imagedestroy($waterImg);
			return $groundImg;
		}

		private function kidOfImage($srcImg,$size,$imgInfo){
			$newImg = imagecreatetruecolor($size['width'],$size['height']);
			$otsc = imagecolortransparent($srcImg);
			if( $otsc >=0 && $otsc < imagecolorstotal($srcImg) ){
				$transparentcolor = imagecolorsforindex($srcImg,$otsc);
				$newtransparentcolor = imagecolorallocate($newImg,$transparentcolor['red'],$transparentcolor['green'],$transparentcolor['blue']);
				imagefill($newImg,0,0,$newtransparentcolor);
				imagecolortransparent($newImg,$newtransparentcolor);
			}
			imagecopyresized($newImg,$srcImg,0,0,0,0,$size['width'],$size['height'],$imgInfo['width'],$imgInfo['height']);
			imagedestroy($srcImg);
			return $newImg;
		}
	}
?>
