<?php
  	include "..\AppKit.php";
	include "lib\user.class.php";
	include "lib\blog.class.php";
	
	$App->db = $App->getExt("Database");
	$App->router = $App->getExt("Router");
	$App->session = $App->getExt("Sessions");
	$App->db->connect("localhost","root","","BlogEngine");
	$App->session->start();
	
	function login($email,$pass) {
		global $App;
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
	}
	
	
	function getBlogs($user_id) {
		global $App;
		$sql = $App->db->select(array("id","title","content"),"blogs");
		$blogs = array();
		$App->db->query($sql,function($data) use (&$blogs) {
			$blog = new Blog;
			$blog->id = $data["id"];
			$blog->title = $data["title"];
			$blog->content = $data["content"];
			$blogs[] = $blog;
		});
		return $blogs;
	}
	
	function getBlog($id) {
		global $App;
		$sql = $App->db->select(array("content","title","id"),"blogs","id = $id");
		$blog = new Blog;
		$App->db->query($sql,function($data) use (&$blog) {
			$blog->id = $data["id"];
			$blog->content = $data["content"];
			$blog->title = $data["title"];
		});
		return $blog;
	}
	
	
	//Index
	$App->router->on("",function() use ($App) {
		if($App->session->get("user"))
		{
			$user_id = $App->session->get("user")->id;
			$index = $App->render("views/index_view.php",array(
				"session" => $App->session,
				"blogs" => getBlogs($user_id)
			));
		}
		else
		{
			$index = $App->render("views/index_view.php",array(
				"session" => $App->session,
				"blogs" => array()
			));
		}
		echo $index;
	});
	
	//Login
	$App->router->on("login",function() use ($App) {
		$email = $App->postVar("email");
		$pass = $App->postVar("pass");
		$user = login($email,$pass);
		header("Location: http://localhost/blog");
	});
	
	//View blog
	$App->router->on("view",function($id) use ($App) {
		$view = $App->render("views/blog_view.php",array(
			"session" => $App->session,
			"blog" => getBlog($id)
		));
		echo $view;
	});
	
	//Create blog
	$App->router->on("create",function() use ($App) {
		if($App->postVar("title") && $App->postVar("content"))
		{
			$App->db->insertInto("blogs",array(
				"title" => $App->postVar("title"),
				"content" => $App->postVar("content")
			));
			header("Location: http://localhost/blog/");
		}
		else
		{
			$view = $App->render("views/create_view.php",array());
			echo $view;
		}
			
	});
	
	//Install
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
	
	//Logout
	$App->router->on("logout",function() use ($App) {
		$App->session->stop();
		header("Location: http://localhost/blog/");
	});
	$App->router->start();
?>
