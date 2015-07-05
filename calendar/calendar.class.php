<?php
	class Calendar{
		private $year;
		private $monh;
		private $start_weekday;
		private $days;

		function __construct(){
			$this->year = isset($_GET["year"]) ? $_GET["year"]: date("Y");
			$this->month = isset($_GET["month"]) ? $_GET["month"] : date("m");
			$this->start_weekday = date("w",mktime(0,0,0,$this->month,1,$this->year));
			$this->days = date("t",mktime(0,0,0,$this->month,1,$this->year));
		}

		function __toString(){
			$out .= "<table align=\"center\">";
			$out .= $this->chageDate();
			$out .= $this->weeksList();
			$out .= $this->daysList();
			$out .= "</table>";
			return $out;
		}
		private function weeksList(){
			$week = array('日','一','二','三','四','五','六');
			$out .= '<tr>';
			for($i=0;$i<count($week);$i++){
				$out .= "<th class='fonth'>{$week[$i]}</th>";
			}
			$out .= '</tr>';
			return $out;
		}
		private function daysList(){
			$out .= "<tr>";
			for($j=0; $j < $this->start_weekday; $j++){
				$out .= "<td>&nbsp;</td>";
			}
			for($k=1; $k <= $this->days; $k++){
				$j++;
				if($k == date('d')){
					$out .= "<td class=\"fontb\">{$k}</td>";
				}else{
					$out .= "<td>{$k}</td>";
				}
				if($j%7 == 0){
					$out.= "</tr><tr>";
				}
			}
			while( $j % 7 !== 0){
				$out .= "<td>&nbsp;</td>";
				$j++;
			}
			$out .= "</tr>";
			return $out;
		}
		private function prevYear($year,$month){
			$year = $year - 1;
			if($year < 1970){
				$year = 1970;
			}
			return "year={$year}&month={$month}";
		}
		private function prevMonth($year,$month){
			if($month == 1){
				$year = $year - 1;
				if($year < 1970){
					$year = 1970;
				}
				$month = 12;
			}else{
				$month = $month - 1;
			}
			return "year={$year}&month={$month}";
		}
		private function nextYear($year,$month){
			$year = $year + 1;
			if($year > 2038){
				$year = 2038;
			}
			return "year={$year}&month={$month}";
		}
		private function nextMonth($year,$month){
			if($month == 12){
				$year = $year + 1;
				if($year > 2038){
					$year = 2038;
				}
				$month = 1;
			}else{
				$month = $month + 1;
			}
			return "year={$year}&month={$month}";
		}
		private function chageDate($url="index.php"){
			$out .= "<tr>";
			$out .= "<td><a href=\"{$url}?{$this->prevYear($this->year,$this->month)}\"><<</a></td>";
			$out .= "<td><a href=\"{$url}?{$this->prevMonth($this->year,$this->month)}\"><<</a></td>";
			$out .= '<td colspan="3">';
			$out .= '<form>';
			$out .= "<select name=\"year\" onchange=\"window.location='{$url}?year='+this.options[selectedIndex].value+'&month={$this->month}'\">";
			for($sy=1970;$sy<=2038;$sy++){
				$selected = ($sy==$this->year) ? "selected" : "";
				$out .= "<option $selected value=\"{$sy}\">{$sy}</option>";
			}
			$out .= "</selected>";
			$out .= "<select name=\"month\" onchange=\"window.lacation='{$url}?year={$this->year}&month='+this.options[selectedIndex].value\">";
			for($sm=1;$sm<=12;$sm++){
				$selected1 = ($sm==$this->month) ? "selected" : "";
				$out .= "<option $selected1 value=\"{$sm}\">{$sm}</option>";
			}
			$out .= "</selected>";
			$out .= "</form>";
			$out .= "</td>";
			$out .= "<td><a href=\"{$url}?{$this->nextYear($this->year,$this->month)}\">>></a></td>";
			$out .= "<td><a href=\"{$url}?{$this->nextMonth($this->year,$this->month)}\">>></a></td>";
			$out .= "</tr>";

			return $out;
		}
	}
?>
