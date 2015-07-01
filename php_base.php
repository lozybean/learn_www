<html>
<head>
</head>
<body>
<?php
    $foo = 25;
    $bar = &$foo;
    echo "<p>$foo\t$bar</p>";
    $foo = 26;
    echo "<p>$foo\t$bar</p>";
    unset($foo);
    $has_foo = empty($foo) ? "NULL" : "NOT NULL";
    $has_bar = empty($bar) ? "NULL" : "NOT NULL";
    echo "<p>foo: $has_foo \tbar:$has_bar</p>";
?>
</body>
</html>
