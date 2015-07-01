<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
<?php
	$contact[1] = 1;
	$contact['ID'] = "Lyon";
	$contact[15] = 15;
	echo "<p>".var_dump($contact)."</p>";
	$contact2 = array(1,14=>'var1','Lyon',14=>'var2','email'=>'xxx@xxx.com');
	echo "<p>".var_dump($contact2)."</p>";
	echo "<hr>";
	while ( list($key,$value) = each($contact2) ) {
		echo "<p>$key=>$value</p>";
	}
	echo "<hr>";
	echo "<p>".key($contact2)."=>".current($contact2)."</p>";
	reset($contact2);
	echo "<p>".key($contact2)."=>".current($contact2)."</p>";
	next($contact2);
	echo "<p>".key($contact2)."=>".current($contact2)."</p>";
	end($contact2);
	echo "<p>".key($contact2)."=>".current($contact2)."</p>";
	prev($contact2);
	echo "<p>".key($contact2)."=>".current($contact2)."</p>";
	echo "<hr>";
	echo '$_SERVER';
	foreach($_SERVER as $key=>$value){
		echo "<p>$key=>$value</p>";
	}
	echo "<hr>";
	echo '$_ENV';
	foreach($_ENV as $key=>$value){
		echo "<p>$key=>$value</p>";
	}
	echo "<hr>";
	echo '$_GET';
	//url like : http://192.168.33.10/learn_www/php_array.php?key=value&name=lyon&page=1   
	foreach($_GET as $key=>$value){
		echo "<p>$key=>$value</p>";
	}
	echo "<hr>";
	echo '$_POST';
	foreach($_POST as $key=>$value){
		echo "<p>$key=>$value</p>";
	}
	echo "<hr>";
	echo '$_REQUEST is equal $_POST and $_GET and $_COOKIE';
	echo "<hr>";
	echo '$_FILES shows the file info using POST method';
	echo "<hr>";
	echo '$_COOKIE shows the cookies';
	echo "<hr>";
	echo '$_SESSION is about the session';
	echo "<hr>";
	
?>
</body>
</html>
