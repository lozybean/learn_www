<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>learn php object</title>
</head>
<body>
<?php
	class Person{
		private $name;
		private $sex;
		private $age; 
		function __construct($name='',$sex='男',$age=1){
			$this->name = $name;
			$this->sex = $sex;
			$this->age = $age;
		}	
		function say(){
			echo "My name is $this->name, $this->sex," .$this->__get(age). " years old<br>";
		}
		function __destruct(){
			echo "再见 $this->name<br>";
		}

		function walk(){
			echo "$this->name 走路时".$this->leftLeg()." ".$this->rightLeg()."<br>";
		}
		private function leftLeg(){
			return "迈左腿";
		}
		private function rightLeg(){
			return "迈右腿";
		}
		protected function __get($propertyName){
			if($propertyName == "name"){
				return $this->name;
			}
			if($propertyName == "sex"){
				return "保密";
			}
			if($propertyName == "age"){
				if($this->sex=="女"){
					return '18';
				}else{
					return $this->age;
				}
			}
		}
		protected function __set($propertyName,$propertyValue){
			if($propertyName == "sex"){
				if(!($propertyValue == "男" || $propertyValue== "女")){
					return;
				}
			}
			if($propertyName == "age"){
				if( !is_int($propertyValue) || $propertyValue < 0  ){
					return;
				}
			}
			$this->$propertyName = $propertyValue;
		}
		private function __isset($propertyName){
			//...
			return isset($this->$propertyName);
		}
		private function __unset($propertyName){
			//...
			unset($this->$propertyName);
		}
	}
	final class Student extends Person{
	//final let the class NotExtendAble
		var $school;

		final function study(){
			echo "$this->name is studying<br>";
		}
		//final let the function NotRewriteAble
		function say(){
			echo "My name is $this->name, I am a student<br>";
		}
	}
	class Teacher extends Person{
		var $wage;
		const CONSTANT = 'CONSTANT value';
		static $count = 0;
		function __construct($name='',$sex='男',$age=1){
			parent::__construct($name,$sex,$age);
			self::$count += 1;
		}
		function teaching(){
			echo "$this->name is teaching<br>";
		}
		function say(){
			parent::say();
			echo "My name is $this->name, I am a teacher<br>";
			echo "I am forever ". $this->__get(age) ."<br>";
		}

	}
	$person1 = new Person('张三','男','20');
	$person2 = new Person('李四','女','18');
	$person3 = new Person('王五','男','40');
	$person1->say();
#	$person1->__destruct(); 
	$person1->walk();
	$person1->age=-1;
	#$person1 is not really destructed, 
	#the __destruct() method is just a method would run before the object destructing, 
	#The REAL destruct method work by the system when ref count is zero
	#然并卵
	#$person1->say_name(); #it is dangerous, when unknown method is called, followed scripts will not run, and "php -l" can not find the error.
	echo '<hr>';
	$person1->age = -1;
	echo "$person1->age<br>";
	$person1->age = '10';
	echo "$person1->age<br>";
	$person1->age = 10;
	echo "$person1->age<br>";
	echo '<hr>';
	unset($person1->age);
	if(isset($person1->age)){
		echo $person1->age."<br>";
	}else{
		echo '$person1->age is unset<br>';
	}
	echo '<hr>';
	$teacher1 = new Teacher('Teacher 杨','女','33');
	$teacher1->say();
	echo 'There has '.Teacher::$count.' teacher constructed.<br>';
	echo '<hr>';
	echo 'This is a '.Teacher::CONSTANT.'<br>';
	if ($teacher1 instanceof Person){
		echo '$teacher1 is a Person instance<br>';
	}
	echo '<hr>';
	$teacher2 = clone $teacher1;
	$teacher1->say();
	echo '<hr>';

?>
<?php
	//  单态
	//  only one object per class
	class DB {
		private static $obj = null;

		private function __construct(){
			echo 'constructed!<br>';
		}
		static function getInstance(){
			if(is_null(self::$obj)){
				self::$obj = new self();
			}
			return self::$obj;
		}
		function query($sql){
			echo $sql;
		}
	}
	$db = DB::getInstance();
	$db -> query('select * from user');
	echo '<hr>';
?>
<?php
	//连贯操作
	class DB1{
		private $sql = array(
			"field" => "",
			"where" => "",
			"order" => "",
			"limit" => "",
			"group" => "",
			"having" => ""
		);

		function __call($methodName, $args){
			$methodName = strtolower($methodName);

			if(array_key_exists($methodName,$this->sql)){
				$this->sql[$methodName] = $args[0];
			}else{
				echo "调用类".get_class($this)."中的方法 $methodName 不存在<br>";
			}

			return $this;
		}

		function select(){
			echo "SELECT FROM {$this->sql['field']} user {$this->sql['where']} {$this->sql['order']} {$this->sql['limit']} {$this->sql['group']} {$this->sql['having']}<br>";
		}
	}
	$db1 = new DB1();
	$db1 -> field('sex, count(sex)')
		-> where('where sex in ("男","女")')
		-> group('group by sex')
		-> having('having avg(age) > 25')
		-> select();
	$db1 -> query('select * from user');
	//	this function will be __call()
	echo '<hr>';
?>
<?php
	//Abstract class and interface
	abstract class MyClass{
		protected $my_name;
		protected $my_country;

		function __construct($name="",$country=""){
			$this->my_name = $name;
			$this->my_country = $country;
		}

		abstract function say();
		abstract function eat();
	}
	interface One{
		const MYCONSTANT = 'CONSTANT value';
		// it is not good to use const in interface;
		function func1();
		function func2();
	}
	interface Two{
		function func3();
		function func4();
	}
	abstract class Three implements One{
		function func1(){
			echo 'it is func1 in Three<br>';
		}
	}
	class Four extends Three implements Two{
		function func2(){
			echo 'it is func2 in Four<br>';
		}
		function func3(){
			echo 'it is func3 in Four<br>';
		}
		function func4(){
			echo 'it is func4 in Four<br>';
		}
	}
	$oobj = new Four();
	echo $oobj->func1();
	echo '<hr>';
?>
</body>
</html>
