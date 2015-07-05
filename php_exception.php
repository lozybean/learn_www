<?php
	class Exception {
		protected $message = 'Unknown exception';
		protected $code = 0;
		protected $file;
		protected $line;

		function __construct($message = null, $code = 0){}

		final function getMessage(){}           //获取异常信息
		final function getCode(){}              //获取异常代码
		final function getFile(){}				//获取发生异常的文件名
		final function getLine(){}				//获取发生异常的行号
		final function getTrace(){}				//backtrace() 数组
		final function getTraceAsString(){}     //已格式化成字符串的getTrace()信息

		function __toString(){}
	}
?>
