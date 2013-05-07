<?php
  
	//Create and setup users
	$App->setup_users = function() use ($App) {
		$create_users_table = "CREATE TABLE IF NOT EXISTS users ( 
			id int AUTO_INCREMENT,
			email text(255),
			pass text(255));";
		mysql_query($create_users_table,$App->db->getLink()) or die("Error: " . mysql_error());
		$App->db->insertInto("users",array(
			"email" => "mouseroot@gmail.com",
			"pass" => "letme1n"
		));	
	};
	
	//Create and setup blogs
	$App->setup_blogs = function() use ($App) {
		$create_blogs_table = "CREATE TABLE IF NOT EXISTS blogs (
			id int AUTO_INCREMENT,
			user_id int,
			title text(255),
			content text(2048));";
		mysql_query($create_blogs_table,$App->db->getLink()) or die("Error: " . mysql_error());
		$App->db->insertInto("blogs",array(
			"user_id" => 1,
			"title" => "My first blog",
			"content" => "My content"
		));
	};

	
	//Main
	$App->setup_users();
	$App->setup_blogs();
	header("Location: http://localhost/blog/");
	
?>
