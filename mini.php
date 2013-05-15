<?php
  error_reporting(E_ALL);
	
	//
	//	AppKit mini
	
	class Application {
		public $db;
		public $router;
		public $session;
		
		public function clean($var)
		{
			$stage_1 = mysql_real_escape_string($var);
			$stage_2 = preg_replace('/[^-a-zA-Z0-9_]/', '', $stage_1);
			return $stage_2;
		}
		
		public function download($url)
		{
			$data = @file_get_contents($url);
			return $data;
		}
		
		public function get($var)
		{
			if(isset($_GET[$var]) && !empty($_GET[$var]))
			{
				return htmlentities($_GET[$var]);
			}
			return null;
		}
		
		public function post($var)
		{
			if(isset($_POST[$var]) && !empty($_POST[$var]))
			{
				return htmlentities($_POST[$var]);
			}
			return null;
		}
		
		public function render($file,$ops)
		{
			if(is_array($ops) && file_exists($file))
			{
				extract($ops);
				ob_start();
				include $file;
				return ob_get_clean();
			}
			else
			{
				return "Unable to render $file";
			}
		}
		
		public function redirect($path)
		{
			header("Location: $path");
		}
		
		public function type($mime)
		{
			header("Content-Type: $mime");
		}
	}

	
	//Database class	
	class Database {
		public $link;
		
		public function connect($host,$user,$pass,$db)
		{
			$this->link = new mysqli($host,$user,$pass,$db);
		}
		
		public function select($items,$table,$where,$limit = 1)
		{
			if($where === "all")
			{
				$query_str = sprintf("SELECT %s FROM %s",implode(",",array_values($items)),$table);
			}
			else
			{
				$query_str = sprintf("SELECT %s FROM %s WHERE %s LIMIT %d",implode(",",array_values($items)),$table,$where,$limit);
			}
			$result = $this->link->query($query_str);
			while($row = $result->fetch_object())
			{
				$rows[] = $row;
			}
			return $rows;
			
		}
		
		public function insert($table,$arr)
		{
			$query_str = sprintf('INSERT INTO %s (%s) VALUES ("%s")',$table,implode(",",array_keys($arr)),implode('","',array_values($arr)));
			$this->link->query($query_str);
		}
		
		public function update($table,$arr,$where)
		{
			foreach($arr as $key => $val)
			{
				$updates[] = "$key = '$val'";
			}
			$query_str = sprintf("UPDATE %s SET %s WHERE %s",$table,implode(", ",$updates),$where);
			$this->link->query($query_str);
		}
		
		public function delete($table,$where)
		{
			$query_str = sprintf("DELETE FROM %s WHERE %s",$table,$where);
			$this->link->query($query_str);
		}
	}
	
	class Session {
		public function start()
		{
			session_start();
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
	}
	
	class Router {
		public $routes;
		
		public function on($route,$callback)
		{
			global $App;
			$this->routes[$route] = $callback;
			//$this->routes[$route] = Closure::bind($callback,$App);
		}
		
		public function start($var = "path")
		{
			global $App;
			if($App->get($var))
			{
				$route = $App->get($var);
			}
			else
			{
				$route = "/";
			}
			
			foreach($this->routes as $r => $cb)
			{
				if($route === $r)
				{
					return call_user_func($cb);
				}
			}
			die("Invalid path: $route");
		}
	}	
	
	$Application = new Application;
	$Application->db = new Database;
	$Application->session = new Session();
	$Application->router = new Router;
	$App = $Application;
	
?>
