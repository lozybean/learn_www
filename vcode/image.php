<?php
	session_start();
	if(isset($_POST["submit"])){
		if(strtoupper(trim($_POST["code"])) == $_SESSION["code"]){
			echo "验证码输入成功！<br>";
		}else{
			echo "<font color='red'> 验证码输入错误! </font><br>";
		}
	}
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>vcode testing</title>
	<script>
		/*定义一个JS函数， 单击验证码时调用， 将重新请求并获取一个图片*/
		function newgdcode(obj,url){
			/* 需要跟一个随机参数，否则在IE和火狐下不刷新图片 */
			obj.src = url + '?nowtime=' + new Date().getTime();
		}
	</script>
</head>
<body>
	<img src="imgcode.php" alt="看不清楚，换一张" style="curson:pointer;" onclick="javascript:newgdcode(this,this.src);"/>
	<form action="image.php" method="POST">
		<input type="text" size=4 name="code"/>
		<input type="submit" name="submit" value="提交"/>
	</form>
</body>
</html>
