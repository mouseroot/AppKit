<?php	
	error_reporting(E_ALL);

	
	class Session {

		public static function start()
		{
			session_start();
		}
		
		public function exists($key)
		{
			if(isset($_SESSOIN[$key]))
			{
				return true;
			}
			return false;
		}
		
		public static function stop()
		{
			session_destroy();
		}
		
		public function get($key)
		{
			if(isset($_SESSION[$key]))
			{
				return $_SESSION[$key];
			}
			return null;
		}
		
		public function set($key,$val)
		{
			$_SESSION[$key] = $val;
			
		}
		
		public function del($key)
		{
			if(isset($_SESSION[$key]))
			{
				unset($_SESSION[$key]);
			}
		}
	}

	class Database {
		private $connected = false;
		private $link = null;
		public $username;
		public $password;
		public $hostname;
		public $dbName;
		      
		public function __construct($host, $user, $pass, $db) {
			$this->connect($host, $user, $pass, $db);
		}

		public function isConnected() {
			return $this->connected;
		}
		
		//creates a connection to the database and stores in into a variable
		public function connect($host,$user,$pass,$dn)
		{
			$this->hostname = $host;
			$this->username = $user;
			$this->password = $pass;
			$this->link = new mysqli($this->hostname, $this->username, $this->password, $dn);
			if(!$this->link) {
				die("Could not connect to database.");
			}
			$this->connected = true;
		}
		

		public static function select($items,$table,$where = null)
		{
			if(!$where)
			{
				$q_str = "SELECT %s FROM %s";
				$sql = sprintf($q_str,implode(",",array_values($items)),$table);
			}
			else
			{
				$q_str = "SELECT %s FROM %s WHERE %s";
				$sql = sprintf($q_str,implode(",",array_values($items)),$table,$where);
			}
			return $sql;
		}

		public function query($query, $callback = null) {
			$result = $this->link->query($query);
			while($row = $result->fetch_assoc()) {
				$callback($row);
			}
		}

		public function execute($query) {
			return $this->link->query($query);
		}
		
		/*
		public function num_rows($q)
		{
			$res = mysqli_query($this->link,$q);
			return mysqli_num_rows($res);		
		}
		*/

		public static function update($table, $array, $where) {
			foreach($arr as $key => $val)
			{
				$updates[] = "$key = '$val'";
			}
			return sprintf("UPDATE %s SET %s WHERE %s",$table,implode(", ",$updates),$where);	
	
		}

		public static function delete($table, $where) {
			return sprintf("DELETE FROM %s WHERE %s",$table,$where);

		}
		
		//Awesome function that inserts an assoc array into the database
		public static function insert($table,$arr)
		{
			return sprintf('INSERT INTO %s (%s) VALUES ("%s")',$table,implode(',',array_keys($arr)), implode('","',array_values($arr)));

		}
	}

	class AppKit {
		public function __construct() {

		}

		private static function isValid($var) {
			return isset($var) && !is_null($var);
		}

		public static function render($file, $options) {
			if(is_array($options) && file_exists($file)) {
				extract($options);
				include($file);
			}
		}

		public static function Database($hostname, $username, $password, $database) {
			return new Database($hostname, $username, $password, $database);
		}

		public static function Session() {
			return new Session();
		}

		public static function GET($var) {
			if(AppKit::isValid($_GET[$var])) {
				return $_GET[$var];
			}
		}

		public static function POST($var) {
			if(AppKit::isValid($_POST[$var])) {
				return $_POST[$var];
			}
		}

		public static function open($url) {
			return @file_get_contents($url);
		}

		public static function scrubString($string) {
			$stage_1 = mysql_real_escape_string($var);
			$stage_2 = preg_replace('/[^-a-zA-Z0-9_]/', '', $stage_1);
			return $stage_2;	
		}

		public static function redirect($location) {
			header("Location: $location");
		}
	}
	
	$App = new AppKit();
?>
