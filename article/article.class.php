<?php
	class Article{
		private $subject;
		private $message;
		
		function __construct($subject="",$message="",$parse=array()){
			$this->subject = $this->html2Text($subject);

			foreach($parse as $value){
				$fun_arr = array(0=>'','delHtmlTags','html2Text','UBBCode2Html','parseURL','parseSmilies','disableKeyWords','parsePHPCode','parsePer','nltobr');
				$message = $this->$fun_arr[$value]($message);
			}
			$this->message = $message;
		}
		private function delHtmlTags($message){
			return strip_tags($message);
		}
		private function html2Text($message){
			return htmlSpecialChars(stripSlashes($message));
		}
		private function UBBCode2Html($message){
			$pattern = array(
				'/\[b\]/i','/\[\/b\]/i','/\[i\]/i','/\[\/i\]/i','/\[u\]/i','/\[\/u\]/i',
				'/\[font=([^\[\<]+?)\]/i',
				'/\[color=([#\w]+?)\]/i',
				'/\[size=(\d+?)\]/i',
				'/\[size=(\d+(\.\d+)?(px|pt|in|cm|mm|pc|em|ex|%)+?)\]/i',
				'/\[align=(left|center|right)\]/i',
				'/\[url=www.([^\["\']+?)\](.+?)\[\/url\]/is',
				'/\[url=(https?|ftp|gopher|news|telnet){1}:\/\/([^\["\']+?)\](.+?)\[\/url\]/is',
				'/\[email\]\s*([a-z0-9\-_.+]+)@([a-z0-9\-_]+[.][a-z0-9\-_.]+)\s*\[\/email\]/i',
				'/\[email=([a-z0-9\-_.+]+)@([a-z0-9\-_]+[.][a-z0-9\-_.]+)\](.+?)\[\/email\]/is',
				'/\[img\](.+?)\[\/img\]/',
				'/\[\/color\]/i', '/\[\/size\]/i', '/\[\/font\]/i', '/\[\/align\]/'
			);
			$replace = array(
				'<b>', '</b>', '<i>', '</i>', '<u>', '</u>',
				'<font face="\\1">',
				'<font color="\\1">',
				'<font size="\\1">',
				'<font style=\"font-size: \\1\">',
				'<p align="\\1">',
				'<a href="http://www.\\1" target="_blank">\\2</a>',
				'<a href="\\1://\\2" target="_blank">\\3</a>',
				'<a href="mailto:\\1@\\2">\\1@\\2</a>',
				'<a href="mailto:\\1@\\2">\\3</a>',
				'<img src="\\1">',
				'</font>', '</font>', '</font>', '</p>'
			);
			$str = preg_replace($pattern, $replace, $message);
			return $str;
		}
		private function cuturl($url){
			$length = 65;
			$url = substr(strtolower($url),0,4) == 'www.' ? "http://$url" : $url;
			$urllink = "<a href=\"".$url.'" target="_blank">';
			if(strlen($url) > $length){
				$url = substr($url, 0, intval($length * 0.5)).' ... '.substr($url, -intval($length*0.3));
			}
			$urllink .= $url.'</a>';
			return $urllink;
		}
		private function parseURL($message){
			$urlPattern = "/(www.|https?:\/\/|ftp:\/\/|news:\/\/|telnet:\/\/){1}([^\[\"']+?)(com|net|org)(\/[\w-\.\/?\%\&\=]*)?/ei";
			$str = preg_replace($urlPattern,"\$this->cuturl(\"\\1\\2\\3\\4\")",$message);
			return $str;
		}
		private function parseSmilies($message){
			$pattern = array(
				'/:\)|\/wx|微笑/i',
				'/:@|\/fn|发怒/i',
				'/:kiss|\/kill|\/sa|示爱/i',
				// lol 
				'/:p|\/tx|偷笑/i',
				'/:q|\/dk|大哭/i'
			);
			$replace = array(
				'<img src="smilies/smile.gif" alt="微笑">',
				'<img src="smilies/huffy.gif" alt="发怒">',
				'<img src="smilies/kiss.gif" alt="示爱">',
				'<img src="smilies/titter.gif" alt="偷笑">',
				'<img src="smilies/cry.gif" alt="大哭">'
			);
			return preg_replace($pattern, $replace, $message);
		}
		private function disableKeyWords($message){
			$keywords_disable = array("杀人","迷奸","群殴");
			return str_replace($keywords_disable, "呵呵", $message);
		}
		private function parsePHPCode($message){
			$pattern = '/(<\?.*?\?>)/ise';
			$replace = '"<pre style=\"background:#ddd\">".highlight_string("\\1",true)."</pre>"';
			$str = preg_replace($pattern,$replace,$message);
			return $str;
		}
		private function parsePer($message){
			return '<pre>'.$message.'</pre>';
		}
		private function nltobr($message){
			return nl2br($message);
		}
		public function getSubject(){
			return "<h1 align=center> {$this->subject} </h1>";
		}
		public function getMessage(){
			return $this->message;
		}
	}
?>
