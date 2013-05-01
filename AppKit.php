<?php	
	//error_reporting(0);
	//Final Revision. 7/12/2012
	
	/*
		[AppKit]


		Contents:
			AppKit - abstract base class
			DbManager - class to manage the database
			Main - Main Appkit class
		
		TODO:
			commandline/web routing.
			config reader/writer

		The idea: 
			Appkit is a class you can extend to give
			your classes the singleton pattern.
			
		usage:
			create a class and have it extend Appkit
			then store the instance using the 
			getInstance method.
			
		example:
			class myClass extends Appkit ...	
			$singleInstanceOfClass = $Appkit->getExt(myClass);
			$singleInstanceOfClass->method();
	*/
	
	//
	// The abstract Appkit class
	//
	
	abstract class AppKit	{
	
		//The array of class instances.
		private static $inst = array();
		
		//Array of added functions
		private $funcs = array();
		
		//Array of added varables
		private $vars = array();
		
		//function to return the single class instance from the array
		//or create it and set it in the array by calling class name.
		//then returning it.
		
		//this is a static method therfore the class does not have to be
		//instantiated to call this method
		//Reminder: use :: to call static methods instead of ->
		public static function getInstance() 
		{
			$cls = get_called_class();
			if(!isset(self::$inst[$cls]))
			{
				self::$inst[$cls] = new $cls;
			}
			return self::$inst[$cls];
		}
		
		//Magic built in override to assign functions to the function array
		//and varables to the varables array
		function __set($name,$val)
		{
			if(is_callable($val)) 
			{
				$this->funcs[$name] = $val;
			} 
			else 
			{
				$this->vars[$name] = $val;
			}
		}
		
		//Magic built in override to return the function or varable from 
		//thier respective arrays
		function __get($name) 
		{
			if(isset($name)) 
			{
				return $this->vars[$name];
			}
		}
		
		//Magic built in override to call a added function from 
		//the functions array
		function __call($method,$args) 
		{
			if(isset($this->funcs[$method])) 
			{
				call_user_func_array($this->funcs[$method],$args);
			} 
			else 
			{
				echo "Unknown function: " . $method;
			}
		}
	}
	//
	//	The Database Class.
	//
	class DbManager extends AppKit {
		private $link;
		public $username;
		public $password;
		public $hostname;
		public $dbName;
		
		
		public function setDb($d) 
		{
			$this->dbName = $d;
			mysql_select_db($d,$this->link);
		}
		
		//creates a connection to the database and stores in into a variable
		public function connect($host,$user,$pass,$dn = null) 
		{
			$this->hostname = $host;
			$this->username = $user;
			$this->password = $pass;
			$this->link = mysql_connect($this->hostname,$this->username,$this->password);
			if(!$this->link) {
			
				die("Could not connect to database.");
			}
			$this->setDb($dn);
		}
		
		//
		//
		public function select($items,$table,$where = null)
		{
			if(!$where)
			{
				$q_str = "SELECT %s FROM %s";
				$sql = sprintf($q_str,implode(",",array_values($items)),$table);
				return $sql;
			}
			else
			{
				$q_str = "SELECT %s FROM %s WHERE %s";
				$sql = sprintf($q_str,implode(",",array_values($items)),$table,$where);
				return $sql;
			}
		}
		
		public function query($q,$func = null)
		{
			if($func)
			{
				$res = mysql_query($q,$this->link);
				while($row = mysql_fetch_assoc($res))
				{
					$func($row);
				}
			}
		}
		
		//Awesome function that inserts an assoc array into the database
		public function insertInto($table,$arr)
		{
			$sql = sprintf('INSERT INTO %s (%s) VALUES ("%s")',$table,implode(',',array_keys($arr)), implode('","',array_values($arr)));
			$res = mysql_query($sql,$this->link);
		}
	
	}
	
	//Router class
	//Handles the routing
	class Router extends AppKit {
		private $routes = array();
		private $request;
		private $request_object;
		
		public function on($path,$func)
		{
			$this->routes[$path] = $func;
		}
		
		public function remove($path)
		{
			unset($this->routes[$path]);
		}
		
		
		public function error_msg()
		{
			$out = "";
			for($i=1;$i > count($this->request_object);$i++)
			{
				$out .= $this->request_object[$i] . "/";
			}
			die("Invalid route: " . $out);
		}
		
		
		public function start()
		{
			$this->request = $_SERVER["REQUEST_URI"];
			$this->request_object = explode("/",$this->request);
			for($i=2;$i <= count($this->request_object);$i++)
			{
				echo $i . " " . $this->request_object[$i] . "<br />";
			}
		}
	}
	
	//Session class
	//Manages the sessions
	class Sessions extends AppKit {
	
		public function start()
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
		
		public function stop()
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
	
	//Main class.
	//This is the main singleton class that holds
	//everything together.
	
	class Main extends AppKit {
		
		public function __construct()
		{
			//if(php_sapi_name() == 'cli')
		}
		
		public function getExt($cls) 
		{
			return $cls::getInstance();
		}
		
		public static function download($url) 
		{
			$data = @file_get_contents($url);
			return $data;
		}
		
		public static function getVar($v) 
		{
			if(isset($_GET[$v])) 
			{
				
				return htmlentities($_GET[$v]);
			}
			return null;
		}
		
		public function getNumericVar($v) 
		{
			if(isset($_GET[$v]) && is_numeric($v))
			{
				return $_GET[$v];
			}
			return null;
		}
		
		public function postNumericVar($v)
		{
			if(isset($_POST[$v]) && is_numeric($v))
			{
				return $_POST[$v];
			}
			return null;
		}
		
		public static function postVar($v) 
		{
			if(isset($_POST[$v])) 
			{
				return $_POST[$v];
			}
			return null;
		}
		
		public static function render($file,$ops)
		{
			if(is_array($ops)) 
			{
				extract($ops);
			}
			require $file;
		}
		
		
	}
	$AppKit = Main::getInstance();
	
?>
