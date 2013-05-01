<?php
  include "AppKit.php";
	$App = $AppKit;
	
	/*
	//Routing
	$Router = $App->getExt("Router");
	$Router->on("plugins",function($method) {
		echo "Searching for plugin " . $method;
	});
	$Router->start();
	*/
	
	//Routing adv.
	$Router = $App->getExt("Router");
	$Router->on("/",function() {
		echo "Hello world";
	});
	$Router->on("profile",function($usr) {
		echo "Profile for: " . $usr;
	});
	$Router->start();
	
	/*
	//Sessions
	$Session = $App->getExt("Sessions");
	$Session->start();
	$Session->set("player","mouseroot");
	echo $Session->get("player");
	$Session->stop();
	*/
	
	/*
	//Database
	$db = $AppKit->getExt("DbManager");
	$db->connect("localhost","root","","BlogEngine");
	
	$data = array(
		"email" => "mouseroot@gmail.com",
		"pass" => "pass"
	);
	$db->insertInto("users",$data);
	
	$post = $AppKit->getNumericVar("post");
	$selector = $db->select(array("id","email"),"users","id = $post AND 200 = 200");
	//echo $selector;
	$db->query($selector,function($out){
		echo $out["id"] . " " . $out["email"];
	});
	*/

?>
