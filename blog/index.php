<?php
  	include "..\AppKit.php";
	include "lib\user.class.php";
	include "lib\blog.class.php";
	
	$App->db = $App->getExt("Database");
	$App->router = $App->getExt("Router");
	$App->session = $App->getExt("Sessions");
	$App->db->connect("localhost","root","","BlogEngine");
	$App->session->start();
	
	$App->login = function($email,$pass) use ($App) {
			$sql = $App->db->select(array("email","pass","id"),"users","email = '$email' AND pass = '$pass' LIMIT 1");
			$num = $App->db->num_rows($sql);
			if($num == 1)
			{
				$user = new User;
				$App->db->query($sql,function($data) use (&$user,$App) {
					$user->id = $data["id"];
					$user->email = $data["email"];
					$user->pass = $data["pass"];
				});
				$App->session->set("user",$user);
				return $user;
			}
			else
			{
				return false;
			}
	};
	
	
	
	$App->router->on("",function() use ($App) {
		$index = $App->render("views/index_view.php",array(
			"session" => $App->session
		));
		echo $index;
	});
	
	$App->router->on("login",function() use ($App) {
		$email = $App->postVar("email");
		$pass = $App->postVar("pass");
		$user = $App->login($email,$pass);
		header("Location: http://localhost/blog/");
	});

	$App->router->on("install",function($pass) use ($App) {
		if($pass == "mypassword") 
        	{
        		include "setup/install.php";
        	}
      		else
        	{
          		die("Invalid password");
        	}
    	});
	
	$App->router->on("logout",function() use ($App) {
		$App->session->stop();
		header("Location: http://localhost/blog/");
	});
	$App->router->start();
	
	
	
?>
