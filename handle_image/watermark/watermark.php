<?php
	include "../image.class.php";
	
	$img = new Image();
	echo $img->watermark('github.jpg','Lyon.png',1,'wa1_');
	echo $img->watermark('github.jpg','Lyon.png',2,'wa2_');
	echo $img->watermark('github.jpg','Lyon.png',3,'wa3_');
	echo $img->watermark('github.jpg','Lyon.png',4,'wa4_');
	echo $img->watermark('github.jpg','Lyon.png',5,'wa5_');
	echo $img->watermark('github.jpg','Lyon.png',6,'wa6_');
	echo $img->watermark('github.jpg','Lyon.png',7,'wa7_');
	echo $img->watermark('github.jpg','Lyon.png',8,'wa8_');
	echo $img->watermark('github.jpg','Lyon.png',9,'wa9_');

	echo $img->watermark('github.jpg','Lyon.png',0);
	echo $img->watermark('github.jpg','Lyon.png',0,'');
	echo $img->watermark('github.jpg','Lyon.png',0,'wa0_');
?>
