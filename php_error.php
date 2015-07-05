<?php
	error_reporting(0);
	
	function error_handler($error_level, $error_message, $file, $line){
		$EXIT = FALSE;
		switch($error_level){
			case E_NOTICE:
			case E_USER_NOTICE:
				$error_type = 'Notice';
				break;
			case E_WARNING:
			case E_USER_WARNING:
				$error_type = 'Warning';
				break;
			case E_ERROR:
			case E_USER_ERROR:
				$error_type = 'Error';
				$EXIT = True;
				break;
			default :
				$error_type = 'Unknown';
				$EXIT = True;
				break;
		}
		//do something to the error;
		printf("<font color='#FF0000'><b>%s</b></font>:%s in <b>%s</b> on line <b>%s</b><br>\n",$error_type,$error_message,$file,$line);

		//turn to a error page for exiting error
		if($EXIT == TRUE){
			echo '<script>location = "err.html" </script>';
		}
	}
	
	//use error_handle
	set_error_handler('error_handler');

	// test some error:
	echo $novar;
	echo 3/0;
	trigger_error('Trigger a fatal error',E_USER_ERROR);
?>
