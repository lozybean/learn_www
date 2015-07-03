<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
<?php
	class MyClass{
		var $var = 'ok';
	}
	$str = "abcd";
	$str{1} = 'change it';
	echo "$str<br>";
	// accd
	$str = "我爱北京天安门";
	echo "{$str{0}}{$str{1}}<br>";
	echo '<hr>';
	$lamp = array('os'=>'Linux','webserver'=>'Apache','db'=>'MySQL','language'=>'PHP');
	echo "A OS is $lamp[os]<br>";
	// it is ok but slow, PHP will regard os as a const first, and turned to string when the const do not exists
	#echo "A OS is $lamp['os']<br>";
	// it is wrong
	echo "A OS is {$lamp['os']}<br>";
	// it is ok and a good way
	$obj = new MyClass();
	echo "A var in obj is $obj->var<br>";
	// it is ok because < can not in a var_name
	#echo "A var in obj is $obj->vartoo<br>";
	// it is wrong because of greeding match
	echo "A var in obj is {$obj->var}too<br>";
	//it is ok
	echo '<hr>';
?>
<?php
	$f = 0.0113;
	$f = sprintf('%2.2f%%',$f*100);
	echo $f;
	echo '<hr>';
?>
<?php
	$a = '1234aBc';
	$b = '1234AbC';
	$c = '23';
	$d = '23abc';
	$e = 'abc23';
	function mycmp($func,$str1,$str2){
		switch($func($str1,$str2)){
			case 0:
				echo "$str1 和 $str2 相等<br>";
				break;
			case 1:
				echo "$str1 比 $str2 大<br>";
				break;
			case -1:
				echo "$str1 比 $str2 小<br>";
				break;
		}
	}
	mycmp('strcmp',$a,$b);	
	mycmp('strcasecmp',$a,$b);
	mycmp('strcmp',$a,$c);
	mycmp('strnatcmp',$a,$c);
	mycmp('strnatcmp',$a,$b);
	mycmp('strnatcmp',$a,$d);
	mycmp('strnatcmp',$a,$e);
	echo '<hr>';
?>
</body>
</html>
