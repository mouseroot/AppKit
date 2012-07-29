<?php
	/*
	
		Experimental Addon file
		
		Roadmap:
			functions to generate files.
			Server classes
	*/
	
	class Generate 
	{
		public $fName;
		public $start = "<?php ";
		public $end = " ?>";
		public $body = "";
		public $fHandle;
		
		
		public function createEchoScript($fname,$helloWorld)
		{
			$start = sprintf("<?php echo '%s'; ?>",$helloWorld);
			$fh = fopen($fname,"w+");
			fputs($fh,$start);
			fclose($fh);
			include $fname;
		}
	}
	
	class Server 
	{
		public $port;
		public $socket;
		
		public function __construct($port) 
		{
			if(!extension_loaded("sockets"))
			{
				echo "Sockets not loaded..trying a reload...\n\n";
				system('php -d "extension=php_sockets.dll" Appkit.php server 89');
				die("killing oroginal");
			}
			$this->socket = socket_create(AF_INET,SOCK_DGRAM, SOL_UDP);
			//socket_set_nonblock($this->socket);
			$this->port = $port;
		}
		
		public function start()
		{
			echo "Starting server.\n";
			$buffer = "";
			$from = null;
			$port = null;
			socket_bind($this->socket,"0.0.0.0",$this->port);
			do
			{
				socket_recvfrom($this->socket,$buffer,255,0,$from,$port);
				echo "Got: " . $buffer . "\n";
				$d = explode(";",$buffer);
				var_dump($d);
			}while(1);
		}
	}
	
	
?>