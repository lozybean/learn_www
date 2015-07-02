<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>learn php function</title>
</head>
<body>
<?php
	function table($tableName, $rows, $cols){
		$str_table = "";
		$str_table .= "<table align='center' border='1' width='600'>";
		$str_table .= "<caption><h1>$tableName</h1></caption>";
		for ($out=0; $out<$rows; $out++){
			$bgcolor = $out%2 == 0 ? "#FFFFFF" : "#DDDDDD";
			$str_table .= "<tr bgcolor=".$bgcolor.">";
			for($in=0; $in<$cols; $in++){
				$str_table .= "<td>".($out*$cols+$in)."</td>";
			}
			$str_table .= "</tr>";
		}
		$str_table .= "</table>";
		return $str_table;
	}
	$str = table( "第一个三行四列的表", 3, 4 );
	echo $str;
	echo table("第二个二行十列的表", 2, 10);
?>
</body>
</html>
