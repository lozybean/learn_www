<?php
	include  "image.class.php";
	$img = new Image('./image/');

	$filename = $img->thumb('github.jpg',500,500,'');
	$midname - $img->thumb($filename,250,250);
	$icon = $img->thumb($filename,80,80,'icon_');

	echo $filename.'<br>';
	echo $midname.'<br>';
	echo $icon.'<br>';
?>
