<?php
	require "article.class.php";
	$article = new Article($_POST["subject"],$_POST["message"],$_POST["parse"]);
	echo $article->getSubject();
	echo '<hr>';
	echo $article->getMessage();
?>
