<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>字符串格式化</title>
</head>
<body>
	<form action=""method="post">
		请输入一个字符串：
	<input type="text" size="30" name="str" value="<?php echo html2Text($_POST['str'])?>">
	<input type="submit" name="submit" value="提交">
	<br>
	</form>
	<?php
		if(isset($_POST['submit'])){
			echo "原型输出：{$_POST['str']} <br>";
			echo "转换实例： ".htmlspecialchars($_POST['str'])." <br>";
			echo "删除斜线： ".stripslashes($_POST['str'])." <br>";
			echo "删除斜线的转换实例：".html2Text($_POST['str'])." <br>";
		}
		function html2Text($input){
			return htmlspecialchars( stripslashes($input) );
		}
	?>
</body>
</html>
