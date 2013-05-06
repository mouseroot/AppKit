<?php
  include "AppKit.php";
	
	$App->db = $App->getExt("Database");
	$App->route = $App->getExt("Router");
	$App->session = $App->getExt("Sessions");
	
	$App->db->connect("localhost","root","","BlogEngine");
	$App->session->start();
	$views = array();
	
	/*
		Functions and variables
	*/
	
	$App->login = function($user,$pass) use ($App) {
		$sql = $App->db->select(array("email","pass"),"users","email = '$user' AND pass = '$pass' LIMIT 1");
		$num = $App->db->num_rows($sql);
		if($num == 1)
		{
			$App->session->set("username",$user);
			return true;
		}
		else
		{
			return false;
		}
		
	};
	
	/*
		Simple Views
	*/
	
	//Login view
	$views["login_view"] = $App->render("views/login_form.php",array());
	
	//Index view
	$views["index_view"] = $App->render("views/index.php",array(
		"login_form" => $views["login_view"],
		"session" => $App->session,	
	));
	
	/*
		Logic views
	*/
	
	//Profile view
	$views["profile_view"] = function($id) use ($App) {
		$blogs_sql = $App->db->select(array("title","id"),"blogs","user_id = '$id'");
		$user_sql = $App->db->select(array("email","id"),"users","id = $id LIMIT 1");
		$blogs = array();
		$user;
		$test = $App->db->query($blogs_sql,function($data) use (&$blogs) {
			$blogs[] = $data;
		});
		
		
		$App->db->query($user_sql,function($item) use ($App,&$user) {
			$user =  $item["email"];
		});
		
		
		$view = $App->render("views/profile.php",array(
			"logged_in" => $App->session->get("username"),
			"blogs" => $blogs,
			"user" => $user
		));
		return $view;
	};
	
	/*
		Routes
	*/
	
	//Index
	$App->route->on("",function() use ($views) {
		echo $views["index_view"];
	});
	
	//Login
	$App->route->on("login",function() use ($App) {
		$username = $App->postVar("username");
		$passwd = $App->postVar("password");
		if($App->login($username,$passwd))
		{
			die("Welcome $username");
		}
		else
		{
			die("Incorrect info for user $username");
		}
	});
	
	//Logout
	$App->route->on("logout",function() use ($App) {
		$App->session->stop();
		die("Logged out!");
	});
	
	//Profile
	$App->route->on("profile",function($id) use ($App,$views) {
		echo $views["profile_view"]($id);
	});
	
	$App->route->start();
	
	//var_dump($views);
	
	
	
?>
